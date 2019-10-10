<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 29.09.2019
 * Time: 19:34
 */

namespace Core\HttpHandler;

use Core\Router\RouteMatch;
use Psr\Http\Message\ServerRequestInterface;

class HttpHandlerResolver
{
    /**
     * @var Factory\HttpHandlerFactoryInterface
     */
    private $httpHandlerFactory;

    /**
     * HttpHandlerResolver constructor.
     * @param Factory\HttpHandlerFactoryInterface $httpHandlerFactory
     */
    public function __construct(Factory\HttpHandlerFactoryInterface $httpHandlerFactory)
    {
        $this->httpHandlerFactory = $httpHandlerFactory;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RouteMatch $result
     */
    public function resolve(ServerRequestInterface $request, RouteMatch $result): void
    {
        [$class, $method] = explode(':', $result->handler());

        $handler = $this->httpHandlerFactory->createHttpHandler($class);
        $handler->setRequest($request);

        $handler->{$method}();
    }
}