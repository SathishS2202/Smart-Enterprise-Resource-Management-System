<?php
namespace Core;

class Database {
    private static $instance = null;
    public $conn; // mysqli connection

    private function __construct() {
        $this->conn = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->conn->connect_error) {
            die("Database Connection Failed: " . $this->conn->connect_error);
        }
    }

    // Return singleton instance
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
}
