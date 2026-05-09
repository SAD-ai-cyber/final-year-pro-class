<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require 'security.php';
require 'config.php';
require 'notification_helper.php';
require_once 'email_helper.php';

// Start secure session and headers for this POST handler
start_secure_session();
// Apply security headers for this request.
send_security_headers();

function read_tabular_rows($file_path, $extension)
{
    $rows = [];
    if ($extension === 'csv') {
        $handle = fopen($file_path, 'r');
        if (!$handle) {
            return $rows;
        }
        while (($row = fgetcsv($handle)) !== false) {
            $rows[] = $row;
        }
        fclose($handle);
        return $rows;
    }

    $autoload_path = __DIR__ . '/../vendor/autoload.php';
    if (file_exists($autoload_path)) {
        require_once $autoload_path;
    }

    if (!class_exists('PhpOffice\\PhpSpreadsheet\\IOFactory')) {
        return $rows;
    }

    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path);
    $sheet = $spreadsheet->getActiveSheet();
    foreach ($sheet->toArray(null, true, true, false) as $row) {
        $rows[] = $row;
    }
    return $rows;
}

function normalize_header($header)
{
    $header = trim($header);
    $header = strtolower($header);
    $header = preg_replace('/[^a-z0-9]+/', '_', $header);
    $header = trim($header, '_');
    return $header;
}

