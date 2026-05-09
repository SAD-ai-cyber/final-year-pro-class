<?php
require '../includes/security.php';

// Start secure session and token for form
start_secure_session();
// Apply security headers for this request.
send_security_headers();
$csrf_token = csrf_token();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Result</title>
    <link rel="stylesheet" href="../css/forms/result-add-form.css?v=<?php echo time(); ?>&refresh=1">
    <style>
        .autocomplete-list {
            list-style: none;
            padding: 0;
            margin: 0;
            border: 1px solid #ddd;
            border-top: none;
            max-height: 250px;
            overflow-y: auto;
            display: none;
            position: absolute;
            background: white;
            width: 100%;
            z-index: 1000;
            border-radius: 0 0 4px 4px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .autocomplete-list.active {
            display: block;
        }
        
        .autocomplete-item {
            padding: 12px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            transition: 0.2s;
        }
        
        .autocomplete-item:hover {
            background-color: #f0f7ff;
            color: #1877f2;
        }
        
        .autocomplete-wrapper {
            position: relative;
        }
    </style>
</head>

<body>
    <div class="form-container fixed-form">

        <div class="form-body">
            <h2>Add Result</h2>
            
            <form id="result-form" action="../includes/add_result.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                <!-- STUDENT AUTO-SELECT DROPDOWN -->
                <div class="form-group autocomplete-wrapper">
                    <label for="student-select">Select Student (ID / Name) *</label>
                    <input type="text" id="student-select" name="student_search" placeholder="Search by ID or Name..." autocomplete="off">
                    <ul id="studentList" class="autocomplete-list"></ul>
                </div>
                <!-- AUTO-FILLED FIELDS -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="student-id">Student ID / Roll No. *</label>
                        <input type="text" id="student-id" name="student_id" placeholder="Auto-filled" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="student-name">Student Name *</label>
                        <input type="text" name="Student_name" id="student-name" placeholder="Auto-filled" required readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="student-email">Student Email *</label>
                        <input type="email" id="student-email-input" name="student-email" placeholder="Auto-filled" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="parent-email">Parent Email *</label>
                        <input type="email" id="parent-email" name="parent-email" placeholder="Auto-filled" required readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="examination">Select Examination *</label>
                        <input type="text" name="Exam_name" id="examination" placeholder="Enter exam name" required>
                    </div>
                    <div class="form-group">
                        <label for="subject">Select Subject / Module *</label>
                        <input type="text" name="Subject_name" id="subject" placeholder="Enter subject name" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="marks-obtained">Marks Obtained *</label>
                        <input type="number" id="marks-obtained" name="marks_obtained" placeholder="e.g., 85" required>
                    </div>
                    <div class="form-group">
                        <label for="total-marks">Total Marks *</label>
                        <input type="number" id="total-marks" name="total_marks" placeholder="e.g., 100" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="status">Result Status *</label>
                        <select id="status" name="status" required>
                            <option value="" disabled selected>Select Status</option>
                            <option value="Pass">Pass</option>
                            <option value="Fail">Fail</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="percentage">Percentage (%) *</label>
                        <input type="number" id="percentage" name="percentage" placeholder="Auto-calculated" min="0" max="100" step="0.01" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="grade">Grade / Grade Point</label>
                        <select name="grade" id="grade">
                            <option value="" disabled selected>Select Grade</option>
                            <option value="A+">A+ (Excellent)</option>
                            <option value="A">A (Very Good)</option>
                            <option value="B+">B+ (Good)</option>
                            <option value="B">B (Average)</option>
                            <option value="C">C (Below Average)</option>
                            <option value="F">F (Fail)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="attendance-percentage">Attendance (%)</label>
                        <input type="number" id="attendance-percentage" name="attendance_percentage" placeholder="e.g., 90" min="0" max="100" step="0.5">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="performance-rating">Performance Rating</label>
                        <select name="performance_rating" id="performance-rating">
                            <option value="" disabled selected>Select Rating</option>
                            <option value="Outstanding">Outstanding</option>
                            <option value="Excellent">Excellent</option>
                            <option value="Good">Good</option>
                            <option value="Average">Average</option>
                            <option value="Needs Improvement">Needs Improvement</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="teacher-remarks">Teacher Remarks</label>
                        <input type="text" id="teacher-remarks" name="teacher_remarks" placeholder="Optional remarks">
                    </div>
                </div>
                <div class="form-group">
                    <label for="instructor-comments">Instructor Comments / Remarks</label>
                    <textarea name="instructor_comments" id="instructor-comments" placeholder="Enter any comments or remarks about student performance..." rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="result-sheet">Upload Result Sheet (PDF/Image)</label>
                    <input type="file" id="result-sheet" name="result_sheet" accept="image/*, .pdf">
                </div>
                <button type="submit" name="Add_Result" class="submit-btn">Add Result</button>
            </form>
        </div> <!-- end .form-body -->
    </div> <!-- end .form-container -->

    <script>
        const studentSelect = document.getElementById('student-select');
        const studentList = document.getElementById('studentList');
        
        // Input listener for autocomplete
        studentSelect.addEventListener('input', function(e) {
            const searchTerm = e.target.value.trim();
            console.log('Searching for:', searchTerm); // Debug log
            
            if (searchTerm.length < 1) {
                studentList.classList.remove('active');
                return;
            }
            
            // Fetch student data with cache busting
            const timestamp = new Date().getTime();
            fetch(`../includes/get_student_details.php?search=${encodeURIComponent(searchTerm)}&_t=${timestamp}`, { cache: "no-store" })
                .then(response => {
                    console.log('Search response:', response); // Debug log
                    return response.json();
                })
                .then(data => {
                    console.log('Search data:', data); // Debug log
                    if (data.success && data.data.length > 0) {
                        studentList.innerHTML = '';
                        data.data.forEach(student => {
                            const li = document.createElement('li');
                            li.className = 'autocomplete-item';
                            // Use Optional Chaining or Fallback
                            const id = student.student_id || '';
                            const name = student.student_name || '';
                            const email = student.student_email || '';
                            
                            li.innerHTML = `<strong>${id}</strong> - ${name} (${email})`;
                            li.addEventListener('mousedown', (e) => {
                                e.preventDefault(); // Prevent input blur from hiding list
                                window.selectStudent(id);
                            });
                            studentList.appendChild(li);
                        });
                        studentList.classList.add('active');
                    } else {
                        studentList.innerHTML = '<li class="autocomplete-item">No students found</li>';
                        studentList.classList.add('active');
                    }
                })
                .catch(error => console.error('Error fetching students:', error));
        });
        
        // Function to select student and auto-fill form
        window.selectStudent = function(studentId) {
            console.log('Selecting student ID:', studentId); // Debug log
            fetch(`../includes/get_student_details.php?student_id=${encodeURIComponent(studentId)}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Student details:', data); // Debug log
                    if (data.success) {
                        const student = data.data;
                        // Use correct keys (lowercase from PHP)
                        document.getElementById('student-id').value = student.student_id || '';
                        document.getElementById('student-name').value = student.student_name || '';
                        document.getElementById('student-email-input').value = student.student_email || '';
                        document.getElementById('parent-email').value = student.parent_email || '';
                        
                        // Auto-fill exam info if available
                        if (student.examination) document.getElementById('examination').value = student.examination;
                        if (student.subject) document.getElementById('subject').value = student.subject;
                        
                        // Update search input
                        const displayId = student.student_id || '';
                        const displayName = student.student_name || '';
                        document.getElementById('student-select').value = `${displayId} - ${displayName}`;
                        
                        studentList.classList.remove('active');
                    }
                })
                .catch(error => console.error('Error fetching details:', error));
        }
        
        // Close autocomplete on blur
        studentSelect.addEventListener('blur', function() {
            setTimeout(() => {
                studentList.classList.remove('active');
            }, 200);
        });

        // Calculate percentage and grade automatically
        document.getElementById('marks-obtained').addEventListener('change', calculateGrade);
        document.getElementById('total-marks').addEventListener('change', calculateGrade);

        function calculateGrade() {
            const obtained = parseFloat(document.getElementById('marks-obtained').value) || 0;
            const total = parseFloat(document.getElementById('total-marks').value) || 100;
            
            if (total > 0) {
                const percentage = (obtained / total) * 100;
                document.getElementById('percentage').value = percentage.toFixed(2);
                
                // Assign grade based on percentage
                let grade = '';
                if (percentage >= 90) grade = 'A+';
                else if (percentage >= 80) grade = 'A';
                else if (percentage >= 70) grade = 'B+';
                else if (percentage >= 60) grade = 'B';
                else if (percentage >= 50) grade = 'C';
                else grade = 'F';
                
                document.getElementById('grade').value = grade;
                
                // Assign status
                document.getElementById('status').value = (percentage >= 40) ? 'Pass' : 'Fail';
            }
        }
    </script>
</body>
</html>
