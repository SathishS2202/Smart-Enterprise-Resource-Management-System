<?php
namespace App\Controllers;

class LanguageController {
    public function switch($lang) {
        $_SESSION['lang'] = $lang;
        $redirect = $_SERVER['HTTP_REFERER'] ?? '/';
        header("Location: $redirect");
        exit;
    }
}
