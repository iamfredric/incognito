<?php

namespace Incognito\Blocks;

use Incognito\Utilities\Transformer;

abstract class Block
{
    use Transformer;

    /**
     * @var null|string
     */
    protected $prefix = null;

    /**
     * @param $attributes
     *
     * @return \duncan3dc\Laravel\BladeInstance
     */
    public function render($attributes)
    {
        return view($this->view(), $this->transform($attributes->toArray()));
    }

    /**
     * @return string
     */
    public function view()
    {
        if ($this->prefix) {
            return "blocks.{$this->prefix}.{$this->name()}";
        }

        return "blocks.{$this->name()}";
    }

    /**
     * The identifier of the block
     *
     * @return string
     */
    abstract protected function name();

    /**
     * The block title
     *
     * @return string
     */
    abstract protected function title();

    /**
     * The description of the block
     *
     * @return string
     */
    abstract protected function description();

    /**
     * The category of the block
     *
     * @return string [common | formatting | layout | widgets | embed]
     */
    abstract protected function category();

    /**
     * The icon of the block
     *
     * @return string
     */
    abstract protected function icon();

    /**
     * The keywords of the block
     *
     * @return array
     */
    abstract protected function keywords();

    /**
     * The mode of the block
     *
     * @return string
     */
    protected function mode()
    {
        return 'auto';
    }

    /**
     * Registers the block
     *
     * @return void
     */
    public function register()
    {
        acf_register_block_type([
            'name' => $this->name(),
            'title' => $this->title(),
            'description' => $this->description(),
            'category' => $this->category(),
            'icon' => $this->icon(),
            'keywords' => $this->keywords(),
            'mode' => $this->mode(),
            'render_callback' => function($d) {
                echo '<div class="custom-block">' . $this->render(collect(get_fields())) . '</div>';
            }
        ]);
    }
}
