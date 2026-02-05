<?php
namespace Core;

class Auth {

    public static function check(): bool {
        return isset($_SESSION['user_id']);
    }

    public static function role(): ?string {
        return $_SESSION['role'] ?? null;
    }

    public static function redirectIfLoggedIn(): void {
        if (self::check()) {
            switch (self::role()) {
                case 'Admin':
                    header("Location: " . BASE_URL . "/admin/dashboard");
                    break;
                case 'Agent':
                    header("Location: " . BASE_URL . "/agent/dashboard");
                    break;
                case 'Client':
                    header("Location: " . BASE_URL . "/client/dashboard");
                    break;
            }
            exit;
        }
    }
}
