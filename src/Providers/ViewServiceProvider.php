<?php

namespace Incognito\Providers;

use Incognito\ViewServiceContainer;

class ViewServiceProvider implements ServiceProvider
{
    public function register()
    {
        return new ViewServiceContainer(
            config('app.views-path'),
            config('app.views-cache-path'),
            config('app.views.composers', []),
            config('app.views.directives', [])
        );
    }
}