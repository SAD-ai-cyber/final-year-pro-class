<?php
require '../includes/security.php';
require '../includes/config.php';

// Security/session bootstrap.
start_secure_session();
// Apply security headers for this request.
send_security_headers();

// Register new student
if (isset($_POST['register_btn'])) {
    require_post_csrf();

    // Basic input read
    $name = trim($_POST['name'] ?? '');
    $email_id = trim($_POST['email'] ?? '');
    $mobile_num = trim($_POST['mobile_no'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name === '' || $email_id === '' || $mobile_num === '' || $password === '') {
        echo "<script>alert('Invalid data'); location.href='../login.php'</script>";
        exit;
    }

    // Save password as hash
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $con->prepare('INSERT INTO add_students (student_name, student_email, student_num, password_hash) VALUES (?, ?, ?, ?)');
    $ok = false;
    if ($stmt) {
        $stmt->bind_param('ssss', $name, $email_id, $mobile_num, $password_hash);
        $ok = $stmt->execute();
        $stmt->close();
    }

    if ($ok) {
        header('location: ../login.php');
        exit;
    }

    echo "<script>alert('Registration failed. Please try again.'); location.href='../login.php'</script>";
}


// Student login
if (isset($_POST['login_button'])) {
    require_post_csrf();

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        echo "<script>alert('Invalid Username and Password'); location.href='../login.php'</script>";
        exit;
    }

    auth_debug_log("STUDENT_LOGIN attempt id={$username}");

    // Fetch student row
    $numeric_id = ctype_digit($username) ? (int) $username : -1;
    $stmt = $con->prepare('SELECT student_id, student_name, student_email, password_hash FROM add_students WHERE student_email = ? OR student_num = ? OR student_id = ? LIMIT 1');
    $row_data = null;
    if ($stmt) {
        $stmt->bind_param('ssi', $username, $username, $numeric_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row_data = $result ? $result->fetch_assoc() : null;
        $stmt->close();
    }

    auth_debug_log('STUDENT_LOGIN row_found=' . ($row_data ? 'yes' : 'no'));

    // Verify password and upgrade old plain text if needed
    $password_ok = $row_data && verify_and_upgrade_password($con, 'add_students', 'student_id', $row_data['student_id'], $password, $row_data['password_hash']);
    auth_debug_log('STUDENT_LOGIN password_ok=' . ($password_ok ? 'yes' : 'no'));

    if ($password_ok) {
        session_regenerate_id(true);
        $_SESSION['username'] = $row_data['student_email'];
        $_SESSION['display_name'] = $row_data['student_name'];
        $_SESSION['role'] = 'student';
        $_SESSION['student_id'] = (int) $row_data['student_id'];

        header('location: ../dashboard/student-dashboard.php');
        exit;
    }

    echo "<script>alert('Invalid Username and Password'); location.href='../login.php'</script>";
}

?>
