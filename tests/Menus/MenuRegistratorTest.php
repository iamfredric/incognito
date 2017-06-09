<?php

namespace Tests\Menus;

use Incognito\Menus\MenuItem;
use Incognito\Menus\MenuRegistrator;
use PHPUnit\Framework\TestCase;

class MenuRegistratorTest extends TestCase
{
    /** @test */
    function it_reads_a_config_file_and_registers_menus()
    {
        // Create config file
        $testfilepath = get_stylesheet_directory() . 'menus.php';

        file_put_contents($testfilepath, '<?php $menu->register("testmenu", "Me smashing menu");');

        $registrator = new MenuRegistrator($testfilepath, 'my-testdomain');

        $this->expectOutputString('action:after_setup_themetestmenu:Me smashing menu:my-testdomain');

        unlink($testfilepath);
    }

    /** @test */
    function it_can_fetch_a_menuitem_based_on_a_slug()
    {
        // Create config file
        $testfilepath = get_stylesheet_directory() . 'menus2.php';

        file_put_contents($testfilepath, '<?php $menu->register("testmenu", "Me smashing menu");');

        $registrator = new MenuRegistrator($testfilepath, 'my-testdomain');

        $menuitem = $registrator->get('testmenu');

        $this->assertInstanceOf(MenuItem::class, $menuitem);
        $this->assertEquals('Me smashing menu', $menuitem->label);

        $nonExistingItem = $registrator->get('menunoexists');

        $this->assertNull($nonExistingItem);

        unlink($testfilepath);
    }
}