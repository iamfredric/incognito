<?php

namespace Incognito\Containers;

abstract class Metabox
{
    /**
     * @return string
     */
    abstract public function id();

    /**
     * @return string
     */
    abstract public function title();

    /**
     * @return string
     */
    abstract public function render();

    /**
     * @return void
     */
    public function register()
    {
        return add_meta_box(
            $this->id(), $this->title(), function () {
                return $this->render();
            }, null, $this->position(), 'high|low|default', null
        );
    }

    /**
     * @return string normal|side|advanced
     */
    public function position()
    {
        return 'side';
    }

    /**
     * @return string high|low|default
     */
    public function order()
    {
        return 'default';
    }
}
