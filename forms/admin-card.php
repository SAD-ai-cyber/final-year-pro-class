<?php
require '../includes/security.php';

start_secure_session();
send_security_headers();
require_role('admin', '../admin_login.php');
$csrf_token = csrf_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admit Card</title>

<style>
body {
    margin: 0;
    font-family: "Segoe UI", Tahoma, sans-serif;
    background: #eef1f5;
}

.page-bg {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 40px 15px;
}

.card-form {
    background: #fff;
    width: 520px;
    border-radius: 10px;
    padding: 25px 28px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.form-title {
    text-align: center;
    color: #2b6fd6;
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 20px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-bottom: 14px;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 14px;
    position: relative;
}

.form-row .form-group {
    margin-bottom: 0;
}

label {
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 5px;
    color: #444;
}

input,
select,
textarea {
    border: 1px solid #d6dbe1;
    border-radius: 6px;
    padding: 8px 10px;
    font-size: 13px;
    background: #fafbfc;
    transition: 0.2s;
}

input:focus,
select:focus,
textarea:focus {
    border-color: #2b6fd6;
    outline: none;
    background: #fff;
}

textarea {
    resize: vertical;
}

.submit-btn {
    width: 100%;
    margin-top: 10px;
    background: #2b6fd6;
    border: none;
    color: #fff;
    font-size: 14px;
    padding: 10px;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.2s;
}

.submit-btn:hover {
    background: #1f58ad;
}

/* Autocomplete */
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
    border-radius: 0 0 6px 6px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.autocomplete-list.active {
    display: block;
}

.autocomplete-item {
    padding: 10px;
    cursor: pointer;
    border-bottom: 1px solid #eee;
    font-size: 13px;
}

.autocomplete-item:hover {
    background-color: #f0f7ff;
    color: #1877f2;
}
</style>
</head>

<body>

<div class="page-bg">
<div class="card-form">

<h2 class="form-title">Admit Card / Hall Ticket</h2>

<form id="admit-card-form" action="../includes/admin_card.php" method="post" enctype="multipart/form-data">

<input type="hidden" name="csrf_token"
value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

<!-- STUDENT SEARCH -->
<div class="form-group">
<label for="student-select">Select Student (ID / Name)</label>
<input type="text" id="student-select" name="student_search"
placeholder="Search by ID or Name..." autocomplete="off">
<ul id="studentList" class="autocomplete-list"></ul>
</div>

<div class="form-row">
    <div class="form-group">
        <label for="student-id">Student ID / Roll No.</label>
        <input type="text" id="student-id" name="student-id" readonly required>
    </div>
    <div class="form-group">
        <label for="student-name">Student Name</label>
        <input type="text" id="student-name" name="student-name" readonly required>
    </div>
</div>

<div class="form-group">
    <label for="student-email">Student Email</label>
    <input type="email" id="student-email" name="student-email" readonly required>
</div>

<div class="form-row">
    <div class="form-group">
        <label for="course">Course Name</label>
        <input type="text" id="course" name="course" required>
    </div>
    <div class="form-group">
        <label for="examination">Examination Name</label>
        <input type="text" id="examination" name="examination" required>
    </div>
</div>

<div class="form-row">
    <div class="form-group">
        <label for="exam-date">Exam Date</label>
        <input type="date" id="exam-date" name="exam-date" required>
    </div>
    <div class="form-group">
        <label for="exam-time">Reporting Time</label>
        <input type="time" id="exam-time" name="exam-time" required>
    </div>
</div>

<div class="form-group">
    <label for="computer-lab">Exam Center / Lab</label>
    <input type="text" id="computer-lab" name="computer-lab" required>
</div>

<div class="form-row">
    <div class="form-group">
        <label for="registration-number">Registration Number</label>
        <input type="text" id="registration-number" name="registration-number" required>
    </div>
    <div class="form-group">
        <label for="seat-number">Seat Number / Roll Number</label>
        <input type="text" id="seat-number" name="seat-number" required>
    </div>
</div>

<div class="form-group">
<label for="card-validity">Hall Ticket Validity Date</label>
<input type="date" id="card-validity"
name="card_validity_date">
</div>

<div class="form-group">
<label for="exam-instructions">Exam Instructions</label>
<textarea id="exam-instructions"
name="exam_instructions"
rows="3"></textarea>
</div>

<div class="form-group">
<label for="student-photo">Upload Student Photo</label>
<input type="file" id="student-photo"
name="student_photo" accept="image/*">
</div>

<button type="submit" class="submit-btn"
name="insert_data">
Generate Card
</button>

</form>
</div>
</div>

<script>
const studentSelect = document.getElementById('student-select');
const studentList = document.getElementById('studentList');

studentSelect.addEventListener('input', function(e) {
    const searchTerm = e.target.value.trim();

    if (searchTerm.length < 1) {
        studentList.classList.remove('active');
        return;
    }

    fetch(`../includes/get_student_details.php?search=${encodeURIComponent(searchTerm)}`)
    .then(res => res.json())
    .then(data => {
        if (data.success && data.data.length > 0) {
            studentList.innerHTML = '';
            data.data.forEach(student => {
                const li = document.createElement('li');
                li.className = 'autocomplete-item';
                li.innerHTML =
`<strong>${student.student_id}</strong> - ${student.student_name} (${student.student_email})`;

                li.addEventListener('mousedown', (e) => {
                    e.preventDefault(); // Prevent input blur from hiding list too early
                   window.selectStudent(student.student_id);
                });
                studentList.appendChild(li);
            });
            studentList.classList.add('active');
        } else {
            studentList.innerHTML =
'<li class="autocomplete-item">No students found</li>';
            studentList.classList.add('active');
        }
    });
});

window.selectStudent = function(studentId) {
    console.log("Selecting student with ID:", studentId);
    
    fetch(`../includes/get_student_details.php?student_id=${encodeURIComponent(studentId)}`)
    .then(res => res.json())
    .then(data => {
        console.log("Received data:", data);
        if (data.success) {
            const s = data.data;

            // Basic Info
            document.getElementById('student-id').value = s.student_id || '';
            document.getElementById('student-name').value = s.student_name || '';
            document.getElementById('student-email').value = s.student_email || '';
            
            // Auto-fill more info if available
            if (s.course) document.getElementById('course').value = s.course;
            if (s.examination) document.getElementById('examination').value = s.examination;
            if (s.exam_date) document.getElementById('exam-date').value = s.exam_date;
            if (s.reporting_time) document.getElementById('exam-time').value = s.reporting_time;
            if (s.exam_center) document.getElementById('computer-lab').value = s.exam_center;
            
            // Search field updated text
            studentSelect.value = `${s.student_id} - ${s.student_name}`;

            studentList.classList.remove('active');
            console.log("Form auto-filled successfully!");
        } else {
            console.error("Data error:", data.message);
            alert("Error: " + (data.message || "Failed to fetch student details."));
        }
    })
    .catch(err => {
        console.error("Fetch error:", err);
        alert("System Error: Could not connect to student database. Check console for details.");
    });
}

studentSelect.addEventListener('blur', () => {
    setTimeout(()=>studentList.classList.remove('active'),200);
});
</script>

</body>
</html>
