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
if (isset($_POST['Register_Now'])) {
    require_post_csrf();
    // Basic input read
    $student_name = trim($_POST['student_name'] ?? '');
    $student_email = trim($_POST['student_email'] ?? '');
    $student_num = trim($_POST['mobile_number'] ?? '');

    // Insert with prepared statement
    $stmt = $con->prepare('INSERT INTO add_online_students(student_name, student_email, student_num) VALUES(?, ?, ?)');
    $ok = false;
    if ($stmt) {
        $stmt->bind_param('sss', $student_name, $student_email, $student_num);
        $ok = $stmt->execute();
        $stmt->close();
    }

    if ($ok) {

        sendNotificationAndEmail(
            $con,
            'admin',
            1,
            'New Online Student Enquiry',
            'A new student enquiry has been received from the website.',
            'show-details/show-online-student-details.php'
        );


        echo "<script> alert('You Will be Called Soon! Thank You for joining with Us!');
           location.href='../index.php'; 
           </script>";
           
    } else {
        echo "<p><strong>MYSQL Error:</strong>" . mysqli_error($con) . "</p>";
    }
}


// Agar koi bhi button nahi daba
else {

    echo "<script> alert('Invalid request.');
           location.href='../index.php'; 
           </script>";

}

mysqli_close($con);

?>
