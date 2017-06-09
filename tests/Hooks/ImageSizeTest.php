<?php

namespace Tests\Hooks;

use Incognito\Media\ImageSize;
use PHPUnit\Framework\TestCase;

class ImageSizeTest extends TestCase
{
    /** @test */
    function an_image_contains_all_data_for_the_registration()
    {
        $image = new ImageSize('testimage');
        $image->width(200)
            ->height(220)
            ->crop();

        $this->assertEquals(200, $image->width);
        $this->assertEquals(220, $image->height);
        $this->assertTrue($image->crop);

        $image->scale();

        $this->assertFalse($image->crop);
    }

    /** @test */
    function it_registers_an_image()
    {
        $image = new ImageSize('testimage');

        $image->width(200)
              ->height(220);

        $image->register();

        $this->expectOutputString('testimage-200-220-1testimage@2x-400-440-1');
    }
}