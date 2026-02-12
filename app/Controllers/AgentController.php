<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Task;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Project;
use App\Models\Leave; 

class AgentController extends Controller
{
    protected $taskModel;
    protected $attendanceModel;
    protected $userModel;
    protected $projectModel;
    protected $leaveModel;
    protected $userId;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

    $role = $_SESSION['impersonate_role'] ?? $_SESSION['role'];
if ($role !== 'Agent' && $_SESSION['role'] !== 'Admin') {
    header('Location: ' . BASE_URL . '/auth/login');
    exit;
}
$this->userId= $_SESSION['user_id'];



        $this->taskModel       = new Task();
        $this->attendanceModel = new Attendance();
        $this->userModel       = new User();
        $this->projectModel    = new Project();
        $this->leaveModel      = new Leave();
    }

    /* ======================
       DASHBOARD
    ====================== */
    public function index()
    {
        $agentId = $_SESSION['user_id'];

        $data = [
            'totalTasks'     => $this->taskModel->countByAgent($agentId),
            'pendingTasks'   => $this->taskModel->countByAgentAndStatus($agentId, 'Pending'),
            'completedTasks' => $this->taskModel->countByAgentAndStatus($agentId, 'Completed'),
            'todayAttendance'=> $this->attendanceModel->todayStatus($agentId)
        ];

        $this->render('agent/dashboard', $data);

    }

    // /agent/dashboard support
    public function dashboard()
    {
        $this->index();
    }

    /* ======================
       TASKS
    ====================== */
    public function tasks()
    {
        $agentId = $_SESSION['user_id'];

        $tasks = $this->taskModel->getByAgent($agentId);

        $this->render('agent/tasks/index', [
            'tasks' => $tasks
        ]);
    }

    public function updateTaskStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            exit;
        }

        $taskId = $_POST['task_id'] ?? null;
        $status = $_POST['status'] ?? null;

        if (!$taskId || !in_array($status, ['Pending','In Progress','Completed','On Hold'])) {
            echo json_encode(['success' => false]);
            exit;
        }

        $this->taskModel->updateStatus($taskId, $status);

        echo json_encode(['success' => true]);
        exit;
    }

    /* ======================
       PROJECTS
    ====================== */
    public function projects()
    {
        $agentId = $_SESSION['user_id'];

        $projects = $this->projectModel->getByAgent($agentId);

        foreach ($projects as &$project) {
            $project['total_tasks'] =
                $this->taskModel->countByProject($project['id']);

            $project['completed_tasks'] =
                $this->taskModel->countByProjectAndStatus($project['id'], 'Completed');
        }

        $this->render('agent/projects/index', [
            'projects' => $projects
        ]);
    }

    


    /* ======================
       ATTENDANCE
    ====================== */
    public function attendance()
    {
        $agentId = $_SESSION['user_id'];

        $this->render('agent/attendance/index', [
            'attendance' => $this->attendanceModel->getByAgent($agentId),
            'today'      => $this->attendanceModel->todayAttendance($agentId)
        ]);
    }

    public function markAttendance()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            exit;
        }

        $agentId = $_SESSION['user_id'];
        $status  = $_POST['status'] ?? '';

        if (!in_array($status, ['Present','Absent','Leave'])) {
            $_SESSION['error'] = 'Invalid status';
            header('Location: ' . BASE_URL . '/agent/attendance');
            exit;
        }

        $this->attendanceModel->markAttendance($agentId, $status);

        $_SESSION['success'] = 'Attendance marked';
        header('Location: ' . BASE_URL . '/agent/attendance');
        exit;
    }

    /* ======================
       PROFILE
    ====================== */
    public function profile()
    {
        $agentId = $_SESSION['user_id'];

        $user = $this->userModel->findById($agentId);

        $this->render('agent/profile/index', [
            'user' => $user
        ]);
    }

    public function checkIn()
{
    $agentId = $_SESSION['user_id'];

    if ($this->attendanceModel->checkIn($agentId)) {
        $_SESSION['success'] = 'Checked in successfully';
    } else {
        $_SESSION['error'] = 'You have already checked in today';
    }

    header('Location: ' . BASE_URL . '/agent/attendance');
    exit;
}

