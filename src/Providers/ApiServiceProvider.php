<?php

namespace Incognito\Providers;

use Incognito\Routing\ApiRouter;

class ApiServiceProvider implements ServiceProvider
{
    /**
     * @return \Incognito\Routing\ApiRouter
     */
    public function register()
    {
        return new ApiRouter(
            config('app.config_files.api_routes'),
            config('app.namespaces.controllers')
        );
    }
}
