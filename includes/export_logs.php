<?php
require 'config.php';
require 'security.php';

start_secure_session();
require_role('admin'); // Only admins can export

// Fetch logs from last 3 months and resolve full_name / batch / page_label
$three_months_ago = date('Y-m-d H:i:s', strtotime('-3 months'));
$sql = "SELECT al.*, 
    COALESCE(NULLIF(al.full_name, ''), s.student_name, t.teacher_name, ad.admin_name, p.parent_name) AS resolved_full_name,
    COALESCE(NULLIF(al.batch, ''), '') AS resolved_batch,
    SUBSTRING_INDEX(SUBSTRING_INDEX(al.page_url, '/', -1), '?', 1) AS page_label
FROM activity_logs al
LEFT JOIN add_students s ON al.role = 'student' AND al.user_id = s.student_id
LEFT JOIN add_teachers t ON al.role = 'teacher' AND al.user_id = t.teacher_id
LEFT JOIN admins ad ON al.role = 'admin' AND al.user_id = ad.admin_id
LEFT JOIN add_parents p ON al.role = 'parent' AND al.user_id = p.parent_id
WHERE al.timestamp >= '$three_months_ago'
ORDER BY al.timestamp DESC";

$result = mysqli_query($con, $sql);

$export_rows = [];
$sr = 1;
while ($r = mysqli_fetch_assoc($result)) {
    $ts = isset($r['timestamp']) ? $r['timestamp'] : '';
    $date = $ts ? substr($ts, 0, 10) : '';
    $time = $ts && strlen($ts) >= 19 ? substr($ts, 11, 8) : '';
    $export_rows[] = [
        'sr_no' => $sr++,
        'role' => $r['role'] ?? '',
        'full_name' => $r['resolved_full_name'] ?? ($r['full_name'] ?? ''),
        'batch' => $r['resolved_batch'] ?? ($r['batch'] ?? ''),
        'date' => $date,
        'time' => $time,
        'action' => $r['action_type'] ?? '',
        'page' => $r['page_label'] ?? ($r['page_url'] ?? '')
    ];
}

$json_data = json_encode($export_rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

// Create ZIP
$zip = new ZipArchive();
$zip_filename = "activity_logs_" . date('Y-m-d_H-i-s') . ".zip";
$json_filename = "activity_logs.json";

if ($zip->open($zip_filename, ZipArchive::CREATE) !== TRUE) {
    die("Cannot open <$zip_filename>\n");
}

$zip->addFromString($json_filename, $json_data);
$zip->close();

// Force Download
if (file_exists($zip_filename)) {
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="'.basename($zip_filename).'"');
    header('Content-Length: ' . filesize($zip_filename));
    flush();
    readfile($zip_filename);
    // Delete file after download
    unlink($zip_filename); 
} else {
    echo "Error creating zip file.";
}
?>
