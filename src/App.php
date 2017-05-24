<?php

namespace Incognito;

use Iamfredric\Instantiator\Instantiator;

class App
{
    protected static $items = [];

    public static function provide($providers)
    {
        foreach ($providers as $key => $provider) {
            static::$items[$key] = (new Instantiator($provider))->callMethod('register');
        }
    }

    public static function bind($key, $value)
    {
        static::$items[$key] = $value;
    }

    public static function get($key)
    {
        return static::$items[$key];
    }

    public static function __callStatic($method, $args)
    {
        return static::get($method);
    }
}