// Handle POST form action.
if (isset($_POST['import_teachers'])) {
    require_post_csrf();

    [$fields_table, $values_table, $id_field] = ensure_extra_tables($con, 'teacher');

    if (!isset($_FILES['teacher_csv']) || $_FILES['teacher_csv']['error'] !== 0) {
        echo "<script>alert('CSV upload failed.'); location.href='../forms/teacher-add.php';</script>";
        exit;
    }

    if ($_FILES['teacher_csv']['size'] > 5 * 1024 * 1024) {
        echo "<script>alert('File too large. Max 5MB allowed.'); location.href='../forms/teacher-add.php';</script>";
        exit;
    }

    $file_path = $_FILES['teacher_csv']['tmp_name'];
    $original_name = $_FILES['teacher_csv']['name'];
    $extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

    if (!in_array($extension, ['csv', 'xlsx'], true)) {
        echo "<script>alert('Only CSV or XLSX allowed.'); location.href='../forms/teacher-add.php';</script>";
        exit;
    }

    $rows = read_tabular_rows($file_path, $extension);
    if (empty($rows)) {
        echo "<script>alert('File is empty.'); location.href='../forms/teacher-add.php';</script>";
        exit;
    }

    $headers = array_shift($rows);
    if (!$headers) {
        echo "<script>alert('Header missing.'); location.href='../forms/teacher-add.php';</script>";
        exit;
    }

    $core_aliases = [
        'teacher_name' => 'teacher_name',
        'name' => 'teacher_name',
        'full_name' => 'teacher_name',
        'teacher_email' => 'teacher_email',
        'email' => 'teacher_email',
        'email_id' => 'teacher_email',
        'teacher_num' => 'teacher_num',
        'mobile' => 'teacher_num',
        'phone' => 'teacher_num',
        'mobile_no' => 'teacher_num',
        'phone_no' => 'teacher_num',
        'contact' => 'teacher_num'
    ];

    $header_map = [];
    $extra_headers = [];
    foreach ($headers as $index => $header) {
        $normalized = normalize_header($header);
        if ($normalized === '') {
            continue;
        }
        if (isset($core_aliases[$normalized])) {
            $header_map[$index] = $core_aliases[$normalized];
        } else {
            $extra_headers[$index] = [
                'field_key' => $normalized,
                'field_label' => trim($header)
            ];
        }
    }

    $required = ['teacher_name', 'teacher_email', 'teacher_num'];
    foreach ($required as $req) {
        if (!in_array($req, $header_map, true)) {
            echo "<script>alert('Required columns missing. Please include: teacher_name, teacher_email, teacher_num'); location.href='../forms/teacher-add.php';</script>";
            exit;
        }
    }

    $extra_field_ids = [];
    foreach ($extra_headers as $index => $meta) {
        $field_key = mysqli_real_escape_string($con, $meta['field_key']);
        $field_label = mysqli_real_escape_string($con, $meta['field_label']);

        $check_stmt = $con->prepare("SELECT field_id FROM {$fields_table} WHERE field_key = ?");
        $field_id_val = 0;
        if ($check_stmt) {
            $check_stmt->bind_param('s', $field_key);
            $check_stmt->execute();
            $res = $check_stmt->get_result();
            if ($res && ($row = $res->fetch_assoc())) {
                $field_id_val = (int) $row['field_id'];
            }
            $check_stmt->close();
        }

        if ($field_id_val > 0) {
            $extra_field_ids[$index] = $field_id_val;
        } else {
            $ins_stmt = $con->prepare("INSERT INTO {$fields_table} (field_key, field_label) VALUES (?, ?)");
            if ($ins_stmt) {
                $ins_stmt->bind_param('ss', $field_key, $field_label);
                $ins_stmt->execute();
                $extra_field_ids[$index] = (int) $ins_stmt->insert_id;
                $ins_stmt->close();
            }
        }
    }

    $inserted = 0;
    $skipped = 0;
    $email_failed = 0;
    $duplicate_rows = [];
    $seen_emails = [];
    $seen_phones = [];
    $password_rows = [];

    foreach ($rows as $row) {
        $row_data = [
            'teacher_name' => '',
            'teacher_email' => '',
            'teacher_num' => ''
        ];

        foreach ($header_map as $index => $field_name) {
            $row_data[$field_name] = isset($row[$index]) ? trim($row[$index]) : '';
        }

        if ($row_data['teacher_name'] === '' || $row_data['teacher_email'] === '' || $row_data['teacher_num'] === '') {
            $skipped++;
            continue;
        }

        $email_key = strtolower(trim($row_data['teacher_email']));
        $phone_key = trim($row_data['teacher_num']);
        if (($email_key !== '' && isset($seen_emails[$email_key])) || ($phone_key !== '' && isset($seen_phones[$phone_key]))) {
            $skipped++;
            $duplicate_rows[] = $row_data['teacher_email'] . ' / ' . $row_data['teacher_num'];
            continue;
        }

        $teacher_name = mysqli_real_escape_string($con, $row_data['teacher_name']);
        $teacher_email = mysqli_real_escape_string($con, $row_data['teacher_email']);
        $teacher_num = mysqli_real_escape_string($con, $row_data['teacher_num']);

        $dup_stmt = $con->prepare('SELECT teacher_id FROM add_teachers WHERE teacher_email = ? OR teacher_num = ? LIMIT 1');
        $dup_found = false;
        if ($dup_stmt) {
            $dup_stmt->bind_param('ss', $teacher_email, $teacher_num);
            $dup_stmt->execute();
            $dup_res = $dup_stmt->get_result();
            $dup_found = $dup_res && $dup_res->num_rows > 0;
            $dup_stmt->close();
        }
        if ($dup_found) {
            $skipped++;
            $duplicate_rows[] = $row_data['teacher_email'] . ' / ' . $row_data['teacher_num'];
            continue;
        }

        $plain_password = generate_random_password();
        $password_hash = password_hash($plain_password, PASSWORD_DEFAULT);

        $stmt = $con->prepare('INSERT INTO add_teachers (teacher_name, teacher_email, teacher_num, password_hash, photo) VALUES (?, ?, ?, ?, ?)');
        $ok = false;
        $new_teacher_id = 0;
        if ($stmt) {
            $empty_photo = '';
            $stmt->bind_param('sssss', $teacher_name, $teacher_email, $teacher_num, $password_hash, $empty_photo);
            $ok = $stmt->execute();
            $new_teacher_id = (int) $stmt->insert_id;
            $stmt->close();
        }

        if (!$ok) {
            $skipped++;
            continue;
        }

        $inserted++;
        if ($email_key !== '') {
            $seen_emails[$email_key] = true;
        }
        if ($phone_key !== '') {
            $seen_phones[$phone_key] = true;
        }

        $email_ok = sendTeacherCredentialsEmail($row_data['teacher_email'], $row_data['teacher_name'], $plain_password, $row_data['teacher_num']);
        if (!$email_ok) {
            $email_failed++;
        }

        sendNotificationAndEmail(
            $con,
            'teacher',
            $new_teacher_id,
            'Welcome',
            'Your teacher account has been created successfully.',
            'dashboard/teacher-dashboard.php'
        );

        sendNotificationAndEmail(
            $con,
            'admin',
            1,
            'New Teacher Added',
            "Teacher: {$row_data['teacher_name']} ({$row_data['teacher_email']})",
            'show-details/show-teacher.php'
        );

        foreach ($extra_headers as $index => $meta) {
            if (!isset($row[$index])) {
                continue;
            }
            $value = trim($row[$index]);
            if ($value === '') {
                continue;
            }
            $field_id = isset($extra_field_ids[$index]) ? (int) $extra_field_ids[$index] : 0;
            if ($field_id > 0 && $new_teacher_id > 0) {
                $safe_value = mysqli_real_escape_string($con, $value);
                $extra_stmt = $con->prepare("INSERT INTO {$values_table} ({$id_field}, field_id, field_value) VALUES (?, ?, ?)");
                if ($extra_stmt) {
                    $extra_stmt->bind_param('iis', $new_teacher_id, $field_id, $safe_value);
                    $extra_stmt->execute();
                    $extra_stmt->close();
                }
            }
        }

        $password_rows[] = [$row_data['teacher_name'], $row_data['teacher_email'], $row_data['teacher_num'], $plain_password];
    }

    if (!empty($password_rows)) {
        $file_name = 'teacher_passwords_' . date('Ymd') . '.csv';
        $file_path = __DIR__ . '/../material_upload/student_passwords/' . $file_name;
        append_password_csv($file_path, ['name', 'email', 'mobile', 'password'], $password_rows);
    }

    $message = "Import complete.\n";
    $message .= "Inserted: {$inserted}\n";
    $message .= "Skipped: {$skipped}\n";
    $message .= "Email failed: {$email_failed}\n";
    if (!empty($duplicate_rows)) {
        $dup_preview = implode(', ', array_slice($duplicate_rows, 0, 5));
        $message .= "Duplicates (email/phone already exists): {$dup_preview}";
        if (count($duplicate_rows) > 5) {
            $message .= '...';
        }
    }

    $_SESSION['import_message'] = $message;
    header('Location: ../forms/teacher-add.php?import=1');
    exit;
}

