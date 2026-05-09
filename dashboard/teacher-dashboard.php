<?php
require '../includes/security.php';
require '../includes/config.php';

// Start secure session, send headers, and allow only teacher
start_secure_session();
// Apply security headers for this request.
send_security_headers();
// Enforce role-based access control.
require_role('teacher', '../admin_login.php');

// --- Stats for teacher dashboard ---
$total_students = 0;
$todays_classes = 0;
$pending_homework = 0;
$total_subjects = 0;

// Total students count
$res = mysqli_query($con, "SELECT COUNT(*) AS cnt FROM add_students");
if ($res && ($row = mysqli_fetch_assoc($res))) {
    $total_students = (int) $row['cnt'];
}

// Today's classes (from timetable) - check if table exists first
$today = date('l'); // Monday, Tuesday, etc.
$table_check = mysqli_query($con, "SHOW TABLES LIKE 'time_table'");
if ($table_check && mysqli_num_rows($table_check) > 0) {
    $res = mysqli_query($con, "SELECT COUNT(*) AS cnt FROM time_table WHERE day_of_week = '$today'");
    if ($res && ($row = mysqli_fetch_assoc($res))) {
        $todays_classes = (int) $row['cnt'];
    }
} else {
    // Table doesn't exist, use 0
    $todays_classes = 0;
}

// Pending homework (dummy for now - you can add homework table later)
$pending_homework = 0;

// Total subjects/courses
$res = mysqli_query($con, "SELECT COUNT(*) AS cnt FROM course_add");
if ($res && ($row = mysqli_fetch_assoc($res))) {
    $total_subjects = (int) $row['cnt'];
}

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
                <span>Teachers</span>
            </div>
        </div>
        <div class="header-right">
            <div class="user-dropdown">
                <button class="notification-btn" id="notificationBtn">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge" id="notificationBadge">0</span>
                </button>
                <div class="notification-dropdown" id="notificationDropdown">
                    <div class="notification-header">
                        <span class="notification-title">Notifications</span>
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
                    <?php 
                        echo $_SESSION['username'];
                    ?>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu" id="userDropdown">
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-user"></i>
                        Profile
                    </a>
                    <a href="../login_includes/logout.php" class="dropdown-item">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
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


        <!-- <div class="sidebar-item">
            <div class="sidebar-main" data-menu="classes">
                <div class="sidebar-main-content">
                    <i class="fas fa-chalkboard"></i>
                    <span>Classes</span>
                </div>
                <i class="fas fa-chevron-down sidebar-arrow"></i>
            </div>
            <div class="sidebar-submenu">
                <div class="submenu-item" data-page="show-class">Classes</div>
                <div class="submenu-item" data-page="show-course">Courses</div>
            </div>
        </div> -->

        <div class="sidebar-item">
            <div class="sidebar-main" data-menu="routines">
                <div class="sidebar-main-content">
                    <i class="fas fa-calendar-alt"></i>
                    <span> Class Routines</span>
                </div>
                <i class="fas fa-chevron-down sidebar-arrow"></i>
            </div>
            <div class="sidebar-submenu">
                <div class="submenu-item" data-page="show-timetd">Time Table</div>
            </div>
        </div>

        <div class="sidebar-item">
            <div class="sidebar-main" data-menu="examinations">
                <div class="sidebar-main-content">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Examinations Details</span>
                </div>
                <i class="fas fa-chevron-down sidebar-arrow"></i>
            </div>
            <div class="sidebar-submenu">
                <!-- <div class="submenu-item" data-page="show-examinforms">Examination Form</div>
                <div class="submenu-item" data-page="show-admin-card">Admin card</div> -->
                <div class="submenu-item" data-page="paper-time-table">Paper Schedule</div>
                <div class="submenu-item" data-page="show-paper-sch">Show Schedule</div>
                <div class="submenu-item" data-page="result-add">Results</div>
                <div class="submenu-item" data-page="show-result">View Results</div>
            </div>
        </div>

        <div class="sidebar-item">
            <div class="sidebar-main" data-menu="attendance">
                <div class="sidebar-main-content">
                    <i class="fas fa-user-check"></i>
                    <span> Manage Attendance</span>
                </div>
                <i class="fas fa-chevron-down sidebar-arrow"></i>
            </div>
            <div class="sidebar-submenu">
                <div class="submenu-item" data-page="show-attendance">Show Attendance</div>
                <!-- <div class="submenu-item" data-page="leave">Leave</div>  -->
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
                <div class="submenu-item" data-page="show-study-mat">Show Study Materials</div>
            </div>
        </div>

        <div class="sidebar-item">
            <div class="sidebar-main" data-menu="materials">
                <div class="sidebar-main-content">
                    <i class="fas fa-book"></i>
                    <span>Exam-Section</span>
                </div>
                <i class="fas fa-chevron-down sidebar-arrow"></i>
            </div>
            <div class="sidebar-submenu">
                <div class="submenu-item" data-page="teacher_create_exam"> Online MCQ Exam </div>
                <div class="submenu-item" data-page="show_exams">Show MCQ Exam Results </div>
            </div>
        </div>

        <div class="sidebar-item">
            <div class="sidebar-main" data-menu="events">
                <div class="sidebar-main-content">
                    <i class="fas fa-calendar"></i>
                    <span> Events</span>
                </div>
                <i class="fas fa-chevron-down sidebar-arrow"></i>
            </div>
            <div class="sidebar-submenu">
                <div class="submenu-item" data-page="show-cls-fun">Clases Functions</div>
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
                <div class="submenu-item" data-page="show-meets">Parent's Meetings</div>
            </div>
        </div>

    </nav>
    <!-- Academy Settings end -->

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <div class="dashboard-header">
            <div>
                <h1 class="dashboard-title">Dashboard</h1>
                <div class="breadcrumb">
                    <a href="#">Teachers</a> / Dashboard
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
       <div class="stats-grid">
            <div class="stat-card students">
                <div class="stat-header">
                    <div>
                        <div class="stat-number" id="teacherStudents" data-target="<?= $total_students ?>">0</div>
                        <div class="stat-label">My Class Students</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card teachers">
                <div class="stat-header">
                    <div>
                        <div class="stat-number" id="teacherClasses" data-target="<?= $todays_classes ?>">0</div>
                        <div class="stat-label">Today's Classes</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card courses">
                <div class="stat-header">
                    <div>
                        <div class="stat-number" id="teacherHomework" data-target="<?= $pending_homework ?>">0</div>
                        <div class="stat-label">Pending Homework</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-book-open"></i>
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


        <!-- Notifications -->
        <div class="notifications-card">
            <h2 class="card-title">
                <i class="fas fa-bell"></i>
                Recent Notifications
            </h2>
            <div id="recentNotifications">
                <div class="notification-item">
                    <div class="notification-text">Loading notifications...</div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="activity-card">
            <h2 class="card-title">
                <i class="fas fa-clock"></i>
                Recent Activity
            </h2>
            <div class="activity-item">
                <div class="activity-avatar">JD</div>
                <div class="activity-content">
                    <div class="activity-text">John Doe submitted assignment for Mathematics</div>
                    <div class="activity-time">2 hours ago</div>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-avatar">SM</div>
                <div class="activity-content">
                    <div class="activity-text">Sarah Miller updated student grades</div>
                    <div class="activity-time">4 hours ago</div>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-avatar">RJ</div>
                <div class="activity-content">
                    <div class="activity-text">Robert Johnson created new course syllabus</div>
                    <div class="activity-time">6 hours ago</div>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-avatar">EW</div>
                <div class="activity-content">
                    <div class="activity-text">Emily Wilson scheduled parent meeting</div>
                    <div class="activity-time">1 day ago</div>
                </div>
            </div>
        </div>

        <!-- chatbot code start -->


        <div id="chatbot-icon"><i class="fa-solid fa-robot"></i></div>
        <div id="chatbot-container" class="hidden">

            <!-- header part -->
            <div id="chatbot-header">
                <span style="font-size:25px; font-weight: 900;">ChatBot</span>
                <button id="close-btn">&times;</button><!--&times; cross icons shortcut   -->
            </div>

            <!-- body part -->
            <div id="chatbot-body">
                <div id="chatbot-messages"></div>
            </div>

            <!-- jaha pe message type hoga or send hoga -->
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


        <!-- chatbot code end -->

        <!-- Footer -->
        <footer class="footer">
            <p>Copyright Â© 2025 <a href="#">class Management System By <!--by Abhishek Suhas Pathak--></a>. All rights
                reserved. | Version 1.0</p>
        </footer>
    </main>


