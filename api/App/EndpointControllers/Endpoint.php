<?php

namespace App\EndpointControllers;

/**
 * Base class for endpoint controllers.
 *
 * This class serves as a base for various endpoint controllers in the application.
 * It provides functionalities for handling and storing data, along with a method
 * to check for allowed API parameters.
 *
 * @author Patrick Shaw
 * 
 */
class Endpoint 
{
    /**
     * @var array Holds the data for the endpoint.
     */
    private $data;

    /**
     * @var array List of allowed parameters for the endpoint.
     */
    protected $allowedParams = [];
 
    /**
     * Constructor for the Endpoint class.
     *
     * Initializes the endpoint with provided data. If no data is provided,
     * initializes with a default array containing an empty 'message' key.
     *
     * @param array $data Initial data for the endpoint, defaults to ['message' => []].
     */
    public function __construct($data = ["message" => []])
    {
        $this->setData($data);
    }
 
    /**
     * Sets the data for the endpoint.
     *
     * @param array $data Data to be set for the endpoint.
     */
    public function setData($data)
    {
        $this->data = $data;
    }
 
    /**
     * Retrieves the data set for the endpoint.
     *
     * @return array The data of the endpoint.
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Checks the request parameters against the allowed parameters.
     *
     * This method iterates through each parameter in the request and verifies
     * whether it's included in the list of allowed parameters. If a parameter
     * is not allowed, a ClientError exception is thrown.
     *
     * @throws \App\ClientError If an unallowed parameter is used in the request.
     */
    protected function checkAllowedParams()
    {
        foreach (\App\Request::params() as $key => $value) 
        {
            if (!in_array($key, $this->allowedParams))
            {
                throw new \App\ClientError(422);
            }
        }
    }
}
