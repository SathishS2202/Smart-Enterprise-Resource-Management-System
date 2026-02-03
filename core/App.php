<?php
namespace Core;
require_once BASE_PATH . "/app/Controllers/AuthController.php";



class App {

    public function run() {
        $url = $_GET['url'] ?? 'home/index';

        $url = explode('/', trim($url, '/'));

        $controller = "App\\Controllers\\" . ucfirst($url[0]) . "Controller";
        $method = $url[1] ?? 'index';

        if (!class_exists($controller)) {
            die("Controller not found");
        }

        $obj = new $controller;

        if (!method_exists($obj, $method)) {
            die("Method not found");
        }

        $obj->$method();
    }
}
