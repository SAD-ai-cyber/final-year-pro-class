<?php
require 'security.php';
require 'config.php';

// Start secure session
start_secure_session();

// Check if user is logged in as parent
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'parent') {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$parent_email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$child_id = 0;

// Get Child ID
if (!empty($parent_email)) {
    $stmt = $con->prepare(
        "SELECT Student_ID AS student_id FROM add_result WHERE parent_email = ?
         UNION
         SELECT student_id AS student_id FROM student_fees WHERE parent_email = ?
         LIMIT 1"
    );
    if ($stmt) {
        $stmt->bind_param("ss", $parent_email, $parent_email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            $child_id = (int) $row['student_id'];
        }
        $stmt->close();
    }
}

$present_days = 0;
$fees_due = 0.00;
$latest_grade = '-';
$remarks_count = 0;

if ($child_id > 0) {
    $sid_str = (string) $child_id;

    // Attendance (last 30 days)
    $stmt = $con->prepare(
        "SELECT COUNT(DISTINCT attendance_date) AS days
         FROM attendance_logs
         WHERE student_id = ?
           AND attendance_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)"
    );
    if ($stmt) {
        $stmt->bind_param("s", $sid_str);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            $present_days = (int) $row['days'];
        }
        $stmt->close();
    }

    // Fees due (latest)
    $stmt = $con->prepare(
        "SELECT remaining_price FROM student_fees
         WHERE parent_email = ?
         ORDER BY created_at DESC
         LIMIT 1"
    );
    if ($stmt) {
        $stmt->bind_param("s", $parent_email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            $fees_due = (float) $row['remaining_price'];
        }
        $stmt->close();
    }

    // Latest grade/result
    $stmt = $con->prepare(
        "SELECT grade, result_status
         FROM add_result
         WHERE parent_email = ?
         ORDER BY upload_date DESC
         LIMIT 1"
    );
    if ($stmt) {
        $stmt->bind_param("s", $parent_email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            $grade = trim((string) $row['grade']);
            $status = trim((string) $row['result_status']);
            $latest_grade = $grade !== '' ? $grade : ($status !== '' ? $status : '-');
        }
        $stmt->close();
    }

    // Teacher remarks count
    $stmt = $con->prepare(
        "SELECT COUNT(*) AS cnt
         FROM add_result
         WHERE parent_email = ?
           AND instructor_comments IS NOT NULL
           AND instructor_comments <> ''"
    );
    if ($stmt) {
        $stmt->bind_param("s", $parent_email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            $remarks_count = (int) $row['cnt'];
        }
        $stmt->close();
    }
}

header('Content-Type: application/json');
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
echo json_encode([
    'status' => 'success',
    'present_days' => $present_days,
    'fees_due' => number_format($fees_due, 2),
    'latest_grade' => htmlspecialchars($latest_grade),
    'remarks_count' => $remarks_count
]);
exit;
?>
