<?php
namespace App\Controllers;

use Core\Controller;
use Core\Auth;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Leave;
use App\Models\RequestModel;
use App\Models\Attendance;
use App\Models\Document;
use App\Models\ReportModels;

class AdminController extends Controller
{
    private $userModel;
    private $projectModel;
    private $taskModel;
    private $leaveModel;
    private $requestModel;
    private $attendanceModel;
    private $documentModel;

    public function __construct()
    {
        // 🔐 Admin only
        Auth::role('Admin');

        $this->userModel     = new User();
        $this->projectModel  = new Project();
        $this->taskModel     = new Task();
        $this->leaveModel    = new Leave();
        $this->requestModel = new RequestModel();
        $this->attendanceModel = new Attendance();
        $this->documentModel = new Document();

    }

    /* ================= DASHBOARD ================= */

    public function dashboard()
    {
        $totalUsers   = $this->userModel->countAll();
        $totalAgents  = $this->userModel->countByRole('Agent');
        $totalClients = $this->userModel->countByRole('Client');

        $totalProjects = $this->projectModel->countAll();

        $pendingTasks    = $this->taskModel->countByStatus('To Do');
        $inProgressTasks = $this->taskModel->countByStatus('In Progress');
        $doneTasks       = $this->taskModel->countByStatus('Done');

        $pendingLeaves = $this->leaveModel->countByStatus('Pending');
        $totalRequests = $this->requestModel->countAll();

        $this->render('admin/dashboard', compact(
            'totalUsers',
            'totalAgents',
            'totalClients',
            'totalProjects',
            'pendingTasks',
            'inProgressTasks',
            'doneTasks',
            'pendingLeaves',
            'totalRequests'
        ));
    }

    /* ================= USER MANAGEMENT ================= */

    // /admin/users
    public function users()
{
    $users = $this->userModel->getAllWithRoles();
    $this->render('admin/users/index', compact('users'));
}

    // /admin/usersCreate
    public function usersCreate()
    {
        $roles = $this->userModel->getRoles();
        $this->render('admin/users/create', compact('roles'));
    }

// UPDATE USER
public function usersUpdate()
{
    $id = $_GET['id'] ?? null;
    if (!$id) die('User ID missing');

    $data = [
        'name'     => trim($_POST['name']),
        'username' => trim($_POST['username']),
        'email'    => trim($_POST['email']),
        'role_id'  => (int) $_POST['role_id'], // role_id is INT
        'status'   => $_POST['status']         // ENUM STRING ✔
    ];

    $this->userModel->update($id, $data);

    $_SESSION['user_msg'] = [
        'type' => 'success',
        'text' => 'User updated successfully'
    ];

    $this->redirect('admin/users');
}


    // /admin/usersStore
    public function usersStore()
    {
        $data = $_POST;
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->userModel->create($data);

        $this->redirect('admin/users');
    }

    // /admin/usersStatus?id=1&status=0
    public function userStatus()
{
    $id = $_GET['id'] ?? null;
    $status = $_GET['status'] ?? null;

    if (!$id || !in_array($status, ['Active', 'Inactive'])) {
        $_SESSION['user_msg'] = [
            'type' => 'error',
            'text' => 'Invalid status update'
        ];
        header("Location: " . BASE_URL . "/admin/users");
        exit;
    }

    $userModel = new \App\Models\User();
    $userModel->updateStatus($id, $status);

    $_SESSION['user_msg'] = [
        'type' => 'success',
        'text' => 'User status updated successfully'
    ];

    header("Location: " . BASE_URL . "/admin/users");
    exit;
}



    public function userDelete()
{
    $id = (int)($_GET['id'] ?? 0);

    if ($this->userModel->exists($id)) {
        $this->userModel->delete($id);
        $_SESSION['user_msg'] = [
            'type' => 'success',
            'text' => 'User deleted successfully.'
        ];
    } else {
        $_SESSION['user_msg'] = [
            'type' => 'error',
            'text' => 'User not found.'
        ];
    }

    $this->redirect('admin/users');
}
// SHOW EDIT FORM
public function usersEdit()
{
    $user  = $this->userModel->getById($_GET['id']);
    $roles = $this->userModel->getRoles();
    $this->render('admin/users/edit', compact('user', 'roles'));
}

// DELETE USER
public function usersDelete()
{
    $this->userModel->delete($_GET['id']);
    $_SESSION['user_msg'] = [
        'type' => 'success',
        'text' => 'User deleted successfully'
    ];
    $this->redirect('admin/users');
}
public function projects()
{
    $projects = $this->projectModel->getAllWithClientAgent();
    $agents   = $this->userModel->getAllAgents(); // ✅ ALL agents

    $this->render('admin/projects/index', compact('projects', 'agents'));
}


