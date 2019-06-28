<?php

if (! function_exists('config')) {
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
}

if (! function_exists('view')) {
    /**
     * Gets the view instances
     *
     * @param string $view
     * @param array $data
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
}

if (! function_exists('base_url')) {
    /**
     * Basic helper for getting the base url of the page
     *
     * @param string $uri optional
     *
     * @return string
     */
    function base_url($uri = '')
    {
        return rtrim(get_site_url(), '/') . '/' . trim($uri, '/');
    }
}

if (! function_exists('theme_url')) {
    /**
     * Basic helper for getting the theme url
     *
     * @param string $url optional
     *
     * @return string
     */
    function theme_url($url = '')
    {
        return rtrim(get_bloginfo('stylesheet_directory'), '/') . '/' . trim($url, '/');
    }
}

if (! function_exists('theme_path')) {
    /**
     * Basic helper for getting the absolute theme path
     *
     * @param string $path optional
     *
     * @return string
     */
    function theme_path($path = '')
    {
        if ( ! function_exists('get_stylesheet_directory')) {
            return $path;
        }

        return rtrim(get_stylesheet_directory(), '/') . '/' . trim($path, '/');
    }
}

if (! function_exists('uploads_path')) {
    /**
     * Basig helper for getting absoulte uploads path
     *
     * @param string $path
     *
     * @return string
     */
    function uploads_path($path = '')
    {
        if ( ! function_exists('wp_upload_dir')) {
            return null;
        }

        $directory = wp_upload_dir();

        return rtrim($directory['basedir'], '/') . '/' . trim($path, '/');
    }
}

if (! function_exists('uploads_url')) {
    /**
     * @param string $path
     *
     * @return string
     */
    function uploads_url($path = '')
    {
        $directory = wp_upload_dir();

        return rtrim($directory['baseurl'], '/') . '/' . trim($path, '/');
    }
}

if (! function_exists('mix')) {
    /**
     * @param $originalFilename
     *
     * @return string
     */
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
    /**
     * @param $file
     *
     * @return string
     */
    function assets($file)
    {
        $file = ltrim($file, '/');

        return theme_url(str_replace('//', '/', config('app.assets-path') . "/{$file}"));
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

if (! function_exists('trans')) {
    /**
     * Translations helper
     *
     * @param $string
     *
     * @return string
     */
    function trans($string)
    {
        return __($string, config('app.theme-slug'));
    }
}


if (! function_exists('menu')) {
    /**
     * Menu helper
     *
     * @param $name
     * @param array $args
     *
     * @return string
     */
    function menu($name, $args = [])
    {
        return wp_nav_menu(array_merge([
            'theme_location' => $name,
            'items_wrap' => '%3$s',
            'container' => null,
            'echo' => false
        ], $args));
    }
}

if (! function_exists('dash_to_camel')) {
    /**
     * Dash to camelcase helper
     *
     * @param $string
     *
     * @return string
     */
    function dash_to_camel($string) {
        return lcfirst(implode('', array_map(function ($item) {
            return ucfirst(strtolower($item));
        }, explode('-', $string))));
    }
}

if (! function_exists('str_excerpt')) {
    /**
     * String to excerpt helper
     *
     * @param $string
     * @param $length
     *
     * @return string
     */
    function str_excerpt($string, $length) {
        if (mb_strlen($string) <= $length) {
            return $string;
        }

        return mb_substr($string, 0, $length) . '...';
    }
}

if (! function_exists('tel')) {
    /**
     * Tel helper
     *
     * @param $string
     *
     * @return string
     */
    function tel($string) {
        $string = str_replace('(0)', '', $string);

        $string = preg_replace('/[^+0-9]+/', '', $string);

        if (substr($string, 0, 2) == '00') {
            $string = '+' . substr($string, 2);
        }

        if (substr($string, 0, 1) != '+') {
            if (substr($string, 0, 1) == '0') {
                $string = substr($string, 1);
            }

            $string = "+46{$string}";
        }

        return $string;
    }
}
