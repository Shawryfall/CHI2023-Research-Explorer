<?php

namespace App\EndpointControllers;

/**
 * Endpoint controller for handling requests related to authors and their affiliations.
 *
 * This class extends the Endpoint base class and is responsible for processing
 * requests related to authors, including their details and affiliations with
 * content, countries, cities, and institutions. It supports GET requests with
 * specific parameters to filter the results.
 *
 * @author Patrick Shaw
 */
class AuthorAndAffiliation extends Endpoint
{
    /**
     * @var array Allowed parameters for GET requests.
     */
    protected $allowedParams = ["content", "country"];

    /**
     * @var string SQL query to fetch author and affiliation details.
     */
    private $sql = "SELECT
                        a.id AS author_id,
                        a.name AS author_name,
                        c.id AS content_id,
                        c.title AS content_title,
                        GROUP_CONCAT(DISTINCT aff.country) AS countries,
                        GROUP_CONCAT(DISTINCT aff.city) AS cities,
                        GROUP_CONCAT(DISTINCT aff.institution) AS institutions
                    FROM
                        author a
                    JOIN
                        content_has_author cha ON a.id = cha.author
                    JOIN
                        content c ON cha.content = c.id
                    JOIN
                        affiliation aff ON c.id = aff.content";

    /**
     * @var array Parameters to bind to the SQL query.
     */
    private $sqlParams = [];

    /**
     * Constructor for AuthorAndAffiliation class.
     *
     * Handles the request based on the method type. For GET requests, it checks allowed
     * parameters, builds the SQL query, and executes it. For other request types,
     * it throws a 405 Client Error.
     *
     * @throws \App\ClientError If the request method is not supported or parameters are invalid.
     */
    public function __construct()
    {
        switch (\App\Request::method()) {
            case 'GET':
                $this->checkAllowedParams();
                $this->buildSQL();
                $dbConn = new \App\Database(CHI2023_DATABASE);
                $data = $dbConn->executeSQL($this->sql, $this->sqlParams);
                break;
            default:
                throw new \App\ClientError(405);
        }
        
        parent::__construct($data);
    }

    /**
     * Builds the SQL query based on request parameters.
     *
     * This method modifies the class's SQL query based on the provided 'content'
     * and/or 'country' parameters in the request. It ensures that valid parameters
     * are used and appends conditions to the SQL query accordingly.
     *
     * @throws \App\ClientError If the parameters are invalid or in an incorrect format.
     */
    private function buildSQL()
    {
        $where = false; 

        if (isset(\App\Request::params()['content'])) 
        {
            if (!is_numeric(\App\Request::params()['content'])) {
                throw new \App\ClientError(422);
            }
            if (count(\App\Request::params()) > 1) {
                throw new \App\ClientError(422);
            } 
            $this->sql .= " WHERE c.id = :content";
            $this->sqlParams[":content"] = \App\Request::params()['content'];
        }

        if (isset(\App\Request::params()['country'])) {
            if (count(\App\Request::params()) > 1) {
                throw new \App\ClientError(422);
            } 
            $this->sql .= ($where) ? " AND" : " WHERE";
            $where = true;
            $this->sql .= " aff.country LIKE :country";
            $this->sqlParams[':country'] = \App\Request::params()['country'];
        }
        
        $this->sql .= " GROUP BY a.id, c.id";

    }
    
}