<?php
require '../includes/security.php';
require '../includes/config.php';

// Security/session bootstrap.
start_secure_session();
// Apply security headers for this request.
send_security_headers();

// Security check: Allow student OR parent
if (!isset($_SESSION['student_id']) && (!isset($_SESSION['role']) || $_SESSION['role'] !== 'parent')) {
    header("Location: ../login.php");
    exit;
}

// For parents, we should use the child_id (stored in session during login or dashboard load)
$student_id = $_SESSION['student_id'] ?? ($_SESSION['child_id'] ?? 0);

if ($student_id <= 0 && $_SESSION['role'] === 'parent') {
    // If child_id not in session, try to find it from parent email
    $parent_email = $_SESSION['email'] ?? '';
    if ($parent_email) {
        $stmt = $con->prepare("SELECT student_id FROM student_fees WHERE parent_email = ? LIMIT 1");
        $stmt->bind_param("s", $parent_email);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            $student_id = $row['student_id'];
            $_SESSION['child_id'] = $student_id;
        }
    }
}

if ($student_id <= 0) {
    die("No student/child record associated with this account.");
}

// Get student info from add_students table (main attendance system table)
$student_sql = "SELECT * FROM add_students WHERE student_id = ?";
$stmt = $con->prepare($student_sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$student_res = $stmt->get_result();
$student = $student_res->fetch_assoc();

if (!$student) {
    die("Student record not found in attendance system");
}

$student_name = $student['student_name'];
$student_email = $student['student_email'];
$student_num = $student['student_num'];

// Calculate current week stats (Monday to Sunday)
$today = date('Y-m-d');
$week_start = date('Y-m-d', strtotime('monday this week'));
$week_end = date('Y-m-d', strtotime('sunday this week'));

// Get weekly attendance
$stats_sql = "SELECT COUNT(*) as present_days 
    FROM attendance_logs 
    WHERE student_id = ? 
    AND DATE(check_in_time) BETWEEN ? AND ?";
$stmt = $con->prepare($stats_sql);
$stmt->bind_param("iss", $student_id, $week_start, $week_end);
$stmt->execute();
$stats = $stmt->get_result()->fetch_assoc();

$present_days = $stats['present_days'] ?? 0;
$days_elapsed = (new DateTime($week_start))->diff(new DateTime($today))->days + 1;
if ($days_elapsed < 0) { $days_elapsed = 0; }
$absent_days = max(0, $days_elapsed - $present_days);
$attendance_percentage = $days_elapsed > 0 ? round(($present_days / $days_elapsed) * 100, 2) : 0;

// Get current week attendance with time
$week_sql = "SELECT DATE(check_in_time) as date, TIME(check_in_time) as in_time, TIME(check_out_time) as out_time 
    FROM attendance_logs 
    WHERE student_id = ? 
    AND DATE(check_in_time) BETWEEN ? AND ?
    ORDER BY check_in_time DESC";
$stmt = $con->prepare($week_sql);
$stmt->bind_param("iss", $student_id, $week_start, $week_end);
$stmt->execute();
$attendance_records = $stmt->get_result();
$attendance_data = [];
while ($row = $attendance_records->fetch_assoc()) {
    $attendance_data[$row['date']] = [
        'in' => $row['in_time'],
        'out' => $row['out_time']
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Attendance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; color: #333; }
        .attendance-container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        
        /* Header */
        .header-section { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: space-between; }
        .student-profile { display: flex; align-items: center; gap: 20px; }
        .profile-avatar { width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: bold; }
        .profile-info h2 { margin-bottom: 5px; color: #2c3e50; }
        .profile-info p { color: #7f8c8d; font-size: 14px; }
        .refresh-btn { padding: 10px 20px; background: #4e73df; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; }
        .refresh-btn:hover { background: #2e59d9; }
        
        /* Stats */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px; }
        .stat-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center; position: relative; overflow: hidden; }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 4px; }
        .stat-card.present::before { background: #1cc88a; }
        .stat-card.absent::before { background: #e74a3b; }
        .stat-card.percentage::before { background: #4e73df; }
        .stat-value { font-size: 36px; font-weight: bold; margin-bottom: 10px; }
        .stat-card.present .stat-value { color: #1cc88a; }
        .stat-card.absent .stat-value { color: #e74a3b; }
        .stat-card.percentage .stat-value { color: #4e73df; }
        .stat-label { color: #858796; font-size: 14px; text-transform: uppercase; }
        
        /* Progress */
        .content-section { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .progress-container { margin: 20px 0; background: #e9ecef; border-radius: 10px; height: 30px; overflow: hidden; }
        .progress-bar { height: 100%; background: linear-gradient(90deg, #1cc88a 0%, #13855c 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px; transition: width 0.3s ease; }
        
        /* Table */
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #e3e6f0; }
        .section-title { font-size: 20px; color: #2c3e50; font-weight: 600; }
        .month-badge { background: #4e73df; color: white; padding: 5px 15px; border-radius: 20px; font-size: 13px; }
        .attendance-table { width: 100%; border-collapse: collapse; }
        .attendance-table thead { background: #f8f9fc; }
        .attendance-table th { padding: 12px; text-align: left; font-weight: 600; color: #5a5c69; font-size: 13px; text-transform: uppercase; }
        .attendance-table td { padding: 12px; border-bottom: 1px solid #e3e6f0; }
        .attendance-table tr:hover { background: #f8f9fc; }
        .date-cell { font-weight: 500; color: #4e73df; }
        .status-badge { display: inline-block; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .status-badge.present { background: #d4edda; color: #155724; }
        .status-badge.absent { background: #f8d7da; color: #721c24; }
        .status-badge.future { background: #e2e3e5; color: #6c757d; }
        .time-badge { background: #e7f1ff; color: #004085; padding: 3px 8px; border-radius: 3px; font-size: 11px; display: inline-block; margin-bottom: 2px; }
        .time-badge.out { background: #fff0f0; color: #a80000; }
        .no-data { text-align: center; padding: 40px; color: #858796; }
    </style>
</head>
<body>
    <div class="attendance-container">
        <!-- Today's Attendance -->
        <?php
        $today_data = $attendance_data[$today] ?? null;
        ?>
        <div class="content-section" style="margin-bottom: 20px; border-left: 5px solid #4e73df;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="color: #2c3e50; font-size: 18px;"><i class="fas fa-calendar-check"></i> Today's Attendance</h3>
                    <p style="color: #858796; font-size: 13px;"><?php echo date('l, d F Y'); ?></p>
                </div>
                <div style="text-align: right;">
                    <?php if ($today_data): ?>
                        <div style="display: flex; gap: 15px;">
                            <div style="text-align: center;">
                                <div style="font-size: 10px; text-transform: uppercase; color: #858796;">Check-In</div>
                                <div style="color: #28a745; font-weight: bold; font-size: 16px;">
                                    <i class="fas fa-sign-in-alt"></i> <?php echo date('h:i A', strtotime($today_data['in'])); ?>
                                </div>
                            </div>
                            <div style="text-align: center;">
                                <div style="font-size: 10px; text-transform: uppercase; color: #858796;">Check-Out</div>
                                <div style="color: <?php echo $today_data['out'] ? '#dc3545' : '#f6c23e'; ?>; font-weight: bold; font-size: 16px;">
                                    <?php if ($today_data['out']): ?>
                                        <i class="fas fa-sign-out-alt"></i> <?php echo date('h:i A', strtotime($today_data['out'])); ?>
                                    <?php else: ?>
                                        <i class="fas fa-clock"></i> Pending
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <span class="status-badge absent">Not Marked Yet</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="header-section">
            <div class="student-profile">
                <div class="profile-avatar"><?php echo strtoupper(substr($student_name, 0, 2)); ?></div>
                <div class="profile-info">
                    <h2><?php echo htmlspecialchars($student_name); ?></h2>
                    <p><i class="fas fa-id-card"></i> ID: <?php echo $student_id; ?> | <i class="fas fa-envelope"></i> <?php echo htmlspecialchars($student_email); ?> | <i class="fas fa-phone"></i> <?php echo htmlspecialchars($student_num); ?></p>
                </div>
            </div>
            <button class="refresh-btn" onclick="location.reload()"><i class="fas fa-sync-alt"></i> Refresh</button>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card present">
                <div class="stat-value"><?php echo $present_days; ?></div>
                <div class="stat-label">Present Days</div>
            </div>
            <div class="stat-card absent">
                <div class="stat-value"><?php echo $absent_days; ?></div>
                <div class="stat-label">Absent Days</div>
            </div>
            <div class="stat-card percentage">
                <div class="stat-value"><?php echo $attendance_percentage; ?>%</div>
                <div class="stat-label">Attendance Rate</div>
            </div>
        </div>

        <!-- Progress -->
        <div class="content-section">
            <h3 style="margin-bottom: 10px; color: #2c3e50;">Weekly Progress</h3>
            <div class="progress-container">
                <div class="progress-bar" style="width: <?php echo $attendance_percentage; ?>%"><?php echo $attendance_percentage; ?>% Complete</div>
            </div>
        </div>

        <!-- Table -->
        <div class="content-section" style="margin-top: 20px;">
            <div class="section-header">
                <h3 class="section-title">This Week Attendance</h3>
                <span class="month-badge"><?php echo date('d M', strtotime($week_start)) . ' - ' . date('d M Y', strtotime($week_end)); ?></span>
            </div>
            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Day</th>
                        <th>Status</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $i < 7; $i++) {
                        $check_date = date('Y-m-d', strtotime($week_start . " +$i days"));
                        $day_name = date('l', strtotime($check_date));
                        $formatted_date = date('d M Y', strtotime($check_date));
                        $today = date('Y-m-d');
                        $is_future = strtotime($check_date) > strtotime($today);
                        
                        echo "<tr>";
                        echo "<td class='date-cell'>" . $formatted_date . "</td>";
                        echo "<td>" . $day_name . "</td>";
                        
                        if ($is_future) {
                            echo "<td><span class='status-badge future'>Future</span></td><td>-</td><td>-</td>";
                        } else if (isset($attendance_data[$check_date])) {
                            echo "<td><span class='status-badge present'><i class='fas fa-check'></i> Present</span></td>";
                            echo "<td><span class='time-badge'><i class='fas fa-sign-in-alt'></i> " . date('h:i A', strtotime($attendance_data[$check_date]['in'])) . "</span></td>";
                            if ($attendance_data[$check_date]['out']) {
                                echo "<td><span class='time-badge out'><i class='fas fa-sign-out-alt'></i> " . date('h:i A', strtotime($attendance_data[$check_date]['out'])) . "</span></td>";
                            } else {
                                echo "<td><span style='color:#ccc; font-size:12px;'>- Pending -</span></td>";
                            }
                        } else {
                            echo "<td><span class='status-badge absent'><i class='fas fa-times'></i> Absent</span></td><td>-</td><td>-</td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
