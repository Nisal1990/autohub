<?php

require_once APP_ROOT . '/app/models/UserModel.php';
require_once APP_ROOT . '/app/models/LookupModel.php';

class AuthController extends Controller
{
    private UserModel $users;

    public function __construct()
    {
        $this->users = new UserModel();
    }

    public function showLogin(): void
    {
        if (isLoggedIn()) $this->redirect(url('dashboard'));
        $this->view('auth/login', ['title' => 'Login — ' . SITE_NAME]);
    }

    public function login(): void
    {
        csrfCheck();
        $email    = $this->post('email');
        $password = $this->post('password');
        $errors   = [];

        if (empty($email))    $errors[] = 'Email is required.';
        if (empty($password)) $errors[] = 'Password is required.';

        if (empty($errors)) {
            $user = $this->users->findByEmail($email);
            if ($user && $this->users->verifyPassword($password, $user['password_hash'])) {
                if ($user['status'] === 'suspended') {
                    $errors[] = 'Your account has been suspended. Contact support.';
                } else {
                    loginUser($user);
                    $intended = $_SESSION['intended_url'] ?? '';
                    unset($_SESSION['intended_url']);
                    $this->redirect($intended ?: url('dashboard'));
                    return;
                }
            } else {
                $errors[] = 'Invalid email or password.';
            }
        }
        $this->view('auth/login', ['title' => 'Login', 'errors' => $errors, 'old' => ['email' => $email]]);
    }

    public function showRegister(): void
    {
        if (isLoggedIn()) $this->redirect(url('dashboard'));
        $districts = (new \LookupModel())->getAllDistricts();
        $this->view('auth/register', ['title' => 'Register — ' . SITE_NAME, 'districts' => $districts]);
    }

    public function register(): void
    {
        csrfCheck();

        $name     = sanitize($this->post('name'));
        $email    = sanitize($this->post('email'));
        $phone    = sanitize($this->post('phone'));
        $district = sanitize($this->post('district'));
        $city     = sanitize($this->post('city'));
        $password = $this->post('password');
        $confirm  = $this->post('password_confirm');
        $errors   = [];

        if (empty($name))                          $errors[] = 'Full name is required.';
        if (!validateEmail($email))                $errors[] = 'Valid email address is required.';
        if ($phone && !validateSriLankaPhone($phone)) $errors[] = 'Enter a valid Sri Lanka phone number (e.g. 0771234567).';
        if (strlen($password) < 8)                 $errors[] = 'Password must be at least 8 characters.';
        if ($password !== $confirm)                $errors[] = 'Passwords do not match.';
        if ($this->users->emailExists($email))     $errors[] = 'This email is already registered. Please login.';

        if (empty($errors)) {
            $id = $this->users->create(compact('name','email','phone','password','district','city'));
            $user = $this->users->findById($id);
            loginUser($user);
            $this->flash('success', 'Welcome to ' . SITE_NAME . '! Your account has been created.');
            $this->redirect(url('dashboard'));
            return;
        }

        $districts = (new \LookupModel())->getAllDistricts();
        $this->view('auth/register', [
            'title'     => 'Register',
            'errors'    => $errors,
            'districts' => $districts,
            'old'       => compact('name','email','phone','district','city'),
        ]);
    }

    public function logout(): void
    {
        logoutUser();
        $this->flash('success', 'You have been logged out.');
        $this->redirect(url('login'));
    }

    public function showForgotPassword(): void
    {
        $this->view('auth/forgot_password', ['title' => 'Forgot Password — ' . SITE_NAME]);
    }

    public function forgotPassword(): void
    {
        csrfCheck();
        // v1: no email sending — just show message. Flag for v2 with PHPMailer.
        $email = sanitize($this->post('email'));
        $this->flash('info', 'If that email is registered, password reset instructions will be sent. (Email sending requires v2 setup.)');
        $this->redirect(url('forgot-password'));
    }
}