// Handle POST form action.
if(isset($_POST['add_teacher']))
    {
    require_post_csrf();
        [$fields_table, $values_table, $id_field] = ensure_extra_tables($con, 'teacher');
        // Form se data lo
        $teacher_name = mysqli_real_escape_string($con, $_POST['teacher_name']);
        $teacher_email = mysqli_real_escape_string($con, $_POST['email']);
        $teacher_num = mysqli_real_escape_string($con, $_POST['mobile_number']);
        $plain_password = generate_random_password();
        $password_hash = password_hash($plain_password, PASSWORD_DEFAULT);
        
    // Photo upload (only images)
    $photo_name = "";
    if (isset($_FILES['teacher_photo'])) {
        $upload = upload_file_simple(
            $_FILES['teacher_photo'],
            "../material_upload/teacher_photo/",
            ['jpg', 'jpeg', 'png', 'webp'],
            2 * 1024 * 1024,
            'teacher_'
        );
        if ($upload['ok']) {
            $photo_name = $upload['filename'];
        } elseif ($upload['error'] !== 'No file uploaded.') {
            echo "<script> alert('Photo upload failed: " . addslashes($upload['error']) . "');
                   location.href='../forms/teacher-add.php';
            </script>";
            exit;
        }
    }

        // DUPLICATE CHECK
        $check_stmt = $con->prepare("SELECT teacher_id FROM add_teachers WHERE teacher_email = ? OR teacher_num = ?");
        if ($check_stmt) {
            $check_stmt->bind_param("ss", $teacher_email, $teacher_num);
            $check_stmt->execute();
            $check_stmt->store_result();
            if ($check_stmt->num_rows > 0) {
                echo "<script> alert('Error: Teacher with this Email or Mobile Number already exists!'); location.href='../forms/teacher-add.php'; </script>";
                $check_stmt->close();
                exit; 
            }
            $check_stmt->close();
        }

        // Insert with prepared statement
        $stmt = $con->prepare('INSERT INTO add_teachers (teacher_name, teacher_email, teacher_num, password_hash, photo) VALUES (?, ?, ?, ?, ?)');
        $ok = false;
        $new_teacher_id = 0;
        if ($stmt) {
            $stmt->bind_param('sssss', $teacher_name, $teacher_email, $teacher_num, $password_hash, $photo_name);
            $ok = $stmt->execute();
            $new_teacher_id = (int) $stmt->insert_id;
            $stmt->close();
        }

        if($ok == true){
            if (!empty($_POST['extra_fields']) && is_array($_POST['extra_fields']) && $new_teacher_id > 0) {
                $extra_stmt = $con->prepare("INSERT INTO {$values_table} ({$id_field}, field_id, field_value) VALUES (?, ?, ?)");
                if ($extra_stmt) {
                    foreach ($_POST['extra_fields'] as $field_id => $field_value) {
                        $field_id = (int) $field_id;
                        $field_value = trim($field_value);
                        if ($field_id > 0 && $field_value !== '') {
                            $extra_stmt->bind_param('iis', $new_teacher_id, $field_id, $field_value);
                            $extra_stmt->execute();
                        }
                    }
                    $extra_stmt->close();
                }
            }

            // OPTIMIZED EMAIL SENDING (Background Queue)
            $baseUrl = isset($GLOBALS['app_base_url']) ? rtrim($GLOBALS['app_base_url'], '/') : '';
            $loginUrl = $baseUrl !== '' ? $baseUrl . '/admin_login.php' : ''; // Teachers usually login via admin/teacher portal

            $subject = 'Teacher Account Details';
            $message = "Hello {$teacher_name},\n\n" .
                "Your Teacher account has been created successfully.\n\n" .
                "Login Email: {$teacher_email}\n" .
                "Mobile: {$teacher_num}\n" .
                "Password: {$plain_password}\n\n";

            if ($loginUrl !== '') {
                $message .= "Login here: {$loginUrl}\n\n";
            }

            $message .= "Note: You can change your password later if needed.\n" .
                "Please keep this information safe.\n\n" .
                "Thanks.";

            // Send Password Email Synchronously (Direct)
            sendTeacherCredentialsEmail($teacher_email, $teacher_name, $plain_password, $teacher_num);

            $file_name = 'teacher_passwords_' . date('Ymd') . '.csv';
            $file_path = __DIR__ . '/../material_upload/student_passwords/' . $file_name;
            append_password_csv($file_path, ['name', 'email', 'mobile', 'password'], [[$teacher_name, $teacher_email, $teacher_num, $plain_password]]);

            // Dashboard Notification ONLY (No Email)
            sendNotification(
                $con,
                'teacher',
                $new_teacher_id,
                'Welcome',
                'Your teacher account has been created successfully.',
                'dashboard/teacher-dashboard.php'
            );

            // Admin Notification ONLY (No Email)
            sendNotification(
                $con,
                'admin',
                1,
                'New Teacher Added',
                "Teacher: {$teacher_name} ({$teacher_email})",
                'show-details/show-teacher.php'
            );

               echo "<script> alert('Teacher Added Successfully!');
           location.href='../forms/teacher-add.php'; 
           </script>";
        
        }
        else{
            $err = addslashes(mysqli_error($con));
             echo"<script> alert('Database Error: {$err}'); location.href='../forms/teacher-add.php'; </script>";
        }
    }

