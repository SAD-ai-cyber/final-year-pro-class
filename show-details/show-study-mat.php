<?php
require '../includes/security.php';
require '../includes/config.php';
require '../includes/notification_helper.php';

// Start secure session and headers
start_secure_session();
// Apply security headers for this request.
send_security_headers();
$csrf_token = csrf_token();

//  DELETE LOGIC 
if(isset($_GET['delete_id']))
{
    $token = $_GET['csrf_token'] ?? '';
    if (!verify_csrf_token($token)) {
        die('Invalid request.');
    }
    $id = (int) $_GET['delete_id'];
    $course = '';
    $subject = '';
    $stmt = $con->prepare('SELECT course, subject FROM study_material WHERE material_id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && ($row = $res->fetch_assoc())) {
            $course = $row['course'] ?? '';
            $subject = $row['subject'] ?? '';
        }
        $stmt->close();
    }

    if ($course !== '' && $subject !== '') {
        $student_title = 'New Study Material';
        $student_message = "Course: {$course} | Subject: {$subject}";
        deleteNotificationsByContent($con, $student_title, $student_message, 'show-details/show-study-mat.php');
        deleteQueuedEmailsByContent($con, $student_title, $student_message, 'show-details/show-study-mat.php');

        $admin_title = 'Study Material Added';
        $admin_message = "Course: {$course} | Subject: {$subject}";
        deleteNotificationsByContent($con, $admin_title, $admin_message, 'show-details/show-study-mat.php');
        deleteQueuedEmailsByContent($con, $admin_title, $admin_message, 'show-details/show-study-mat.php');
    }
    $stmt = $con->prepare('DELETE FROM study_material WHERE material_id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }
    header("location: show-study-mat.php");
}

// UPDATE LOGIC 
if(isset($_POST['save_btn']))
{
    require_post_csrf();
    $id = (int) $_POST['id'];
    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $course = $_POST['course'];
    $subject = $_POST['sub'];
    $type = $_POST['type'];
    
    // Purana path hidden input se liya (agar kuch naya upload nahi kiya to yehi rahega)
    $final_path = $_POST['old_path'];

    // 1. Agar User ne Nayi File select ki hai (PDF/ZIP ke liye)
    if(isset($_FILES['mat_file'])) {
        $upload = upload_file_simple(
            $_FILES['mat_file'],
            "../material_upload/material/",
            ['pdf', 'zip'],
            10 * 1024 * 1024,
            'material_'
        );
        if ($upload['ok']) {
            $final_path = "../material_upload/material/" . $upload['filename'];
        } elseif ($upload['error'] !== 'No file uploaded.') {
            echo "<script> alert('File upload failed: " . addslashes($upload['error']) . "');
                   location.href='show-study-mat.php';
            </script>";
            exit;
        }
    }
    // 2. Agar User ne Link dala hai (Link/Video ke liye)
    else if(!empty($_POST['mat_link']) && ($type == 'link' || $type == 'video')) {
        $final_path = $_POST['mat_link']; // Naya link set ho gaya
    }

    $stmt = $con->prepare(
        'UPDATE study_material SET title = ?, description = ?, course = ?, subject = ?, material_type = ?, file_path_or_link = ? WHERE material_id = ?'
    );
    if ($stmt) {
        $stmt->bind_param('ssssssi', $title, $desc, $course, $subject, $type, $final_path, $id);
        $stmt->execute();
        $stmt->close();
    }
     header("location: show-study-mat.php");          
}


$data = mysqli_query($con, 'SELECT * FROM study_material ORDER BY material_id DESC');
$total = mysqli_num_rows($data);

?>
<html>
    <head>
        <title>Study Material Details</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        

        <!--  php echo time();  har second URL ko badal deta hai-->
     <link rel="stylesheet" href="../css/details/study-mat.css?v=<?php echo time(); ?>">
    </head>

    <body class="fixed-scroll-page">
        <div class="card fixed-scroll-card">
            <div class="card-header fixed-scroll-header">
                <h2 class="card-title">All Study Materials</h2>
            </div>

            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                <div class="card-body">
                    <table class="details-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Course</th>
                                <th>Subject</th>
                                <th>Type</th>
                                <th>File / Link (Edit)</th>
                            <th>Upload Date</th>
                            <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'teacher') { ?>
                                <th>Action</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                 
                <?php
                $role = $_SESSION['role'] ?? '';
                if($total > 0)
                {
                    while($result = mysqli_fetch_assoc($data))
                    {
                        $file_path = $result['file_path_or_link'];

                        
// Handle GET query action.
                        if(isset($_GET['edit_id']) && $_GET['edit_id'] == $result['material_id'])
                        {
                            echo "<tr>
                            <td>". $result['material_id']. "<input type='hidden' name='id' value='". $result['material_id']."'></td>

                             <td><input type='text' name='title' value='" . $result['title'] . "'></td>
                             <td><input type='text' name='desc' value='" . $result['description'] . "'></td>
                             <td><input type='text' name='course' value='" . $result['course'] . "'></td>
                             <td><input type='text' name='sub' value='" . $result['subject'] . "'></td>
                             
                             <td><input type='text' name='type' value='" . $result['material_type'] . "' placeholder='pdf/link'></td>
                             
                             <td>
                                <input type='hidden' name='old_path' value='" . $file_path . "'>
                                
                                <small>Link Update:</small><br>
                                <input type='text' name='mat_link' value='" . $file_path . "' placeholder='Paste Link here'><br>
                                
                                <small>OR Upload New File:</small><br>
                                <input type='file' name='mat_file'>
                             </td>
                             
                             <td>" . $result['upload_date'] . "</td>";

                             if ($role === 'admin' || $role === 'teacher') {
                                 echo "<td class='action-buttons'>
                                    <button type='submit' name='save_btn'><i class='fa-solid fa-check'></i></button>
                                    <a href='show-study-mat.php' class='btn-cancel'><i class='fa-solid fa-xmark'></i></a>
                                </td>";
                             }
                            
                            echo "</tr>";
                        }
                        else
                        {
                           
                            echo "<tr>
                            <td>". $result['material_id'] . "</td>
                            <td>". $result['title'] . "</td>
                            <td>". $result['description'] . "</td>
                            <td>". $result['course']. "</td>
                            <td>". $result['subject']. "</td>
                            <td>". $result['material_type']. "</td>
                            
                            <td>
                                <a href='$file_path' target='_blank'>View / Download</a>
                            </td>
                            
                             <td>" . $result['upload_date'] . "</td>";

                             if ($role === 'admin' || $role === 'teacher') {
                                echo "<td class='action-buttons'>
                                 <a href='show-study-mat.php?edit_id=" . $result['material_id'] . "' class='btn-edit'><i class='fa-solid fa-pen-to-square'></i></a>
                                 <a href='show-study-mat.php?delete_id=" . $result['material_id'] . "&csrf_token=" . urlencode($csrf_token) . "' class='btn-delete' onclick='return confirm(\"Delete Material?\")'><i class='fa-solid fa-trash'></i></a>
                                </td>";
                             }
                            echo "</tr>";
                        }
                    }
                }
                else{
                    $cols = ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'teacher') ? 9 : 8;
                    echo"<tr><td colspan='$cols' style='text-align:center;'>No Material Found</td></tr>";
                }
                ?>    
                    </tbody>
                    </table>
                </div>
            </form>
        </div>
    </body>
</html>
