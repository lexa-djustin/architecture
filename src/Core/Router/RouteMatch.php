<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 29.09.2019
 * Time: 19:28
 */

namespace Core\Router;


class RouteMatch
{
    /**
     * @var string
     */
    private $route;

    /**
     * @var string
     */
    private $handler;

    /**
     * @var array
     */
    private $tokens;

    public function __construct(string $route, string $handler, array $tokens)
    {
        $this->route = $route;
        $this->handler = $handler;
        $this->tokens = $tokens;
    }

    /**
     * @return string
     */
    public function route(): string
    {
        return $this->route;
    }

    /**
     * @return string
     */
    public function handler(): string
    {
        return $this->handler;
    }

    /**
     * @return array
     */
    public function tokens(): array
    {
        return $this->tokens;
    }
}