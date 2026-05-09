<?php
require '../includes/security.php';
require '../includes/config.php';

// Start secure session and headers
start_secure_session();
// Apply security headers for this request.
send_security_headers();

// 1. Check Login
if(!isset($_SESSION['username'])) {
    die("<div style='padding:20px; font-family:Arial;'><h3>Access Denied</h3><p>Please Login as Student First.</p></div>");
}

// 2. Filter Logic
$logged_in_email = $_SESSION['username'];

// 3. Fetch Pending Exam
// Fetch pending exam (prepared)
$stmt = $con->prepare(
    "SELECT * FROM student_exams WHERE status = 'Pending' AND student_email = ? ORDER BY exam_id DESC LIMIT 1"
);
$exam_data = null;
if ($stmt) {
    $stmt->bind_param('s', $logged_in_email);
    $stmt->execute();
    $res_exam = $stmt->get_result();
    $exam_data = $res_exam ? $res_exam->fetch_assoc() : null;
    $stmt->close();
}

// Agar koi Pending Exam nahi hai
if(!$exam_data) {
    $student_name = isset($_SESSION['display_name']) ? $_SESSION['display_name'] : 'Student';
    echo "<div style='font-family:Arial; padding:50px; text-align:center;'>
            <h2>Hello, $student_name</h2>
            <p style='color:#666;'>You have no pending exams right now.</p>
          </div>";
    exit;
}

$exam_id = $exam_data['exam_id'];
$res_questions = null;
$stmt = $con->prepare('SELECT * FROM exam_questions WHERE exam_id = ?');
if ($stmt) {
    $stmt->bind_param('i', $exam_id);
    $stmt->execute();
    $res_questions = $stmt->get_result();
    $stmt->close();
}

$csrf_token = csrf_token();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Exam</title>
    <link rel="stylesheet" href="exam-section-css/take_exam_style.css">
    <style>
        /* Security CSS: Selection Disable */
        body { 
            user-select: none; 
            -webkit-user-select: none; 
            -moz-user-select: none; 
            -ms-user-select: none;
        }
    </style>
