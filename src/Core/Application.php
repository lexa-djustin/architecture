<?php

namespace Core;

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;
use Core\Container\Container;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Application
{
    public function run(): void
    {
        $request = ServerRequestFactory::fromGlobals();

        $router = Router\Router::loadFromConfigurationFile(new Config\YmlReader('config/routes.yml'));
        $result = $router->match($request);

        foreach ($result->tokens() as $name => $value) {
            $request = $request->withAttribute($name, $value);
        }

        $config = new Config\Config(ROOT_DIRECTORY . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'dependencies.php');
        $container = new Container($config);

        //$config = new Config\Config(ROOT_DIRECTORY . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'application.php');
        //$result = $config->get('my.a.b!.c');
        //var_dump($result);exit();

        $httpHandlerResolver = new HttpHandler\HttpHandlerResolver($container);
        $response = $httpHandlerResolver->resolve($request, $result);
        $emitter = new SapiEmitter();
        $emitter->emit($response);
    }
}