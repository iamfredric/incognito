<?php

namespace Tests\Router;

use Incognito\Routing\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    /** @test */
    function it_registers_a_route_endpoint_classname()
    {
        $route = new Route('testroute', 'TestController@index', '');

        $this->assertEquals(
            'TestController',
            $route->getClassName()
        );
    }

    /** @test */
    function it_registers_a_route_endpoint_method()
    {
        $route = new Route('testroute', 'TestController@index', '');

        $this->assertEquals(
            'index',
            $route->getMethodName()
        );
    }

    /** @test */
    function it_registers_a_route_class_with_namespace()
    {
        $route = new Route('testroute', 'TestController@index', 'App\\Http\\Controllers');

        $this->assertEquals(
            'App\\Http\\Controllers\\TestController',
            $route->getClassName()
        );
    }

    /** @test */
    function it_fetches_the_route_name()
    {
        $route = new Route('testroute', 'TestController@index', 'App\\Http\\Controllers');

        $this->assertEquals(
            'testroute',
            $route->getName()
        );
    }

    /** @test */
    function it_resolves_the_route()
    {
        $route = new Route('testroute', 'TestController@index');

        $this->assertEquals(
            'Route is resolved',
            $route->resolve()
        );
    }
}