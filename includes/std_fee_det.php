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
if (isset($_POST['submit_fee_details'])) {
    require_post_csrf();

    // FILE UPLOAD LOGIC (receipt file)
    $receipt_filename = "";
    $upload = upload_file_simple(
        $_FILES["fee_receipt"] ?? null,
        "../material_upload/receipts/",
        ['pdf', 'jpg', 'jpeg', 'png'],
        5 * 1024 * 1024,
        'receipt_'
    );

    if ($upload['ok']) {
        $receipt_filename = $upload['filename'];
    } elseif ($upload['error'] !== 'No file uploaded.') {
        echo "<script> alert('Sorry, there was an error uploading your file: " . addslashes($upload['error']) . "');
                   location.href='../forms/student-fee-det.php';
            </script>";
        exit;
    }

    //   DATA CAPTURE 
    $student_id = mysqli_real_escape_string($con, $_POST['student_id']);
    $student_name = mysqli_real_escape_string($con, $_POST['student_name']);
    $student_email = mysqli_real_escape_string($con, $_POST['student_email']);
    $parent_email = mysqli_real_escape_string($con, $_POST['parent_email']);
    $course_name = mysqli_real_escape_string($con, $_POST['course']);
    $course_price = mysqli_real_escape_string($con, $_POST['course_price']);
    $paid_price = mysqli_real_escape_string($con, $_POST['paid_price']);
    $remaining_price = mysqli_real_escape_string($con, $_POST['remaining_price']);
    
    // NEW FIELDS
    $payment_method = mysqli_real_escape_string($con, $_POST['payment_method']);
    $transaction_id = mysqli_real_escape_string($con, $_POST['transaction_id']);
    $receipt_number = mysqli_real_escape_string($con, $_POST['receipt_number']);
    $payment_date = mysqli_real_escape_string($con, $_POST['payment_date']);
    $payment_time = mysqli_real_escape_string($con, $_POST['payment_time']);
    $discount_amount = mysqli_real_escape_string($con, $_POST['discount_amount']);
    $payment_notes = mysqli_real_escape_string($con, $_POST['payment_notes']);
    
    $receipt_file_safe = $receipt_filename;

    // Insert with prepared statement
    $stmt = $con->prepare(
        'INSERT INTO student_fees (student_id, student_name, student_email, parent_email, course_name, course_price, paid_price, remaining_price, payment_method, transaction_id, receipt_number, payment_date, payment_time, discount_amount, payment_notes, receipt_file)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );
    $ok = false;
    if ($stmt) {
        $stmt->bind_param(
            'isssssssssssssss',
            $student_id,
            $student_name,
            $student_email,
            $parent_email,
            $course_name,
            $course_price,
            $paid_price,
            $remaining_price,
            $payment_method,
            $transaction_id,
            $receipt_number,
            $payment_date,
            $payment_time,
            $discount_amount,
            $payment_notes,
            $receipt_file_safe
        );
        $ok = $stmt->execute();
        $stmt->close();
    }

    if ($ok == true) {
        $notif_title = 'Fee Payment Updated';
        $notif_message = "Course: $course_name | Paid: $paid_price | Remaining: $remaining_price";
        sendNotificationAndEmail($con, 'student', (int) $student_id, $notif_title, $notif_message, 'show-details/show-std-fee.php');
        notifyParentByEmail($con, $parent_email, $notif_title, $notif_message, 'show-details/show-std-fee.php');

        sendNotificationAndEmail(
            $con,
            'admin',
            1,
            'Fee Updated',
            "Student: {$student_name} | Course: {$course_name}",
            'show-details/show-std-fee.php'
        );

        echo "<script> alert('Fee Details Added Successfully!');
                   location.href='../forms/student-fee-det.php'; 
            </script>";
    } else {
        echo "<p><strong>MYSQL Error:</strong> " . mysqli_error($con) . "</p>";
    }

    mysqli_close($con);
  
}
?>
