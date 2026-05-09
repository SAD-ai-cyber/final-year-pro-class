<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'security.php';
require 'config.php';
require 'notification_helper.php';

// Start secure session and headers for this POST handler
start_secure_session();
// Apply security headers for this request.
send_security_headers();

// Button click check
if (isset($_POST['add_course'])) {
    require_post_csrf();

    $course_name = mysqli_real_escape_string($con, $_POST['course_name']);
    $course_code = mysqli_real_escape_string($con, $_POST['course_code']);
    $section = mysqli_real_escape_string($con, $_POST['section']);
    $teacher_name = mysqli_real_escape_string($con, $_POST['teacher_name']);
    $duration = mysqli_real_escape_string($con, $_POST['duration']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $start_date = $_POST['start_date']; 
    $description = mysqli_real_escape_string($con, $_POST['description']);


    $fees = mysqli_real_escape_string($con, $_POST['course_fees']);

    // 2. Photo Upload Logic (only images)
    $photo_name = "";
    if (isset($_FILES['course_photo'])) {
        $upload = upload_file_simple(
            $_FILES['course_photo'],
            "../material_upload/course_photo/",
            ['jpg', 'jpeg', 'png', 'webp'],
            2 * 1024 * 1024,
            'course_'
        );
        if ($upload['ok']) {
            $photo_name = $upload['filename'];
        } elseif ($upload['error'] !== 'No file uploaded.') {
            echo "<script> alert('Photo upload failed: " . addslashes($upload['error']) . "');
                   location.href='../forms/course-add.php';
            </script>";
            exit;
        }
    }

    // 3. Database me data dalne ki query
    // Insert with prepared statement
    $stmt = $con->prepare(
        'INSERT INTO course_add (Course_Name, Course_Code, Section, Teacher, Duration, Category, Starting_date, Course_description, course_fees, course_photo)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );
    $ok = false;
    if ($stmt) {
        $stmt->bind_param(
            'ssssssssss',
            $course_name,
            $course_code,
            $section,
            $teacher_name,
            $duration,
            $category,
            $start_date,
            $description,
            $fees,
            $photo_name
        );
        $ok = $stmt->execute();
        $stmt->close();
    }

    if ($ok == true) {
        sendNotificationAndEmail(
            $con,
            'admin',
            1,
            'Course Added',
            "Course: {$course_name} ({$course_code})",
            'show-details/show-course.php'
        );
        echo "<script> alert('Course Added Successfully!');
                       location.href='../forms/course-add.php'; 
              </script>";
    } else {
        echo "<p><strong>Error:</strong> " . mysqli_error($con) . "</p>";
    }

    mysqli_close($con);
}
?>
