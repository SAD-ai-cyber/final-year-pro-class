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
if(isset($_POST['Add_Result'])){
    require_post_csrf();

    $student_id_raw = $_POST['student_id'];
    $student_name_raw = $_POST['Student_name'];

    // Student ke naam ko file name ke liye safe banayega
    $safe_student_name = preg_replace('/[^A-Za-z0-9_\-]/', '_', $student_name_raw);
    $safe_student_name = preg_replace('/_+/', '_', $safe_student_name);

    $result_sheet_filename = "";
    $upload = upload_file_simple(
        $_FILES["result_sheet"] ?? null,
        "../material_upload/results/",
        ['pdf', 'jpg', 'jpeg', 'png'],
        5 * 1024 * 1024,
        'result_' . $student_id_raw . '_' . $safe_student_name . '_'
    );

    if ($upload['ok']) {
        $result_sheet_filename = $upload['filename'];
    } elseif ($upload['error'] !== 'No file uploaded.') {
        echo "<script> alert('Result sheet upload failed: " . addslashes($upload['error']) . "');
           location.href='../forms/result-add.php';
           </script>";
        exit;
    }

    $Student_ID = mysqli_real_escape_string($con, $student_id_raw);
    $Student_Name = mysqli_real_escape_string($con, $student_name_raw);
    $Student_email = mysqli_real_escape_string($con, $_POST['student-email']);
    $Parent_email = mysqli_real_escape_string($con, $_POST['parent-email']);
    $Examination_name = mysqli_real_escape_string($con, $_POST['Exam_name']);
    $Module = mysqli_real_escape_string($con, $_POST['Subject_name']);
    $Marks_obtained = mysqli_real_escape_string($con, $_POST['marks_obtained']);
    $Total_Marks = mysqli_real_escape_string($con, $_POST['total_marks']);
    $result_status = mysqli_real_escape_string($con, $_POST['status']);
    
    // NEW FIELDS
    $Percentage = mysqli_real_escape_string($con, $_POST['percentage']);
    $Grade = mysqli_real_escape_string($con, $_POST['grade']);
    $Attendance_Percentage = mysqli_real_escape_string($con, $_POST['attendance_percentage']);
    $Performance_Rating = mysqli_real_escape_string($con, $_POST['performance_rating']);
    $Instructor_Comments = mysqli_real_escape_string($con, $_POST['instructor_comments']);
    
    // File ka naya naam 
    $result_sheet_file_safe = $result_sheet_filename;

    // Insert with prepared statement
    $stmt = $con->prepare(
        'INSERT INTO add_result (Student_ID, Student_Name, student_email, parent_email, Examination_name, Module, Marks_obtained, Total_Marks, result_status, percentage, grade, attendance_percentage, performance_rating, instructor_comments, result_sheet_file)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );
    $ok = false;
    if ($stmt) {
        $stmt->bind_param(
            'issssssssssssss',
            $Student_ID,
            $Student_Name,
            $Student_email,
            $Parent_email,
            $Examination_name,
            $Module,
            $Marks_obtained,
            $Total_Marks,
            $result_status,
            $Percentage,
            $Grade,
            $Attendance_Percentage,
            $Performance_Rating,
            $Instructor_Comments,
            $result_sheet_file_safe
        );
        $ok = $stmt->execute();
        $stmt->close();
    }

        if($ok == true)
        {
                $notif_title = 'Result Updated';
                $notif_message = "Exam: $Examination_name | Module: $Module | Marks: $Marks_obtained/$Total_Marks";
                sendNotificationAndEmail($con, 'student', (int) $Student_ID, $notif_title, $notif_message, 'show-details/show-result.php');
                notifyParentByEmail($con, $Parent_email, $notif_title, $notif_message, 'show-details/show-result.php');

                sendNotificationAndEmail(
                    $con,
                    'admin',
                    1,
                    'Result Added',
                    "Student: {$Student_Name} | Exam: {$Examination_name}",
                    'show-details/show-result.php'
                );
        
                 echo "<script> alert('Data Inserted Into Database Tables');
                     location.href='../forms/result-add.php'; 
                     </script>";
        }

    else{
        echo "<p><strong>MYSQL Error:</strong>".mysqli_error($con). "</p>";
    }
    
    mysqli_close($con);
    
    
}

?>
