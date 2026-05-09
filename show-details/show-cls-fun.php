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

// delete logic he
if (isset($_GET['delete_id']) && $isAdmin) {
    if (!verify_csrf_token($_GET['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }

    $id = (int)$_GET['delete_id'];

    $event_name = '';
    $event_date = '';
    $event_time = '';
    $stmt = mysqli_prepare($con, "SELECT Event_Name, Event_Date, Event_Time FROM add_event WHERE Event_id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($res && ($row = mysqli_fetch_assoc($res))) {
            $event_name = $row['Event_Name'] ?? '';
            $event_date = $row['Event_Date'] ?? '';
            $event_time = $row['Event_Time'] ?? '';
        }
        mysqli_stmt_close($stmt);
    }

    if ($event_name !== '' && $event_date !== '') {
        $notif_title = 'New Class Event';
        $message_prefix = "Event: {$event_name} | Date: {$event_date}";
        $link = 'show-details/show-cls-fun.php';

        $stmt = mysqli_prepare(
            $con,
            'DELETE FROM notifications WHERE title = ? AND message LIKE ? AND link = ?'
        );
        if ($stmt) {
            $like = $message_prefix . '%';
            mysqli_stmt_bind_param($stmt, 'sss', $notif_title, $like, $link);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        $email_stmt = mysqli_prepare(
            $con,
            "DELETE FROM notification_email_queue WHERE subject = ? AND body LIKE ? AND link = ? AND status <> 'sent'"
        );
        if ($email_stmt) {
            $like = $message_prefix . '%';
            mysqli_stmt_bind_param($email_stmt, 'sss', $notif_title, $like, $link);
            mysqli_stmt_execute($email_stmt);
            mysqli_stmt_close($email_stmt);
        }
    }
    
    // Database se event delete karega
    $stmt = mysqli_prepare($con, "DELETE FROM add_event WHERE Event_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    
    header("Location: show-cls-fun.php");
}

// update logic he 
if (isset($_POST['save_btn']) && $isAdmin) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }
    
    $id = (int)$_POST['id'];
    
    $e_name = $_POST['ename'];
    $e_desc = $_POST['edesc'];
    $e_date = $_POST['edate'];
    $e_time = $_POST['etime'];
    $e_expense = $_POST['etotal'];
    

    $update_query = "UPDATE add_event SET 
                     Event_Name=?, 
                     Event_Desc=?, 
                     Event_Date=?, 
                     Event_Time=?, 
                     Total_Expense=?
                     WHERE Event_id=?";
    
    $stmt = mysqli_prepare($con, $update_query);
    mysqli_stmt_bind_param($stmt, "sssssi", $e_name, $e_desc, $e_date, $e_time, $e_expense, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: show-cls-fun.php");
}

// DATA FETCH LOGIC 

if ($isAdmin) {
    // Admin: Sab kuch dikhega (Past + Future)
    $query = "SELECT * FROM add_event";
} else {
    // Student: Sirf Upcoming (Event_Date >= Aaj ki date)
    // ORDER BY ASC taaki jo event paas hai wo pehle dikhe
    $query = "SELECT * FROM add_event WHERE Event_Date >= CURDATE() ORDER BY Event_Date ASC";
}

$data = mysqli_query($con, $query);
$total = mysqli_num_rows($data);
?>

<html>
<head>
    <title>Class Event Details</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!--  php echo time();  har second URL ko badal deta hai-->
     <link rel="stylesheet" href="../css/details/class-function.css?v=<?php echo time(); ?>">
</head>

<body class="fixed-scroll-page">
    <div class="card fixed-scroll-card">
        <div class="card-header fixed-scroll-header">
            <h2 class="card-title">Class Events Management</h2>
        </div>

        <form action="" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
            
            <div class="card-body">
                <table class="details-table">
                    <thead>
                        <tr>
                            <th>Event ID</th>
                            <th>Event Name</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Time</th>
                            
                            <?php if($isAdmin) { ?>
                                <th>Expense</th>
                            <?php } ?>

                            <th>Event Photo</th> 
                            
                            <?php if($isAdmin){ ?>
                             <th>Actions</th>
                           <?php } ?>
                        </tr>
                    </thead>
                    
                    <tbody>
            <?php
            if ($total > 0) {
                while ($result = mysqli_fetch_assoc($data)) {
                    
                    
                    // Agar database me file ka naam hai, to folder path + filename add karega
                    $image_src = "../material_upload/event_data/" . $result['event_file'];


                    // ye edit karne vala logic he (Sirf Admin access karega naturally)
                    if (isset($_GET['edit_id']) && $_GET['edit_id'] == $result['Event_id'] && $isAdmin) {
                        
                        echo "<tr>
                            <td>" . $result['Event_id'] . "<input type='hidden' name='id' value='" . $result['Event_id'] . "'></td>
                            
                            <td><input type='text' name='ename' value='" . $result['Event_Name'] . "'></td>
                            <td><input type='text' name='edesc' value='" . $result['Event_Desc'] . "'></td>
                            <td><input type='date' name='edate' value='" . $result['Event_Date'] . "'></td>
                            <td><input type='time' name='etime' value='" . $result['Event_Time'] . "'></td>
                            
                            <td><input type='text' name='etotal' value='" . $result['Total_Expense'] . "'></td>
                            
                            <td>
                                <img src='$image_src' alt='Event Img' style='width:100px; height:100px; object-fit:cover; border-radius:4px;'>
                            </td>
                            
                            <td class='action-buttons'>
                                <button type='submit' name='save_btn' title='Save'>
                                    <i class='fa-solid fa-check'></i>
                                </button>
                                <a href='show-cls-fun.php' class='btn-cancel' title='Cancel'>
                                    <i class='fa-solid fa-xmark'></i>
                                </a>
                            </td>
                        </tr>";

                    } else {

                        // data show karne vala logic he 
                        echo "<tr>
                            <td>" . $result['Event_id'] . "</td>
                            <td>" . $result['Event_Name'] . "</td>
                            <td>" . $result['Event_Desc'] . "</td>
                            <td style='color:red';>" . $result['Event_Date'] . "</td>
                            <td>" . $result['Event_Time'] . "</td>";

                            // Expense Data: Sirf Admin ko dikhega
                            if($isAdmin) {
                                echo "<td>" . $result['Total_Expense'] . "</td>";
                            }
                            
                        echo "<td>
                                <img src='$image_src' alt='No Image' style='width:100px; height:100px; object-fit:cover; border-radius:4px; border:1px solid #ccc;'>
                            </td>";
                           
                            // Action Buttons: Sirf Admin ko dikhenge
                            if($isAdmin){
                               echo"<td class='action-buttons'>
                                    <a href='show-cls-fun.php?edit_id=" . $result['Event_id'] . "' class='btn-edit' title='Edit'>
                                        <i class='fa-solid fa-pen-to-square'></i>
                                    </a>
                                    <a href='show-cls-fun.php?delete_id=" . $result['Event_id'] . "&csrf_token=" . urlencode($csrf_token) . "' class='btn-delete' onclick='return confirm(\"Delete this event?\")' title='Delete'>
                                        <i class='fa-solid fa-trash'></i>
                                    </a>
                                </td>";
                            }
                            
                        echo"</tr>";
                    }
                }
            } else {
                // Colspan dynamic kiya hai taaki 'No Events Found' center me aaye
                $colspan = $isAdmin ? 8 : 6; 
                echo "<tr><td colspan='$colspan' style='text-align:center;'>No Upcoming Events Found</td></tr>";
            }
            ?>
                    </tbody>
                </table>
            </div> 
        </form> 
    </div>
</body>
</html>
