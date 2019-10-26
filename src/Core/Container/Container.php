<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 26.10.2019
 * Time: 18:35
 */

namespace Core\Container;

use Core\Config\Config;
use Core\Factory\AbstractFactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Core\Factory\FactoryInterface;

class Container implements ContainerInterface
{
    /**
     * @var Config
     */
    private $factories;

    /**
     * @var array
     */
    private $map = [];

    /**
     * @var FactoryInterface[]
     */
    private $abstractFactories = [];

    /**
     * @var FactoryInterface
     */
    protected $defaultFactory;

    public function __construct(Config $factories)
    {
        $this->factories = $factories;
    }

    public function get($id): object
    {
        if (isset($this->map[$id])) {
            return $this->map[$id];
        }

        $factories = $this->factories->get('factories');

        if (array_key_exists($id, $factories)) {
            /** @var FactoryInterface $factory */
            $factory = new $factories[$id]($this);
            return $this->map[$id] = $factory->create($id);
        }

        /** @var string $factoryClass */
        foreach ($this->factories->get('abstract_factories') as $factoryClass) {
            $factory = $this->getAbstractFactory($factoryClass);

            if (!$factory->canCreate($id)) {
                continue;
            }

            return $this->map[$id] = $factory->create($id);
        }
    }

    public function has($id): bool
    {
        if (isset($this->factories->get('factories')[$id])) {
            return true;
        }

        /** @var string $factoryClass */
        foreach ($this->factories->get('abstract_factories') as $factoryClass) {
            if ($this->getAbstractFactory($factoryClass)->canCreate($id)) {
                return true;
            }
        }

        return false;
    }

    private function getAbstractFactory(string $name): AbstractFactoryInterface
    {
        if (!isset($this->abstractFactories[$name])) {
            $this->abstractFactories[$name] = new $name($this);
        }

        return $this->abstractFactories[$name];
    }
}