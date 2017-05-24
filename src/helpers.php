<?php

function config($key, $default = null) {
    $keys = explode('.', $key);

    $value = require theme_path('config/' . $keys[0] .'.php');

    unset($keys[0]);
    foreach ($keys as $key) {
        if (! isset($value[$key])) {
            $value = $default;
            break;
        }
        $value = $value[$key];
    }

    return $value;
}

function view($view = null, $data = [])
{
    $instance = \Incognito\App::view()->getBladeInstance();

    if (empty($view)) {
        return $instance;
    }

    return $instance->render($view, $data);
}

/**
 * Basic helper for getting the base url of the page
 *
 * @param  string $uri optional
 *
 * @return string
 */
function base_url($uri = '')
{
    return get_site_url().'/'.$uri;
}

/**
 * Basic helper for getting the theme url
 *
 * @param  string $url optional
 *
 * @return string
 */
function theme_url($url = '')
{
    return get_bloginfo('stylesheet_directory') . '/' . $url;
}

/**
 * Basic helper for getting the absolute theme path
 *
 * @param  string $path optional
 *
 * @return string
 */
function theme_path($path = '')
{
    return get_stylesheet_directory() . '/' . $path;
}

/**
 * Basig helper for getting absoulte uploads path
 *
 * @param string $path
 *
 * @return string
 */
function uploads_path($path = '')
{
    $directory = wp_upload_dir();

    return $directory['basedir'] . '/' . $path;
}

function uploads_url($path = '')
{
    $directory = wp_upload_dir();

    return $directory['baseurl'] . '/' . $path;
}


