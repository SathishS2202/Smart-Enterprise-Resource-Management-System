<?php
namespace Core;

class Database {
    private static $instance = null;
    public $conn;

    private function __construct() {
        $this->conn = new \mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->conn->connect_error) {
            die("Database Connection Failed: " . $this->conn->connect_error);
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // 🔹 For INSERT / UPDATE / DELETE
    public function query($sql) {
        return $this->conn->query($sql);
    }

    // 🔹 For SELECT (multiple rows)
    public function fetchAll($sql) {
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // 🔹 For SELECT (single row)
    public function fetch($sql) {
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }
}
