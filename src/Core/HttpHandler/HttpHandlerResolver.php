<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 29.09.2019
 * Time: 19:34
 */

namespace Core\HttpHandler;

use Core\Router\RouteMatch;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Container\ContainerInterface;

class HttpHandlerResolver
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RouteMatch $result
     *
     * @return ResponseInterface
     */
    public function resolve(ServerRequestInterface $request, RouteMatch $result): ResponseInterface
    {
        [$class, $method] = explode(':', $result->handler());

        $handler = $this->container->get($class);
        return $handler->handle($request);
    }
}