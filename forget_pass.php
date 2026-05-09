<?php
require __DIR__ . '/includes/security.php';

// Start secure session and set headers
start_secure_session();
// Apply security headers for this request.
send_security_headers();

// Token for verify form
$csrf_token = csrf_token();
?>

<!-- ye form he forget password ke  this is form1  -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/for_pass.css">
    <title>Forgot Password</title>
</head>
<body>
    <!-- email Verify form -->
    <div class="container">
        
        <div class="form-box active" id="forgot-pass">
            <form action="login_includes/rest_pass.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                <h2>Forgot Password</h2>
           
         <div class="input-box">
            <select name="role_select" required >
                <option value="" disabled selected>--Select Role--</option>
                <option value="Student">Student</option> 
                <option value="Teacher">Teacher</option>
                <option value="Parent">Parent</option>
                <option value="Admin">Admin</option>
            </select>
            <i class="fa-solid fa-caret-down" style="pointer-events: none;"></i>
         </div>

                <div class="input-box">
                    <input type="text" name="email_id" placeholder="Enter your Email" required>
                     <i class="fa-solid fa-user"></i>
                </div>

                <button type="submit" name="verify_btn">
                  Verify Email
                </button>
            </form>
        </div>

    </div>


     
    

    </body>
</html>
