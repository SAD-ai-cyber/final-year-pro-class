<?php
// Yeh blank screen ki jagah asli error dikhayega
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
if(isset($_POST['insert_data'])){
  require_post_csrf();
    
  $Student_ID = mysqli_real_escape_string($con, $_POST['student_id']);
    $Student_Name = mysqli_real_escape_string($con, $_POST['student-name']);
    $Student_email = mysqli_real_escape_string($con, $_POST['student-email']);
    $Course_Name = mysqli_real_escape_string($con, $_POST['course']);
    $Examination = mysqli_real_escape_string($con, $_POST['examination']);
    $Exam_Date = mysqli_real_escape_string($con, $_POST['exam_date']);
    $Reporting_time = mysqli_real_escape_string($con, $_POST['reporting_time']);
    $Exam_center = mysqli_real_escape_string($con, $_POST['computer-lab']);
    
    // NEW FIELDS
    $Registration_Number = mysqli_real_escape_string($con, $_POST['registration_number']);
    $Seat_Number = mysqli_real_escape_string($con, $_POST['seat_number']);
    $Card_Validity_Date = mysqli_real_escape_string($con, $_POST['card_validity_date']);
    $Exam_Instructions = mysqli_real_escape_string($con, $_POST['exam_instructions']);
    
     // Photo upload (only images)
    $photo_name = "";
    if (isset($_FILES['student_photo'])) {
      $upload = upload_file_simple(
        $_FILES['student_photo'],
        "../material_upload/student_photo/",
        ['jpg', 'jpeg', 'png', 'webp'],
        2 * 1024 * 1024,
        'card_'
      );
      if ($upload['ok']) {
        $photo_name = $upload['filename'];
      } elseif ($upload['error'] !== 'No file uploaded.') {
        echo "<script> alert('Photo upload failed: " . addslashes($upload['error']) . "');
             location.href='../forms/admin-card.php';
        </script>";
        exit;
      }
    }



     // Insert with prepared statement
    $stmt = $con->prepare(
      'INSERT INTO admin_card (Student_Id, Student_Name, student_email, Course_Name, Examination_Name, Exam_Date, Reporting_Time, Exam_Center, Registration_Number, Seat_Number, Card_Validity_Date, Exam_Instructions, photo)
       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );
    $ok = false;
    if ($stmt) {
      $stmt->bind_param(
        'issssssssssss',
        $Student_ID,
        $Student_Name,
        $Student_email,
        $Course_Name,
        $Examination,
        $Exam_Date,
        $Reporting_time,
        $Exam_center,
        $Registration_Number,
        $Seat_Number,
        $Card_Validity_Date,
        $Exam_Instructions,
        $photo_name
      );
      $ok = $stmt->execute();
      $stmt->close();
    }

    if($ok == true)
    {
        $notif_title = 'Hall Ticket Generated';
        $notif_message = "Exam: $Examination | Date: $Exam_Date | Center: $Exam_center";
        
        // Student ko notification
        sendNotificationAndEmail($con, 'student', (int) $Student_ID, $notif_title, $notif_message, 'show-details/show-admin-card.php');
        
        // Parent ko notification
        notifyParentByStudentId($con, (int) $Student_ID, $notif_title, $notif_message, 'show-details/show-admin-card.php');

        // All teachers ko notification
        sendNotificationToRole(
            $con,
            'teacher',
            'Hall Ticket Generated',
            "Student: {$Student_Name} | Exam: {$Examination}",
            'show-details/show-admin-card.php'
        );

        // Admin ko notification
        sendNotificationAndEmail(
          $con,
          'admin',
          1,
          'Hall Ticket Generated',
          "Student: {$Student_Name} | Exam: {$Examination}",
          'show-details/show-admin-card.php'
        );
     
      echo "<script> alert('Admit Card Generated Successfully!');
               location.href='../forms/admin-card.php'; 
          </script>";
    }
    else{
        echo "<script> alert('Please Check your Code Again');
                       location.href='../forms/admin-card.php'; 
                </script>";
        // real error dikha ye ga
        echo "<p><strong>MySQL Error:</strong> " . mysqli_error($con) . "</p>";
        
    }
    mysqli_close($con);
}

?>