public function checkOut()
{
    // Safety check
    if (!isset($_SESSION['user_id'])) {
        header("Location: " . BASE_URL . "/auth/login");
        exit;
    }

    $userId = $_SESSION['user_id'];

    $attendanceModel = new \App\Models\Attendance();
    $attendanceModel->checkOut($userId);

    header("Location: " . BASE_URL . "/agent/attendance");
    exit;
}

public function reports()
{
    $agentId = $_SESSION['user_id'];

    /* =========================
       TASK COUNTS
    ==========================*/
    $pendingTasks     = $this->taskModel->countByAgentAndStatus($agentId, 'Pending');
    $inProgressTasks  = $this->taskModel->countByAgentAndStatus($agentId, 'In Progress');
    $completedTasks   = $this->taskModel->countByAgentAndStatus($agentId, 'Completed');

    /* =========================
       ATTENDANCE COUNTS
    ==========================*/
    $attendance = $this->attendanceModel->summaryByAgent($agentId);

    if (!is_array($attendance)) {
    $attendance = [];
}
    $attendanceData = [
        'Present' => 0,
        'Absent'  => 0,
        'Late'    => 0,
        'Leave'   => 0
    ];

    foreach ($attendance as $row) {
    // Safety check: make sure $row has 'status' and 'total'
    if (isset($row['status'], $row['total'])) {
        $attendanceData[$row['status']] = (int)$row['total'];
    }
    /* =========================
       PROJECT COUNTS
    ==========================*/
    $activeProjects     = $this->projectModel->countByAgentAndStatus($agentId, 'Active');
    $completedProjects  = $this->projectModel->countByAgentAndStatus($agentId, 'Completed');
    $pendingProjects    = $this->projectModel->countByAgentAndStatus($agentId, 'Pending');

    /* =========================
       RENDER VIEW
    ==========================*/
    $this->render('agent/reports/index', compact(
        'pendingTasks',
        'inProgressTasks',
        'completedTasks',
        'attendanceData',
        'activeProjects',
        'completedProjects',
        'pendingProjects'
    ));
}
}

public function projectDetails($projectId)
{
    $projectId = (int)$projectId;
    $project = $this->projectModel->getProjectById($projectId);

    if (!$project) {
        die("Project not found!");
    }

    // Fetch tasks for this project
    $tasks = $this->taskModel->getTasksByProject($projectId);

    $this->render('agent/projects/details', compact('project', 'tasks'));
}
public function exportProjectTasks()
{
    session_start();
    $projectId = $_GET['project_id'] ?? 0;
    $projectId = (int)$projectId;

    if (!$projectId) {
        die("Invalid Project ID");
    }

    // Fetch tasks for this project
    $tasks = $this->taskModel->getTasksByProject($projectId);

    if (empty($tasks)) {
        die("No tasks found for this project.");
    }

    // Set CSV headers
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="project_' . $projectId . '_tasks.csv"');

    $output = fopen('php://output', 'w');

    // CSV column headers
    fputcsv($output, ['Task Title', 'Status', 'Due Date', 'Created At']);

    // Write rows
    foreach ($tasks as $task) {
        fputcsv($output, [
            $task['title'],
            $task['status'],
            $task['due_date'] ?? '-',
            $task['created_at']
        ]);
    }

    fclose($output);
    exit;
}


public function tasksExport()
{
    session_start();
    $agentId = $_SESSION['user_id'];
    $status  = $_GET['status'] ?? 'All';

    // Fetch tasks assigned to this agent with optional status filter
    $tasks = $this->taskModel->getTasksByAgentAndStatus($agentId, $status);

    // Prepare CSV headers
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="tasks_' . strtolower($status) . '.csv"');

    $output = fopen('php://output', 'w');

    // Column headers
    fputcsv($output, ['Task Title', 'Project Name', 'Status', 'Start Date', 'Due Date', 'Created At']);

    // Populate rows
    foreach ($tasks as $task) {
        fputcsv($output, [
            $task['title'],
            $task['project_name'] ?? '-',   // join in model to get project name
            $task['status'],
            $task['start_date'] ?? '-',
            $task['due_date'] ?? '-',
            $task['created_at']
        ]);
    }

    fclose($output);
    exit;
}


public function taskDetails()
{
    $agentId = $_SESSION['user_id'];
    $status  = $_GET['status'] ?? '';

    if (!$status) {
        header("Location: " . BASE_URL . "/agent/reports");
        exit;
    }

    $tasks = $this->taskModel->getByAgentAndStatus($agentId, $status);

    $this->render('agent/reports/task_details', compact('tasks', 'status'));
}


