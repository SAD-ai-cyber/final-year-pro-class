<?php
require '../includes/security.php';
require '../includes/config.php';

// Start secure session, send headers, and allow only admin
start_secure_session();
// Apply security headers for this request.
send_security_headers();
// Enforce role-based access control.
require_role('admin', '../admin_login.php');

//  admin id (abhi single admin system)
$admin_id = 1;

//  fetch latest notifications for admin
$notif_sql = "SELECT id, title, message, link, is_read, created_at 
              FROM notifications 
              WHERE user_role = 'admin' 
              AND user_id = '$admin_id'
              ORDER BY created_at DESC
              LIMIT 10";

$notif_result = mysqli_query($con, $notif_sql);

//  unread count (bell badge ke liye)
$count_sql = "SELECT COUNT(*) AS unread_count 
              FROM notifications 
              WHERE user_role = 'admin' 
              AND user_id = '$admin_id' 
              AND is_read = 0";

$count_result = mysqli_query($con, $count_sql);
$unread_count = 0;

if ($count_row = mysqli_fetch_assoc($count_result)) {
    $unread_count = $count_row['unread_count'];
}

// --- Stats for admin dashboard ---
$total_students = 0;
$total_teachers = 0;
$total_courses = 0;
$new_inquiries = 0;

$res = mysqli_query($con, "SELECT COUNT(*) AS cnt FROM add_students");
if ($res && ($row = mysqli_fetch_assoc($res))) {
    $total_students = (int) $row['cnt'];
}

$res = mysqli_query($con, "SELECT COUNT(*) AS cnt FROM add_teachers");
if ($res && ($row = mysqli_fetch_assoc($res))) {
    $total_teachers = (int) $row['cnt'];
}

$res = mysqli_query($con, "SELECT COUNT(*) AS cnt FROM course_add");
if ($res && ($row = mysqli_fetch_assoc($res))) {
    $total_courses = (int) $row['cnt'];
}

$inq_total = 0;
$res = mysqli_query($con, "SELECT COUNT(*) AS cnt FROM add_online_students WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)");
if ($res && ($row = mysqli_fetch_assoc($res))) {
    $inq_total += (int) $row['cnt'];
}
$res = mysqli_query($con, "SELECT COUNT(*) AS cnt FROM add_demo_students WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)");
if ($res && ($row = mysqli_fetch_assoc($res))) {
    $inq_total += (int) $row['cnt'];
}
$res = mysqli_query($con, "SELECT COUNT(*) AS cnt FROM contact_demo_student WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)");
if ($res && ($row = mysqli_fetch_assoc($res))) {
    $inq_total += (int) $row['cnt'];
}
$new_inquiries = $inq_total;

