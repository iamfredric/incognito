<?php

namespace Incognito\Containers;

class MenuServiceContainer
{
    /**
     * @var array
     */
    protected $menus = [];

    /**
     * Construction method
     */
    public function make($routesFile)
    {
        $this->parseMenuRoutes($routesFile)
            ->registerMenus();
    }

    /**
     * Registering menus
     *
     * @param $slug
     * @param $label
     *
     * @return void
     */
    public function register($slug, $label)
    {
        $this->menus[$slug] = __($label, config('app.theme-slug'));
    }

    /**
     * Parses the menu routes file
     *
     * @return $this
     */
    protected function parseMenuRoutes($routesFile)
    {
        $menu = $this;

        include_once $routesFile;

        return $this;
    }

    /**
     * Registering menus
     */
    public function registerMenus()
    {
        add_action('after_setup_theme', function () {
            register_nav_menus($this->menus);
        });
    }
}
