<?php
require 'config.php';
require 'security.php';

start_secure_session();

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

// Get raw POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data) {
    http_response_code(400);
    exit;
}

// Extract data
$page_url = mysqli_real_escape_string($con, $data['page_url'] ?? '');
$action_type = mysqli_real_escape_string($con, $data['action_type'] ?? '');
$element_text = mysqli_real_escape_string($con, $data['element_text'] ?? '');
$ip_address = $_SERVER['REMOTE_ADDR'];

// Determine User ID and Role from Session
$user_id = null;
$role = null;
$full_name = '';
$batch = '';

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
    
    // Map role to specific ID session variable
    switch ($role) {
        case 'admin':
            $user_id = $_SESSION['admin_id'] ?? 1; // Default admin ID
            break;
        case 'teacher':
            $user_id = $_SESSION['teacher_id'] ?? null;
            break;
        case 'student':
            $user_id = $_SESSION['student_id'] ?? null;
            break;
        case 'parent':
            $user_id = $_SESSION['parent_id'] ?? 0;
            break;
    }
}

// Prefer display_name from session when present
if (!empty($_SESSION['display_name'])) {
    $full_name = $_SESSION['display_name'];
}

// Safety: ensure we always insert a readable role/user so admin logs are easier to debug
if (empty($role)) $role = 'unknown';
$user_id = (int) ($user_id ?? 0);
if ($full_name === '') $full_name = '(Unknown)';

// If still empty, try to look up the user's name from the DB by role
if ($full_name === '') {
    $uid = (int)$user_id;
    if ($role === 'admin' && $uid > 0) {
        $r = mysqli_query($con, "SELECT admin_name FROM admins WHERE admin_id = $uid LIMIT 1");
        if ($r && $row = mysqli_fetch_assoc($r)) $full_name = $row['admin_name'] ?? '';
    } elseif ($role === 'teacher' && $uid > 0) {
        $r = mysqli_query($con, "SELECT teacher_name FROM add_teachers WHERE teacher_id = $uid LIMIT 1");
        if ($r && $row = mysqli_fetch_assoc($r)) $full_name = $row['teacher_name'] ?? '';
    } elseif ($role === 'student' && $uid > 0) {
        $r = mysqli_query($con, "SELECT student_name FROM add_students WHERE student_id = $uid LIMIT 1");
        if ($r && $row = mysqli_fetch_assoc($r)) $full_name = $row['student_name'] ?? '';
    } elseif ($role === 'parent' && $uid > 0) {
        $r = mysqli_query($con, "SELECT parent_name FROM add_parents WHERE parent_id = $uid LIMIT 1");
        if ($r && $row = mysqli_fetch_assoc($r)) $full_name = $row['parent_name'] ?? '';
    }
}

// Batch Ã¢â‚¬â€ prefer session value if present, otherwise leave empty (no reliable mapping available)
if (!empty($_SESSION['batch'])) $batch = $_SESSION['batch'];

// Final fallback for full_name: prefer session username/admin_name if DB lookups failed
if (empty($full_name)) {
    if (!empty($_SESSION['admin_name'])) $full_name = $_SESSION['admin_name'];
    elseif (!empty($_SESSION['teacher_name'])) $full_name = $_SESSION['teacher_name'];
    elseif (!empty($_SESSION['student_name'])) $full_name = $_SESSION['student_name'];
    elseif (!empty($_SESSION['username'])) $full_name = $_SESSION['username'];
}

// Ensure integers
$user_id = (int)$user_id;

// Insert into database (includes full_name and batch)
$page_url_safe = mysqli_real_escape_string($con, $page_url);
$action_type_safe = mysqli_real_escape_string($con, $action_type);
$element_text_safe = mysqli_real_escape_string($con, $element_text);
$full_name_safe = mysqli_real_escape_string($con, $full_name);
$batch_safe = mysqli_real_escape_string($con, $batch);

$sql = "INSERT INTO activity_logs (user_id, role, full_name, batch, page_url, action_type, element_text, ip_address) 
        VALUES ('$user_id', '$role', '$full_name_safe', '$batch_safe', '$page_url_safe', '$action_type_safe', '$element_text_safe', '$ip_address')";

if (mysqli_query($con, $sql)) {
    echo json_encode(['status' => 'success']);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => mysqli_error($con)]);
}
?>
