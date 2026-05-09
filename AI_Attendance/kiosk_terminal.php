<?php
require_once '../includes/config.php';
require_once '../includes/device_helper.php';

// 1. Check Device Permission
$status = check_device_permission($con);
$client_ip = get_client_ip();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Auto Refresh for Pending devices to check status change -->
    <?php if ($status === 'pending'): ?>
        <meta http-equiv="refresh" content="10">
    <?php endif; ?>
    
    <title>Kiosk Attendance Terminal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #eef2f7; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); text-align: center; max-width: 500px; width: 90%; }
        
        h1 { margin-bottom: 10px; color: #333; }
        .ip-badge { background: #e9ecef; padding: 5px 10px; border-radius: 5px; font-family: monospace; font-size: 14px; color: #555; }
        
        .status-icon { font-size: 60px; margin: 20px 0; }
        
        /* Status Colors */
        .pending { color: #fd7e14; }
        .blocked { color: #dc3545; }
        .allowed { color: #28a745; }
        
        .msg { font-size: 18px; margin: 10px 0; color: #444; }
        .sub-msg { font-size: 14px; color: #777; margin-bottom: 20px; }
        
        .btn-attendance { background: #28a745; color: white; border: none; padding: 15px 30px; font-size: 18px; border-radius: 50px; cursor: pointer; transition: 0.3s; box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3); }
        .btn-attendance:hover { transform: scale(1.05); }

        .loader { border: 4px solid #f3f3f3; border-top: 4px solid #fd7e14; border-radius: 50%; width: 30px; height: 30px; animation: spin 1s linear infinite; margin: 0 auto 15px auto; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
</head>
<body>

<div class="card">
    <div class="ip-badge"><i class="fas fa-network-wired"></i> IP: <?php echo $client_ip; ?></div>

    <?php if ($status === 'allowed'): ?>
        
        <!-- ALLOWED STATE -->
        <div class="status-icon allowed"><i class="fas fa-check-circle"></i></div>
        <h1>Device Authorized</h1>
        <p class="sub-msg">This device is approved correctly.</p>
        
        <button class="btn-attendance" onclick="location.href='mark_attendance_page.php'">
            <i class="fas fa-camera"></i> Start Face Attendance
        </button>

    <?php elseif ($status === 'blocked'): ?>
        
        <!-- BLOCKED STATE -->
        <div class="status-icon blocked"><i class="fas fa-ban"></i></div>
        <h1>Access Denied</h1>
        <p class="msg">This device has been blocked by Admin.</p>
        <p class="sub-msg">Please contact the administrator if this is a mistake.</p>

    <?php else: ?>
        
        <!-- PENDING STATE -->
        <div class="status-icon pending">
            <div class="loader"></div>
        </div>
        <h1>Waiting for Approval...</h1>
        <p class="msg">Admin approval is required to use this device.</p>
        <p class="sub-msg">Please ask the Admin to approve IP <strong><?php echo $client_ip; ?></strong></p>
        <small style="color:#999;">Page will auto-refresh in 10s...</small>

    <?php endif; ?>
</div>

</body>
</html>
