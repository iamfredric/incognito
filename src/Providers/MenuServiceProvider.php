<?php

namespace Incognito\Providers;

use Incognito\Containers\MenuServiceContainer;

class MenuServiceProvider implements ServiceProvider
{
    public function register()
    {
        return new MenuServiceContainer();
    }
}