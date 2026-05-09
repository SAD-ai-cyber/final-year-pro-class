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
    <title>Student Fee Details</title>
    <link rel="stylesheet" href="../css/forms/student-fee-det.css?v=<?php echo time(); ?>&refresh=2">
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


    <h2>Student Fee Details</h2>


    <form id="fee-details-form" action="../includes/std_fee_det.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

        <!-- STUDENT AUTO-SELECT DROPDOWN -->
        <div class="form-group autocomplete-wrapper">
            <label for="student-select">Select Student (ID / Name) *</label>
            <input type="text" id="student-select" name="student_search" placeholder="Search by ID or Name..." autocomplete="off">
            <ul id="studentList" class="autocomplete-list"></ul>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="student-id">Student ID *</label>
                <input type="text" id="student-id" name="student_id" placeholder="Auto-filled" required readonly>
            </div>
            <div class="form-group">
                <label for="student-name">Student Name *</label>
                <input type="text" name="student_name" id="student-name" placeholder="Auto-filled" required readonly>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="student-email">Student Email *</label>
                <input type="email" name="student_email" id="student-email" placeholder="Auto-filled" required readonly>
            </div>
            <div class="form-group">
                <label for="parent-email">Parent Email *</label>
                <input type="email" name="parent_email" id="parent-email" placeholder="Auto-filled" required readonly>
            </div>
        </div>
        
        <div class="form-group">
            <label for="course">Select Course *</label>
            <input type="text" name="course" id="course" placeholder="Enter course name" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="course-price">Course Price (?) *</label>
                <input type="number" id="course-price" name="course_price" placeholder="e.g., 50000" required>
            </div>
            <div class="form-group">
                <label for="paid-price">Paid Price (?) *</label>
                <input type="number" id="paid-price" name="paid_price" placeholder="e.g., 25000" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="discount">Discount / Concession (?)</label>
                <input type="number" id="discount" name="discount_amount" placeholder="Discount amount" min="0">
            </div>
            <div class="form-group">
                <label for="remaining-price">Remaining Balance (?) *</label>
                <input type="number" id="remaining-price" name="remaining_price" placeholder="Auto-calculated" readonly required>
            </div>
        </div>

        <!-- ACCOUNTING SPECIFIC FIELDS -->
        <div class="form-row">
            <div class="form-group">
                <label for="payment-method">Payment Method *</label>
                <select name="payment_method" id="payment-method" required>
                    <option value="">Select Payment Method</option>
                    <option value="Cash">Cash</option>
                    <option value="Cheque">Cheque</option>
                    <option value="Online">Online Transfer</option>
                    <option value="Bank">Bank Deposit</option>
                    <option value="Card">Credit/Debit Card</option>
                    <option value="UPI">UPI</option>
                </select>
            </div>
            <div class="form-group">
                <label for="transaction-id">Transaction ID / Cheque Number</label>
                <input type="text" id="transaction-id" name="transaction_id" placeholder="e.g., TXN123456">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="receipt-number">Bill / Receipt Number</label>
                <input type="text" id="receipt-number" name="receipt_number" placeholder="e.g., BILL-2025-001">
            </div>
            <div class="form-group">
                <label for="date">Payment Date *</label>
                <input type="date" id="date" name="payment_date" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="time">Payment Time *</label>
                <input type="time" id="time" name="payment_time" required>
            </div>
            <div class="form-group">
                <label for="fee-receipt">Upload Receipt *</label>
                <input type="file" id="fee-receipt" name="fee_receipt" accept="image/*, .pdf" required>
            </div>
        </div>

        <div class="form-group">
            <label for="notes">Payment Notes / Remarks</label>
            <textarea name="payment_notes" id="notes" placeholder="Additional notes about this payment..." rows="3"></textarea>
        </div>

        <button type="submit" name="submit_fee_details" class="submit-btn" style="background-color: #1877f2; margin-top: 10px;">Add Fee Details</button>
    </form>
</div> <!-- end .form-body -->
</div> <!-- end .form-container -->

<script>
    // --- Clean Autocomplete Logic ---
    document.addEventListener('DOMContentLoaded', function () {
        const studentSelect = document.getElementById('student-select');
        const studentList = document.getElementById('studentList');
        if (studentSelect && studentList) {
            studentSelect.addEventListener('input', function (e) {
                const searchTerm = e.target.value.trim();
                if (searchTerm.length < 1) {
                    studentList.classList.remove('active');
                    studentList.innerHTML = '';
                    return;
                }
                fetch(`../includes/search_students.php?query=${encodeURIComponent(searchTerm)}`)
                    .then(response => response.json())
                    .then(data => {
                        studentList.innerHTML = '';
                        if (data.success && Array.isArray(data.students) && data.students.length > 0) {
                            data.students.forEach(student => {
                                const li = document.createElement('li');
                                li.className = 'autocomplete-item';
                                li.innerHTML = `<strong>${student.student_id}</strong> - ${student.student_name} (${student.student_email})`;
                                li.addEventListener('mousedown', function (e) {
                                    e.preventDefault(); // Prevent blur hiding list
                                    selectStudent(student.student_id);
                                });
                                studentList.appendChild(li);
                            });
                            studentList.classList.add('active');
                        } else {
                            studentList.innerHTML = '<li class="autocomplete-item">No students found</li>';
                            studentList.classList.add('active');
                        }
                    })
                    .catch(error => {
                        studentList.innerHTML = '<li class="autocomplete-item">Error fetching students</li>';
                        studentList.classList.add('active');
                        console.error('Error:', error);
                    });
            });

            studentSelect.addEventListener('blur', function () {
                setTimeout(() => {
                    studentList.classList.remove('active');
                }, 200);
            });
        }

        window.selectStudent = function (studentId) {
            fetch(`../includes/get_student_details.php?student_id=${encodeURIComponent(studentId)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const student = data.data;
                        document.getElementById('student-id').value = student.student_id;
                        document.getElementById('student-name').value = student.student_name;
                        document.getElementById('student-email').value = student.student_email;
                        document.getElementById('parent-email').value = student.parent_email || '';
                        
                        // Auto-fill course if available
                        if (student.course) document.getElementById('course').value = student.course;
                        
                        document.getElementById('student-select').value = `${student.student_id} - ${student.student_name}`;
                        if (studentList) studentList.classList.remove('active');
                    }
                })
                .catch(error => console.error('Error:', error));
        };

        // --- Clean Auto-Calculation Logic ---
        const coursePriceInput = document.getElementById('course-price');
        const paidPriceInput = document.getElementById('paid-price');
        const discountInput = document.getElementById('discount');
        const remainingPriceInput = document.getElementById('remaining-price');
        function calculateRemaining() {
            const coursePrice = parseFloat(coursePriceInput && coursePriceInput.value) || 0;
            const paidPrice = parseFloat(paidPriceInput && paidPriceInput.value) || 0;
            const discount = parseFloat(discountInput && discountInput.value) || 0;
            const remaining = (coursePrice - discount) - paidPrice;
            if (remainingPriceInput) remainingPriceInput.value = remaining.toFixed(2);
        }
        if (coursePriceInput) {
            coursePriceInput.addEventListener('input', calculateRemaining);
            coursePriceInput.addEventListener('change', calculateRemaining);
        }
        if (paidPriceInput) {
            paidPriceInput.addEventListener('input', calculateRemaining);
            paidPriceInput.addEventListener('change', calculateRemaining);
        }
        if (discountInput) {
            discountInput.addEventListener('input', calculateRemaining);
            discountInput.addEventListener('change', calculateRemaining);
        }
    });
    </script>
    
</body>
</html>
