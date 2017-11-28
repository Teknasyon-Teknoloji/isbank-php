<?php

namespace Teknasyon\Isbank;


/**
 * Class Config
 * @package Teknasyon\Isbank
 * @author Ilyas Serter <ilyasserter@teknasyon.com>
 */
class IsbankConfig
{
    private static $data = [];

    public static function get(string $key, $default = null)
    {
        return array_key_exists($key, static::$data) ? static::$data[$key] : $default;
    }

    public static function set(string $key, $value)
    {
        static::$data[$key] = $value;
    }

    public static function delete(string $key)
    {
        if(array_key_exists($key, static::$data)) {
            unset(static::$data[$key]);
        }
    }
}