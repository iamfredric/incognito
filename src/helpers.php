<?php

/**
 * Fetches the configuration key that responds to
 * the given configuration key
 *
 * @param  string $key
 * @param  string $default Default value
 *
 * @return mixed
 */
function config($key, $default = null)
{
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

/**
 * Gets the view instances
 *
 * @param  string $view
 * @param  array  $data
 *
 * @return \duncan3dc\Laravel\BladeInstance
 */
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

        $manifestFile = theme_path(config('app.assets-path') . '/mix-manifest.json');

        if (! file_exists($manifestFile)) {
            return assets($originalFilename);
        }

        $manifest = json_decode(file_get_contents($manifestFile));

        return isset($manifest->{$filename})
            ? assets($manifest->{$filename})
            : assets($originalFilename);
    }
}

if (! function_exists('assets')) {
    function assets($file)
    {
        $file = ltrim($file, '/');

        return theme_url(str_replace('//', '/', config('app.assets-path') . "/{$file}"));
    }
}

if (! function_exists('array_to_object')) {
    function array_to_object($array)
    {
        $object = new stdClass();

        foreach ($array as $key => $value) {
            $object->{str_dash_to_camel($key)} = $value;
        }

        return $object;
    }
}

if (! function_exists('str_dash_to_camel')) {
    function str_dash_to_camel($string)
    {
        $values = array_map(function ($value) {
            return ucfirst(strtolower($value));
        }, explode('-', $string));

        return lcfirst(implode('', $values));
    }
}

if (! function_exists('view_composer')) {
    function view_composer($key, $endpoint)
    {
        return view()->composer($key, function ($view) use ($endpoint) {
            $parts     = explode('@', $endpoint);
            $classname = "App\\Http\\Composers\\{$parts[0]}";
            $method    = isset($parts[1]) ? $parts[1] : 'compose';

            $class = new \Iamfredric\Instantiator\Instantiator($classname);

            return ($class->call())->{$method}($view);
        });
    }
}
