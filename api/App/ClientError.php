<?php

namespace App;

/**
 * Custom exception class for client errors.
 *
 * This class extends the base Exception class and is used to handle
 * various client error responses, typically in HTTP contexts.
 * It supports several HTTP status codes like 404, 405, 422, and 401.
 * 
 * @author Patrick Shaw
 */
class ClientError extends \Exception
{
    /**
     * Constructor for ClientError.
     *
     * Calls the parent constructor with a message based on the provided error code.
     * 
     * @param int $code The HTTP status code corresponding to the client error.
     */
    public function __construct($code)
    {
        parent::__construct($this->errorResponses($code));
    }

    /**
     * Generates an error message based on an HTTP status code.
     *
     * This method sets the HTTP response code and returns an appropriate
     * error message. It throws an exception if an unknown error code is provided.
     * 
     * @param int $code The HTTP status code for the error.
     * @return string The error message corresponding to the provided status code.
     * @throws \Exception If an unknown error code is provided.
     */
    public function errorResponses($code)
    {
        switch ($code) {
            case 404:
                http_response_code(404);
                $message = '404 Not Found';
                break;
            case 405:
                http_response_code(405);
                $message = '405 Method Not Allowed';
                break;
            case 422:
                http_response_code(422);
                $message = '422 Unprocessable Entity';
                break;
            case 401:
                http_response_code(401);
                $message = '401 Unauthorized';
                break;
            default:
                throw new \Exception('Unknown Error Code');
        }
        return $message;
    }
}
