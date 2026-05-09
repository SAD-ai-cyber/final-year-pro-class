<?php
// Start session with safe cookie settings
function start_secure_session()
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    // HTTPS check - also handle Railway/proxy X-Forwarded-Proto header
    $is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443)
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');

    ini_set('session.use_only_cookies', '1');
    ini_set('session.use_strict_mode', '1');

    $params = session_get_cookie_params();
    $cookie = [
        'lifetime' => 0,
        'path' => $params['path'] ?? '/',
        'domain' => $params['domain'] ?? '',
        'secure' => $is_https,
        'httponly' => true,
        'samesite' => 'Lax',  // Changed from Strict to Lax for Railway proxy compatibility
    ];

    session_set_cookie_params($cookie);

    if ($is_https) {
        ini_set('session.cookie_secure', '1');
    }

    session_start();
}

// Common security headers for pages
function send_security_headers()
{
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: geolocation=(), microphone=(), camera=()');
    header('Cross-Origin-Opener-Policy: same-origin');
    header('Cross-Origin-Resource-Policy: same-origin');

    $csp = "default-src 'self' https: data: blob:; "
        . "img-src 'self' https: data: blob:; "
        . "script-src 'self' https: 'unsafe-inline' blob:; "
        . "script-src-elem 'self' https: 'unsafe-inline' blob:; "
        . "script-src-attr 'self' 'unsafe-inline'; "
        . "style-src 'self' https: 'unsafe-inline'; "
        . "font-src 'self' https: data:; "
        . "frame-ancestors 'self'; "
        . "base-uri 'self'; "
        . "form-action 'self'";
    header('Content-Security-Policy: ' . $csp);
}

// Backwards-compatible alias
function apply_security_headers()
{
// Apply security headers for this request.
    send_security_headers();
}

// Simple role-based guard
function require_role($role, $redirect = '../login.php')
{
// Enforce active session for access.
    if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
        header('Location: ' . $redirect);
        exit;
    }

    $current_role = $_SESSION['role'];
    $allowed = is_array($role) ? $role : [$role];
    if (!in_array($current_role, $allowed, true)) {
        header('Location: ' . $redirect);
        exit;
    }
}

// Create or reuse CSRF token
function csrf_token()
{
    if (empty($_SESSION['csrf_token']) || empty($_SESSION['csrf_token_time'])
        || (time() - (int) $_SESSION['csrf_token_time']) > 3600
    ) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_token_time'] = time();
    }

    return $_SESSION['csrf_token'];
}

// Backwards-compatible alias
function generate_csrf_token()
{
    return csrf_token();
}

// Check CSRF token
function verify_csrf_token($token)
{
    return isset($_SESSION['csrf_token'])
        && is_string($token)
        && hash_equals($_SESSION['csrf_token'], $token);
}

// Require valid CSRF token on POST
function require_post_csrf()
{
// Handle request mode checks.
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return;
    }

    $token = $_POST['csrf_token'] ?? '';
    if (!verify_csrf_token($token)) {
        http_response_code(400);
        echo 'Invalid request.';
        exit;
    }
}

// Verify password and upgrade legacy plain text to hash
function verify_and_upgrade_password($con, $table, $id_field, $id, $input, $stored_hash)
{
    if (!is_string($input) || !is_string($stored_hash)) {
        return false;
    }

    if (password_verify($input, $stored_hash)) {
        return true;
    }

    $info = password_get_info($stored_hash);
    if ($info['algo'] !== 0 || !hash_equals($stored_hash, $input)) {
        return false;
    }

    $allowed_tables = [
        'admins' => 'admin_id',
        'add_teachers' => 'teacher_id',
        'add_parents' => 'parent_id',
        'add_students' => 'student_id',
    ];

    if (!isset($allowed_tables[$table]) || $allowed_tables[$table] !== $id_field) {
        return false;
    }

    $new_hash = password_hash($input, PASSWORD_DEFAULT);
    $sql = "UPDATE {$table} SET password_hash = ? WHERE {$id_field} = ?";
    $stmt = $con->prepare($sql);
    if ($stmt) {
        $id_val = (int) $id;
        $stmt->bind_param('si', $new_hash, $id_val);
        $stmt->execute();
        $stmt->close();
    }

    return true;
}

