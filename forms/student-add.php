<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require '../includes/security.php';
require '../includes/config.php';

// Start secure session and token for forms
start_secure_session();
// Apply security headers for this request.
send_security_headers();
$csrf_token = csrf_token();

function formatExtraFieldLabel($label)
{
    $label = trim($label);
    if ($label === '') {
        return $label;
    }
    $label = str_replace(['_', '-'], ' ', $label);
    $label = preg_replace('/\s+/', ' ', $label);
    return 'Extra: ' . ucwords($label);
}

$extra_fields = [];
$table_check = mysqli_query($con, "SHOW TABLES LIKE 'student_extra_fields'");
if ($table_check && mysqli_num_rows($table_check) > 0) {
    $extra_field_query = mysqli_query($con, "SELECT field_id, field_label FROM student_extra_fields ORDER BY field_label ASC");
    if ($extra_field_query) {
        while ($row = mysqli_fetch_assoc($extra_field_query)) {
            $extra_fields[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
    <link rel="stylesheet" href="../css/forms/teacher-form.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/responsive-core.css?v=<?php echo time(); ?>">
</head>

<body>
    <?php if (!empty($_SESSION['import_message'])) { ?>
        <script>
            alert("<?php echo addslashes($_SESSION['import_message']); ?>");
            if (window.location.search.indexOf('import=1') !== -1) {
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        </script>
        <?php unset($_SESSION['import_message']); ?>
    <?php } ?>
    <div class="page-container flex-stack" style="padding: 20px;">
        <!-- Left: Add Student Form -->
        <div class="form-container" style="flex: 2;">
            <h2>Add Student</h2>
            <form id="add-student-form" action="../includes/add_student.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                <!-- PERSONAL INFORMATION SECTION -->
                <h3 style="color: #333; margin-top: 20px; border-bottom: 2px solid #4e73df; padding-bottom: 10px;">Personal Information</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="add-student-name">Student Full Name *</label>
                        <input type="text" id="add-student-name" name="student_name" placeholder="Enter full name" required>
                    </div>
                    <div class="form-group">
                        <label for="add-blood">Blood Group</label>
                        <select id="add-blood" name="blood_group" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; background-color: #ffffff; color: #333; cursor: pointer;">
                            <option value="">Select Blood Group</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="add-aadhar">Aadhar Number</label>
                        <input type="text" id="add-aadhar" name="aadhar_number" placeholder="Enter 12-digit Aadhar number" maxlength="12">
                    </div>
                </div>

                <!-- CONTACT INFORMATION SECTION -->
                <h3 style="color: #333; margin-top: 20px; border-bottom: 2px solid #4e73df; padding-bottom: 10px;">Contact Information</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="add-email">Email Address *</label>
                        <input type="email" id="add-email" name="student_email" placeholder="Enter email address" required>
                    </div>
                    <div class="form-group">
                        <label for="student-num">Mobile Number *</label>
                        <input type="tel" id="student-num" name="student_num" placeholder="Enter 10-digit mobile number"
                            maxlength="10" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="emergency-contact-name">Emergency Contact Name</label>
                        <input type="text" id="emergency-contact-name" name="emergency_contact_name" placeholder="Enter emergency contact name">
                    </div>
                    <div class="form-group">
                        <label for="emergency-contact-phone">Emergency Contact Phone</label>
                        <input type="tel" id="emergency-contact-phone" name="emergency_contact_phone" placeholder="Enter 10-digit phone" maxlength="10">
                    </div>
                </div>

                <!-- ACADEMIC INFORMATION SECTION -->
                <h3 style="color: #333; margin-top: 20px; border-bottom: 2px solid #4e73df; padding-bottom: 10px;">Academic Information</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="computer-knowledge">Computer Knowledge</label>
                        <select id="computer-knowledge" name="computer_knowledge" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; background-color: #ffffff; color: #333; cursor: pointer;">
                            <option value="">-- Select Level --</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert">Expert</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="programming-interest">Programming Interest</label>
                        <select id="programming-interest" name="programming_interest" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; background-color: #ffffff; color: #333; cursor: pointer;">
                            <option value="">-- Select --</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                            <option value="Maybe">Maybe</option>
                        </select>
                    </div>
                </div>

                <!-- PARENT INFORMATION SECTION -->
                <h3 style="color: #333; margin-top: 20px; border-bottom: 2px solid #4e73df; padding-bottom: 10px;">Parent/Guardian Information</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label for="parent-occupation">Parent Occupation</label>
                        <input type="text" id="parent-occupation" name="parent_occupation" placeholder="Enter parent occupation">
                    </div>
                    <div class="form-group">
                        <label for="parent-email">Parent Email</label>
                        <input type="email" id="parent-email" name="parent_email" placeholder="Enter parent email">
                    </div>
                </div>

                <!-- BATCH INFORMATION SECTION -->
                <h3 style="color: #333; margin-top: 20px; border-bottom: 2px solid #4e73df; padding-bottom: 10px;">Batch Timings</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="start-time">Batch Start Time *</label>
                        <div style="display:flex; gap:5px; align-items:center;">
                            <input type="hidden" id="start-time" name="start_time" required>
                            <select class="time-hour" data-target="start-time" style="width:65px; padding:8px; border:1px solid #ccc; border-radius:5px; font-size:14px; background:#fff;" required>
                                <option value="">HH</option>
                                <option value="01">01</option><option value="02">02</option><option value="03">03</option>
                                <option value="04">04</option><option value="05">05</option><option value="06">06</option>
                                <option value="07">07</option><option value="08">08</option><option value="09">09</option>
                                <option value="10">10</option><option value="11">11</option><option value="12">12</option>
                            </select>
                            <span style="font-weight:bold;">:</span>
                            <select class="time-minute compact-dropdown" data-target="start-time" style="width:65px; padding:8px; border:1px solid #ccc; border-radius:5px; font-size:14px; background:#fff;" required>
                                <option value="">MM</option>
                                <option value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option>
                                <option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option>
                                <option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option>
                                <option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option>
                                <option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option>
                                <option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option>
                                <option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option>
                                <option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option>
                                <option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option>
                                <option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option>
                                <option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option>
                                <option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option>
                            </select>
                            <select class="time-ampm" data-target="start-time" style="width:70px; padding:8px; border:1px solid #ccc; border-radius:5px; font-size:14px; background:#fff;" required>
                                <option value="AM">AM</option>
                                <option value="PM">PM</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="end-time">Batch End Time *</label>
                        <div style="display:flex; gap:5px; align-items:center;">
                            <input type="hidden" id="end-time" name="end_time" required>
                            <select class="time-hour" data-target="end-time" style="width:65px; padding:8px; border:1px solid #ccc; border-radius:5px; font-size:14px; background:#fff;" required>
                                <option value="">HH</option>
                                <option value="01">01</option><option value="02">02</option><option value="03">03</option>
                                <option value="04">04</option><option value="05">05</option><option value="06">06</option>
                                <option value="07">07</option><option value="08">08</option><option value="09">09</option>
                                <option value="10">10</option><option value="11">11</option><option value="12">12</option>
                            </select>
                            <span style="font-weight:bold;">:</span>
                            <select class="time-minute compact-dropdown" data-target="end-time" style="width:65px; padding:8px; border:1px solid #ccc; border-radius:5px; font-size:14px; background:#fff;" required>
                                <option value="">MM</option>
                                <option value="00">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option>
                                <option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option>
                                <option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option>
                                <option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option>
                                <option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option>
                                <option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option>
                                <option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option>
                                <option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option>
                                <option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option>
                                <option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option>
                                <option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option>
                                <option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option>
                            </select>
                            <select class="time-ampm" data-target="end-time" style="width:70px; padding:8px; border:1px solid #ccc; border-radius:5px; font-size:14px; background:#fff;" required>
                                <option value="AM">AM</option>
                                <option value="PM">PM</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- ACCOUNT SECURITY SECTION -->
                <h3 style="color: #333; margin-top: 20px; border-bottom: 2px solid #4e73df; padding-bottom: 10px;">Account Security</h3>
                <p style="color:#666; margin: 5px 0 15px;">Password auto-generate hoga, aapko manual dalna nahi padega.</p>

                <!-- EXTRA FIELDS SECTION -->
                <h3 style="color: #333; margin-top: 20px; border-bottom: 2px solid #4e73df; padding-bottom: 10px;">Extra Fields</h3>
                <?php if (!empty($extra_fields)) { ?>
                    <?php foreach ($extra_fields as $field) { ?>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="extra-field-<?php echo (int)$field['field_id']; ?>"><?php echo htmlspecialchars(formatExtraFieldLabel($field['field_label'])); ?></label>
                                <input type="text" id="extra-field-<?php echo (int)$field['field_id']; ?>" name="extra_fields[<?php echo (int)$field['field_id']; ?>]" placeholder="Enter <?php echo htmlspecialchars(formatExtraFieldLabel($field['field_label'])); ?>">
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p style="color:#666;">Abhi koi extra field nahi hai. CSV import ke time pe auto add ho jayega.</p>
                <?php } ?>

                <!-- PHOTO SECTION -->
                <h3 style="color: #333; margin-top: 20px; border-bottom: 2px solid #4e73df; padding-bottom: 10px;">Photo</h3>
                
                <div class="form-group">
                    <label for="student-photo">Upload Photo (ID/Passport Size) *</label>
                    <input type="file" id="student-photo" name="student_photo" accept="image/*" required>
                    <small style="color: #666; margin-top: 5px; display: block;">Recommended: 200x250 pixels, Max 5MB</small>
                </div>

                <div class="button-container">
                    <button type="submit" name="Add_Student" class="btn btn-add" id="add-student-submit">Add Student</button>
                </div>
            </form>
        </div>

        <!-- Right: Import and Remove Forms -->
        <div class="right-column" style="flex: 1; display: flex; flex-direction: column; gap: 32px;">
            <!-- Import Students (CSV/XLSX) -->
            <div class="form-container">
                <h2>Import Students (CSV/XLSX)</h2>
                <form action="../includes/student_import.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="student-csv">Upload File *</label>
                            <input type="file" id="student-csv" name="student_csv" accept=".csv,.xlsx" required>
                        </div>
                    </div>
                    <div class="button-container">
                        <button type="submit" name="import_students" class="btn btn-add">Import Students</button>
                    </div>
                </form>
            </div>
            <!-- Remove Student -->
            <div class="form-container">
                <h2>Remove Student</h2>
                <form id="delete-student-form" action="../includes/add_student.php" method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="delete-id">Student ID *</label>
                            <input type="number" id="delete-id" name="student_id" placeholder="Enter Student ID" required>
                        </div>
                        <div class="form-group">
                            <label for="delete-name">Student Name *</label>
                            <input type="text" id="delete-name" name="student_name_confirm" placeholder="Enter name to confirm" required>
                        </div>
                    </div>
                    <div class="button-container">
                        <button type="submit" name="Remove_Student" class="btn btn-remove">Remove Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>

    document.addEventListener('DOMContentLoaded', () => {

        const mobileInput = document.getElementById('student-num');

        // --- Mobile input validation logic (Yeh sahi hai aur ise rakha gaya hai) ---
        if (mobileInput) {
            mobileInput.addEventListener('input', () => {
                mobileInput.value = mobileInput.value.replace(/[^0-9]/g, '');
                if (mobileInput.value.length > 10) {
                    mobileInput.value = mobileInput.value.slice(0, 10);
                }
            });
        }

        const form = document.getElementById('add-student-form');
        const submitBtn = document.getElementById('add-student-submit');
        if (form && submitBtn) {
            form.addEventListener('submit', () => {
                submitBtn.style.pointerEvents = 'none';
                submitBtn.textContent = 'Please wait...';
            });
        }

        // AM/PM Time Conversion Logic for Dropdowns
        document.querySelectorAll('.time-hour').forEach(hourSelect => {
            const targetId = hourSelect.getAttribute('data-target');
            const minuteSelect = document.querySelector(`.time-minute[data-target="${targetId}"]`);
            const ampmSelect = document.querySelector(`.time-ampm[data-target="${targetId}"]`);
            const hiddenInput = document.getElementById(targetId);

            function updateHiddenTime() {
                const hours = hourSelect.value;
                const minutes = minuteSelect.value;
                const ampm = ampmSelect.value;
                
                if (!hours || !minutes) {
                    return;
                }
                
                let hour24 = parseInt(hours);
                
                if (ampm === 'PM' && hour24 < 12) hour24 += 12;
                if (ampm === 'AM' && hour24 === 12) hour24 = 0;
                
                hiddenInput.value = `${hour24.toString().padStart(2, '0')}:${minutes}:00`;
            }

            hourSelect.addEventListener('change', updateHiddenTime);
            minuteSelect.addEventListener('change', updateHiddenTime);
            ampmSelect.addEventListener('change', updateHiddenTime);
        });
    });
</script>

</html>