</head>
<body>

    <div id="start-screen">
        <div class="start-header">
            <h1>Exam: <?php echo htmlspecialchars($exam_data['course_name']); ?></h1>
            <p><strong>Student:</strong> <?php echo htmlspecialchars($exam_data['student_name']); ?></p>
        </div>

        <div class="instructions-box">
            <strong>SECURITY RULES (3 Warnings, 4th Violation = Terminate):</strong>
            <ul style="color: #c0392b;">
                <li><strong>Tab Switching:</strong> 3 warnings, exam terminates on 4th attempt</li>
                <li><strong>Alt+Tab:</strong> 3 warnings, exam terminates on 4th attempt</li>
                <li><strong>Screenshots (PrtScn/Win+Shift+S):</strong> 3 warnings, exam terminates on 4th attempt</li>
                <li><strong>Right-Click:</strong> 3 warnings, exam terminates on 4th attempt</li>
                <li><strong>Copy/Paste (Ctrl+C/V):</strong> 3 warnings, exam terminates on 4th attempt</li>
                <li><strong>Page Refresh (F5/Ctrl+R):</strong> 3 warnings, exam terminates on 4th attempt</li>
                <li><strong>Developer Tools (F12):</strong> 3 warnings, exam terminates on 4th attempt</li>
                <li><strong>Fullscreen Exit:</strong> Auto-prevention - cannot exit fullscreen</li>
                <li><strong>Window Close:</strong> Not allowed during exam</li>
            </ul>
        </div>

        <button class="start-btn" onclick="startExam(); return false;">I Agree & Start Exam</button>
    </div>


    <div id="exam-interface" style="display:none;">
        
        <div class="header">
            <div><strong>Subject:</strong> <?php echo $exam_data['course_name']; ?></div>
            <div id="timer" class="timer">Time Left: 60:00</div>
        </div>

        <form id="examForm" action="submit_exam.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
            
            <input type="hidden" name="remarks" id="remarks_field" value="Completed Successfully">

            <?php 
            $i = 1; 
            while($row = mysqli_fetch_assoc($res_questions)) { 
            ?>
                <div class="question-block">
                    <div class="question">Q<?php echo $i; ?>: <?php echo $row['question_text']; ?></div>
                    
                    <?php if(!empty($row['code_snippet'])) { ?>
                        <div class="code-box"><pre><?php echo htmlspecialchars($row['code_snippet']); ?></pre></div>
                    <?php } ?>

                    <div class="options">
                        <label><input type="radio" name="ans[<?php echo $row['id']; ?>]" value="A"> A) <?php echo $row['opt_a']; ?></label>
                        <label><input type="radio" name="ans[<?php echo $row['id']; ?>]" value="B"> B) <?php echo $row['opt_b']; ?></label>
                        <label><input type="radio" name="ans[<?php echo $row['id']; ?>]" value="C"> C) <?php echo $row['opt_c']; ?></label>
                        <label><input type="radio" name="ans[<?php echo $row['id']; ?>]" value="D"> D) <?php echo $row['opt_d']; ?></label>
                    </div>
                </div>
            <?php 
            $i++; 
            } 
            ?>
            
            <button type="submit" name="submit_exam" class="submit-btn" id="submitBtn" onclick="return confirmSubmit();">Submit Exam</button>
        </form>
    </div>

    <script>
        // ===== SECURITY & EXAM STATE MANAGEMENT =====
        let examActive = false;
        let violationTracker = {
            tabSwitch: 0,
            altTab: 0,
            screenshot: 0,
            rightClick: 0,
            copyPaste: 0,
            refresh: 0,
            devTools: 0
        };
        const MAX_VIOLATIONS = 3; // 3 warnings, 4th violation = terminate
        
        // ===== VIOLATION HANDLER =====
        function handleViolation(violationType, displayName) {
            if (!examActive) return;
            
            violationTracker[violationType]++;
            const count = violationTracker[violationType];
            
            if (count === 1) {
                // Warning 1
                alert(`WARNING 1/3: ${displayName} detected!\n\nTwo more warnings left.`);
            } 
            else if (count === 2) {
                // Warning 2
                alert(`WARNING 2/3: ${displayName} detected again!\n\nOnly one more warning left.`);
            }
            else if (count === 3) {
                // Warning 3 (Final Warning)
                alert(`WARNING 3/3: FINAL WARNING!\n\nNext detection will terminate your exam immediately.`);
            }
            else if (count >= 4) {
                // TERMINATE
                autoSubmit(`Multiple Security Violations: ${displayName}`);
            }
        }

        // ===== EXAM START FUNCTION =====
        function startExam() {
            try {
                document.getElementById('start-screen').style.display = 'none';
                document.getElementById('exam-interface').style.display = 'block';
                examActive = true;
                
                // Inform parent dashboard that exam is active
                if (window.parent) {
                    window.parent.examActive = true;
                }

                console.log('Exam started - Security active');
                startTimer();
                
                // Enter Fullscreen
                const elem = document.documentElement;
                if (elem.requestFullscreen) {
                    elem.requestFullscreen().catch(err => console.log('Fullscreen error:', err));
                } else if (elem.webkitRequestFullscreen) {
                    elem.webkitRequestFullscreen();
                } else if (elem.mozRequestFullScreen) {
                    elem.mozRequestFullScreen();
                } else if (elem.msRequestFullscreen) {
                    elem.msRequestFullscreen();
                }
            } catch(e) {
                alert('Error starting exam: ' + e.message);
                console.error(e);
            }
        }

        // ===== TIMER FUNCTION =====
        function startTimer() {
            let duration = 60 * 60; // 60 Minutes
            let timerDisplay = document.getElementById("timer");

            let timerInterval = setInterval(function () {
                let m = parseInt(duration / 60, 10);
                let s = parseInt(duration % 60, 10);
                timerDisplay.textContent = "Time Left: " + (m < 10 ? "0"+m : m) + ":" + (s < 10 ? "0"+s : s);
                
                if (--duration < 0) {
                    clearInterval(timerInterval);
                    autoSubmit("Time Limit Exceeded");
                }
            }, 1000);
        }

        // ===== AUTO SUBMIT FUNCTION =====
        function autoSubmit(reason) {
            examActive = false;
            if (window.parent) window.parent.examActive = false;
            
            alert("EXAM TERMINATED!\n\nReason: " + reason);
            document.getElementById('remarks_field').value = "Terminated: " + reason;
            
            if (document.fullscreenElement) {
                document.exitFullscreen().catch(err => {});
            }
            document.getElementById('examForm').submit();
        }

        // ===== CONFIRM SUBMIT =====
        function confirmSubmit() {
            if (!examActive) {
                alert("Please start the exam first!");
                return false;
            }
            const confirmed = confirm("Are you sure you want to submit the exam?");
            if (confirmed) {
                examActive = false;
                if (window.parent) window.parent.examActive = false;
                
                if (document.fullscreenElement) {
                    document.exitFullscreen().catch(err => {});
                }
            }
            return confirmed;
        }

        // ===== SECURITY: TAB SWITCHING =====
        document.addEventListener('visibilitychange', function() {
            if (!examActive) return;
            
            if (document.hidden) {
                handleViolation('tabSwitch', 'Tab Switch Detected');
            }
            document.title = examActive ? "Online Exam" : "Exam Ended";
        });

        // ===== SECURITY: RIGHT CLICK =====
        document.addEventListener('contextmenu', event => {
            if(examActive) {
                event.preventDefault();
                handleViolation('rightClick', 'Right-Click Disabled');
            }
        });

        // ===== SECURITY: COPY/PASTE =====
        document.addEventListener('copy', e => { 
            if(examActive) {
                e.preventDefault();
                handleViolation('copyPaste', 'Copy Attempt');
            }
        });
        document.addEventListener('paste', e => { 
            if(examActive) {
                e.preventDefault();
                handleViolation('copyPaste', 'Paste Attempt');
            }
        });

        // ===== SECURITY: KEYBOARD SHORTCUTS =====
        document.addEventListener('keydown', function(e) {
            if (!examActive) return;
            
            // Alt+Tab
            if ((e.altKey && e.key === 'Tab') || (e.altKey && e.keyCode === 9)) {
                e.preventDefault();
                handleViolation('altTab', 'Alt+Tab Window Switch');
                return false;
            }
            
            // Windows+Shift+S (Screenshot Tool)
            // Windows Key (Meta / OS) + Shift + 'S'
            if ((e.metaKey || e.osKey) && e.shiftKey && (e.key === 's' || e.key === 'S' || e.code === 'KeyS')) {
                e.preventDefault();
                handleViolation('screenshot', 'Screenshot Tool (Win+Shift+S)');
                return false;
            }
            
            // PrintScreen Key
            if (e.key === 'PrintScreen' || e.code === 'PrintScreen') {
                e.preventDefault();
                // Clear clipboard
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText('Screenshots are disabled for this exam.');
                }
                handleViolation('screenshot', 'PrintScreen Key');
                
                // Visual block (Flash screen black briefly)
                document.body.style.opacity = "0";
                setTimeout(() => document.body.style.opacity = "1", 500);
            }
            
            // Ctrl+C, Ctrl+V, Ctrl+U
            if (e.ctrlKey && (e.key === 'c' || e.key === 'v' || e.key === 'u')) {
                e.preventDefault();
                handleViolation('copyPaste', 'Ctrl+' + e.key.toUpperCase());
            }
            
            // F12 (Developer Tools)
            if (e.key === 'F12') {
                e.preventDefault();
                handleViolation('devTools', 'Developer Tools (F12)');
            }
            
            // F5 (Refresh)
            if (e.key === 'F5') {
                e.preventDefault();
                handleViolation('refresh', 'Page Refresh (F5)');
                return false;
            }
            
            // Ctrl+R (Refresh)
            if (e.ctrlKey && e.key === 'r') {
                e.preventDefault();
                handleViolation('refresh', 'Page Refresh (Ctrl+R)');
                return false;
            }
        });

        // ===== SECURITY: FULLSCREEN LOCK =====
        document.addEventListener('fullscreenchange', function() {
            if (!examActive) return;
            
            if (!document.fullscreenElement) {
                setTimeout(() => {
                    const elem = document.documentElement;
                    elem.requestFullscreen().catch(err => {});
                }, 100);
            }
        });

        // ===== SECURITY: WINDOW CLOSE =====
        window.addEventListener('beforeunload', function(e) {
            if (examActive) {
                e.preventDefault();
                e.returnValue = '';
                return false;
            }
        });

        // ===== SECURITY: DISABLE RIGHT-CLICK MENU =====
        document.addEventListener('mousedown', function(e) {
            if (examActive && e.button === 2) {
                e.preventDefault();
                return false;
            }
        });

        // ===== CONSOLE WARNING =====
        if(examActive) {
            console.clear();
            console.log('%c EXAM SECURITY ACTIVE', 'color: red; font-size: 16px; font-weight: bold;');
            console.log('%cDo not use browser console. All activities are monitored.', 'color: orange; font-size: 12px;');
        }
    </script>
</body>
</html>
