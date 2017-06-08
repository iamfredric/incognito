<?php

namespace Tests\Helpers;

use PHPUnit\Framework\TestCase;

class UploadsUrlTest extends TestCase
{
    /** @test */
    function it_fetches_the_uploads_url()
    {
        $this->assertEquals(
            'http://example.com/uploads/testupload',
            uploads_url('/testupload')
        );
    }
}