    // Show create form
    public function projectsCreate() {
        $clients = $this->projectModel->getByRoleName('Client');
        $agents  = $this->projectModel->getByRoleName('Agent');
        $this->render('admin/projects/create', compact('clients','agents'));
    }

    // Store new project
    public function projectsStore() {
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'] ?? '',
                'client_id' => $_POST['client_id'],
                'start_date' => $_POST['start_date'] ?? null,
                'end_date' => $_POST['end_date'] ?? null,
                'status' => $_POST['status'] ?? 'Pending',
            ];

            if ($this->projectModel->create($data)) {
                $_SESSION['project_msg'] = ['type'=>'success','text'=>'Project created successfully'];
            } else {
                $_SESSION['project_msg'] = ['type'=>'danger','text'=>'Failed to create project'];
            }

            header('Location: '.BASE_URL.'/admin/projects');
            exit;
        }
    }

    // Show edit form
    public function projectsEdit() {
        $id = $_GET['id'] ?? 0;
        $project = $this->projectModel->getById($id);
        $clients = $this->projectModel->getByRoleName('Client');
        $agents  = $this->projectModel->getByRoleName('Agent');
        $this->render('admin/projects/edit', compact('project','clients','agents'));
    }

    // Update project
    public function projectsUpdate() {
        $id = $_GET['id'] ?? 0;
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $data = [
                'name' => $_POST['name'],
                'client_id' => $_POST['client_id'],
                'agent_id' => $_POST['agent_id'] ?? null,
                'start_date' => $_POST['start_date'] ?? null,
                'end_date' => $_POST['end_date'] ?? null,
                'status' => $_POST['status'] ?? 'Pending'
            ];

            if ($this->projectModel->update($id,$data)) {
                $_SESSION['project_msg'] = ['type'=>'success','text'=>'Project updated successfully'];
            } else {
                $_SESSION['project_msg'] = ['type'=>'danger','text'=>'Failed to update project'];
            }

            header('Location: '.BASE_URL.'/admin/projects');
            exit;
        }
    }

    // Delete project
    public function projectsDelete() {
        $id = $_GET['id'] ?? 0;
        if ($this->projectModel->delete($id)) {
            $_SESSION['project_msg'] = ['type'=>'success','text'=>'Project deleted successfully'];
        } else {
            $_SESSION['project_msg'] = ['type'=>'danger','text'=>'Failed to delete project'];
        }
        header('Location: '.BASE_URL.'/admin/projects');
        exit;
    }

    // Assign agent
    public function assignAgent() {
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $pid = $_POST['project_id'];
            $aid = $_POST['agent_id'];

            if ($this->projectModel->assignAgent($pid,$aid)) {
                $_SESSION['project_msg'] = ['type'=>'success','text'=>'Agent assigned successfully'];
            } else {
                $_SESSION['project_msg'] = ['type'=>'danger','text'=>'Failed to assign agent'];
            }
            header('Location: '.BASE_URL.'/admin/projects');
            exit;
        }
    }
    // Tasks List
public function tasks() {
    $tasks = $this->taskModel->getAll();
    $agents = $this->taskModel->getAgents();
    $projects = $this->taskModel->getProjects();
    $this->render('admin/tasks/index', compact('tasks','agents','projects'));
}

// Create Task Page
public function tasksCreate() {
    $agents = $this->taskModel->getAgents();
    $projects = $this->taskModel->getProjects();
    $this->render('admin/tasks/create', compact('agents','projects'));
}

// Store Task
public function tasksStore() {
    $data = [
        'project_id' => $_POST['project_id'],
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'assigned_to' => $_POST['assigned_to'] ?? null,
        'start_date' => $_POST['start_date'] ?? null,
        'due_date' => $_POST['due_date'] ?? null,
        'status' => $_POST['status'] ?? 'Pending'
    ];
    $this->taskModel->create($data);
    $_SESSION['task_msg'] = ['type'=>'success','text'=>'Task created successfully!'];
    header("Location: " . BASE_URL . "/admin/tasks");
}

