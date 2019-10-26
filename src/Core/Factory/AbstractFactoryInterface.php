<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 26.10.2019
 * Time: 19:22
 */

namespace Core\Factory;


interface AbstractFactoryInterface extends FactoryInterface
{
    public function canCreate(string $name): bool ;
}