<?php

namespace Incognito\Providers;

use Incognito\Routing\Router;

class RouterServiceProvider implements ServiceProvider
{
    public function register()
    {
        return new Router(
            config('app.config_files.routes'),
            config('app.namespaces.controllers')
        );
    }
}