<?php
class ReportModel {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    /* USERS */
    public function totalUsers(){
        return mysqli_fetch_assoc(
            mysqli_query($this->conn,"SELECT COUNT(*) total FROM users")
        )['total'];
    }

    public function usersByRole(){
        return mysqli_query($this->conn,"
            SELECT r.role_name, COUNT(u.id) total
            FROM users u
            JOIN roles r ON u.role_id = r.id
            GROUP BY r.id
        ");
    }

    public function weeklyUserGrowth(){
        $data = [];
        for($i=6;$i>=0;$i--){
            $day = date('Y-m-d', strtotime("-$i days"));
            $count = mysqli_fetch_assoc(
                mysqli_query($this->conn,"SELECT COUNT(*) total FROM users WHERE DATE(created_at)='$day'")
            )['total'];
            $data[] = ['day'=>$day,'total'=>$count];
        }
        return $data;
    }

    /* PROJECTS */
    public function totalProjects(){
        return mysqli_fetch_assoc(
            mysqli_query($this->conn,"SELECT COUNT(*) total FROM projects")
        )['total'];
    }

    public function projectsByStatus(){
        $statuses = ['Active','Completed','On Hold'];
        $data = [];
        foreach($statuses as $s){
            $data[$s] = mysqli_fetch_assoc(
                mysqli_query($this->conn,"SELECT COUNT(*) total FROM projects WHERE status='$s'")
            )['total'];
        }
        return $data;
    }

    public function projectsPerAgent(){
        return mysqli_query($this->conn,"
            SELECT u.name, COUNT(p.id) total
            FROM projects p
            JOIN users u ON p.agent_id = u.id
            GROUP BY u.id
        ");
    }

    /* TASKS */
    public function totalTasks(){
        return mysqli_fetch_assoc(
            mysqli_query($this->conn,"SELECT COUNT(*) total FROM tasks")
        )['total'];
    }

    public function tasksByStatus(){
        $statuses = ['To Do','In Progress','Done'];
        $data = [];
        foreach($statuses as $s){
            $data[$s] = mysqli_fetch_assoc(
                mysqli_query($this->conn,"SELECT COUNT(*) total FROM tasks WHERE status='$s'")
            )['total'];
        }
        return $data;
    }

    public function tasksByPriority(){
        $priorities = ['Low','Medium','High'];
        $data = [];
        foreach($priorities as $p){
            $data[$p] = mysqli_fetch_assoc(
                mysqli_query($this->conn,"SELECT COUNT(*) total FROM tasks WHERE priority='$p'")
            )['total'];
        }
        return $data;
    }

    /* ATTENDANCE */
    public function attendanceSummary(){
        $present = mysqli_fetch_assoc(
            mysqli_query($this->conn,"SELECT COUNT(*) total FROM attendance WHERE check_in IS NOT NULL")
        )['total'];
        $users = mysqli_fetch_assoc(
            mysqli_query($this->conn,"SELECT COUNT(*) total FROM users")
        )['total'];

        return [
            'present' => $present,
            'absent'  => $users - $present
        ];
    }

    public function weeklyAttendance(){
        $data = [];
        for($i=6;$i>=0;$i--){
            $day = date('Y-m-d', strtotime("-$i days"));
            $count = mysqli_fetch_assoc(
                mysqli_query($this->conn,"SELECT COUNT(*) total FROM attendance WHERE DATE(attendance_date)='$day' AND check_in IS NOT NULL")
            )['total'];
            $data[] = ['day'=>$day,'total'=>$count];
        }
        return $data;
    }
}
