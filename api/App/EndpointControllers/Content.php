<?php

namespace App\EndpointControllers;

/**
 * Endpoint controller for handling content-related requests.
 *
 * This class extends the 'Endpoint' class and is responsible for processing
 * GET requests related to content. It supports filtering based on 'type' and
 * pagination through the 'page' parameter.
 * 
 * @author Patrick Shaw
 */
class Content extends Endpoint
{
    /**
     * @var array Allowed parameters for GET requests. Supports 'type' and 'page'.
     */
    protected $allowedParams = ["type", "page"];

    /**
     * @var string SQL query to fetch content details from the database.
     */
    private $sql = "SELECT 
    content.id,
    content.title,
    content.abstract,
    type.name AS type,
    award.name AS award,
    content.doi_link,
    content.preview_video
    FROM 
    content
    JOIN 
    type ON content.type = type.id
    LEFT JOIN 
    content_has_award cha ON content.id = cha.content
    LEFT JOIN 
    award ON cha.award = award.id";

    /**
     * @var array Parameters to bind to the SQL query.
     */
    private $sqlParams = [];

    /**
     * Constructor for the Content class.
     *
     * Processes GET requests by building and executing an SQL query to retrieve
     * content details. Throws an error for unsupported request methods.
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
     * Modifies the class's SQL query to add conditions and pagination based on 'type' and 'page'
     * parameters from the request. Validates parameters before appending them to the query.
     *
     * @throws \App\ClientError If any parameter is invalid or in an incorrect format.
     */
    private function buildSQL()
    {
        $where = false; 

        if (isset(\App\Request::params()['type']))
        {
            $this->sql .= ($where) ? " AND" : " WHERE";
            $where = true;
            $this->sql .= " type.name LIKE :type";
            $this->sqlParams[':type'] = \App\Request::params()['type'];
        }

        if (isset(\App\Request::params()['page'])) 
        {
            if (!is_numeric(\App\Request::params()['page'])) {
                throw new \App\ClientError(422);
            }
            $page = (int)\App\Request::params()['page'];       
            $resultsPerPage = 20;
            $offset = ($page - 1) * $resultsPerPage;
            $this->sql .= " LIMIT :limit OFFSET :offset";
            $this->sqlParams[':limit'] = $resultsPerPage;
            $this->sqlParams[':offset'] = $offset;
        }
    }   
}
