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
public function countAll()
{
    return $this->db->conn
        ->query("SELECT COUNT(*) total FROM tasks")
        ->fetch_assoc()['total'];
}
public function countByStatus()
{
    $sql = "
        SELECT status, COUNT(*) AS total
        FROM tasks
        GROUP BY status
    ";

    $result = $this->db->query($sql);

    $labels = [];
    $data   = [];

    while ($row = $result->fetch_assoc()) {
        $labels[] = $row['status'];
        $data[]   = (int)$row['total'];
    }

    return [
        'labels' => $labels,
        'data'   => $data
    ];
}

public function countByPriority(): array
{
    $sql = "
        SELECT priority, COUNT(*) AS total
        FROM tasks
        GROUP BY priority
    ";

    $stmt = $this->db->conn->prepare($sql);
    $stmt->execute();

    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
public function countByAgent(int $agentId): int
{
    $stmt = $this->db->conn->prepare(
        "SELECT COUNT(*) AS total FROM tasks WHERE assigned_to = ?"
    );
    $stmt->bind_param("i", $agentId);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc()['total'] ?? 0;
}

public function countPendingByAgent(int $agentId): int
{
    $stmt = $this->db->conn->prepare(
        "SELECT COUNT(*) AS total 
         FROM tasks 
         WHERE assigned_to = ? AND status != 'Completed'"
    );
    $stmt->bind_param("i", $agentId);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc()['total'] ?? 0;
}



    // Count tasks for an agent by status
   
    // Count tasks assigned to an agent by status
    public function countByAgentAndStatus($agentId, $status)
    {
        $agentId = (int)$agentId;
        $status = addslashes($status);
        $sql = "SELECT COUNT(*) as total FROM tasks WHERE assigned_to = $agentId AND status = '$status'";
        $row = $this->db->fetch($sql);
        return $row ? (int)$row['total'] : 0;
    }

    // Get all tasks assigned to an agent
    public function getByAgent($agentId)
    {
        $agentId = (int)$agentId;
        $sql = "SELECT * FROM tasks WHERE assigned_to = $agentId ORDER BY created_at DESC";
        return $this->db->fetchAll($sql);
    }

    // Update task status
    public function updateStatus($taskId, $status)
    {
        $taskId = (int)$taskId;
        $status = addslashes($status);
        $sql = "UPDATE tasks SET status = '$status', updated_at = NOW() WHERE id = $taskId";
        return $this->db->query($sql);
    }

   



    public function countByProject(int $projectId): int
    {
        $row = $this->db->fetch("SELECT COUNT(*) AS total FROM tasks WHERE project_id = $projectId");
        return $row['total'] ?? 0;
    }

    public function countByProjectAndStatus(int $projectId, string $status): int
    {
        $row = $this->db->fetch("SELECT COUNT(*) AS total FROM tasks WHERE project_id = $projectId AND status='$status'");
        return $row['total'] ?? 0;
    }
}


