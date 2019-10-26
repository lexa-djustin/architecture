<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 26.10.2019
 * Time: 19:44
 */

namespace Core\Factory;

use Psr\Container\ContainerInterface;
use ReflectionClass;

abstract class AbstractReflectionFactory implements AbstractFactoryInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function create(string $name = null): object
    {
        $class = new ReflectionClass($name);
        $constructor = $class->getConstructor();
        $arguments = [];

        foreach ($constructor->getParameters() as $parameter) {
            $type = $parameter->getType()->getName();

            if (!$this->container->has($type)) {
                throw new \Exception('Can\'t resolve dependency');
            }

            $arguments[] = $this->container->get($type);
        }

        return new $name(...$arguments);
    }

    abstract public function canCreate(string $name): bool;
}