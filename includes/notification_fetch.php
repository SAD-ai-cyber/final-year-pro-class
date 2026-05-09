<?php
require 'security.php';
require 'config.php';

// Security/session bootstrap.
start_secure_session();
// Apply security headers for this request.
send_security_headers();

header('Content-Type: application/json');
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

function resolve_role_from_session()
{
    if (isset($_SESSION['role']) && is_string($_SESSION['role'])) {
        $role = strtolower(trim((string) $_SESSION['role']));
        if ($role !== '') {
            return $role;
        }
    }

    if (isset($_SESSION['admin_id'])) {
        return 'admin';
    }
    if (isset($_SESSION['teacher_id'])) {
        return 'teacher';
    }
    if (isset($_SESSION['parent_id']) || isset($_SESSION['email'])) {
        return 'parent';
    }
    if (isset($_SESSION['student_id'])) {
        return 'student';
    }

    return '';
}

function resolve_user_id($con, $role)
{
    if ($role === 'admin') {
        if (isset($_SESSION['admin_id'])) {
            return (int) $_SESSION['admin_id'];
        }
        $identifier = trim((string) ($_SESSION['username'] ?? ''));
        if ($identifier === '') {
            return 0;
        }
        $numeric_id = ctype_digit($identifier) ? (int) $identifier : -1;
        $stmt = $con->prepare('SELECT admin_id FROM admins WHERE admin_name = ? OR admin_id = ? LIMIT 1');
        if ($stmt) {
            $stmt->bind_param('si', $identifier, $numeric_id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res && ($row = $res->fetch_assoc())) {
                $stmt->close();
                return (int) $row['admin_id'];
            }
            $stmt->close();
        }
        return 0;
    }

    if ($role === 'teacher') {
        if (isset($_SESSION['teacher_id'])) {
            return (int) $_SESSION['teacher_id'];
        }
        $identifier = trim((string) ($_SESSION['username'] ?? ''));
        if ($identifier === '') {
            return 0;
        }
        $numeric_id = ctype_digit($identifier) ? (int) $identifier : -1;
        $stmt = $con->prepare('SELECT teacher_id FROM add_teachers WHERE teacher_name = ? OR teacher_email = ? OR teacher_id = ? LIMIT 1');
        if ($stmt) {
            $stmt->bind_param('ssi', $identifier, $identifier, $numeric_id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res && ($row = $res->fetch_assoc())) {
                $stmt->close();
                return (int) $row['teacher_id'];
            }
            $stmt->close();
        }
        return 0;
    }

    if ($role === 'parent') {
        if (isset($_SESSION['parent_id'])) {
            return (int) $_SESSION['parent_id'];
        }
        $identifier = trim((string) ($_SESSION['email'] ?? ($_SESSION['username'] ?? '')));
        if ($identifier === '') {
            return 0;
        }
        $numeric_id = ctype_digit($identifier) ? (int) $identifier : -1;
        $stmt = $con->prepare('SELECT parent_id FROM add_parents WHERE parent_email = ? OR parent_name = ? OR parent_id = ? LIMIT 1');
        if ($stmt) {
            $stmt->bind_param('ssi', $identifier, $identifier, $numeric_id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res && ($row = $res->fetch_assoc())) {
                $stmt->close();
                return (int) $row['parent_id'];
            }
            $stmt->close();
        }
        return 0;
    }

    if ($role === 'student') {
        if (isset($_SESSION['student_id'])) {
            return (int) $_SESSION['student_id'];
        }
        $identifier = trim((string) ($_SESSION['username'] ?? ''));
        if ($identifier === '') {
            return 0;
        }
        $numeric_id = ctype_digit($identifier) ? (int) $identifier : -1;
        $stmt = $con->prepare('SELECT student_id FROM add_students WHERE student_email = ? OR student_num = ? OR student_id = ? LIMIT 1');
        if ($stmt) {
            $stmt->bind_param('ssi', $identifier, $identifier, $numeric_id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res && ($row = $res->fetch_assoc())) {
                $stmt->close();
                return (int) $row['student_id'];
            }
            $stmt->close();
        }
    }

    return 0;
}

