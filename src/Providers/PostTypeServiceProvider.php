<?php

namespace Incognito\Providers;

use Incognito\Containers\PostTypeContainer;

class PostTypeServiceProvider implements ServiceProvider
{
    public function register()
    {
        return new PostTypeContainer(
            config('app.config_files.posttypes')
        );
    }
}