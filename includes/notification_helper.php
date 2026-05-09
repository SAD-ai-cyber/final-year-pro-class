<?php
require_once __DIR__ . '/email_helper.php';

if (!function_exists('sendNotification')) {

// [1] $con ? DB connection  [2] $user_role ? admin / student / parent / teacher
// [3] $user_id ? jis user ko notification hai  [4] $title ? short heading
// [5] $message ? detail  [6] $link ? optional redirect

    function sendNotification($con, $user_role, $user_id, $title, $message, $link = null)
    {
        // basic validation
        $allowed_roles = ['admin', 'teacher', 'student', 'parent'];
        $user_role = strtolower(trim((string) $user_role));
        $user_id = (int) $user_id;
        $title = trim((string) $title);
        $message = trim((string) $message);
        $link = isset($link) ? trim((string) $link) : null;

        if (!in_array($user_role, $allowed_roles, true)) {
            return false;
        }

        if ($user_id <= 0 || $title === '' || $message === '') {
            return false;
        }

        // prepare statement 
        $stmt = mysqli_prepare(
            $con,
            "INSERT INTO notifications (user_role, user_id, title, message, link) 
             VALUES (?, ?, ?, ?, ?)"
        );

        if (!$stmt) {
            return false;
        }

        mysqli_stmt_bind_param(
            $stmt,
            "sisss",
            $user_role,
            $user_id,
            $title,
            $message,
            $link
        );

        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $result;
    }

}

function getUserEmailByRole($con, $user_role, $user_id)
{
    $user_role = strtolower(trim((string) $user_role));
    $user_id = (int) $user_id;
    if ($user_id <= 0) {
        return '';
    }

    $stmt = null;
    if ($user_role === 'student') {
        $stmt = $con->prepare('SELECT student_email AS email FROM add_students WHERE student_id = ? LIMIT 1');
    } elseif ($user_role === 'teacher') {
        $stmt = $con->prepare('SELECT teacher_email AS email FROM add_teachers WHERE teacher_id = ? LIMIT 1');
    } elseif ($user_role === 'parent') {
        $stmt = $con->prepare('SELECT parent_email AS email FROM add_parents WHERE parent_id = ? LIMIT 1');
    } elseif ($user_role === 'admin') {
        $stmt = $con->prepare('SELECT admin_email AS email FROM admins WHERE admin_id = ? LIMIT 1');
    }

    if (!$stmt) {
        return '';
    }

    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $email = '';
    if ($res && ($row = $res->fetch_assoc())) {
        $email = isset($row['email']) ? trim((string) $row['email']) : '';
    }
    $stmt->close();
    return $email;
}

function sendNotificationAndEmail($con, $user_role, $user_id, $title, $message, $link = null)
{
    $ok = sendNotification($con, $user_role, $user_id, $title, $message, $link);
    $email = getUserEmailByRole($con, $user_role, $user_id);
    if ($email !== '') {
        $full_link = '';
        if ($link) {
            $baseUrl = isset($GLOBALS['app_base_url']) ? rtrim($GLOBALS['app_base_url'], '/') : '';
            $full_link = $baseUrl !== '' ? $baseUrl . '/' . ltrim($link, '/') : $link;
        }
        sendNotificationEmail($email, $title, $message, $full_link);
    }
    return $ok;
}

function deleteNotificationsByContent($con, $title, $message, $link)
{
    $title = trim((string) $title);
    $message = trim((string) $message);
    $link = trim((string) $link);

    if ($title === '' || $message === '' || $link === '') {
        return false;
    }

    $stmt = mysqli_prepare(
        $con,
        'DELETE FROM notifications WHERE title = ? AND message = ? AND link = ?'
    );
    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, 'sss', $title, $message, $link);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $ok;
}

function deleteQueuedEmailsByContent($con, $subject, $body, $link)
{
    $subject = trim((string) $subject);
    $body = trim((string) $body);
    $link = trim((string) $link);

    if ($subject === '' || $body === '' || $link === '') {
        return false;
    }

    $stmt = mysqli_prepare(
        $con,
        "DELETE FROM notification_email_queue WHERE subject = ? AND body = ? AND link = ? AND status <> 'sent'"
    );
    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, 'sss', $subject, $body, $link);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $ok;
}

