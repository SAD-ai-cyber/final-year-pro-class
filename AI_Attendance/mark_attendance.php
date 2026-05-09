<?php
ini_set('display_errors', 0);
error_reporting(0);
ob_start();

date_default_timezone_set('Asia/Kolkata');

require_once "../includes/security.php";
require_once "../includes/config.php";

// Security/session bootstrap.
start_secure_session();
// Apply security headers for this request.
send_security_headers();

function json_response($payload)
{
    if (ob_get_length()) {
        ob_clean();
    }
    header('Content-Type: application/json');
    echo json_encode($payload);
    exit;
}

// Security check
if (!isset($_SESSION['student_id'])) {
    json_response([
        "status" => "error",
        "message" => "Not logged in"
    ]);
}

$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    $input = [];
}
$attendance_type = $input['attendance_type'] ?? 'in'; // Default to 'in' for backward compatibility

if (!verify_csrf_token($input['csrf_token'] ?? '')) {
    json_response([
        "status" => "error",
        "message" => "Invalid request"
    ]);
}

$student_id = $_SESSION['student_id'];

// Verify student exists and get time slot
$verify_sql = "SELECT student_id, student_name, start_time, end_time FROM add_students WHERE student_id = ?";
$stmt = $con->prepare($verify_sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    json_response([
        "status" => "error",
        "message" => "Student record not found in system"
    ]);
}

$student = $result->fetch_assoc();
$start_time = $student['start_time'];
$end_time = $student['end_time'];

if ($start_time === null || $end_time === null || $start_time === '' || $end_time === '') {
    json_response([
        "status" => "error",
        "message" => "Attendance time slot not set"
    ]);
}

// Validate current time is within student's time slot
function parse_time_value($time)
{
    $dt = DateTime::createFromFormat('H:i:s', $time);
    if ($dt instanceof DateTime) {
        return $dt;
    }
    $dt = DateTime::createFromFormat('H:i', $time);
    if ($dt instanceof DateTime) {
        return $dt;
    }
    return null;
}

$now = new DateTime('now');
$start_dt = parse_time_value($start_time);
$end_dt = parse_time_value($end_time);

if (!$start_dt || !$end_dt) {
    json_response([
        "status" => "error",
        "message" => "Invalid attendance time slot"
    ]);
}

$start_dt->setDate((int) $now->format('Y'), (int) $now->format('m'), (int) $now->format('d'));
$end_dt->setDate((int) $now->format('Y'), (int) $now->format('m'), (int) $now->format('d'));

if ($end_dt < $start_dt) {
    $end_dt->modify('+1 day');
}

if ($now < $start_dt || $now > $end_dt) {
    $start_formatted = $start_dt->format('g:i A');
    $end_formatted = $end_dt->format('g:i A');
    json_response([
        "status" => "error",
        "message" => "Attendance can only be marked between $start_formatted and $end_formatted"
    ]);
}

// Block invalid attempts early (same day)
$today = date('Y-m-d');
$check_sql = "SELECT id, check_in_time, check_out_time FROM attendance_logs WHERE student_id = ? AND DATE(check_in_time) = ? LIMIT 1";
$stmt = $con->prepare($check_sql);
$stmt->bind_param("ss", $student_id, $today);
$stmt->execute();
$check_res = $stmt->get_result();
$attendance_status = $check_res->fetch_assoc();

if ($attendance_type === 'in' && $attendance_status) {
    json_response([
        "status" => "duplicate",
        "message" => "Check-In already marked today at " . date('g:i A', strtotime($attendance_status['check_in_time']))
    ]);
}

if ($attendance_type === 'out') {
    if (!$attendance_status) {
        json_response([
            "status" => "error",
            "message" => "Please Check-In first before marking Check-Out"
        ]);
    }
    if ($attendance_status['check_out_time']) {
        json_response([
            "status" => "duplicate",
            "message" => "Check-Out already marked today at " . date('g:i A', strtotime($attendance_status['check_out_time']))
        ]);
    }
    
    // Check 1-hour rule
    $check_in_ts = strtotime($attendance_status['check_in_time']);
    if ((time() - $check_in_ts) < 3600) {
        $wait_mins = 60 - floor((time() - $check_in_ts) / 60);
        json_response([
            "status" => "error",
            "message" => "Check-Out only allowed after 1 hour of Check-In ($wait_mins mins left)"
        ]);
    }
}

// Check if face is registered
$embedding_path = __DIR__ . "/face_engine/deep_learning/embeddings/" . $student_id . ".npy";

if (!file_exists($embedding_path)) {
    json_response([
        "status" => "error",
        "message" => "Face not registered"
    ]);
}

// Get paths (Cross-Platform)
$base_dir = dirname(__DIR__);
$is_windows = (PHP_OS_FAMILY === 'Windows');

