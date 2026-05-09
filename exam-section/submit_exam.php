<?php
require '../includes/security.php';
require '../includes/config.php';

// Start secure session and headers
start_secure_session();
// Apply security headers for this request.
send_security_headers();

// Handle POST form action.
if(isset($_POST['submit_exam']) || isset($_POST['exam_id'])) {
    require_post_csrf();
    
    $exam_id = (int) ($_POST['exam_id'] ?? 0);
    
    // --- IMPORTANCE: Remark Capture ---
    // Agar form normal submit hua to value "Completed Successfully" hogi
    // Agar auto-submit hua to value "Terminated: Tab Switching..." hogi
    $remarks = isset($_POST['remarks']) ? trim($_POST['remarks']) : 'Completed Successfully';

    // Questions check logic
    $res_qs = null;
    $stmt = $con->prepare('SELECT id, correct_ans FROM exam_questions WHERE exam_id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $exam_id);
        $stmt->execute();
        $res_qs = $stmt->get_result();
        $stmt->close();
    }

    $total_questions = $res_qs ? $res_qs->num_rows : 0;
    $marks = 0;

    // Prepare insert for answers log
    $log_stmt = $con->prepare(
        'INSERT INTO exam_answers_log (exam_id, question_id, student_answer, is_correct) VALUES (?, ?, ?, ?)'
    );

    while($res_qs && ($row = mysqli_fetch_assoc($res_qs))) {
        $qid = (int) $row['id'];
        $correct_opt = trim($row['correct_ans']);
        
        $student_ans = isset($_POST['ans'][$qid]) ? $_POST['ans'][$qid] : 'Not Attempted';
        $is_correct = 0;

        if($student_ans == $correct_opt) {
            $marks++;
            $is_correct = 1;
        }

        if ($log_stmt) {
            $log_stmt->bind_param('iisi', $exam_id, $qid, $student_ans, $is_correct);
            $log_stmt->execute();
        }
    }

    if ($log_stmt) {
        $log_stmt->close();
    }

   
    // Yahan hum 'remarks' column update kar rahe hain
    $stmt = $con->prepare('UPDATE student_exams SET status = ?, marks_obtained = ?, remarks = ? WHERE exam_id = ?');
    $ok = false;
    if ($stmt) {
        $status = 'Completed';
        $stmt->bind_param('sisi', $status, $marks, $remarks, $exam_id);
        $ok = $stmt->execute();
        $stmt->close();
    }
    
    if($ok) {
        echo "<script>
                alert('Exam Submitted! Score: $marks / $total_questions');
                window.location.href='show_exams.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }

} else {
    header("Location: show_exams.php");
}
?>
