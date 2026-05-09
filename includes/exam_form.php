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
if(isset($_POST['add_examination']))
    {
    require_post_csrf();
    $Exam_Name= mysqli_real_escape_string($con, $_POST['exam_name']);
    $Course_Name= mysqli_real_escape_string($con, $_POST['course']);
    $Module= mysqli_real_escape_string($con, $_POST['module']);
    $Exam_Type= mysqli_real_escape_string($con, $_POST['exam_type']);
    $Comp_Lab= mysqli_real_escape_string($con, $_POST['computer_lab']);
    $Exam_Date = mysqli_real_escape_string($con, $_POST['exam_date']);
    $Start_time = mysqli_real_escape_string($con, $_POST['start_time']);  
    $End_time = mysqli_real_escape_string($con, $_POST['end_time']);  
    $Total_Marks = mysqli_real_escape_string($con, $_POST['total_marks']);
    
    // New fields
    $Passing_Marks = mysqli_real_escape_string($con, $_POST['passing_marks']);
    $No_Of_Questions = mysqli_real_escape_string($con, $_POST['no_of_questions']);
    $Difficulty_Level = mysqli_real_escape_string($con, $_POST['difficulty_level']);
    $Invigilator_Name = mysqli_real_escape_string($con, $_POST['invigilator_name']);
    $Invigilator_Email = mysqli_real_escape_string($con, $_POST['invigilator_email']);
    $Exam_Instructions = mysqli_real_escape_string($con, $_POST['exam_instructions']);

    // Insert with prepared statement
    $stmt = $con->prepare(
        'INSERT INTO exam_form (Exam_Name, Course_Name, Module, Exam_Type, Comp_Lab, Exam_Date, Start_time, End_time, Total_Marks, Passing_Marks, No_Of_Questions, Difficulty_Level, Invigilator_Name, Invigilator_Email, Exam_Instructions)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );
    $ok = false;
    if ($stmt) {
        $stmt->bind_param(
            'sssssssssssssss',
            $Exam_Name,
            $Course_Name,
            $Module,
            $Exam_Type,
            $Comp_Lab,
            $Exam_Date,
            $Start_time,
            $End_time,
            $Total_Marks,
            $Passing_Marks,
            $No_Of_Questions,
            $Difficulty_Level,
            $Invigilator_Name,
            $Invigilator_Email,
            $Exam_Instructions
        );
        $ok = $stmt->execute();
        $stmt->close();
    }

    if($ok == true){
         // 1. Admin ko notification
         sendNotificationAndEmail(
             $con,
             'admin',
             1,
             'Exam Created',
             "Exam: {$Exam_Name} | Course: {$Course_Name}",
             'show-details/show-examinforms.php'
         );

         // 2. Saare students ko notification
         sendNotificationToRole(
             $con,
             'student',
             'Exam Scheduled',
             "Exam: {$Exam_Name} | Course: {$Course_Name} | Date: {$Exam_Date}",
             'show-details/show-examinforms.php'
         );

         // 3. Saare parents ko notification
         sendNotificationToRole(
             $con,
             'parent',
             'Exam Scheduled',
             "Exam: {$Exam_Name} | Course: {$Course_Name} | Date: {$Exam_Date}",
             'show-details/show-examinforms.php'
         );

         // 4. Saare teachers ko notification
         sendNotificationToRole(
             $con,
             'teacher',
             'Exam Scheduled',
             "Exam: {$Exam_Name} | Course: {$Course_Name} | Date: {$Exam_Date}",
             'show-details/show-examinforms.php'
         );
        
         echo "<script> alert('Data Inserted Into Database Tables');
                       location.href='../forms/examinationform.php'; 
                </script>";
    }
    else{
        echo"<p><strong> MYSQL Error: </strong>". mysqli_error($con). "</p>";
    }

    mysqli_close($con);
}
?>
