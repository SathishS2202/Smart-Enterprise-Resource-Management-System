<?php
namespace App\Controllers;

use Core\Controller;
use Core\Session;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Leave;
use App\Models\RequestModel;

class AdminController extends Controller {

    private $userModel;
    private $projectModel;
    private $taskModel;
    private $leaveModel;
    private $requestModel;

    public function __construct() {
        $this->userModel = new User();
        $this->projectModel = new Project();
        $this->taskModel = new Task();
        $this->leaveModel = new Leave();
        $this->requestModel = new RequestModel();
    }

    public function dashboard() {
        $totalUsers = $this->userModel->countAll();
        $totalAgents = $this->userModel->countByRole('Agent');
        $totalClients = $this->userModel->countByRole('Client');

        $totalProjects = $this->projectModel->countAll();
        $pendingTasks = $this->taskModel->countByStatus('To Do');
        $inProgressTasks = $this->taskModel->countByStatus('In Progress');
        $doneTasks = $this->taskModel->countByStatus('Done');

        $pendingLeaves = $this->leaveModel->countByStatus('Pending');
        $totalRequests = $this->requestModel->countAll();

        $data = compact(
            'totalUsers',
            'totalAgents',
            'totalClients',
            'totalProjects',
            'pendingTasks',
            'inProgressTasks',
            'doneTasks',
            'pendingLeaves',
            'totalRequests'
        );

        $this->render('admin/dashboard', $data);
    }
}
