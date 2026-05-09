<?php
require __DIR__ . '/includes/security.php';

// Start secure session and set headers
start_secure_session();
// Apply security headers for this request.
send_security_headers();

// Enforce active session for access.
if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
    // Agar student hai to dashboard bhejo
    if($_SESSION['role'] == 'student'){
        header("Location: dashboard/student-dashboard.php");
        exit;
    }
    // Agar baki log yaha aa gaye to unke dashboard bhejo
    else {
        header("Location: admin_login.php"); 
        exit;
    }
}

// Token for login/register forms
$csrf_token = csrf_token();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
     <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
     <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Mozilla+Headline:wght@200..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/l_s_style.css">
    <link rel="stylesheet" href="css/l_s_media.css">
    <title>Login and Register Form</title>
</head>
<body>
    <div class="container">
        
        <!-- login form start -->
        <div class="form-box login">
            <form action="login_includes/student_log.php" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                <h1>User Login</h1>
                <div class="input-box">
                    <input type="text" name="username" placeholder="Username(email-id)" required>
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="password" required>
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div class="forgot-link" name="forget_pass">
                    <a href="forget_pass.php">Forgot Password?</a>
                </div>
                <button type="submit" name="login_button" class="btn login-btn">Login</button>
                <p>Or Login With Social Platform</p>
                <div class="social-icons">
                    <a href="#"><i class="fa-brands fa-google"></i></a>
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-github"></i></a>
                    <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                </div>
                <div class="back-to-site">
                    <a href="index.php"><i class="fa-solid fa-arrow-left"></i> Back to Website</a>
                </div>
            </form>
        </div>
        <!-- login form end-->

        <!-- Register form start -->
         <div class="form-box register">
            <form action="login_includes/student_log.php" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                <h1>Student Registration</h1>
                <div class="input-box">
                    <input type="text" name="name" placeholder="Fullname" required>
                    <i class="fa-solid fa-user"></i>
                </div>
                
                <div class="input-box">
                    <input type="tel" name="mobile_no" placeholder="Mobile No" maxlength="10" required>
                    <i class="fa-solid fa-user"></i>
                </div>
            
                <div class="input-box">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="password" required>
                    <i class="fa-solid fa-lock"></i>
                </div>
                
                <button type="submit" name="register_btn" class="btn login-btn">Register</button>
                <p>Or Register With Social Platform</p>
                <div class="social-icons">
                    <a href="#"><i class="fa-brands fa-google"></i></a>
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-github"></i></a>
                    <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                </div>
                <div class="back-to-site">
                    <a href="index.php"><i class="fa-solid fa-arrow-left"></i> Back to Website</a>
                </div>
            </form>
        </div>

        <!-- Register form end -->

        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Hello, Welcome!</h1>
                <p>Don't Have an Account?</p>
                <button class="login-btn register-btn">Register</button>
            </div>

            <div class="toggle-panel toggle-right">
                <h1> Welcome Back!</h1>
                <p>Already Have an Account?</p>
                <button class="login-btn login2-btn">Login</button>
            </div>
        </div>

    </div>
</body>
<script src="js/l_s_script.js?v=<?php echo filemtime(__DIR__ . '/js/l_s_script.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>
</html>