// Edit Task Page
public function tasksEdit() {
    $id = $_GET['id'];
    $task = $this->taskModel->getById($id);
    $agents = $this->taskModel->getAgents();
    $projects = $this->taskModel->getProjects();
    $this->render('admin/tasks/edit', compact('task','agents','projects'));
}

// Update Task
public function tasksUpdate() {
    $id = $_GET['id'];
    $data = [
        'project_id' => $_POST['project_id'],
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'assigned_to' => $_POST['assigned_to'] ?? null,
        'start_date' => $_POST['start_date'] ?? null,
        'due_date' => $_POST['due_date'] ?? null,
        'status' => $_POST['status'] ?? 'Pending'
    ];
    $this->taskModel->update($id, $data);
    $_SESSION['task_msg'] = ['type'=>'success','text'=>'Task updated successfully!'];
    header("Location: " . BASE_URL . "/admin/tasks");
}

// Delete Task
public function tasksDelete() {
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        $_SESSION['task_msg'] = [
            'type' => 'danger',
            'text' => 'Invalid task ID'
        ];
        header("Location: " . BASE_URL . "/admin/tasks");
        exit;
    }

    $id = (int)$_GET['id'];
    $this->taskModel->delete($id);

    $_SESSION['task_msg'] = [
        'type' => 'success',
        'text' => 'Task deleted successfully'
    ];

    header("Location: " . BASE_URL . "/admin/tasks");
    exit;
}

public function tasksAssignAgent() {
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $taskId = $_POST['task_id'] ?? null;
        $agentId = $_POST['agent_id'] ?? null;

        if($taskId && $agentId) {
            $success = $this->taskModel->assignAgent((int)$taskId, (int)$agentId);
            if($success) {
                $_SESSION['task_msg'] = ['type'=>'success','text'=>'Agent assigned successfully'];
            } else {
                $_SESSION['task_msg'] = ['type'=>'danger','text'=>'Failed to assign agent'];
            }
        }
        header('Location: '.BASE_URL.'/admin/tasks');
        exit;
    }
}
// List Attendance



// Add Attendance
public function attendance()
{
    $attendances = $this->attendanceModel->getAll();
    $this->render('admin/attendance/index', compact('attendances'));
}


public function attendanceStore() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'user_id' => $_POST['user_id'],
            'date' => $_POST['date'],
            'status' => $_POST['status'],
            'remarks' => $_POST['remarks'] ?? ''
        ];
        $this->attendanceModel->create($data);
        $_SESSION['attendance_msg'] = ['type'=>'success','text'=>'Attendance added successfully'];
        header("Location: " . BASE_URL . "/admin/attendance");
        exit;
    }
}

// Edit Attendance
public function attendanceEdit() {
    if (!isset($_GET['id'])) {
        header("Location: " . BASE_URL . "/admin/attendance"); exit;
    }
    $attendance = $this->attendanceModel->getById((int)$_GET['id']);
    $users = $this->attendanceModel->getUsers();
    $this->render('admin/attendance/edit', compact('attendance','users'));
}

public function attendanceUpdate() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $data = [
            'user_id' => $_POST['user_id'],
            'date' => $_POST['date'],
            'status' => $_POST['status'],
            'remarks' => $_POST['remarks'] ?? ''
        ];
        $this->attendanceModel->update($id, $data);
        $_SESSION['attendance_msg'] = ['type'=>'success','text'=>'Attendance updated successfully'];
        header("Location: " . BASE_URL . "/admin/attendance");
        exit;
    }
}

