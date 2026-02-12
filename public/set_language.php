<?php
require_once __DIR__ . '/../app/init.php'; // Load Core + Autoloader
use App\Controllers\LanguageController;

$lang = $_GET['lang'] ?? 'en';
$controller = new LanguageController();
$controller->switch($lang);
