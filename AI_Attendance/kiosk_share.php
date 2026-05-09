<?php
require_once '../includes/config.php';
// File: AI_Attendance/kiosk_share.php

// Construct the full Kiosk URL
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$is_localhost = ($host === 'localhost' || $host === '127.0.0.1' || $host === '::1');

// Try to suggest the Local LAN IP if on localhost
$suggested_ip = 'YOUR_LAN_IP';
if ($is_localhost && PHP_OS_FAMILY === 'Windows') {
    // Attempt to get local IP on Windows
    exec('ipconfig', $output);
    foreach ($output as $line) {
        if (preg_match('/IPv4 Address.*: ([\d\.]+)/', $line, $m)) {
            if ($m[1] !== '127.0.0.1') {
                $suggested_ip = $m[1];
                break;
            }
        }
    }
}

$kiosk_url = "{$protocol}://{$host}/AI_Attendance/kiosk_terminal.php";
if ($is_localhost) {
    $suggested_url = "{$protocol}://{$suggested_ip}/AI_Attendance/kiosk_terminal.php";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share Kiosk Link</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; color: #333; margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .share-container { background: #ffffff; padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); text-align: center; max-width: 500px; width: 90%; }
        .icon-circle { width: 80px; height: 80px; background: #e7f3ff; color: #007bff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 35px; margin: 0 auto 20px; }
        h2 { margin: 0 0 10px; color: #212529; }
        p { color: #6c757d; font-size: 15px; margin-bottom: 25px; line-height: 1.5; }
        .link-box { background: #f1f3f5; border: 1px solid #dee2e6; padding: 12px 15px; border-radius: 8px; display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; overflow: hidden; }
        .link-text { color: #495057; font-family: monospace; font-size: 14px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-right: 10px; }
        .copy-btn { background: #007bff; color: white; border: none; padding: 12px 25px; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 16px; transition: 0.2s; display: flex; align-items: center; gap: 8px; width: 100%; justify-content: center; }
        .copy-btn:hover { background: #0056b3; }
        .copy-btn:active { transform: scale(0.98); }
        .qr-info { margin-top: 25px; font-size: 13px; color: #888; border-top: 1px solid #eee; padding-top: 15px; }
        
        #toast { visibility: hidden; min-width: 250px; background-color: #333; color: #fff; text-align: center; border-radius: 50px; padding: 12px; position: fixed; z-index: 1; bottom: 30px; left: 50%; transform: translateX(-50%); font-size: 14px; }
        #toast.show { visibility: visible; animation: fadein 0.5s, fadeout 0.5s 2.5s; }
        @keyframes fadein { from {bottom: 0; opacity: 0;} to {bottom: 30px; opacity: 1;} }
        @keyframes fadeout { from {bottom: 30px; opacity: 1;} to {bottom: 0; opacity: 0;} }
    </style>
</head>
<body>

<div class="share-container">
    <div class="icon-circle"><i class="fas fa-share-alt"></i></div>
    <h2>Share Kiosk Link</h2>
    <p>Copy this link and open it in the browser of the Tablet or PC you want to use for attendance.</p>
    
    <div class="link-box">
        <span class="link-text" id="kioskUrl"><?php echo $kiosk_url; ?></span>
        <i class="fas fa-link" style="color:#adb5bd;"></i>
    </div>

    <?php if ($is_localhost) { ?>
        <div style="background: #fff4e5; border: 1px solid #ffe2b3; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: left;">
            <strong style="color: #663c00;"><i class="fas fa-exclamation-triangle"></i> Important:</strong>
            <p style="font-size: 13px; color: #663c00; margin: 5px 0 0;">
                You are accessing via <b>localhost</b>. Other devices cannot open "localhost". 
                Please use your LAN IP instead:
            </p>
            <div style="margin-top: 10px; font-family: monospace; font-size: 13px; background: #fff; padding: 5px; border: 1px solid #ffe2b3; word-break: break-all;">
                <?php echo $suggested_url; ?>
            </div>
        </div>
    <?php } ?>
    
    <button class="copy-btn" onclick="copyLink()">
        <i class="fas fa-copy"></i> Copy Current Link
    </button>
    
    <div class="qr-info">
        <i class="fas fa-info-circle"></i> Once opened on the other device, approve the request in <b>Device Management</b>.
    </div>
</div>

<div id="toast">Link copied to clipboard!</div>

<script>
    function copyLink() {
        const urlText = document.getElementById('kioskUrl').innerText;
        navigator.clipboard.writeText(urlText).then(() => {
            const toast = document.getElementById("toast");
            toast.className = "show";
            setTimeout(() => { toast.className = toast.className.replace("show", ""); }, 3000);
        });
    }
</script>

</body>
</html>
