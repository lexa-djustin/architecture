<?php

namespace Core\HttpHandler\Factory;

use Core\HttpHandler\AbstractHttpHandler;

interface HttpHandlerFactoryInterface
{
    /**
     * @param string $class
     *
     * @return AbstractHttpHandler
     */
    function createHttpHandler(string $class) : AbstractHttpHandler;
}