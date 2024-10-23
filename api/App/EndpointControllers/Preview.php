<?php

namespace App\EndpointControllers;

/**
 * Controller class for managing preview content.
 *
 * This class extends the 'Endpoint' class and is responsible for handling
 * requests to retrieve content previews. It supports GET requests with an
 * optional 'limit' parameter to control the number of previews returned.
 *
 * @author Patrick Shaw
 */
class Preview extends Endpoint
{
    /**
     * @var array Allowed parameters for GET requests. Currently supports 'limit'.
     */
    protected $allowedParams = ["limit"];

    /**
     * @var string SQL query to fetch titles and preview videos from the content.
     */
    private $sql = "SELECT title, preview_video
                    FROM content
                    WHERE preview_video IS NOT NULL
                    ORDER BY RANDOM()";

    /**
     * @var array Parameters to bind to the SQL query.
     */
    private $sqlParams = [];

    /**
     * Constructor for the Preview class.
     *
     * Processes GET requests by building and executing an SQL query to retrieve
     * content previews. Throws an error for unsupported request methods.
     *
     * @throws \App\ClientError If the request method is not supported or if parameters are invalid.
     */
    public function __construct()
    {
        switch(\App\Request::method()) {
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
     * Modifies the class's SQL query to add a 'LIMIT' clause if the 'limit' parameter
     * is provided in the request. Validates the 'limit' parameter before appending.
     *
     * @throws \App\ClientError If the 'limit' parameter is invalid or in an incorrect format.
     */
    private function buildSQL()
    {
        if (isset(\App\Request::params()['limit']))
        {
            if (!is_numeric(\App\Request::params()['limit'])) {
                throw new \App\ClientError(422);
            }
            $limit = (int)\App\Request::params()['limit'];
            $this->sql .= " LIMIT :limit";
            $this->sqlParams[':limit'] = $limit;
        }
    }
}
