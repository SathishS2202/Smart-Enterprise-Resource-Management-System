<?php
namespace App\Models;

use Core\Database;

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance(); // Singleton DB
    }

    // Count all users
    public function countAll() {
        $stmt = $this->db->conn->prepare("SELECT COUNT(*) AS total FROM users");
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    // Count users by role name (Admin, Agent, Client)
    public function countByRole($roleName) {
        $stmt = $this->db->conn->prepare("
            SELECT COUNT(*) AS total 
            FROM users 
            JOIN roles ON users.role_id = roles.id 
            WHERE roles.role_name = ?
        ");
        $stmt->bind_param("s", $roleName);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }

    // Get a single user by ID
    public function getById($userId) {
        $stmt = $this->db->conn->prepare("SELECT * FROM users WHERE id=?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    

    // Fetch user by username (for login)
public function findByUsername($username) {
    $stmt = $this->db->conn->prepare("
        SELECT users.*, roles.role_name 
        FROM users 
        JOIN roles ON users.role_id = roles.id 
        WHERE users.username = ? 
        LIMIT 1
    ");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc(); // Returns array or null if not found
}
public function countByUser($userId) {
        $stmt = $this->db->conn->prepare("SELECT COUNT(*) AS total FROM leave_requests WHERE user_id=?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['total'];
    }
// Add this inside your User class
public function create($data) {
    // Check if username or email already exists
    $stmt = $this->db->conn->prepare("SELECT id FROM users WHERE username=? OR email=? LIMIT 1");
    $stmt->bind_param("ss", $data['username'], $data['email']);
    $stmt->execute();
    $existing = $stmt->get_result()->fetch_assoc();
    if ($existing) {
        return false; // Username or email already taken
    }

    // Insert new user
    $stmt = $this->db->conn->prepare("
        INSERT INTO users (name, email, username, password, role_id) 
        VALUES (?, ?, ?, ?, ?)
    ");

    // Default role_id = 3 (Client) if not provided
    $role_id = $data['role_id'] ?? 3;

    $stmt->bind_param(
        "ssssi", 
        $data['name'], 
        $data['email'], 
        $data['username'], 
        $data['password'], // hashed password
        $role_id
    );

    return $stmt->execute();
}
// Find user by email
public function findByEmail($email) {
    $stmt = $this->db->conn->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Create password reset token
public function createPasswordResetToken($userId, $token, $expires) {
    $stmt = $this->db->conn->prepare("
        INSERT INTO password_resets (user_id, token, expires_at)
        VALUES (?, ?, ?)
    ");
    $stmt->bind_param("iss", $userId, $token, $expires);
    $stmt->execute();
}
// Get token
public function getPasswordResetByToken($token) {
    $stmt = $this->db->conn->prepare("SELECT * FROM password_resets WHERE token=? LIMIT 1");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Update password
public function updatePassword($userId, $password) {
    $stmt = $this->db->conn->prepare("UPDATE users SET password=? WHERE id=?");
    $stmt->bind_param("si", $password, $userId);
    $stmt->execute();
}

// Delete token
public function deletePasswordResetToken($token) {
    $stmt = $this->db->conn->prepare("DELETE FROM password_resets WHERE token=?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
}
public function toggleStatus($id, $status) {
        $stmt = $this->db->conn->prepare("UPDATE users SET status=? WHERE id=?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }

    // 🔹 Get all roles
  public function getAll()
{
    $sql = "
        SELECT users.*, roles.role_name
        FROM users
        JOIN roles ON users.role_id = roles.id
        ORDER BY users.id DESC
    ";

    $stmt = $this->db->conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
public function getRoles()
{
    $sql = "SELECT id, role_name FROM roles";
    $result = mysqli_query($this->db->conn, $sql);

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

public function getAllWithRoles()
{
    $sql = "
        SELECT users.id, users.name, users.username, users.email,
                users.status, roles.role_name
        FROM users
        JOIN roles ON users.role_id = roles.id
    ";

    $stmt = $this->db->conn->prepare($sql);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

public function exists($id)
{
    $stmt = $this->db->conn->prepare(
        "SELECT id FROM users WHERE id=? LIMIT 1"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}

public function delete($id)
{
    $stmt = $this->db->conn->prepare(
        "DELETE FROM users WHERE id=?"
    );
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

public function updateStatus($id, $status)
{
    $db = \Core\Database::getInstance()->conn;

    $stmt = $db->prepare("UPDATE users SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
}

public function update($id, $data)
{
   $stmt = $this->db->conn->prepare(
    "UPDATE users 
     SET name=?, username=?, email=?, role_id=?, status=?
     WHERE id=?"
);

$stmt->bind_param(
    "sssisi",   // 👈 status = s (string), role_id & id = i
    $data['name'],
    $data['username'],
    $data['email'],
    $data['role_id'],
    $data['status'],
    $id
);

$stmt->execute();

}
public function countByRoles(): array
{
    $sql = "
        SELECT r.role_name AS role, COUNT(u.id) AS total
        FROM users u
        JOIN roles r ON u.role_id = r.id
        GROUP BY r.role_name
    ";

    $stmt = $this->db->conn->prepare($sql);
    $stmt->execute();

    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

public function countByStatus()
{
    $sql = "
        SELECT status, COUNT(*) AS total
        FROM projects
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

public function countPerAgent()
{
    $sql = "
        SELECT u.name, COUNT(p.id) AS total
        FROM projects p
        JOIN users u ON p.agent_id = u.id
        GROUP BY u.id
    ";

    $result = $this->db->query($sql);

    $labels = [];
    $data   = [];

    while ($row = $result->fetch_assoc()) {
        $labels[] = $row['name'];
        $data[]   = (int)$row['total'];
    }

    return [
        'labels' => $labels,
        'data'   => $data
    ];
}



// User.php
// Fetch users by role name (Agent, Client)
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

public function weeklyGrowth(): array
{
    $labels = [];
    $data   = [];

    for ($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));

        $sql = "
            SELECT COUNT(*) AS total
            FROM users
            WHERE DATE(created_at) = ?
        ";

        $stmt = $this->db->conn->prepare($sql);
        $stmt->bind_param("s", $date);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();

        $labels[] = date('d M', strtotime($date));
        $data[]   = (int) $result['total'];
    }

    return [
        'labels' => $labels,
        'data'   => $data
    ];
}
public function findById(int $id): array|null
{
    $sql = "
        SELECT 
            u.id,
            u.name,
            u.email,
            u.username,
            r.role_name
        FROM users u
        JOIN roles r ON u.role_id = r.id
        WHERE u.id = ?
        LIMIT 1
    ";

    $stmt = $this->db->conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}



    // 🔹 Create user
   
    // Add more CRUD methods as needed (create, update, delete)
}
