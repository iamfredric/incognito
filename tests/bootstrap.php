<?php

function get_stylesheet_directory() {
    return __DIR__ . '/boilerplate/';
}

function get_site_url() {
    return 'http://example.com';
}

function get_bloginfo($arg) {
    return 'http://example.com/theme';
}

function wp_upload_dir() {
    return [
        'basedir' => '/example/uploads',
        'baseurl' => 'http://example.com/uploads'
    ];
}

function get_post_meta($key) {
    return 'meta';
}

function get_the_ID() {
    return 1;
}

function add_image_size($size, $width, $height, $crop) {
    echo "{$size}-{$width}-{$height}-{$crop}";
}

function add_action($key, $callable) {
    echo "action:{$key}";
    $callable();
}

function register_nav_menu($slug, $label) {
    echo "{$slug}:{$label}";
}

function __($label, $domain) {
    return "{$label}:$domain";
}

function wp_nav_menu($args) {
    echo json_encode($args);
}

function add_theme_support($key) {
    echo "theme_support";
}

function register_rest_route($namespace, $uri, $args) {
    echo "namespace={$namespace}:url={$uri}";

    return true;
}

function add_filter($key, $callback) {
    if ($key == 'template_include') {
        return $callback('name');
    }

    $callback([]);
}

class TestProvider implements \Incognito\Providers\ServiceProvider
{
    public function register()
    {
        return 'provided';
    }
}

class TestController
{
    public function index()
    {
        return 'Route is resolved';
    }

    public function show()
    {
        return 'Route is shown';
    }
}

class TestComposer
{
    public function test($view)
    {
        return 'It is composed';
    }
}
