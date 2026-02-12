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
   public function getAll(): array
{
    $sql = "
        SELECT 
            a.id,
            a.user_id,
            a.date,
            a.status,
            u.name AS user_name
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

    public function presentVsAbsent()
{
    $present = $this->db->conn
        ->query("SELECT COUNT(*) total FROM attendance WHERE status='Present'")
        ->fetch_assoc()['total'];

    $totalUsers = $this->db->conn
        ->query("SELECT COUNT(*) total FROM users")
        ->fetch_assoc()['total'];

    return [
        'present'=>$present,
        'absent'=>$totalUsers - $present
    ];
}

public function weeklyAttendance()
{
    $labels = [];
    $data = [];

    for($i=6;$i>=0;$i--){
        $day = date('Y-m-d', strtotime("-$i days"));
        $labels[] = date('d M', strtotime($day));

        $stmt = $this->db->conn->prepare(
            "SELECT COUNT(*) total FROM attendance 
             WHERE date=? AND status='Present'"
        );
        $stmt->bind_param("s",$day);
        $stmt->execute();
        $data[] = $stmt->get_result()->fetch_assoc()['total'];
    }

    return compact('labels','data');
}

public function todayStatus(int $agentId): ?string
{
    $stmt = $this->db->conn->prepare(
        "SELECT status FROM attendance 
         WHERE user_id = ? AND date = CURDATE()"
    );
    $stmt->bind_param("i", $agentId);
    $stmt->execute();

    $row = $stmt->get_result()->fetch_assoc();
    return $row['status'] ?? 'Not Marked';
}
public function markCheckOut($agentId)
    {
        $sql = "
            UPDATE attendance
            SET check_out = NOW()
            WHERE agent_id = ? AND date = CURDATE()
        ";
        return $this->db->execute($sql, [$agentId]);
    }

     public function getByAgent($agentId)
    {
        $sql = "
            SELECT *
            FROM attendance
            WHERE user_id = $agentId
            ORDER BY date DESC
        ";

        return $this->db->fetchAll($sql);
    }

    // Get today's attendance (check-in / check-out status)
    public function todayAttendance($agentId)
    {
        $today = date('Y-m-d');

        $sql = "
            SELECT *
            FROM attendance
            WHERE user_id = $agentId
            AND date = '$today'
            LIMIT 1
        ";

        return $this->db->fetch($sql);
    }

    // Check-in
   public function checkIn(int $userId): bool
{
    $today = date('Y-m-d');

    // Check if already marked
    $existing = $this->db->fetch(
        "SELECT id FROM attendance WHERE user_id = $userId AND date = '$today'"
    );

    if ($existing) {
        return false; // already checked in
    }

    return $this->db->query(
        "INSERT INTO attendance (user_id, date, status)
         VALUES ($userId, '$today', 'Present')"
    );
}


    // Check-out
    public function checkOut($agentId)
    {
        $time = date('H:i:s');

        $sql = "
            UPDATE attendance
            SET check_out = '$time'
            WHERE user_id = $agentId
            AND date = CURDATE()
        ";

        return $this->db->query($sql);
    }


 public function countByAgentAndStatus($agentId, $status)
{
    $stmt = $this->db->prepare("
        SELECT COUNT(*) as total 
        FROM attendance 
        WHERE user_id = ? AND status = ?
    ");
    $stmt->bind_param("is", $agentId, $status);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc()['total'];
}

    public function summaryByAgent($agentId)
{
    $agentId = (int)$agentId;
    $sql = "
        SELECT status, COUNT(*) as total
        FROM attendance
        WHERE user_id = $agentId
        GROUP BY status
    ";

    $result = $this->db->conn->query($sql);

    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data; // ALWAYS return array, even if empty
}


     public function getByStatus($userId, $status = 'All') {
    $userId = (int)$userId;
    $sql = "SELECT * FROM attendance WHERE user_id = $userId";

    if ($status !== 'All') {
        $statusEscaped = $this->db->conn->real_escape_string($status);
        $sql .= " AND status = '$statusEscaped'";
    }

    $sql .= " ORDER BY date DESC";

    $result = $this->db->conn->query($sql);

    $records = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $records[] = $row;
        }
    }

    return $records; // ALWAYS return an array
}



    /**
     * Get detailed attendance records for an agent by status
     */
    public function getByAgentAndStatus($userId, $status)
    {
        $userId = (int)$userId;           // safe cast
        $status = addslashes($status);    // escape single quotes

        $sql = "SELECT * FROM attendance 
                WHERE user_id = $userId AND status = '$status' 
                ORDER BY date DESC";

        $result = $this->db->query($sql);

        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }


}
