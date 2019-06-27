<?php

namespace Incognito\Providers;

use Iamfredric\Instantiator\Instantiator;

class HooksServiceProvider implements ServiceProvider
{
    /**
     * Register actions and filters
     *
     * @return void
     */
    public function register()
    {
        // Actions
        if ($actions = config('hooks.actions')) {
            foreach ($actions as $name => $classname) {
                (new Instantiator($classname))->callMethod('register');
            }
        }

        // Filters
        if ($filters = config('hooks.filters')) {
            foreach ($filters as $classname) {
                $class = (new Instantiator($classname))->call();

                $class->register();
            }
        }
    }
}
