<?php
namespace App\Models;

use Core\Database;

class Project {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance(); // ✅ Use singleton
    }

    public function countAll() {
        $stmt = $this->db->conn->prepare("SELECT COUNT(*) AS total FROM projects");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function countByClient($clientId) {
        $stmt = $this->db->conn->prepare("SELECT COUNT(*) AS total FROM projects WHERE client_id=?");
        $stmt->bind_param("i", $clientId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }
}
