<?php
namespace App\Controllers;

use Core\Controller;
use Core\Auth;
use Core\Session;
use App\Models\Project;
use App\Models\RequestModel;

class ClientController extends Controller {

    private $projectModel;
    private $requestModel;

    public function __construct() {
        Auth::role('Client'); // Only client access
        $this->projectModel = new Project();
        $this->requestModel = new RequestModel();
    }

    public function dashboard() {
        $userId = Session::get('user')['id'];

        $myProjects = $this->projectModel->countByClient($userId);
        $pendingRequests = $this->requestModel->countPendingByClient($userId);
        $approvedRequests = $this->requestModel->countApprovedByClient($userId);

        $title = "Client Dashboard";

        $this->render('client/dashboard', compact('myProjects','pendingRequests','approvedRequests','title'));
    }

    // Add client-specific methods like submitting requests, viewing projects
}
