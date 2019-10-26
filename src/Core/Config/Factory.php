<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 26.10.2019
 * Time: 21:02
 */

namespace Core\Config;

use Core\Config\Config;
use Core\Factory\FactoryInterface;

class Factory implements FactoryInterface
{
    public function create(string $name): object
    {
        return new Config(ROOT_DIRECTORY . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'application.php');
    }
}