<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'security.php';
require 'config.php';
require 'notification_helper.php';
require_once 'email_helper.php';

// Start secure session and headers for this POST handler
start_secure_session();
// Apply security headers for this request.
send_security_headers();

// Handle POST form action.
if (isset($_POST['Add_Student'])) {
    require_post_csrf();
    
    // 1. Form se data receive karo - PERSONAL INFORMATION
    $student_name = mysqli_real_escape_string($con, $_POST['student_name']);
    $blood_group = isset($_POST['blood_group']) ? mysqli_real_escape_string($con, $_POST['blood_group']) : '';
    $aadhar_number = isset($_POST['aadhar_number']) ? mysqli_real_escape_string($con, $_POST['aadhar_number']) : '';
    
    // CONTACT INFORMATION
    $student_email = mysqli_real_escape_string($con, $_POST['student_email']);
    $student_num = mysqli_real_escape_string($con, $_POST['student_num']);
    $emergency_contact_name = isset($_POST['emergency_contact_name']) ? mysqli_real_escape_string($con, $_POST['emergency_contact_name']) : '';
    $emergency_contact_phone = isset($_POST['emergency_contact_phone']) ? mysqli_real_escape_string($con, $_POST['emergency_contact_phone']) : '';
    
    // ACADEMIC INFORMATION
    $computer_knowledge = isset($_POST['computer_knowledge']) ? mysqli_real_escape_string($con, $_POST['computer_knowledge']) : '';
    $programming_interest = isset($_POST['programming_interest']) ? mysqli_real_escape_string($con, $_POST['programming_interest']) : '';
    
    // PARENT INFORMATION
    $parent_occupation = isset($_POST['parent_occupation']) ? mysqli_real_escape_string($con, $_POST['parent_occupation']) : '';
    $parent_email = isset($_POST['parent_email']) ? mysqli_real_escape_string($con, $_POST['parent_email']) : '';
    
    // BATCH INFORMATION
    $start_time = mysqli_real_escape_string($con, $_POST['start_time']);
    $end_time = mysqli_real_escape_string($con, $_POST['end_time']);
    
    // ACCOUNT SECURITY (Auto-generate password)
    $password_chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789!@#$%';
    $plain_password = '';
    for ($i = 0; $i < 10; $i++) {
        $plain_password .= $password_chars[random_int(0, strlen($password_chars) - 1)];
    }
    $password_hash = password_hash($plain_password, PASSWORD_DEFAULT);

    // 2. Duplicate check (email/mobile)
    $dup_stmt = mysqli_prepare(
        $con,
        "SELECT student_id FROM add_students WHERE student_email = ? OR student_num = ? LIMIT 1"
    );
    mysqli_stmt_bind_param($dup_stmt, "ss", $student_email, $student_num);
    mysqli_stmt_execute($dup_stmt);
    $dup_check = mysqli_stmt_get_result($dup_stmt);
    mysqli_stmt_close($dup_stmt);

    if ($dup_check && mysqli_num_rows($dup_check) > 0) {
        $last_email = isset($_SESSION['last_student_email']) ? $_SESSION['last_student_email'] : '';
        $last_num = isset($_SESSION['last_student_num']) ? $_SESSION['last_student_num'] : '';
        $last_time = isset($_SESSION['last_student_time']) ? (int)$_SESSION['last_student_time'] : 0;
        if ($student_email === $last_email && $student_num === $last_num && (time() - $last_time) < 10) {
            echo "<script>
                    alert('Student already added.');
                    location.href='../forms/student-add.php';
                  </script>";
        } else {
            echo "<script> 
                    alert('Student already exists! Check Email or Mobile Number.'); 
                    history.back();
                  </script>";
        }
        exit;
    }

    // 3. Pehle Database mein INSERT karo 
    // 'student_id' auto-increment hoga
    $insert = "INSERT INTO add_students (
                student_name, student_email, student_num,
                start_time, end_time,
                password_hash, photo,
                blood_group, aadhar_number,
                emergency_contact_name, emergency_contact_phone,
                computer_knowledge, programming_interest,
                parent_occupation, parent_email
               ) VALUES(
                ?, ?, ?,
                ?, ?,
                ?, ?,
                ?, ?,
                ?, ?,
                ?, ?,
                ?, ?
               )";

    $stmt = mysqli_prepare($con, $insert);
    $empty_photo = '';
    mysqli_stmt_bind_param(
        $stmt,
        "sssssssssssssss",
        $student_name,
        $student_email,
        $student_num,
        $start_time,
        $end_time,
        $password_hash,
        $empty_photo,
        $blood_group,
        $aadhar_number,
        $emergency_contact_name,
        $emergency_contact_phone,
        $computer_knowledge,
        $programming_interest,
        $parent_occupation,
        $parent_email
    );
    $insert_ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($insert_ok) {
        
        // 3. Abhi jo ID generate hui hai, wo nikalo (Jaise: 31, 32...)
        $new_student_id = mysqli_insert_id($con);
        
        $photo_name = ""; // Default empty

        // 4. Photo upload (only images)
        if (isset($_FILES['student_photo'])) {
            $upload = upload_file_simple(
                $_FILES['student_photo'],
                "../material_upload/student_photo/",
                ['jpg', 'jpeg', 'png', 'webp'],
                2 * 1024 * 1024,
                'student_' . $new_student_id . '_'
            );

            if ($upload['ok']) {
                $new_filename = $upload['filename'];
                // 5. Database ko update karo sahi photo name ke saath
                $stmt = mysqli_prepare($con, "UPDATE add_students SET photo = ? WHERE student_id = ?");
                mysqli_stmt_bind_param($stmt, "si", $new_filename, $new_student_id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            } elseif ($upload['error'] !== 'No file uploaded.') {
                echo "<script> alert('Photo upload failed: " . addslashes($upload['error']) . "');
                       location.href='../forms/student-add.php';
                </script>";
                exit;
            }
        }

        // 6. Extra fields store karo (agar hai)
        if (!empty($_POST['extra_fields']) && is_array($_POST['extra_fields'])) {
            $extra_stmt = mysqli_prepare(
                $con,
                "INSERT INTO student_extra_values (student_id, field_id, field_value) VALUES (?, ?, ?)"
            );
            foreach ($_POST['extra_fields'] as $field_id => $field_value) {
                $field_id = (int)$field_id;
                $field_value = trim($field_value);
                if ($field_id > 0 && $field_value !== '') {
                    mysqli_stmt_bind_param($extra_stmt, "iis", $new_student_id, $field_id, $field_value);
                    mysqli_stmt_execute($extra_stmt);
                }
            }
            mysqli_stmt_close($extra_stmt);
        }
        // Student Notification (DB Only)
        sendNotification(
            $con,
            'student',
            $new_student_id,
            'Welcome',
            'Your student account has been created successfully.',
            'dashboard/student-dashboard.php'
        );

        // Parent Notification (Disabled to avoid spam/errors, as per user request to block other emails)
        /*
        if (!empty($parent_email)) {
             // Logic to find parent ID and notify would go here if parent accounts were managed differently
             // For now, this email notification is blocked.
        }
        */

        // All teachers ko notification (Uses queue, so effectively blocked on user's setup)
        sendNotificationToRole(
            $con,
            'teacher',
            'New Student Joined',
            "Student: {$student_name} has been added to the institute.",
            'show-details/show-student.php'
        );

        // Admin ko notification (DB Only)
        sendNotification(
            $con,
            'admin',
            1, // Assuming admin_id 1 for general admin notifications
            'New Student Added',
            "Student: {$student_name} ({$student_email})",
            'show-details/show-student.php'
        );

        // OPTIMIZED EMAIL SENDING (Background Queue)
        $baseUrl = isset($GLOBALS['app_base_url']) ? rtrim($GLOBALS['app_base_url'], '/') : '';
        $loginUrl = $baseUrl !== '' ? $baseUrl . '/login.php' : '';

        $subject = 'Student Account Details';
        $message = "Hello {$student_name},\n\n" .
            "Your student account has been created successfully.\n\n" .
            "Login Email: {$student_email}\n" .
            "Mobile: {$student_num}\n" .
            "Password: {$plain_password}\n\n";

        if ($loginUrl !== '') {
            $message .= "Login here: {$loginUrl}\n\n";
        }

        $message .= "Note: You can change your password later if needed.\n" .
            "Please keep this information safe.\n\n" .
            "Thanks.";

        // Send Password Email Synchronously (Direct)
        sendStudentCredentialsEmail($student_email, $student_name, $plain_password, $student_num);

        $file_name = 'student_passwords_' . date('Ymd') . '.csv';
        $file_path = __DIR__ . '/../material_upload/student_passwords/' . $file_name;
        append_password_csv($file_path, ['name', 'email', 'mobile', 'password'], [[$student_name, $student_email, $student_num, $plain_password]]);

        $_SESSION['last_student_email'] = $student_email;
        $_SESSION['last_student_num'] = $student_num;
        $_SESSION['last_student_time'] = time();

        echo "<script> 
            alert('Student Added Successfully!');
            location.href='../forms/student-add.php'; 
              </script>";
              
        }
                 else {
                             // Koi aur error ho to normal dikhaye
                             $error = mysqli_error($con);
                             echo "<p><strong>MYSQL Error:</strong>" . $error . "</p>";
                 }
}

