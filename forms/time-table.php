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
    <title>Add Time Table</title>
    <link rel="stylesheet" href="../css/forms/time-table.css">
</head>

<body>

    <div class="container">
        <h1>Add Time Table</h1>

        <form id="timetableForm" action="../includes/add_timetable.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
            <div class="form-row">
                <div class="form-group">
                    <label for="batchName">Batch Name *</label>
                    <input type="text" id="batchName" name="batchName" placeholder="Enter batch name" required>
                </div>
                <div class="form-group">
                    <label for="course">Course *</label>
                    <input type="text" name="course" id="course" placeholder="Enter course name" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="duration">Course Duration (Months)</label>
                    <input type="text" name="duration" id="duration" placeholder="Enter duration in months">
                </div>
            </div>

            <div class="day-schedule">
                <div class="day-title">Monday</div>
                <div class="period-headers">
                    <div>Time Range</div>
                    <div>Topic/Subject</div>
                    <div>Instructor</div>
                </div>
                <div id="mondayPeriods">
                    <div class="period-row">
                        <select name="monday_time[]" required>
                            <option value="" disabled selected>Select Time</option>
                            <option value="09:00 - 11:00">09:00 - 11:00</option>
                            <option value="11:00 - 01:00">11:00 - 01:00</option>
                            <option value="01:00 - 03:00">01:00 - 03:00</option>
                            <option value="03:00 - 05:00">03:00 - 05:00</option>
                            <option value="05:00 - 07:00">05:00 - 07:00</option>
                            <option value="07:00 - 09:00">07:00 - 09:00</option>
                        </select>
                        <input type="text" name="monday_topic[]" placeholder="Topic Name" required>
                        <input type="text" name="monday_instructor[]" placeholder="Teacher-name" required>
                    </div>
                </div>
                <button type="button" class="add-period-btn" onclick="addPeriod('monday')">Add Period</button>
            </div>

            <div class="day-schedule">
                <div class="day-title">Tuesday</div>
                <div class="period-headers">
                    <div>Time Range</div>
                    <div>Topic/Subject</div>
                    <div>Instructor</div>
                </div>
                <div id="tuesdayPeriods">
                    <div class="period-row">
                        <select name="tuesday_time[]" required>
                            <option value="" disabled selected>Select Time</option>
                            <option value="09:00 - 11:00">09:00 - 11:00</option>
                            <option value="11:00 - 01:00">11:00 - 01:00</option>
                            <option value="01:00 - 03:00">01:00 - 03:00</option>
                            <option value="03:00 - 05:00">03:00 - 05:00</option>
                            <option value="05:00 - 07:00">05:00 - 07:00</option>
                            <option value="07:00 - 09:00">07:00 - 09:00</option>
                        </select>
                        <input type="text" name="tuesday_topic[]" placeholder="Topic Name" required>
                        <input type="text" name="tuesday_instructor[]" placeholder="Teacher-name" required>
                    </div>
                </div>
                <button type="button" class="add-period-btn" onclick="addPeriod('tuesday')">Add Period</button>
            </div>

            <div class="day-schedule">
                <div class="day-title">Wednesday</div>
                <div class="period-headers">
                    <div>Time Range</div>
                    <div>Topic/Subject</div>
                    <div>Instructor</div>
                </div>
                <div id="wednesdayPeriods">
                    <div class="period-row">
                        <select name="wednesday_time[]" required>
                            <option value="" disabled selected>Select Time</option>
                            <option value="09:00 - 11:00">09:00 - 11:00</option>
                            <option value="11:00 - 01:00">11:00 - 01:00</option>
                            <option value="01:00 - 03:00">01:00 - 03:00</option>
                            <option value="03:00 - 05:00">03:00 - 05:00</option>
                            <option value="05:00 - 07:00">05:00 - 07:00</option>
                            <option value="07:00 - 09:00">07:00 - 09:00</option>
                        </select>
                        <input type="text" name="wednesday_topic[]" placeholder="Topic Name" required>
                        <input type="text" name="wednesday_instructor[]" placeholder="Teacher-name" required>
                    </div>
                </div>
                <button type="button" class="add-period-btn" onclick="addPeriod('wednesday')">Add Period</button>
            </div>

            <div class="day-schedule">
                <div class="day-title">Thursday</div>
                <div class="period-headers">
                    <div>Time Range</div>
                    <div>Topic/Subject</div>
                    <div>Instructor</div>
                </div>
                <div id="thursdayPeriods">
                    <div class="period-row">
                        <select name="thursday_time[]" required>
                            <option value="" disabled selected>Select Time</option>
                            <option value="09:00 - 11:00">09:00 - 11:00</option>
                            <option value="11:00 - 01:00">11:00 - 01:00</option>
                            <option value="01:00 - 03:00">01:00 - 03:00</option>
                            <option value="03:00 - 05:00">03:00 - 05:00</option>
                            <option value="05:00 - 07:00">05:00 - 07:00</option>
                            <option value="07:00 - 09:00">07:00 - 09:00</option>
                        </select>
                        <input type="text" name="thursday_topic[]" placeholder="Topic Name" required>
                        <input type="text" name="thursday_instructor[]" placeholder="Teacher-name" required>
                    </div>
                </div>
                <button type="button" class="add-period-btn" onclick="addPeriod('thursday')">Add Period</button>
            </div>

            <div class="day-schedule">
                <div class="day-title">Friday</div>
                <div class="period-headers">
                    <div>Time Range</div>
                    <div>Topic/Subject</div>
                    <div>Instructor</div>
                </div>
                <div id="fridayPeriods">
                    <div class="period-row">
                        <select name="friday_time[]" required>
                            <option value="" disabled selected>Select Time</option>
                            <option value="09:00 - 11:00">09:00 - 11:00</option>
                            <option value="11:00 - 01:00">11:00 - 01:00</option>
                            <option value="01:00 - 03:00">01:00 - 03:00</option>
                            <option value="03:00 - 05:00">03:00 - 05:00</option>
                            <option value="05:00 - 07:00">05:00 - 07:00</option>
                            <option value="07:00 - 09:00">07:00 - 09:00</option>
                        </select>
                        <input type="text" name="friday_topic[]" placeholder="Topic Name" required>
                        <input type="text" name="friday_instructor[]" placeholder="Teacher-name" required>
                    </div>
                </div>
                <button type="button" class="add-period-btn" onclick="addPeriod('friday')">Add Period</button>
            </div>

            <div class="day-schedule">
                <div class="day-title">Saturday</div>
                <div class="period-headers">
                    <div>Time Range</div>
                    <div>Topic/Subject</div>
                    <div>Instructor</div>
                </div>
                <div id="saturdayPeriods">
                    <div class="period-row">
                        <select name="saturday_time[]" required>
                            <option value="" disabled selected>Select Time</option>
                            <option value="09:00 - 11:00">09:00 - 11:00</option>
                            <option value="11:00 - 01:00">11:00 - 01:00</option>
                            <option value="01:00 - 03:00">01:00 - 03:00</option>
                            <option value="03:00 - 05:00">03:00 - 05:00</option>
                            <option value="05:00 - 07:00">05:00 - 07:00</option>
                            <option value="07:00 - 09:00">07:00 - 09:00</option>
                        </select>
                        <input type="text" name="saturday_topic[]" placeholder="Topic Name" required>
                        <input type="text" name="saturday_instructor[]" placeholder="Teacher-name" required>
                    </div>
                </div>
                <button type="button" class="add-period-btn" onclick="addPeriod('saturday')">Add Period</button>
            </div>

            <button type="submit" name="submit_timetable" class="btn-submit">Add Time Table</button>
        </form>
    </div>

    <script>
        function addPeriod(day) {
            const periodsContainer = document.getElementById(day + 'Periods');
            const newPeriod = document.createElement('div');
            newPeriod.className = 'period-row';

            newPeriod.innerHTML = `
                <select name="${day}_time[]" required>
                    <option value="" disabled selected>Select Time</option>
                    <option value="09:00 - 11:00">09:00 - 11:00</option>
                    <option value="11:00 - 01:00">11:00 - 01:00</option>
                    <option value="01:00 - 03:00">01:00 - 03:00</option>
                    <option value="03:00 - 05:00">03:00 - 05:00</option>
                    <option value="05:00 - 07:00">05:00 - 07:00</option>
                    <option value="07:00 - 09:00">07:00 - 09:00</option>
                </select>
                <input type="text" name="${day}_topic[]" placeholder="Topic Name">
                <input type="text" name="${day}_instructor[]" placeholder="Teacher-name">
                <button type="button" class="remove-period-btn" onclick="removePeriod(this)">Remove</button>
            `;

            periodsContainer.appendChild(newPeriod);
        }

        function removePeriod(button) {
            button.parentElement.remove();
        }
    </script>
</body>
</html>
