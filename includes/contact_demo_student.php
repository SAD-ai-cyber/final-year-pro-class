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
if (isset($_POST['Send_Message'])) {
    require_post_csrf();
    // Basic input read
    $student_name = trim($_POST['student_name'] ?? '');
    $student_email = trim($_POST['student_email'] ?? '');
    $student_num = trim($_POST['student_num'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Insert with prepared statement
    $stmt = $con->prepare('INSERT INTO contact_demo_student(student_name, student_email, student_num, subject_name, enq_message) VALUES(?, ?, ?, ?, ?)');
    $ok = false;
    if ($stmt) {
        $stmt->bind_param('sssss', $student_name, $student_email, $student_num, $subject, $message);
        $ok = $stmt->execute();
        $stmt->close();
    }

    if ($ok) {

        sendNotificationAndEmail(
            $con,
            'admin',
            1,
            'New Contact Enquiry',
            'A new contact enquiry has been received from the website.',
            'show-details/show-contact-student-details.php'
        );

        echo "<script> alert('You Will be Called Soon!<br> Thank You for joining with Us!');
                       location.href='../pages/contact-page.php'; 
                </script>";
    } else {
        echo "<p><strong>MYSQL Error:</strong>" . mysqli_error($con) . "</p>";
    }
}


// Agar koi bhi button nahi daba
else {
    echo "<script> alert('Invalid request.');
                       location.href='../pages/contact-page.php'; 
                </script>";
}

mysqli_close($con);

?>
