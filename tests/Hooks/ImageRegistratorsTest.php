<?php

namespace Tests\Hooks;

use Incognito\Media\ImageRegistrator;
use PHPUnit\Framework\TestCase;

class ImageRegistratorsTest extends TestCase
{
    /** @test */
    function it_reads_a_config_file_and_parses_the_images()
    {
        // Create config file
        $testfilepath = get_stylesheet_directory() . 'images.php';

        file_put_contents($testfilepath, '<?php $image->register("testimage")->width(200)->height(400)->crop();');

        $registrator = new ImageRegistrator($testfilepath);

        $this->expectOutputString('action:inittheme_supporttestimage-200-400-1testimage@2x-400-800-1');

        unlink($testfilepath);

    }

    /** @test */
    function an_images_can_be_registered_in_one_method_call()
    {
        // Create config file
        $testfilepath = get_stylesheet_directory() . 'images2.php';

        file_put_contents($testfilepath, '<?php $image->register("testimage", 300, 600, true); ');

        $registrator = new ImageRegistrator($testfilepath);

        $this->expectOutputString('action:inittheme_supporttestimage-300-600-1testimage@2x-600-1200-1');

        unlink($testfilepath);
    }

    /** @test */
    function when_no_images_are_defined_no_images_are_registered()
    {
        // Create config file
        $testfilepath = get_stylesheet_directory() . 'images3.php';

        file_put_contents($testfilepath, '<?php ');

        $registrator = new ImageRegistrator($testfilepath);

        $this->expectOutputString('');

        unlink($testfilepath);
    }
}