<?php
namespace Core;
require_once BASE_PATH . "/app/Controllers/AuthController.php";


class App {

   public function run()
{
    $url = $_GET['url'] ?? 'home/index';
    $url = explode('/', trim($url, '/'));

    $controllerName = ucfirst($url[0]) . 'Controller';
    $controller = "App\\Controllers\\" . $controllerName;

    $method = $url[1] ?? 'index';
    $param = $url[2] ?? null;

    if (!class_exists($controller)) {
        die("Controller not found");
    }

    $obj = new $controller;

    // 🔹 If 3rd segment exists → combine method
    if ($param) {
        $method = $method . ucfirst($param);
    }

    if (!method_exists($obj, $method)) {
        die("Method not found: " . $method);
    }

    $obj->$method();
}

}
