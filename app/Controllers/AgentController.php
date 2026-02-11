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

        $this->attendanceModel->mark($agentId, $status);

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
public function reports()
{
    $agentId = $_SESSION['user_id'];

    // TASK COUNTS
    $pendingTasks   = $this->taskModel->countByAgentAndStatus($agentId, 'Pending');
    $completedTasks = $this->taskModel->countByAgentAndStatus($agentId, 'Completed');

    // ATTENDANCE COUNTS
    $attendance = $this->attendanceModel->summaryByAgent($agentId);

    // Convert attendance rows to key-value
    $attendanceData = [
        'Present' => 0,
        'Absent'  => 0,
        'Late'    => 0,
        'Leave'   => 0
    ];

    foreach ($attendance as $row) {
        $attendanceData[$row['status']] = $row['total'];
    }

    $this->render('agent/reports/index', compact(
        'pendingTasks',
        'completedTasks',
        'attendanceData'
    ));
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