$env_path = $base_dir . DIRECTORY_SEPARATOR . "face_attendance_env";
if ($is_windows) {
    $python = $env_path . DIRECTORY_SEPARATOR . "Scripts" . DIRECTORY_SEPARATOR . "python.exe";
} else {
    $python = $env_path . DIRECTORY_SEPARATOR . "bin" . DIRECTORY_SEPARATOR . "python";
}

$setup_script = __DIR__ . DIRECTORY_SEPARATOR . ($is_windows ? "setup.bat" : "setup.sh");
$script = __DIR__ . DIRECTORY_SEPARATOR . "face_engine" . DIRECTORY_SEPARATOR . "deep_learning" . DIRECTORY_SEPARATOR . "recognize.py";

// Auto-setup check
if (!file_exists($python)) {
    error_log("Python environment not found - triggering auto-setup");
    if ($is_windows) {
        shell_exec("\"$setup_script\"");
    } else {
        shell_exec("bash \"$setup_script\"");
    }
}

// Delete old result file if exists
$result_file = __DIR__ . "/face_engine/deep_learning/result.json";
if (file_exists($result_file)) {
    unlink($result_file);
}

$cmd = "\"$python\" \"$script\" \"$student_id\"";
$output = shell_exec($cmd . " 2>&1");

// If first execution failed to create result file, try auto-setup and retry
if (!file_exists($result_file)) {
    error_log("Result file not found - checking output for missing dependencies");
    
    // Only trigger heavy setup if output indicates missing modules or environment issues
    if (!$output || strpos(strtolower($output), "not found") !== false || strpos(strtolower($output), "no module") !== false) {
        error_log("Dependencies missing - triggering auto-setup");
        if ($is_windows) {
            shell_exec("\"$setup_script\"");
        } else {
            shell_exec("bash \"$setup_script\"");
        }
    }
    
    // Final retry attempt
    $output = shell_exec($cmd . " 2>&1");
}

// Wait for result file with timeout
$max_wait = 15; // 15 seconds max
$waited = 0;
while (!file_exists($result_file) && $waited < $max_wait) {
    sleep(1);
    $waited++;
}

// Read result.json
if (!file_exists($result_file)) {
    json_response([
        "status" => "error",
        "message" => "Recognition timeout - camera not responding"
    ]);
}

$result = json_decode(file_get_contents($result_file), true);

if (!$result) {
    json_response([
        "status" => "error",
        "message" => "Invalid recognition result"
    ]);
}

// Check if match and belongs to logged-in student
if ($result["status"] === "match" && $result["student_id"] == $student_id) {
    
    // Double check state inside the verification block to avoid race conditions
    $today = date('Y-m-d');
    $check_sql = "SELECT id, check_in_time, check_out_time FROM attendance_logs WHERE student_id = ? AND DATE(check_in_time) = ? LIMIT 1";
    $stmt = $con->prepare($check_sql);
    $stmt->bind_param("ss", $student_id, $today);
    $stmt->execute();
    $att_status = $stmt->get_result()->fetch_assoc();

    if ($attendance_type === 'in') {
        if ($att_status) {
            json_response(["status" => "duplicate", "message" => "Already checked in"]);
        }
        $insert_sql = "INSERT INTO attendance_logs (student_id, check_in_time, attendance_date) VALUES (?, NOW(), ?)";
        $stmt = $con->prepare($insert_sql);
        $stmt->bind_param("ss", $student_id, $today);
    } else {
        if (!$att_status) {
            json_response(["status" => "error", "message" => "No check-in record found"]);
        }
        if ($att_status['check_out_time']) {
            json_response(["status" => "duplicate", "message" => "Already checked out"]);
        }
        // One final check for 1-hour rule
        if ((time() - strtotime($att_status['check_in_time'])) < 3600) {
            json_response(["status" => "error", "message" => "1 hour not passed yet"]);
        }
        $insert_sql = "UPDATE attendance_logs SET check_out_time = NOW() WHERE id = ?";
        $stmt = $con->prepare($insert_sql);
        $stmt->bind_param("i", $att_status['id']);
    }
    
    if ($stmt->execute()) {
        $msg = ($attendance_type === 'in') ? "Check-In marked successfully" : "Check-Out marked successfully";
        json_response([
            "status" => "success",
            "message" => $msg,
            "distance" => isset($result['distance']) ? $result['distance'] : 'N/A',
            "lighting" => isset($result['lighting']) ? $result['lighting'] : 'unknown'
        ]);
    } else {
        json_response([
            "status" => "error",
            "message" => "Database error: " . $con->error
        ]);
    }
    exit;
}

// Handle error or mismatch
$error_msg = "Face verification failed";
if (isset($result['status']) && $result['status'] === 'error' && isset($result['message'])) {
    $error_msg = $result['message'];
}

json_response([
    "status" => "error",
    "message" => $error_msg,
    "distance" => isset($result['distance']) ? $result['distance'] : 'N/A',
    "threshold" => isset($result['threshold']) ? $result['threshold'] : 'N/A',
    "lighting" => isset($result['lighting']) ? $result['lighting'] : 'unknown'
]);
?>
