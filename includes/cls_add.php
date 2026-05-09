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
if(isset($_POST['add_class'])){
    require_post_csrf();

    $Class_Name= mysqli_real_escape_string($con, $_POST['class-name']);
    $Section = mysqli_real_escape_string($con, $_POST['section']);
    $Teacher_Name = mysqli_real_escape_string($con, $_POST['class-teacher']);
    $Max_Student = mysqli_real_escape_string($con, $_POST['max_students']);
    
    // Insert with prepared statement
    $stmt = $con->prepare('INSERT INTO add_class (Class_Name, Section, Teacher_Name, Max_Student) VALUES (?, ?, ?, ?)');
    $ok = false;
    if ($stmt) {
        $stmt->bind_param('ssss', $Class_Name, $Section, $Teacher_Name, $Max_Student);
        $ok = $stmt->execute();
        $stmt->close();
    }

    if($ok == true)
    {
        sendNotificationAndEmail(
            $con,
            'admin',
            1,
            'Class Added',
            "Class: {$Class_Name} | Section: {$Section}",
            'show-details/show-class.php'
        );
        echo "<script> alert('Data Inserted into database Tables.');
                       location.href='../forms/class-add.php'; 
                </script>";
    }
    else{
        echo"<p><strong>MYSQL Error:</strong>".mysqli_error($con) . "</p>";
    }
    
    mysqli_close($con);
}
?>
