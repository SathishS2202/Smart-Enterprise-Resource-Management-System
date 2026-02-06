<?php
namespace App\Models;

use Core\Database;

class Project {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance(); // Singleton DB
    }

    // Fetch all projects with client & agent names
public function getAll(): array {
    $sql = "
        SELECT 
            p.id,
            p.name AS project_name,
            p.status,
            p.start_date,
            p.end_date,
            u.name AS client_name,
            a.name AS agent_name
        FROM projects p
        LEFT JOIN users u ON p.client_id = u.id
        LEFT JOIN users a ON p.agent_id = a.id
        ORDER BY p.created_at DESC
    ";

    $stmt = $this->db->conn->prepare($sql);
    $stmt->execute();

    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
public function getAgents(): array {
    $sql = "SELECT id, name FROM users WHERE role_id = (SELECT id FROM roles WHERE role_name='Agent')";
    $result = $this->db->conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}




    // Assign agent and approve project
public function assignAgent(int $projectId, int $agentId): bool {
    // Use a valid ENUM value, e.g., 'In Progress'
    $stmt = $this->db->conn->prepare("UPDATE projects SET agent_id=?, status='In Progress' WHERE id=?");
    $stmt->bind_param("ii", $agentId, $projectId);
    return $stmt->execute();
}


    // Verify project
    public function verifyProject(int $projectId): bool {
        $stmt = $this->db->conn->prepare("UPDATE projects SET admin_verified=1 WHERE id=?");
        $stmt->bind_param("i", $projectId);
        return $stmt->execute();
    }
    // Add new project
public function create(array $data): bool {
    $stmt = $this->db->conn->prepare("
        INSERT INTO projects (name, description, client_id, start_date, end_date, status)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssisss",
        $data['name'],
        $data['description'],
        $data['client_id'],
        $data['start_date'],
        $data['end_date'],
        $data['status']
    );

    return $stmt->execute();
}

// Fetch users by role name (Client or Agent)
public function getByRoleName(string $roleName): array {
    $sql = "
        SELECT users.id, users.name
        FROM users
        JOIN roles ON users.role_id = roles.id
        WHERE roles.role_name = ?
        ORDER BY users.name ASC
    ";
    $stmt = $this->db->conn->prepare($sql);
    $stmt->bind_param("s", $roleName);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}


public function getAllWithClientsAndAgents() {
    $sql = "
        SELECT p.id, p.name, p.start_date, p.end_date, p.status,
               c.name AS client_name,
               a.name AS agent_name
        FROM projects p
        LEFT JOIN users c ON p.client_id = c.id
        LEFT JOIN users a ON p.agent_id = a.id
        ORDER BY p.created_at DESC
    ";
    $stmt = $this->db->conn->prepare($sql);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

public function getById(int $id): array {
    $stmt = $this->db->conn->prepare("SELECT * FROM projects WHERE id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
public function countAll(): int
{
    $sql = "SELECT COUNT(*) AS total FROM projects";
    $stmt = $this->db->conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_assoc();
    return (int) $result['total'];
}

public function update(int $id, array $data): bool {
    $stmt = $this->db->conn->prepare("
        UPDATE projects SET 
            name=?,
            client_id=?,
            agent_id=?,
            start_date=?,
            end_date=?,
            status=?
        WHERE id=?
    ");
    $stmt->bind_param(
        "siisssi",
        $data['name'],
        $data['client_id'],
        $data['agent_id'],
        $data['start_date'],
        $data['end_date'],
        $data['status'],
        $id
    );
    return $stmt->execute();
}

public function delete(int $id): bool {
    $stmt = $this->db->conn->prepare("DELETE FROM projects WHERE id=?");
    $stmt->bind_param("i",$id);
    return $stmt->execute();
}
public function countByStatus(): array
{
    $sql = "
        SELECT status, COUNT(*) AS total
        FROM projects
        GROUP BY status
    ";

    $stmt = $this->db->conn->prepare($sql);
    $stmt->execute();

    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
public function countPerAgent(): array
{
    $sql = "
        SELECT u.name AS agent, COUNT(p.id) AS total
        FROM projects p
        JOIN users u ON p.agent_id = u.id
        GROUP BY p.agent_id
    ";

    $stmt = $this->db->conn->prepare($sql);
    $stmt->execute();

    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

public function countByAgent(int $agentId): int
{
    $stmt = $this->db->conn->prepare(
        "SELECT COUNT(*) AS total FROM projects WHERE agent_id = ?"
    );
    $stmt->bind_param("i", $agentId);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc()['total'] ?? 0;
}
 public function getByAgent(int $agentId): array
    {
        $sql = "SELECT * FROM projects WHERE agent_id = $agentId ORDER BY start_date DESC";
        return $this->db->fetchAll($sql);
    }







}
