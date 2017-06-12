<?php

namespace Tests\Views;

use duncan3dc\Laravel\BladeInstance;
use Incognito\Views\BladeViewContainer;
use Mockery;
use PHPUnit\Framework\TestCase;

class BladeViewContainerTest extends TestCase
{
    /** @test */
    function it_sets_up_blade()
    {
        $instance = new BladeViewContainer('path/to/views', 'path/to/cache');

        $this->assertInstanceOf(BladeInstance::class, $instance->getInstance());
    }

    /** @test */
    function a_view_composer_can_be_added()
    {
        $bladeInstance = Mockery::mock(BladeInstance::class);

        $bladeInstance->shouldReceive('composer')->once(); // ->with(['testkey', 'callback']);

        $instance = new BladeViewContainer(null, null, $bladeInstance);

        $output = $instance->composer('testkey', function ($view) {
            return 'callback';
        });

        $this->assertInstanceOf(BladeViewContainer::class, $output);
    }

    /** @test */
    function a_view_composer_can_be_added_as_a_method_string()
    {
        $bladeInstance = Mockery::mock(BladeInstance::class);

        $bladeInstance->shouldReceive('composer')->once();

        $instance = new BladeViewContainer(null, null, $bladeInstance);

        $output = $instance->composer('testkey', 'ComposerClass@compose');

        $this->assertInstanceOf(BladeViewContainer::class, $output);
    }

    /** @test */
    function a_view_directive_can_be_added()
    {
        $bladeInstance = Mockery::mock(BladeInstance::class);

        $bladeInstance->shouldReceive('directive')->once(); // ->with(['testkey', 'callback']);

        $instance = new BladeViewContainer(null, null, $bladeInstance);

        $output = $instance->directive('testkey', function ($view) {
            return 'callback';
        });

        $this->assertInstanceOf(BladeViewContainer::class, $output);
    }

    /** @test */
    function a_view_directive_can_be_added_as_a_method_string()
    {
        $bladeInstance = Mockery::mock(BladeInstance::class);

        $bladeInstance->shouldReceive('directive')->once();

        $instance = new BladeViewContainer(null, null, $bladeInstance);

        $output = $instance->directive('testkey', 'ComposerClass@compose');

        $this->assertInstanceOf(BladeViewContainer::class, $output);
    }

    public function tearDown()
    {
        Mockery::close();
    }
}