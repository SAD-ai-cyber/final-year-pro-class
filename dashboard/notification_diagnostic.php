<?php
/**
 * Notification System Diagnostic Tool
 * 
 * This script checks all aspects of the notification system
 * and reports any issues found.
 */

require '../includes/config.php';
require '../includes/security.php';
require '../includes/notification_helper.php';

start_secure_session();
require_role('admin');

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notification System Diagnostics</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .test-section {
            background: white;
            padding: 20px;
            margin: 15px 0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .test-section h2 {
            margin-top: 0;
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .success {
            color: #28a745;
            font-weight: bold;
        }
        .error {
            color: #dc3545;
            font-weight: bold;
        }
        .warning {
            color: #ffc107;
            font-weight: bold;
        }
        .info {
            color: #17a2b8;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background: #f8f9fa;
            font-weight: bold;
        }
        .code {
            background: #f4f4f4;
            padding: 10px;
            border-left: 3px solid #007bff;
            margin: 10px 0;
            font-family: monospace;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <h1>Ã°Å¸â€â€ Notification System Diagnostics</h1>
    
    <?php
    $issues = [];
    $warnings = [];
    
    // Test 1: Check if notifications table exists
    echo '<div class="test-section">';
    echo '<h2>1. Database Table Check</h2>';
    
    $table_check = mysqli_query($con, "SHOW TABLES LIKE 'notifications'");
    if ($table_check && mysqli_num_rows($table_check) > 0) {
        echo '<p class="success">Ã¢Å“â€œ Notifications table exists</p>';
        
        // Check table structure
        $columns = mysqli_query($con, "DESCRIBE notifications");
        echo '<table>';
        echo '<tr><th>Column</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>';
        while ($col = mysqli_fetch_assoc($columns)) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($col['Field']) . '</td>';
            echo '<td>' . htmlspecialchars($col['Type']) . '</td>';
            echo '<td>' . htmlspecialchars($col['Null']) . '</td>';
            echo '<td>' . htmlspecialchars($col['Key']) . '</td>';
            echo '<td>' . htmlspecialchars($col['Default']) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p class="error">Ã¢Å“â€” Notifications table does NOT exist!</p>';
        $issues[] = 'Notifications table missing';
        echo '<div class="code">Run this SQL to create the table:<br><br>';
        echo 'CREATE TABLE `notifications` (<br>';
        echo '  `id` INT AUTO_INCREMENT PRIMARY KEY,<br>';
        echo '  `user_role` VARCHAR(50) NOT NULL,<br>';
        echo '  `user_id` INT NOT NULL,<br>';
        echo '  `title` VARCHAR(255) NOT NULL,<br>';
        echo '  `message` TEXT NOT NULL,<br>';
        echo '  `link` VARCHAR(255) DEFAULT NULL,<br>';
        echo '  `is_read` TINYINT(1) DEFAULT 0,<br>';
        echo '  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP<br>';
        echo ') ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;';
        echo '</div>';
    }
    echo '</div>';
    
    // Test 2: Count notifications by role
    echo '<div class="test-section">';
    echo '<h2>2. Notifications Count by Role</h2>';
    
    $roles = ['admin', 'teacher', 'student', 'parent'];
    echo '<table>';
    echo '<tr><th>Role</th><th>Total</th><th>Unread</th><th>Read</th></tr>';
    
    foreach ($roles as $role) {
        $total_query = mysqli_query($con, "SELECT COUNT(*) as cnt FROM notifications WHERE user_role = '$role'");
        $total = 0;
        if ($total_query && ($row = mysqli_fetch_assoc($total_query))) {
            $total = (int)$row['cnt'];
        }
        
        $unread_query = mysqli_query($con, "SELECT COUNT(*) as cnt FROM notifications WHERE user_role = '$role' AND is_read = 0");
        $unread = 0;
        if ($unread_query && ($row = mysqli_fetch_assoc($unread_query))) {
            $unread = (int)$row['cnt'];
        }
        
        $read = $total - $unread;
        
        echo '<tr>';
        echo '<td><strong>' . ucfirst($role) . '</strong></td>';
        echo '<td>' . $total . '</td>';
        echo '<td class="warning">' . $unread . '</td>';
        echo '<td class="success">' . $read . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    echo '</div>';
    
    // Test 3: Check recent notifications
    echo '<div class="test-section">';
    echo '<h2>3. Recent Notifications (Last 10)</h2>';
    
    $recent = mysqli_query($con, "SELECT * FROM notifications ORDER BY created_at DESC LIMIT 10");
    if ($recent && mysqli_num_rows($recent) > 0) {
        echo '<table>';
        echo '<tr><th>ID</th><th>Role</th><th>User ID</th><th>Title</th><th>Message</th><th>Read</th><th>Created</th></tr>';
        while ($notif = mysqli_fetch_assoc($recent)) {
            $read_status = $notif['is_read'] == 1 ? '<span class="success">Ã¢Å“â€œ</span>' : '<span class="warning">Ã¢Å“â€”</span>';
            echo '<tr>';
            echo '<td>' . $notif['id'] . '</td>';
            echo '<td>' . htmlspecialchars($notif['user_role']) . '</td>';
            echo '<td>' . $notif['user_id'] . '</td>';
            echo '<td>' . htmlspecialchars(substr($notif['title'], 0, 30)) . '</td>';
            echo '<td>' . htmlspecialchars(substr($notif['message'], 0, 50)) . '</td>';
            echo '<td>' . $read_status . '</td>';
            echo '<td>' . $notif['created_at'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p class="warning">Ã¢Å¡Â  No notifications found in database</p>';
        $warnings[] = 'No notifications in database';
    }
    echo '</div>';
    
    // Test 4: Check user tables
    echo '<div class="test-section">';
    echo '<h2>4. User Tables Check</h2>';
    
    $user_tables = [
        'admins' => 'admin_id',
        'add_teachers' => 'teacher_id',
        'add_students' => 'student_id',
        'add_parents' => 'parent_id'
    ];
    
    echo '<table>';
    echo '<tr><th>Table</th><th>Status</th><th>Count</th></tr>';
    
    foreach ($user_tables as $table => $id_field) {
        $check = mysqli_query($con, "SHOW TABLES LIKE '$table'");
        if ($check && mysqli_num_rows($check) > 0) {
            $count_query = mysqli_query($con, "SELECT COUNT(*) as cnt FROM $table");
            $count = 0;
            if ($count_query && ($row = mysqli_fetch_assoc($count_query))) {
                $count = (int)$row['cnt'];
            }
            echo '<tr>';
            echo '<td>' . $table . '</td>';
            echo '<td class="success">Ã¢Å“â€œ Exists</td>';
            echo '<td>' . $count . ' users</td>';
            echo '</tr>';
        } else {
            echo '<tr>';
            echo '<td>' . $table . '</td>';
            echo '<td class="error">Ã¢Å“â€” Missing</td>';
            echo '<td>-</td>';
            echo '</tr>';
            $issues[] = "Table $table is missing";
        }
    }
    echo '</table>';
    echo '</div>';
    
    // Test 5: Test notification creation
    echo '<div class="test-section">';
    echo '<h2>5. Test Notification Creation</h2>';
    
    // Get first admin
    $admin_query = mysqli_query($con, "SELECT admin_id FROM admins LIMIT 1");
    if ($admin_query && ($admin = mysqli_fetch_assoc($admin_query))) {
        $admin_id = (int)$admin['admin_id'];
        
        // Try to create a test notification
        $test_title = "Test Notification - " . date('Y-m-d H:i:s');
        $test_message = "This is a test notification created by the diagnostic tool.";
        $test_link = "dashboard/dashboard.php";
        
        $result = sendNotification($con, 'admin', $admin_id, $test_title, $test_message, $test_link);
        
        if ($result) {
            echo '<p class="success">Ã¢Å“â€œ Successfully created test notification for admin ID: ' . $admin_id . '</p>';
            echo '<p class="info">Title: ' . htmlspecialchars($test_title) . '</p>';
            echo '<p class="info">Message: ' . htmlspecialchars($test_message) . '</p>';
            
            // Clean up test notification
            mysqli_query($con, "DELETE FROM notifications WHERE title = '" . mysqli_real_escape_string($con, $test_title) . "'");
            echo '<p class="info">Test notification cleaned up.</p>';
        } else {
            echo '<p class="error">Ã¢Å“â€” Failed to create test notification</p>';
            $issues[] = 'Cannot create notifications';
        }
    } else {
        echo '<p class="warning">Ã¢Å¡Â  No admin user found to test with</p>';
        $warnings[] = 'No admin user available for testing';
    }
    echo '</div>';
    
    // Test 6: Check notification fetch endpoint
    echo '<div class="test-section">';
    echo '<h2>6. Notification Fetch Endpoint</h2>';
    
    $fetch_file = '../includes/notification_fetch.php';
    if (file_exists($fetch_file)) {
        echo '<p class="success">Ã¢Å“â€œ notification_fetch.php exists</p>';
        echo '<p class="info">Path: ' . realpath($fetch_file) . '</p>';
    } else {
        echo '<p class="error">Ã¢Å“â€” notification_fetch.php NOT found</p>';
        $issues[] = 'notification_fetch.php missing';
    }
    
    $read_file = '../includes/notification_read.php';
    if (file_exists($read_file)) {
        echo '<p class="success">Ã¢Å“â€œ notification_read.php exists</p>';
        echo '<p class="info">Path: ' . realpath($read_file) . '</p>';
    } else {
        echo '<p class="error">Ã¢Å“â€” notification_read.php NOT found</p>';
        $issues[] = 'notification_read.php missing';
    }
    echo '</div>';
    
    // Summary
    echo '<div class="test-section">';
    echo '<h2>Ã°Å¸â€œÅ  Summary</h2>';
    
    if (count($issues) == 0 && count($warnings) == 0) {
        echo '<p class="success" style="font-size: 18px;">Ã¢Å“â€œ All tests passed! Notification system is working properly.</p>';
    } else {
        if (count($issues) > 0) {
            echo '<h3 class="error">Critical Issues Found:</h3>';
            echo '<ul>';
            foreach ($issues as $issue) {
                echo '<li class="error">' . htmlspecialchars($issue) . '</li>';
            }
            echo '</ul>';
        }
        
        if (count($warnings) > 0) {
            echo '<h3 class="warning">Warnings:</h3>';
            echo '<ul>';
            foreach ($warnings as $warning) {
                echo '<li class="warning">' . htmlspecialchars($warning) . '</li>';
            }
            echo '</ul>';
        }
    }
    echo '</div>';
    ?>
    
    <div class="test-section">
        <h2>Ã°Å¸â€Â§ Quick Actions</h2>
        <p><a href="../show-details/show-notifications.php" style="color: #007bff;">View All Notifications</a></p>
        <p><a href="../dashboard/dashboard.php" style="color: #007bff;">Back to Dashboard</a></p>
    </div>
</body>
</html>
