<?php
namespace App\Models;

use Core\Database;

class Document {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll(): array {
        $sql = "
            SELECT d.id, d.title, d.file_path, d.created_at,
                   u.name AS uploaded_by
            FROM documents d
            JOIN users u ON d.uploaded_by = u.id
            ORDER BY d.created_at DESC
        ";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getById(int $id) {
        $stmt = $this->db->conn->prepare("SELECT * FROM documents WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create(array $data): bool {
        $stmt = $this->db->conn->prepare("
            INSERT INTO documents (title, file_path, uploaded_by)
            VALUES (?, ?, ?)
        ");
        $stmt->bind_param("ssi",
            $data['title'],
            $data['file_path'],
            $data['uploaded_by']
        );
        return $stmt->execute();
    }

    public function delete(int $id): bool {
        $stmt = $this->db->conn->prepare("DELETE FROM documents WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function countByAgent(int $agentId): int
{
    $stmt = $this->db->conn->prepare(
        "SELECT COUNT(*) AS total FROM documents WHERE uploaded_by = ?"
    );
    $stmt->bind_param("i", $agentId);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc()['total'] ?? 0;
}

}
