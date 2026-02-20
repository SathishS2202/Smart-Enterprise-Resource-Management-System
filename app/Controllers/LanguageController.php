<?php

namespace App\Controllers;

class LanguageController
{
    public function switch()
    {
        $lang = $_GET['lang'] ?? 'en';

        $_SESSION['locale'] = $lang;

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
