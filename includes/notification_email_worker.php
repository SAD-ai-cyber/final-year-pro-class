<?php
ini_set('display_errors', 0);
error_reporting(0);
ignore_user_abort(true);
set_time_limit(0);

require __DIR__ . '/config.php';
require_once __DIR__ . '/email_helper.php';
require __DIR__ . '/notification_helper.php';

ensure_email_queue_table($con);

$batch_limit = 25;
$rows = [];

$stmt = $con->prepare(
    "SELECT id, to_email, subject, body, link, attempts
     FROM notification_email_queue
     WHERE status = 'pending'
     ORDER BY id ASC
     LIMIT ?"
);
if ($stmt) {
    $stmt->bind_param('i', $batch_limit);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($res && ($row = $res->fetch_assoc())) {
        $rows[] = $row;
    }
    $stmt->close();
}

foreach ($rows as $row) {
    $id = (int) $row['id'];
    $to = trim((string) $row['to_email']);
    $subject = (string) $row['subject'];
    $body = (string) $row['body'];
    $link = (string) $row['link'];
    $attempts = (int) $row['attempts'];

    $lock = $con->prepare("UPDATE notification_email_queue SET status = 'sending' WHERE id = ? AND status = 'pending'");
    if (!$lock) {
        continue;
    }
    $lock->bind_param('i', $id);
    $lock->execute();
    $locked = $lock->affected_rows > 0;
    $lock->close();

    if (!$locked) {
        continue;
    }

    $ok = false;
    if ($to !== '') {
        $ok = sendNotificationEmail($to, $subject, $body, $link);
    }

    if ($ok) {
        $update = $con->prepare("UPDATE notification_email_queue SET status = 'sent', sent_at = NOW() WHERE id = ?");
        if ($update) {
            $update->bind_param('i', $id);
            $update->execute();
            $update->close();
        }
    } else {
        $error = isset($GLOBALS['email_last_error']) ? (string) $GLOBALS['email_last_error'] : 'send failed';
        $new_attempts = $attempts + 1;
        $update = $con->prepare(
            "UPDATE notification_email_queue SET status = 'pending', attempts = ?, last_error = ? WHERE id = ?"
        );
        if ($update) {
            $update->bind_param('isi', $new_attempts, $error, $id);
            $update->execute();
            $update->close();
        }
    }
}

$cleanup = $con->prepare("DELETE FROM notification_email_queue WHERE status = 'sent' AND sent_at < DATE_SUB(NOW(), INTERVAL 7 DAY)");
if ($cleanup) {
    $cleanup->execute();
    $cleanup->close();
}

mysqli_close($con);

?>
