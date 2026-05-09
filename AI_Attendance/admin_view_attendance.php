<?php
ini_set('display_errors', 0);
error_reporting(0);
ob_start();
require_once "../includes/security.php";
require_once "../includes/config.php";

// Security/session bootstrap.
start_secure_session();
// Apply security headers for this request.
send_security_headers();
$csrf_token = csrf_token();

function json_response($payload)
{
    if (ob_get_length()) {
        ob_clean();
    }
    header('Content-Type: application/json');
    echo json_encode($payload);
    exit;
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['admin_id']) && !isset($_SESSION['teacher_id'])) {
        json_response(["status" => "error", "message" => "Unauthorized"]);
    }

    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input)) {
        $input = [];
    }

    if (!verify_csrf_token($input['csrf_token'] ?? '')) {
        json_response(["status" => "error", "message" => "Invalid request"]);
    }
    
    // Download all attendance as Excel
    if (isset($input['action']) && $input['action'] === 'download_all_excel') {
// Enforce active session for access.
        if (!isset($_SESSION['admin_id']) && !isset($_SESSION['teacher_id'])) {
            json_response(["status" => "error", "message" => "Unauthorized"]);
        }
        
        $sql = "SELECT a.id, a.student_id, s.student_name, a.check_in_time, a.check_out_time 
                FROM attendance_logs a 
                JOIN add_students s ON a.student_id = s.student_id 
                ORDER BY a.check_in_time DESC";
        $result = $con->query($sql);
        
        // Create CSV
        $csv = "ID,Student ID,Student Name,Date,Check-in Time,Check-out Time\n";
        while ($row = $result->fetch_assoc()) {
            $date = date('Y-m-d', strtotime($row['check_in_time']));
            $time_in = date('h:i A', strtotime($row['check_in_time']));
            $time_out = $row['check_out_time'] ? date('h:i A', strtotime($row['check_out_time'])) : '-';
            $csv .= $row['id'] . "," . $row['student_id'] . ",\"" . addslashes($row['student_name']) . "\"," . $date . "," . $time_in . "," . $time_out . "\n";
        }
        
        if (ob_get_length()) {
            ob_clean();
        }
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="all_attendance_' . date('Y-m-d_His') . '.csv"');
        echo $csv;
        exit;
    }
    
    // Delete attendance record (admin only)
    if (isset($input['action']) && $input['action'] === 'delete') {
// Enforce active session for access.
        if (!isset($_SESSION['admin_id']) && !isset($_SESSION['teacher_id'])) {
            json_response(["status" => "error", "message" => "Unauthorized"]);
        }
        
        $record_id = intval($input['record_id']);
        $sql = "DELETE FROM attendance_logs WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $record_id);
        
        if ($stmt->execute()) {
            json_response(["status" => "success", "message" => "Record deleted"]);
        } else {
            json_response(["status" => "error", "message" => "Failed to delete"]);
        }
    }
    
    // Get graph data for date range (all students)
    if (isset($input['action']) && $input['action'] === 'get_graph_data') {
        $start_date = isset($input['start_date']) ? $input['start_date'] : date('Y-m-d', strtotime('-30 days'));
        $end_date = isset($input['end_date']) ? $input['end_date'] : date('Y-m-d');
        
        // Get total number of students
        $total_sql = "SELECT COUNT(*) as total FROM add_students";
        $total_result = $con->query($total_sql);
        $total_row = $total_result->fetch_assoc();
        $total_students = $total_row['total'] > 0 ? $total_row['total'] : 1;
        
        $sql = "SELECT DATE(check_in_time) as date, COUNT(*) as count FROM attendance_logs 
                WHERE DATE(check_in_time) BETWEEN ? AND ? 
                GROUP BY DATE(check_in_time) 
                ORDER BY DATE(check_in_time) ASC";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $start_date, $end_date);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $dates = [];
        $counts = [];
        
        // Fill all dates in range
        $current = new DateTime($start_date);
        $end = new DateTime($end_date);
        $data_map = [];
        
        while ($row = $result->fetch_assoc()) {
            $data_map[$row['date']] = $row['count'];
        }
        
        while ($current <= $end) {
            $date_str = $current->format('Y-m-d');
            $dates[] = $date_str;
            $count = isset($data_map[$date_str]) ? $data_map[$date_str] : 0;
            // Calculate percentage
            $percentage = ($count / $total_students) * 100;
            $counts[] = round($percentage, 2);
            $current->modify('+1 day');
        }
        
        json_response(["status" => "success", "dates" => $dates, "counts" => $counts]);
    }
    
    // Get graph data for individual student
    if (isset($input['action']) && $input['action'] === 'get_student_graph_data') {
        $student_id = intval($input['student_id']);
        $start_date = isset($input['start_date']) ? $input['start_date'] : date('Y-m-d', strtotime('-30 days'));
        $end_date = isset($input['end_date']) ? $input['end_date'] : date('Y-m-d');
        
        $sql = "SELECT DATE(check_in_time) as date, TIME(check_in_time) as time FROM attendance_logs 
                WHERE student_id = ? AND DATE(check_in_time) BETWEEN ? AND ? 
                ORDER BY DATE(check_in_time) ASC";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("iss", $student_id, $start_date, $end_date);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $dates = [];
        $status = [];
        
        // Fill all dates in range
        $current = new DateTime($start_date);
        $end = new DateTime($end_date);
        $data_map = [];
        
        while ($row = $result->fetch_assoc()) {
            $data_map[$row['date']] = $row['time'];
        }
        
        while ($current <= $end) {
            $date_str = $current->format('Y-m-d');
            $dates[] = $date_str;
            $status[] = isset($data_map[$date_str]) ? 1 : 0;
            $current->modify('+1 day');
        }
        
        json_response(["status" => "success", "dates" => $dates, "attendance" => $status]);
    }
    
    // Get student attendance records
    if (isset($input['action']) && $input['action'] === 'get_records') {
        $student_id = intval($input['student_id']);
        $sql = "SELECT id, check_in_time, check_out_time FROM attendance_logs WHERE student_id = ? ORDER BY check_in_time DESC LIMIT 30";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $records = [];
        while ($row = $result->fetch_assoc()) {
            $records[] = $row;
        }
        json_response(["records" => $records]);
    }

    json_response(["status" => "error", "message" => "Invalid action"]);
}

