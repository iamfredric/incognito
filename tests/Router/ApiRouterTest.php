<?php

namespace Tests\Router;

use Incognito\Routing\ApiRouter;
use PHPUnit\Framework\TestCase;

class ApiRouterTest extends TestCase
{
    /** @test */
    function it_reads_a_routes_file_and_makes_routes()
    {
        $routesFile = get_stylesheet_directory() . 'api.php';
        file_put_contents($routesFile, '<?php $route->get("/tests", "TestsController@test");$route->post("/tests", "PostsController@post");');

        new ApiRouter($routesFile);

        $this->expectOutputString('action:rest_api_initnamespace=:url=/testsnamespace=:url=/tests');

        unlink($routesFile);
    }
}