<?php
require 'security.php';
require 'config.php';

// Start secure session and headers for this endpoint
start_secure_session();
// Apply security headers for this request.
send_security_headers();

function resolve_role_from_session()
{
    if (isset($_SESSION['role']) && is_string($_SESSION['role'])) {
        $role = strtolower(trim((string) $_SESSION['role']));
        if ($role !== '') {
            return $role;
        }
    }

    if (isset($_SESSION['admin_id'])) {
        return 'admin';
    }
    if (isset($_SESSION['teacher_id'])) {
        return 'teacher';
    }
    if (isset($_SESSION['parent_id']) || isset($_SESSION['email'])) {
        return 'parent';
    }
    if (isset($_SESSION['student_id'])) {
        return 'student';
    }

    return '';
}

function resolve_user_id($con, $role)
{
    if ($role === 'admin') {
        if (isset($_SESSION['admin_id'])) {
            return (int) $_SESSION['admin_id'];
        }
        $identifier = trim((string) ($_SESSION['username'] ?? ''));
        if ($identifier === '') {
            return 0;
        }
        $numeric_id = ctype_digit($identifier) ? (int) $identifier : -1;
        $stmt = $con->prepare('SELECT admin_id FROM admins WHERE admin_name = ? OR admin_id = ? LIMIT 1');
        if ($stmt) {
            $stmt->bind_param('si', $identifier, $numeric_id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res && ($row = $res->fetch_assoc())) {
                $stmt->close();
                return (int) $row['admin_id'];
            }
            $stmt->close();
        }
        return 0;
    }

    if ($role === 'teacher') {
        if (isset($_SESSION['teacher_id'])) {
            return (int) $_SESSION['teacher_id'];
        }
        $identifier = trim((string) ($_SESSION['username'] ?? ''));
        if ($identifier === '') {
            return 0;
        }
        $numeric_id = ctype_digit($identifier) ? (int) $identifier : -1;
        $stmt = $con->prepare('SELECT teacher_id FROM add_teachers WHERE teacher_name = ? OR teacher_email = ? OR teacher_id = ? LIMIT 1');
        if ($stmt) {
            $stmt->bind_param('ssi', $identifier, $identifier, $numeric_id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res && ($row = $res->fetch_assoc())) {
                $stmt->close();
                return (int) $row['teacher_id'];
            }
            $stmt->close();
        }
        return 0;
    }

    if ($role === 'parent') {
        if (isset($_SESSION['parent_id'])) {
            return (int) $_SESSION['parent_id'];
        }
        $identifier = trim((string) ($_SESSION['email'] ?? ($_SESSION['username'] ?? '')));
        if ($identifier === '') {
            return 0;
        }
        $numeric_id = ctype_digit($identifier) ? (int) $identifier : -1;
        $stmt = $con->prepare('SELECT parent_id FROM add_parents WHERE parent_email = ? OR parent_name = ? OR parent_id = ? LIMIT 1');
        if ($stmt) {
            $stmt->bind_param('ssi', $identifier, $identifier, $numeric_id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res && ($row = $res->fetch_assoc())) {
                $stmt->close();
                return (int) $row['parent_id'];
            }
            $stmt->close();
        }
        return 0;
    }

    if ($role === 'student') {
        if (isset($_SESSION['student_id'])) {
            return (int) $_SESSION['student_id'];
        }
        $identifier = trim((string) ($_SESSION['username'] ?? ''));
        if ($identifier === '') {
            return 0;
        }
        $numeric_id = ctype_digit($identifier) ? (int) $identifier : -1;
        $stmt = $con->prepare('SELECT student_id FROM add_students WHERE student_email = ? OR student_num = ? OR student_id = ? LIMIT 1');
        if ($stmt) {
            $stmt->bind_param('ssi', $identifier, $identifier, $numeric_id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res && ($row = $res->fetch_assoc())) {
                $stmt->close();
                return (int) $row['student_id'];
            }
            $stmt->close();
        }
    }

    return 0;
}

//  AUTH CHECK
$role = resolve_role_from_session();
if ($role === '') {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'unauthorized']);
    exit;
}

$user_id = resolve_user_id($con, $role);
if ($user_id <= 0) {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'unauthorized']);
    exit;
}


//  SINGLE NOTIFICATION READ 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

    header('Content-Type: application/json');

    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        echo json_encode(['status' => 'invalid_csrf']);
        exit;
    }

    $notification_id = (int) $_POST['id'];

    // mark single notification as read (SECURE)
        $stmt = $con->prepare(
                "UPDATE notifications
                 SET is_read = 1
                 WHERE id = ?
                     AND user_role = ?
                     AND user_id = ?"
        );
        $stmt->bind_param("isi", $notification_id, $role, $user_id);
    $stmt->execute();

    // unread count (SECURE)
        $countStmt = $con->prepare(
                "SELECT COUNT(*) AS unread
                 FROM notifications
                 WHERE user_role = ?
                     AND user_id = ?
                     AND is_read = 0"
        );
        $countStmt->bind_param("si", $role, $user_id);
    $countStmt->execute();
    $result = $countStmt->get_result();
    $row = $result->fetch_assoc();

    echo json_encode([
        'status' => 'success',
        'unread' => (int) $row['unread']
    ]);
    exit;
}


//  MARK ALL AS READ 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_all'])) {

    header('Content-Type: application/json');

    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        echo json_encode(['status' => 'invalid_csrf']);
        exit;
    }

        $stmt = $con->prepare(
                "UPDATE notifications
                 SET is_read = 1
                 WHERE user_role = ?
                     AND user_id = ?"
        );
        $stmt->bind_param("si", $role, $user_id);
    $stmt->execute();

    echo json_encode([
        'status' => 'success',
        'unread' => 0
    ]);
    exit;
}


//  NORMAL REDIRECT FLOW 

if (isset($_GET['id'])) {

    $notification_id = (int) $_GET['id'];

    // get redirect link (SECURE)
        $stmt = $con->prepare(
                "SELECT link
                 FROM notifications
                 WHERE id = ?
                     AND user_role = ?
                     AND user_id = ?"
        );
        $stmt->bind_param("isi", $notification_id, $role, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {

        // mark read (SECURE)
        $updateStmt = $con->prepare(
            "UPDATE notifications
             SET is_read = 1
             WHERE id = ?
               AND user_role = ?
               AND user_id = ?"
        );
        $updateStmt->bind_param("isi", $notification_id, $role, $user_id);
        $updateStmt->execute();

        $link = trim((string) $row['link']);
        if ($link !== '') {
            if ($role === 'admin' && strpos($link, '/') === false) {
                header("Location: ../show-details/" . $link);
            } else {
                header("Location: ../" . ltrim($link, '/'));
            }
            exit;
        }
    }
}


$fallback = '../dashboard/dashboard.php';
if ($role === 'student') {
    $fallback = '../dashboard/student-dashboard.php';
} elseif ($role === 'teacher') {
    $fallback = '../dashboard/teacher-dashboard.php';
} elseif ($role === 'parent') {
    $fallback = '../dashboard/parent-dashboard.php';
}

header("Location: " . $fallback);
exit;
