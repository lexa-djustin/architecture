<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 26.10.2019
 * Time: 18:40
 */

namespace Core\Twig;

use Core\Config\Config;
use Core\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Factory implements FactoryInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function create(string $name): object
    {
        $config = $this->container->get(Config::class);
        $loader = new FilesystemLoader($config->get('twig.templates'));

        return new Environment($loader, $config->get('twig.environment'));
    }
}