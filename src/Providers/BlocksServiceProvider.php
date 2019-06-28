<?php

namespace Incognito\Providers;

use Iamfredric\Instantiator\Instantiator;

class BlocksServiceProvider implements ServiceProvider
{
    /**
     * Register defined blocks
     *
     * @return void
     */
    public function register()
    {
        if (! function_exists('acf_register_block_type')) {
            return;
        }

        if (! function_exists('add_action')) {
            return;
        }

        add_action('acf/init', function () {
            foreach ($this->blocks() as $block) {
                (new Instantiator($block))->call()->register();
            }
        });
    }

    /**
     * @return array
     */
    protected function blocks()
    {
        return config('blocks') ?: [];
    }
}
