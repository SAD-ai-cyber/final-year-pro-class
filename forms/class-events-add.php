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
<title>Manage Events</title>

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

.time-row {
    display: flex;
    gap: 5px;
    align-items: center;
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

<h2 class="form-title">Manage Class Events</h2>

<form id="event-form"
action="../includes/cls_event.php"
method="post"
enctype="multipart/form-data">

<input type="hidden" name="csrf_token"
value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

<div class="form-group">
<label for="event-name">Event Name</label>
<input type="text"
id="event-name"
name="event_name"
placeholder="e.g., Annual Day, Farewell Party"
required>
</div>

<div class="form-group">
<label for="description">Event Description</label>
<textarea id="description"
name="description"
rows="4"
placeholder="Enter a detailed description"></textarea>
</div>

<div class="form-row">
<div class="form-group">
<label for="event-date">Event Date</label>
<input type="date"
id="event-date"
name="event_date"
required>
</div>

<div class="form-group">
<label>Event Time</label>

<div class="time-row">

<input type="hidden"
id="event-time"
name="event_time"
required>

<select class="time-hour"
data-target="event-time"
required>
<option value="">HH</option>
<?php for($i=1;$i<=12;$i++):
$v=str_pad($i,2,'0',STR_PAD_LEFT); ?>
<option value="<?= $v ?>"><?= $v ?></option>
<?php endfor; ?>
</select>

<span>:</span>

<select class="time-minute"
data-target="event-time"
required>
<option value="">MM</option>
<?php for($i=0;$i<60;$i++):
$v=str_pad($i,2,'0',STR_PAD_LEFT); ?>
<option value="<?= $v ?>"><?= $v ?></option>
<?php endfor; ?>
</select>

<select class="time-ampm"
data-target="event-time"
required>
<option value="AM">AM</option>
<option value="PM">PM</option>
</select>

</div>
</div>
</div>

<div class="form-group">
<label for="total-expense">Total Expense (Ã¢â€šÂ¹)</label>
<input type="number"
id="total-expense"
name="total_expense"
placeholder="e.g., 5000"
required>
</div>

<div class="form-group">
<label for="event-poster">Upload Event Poster/Banner</label>
<input type="file"
id="event-poster"
name="event_poster"
accept="image/*">
</div>

<button type="submit"
name="add_event"
class="submit-btn">
Add Event
</button>

</form>
</div>
</div>

<script>
document.querySelectorAll('.time-hour').forEach(hourSelect => {
    const targetId = hourSelect.dataset.target;
    const minuteSelect =
document.querySelector(`.time-minute[data-target="${targetId}"]`);
    const ampmSelect =
document.querySelector(`.time-ampm[data-target="${targetId}"]`);
    const hiddenInput = document.getElementById(targetId);

    function updateHiddenTime() {
        const h = hourSelect.value;
        const m = minuteSelect.value;
        const ap = ampmSelect.value;
        if (!h || !m) return;

        let hr = parseInt(h);
        if (ap === "PM" && hr < 12) hr += 12;
        if (ap === "AM" && hr === 12) hr = 0;

        hiddenInput.value =
hr.toString().padStart(2,'0') + ":" + m + ":00";
    }

    hourSelect.addEventListener('change', updateHiddenTime);
    minuteSelect.addEventListener('change', updateHiddenTime);
    ampmSelect.addEventListener('change', updateHiddenTime);
});
</script>

</body>
</html>
