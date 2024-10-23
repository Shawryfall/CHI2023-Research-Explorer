<?php

namespace App\EndpointControllers;
/**
 * Endpoint controller for student id and name
 *
 * @author Patrick Shaw
 */
class Developer extends Endpoint
{
    protected $allowedParams = [];
    private $sqlParams = [];

    public function __construct()
    {
        switch(\App\Request::method()) {
            case 'GET':
                $this->checkAllowedParams();
                $data['id'] = "w20012045";
                $data['name'] = "Patrick Shaw";
                break;
            default:
                throw new ClientError(405);
        }
        parent::__construct($data);       
    }
}