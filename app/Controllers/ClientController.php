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
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Client') {
            header('Location: ' . BASE_URL . '/auth/login');
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
}
