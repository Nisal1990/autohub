<?php
/**
 * AutoHub LK — Site Configuration
 */

// --- Site ---
define('SITE_NAME', 'AutoHub LK');
define('SITE_TAGLINE', 'Sri Lanka\'s #1 Auto Marketplace');
define('BASE_URL', 'http://localhost/autohub/public'); // No trailing slash
define('APP_ROOT', dirname(__DIR__));

// --- Database ---
define('DB_HOST', 'localhost');
define('DB_NAME', 'autohub_lk');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// --- Uploads ---
define('UPLOAD_PATH', APP_ROOT . '/uploads');
define('UPLOAD_URL', BASE_URL . '/../uploads'); // served via serve_image.php
define('MAX_IMAGE_SIZE', 5 * 1024 * 1024); // 5 MB
define('MAX_IMAGES_PER_LISTING', 8);
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp']);
define('ALLOWED_IMAGE_EXTS', ['jpg', 'jpeg', 'png', 'webp']);

// --- Pagination ---
define('LISTINGS_PER_PAGE', 12);
define('ADMIN_ROWS_PER_PAGE', 20);

// --- Session ---
define('SESSION_LIFETIME', 3600 * 8); // 8 hours

// --- Currency ---
define('CURRENCY_SYMBOL', 'Rs.');

// --- Email (basic — no PHPMailer in v1) ---
define('ADMIN_EMAIL', 'admin@autohub.lk');

// --- Environment ---
define('APP_ENV', 'development'); // 'production' on live
define('APP_DEBUG', true);

// Error display based on environment
if (APP_DEBUG) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// Timezone
date_default_timezone_set('Asia/Colombo');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => SESSION_LIFETIME,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}
