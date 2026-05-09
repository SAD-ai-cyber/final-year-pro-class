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

    deleteLatestNotificationForUser(
        $con,
        'admin',
        1,
        'New Demo Class Request',
        'A new demo class request has been received from the website.',
        'show-details/show-demo-register-Std-details.php'
    );

    // Database se wo row delete kar dega
    $stmt = mysqli_prepare($con, "DELETE FROM add_demo_students WHERE Student_Id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Page refresh kar rega
    header("Location: show-demo-register-Std-details.php");
}


//  Kya User ne 'save_btn' dabaya hai? 
if (isset($_POST['save_btn'])) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }

    // Hidden ID le rahe hai taaki pata chale kis student ka data hai
    $id = (int)$_POST['id'];

    // Form se naya data variables me store kiya
    $s_name = $_POST['sname'];
    $s_num = $_POST['snum'];
    

    // Update query 
    $update_query = "UPDATE add_demo_students SET 
                    student_name =?, 
                     student_num =? 
                     
                     WHERE Student_Id=?";

    $stmt = mysqli_prepare($con, $update_query);
    mysqli_stmt_bind_param($stmt, "ssi", $s_name, $s_num, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);


    header("Location: show-demo-register-Std-details.php");
}

//  data lene keliye query chalayi
$query = "SELECT * FROM add_demo_students";
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
     <link rel="stylesheet" href="../css/details/class-function.css?v=<?php echo time(); ?>">
</head>

<body class="fixed-scroll-page">
    <div class="card fixed-scroll-card">
        <div class="card-header fixed-scroll-header">
            <h2 class="card-title">Manage Demo Student</h2>
        </div>

        <form action="" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">

            <div class="card-body">
                <table class="details-table">
                    <thead>
                        <tr>
                            <th>Student Id </th>
                            <th>Student Name</th>
                            <th>Student Number</th>
                            <th>Upload At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if ($total > 0) {
                            while ($result = mysqli_fetch_assoc($data)) {

                                //  Kya hume is row ko Edit karna hai?
                                if (isset($_GET['edit_id']) && $_GET['edit_id'] == $result['Student_Id']) {

                                    //   edit karne keliye input box dale 
                                    echo "<tr>
                            <td>
                                " . $result['Student_Id'] . "
                                <input type='hidden' name='id' value='" . $result['Student_Id'] . "'>
                            </td>

                            <td><input type='text' name='sname' value='" . $result['student_name'] . "'></td>
                            <td><input type='tel' name='snum' maxlength='10' value=' " . $result['student_num'] . "'></td>
                            <td>" . $result['created_at'] . "</td>
                            
                            <td class='action-buttons'>
                                <button type='submit' name='save_btn' title='Save Changes'>
                                    <i class='fa-solid fa-check'></i>
                                </button>
                                
                                <a href='show-demo-register-Std-details.php' title='Cancel' class='btn-cancel'>
                                    <i class='fa-solid fa-xmark'></i>
                                </a>
                            </td>
                        </tr>";

                                } else {

                                    //data show kiya 
                                    echo "<tr>
                            <td>" . $result['Student_Id'] . "</td>
                            <td>" . $result['student_name'] . "</td>
                            <td>" . $result['student_num'] . "</td>
                            <td>" . $result['created_at'] . "</td>
                            
                        
                            <td class='action-buttons'>
                                <a href='show-demo-register-Std-details.php?edit_id=" . $result['Student_Id'] . "' class='btn-edit' title='Edit'>
                                    <i class='fa-solid fa-pen-to-square'></i>
                                </a>

                                <a href='show-demo-register-Std-details.php?delete_id=" . $result['Student_Id'] . "&csrf_token=" . urlencode($csrf_token) . "' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete?\")' title='Delete'>
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
