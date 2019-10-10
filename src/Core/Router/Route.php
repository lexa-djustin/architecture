<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 29.09.2019
 * Time: 18:07
 */

namespace Core\Router;

use Psr\Http\Message\ServerRequestInterface;

class Route
{
    private $methods;

    private $route;

    private $handler;

    /**
     * Route constructor.
     *
     * @param array $methods
     * @param string $route
     * @param string $handler
     */
    public function __construct(array $methods, string $route, string $handler)
    {
        $this->route = $route;
        $this->methods = $methods;
        $this->handler = $handler;
    }

    public function match(ServerRequestInterface $request): ?RouteMatch
    {
        if (!in_array($request->getMethod(), $this->methods, true)) {
            return null;
        }

        $tokens = [];
        $pattern = '';
        $parts = explode('/', $this->route);
        array_shift($parts);

        foreach ($parts as $part) {
            if (preg_match('/^{(.*):(.+)}$/', $part, $matches)) {
                $tokens[$matches[1]] = null;
                $pattern .= ('\/' . '(' . $matches[2] . ')');
                continue;
            }

            $pattern .= ('\/' . $part);
        }

        if (!preg_match('/^' . $pattern . '$/', $request->getUri()->getPath(), $matches)) {
            return null;
        }

        array_shift($matches);

        foreach (array_keys($tokens) as $i => $name) {
            $tokens[$name] = $matches[$i];
        }

        return new RouteMatch($this->route, $this->handler, $tokens);
    }
}