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
