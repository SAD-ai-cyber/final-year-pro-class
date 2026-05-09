<?php
// File: includes/device_helper.php
// Centralized logic for Device Authorization

function get_client_ip() {
    $ip = $_SERVER['REMOTE_ADDR'];
    if ($ip === '::1') $ip = '127.0.0.1';
    return $ip;
}

function check_device_permission($con) {
    if (!$con) return 'error';

    // Ensure device_token column exists (Portable Migration)
    $result = $con->query("SHOW COLUMNS FROM device_permissions LIKE 'device_token'");
    if ($result->num_rows == 0) {
        $con->query("ALTER TABLE device_permissions ADD COLUMN device_token VARCHAR(100) DEFAULT NULL AFTER ip_address");
    }

    $client_ip = get_client_ip();
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    
    // 1. Get Token from Cookie
    $token = $_COOKIE['device_auth_token'] ?? '';

    // 2. Check by Token first (Most Reliable for Dynamic IP)
    if ($token !== '') {
        $sql = "SELECT status, ip_address FROM device_permissions WHERE device_token = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            
            // If IP changed but token is valid, update the IP in DB
            if ($row['ip_address'] !== $client_ip) {
                $upd = "UPDATE device_permissions SET ip_address = ?, last_accessed = NOW() WHERE device_token = ?";
                $ustmt = $con->prepare($upd);
                $ustmt->bind_param("ss", $client_ip, $token);
                $ustmt->execute();
            } else {
                $upd = "UPDATE device_permissions SET last_accessed = NOW() WHERE device_token = ?";
                $ustmt = $con->prepare($upd);
                $ustmt->bind_param("s", $token);
                $ustmt->execute();
            }
            return $row['status'];
        }
    }

    // 3. Fallback to IP check (Traditional/New Device)
    $sql = "SELECT status, id FROM device_permissions WHERE ip_address = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $client_ip);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id = $row['id'];
        
        // If device has no token, or token changed, handle it
        if ($token === '') {
            $token = bin2hex(random_bytes(16));
            setcookie('device_auth_token', $token, time() + (86400 * 365), "/"); // 1 year
            
            $upd = "UPDATE device_permissions SET device_token = ?, last_accessed = NOW() WHERE id = ?";
            $ustmt = $con->prepare($upd);
            $ustmt->bind_param("si", $token, $id);
            $ustmt->execute();
        } else {
            $upd = "UPDATE device_permissions SET last_accessed = NOW() WHERE id = ?";
            $ustmt = $con->prepare($upd);
            $ustmt->bind_param("i", $id);
            $ustmt->execute();
        }

        return $row['status'];
    } else {
        // 4. Insert as pending if brand new
        $newToken = bin2hex(random_bytes(16));
        setcookie('device_auth_token', $newToken, time() + (86400 * 365), "/"); // 1 year
        
        $ins = "INSERT INTO device_permissions (ip_address, device_token, device_name, status) VALUES (?, ?, ?, 'pending')";
        $istmt = $con->prepare($ins);
        $istmt->bind_param("sss", $client_ip, $newToken, $user_agent);
        $istmt->execute();
        
        return 'pending';
    }
}
?>
