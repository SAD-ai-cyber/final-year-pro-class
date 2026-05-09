<?php
require '../includes/security.php';
require '../includes/config.php';

// Start secure session and headers
start_secure_session();
// Apply security headers for this request.
send_security_headers();

// Check agar ID aayi hai
if (!isset($_GET['exam_id'])) {
    die("Error: No Exam ID selected.");
}

$exam_id = (int) ($_GET['exam_id'] ?? 0);

// 1. Exam Details Nikalo
$exam = null;
$stmt = $con->prepare('SELECT * FROM student_exams WHERE exam_id = ?');
if ($stmt) {
    $stmt->bind_param('i', $exam_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $exam = $res ? $res->fetch_assoc() : null;
    $stmt->close();
}

if(!$exam) {
    die("Exam not found.");
}

// 2. Questions aur Answers ka Log Nikalo
$details_res = null;
$stmt = $con->prepare(
    'SELECT q.question_text, q.correct_ans, q.explanation, q.video_link, l.student_answer, l.is_correct
     FROM exam_questions q
     JOIN exam_answers_log l ON q.id = l.question_id
     WHERE q.exam_id = ?'
);
if ($stmt) {
    $stmt->bind_param('i', $exam_id);
    $stmt->execute();
    $details_res = $stmt->get_result();
    $stmt->close();
}

// Pass/Fail Logic for CSS Class
$passing_marks = $exam['total_questions'] / 2;
$score_class = ($exam['marks_obtained'] >= $passing_marks) ? 'pass' : 'fail';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Report Card</title>
    <link rel="stylesheet" href="exam-section-css/student_report.css">
</head>
<body>

    <div class="report-container">
        <button onclick="window.print()" class="print-btn">Print Report</button>
        
        <div class="header">
            <h2>Exam Report Card</h2>
            <div class="student-info">
                <strong>Student:</strong><span style="color: red; font-weight: bold; font-size:22px;"> <?php echo $exam['student_name']; ?></span> | 
                <strong>ID:</strong><span style="color: red; font-weight: bold; font-size:20px;"> <?php echo $exam['student_id']; ?></span> <br>
                <strong>Topic:</strong> <?php echo $exam['course_name']; ?> - <?php echo $exam['topic_name']; ?>
            </div>
        </div>

        <div class="score-box <?php echo $score_class; ?>">
            Score Obtained: <?php echo $exam['marks_obtained']; ?> / <?php echo $exam['total_questions']; ?>
        </div>

        <h3>Detailed Analysis:</h3>

        <?php 
        $i = 1;
        while($row = mysqli_fetch_assoc($details_res)) { 
            // Determine classes based on correctness
            $cardClass = ($row['is_correct'] == 1) ? 'correct' : 'wrong';
            $statusHTML = ($row['is_correct'] == 1) 
                ? '<span class="status-correct">Correct</span>' 
                : '<span class="status-wrong">Wrong</span>';
        ?>
            <div class="question-card <?php echo $cardClass; ?>">
                <p><strong>Q<?php echo $i; ?>:</strong> <?php echo $row['question_text']; ?></p>
                
                <div class="ans-row">
                    <div><span class="label">Student Answer:</span> <?php echo $row['student_answer']; ?></div>
                    <div><span class="label">Result:</span> <?php echo $statusHTML; ?></div>
                </div>

                <?php if($row['is_correct'] == 0) { ?>
                    <div class="explanation-box">
                        <span class="label">Correct Answer:</span> <?php echo $row['correct_ans']; ?><br>
                        <span class="label">Explanation:</span> <?php echo $row['explanation']; ?>
                    </div>
                    
                    <?php if(!empty($row['video_link'])) { ?>
                        <a href="<?php echo $row['video_link']; ?>" target="_blank" class="video-link">Watch Solution</a>
                    <?php } ?>
                <?php } ?>
            </div>
        <?php $i++; } ?>
        
    </div>

</body>
</html>
