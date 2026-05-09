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
if (isset($_POST['submit_timetable'])) {
    require_post_csrf();

    $batchName = mysqli_real_escape_string($con, $_POST['batchName']);
    $course = mysqli_real_escape_string($con, $_POST['course']);
    $duration = mysqli_real_escape_string($con, $_POST['duration']);

    // Insert main batch (prepared)
    $stmt = $con->prepare('INSERT INTO batches (batch_name, course_name, duration_months) VALUES (?, ?, ?)');
    $result_batch = false;
    if ($stmt) {
        $stmt->bind_param('sss', $batchName, $course, $duration);
        $result_batch = $stmt->execute();
        $stmt->close();
    }

  
    if ($result_batch == true) {
        
        $new_batch_id = mysqli_insert_id($con);
        $all_periods_saved = true; 

        //  har din ke periods ko 'batch_schedule' table me save karega
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

        // Prepare period insert once
        $period_stmt = $con->prepare('INSERT INTO batch_schedule (new_batch_id, day_safe, time_safe, topic_safe, instructor_safe) VALUES (?, ?, ?, ?, ?)');

        foreach ($days as $day) {
            $times = $_POST[$day . '_time'] ?? [];
            $topics = $_POST[$day . '_topic'] ?? [];
            $instructors = $_POST[$day . '_instructor'] ?? [];

            for ($i = 0; $i < count($times); $i++) {
                $time = $times[$i];
                $topic = $topics[$i];
                $instructor = $instructors[$i];

                if (!empty($time) || !empty($topic) || !empty($instructor)) {
                    $time_safe = mysqli_real_escape_string($con, $time);
                    $topic_safe = mysqli_real_escape_string($con, $topic);
                    $instructor_safe = mysqli_real_escape_string($con, $instructor);
                    $day_safe = mysqli_real_escape_string($con, $day);

                    $result_period = false;
                    if ($period_stmt) {
                        $period_stmt->bind_param('issss', $new_batch_id, $day_safe, $time_safe, $topic_safe, $instructor_safe);
                        $result_period = $period_stmt->execute();
                    }

                    // Agar koi period save nahi hua, to error dikhayega
                    if ($result_period == false) {
                        $all_periods_saved = false;
                        echo "<p><strong>Period Save Error ($day):</strong> " . mysqli_error($con) . "</p>";
                    }
                }
            }
        }

        if ($period_stmt) {
            $period_stmt->close();
        }

        if ($all_periods_saved) {
            $notif_title = 'Time Table Updated';
            $notif_message = "Batch: {$batchName} | Course: {$course}";
            $notif_link = 'show-details/show-timetd.php';

            sendNotificationToRole($con, 'student', $notif_title, $notif_message, $notif_link);
            sendNotificationToRole($con, 'parent', $notif_title, $notif_message, $notif_link);
            sendNotificationToRole($con, 'teacher', $notif_title, $notif_message, $notif_link);
            sendNotificationToRole($con, 'admin', $notif_title, $notif_message, $notif_link);

            echo "<script> alert('Time Table Added Successfully!');
                location.href='../forms/time-table.php';
            </script>";

        } else {
            echo "<script> alert('Time Table saved, but some periods had errors.');</script>";
        }

    } else {
        // Agar main batch hi save nahi hua to error dikhayega
        echo "<p><strong>Main Batch Save Error:</strong> " . mysqli_error($con) . "</p>";

    }

    mysqli_close($con);

} else {
    // Agar koi direct PHP file access kare to use wapas bhej do
    header("Location: ../forms/time-table.html");
    exit;
}
?>
