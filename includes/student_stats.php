<?php
require 'security.php';
require 'config.php';

// Security/session bootstrap.
start_secure_session();
// Apply security headers for this request.
send_security_headers();

header('Content-Type: application/json');

// Enforce active session for access.
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student' || !isset($_SESSION['student_id'])) {
    echo json_encode(['status' => 'unauthorized']);
    exit;
}

$student_id = (int) $_SESSION['student_id'];
$attendance_days = 0;
$attendance_percent = 0;
$pending_homework = 0;
$next_exam_label = 'N/A';
$last_result_label = '-';

// Attendance (last 30 days)
$stmt = $con->prepare(
    "SELECT COUNT(DISTINCT attendance_date) AS days
     FROM attendance_logs
     WHERE student_id = ?
       AND attendance_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)"
);
$sid_str = (string) $student_id;
$stmt->bind_param("s", $sid_str);
$stmt->execute();
$res = $stmt->get_result();
if ($row = $res->fetch_assoc()) {
    $attendance_days = (int) $row['days'];
}
$stmt->close();
$attendance_percent = (int) round(($attendance_days / 30) * 100);
if ($attendance_percent < 0) {
    $attendance_percent = 0;
} elseif ($attendance_percent > 100) {
    $attendance_percent = 100;
}

// Homework Due = Pending Exams count
$stmt = $con->prepare(
    "SELECT COUNT(*) AS cnt
     FROM student_exams
     WHERE student_id = ?
       AND status = 'Pending'"
);
$stmt->bind_param("s", $sid_str);
$stmt->execute();
$res = $stmt->get_result();
if ($row = $res->fetch_assoc()) {
    $pending_homework = (int) $row['cnt'];
}
$stmt->close();

// Next Exam (nearest pending)
$stmt = $con->prepare(
    "SELECT exam_date
     FROM student_exams
     WHERE student_id = ?
       AND status = 'Pending'
     ORDER BY exam_date ASC
     LIMIT 1"
);
$stmt->bind_param("s", $sid_str);
$stmt->execute();
$res = $stmt->get_result();
if ($row = $res->fetch_assoc()) {
    $next_exam_label = date('d M', strtotime($row['exam_date']));
}
$stmt->close();

// Last Result
$stmt = $con->prepare(
    "SELECT grade, result_status
     FROM add_result
     WHERE Student_ID = ?
     ORDER BY upload_date DESC
     LIMIT 1"
);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$res = $stmt->get_result();
if ($row = $res->fetch_assoc()) {
    $grade = trim((string) $row['grade']);
    $status = trim((string) $row['result_status']);
    if ($grade !== '') {
        $last_result_label = $grade;
    } elseif ($status !== '') {
        $last_result_label = $status;
    }
}
$stmt->close();

echo json_encode([
    'status' => 'success',
    'attendance_percent' => $attendance_percent,
    'pending_homework' => $pending_homework,
    'next_exam_label' => $next_exam_label,
    'last_result_label' => $last_result_label
]);
