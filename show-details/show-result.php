<?php
require '../includes/config.php';
require '../includes/security.php';
require '../includes/notification_helper.php';

// Security/session bootstrap.
start_secure_session();
// Apply security headers for this request.
apply_security_headers();
// Enforce role-based access control.
require_role(['admin', 'teacher', 'parent', 'student']);
$csrf_token = generate_csrf_token();

// Role aur Username nikalo
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$loggedInUser = isset($_SESSION['username']) ? $_SESSION['username'] : '';


// Admin aur Teacher dono ko permission milegi
$hasPermission = false;
if($role == 'admin' || $role == 'teacher') {
    $hasPermission = true;
}

// 1. DELETE LOGIC 
if (isset($_GET['delete_id']) && $hasPermission) {
    if (!verify_csrf_token($_GET['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }

    $id = (int)$_GET['delete_id'];
    $student_name = '';
    $exam_name = '';
    $module = '';
    $marks_obt = '';
    $total_marks = '';

    $stmt = mysqli_prepare($con, "SELECT Student_Name, Examination_name, Module, Marks_obtained, Total_Marks FROM add_result WHERE result_id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($res && ($row = mysqli_fetch_assoc($res))) {
            $student_name = $row['Student_Name'] ?? '';
            $exam_name = $row['Examination_name'] ?? '';
            $module = $row['Module'] ?? '';
            $marks_obt = $row['Marks_obtained'] ?? '';
            $total_marks = $row['Total_Marks'] ?? '';
        }
        mysqli_stmt_close($stmt);
    }

    if ($exam_name !== '' && $module !== '' && $marks_obt !== '' && $total_marks !== '') {
        $student_title = 'Result Updated';
        $student_message = "Exam: {$exam_name} | Module: {$module} | Marks: {$marks_obt}/{$total_marks}";
        deleteNotificationsByContent($con, $student_title, $student_message, 'show-details/show-result.php');
        deleteQueuedEmailsByContent($con, $student_title, $student_message, 'show-details/show-result.php');
    }

    if ($student_name !== '' && $exam_name !== '') {
        $admin_title = 'Result Added';
        $admin_message = "Student: {$student_name} | Exam: {$exam_name}";
        deleteNotificationsByContent($con, $admin_title, $admin_message, 'show-details/show-result.php');
        deleteQueuedEmailsByContent($con, $admin_title, $admin_message, 'show-details/show-result.php');
    }
    $stmt = mysqli_prepare($con, "DELETE FROM add_result WHERE result_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: show-result.php");
}

// 2. UPDATE LOGIC 
if (isset($_POST['save_btn']) && $hasPermission) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }

    $id = (int)$_POST['id'];
    $s_id = $_POST['sid'];
    $s_name = $_POST['sname'];
    $s_email = $_POST['semail'];
    $p_email = $_POST['pemail'];
    $e_name = $_POST['ename'];
    $module = $_POST['mod'];
    $marks_obt = $_POST['mobt'];
    $total_marks = $_POST['tmark'];
    $result_status = $_POST['result']; 
    $percentage = $_POST['percentage'];
    $grade = $_POST['grade'];
    $attendance_percentage = $_POST['attendance_percentage'];
    $performance_rating = $_POST['performance_rating'];
    $instructor_comments = $_POST['instructor_comments'];

    $update_query = "UPDATE add_result SET 
                     Student_ID=?, 
                     Student_Name=?, 
                     student_email=?, 
                     parent_email=?,
                     Examination_name=?, 
                     Module =?, 
                     Marks_obtained=?, 
                     Total_Marks=?, 
                     result_status=?,
                     percentage=?,
                     grade=?,
                     attendance_percentage=?,
                     performance_rating=?,
                     instructor_comments=?
                     WHERE result_id=?";

    $stmt = mysqli_prepare($con, $update_query);
    mysqli_stmt_bind_param(
        $stmt,
        "ssssssssssssssi",
        $s_id,
        $s_name,
        $s_email,
        $p_email,
        $e_name,
        $module,
        $marks_obt,
        $total_marks,
        $result_status,
        $percentage,
        $grade,
        $attendance_percentage,
        $performance_rating,
        $instructor_comments,
        $id
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: show-result.php");
}

// 3. FETCH DATA LOGIC 

if ($hasPermission) {
    // Case 1: Admin & Teacher - Sabka result dekhenge
    $query = "SELECT * FROM add_result";
    $data = mysqli_query($con, $query);
} 
elseif ($role == 'parent') {
    // Case 2: Parent - Session email se data filter karega
    if(isset($_SESSION['email'])) {
        $parent_email = $_SESSION['email'];
        $stmt = mysqli_prepare($con, "SELECT * FROM add_result WHERE parent_email = ?");
        mysqli_stmt_bind_param($stmt, "s", $parent_email);
        mysqli_stmt_execute($stmt);
        $data = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
    } else {
        $data = mysqli_query($con, "SELECT * FROM add_result WHERE 1=0");
    }

} 
else {
    // Case 3: Student (Sirf apna result dekhega email ke base par)
    $stmt = mysqli_prepare($con, "SELECT * FROM add_result WHERE student_email = ?");
    mysqli_stmt_bind_param($stmt, "s", $loggedInUser);
    mysqli_stmt_execute($stmt);
    $data = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
}

$total = mysqli_num_rows($data);
?>

<html>
<head>
    <title>Student Result Details</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!--  php echo time();  har second URL ko badal deta hai-->
    <link rel="stylesheet" href="../css/details/parent.css?v=<?php echo time(); ?>">
</head>

<body class="fixed-scroll-page">
    <div class="card fixed-scroll-card">
        <div class="card-header fixed-scroll-header">
            <h2 class="card-title">All Student Results Details</h2>
        </div>

        <form action="" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
            <div class="card-body">
                <table class="details-table">
                    <thead>
                        <tr>
                            <?php if ($hasPermission) { ?>
                                <th>Result ID</th>
                            <?php } ?>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <?php if ($hasPermission) { ?>
                                <th>Student Email</th>
                                <th>Parent Email</th>
                            <?php } ?>
                            <th>Examination Name</th>
                            <th>Module</th>
                            <th>Marks Obtained</th>
                            <th>Total Marks</th>
                            <th>Result Status</th>
                            <th>Percentage</th>
                            <th>Grade</th>
                            <?php if ($hasPermission) { ?>
                                <th>Attendance %</th>
                                <th>Performance</th>
                                <th>Instructor Comments</th>
                                <th>Result Sheet</th>
                            <?php } ?>
                            <th>Date</th>
                            
                            <?php if ($hasPermission) { ?>
                                <th>Actions</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
            <?php
            if ($total > 0) {
                while ($result = mysqli_fetch_assoc($data)) {
                    
                    $image_src = "../material_upload/results/" . $result['result_sheet_file'];
                 
                    // EDIT MODE (Admin OR Teacher Only)
                    if (isset($_GET['edit_id']) && $_GET['edit_id'] == $result['result_id'] && $hasPermission) {
                      
                        echo "<tr>
                            <td>" . $result['result_id'] . "<input type='hidden' name='id' value='" . $result['result_id'] . "'></td>
                            <td><input type='text' name='sid' value='" . $result['Student_ID'] . "'></td>
                            <td><input type='text' name='sname' value='" . $result['Student_Name'] . "'></td>
                            <td><input type='email' name='semail' value='" . $result['student_email'] . "'></td>
                            <td><input type='email' name='pemail' value='" . $result['parent_email'] . "'></td>
                            <td><input type='text' name='ename' value='" . $result['Examination_name'] . "'></td>
                            <td><input type='text' name='mod' value='" . $result['Module'] . "'></td>
                            <td><input type='number' name='mobt' value='" . $result['Marks_obtained'] . "'></td>
                            <td><input type='number' name='tmark' value='" . $result['Total_Marks'] . "'></td>
                            <td><input type='text' name='result' value='" . $result['result_status'] . "'></td>
                            <td><input type='number' step='0.01' name='percentage' value='" . $result['percentage'] . "'></td>
                            <td><input type='text' name='grade' value='" . $result['grade'] . "'></td>
                            <td><input type='number' step='0.01' name='attendance_percentage' value='" . $result['attendance_percentage'] . "'></td>
                            <td><input type='text' name='performance_rating' value='" . $result['performance_rating'] . "'></td>
                            <td><input type='text' name='instructor_comments' value='" . $result['instructor_comments'] . "'></td>
                            
                            <td>
                                <img src='$image_src' alt='result Img' style='width:100px; height:100px; object-fit:cover; border-radius:4px;'>
                            </td>

                            <td>" . $result['upload_date'] . "</td>
                            
                            <td class='action-buttons'>
                                <button type='submit' name='save_btn'><i class='fa-solid fa-check'></i></button>
                                <a href='show-result.php' class='btn-cancel'><i class='fa-solid fa-xmark'></i></a>
                            </td>
                        </tr>";

                    } else {
                        // VIEW MODE
                        echo "<tr>";
                        
                        if ($hasPermission) {
                            echo "<td>" . $result['result_id'] . "</td>";
                        }

                        echo "<td>" . $result['Student_ID'] . "</td>
                              <td>" . $result['Student_Name'] . "</td>";

                        if ($hasPermission) {
                             echo "<td>" . $result['student_email'] . "</td>
                                   <td>" . $result['parent_email'] . "</td>";
                        }

                        echo "<td>" . $result['Examination_name'] . "</td>
                              <td>" . $result['Module'] . "</td>
                              <td>" . $result['Marks_obtained'] . "</td>
                              <td>" . $result['Total_Marks'] . "</td>
                              <td>" . $result['result_status'] . "</td>
                              <td>" . $result['percentage'] . "</td>
                              <td>" . $result['grade'] . "</td>";
                        
                        // Hidden columns from users
                        if ($hasPermission) {
                            echo "<td>" . $result['attendance_percentage'] . "</td>
                                  <td>" . $result['performance_rating'] . "</td>
                                  <td>" . $result['instructor_comments'] . "</td>
                                  <td>
                                    <img src='$image_src' alt='No Image' style='width:100px; height:100px; object-fit:cover; border-radius:4px; border:1px solid #ccc;'>
                                  </td>";
                        }

                        echo "<td>" . $result['upload_date'] . "</td>";

                            // Admin aur Teacher dono ko edit/delete buttons dikhenge
                            if($hasPermission){
                                echo "<td class='action-buttons'>
                                    <a href='show-result.php?edit_id=" . $result['result_id'] . "' class='btn-edit'><i class='fa-solid fa-pen-to-square'></i></a>
                                    <a href='show-result.php?delete_id=" . $result['result_id'] . "&csrf_token=" . urlencode($csrf_token) . "' class='btn-delete' onclick='return confirm(\"Delete Result?\")'><i class='fa-solid fa-trash'></i></a>
                                </td>";
                            }

                        echo "</tr>";
                    }
                }
            } else {
                
                // Colspan adjustment
                $colspan = $hasPermission ? 18 : 10;
                echo "<tr><td colspan='$colspan' style='text-align:center;'>No Records Found</td></tr>";
            }
            ?>
                    </tbody>
                </table>
            </div> 
        </form> 
    </div>
</body>
</html>
