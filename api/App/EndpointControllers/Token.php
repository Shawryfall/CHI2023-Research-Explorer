<?php

namespace App\EndpointControllers;

/**
 * Controller class for token generation and validation.
 *
 * This class extends the 'Endpoint' class and is responsible for handling
 * token-related operations in the application. It supports GET and POST requests
 * for user authentication and JWT (JSON Web Token) generation.
 *
 * @author Patrick Shaw
 */
class Token extends Endpoint
{
    /**
     * @var string SQL query to fetch user id and password based on email.
     */
    private $sql = "SELECT id, password FROM account WHERE email = :email";

    /**
     * @var array Parameters to bind to the SQL query.
     */
    private $sqlParams = [];

    /**
     * Constructor for the Token class.
     *
     * Processes GET and POST requests for user authentication and token generation.
     * It validates user credentials and generates a JWT if authentication is successful.
     *
     * @throws \App\ClientError For invalid authentication credentials or unsupported HTTP methods.
     */
    public function __construct() {

        switch(\App\Request::method()) 
        {
            case 'GET':
            case 'POST':
                $this->checkAllowedParams();
                $dbConn = new \App\Database(USERS_DATABASE);
    
                if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
                    throw new \App\ClientError(401);
                }
                if (empty(trim($_SERVER['PHP_AUTH_USER'])) || empty(trim($_SERVER['PHP_AUTH_PW']))) {
                    throw new \App\ClientError(401);
                }
              
                $this->sqlParams[":email"] = $_SERVER['PHP_AUTH_USER'];
                $data = $dbConn->executeSQL($this->sql, $this->sqlParams);

                if (count($data) != 1) {
                    throw new \App\ClientError(401);
                }

                if (!password_verify($_SERVER['PHP_AUTH_PW'], $data[0]['password'])) {
                    throw new \App\ClientError(401);
                }

                $token = $this->generateJWT($data[0]['id']);        
                $data = ['token' => $token];
 
                parent::__construct($data);
                break;
            default:
                throw new \App\ClientError(405);
                break;
        }
    }

    /**
     * Generates a JWT (JSON Web Token) for the authenticated user.
     *
     * Creates a JWT with the user's ID as the subject, using HS256 for encoding.
     * The token includes issued at, expiration, and issuer information.
     *
     * @param string $id The authenticated user's ID.
     * @return string The generated JWT.
     */
    private function generateJWT($id) {
 
        $secretKey = SECRET;

        $payload = [
            'sub' => $id,
            'exp' => strtotime('+30 mins', time()),
            'iat' => time(),
            'iss' => $_SERVER['HTTP_HOST']
            ];

        $jwt = \FIREBASE\JWT\JWT::encode($payload, $secretKey, 'HS256');
  
        return $jwt;
    }

}