// DELETE STUDENT LOGIC
else if (isset($_POST['Remove_Student'])) {
    require_post_csrf();

    $student_id = (int) ($_POST['student_id'] ?? 0);
    $student_name_confirm = trim($_POST['student_name_confirm'] ?? '');

    // Step 0: Pehle student ka data fetch karo for notifications
    $student_data = null;
    $fetch_stmt = $con->prepare('SELECT student_name, student_email, parent_email FROM add_students WHERE student_id = ?');
    if ($fetch_stmt) {
        $fetch_stmt->bind_param('i', $student_id);
        $fetch_stmt->execute();
        $fetch_res = $fetch_stmt->get_result();
        if ($fetch_row = $fetch_res->fetch_assoc()) {
            $student_data = $fetch_row;
        }
        $fetch_stmt->close();
    }

    // Step 1: Pehle purani photo delete karo folder se
    $stmt = $con->prepare('SELECT photo FROM add_students WHERE student_id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $student_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            if (!empty($row['photo'])) {
                $photo_path = "../material_upload/student_photo/" . $row['photo'];
                if (file_exists($photo_path)) {
                    unlink($photo_path); // File Delete
                }
            }
        }
        $stmt->close();
    }

    // Step 2: Extra fields values delete karo
    $stmt = $con->prepare('DELETE FROM student_extra_values WHERE student_id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $student_id);
        $stmt->execute();
        $stmt->close();
    }

    // Step 3: Database se record delete karo
    $stmt = $con->prepare('DELETE FROM add_students WHERE student_id = ? AND student_name = ?');
    $ok = false;
    if ($stmt) {
        $stmt->bind_param('is', $student_id, $student_name_confirm);
        $ok = $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();
    }

    if ($ok) {
        if ($affected > 0) {
            // Send notifications BEFORE showing success message
            if ($student_data) {
                // 1. Student ko notification (account removed)
                sendNotificationAndEmail(
                    $con,
                    'student',
                    $student_id,
                    'Account Removed',
                    'Your student account has been removed by admin.',
                    'index.php'
                );

                // 2. Parent ko notification (if parent email exists)
                if (!empty($student_data['parent_email'])) {
                    notifyParentByEmail(
                        $con,
                        $student_data['parent_email'],
                        'Student Account Removed',
                        "Student: {$student_data['student_name']} account has been removed.",
                        'index.php'
                    );
                }

                // 3. All teachers ko notification
                sendNotificationToRole(
                    $con,
                    'teacher',
                    'Student Removed',
                    "Student: {$student_data['student_name']} (ID: {$student_id}) has been removed.",
                    'show-details/show-student.php'
                );

                // 4. Admin ko confirmation
                sendNotificationToRole(
                    $con,
                    'admin',
                    'Student Removed',
                    "Student: {$student_data['student_name']} (ID: {$student_id}) has been removed.",
                    'show-details/show-student.php'
                );
            }

            echo "<script> alert('Student Removed Successfully!'); location.href='../forms/student-add.php'; </script>";
        } else {
            echo "<script> alert('ID/Name mismatch or ID not found.'); location.href='../forms/student-add.php'; </script>";
        }
    } else {
        echo "<p><strong>MYSQL Error:</strong>" . mysqli_error($con) . "</p>";
    }
} else {
    echo "<script> location.href='../forms/student-add.php'; </script>";
}

mysqli_close($con);
?>
