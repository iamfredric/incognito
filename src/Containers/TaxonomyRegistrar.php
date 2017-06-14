<?php

namespace Incognito\Containers;

class TaxonomyRegistrar
{
    /**
     * @var
     */
    private $slug;

    /**
     * @var bool
     */
    private $showUi = true;

    /**
     * @var bool
     */
    private $queryVar = true;

    /**
     * @var bool
     */
    private $hierarchical = true;

    /**
     * @var
     */
    private $singular;

    /**
     * @var
     */
    private $plural;

    /**
     * @var
     */
    private $menuname;


    /**
     * @param $slug
     *
     * @return $this
     */
    public function slug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @param $singular
     *
     * @return $this
     */
    public function singular($singular)
    {
        $this->singular = $singular;

        return $this;
    }

    /**
     * @param $plural
     *
     * @return $this
     */
    public function plural($plural)
    {
        $this->plural = $plural;

        return $this;
    }

    /**
     * @param $menuname
     *
     * @return $this
     */
    public function menuname($menuname)
    {
        $this->menuname = $menuname;

        return $this;
    }

    /**
     * @return $this
     */
    public function isNotHierarchical()
    {
        $this->hierarchical = false;

        return $this;
    }

    /**
     * @return $this
     */
    public function isHierarchical()
    {
        $this->hierarchical = true;

        return $this;
    }

    /**
     * @return string
     */
    protected function getSlug()
    {
        return $this->slug ?: str_slug($this->singular);
    }

    /**
     * @return mixed
     */
    protected function getMenuname()
    {
        return $this->menuname ?: $this->plural;
    }

    /**
     * @param $posttype
     */
    public function register($posttype)
    {
        register_taxonomy($this->getSlug(), $posttype, [
            'hierarchical' => $this->hierarchical,
            'show_ui' => $this->showUi,
            'query_var' => $this->queryVar,

            'labels' => [
                'name' => $this->plural,
                'edit_item' => __("Redigera {$this->singular}"),
                'update_item' => __("Uppdatera {$this->singular}"),
                'add_new_item' => __("Lägg till {$this->singular}"),
                'new_item_name' => __("Ny {$this->singular}"),
                'menu_name' => $this->getMenuname()
            ]
        ]);
    }
}
