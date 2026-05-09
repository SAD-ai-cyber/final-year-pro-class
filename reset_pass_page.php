<?php
require __DIR__ . '/includes/security.php';

// Start secure session and set headers
start_secure_session();
// Apply security headers for this request.
send_security_headers();

// Token for reset form
$csrf_token = csrf_token();
$is_admin_reset = isset($_SESSION['reset_role']) && $_SESSION['reset_role'] === 'Admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/for_pass.css">
    <title>Reset Password</title>
</head>
<body>
    <div class="container">
        <div class="form-box active" id="reset-pass">
            <form action="login_includes/rest_pass.php" method="POST">
                <h2>Reset Password</h2>
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

                <div class="input-box">
                    <input type="password" name="new_password" placeholder="New Password" required>
                </div>
                <div class="input-box">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                </div>
                <div class="input-box">
                    <input type="text" name="otp_code" placeholder="Enter OTP" required>
                </div>

                <button type="submit" name="reset_btn">Update Password</button>
            </form>
        </div>
    </div>
</body>
</html>