// Simple file upload helper (returns ['ok' => bool, 'filename' => '', 'error' => ''])
function upload_file_simple($file, $target_dir, $allowed_exts, $max_bytes, $prefix = '')
{
    $result = ['ok' => false, 'filename' => '', 'error' => ''];

    if (!isset($file) || !isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        $result['error'] = 'No file uploaded.';
        return $result;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $result['error'] = 'Upload error.';
        return $result;
    }

    if ($file['size'] > $max_bytes) {
        $result['error'] = 'File too large.';
        return $result;
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed_exts, true)) {
        $result['error'] = 'Invalid file type.';
        return $result;
    }

    $base = pathinfo($file['name'], PATHINFO_FILENAME);
    $base = preg_replace('/[^A-Za-z0-9_\-]/', '_', $base);
    $base = preg_replace('/_+/', '_', $base);
    $base = trim($base, '_');
    if ($base === '') {
        $base = 'file';
    }

    $new_name = $prefix . time() . '_' . $base . '.' . $ext;
    $target = rtrim($target_dir, '/\\') . DIRECTORY_SEPARATOR . $new_name;

    if (!move_uploaded_file($file['tmp_name'], $target)) {
        $result['error'] = 'Failed to save file.';
        return $result;
    }

    $result['ok'] = true;
    $result['filename'] = $new_name;
    return $result;
}

function generate_random_password($length = 10)
{
    $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789!@#$%';
    $out = '';
    $max = strlen($chars) - 1;
    for ($i = 0; $i < $length; $i++) {
        $out .= $chars[random_int(0, $max)];
    }
    return $out;
}

function append_password_csv($file_path, $headers, $rows)
{
    $dir = dirname($file_path);
    if (!is_dir($dir)) {
        if (!mkdir($dir, 0775, true) && !is_dir($dir)) {
            return false;
        }
    }

    $is_new = !file_exists($file_path);
    $fh = fopen($file_path, 'a');
    if (!$fh) {
        return false;
    }

    if ($is_new) {
        fputcsv($fh, $headers);
    }

    foreach ($rows as $row) {
        fputcsv($fh, $row);
    }

    fclose($fh);
    return true;
}

function ensure_extra_tables($con, $role_prefix)
{
    $fields_table = $role_prefix . '_extra_fields';
    $values_table = $role_prefix . '_extra_values';
    $id_field = $role_prefix . '_id';

    $fields_sql = "CREATE TABLE IF NOT EXISTS `{$fields_table}` ("
        . " `field_id` int(11) NOT NULL AUTO_INCREMENT,"
        . " `field_key` varchar(100) NOT NULL,"
        . " `field_label` varchar(150) NOT NULL,"
        . " `created_at` timestamp NOT NULL DEFAULT current_timestamp(),"
        . " PRIMARY KEY (`field_id`),"
        . " UNIQUE KEY `uniq_{$fields_table}_key` (`field_key`)"
        . ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

    $values_sql = "CREATE TABLE IF NOT EXISTS `{$values_table}` ("
        . " `{$id_field}` int(11) NOT NULL,"
        . " `field_id` int(11) NOT NULL,"
        . " `field_value` text DEFAULT NULL,"
        . " PRIMARY KEY (`{$id_field}`, `field_id`),"
        . " KEY `idx_{$values_table}_field` (`field_id`)"
        . ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

    mysqli_query($con, $fields_sql);
    mysqli_query($con, $values_sql);

    return [$fields_table, $values_table, $id_field];
}

// Write auth debug logs in development only
function auth_debug_log($message)
{
    $app_env = getenv('APP_ENV') ?: 'development';
    if ($app_env === 'production') {
        return;
    }

    $log_dir = __DIR__ . '/../material_upload';
    $log_file = $log_dir . '/auth_debug.log';
    $line = date('Y-m-d H:i:s') . ' ' . $message . "\n";
    @file_put_contents($log_file, $line, FILE_APPEND);
}

