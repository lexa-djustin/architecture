<?php

return [
    'factories' => [
        Twig\Environment::class => Core\Twig\Factory::class,
        Core\Config\Config::class => Core\Config\Factory::class,
    ],
    'abstract_factories' => [
        Core\HttpHandler\HttpHandlerInterface::class => Core\HttpHandler\HttpHandlerFactory::class,
    ],
    'initializers' => [
        Core\HttpHandler\HttpHandlerInterface::class
    ],
];