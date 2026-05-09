<?php
// Error Reporting On
ini_set('display_errors', 1);
error_reporting(E_ALL);
require '../includes/security.php';
require '../includes/config.php';
require '../includes/notification_helper.php';

// Start secure session and headers
start_secure_session();
// Apply security headers for this request.
send_security_headers();
// Enforce role-based access control.
require_role(['admin', 'teacher'], '../login.php');

// --- API CONFIGURATION ---
$apiKey = defined('GEMINI_API_KEY') ? GEMINI_API_KEY : ($GLOBALS['gemini_api_key'] ?? ''); 
$apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=" . $apiKey;

// --- FETCH STUDENTS FOR DROPDOWN ---
$students = [];
$stu_res = null;
$stmt = $con->prepare("SELECT * FROM add_students");
if ($stmt) {
    $stmt->execute();
    $stu_res = $stmt->get_result();
    $stmt->close();
}

if($stu_res) {
    while($s = mysqli_fetch_assoc($stu_res)) {
        $students[] = $s;
    }
} else {
    echo "Database Error: " . mysqli_error($con);
}

// Handle POST form action.
if (isset($_POST['generate_exam'])) {
    require_post_csrf();

    // Value format: "ID|Name|Email"
    $studentData = explode("|", $_POST['student_select']); 
    
    if(count($studentData) < 3) {
        echo "<script>alert('Error: Student Email not found.');</script>";
    } else {
        $student_id = (int)$studentData[0];
        $student_name = $studentData[1];
        $student_email = $studentData[2];
        
        $course = $_POST['course_name'];
        $subject = $_POST['subject'];
        $topic = $_POST['syllabusText'];
        $difficulty = $_POST['difficulty'];
        $creation_method = $_POST['creation_method']; // AI or Manual

        $exam_date_input = trim($_POST['exam_date'] ?? '');
        $exam_time_input = trim($_POST['exam_time'] ?? '');
        $exam_datetime_raw = trim($exam_date_input . ' ' . $exam_time_input);
        $exam_date = $exam_datetime_raw !== '' ? date('Y-m-d H:i:s', strtotime($exam_datetime_raw)) : date('Y-m-d H:i:s');

        $questions = [];
        $error = false;

        if ($creation_method === 'AI') {
            // --- AI GENERATION LOGIC (Safe & Professional IEEE Standard) ---
            $promptText = "Generate exactly 25 professional MCQs based on IEEE assessment standards (concise stems, clear options) for student '$student_name' on topic '$topic' ($course). Difficulty: '$difficulty'. 
            Format: [{\"q\":\"\",\"code\":\"\",\"a\":\"\",\"b\":\"\",\"c\":\"\",\"d\":\"\",\"correct\":\"A\",\"explain\":\"\",\"search_query\":\"\"}]. 
            Respond with ONLY JSON array. Strictly brief (1-sentence) explanations.";

            $data = [
                "contents" => [["parts" => [["text" => $promptText]]]],
                "generationConfig" => [
                    "temperature" => 0.1,
                    "topP" => 0.95,
                    "maxOutputTokens" => 8192
                ]
            ];
            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            
            if(curl_errno($ch)){
                echo 'Curl Error: ' . curl_error($ch); die();
            }
            curl_close($ch);
            
            $jsonResponse = json_decode($response, true);
            if(isset($jsonResponse['error'])) {
                echo "<script>alert('API Error: " . $jsonResponse['error']['message'] . "');</script>";
                $error = true;
            } elseif(isset($jsonResponse['candidates'][0]['content']['parts'][0]['text'])) {
                $rawText = $jsonResponse['candidates'][0]['content']['parts'][0]['text'];
                $rawText = str_replace(["```json", "```"], "", $rawText);
                $questions = json_decode($rawText, true);
                if(!$questions) { $error = true; echo "JSON Parse Error."; }
            } else {
                echo "No Response from AI."; $error = true;
            }
        } else {
            // --- MANUAL ENTRY LOGIC ---
            if (isset($_POST['manual_questions']) && is_array($_POST['manual_questions'])) {
                foreach ($_POST['manual_questions'] as $mq) {
                    $questions[] = [
                        'q' => $mq['q'],
                        'code' => $mq['code'] ?? '',
                        'a' => $mq['a'],
                        'b' => $mq['b'],
                        'c' => $mq['c'],
                        'd' => $mq['d'],
                        'correct' => $mq['correct'],
                        'explain' => $mq['explain'] ?? '',
                        'search_query' => $subject . " " . $mq['q']
                    ];
                }
            } else {
                echo "<script>alert('Please add at least one question.');</script>";
                $error = true;
            }
        }

        if (!$error && !empty($questions)) {
            // Save to DB
            $stmt = $con->prepare("INSERT INTO student_exams (student_id, student_name, student_email, course_name, subject, topic_name, difficulty, total_questions, exam_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $count = count($questions);
            $stmt->bind_param("issssssis", $student_id, $student_name, $student_email, $course, $subject, $topic, $difficulty, $count, $exam_date);
            $stmt->execute();
            $exam_id = $stmt->insert_id;

            // 2. Insert questions using a PREPARED statement OUTSIDE the loop for speed
            $q_stmt = $con->prepare('INSERT INTO exam_questions (exam_id, question_text, code_snippet, opt_a, opt_b, opt_c, opt_d, correct_ans, explanation, video_link) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            
            if ($q_stmt) {
                foreach ($questions as $row) {
                    $q_text = $row['q'] ?? '';
                    $code = $row['code'] ?? '';
                    $oa = $row['a'] ?? '';
                    $ob = $row['b'] ?? '';
                    $oc = $row['c'] ?? '';
                    $od = $row['d'] ?? '';
                    $cans = $row['correct'] ?? 'A';
                    $exp = $row['explain'] ?? '';
                    
                    // Construct search query for video
                    $raw_search = isset($row['search_query']) ? $row['search_query'] : ($subject . " " . $q_text);
                    $vid = "https://www.youtube.com/results?search_query=" . urlencode($raw_search);

                    $q_stmt->bind_param('isssssssss', $exam_id, $q_text, $code, $oa, $ob, $oc, $od, $cans, $exp, $vid);
                    $q_stmt->execute();
                }
                $q_stmt->close();
            }

            $notif_title = 'New Exam Assigned';
            $notif_message = "New exam assigned: $course ($subject)";
            sendNotificationAndEmail($con, 'student', (int)$student_id, $notif_title, $notif_message, 'exam-section/show_exams.php');
            notifyParentByStudentId($con, (int)$student_id, $notif_title, $notif_message, 'exam-section/show_exams.php');

            echo "<script>alert('Exam Assigned Successfully!'); window.location.href='teacher_create_exam.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assign Exam</title>
    <link rel="stylesheet" href="exam-section-css/create_exam_style.css?v=<?php echo time(); ?>">
    <style>
        .method-toggle { display: flex; gap: 20px; margin-bottom: 20px; background: #f0f4f8; padding: 10px; border-radius: 8px; }
        .manual-section { border: 1px solid #ddd; padding: 15px; border-radius: 8px; margin-top: 20px; }
        .q-row { background: #fff; border: 1px solid #77c5f8; padding: 15px; border-radius: 5px; margin-bottom: 15px; position: relative; }
        .remove-q { position: absolute; right: 10px; top: 10px; color: red; cursor: pointer; font-weight: bold; }
        .add-btn { background: #28a745; color: #fff; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Assign Exam</h2>
        <form method="POST" id="examForm" onsubmit="handleFormSubmit(event)">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
            
            <div class="method-toggle">
                <label><input type="radio" name="creation_method" value="AI" checked onclick="toggleMode('AI')"> AI Generated</label>
                <label><input type="radio" name="creation_method" value="Manual" onclick="toggleMode('Manual')"> Manual Entry</label>
            </div>

            <div class="form-group">
                <label>Select Student:</label>
                <select name="student_select" required>
                    <option value="">-- Choose Student --</option>
                    <?php 
                    foreach($students as $s) { 
                        // 1. Name Fetch Logic
                        $name = "Unknown";
                        if(!empty($s['first_name'])) $name = $s['first_name'];
                        elseif(!empty($s['student_name'])) $name = $s['student_name'];
                        
                        $lname = "";
                        if(!empty($s['last_name'])) $lname = $s['last_name'];
                        $fullName = trim($name . " " . $lname);

                        // 2. ID Fetch Logic
                        $sid = !empty($s['student_id']) ? $s['student_id'] : (isset($s['id']) ? $s['id'] : '0');
                        
                        // 3. Email Fetch Logic (New)
                        $semail = "";
                        if(!empty($s['email'])) $semail = $s['email'];
                        elseif(!empty($s['Email'])) $semail = $s['Email'];
                        elseif(!empty($s['student_email'])) $semail = $s['student_email'];

                        if(empty($semail)) { $semail = "no_email"; } // Fallback
                    ?>
                        <option value="<?php echo $sid . '|' . $fullName . '|' . $semail; ?>">
                            <?php echo $fullName . " (ID: $sid) - " . $semail; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label>Course & Subject:</label>
                <input type="text" name="course_name" placeholder="Course (e.g. Java)" required>
                <input type="text" name="subject" placeholder="Subject (e.g. OOPs Concept)" required>
            </div>

            <div class="form-group">
                <label>Weekly Syllabus Covered:</label>
                <textarea name="syllabusText" rows="3" placeholder="What did this student learn this week?" required></textarea>
            </div>

            <div class="form-group">
                <label>Difficulty Level:</label>
                <select name="difficulty">
                    <option value="Easy">Easy (Beginner)</option>
                    <option value="Medium" selected>Medium (Standard)</option>
                    <option value="Hard">Hard (Expert)</option>
                </select>
            </div>

            <div class="form-group">
                <label>Exam Date & Time:</label>
                <div style="display:flex; gap:10px;">
                    <input type="date" name="exam_date" required style="flex:1;">
                    <input type="time" name="exam_time" required style="flex:1;">
                </div>
            </div>

            <div id="manual-section" class="manual-section" style="display:none;">
                <h3>Questions</h3>
                <div id="q-container"></div>
                <button type="button" class="add-btn" onclick="addQuestion()">+ Add Question</button>
            </div>

            <button type="submit" name="generate_exam" id="submitBtn">Generate & Assign Exam</button>
            <div id="loader" class="loader">Processing... Please wait...</div>
        </form>
    </div>

    <script>
        let qCount = 0;
        function toggleMode(mode) {
            const manual = document.getElementById('manual-section');
            const submitBtn = document.getElementById('submitBtn');
            if(mode === 'Manual') {
                manual.style.display = 'block';
                submitBtn.innerText = 'Save & Assign Exam';
                if(qCount === 0) addQuestion();
            } else {
                manual.style.display = 'none';
                submitBtn.innerText = 'Generate & Assign Exam';
            }
        }

        function addQuestion() {
            qCount++;
            const div = document.createElement('div');
            div.className = 'q-row';
            div.id = 'q_' + qCount;
            div.innerHTML = `
                <span class="remove-q" onclick="removeQ(${qCount})">X</span>
                <label>Question ${qCount}</label>
                <input type="text" name="manual_questions[${qCount}][q]" required placeholder="Enter question">
                <input type="text" name="manual_questions[${qCount}][code]" placeholder="Code Snippet (Optional)">
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px; margin-top:10px;">
                    <input type="text" name="manual_questions[${qCount}][a]" required placeholder="Option A">
                    <input type="text" name="manual_questions[${qCount}][b]" required placeholder="Option B">
                    <input type="text" name="manual_questions[${qCount}][c]" required placeholder="Option C">
                    <input type="text" name="manual_questions[${qCount}][d]" required placeholder="Option D">
                </div>
                <select name="manual_questions[${qCount}][correct]" required style="margin-top:10px;">
                    <option value="A">Correct: A</option>
                    <option value="B">Correct: B</option>
                    <option value="C">Correct: C</option>
                    <option value="D">Correct: D</option>
                </select>
                <input type="text" name="manual_questions[${qCount}][explain]" placeholder="Explanation" style="margin-top:10px;">
            `;
            document.getElementById('q-container').appendChild(div);
        }

        function removeQ(id) {
            document.getElementById('q_' + id).remove();
        }

        function handleFormSubmit(e) {
            document.getElementById('loader').style.display='block';
        }
    </script>
</body>
</html>
