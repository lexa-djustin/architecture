<?php

namespace Tests\Core\Router;

use Core\Router\{
    Route, RouteMatch
};
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;

class RouteTest extends TestCase
{
    /**
     * @dataProvider correctData
     *
     * @param Route $route
     * @param ServerRequest $request
     * @param RouteMatch $routeMatch
     */
    public function testCorrectRoutes(Route $route, ServerRequest $request, RouteMatch $routeMatch): void
    {
        $result = $route->match($request);

        self::assertInstanceOf(RouteMatch::class, $result);
        self::assertSame($routeMatch->tokens(), $result->tokens());
    }

    /**
     * @dataProvider wrongData
     *
     * @param Route $route
     * @param ServerRequest $request
     *
     * @return void
     */
    public function testWrongRoutes(Route $route, ServerRequest $request): void
    {
        $result = $route->match($request);

        self::assertNull($result);
    }

    /**
     * @return array
     */
    public function correctData(): array
    {
        return [
            [
                new Route(['GET'], '/', ''),
                new ServerRequest([], [], '/', 'GET'),
                new RouteMatch('/', '', [])
            ],
            [
                new Route(['POST'], '/', ''),
                new ServerRequest([], [], '/', 'POST'),
                new RouteMatch('/', '', [])
            ],
            [
                new Route(['GET', 'POST'], '/foo', ''),
                new ServerRequest([], [], '/foo', 'POST'),
                new RouteMatch('/foo', '', [])
            ],
            [
                new Route(['GET'], '/foo/bar/baz', ''),
                new ServerRequest([], [], '/foo/bar/baz', 'GET'),
                new RouteMatch('/foo/bar/baz', '', [])
            ],
            [
                new Route(['GET'], '/foo/bar/baz/{foo:\d+}', ''),
                new ServerRequest([], [], '/foo/bar/baz/1', 'GET'),
                new RouteMatch('/foo/bar/baz/1', '', ['foo' => '1'])
            ],
            [
                new Route(['GET'], '/foo/bar/baz/{foo:\d+}/{bar:\w+}', ''),
                new ServerRequest([], [], '/foo/bar/baz/1/1', 'GET'),
                new RouteMatch('/foo/bar/baz/1', '', ['foo' => '1', 'bar' => '1'])
            ],
            [
                new Route(['GET'], '/foo-bar-baz', ''),
                new ServerRequest([], [], '/foo-bar-baz', 'GET'),
                new RouteMatch('/foo/bar/baz/1', '', [])
            ],
        ];
    }

    /**
     * @return array
     */
    public function wrongData(): array
    {
        return [
            [
                new Route(['POST'], '/foo', ''),
                new ServerRequest([], [], '/foo', 'GET'),
            ],
            [
                new Route(['GET'], '/foo/bar/baz/{foo:\d+}', ''),
                new ServerRequest([], [], '/foo/bar/baz/A', 'GET'),
            ],
        ];
    }
}