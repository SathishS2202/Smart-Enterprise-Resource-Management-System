<?php

spl_autoload_register(function ($class) {

    // Convert namespace to full file path
    $class = ltrim($class, '\\');
    $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    $file = BASE_PATH . DIRECTORY_SEPARATOR . $classPath . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});
