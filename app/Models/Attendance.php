<?php
namespace App\Models;

use Core\Database;

class Attendance {
    private $db;

    public function __construct() {
        // Get the DB instance (singleton)
        $this->db = Database::getInstance();
    }

    /**
     * Get all attendance records with user names
     */
   public function getAll(): array {
    $sql = "
        SELECT a.id, a.date, a.status, u.name AS user_name
        FROM attendance a
        LEFT JOIN users u ON a.user_id = u.id
        ORDER BY a.date DESC
    ";
    $stmt = $this->db->conn->prepare($sql);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

    /**
     * Get a single attendance record by ID
     */
    public function getById(int $id): ?array {
        $stmt = $this->db->conn->prepare("
            SELECT * FROM attendance WHERE id = ?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ?: null;
    }

    /**
     * Add new attendance
     * $data = ['user_id'=>1, 'date'=>'2026-02-05', 'status'=>'Present']
     */
    public function create(array $data): bool {
    $stmt = $this->db->conn->prepare("
        INSERT INTO attendance (user_id, date, status)
        VALUES (?, ?, ?)
    ");

    $stmt->bind_param(
        "iss",
        $data['user_id'],
        $data['date'],
        $data['status']
    );

    return $stmt->execute();
}


    /**
     * Update attendance by ID'
     */
    public function update(int $id, array $data): bool {
        $stmt = $this->db->conn->prepare("
            UPDATE attendance 
            SET user_id = ?, date = ?, status = ?
            WHERE id = ?
        ");
        $stmt->bind_param(
            "issi",
            $data['user_id'],
            $data['date'],
            $data['status'],
            $id
        );
        return $stmt->execute();
    }

    /**
     * Delete attendance record by ID
     */
    public function delete(int $id): bool {
        $stmt = $this->db->conn->prepare("
            DELETE FROM attendance WHERE id = ?
        ");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    /**
     * Get all users (to assign attendance)
     */
    public function getUsers(): array {
        $sql = "SELECT id, name FROM users ORDER BY name ASC";
        $result = $this->db->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
