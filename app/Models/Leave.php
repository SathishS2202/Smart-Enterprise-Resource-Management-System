<?php
namespace App\Models;

use Core\Database;

class Leave
{
    private $db;
    protected $table = 'leave_requests'; // Your table name

    public function __construct()
    {
        // Get the database instance
        $this->db = Database::getInstance();
    }

    // Create a leave request
    public function create(array $data)
    {
        $userId     = (int) $data['user_id'];
        $startDate  = $this->db->conn->real_escape_string($data['start_date']);
        $endDate    = $this->db->conn->real_escape_string($data['end_date']);
        $reason     = $this->db->conn->real_escape_string($data['reason']);
        $status     = 'Pending';

        $sql = "INSERT INTO {$this->table} (user_id, start_date, end_date, reason, status)
                VALUES ($userId, '$startDate', '$endDate', '$reason', '$status')";

        return $this->db->query($sql);
    }

    // Get leaves by user
    public function getByUser($userId)
    {
        $userId = (int) $userId;
        $sql = "SELECT * FROM {$this->table} WHERE user_id = $userId ORDER BY id DESC";
        return $this->db->fetchAll($sql);
    }

    // ✅ Get leaves by status (for admin leave approvals)
    public function getByStatus($status)
    {
        $status = $this->db->conn->real_escape_string($status);

        $sql = "SELECT l.*, u.name AS user_name
                FROM {$this->table} l
                JOIN users u ON l.user_id = u.id
                WHERE l.status = '$status'
                ORDER BY l.created_at DESC";

        return $this->db->fetchAll($sql);
    }

     public function countByStatus($status)
    {
        $status = $this->db->conn->real_escape_string($status);
        $sql = "SELECT COUNT(*) AS total FROM {$this->table} WHERE status = '$status'";
        $row = $this->db->fetch($sql);
        return $row['total'] ?? 0;
    }

    // Update leave status (approve/reject)
    public function updateStatus($id, $status)
    {
        $id = (int) $id;
        $status = $this->db->conn->real_escape_string($status);

        $sql = "UPDATE {$this->table} SET status = '$status' WHERE id = $id";
        return $this->db->query($sql);
    }

    public function countPending()
{
    $result = $this->db->query("SELECT COUNT(*) as total FROM leave_requests WHERE status = 'Pending'");
    return $result[0]['total'] ?? 0;
}

}
