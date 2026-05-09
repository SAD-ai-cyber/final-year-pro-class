<?php
require '../includes/security.php';

// Start secure session and token for form
start_secure_session();
// Apply security headers for this request.
send_security_headers();
$csrf_token = csrf_token();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Students (CSV/XLSX)</title>
    <link rel="stylesheet" href="../css/forms/teacher-form.css">
</head>

<body>
    <div class="page-container">
        <div class="form-container">
            <h2>Import Students (CSV/XLSX)</h2>
            <p style="color:#666; margin-bottom:10px;">CSV me header row hona chahiye.</p>
            <ul style="color:#666; margin: 0 0 15px 18px;">
                <li>Required columns: student_name, student_email, student_num</li>
                <li>Optional columns: start_time, end_time, blood_group, aadhar_number, emergency_contact_name,
                    emergency_contact_phone, computer_knowledge, programming_interest, parent_occupation, parent_email</li>
                <li>Baaki extra columns automatic extra fields me save ho jayenge.</li>
                <li>Optional columns missing honge to blank save hoga. Required missing hua to row skip hoga.</li>
                <li>Email credentials student_email par send hoga (SMTP settings required).</li>
            </ul>

            <form action="../includes/student_import.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                <div class="form-group">
                    <label for="csv-file">Upload CSV File *</label>
                    <input type="file" id="csv-file" name="student_csv" accept=".csv,.xlsx" required>
                </div>

                <div class="button-container" style="display:flex; gap:12px; flex-wrap:wrap;">
                    <button type="submit" name="import_students" class="btn btn-add">Import</button>
                    <a href="student-add.php" class="btn btn-remove" style="text-decoration:none;">Back</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
