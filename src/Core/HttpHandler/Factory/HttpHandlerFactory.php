<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 29.09.2019
 * Time: 13:32
 */

namespace Core\HttpHandler\Factory;

use Core\HttpHandler\AbstractHttpHandler;

class HttpHandlerFactory implements HttpHandlerFactoryInterface
{
    /**
     * @param string $name
     *
     * @return AbstractHttpHandler
     * @throws HttpHandlerWasNotFoundException
     */
    public function createHttpHandler(string $name): AbstractHttpHandler
    {
        if (!class_exists($name)){
            throw new HttpHandlerWasNotFoundException(printf(
                'Class with name "%s" was not found',
                $name
            ));
        }

        return new $name;
    }
}