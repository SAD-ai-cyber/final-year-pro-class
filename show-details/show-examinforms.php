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


//  Kya URL me 'delete_id' ye kya dekhega 
if (isset($_GET['delete_id'])) {
    if (!verify_csrf_token($_GET['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }

    $id = (int)$_GET['delete_id'];

    $exam_name = '';
    $course_name = '';
    $stmt = mysqli_prepare($con, "SELECT Exam_Name, Course_Name FROM exam_form WHERE exam_id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($res && ($row = mysqli_fetch_assoc($res))) {
            $exam_name = $row['Exam_Name'] ?? '';
            $course_name = $row['Course_Name'] ?? '';
        }
        mysqli_stmt_close($stmt);
    }

    if ($exam_name !== '' && $course_name !== '') {
        $notif_title = 'Exam Created';
        $notif_message = "Exam: {$exam_name} | Course: {$course_name}";
        deleteNotificationsByContent($con, $notif_title, $notif_message, 'show-details/show-examinforms.php');
        deleteQueuedEmailsByContent($con, $notif_title, $notif_message, 'show-details/show-examinforms.php');

        // Notify users that exam was cancelled
        sendNotificationToRole(
            $con,
            'student',
            'Exam Cancelled',
            "Exam: {$exam_name} | Course: {$course_name} has been cancelled.",
            'show-details/show-examinforms.php'
        );

        sendNotificationToRole(
            $con,
            'parent',
            'Exam Cancelled',
            "Exam: {$exam_name} | Course: {$course_name} has been cancelled.",
            'show-details/show-examinforms.php'
        );

        sendNotificationToRole(
            $con,
            'teacher',
            'Exam Cancelled',
            "Exam: {$exam_name} | Course: {$course_name} has been cancelled.",
            'show-details/show-examinforms.php'
        );

        sendNotificationToRole(
            $con,
            'admin',
            'Exam Deleted',
            "Exam: {$exam_name} | Course: {$course_name} has been removed.",
            'show-details/show-examinforms.php'
        );
    }

    // Database se wo row delete kar dega
    $stmt = mysqli_prepare($con, "DELETE FROM exam_form WHERE exam_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Page refresh kar rega
    header("Location: show-examinforms.php");
}


//  Kya User ne 'save_btn' dabaya hai? 
if (isset($_POST['save_btn'])) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }

    // Hidden ID le rahe hain taaki pata chale kis student ka data hai
    $id = (int)$_POST['id'];

    // Form se naya data variables me store kiya
    $e_name = $_POST['ename'];
    $c_name = $_POST['cname'];
    $module = $_POST['module'];
    $e_type = $_POST['etype'];
    $c_lab = $_POST['clab'];
    $e_date = $_POST['edate'];
    $s_time = $_POST['stime'];
    $e_time = $_POST['etime'];
    $marks = $_POST['marks'];
    $passing_marks = $_POST['passing_marks'];
    $no_of_questions = $_POST['no_of_questions'];
    $difficulty_level = $_POST['difficulty_level'];
    $invigilator_name = $_POST['invigilator_name'];
    $invigilator_email = $_POST['invigilator_email'];
    $exam_instructions = $_POST['exam_instructions'];

    // Update query 
    $update_query = "UPDATE exam_form SET 
                     Exam_Name=?, 
                     Course_Name=?, 
                     Module=?, 
                     Exam_Type=?, 
                     Comp_Lab=?, 
                     Exam_Date=?, 
                     Start_time=?, 
                     End_time=?, 
                     Total_Marks=?,
                     Passing_Marks=?,
                     No_Of_Questions=?,
                     Difficulty_Level=?,
                     Invigilator_Name=?,
                     Invigilator_Email=?,
                     Exam_Instructions=?
                     WHERE exam_id=?";

    $stmt = mysqli_prepare($con, $update_query);
    mysqli_stmt_bind_param(
        $stmt,
        "sssssssssssssssi",
        $e_name,
        $c_name,
        $module,
        $e_type,
        $c_lab,
        $e_date,
        $s_time,
        $e_time,
        $marks,
        $passing_marks,
        $no_of_questions,
        $difficulty_level,
        $invigilator_name,
        $invigilator_email,
        $exam_instructions,
        $id
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);


    header("Location: show-examinforms.php");
}

//  data lene keliye query chalayi
$query = "SELECT * FROM exam_form";
// execute kiya query ko
$data = mysqli_query($con, $query);
// table me kitne number of data row he vo store kiya
$total = mysqli_num_rows($data);
?>


<html>

<head>
    <title>Manage Examination Forms</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!--  php echo time();  har second URL ko badal deta hai-->
     <link rel="stylesheet" href="../css/details/exam-form.css?v=<?php echo time(); ?>">
    
    <style>
        .time-input-group {
            display: flex;
            gap: 5px;
            align-items: center;
        }
        .time-input-group .hhmm-input {
            width: 70px;
            padding: 6px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .time-input-group .ampm-select {
            width: 60px;
            padding: 6px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            background: white;
        }
        .time-input-group .hhmm-input:focus,
        .time-input-group .ampm-select:focus {
            outline: none;
            border-color: #4e73df;
        }
    </style>
</head>

<body class="fixed-scroll-page">
    <div class="card fixed-scroll-card">
        <div class="card-header fixed-scroll-header">
            <h2 class="card-title">Manage Examination Forms</h2>
        </div>

        <form action="" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">

            <div class="card-body">
                <table class="details-table">
                    <thead>
                        <tr>
                            <th>Exam Id</th>
                            <th>Exam Name</th>
                            <th>Course Name</th>
                            <th>Module</th>
                            <th>Exam Type</th>
                            <th>Comp Lab</th>
                            <th>Exam Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Total Marks</th>
                            <th>Passing Marks</th>
                            <th>No. Of Questions</th>
                            <th>Difficulty Level</th>
                            <th>Invigilator Name</th>
                            <th>Invigilator Email</th>
                            <th>Exam Instructions</th>
                            <th>Upload Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if ($total > 0) {
                            while ($result = mysqli_fetch_assoc($data)) {

                                //  Kya hume is row ko Edit karna hai?
                                if (isset($_GET['edit_id']) && $_GET['edit_id'] == $result['exam_id']) {

                                    //   edit karne keliye input box dale 
                                    echo "<tr>
                            <td>
                                " . $result['exam_id'] . "
                                <input type='hidden' name='id' value='" . $result['exam_id'] . "'>
                            </td>
                            <td><input type='text' name='ename' value='" . $result['Exam_Name'] . "'></td>
                            <td><input type='text' name='cname' value='" . $result['Course_Name'] . "'></td>
                            <td><input type='text' name='module' value='" . $result['Module'] . "'></td>
                            <td><input type='text' name='etype' value='" . $result['Exam_Type'] . "'></td>
                            <td><input type='text' name='clab' value='" . $result['Comp_Lab'] . "'></td>
                            <td><input type='date' name='edate' value='" . $result['Exam_Date'] . "'></td>
                            <td>";
                                    $stime_val = $result['Start_time'];
                                    $st_ts = strtotime($stime_val);
                                    $st_display = date('h:i', $st_ts);
                                    $st_ampm = date('A', $st_ts);
                                    echo "<div class='time-input-group'>
                                        <input type='hidden' name='stime' class='real-time-input' value='" . $stime_val . "'>
                                        <input type='text' class='hhmm-input' value='" . $st_display . "' placeholder='HH:MM' maxlength='5'>
                                        <select class='ampm-select'>
                                            <option value='AM'" . ($st_ampm=='AM' ? ' selected' : '') . ">AM</option>
                                            <option value='PM'" . ($st_ampm=='PM' ? ' selected' : '') . ">PM</option>
                                        </select>
                                    </div>";
                                echo "</td>
                            <td>";
                                    $etime_val = $result['End_time'];
                                    $et_ts = strtotime($etime_val);
                                    $et_display = date('h:i', $et_ts);
                                    $et_ampm = date('A', $et_ts);
                                    echo "<div class='time-input-group'>
                                        <input type='hidden' name='etime' class='real-time-input' value='" . $etime_val . "'>
                                        <input type='text' class='hhmm-input' value='" . $et_display . "' placeholder='HH:MM' maxlength='5'>
                                        <select class='ampm-select'>
                                            <option value='AM'" . ($et_ampm=='AM' ? ' selected' : '') . ">AM</option>
                                            <option value='PM'" . ($et_ampm=='PM' ? ' selected' : '') . ">PM</option>
                                        </select>
                                    </div>";
                                echo "</td>
                            <td><input type='number' name='marks' value='" . $result['Total_Marks'] . "'></td>
                            <td><input type='number' name='passing_marks' value='" . $result['Passing_Marks'] . "'></td>
                            <td><input type='number' name='no_of_questions' value='" . $result['No_Of_Questions'] . "'></td>
                            <td><input type='text' name='difficulty_level' value='" . $result['Difficulty_Level'] . "'></td>
                            <td><input type='text' name='invigilator_name' value='" . $result['Invigilator_Name'] . "'></td>
                            <td><input type='email' name='invigilator_email' value='" . $result['Invigilator_Email'] . "'></td>
                            <td><textarea name='exam_instructions'>" . $result['Exam_Instructions'] . "</textarea></td>
                            <td>" . $result['upload_date'] . "</td>
                            
                            <td class='action-buttons'>
                                <button type='submit' name='save_btn' title='Save Changes'>
                                    <i class='fa-solid fa-check'></i>
                                </button>
                                
                                <a href='show-examinforms.php' title='Cancel' class='btn-cancel'>
                                    <i class='fa-solid fa-xmark'></i>
                                </a>
                            </td>
                        </tr>";

                                } else {

                                    //data show kiya 
                                    echo "<tr>
                            <td>" . $result['exam_id'] . "</td>
                            <td>" . $result['Exam_Name'] . "</td>
                            <td>" . $result['Course_Name'] . "</td>
                            <td>" . $result['Module'] . "</td>
                            <td>" . $result['Exam_Type'] . "</td>
                            <td>" . $result['Comp_Lab'] . "</td>
                            <td>" . $result['Exam_Date'] . "</td>
                            <td>" . date('h:i A', strtotime($result['Start_time'])) . "</td>
                            <td>" . date('h:i A', strtotime($result['End_time'])) . "</td>
                            <td>" . $result['Total_Marks'] . "</td>
                            <td>" . $result['Passing_Marks'] . "</td>
                            <td>" . $result['No_Of_Questions'] . "</td>
                            <td>" . $result['Difficulty_Level'] . "</td>
                            <td>" . $result['Invigilator_Name'] . "</td>
                            <td>" . $result['Invigilator_Email'] . "</td>
                            <td>" . $result['Exam_Instructions'] . "</td>
                            <td>" . $result['upload_date'] . "</td>
                            
                        
                            <td class='action-buttons'>
                                <a href='show-examinforms.php?edit_id=" . $result['exam_id'] . "' class='btn-edit' title='Edit'>
                                    <i class='fa-solid fa-pen-to-square'></i>
                                </a>

                                <a href='show-examinforms.php?delete_id=" . $result['exam_id'] . "&csrf_token=" . urlencode($csrf_token) . "' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete?\")' title='Delete'>
                                    <i class='fa-solid fa-trash'></i>
                                </a>
                            </td>
                        </tr>";
                                }
                            }
                        } else {
                            echo "<tr><td colspan='18' style='text-align:center;'>No Records Found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <script>
        // Time input synchronization for AM/PM split inputs
        document.querySelectorAll('.time-input-group').forEach(group => {
            const realInput = group.querySelector('.real-time-input');
            const hhmmInput = group.querySelector('.hhmm-input');
            const ampmSelect = group.querySelector('.ampm-select');

            function updateRealTime() {
                let timeStr = hhmmInput.value.trim();
                let ampm = ampmSelect.value;
                
                if (!/^([0-1]?[0-9]):([0-5][0-9])$/.test(timeStr)) {
                    return;
                }
                
                let [hours, minutes] = timeStr.split(':').map(Number);
                
                if (ampm === 'PM' && hours < 12) hours += 12;
                if (ampm === 'AM' && hours === 12) hours = 0;
                
                let hoursStr = hours.toString().padStart(2, '0');
                let minutesStr = minutes.toString().padStart(2, '0');
                
                realInput.value = `${hoursStr}:${minutesStr}:00`;
            }

            hhmmInput.addEventListener('input', updateRealTime);
            hhmmInput.addEventListener('blur', updateRealTime);
            ampmSelect.addEventListener('change', updateRealTime);
        });
    </script>
</body>

</html>