else if(isset($_POST['Remove_Teacher']))
    {
    require_post_csrf();
        [$fields_table, $values_table, $id_field] = ensure_extra_tables($con, 'teacher');
        $teacher_id = mysqli_real_escape_string($con, $_POST['teacher_id']);
        $teacher_name_confirm = mysqli_real_escape_string($con, $_POST['teacher_name_confirm']);


        // Delete with prepared statement
        $stmt = $con->prepare("DELETE FROM {$values_table} WHERE {$id_field} = ?");
        if ($stmt) {
            $teacher_id_int = (int) $teacher_id;
            $stmt->bind_param('i', $teacher_id_int);
            $stmt->execute();
            $stmt->close();
        }

        $stmt = $con->prepare('DELETE FROM add_teachers WHERE teacher_id = ? AND teacher_name = ?');
        $ok = false;
        if ($stmt) {
            $teacher_id_int = (int) $teacher_id;
            $stmt->bind_param('is', $teacher_id_int, $teacher_name_confirm);
            $ok = $stmt->execute();
            $stmt->close();
        }

        if($ok == true){
           
            if (mysqli_affected_rows($con) > 0) {
                echo "<script> alert('Teacher (ID: $teacher_id) Removed Successfully!)</script>";
            } 
            else {
                 echo "<script> alert('Teacher ID not found or Name does not match. No Teacher removed.');
                       location.href='../forms/teacher-add.php'; 
                </script>";
            }
        }
        else{
             echo "<p><strong> MYSQL Error:</strong>".mysqli_error($con). "</p>";
        }
    }

else {
    
    echo "<script> alert('Invalid request.');
                       location.href='../forms/teacher-add.php'; 
                </script>";
}

mysqli_close($con);

?>
