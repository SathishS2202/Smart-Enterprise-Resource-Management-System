<?php
namespace Core;

require_once BASE_PATH . "/app/Controllers/AuthController.php";

class App {

   public function run()
   {
       // ✅ 1️⃣ START LANGUAGE
       $locale = $_SESSION['locale'] ?? 'en';

       // Load language file
       \Core\Language::load($locale);

       // ✅ 2️⃣ DEFINE GLOBAL CONSTANTS
       $rtlLanguages = ['ar', 'he', 'fa'];

       define('APP_LANG', $locale);
       define('APP_RTL', in_array($locale, $rtlLanguages));

       // ✅ 3️⃣ ROUTING
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

       if ($param) {
           $method = $method . ucfirst($param);
       }

       if (!method_exists($obj, $method)) {
           die("Method not found: " . $method);
       }

       $obj->$method();
   }
}
