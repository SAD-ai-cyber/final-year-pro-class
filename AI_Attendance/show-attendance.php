<?php
require '../includes/security.php';

// Security/session bootstrap.
start_secure_session();
// Apply security headers for this request.
send_security_headers();

// Check if user is admin or teacher
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        // For admin, show admin_view_attendance
        $_SESSION['admin_id'] = $_SESSION['admin_id'] ?? 1; // Set admin_id if not set
        require_once "admin_view_attendance.php";
    } elseif ($_SESSION['role'] === 'teacher') {
        // For teacher, also show admin_view_attendance (with teacher conditions)
        $_SESSION['teacher_id'] = $_SESSION['teacher_id'] ?? $_SESSION['username'];
        require_once "admin_view_attendance.php";
    } elseif ($_SESSION['role'] === 'parent') {
        // For parent, show student's view_attendance (child data)
        require_once "view_attendance.php";
    } else {
        echo "Unauthorized access";
    }
} else {
    echo "Please login first";
}
?>
