<?php

namespace Incognito\Menus;

class MenuItem
{
    /**
     * @var string
     */
    public $slug;

    /**
     * @var null|string
     */
    public $label;

    /**
     * @var null|string
     */
    public $themeSlug;

    /**
     * MenuItem constructor.
     *
     * @param $slug
     * @param null $label
     * @param null $themeSlug
     */
    public function __construct($slug, $label = null, $themeSlug = null)
    {
        $this->slug = $slug;
        $this->label = $label;
        $this->themeSlug = $themeSlug;
    }

    /**
     * Renders menu
     *
     * @param array $args
     */
    public function render($args = [])
    {
        wp_nav_menu(array_merge([
            'theme_location' => $this->slug,
            'container' => null,
            'items_wrap' => '%3$s'
        ], $args));
    }

    /**
     * Registers menu
     *
     * @return void
     */
    public function register()
    {
        register_nav_menu($this->slug, __($this->label, $this->themeSlug));
    }
}