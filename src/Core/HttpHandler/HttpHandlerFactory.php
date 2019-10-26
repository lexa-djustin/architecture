<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 29.09.2019
 * Time: 13:32
 */

namespace Core\HttpHandler;

use Core\Factory\AbstractReflectionFactory;
use Core\HttpHandler\AbstractHttpHandler;

class HttpHandlerFactory extends AbstractReflectionFactory
{
    public function canCreate(string $name): bool
    {
        return is_a($name, AbstractHttpHandler::class, true);
    }
}