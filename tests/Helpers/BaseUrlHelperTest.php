<?php

namespace Tests\Helpers;

use PHPUnit\Framework\TestCase;

class BaseUrlHelperTest extends TestCase
{
    /** @test */
    function it_fetches_the_base_url()
    {
        $this->assertEquals(
            'http://example.com/test/test',
            base_url('/test/test')
        );
    }
}