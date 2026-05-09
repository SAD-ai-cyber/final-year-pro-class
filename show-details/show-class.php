<?php
require '../includes/config.php';
require '../includes/security.php';
require '../includes/notification_helper.php';

// Security/session bootstrap.
start_secure_session();
// Apply security headers for this request.
apply_security_headers();
// Enforce role-based access control.
require_role(['admin']);
$csrf_token = generate_csrf_token();


//  Kya URL me 'delete_id' ye kya dekhega 
if (isset($_GET['delete_id'])) {
    if (!verify_csrf_token($_GET['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }

    $id = (int)$_GET['delete_id'];

    $class_name = '';
    $section = '';
    $stmt = mysqli_prepare($con, "SELECT Class_Name, Section FROM add_class WHERE class_id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($res && ($row = mysqli_fetch_assoc($res))) {
            $class_name = $row['Class_Name'] ?? '';
            $section = $row['Section'] ?? '';
        }
        mysqli_stmt_close($stmt);
    }

    if ($class_name !== '' && $section !== '') {
        $notif_title = 'Class Added';
        $notif_message = "Class: {$class_name} | Section: {$section}";
        deleteNotificationsByContent($con, $notif_title, $notif_message, 'show-details/show-class.php');
        deleteQueuedEmailsByContent($con, $notif_title, $notif_message, 'show-details/show-class.php');
    }

    // Database se wo row delete kar dega
    $stmt = mysqli_prepare($con, "DELETE FROM add_class WHERE class_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Page refresh kar rega
    header("Location: show-class.php");
}


//  Kya User ne 'save_btn' dabaya hai? 
if (isset($_POST['save_btn'])) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }

    // Hidden ID le rahe hain taaki pata chale kis student ka data hai
    $id = (int)$_POST['id'];

    // Form se naya data variables me store kiya
    $c_name = $_POST['cname'];
    $section = $_POST['section'];
    $t_name = $_POST['tname'];
    $max_std = $_POST['max'];
    
    

    // Update query 
    $update_query = "UPDATE add_class SET 
                    Class_Name=?, 
                    Section=?, 
                     Teacher_Name=?, 
                    Max_Student=? 
                     
                     WHERE class_id=?";

    $stmt = mysqli_prepare($con, $update_query);
    mysqli_stmt_bind_param($stmt, "sssii", $c_name, $section, $t_name, $max_std, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);


    header("Location: show-class.php");
}

//  data lene keliye query chalayi
$query = "SELECT * FROM add_class";
// execute kiya query ko
$data = mysqli_query($con, $query);
// table me kitne number of data row he vo store kiya
$total = mysqli_num_rows($data);
?>


<html>

<head>
    <title>Manage Classes</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!--  php echo time();  har second URL ko badal deta hai-->
     <link rel="stylesheet" href="../css/details/class.css?v=<?php echo time(); ?>">
</head>

<body class="fixed-scroll-page">
    <div class="card fixed-scroll-card">
        <div class="card-header fixed-scroll-header">
            <h2 class="card-title">Manage Classes</h2>
        </div>

        <form action="" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">

            <div class="card-body">
                <table class="details-table">
                    <thead>
                        <tr>
                            <th>Class ID</th>
                            <th>Class Name</th>
                            <th>Section</th>
                            <th>Teacher Name</th>
                            <th>Max Student</th>
                            <th>Upload Data</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if ($total > 0) {
                            while ($result = mysqli_fetch_assoc($data)) {

                                //  Kya hume is row ko Edit karna hai?
                                if (isset($_GET['edit_id']) && $_GET['edit_id'] == $result['class_id']) {

                                    //   edit karne keliye input box dale 
                                    echo "<tr>
                            <td>
                                " . $result['class_id'] . "
                                <input type='hidden' name='id' value='" . $result['class_id'] . "'>
                            </td>
                            <td><input type='text' name='cname' value='" . $result['Class_Name'] . "'></td>
                            <td><input type='text' name='section' value='" . $result['Section'] . "'></td>
                            <td><input type='text' name='tname' value='" . $result['Teacher_Name'] . "'></td>
                            <td><input type='number' name='max' value='" . $result['Max_Student'] . "'></td>
                            <td>" . $result['upload_date'] . "</td>
                            
                            <td class='action-buttons'>
                                <button type='submit' name='save_btn' title='Save Changes'>
                                    <i class='fa-solid fa-check'></i>
                                </button>
                                
                                <a href='show-class.php' title='Cancel' class='btn-cancel'>
                                    <i class='fa-solid fa-xmark'></i>
                                </a>
                            </td>
                        </tr>";

                                } else {

                                    //data show kiya 
                                    echo "<tr>
                            <td>" . $result['class_id'] . "</td>
                            <td>" . $result['Class_Name'] . "</td>
                            <td>" . $result['Section'] . "</td>
                            <td>" . $result['Teacher_Name'] . "</td>
                            <td>" . $result['Max_Student'] . "</td>
                            <td>" . $result['upload_date'] . "</td>
                            
                        
                            <td class='action-buttons'>
                                <a href='show-class.php?edit_id=" . $result['class_id'] . "' class='btn-edit' title='Edit'>
                                    <i class='fa-solid fa-pen-to-square'></i>
                                </a>

                                <a href='show-class.php?delete_id=" . $result['class_id'] . "&csrf_token=" . urlencode($csrf_token) . "' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete?\")' title='Delete'>
                                    <i class='fa-solid fa-trash'></i>
                                </a>
                            </td>
                        </tr>";
                                }
                            }
                        } else {
                            echo "<tr><td colspan='10' style='text-align:center;'>No Records Found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</body>

</html>
