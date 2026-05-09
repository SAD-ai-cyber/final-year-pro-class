<?php
require '../includes/security.php';

// Start secure session and token for form
start_secure_session();
// Apply security headers for this request.
send_security_headers();
$csrf_token = csrf_token();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <link rel="stylesheet" href="../css/forms/teacher-form.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/responsive-core.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="form-container">
        <h2>Add Course</h2>

        <form id="courseForm" action="../includes/course_add.php" method="post" data-ajax="true" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

            <div class="form-row">
                <div class="form-group">
                    <label for="courseName">Course Name *</label>
                    <input type="text" id="courseName" name="course_name" placeholder="Enter course name" required>
                </div>
                <div class="form-group">
                    <label for="courseCode">Course Code *</label>
                    <input type="text" id="course_Code" name="course_code" placeholder="e.g., CS101" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="section">Section</label>
                    <input type="text" id="section" name="section" placeholder="Enter section">
                </div>
                <div class="form-group">
                    <label for="teacher">Class Teacher *</label>
                    <input type="text" id="teacher" name="teacher_name" placeholder="Teacher name" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="category">Category *</label>
                    <input type="text" id="category" name="category" placeholder="e.g., Science, Commerce" required>
                </div>
                <div class="form-group">
                    <label for="duration">Duration (Months)</label>
                    <input type="number" id="duration" name="duration" min="1" max="48" placeholder="Enter duration">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="startDate">Start Date</label>
                    <input type="date" id="start_date" name="start_date">
                </div>
                <div class="form-group">
                    <label for="courseFees">Course Fees (?) *</label>
                    <input type="number" id="courseFees" name="course_fees" placeholder="Enter amount" required>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Course Description</label>
                <textarea id="description" name="description" placeholder="Enter detailed course description..." rows="4"></textarea>
            </div>

            <div class="form-group">
                <label for="coursePhoto">Course Thumbnail/Photo</label>
                <input type="file" id="coursePhoto" name="course_photo" accept="image/*">
            </div>

            <div class="button-container">
                <button type="submit" name="add_course" class="btn btn-add">Add Course</button>
            </div>
        </form>
    </div>

</body>

</html>
