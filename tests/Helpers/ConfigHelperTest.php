<?php

namespace Tests\Helpers;

use PHPUnit\Framework\TestCase;

class ConfigHelperTest extends TestCase
{
    /** @test */
    function it_get_a_value_from_a_config_file()
    {
        $testfilepath = get_stylesheet_directory() . 'config/config.php';

        file_put_contents($testfilepath, "<?php return ['test' => ['leveldownl' => strtolower('TESTCONFIGVALUE')]]; ");

        $this->assertEquals('testconfigvalue', config('config.test.leveldownl'));

        unlink($testfilepath);
    }
}