public function attendanceDetails()
{
    $agentId = $_SESSION['user_id'];
    $status  = $_GET['status'] ?? '';

    if (!$status) {
        header("Location: " . BASE_URL . "/agent/reports");
        exit;
    }

    $records = $this->attendanceModel->getByAgentAndStatus($agentId, $status);

    $this->render('agent/reports/attendance_details', compact('records', 'status'));
}


public function changePassword()
{
    $userId = $_SESSION['user_id'];
    $message = null;
    $error = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $current = $_POST['current_password'] ?? '';
        $new     = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if ($new !== $confirm) {
            $error = "New passwords do not match.";
        } else {
            $user = $this->userModel->findById($userId);

            if (!password_verify($current, $user['password'])) {
                $error = "Current password is incorrect.";
            } else {
                $hashed = password_hash($new, PASSWORD_DEFAULT);
                $this->userModel->updatePassword($userId, $hashed);
                $message = "Password updated successfully.";
            }
        }
    }

    $this->render('agent/profile/change_password', [
        'success' => $message,
        'error'   => $error
    ]);
}
public function submitForReview()
{
    $success = null;
     $error   = null;
    $projectId = $_POST['project_id'] ?? null;

    if ($projectId) {
        $this->projectModel->markReadyForReview($projectId);
        $success = "Project submitted for admin review";
    } else {
        $error = "Invalid project";
    }

    $agentId  = $_SESSION['user_id'];
    $projects = $this->projectModel->getByAgent($agentId);

    $this->render('agent/projects/index', compact('projects', 'success', 'error'));
}

public function markTaskDone2($taskId)
{
    if (empty($taskId)) {
        header("Location: " . BASE_URL . "/agent/tasks");
        exit;
    }

    $this->taskModel->updateStatus($taskId, 'Completed');

    $_SESSION['task_msg'] = [
        'type' => 'success',
        'text' => 'Task marked as completed'
    ];

    header("Location: " . BASE_URL . "/agent/tasks");
    exit;
}

public function markTaskDone()
{
    $taskId = $_POST['task_id'] ?? null;

    if (!$taskId) {
        header("Location: " . BASE_URL . "/agent/tasks");
        exit;
    }

    $this->taskModel->updateStatus($taskId, 'Completed');

    $_SESSION['task_msg'] = [
        'type' => 'success',
        'text' => 'Task marked as completed'
    ];

    header("Location: " . BASE_URL . "/agent/tasks");
    exit;
}
// Display leave requests submitted by this agent
public function leaveRequests()
{
    $userId = $_SESSION['user_id'];
    $leaves = $this->leaveModel->getByUser($userId);
    $this->render('agent/leaves/index', compact('leaves'));
}

// Submit new leave
public function leaveSubmit()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'user_id'    => $_SESSION['user_id'],
            'start_date' => $_POST['start_date'],
            'end_date'   => $_POST['end_date'],
            'reason'     => $_POST['reason']
        ];

        $this->leaveModel->create($data);
        header('Location: ' . BASE_URL . '/agent/leaveRequests');
        exit;
    }

    $this->render('agent/leaves/create');
}
public function attendanceExport()
{
    // Optional: Check if user is logged in
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Agent') {
        header("Location: " . BASE_URL . "/auth/login");
        exit;
    }

    $status = $_GET['status'] ?? 'All';

    // Load the model
    $attendanceModel = new \App\Models\Attendance();

    // Get attendance records filtered by status
    $records = $attendanceModel->getByStatus($_SESSION['user_id'], $status);

    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="attendance_' . strtolower($status) . '.csv"');

    $output = fopen('php://output', 'w');

    // Add CSV column headers
    fputcsv($output, ['Date', 'Status', 'Check In', 'Check Out', 'Remarks']);

    foreach ($records as $row) {
        fputcsv($output, [
            $row['date'],
            $row['status'],
            $row['check_in'],
            $row['check_out'],
            $row['remarks']
        ]);
    }

    fclose($output);
    exit;
}






    /* ======================
       LOGOUT
    ====================== */
    public function logout()
    {
        session_destroy();
        header('Location: ' . BASE_URL . '/auth/login');
        exit;
    }
}
