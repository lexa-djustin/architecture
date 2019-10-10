<?php

namespace Core\Router;

use Psr\Http\Message\ServerRequestInterface;
use Core\Config\Reader;

class Router
{
    /**
     * @var Route[]
     */
    private $routes = [];

    /**
     * @param Reader $reader
     *
     * @return Router
     */
    public static function loadFromConfigurationFile(Reader $reader): Router
    {
        return self::loadFromArray($reader->read());
    }

    /**
     * @param array $data
     *
     * @return Router
     */
    public static function loadFromArray(array $data): Router
    {
        $self = new static();

        foreach ($data as $route) {
            $methods = explode(',', $route['methods']);
            $methods = array_map('strtoupper', $methods);

            $self->add($methods, $route['route'], $route['class'] . ':' . $route['method']);
        }

        return $self;
    }

    /**
     * @param array $methods
     * @param string $route
     * @param string $handler
     */
    public function add(array $methods, string $route, string $handler): void
    {
        $this->routes[] = new Route($methods, $route, $handler);
    }

    /**
     * @param ServerRequestInterface $request
     * @return RouteMatch
     * @throws RouteWasNotFoundException
     */
    public function match(ServerRequestInterface $request): RouteMatch
    {
        foreach ($this->routes as $route) {
            $result = $route->match($request);

            if ($result !== null) {
                return $result;
            }
        }

        throw new RouteWasNotFoundException('Page was not found', 404);
    }
}