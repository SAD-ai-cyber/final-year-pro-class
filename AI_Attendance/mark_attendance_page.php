<?php
require_once '../includes/config.php';
require_once '../includes/security.php';
require_once '../includes/device_helper.php';

// Check Device Permission
$status = check_device_permission($con);
if ($status !== 'allowed') {
    header("Location: kiosk_terminal.php");
    exit;
}

// Security/session bootstrap.
start_secure_session();
// Apply security headers for this request.
send_security_headers();
// Stop caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
// Enforce role-based access control.
require_role('student', '../login.php');
$student_id = $_SESSION['student_id'];
$csrf_token = csrf_token();

// Check today's attendance status
$today = date('Y-m-d');
$check_sql = "SELECT check_in_time, check_out_time FROM attendance_logs WHERE student_id = ? AND DATE(check_in_time) = ? LIMIT 1";
$stmt = $con->prepare($check_sql);
$stmt->bind_param("ss", $student_id, $today);
$stmt->execute();
$attendance_status = $stmt->get_result()->fetch_assoc();

$can_check_in = !$attendance_status;
$can_check_out = false;
$show_message = false;
$message_text = "";

if ($attendance_status) {
    if (!$attendance_status['check_out_time']) {
        $check_in_ts = strtotime($attendance_status['check_in_time']);
        $diff_hours = (time() - $check_in_ts) / 3600;
        
        if ($diff_hours >= 1) {
            $can_check_out = true;
        } else {
            $show_message = true;
            $wait_mins = 60 - floor((time() - $check_in_ts) / 60);
            $message_text = "Check-In done at " . date('h:i A', $check_in_ts) . ".<br>Check-Out available in " . $wait_mins . " minutes.";
        }
    } else {
        $show_message = true;
        $message_text = "Attendance complete for today.<br>Check-In: " . date('h:i A', strtotime($attendance_status['check_in_time'])) . " | Check-Out: " . date('h:i A', strtotime($attendance_status['check_out_time']));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        h2 {
            color: #333;
            margin-bottom: 10px;
            font-size: 24px;
        }
        
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .action-section {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }
        
        .btn-primary {
            background: #4e73df;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2e59d9;
        }

        .btn-success {
            background: #1cc88a;
            color: white;
        }

        .btn-success:hover {
            background: #17a673;
        }

        .btn-danger {
            background: #e74a3b;
            color: white;
        }

        .btn-danger:hover {
            background: #be2617;
        }
        
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
        }
        
        .alert.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            display: block;
        }
        
        .alert.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            display: block;
        }
        
        .alert.warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
            display: block;
        }
        
        /* Duplicate Entry Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 0;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            animation: slideDown 0.3s;
        }
        
        @keyframes slideDown {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .modal-header {
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
            background: #fff3cd;
            display: flex;
            align-items: center;
            border-radius: 8px 8px 0 0;
        }
        
        .modal-header i {
            font-size: 24px;
            color: #856404;
            margin-right: 12px;
        }
        
        .modal-header h3 {
            margin: 0;
            color: #856404;
            font-size: 18px;
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .modal-body p {
            margin: 10px 0;
            color: #666;
            font-size: 15px;
        }
        
        .modal-body .time-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 3px solid #fd7e14;
        }
        
        .modal-body .time-info span {
            font-weight: 600;
            color: #333;
        }
        
        .modal-footer {
            padding: 15px 20px;
            border-top: 1px solid #e9ecef;
            text-align: right;
            border-radius: 0 0 8px 8px;
        }
        
        .modal-footer .btn {
            margin-left: 10px;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .loader {
            display: none;
            width: 30px;
            height: 30px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #4e73df;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 20px auto 0;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .instruction-box {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .instruction-box h4 {
            margin: 0 0 10px 0;
            color: #1976d2;
        }
        
        .instruction-box ul {
            margin: 0;
            padding-left: 20px;
            color: #424242;
        }
        
        .instruction-box li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Mark Your Attendance</h2>
        <p class="subtitle">Use face recognition to mark attendance (valid only during your time slot).</p>

        <div class="instruction-box">
            <h4>Instructions:</h4>
            <ul>
                <li>Make sure your face is clearly visible.</li>
                <li>Ensure good lighting for accurate recognition.</li>
                <li>Attendance can only be marked during your assigned time.</li>
            </ul>
        </div>

        <div id="alertBox" class="alert"></div>

        <div class="action-section">
            <?php if ($can_check_in): ?>
                <button id="markBtn" class="btn btn-success" onclick="markAttendance('in')">
                    <i class="fas fa-sign-in-alt"></i> Mark Check-In
                </button>
            <?php elseif ($can_check_out): ?>
                <button id="markBtn" class="btn btn-danger" onclick="markAttendance('out')">
                    <i class="fas fa-sign-out-alt"></i> Mark Check-Out
                </button>
            <?php elseif ($show_message): ?>
                <div class="alert warning" style="display:block; margin-bottom:0;">
                    <i class="fas fa-info-circle"></i> <?php echo $message_text; ?>
                </div>
            <?php endif; ?>
            <div id="loader" class="loader"></div>
        </div>
    </div>

    <div id="duplicateModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fas fa-exclamation-triangle"></i>
                <h3>Attendance Already Marked</h3>
            </div>
            <div class="modal-body">
                <p>You have already marked attendance today.</p>
                <div class="time-info">
                    <p>Existing Time: <span id="existingTime"></span></p>
                    <p>Current Time: <span id="currentTime"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeDuplicateModal()">Close</button>
            </div>
        </div>
    </div>
    
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        function closeDuplicateModal() {
            const modal = document.getElementById('duplicateModal');
            modal.style.display = 'none';
        }
        
        function markAttendance(type) {
            const btn = document.getElementById('markBtn');
            const loader = document.getElementById('loader');
            const alertBox = document.getElementById('alertBox');
            
            // Clear previous alerts
            alertBox.className = 'alert';
            alertBox.textContent = '';
            
            // Show loading state
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            }
            loader.style.display = 'block';
            
            // Call backend
            fetch('mark_attendance.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ 
                    csrf_token: csrfToken,
                    attendance_type: type
                })
            })
            .then(response => response.text())
            .then(text => {
                const cleaned = text.replace(/^\uFEFF/, '').trim();
                let data = null;
                try {
                    data = JSON.parse(cleaned);
                } catch (err) {
                    const start = cleaned.indexOf('{');
                    const end = cleaned.lastIndexOf('}');
                    if (start >= 0 && end > start) {
                        const slice = cleaned.slice(start, end + 1);
                        data = JSON.parse(slice);
                    } else {
                        throw err;
                    }
                }

                loader.style.display = 'none';
                btn.disabled = false;
                
                // Restore original button label based on type
                const isCheckIn = type === 'in';
                btn.innerHTML = isCheckIn ? '<i class="fas fa-sign-in-alt"></i> Mark Check-In' : '<i class="fas fa-sign-out-alt"></i> Mark Check-Out';
                
                if (data.status === 'success') {
                    let msg = '<i class="fas fa-check-circle"></i> ' + data.message;
                    if (data.lighting && data.lighting.includes('poor')) {
                        msg += '<br><small><i class="fas fa-lightbulb"></i> Note: Lighting is ' + data.lighting + '. Please find better light for next time.</small>';
                    }
                    alertBox.className = 'alert success';
                    alertBox.innerHTML = msg;
                } else if (data.status === 'duplicate') {
                    // Show duplicate modal instead of alert
                    const duplicateModal = document.getElementById('duplicateModal');
                    if (duplicateModal) {
                        const existingTimeEl = document.getElementById('existingTime');
                        const currentTimeEl = document.getElementById('currentTime');
                        if (existingTimeEl) existingTimeEl.textContent = data.existing_time;
                        if (currentTimeEl) currentTimeEl.textContent = data.current_time;
                        duplicateModal.style.display = 'block';
                    } else {
                         alertBox.className = 'alert warning';
                         alertBox.innerHTML = '<i class="fas fa-check-double"></i> ' + data.message;
                    }
                } else if (data.status === 'warning') {
                    alertBox.className = 'alert warning';
                    alertBox.innerHTML = '<i class="fas fa-exclamation-triangle"></i> ' + data.message;
                } else {
                    // UX-OPTIMIZED ERROR HANDLING (IEEE Guidelines)
                    
                    // Priority 1: Low Light Detection
                    if (data.lighting && data.lighting.includes('poor')) {
                        alertBox.className = 'alert warning';
                        let lightMsg = '<i class="fas fa-lightbulb"></i> <strong>Lighting Issue Detected</strong><br>';
                        
                        if (data.lighting.includes('dark')) {
                            lightMsg += 'The environment is too dark. Please turn on lights or move to a brighter area.';
                        } else if (data.lighting.includes('bright')) {
                            lightMsg += 'The environment is too bright. Please reduce direct light or move to a shaded area.';
                        } else {
                            lightMsg += 'Poor lighting detected. Please improve lighting conditions and try again.';
                        }
                        
                        alertBox.innerHTML = lightMsg;
                    }
                    // Priority 2: Near Miss (Close but not quite)
                    else if (data.distance && data.threshold && parseFloat(data.distance) < parseFloat(data.threshold) + 0.10) {
                        alertBox.className = 'alert warning';
                        alertBox.innerHTML = '<i class="fas fa-user-times"></i> <strong>Face Not Recognized</strong><br>' +
                            'Please hold still, look directly at the camera, and remove glasses/mask if wearing. Then try again.';
                    }
                    // Priority 3: Total Mismatch
                    else if (data.distance && parseFloat(data.distance) >= 0.50) {
                        alertBox.className = 'alert error';
                        alertBox.innerHTML = '<i class="fas fa-times-circle"></i> <strong>Face Verification Failed</strong><br>' +
                            'Please ensure you are logged into the correct account.';
                    }
                    // Fallback: Generic error
                    else {
                        alertBox.className = 'alert error';
                        alertBox.innerHTML = '<i class="fas fa-times-circle"></i> <strong>' + (data.message || 'Verification Failed') + '</strong><br>' +
                            'Please try again or contact support if the issue persists.';
                    }
                }
            })
            .catch(error => {
                loader.style.display = 'none';
                btn.disabled = false;
                
                // Restore original button label based on type
                const isCheckIn = type === 'in';
                btn.innerHTML = isCheckIn ? '<i class="fas fa-sign-in-alt"></i> Mark Check-In' : '<i class="fas fa-sign-out-alt"></i> Mark Check-Out';

                alertBox.className = 'alert error';
                alertBox.innerHTML = '<i class="fas fa-times-circle"></i> Error: ' + error.message;
            });
        }
    </script>
</body>
</html>
