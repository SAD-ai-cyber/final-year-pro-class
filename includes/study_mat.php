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

// Handle POST form action.
if (isset($_POST['upload_material'])) {
    require_post_csrf();

    // 1. Text data ko escape karna
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $course = mysqli_real_escape_string($con, $_POST['course']);
    $subject = mysqli_real_escape_string($con, $_POST['subject']);
    $material_type = mysqli_real_escape_string($con, $_POST['material_type']);

    $db_storage_value = ""; // DB mein save karne ke liye final value

    // 2. Material type ke hisaab se logic he
    if ($material_type == 'pdf' || $material_type == 'zip') {
        // PDF/ZIP upload
        $upload = upload_file_simple(
            $_FILES['material_file'] ?? null,
            "../material_upload/material/",
            ['pdf', 'zip'],
            10 * 1024 * 1024,
            'material_'
        );

        if ($upload['ok']) {
            $db_storage_value = "../material_upload/material/" . $upload['filename'];
        } else {
            die("Error: " . $upload['error']);
        }

    } else if ($material_type == 'video' || $material_type == 'link') {
        //  YEH LINK (URL) KA LOGIC HAI

        if (!empty($_POST['material_link'])) {
            $link_url = $_POST['material_link'];
            $db_storage_value = $link_url;
        } else {
            // Agar link khaali tha, toh script rok kar error dikhao
            die("Error: Material type was link/video, but no URL was provided.");
        }
    }

      
    $db_storage_value_sql = $db_storage_value;

    // Insert with prepared statement
    $stmt = $con->prepare(
        'INSERT INTO study_material (title, description, course, subject, material_type, file_path_or_link) VALUES (?, ?, ?, ?, ?, ?)'
    );
    $ok = false;
    if ($stmt) {
        $stmt->bind_param('ssssss', $title, $description, $course, $subject, $material_type, $db_storage_value_sql);
        $ok = $stmt->execute();
        $stmt->close();
    }

    if ($ok == true) {
        // Notify students enrolled in the course
        $stmt = $con->prepare('SELECT DISTINCT student_id FROM student_fees WHERE course_name = ?');
        if ($stmt) {
            $stmt->bind_param('s', $course);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($res && ($stu = $res->fetch_assoc())) {
                $sid = (int) $stu['student_id'];
                if ($sid > 0) {
                    $notif_title = 'New Study Material';
                    $notif_message = "Course: $course | Subject: $subject";
                    sendNotificationAndEmail($con, 'student', $sid, $notif_title, $notif_message, 'show-details/show-study-mat.php');
                }
            }
            $stmt->close();
        }

        sendNotificationAndEmail(
            $con,
            'admin',
            1,
            'Study Material Added',
            "Course: {$course} | Subject: {$subject}",
            'show-details/show-study-mat.php'
        );

         echo "<script> alert('Material has been uploaded successfully.');
                       location.href='../forms/study-mat-add.php'; 
                </script>";
    } 
    else {
        // Agar data save nahi hua
           echo "<script> alert('Database Error! Data could not be inserted into the database.');
                       location.href='../forms/study-mat-add.php'; 
                </script>";
        
        // YEH LINE AAPKO ASLI ERROR BATAYEGI
        echo "<p><strong>MYSQL Error:</strong> " . mysqli_error($con) . "</p>";
    }
    
    mysqli_close($con);
}
?>
