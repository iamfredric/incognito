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
    return rtrim(get_site_url(), '/') . '/'. trim($uri, '/');
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
    return rtrim(get_bloginfo('stylesheet_directory'), '/') . '/' . trim($url, '/');
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
    return rtrim(get_stylesheet_directory(), '/') . '/' . trim($path, '/');
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

    return rtrim($directory['basedir'], '/') . '/' . trim($path, '/');
}

function uploads_url($path = '')
{
    $directory = wp_upload_dir();

    return rtrim($directory['baseurl'], '/') . '/' . trim($path, '/');
}

if (! function_exists('mix')) {
    function mix($originalFilename)
    {
        $filename = '/'.ltrim($originalFilename, '/');

        $mainfestFile = theme_path('mix-manifest.json');

        if (! file_exists($mainfestFile)) {
            return theme_url($originalFilename);
        }

        $manifest = json_decode(file_get_contents($mainfestFile));

        return isset($manifest->{$filename})
            ? theme_url($manifest->{$filename})
            : theme_url($originalFilename);
    }
}
