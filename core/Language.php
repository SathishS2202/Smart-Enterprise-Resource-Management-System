<?php

namespace Core;

class Language
{
    private static $translations = [];

    public static function load($locale)
    {
        $basePath = dirname(__DIR__);
        $file = $basePath . "/app/Lang/$locale.php";

        if (!file_exists($file)) {
            $file = $basePath . "/app/Lang/en.php";
        }

        self::$translations = require $file;
    }

    public static function get($key)
    {
        return self::$translations[$key] ?? $key;
    }
}
