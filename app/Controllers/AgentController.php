<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Task;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Project;

class AgentController extends Controller
{
    protected Task $taskModel;
    protected Attendance $attendanceModel;
    protected User $userModel;
    protected Project $projectModel;

    public function __construct()
    {
        // Start session only if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Only allow Agents
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Agent') {
            header('Location: ' . BASE_URL . '/auth/login');
            exit;
        }

        $this->taskModel = new Task();
        $this->attendanceModel = new Attendance();
        $this->userModel = new User();
        $this->projectModel = new Project();
    }

    /* =========================
       DASHBOARD
    ==========================*/
   public function index()
{
    $agentId = $_SESSION['user_id'];

    $totalTasks   = $this->taskModel->countByAgent($agentId);
    $pendingTasks = $this->taskModel->countByAgentAndStatus($agentId, 'Pending');
    $completed    = $this->taskModel->countByAgentAndStatus($agentId, 'Completed');

    $todayAttendance = $this->attendanceModel->todayStatus($agentId);

    $this->render('agent/dashboard', compact(
        'totalTasks',
        'pendingTasks',
        'completed',
        'todayAttendance'
    ));
}


    // Optional: allow /agent/dashboard URL
    public function dashboard()
    {
        $this->index();
    }

    /* =========================
       TASKS
    ==========================*/
    public function tasks()
    {
        $agentId = $_SESSION['user_id'];
        $tasks = $this->taskModel->getByAgent($agentId);

        $this->render('agent/tasks/index', compact('tasks'));
    }

    public function updateTaskStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $taskId = $_POST['task_id'] ?? null;
            $status = $_POST['status'] ?? null;

            // Validate
            if (!$taskId || !in_array($status, ['Pending', 'Completed'])) {
                echo json_encode(['success' => false, 'message' => 'Invalid input']);
                exit;
            }

            if ($this->taskModel->updateStatus($taskId, $status)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Update failed']);
            }
            exit;
        }
    }

    /* =========================
       ATTENDANCE
    ==========================*/
    public function attendance()
    {
        $agentId = $_SESSION['user_id'];
        $attendance = $this->attendanceModel->getByUser($agentId);
        $today = $this->attendanceModel->todayStatus($agentId);

        $this->render('agent/attendance/index', compact('attendance', 'today'));
    }

    public function markAttendance()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $agentId = $_SESSION['user_id'];
            $status  = $_POST['status'] ?? null;
            $remarks = $_POST['remarks'] ?? null;

            // Validate
            if (!$status || !in_array($status, ['Present', 'Absent', 'Leave'])) {
                $_SESSION['error'] = "Invalid attendance status.";
                header('Location: ' . BASE_URL . '/agent/attendance');
                exit;
            }

            $this->attendanceModel->mark($agentId, $status, $remarks);
            $_SESSION['success'] = "Attendance marked successfully.";
            header('Location: ' . BASE_URL . '/agent/attendance');
            exit;
        }
    }

    /* =========================
       PROFILE
    ==========================*/
    public function profile()
    {
        $agentId = $_SESSION['user_id'];
        $user = $this->userModel->findById($agentId);

        $this->render('agent/profile/index', compact('user'));
    }

    /* =========================
       LOGOUT
    ==========================*/
    public function logout()
    {
        session_destroy();
        header('Location: ' . BASE_URL . '/auth/login');
        exit;
    }

    public function projects()
{
    $agentId = $_SESSION['user_id'];

    // Fetch projects assigned to this agent
    $projects = $this->projectModel->getByAgent($agentId);

    // Count tasks for each project
    foreach ($projects as &$project) {
        $project['total_tasks'] = $this->taskModel->countByProject($project['id']);
        $project['completed_tasks'] = $this->taskModel->countByProjectAndStatus($project['id'], 'Completed');
    }

    $this->render('agent/projects/index', compact('projects'));
}

}
