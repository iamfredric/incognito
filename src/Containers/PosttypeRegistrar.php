<?php

namespace Incognito\Containers;

class PosttypeRegistrar
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string|null
     */
    private $slug = null;

    /**
     * @var string
     */
    private $type = 'post';

    /**
     * @var string
     */
    private $singular;

    /**
     * @var string
     */
    private $plural;

    /**
     * @var bool
     */
    private $hierarchical = true;

    /**
     * @var array
     */
    private $supports = [
        'title', 'editor', 'author', 'thumbnail', 'excerpt'
    ];

    /**
     * @var bool
     */
    private $public = true;

    /**
     * @var bool
     */
    private $visible = true;

    /**
     * @var bool
     */
    private $archive = false;

    /**
     * @var bool
     */
    private $exportable = true;

    /**
     * @var bool
     */
    private $showInRest = true;

    /**
     * @var string
     */
    private $icon = 'dashicons-admin-post';

    /**
     * @var array
     */
    private $taxonomies = [];

    /**
     * @var bool
     */
    private $menuPosition = true;

    /**
     * @var
     */
    protected $metabox = null;

    /**
     * PosttypeRegistrar constructor.
     *
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Setter for slug
     *
     * @param string $slug
     *
     * @return $this
     */
    public function slug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Setter for type
     *
     * @param string $type post|page
     *
     * @return $this
     */
    public function type($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Setter for singular
     *
     * @param string $name
     *
     * @return $this
     */
    public function singular($name)
    {
        $this->singular = $name;

        return $this;
    }

    /**
     * Setter for plural
     *
     * @param string $name
     *
     * @return $this
     */
    public function plural($name)
    {
        $this->plural = $name;

        return $this;
    }

    /**
     * Sets hierarchial to true
     *
     * @return $this
     */
    public function isMultiLevel()
    {
        $this->hierarchical = true;
        $this->supports[] = 'page-attributes';

        return $this;
    }

    /**
     * Hides type from rest api
     *
     * @return $this
     */
    public function hideFromApi()
    {
        $this->showInRest = false;

        return $this;
    }

    /**
     * Sets hierarchial to false
     *
     * @return $this
     */
    public function isSingleLevel()
    {
        $this->hierarchical = false;

        return $this;
    }

    /**
     * Setter for supports
     *
     * @return $this
     */
    public function supports()
    {
        $this->supports = func_get_args();

        return $this;
    }

    /**
     * Sets visibility to none
     *
     * @return $this;
     */
    public function invisible()
    {
        $this->visible = false;

        return $this;
    }

    /**
     * Sets public to true
     *
     * @return $this;
     */
    public function isPublic()
    {
        $this->public = true;

        return $this;
    }

    /**
     * Sets public to false
     *
     * @return $this;
     */
    public function isPrivate()
    {
        $this->public = false;

        return $this;
    }

    /**
     * Enables archives
     *
     * @return $this
     */
    public function hasArchives()
    {
        $this->archive = true;

        return $this;
    }

    /**
     * Registers a metabox
     *
     * @return $this
     */
    public function withMetabox($metabox)
    {
        $this->metabox = $metabox;

        return $this;
    }

    /**
     * Enables exports
     *
     * @return $this
     */
    public function canBeExported()
    {
        $this->exportable = true;

        return $this;
    }

    /**
     * Getter for slug
     *
     * @return string
     */
    private function getSlug()
    {
        return $this->slug ?: $this->id;
    }

    /**
     * Setter for icon
     *
     * @param string $icon The url to the icon to be used for this menu or the name of the icon from the iconfont
     *
     * @return $this
     */
    public function icon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    public function taxonomy(TaxonomyRegistrar $taxonomy)
    {
        $this->taxonomies[] = $taxonomy;

        return $this;
    }

    /**
     * @param $string
     *
     * @return $this
     */
    public function menuPositionUnder($string)
    {
        $this->menuPosition = $string;

        return $this;
    }

    /**
     * Registers the post type
     *
     * @return void
     */
    public function register()
    {
        $args = [
            'labels' => [
                'name' => _x($this->plural, $this->id),
                'singular_name' => _x($this->singular, $this->id),
            ],
            'hierarchical'          => $this->hierarchical,
            'supports'              => $this->supports,
            'public'                => $this->public,
            'show_ui'               => true,
            'show_in_nav_menus'     => $this->visible,
            'publicly_queryable'    => $this->visible,
            'exclude_from_search'   => !$this->visible,
            'has_archive'           => $this->archive,
            'query_var'             => $this->visible,
            'can_export'            => $this->exportable,
            'rewrite'               => ['slug' => $this->getSlug()],
            'capability_type'       => $this->type,
            'menu_icon'             => $this->icon,
            'show_in_menu'          => $this->menuPosition,
            'show_in_rest'          => $this->showInRest
        ];

        if ($this->metabox) {
            $args['register_meta_box_cb'] = function () {
                return (new $this->metabox())->register();
            };
        }

        register_post_type($this->id, [
            'labels' => [
                'name' => _x($this->plural, $this->id),
                'singular_name' => _x($this->singular, $this->id),
            ],
            'hierarchical'          => $this->hierarchical,
            'supports'              => $this->supports,
            'public'                => $this->public,
            'show_ui'               => true,
            'show_in_nav_menus'     => $this->visible,
            'publicly_queryable'    => $this->visible,
            'exclude_from_search'   => ! $this->visible,
            'has_archive'           => $this->archive,
            'query_var'             => $this->visible,
            'can_export'            => $this->exportable,
            'rewrite'               => ['slug' => $this->getSlug()],
            'capability_type'       => $this->type,
            'menu_icon'             => $this->icon,
            'show_in_menu'          => $this->menuPosition,
            'show_in_rest'          => $this->showInRest
        ]);

        foreach ($this->taxonomies as $taxonomy) {
            $taxonomy->register($this->id);
        }
    }
}
