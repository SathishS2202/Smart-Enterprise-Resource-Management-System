<?php
namespace App;

session_start();

class Language {
    private static $translations = [];

    public static function load($lang = null) {
        $lang = $lang ?? $_SESSION['lang'] ?? 'en';
        $file = __DIR__ . "/Languages/$lang.php";

        if (file_exists($file)) {
            self::$translations = include $file;
        } else {
            self::$translations = include __DIR__ . "/Languages/en.php";
        }
    }

    public static function t($key) {
        return self::$translations[$key] ?? $key;
    }
}

// Load current language on every request
Language::load();
