<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class ClientController extends Controller
{
    protected Project $projectModel;
    protected Task $taskModel;
    protected User $userModel;

    public function __construct()
    {
        // Start session safely
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Client only
       $role = $_SESSION['impersonate_role'] ?? $_SESSION['role'];

    if ($role !== 'Client' && $_SESSION['role'] !== 'Admin') {
        header("Location: " . BASE_URL . "/auth/login");
        exit;
    }

        // ✅ INITIALIZE ALL MODELS
        $this->projectModel = new Project();
        $this->taskModel    = new Task();
        $this->userModel    = new User();
    }

    /* ======================
       DASHBOARD
    ====================== */
    public function index()
    {
        $clientId = $_SESSION['user_id'];

        $totalProjects =
            $this->projectModel->countByClient($clientId);

        $activeProjects =
            $this->projectModel->countByClientAndStatus($clientId, 'Active');

        $completedProjects =
            $this->projectModel->countByClientAndStatus($clientId, 'Completed');

        $this->render('client/dashboard', compact(
            'totalProjects',
            'activeProjects',
            'completedProjects'
        ));
    }

    public function dashboard()
    {
        $this->index();
    }

    /* ======================
       PROJECTS
    ====================== */
    public function projects()
    {
        $clientId = $_SESSION['user_id'];

        $projects = $this->projectModel->getByClient($clientId);

        // Task stats per project
        foreach ($projects as &$project) {
            $project['total_tasks'] =
                $this->taskModel->countByProject($project['id']);

            $project['completed_tasks'] =
                $this->taskModel->countByProjectAndStatus(
                    $project['id'],
                    'Completed'
                );
        }

        $this->render('client/projects/index', compact('projects'));
    }

    /* ======================
       PROFILE
    ====================== */
    public function profile()
    {
        $clientId = $_SESSION['user_id'];
        $user = $this->userModel->findById($clientId);

        $this->render('client/profile/index', compact('user'));
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
    /* ======================
   CREATE PROJECT (CLIENT)
====================== */
public function projectsCreate()
{
    $this->render('client/projects/create');
}

/* ======================
   STORE PROJECT (CLIENT)
====================== */
public function projectsStore()
{
    $clientId = $_SESSION['user_id'];

    $data = [
        'name'       => $_POST['name'],
        'client_id'  => $clientId,
        'agent_id'   => null,
        'start_date' => $_POST['start_date'] ?? null,
        'end_date'   => $_POST['end_date'] ?? null,
        'status'     => 'Pending' // 👈 important
    ];

    $this->projectModel->create($data);

    $_SESSION['success'] = 'Project request submitted successfully';

    header("Location: " . BASE_URL . "/client/projects");
    exit;
}

public function tasks()
{
    $clientId = $_SESSION['user_id'];

    // Load model
    $taskModel = new \App\Models\Task();

    // Fetch client tasks (through projects)
    $tasks = $taskModel->getByClient($clientId);

    $this->render('client/tasks/index', compact('tasks'));
}

/* ======================
   TASKS
====================== */

// LIST TASKS
// SHOW CREATE FORM
public function createTask()
{
    $clientId = $_SESSION['user_id'];

    // client projects only
    $projects = $this->projectModel->getByClient($clientId);

    $this->render('client/tasks/create', compact('projects'));
}

// STORE TASK
public function storeTask()
{
    $data = [
        'project_id'   => $_POST['project_id'],
        'title'        => $_POST['title'],
        'description'  => $_POST['description'] ?? null,
        'priority'     => $_POST['priority'] ?? 'Normal',
        'start_date'   => $_POST['start_date'] ?? null,
        'due_date'     => $_POST['due_date'] ?? null,
        'status'       => 'Pending'
    ];

    $this->taskModel->create($data);

    $_SESSION['task_msg'] = [
        'type' => 'success',
        'text' => 'Task added successfully'
    ];

    header('Location: ' . BASE_URL . '/client/tasks');
    exit;
}
/* ======================
   REPORTS
====================== */
public function reports()
{
    $clientId = $_SESSION['user_id'];

    // PROJECT COUNTS
    $totalProjects =
        $this->projectModel->countByClient($clientId);

    $completedProjects =
        $this->projectModel->countByClientAndStatus($clientId, 'Completed');

    $activeProjects =
        $this->projectModel->countByClientAndStatus($clientId, 'Active');

    // TASK COUNTS
    $totalTasks =
        $this->taskModel->countByClient($clientId);

    $completedTasks =
        $this->taskModel->countByClientAndStatus($clientId, 'Completed');

    $pendingTasks = $totalTasks - $completedTasks;

    $this->render('client/reports/index', compact(
        'totalProjects',
        'activeProjects',      
        'completedProjects',
        'totalTasks',
        'completedTasks',
        'pendingTasks'
    ));
}

public function profileUpdate()
{
    $clientId = $_SESSION['user_id'];

    $data = [
        'name'  => $_POST['name'],
    ];

    $this->userModel->updateProfile($clientId, $data);

    $_SESSION['profile_msg'] = 'Profile updated successfully!';
    header('Location: ' . BASE_URL . '/client/profile');
    exit;
}



}
