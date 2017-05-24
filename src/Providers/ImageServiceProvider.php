<?php

namespace Incognito\Providers;

use Incognito\Containers\ImageServiceContainer;

class ImageServiceProvider implements ServiceProvider
{
    public function register()
    {
        return new ImageServiceContainer;
    }
}