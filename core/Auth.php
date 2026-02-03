<?php
namespace Core;

class Auth {

    public static function check(): bool {
        return Session::get('user') !== null;
    }

    public static function user() {
        return Session::get('user');
    }

    public static function role(string $role): void {
        if (!self::check() || self::user()['role'] !== $role) {
            header("Location: " . BASE_URL . "/auth/login");
            exit;
        }
    }
}
