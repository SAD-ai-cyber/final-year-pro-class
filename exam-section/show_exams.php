<?php
require '../includes/security.php';
require '../includes/config.php';

// Start secure session and headers
start_secure_session();
// Apply security headers for this request.
send_security_headers();
// Enforce role-based access control.
require_role(['admin', 'teacher', 'parent', 'student'], '../login.php');
$csrf_token = csrf_token();

// Role aur Email set karna
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$logged_email = isset($_SESSION['username']) ? $_SESSION['username'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exam Records</title>

    <!--  php echo time();  har second URL ko badal deta hai-->
  <link rel="stylesheet" href="../exam-section/exam-section-css/show_exams_style.css?v=<?php echo time(); ?>">
</head>
<body>

    <div class="card">
        
        <div class="card-header">
            <h3 class="card-title">Exam Records List</h3>
        </div>

        <div class="card-body">
            <table class="details-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student Name & Email</th>
                        <th>Course / Topic</th>
                        <th>Date Assigned</th>
                        <th>Marks</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Logic: Student sirf apna dekhe, Admin sabka
                    if ($role == 'student') {
                        $stmt = $con->prepare('SELECT * FROM student_exams WHERE student_email = ? ORDER BY exam_id');
                        $res = null;
                        if ($stmt) {
                            $stmt->bind_param('s', $logged_email);
                            $stmt->execute();
                            $res = $stmt->get_result();
                            $stmt->close();
                        }
                    } else {
                        $stmt = $con->prepare('SELECT * FROM student_exams ORDER BY exam_id');
                        $res = null;
                        if ($stmt) {
                            $stmt->execute();
                            $res = $stmt->get_result();
                            $stmt->close();
                        }
                    }

                    if($res && mysqli_num_rows($res) > 0) {
                        while($row = mysqli_fetch_assoc($res)) {
                            
                            // Date Format
                            $dateShow = isset($row['exam_date']) ? date("Y-m-d H:i", strtotime($row['exam_date'])) : "N/A";
                            
                            // Marks Logic
                            $marksShow = ($row['status'] == 'Completed') ? $row['marks_obtained'] . " / " . $row['total_questions'] : "-";
                            
                            // Color Logic using CSS variables classes
                            $statusClass = ($row['status'] == 'Completed') ? 'text-success' : 'text-warning';

                            // Remark Logic
                            $remarkText = isset($row['remarks']) ? $row['remarks'] : 'Completed Successfully';
                            $remarkClass = 'text-dark';

                            if(strpos($remarkText, 'Terminated') !== false) {
                                $remarkClass = 'text-danger';
                                $remarkText = $remarkText;
                            } else if($remarkText == 'Completed Successfully') {
                                $remarkClass = 'text-success';
                                $remarkText = 'Clean';
                            }

                            $deleteBtn = '';
                            if ($role == 'admin' || $role == 'teacher') {
                                $deleteBtn = " | <a href='delete_exam.php?exam_id={$row['exam_id']}&csrf_token=" . urlencode($csrf_token) . "' class='view-link text-danger' onclick=\"return confirm('Delete this exam?');\">Delete</a>";
                            }

                            echo "<tr>
                                <td>#{$row['exam_id']}</td>
                                <td>
                                    <strong>{$row['student_name']}</strong><br>
                                    <span style='font-size: 0.85rem; color: #6c757d;'>{$row['student_email']}</span>
                                </td>
                                <td>
                                    {$row['course_name']}<br>
                                    <span style='font-size: 0.85rem; color: #6c757d;'>{$row['topic_name']}</span>
                                </td>
                                <td>{$dateShow}</td>
                                <td><strong>{$marksShow}</strong></td>
                                <td class='{$statusClass}'>{$row['status']}</td>
                                
                                <td class='{$remarkClass}'>{$remarkText}</td>

                                <td>
                                    <a href='view_student_result.php?exam_id={$row['exam_id']}' class='view-link'>View Report</a>{$deleteBtn}
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' style='text-align:center; padding:30px; color: #6c757d;'>No Exam Records Found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
