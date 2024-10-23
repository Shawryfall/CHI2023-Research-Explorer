<?php

namespace App;

/**
 * Abstract Router class for routing HTTP requests to appropriate endpoint controllers.
 *
 * This class defines a static method to route incoming HTTP requests to specific
 * endpoint controllers based on the request URI. It supports various endpoints
 * and throws a ClientError for unknown URIs.
 * 
 * @author Patrick Shaw
 */
abstract class Router
{
    /**
     * Routes the incoming HTTP request to the appropriate endpoint controller.
     *
     * This method analyzes the request URI and instantiates the corresponding
     * endpoint controller. It handles various predefined routes and defaults
     * to a 404 ClientError for unknown routes. In the event of a ClientError,
     * an error message is returned encapsulated in an Endpoint controller.
     *
     * @return \App\EndpointControllers\Endpoint The instantiated endpoint controller.
     * @throws \App\ClientError If the requested endpoint is not found.
     */
    public static function routeRequest()
    {
        try {
            switch (Request::endpointName()) {
                case '/':
                case '/developer':
                case '/developer/':
                    $endpoint = new \App\EndpointControllers\Developer();
                    break;
                case '/country':
                case '/country/':
                    $endpoint = new \App\EndpointControllers\Country();
                    break;
                case '/preview':
                case '/preview/':
                    $endpoint = new \App\EndpointControllers\Preview();
                    break;
                case '/author-and-affiliation':
                case '/author-and-affiliation/':
                    $endpoint = new \App\EndpointControllers\AuthorAndAffiliation();
                    break;
                case '/content':
                case '/content/':
                    $endpoint = new \App\EndpointControllers\Content();
                    break;
                case '/token':
                case '/token/':
                    $endpoint = new \App\EndpointControllers\Token();
                    break;
                case '/note':
                case '/note/':
                    $endpoint = new \App\EndpointControllers\Note();
                    break;
                case '/favourites':
                case '/favourites/':
                    $endpoint = new \App\EndpointControllers\Favourites();
                    break;
                default:
                    throw new ClientError(404);
            }
        } catch (ClientError $e) {
            $data['message'] = $e->getmessage();
            $endpoint = new \App\EndpointControllers\Endpoint([$data]);
        }
        return $endpoint;
    }
}