function resolve_child_id($con, $parent_email) {
    if (empty($parent_email)) return 0;
    // Fix: Query add_students table which definitely has parent_email and student_id
    $stmt = $con->prepare("SELECT student_id FROM add_students WHERE parent_email = ? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param("s", $parent_email);
        $stmt->execute();
        $res = $stmt->get_result();
        $cid = 0;
        if ($row = $res->fetch_assoc()) {
            $cid = (int) $row['student_id'];
        }
        $stmt->close();
        return $cid;
    }
    return 0;
}

$role = resolve_role_from_session();

if ($role === '') {
    echo json_encode(['status' => 'unauthorized']);
    exit;
}

$user_id = resolve_user_id($con, $role);

$child_id = 0;
if ($role === 'parent') {
    $p_email = isset($_SESSION['email']) ? trim($_SESSION['email']) : '';
    $child_id = resolve_child_id($con, $p_email);
}

if ($user_id <= 0 && $child_id <= 0) {
    echo json_encode(['status' => 'unauthorized']);
    exit;
}

$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 10;
if ($limit < 1) $limit = 1;
if ($limit > 50) $limit = 50;

$date_filter = '';
mysqli_set_charset($con, "utf8mb4");

if ($role === 'parent' && $child_id > 0) {
    $stmt = $con->prepare(
        "SELECT id, title, message, link, is_read, created_at
         FROM notifications
         WHERE (user_role = 'parent' AND user_id = ?)
            OR (user_role = 'student' AND user_id = ?)
         ORDER BY created_at DESC
         LIMIT ?"
    );
    $stmt->bind_param("iii", $user_id, $child_id, $limit);
} else {
    $stmt = $con->prepare(
        "SELECT id, title, message, link, is_read, created_at
         FROM notifications
         WHERE user_role = ?
             AND user_id = ?
         ORDER BY created_at DESC
         LIMIT ?"
    );
    $stmt->bind_param("sii", $role, $user_id, $limit);
}

$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}
$stmt->close();

// Fix JSON UTF8 issues by re-encoding strings
foreach ($notifications as &$rowRef) {
    foreach ($rowRef as $key => $val) {
        if (is_string($val)) {
            // Convert to UTF-8 to ensure valid JSON
            $rowRef[$key] = mb_convert_encoding($val, 'UTF-8', 'UTF-8');
        }
    }
}
unset($rowRef);

// De-duplication Logic
$deduped = [];
$seen = [];
foreach ($notifications as $row) {
    $key = strtolower(trim((string) ($row['title'] ?? '')))
        . '|' . trim((string) ($row['message'] ?? ''))
        . '|' . trim((string) ($row['link'] ?? ''))
        . '|' . substr((string) ($row['created_at'] ?? ''), 0, 10);
    if (isset($seen[$key])) {
        continue;
    }
    $seen[$key] = true;
    $deduped[] = $row;
}
$notifications = $deduped;

// Count Unread
if ($role === 'parent' && $child_id > 0) {
    $countStmt = $con->prepare(
        "SELECT COUNT(*) AS unread
         FROM notifications
         WHERE ((user_role = 'parent' AND user_id = ?)
            OR (user_role = 'student' AND user_id = ?))
           AND is_read = 0"
    );
    $countStmt->bind_param("ii", $user_id, $child_id);
} else {
    $countStmt = $con->prepare(
        "SELECT COUNT(*) AS unread
         FROM notifications
         WHERE user_role = ?
             AND user_id = ?
             AND is_read = 0"
    );
    $countStmt->bind_param("si", $role, $user_id);
}

$countStmt->execute();
$countResult = $countStmt->get_result();
$countRow = $countResult->fetch_assoc();
$countStmt->close();

$unread = isset($countRow['unread']) ? (int) $countRow['unread'] : 0;

// Re-calc deduped unread from list? 
// Actually, total unread count is good.
// But if we want deduped unread in the LIMIT list:
$deduped_unread = 0;
foreach ($notifications as $row) {
    if ((int) ($row['is_read'] ?? 0) === 0) {
        $deduped_unread++;
    }
}
// We usually want Total Unread (Badge), not just visible unread. 
// So $unread from DB is correct badge number.
// $deduped_unread is just for the dropdown list styling if used.

echo json_encode([
    'status' => 'success',
    'unread' => $unread,
    'notifications' => $notifications
]);
