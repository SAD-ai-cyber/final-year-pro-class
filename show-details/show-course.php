<?php
require '../includes/security.php';
require '../includes/config.php';
require '../includes/notification_helper.php';

// Start secure session and headers
start_secure_session();
// Apply security headers for this request.
send_security_headers();
$csrf_token = csrf_token();

// DELETE LOGIC 
if (isset($_GET['delete_id'])) {
    $token = $_GET['csrf_token'] ?? '';
    if (!verify_csrf_token($token)) {
        die('Invalid request.');
    }
    $id = (int) $_GET['delete_id'];
    $course_name = '';
    $course_code = '';
    $stmt = $con->prepare('SELECT Course_Name, Course_Code FROM course_add WHERE Course_id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && ($row = $res->fetch_assoc())) {
            $course_name = $row['Course_Name'] ?? '';
            $course_code = $row['Course_Code'] ?? '';
        }
        $stmt->close();
    }

    if ($course_name !== '' && $course_code !== '') {
        $notif_title = 'Course Added';
        $notif_message = "Course: {$course_name} ({$course_code})";
        deleteNotificationsByContent($con, $notif_title, $notif_message, 'show-details/show-course.php');
        deleteQueuedEmailsByContent($con, $notif_title, $notif_message, 'show-details/show-course.php');
    }
    $stmt = $con->prepare('DELETE FROM course_add WHERE Course_id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: show-course.php");
}

//  UPDATE LOGIC
if (isset($_POST['save_btn'])) {
    require_post_csrf();

    $id = (int) $_POST['id'];
    
    $c_name = $_POST['cname'];
    $c_code = $_POST['code'];
    $section = $_POST['section'];
    $t_name = $_POST['tname'];
    $duration = $_POST['duration'];
    $category = $_POST['catg'];
    $start_date = $_POST['dat'];
    $desc = $_POST['desc'];
    $fees = $_POST['fees']; 

    //  PHOTO UPDATE LOGIC
    
    $photo_name = $_POST['old_photo']; 

    // Agar user ne nayi photo select ki hai
    if (isset($_FILES['new_photo'])) {
        $upload = upload_file_simple(
            $_FILES['new_photo'],
            "../material_upload/course_photo/",
            ['jpg', 'jpeg', 'png', 'webp'],
            2 * 1024 * 1024,
            'course_'
        );
        if ($upload['ok']) {
            $photo_name = $upload['filename'];
        } elseif ($upload['error'] !== 'No file uploaded.') {
            echo "<script> alert('Photo upload failed: " . addslashes($upload['error']) . "');
                   location.href='show-course.php';
            </script>";
            exit;
        }
    }

    $stmt = $con->prepare(
        'UPDATE course_add SET Course_Name=?, Course_Code=?, Section=?, Teacher=?, Duration=?, Category=?, starting_date=?, course_description=?, course_fees=?, course_photo=? WHERE Course_id=?'
    );
    if ($stmt) {
        $stmt->bind_param(
            'ssssssssssi',
            $c_name,
            $c_code,
            $section,
            $t_name,
            $duration,
            $category,
            $start_date,
            $desc,
            $fees,
            $photo_name,
            $id
        );
        $stmt->execute();
        $stmt->close();
    }
    header("Location: show-course.php");
}

// --- DATA FETCH ---
$data = mysqli_query($con, 'SELECT * FROM course_add');
$total = mysqli_num_rows($data);
?>

<html>
<head>
    <title>Manage Courses</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    

    <!--  php echo time();  har second URL ko badal deta hai-->
     <link rel="stylesheet" href="../css/details/course.css?v=<?php echo time(); ?>">
    
    <style>
        /* Thoda sa style taaki photo sahi dikhe */
        .course-img {
            width: 50px; height: 50px; 
            border-radius: 50%; 
            object-fit: cover; 
            border: 1px solid #ccc;
        }
    </style>
</head>

