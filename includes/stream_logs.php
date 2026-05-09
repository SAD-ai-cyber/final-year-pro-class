<?php
require 'config.php';
require 'security.php';
//Added
ini_set('output_buffering', 'off');
ini_set('zlib.output_compression', false);


// Long-running SSE endpoint that emits new activity_logs rows to connected admin clients.
start_secure_session();
require_role('admin');

// Prevent PHP from timing out and allow script to continue after client disconnect
set_time_limit(0);
ignore_user_abort(true);

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

// Helper to send an SSE event
function sse_send($event, $data) {
    echo "event: {$event}\n";
    // JSON-encode and escape newlines per SSE requirements
    $payload = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    echo "data: {$payload}\n\n";
    @ob_flush();
    @flush();
}

// Keep track of the last sent id (client may provide ?last_id=NN)
$lastId = 0;
if (!empty($_GET['last_id'])) {
    $lastId = (int) $_GET['last_id'];
} else {
    // initialize to current max id so only *new* rows are pushed
    $r = mysqli_query($con, "SELECT MAX(id) AS m FROM activity_logs");
    if ($r && $row = mysqli_fetch_assoc($r)) $lastId = (int)($row['m'] ?? 0);
}

$heartbeatCounter = 0;

while (!connection_aborted()) {
    // Query for any new rows
    $sql = "SELECT al.*, 
        COALESCE(NULLIF(al.full_name, ''), s.student_name, t.teacher_name, ad.admin_name, p.parent_name) AS resolved_full_name,
        COALESCE(NULLIF(al.batch, ''), '') AS resolved_batch,
        SUBSTRING_INDEX(SUBSTRING_INDEX(al.page_url, '/', -1), '?', 1) AS page_label
    FROM activity_logs al
    LEFT JOIN add_students s ON al.role = 'student' AND al.user_id = s.student_id
    LEFT JOIN add_teachers t ON al.role = 'teacher' AND al.user_id = t.teacher_id
    LEFT JOIN admins ad ON al.role = 'admin' AND al.user_id = ad.admin_id
    LEFT JOIN add_parents p ON al.role = 'parent' AND al.user_id = p.parent_id
    WHERE al.id > $lastId
    ORDER BY al.id ASC LIMIT 100";

    $res = mysqli_query($con, $sql);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $row['full_name'] = $row['resolved_full_name'] ?? ($row['full_name'] ?? '');
            $row['batch'] = $row['resolved_batch'] ?? ($row['batch'] ?? '');
            $row['page_label'] = $row['page_label'] ?? (isset($row['page_url']) ? preg_replace('/^.*\\//', '', parse_url($row['page_url'], PHP_URL_PATH)) : '');
            unset($row['resolved_full_name'], $row['resolved_batch']);

            sse_send('log', $row);
            $lastId = max($lastId, (int)$row['id']);
        }
    } else {
        // If query fails, send an error event once and break
        sse_send('error', ['message' => 'Stream query failed: ' . mysqli_error($con)]);
        break;
    }

    // heartbeat to keep connection alive (every 10 seconds)
    $heartbeatCounter++;
    if ($heartbeatCounter >= 10) {
        echo ": heartbeat\n\n"; // SSE comment line
        @ob_flush();
        @flush();
        $heartbeatCounter = 0;
    }

    // Short sleep to avoid high CPU Ã¢â‚¬â€ adjust as needed for latency vs load
    sleep(1);
}

// Close stream
exit;
