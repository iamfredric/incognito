<?php

namespace Incognito\Menus;

class MenuRegistrator
{
    /**
     * @var null|string
     */
    protected $themeSlug;

    /**
     * @var array
     */
    protected $menus = [];

    /**
     * MenuRegistrator constructor.
     *
     * @param $configFilePath
     * @param null $themeSlug
     */
    public function __construct($configFilePath, $themeSlug = null)
    {
        $this->themeSlug = $themeSlug;

        $this->getRoutes($configFilePath)
             ->registerRoutes();
    }

    /**
     * @param $slug
     * @param $label
     *
     * @return mixed
     */
    public function register($slug, $label)
    {
        $this->menus[$slug] = new MenuItem($slug, $label, $this->themeSlug);

        return $this->menus[$slug];
    }

    /**
     * @param $key
     *
     * @return mixed|null
     */
    public function get($key)
    {
        return isset($this->menus[$key])
            ? $this->menus[$key]
            : null;
    }

    /**
     * @param $configFilePath
     *
     * @return $this
     */
    protected function getRoutes($configFilePath)
    {
        $menu = $this;

        include_once $configFilePath;

        return $this;
    }

    /**
     *
     */
    protected function registerRoutes()
    {
        add_action('after_setup_theme', function () {
            foreach ($this->menus as $menu) {
                $menu->register();
            }
        });
    }
}