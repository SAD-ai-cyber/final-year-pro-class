<?php
require '../includes/security.php';
require '../includes/config.php';

// Security/session bootstrap.
start_secure_session();
// Apply security headers for this request.
send_security_headers();
// Enforce role-based access control.
require_role(['admin', 'teacher'], 'show_exams.php');

if (!verify_csrf_token($_GET['csrf_token'] ?? '')) {
    die('Invalid CSRF token.');
}

$exam_id = isset($_GET['exam_id']) ? (int) $_GET['exam_id'] : 0;
if ($exam_id <= 0) {
    header("Location: show_exams.php");
    exit;
}

$stmt = $con->prepare("DELETE FROM student_exams WHERE exam_id = ?");
$stmt->bind_param("i", $exam_id);
$stmt->execute();
$stmt->close();

header("Location: show_exams.php");
exit;
