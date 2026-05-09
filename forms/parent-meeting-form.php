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
<title>Schedule Parent Meeting</title>

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
    padding: 30px 15px;
}

/* BIG RESPONSIVE CARD */
.card-form {
    background: #fff;
    width: 100%;
    max-width: 1000px;
    border-radius: 12px;
    padding: 30px 40px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.08);
}

.form-title {
    text-align: center;
    color: #2b6fd6;
    font-size: 26px;
    font-weight: 600;
    margin-bottom: 25px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 18px;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 18px;
}

label {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 6px;
    color: #333;
}

input,
select,
textarea {
    border: 1px solid #d6dbe1;
    border-radius: 8px;
    padding: 11px 12px;
    font-size: 14px;
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
    gap: 6px;
    align-items: center;
}

.submit-btn {
    width: 100%;
    margin-top: 15px;
    background: #2b6fd6;
    border: none;
    color: #fff;
    font-size: 15px;
    padding: 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.2s;
}

.submit-btn:hover {
    background: #1f58ad;
}

/* TABLET */
@media (max-width: 768px) {
    .card-form {
        max-width: 95%;
        padding: 25px;
    }

    .form-row {
        grid-template-columns: 1fr;
    }

    .form-title {
        font-size: 22px;
    }
}

/* MOBILE */
@media (max-width: 480px) {
    .card-form {
        padding: 20px 15px;
        border-radius: 8px;
    }

    label {
        font-size: 13px;
    }

    input,
    select {
        font-size: 13px;
        padding: 9px;
    }

    .submit-btn {
        font-size: 14px;
        padding: 11px;
    }
}
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
    }

    .toast {
        background: #fff;
        border-radius: 8px;
        padding: 16px 20px;
        margin-bottom: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 300px;
        transform: translateX(120%);
        transition: transform 0.3s ease-out;
        border-left: 4px solid #2b6fd6;
    }
    
    .toast.show {
        transform: translateX(0);
    }

    .toast.success { border-left-color: #2ecc71; }
    .toast.error { border-left-color: #e74c3c; }

    .toast-icon {
        font-size: 20px;
    }
    
    .toast-content {
        flex: 1;
    }
    
    .toast-title {
        font-weight: 600;
        font-size: 14px;
        color: #333;
        margin-bottom: 2px;
    }
    
    .toast-message {
        font-size: 13px;
        color: #666;
    }

    .toast-close {
        cursor: pointer;
        color: #999;
        font-size: 18px;
    }
</style>
</head>

<body>

<div class="page-bg">
<div class="card-form">

<h2 class="form-title">Schedule Parent Meeting</h2>

<form id="meeting-form" action="../includes/meeting_form.php" method="post">

<input type="hidden" name="csrf_token"
value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

<div class="form-group">
<label for="meeting-title">Meeting Agenda / Title</label>
<input type="text" id="meeting-title"
name="meeting_title"
placeholder="e.g., Mid-Term Progress Review"
required>
</div>

<div class="form-row">

<div class="form-group">
<label for="meeting-date">Meeting Date</label>
<input type="date" id="meeting-date"
name="meeting_date" required>
</div>

<div class="form-group">
<label>Meeting Time</label>
<div class="time-row">

<input type="hidden" id="meeting-time"
name="meeting_time" required>

<select class="time-hour"
data-target="meeting-time" required>
<option value="">HH</option>
<?php for($i=1;$i<=12;$i++):
$v=str_pad($i,2,'0',STR_PAD_LEFT); ?>
<option value="<?= $v ?>"><?= $v ?></option>
<?php endfor; ?>
</select>

<span>:</span>

<select class="time-minute"
data-target="meeting-time" required>
<option value="">MM</option>
<?php for($i=0;$i<60;$i++):
$v=str_pad($i,2,'0',STR_PAD_LEFT); ?>
<option value="<?= $v ?>"><?= $v ?></option>
<?php endfor; ?>
</select>

<select class="time-ampm"
data-target="meeting-time" required>
<option value="AM">AM</option>
<option value="PM">PM</option>
</select>

</div>
</div>

</div>

<div class="form-group">
<label for="meeting-mode">Meeting Mode</label>
<select id="meeting-mode"
name="meeting_mode"
required
onchange="toggleLinkField()">
<option value="" disabled selected>Select Meeting Mode</option>
<option value="Offline">Offline (In-Person)</option>
<option value="Online">Online (Virtual)</option>
</select>
</div>

<div id="link-group" class="form-group" style="display:none;">
<label for="meeting-link">Online Meeting Link</label>
<input type="url" id="meeting-link"
name="meeting_link"
placeholder="https://zoom.us/j/1234567890">
</div>

<button type="submit"
name="Schedule_Meeting"
class="submit-btn">
Schedule Meeting
</button>

</form>

</div>
</div>

<!-- Toast Container -->
<div class="toast-container" id="toastContainer"></div>

<script>
function toggleLinkField() {
    const mode = document.getElementById('meeting-mode').value;
    const linkGroup = document.getElementById('link-group');
    linkGroup.style.display = (mode === 'Online') ? 'block' : 'none';
}

document.addEventListener('DOMContentLoaded', () => {

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

// Toast Logic
function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    
    const icon = type === 'success' ? 'Ã¢Å“â€œ' : 'Ã¢Å¡Â ';
    const title = type === 'success' ? 'Success' : 'Error';
    
    toast.innerHTML = `
        <div class="toast-icon">${icon}</div>
        <div class="toast-content">
            <div class="toast-title">${title}</div>
            <div class="toast-message">${message}</div>
        </div>
        <div class="toast-close" onclick="this.parentElement.remove()">Ãƒâ€”</div>
    `;
    
    container.appendChild(toast);
    
    // Animate In
    requestAnimationFrame(() => {
        toast.classList.add('show');
    });

    // Auto Remove
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}

// Check URL Params for Toast Messages
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.has('status') && urlParams.has('message')) {
    const status = urlParams.get('status');
    const message = decodeURIComponent(urlParams.get('message'));
    showToast(message, status); // status should be 'success' or 'error'
    
    // Clean URL
    window.history.replaceState({}, document.title, window.location.pathname);
}

});
</script>

</body>
</html>
