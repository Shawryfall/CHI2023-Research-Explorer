<?php

namespace App\EndpointControllers;
/**
 * Controller class for managing notes in the application.
 *
 * This class extends the 'Endpoint' class and is responsible for handling
 * various HTTP methods (GET, POST, DELETE) related to notes. It includes
 * functionality for validating tokens, checking user existence, and performing
 * operations on favourites.
 *
 * @author Patrick Shaw
 */ 
class Favourites extends Endpoint 
{
    /**
     * Constructs the Note object and processes the HTTP request.
     *
     * The constructor validates the user token, checks if the user exists,
     * and then processes the request based on the HTTP method. Supported
     * methods are GET, POST, and DELETE for favourite operations.
     *
     * @throws \App\ClientError For unsupported HTTP methods or authentication failures.
     */
    public function __construct()
    {
        
        $id = $this->validateToken();
 
        switch(\App\Request::method()) 
        {
            case 'GET':
                $data = $this->getFavourites($id);
                break;
            case 'POST':
                $data = $this->postFavourites($id);
                break;
            case 'DELETE':
                $data = $this->deleteFavourites($id);
                break;
            default:
                throw new \App\ClientError(405);
                break;
        }
        parent::__construct($data);
    }

    /**
     * Validates the JWT token from the request.
     *
     * Validates the token using JWT standards and extracts the user ID from it.
     * It throws an error if the token is invalid or expired.
     *
     * @return string The user's ID extracted from the token.
     * @throws \App\ClientError If the token is invalid or expired.
     */
    private function validateToken()
    {
    $secretkey = SECRET;
                
    $jwt = \App\REQUEST::getBearerToken();

    try {
        $decodedJWT = \FIREBASE\JWT\JWT::decode($jwt, new \FIREBASE\JWT\Key($secretkey, 'HS256'));
    } catch (\Exception $e) {
        throw new \App\ClientError(401);
    }

    if (!isset($decodedJWT->exp) || !isset($decodedJWT->sub)) { 
        throw new \App\ClientError(401);
    }
    
    if ($_SERVER['HTTP_HOST'] != $decodedJWT->iss)
    {
        throw new \App\ClientError(401);
    }
    return $decodedJWT->sub;
    }
    /**
     * Retrieves the list of favourite items for the given user ID.
     *
     * Executes a query to fetch favourite content IDs from the database for the specified user.
     *
     * @param string $id User ID for which favourites are to be fetched.
     * @return array Array of favourite content IDs.
     * @throws \App\DatabaseError If there is an issue with the database query.
     */
    private function getFavourites($id)
    {
        $dbConn = new \App\Database(USERS_DATABASE);
        $sql = "SELECT content_id FROM favourites WHERE user_id = :id";
        $sqlParams = [':id' => $id];
        $data = $dbConn->executeSQL($sql, $sqlParams);
        return $data;
    }
    /**
     * Adds a new item to the user's favourites.
     *
     * Accepts a content ID and adds it to the user's favourites if it doesn't already exist.
     * Validates if the content ID is provided and numeric.
     *
     * @param string $id User ID to which the content ID will be added.
     * @return array An empty array, indicating successful addition.
     * @throws \App\ClientError If content_id is not provided or not numeric.
     * @throws \App\DatabaseError If there is an issue with the database operation.
     */
    private function postFavourites($id)
    {
        if (!isset(\App\REQUEST::params()['content_id']))
        {
            throw new \App\ClientError(422);
        }
 
 
        $content_id = \App\REQUEST::params()['content_id'];
        
        if (!is_numeric($content_id))
        {
            throw new \App\ClientError(422);
        }
 
 
        $dbConn = new \App\Database(USERS_DATABASE);
 
 
        $sqlParams = [':id' => $id, 'content_id' => $content_id];
        $sql = "SELECT * FROM favourites WHERE user_id = :id AND content_id = :content_id";
        $data = $dbConn->executeSQL($sql, $sqlParams);
 
 
        if (count($data) === 0) {
            $sql = "INSERT INTO favourites (user_id, content_id) VALUES (:id, :content_id)";
            $data = $dbConn->executeSQL($sql, $sqlParams);
        }
        
        return [];
 
 
    }
    /**
     * Deletes an item from the user's favourites.
     *
     * Removes the specified content ID from the user's favourites.
     * Validates if the content ID is provided and numeric.
     *
     * @param string $id User ID from which the content ID will be removed.
     * @return array Array containing the result of the delete operation.
     * @throws \App\ClientError If content_id is not provided or not numeric.
     * @throws \App\DatabaseError If there is an issue with the database operation.
     */
    private function deleteFavourites($id)
    {
        if (!isset(\App\REQUEST::params()['content_id']))
        {
            throw new \App\ClientError(422);
        }
        
        $content_id = \App\REQUEST::params()['content_id'];
 
 
        if (!is_numeric($content_id))
        {
            throw new \App\ClientError(422);
        }
        
        $content_id = \App\REQUEST::params()['content_id'];
 
 
        $dbConn = new \App\Database(USERS_DATABASE);
        $sql = "DELETE FROM favourites WHERE user_id = :id AND content_id = :content_id";
        $sqlParams = [':id' => $id, 'content_id' => $content_id];
        $data = $dbConn->executeSQL($sql, $sqlParams);
        return $data;
    }
}