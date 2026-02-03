<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';


define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', '/serms/public');

// LOAD CONFIG
require_once BASE_PATH . '/config/database.php';

// AUTOLOADER
spl_autoload_register(function ($class) {
    $path = BASE_PATH . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

require_once BASE_PATH . '/core/App.php';

$app = new Core\App();
$app->run();
