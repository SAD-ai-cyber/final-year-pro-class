<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'security.php';
require 'config.php';
require_once 'email_helper.php';
require 'notification_helper.php';

// Start secure session and headers for this POST handler
start_secure_session();
// Apply security headers for this request.
send_security_headers();

if (!isset($_POST['import_students'])) {
    header("Location: ../forms/student-import.php");
    exit;
}

require_post_csrf();

if (!isset($_FILES['student_csv']) || $_FILES['student_csv']['error'] !== 0) {
    echo "<script>alert('CSV upload failed.'); location.href='../forms/student-import.php';</script>";
    exit;
}

// Simple size check (max 5 MB)
if ($_FILES['student_csv']['size'] > 5 * 1024 * 1024) {
    echo "<script>alert('File too large. Max 5MB allowed.'); location.href='../forms/student-import.php';</script>";
    exit;
}

$file_path = $_FILES['student_csv']['tmp_name'];
$original_name = $_FILES['student_csv']['name'];
$extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

$rows = [];

if ($extension === 'csv') {
    $handle = fopen($file_path, 'r');
    if (!$handle) {
        echo "<script>alert('CSV open failed.'); location.href='../forms/student-import.php';</script>";
        exit;
    }
    while (($row = fgetcsv($handle)) !== false) {
        $rows[] = $row;
    }
    fclose($handle);
} elseif ($extension === 'xlsx') {
    $autoload_path = __DIR__ . '/../vendor/autoload.php';
    if (file_exists($autoload_path)) {
        require_once $autoload_path;
    }

    if (!class_exists('PhpOffice\\PhpSpreadsheet\\IOFactory')) {
        echo "<script>alert('XLSX support ke liye PhpSpreadsheet install karna hoga.'); location.href='../forms/student-import.php';</script>";
        exit;
    }

    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path);
    $sheet = $spreadsheet->getActiveSheet();
    foreach ($sheet->toArray(null, true, true, false) as $row) {
        $rows[] = $row;
    }
} else {
    echo "<script>alert('Only CSV or XLSX allowed.'); location.href='../forms/student-import.php';</script>";
    exit;
}

if (empty($rows)) {
    echo "<script>alert('File is empty.'); location.href='../forms/student-import.php';</script>";
    exit;
}

function normalize_header($header)
{
    $header = trim($header);
    $header = strtolower($header);
    $header = preg_replace('/[^a-z0-9]+/', '_', $header);
    $header = trim($header, '_');
    return $header;
}

$core_aliases = [
    'student_name' => 'student_name',
    'name' => 'student_name',
    'full_name' => 'student_name',
    'student_email' => 'student_email',
    'email' => 'student_email',
    'email_id' => 'student_email',
    'student_num' => 'student_num',
    'mobile' => 'student_num',
    'phone' => 'student_num',
    'mobile_no' => 'student_num',
    'phone_no' => 'student_num',
    'contact' => 'student_num',
    'start_time' => 'start_time',
    'end_time' => 'end_time',
    'blood_group' => 'blood_group',
    'aadhar_number' => 'aadhar_number',
    'aadhar' => 'aadhar_number',
    'emergency_contact_name' => 'emergency_contact_name',
    'emergency_name' => 'emergency_contact_name',
    'emergency_contact_phone' => 'emergency_contact_phone',
    'emergency_phone' => 'emergency_contact_phone',
    'computer_knowledge' => 'computer_knowledge',
    'programming_interest' => 'programming_interest',
    'parent_occupation' => 'parent_occupation',
    'parent_email' => 'parent_email'
];

$headers = array_shift($rows);
if (!$headers) {
    echo "<script>alert('Header missing.'); location.href='../forms/student-import.php';</script>";
    exit;
}

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

$required = ['student_name', 'student_email', 'student_num'];
foreach ($required as $req) {
    if (!in_array($req, $header_map, true)) {
        echo "<script>alert('Required columns missing. Please include: student_name, student_email, student_num'); location.href='../forms/student-import.php';</script>";
        exit;
    }
}

$extra_field_ids = [];
foreach ($extra_headers as $index => $meta) {
    $field_key = mysqli_real_escape_string($con, $meta['field_key']);
    $field_label = mysqli_real_escape_string($con, $meta['field_label']);

    $check_stmt = $con->prepare('SELECT field_id FROM student_extra_fields WHERE field_key = ?');
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
        $ins_stmt = $con->prepare('INSERT INTO student_extra_fields (field_key, field_label) VALUES (?, ?)');
        if ($ins_stmt) {
            $ins_stmt->bind_param('ss', $field_key, $field_label);
            $ins_stmt->execute();
            $extra_field_ids[$index] = (int) $ins_stmt->insert_id;
            $ins_stmt->close();
        }
    }
}

// Passwords are emailed only, not stored in files

$inserted = 0;
$skipped = 0;
$email_failed = 0;
$duplicate_rows = [];
$seen_emails = [];
$seen_phones = [];