// Today's Global Attendance Stats
$todays_in = 0;
$todays_out = 0;
$res = mysqli_query($con, "SELECT COUNT(*) as cnt_in, COUNT(check_out_time) as cnt_out FROM attendance_logs WHERE DATE(check_in_time) = CURDATE()");
if ($res && ($row = mysqli_fetch_assoc($res))) {
    $todays_in = (int) $row['cnt_in'];
    $todays_out = (int) $row['cnt_out'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>">
    <title>Class Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/responsive-core.css?v=<?php echo time(); ?>">
    <style>
        #toast-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }

        .toast {
            background-color: #fff;
            color: #333;
            padding: 16px 20px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-left: 5px solid #28a745;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-width: 300px;
            animation: slideIn 0.3s ease-out forwards;
            font-family: 'Segoe UI', sans-serif;
        }

        .toast-content {
            margin-right: 15px;
        }

        .toast-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 4px;
            display: block;
        }

        .toast-message {
            font-size: 13px;
            color: #666;
        }

        .toast-close {
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            font-size: 18px;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    </style>
</head>

<body>
    <div id="toast-container"></div>
    <!-- Header -->
    <header class="header">
        <div class="header-left">
            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="logo">
                <i class="fas fa-graduation-cap"></i>
                <span>Admin</span>
            </div>
        </div>
        <div class="header-right">
            <div class="user-dropdown">
                <button class="notification-btn" id="notificationBtn">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge" id="notificationBadge">
                        <?= $unread_count ?>
                    </span>
                </button>
                <div class="notification-dropdown" id="notificationDropdown">
                    <div class="notification-header">
                        <span class="notification-title">Notifications</span>

                        <!-- ?? FIX 2: id match JS -->
                        <a href="#" class="mark-all-read" id="markAllReadBtn">Mark all read</a>
                    </div>

                    <div class="notification-list" id="notificationList">
                        <div class="notification-dropdown-item">
                            <div class="notification-content">
                                <div class="notification-dropdown-text">Loading notifications...</div>
                            </div>
                        </div>
                    </div>

                    <div class="notification-footer">
                        <a href="../show-details/show-notifications.php" class="view-all-notifications">View all notifications</a>
                    </div>
                </div>
            </div>

            <div class="user-dropdown">
                <button class="user-btn" id="userBtn">
                    <i class="fas fa-user-circle"></i>
                    <?php echo $_SESSION['username']; ?>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu" id="userDropdown">
                    <a href="#" class="dropdown-item"><i class="fas fa-user"></i> Profile</a>
                    <a href="#" class="dropdown-item"><i class="fas fa-cog"></i> Settings</a>
                    <a href="../login_includes/logout.php" class="dropdown-item">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-item">
            <div class="sidebar-main" data-menu="dashboard">
                <div class="sidebar-main-content">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </div>
            </div>
        </div>

        <div class="sidebar-item">
            <div class="sidebar-main" data-menu="accounts">
                <div class="sidebar-main-content">
                    <i class="fas fa-users"></i>
                    <span>Manage Accounts</span>
                </div>
                <i class="fas fa-chevron-down sidebar-arrow"></i>
            </div>
            <div class="sidebar-submenu">
                <div class="submenu-item" data-page="teacher-add">Teachers</div>
                <div class="submenu-item" data-page="show-teacher">View Teachers</div>
                <div class="submenu-item" data-page="student-add">Students</div>
                <div class="submenu-item" data-page="show-student">View Students</div>
                <div class="submenu-item" data-page="parent-add">Parents</div>
                <div class="submenu-item" data-page="show-parent">View Parents</div>
            </div>
        </div>

        <div class="sidebar-item">
            <div class="sidebar-main" data-menu="classes">
                <div class="sidebar-main-content">
                    <i class="fas fa-chalkboard"></i>
                    <span>Manage Classes</span>
                </div>
                <i class="fas fa-chevron-down sidebar-arrow"></i>
            </div>
            <div class="sidebar-submenu">
                <div class="submenu-item" data-page="class-add">Classes</div>
                <div class="submenu-item" data-page="show-class">View Classes</div>
                <div class="submenu-item" data-page="course-add">Courses</div>
                <div class="submenu-item" data-page="show-course">View Courses</div>
            </div>
        </div>

        <div class="sidebar-item">
            <div class="sidebar-main" data-menu="routines">
                <div class="sidebar-main-content">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Manage Class Routines</span>
                </div>
                <i class="fas fa-chevron-down sidebar-arrow"></i>
            </div>
            <div class="sidebar-submenu">
                <div class="submenu-item" data-page="time-table">Time Table</div>
                <div class="submenu-item" data-page="show-timetd">View Time Table</div>
            </div>
        </div>

        <div class="sidebar-item">
            <div class="sidebar-main" data-menu="examinations">
                <div class="sidebar-main-content">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Manage Examinations</span>
                </div>
                <i class="fas fa-chevron-down sidebar-arrow"></i>
            </div>
            <div class="sidebar-submenu">
                <div class="submenu-item" data-page="examinationform">Examination Form</div>
                <div class="submenu-item" data-page="show-examinforms">View Examination Forms</div>
                <div class="submenu-item" data-page="admin-card">Admin card</div>
                <div class="submenu-item" data-page="show-admin-card">View Admin cards</div>
                <div class="submenu-item" data-page="paper-time-table">Paper Schedule</div>
                <div class="submenu-item" data-page="show-paper-sch">View Paper Schedules</div>
            </div>
        </div>

        <div class="sidebar-item">
            <div class="sidebar-main" data-menu="attendance">
                <div class="sidebar-main-content">
                    <i class="fas fa-user-check"></i>
                    <span>Manage Attendance</span>
                </div>
                <i class="fas fa-chevron-down sidebar-arrow"></i>
            </div>
            <div class="sidebar-submenu">
                <div class="submenu-item" data-page="show-attendance">View Attendances</div>
            </div>
        </div>

        <div class="sidebar-item">
            <div class="sidebar-main" data-menu="accounting">
                <div class="sidebar-main-content">
                    <i class="fas fa-calculator"></i>
                    <span>Manage Accountings</span>
                </div>
                <i class="fas fa-chevron-down sidebar-arrow"></i>
            </div>
            <div class="sidebar-submenu">
                <div class="submenu-item" data-page="student-fee-det">Student Fee Details</div>
                <div class="submenu-item" data-page="show-std-fee">View Student Fee Details</div>
                <div class="submenu-item" data-page="result-add">Results</div>
                <div class="submenu-item" data-page="show-result">View Results</div>
            </div>
        </div>

        <div class="sidebar-item">
            <div class="sidebar-main" data-menu="materials">
                <div class="sidebar-main-content">
                    <i class="fas fa-book"></i>
                    <span>Study Materials</span>
                </div>
                <i class="fas fa-chevron-down sidebar-arrow"></i>
            </div>
            <div class="sidebar-submenu">
                <div class="submenu-item" data-page="study-mat-add">Study Materials</div>
                <div class="submenu-item" data-page="show-study-mat">View Study Materials</div>
            </div>
        </div>

        <div class="sidebar-item">
            <div class="sidebar-main" data-menu="exam-section">
                <div class="sidebar-main-content">
                    <i class="fas fa-book"></i>
                    <span>Exam-Section</span>
                </div>
                <i class="fas fa-chevron-down sidebar-arrow"></i>
            </div>
            <div class="sidebar-submenu">
                <div class="submenu-item" data-page="teacher_create_exam">Online MCQ Exam</div>
                <div class="submenu-item" data-page="show_exams">Show MCQ Exam Results</div>
            </div>
        </div>

        <div class="sidebar-item">
            <div class="sidebar-main" data-menu="events">
                <div class="sidebar-main-content">
                    <i class="fas fa-calendar"></i>
                    <span>Manage Events</span>
                </div>
                <i class="fas fa-chevron-down sidebar-arrow"></i>
            </div>
            <div class="sidebar-submenu">
                <div class="submenu-item" data-page="class-events-add">Classes Functions</div>
                <div class="submenu-item" data-page="show-cls-fun">View Classes Functions</div>
            </div>
        </div>

        <div class="sidebar-item">
            <div class="sidebar-main" data-menu="events">
                <div class="sidebar-main-content">
                    <i class="fas fa-calendar"></i>
                    <span>Enquire Student Sections</span>
                </div>
                <i class="fas fa-chevron-down sidebar-arrow"></i>
            </div>
            <div class="sidebar-submenu">
                <div class="submenu-item" data-page="show-online-student-details">View online-register Students</div>
                <div class="submenu-item" data-page="show-demo-register-std-details">View demo-register Students</div>
                <div class="submenu-item" data-page="show-contact-student-details">View via-contact-demo Students</div>
            </div>
        </div>

        <div class="sidebar-item">
            <div class="sidebar-main" data-menu="communications">
                <div class="sidebar-main-content">
                    <i class="fas fa-comments"></i>
                    <span>Communications</span>
                </div>
                <i class="fas fa-chevron-down sidebar-arrow"></i>
            </div>
            <div class="sidebar-submenu">
                <div class="submenu-item" data-page="parent-meeting-form">Parent's Meetings</div>
                <div class="submenu-item" data-page="show-meets">View Parent's Meetings</div>
            </div>
        </div>

        <div class="sidebar-item">
            <div class="sidebar-main" data-menu="settings">
                <div class="sidebar-main-content">
                    <i class="fas fa-cogs"></i>
                    <span>Academy Settings</span>
                </div>
                <i class="fas fa-chevron-down sidebar-arrow"></i>
            </div>
            <div class="sidebar-submenu">
                <div class="submenu-item" data-page="basic-info">Basic Informations</div>
                <div class="submenu-item" data-page="view-basic-info">View Basic Informations</div>
            </div>
        </div>
        <div class="sidebar-item">
            <div class="sidebar-main" data-menu="devices">
                <div class="sidebar-main-content">
                    <i class="fas fa-desktop"></i>
                    <span>Device Management</span>
                </div>
                <i class="fas fa-chevron-down sidebar-arrow"></i>
            </div>
            <div class="sidebar-submenu">
                <div class="submenu-item" data-page="admin_devices">Authorize Devices</div>
                <div class="submenu-item" data-page="kiosk_share">Share Kiosk Link</div>
            </div>
        </div>

        <div class="sidebar-item">
            <div class="sidebar-main" data-menu="logs">
                <div class="sidebar-main-content">
                    <i class="fas fa-history"></i>
                    <span>Activity Logs</span>
                </div>
                <i class="fas fa-chevron-down sidebar-arrow"></i>
            </div>
            <div class="sidebar-submenu">
                <div class="submenu-item" data-page="admin_logs">View Logs</div>
            </div>
        </div>

    </nav>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <div class="dashboard-header">
            <div>
                <h1 class="dashboard-title">Dashboard</h1>
                <div class="breadcrumb">
                    <a href="#">Admin</a> / Dashboard
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card students">
                <div class="stat-header">
                    <div>
                        <div class="stat-number" id="adminStudents" data-target="<?= $total_students ?>">0</div>
                        <div class="stat-label">Total Students</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card teachers">
                <div class="stat-header">
                    <div>
                        <div class="stat-number" id="adminTeachers" data-target="<?= $total_teachers ?>">0</div>
                        <div class="stat-label">Total Teachers</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card courses">
                <div class="stat-header">
                    <div>
                        <div class="stat-number" id="adminCourses" data-target="<?= $total_courses ?>">0</div>
                        <div class="stat-label">Total Courses</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card inquiries">
                <div class="stat-header">
                    <div>
                        <div style="font-size: 14px; font-weight: bold; color: #1cc88a;">In: <?= $todays_in ?></div>
                        <div style="font-size: 14px; font-weight: bold; color: #e74a3b;">Out: <?= $todays_out ?></div>
                        <div class="stat-label">Today's Presence</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-user-clock"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <div class="quick-action" data-action="add-student">
                <i class="fas fa-user-plus"></i>
                <span>Add Student</span>
            </div>
            <div class="quick-action" data-action="create-exam">
                <i class="fas fa-plus-circle"></i>
                <span>Create Exam</span>
            </div>
            <div class="quick-action" data-action="manage-fees">
                <i class="fas fa-money-bill-wave"></i>
                <span>Manage Fees</span>
            </div>
            <div class="quick-action" data-action="view-reports">
                <i class="fas fa-chart-bar"></i>
                <span>View Reports</span>
            </div>
        </div>

        <!-- Notifications -->
        <div class="notifications-card">
            <h2 class="card-title">
                <i class="fas fa-bell"></i>
                Recent Notifications
            </h2>
            <?php
            // recent 5 notifications (admin)
            $recent_sql = "SELECT title, message, created_at , is_read
               FROM notifications 
               WHERE user_role = 'admin' 
               AND user_id = '$admin_id'
               ORDER BY created_at  DESC
               LIMIT 5";

            $recent_result = mysqli_query($con, $recent_sql);
            ?>

            <?php if (mysqli_num_rows($recent_result) > 0): ?>
                <?php while ($r = mysqli_fetch_assoc($recent_result)): ?>
                    <div class="notification-item">
                        <div class="notification-icon <?= $r['is_read'] == 0 ? 'new' : '' ?>"></div>
                        <div class="notification-text">
                            <strong><?= htmlspecialchars($r['title']) ?></strong><br>
                            <small><?= htmlspecialchars($r['message']) ?></small><br>
                            <small style="color:red;">
                                <?= date('d M Y, h:i A', strtotime($r['created_at'])) ?>
                            </small>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="notification-item">
                    <div class="notification-text">No recent notifications</div>
                </div>
            <?php endif; ?>

        </div>

        <!-- Recent Activity -->
        <div class="activity-card">
            <h2 class="card-title">
                <i class="fas fa-clock"></i>
                Recent Activity
            </h2>
            <div id="activityList" style="max-height: 500px; overflow-y: auto;">
                <div style="padding: 20px; text-align: center; color: #888;">
                    <i class="fas fa-spinner fa-spin"></i> Loading latest activity...
                </div>
            </div>
        </div>

        <!-- Chatbot -->
        <div id="chatbot-icon"><i class="fa-solid fa-robot"></i></div>
        <div id="chatbot-container" class="hidden">
            <div id="chatbot-header">
                <span style="font-size:25px; font-weight: 900;">ChatBot</span>
                <button id="close-btn">&times;</button>
            </div>
            <div id="chatbot-body">
                <div id="chatbot-messages"></div>
            </div>
            <div id="chatbot-input-container">
                <div id="file-preview"></div>
                <div class="main-input-area">
                    <div class="input-wrapper">
                        <div id="chatbot-input" contenteditable="true"></div>
                        <button id="attach-btn" class="input-icon-btn"><i class="fa-solid fa-paperclip"></i></button>
                        <input type="file" id="file-input" hidden accept="image/*, .txt, .md">
                    </div>
                    <button id="send-btn"><i class="fa-solid fa-paper-plane"></i></button>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <p>Copyright Â© 2025 <a href="#"> Class Management System</a>. All rights reserved. | Version 1.0</p>
        </footer>
    </main>

    <script>window.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content') || '';</script>
    <script src="../js/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        (function () {
            const listEl = document.getElementById('notificationList');
            const badgeEl = document.getElementById('notificationBadge');
            const markAllBtn = document.getElementById('markAllReadBtn');
            const csrfToken = window.csrfToken;

            function formatDate(ts) {
                const d = new Date(ts.replace(' ', 'T'));
                if (Number.isNaN(d.getTime())) return ts;
                return d.toLocaleString();
            }

            function renderNotifications(items) {
                if (!listEl) return;
                if (!items || items.length === 0) {
                    listEl.innerHTML = `
                        <div class="notification-dropdown-item">
                            <div class="notification-content">
                                <div class="notification-dropdown-text">No notifications found</div>
                            </div>
                        </div>`;
                    return;
                }

                listEl.innerHTML = items.map(n => {
                    const iconClass = n.is_read == 0 ? 'new' : '';
                    const unreadClass = n.is_read == 0 ? 'unread' : '';
                    const title = n.title ? n.title.replace(/</g, '&lt;') : '';
                    const message = n.message ? n.message.replace(/</g, '&lt;') : '';
                    return `
                        <div class="notification-dropdown-item" id="notif-${n.id}">
                            <div class="notification-dropdown-icon ${iconClass}">
                                <i class="fas fa-bell"></i>
                            </div>
                            <div class="notification-content">
                                <div class="notification-dropdown-text">
                                    <a href="../includes/notification_read.php?id=${n.id}" class="notif-link ${unreadClass}">
                                        <strong>${title}</strong><br>
                                        <small>${message}</small>
                                    </a>
                                </div>
                                <div class="notification-dropdown-time" style="color:red;">
                                    ${formatDate(n.created_at)}
                                </div>
                            </div>
                        </div>`;
                }).join('');
            }

            let lastNavId = 0;
            let isFirstLoad = true;

            function showToast(title, message) {
                const container = document.getElementById('toast-container');
                if (!container) return;
                const toast = document.createElement('div');
                toast.className = 'toast';
                toast.innerHTML = `
                    <div class="toast-content">
                        <span class="toast-title">${title}</span>
                        <span class="toast-message">${message}</span>
                    </div>
                    <button class="toast-close" onclick="this.parentElement.remove()">&times;</button>
                `;
                container.appendChild(toast);
                setTimeout(() => {
                    toast.style.animation = 'fadeOut 0.3s forwards';
                    setTimeout(() => toast.remove(), 300);
                }, 5000);
            }

            async function fetchNotifications() {
                try {
                    const res = await fetch('../includes/notification_fetch.php?limit=10&t=' + Date.now(), {
                        cache: 'no-store',
                        credentials: 'same-origin'
                    });
                    if (!res.ok) {
                        throw new Error('HTTP ' + res.status);
                    }
                    const data = await res.json();
                    if (data.status !== 'success') {
                        renderNotifications([]);
                        return;
                    }
                    const unread = typeof data.unread === 'number' ? data.unread : 0;
                    if (badgeEl) badgeEl.textContent = unread;

                    const items = Array.isArray(data.notifications) ? data.notifications : [];
                    
                    // Popup Logic
                    if (items.length > 0) {
                        const latest = items[0].id;
                        if (!isFirstLoad && latest > lastNavId) {
                            const newItems = items.filter(n => n.id > lastNavId);
                            newItems.forEach(n => {
                                showToast(n.title || 'New Notification', n.message || '');
                            });
                        }
                        lastNavId = latest;
                    }
                    isFirstLoad = false;

                    renderNotifications(items);
                } catch (e) {
                    renderNotifications([]);
                }
            }

            if (markAllBtn) {
                markAllBtn.addEventListener('click', async (e) => {
                    e.preventDefault();
                    try {
                        await fetch('../includes/notification_read.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: 'mark_all=1&csrf_token=' + encodeURIComponent(csrfToken)
                        });
                        fetchNotifications();
                    } catch (e) {
                        // silent fail
                    }
                });
            }

            function animateValue(el, target) {
                const duration = 1200;
                const startTime = performance.now();
                const startValue = parseInt((el.textContent || '0').replace(/[^0-9]/g, ''), 10) || 0;

                function update(now) {
                    const progress = Math.min((now - startTime) / duration, 1);
                    const value = Math.floor(startValue + (target - startValue) * progress);
                    el.textContent = `${value}`;
                    if (progress < 1) {
                        requestAnimationFrame(update);
                    } else {
                        el.textContent = `${target}`;
                    }
                }

                requestAnimationFrame(update);
            }

            function animateCounters() {
                const counters = document.querySelectorAll('.stat-number[data-target]');
                counters.forEach((el) => {
                    const target = parseInt(el.getAttribute('data-target') || '0', 10);
                    animateValue(el, target);
                });
            }

            function getInitials(name) {
                if (!name) return '??';
                const parts = name.split(' ');
                if (parts.length === 1) return parts[0].substring(0, 2).toUpperCase();
                return (parts[0][0] + parts[parts.length - 1][0]).toUpperCase();
            }

            function timeAgo(dateString) {
                const date = new Date(dateString.replace(' ', 'T'));
                const now = new Date();
                const seconds = Math.floor((now - date) / 1000);

                if (seconds < 60) return 'Just now';
                const minutes = Math.floor(seconds / 60);
                if (minutes < 60) return minutes + 'm ago';
                const hours = Math.floor(minutes / 60);
                if (hours < 24) return hours + 'h ago';
                const days = Math.floor(hours / 24);
                return days + 'd ago';
            }

            async function fetchRecentActivity() {
                const activityList = document.getElementById('activityList');
                if (!activityList) return;

                try {
                    const res = await fetch('../logs/fetch_logs_ajax.php?per_page=8&t=' + Date.now(), {
                        cache: 'no-store'
                    });
                    const data = await res.json();

                    if (data.status === 'ok' && data.logs) {
                        if (data.logs.length === 0) {
                            activityList.innerHTML = '<div style="padding: 20px; text-align: center; color: #888;">No recent activity found.</div>';
                            return;
                        }

                        activityList.innerHTML = data.logs.map(log => {
                            const initials = getInitials(log.full_name);
                            const timeStr = timeAgo(log.timestamp);
                            const action = log.action_type === 'page_view' ? 'Visited' : (log.action_type === 'click' ? 'Clicked' : log.action_type);
                            const element = log.element_text ? ` <strong>"${log.element_text}"</strong>` : '';
                            const page = log.page_label ? ` on ${log.page_label}` : '';
                            
                            return `
                                <div class="activity-item">
                                    <div class="activity-avatar">${initials}</div>
                                    <div class="activity-content">
                                        <div class="activity-text">${log.full_name} ${action}${element}${page}</div>
                                        <div class="activity-time">${timeStr}</div>
                                    </div>
                                </div>
                            `;
                        }).join('');
                    }
                } catch (e) {
                    console.error('Activity fetch error:', e);
                }
            }

            window.refreshAdminStats = function () {
                animateCounters();
                fetchRecentActivity();
            };

            fetchNotifications();
            animateCounters();
            fetchRecentActivity();
            setInterval(fetchNotifications, 5000);
            setInterval(fetchRecentActivity, 300000);
        })();
    </script>
</body>

</html>