function deleteLatestNotificationForUser($con, $user_role, $user_id, $title, $message, $link)
{
    $user_role = strtolower(trim((string) $user_role));
    $user_id = (int) $user_id;
    $title = trim((string) $title);
    $message = trim((string) $message);
    $link = trim((string) $link);

    if ($user_role === '' || $user_id <= 0 || $title === '' || $message === '' || $link === '') {
        return false;
    }

    $stmt = mysqli_prepare(
        $con,
        'DELETE FROM notifications WHERE user_role = ? AND user_id = ? AND title = ? AND message = ? AND link = ? ORDER BY id DESC LIMIT 1'
    );
    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, 'sisss', $user_role, $user_id, $title, $message, $link);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $ok;
}

function notificationExistsForUser($con, $user_role, $user_id, $title, $link, $date = null)
{
    $user_role = strtolower(trim((string) $user_role));
    $user_id = (int) $user_id;
    $title = trim((string) $title);
    $link = trim((string) $link);
    $date = isset($date) ? trim((string) $date) : null;

    if ($user_role === '' || $user_id <= 0 || $title === '' || $link === '') {
        return false;
    }

    if ($date !== null && $date !== '') {
        $stmt = mysqli_prepare(
            $con,
            'SELECT id FROM notifications WHERE user_role = ? AND user_id = ? AND title = ? AND link = ? AND DATE(created_at) = ? LIMIT 1'
        );
        if (!$stmt) {
            return false;
        }
        mysqli_stmt_bind_param($stmt, 'sisss', $user_role, $user_id, $title, $link, $date);
    } else {
        $stmt = mysqli_prepare(
            $con,
            'SELECT id FROM notifications WHERE user_role = ? AND user_id = ? AND title = ? AND link = ? LIMIT 1'
        );
        if (!$stmt) {
            return false;
        }
        mysqli_stmt_bind_param($stmt, 'siss', $user_role, $user_id, $title, $link);
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $exists = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);

    return $exists;
}

function ensure_email_queue_table($con)
{
    $sql = "CREATE TABLE IF NOT EXISTS notification_email_queue ("
        . " id INT AUTO_INCREMENT PRIMARY KEY,"
        . " to_email VARCHAR(255) NOT NULL,"
        . " subject VARCHAR(255) NOT NULL,"
        . " body TEXT NOT NULL,"
        . " link TEXT NULL,"
        . " status VARCHAR(20) NOT NULL DEFAULT 'pending',"
        . " attempts INT NOT NULL DEFAULT 0,"
        . " last_error TEXT NULL,"
        . " created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,"
        . " sent_at TIMESTAMP NULL"
        . ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
    mysqli_query($con, $sql);
}

function queueNotificationEmail($con, $toEmail, $subject, $message, $link = '')
{
    // Silenced by user request - only ID/Password and OTP emails allowed.
    return true;
}