</body>
<script src="../js/dashboard.js"></script>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    (function () {
        const listEl = document.getElementById('notificationList');
        const badgeEl = document.getElementById('notificationBadge');
        const markAllBtn = document.getElementById('markAllReadBtn');
        const recentEl = document.getElementById('recentNotifications');
        const csrfMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

        function formatDate(ts) {
            const d = new Date(ts.replace(' ', 'T'));
            if (Number.isNaN(d.getTime())) return ts;
            return d.toLocaleString();
        }

        function renderDropdown(items) {
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
                            <div class="notification-dropdown-time">${formatDate(n.created_at)}</div>
                        </div>
                    </div>`;
            }).join('');
        }

        function renderRecent(items) {
            if (!recentEl) return;
            if (!items || items.length === 0) {
                recentEl.innerHTML = `
                    <div class="notification-item">
                        <div class="notification-text">No notifications found</div>
                    </div>`;
                return;
            }
            recentEl.innerHTML = items.slice(0, 5).map(n => {
                const iconClass = n.is_read == 0 ? 'new' : '';
                const title = n.title ? n.title.replace(/</g, '&lt;') : '';
                return `
                    <div class="notification-item">
                        <div class="notification-icon ${iconClass}"></div>
                        <div class="notification-text">${title}</div>
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
                    renderDropdown([]);
                    renderRecent([]);
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

                renderDropdown(items);
                renderRecent(items);
            } catch (e) {
                renderDropdown([]);
                renderRecent([]);
            }
        }

        // Just calling it below

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

        // ? Number Animation Function (same as admin dashboard)
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

        fetchNotifications();
        animateCounters(); // ? Start animation on page load
        setInterval(fetchNotifications, 5000); // Faster Interval
    })();
</script>

</html>
