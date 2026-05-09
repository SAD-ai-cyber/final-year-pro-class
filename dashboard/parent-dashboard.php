<?php
require '../includes/security.php';
require '../includes/config.php';

// Start secure session, send headers, and allow only parent
start_secure_session();
// Apply security headers for this request.
send_security_headers();
// Enforce role-based access control.
require_role('parent', '../admin_login.php');

$parent_email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$child_id = 0;

if (!empty($parent_email)) {
    $stmt = $con->prepare(
        "SELECT Student_ID AS student_id FROM add_result WHERE parent_email = ?
         UNION
         SELECT student_id AS student_id FROM student_fees WHERE parent_email = ?
         LIMIT 1"
    );
    $stmt->bind_param("ss", $parent_email, $parent_email);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $child_id = (int) $row['student_id'];
    }
    $stmt->close();
}

$present_days = 0;
$fees_due = 0;
$latest_grade = '-';
$remarks_count = 0;

if ($child_id > 0) {
    $sid_str = (string) $child_id;

    // Attendance (last 30 days)
    $stmt = $con->prepare(
        "SELECT COUNT(DISTINCT attendance_date) AS days
         FROM attendance_logs
         WHERE student_id = ?
           AND attendance_date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)"
    );
    $stmt->bind_param("s", $sid_str);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $present_days = (int) $row['days'];
    }
    $stmt->close();

    // Fees due (latest)
    $stmt = $con->prepare(
        "SELECT remaining_price FROM student_fees
         WHERE parent_email = ?
         ORDER BY created_at DESC
         LIMIT 1"
    );
    $stmt->bind_param("s", $parent_email);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $fees_due = (float) $row['remaining_price'];
    }
    $stmt->close();

    // Latest grade/result
    $stmt = $con->prepare(
        "SELECT grade, result_status
         FROM add_result
         WHERE parent_email = ?
         ORDER BY upload_date DESC
         LIMIT 1"
    );
    $stmt->bind_param("s", $parent_email);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $grade = trim((string) $row['grade']);
        $status = trim((string) $row['result_status']);
        $latest_grade = $grade !== '' ? $grade : ($status !== '' ? $status : '-');
    }
    $stmt->close();

    // Teacher remarks count
    $stmt = $con->prepare(
        "SELECT COUNT(*) AS cnt
         FROM add_result
         WHERE parent_email = ?
           AND instructor_comments IS NOT NULL
           AND instructor_comments <> ''"
    );
    $stmt->bind_param("s", $parent_email);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $remarks_count = (int) $row['cnt'];
    }
    $stmt->close();
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
                <span>Parents</span>
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

                    <?php echo $_SESSION['username'];  ?>
                    
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu" id="userDropdown">
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
                <div class="submenu-item" data-page="show-paper-sch">Paper Schedule</div>
                <div class="submenu-item" data-page="show-result">Results</div>
            </div>
        </div>

        <div class="sidebar-item">
            <div class="sidebar-main" data-menu="attendance">
                <div class="sidebar-main-content">
                    <i class="fas fa-user-check"></i>
                    <span> Attendance</span>
                </div>
                <i class="fas fa-chevron-down sidebar-arrow"></i>
            </div>
            <div class="sidebar-submenu">
                <div class="submenu-item" data-page="show-attendance">Attendance</div>
            </div>
        </div>

        <div class="sidebar-item">
            <div class="sidebar-main" data-menu="accounting">
                <div class="sidebar-main-content">
                    <i class="fas fa-calculator"></i>
                    <span>Accountings</span>
                </div>
                <i class="fas fa-chevron-down sidebar-arrow"></i>
            </div>
            <div class="sidebar-submenu">
                <div class="submenu-item" data-page="show-std-fee">Student Fee Details</div>
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
                    <a href="#">Parents</a> / Dashboard
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
      <div class="stats-grid">
            <div class="stat-card students">
                <div class="stat-header">
                    <div>
                            <div class="stat-number" id="stats-attendance"><?php echo $present_days; ?>/30</div>
                        <div class="stat-label">Days Present (Nov)</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-user-clock"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card teachers">
                <div class="stat-header">
                    <div>
                            <div class="stat-number" id="stats-fees">₹ <?php echo number_format($fees_due, 2); ?></div>
                        <div class="stat-label">Fees Due</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card courses">
                <div class="stat-header">
                    <div>
                            <div class="stat-number" id="stats-grade"><?php echo htmlspecialchars($latest_grade); ?></div>
                        <div class="stat-label">Latest Grade</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card inquiries">
                <div class="stat-header">
                    <div>
                            <div class="stat-number" id="stats-remarks"><?php echo $remarks_count; ?> New</div>
                        <div class="stat-label">Teacher Remarks</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-comment-alt"></i>
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
            <p>Copyright Â© 2025 <a href="#">class Management System<!--by Abhishek Suhas Pathak--></a>. All rights
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

            // Auto remove
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
                        // Find all new notifications
                        const newItems = items.filter(n => n.id > lastNavId);
                        newItems.forEach(n => {
                            showToast(n.title || 'New Notification', n.message || '');
                        });
                        // Play sound? Optional
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

        // Removed existing fetchNotifications definition to prevent conflict
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

        async function fetchStats() {
            try {
                const res = await fetch('../includes/fetch_parent_stats.php', {
                    cache: 'no-store'
                });
                if (!res.ok) throw new Error('HTTP ' + res.status);
                const data = await res.json();
                if (data.status === 'success') {
                    if (document.getElementById('stats-attendance')) 
                        document.getElementById('stats-attendance').textContent = data.present_days + '/30';
                    
                    if (document.getElementById('stats-fees')) 
                        document.getElementById('stats-fees').textContent = '₹ ' + data.fees_due;
                    
                    if (document.getElementById('stats-grade')) 
                        document.getElementById('stats-grade').textContent = data.latest_grade;
                    
                    if (document.getElementById('stats-remarks')) 
                        document.getElementById('stats-remarks').textContent = data.remarks_count + ' New';
                }
            } catch (e) {
                console.error('Stats fetch error:', e);
            }
        }

        fetchNotifications(); // Initial fetch
        fetchStats(); // Initial stats
        setInterval(fetchNotifications, 5000); // Check every 5 seconds for faster popup
        setInterval(fetchStats, 10000); // Update stats every 10 seconds
    })();
</script>

</html>