function triggerEmailWorker()
{
    $logFile = __DIR__ . '/debug_notif.txt';
    $script = __DIR__ . '/notification_email_worker.php';
    
    if (!file_exists($script)) {
        @file_put_contents($logFile, date('Y-m-d H:i:s') . " Error: Worker script not found: $script\n", FILE_APPEND);
        return;
    }
    
    // DETECT CORRECT PHP BINARY
    $php = PHP_BINARY;
    $is_wrong_binary = (stripos($php, 'httpd') !== false || stripos($php, 'apache') !== false);
    
    if ($is_wrong_binary || !file_exists($php)) {
        $candidates = [
            'C:/xampp/includes/php.exe',
            'C:/includes/php.exe',
            'D:/xampp/includes/php.exe',
            dirname(dirname(PHP_BINARY)) . '/includes/php.exe' // Try to guess relative to apache bin
        ];
        foreach ($candidates as $candidate) {
            if (file_exists($candidate)) {
                $php = $candidate;
                break;
            }
        }
        // If still httpd, force 'php' and hope it's in PATH
        if (stripos($php, 'httpd') !== false || stripos($php, 'apache') !== false) {
            $php = 'php';
        }
    }

    // Close session
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_write_close();
    }

    // 1. Try COM on Windows (Most Reliable)
    if (PHP_OS_FAMILY === 'Windows' && class_exists('COM')) {
        try {
            $wsh = new COM("WScript.Shell");
            // Run async (0=hide window, false=no-wait)
            $cmd = '"' . $php . '" "' . $script . '"';
            $wsh->Run($cmd, 0, false);
            @file_put_contents($logFile, date('Y-m-d H:i:s') . " Worker triggered via COM: $cmd\n", FILE_APPEND);
            return; 
        } catch (Throwable $e) {
            @file_put_contents($logFile, date('Y-m-d H:i:s') . " COM failed: " . $e->getMessage() . "\n", FILE_APPEND);
        }
    }

    // 2. Fallback: Popen
    $cmd = '';
    if (PHP_OS_FAMILY === 'Windows') {
        $cmd = 'start /B "" "' . $php . '" "' . $script . '" > NUL 2>&1';
    } else {
        $cmd = 'nohup "' . $php . '" "' . $script . '" > /dev/null 2>&1 &';
    }
    
    $handle = popen($cmd, 'r');
    if ($handle) {
        pclose($handle);
        @file_put_contents($logFile, date('Y-m-d H:i:s') . " Worker triggered via POPEN: $cmd\n", FILE_APPEND);
    } else {
        @file_put_contents($logFile, date('Y-m-d H:i:s') . " POPEN failed.\n", FILE_APPEND);
    }
}

function sendNotificationToRole($con, $user_role, $title, $message, $link = null)
{
    $user_role = strtolower(trim((string) $user_role));
    $rows = [];
    if ($user_role === 'student') {
        $rows = mysqli_query($con, 'SELECT student_id AS id FROM add_students');
    } elseif ($user_role === 'teacher') {
        $rows = mysqli_query($con, 'SELECT teacher_id AS id FROM add_teachers');
    } elseif ($user_role === 'parent') {
        $rows = mysqli_query($con, 'SELECT parent_id AS id FROM add_parents');
    } elseif ($user_role === 'admin') {
        $rows = mysqli_query($con, 'SELECT admin_id AS id FROM admins');
    }

    if (!$rows) {
        return 0;
    }

    $count = 0;
    while ($row = mysqli_fetch_assoc($rows)) {
        $id = (int) $row['id'];
        if ($id > 0) {
            if (sendNotification($con, $user_role, $id, $title, $message, $link)) {
                $count++;
            }

            $email = getUserEmailByRole($con, $user_role, $id);
            if ($email !== '') {
                $full_link = '';
                if ($link) {
                    $baseUrl = isset($GLOBALS['app_base_url']) ? rtrim($GLOBALS['app_base_url'], '/') : '';
                    $full_link = $baseUrl !== '' ? $baseUrl . '/' . ltrim($link, '/') : $link;
                }
                queueNotificationEmail($con, $email, $title, $message, $full_link);
            }
        }
    }

    triggerEmailWorker();

    return $count;
}

function notifyParentByEmail($con, $parent_email, $title, $message, $link = null)
{
    $parent_email = trim((string) $parent_email);
    if ($parent_email === '') {
        return false;
    }

    $stmt = $con->prepare('SELECT parent_id FROM add_parents WHERE parent_email = ? LIMIT 1');
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param('s', $parent_email);
    $stmt->execute();
    $res = $stmt->get_result();
    $parent_id = 0;
    if ($res && ($row = $res->fetch_assoc())) {
        $parent_id = (int) $row['parent_id'];
    }
    $stmt->close();

    if ($parent_id <= 0) {
        return false;
    }

    return sendNotificationAndEmail($con, 'parent', $parent_id, $title, $message, $link);
}

function notifyParentByStudentId($con, $student_id, $title, $message, $link = null)
{
    $student_id = (int) $student_id;
    if ($student_id <= 0) {
        return false;
    }

    $stmt = $con->prepare('SELECT parent_email FROM add_students WHERE student_id = ? LIMIT 1');
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param('i', $student_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $parent_email = '';
    if ($res && ($row = $res->fetch_assoc())) {
        $parent_email = trim((string) $row['parent_email']);
    }
    $stmt->close();

    if ($parent_email === '') {
        return false;
    }

    return notifyParentByEmail($con, $parent_email, $title, $message, $link);
}
