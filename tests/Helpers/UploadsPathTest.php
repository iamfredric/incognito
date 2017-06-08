<?php

namespace Tests\Helpers;

use PHPUnit\Framework\TestCase;

class UploadsPathTest extends TestCase
{
    /** @test */
    function it_fetches_the_uploads_path()
    {
        $this->assertEquals(
            '/example/uploads/testupload',
            uploads_path('/testupload')
        );
    }
}