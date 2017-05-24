<?php

namespace Incognito\Containers;

class ImageServiceContainer
{
    /**
     * @var array
     */
    protected $images = [];

    /**
     * @var array
     */
    protected $types = [];

    /**
     * Construction method
     */
    public function make($routesPath)
    {
        $this->parseImageRoutes($routesPath)
            ->registerImages();
    }

    /**
     * Set specified post types for thumbnails
     */
    public function enable()
    {
        $this->types = func_get_args();
    }

    /**
     * Registers a new image size
     *
     * @param $name
     * @param null $width
     * @param null $height
     * @param bool $crop
     *
     * @return ImageRegistrar
     */
    public function register($name, $width = null, $height = null, $crop = false, $retina = false)
    {
        $image = new ImageRegistrar($name);

        if ($width) {
            $image->width($width);
        }

        if ($height) {
            $image->width($height);
        }

        if ($crop) {
            $image->crop($crop);
        }

        if($retina) {
            $image->retina($retina);
        }

        $this->images[] = $image;

        return $image;
    }

    /**
     * @return $this
     */
    protected function parseImageRoutes($routesPath)
    {
        $image = $this;

        include_once $routesPath;

        return $this;
    }

    /**
     * @return $this
     */
    public function registerImages()
    {
        if (! count($this->images)) {
            return $this;
        }

        add_action('init', function () {
            add_theme_support('post-thumbnails', $this->types);

            foreach ($this->images as $image) {
                add_image_size($image->name, $image->width, $image->height, $image->crop);
                add_image_size($image->name . '@2x', $image->width*2, $image->height*2, $image->crop);
            }
        });
    }
}