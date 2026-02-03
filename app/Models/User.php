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


    // Add more CRUD methods as needed (create, update, delete)
}
