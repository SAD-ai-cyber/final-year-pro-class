<?php
require '../includes/security.php';
require '../includes/config.php';

start_secure_session();
send_security_headers();
require_role('admin');

$success = '';
$error = '';
$csrf_token = csrf_token();

if (isset($_POST['submit_institute_info'])) {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = 'Invalid CSRF token. Please try again.';
    } else {
        $institute_name = mysqli_real_escape_string($con, trim($_POST['institute_name']));
        $institute_code = mysqli_real_escape_string($con, trim($_POST['institute_code']));
        $director_name = mysqli_real_escape_string($con, trim($_POST['director_name']));
        $institute_email = mysqli_real_escape_string($con, trim($_POST['institute_email']));
        $institute_phone = mysqli_real_escape_string($con, trim($_POST['institute_phone']));
        $institute_address = mysqli_real_escape_string($con, trim($_POST['institute_address']));
        $institute_city = mysqli_real_escape_string($con, trim($_POST['institute_city']));
        $institute_state = mysqli_real_escape_string($con, trim($_POST['institute_state']));
        $institute_pincode = mysqli_real_escape_string($con, trim($_POST['institute_pincode']));
        $institute_website = mysqli_real_escape_string($con, trim($_POST['institute_website']));
        $established_year = mysqli_real_escape_string($con, trim($_POST['established_year']));
        $registration_authority = mysqli_real_escape_string($con, trim($_POST['registration_authority']));
        $registration_number = mysqli_real_escape_string($con, trim($_POST['registration_number']));
        $courses_offered = mysqli_real_escape_string($con, trim($_POST['courses_offered']));
        
        // Check if institute info already exists
        $check = mysqli_query($con, "SELECT id FROM institute_basic_info LIMIT 1");
        
        if (mysqli_num_rows($check) > 0) {
            // Update existing record
            $query = "UPDATE institute_basic_info SET 
                      institute_name = '$institute_name',
                      institute_code = '$institute_code',
                      director_name = '$director_name',
                      institute_email = '$institute_email',
                      institute_phone = '$institute_phone',
                      institute_address = '$institute_address',
                      institute_city = '$institute_city',
                      institute_state = '$institute_state',
                      institute_pincode = '$institute_pincode',
                      institute_website = '$institute_website',
                      established_year = '$established_year',
                      registration_authority = '$registration_authority',
                      registration_number = '$registration_number',
                      courses_offered = '$courses_offered',
                      updated_at = NOW()
                      LIMIT 1";
        } else {
            // Insert new record
            $query = "INSERT INTO institute_basic_info 
                      (institute_name, institute_code, director_name, institute_email, institute_phone, 
                       institute_address, institute_city, institute_state, institute_pincode, institute_website,
                       established_year, registration_authority, registration_number, courses_offered)
                      VALUES 
                      ('$institute_name', '$institute_code', '$director_name', '$institute_email', '$institute_phone',
                       '$institute_address', '$institute_city', '$institute_state', '$institute_pincode', '$institute_website',
                       '$established_year', '$registration_authority', '$registration_number', '$courses_offered')";
        }
        
        if (mysqli_query($con, $query)) {
            $success = 'Institute basic information saved successfully!';
        } else {
            $error = 'Error saving information: ' . mysqli_error($con);
        }
    }
}

// Fetch existing data
$existing_data = mysqli_query($con, "SELECT * FROM institute_basic_info LIMIT 1");
$data = mysqli_num_rows($existing_data) > 0 ? mysqli_fetch_assoc($existing_data) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Computer Institute Basic Information</title>
    <link rel="stylesheet" href="../css/responsive-core.css?v=<?php echo time(); ?>">
    <style>
body {
    margin:0;
    font-family:"Segoe UI",Tahoma,sans-serif;
    background:#eef1f5;
}

.page-bg {
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:flex-start;
    padding:40px 15px;
}

.card-form {
    background:#fff;
    max-width:650px;
    width: 100%;
    border-radius:10px;
    padding:25px 28px;
    box-shadow:0 2px 8px rgba(0,0,0,0.08);
    box-sizing: border-box;
}

.form-title {
    text-align:center;
    color:#2b6fd6;
    font-size:22px;
    font-weight:600;
    margin-bottom:20px;
}

.form-row {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:14px;
    margin-bottom:14px;
}

.form-row-3 {
    display:grid;
    grid-template-columns:1fr 1fr 1fr;
    gap:14px;
    margin-bottom:14px;
}

.form-group {
    display:flex;
    flex-direction:column;
    margin-bottom:14px;
}

@media (max-width: 768px) {
    .form-row, .form-row-3 {
        grid-template-columns: 1fr !important;
    }
    
    .page-bg {
        padding: 10px !important;
    }
    
    .card-form {
        padding: 20px 15px !important;
    }
    
    .card-form {
        margin-top: 10px;
    }
}

label {
    font-size:13px;
    font-weight:500;
    margin-bottom:5px;
    color:#444;
}

input,select,textarea {
    border:1px solid #d6dbe1;
    border-radius:6px;
    padding:8px 10px;
    font-size:13px;
    background:#fafbfc;
}

input:focus,select:focus,textarea:focus {
    border-color:#2b6fd6;
    outline:none;
    background:#fff;
}

textarea { resize:vertical; }

