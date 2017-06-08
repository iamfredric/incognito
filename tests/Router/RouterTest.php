<?php

namespace Tests\Router;

use Incognito\Routing\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /** @test */
    function routes_can_be_defined_on_the_router_object()
    {
        $router = new Router();

        $router->register('test', 'TestController@index');

        $this->assertEquals('Route is resolved', $router->resolve('test'));
    }

    /** @test */
    function routes_can_be_read_from_a_routes_file()
    {
        $routesFile = get_stylesheet_directory() . 'routes.php';
        file_put_contents($routesFile, '<?php $route->template("fileroutertest", "Me template", "TestController@show"); $route->register("testroute", "TestController@index");');

        $router = new Router();

        $router->make($routesFile);

        $this->assertEquals('Route is shown', $router->resolve('fileroutertest'));
        $this->assertEquals('Route is resolved', $router->resolve('testroute'));

        unlink($routesFile);
    }
}