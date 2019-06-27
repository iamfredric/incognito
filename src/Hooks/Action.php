<?php

namespace Incognito\Hooks;

abstract class Action
{
    /**
     * The priority level of hook
     *
     * @var int
     */
    public $priority = 10;

    /**
     * The hook or hooks
     *
     * @return mixed|array
     */
    abstract public function hook();

    /**
     * Registers the action hook
     *
     * @return void
     */
    public function register()
    {
        foreach ((array) $this->hook() as $hook) {
            add_filter($hook, function () {
                return call_user_func_array([$this, 'action'], func_get_args());
            }, $this->priority);
        }
    }
}
