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
    <title>Paper Schedule</title>
    <link rel="stylesheet" href="../css/forms/pap-tim-tbl.css?v=5">
</head>

<body>
    <div class="form-container">
            <h1>Paper Schedule</h1>

            <form id="schedule-form" action="../includes/paper_time_table.php" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
            <div class="form-row">
                <div class="form-group">
                    <label for="schedule-name">Schedule Name *</label>
                    <input type="text" id="schedule-name" name="schedule_name" placeholder="e.g., Mid-Term Exam Schedule" required>
                </div>
                <div class="form-group">
                    <label for="course">Select Course *</label>
                    <input type="text" name="course" id="course" placeholder="Enter course name" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="week-of">Week Starting From (Monday) *</label>
                    <input type="date" id="week-of" name="week_of" required>
                </div>
            </div>

            <div class="divider"></div>

            <div class="schedule-grid">
                <div class="grid-header">
                    <span>Day</span>
                    <span>Module / Subject</span>
                    <span>Exam Time (Start - End)</span>
                    <span>Computer Lab</span>
                </div>

                <div class="grid-row">
                    <span class="day-label">Monday</span>
                    <input type="text" name="monday_module" placeholder="Subject/Module name">
                    <div class="time-group">
                        <input type="time" name="monday_start_time">
                        <span>-</span>
                        <input type="time" name="monday_end_time">
                    </div>
                    <input type="text" name="monday_lab" placeholder="Lab name">
                </div>

                <div class="grid-row">
                    <span class="day-label">Tuesday</span>
                    <input type="text" name="tuesday_module" placeholder="Subject/Module name">
                    <div class="time-group">
                        <input type="time" name="tuesday_start_time">
                        <span>-</span>
                        <input type="time" name="tuesday_end_time">
                    </div>
                    <input type="text" name="tuesday_lab" placeholder="Lab name">
                </div>

                <div class="grid-row">
                    <span class="day-label">Wednesday</span>
                    <input type="text" name="wednesday_module" placeholder="Subject/Module name">
                    <div class="time-group">
                        <input type="time" name="wednesday_start_time">
                        <span>-</span>
                        <input type="time" name="wednesday_end_time">
                    </div>
                    <input type="text" name="wednesday_lab" placeholder="Lab name">
                </div>

                <div class="grid-row">
                    <span class="day-label">Thursday</span>
                    <input type="text" name="thursday_module" placeholder="Subject/Module name">
                    <div class="time-group">
                        <input type="time" name="thursday_start_time">
                        <span>-</span>
                        <input type="time" name="thursday_end_time">
                    </div>
                    <input type="text" name="thursday_lab" placeholder="Lab name">
                </div>

                <div class="grid-row">
                    <span class="day-label">Friday</span>
                    <input type="text" name="friday_module" placeholder="Subject/Module name">
                    <div class="time-group">
                        <input type="time" name="friday_start_time">
                        <span>-</span>
                        <input type="time" name="friday_end_time">
                    </div>
                    <input type="text" name="friday_lab" placeholder="Lab name">
                </div>

                <div class="grid-row">
                    <span class="day-label">Saturday</span>
                    <input type="text" name="saturday_module" placeholder="Subject/Module name">
                    <div class="time-group">
                        <input type="time" name="saturday_start_time">
                        <span>-</span>
                        <input type="time" name="saturday_end_time">
                    </div>
                    <input type="text" name="saturday_lab" placeholder="Lab name">
                </div>
            </div>

            <button type="submit" name="set_schedule" class="submit-btn">Set Schedule</button>
            </form>
    </div>
</body>

</html>
