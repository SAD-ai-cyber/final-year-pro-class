<?php
require '../includes/security.php';
require '../includes/config.php';

// Ensure no accidental HTML/warning output and always return clean JSON
if (ob_get_level()) ob_end_clean();
ini_set('display_errors', '0');

start_secure_session();
require_role('admin');

header('Content-Type: application/json; charset=utf-8');

// Ensure the table exists before querying to avoid PHP warnings / HTML output
$check = mysqli_query($con, "SHOW TABLES LIKE 'activity_logs'");
if (! $check || mysqli_num_rows($check) === 0) {
    echo json_encode(['status' => 'no_table', 'logs' => []]);
    exit;
}

// Detect whether optional columns exist so the query won't fail on older schemas
$has_full_name = (bool) mysqli_num_rows(mysqli_query($con, "SHOW COLUMNS FROM activity_logs LIKE 'full_name'"));
$has_batch = (bool) mysqli_num_rows(mysqli_query($con, "SHOW COLUMNS FROM activity_logs LIKE 'batch'"));

// Build resolved fields conditionally so older DBs still return rows
if ($has_full_name) {
    // Treat placeholder values like empty string or '(Unknown)' as NULL so we can fall back to DB lookups
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

$pageLabelExpr = "SUBSTRING_INDEX(SUBSTRING_INDEX(al.page_url, '/', -1), '?', 1) AS page_label";

// If a since_id is provided, return only newer rows (ascending order) for incremental polling.
$since_id = isset($_GET['since_id']) ? (int) $_GET['since_id'] : 0;
$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 0;
$per_page = isset($_GET['per_page']) ? max(1, min(500, (int) $_GET['per_page'])) : 50; // sensible bounds

// Get filter parameters
$search = isset($_GET['search']) ? mysqli_real_escape_string($con, trim($_GET['search'])) : '';
$start_date = isset($_GET['start_date']) ? mysqli_real_escape_string($con, trim($_GET['start_date'])) : '';
$end_date = isset($_GET['end_date']) ? mysqli_real_escape_string($con, trim($_GET['end_date'])) : '';

// Build WHERE clause for filters
$where_conditions = [];

if ($since_id > 0) {
    $where_conditions[] = "al.id > $since_id";
}

if ($search !== '') {
    $where_conditions[] = "(al.role LIKE '%$search%' OR al.full_name LIKE '%$search%' OR s.student_name LIKE '%$search%' OR t.teacher_name LIKE '%$search%' OR ad.admin_name LIKE '%$search%' OR p.parent_name LIKE '%$search%')";
}

if ($start_date !== '') {
    $where_conditions[] = "DATE(al.timestamp) >= '$start_date'";
}

if ($end_date !== '') {
    $where_conditions[] = "DATE(al.timestamp) <= '$end_date'";
}

$where_clause = count($where_conditions) > 0 ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

if ($since_id > 0) {
    $sql = "SELECT al.*, {$resolvedFull}, {$resolvedBatch}, {$pageLabelExpr} 
        FROM activity_logs al
        LEFT JOIN add_students s ON al.role = 'student' AND al.user_id = s.student_id
        LEFT JOIN add_teachers t ON al.role = 'teacher' AND al.user_id = t.teacher_id
        LEFT JOIN admins ad ON al.role = 'admin' AND al.user_id = ad.admin_id
        LEFT JOIN add_parents p ON al.role = 'parent' AND al.user_id = p.parent_id
        $where_clause
        ORDER BY al.id ASC";
} elseif ($page > 0) {
    // Paginated response (page = 1..N)
    $offset = ($page - 1) * $per_page;

    // Total count for pagination (with filters)
    $countSql = "SELECT COUNT(*) AS cnt FROM activity_logs al
        LEFT JOIN add_students s ON al.role = 'student' AND al.user_id = s.student_id
        LEFT JOIN add_teachers t ON al.role = 'teacher' AND al.user_id = t.teacher_id
        LEFT JOIN admins ad ON al.role = 'admin' AND al.user_id = ad.admin_id
        LEFT JOIN add_parents p ON al.role = 'parent' AND al.user_id = p.parent_id
        $where_clause";
    $countRes = mysqli_query($con, $countSql);
    $total = 0;
    if ($countRes && ($crow = mysqli_fetch_assoc($countRes))) $total = (int) $crow['cnt'];

    $sql = "SELECT al.*, {$resolvedFull}, {$resolvedBatch}, {$pageLabelExpr} 
        FROM activity_logs al
        LEFT JOIN add_students s ON al.role = 'student' AND al.user_id = s.student_id
        LEFT JOIN add_teachers t ON al.role = 'teacher' AND al.user_id = t.teacher_id
        LEFT JOIN admins ad ON al.role = 'admin' AND al.user_id = ad.admin_id
        LEFT JOIN add_parents p ON al.role = 'parent' AND al.user_id = p.parent_id
        $where_clause
        ORDER BY al.timestamp DESC LIMIT $offset, $per_page";
} else {
    // respect per_page even if page is not explicitly set
    $sql = "SELECT al.*, {$resolvedFull}, {$resolvedBatch}, {$pageLabelExpr} 
        FROM activity_logs al
        LEFT JOIN add_students s ON al.role = 'student' AND al.user_id = s.student_id
        LEFT JOIN add_teachers t ON al.role = 'teacher' AND al.user_id = t.teacher_id
        LEFT JOIN admins ad ON al.role = 'admin' AND al.user_id = ad.admin_id
        LEFT JOIN add_parents p ON al.role = 'parent' AND al.user_id = p.parent_id
        $where_clause
        ORDER BY al.timestamp DESC LIMIT $per_page";
}

$result = mysqli_query($con, $sql);

// If the query fails, return an error message to help debugging (safe for local/dev)
if ($result === false) {
    echo json_encode(['status' => 'error', 'message' => 'Query failed: ' . mysqli_error($con), 'logs' => []]);
    exit;
}

$logs = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Prefer resolved values from the SELECT; keep original names for backward compatibility
    $row['full_name'] = $row['resolved_full_name'] ?? ($row['full_name'] ?? '');
    $row['batch'] = $row['resolved_batch'] ?? ($row['batch'] ?? '');
    $row['page_label'] = $row['page_label'] ?? (isset($row['page_url']) ? preg_replace('/^.*\//', '', parse_url($row['page_url'], PHP_URL_PATH)) : '');
    unset($row['resolved_full_name'], $row['resolved_batch']);
    $logs[] = $row;
}

// Include total count for pagination so UI can show 'Showing X to Y of Z'
$totalCount = 0;
$countRes2 = mysqli_query($con, 'SELECT COUNT(*) AS cnt FROM activity_logs');
if ($countRes2 && ($crow2 = mysqli_fetch_assoc($countRes2))) $totalCount = (int) $crow2['cnt'];

// Return strict JSON only (always include total)
echo json_encode(['status' => 'ok', 'total' => $totalCount, 'logs' => $logs], JSON_UNESCAPED_SLASHES);
exit;
?>
