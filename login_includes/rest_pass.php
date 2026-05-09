<?php
require '../includes/security.php';
require '../includes/config.php';
require '../includes/email_helper.php';

// Security/session bootstrap.
start_secure_session();
// Apply security headers for this request.
send_security_headers();

// Step 1: verify email and role
if (isset($_POST['verify_btn'])) {
    require_post_csrf();

    // Basic input read
    $email = trim($_POST['email_id'] ?? '');
    $role = trim($_POST['role_select'] ?? '');

    if ($email === '' || $role === '') {
        echo "<script>alert('Invalid request.'); location.href = '../forget_pass.php';</script>";
        exit;
    }

    // Pick table by role
    $stmt = null;
    if ($role === 'Student') {
        $stmt = $con->prepare('SELECT student_id FROM add_students WHERE student_email = ? LIMIT 1');
    } elseif ($role === 'Teacher') {
        $stmt = $con->prepare('SELECT teacher_id FROM add_teachers WHERE teacher_email = ? LIMIT 1');
    } elseif ($role === 'Parent') {
        $stmt = $con->prepare('SELECT parent_id FROM add_parents WHERE parent_email = ? LIMIT 1');
    } elseif ($role === 'Admin') {
        $stmt = $con->prepare('SELECT admin_id FROM admins WHERE admin_email = ? LIMIT 1');
    }

    $found = false;
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $found = $result && $result->num_rows === 1;
        $stmt->close();
    }

    if ($found) {
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_role'] = $role;

        // Generate and send OTP for ALL roles
        $otp = (string) random_int(100000, 999999);
        $_SESSION['reset_otp_hash'] = password_hash($otp, PASSWORD_DEFAULT);
        $_SESSION['reset_otp_exp'] = time() + 600;

        $email_ok = sendUserOtpEmail($email, $otp, $role);
        if (!$email_ok) {
            $err = isset($GLOBALS['email_last_error']) ? $GLOBALS['email_last_error'] : '';
            $msg = $err !== '' ? "OTP email failed: {$err}" : 'OTP email failed.';
            echo "<script>alert('{$msg}'); location.href = '../forget_pass.php';</script>";
            exit;
        }

        header('location: ../reset_pass_page.php');
        exit;
    }

    echo "<script>alert('Email Does Not Found in {$role} database Try Again'); location.href = '../forget_pass.php';</script>";
}


// Step 2: reset password
if (isset($_POST['reset_btn'])) {
    require_post_csrf();

    // Read inputs and session data
    $new_pass = $_POST['new_password'] ?? '';
    $confirm_pass = $_POST['confirm_password'] ?? '';
    $email = $_SESSION['reset_email'] ?? '';
    $role = $_SESSION['reset_role'] ?? '';

    if ($email === '' || $role === '') {
        echo "<script>alert('Session expired. Please try again.'); location.href='../forget_pass.php';</script>";
        exit;
    }

    if ($new_pass === '' || $new_pass !== $confirm_pass) {
        echo "<script>alert('Password Does Not Match Try Again');</script>";
        exit;
    }

    // Unified OTP verification for all roles
    $otp_input = trim($_POST['otp_code'] ?? '');
    $otp_hash = $_SESSION['reset_otp_hash'] ?? '';
    $otp_exp = (int) ($_SESSION['reset_otp_exp'] ?? 0);

    if ($otp_input === '' || $otp_hash === '' || $otp_exp === 0) {
        echo "<script>alert('OTP missing or session expired. Please try again.'); location.href='../forget_pass.php';</script>";
        exit;
    }

    if (time() > $otp_exp) {
        echo "<script>alert('OTP expired. Please try again.'); location.href='../forget_pass.php';</script>";
        exit;
    }

    if (!password_verify($otp_input, $otp_hash)) {
        echo "<script>alert('Invalid OTP.');</script>";
        exit;
    }

    // Save new password as hash
    $password_hash = password_hash($new_pass, PASSWORD_DEFAULT);
    $stmt = null;

    if ($role === 'Student') {
        $stmt = $con->prepare('UPDATE add_students SET password_hash = ? WHERE student_email = ?');
    } elseif ($role === 'Teacher') {
        $stmt = $con->prepare('UPDATE add_teachers SET password_hash = ? WHERE teacher_email = ?');
    } elseif ($role === 'Parent') {
        $stmt = $con->prepare('UPDATE add_parents SET password_hash = ? WHERE parent_email = ?');
    } elseif ($role === 'Admin') {
        $stmt = $con->prepare('UPDATE admins SET password_hash = ? WHERE admin_email = ?');
    }

    $ok = false;
    if ($stmt) {
        $stmt->bind_param('ss', $password_hash, $email);
        $ok = $stmt->execute();
        $stmt->close();
    }

    if ($ok) {
        unset($_SESSION['reset_email'], $_SESSION['reset_role'], $_SESSION['reset_otp_hash'], $_SESSION['reset_otp_exp']);
        if ($role === 'Student') {
            echo "<script>alert('Password Update Successfully'); location.href='../login.php';</script>";
        } else {
            echo "<script>alert('Password Update Successfully'); location.href='../admin_login.php';</script>";
        }
        exit;
    }

    echo 'Password Not Updated.';
}


?>
