<?php

namespace Incognito\Providers;

use Incognito\Routing\ApiRouter;

class InstantiatorServiceProvider implements ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        if ($bindings = config('app.bindings')) {
            foreach ($bindings as $classname => $callable) {
                \Iamfredric\Instantiator\Instantiator::bind($classname, $callable);
            }
        }
    }
}