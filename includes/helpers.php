<?php
/**
 * AutoHub LK — Helper Functions
 */

// ─── CSRF ────────────────────────────────────────────────────────────────────

function generateCsrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken(string $token): bool
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(generateCsrfToken()) . '">';
}

function csrfCheck(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!verifyCsrfToken($token)) {
        http_response_code(403);
        die('Invalid CSRF token. Please go back and try again.');
    }
}

// ─── SANITIZE / ESCAPE ───────────────────────────────────────────────────────

function e(string|null $str): string
{
    return htmlspecialchars((string)$str, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function sanitize(string $str): string
{
    return trim(strip_tags($str));
}

// ─── FORMATTING ──────────────────────────────────────────────────────────────

function formatPrice(float|int $amount): string
{
    return CURRENCY_SYMBOL . ' ' . number_format($amount, 0, '.', ',');
}

function formatDate(string $dateStr): string
{
    return date('d M Y', strtotime($dateStr));
}

function timeAgo(string $dateStr): string
{
    $diff = time() - strtotime($dateStr);
    if ($diff < 60)       return 'Just now';
    if ($diff < 3600)     return floor($diff / 60) . 'm ago';
    if ($diff < 86400)    return floor($diff / 3600) . 'h ago';
    if ($diff < 604800)   return floor($diff / 86400) . 'd ago';
    return formatDate($dateStr);
}

// ─── VALIDATION ──────────────────────────────────────────────────────────────

function validateSriLankaPhone(string $phone): bool
{
    // Accepts: +94XXXXXXXXX, 0XXXXXXXXX (9 or 10 digits after prefix)
    return (bool) preg_match('/^(?:\+94|0)[0-9]{9}$/', preg_replace('/[\s\-]/', '', $phone));
}

function validateEmail(string $email): bool
{
    return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
}

// ─── IMAGES ──────────────────────────────────────────────────────────────────

/**
 * Handle a single image upload.
 *
 * @param array  $file     $_FILES element
 * @param string $subdir   'vehicles' | 'parts' | 'services'
 * @return string|false    Relative path stored in DB (e.g. vehicles/abc123.jpg) or false on failure
 */
function uploadImage(array $file, string $subdir): string|false
{
    if ($file['error'] !== UPLOAD_ERR_OK) return false;
    if ($file['size'] > MAX_IMAGE_SIZE) return false;

    // Verify MIME type via finfo (not just extension)
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime, ALLOWED_IMAGE_TYPES, true)) return false;

    $ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ALLOWED_IMAGE_EXTS, true)) return false;

    $filename = bin2hex(random_bytes(16)) . '.' . $ext;
    $destDir  = UPLOAD_PATH . '/' . $subdir;

    if (!is_dir($destDir)) {
        mkdir($destDir, 0755, true);
    }

    $destPath = $destDir . '/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destPath)) return false;

    return $subdir . '/' . $filename;
}

/**
 * Get the public URL for a stored image path.
 */
function imageUrl(string|null $path, string $placeholder = ''): string
{
    if (empty($path)) {
        return $placeholder ?: BASE_URL . '/assets/images/placeholder.jpg';
    }
    return BASE_URL . '/../uploads/' . ltrim($path, '/');
}

// ─── PAGINATION ──────────────────────────────────────────────────────────────

function paginate(int $total, int $perPage, int $currentPage): array
{
    $totalPages = max(1, (int) ceil($total / $perPage));
    $currentPage = max(1, min($currentPage, $totalPages));
    $offset = ($currentPage - 1) * $perPage;

    return [
        'total'       => $total,
        'per_page'    => $perPage,
        'current'     => $currentPage,
        'total_pages' => $totalPages,
        'offset'      => $offset,
        'has_prev'    => $currentPage > 1,
        'has_next'    => $currentPage < $totalPages,
        'prev'        => $currentPage - 1,
        'next'        => $currentPage + 1,
    ];
}

// ─── FLASH MESSAGES ──────────────────────────────────────────────────────────

function flashGet(): array
{
    $flash = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $flash;
}

// ─── URL HELPERS ─────────────────────────────────────────────────────────────

function url(string $path = ''): string
{
    return BASE_URL . '/' . ltrim($path, '/');
}

function currentUrl(): string
{
    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http')
        . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

function buildQuery(array $params): string
{
    return http_build_query(array_filter($params, fn($v) => $v !== '' && $v !== null));
}

// ─── STATUS BADGES ───────────────────────────────────────────────────────────

function statusBadge(string $status): string
{
    $map = [
        'pending'  => ['warning',   'Pending Review'],
        'approved' => ['success',   'Approved'],
        'rejected' => ['danger',    'Rejected'],
        'sold'     => ['secondary', 'Sold'],
        'sold_out' => ['secondary', 'Sold Out'],
        'expired'  => ['dark',      'Expired'],
        'active'   => ['success',   'Active'],
        'suspended'=> ['danger',    'Suspended'],
    ];
    [$color, $label] = $map[$status] ?? ['light', ucfirst($status)];
    return '<span class="badge bg-' . $color . '">' . e($label) . '</span>';
}

// ─── MISC ────────────────────────────────────────────────────────────────────

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

function truncate(string $text, int $length = 120): string
{
    if (mb_strlen($text) <= $length) return $text;
    return mb_substr($text, 0, $length) . '…';
}

function selectedIf(mixed $a, mixed $b): string
{
    return $a == $b ? ' selected' : '';
}

function checkedIf(mixed $a, mixed $b): string
{
    return $a == $b ? ' checked' : '';
}
