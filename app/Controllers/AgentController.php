<?php
namespace App\Controllers;

use Core\Controller;
use Core\Auth;
use Core\Session;
use App\Models\Task;
use App\Models\Project;
use App\Models\Leave;

class AgentController extends Controller {

    private $taskModel;
    private $projectModel;
    private $leaveModel;

    public function __construct() {
        Auth::role('Agent'); // Only agent access
        $this->taskModel = new Task();
        $this->projectModel = new Project();
        $this->leaveModel = new Leave();
    }

    public function dashboard() {
        $userId = Session::get('user')['id'];

        $assignedTasks = $this->taskModel->countByUser($userId);
        $pendingTasks = $this->taskModel->countByUserAndStatus($userId,'To Do');
        $completedTasks = $this->taskModel->countByUserAndStatus($userId,'Done');

        $chartData = [
            $pendingTasks,
            $this->taskModel->countByUserAndStatus($userId,'In Progress'),
            $completedTasks
        ];

        $title = "Agent Dashboard";

        $this->render('agent/dashboard', compact('assignedTasks','pendingTasks','completedTasks','chartData','title'));
    }

    // Add agent-specific methods like submitting tasks, attendance, documents
}
