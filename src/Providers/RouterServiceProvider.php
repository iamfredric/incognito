<?php

namespace Incognito\Providers;

use Incognito\Routing\Router;

class RouterServiceProvider implements ServiceProvider
{
    public function register()
    {
        return new Router();
    }
}