<?php

namespace Incognito\Utilities\Wordpress;

class WpImage
{
    /**
     * @var int
     */
    protected $postId;

    /**
     * @var int
     */
    protected $thumbnailId;

    /**
     * WpImage constructor.
     *
     * @param $postId
     */
    public function __construct($postId)
    {
        $this->postId = $postId;
    }

    /**
     * Getter of the thubnail id
     *
     * @return int
     */
    public function id()
    {
        if ( ! $this->thumbnailId) {
            $this->thumbnailId = get_post_thumbnail_id($this->postId);
        }

        return $this->thumbnailId;
    }

    /**
     * Getter for the title
     *
     * @return string
     */
    public function title()
    {
        return get_the_title($this->id());
    }

    /**
     * Getter for the url
     *
     * @param string $size optional
     *
     * @return string
     */
    public function url($size = null)
    {
        return get_the_post_thumbnail_url($this->id, $size);
    }

    /**
     * Getter for the html
     *
     * @param string $size
     * @param array $attr optional
     *
     * @return string
     */
    public function render($size = null, $attr = [])
    {
        return get_the_post_thumbnail($this->postId, $size, $attr);
    }

    /**
     * Getter for the style params
     *
     * @param null $size
     *
     * @return string|null
     */
    public function style($size = null)
    {
        if ( ! $srcset = wp_get_attachment_image_srcset($this->id(), $size)) {
            return null;
        }

        $srcsets     = explode(', ', $srcset);
        $currentSize = '';

        $css = [];

        foreach ($srcsets as $set) {
            $parts = explode(' ', $set);

            $url = esc_url($parts[0]);

            $imageTag = "background-image: url({$url});";

            if ($currentSize) {
                $css[] = "@media only screen and (min-width: {$currentSize}) { {$imageTag} }";
            } else {
                $css[] = $imageTag;
            }

            $currentSize = str_replace('w', 'px', $parts[1]);
        }

        return implode('', $css);
    }

    /**
     * @return boolean
     */
    public function exists()
    {
        return has_post_thumbnail($this->postId);
    }
}
