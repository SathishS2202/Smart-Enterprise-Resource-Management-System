<?php
namespace Core;

class Language
{
    private static $data = [];

    // Load the language file
    public static function load($lang = 'en')
    {
        $file = __DIR__ . "/../app/Languages/$lang.php";
        if (file_exists($file)) {
            self::$data = include $file;
        } else {
            self::$data = include __DIR__ . "/../app/Languages/en.php";
        }
    }

    // Get a translation
    public static function get($key)
    {
        return self::$data[$key] ?? $key;
    }
}