.submit-btn {
    width:100%;
    margin-top:10px;
    background:#2b6fd6;
    border:none;
    color:#fff;
    font-size:14px;
    padding:10px;
    border-radius:6px;
    cursor:pointer;
}

.submit-btn:hover { background:#1f58ad; }

.success-message {
    background:#e6f7ee;
    color:#1b7a46;
    padding:10px;
    border-radius:6px;
    margin-bottom:15px;
    font-size:13px;
}

.error-message {
    background:#fdecea;
    color:#b42318;
    padding:10px;
    border-radius:6px;
    margin-bottom:15px;
    font-size:13px;
}
</style>
</head>
<body>
    <div class="page-bg">
        <div class="card-form">
            <h2 class="form-title">Computer Institute Basic Information</h2>

        <?php if ($success): ?>
        <div class="success-message"><?php echo $success; ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
        <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
            
            <div class="form-row">
                <div class="form-group">
                    <label for="institute_name">Institute Name</label>
                    <input type="text" name="institute_name" id="institute_name" 
                           placeholder="Enter institute name" 
                           value="<?php echo htmlspecialchars($data['institute_name'] ?? ''); ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="institute_code">Institute Code</label>
                    <input type="text" name="institute_code" id="institute_code" 
                           placeholder="Enter institute code" 
                           value="<?php echo htmlspecialchars($data['institute_code'] ?? ''); ?>" 
                           required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="director_name">Director/Owner Name</label>
                    <input type="text" name="director_name" id="director_name" 
                           placeholder="Enter director name" 
                           value="<?php echo htmlspecialchars($data['director_name'] ?? ''); ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="established_year">Established Year</label>
                    <input type="number" name="established_year" id="established_year" 
                           placeholder="YYYY" min="1800" max="<?php echo date('Y'); ?>" 
                           value="<?php echo htmlspecialchars($data['established_year'] ?? ''); ?>" 
                           required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="institute_email">Email Address</label>
                    <input type="email" name="institute_email" id="institute_email" 
                           placeholder="institute@example.com" 
                           value="<?php echo htmlspecialchars($data['institute_email'] ?? ''); ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="institute_phone">Phone Number</label>
                    <input type="tel" name="institute_phone" id="institute_phone" 
                           placeholder="+91 1234567890" 
                           value="<?php echo htmlspecialchars($data['institute_phone'] ?? ''); ?>" 
                           required>
                </div>
            </div>

            <div class="form-group">
                <label for="institute_website">Website URL</label>
                <input type="url" name="institute_website" id="institute_website" 
                       placeholder="https://www.example.com" 
                       value="<?php echo htmlspecialchars($data['institute_website'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="institute_address">Street Address</label>
                <textarea name="institute_address" id="institute_address" 
                          placeholder="Enter complete address" 
                          required><?php echo htmlspecialchars($data['institute_address'] ?? ''); ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="institute_city">City</label>
                    <input type="text" name="institute_city" id="institute_city" 
                           placeholder="Enter city" 
                           value="<?php echo htmlspecialchars($data['institute_city'] ?? ''); ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="institute_state">State</label>
                    <input type="text" name="institute_state" id="institute_state" 
                           placeholder="Enter state" 
                           value="<?php echo htmlspecialchars($data['institute_state'] ?? ''); ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="institute_pincode">PIN Code</label>
                    <input type="text" name="institute_pincode" id="institute_pincode" 
                           placeholder="Enter PIN code" pattern="[0-9]{6}" 
                           value="<?php echo htmlspecialchars($data['institute_pincode'] ?? ''); ?>" 
                           required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="registration_authority">Registration Authority</label>
                    <select name="registration_authority" id="registration_authority" required>
                        <option value="">Select Authority</option>
                        <option value="Government of India" <?php echo ($data['registration_authority'] ?? '') == 'Government of India' ? 'selected' : ''; ?>>Government of India</option>
                        <option value="State Government" <?php echo ($data['registration_authority'] ?? '') == 'State Government' ? 'selected' : ''; ?>>State Government</option>
                        <option value="NIELIT" <?php echo ($data['registration_authority'] ?? '') == 'NIELIT' ? 'selected' : ''; ?>>NIELIT (National Institute of Electronics & IT)</option>
                        <option value="ISO Certified" <?php echo ($data['registration_authority'] ?? '') == 'ISO Certified' ? 'selected' : ''; ?>>ISO Certified</option>
                        <option value="Private" <?php echo ($data['registration_authority'] ?? '') == 'Private' ? 'selected' : ''; ?>>Private</option>
                        <option value="Other" <?php echo ($data['registration_authority'] ?? '') == 'Other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="registration_number">Registration Number</label>
                    <input type="text" name="registration_number" id="registration_number" 
                           placeholder="Enter registration number" 
                           value="<?php echo htmlspecialchars($data['registration_number'] ?? ''); ?>" 
                           required>
                </div>
            </div>

            <div class="form-group">
                <label for="courses_offered">Courses Offered</label>
                <textarea name="courses_offered" id="courses_offered" 
                          placeholder="e.g., Basic Computer, MS Office, Programming, Web Development, Graphic Design, Tally, etc." 
                          required><?php echo htmlspecialchars($data['courses_offered'] ?? ''); ?></textarea>
            </div>

            <button type="submit" name="submit_institute_info" class="submit-btn">Save Information</button>
        </form>
    </div>
</div>
</body>
</html>
