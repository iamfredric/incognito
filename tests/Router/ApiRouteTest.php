<?php

namespace Tests\Router;

use Incognito\Routing\ApiRoute;
use PHPUnit\Framework\TestCase;

class ApiRouteTest extends TestCase
{
    /** @test */
    function it_registers_an_api_route()
    {
        $route = new ApiRoute('post', '/test/{id}', 'ApiController@test', null, 'testnamespace');

        $route->register();

        $this->expectOutputString('namespace=testnamespace:url=/test/(?P<id>\w+)');
    }
}