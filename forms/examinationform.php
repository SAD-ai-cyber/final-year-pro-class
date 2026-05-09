<?php
require '../includes/security.php';

start_secure_session();
send_security_headers();
$csrf_token = csrf_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examination Form</title>
    <link rel="stylesheet" href="../css/responsive-core.css?v=<?php echo time(); ?>">

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
            width: 100%;
            max-width: 520px;
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
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 14px;
        }

        .form-row > .form-group {
            flex: 1;
            min-width: 200px;
        }

        @media (max-width: 480px) {
            .form-row > .form-group {
                min-width: 100%;
            }
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 14px;
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

        .time-row {
            display: flex;
            gap: 5px;
            align-items: center;
        }

        .time-hour,
        .time-minute,
        .time-ampm {
            height: 34px;
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
    </style>
</head>

<body>
<div class="page-bg">
    <div class="card-form">
        <h2 class="form-title">Examination Form</h2>

        <form id="examination-form" method="post" action="../includes/exam_form.php">

            <input type="hidden" name="csrf_token"
                   value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

            <div class="form-group">
                <label for="exam-name">Examination Name</label>
                <input type="text" id="exam-name" name="exam_name"
                       placeholder="e.g., Mid-Term Exam" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="course">Course Name</label>
                    <input type="text" id="course" name="course"
                           placeholder="Enter course name" required>
                </div>

                <div class="form-group">
                    <label for="module">Select Module</label>
                    <input type="text" name="module" id="module"
                           placeholder="e.g., HTML, CSS, JavaScript" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="exam-type">Exam Type</label>
                    <select name="exam_type" id="exam-type" required>
                        <option value="" disabled selected>Select Exam Type</option>
                        <option value="MCQ">MCQ (Multiple Choice)</option>
                        <option value="Descriptive">Descriptive</option>
                        <option value="Practical">Practical</option>
                        <option value="Mixed">Mixed</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="computer-lab">Computer Lab / Exam Center</label>
                    <input type="text" name="computer_lab" id="computer-lab"
                           placeholder="Lab name" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="exam-date">Exam Date</label>
                    <input type="date" id="exam-date" name="exam_date" required>
                </div>

                <div class="form-group">
                    <label>Start Time</label>
                    <div class="time-row">
                        <input type="hidden" id="start-time" name="start_time" required>

                        <select class="time-hour" data-target="start-time" required>
                            <option value="">HH</option>
                            <?php for($i=1;$i<=12;$i++):
                                $v=str_pad($i,2,'0',STR_PAD_LEFT); ?>
                                <option value="<?= $v ?>"><?= $v ?></option>
                            <?php endfor; ?>
                        </select>

                        <span>:</span>

                        <select class="time-minute" data-target="start-time" required>
                            <option value="">MM</option>
                            <?php for($i=0;$i<60;$i++):
                                $v=str_pad($i,2,'0',STR_PAD_LEFT); ?>
                                <option value="<?= $v ?>"><?= $v ?></option>
                            <?php endfor; ?>
                        </select>

                        <select class="time-ampm" data-target="start-time" required>
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>End Time</label>
                    <div class="time-row">
                        <input type="hidden" id="end-time" name="end_time" required>

                        <select class="time-hour" data-target="end-time" required>
                            <option value="">HH</option>
                            <?php for($i=1;$i<=12;$i++):
                                $v=str_pad($i,2,'0',STR_PAD_LEFT); ?>
                                <option value="<?= $v ?>"><?= $v ?></option>
                            <?php endfor; ?>
                        </select>

                        <span>:</span>

                        <select class="time-minute" data-target="end-time" required>
                            <option value="">MM</option>
                            <?php for($i=0;$i<60;$i++):
                                $v=str_pad($i,2,'0',STR_PAD_LEFT); ?>
                                <option value="<?= $v ?>"><?= $v ?></option>
                            <?php endfor; ?>
                        </select>

                        <select class="time-ampm" data-target="end-time" required>
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="total-marks">Total Marks</label>
                    <input type="number" id="total-marks" name="total_marks"
                           placeholder="e.g., 100" min="1" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="passing-marks">Minimum Passing Marks</label>
                    <input type="number" id="passing-marks" name="passing_marks"
                           placeholder="e.g., 40" required>
                </div>

                <div class="form-group">
                    <label for="no-questions">Number of Questions</label>
                    <input type="number" id="no-questions" name="no_of_questions"
                           placeholder="e.g., 50" min="1">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="difficulty-level">Difficulty Level</label>
                    <select name="difficulty_level" id="difficulty-level">
                        <option value="" disabled selected>Select Level</option>
                        <option value="Easy">Easy</option>
                        <option value="Medium">Medium</option>
                        <option value="Hard">Hard</option>
                        <option value="Mixed">Mixed</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="invigilator">Exam Invigilator Name</label>
                    <input type="text" name="invigilator_name" id="invigilator"
                           placeholder="Invigilator name">
                </div>
            </div>

            <div class="form-group">
                <label for="invigilator-email">Invigilator Email</label>
                <input type="email" name="invigilator_email"
                       id="invigilator-email"
                       placeholder="Invigilator email">
            </div>

            <div class="form-group">
                <label for="exam-instructions">Exam Instructions</label>
                <textarea name="exam_instructions"
                          id="exam-instructions"
                          rows="4"
                          placeholder="Enter exam instructions..."></textarea>
            </div>

            <button type="submit" name="add_examination"
                    class="submit-btn">
                Add Examination
            </button>

        </form>
    </div>
</div>

<script>
document.querySelectorAll('.time-hour').forEach(hourSelect => {
    const targetId = hourSelect.dataset.target;
    const minuteSelect = document.querySelector(`.time-minute[data-target="${targetId}"]`);
    const ampmSelect = document.querySelector(`.time-ampm[data-target="${targetId}"]`);
    const hiddenInput = document.getElementById(targetId);

    function updateHiddenTime() {
        const h = hourSelect.value;
        const m = minuteSelect.value;
        const ap = ampmSelect.value;
        if (!h || !m) return;

        let hr = parseInt(h);
        if (ap === "PM" && hr < 12) hr += 12;
        if (ap === "AM" && hr === 12) hr = 0;

        hiddenInput.value = hr.toString().padStart(2,'0') + ":" + m + ":00";
    }

    hourSelect.addEventListener('change', updateHiddenTime);
    minuteSelect.addEventListener('change', updateHiddenTime);
    ampmSelect.addEventListener('change', updateHiddenTime);
});
</script>

</body>
</html>
