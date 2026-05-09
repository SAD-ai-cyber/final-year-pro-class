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

// Check karein user Admin hai ya nahi
$isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] == 'admin');

// 1. DELETE LOGIC (Sirf Admin)
if (isset($_GET['delete_id']) && $isAdmin) {
    if (!verify_csrf_token($_GET['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }

    $id = (int)$_GET['delete_id'];
    $meeting_title = '';
    $meeting_date = '';
    $meeting_time = '';
    $meeting_mode = '';

    $stmt = mysqli_prepare($con, "SELECT Meeting_title, meeting_date, meeting_time, meeting_mode FROM meeting_form WHERE meeting_id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($res && ($row = mysqli_fetch_assoc($res))) {
            $meeting_title = $row['Meeting_title'] ?? '';
            $meeting_date = $row['meeting_date'] ?? '';
            $meeting_time = $row['meeting_time'] ?? '';
            $meeting_mode = $row['meeting_mode'] ?? '';
        }
        mysqli_stmt_close($stmt);
    }

    if ($meeting_title !== '' && $meeting_date !== '' && $meeting_time !== '' && $meeting_mode !== '') {
        $notif_title = 'Parent Meeting Scheduled';
        $notif_message = "Meeting: {$meeting_title} | {$meeting_date} {$meeting_time} ({$meeting_mode})";
        deleteNotificationsByContent($con, $notif_title, $notif_message, 'show-details/show-meets.php');
        deleteQueuedEmailsByContent($con, $notif_title, $notif_message, 'show-details/show-meets.php');
    }

    $stmt = mysqli_prepare($con, "DELETE FROM meeting_form WHERE meeting_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: show-meets.php");
}


// 2. UPDATE LOGIC (Sirf Admin)
if (isset($_POST['save_btn']) && $isAdmin) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }

    $id = (int)$_POST['id'];
    $m_title = $_POST['mtitle'];
    $m_date = $_POST['mdate'];
    $m_time = $_POST['mtime'];
    $m_mode = $_POST['mode'];
    $m_link = $_POST['mlink'];
    
    $update_query = "UPDATE meeting_form SET 
                     Meeting_title=?, 
                     meeting_date=?, 
                     meeting_time=?, 
                     meeting_mode=?, 
                     meeting_link=? 
                     WHERE meeting_id=?";

    $stmt = mysqli_prepare($con, $update_query);
    mysqli_stmt_bind_param($stmt, "sssssi", $m_title, $m_date, $m_time, $m_mode, $m_link, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: show-meets.php");
}

// 3. FETCH DATA LOGIC 


if ($isAdmin) {
    // Admin: Sab kuch dikhega (Old + New)
    $query = "SELECT * FROM meeting_form";
} else {
    // Parent/Student: Sirf Upcoming (Old meetings HIDE ho jayengi)
    $query = "SELECT * FROM meeting_form WHERE meeting_date >= CURDATE() ORDER BY meeting_date ASC";
}

$data = mysqli_query($con, $query);
$total = mysqli_num_rows($data);
?>


<html>

<head>
    <title>Manage Meetings</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!--  php echo time();  har second URL ko badal deta hai-->
     <link rel="stylesheet" href="../css/details/meeting.css?v=<?php echo time(); ?>">
</head>

<body class="fixed-scroll-page">
    <div class="card fixed-scroll-card">
        <div class="card-header fixed-scroll-header">
            <h2 class="card-title">Manage Meetings</h2>
        </div>

        <form action="" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">

            <div class="card-body">
                <table class="details-table">
                    <thead>
                        <tr>
                            <th>Meeting ID</th>
                            <th>Meeting Title</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Mode</th>
                            <th>Link</th>
                            <th>Upload Date</th>
                            
                            <?php if($isAdmin) { ?>
                                <th>Actions</th>
                            <?php } ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if ($total > 0) {
                            // yaha pe ek ek row loop me jayega
                            while ($result = mysqli_fetch_assoc($data)) {

                                // EDIT MODE (Sirf Admin ke liye)
                                // check hoga ki row edit mode me hai ya nahi
                                if (isset($_GET['edit_id']) && $_GET['edit_id'] == $result['meeting_id'] && $isAdmin) {

                                    echo "<tr>
                                        <td>
                                            " . $result['meeting_id'] . "
                                            <input type='hidden' name='id' value='" . $result['meeting_id'] . "'>
                                        </td>
                                        <td><input type='text' name='mtitle' value='" . $result['Meeting_title'] . "'></td>
                                        <td><input type='date' name='mdate' value='" . $result['meeting_date'] . "'></td>
                                        <td><input type='time' name='mtime' value='" . $result['meeting_time'] . "'></td>
                                        <td><input type='text' name='mode' value='" . $result['meeting_mode'] . "'></td>
                                        <td><input type='url' name='mlink' value='" . $result['meeting_link'] . "'></td>
                                        <td>" . $result['upload_date'] . "</td>
                                        
                                        <td class='action-buttons'>
                                            <button type='submit' name='save_btn' title='Save Changes'>
                                                <i class='fa-solid fa-check'></i>
                                            </button>
                                            
                                            <a href='show-meets.php' title='Cancel' class='btn-cancel'>
                                                <i class='fa-solid fa-xmark'></i>
                                            </a>
                                        </td>
                                    </tr>";

                                } else {

                                    
                                    // Agar Mode 'Offline' hai to Link mat dikhao, bas '-' dikhao
                                    $display_link = '-'; 
                                    
                                    // Check  Agar 'Offline' nahi hai, tabhi link banega
                                    if (strcasecmp($result['meeting_mode'], 'Offline') !== 0) {
                                        $display_link = "<a href='" . $result['meeting_link'] . "' target='_blank'>Join Link</a>";
                                    }
                                   


                                    // VIEW MODE
                                    echo "<tr>
                                        <td>" . $result['meeting_id'] . "</td>
                                        <td>" . $result['Meeting_title'] . "</td>
                                        
                                        <td style='color: #2c3e50; font-weight:bold;'>" . $result['meeting_date'] . "</td>
                                        
                                        <td>" . $result['meeting_time'] . "</td>
                                        <td>" . $result['meeting_mode'] . "</td>
                                        
                                        <td>" . $display_link . "</td>
                                        
                                        <td>" . $result['upload_date'] . "</td>";
                                        
                                        // Edit/Delete Buttons: Sirf Admin ko dikhenge
                                        if($isAdmin) {
                                            echo "<td class='action-buttons'>
                                                <a href='show-meets.php?edit_id=" . $result['meeting_id'] . "' class='btn-edit' title='Edit'>
                                                    <i class='fa-solid fa-pen-to-square'></i>
                                                </a>

                                                <a href='show-meets.php?delete_id=" . $result['meeting_id'] . "&csrf_token=" . urlencode($csrf_token) . "' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete?\")' title='Delete'>
                                                    <i class='fa-solid fa-trash'></i>
                                                </a>
                                            </td>";
                                        }

                                    echo "</tr>";
                                }
                            }
                        } else {
                            // Colspan adjustment
                            $colspan = $isAdmin ? 8 : 7;
                            echo "<tr><td colspan='$colspan' style='text-align:center;'>No Upcoming Meetings Found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</body>

</html>
