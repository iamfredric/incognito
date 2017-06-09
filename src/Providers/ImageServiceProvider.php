<?php

namespace Incognito\Providers;

use Incognito\Media\ImageRegistrator;

class ImageServiceProvider implements ServiceProvider
{
    public function register()
    {
        return new ImageRegistrator(config('app.config_files.images'));
    }
}