<?php

namespace Tests\Container;

use Incognito\App;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    /** @test */
    function it_binds_a_value_in_the_service_container()
    {
        App::bind('test', 'testvalue');

        $this->assertEquals('testvalue', App::get('test'));
    }

    /** @test */
    function it_resolves_a_service_provider()
    {
        App::provide([
            'test' => \TestProvider::class
        ]);

        $this->assertEquals('provided', App::get('test'));
    }

    /** @test */
    function the_contaier_can_be_called_staticly()
    {
        App::bind('test', 'testvalue');

        $this->assertEquals('testvalue', App::test());
    }
}