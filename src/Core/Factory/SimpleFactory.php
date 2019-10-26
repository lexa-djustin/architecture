<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 26.10.2019
 * Time: 19:43
 */

namespace Core\Factory;

class SimpleFactory implements FactoryInterface
{
    /**
     * @param string $name
     *
     * @return AbstractHttpHandler
     * @throws HttpHandlerWasNotFoundException
     */
    public function create(string $name = null): object
    {
        /*
        if (!class_exists($name)) {
            throw new HttpHandlerWasNotFoundException(printf(
                'Class with name "%s" was not found',
                $name
            ));
        }
        */

        return new $name();
    }
}
