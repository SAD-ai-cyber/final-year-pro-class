<?php
// On-demand reminder trigger for logged-in students.
require 'security.php';
require 'config.php';
require 'notification_helper.php';

// Security/session bootstrap.
start_secure_session();
// Apply security headers for this request.
send_security_headers();

header('Content-Type: application/json');

// Enforce active session for access.
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    echo json_encode(['status' => 'unauthorized']);
    exit;
}

if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
    echo json_encode(['status' => 'invalid_csrf']);
    exit;
}

$student_id = isset($_SESSION['student_id']) ? (int) $_SESSION['student_id'] : 0;
if ($student_id <= 0) {
    echo json_encode(['status' => 'unauthorized']);
    exit;
}

$now = new DateTime('now');
$today = $now->format('Y-m-d');
$current_time = $now->format('H:i:s');

$reminders = [
    'attendance' => false,
    'exam' => false
];

// Attendance reminder (only once per day within time window)
$stmt = $con->prepare('SELECT start_time, end_time FROM add_students WHERE student_id = ? LIMIT 1');
if ($stmt) {
    $stmt->bind_param('i', $student_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res ? $res->fetch_assoc() : null;
    $stmt->close();

    if ($row) {
        $start_time = (string) $row['start_time'];
        $end_time = (string) $row['end_time'];

        if ($start_time !== '' && $end_time !== '') {
            if ($current_time >= $start_time && $current_time <= $end_time) {
                $check = $con->prepare('SELECT id FROM attendance_logs WHERE student_id = ? AND DATE(check_in_time) = ? LIMIT 1');
                if ($check) {
                    $check->bind_param('is', $student_id, $today);
                    $check->execute();
                    $check->store_result();
                    $already_marked = $check->num_rows > 0;
                    $check->close();

                    if (!$already_marked) {
                        $title = 'Attendance Reminder';
                        $link = 'AI_Attendance/mark_attendance_page.php';
                        if (!notificationExistsForUser($con, 'student', $student_id, $title, $link, $today)) {
                            $start_label = date('g:i A', strtotime($start_time));
                            $end_label = date('g:i A', strtotime($end_time));
                            $message = "Attendance window: {$start_label} - {$end_label}";
                            if (sendNotification($con, 'student', $student_id, $title, $message, $link)) {
                                $reminders['attendance'] = true;
                            }
                        }
                    }
                }
            }
        }
    }
}

// Exam reminder (when exam time has arrived, avoid duplicates)
$exam_stmt = $con->prepare(
    "SELECT exam_id, course_name, subject, exam_date
     FROM student_exams
     WHERE student_id = ?
       AND status = 'Pending'
       AND exam_date <= NOW()
       AND exam_date >= DATE_SUB(NOW(), INTERVAL 1 DAY)"
);
if ($exam_stmt) {
    $student_id_str = (string) $student_id;
    $exam_stmt->bind_param('s', $student_id_str);
    $exam_stmt->execute();
    $exam_res = $exam_stmt->get_result();
    while ($exam_res && ($exam = $exam_res->fetch_assoc())) {
        $exam_id = (int) $exam['exam_id'];
        $course = trim((string) $exam['course_name']);
        $subject = trim((string) $exam['subject']);
        $link = 'exam-section/student_take_exam.php?exam_id=' . $exam_id;
        $title = 'MCQ Exam Reminder';

        if (!notificationExistsForUser($con, 'student', $student_id, $title, $link)) {
            $label_parts = [];
            if ($course !== '') {
                $label_parts[] = $course;
            }
            if ($subject !== '') {
                $label_parts[] = $subject;
            }
            $label = !empty($label_parts) ? implode(' - ', $label_parts) : 'Your exam';
            $message = $label . ' is now live. Please start your exam.';
            if (sendNotification($con, 'student', $student_id, $title, $message, $link)) {
                $reminders['exam'] = true;
            }
        }
    }
    $exam_stmt->close();
}

echo json_encode(['status' => 'success', 'reminders' => $reminders]);
