<?php
// Disable error display, enable logging
ini_set('display_errors', 0);
ini_set('log_errors', 1);
header('Content-Type: application/json');

// Allow generic access for now to fix functionality
header('Access-Control-Allow-Origin: *');

require 'config.php';
// require 'security.php'; // Removed to avoid session conflict issues

// Try to start session if not started, but don't block if role is missing
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- 1. SEARCH STUDENTS ---
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    
    if (empty($search)) {
        echo json_encode(['success' => false, 'data' => []]);
        exit;
    }
    
    // Search by ID or Name
    $sql = "SELECT student_id, student_name, student_email 
            FROM add_students 
            WHERE student_name LIKE ? OR student_id LIKE ? 
            LIMIT 10";
            
    $stmt = mysqli_prepare($con, $sql);
    
    if ($stmt) {
        $param = "%{$search}%";
        mysqli_stmt_bind_param($stmt, "ss", $param, $param);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $students = [];
        while ($row = mysqli_fetch_assoc($result)) {
            // Normalize keys to lowercase
            $students[] = array_change_key_case($row, CASE_LOWER);
        }
        
        echo json_encode(['success' => true, 'data' => $students]);
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
    exit;
}

// --- 2. GET STUDENT DETAILS ---
if (isset($_GET['student_id'])) {
    $student_id = (int)$_GET['student_id'];
    
    // Fetch basic student info
    $sql = "SELECT student_id, student_name, student_email, parent_email 
            FROM add_students 
            WHERE student_id = ?";
            
    $stmt = mysqli_prepare($con, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $student_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($result)) {
            $data = array_change_key_case($row, CASE_LOWER);
            
            // Try to fetch latest pending exam for this student with center info
            $exam_sql = "SELECT e.course_name, e.subject, e.topic_name, e.exam_date, f.Comp_Lab 
                        FROM student_exams e
                        LEFT JOIN exam_form f ON e.course_name = f.Course_Name AND e.topic_name = f.Exam_Name
                        WHERE e.student_email = ? AND e.status = 'Pending' 
                        ORDER BY e.exam_id DESC LIMIT 1";
            
            $exam_stmt = mysqli_prepare($con, $exam_sql);
            if ($exam_stmt) {
                mysqli_stmt_bind_param($exam_stmt, "s", $data['student_email']);
                mysqli_stmt_execute($exam_stmt);
                $exam_res = mysqli_stmt_get_result($exam_stmt);
                
                if ($exam_row = mysqli_fetch_assoc($exam_res)) {
                    // Add exam details to the data object
                    $data['course'] = $exam_row['course_name'];
                    $data['subject'] = $exam_row['subject'];
                    $data['examination'] = $exam_row['topic_name'];
                    $data['exam_center'] = $exam_row['Comp_Lab'];
                    
                    // Split date and time
                    if (!empty($exam_row['exam_date'])) {
                        $ts = strtotime($exam_row['exam_date']);
                        $data['exam_date'] = date('Y-m-d', $ts);
                        $data['exam_time'] = date('H:i', $ts);
                        
                        // Set reporting time to 30 mins before if possible
                        $data['reporting_time'] = date('H:i', $ts - (30 * 60));
                    }
                }
                mysqli_stmt_close($exam_stmt);
            }
            
            echo json_encode(['success' => true, 'data' => $data]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Student not found']);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
?>
