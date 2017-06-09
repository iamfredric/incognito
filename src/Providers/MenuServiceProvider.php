<?php

namespace Incognito\Providers;

use Incognito\Menus\MenuRegistrator;

class MenuServiceProvider implements ServiceProvider
{
    public function register()
    {
        return new MenuRegistrator(
            config('app.config_files.menus'),
            config('app.theme-slug')
        );
    }
}