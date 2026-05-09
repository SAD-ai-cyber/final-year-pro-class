<?php
require '../includes/config.php';
require '../includes/security.php';
require '../includes/notification_helper.php';

// Security/session bootstrap.
start_secure_session();
// Apply security headers for this request.
apply_security_headers();
// Enforce role-based access control.
require_role(['admin', 'teacher', 'parent', 'student']);
$csrf_token = generate_csrf_token();

$isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] == 'admin');

// 1. DELETE LOGIC
if (isset($_GET['delete_id']) && $isAdmin) {
    if (!verify_csrf_token($_GET['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }

    $d_id = (int)$_GET['delete_id'];
    $batch_name = '';
    $course_name = '';
    $batch_id = 0;

    $stmt = mysqli_prepare($con, "SELECT new_batch_id FROM batch_schedule WHERE schedule_id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $d_id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($res && ($row = mysqli_fetch_assoc($res))) {
            $batch_id = (int) ($row['new_batch_id'] ?? 0);
        }
        mysqli_stmt_close($stmt);
    }

    if ($batch_id > 0) {
        $stmt = mysqli_prepare($con, "SELECT batch_name, course_name FROM batches WHERE batch_id = ?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $batch_id);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);
            if ($res && ($row = mysqli_fetch_assoc($res))) {
                $batch_name = $row['batch_name'] ?? '';
                $course_name = $row['course_name'] ?? '';
            }
            mysqli_stmt_close($stmt);
        }
    }

    if ($batch_name !== '' && $course_name !== '') {
        $notif_title = 'Time Table Updated';
        $notif_message = "Batch: {$batch_name} | Course: {$course_name}";
        deleteNotificationsByContent($con, $notif_title, $notif_message, 'show-details/show-timetd.php');
        deleteQueuedEmailsByContent($con, $notif_title, $notif_message, 'show-details/show-timetd.php');
    }

    $stmt = mysqli_prepare($con, "DELETE FROM batch_schedule WHERE schedule_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $d_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: show-timetd.php");
}

// 2. UPDATE LOGIC
if (isset($_POST['update_period']) && $isAdmin ) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }

    $u_id = (int)$_POST['schedule_id'];
    $u_topic = $_POST['topic'];
    $u_instructor = $_POST['instructor'];

    $update_sql = "UPDATE batch_schedule SET 
                   topic_safe = ?, 
                   instructor_safe = ? 
                   WHERE schedule_id = ?";

    $stmt = mysqli_prepare($con, $update_sql);
    mysqli_stmt_bind_param($stmt, "ssi", $u_topic, $u_instructor, $u_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: show-timetd.php");
}

// 3. EDIT DATA FETCH
$edit_data = null;
// Handle GET query action.
if (isset($_GET['edit_id'])  && $isAdmin) {
    $e_id = (int)$_GET['edit_id'];
    $stmt = mysqli_prepare($con, "SELECT * FROM batch_schedule WHERE schedule_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $e_id);
    mysqli_stmt_execute($stmt);
    $e_result = mysqli_stmt_get_result($stmt);
    $edit_data = mysqli_fetch_assoc($e_result);
    mysqli_stmt_close($stmt);
}

// 4. DATA FETCH (SIMPLE)
$batch_query = "SELECT * FROM batches ORDER BY batch_id DESC LIMIT 1";
$batch_result = mysqli_query($con, $batch_query);
$batch_data = mysqli_fetch_assoc($batch_result);

$schedule_map = []; // Simple array to hold data
$batch_display = "No Batch Found";

if ($batch_data) {
    $current_batch_id = $batch_data['batch_id'];
    $batch_display = $batch_data['batch_name'] . " (" . $batch_data['course_name'] . ")";

    // Simple Select Query 
    $schedule_sql = "SELECT * FROM batch_schedule WHERE new_batch_id = ?";
    $stmt = mysqli_prepare($con, $schedule_sql);
    mysqli_stmt_bind_param($stmt, "i", $current_batch_id);
    mysqli_stmt_execute($stmt);
    $schedule_res = mysqli_stmt_get_result($stmt);

    // Data ko normal tareeke se array me daal rahe hain taaki table me sahi jagah dikhe
    while ($row = mysqli_fetch_assoc($schedule_res)) {
        $day = strtolower($row['day_safe']);
        $time = $row['time_safe'];

        $schedule_map[$day][$time] = [
            'id' => $row['schedule_id'],
            'topic' => $row['topic_safe'],
            'teacher' => $row['instructor_safe']
        ];
    }
    mysqli_stmt_close($stmt);
}

// Fixed Rows and Columns
$time_slots = [
    "09:00 - 11:00",
    "11:00 - 01:00",
    "01:00 - 03:00",
    "03:00 - 05:00",
    "05:00 - 07:00",
    "07:00 - 09:00"
];
$days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Weekly Time Table</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/details/parent.css?v=<?php echo time(); ?>">

    <style>
        .fixed-scroll-page {
            padding: 20px;
            box-sizing: border-box;
        }

        .card-subtitle {
            margin: 6px 0 0 0;
            font-size: 0.95rem;
            opacity: 0.9;
        }

        /*  EDIT FORM  */
        .edit-box {
            background: #fff8e1;
            border: 1px solid #ffe082;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .edit-box input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-update {
            background: #28a745;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-cancel {
            background: #dc3545;
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 4px;
        }

        /* TABLE STYLE  */
        .table-wrapper {
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #e0e0e0;
            border-top: none;
        }

        th {
            padding: 15px;
            color: #4361ee;
            /* Blue Text Header */
            font-weight: 600;
            border: 1px solid #e0e0e0;
            text-transform: capitalize;
            font-size: 14px;
            background-color: white;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        thead tr:first-child th {
            border-top: none;
        }

        td {
            border: 1px solid #e0e0e0;
            padding: 10px;
            text-align: center;
            vertical-align: middle;
            height: 80px;
            font-size: 13px;
            color: #555;
        }

        /* Time Column Styling */
        td:first-child {
            color: #4361ee;
            font-weight: 600;
            background-color: #fafafa;
        }

        .has-class {
            background-color: #e3f2fd;
            color: #333;
        }

        .topic-text {
            display: block;
            font-weight: bold;
            font-size: 14px;
            color: #000;
            margin-bottom: 5px;
        }

        .teacher-text {
            display: block;
            font-size: 12px;
            color: #666;
        }

        /* Icons */
        .action-icons {
            margin-top: 5px;
            opacity: 0.6;
        }

        .action-icons:hover {
            opacity: 1;
        }

        .action-icons a {
            margin: 0 5px;
            text-decoration: none;
            font-size: 12px;
        }

        .edit-icon {
            color: #f39c12;
        }

        .delete-icon {
            color: #e74c3c;
        }
    </style>
</head>

<body class="fixed-scroll-page">

    <?php if ($edit_data) { ?>
        <div class="edit-box">
            <strong>Edit Class:</strong>
            <form method="POST" style="display: flex; gap: 10px; align-items: center;">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                <input type="hidden" name="schedule_id" value="<?php echo $edit_data['schedule_id']; ?>">
                <input type="text"
                    value="<?php echo ucfirst($edit_data['day_safe']) . ' (' . $edit_data['time_safe'] . ')'; ?>" disabled
                    style="background: #cc2828ff; width: 220px;">

                <input type="text" name="topic" value="<?php echo $edit_data['topic_safe']; ?>" placeholder="Topic Name"
                    required>
                <input type="text" name="instructor" value="<?php echo $edit_data['instructor_safe']; ?>"
                    placeholder="Instructor Name" required>

                <button type="submit" name="update_period" class="btn-update">Update</button>
                <a href="show-timetd.php" class="btn-cancel">Cancel</a>
            </form>
        </div>
    <?php } ?>

    <div class="card fixed-scroll-card">
        <div class="card-header fixed-scroll-header">
            <h2 class="card-title">Weekly Class Time Table</h2>
            <p class="card-subtitle">Batch: <?php echo $batch_display; ?></p>
        </div>

        <div class="card-body">
            <div class="table-wrapper">
                <table class="details-table">
                <thead>
                    <tr>
                        <th style="width: 10%;">Time</th>
                        <th style="width: 15%;">Monday</th>
                        <th style="width: 15%;">Tuesday</th>
                        <th style="width: 15%;">Wednesday</th>
                        <th style="width: 15%;">Thursday</th>
                        <th style="width: 15%;">Friday</th>
                        <th style="width: 15%;">Saturday</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($time_slots as $slot) { ?>
                        <tr>
                            <td><?php echo $slot; ?></td>

                            <?php foreach ($days as $day) {
                                // Simple Check: Kya is time aur day pe data hai?
                                if (isset($schedule_map[$day][$slot])) {
                                    $info = $schedule_map[$day][$slot];

                                    // Data Show 
                                    echo "<td class='has-class'>
                                            <span class='topic-text'>" . $info['topic'] . "</span>
                                            <span class='teacher-text'>" . $info['teacher'] . "</span>";

                                    if ($isAdmin) {
                                        echo "<div class='action-icons'>
                                                <a href='show-timetd.php?edit_id=" . $info['id'] . "' class='edit-icon'><i class='fa-solid fa-pen'></i></a>
                                                <a href='show-timetd.php?delete_id=" . $info['id'] . "&csrf_token=" . urlencode($csrf_token) . "' class='delete-icon' onclick='return confirm(\"Remove this class?\")'><i class='fa-solid fa-trash'></i></a>
                                            </div>";
                                    }
                                    echo "</td>";
                                } else {
                                    // Empty Cell
                                    echo "<td></td>";
                                }
                            } ?>
                        </tr>
                    <?php } ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
