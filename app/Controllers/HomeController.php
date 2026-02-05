<?php
namespace App\Controllers;

use Core\Controller;
use Core\Auth;


class HomeController extends Controller {

    public function index() {

    // 🚫 Logged-in users should not see home
    Auth::redirectIfLoggedIn();

    $this->render('home/index');
}
}