// Check if user is admin or teacher
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['teacher_id'])) {
    header('Location: ../admin_login.php');
    exit;
}

$is_admin = isset($_SESSION['admin_id']);
$is_teacher = isset($_SESSION['teacher_id']);

// Get all students with their attendance counts
$students_sql = "
    SELECT 
        s.student_id,
        s.student_name,
        s.student_email,
        s.student_num,
        COUNT(DISTINCT CASE WHEN DATE(a.check_in_time) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) THEN DATE(a.check_in_time) END) as present_days,
        30 as total_days,
        MAX(CASE WHEN DATE(a.check_in_time) = CURDATE() THEN TIME(a.check_in_time) END) as today_in,
        MAX(CASE WHEN DATE(a.check_in_time) = CURDATE() THEN TIME(a.check_out_time) END) as today_out
    FROM add_students s
    LEFT JOIN attendance_logs a ON s.student_id = a.student_id
    GROUP BY s.student_id, s.student_name, s.student_email, s.student_num
    ORDER BY s.student_name ASC
";

$result = $con->query($students_sql);
$students = [];
while ($row = $result->fetch_assoc()) {
    $students[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
    <title><?php echo $is_admin ? 'Admin' : 'Teacher'; ?> - Attendance Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/responsive-core.css?v=<?php echo time(); ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .header h2 {
            margin: 0 0 15px 0;
            color: #333;
        }
        
        .filter-section {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 15px;
        }
        
        .filter-section input,
        .filter-section select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .graph-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: none;
        }
        
        .graph-section.active {
            display: block;
        }
        
        .graph-controls {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
            align-items: center;
        }
        
        .graph-controls input[type="date"] {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .graph-controls button {
            padding: 8px 16px;
            background: #4e73df;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
        }
        
        .graph-controls button:hover {
            background: #2e59d9;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 20px;
        }
        
        .filter-section button {
            padding: 8px 16px;
            background: #4e73df;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
        }
        
        .filter-section button:hover {
            background: #2e59d9;
        }
        
        .table-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
        }
        
        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }
        
        td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
            font-size: 14px;
        }
        
        tbody tr:hover {
            background: #f8f9fa;
        }
        
        .student-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .student-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #4e73df;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 12px;
        }
        
        .progress-bar {
            width: 100%;
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            margin: 5px 0;
        }
        
        .progress-fill {
            height: 100%;
            background: #28a745;
            border-radius: 4px;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 12px;
        }
        
        .badge-success {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }
        
        .action-btns {
            display: flex;
            gap: 8px;
        }
        
        .btn-icon {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        
        .btn-view {
            background: #4e73df;
            color: white;
        }
        
        .btn-view:hover {
            background: #2e59d9;
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
        }
        
        .btn-delete:hover {
            background: #c82333;
        }
        
        .no-records {
            padding: 40px;
            text-align: center;
            color: #999;
        }
        
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .filter-section {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }
            .filter-section input, .filter-section select, .filter-section button {
                width: 100% !important;
                min-width: unset !important;
                margin: 5px 0;
            }
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
        
        /* Graph Section */
        .graph-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: none;
        }
        
        .graph-section.active {
            display: block;
        }
        
        .graph-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #007bff;
        }
        
        .graph-header h3 {
            margin: 0;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .graph-controls {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 6px;
        }
        
        .date-input-group {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        
        .date-input-group label {
            font-weight: 600;
            color: #555;
            font-size: 13px;
        }
        
        .date-input-group input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 13px;
        }
        
        .btn-generate-graph {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: background 0.3s;
        }
        
        .btn-generate-graph:hover {
            background: #0056b3;
        }
        
        .chart-container {
            position: relative;
            height: 350px;
            margin-bottom: 30px;
            background: white;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }
        
        .chart-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            font-size: 14px;
        }
        
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        
        .modal-content {
            background-color: white;
            margin: 5% auto;
            padding: 0;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        
        .modal-header {
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-header h3 {
            margin: 0;
            color: #333;
        }
        
        .close-btn {
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
            color: #999;
        }
        
        .modal-body {
            padding: 20px;
            max-height: 600px;
            overflow-y: auto;
        }
        
        .attendance-record {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 10px;
        }
        
        .attendance-record:last-child {
            border-bottom: none;
        }
        
        .record-info {
            flex: 1;
        }
        
        .record-date {
            font-weight: 600;
            color: #333;
        }
        
        .record-time {
            font-size: 12px;
            color: #999;
            margin-top: 3px;
        }
        
        .record-actions {
            display: flex;
            gap: 8px;
        }
        
        /* Modal Tabs */
        .modal-tabs {
            display: flex;
            gap: 0;
            border-bottom: 2px solid #e9ecef;
            margin-bottom: 20px;
        }
        
        .modal-tab {
            flex: 1;
            padding: 12px;
            background: #f8f9fa;
            border: none;
            cursor: pointer;
            font-weight: 600;
            color: #555;
            transition: all 0.3s;
        }
        
        .modal-tab.active {
            background: #007bff;
            color: white;
            border-bottom: 2px solid #007bff;
        }
        
        .modal-tab-content {
            display: none;
        }
        
        .modal-tab-content.active {
            display: block;
        }
        
        .modal-graph-container {
            position: relative;
            height: 300px;
            margin-bottom: 20px;
            background: white;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }
        
        .modal-graph-controls {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }
        
        .modal-graph-controls label {
            font-weight: 600;
            font-size: 12px;
            color: #555;
        }
        
        .modal-graph-controls input {
            padding: 6px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 12px;
        }
        
        .btn-generate-student-graph {
            background: #007bff;
            color: white;
            border: none;
            padding: 6px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
        }
        
        .btn-generate-student-graph:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2><i class="fas fa-list"></i> Attendance Management</h2>
            <p style="color: #666; margin: 0; font-size: 14px;"><?php echo $is_admin ? 'View and manage all students\' attendance records' : 'View attendance records for your class'; ?></p>
            <?php if ($is_teacher): ?>
            <div style="background: #e7f1ff; border-left: 4px solid #4e73df; padding: 12px; border-radius: 5px; margin-top: 15px; font-size: 13px;">
                <i class="fas fa-info-circle" style="color: #4e73df; margin-right: 8px;"></i>
                <strong>Teacher View:</strong> You can view and manage attendance records.
            </div>
            <?php endif; ?>
            
            <div class="filter-section">
                <input type="text" id="searchInput" placeholder="Search by name or email">
                <select id="filterStatus">
                    <option value="">All Status</option>
                    <option value="good">Good (>75%)</option>
                    <option value="warning">Warning (50-75%)</option>
                    <option value="poor">Poor (<50%)</option>
                </select>
                <button onclick="applyFilters()">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <button onclick="downloadAllExcel()" style="background: #6f42c1;">
                    <i class="fas fa-download"></i> Download All
                </button>
                <button onclick="exportData()" style="background: #28a745;">
                    <i class="fas fa-download"></i> Export
                </button>
            </div>
        </div>
        
        <div class="table-container table-responsive">
            <table>
                <thead>
                    <tr>
                        <?php if ($is_admin): ?><th>ID</th><?php endif; ?>
                        <th>Student</th>
                        <th>Email</th>
                        <th>Today's Status</th>
                        <th>Last 30 Days</th>
                        <th>Attendance %</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Populated by JavaScript -->
                </tbody>
            </table>
        </div>
        
        <!-- Graph Section -->
        <div class="graph-section active" id="graphSection">
            <div class="graph-header">
                <h3><i class="fas fa-chart-line"></i> Attendance Analytics</h3>
            </div>
            
            <div class="graph-controls">
                <div class="date-input-group">
                    <label>From Date:</label>
                    <input type="date" id="startDate" placeholder="Start date">
                </div>
                <div class="date-input-group">
                    <label>To Date:</label>
                    <input type="date" id="endDate" placeholder="End date">
                </div>
                <button class="btn-generate-graph" onclick="generateGraphAllStudents()">
                    <i class="fas fa-sync-alt"></i> Generate Graph
                </button>
            </div>
            
            <div class="chart-container">
                <div class="chart-title">Overall Attendance Trend (Line)</div>
                <canvas id="allStudentsChart"></canvas>
            </div>
            <div class="chart-container">
                <div class="chart-title">Overall Attendance Trend (Bar)</div>
                <canvas id="allStudentsBarChart"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Student Details Modal -->
    <div id="detailsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="studentName"></h3>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="modal-tabs">
                    <button class="modal-tab active" onclick="switchTab('records', event)">
                        <i class="fas fa-list"></i> Attendance Records
                    </button>
                    <button class="modal-tab" onclick="switchTab('graph', event)">
                        <i class="fas fa-chart-bar"></i> Attendance Graph
                    </button>
                </div>
                
                <div id="recordsTab" class="modal-tab-content active">
                    <div id="attendanceDetails"></div>
                </div>
                
                <div id="graphTab" class="modal-tab-content">
                    <div class="modal-graph-controls">
                        <label>From:</label>
                        <input type="date" id="studentGraphStartDate" placeholder="Start date">
                        <label>To:</label>
                        <input type="date" id="studentGraphEndDate" placeholder="End date">
                        <button class="btn-generate-student-graph" onclick="generateStudentGraph()">
                            <i class="fas fa-sync-alt"></i> Generate
                        </button>
                    </div>
                    <div class="modal-graph-container">
                        <canvas id="studentChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        const students = <?php echo json_encode($students); ?>;
        const isAdmin = <?php echo json_encode($is_admin); ?>;
        const isTeacher = <?php echo json_encode($is_teacher); ?>;
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        
        function getStatusBadge(percentage) {
            if (percentage >= 75) {
                return '<span class="badge badge-success">Good</span>';
            } else if (percentage >= 50) {
                return '<span class="badge badge-warning">Warning</span>';
            } else {
                return '<span class="badge badge-danger">Poor</span>';
            }
        }
        
        function getInitials(name) {
            return name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
        }
        
        function displayTable(data) {
            const tbody = document.getElementById('tableBody');
            const colSpan = isAdmin ? 8 : 7;
            
            if (data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="${colSpan}" class="no-records">No students found</td></tr>`;
                return;
            }
            
            tbody.innerHTML = data.map(student => {
                const attendance_percentage = student.total_days > 0 
                    ? Math.round((student.present_days / student.total_days) * 100) 
                    : 0;
                
                const idColumn = isAdmin ? `<td>${student.student_id}</td>` : '';
                
                const todayIn = student.today_in ? student.today_in : null;
                const todayOut = student.today_out ? student.today_out : null;
                
                let todayStatusHtml = '<span style="color: #999; font-size: 12px;">No records today</span>';
                if (todayIn) {
                    const formatT = (t) => {
                        const [h, m] = t.split(':');
                        const hh = parseInt(h);
                        return (hh % 12 || 12) + ':' + m + (hh >= 12 ? ' PM' : ' AM');
                    };
                    
                    todayStatusHtml = `
                        <div style="font-size: 11px; line-height: 1.4;">
                            <span style="color: #28a745;"><i class="fas fa-sign-in-alt"></i> In: ${formatT(todayIn)}</span><br>
                            ${todayOut ? `<span style="color: #dc3545;"><i class="fas fa-sign-out-alt"></i> Out: ${formatT(todayOut)}</span>` : '<span style="color: #f6c23e;"><i class="fas fa-clock"></i> Still In</span>'}
                        </div>
                    `;
                } else {
                    todayStatusHtml = '<span class="badge" style="background: #eaecf4; color: #858796; font-size: 10px;">Not Arrived</span>';
                }

                return `
                    <tr>
                        ${idColumn}
                        <td>
                            <div class="student-info">
                                <div class="student-avatar">${getInitials(student.student_name)}</div>
                                <div>${student.student_name}</div>
                            </div>
                        </td>
                        <td>${student.student_email}</td>
                        <td>${todayStatusHtml}</td>
                        <td>
                            <strong>${student.present_days}</strong>/${student.total_days} days
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: ${attendance_percentage}%"></div>
                            </div>
                        </td>
                        <td>${attendance_percentage}%</td>
                        <td>${getStatusBadge(attendance_percentage)}</td>
                        <td>
                            <div class="action-btns">
                                <button class="btn-icon btn-view" onclick="viewDetails(${student.student_id}, '${student.student_name}')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }
        
        function applyFilters() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('filterStatus').value;
            
            let filtered = students.filter(student => {
                const matchesSearch = student.student_name.toLowerCase().includes(searchTerm) || 
                                    student.student_email.toLowerCase().includes(searchTerm);
                
                let matchesStatus = true;
                if (statusFilter) {
                    const percentage = student.total_days > 0 
                        ? Math.round((student.present_days / student.total_days) * 100) 
                        : 0;
                    
                    if (statusFilter === 'good') matchesStatus = percentage >= 75;
                    if (statusFilter === 'warning') matchesStatus = percentage >= 50 && percentage < 75;
                    if (statusFilter === 'poor') matchesStatus = percentage < 50;
                }
                
                return matchesSearch && matchesStatus;
            });
            
            displayTable(filtered);
        }
        
        function viewDetails(studentId, studentName) {
            document.getElementById('studentName').textContent = studentName;
            
            // Store student ID for graph generation
            currentStudentIdForGraph = studentId;
            
            // Set default dates for graph
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const todayStr = `${year}-${month}-${day}`;
            
            const thirtyDaysAgo = new Date(now.getTime() - (30 * 24 * 60 * 60 * 1000));
            const y2 = thirtyDaysAgo.getFullYear();
            const m2 = String(thirtyDaysAgo.getMonth() + 1).padStart(2, '0');
            const d2 = String(thirtyDaysAgo.getDate()).padStart(2, '0');
            const thirtyDaysAgoStr = `${y2}-${m2}-${d2}`;

            document.getElementById('studentGraphEndDate').value = todayStr;
            document.getElementById('studentGraphStartDate').value = thirtyDaysAgoStr;
            
            // Fetch attendance records
            fetch('admin_view_attendance.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'get_records', student_id: studentId, csrf_token: csrfToken })
            })
                .then(r => r.json())
                .then(data => {
                    let html = '<h4 style="margin-top: 0;">Last 30 Days Attendance</h4>';
                    
                    if (data.records && data.records.length > 0) {
                        html += data.records.map(record => {
                            const dateIn = new Date(record.check_in_time);
                            const formatted_date = dateIn.toLocaleDateString('en-US', { 
                                weekday: 'short', 
                                year: 'numeric', 
                                month: 'short', 
                                day: 'numeric' 
                            });
                            const time_in = dateIn.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
                            
                            let time_out_html = '<span style="color: #999;">- No Check-Out -</span>';
                            if (record.check_out_time) {
                                const time_out = new Date(record.check_out_time).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
                                time_out_html = `<span style="color: #dc3545;"><i class="fas fa-sign-out-alt"></i> Out: ${time_out}</span>`;
                            }
                            
                            const deleteBtn = (isAdmin || isTeacher) ? `
                                <button class="btn-icon btn-delete" onclick="deleteRecord(${record.id}, ${studentId}, '${studentName}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            ` : '';
                            
                            return `
                                <div class="attendance-record">
                                    <div class="record-info">
                                        <div class="record-date"><i class="fas fa-calendar-day" style="color: #4e73df;"></i> ${formatted_date}</div>
                                        <div class="record-time">
                                            <span style="color: #28a745;"><i class="fas fa-sign-in-alt"></i> In: ${time_in}</span>
                                            <span style="margin-left: 10px;">${time_out_html}</span>
                                        </div>
                                    </div>
                                    <div class="record-actions">
                                        ${deleteBtn}
                                    </div>
                                </div>
                            `;
                        }).join('');
                    } else {
                        html += '<p style="color: #999; text-align: center; padding: 20px;">No attendance records found</p>';
                    }
                    
                    document.getElementById('attendanceDetails').innerHTML = html;
                    document.getElementById('detailsModal').style.display = 'block';
                });
        }
        
        function deleteRecord(recordId, studentId, studentName) {
            if (confirm('Are you sure you want to delete this attendance record?')) {
                fetch('admin_view_attendance.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ action: 'delete', record_id: recordId, csrf_token: csrfToken })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Record deleted successfully');
                        viewDetails(studentId, studentName);
                    } else {
                        alert('Error: ' + data.message);
                    }
                });
            }
        }
        
        function closeModal() {
            document.getElementById('detailsModal').style.display = 'none';
        }
        
        function downloadAllExcel() {
            if (confirm('Download all attendance records as Excel?')) {
                fetch('admin_view_attendance.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ action: 'download_all_excel', csrf_token: csrfToken })
                })
                .then(response => {
                    if (!response.ok) throw new Error('Download failed');
                    return response.blob();
                })
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'all_attendance_' + new Date().toISOString().split('T')[0] + '.csv';
                    a.click();
                    window.URL.revokeObjectURL(url);
                })
                .catch(error => alert('Error: ' + error.message));
            }
        }
        
        function exportData() {
            // Simple CSV export
            let csv = 'Student Name,Email,Phone,Present Days,Total Days,Attendance %\n';
            students.forEach(s => {
                const percentage = s.total_days > 0 
                    ? Math.round((s.present_days / s.total_days) * 100) 
                    : 0;
                csv += `"${s.student_name}","${s.student_email}","${s.student_num}",${s.present_days},${s.total_days},${percentage}\n`;
            });
            
            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'attendance_' + new Date().toISOString().split('T')[0] + '.csv';
            a.click();
        }
        
        // Graph functionality
        let allStudentsChartInstance = null;
        let allStudentsBarChartInstance = null;
        
        function setDefaultDates() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const todayStr = `${year}-${month}-${day}`;
            
            const thirtyDaysAgo = new Date(now.getTime() - (30 * 24 * 60 * 60 * 1000));
            const y2 = thirtyDaysAgo.getFullYear();
            const m2 = String(thirtyDaysAgo.getMonth() + 1).padStart(2, '0');
            const d2 = String(thirtyDaysAgo.getDate()).padStart(2, '0');
            const thirtyDaysAgoStr = `${y2}-${m2}-${d2}`;
            
            document.getElementById('endDate').value = todayStr;
            document.getElementById('startDate').value = thirtyDaysAgoStr;
        }
        
        function generateGraphAllStudents() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            
            if (!startDate || !endDate) {
                alert('Please select both start and end dates');
                return;
            }
            
            if (new Date(startDate) > new Date(endDate)) {
                alert('Start date must be before end date');
                return;
            }
            
            fetch('admin_view_attendance.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'get_graph_data',
                    start_date: startDate,
                    end_date: endDate,
                    csrf_token: csrfToken
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    renderGraphAllStudents(data.dates, data.counts);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => alert('Error fetching data: ' + error.message));
        }
        
        function renderGraphAllStudents(dates, counts) {
            const ctx = document.getElementById('allStudentsChart').getContext('2d');
            
            // Destroy existing chart if it exists
            if (allStudentsChartInstance) {
                allStudentsChartInstance.destroy();
            }
            
            // Format dates for display
            const formattedDates = dates.map(date => {
                const d = new Date(date);
                return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            });
            
            allStudentsChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: formattedDates,
                    datasets: [{
                        label: 'Attendance Percentage (%)',
                        data: counts,
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: '#28a745',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                font: { size: 12 },
                                padding: 15
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y.toFixed(2) + '%';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            title: {
                                display: true,
                                text: 'Attendance Percentage (%)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return value.toFixed(0) + '%';
                                }
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        }
                    }
                }
            });

            renderGraphAllStudentsBar(formattedDates, counts);
        }

        function renderGraphAllStudentsBar(labels, counts) {
            const ctx = document.getElementById('allStudentsBarChart').getContext('2d');

            if (allStudentsBarChartInstance) {
                allStudentsBarChartInstance.destroy();
            }

            allStudentsBarChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Attendance Percentage (%)',
                        data: counts,
                        backgroundColor: 'rgba(40, 167, 69, 0.6)',
                        borderColor: '#28a745',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Attendance: ' + context.parsed.y.toFixed(2) + '%';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            title: {
                                display: true,
                                text: 'Attendance Percentage (%)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return value.toFixed(0) + '%';
                                }
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        }
                    }
                }
            });
        }
        
        // Tab switching for modal
        function switchTab(tabName, evt) {
            // Hide all tabs
            document.querySelectorAll('.modal-tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.modal-tab').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected tab
            document.getElementById(tabName + 'Tab').classList.add('active');
            if (evt && evt.target) {
                evt.target.classList.add('active');
            }
            
            // If graph tab is opened, generate the graph
            if (tabName === 'graph') {
                const startDate = document.getElementById('studentGraphStartDate').value;
                if (startDate) {
                    generateStudentGraph();
                }
            }
        }
        
        // Store current student ID for graph generation
        let currentStudentIdForGraph = null;
        
        // Generate student individual graph
        function generateStudentGraph() {
            if (!currentStudentIdForGraph) {
                alert('Student ID not found');
                return;
            }
            
            const startDate = document.getElementById('studentGraphStartDate').value;
            const endDate = document.getElementById('studentGraphEndDate').value;
            
            if (!startDate || !endDate) {
                alert('Please select both start and end dates');
                return;
            }
            
            if (new Date(startDate) > new Date(endDate)) {
                alert('Start date must be before end date');
                return;
            }
            
            fetch('admin_view_attendance.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'get_student_graph_data',
                    student_id: currentStudentIdForGraph,
                    start_date: startDate,
                    end_date: endDate,
                    csrf_token: csrfToken
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    renderStudentAttendanceGraph(data.dates, data.attendance);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => alert('Error fetching data: ' + error.message));
        }
        
        let studentChartInstance = null;
        
        function renderStudentAttendanceGraph(dates, attendance) {
            const ctx = document.getElementById('studentChart').getContext('2d');
            
            // Destroy existing chart
            if (studentChartInstance) {
                studentChartInstance.destroy();
            }
            
            // Format dates
            const formattedDates = dates.map(date => {
                const d = new Date(date);
                return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            });
            
            // Separate data for present and absent
            const presentData = attendance.map(val => val === 1 ? 1 : null);
            const absentData = attendance.map(val => val === 0 ? 1 : null);
            
            // Create bar chart with two datasets
            studentChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: formattedDates,
                    datasets: [
                        {
                            label: 'Present',
                            data: presentData,
                            backgroundColor: '#28a745',
                            borderColor: '#28a745',
                            borderWidth: 1
                        },
                        {
                            label: 'Absent',
                            data: absentData,
                            backgroundColor: '#dc3545',
                            borderColor: '#dc3545',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 1,
                            ticks: {
                                stepSize: 1,
                                callback: function(value) {
                                    return value === 1 ? 'Yes' : '';
                                }
                            },
                            title: {
                                display: true,
                                text: 'Attendance Status'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        }
                    }
                }
            });
        }
        
        // Initial display
        displayTable(students);
        setDefaultDates();
        generateGraphAllStudents();
        
        // Add event listeners for real-time search and filter
        document.getElementById('searchInput').addEventListener('input', applyFilters);
        document.getElementById('filterStatus').addEventListener('change', applyFilters);

        // Auto-generate graph on date change
        document.getElementById('startDate').addEventListener('change', generateGraphAllStudents);
        document.getElementById('endDate').addEventListener('change', generateGraphAllStudents);

        // Auto-generate student graph on date change when modal is open and graph tab active
        document.getElementById('studentGraphStartDate').addEventListener('change', () => {
            if (currentStudentIdForGraph && document.getElementById('graphTab').classList.contains('active')) {
                generateStudentGraph();
            }
        });
        document.getElementById('studentGraphEndDate').addEventListener('change', () => {
            if (currentStudentIdForGraph && document.getElementById('graphTab').classList.contains('active')) {
                generateStudentGraph();
            }
        });
    </script>
</body>
</html>
