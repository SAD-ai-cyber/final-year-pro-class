<?php
require '../includes/security.php';
require '../includes/config.php';

start_secure_session();
require_role('admin');

/* ==============================
   FILTER INPUT
============================== */

$search      = $_GET['search'] ?? '';
$start_date  = $_GET['start_date'] ?? '';
$end_date    = $_GET['end_date'] ?? '';

$where = "WHERE 1=1";

if ($search !== '') {
    $search = mysqli_real_escape_string($con, $search);
    $where .= " AND (role LIKE '%$search%' OR full_name LIKE '%$search%')";
}

if ($start_date !== '') {
    $start_date = mysqli_real_escape_string($con, $start_date);
    $where .= " AND DATE(timestamp) >= '$start_date'";
}

if ($end_date !== '') {
    $end_date = mysqli_real_escape_string($con, $end_date);
    $where .= " AND DATE(timestamp) <= '$end_date'";
}

/* ==============================
   FETCH LOGS (WITH JOINS)
============================== */

// Detect whether optional columns exist
$has_full_name = (bool) mysqli_num_rows(mysqli_query($con, "SHOW COLUMNS FROM activity_logs LIKE 'full_name'"));
$has_batch = (bool) mysqli_num_rows(mysqli_query($con, "SHOW COLUMNS FROM activity_logs LIKE 'batch'"));

// Build resolved fields conditionally
if ($has_full_name) {
    $resolvedFull = "COALESCE(
        (CASE WHEN TRIM(al.full_name) = '' OR LOWER(TRIM(al.full_name)) = '(unknown)' THEN NULL ELSE al.full_name END),
        s.student_name, t.teacher_name, ad.admin_name, p.parent_name
    ) AS resolved_full_name";
} else {
    $resolvedFull = "COALESCE(s.student_name, t.teacher_name, ad.admin_name, p.parent_name) AS resolved_full_name";
}

if ($has_batch) {
    $resolvedBatch = "COALESCE(NULLIF(al.batch, ''), '') AS resolved_batch";
} else {
    $resolvedBatch = "'' AS resolved_batch";
}

$sql = "
SELECT al.role, {$resolvedFull}, {$resolvedBatch}, al.timestamp, al.action_type, al.page_url
FROM activity_logs al
LEFT JOIN add_students s ON al.role = 'student' AND al.user_id = s.student_id
LEFT JOIN add_teachers t ON al.role = 'teacher' AND al.user_id = t.teacher_id
LEFT JOIN admins ad ON al.role = 'admin' AND al.user_id = ad.admin_id
LEFT JOIN add_parents p ON al.role = 'parent' AND al.user_id = p.parent_id
$where
ORDER BY al.timestamp DESC
";

$result = mysqli_query($con, $sql);

/* ==============================
   LOG EXPORT ACTION
============================== */

$user_id  = $_SESSION['user_id'] ?? 0;
$role     = $_SESSION['role'] ?? 'admin';
$username = $_SESSION['username'] ?? 'Admin';

$username = mysqli_real_escape_string($con, $username);

mysqli_query($con, "
INSERT INTO activity_logs (user_id, role, full_name, action_type, timestamp)
VALUES ($user_id, '$role', '$username', 'Exported CSV Logs', NOW())
");

/* ==============================
   CSV OUTPUT
============================== */

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="activity_logs.csv"');

$output = fopen('php://output', 'w');

fputcsv($output, [
    'Role',
    'Full Name',
    'Batch',
    'Date',
    'Time',
    'Action',
    'Admin Page',
    'Developer'
]);

function getDashboardName($url) {
    if (!$url) return '-';
    $file = basename($url, '.php');
    return ucwords(str_replace('_', ' ', $file));
}

while ($row = mysqli_fetch_assoc($result)) {

    /* Split Date & Time */
    $timestamp = $row['timestamp'] ?? '';
    $datePart = '';
    $timePart = '';

    if (!empty($timestamp)) {
        $parts = explode(' ', $timestamp);
        $datePart = $parts[0] ?? '';
        $timePart = $parts[1] ?? '';
    }

    /* Use resolved full name from JOIN */
    $fullName = trim($row['resolved_full_name'] ?? '');

    if (empty($fullName) || 
        stripos($fullName, 'unknown') !== false ||
        stripos($fullName, '(unknown') !== false
    ) {
        $fullName = '-';
    }

    $batch = trim($row['resolved_batch'] ?? '');
    if (empty($batch)) $batch = '-';

    $adminPage = getDashboardName($row['page_url']);
    $developerPage = $row['page_url'] ?? '-';

    fputcsv($output, [
        $row['role'] ?? '-',
        $fullName,
        $batch,
        $datePart,
        $timePart,
        $row['action_type'] ?? '-',
        $adminPage,
        $developerPage
    ]);
}

fclose($output);
exit;
