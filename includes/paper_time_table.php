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
if(isset($_POST['set_schedule']))
{
    require_post_csrf();
    $schedule_name = mysqli_real_escape_string($con, $_POST['schedule_name']);
    $course_name = mysqli_real_escape_string($con, $_POST['course']);
    $week_of = mysqli_real_escape_string($con, $_POST['week_of']);

    // Monday (Start Time & End Time included)
    $monday_module = mysqli_real_escape_string($con, $_POST['monday_module']);
    $monday_time = mysqli_real_escape_string($con, $_POST['monday_start_time']); 
    $monday_end_time = mysqli_real_escape_string($con, $_POST['monday_end_time']); 
    $monday_lab = mysqli_real_escape_string($con, $_POST['monday_lab']);

    // Tuesday
    $tuesday_module = mysqli_real_escape_string($con, $_POST['tuesday_module']);
    $tuesday_time = mysqli_real_escape_string($con, $_POST['tuesday_start_time']);
    $tuesday_end_time = mysqli_real_escape_string($con, $_POST['tuesday_end_time']);
    $tuesday_lab = mysqli_real_escape_string($con, $_POST['tuesday_lab']);

    // Wednesday
    $wednesday_module = mysqli_real_escape_string($con, $_POST['wednesday_module']);
    $wednesday_time = mysqli_real_escape_string($con, $_POST['wednesday_start_time']);
    $wednesday_end_time = mysqli_real_escape_string($con, $_POST['wednesday_end_time']);
    $wednesday_lab = mysqli_real_escape_string($con, $_POST['wednesday_lab']);

    // Thursday
    $thursday_module = mysqli_real_escape_string($con, $_POST['thursday_module']);
    $thursday_time = mysqli_real_escape_string($con, $_POST['thursday_start_time']);
    $thursday_end_time = mysqli_real_escape_string($con, $_POST['thursday_end_time']);
    $thursday_lab = mysqli_real_escape_string($con, $_POST['thursday_lab']);

    // Friday
    $friday_module = mysqli_real_escape_string($con, $_POST['friday_module']);
    $friday_time = mysqli_real_escape_string($con, $_POST['friday_start_time']);
    $friday_end_time = mysqli_real_escape_string($con, $_POST['friday_end_time']);
    $friday_lab = mysqli_real_escape_string($con, $_POST['friday_lab']);

    // Saturday
    $saturday_module = mysqli_real_escape_string($con, $_POST['saturday_module']);
    $saturday_time = mysqli_real_escape_string($con, $_POST['saturday_start_time']);
    $saturday_end_time = mysqli_real_escape_string($con, $_POST['saturday_end_time']);
    $saturday_lab = mysqli_real_escape_string($con, $_POST['saturday_lab']);

    // Updated Insert Query with End Time Columns
    // Insert with prepared statement
    $stmt = $con->prepare(
        'INSERT INTO paper_schedule (
            schedule_name, course_name, week_of,
            monday_module, monday_time, monday_end_time, monday_lab,
            tuesday_module, tuesday_time, tuesday_end_time, tuesday_lab,
            wednesday_module, wednesday_time, wednesday_end_time, wednesday_lab,
            thursday_module, thursday_time, thursday_end_time, thursday_lab,
            friday_module, friday_time, friday_end_time, friday_lab,
            saturday_module, saturday_time, saturday_end_time, saturday_lab
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );
    $ok = false;
    if ($stmt) {
        $stmt->bind_param(
            'sssssssssssssssssssssssssss',
            $schedule_name,
            $course_name,
            $week_of,
            $monday_module,
            $monday_time,
            $monday_end_time,
            $monday_lab,
            $tuesday_module,
            $tuesday_time,
            $tuesday_end_time,
            $tuesday_lab,
            $wednesday_module,
            $wednesday_time,
            $wednesday_end_time,
            $wednesday_lab,
            $thursday_module,
            $thursday_time,
            $thursday_end_time,
            $thursday_lab,
            $friday_module,
            $friday_time,
            $friday_end_time,
            $friday_lab,
            $saturday_module,
            $saturday_time,
            $saturday_end_time,
            $saturday_lab
        );
        $ok = $stmt->execute();
        $stmt->close();
    }

    if($ok == true){
        // Notify students enrolled in the course
        $stmt = $con->prepare('SELECT DISTINCT student_id, parent_email FROM student_fees WHERE course_name = ?');
        if ($stmt) {
            $stmt->bind_param('s', $course_name);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($res && ($stu = $res->fetch_assoc())) {
                $sid = (int) $stu['student_id'];
                $parent_email = isset($stu['parent_email']) ? trim((string) $stu['parent_email']) : '';
                if ($sid > 0) {
                    $notif_title = 'New Paper Schedule';
                    $notif_message = "Course: $course_name | Week: $week_of";
                    sendNotificationAndEmail($con, 'student', $sid, $notif_title, $notif_message, 'show-details/show-paper-sch.php');
                    if ($parent_email !== '') {
                        notifyParentByEmail($con, $parent_email, $notif_title, $notif_message, 'show-details/show-paper-sch.php');
                    }
                }
            }
            $stmt->close();
        }

        $notif_title = 'New Paper Schedule';
        $notif_message = "Course: $course_name | Week: $week_of";
        sendNotificationToRole($con, 'teacher', $notif_title, $notif_message, 'show-details/show-paper-sch.php');
        sendNotificationToRole($con, 'admin', $notif_title, $notif_message, 'show-details/show-paper-sch.php');

        echo "<script> alert('Schedule Data Inserted Into Database Successfully');
                       location.href='../forms/paper-time-table.php'; 
                </script>";
    }
    else{
        echo "<p><strong> MYSQL Error: </strong>". mysqli_error($con). "</p>";
    }

    mysqli_close($con);
}
?>
