<?php
namespace Core;

abstract class Controller {

    protected function render(string $view, array $data = []) {

        extract($data);

        $viewFile = BASE_PATH . "/app/Views/" . $view . ".php";

        if (!file_exists($viewFile)) {
            die("View not found: " . $view);
        }

        require BASE_PATH . "/app/Views/layouts/main.php";
    }

    protected function redirect(string $path) {
        header("Location: " . BASE_URL . "/" . $path);
        exit;
    }
}