// Delete Attendance
public function attendanceDelete() {
    if (isset($_GET['id'])) {
        $this->attendanceModel->delete((int)$_GET['id']);
        $_SESSION['attendance_msg'] = ['type'=>'success','text'=>'Attendance deleted successfully'];
    }
    header("Location: " . BASE_URL . "/admin/attendance");
    exit;
}
public function documents() {
    $documents = $this->documentModel->getAll();
    $this->render('admin/documents/index', compact('documents'));
}
public function documentsCreate() {
    $this->render('admin/documents/create');
}
public function documentsDelete() {
    $id = (int)$_GET['id'];
    $doc = $this->documentModel->getById($id);

    if ($doc) {
        @unlink(BASE_PATH.'/public/'.$doc['file_path']);
        $this->documentModel->delete($id);
    }

    $_SESSION['doc_msg'] = [
        'type' => 'success',
        'text' => 'Document deleted'
    ];

    header("Location: ".BASE_URL."/admin/documents");
}
public function documentsStore() {

    $file = $_FILES['document'];
    $fileName = time().'_'.$file['name'];
    $uploadPath = 'uploads/documents/'.$fileName;

    move_uploaded_file($file['tmp_name'], BASE_PATH.'/public/'.$uploadPath);

    $this->documentModel->create([
        'title' => $_POST['title'],
        'file_path' => $uploadPath,
        'uploaded_by' => $_SESSION['user_id']
    ]);

    $_SESSION['doc_msg'] = [
        'type' => 'success',
        'text' => 'Document uploaded successfully'
    ];

    header("Location: ".BASE_URL."/admin/documents");
}
public function documentView()
{
    $id = $_GET['id'] ?? null;

    if (!$id) {
        header("Location: " . BASE_URL . "/admin/documents");
        exit;
    }

    $document = $this->documentModel->findById($id);

    if (!$document) {
        $_SESSION['doc_msg'] = [
            'type' => 'error',
            'text' => 'Document not found'
        ];
        header("Location: " . BASE_URL . "/admin/documents");
        exit;
    }

    $this->view('admin/documents/view', [
        'title' => 'View Document',
        'document' => $document
    ]);
}
public function reports()
{
    // USERS
    $totalUsers = $this->userModel->countAll();
    $rolesData = $this->userModel->countByRoles();
    $userGrowth = $this->userModel->weeklyGrowth();

    // PROJECTS
    $totalProjects = $this->projectModel->countAll();
    $projectStatus = $this->projectModel->countByStatus();
    $projectsPerAgent = $this->projectModel->countPerAgent();

    // TASKS
    $totalTasks = $this->taskModel->countAll();
    $taskStatus = $this->taskModel->countByStatus();
   

    // ATTENDANCE
    $attendanceStats = $this->attendanceModel->presentVsAbsent();
    $attendanceWeekly = $this->attendanceModel->weeklyAttendance();

    $this->render('admin/reports/index', compact(
    'totalUsers',
    'rolesData',
    'userGrowth',
    'totalProjects',
    'projectStatus',
    'projectsPerAgent',
    'totalTasks',
    'taskStatus',
    'attendanceStats',
    'attendanceWeekly'
));

}
public function profile()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $user = $this->userModel->findById($_SESSION['user_id']);

        $this->render('admin/profile/index', compact('user'));
    }

    public function logout()
{
    session_start();

    // Unset all session variables
    $_SESSION = [];

    // Destroy session
    session_destroy();

    // Redirect to login page
    header('Location: ' . BASE_URL . '/auth/login');
    exit;
}



public function changePassword()
{


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $current = $_POST['current_password'] ?? '';
        $new     = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if ($new !== $confirm) {
            $_SESSION['profile_msg'] = [
                'type' => 'danger',
                'text' => 'New password and confirm password do not match'
            ];
            header('Location: ' . BASE_URL . '/admin/changePassword');
            exit;
        }

        $user = $this->userModel->findById($userId);

        if (!password_verify($current, $user['password'])) {
            $_SESSION['profile_msg'] = [
                'type' => 'danger',
                'text' => 'Current password is incorrect'
            ];
            header('Location: ' . BASE_URL . '/admin/changePassword');
            exit;
        }

        $hashed = password_hash($new, PASSWORD_DEFAULT);
        $this->userModel->updatePassword($userId, $hashed);

        $_SESSION['profile_msg'] = [
            'type' => 'success',
            'text' => 'Password updated successfully'
        ];

        header('Location: ' . BASE_URL . '/admin/profile');
        exit;
    }

    $this->render('admin/profile/change_password');
}
public function approveProject()
{
    $projectId = $_POST['project_id'] ?? null;
    $adminId   = $_SESSION['user_id'];

    if ($projectId) {
        $this->projectModel->markCompleted($projectId, $adminId);
        $success = "Project approved & completed";
    } else {
        $error = "Invalid project";
    }

    $projects = $this->projectModel->getAllWithRelations();
    $agents   = $this->userModel->getAgents();

    $this->render('admin/projects/index', compact(
        'projects',
        'agents',
        'success',
        'error'
    ));
}



}

