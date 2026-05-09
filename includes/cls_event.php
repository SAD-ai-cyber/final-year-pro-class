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
if(isset($_POST['add_event'])){
    require_post_csrf();
    $Event_Name= mysqli_real_escape_string($con, $_POST['event_name']);
    $Event_Desc= mysqli_real_escape_string($con, $_POST['description']);
    $Event_Date= mysqli_real_escape_string($con, $_POST['event_date']);
    $Event_Time= mysqli_real_escape_string($con, $_POST['event_time']);
    $Total_Expense= mysqli_real_escape_string($con, $_POST['total_expense']);
    
  
    $safe_event_name = preg_replace('/[^A-Za-z0-9_\-]/', '_', $_POST['event_name']);
    $safe_event_name = preg_replace('/_+/', '_', $safe_event_name);

    $event_file_filename = "";
    if (isset($_FILES["event_poster"])) {
        $upload = upload_file_simple(
            $_FILES["event_poster"],
            "../material_upload/event_data/",
            ['jpg', 'jpeg', 'png', 'webp'],
            2 * 1024 * 1024,
            $safe_event_name . '_'
        );
        if ($upload['ok']) {
            $event_file_filename = $upload['filename'];
        } elseif ($upload['error'] !== 'No file uploaded.') {
            echo "<script> alert('Event file upload failed: " . addslashes($upload['error']) . "');
                   location.href='../forms/class-events-add.php';
            </script>";
            exit;
        }
    }

    // File ka naam database ke liye safe karo
    $event_file_safe = mysqli_real_escape_string($con, $event_file_filename);
    
    // Insert with prepared statement
    $stmt = $con->prepare('INSERT INTO add_event(Event_Name, Event_Desc, Event_Date, Event_Time, Total_Expense, event_file) VALUES(?, ?, ?, ?, ?, ?)');
    $ok = false;
    if ($stmt) {
        $stmt->bind_param('ssssss', $Event_Name, $Event_Desc, $Event_Date, $Event_Time, $Total_Expense, $event_file_safe);
        $ok = $stmt->execute();
        $stmt->close();
    }

    if($ok == true)
    {
        $notif_title = 'New Class Event';
        $notif_message = "Event: {$Event_Name} | Date: {$Event_Date} {$Event_Time}";
        $notif_link = 'show-details/show-cls-fun.php';

        sendNotificationToRole($con, 'student', $notif_title, $notif_message, $notif_link);
        sendNotificationToRole($con, 'parent', $notif_title, $notif_message, $notif_link);
        sendNotificationToRole($con, 'teacher', $notif_title, $notif_message, $notif_link);
        sendNotificationToRole($con, 'admin', $notif_title, $notif_message, $notif_link);

        echo "<script> alert('Data Inserted Into Database Tables.');
                       location.href='../forms/class-events-add.php'; 
                </script>";
        
    }
    else{
        echo"<p><strong>MYSQL Error:</strong>".mysqli_error($con) . "</p>";
    }
    mysqli_close($con);
}

?>
