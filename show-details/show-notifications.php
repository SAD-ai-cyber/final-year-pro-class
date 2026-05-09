<?php
require '../includes/security.php';
require '../includes/config.php';
require '../includes/notification_helper.php';

// Security/session bootstrap.
start_secure_session();
// Apply security headers for this request.
apply_security_headers();
// Enforce role-based access control.
require_role(['admin', 'teacher', 'parent', 'student']);

$role = $_SESSION['role'] ?? '';
$user_id = 0;
if ($role === 'admin') {
    $user_id = isset($_SESSION['admin_id']) ? (int) $_SESSION['admin_id'] : 1;
} elseif ($role === 'student') {
    $user_id = isset($_SESSION['student_id']) ? (int) $_SESSION['student_id'] : 0;
} elseif ($role === 'teacher') {
    $user_id = isset($_SESSION['teacher_id']) ? (int) $_SESSION['teacher_id'] : 0;
} elseif ($role === 'parent') {
    $user_id = isset($_SESSION['parent_id']) ? (int) $_SESSION['parent_id'] : 0;
}

if ($user_id <= 0) {
    header('Location: ../login.php');
    exit;
}

$csrf_token = generate_csrf_token();

$date_filter = '';
if ($role !== 'admin') {
        $date_filter = ' AND DATE(created_at) >= CURDATE()';
}

$stmt = $con->prepare(
        "SELECT id, title, message, link, is_read, created_at
         FROM notifications
         WHERE user_role = ?
             AND user_id = ?
             {$date_filter}
         ORDER BY created_at DESC"
);
$stmt->bind_param('si', $role, $user_id);
$stmt->execute();
$res = $stmt->get_result();
$rows = [];
while ($res && ($row = $res->fetch_assoc())) {
    $rows[] = $row;
}
$stmt->close();

$deduped = [];
$seen = [];
foreach ($rows as $row) {
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

$rows = $deduped;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
    <title>All Notifications</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/details/parent.css?v=<?php echo time(); ?>">
    <style>
        .notif-header { display: flex; align-items: center; justify-content: space-between; }
        .notif-btn { background: #2563eb; color: #fff; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; }
        .notif-btn:disabled { opacity: 0.6; cursor: not-allowed; }
        .notif-unread { font-weight: 600; }
    </style>
</head>
<body class="fixed-scroll-page">
    <div class="card fixed-scroll-card">
        <div class="card-header fixed-scroll-header notif-header">
            <h2 class="card-title">All Notifications</h2>
            <button class="notif-btn" id="markAllBtn">Mark all read</button>
        </div>
        <div class="card-body">
            <table class="details-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Open</th>
                    </tr>
                </thead>
                <tbody id="notifTableBody">
                    <?php if (empty($rows)) { ?>
                        <tr><td colspan="5">No notifications found</td></tr>
                    <?php } else { ?>
                        <?php foreach ($rows as $row) { ?>
                            <tr>
                                <td class="<?php echo ((int) $row['is_read'] === 0) ? 'notif-unread' : ''; ?>">
                                    <?php echo htmlspecialchars($row['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['message'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($row['created_at'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo ((int) $row['is_read'] === 0) ? 'Unread' : 'Read'; ?></td>
                                <td>
                                    <a href="../includes/notification_read.php?id=<?php echo (int) $row['id']; ?>">View</a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        (function () {
            const btn = document.getElementById('markAllBtn');
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';
            if (!btn) return;
            btn.addEventListener('click', async () => {
                btn.disabled = true;
                try {
                    const res = await fetch('../includes/notification_read.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'mark_all=1&csrf_token=' + encodeURIComponent(csrfToken)
                    });
                    const data = await res.json();
                    if (data.status === 'success') {
                        location.reload();
                    }
                } catch (e) {
                    // ignore
                } finally {
                    btn.disabled = false;
                }
            });
        })();
    </script>
</body>
</html>
