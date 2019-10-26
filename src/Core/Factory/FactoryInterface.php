<?php

namespace Core\Factory;

interface FactoryInterface
{
    public function create(string $name): object;
}