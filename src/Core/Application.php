<?php

namespace Core;

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response;

class Application
{
    private $request;

    private $response;

    public function __construct()
    {
        $this->request = ServerRequestFactory::fromGlobals();
        $this->response = new Response();
    }

    public function run(): void
    {
        $router = Router\Router::loadFromConfigurationFile(new Config\YmlReader('config/routes.yml'));
        $result = $router->match($this->request);

        foreach ($result->tokens() as $name => $value) {
            $this->request = $this->request->withAttribute($name, $value);
        }

        $httpHandlerResolver = new HttpHandler\HttpHandlerResolver(new HttpHandler\Factory\HttpHandlerFactory());
        $httpHandlerResolver->resolve($this->request, $result);
    }
}