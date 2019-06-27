<?php

namespace Incognito\Hooks;

abstract class Filter
{
    /**
     * The priority level
     *
     * @var int
     */
    public $priority = 10;

    /**
     * The hook or hooks that should be registered for
     * the given class
     *
     * @return string|array
     */
    abstract public function hook();

    /**
     * Registers the hook
     *
     * @return void
     */
    public function register()
    {
        foreach ((array) $this->hook() as $hook) {
            add_filter($hook, function () {
                return call_user_func_array([$this, 'filter'], func_get_args());
            }, $this->priority);
        }
    }
}
