<?php
namespace App\Models;

use Core\Database;

class RequestModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function countAll() {
        $stmt = $this->db->conn->prepare("SELECT COUNT(*) AS total FROM client_requests");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function countPendingByClient($clientId) {
        $stmt = $this->db->conn->prepare("SELECT COUNT(*) AS total FROM client_requests WHERE client_id=? AND status='Pending'");
        $stmt->bind_param("i", $clientId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    public function countApprovedByClient($clientId) {
        $stmt = $this->db->conn->prepare("SELECT COUNT(*) AS total FROM client_requests WHERE client_id=? AND status='Approved'");
        $stmt->bind_param("i", $clientId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }
}
