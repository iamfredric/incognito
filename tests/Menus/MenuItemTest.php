<?php

namespace Tests\Menus;

use Incognito\Menus\MenuItem;
use PHPUnit\Framework\TestCase;

class MenuItemTest extends TestCase
{
    /** @test */
    function it_registers_a_nav_item()
    {
        $item = new MenuItem('menuslug', 'Menutitle', 'my-domain');

        $item->register();

        $this->expectOutputString('menuslug:Menutitle:my-domain');
    }

    /** @test */
    function it_renders_a_menu_item()
    {
        $item = new MenuItem('menuslug', 'Menutitle', 'my-domain');

        $item->render();

        $this->expectOutputString('{"theme_location":"menuslug","container":null,"items_wrap":"%3$s"}');
    }
}