<?php
require '../includes/security.php';

// Security/session bootstrap.
start_secure_session();
// Apply security headers for this request.
send_security_headers();
// Enforce role-based access control.
require_role('admin', '../admin_login.php');
$csrf_token = csrf_token();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Class</title>
    <link rel="stylesheet" href="../css/forms/teacher-form.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/responsive-core.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="form-container">
        <h2>Add Class</h2>

        <form id="add-class-form" action="../includes/cls_add.php" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

            <div class="form-group">
                <label for="class-name">Class Name *</label>
                <input type="text" id="class-name" name="class-name" placeholder="e.g., Class 10-A" required>
            </div>
            <div class="form-group">
                <label for="section">Section *</label>
                <input type="text" id="section" name="section" placeholder="e.g., A, B, C" required>
            </div>
            <div class="form-group">
                <label for="class-teacher">Class Teacher *</label>
                <input type="text" id="class-teacher" name="class-teacher" placeholder="Enter teacher name" required>
            </div>
            <div class="form-group">
                <label for="max-students">Maximum Students *</label>
                <input type="number" id="max-students" name="max_students" placeholder="e.g., 50" required>
            </div>

            <div class="button-container">
                <button type="submit" name="add_class" class="btn btn-add">Add Class</button>
            </div>
        </form>
    </div>

</body>

</html>