<body class="fixed-scroll-page">
    <div class="card fixed-scroll-card">
        <div class="card-header fixed-scroll-header">
            <h2 class="card-title">Manage Courses</h2>
        </div>

        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

            <div class="card-body">
                <table class="details-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Photo</th> 
                            <th>Name</th>
                            <th>Code</th>
                            <th>Section</th>
                            <th>Teacher</th>
                            <th>Fees</th> 
                            <th>Duration</th>
                            <th>Category</th>
                            <th>Start Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if ($total > 0) {
                            while ($result = mysqli_fetch_assoc($data)) {

                                // Photo Path Set kiya
                                $photo_path = "../material_upload/course_photo/" . $result['course_photo'];
                                
                                // Agar photo DB me nahi hai ya file exist nahi karti to default image
                                if(empty($result['course_photo'])) {
                                    
                                    $display_img = "<span style='color:grey; font-size:12px;'>No Img</span>";
                                } else {
                                    $display_img = "<img src='$photo_path' class='course-img'>";
                                }

                                // EDIT MODE 
                                if (isset($_GET['edit_id']) && $_GET['edit_id'] == $result['Course_id']) {

                                    echo "<tr>
                                        <td>" . $result['Course_id'] . "<input type='hidden' name='id' value='" . $result['Course_id'] . "'></td>
                                        
                                        <td>
                                            $display_img <br>
                                            <input type='hidden' name='old_photo' value='" . $result['course_photo'] . "'>
                                            <input type='file' name='new_photo' style='width:90px; font-size:10px;'>
                                        </td>

                                        <td><input type='text' name='cname' value='" . $result['Course_Name'] . "' style='width:100px;'></td>
                                        <td><input type='text' name='code' value='" . $result['Course_Code'] . "' style='width:60px;'></td>
                                        <td><input type='text' name='section' value='" . $result['Section'] . "' style='width:50px;'></td>
                                        <td><input type='text' name='tname' value='" . $result['Teacher'] . "' style='width:80px;'></td>
                                        
                                        <td><input type='number' name='fees' value='" . $result['course_fees'] . "' style='width:70px;'></td>

                                        <td><input type='number' name='duration' value='" . $result['Duration'] . "' style='width:50px;'></td>
                                        <td><input type='text' name='catg' value='" . $result['Category'] . "' style='width:70px;'></td>
                                        <td><input type='date' name='dat' value='" . $result['starting_date'] . "'></td>
                                        
                                        <input type='hidden' name='desc' value='" . $result['course_description'] . "'>

                                        <td class='action-buttons'>
                                            <button type='submit' name='save_btn' title='Save'>
                                                <i class='fa-solid fa-check'></i>
                                            </button>
                                            <a href='show-course.php' class='btn-cancel' title='Cancel'>
                                                <i class='fa-solid fa-xmark'></i>
                                            </a>
                                        </td>
                                    </tr>";

                                } else {
                                    //  NORMAL DISPLAY MODE 
                                    echo "<tr>
                                        <td>" . $result['Course_id'] . "</td>
                                        
                                        <td>" . $display_img . "</td>

                                        <td>" . $result['Course_Name'] . "</td>
                                        <td>" . $result['Course_Code'] . "</td>
                                        <td>" . $result['Section'] . "</td>
                                        <td>" . $result['Teacher'] . "</td>
                                        
                                        <td style='color:green; font-weight:bold;'>" . $result['course_fees'] . "</td>

                                        <td>" . $result['Duration'] . " Months</td>
                                        <td>" . $result['Category'] . "</td>
                                        <td>" . $result['starting_date'] . "</td>
                                        
                                        <td class='action-buttons'>
                                            <a href='show-course.php?edit_id=" . $result['Course_id'] . "' class='btn-edit' title='Edit'>
                                                <i class='fa-solid fa-pen-to-square'></i>
                                            </a>
                                            <a href='show-course.php?delete_id=" . $result['Course_id'] . "&csrf_token=" . urlencode($csrf_token) . "' class='btn-delete' onclick=\"return confirm('Delete this course?')\" title='Delete'>
                                                <i class='fa-solid fa-trash'></i>
                                            </a>
                                        </td>
                                    </tr>";
                                }
                            }
                        } else {
                            echo "<tr><td colspan='11' style='text-align:center;'>No Courses Found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</body>
</html>
