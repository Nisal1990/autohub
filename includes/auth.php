<?php
/**
 * AutoHub LK — Auth Helpers
 */

function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function isAdmin(): bool
{
    return isLoggedIn() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function currentUser(): array|null
{
    if (!isLoggedIn()) return null;
    return [
        'id'    => $_SESSION['user_id'],
        'name'  => $_SESSION['user_name'] ?? '',
        'email' => $_SESSION['user_email'] ?? '',
        'role'  => $_SESSION['user_role'] ?? 'user',
    ];
}

function requireLogin(string $redirectTo = ''): void
{
    if (!isLoggedIn()) {
        $redirect = $redirectTo ?: BASE_URL . '/login';
        $_SESSION['intended_url'] = $_SERVER['REQUEST_URI'] ?? '';
        header('Location: ' . $redirect);
        exit;
    }
}

function requireAdmin(): void
{
    if (!isAdmin()) {
        if (!isLoggedIn()) {
            header('Location: ' . BASE_URL . '/admin/login');
        } else {
            header('Location: ' . BASE_URL . '/');
        }
        exit;
    }
}

function loginUser(array $user): void
{
    session_regenerate_id(true);
    $_SESSION['user_id']    = $user['id'];
    $_SESSION['user_name']  = $user['name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_role']  = $user['role'];
}

function logoutUser(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }
    session_destroy();
}
