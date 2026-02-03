<?php
namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Core\Controller;
use App\Models\User;


class AuthController extends Controller {

    private $user;

    public function __construct() {
        $this->user = new User();
    }

    // Show login page
    public function login() {
        $this->render('auth/login', [
            'title' => 'Login'
        ]);
    }

    // Handle login POST
    public function authenticate() {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth/login');
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = $this->user->findByUsername($username);

        if (!$user || !password_verify($password, $user['password'])) {
            $this->render('auth/login', [
                'error' => 'Invalid username or password'
            ]);
            return;
        }

        // ✅ LOGIN SUCCESS
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['username']  = $user['username'];
        $_SESSION['role']      = $user['role_name'];

        // Role-based redirect
        switch ($user['role_name']) {
            case 'Admin':
                $this->redirect('admin/dashboard');
            case 'Agent':
                $this->redirect('agent/dashboard');
            case 'Client':
                $this->redirect('client/dashboard');
            default:
                session_destroy();
                $this->redirect('auth/login');
        }
    }

    // Logout
    public function logout() {
        session_destroy();
        $this->redirect('auth/login');
    }

    // Show register page
    public function register() {
        $this->render('auth/register', [
            'title' => 'Register'
        ]);
    }

    // Handle register POST
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth/register');
        }

        $data = [
            'name'                  => trim($_POST['name'] ?? ''),
            'email'                 => trim($_POST['email'] ?? ''),
            'username'              => trim($_POST['username'] ?? ''),
            'password'              => $_POST['password'] ?? '',
            'password_confirmation' => $_POST['password_confirmation'] ?? '',
        ];

        // Basic validation
        if (empty($data['name']) || empty($data['email']) || empty($data['username']) || empty($data['password'])) {
            $this->render('auth/register', [
                'error' => 'All fields are required'
            ]);
            return;
        }

        if ($data['password'] !== $data['password_confirmation']) {
            $this->render('auth/register', [
                'error' => 'Passwords do not match'
            ]);
            return;
        }

        // Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        
        if (!$this->user->create($data)) {
            $this->render('auth/register', [
                'error' => 'Registration failed'
            ]);
            return;
        }

        // Redirect to login
        $this->redirect('auth/login');
    }

    // Show forgot password page
public function forgot() {
    $this->render('auth/forgot', ['title' => 'Forgot Password']);
}



public function sendResetLink() {
    $email = trim($_POST['email'] ?? '');
    $user = $this->user->findByEmail($email);
    if (!$user) {
        $this->render('auth/forgot', ['error' => 'Email not found']);
        return;
    }

    $token = bin2hex(random_bytes(16));
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
    $this->user->createPasswordResetToken($user['id'], $token, $expires);

    // Detect current protocol and host dynamically
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST']; // localhost, serms.local, or live domain
$baseUrl = $protocol . $host . "/serms"; // adjust "/serms" to your project folder if different

$resetLink = $baseUrl . "/index.php?url=auth/reset&token=$token";



    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';   // e.g., Gmail SMTP
        $mail->SMTPAuth   = true;
        $mail->Username = 'sathishs2202@gmail.com';
    $mail->Password = 'iegaktnuladdhjsm';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('sathishs2202@gmail.com', 'SERMS');
        $mail->addAddress($email, $user['name']);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body    = "Click the link to reset your password: <a href='$resetLink'>$resetLink</a>";

        $mail->send();
        $this->render('auth/forgot', ['success' => 'Reset link sent to your email']);
    } catch (Exception $e) {
        $this->render('auth/forgot', ['error' => "Email could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
    }
}

// Show reset form
public function reset() {
    $token = $_GET['token'] ?? '';
    if (!$token) {
        $this->redirect('auth/login');
    }

    $this->render('auth/reset', ['token' => $token]);
}

// Handle reset POST
public function updatePassword() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $this->redirect('auth/login');
    }

    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if (empty($password) || $password !== $password_confirm) {
        $this->render('auth/reset', ['error' => 'Passwords do not match', 'token' => $token]);
        return;
    }

    $reset = $this->user->getPasswordResetByToken($token);
    if (!$reset || strtotime($reset['expires_at']) < time()) {
        $this->render('auth/reset', ['error' => 'Invalid or expired token']);
        return;
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $this->user->updatePassword($reset['user_id'], $hashed);

    // Delete token after use
    $this->user->deletePasswordResetToken($token);

    $this->redirect('auth/login');
}


}
