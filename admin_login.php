<?php
require __DIR__ . '/includes/security.php';

// Start secure session and set headers
start_secure_session();
// Apply security headers for this request.
send_security_headers();

// Agar user login hai, to usse Login page mat dikhao, seedha Dashboard bhejo
if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
    
    $role = $_SESSION['role'];

    if($role == 'admin') {
        header("Location: dashboard/dashboard.php");
    } 
    elseif($role == 'teacher') {
        header("Location: dashboard/teacher-dashboard.php");
    } 
    elseif($role == 'parent') {
        header("Location: dashboard/parent-dashboard.php");
    }
    // Agar student galti se yaha aa gaya
    elseif($role == 'student') {
        header("Location: dashboard/student-dashboard.php");
    }
    exit;
}

// Token for form CSRF protection
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
     <link rel="stylesheet" href="css/adm_log.css">
    <title>Admin login</title>
</head>
<body>
    <div class="container">
        <!-- admin login form -->
         <!-- yaha pe login form ko active class de he so vo open hogi -->
        <div class="form-box active" id="login-form">
            <form action="login_includes/adm_log.php" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                <h2>Login Here</h2>
                <div class="input-box">
                    <input type="text" name='admname' placeholder="Username or Email" required>
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="input-box">
                    <input type="password" name="admpass" placeholder="password" required>
                    <i class="fa-solid fa-lock"></i>
                </div>
                
                <div class="input-box">
                    <select name="role" required>
                        <option value="">--Select Role--</option>
                        <option value="admin">Admin</option>
                        <option value="teacher">Teachers</option>
                        <option value="parent">Parents</option>
                    </select>
                </div>
                
                <div class="forgot-link  mt-3">
                    <a href="forget_pass.php">Forgot Password?</a>
                </div>
                <button type="submit" name="login_btn">Login</button>
                <div class="back-to-site">
                    <a href="index.php"><i class="fa-solid fa-arrow-left"></i> Back to Website</a>
                </div>
            </form>
        </div>
        
      
    </div>
</body>

<script src="js/adm_log_script.js?v=<?php echo filemtime(__DIR__ . '/js/adm_log_script.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>
</html>
