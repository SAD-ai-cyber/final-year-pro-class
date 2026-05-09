<?php
// Start output buffering to catch any unwanted warnings/notices
ob_start();

header('Content-Type: application/json');

// Disable error display immediately
error_reporting(E_ALL);
ini_set('display_errors', 0);
set_time_limit(120); // Increase timeout to 2 minutes

require '../includes/security.php';
require_once '../includes/config.php';
require_once '../includes/device_helper.php';

// Security/session bootstrap.
start_secure_session();

// Check Device Permission (Strict Backend enforcement)
$device_status = check_device_permission($con);
if ($device_status !== 'allowed') {
    send_json([
        "status" => "error",
        "message" => "Unauthorized Device. Please connect from an approved kiosk."
    ]);
}

// Function to send JSON response cleanly
function send_json($data) {
    // Clear any previous buffer content
    ob_end_clean();
    echo json_encode($data);
    exit;
}

// =================================================
// AUTH CHECK
// =================================================
if (!isset($_SESSION['student_id'])) {
    send_json([
        "status" => "error",
        "message" => "Not logged in"
    ]);
}

$student_id = $_SESSION['student_id'];

// =================================================
// DUPLICATE CHECK
// =================================================
$existing_file = __DIR__ . "/face_engine/deep_learning/embeddings/" . $student_id . ".npy";
if (file_exists($existing_file)) {
    send_json([
        "status" => "success",
        "message" => "Face already registered! Reloading...",
        "student_id" => $student_id
    ]);
}

// =================================================
// ACTION CHECK (FROM REGISTER BUTTON)
// =================================================
if ($_SERVER['REQUEST_METHOD'] !== 'POST' ||
    !isset($_POST['action']) ||
    $_POST['action'] !== 'register') {

    send_json([
        "status" => "error",
        "message" => "Invalid request"
    ]);
}

if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
    send_json([
        "status" => "error",
        "message" => "Invalid request"
    ]);
}

// =================================================
// PATHS (Cross-Platform)
// =================================================
$base_dir = dirname(__DIR__);
$is_windows = (PHP_OS_FAMILY === 'Windows');

// Virtualenv path detection
$env_path = $base_dir . DIRECTORY_SEPARATOR . "face_attendance_env";
if ($is_windows) {
    $python = $env_path . DIRECTORY_SEPARATOR . "Scripts" . DIRECTORY_SEPARATOR . "python.exe";
} else {
    $python = $env_path . DIRECTORY_SEPARATOR . "bin" . DIRECTORY_SEPARATOR . "python";
}

$setup_script = __DIR__ . DIRECTORY_SEPARATOR . ($is_windows ? "setup.bat" : "setup.sh");
$script = __DIR__ . DIRECTORY_SEPARATOR . "face_engine" . DIRECTORY_SEPARATOR . "deep_learning" . DIRECTORY_SEPARATOR . "register_face.py";

// =================================================
// AUTO-SETUP CHECK (First time or missing dependencies)
// =================================================
$needs_setup = false;

// Check if environment doesn't exist
if (!file_exists($python)) {
    error_log("Python environment not found - will trigger auto-setup");
    // Run setup if python is missing
    if ($is_windows) {
        shell_exec("\"$setup_script\"");
    } else {
        shell_exec("bash \"$setup_script\"");
    }
    $needs_setup = true;
}

// =================================================
// COMMAND
// =================================================
// Construct command to run python script directly
$cmd = "\"$python\" \"$script\" \"$student_id\"";

// =================================================
// EXECUTE & CAPTURE STDOUT
// =================================================
$output = shell_exec($cmd . " 2>&1");
$output = trim($output);

// Log raw output for debugging
error_log("Raw output from register script: " . $output);

// Extract JSON from output - Look for the LAST matching {} pair
// This handles cases where some noise might still be printed before the final JSON
$last_brace = strrpos($output, '}');
if ($last_brace !== false) {
    // Find the matching opening brace by walking backwards or assume it's valid JSON
    // A simpler robust way: find the *last* occurrence of "{" before the last "}"
    $json_candidate = substr($output, 0, $last_brace + 1);
    $first_brace = strrpos($json_candidate, '{');
    
    if ($first_brace !== false) {
        $json_str = substr($json_candidate, $first_brace);
        $result = json_decode($json_str, true);
    } else {
        $result = null;
    }
} else {
    $result = null;
}

if ($result === null || json_last_error() !== JSON_ERROR_NONE) {
    error_log("JSON decode error: " . json_last_error_msg());
    error_log("Output was: " . $output);
    
    // Fallback: If no valid JSON, return error with raw output
    send_json([
        "status" => "error",
        "message" => "Invalid response from Face Engine",
        "debug" => substr($output, 0, 200) // Send first 200 chars for debugging
    ]);
}

// Check if Python itself returned an error status
if (isset($result['status']) && $result['status'] === 'error') {
     send_json($result);
}


// =================================================
// SUCCESS
// =================================================
send_json($result);
