<?php

namespace Tests\Helpers;

use PHPUnit\Framework\TestCase;

class ThemeUrlHelperTest extends TestCase
{
    /** @test */
    function it_fetches_the_theme_url()
    {
        $this->assertEquals(
            'http://example.com/theme/test/test',
            theme_url('/test/test/')
        );
    }
}