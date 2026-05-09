<?php
require '../includes/security.php';
require '../includes/config.php';

// Security/session bootstrap.
start_secure_session();
// Apply security headers for this request.
send_security_headers();

// Admin/Teacher/Parent login handler
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_btn'])) {
    require_post_csrf();

    // Basic input read
    $role = $_POST['role'] ?? '';
    $identifier = trim($_POST['admname'] ?? '');
    $password = $_POST['admpass'] ?? '';

    if ($role === '' || $identifier === '' || $password === '') {
        echo "<script>alert('Invalid user name and password'); location.href='../admin_login.php'</script>";
        exit;
    }

    auth_debug_log("ADM_LOGIN attempt role={$role} id={$identifier}");

    $numeric_id = ctype_digit($identifier) ? (int) $identifier : -1;

    // Decide table and redirect by role
    $stmt = null;
    $table = '';
    $id_field = '';
    $redirect = '';
    $login_email = ''; // To store the email from the row

    if ($role === 'admin') {
        $table = 'admins';
        $id_field = 'admin_id';
        $redirect = '../dashboard/dashboard.php';
        // Admin can login via Username OR Email (Flexible)
        $stmt = $con->prepare('SELECT admin_id, admin_name, admin_email, password_hash FROM admins WHERE admin_name = ? OR admin_email = ? LIMIT 1');
    } elseif ($role === 'teacher') {
        $table = 'add_teachers';
        $id_field = 'teacher_id';
        $redirect = '../dashboard/teacher-dashboard.php';
        // Teacher MUST login via Email
        $stmt = $con->prepare('SELECT teacher_id, teacher_name, teacher_email, password_hash FROM add_teachers WHERE teacher_email = ? LIMIT 1');
    } elseif ($role === 'parent') {
        $table = 'add_parents';
        $id_field = 'parent_id';
        $redirect = '../dashboard/parent-dashboard.php';
        // Parent MUST login via Email
        $stmt = $con->prepare('SELECT parent_id, parent_name, parent_email, password_hash FROM add_parents WHERE parent_email = ? LIMIT 1');
    }

    // Fetch user row
    $row = null;
    if ($stmt) {
        if ($role === 'admin') {
            $stmt->bind_param('ss', $identifier, $identifier);
        } elseif ($role === 'teacher' || $role === 'parent') {
            $stmt->bind_param('s', $identifier);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result ? $result->fetch_assoc() : null;
        $stmt->close();
    }

    auth_debug_log('ADM_LOGIN row_found=' . ($row ? 'yes' : 'no'));

    // Verify password and upgrade old plain text if needed
    $password_ok = $row && verify_and_upgrade_password($con, $table, $id_field, $row[$id_field], $password, $row['password_hash']);
    auth_debug_log('ADM_LOGIN password_ok=' . ($password_ok ? 'yes' : 'no'));

    if ($password_ok) {
        session_regenerate_id(true);
        $_SESSION['username'] = $identifier;
        $_SESSION['role'] = $role;
        $_SESSION[$id_field] = (int) $row[$id_field];

        // Store display names for activity logging
        if ($role === 'admin' && isset($row['admin_name'])) {
            $_SESSION['admin_name'] = $row['admin_name'];
            $_SESSION['display_name'] = $row['admin_name'];
        }

        // Parent uses email in dashboard
        if ($role === 'parent' && isset($row['parent_email'])) {
            $_SESSION['email'] = $row['parent_email'];
        }
        // Teacher uses email in dashboard
        if ($role === 'teacher' && isset($row['teacher_email'])) {
             $_SESSION['email'] = $row['teacher_email'];
        }

        header('Location: ' . $redirect);
        exit;
    }

    echo "<script>alert('Invalid user name and password'); location.href='../admin_login.php'</script>";
}
?>

