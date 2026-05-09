<?php
require '../includes/config.php';
require '../includes/security.php';
require '../includes/notification_helper.php';

// Security/session bootstrap.
start_secure_session();
// Apply security headers for this request.
apply_security_headers();
// Enforce role-based access control.
require_role(['admin', 'teacher']);
$csrf_token = generate_csrf_token();

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
$extra_fields_map = [];
$table_check = mysqli_query($con, "SHOW TABLES LIKE 'student_extra_fields'");
if ($table_check && mysqli_num_rows($table_check) > 0) {
    $extra_fields_res = mysqli_query($con, "SELECT field_id, field_label FROM student_extra_fields ORDER BY field_label ASC");
    if ($extra_fields_res) {
        while ($row = mysqli_fetch_assoc($extra_fields_res)) {
            $extra_fields[] = $row;
            $extra_fields_map[(int)$row['field_id']] = $row['field_label'];
        }
    }
}

//  DELETE LOGIC 
if (isset($_GET['delete_id'])) {
    if (!verify_csrf_token($_GET['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }

    $id = (int)$_GET['delete_id'];
    $student_name = '';
    $student_email = '';
    $stmt = mysqli_prepare($con, "SELECT student_name, student_email FROM add_students WHERE student_id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($res && ($row = mysqli_fetch_assoc($res))) {
            $student_name = $row['student_name'] ?? '';
            $student_email = $row['student_email'] ?? '';
        }
        mysqli_stmt_close($stmt);
    }

    deleteLatestNotificationForUser(
        $con,
        'student',
        $id,
        'Welcome',
        'Your student account has been created successfully.',
        'dashboard/student-dashboard.php'
    );

    if ($student_name !== '' && $student_email !== '') {
        $admin_title = 'New Student Added';
        $admin_message = "Student: {$student_name} ({$student_email})";
        deleteNotificationsByContent($con, $admin_title, $admin_message, 'show-details/show-student.php');
    }
    $stmt = mysqli_prepare($con, "DELETE FROM student_extra_values WHERE student_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare($con, "DELETE FROM add_students WHERE student_id  = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: show-student.php");
}

//UPDATE LOGIC 
if (isset($_POST['save_btn'])) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }

    $id = (int)$_POST['id'];
    $s_name = $_POST['sname'];
    $s_email =$_POST['semail'];
    $s_num =  $_POST['snum'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $blood_group = $_POST['blood_group'];
    $aadhar_number = $_POST['aadhar_number'];
    $emergency_contact_name = $_POST['emergency_contact_name'];
    $emergency_contact_phone = $_POST['emergency_contact_phone'];
    $computer_knowledge = $_POST['computer_knowledge'];
    $programming_interest = $_POST['programming_interest'];
    $parent_occupation = $_POST['parent_occupation'];
    $parent_email = $_POST['parent_email'];
   

    $update_query = "UPDATE add_students SET 
                     student_name=?, 
                     student_email=?, 
                     student_num =?,
                     start_time =?,
                     end_time = ?,
                     blood_group = ?,
                     aadhar_number = ?,
                     emergency_contact_name = ?,
                     emergency_contact_phone = ?,
                     computer_knowledge = ?,
                     programming_interest = ?,
                     parent_occupation = ?,
                     parent_email = ?
                     WHERE student_id=?";

    $stmt = mysqli_prepare($con, $update_query);
    mysqli_stmt_bind_param(
        $stmt,
        "sssssssssssssi",
        $s_name,
        $s_email,
        $s_num,
        $start_time,
        $end_time,
        $blood_group,
        $aadhar_number,
        $emergency_contact_name,
        $emergency_contact_phone,
        $computer_knowledge,
        $programming_interest,
        $parent_occupation,
        $parent_email,
        $id
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Extra fields update
    $stmt = mysqli_prepare($con, "DELETE FROM student_extra_values WHERE student_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if (!empty($_POST['extra_fields']) && is_array($_POST['extra_fields'])) {
        $insert_stmt = mysqli_prepare(
            $con,
            "INSERT INTO student_extra_values (student_id, field_id, field_value) VALUES (?, ?, ?)"
        );
        foreach ($_POST['extra_fields'] as $field_id => $field_value) {
            $field_id = (int)$field_id;
            $field_value = trim($field_value);
            if ($field_id > 0 && $field_value !== '') {
                mysqli_stmt_bind_param($insert_stmt, "iis", $id, $field_id, $field_value);
                mysqli_stmt_execute($insert_stmt);
            }
        }
        mysqli_stmt_close($insert_stmt);
    }

    header("Location: show-student.php");
}

// FETCH DATA
$query = "SELECT * FROM add_students";
$data = mysqli_query($con, $query);
$total = mysqli_num_rows($data);
?>

<html>
<head>
    <title>Student Details</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    
    <!--  php echo time();  har second URL ko badal deta hai-->
     <link rel="stylesheet" href="../css/details/parent.css?v=<?php echo time(); ?>">

    <style>
        .pass-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .pass-wrapper input {
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 4px;
            width: 100px;
        }
        .pass-wrapper i {
            margin-left: -25px;
            cursor: pointer;
            color: #555;
            z-index: 10;
        }

        /* Split Input Time Picker Styles */
        .time-input-group {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .time-input-group input[type="text"] {
            width: 60px;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
            text-align: center;
            font-size: 14px;
        }

        .time-input-group select {
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            background-color: #fff;
            cursor: pointer;
        }

        .time-input-group input:focus,
        .time-input-group select:focus {
            border-color: #4a90e2;
            outline: none;
            box-shadow: 0 0 3px rgba(74, 144, 226, 0.3);
        }

    </style>
</head>

<body class="fixed-scroll-page">
    <div class="card fixed-scroll-card">
        <div class="card-header fixed-scroll-header">
            <h2 class="card-title">All Students Details</h2>
        </div>

        <form action="" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
            <div class="card-body">
                <table class="details-table">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Student Email </th>
                            <th>Mobile Number </th>
                            <th>Start Time </th>
                            <th>End Time </th>
                            <th>Blood Group</th>
                            <th>Aadhar</th>
                            <th>Emergency Name</th>
                            <th>Emergency Phone</th>
                            <th>Computer Knowledge</th>
                            <th>Programming Interest</th>
                            <th>Parent Occupation</th>
                            <th>Parent Email</th>
                            <?php foreach ($extra_fields as $field) { ?>
                                <th><?php echo htmlspecialchars(formatExtraFieldLabel($field['field_label'])); ?></th>
                            <?php } ?>
                            <th>Photo</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php
            if ($total > 0) {
                while ($result = mysqli_fetch_assoc($data)) {
                    
                    $image_src = "../material_upload/student_photo/" . $result['photo'];

                    $extra_values = [];
                    if (!empty($extra_fields)) {
                        $extra_stmt = mysqli_prepare(
                            $con,
                            "SELECT field_id, field_value FROM student_extra_values WHERE student_id = ?"
                        );
                        $student_id = (int)$result['student_id'];
                        mysqli_stmt_bind_param($extra_stmt, "i", $student_id);
                        mysqli_stmt_execute($extra_stmt);
                        $extra_res = mysqli_stmt_get_result($extra_stmt);
                        if ($extra_res) {
                            while ($ev = mysqli_fetch_assoc($extra_res)) {
                                $extra_values[(int)$ev['field_id']] = $ev['field_value'];
                            }
                        }
                        mysqli_stmt_close($extra_stmt);
                    }
                 
// Handle GET query action.
                    if (isset($_GET['edit_id']) && $_GET['edit_id'] == $result['student_id']) {
                        $extra_cells = '';
                        if (!empty($extra_fields)) {
                            foreach ($extra_fields as $field) {
                                $field_id = (int)$field['field_id'];
                                $value = isset($extra_values[$field_id]) ? htmlspecialchars($extra_values[$field_id]) : '-';
                                $extra_cells .= "<td><input type='text' name='extra_fields[$field_id]' value='" . $value . "'></td>";
                            }
                        }
                      
                    //   edit karne vala code
                        echo "<tr>
                            <td>" . $result['student_id'] . "<input type='hidden' name='id' value='" . $result['student_id'] . "'></td>
                            
                            <td><input type='text' name='sname' value='" . $result['student_name'] . "'></td>
                            <td><input type='email' name='semail' value='" . $result['student_email'] . "'></td>
                            <td><input type='text' name='snum' value='" . $result['student_num'] . "'></td>";
                            
                            // START TIME LOGIC
                            $start_time_val = $result['start_time']; 
                            $s_ts = strtotime($start_time_val);
                            $s_display = date('h:i', $s_ts);
                            $s_ampm = date('A', $s_ts);
                            
                            echo "<td>
                                <div class='time-input-group'>
                                    <input type='hidden' name='start_time' class='real-time-input' value='" . $start_time_val . "'>
                                    <input type='text' class='hhmm-input' value='" . $s_display . "' placeholder='HH:MM' maxlength='5'>
                                    <select class='ampm-select'>
                                        <option value='AM' " . ($s_ampm=='AM' ? 'selected' : '') . ">AM</option>
                                        <option value='PM' " . ($s_ampm=='PM' ? 'selected' : '') . ">PM</option>
                                    </select>
                                </div>
                            </td>";

                            // END TIME LOGIC
                            $end_time_val = $result['end_time'];
                            $e_ts = strtotime($end_time_val);
                            $e_display = date('h:i', $e_ts);
                            $e_ampm = date('A', $e_ts);

                            echo "<td>
                                <div class='time-input-group'>
                                    <input type='hidden' name='end_time' class='real-time-input' value='" . $end_time_val . "'>
                                    <input type='text' class='hhmm-input' value='" . $e_display . "' placeholder='HH:MM' maxlength='5'>
                                    <select class='ampm-select'>
                                        <option value='AM' " . ($e_ampm=='AM' ? 'selected' : '') . ">AM</option>
                                        <option value='PM' " . ($e_ampm=='PM' ? 'selected' : '') . ">PM</option>
                                    </select>
                                </div>
                            </td>";
                            
                            echo "<td><input type='text' name='blood_group' value='" . $result['blood_group'] . "'></td>
                            <td><input type='text' name='aadhar_number' value='" . $result['aadhar_number'] . "'></td>
                            <td><input type='text' name='emergency_contact_name' value='" . $result['emergency_contact_name'] . "'></td>
                            <td><input type='text' name='emergency_contact_phone' value='" . $result['emergency_contact_phone'] . "'></td>
                            <td><input type='text' name='computer_knowledge' value='" . $result['computer_knowledge'] . "'></td>
                            <td><input type='text' name='programming_interest' value='" . $result['programming_interest'] . "'></td>
                            <td><input type='text' name='parent_occupation' value='" . $result['parent_occupation'] . "'></td>
                            <td><input type='email' name='parent_email' value='" . $result['parent_email'] . "'></td>
                            " . $extra_cells . "
                            
                            <td>
                                <img src='$image_src' alt='student Img' style='width:100px; height:100px; object-fit:cover; border-radius:4px;'>
                            </td>

                            <td>" . $result['created_at'] . "</td>
                            
                            <td class='action-buttons'>
                                <button type='submit' name='save_btn'><i class='fa-solid fa-check'></i></button>
                                <a href='show-student.php' class='btn-cancel'><i class='fa-solid fa-xmark'></i></a>
                            </td>
                        </tr>";

                    } else {
             
                        $extra_cells = '';
                        if (!empty($extra_fields)) {
                            foreach ($extra_fields as $field) {
                                $field_id = (int)$field['field_id'];
                                $value = isset($extra_values[$field_id]) ? htmlspecialchars($extra_values[$field_id]) : '-';
// Handle GET query action.
                                if (isset($_GET['edit_id']) && $_GET['edit_id'] == $result['student_id']) {
                                    $extra_cells .= "<td><input type='text' name='extra_fields[$field_id]' value='" . $value . "'></td>";
                                } else {
                                    $extra_cells .= "<td>" . $value . "</td>";
                                }
                            }
                        }

                        echo "<tr>
                           
                             <td>" . $result['student_id'] . "</td>
                            <td>" . $result['student_name'] . "</td>
                            <td>" . $result['student_email'] . "</td>
                            <td>" . $result['student_num'] . "</td>
                            <td>" . date('h:i A', strtotime($result['start_time'])) . "</td>
                            <td>" . date('h:i A', strtotime($result['end_time'])) . "</td>
                            <td>" . $result['blood_group'] . "</td>
                            <td>" . $result['aadhar_number'] . "</td>
                            <td>" . $result['emergency_contact_name'] . "</td>
                            <td>" . $result['emergency_contact_phone'] . "</td>
                            <td>" . $result['computer_knowledge'] . "</td>
                            <td>" . $result['programming_interest'] . "</td>
                            <td>" . $result['parent_occupation'] . "</td>
                            <td>" . $result['parent_email'] . "</td>
                            " . $extra_cells . "
                            
                            <td>
                                <img src='$image_src' alt='No Image' style='width:100px; height:100px; object-fit:cover; border-radius:4px; border:1px solid #ccc;'>
                            </td>

                             <td>" . $result['created_at'] . "</td>
                            <td class='action-buttons'>
                                <a href='show-student.php?edit_id=" . $result['student_id'] . "' class='btn-edit'><i class='fa-solid fa-pen-to-square'></i></a>
                                <a href='show-student.php?delete_id=" . $result['student_id'] . "&csrf_token=" . urlencode($csrf_token) . "' class='btn-delete' onclick='return confirm(\"Delete Student?\")'><i class='fa-solid fa-trash'></i></a>
                            </td>
                        </tr>";
                    }
                }
            } else {
                $colspan = 17 + count($extra_fields);
                echo "<tr><td colspan='" . $colspan . "' style='text-align:center;'>No Students Found</td></tr>";
            }
            ?>
                    </tbody>
                </table>
            </div> 
        </form> 
    </div>

  
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Sync logic for Split Inputs
        const groups = document.querySelectorAll('.time-input-group');
        
        groups.forEach(group => {
            const realInput = group.querySelector('.real-time-input');
            const hhmmInput = group.querySelector('.hhmm-input');
            const ampmSelect = group.querySelector('.ampm-select');
            
            function updateRealTime() {
                let timeStr = hhmmInput.value.trim();
                let ampm = ampmSelect.value;
                
                // Regex to check HH:MM format (allows 1-12 hours)
                // If invalid, we don't update key hidden input to avoid breaking DB with garbage
                if (!/^([0-1]?[0-9]):([0-5][0-9])$/.test(timeStr)) {
                    return; // Invalid format, skip
                }
                
                let [hours, minutes] = timeStr.split(':').map(Number);
                
                // Convert to 24h
                if (ampm === 'PM' && hours < 12) hours += 12;
                if (ampm === 'AM' && hours === 12) hours = 0;
                
                // Create HH:MM:00 string
                let hoursStr = hours.toString().padStart(2, '0');
                let minutesStr = minutes.toString().padStart(2, '0');
                
                realInput.value = `${hoursStr}:${minutesStr}:00`;
            }
            
            // Listen for changes
            hhmmInput.addEventListener('input', updateRealTime);
            hhmmInput.addEventListener('change', function() {
                // Auto-format on blur/change to ensure 2 digits
                let parts = hhmmInput.value.split(':');
                if (parts.length === 2) {
                    let h = parseInt(parts[0]) || 0;
                    let m = parseInt(parts[1]) || 0;
                    if(h > 12) h = 12; // cap at 12
                    if(h < 1 && h !== 0) h = 1; 
                    hhmmInput.value = `${h.toString().padStart(2,'0')}:${m.toString().padStart(2,'0')}`;
                    updateRealTime();
                }
            });
            ampmSelect.addEventListener('change', updateRealTime);
        });
    });
</script>
</html>