foreach ($rows as $row) {
    $row_data = [
        'student_name' => '',
        'student_email' => '',
        'student_num' => '',
        'start_time' => '',
        'end_time' => '',
        'blood_group' => '',
        'aadhar_number' => '',
        'emergency_contact_name' => '',
        'emergency_contact_phone' => '',
        'computer_knowledge' => '',
        'programming_interest' => '',
        'parent_occupation' => '',
        'parent_email' => ''
    ];

    foreach ($header_map as $index => $field_name) {
        $row_data[$field_name] = isset($row[$index]) ? trim($row[$index]) : '';
    }

    if ($row_data['student_name'] === '' || $row_data['student_email'] === '' || $row_data['student_num'] === '') {
        $skipped++;
        continue;
    }

    $password_chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789!@#$%';
    $plain_password = '';
    for ($i = 0; $i < 10; $i++) {
        $plain_password .= $password_chars[random_int(0, strlen($password_chars) - 1)];
    }

    $student_name = mysqli_real_escape_string($con, $row_data['student_name']);
    $student_email = mysqli_real_escape_string($con, $row_data['student_email']);
    $student_num = mysqli_real_escape_string($con, $row_data['student_num']);
    $start_time = mysqli_real_escape_string($con, $row_data['start_time']);
    $end_time = mysqli_real_escape_string($con, $row_data['end_time']);
    $password_hash = password_hash($plain_password, PASSWORD_DEFAULT);
    $blood_group = mysqli_real_escape_string($con, $row_data['blood_group']);
    $aadhar_number = mysqli_real_escape_string($con, $row_data['aadhar_number']);
    $emergency_contact_name = mysqli_real_escape_string($con, $row_data['emergency_contact_name']);
    $emergency_contact_phone = mysqli_real_escape_string($con, $row_data['emergency_contact_phone']);
    $computer_knowledge = mysqli_real_escape_string($con, $row_data['computer_knowledge']);
    $programming_interest = mysqli_real_escape_string($con, $row_data['programming_interest']);
    $parent_occupation = mysqli_real_escape_string($con, $row_data['parent_occupation']);
    $parent_email = mysqli_real_escape_string($con, $row_data['parent_email']);

    $email_key = strtolower(trim($row_data['student_email']));
    $phone_key = trim($row_data['student_num']);
    if (($email_key !== '' && isset($seen_emails[$email_key])) || ($phone_key !== '' && isset($seen_phones[$phone_key]))) {
        $skipped++;
        $duplicate_rows[] = $row_data['student_email'] . ' / ' . $row_data['student_num'];
        continue;
    }

    $dup_stmt = $con->prepare('SELECT student_id FROM add_students WHERE student_email = ? OR student_num = ? LIMIT 1');
    $dup_found = false;
    if ($dup_stmt) {
        $dup_stmt->bind_param('ss', $student_email, $student_num);
        $dup_stmt->execute();
        $dup_res = $dup_stmt->get_result();
        $dup_found = $dup_res && $dup_res->num_rows > 0;
        $dup_stmt->close();
    }
    if ($dup_found) {
        $skipped++;
        $duplicate_rows[] = $row_data['student_email'] . ' / ' . $row_data['student_num'];
        continue;
    }

    $ins_stmt = $con->prepare(
        'INSERT INTO add_students (student_name, student_email, student_num, start_time, end_time, password_hash, photo, blood_group, aadhar_number, emergency_contact_name, emergency_contact_phone, computer_knowledge, programming_interest, parent_occupation, parent_email)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );
    $ok = false;
    if ($ins_stmt) {
        $empty_photo = '';
        $ins_stmt->bind_param(
            'sssssssssssssss',
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
        $ok = $ins_stmt->execute();
        $new_student_id = (int) $ins_stmt->insert_id;
        $ins_stmt->close();
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

    // Add to password CSV array
    $password_rows[] = [$student_name, $student_email, $student_num, $plain_password];

    $email_ok = sendStudentCredentialsEmail($row_data['student_email'], $row_data['student_name'], $plain_password, $row_data['student_num']);
    if (!$email_ok) {
        $email_failed++;
    }

    // Student Welcome Notification (DB Only)
    sendNotification(
        $con,
        'student',
        $new_student_id,
        'Welcome',
        'Your student account has been created successfully.',
        'dashboard/student-dashboard.php'
    );

    // Admin Notification (DB Only)
    sendNotification(
        $con,
        'admin',
        1,
        'Student Imported',
        "Student: {$row_data['student_name']} ({$row_data['student_email']})",
        'show-details/show-student.php'
    );

    foreach ($extra_headers as $index => $meta) {
        if (!isset($row[$index])) {
            continue;
        }
        $value = trim($row[$index]);
        if ($value === '') {
            continue;
        }
        $field_id = isset($extra_field_ids[$index]) ? (int)$extra_field_ids[$index] : 0;
        if ($field_id > 0) {
            $safe_value = mysqli_real_escape_string($con, $value);
            $extra_stmt = $con->prepare('INSERT INTO student_extra_values (student_id, field_id, field_value) VALUES (?, ?, ?)');
            if ($extra_stmt) {
                $extra_stmt->bind_param('iis', $new_student_id, $field_id, $safe_value);
                $extra_stmt->execute();
                $extra_stmt->close();
            }
        }
    }
}

// Log Passwords to CSV
if (!empty($password_rows)) {
    $file_name = 'student_passwords_' . date('Ymd') . '.csv';
    $file_path = __DIR__ . '/../material_upload/student_passwords/' . $file_name;
    // Ensure parent directory exists? material_upload/student_passwords usually exists.
    append_password_csv($file_path, ['name', 'email', 'mobile', 'password'], $password_rows);
}

$message = "Import complete.\n";
$message .= "Inserted: $inserted\n";
$message .= "Skipped: $skipped\n";
$message .= "Email failed: $email_failed\n";
if (!empty($duplicate_rows)) {
    $dup_preview = implode(', ', array_slice($duplicate_rows, 0, 5));
    $message .= "Duplicates (email/phone already exists): $dup_preview";
    if (count($duplicate_rows) > 5) {
        $message .= '...';
    }
}

$_SESSION['import_message'] = $message;
header("Location: ../forms/student-add.php?import=1");
exit;

echo "<script>alert('" . addslashes($message) . "'); location.href='../forms/student-add.php';</script>";

?>
