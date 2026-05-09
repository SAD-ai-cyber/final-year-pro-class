<?php
// Disable error display for clean JSON output
ini_set('display_errors', 0);
ini_set('log_errors', 1);
header('Content-Type: application/json');

require 'config.php';

// Check if query is provided
if (isset($_GET['query'])) {
    $search = trim($_GET['query']);
    
    if (empty($search)) {
        echo json_encode(['success' => false, 'students' => []]);
        exit;
    }
    
    // Search by ID or Name from add_students table
    // Using LIKE for partial matching
    $sql = "SELECT student_id, student_name, student_email 
            FROM add_students 
            WHERE student_name LIKE ? OR CAST(student_id AS CHAR) LIKE ? 
            ORDER BY student_name ASC 
            LIMIT 10";
            
    $stmt = mysqli_prepare($con, $sql);
    
    if ($stmt) {
        $param = "%{$search}%";
        mysqli_stmt_bind_param($stmt, "ss", $param, $param);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $students = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $students[] = [
                'student_id' => $row['student_id'],
                'student_name' => $row['student_name'],
                'student_email' => $row['student_email']
            ];
        }
        
        echo json_encode(['success' => true, 'students' => $students]);
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Query parameter missing']);
?>
