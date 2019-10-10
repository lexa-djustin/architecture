<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 29.09.2019
 * Time: 20:45
 */

namespace Core\Config;


interface Reader
{
    /**
     *
     */
    function read(): array;
}