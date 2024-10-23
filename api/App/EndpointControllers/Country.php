<?php

namespace App\EndpointControllers;

/**
 * Endpoint controller for handling country-related requests.
 *
 * This class extends the Endpoint base class and is designed to handle requests
 * that retrieve a distinct list of countries from the 'affiliation' table.
 * Currently, it only supports GET requests without parameters.
 *
 * @author Patrick Shaw
 */
class Country extends Endpoint
{
    /**
     * @var array Allowed parameters for GET requests. Empty as no parameters are expected.
     */
    protected $allowedParams = [];

    /**
     * @var string SQL query to fetch distinct countries from the affiliation table.
     */
    private $sql = "SELECT DISTINCT country FROM affiliation";

    /**
     * @var array Parameters to bind to the SQL query. Empty as no parameters are expected.
     */
    private $sqlParams = [];

    /**
     * Constructor for the Country class.
     *
     * Handles GET requests by executing a predefined SQL query to retrieve
     * distinct countries. For request methods other than GET, a 405 Client Error is thrown.
     *
     * @throws \App\ClientError If the request method is not GET.
     */
    public function __construct()
    {
        switch(\App\Request::method()) {
            case 'GET':
                $this->checkAllowedParams();
                $dbConn = new \App\Database(CHI2023_DATABASE);
                $data = $dbConn->executeSQL($this->sql, $this->sqlParams);
                break;
            default:
                throw new \App\ClientError(405);
        }
        
        parent::__construct($data);
    }
}
