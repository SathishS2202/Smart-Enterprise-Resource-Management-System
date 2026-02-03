<?php
namespace App\Models;

use Core\Database;

class Task {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance(); // Singleton DB
    }

    public function countAll() {
        $stmt = $this->db->conn->prepare("SELECT COUNT(*) AS total FROM tasks");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function countByStatus($status) {
        $stmt = $this->db->conn->prepare("SELECT COUNT(*) AS total FROM tasks WHERE status=?");
        $stmt->bind_param("s", $status);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function countByUser($userId) {
        $stmt = $this->db->conn->prepare("SELECT COUNT(*) AS total FROM tasks WHERE assigned_to=?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function countByUserAndStatus($userId, $status) {
        $stmt = $this->db->conn->prepare("SELECT COUNT(*) AS total FROM tasks WHERE assigned_to=? AND status=?");
        $stmt->bind_param("is", $userId, $status);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }
}
