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
if(isset($_POST['Schedule_Meeting'])){
    require_post_csrf();
    $Meeting_title = mysqli_real_escape_string($con, $_POST['meeting_title']);
    $meeting_date = mysqli_real_escape_string($con, $_POST['meeting_date']);
    $meeting_time = mysqli_real_escape_string($con, $_POST['meeting_time']);
    $meeting_mode = mysqli_real_escape_string( $con, $_POST['meeting_mode']);

    // Optional link (empty means NULL)
    $meeting_link_raw = $_POST['meeting_link'] ?? '';
    $meeting_link = $meeting_link_raw === '' ? null : $meeting_link_raw;

    // Insert with prepared statement
    $stmt = $con->prepare('INSERT INTO meeting_form(Meeting_title, meeting_date, meeting_time, meeting_mode, meeting_link) VALUES(?, ?, ?, ?, ?)');
    $ok = false;
    if ($stmt) {
        $stmt->bind_param('sssss', $Meeting_title, $meeting_date, $meeting_time, $meeting_mode, $meeting_link);
        $ok = $stmt->execute();
        $stmt->close();
    }

    if($ok == true)
        {
         $notif_title = 'Parent Meeting Scheduled';
         $notif_message = "Meeting: {$Meeting_title} | {$meeting_date} {$meeting_time} ({$meeting_mode})";
         $notif_link = 'show-details/show-meets.php';

         sendNotificationToRole($con, 'student', $notif_title, $notif_message, $notif_link);
         sendNotificationToRole($con, 'parent', $notif_title, $notif_message, $notif_link);
         sendNotificationToRole($con, 'admin', $notif_title, $notif_message, $notif_link);
         
         header("Location: ../forms/parent-meeting-form.php?status=success&message=" . urlencode('Meeting Scheduled Successfully'));
         exit;
    }

    else{
        $error = mysqli_error($con);
        header("Location: ../forms/parent-meeting-form.php?status=error&message=" . urlencode("Database Error: " . $error));
        exit;
    }
    mysqli_close($con);
    
}
?>
