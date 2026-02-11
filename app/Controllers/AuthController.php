<?php
namespace App\Controllers;

use Core\Controller;
use Core\Auth;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    /* =================== LOGIN =================== */
    public function login()
    {
        Auth::redirectIfLoggedIn();
        $this->render('auth/login', ['title' => 'Login']);
    }

    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth/login');
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = $this->user->findByUsername($username);

        if (!$user || !password_verify($password, $user['password'])) {
            $this->render('auth/login', ['error' => 'Invalid username or password']);
            return;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role_name'];

        // Role-based redirect
        switch ($user['role_name']) {
            case 'Admin':
                $this->redirect('admin/dashboard');
                break;
            case 'Agent':
                $this->redirect('agent/dashboard');
                break;
            case 'Client':
                $this->redirect('client/dashboard');
                break;
            default:
                session_destroy();
                $this->redirect('auth/login');
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('auth/login');
    }

    /* =================== REGISTER =================== */
    public function register()
    {
        $this->render('auth/register', ['title' => 'Register']);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth/register');
        }

        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'username' => trim($_POST['username'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'password_confirmation' => $_POST['password_confirmation'] ?? '',
        ];

        if (empty($data['name']) || empty($data['email']) || empty($data['username']) || empty($data['password'])) {
            $this->render('auth/register', ['error' => 'All fields are required']);
            return;
        }

        if ($data['password'] !== $data['password_confirmation']) {
            $this->render('auth/register', ['error' => 'Passwords do not match']);
            return;
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['role_id'] = 3; // Default role = Client
        $data['status'] = 'Active';

        if (!$this->user->create($data)) {
            $this->render('auth/register', ['error' => 'Registration failed']);
            return;
        }

        $this->render('auth/login', ['success' => 'Registration successful. Please login.']);
    }

    /* =================== FORGOT PASSWORD =================== */
    public function forgot()
    {
        $this->render('auth/forgot', ['title' => 'Forgot Password']);
    }


    public function sendResetLink()
{
    // Only handle POST requests
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $this->redirect('auth/forgot');
    }

    $email = trim($_POST['email'] ?? '');
    if (empty($email)) {
        $this->render('auth/forgot', ['error' => 'Please enter your email']);
        return;
    }

    $user = $this->user->findByEmail($email);
    if (!$user) {
        $this->render('auth/forgot', ['error' => 'Email not found']);
        return;
    }

    // Generate a secure token and expiry
    $token = bin2hex(random_bytes(16));
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Save token in DB
    $this->user->createPasswordResetToken($user['id'], $token, $expires);

    // Build reset link for localhost
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST']; // e.g., localhost
    $baseUrl = $protocol . $host . "/serms/public"; // adjust if your project folder is different

    // Important: use index.php?url=auth/reset&token=... for your router
    $resetLink = $baseUrl . "/index.php?url=auth/reset&token=" . $token;

    // Send email using PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
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
        $mail->Body    = "
            <p>Hello {$user['name']},</p>
            <p>You requested a password reset. Click the link below to reset your password:</p>
            <p><a href='{$resetLink}'>Reset Password</a></p>
            <p>If you did not request this, you can safely ignore this email.</p>
        ";

        $mail->send();

        $this->render('auth/forgot', [
            'success' => 'Reset link sent successfully. Check your email.'
        ]);

    } catch (\PHPMailer\PHPMailer\Exception $e) {
        $this->render('auth/forgot', [
            'error' => "Email could not be sent. Mailer Error: {$mail->ErrorInfo}"
        ]);
    }
}


    
    /* =================== RESET PASSWORD =================== */
    public function reset()
    {
        $token = $_GET['token'] ?? '';
        if (!$token) {
            $this->redirect('auth/login');
        }

        $this->render('auth/reset', ['token' => $token]);
    }

    public function updatePassword()
    {
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

        $this->user->deletePasswordResetToken($token);

        $this->redirect('auth/login');
    }
}
