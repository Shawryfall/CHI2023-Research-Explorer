<?php

namespace App;

/**
 * Response class for handling HTTP responses.
 *
 * This class is responsible for sending HTTP headers and outputting JSON responses.
 * It includes handling for OPTIONS requests and sets necessary headers for CORS and content type.
 * 
 * @author Patrick Shaw
 */
class Response
{
    /**
     * Constructor for the Response class.
     *
     * Sends out HTTP headers and handles OPTIONS requests by exiting early
     * to prevent further processing in such cases.
     */
    public function __construct()
    {
        $this->outputHeaders();

        if (\App\Request::method() === 'OPTIONS') {
            exit();
        }
    }
    
    /**
     * Sends out common HTTP headers.
     *
     * Sets the Content-Type to application/json and configures CORS (Cross-Origin Resource Sharing) headers.
     */
    private function outputHeaders()
    {
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: https://w20012045.nuwebspace.co.uk');
        header('Access-Control-Allow-Headers: Authorization, Content-Type'); 
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE');
    }

 
    /**
     * Outputs the provided data in JSON format.
     *
     * Encodes the given data as JSON and outputs it.
     *
     * @param mixed $data The data to be encoded into JSON.
     */
    public function outputJSON($data)
    {
    if (empty($data)) {
        http_response_code(204);
    }
    echo json_encode($data);
    }
}
