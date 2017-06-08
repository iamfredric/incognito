<?php

namespace Tests\Helpers;

use PHPUnit\Framework\TestCase;

class ThemePathTest extends TestCase
{
    /** @test */
    function it_fetches_the_theme_path()
    {
        $this->assertEquals(
            get_stylesheet_directory() . 'test/test',
            theme_path('/test/test/')
        );
    }
}