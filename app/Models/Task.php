<?php
namespace App\Models;

use Core\Database;

class Task {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Get all tasks with project & agent names
    public function getAll(): array {
        $sql = "
            SELECT t.id, t.title, t.description, t.status, t.start_date, t.due_date,
                   p.name AS project_name,
                   u.name AS agent_name
            FROM tasks t
            LEFT JOIN projects p ON t.project_id = p.id
            LEFT JOIN users u ON t.assigned_to = u.id
            ORDER BY t.created_at DESC
        ";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Get all agents
    public function getAgents(): array {
        $sql = "SELECT id, name FROM users WHERE role_id = (SELECT id FROM roles WHERE role_name='Agent')";
        $result = $this->db->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Create a new task
    public function create(array $data): bool {
        $stmt = $this->db->conn->prepare("
            INSERT INTO tasks (project_id, title, description, assigned_to, start_date, due_date, status)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "ississs",
            $data['project_id'],
            $data['title'],
            $data['description'],
            $data['assigned_to'],
            $data['start_date'],
            $data['due_date'],
            $data['status']
        );
        return $stmt->execute();
    }

    // Get single task by ID
    public function getById(int $id): array {
        $stmt = $this->db->conn->prepare("SELECT * FROM tasks WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update task
    public function update(int $id, array $data): bool {
        $stmt = $this->db->conn->prepare("
            UPDATE tasks
            SET project_id=?, title=?, description=?, assigned_to=?, start_date=?, due_date=?, status=?
            WHERE id=?
        ");
        $stmt->bind_param(
            "ississsi",
            $data['project_id'],
            $data['title'],
            $data['description'],
            $data['assigned_to'],
            $data['start_date'],
            $data['due_date'],
            $data['status'],
            $id
        );
        return $stmt->execute();
    }

    // Delete task
  public function delete(int $id): bool {
    $stmt = $this->db->conn->prepare("DELETE FROM tasks WHERE id=?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
    // Get all projects for dropdown
    public function getProjects(): array {
        $sql = "SELECT id, name FROM projects ORDER BY name ASC";
        $result = $this->db->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function assignAgent(int $taskId, int $agentId): bool {
    $stmt = $this->db->conn->prepare("UPDATE tasks SET assigned_to=? WHERE id=?");
    $stmt->bind_param("ii", $agentId, $taskId);
    return $stmt->execute();
}


}
