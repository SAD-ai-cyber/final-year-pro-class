<?php
require '../includes/security.php';
require '../includes/config.php';
require '../includes/notification_helper.php';

// Start secure session and headers
start_secure_session();
// Apply security headers for this request.
send_security_headers();
$csrf_token = csrf_token();

// Check karein user Admin hai ya nahi
$isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] == 'admin');

// Logged in user ka username/ID nikalein 
$loggedInUser = isset($_SESSION['username']) ? $_SESSION['username'] : '';


// 1. DELETE LOGIC 

if (isset($_GET['delete_id']) && $isAdmin) {

    $token = $_GET['csrf_token'] ?? '';
    if (!verify_csrf_token($token)) {
        die('Invalid request.');
    }

    $id = (int) $_GET['delete_id'];
    $student_name = '';
    $exam_name = '';
    $exam_date = '';
    $exam_center = '';

    $stmt = $con->prepare('SELECT Student_Name, Examination_Name, Exam_Date, Exam_Center FROM admin_card WHERE admin_card_id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && ($row = $res->fetch_assoc())) {
            $student_name = $row['Student_Name'] ?? '';
            $exam_name = $row['Examination_Name'] ?? '';
            $exam_date = $row['Exam_Date'] ?? '';
            $exam_center = $row['Exam_Center'] ?? '';
        }
        $stmt->close();
    }

    if ($exam_name !== '' && $exam_date !== '' && $exam_center !== '') {
        $student_title = 'Hall Ticket Generated';
        $student_message = "Exam: {$exam_name} | Date: {$exam_date} | Center: {$exam_center}";
        deleteNotificationsByContent($con, $student_title, $student_message, 'show-details/show-admin-card.php');
        deleteQueuedEmailsByContent($con, $student_title, $student_message, 'show-details/show-admin-card.php');
    }

    if ($student_name !== '' && $exam_name !== '') {
        $admin_title = 'Hall Ticket Generated';
        $admin_message = "Student: {$student_name} | Exam: {$exam_name}";
        deleteNotificationsByContent($con, $admin_title, $admin_message, 'show-details/show-admin-card.php');
        deleteQueuedEmailsByContent($con, $admin_title, $admin_message, 'show-details/show-admin-card.php');
    }

    // Database se wo row delete kar dega
    $stmt = $con->prepare('DELETE FROM admin_card WHERE admin_card_id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

    // Page refresh kar rega
    header("Location: show-admin-card.php");
}


// 2. UPDATE LOGIC (Sirf Admin ke liye)

if (isset($_POST['save_btn']) && $isAdmin) {
    require_post_csrf();

    // Hidden ID le rahe hain taaki pata chale kis student ka data hai
    $id = (int) $_POST['id'];

    // Form se naya data variables me store kiya
    $s_id = $_POST['sid'];
    $s_name = $_POST['sname'];
    $s_email = $_POST['semail'];
    $c_name = $_POST['cname'];
    $e_name = $_POST['ename'];
    $e_date = $_POST['edate'];
    $e_time = $_POST['etime'];
    $e_center = $_POST['ecenter'];
    $reg_number = $_POST['reg_number'];
    $seat_number = $_POST['seat_number'];
    $card_validity = $_POST['card_validity'];
    $exam_instructions = $_POST['exam_instructions'];

    // Update query 
    $stmt = $con->prepare(
        'UPDATE admin_card SET Student_Id=?, Student_Name=?, student_email=?, Course_Name=?, Examination_Name=?, Exam_Date=?, Reporting_Time=?, Exam_Center=?, Registration_Number=?, Seat_Number=?, Card_Validity_Date=?, Exam_Instructions=? WHERE admin_card_id=?'
    );
    if ($stmt) {
        $stmt->bind_param(
            'isssssssssssi',
            $s_id,
            $s_name,
            $s_email,
            $c_name,
            $e_name,
            $e_date,
            $e_time,
            $e_center,
            $reg_number,
            $seat_number,
            $card_validity,
            $exam_instructions,
            $id
        );
        $stmt->execute();
        $stmt->close();
    }


    header("Location: show-admin-card.php");
}


// 3. DATA FETCH LOGIC 

if ($isAdmin) {
    // Agar Admin hai, toh SABKA data dikhao
    $data = mysqli_query($con, "SELECT * FROM admin_card");
} else {
    // Agar Student hai, toh sirf USKA data dikhao
    $stmt = $con->prepare('SELECT * FROM admin_card WHERE student_email = ?');
    $data = null;
    if ($stmt) {
        $stmt->bind_param('s', $loggedInUser);
        $stmt->execute();
        $data = $stmt->get_result();
        $stmt->close();
    }
}
// table me kitne number of data row he vo store kiya
$total = mysqli_num_rows($data);
?>


<html>

<head>
    <title>Hall Ticket Card Details</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!--  php echo time();  har second URL ko badal deta hai-->
     <link rel="stylesheet" href="../css/details/admin-card.css?v=<?php echo time(); ?>">
</head>

<body class="fixed-scroll-page">
    <div class="card fixed-scroll-card">
        <div class="card-header fixed-scroll-header">
            <h2 class="card-title">Student Hall Ticket Details</h2>
        </div>

        <form action="" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

            <div class="card-body">
                <table class="details-table">
                    <thead>
                        <tr>
                            <th>Admin ID</th>
                            <th>Student ID</th>
                            <th>Student Photo</th>
                            <th>Student Name</th>
                            <th>Student Email</th>
                            <th>Course Name</th>
                            <th>Exam Name</th>
                            <th>Exam Date</th>
                            <th>Exam Time</th>
                            <th>Exam Center</th>
                            <th>Registration Number</th>
                            <th>Seat Number</th>
                            <th>Card Validity Date</th>
                            <th>Exam Instructions</th>
                            <th>Upload Data</th>
                            
                            <?php if ($isAdmin) { ?>
                                <th>Actions</th>
                            <?php } ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if ($total > 0) {
                            while ($result = mysqli_fetch_assoc($data)) {

                                $image_src = "../material_upload/student_photo/" . $result['photo'];

                                //  Kya hume is row ko Edit karna hai? 
                                if (isset($_GET['edit_id']) && $_GET['edit_id'] == $result['admin_card_id'] && $isAdmin) {

                                    //   edit karne keliye input box dale 
                                    echo "<tr>
                            <td>
                                " . $result['admin_card_id'] . "
                                <input type='hidden' name='id' value='" . $result['admin_card_id'] . "'>
                            </td>
                            <td><input type='text' name='sid' value='" . $result['Student_Id'] . "'></td>
                             <td>
                                <img src='$image_src' alt='student Img' style='width:100px; height:100px; object-fit:cover; border-radius:4px;'>
                            </td>

                            <td><input type='text' name='sname' value='" . $result['Student_Name'] . "'></td>
                            <td><input type='text' name='semail' value='" . $result['student_email'] . "'></td>
                            <td><input type='text' name='cname' value='" . $result['Course_Name'] . "'></td>
                            <td><input type='text' name='ename' value='" . $result['Examination_Name'] . "'></td>
                            <td><input type='date' name='edate' value='" . $result['Exam_Date'] . "'></td>
                            <td><input type='text' name='etime' value='" . $result['Reporting_Time'] . "'></td>
                            <td><input type='text' name='ecenter' value='" . $result['Exam_Center'] . "'></td>
                            <td><input type='text' name='reg_number' value='" . $result['Registration_Number'] . "'></td>
                            <td><input type='text' name='seat_number' value='" . $result['Seat_Number'] . "'></td>
                            <td><input type='date' name='card_validity' value='" . $result['Card_Validity_Date'] . "'></td>
                            <td><textarea name='exam_instructions'>" . $result['Exam_Instructions'] . "</textarea></td>
                            <td>" . $result['upload_date'] . "</td>
                            
                            <td class='action-buttons'>
                                <button type='submit' name='save_btn' title='Save Changes'>
                                    <i class='fa-solid fa-check'></i>
                                </button>
                                
                                <a href='show-admin-card.php' title='Cancel' class='btn-cancel'>
                                    <i class='fa-solid fa-xmark'></i>
                                </a>
                            </td>
                        </tr>";
                                } else {

                                    //data show kiya 
                                    echo "<tr>
                            <td>" . $result['admin_card_id'] . "</td>
                            <td>" . $result['Student_Id'] . "</td>

                             <td>
                                <img src='$image_src' alt='No Image' style='width:100px; height:100px; object-fit:cover; border-radius:4px; border:1px solid #ccc;'>
                            </td>

                            <td>" . $result['Student_Name'] . "</td>
                            <td>" . $result['student_email'] . "</td>
                            <td>" . $result['Course_Name'] . "</td>
                            <td>" . $result['Examination_Name'] . "</td>
                            <td>" . $result['Exam_Date'] . "</td>
                            <td>" . $result['Reporting_Time'] . "</td>
                            <td>" . $result['Exam_Center'] . "</td>
                            <td>" . $result['Registration_Number'] . "</td>
                            <td>" . $result['Seat_Number'] . "</td>
                            <td>" . $result['Card_Validity_Date'] . "</td>
                            <td>" . $result['Exam_Instructions'] . "</td>
                            <td>" . $result['upload_date'] . "</td>";

                                    // Actions Buttons Sirf Admin ko dikhenge
                                    if ($isAdmin) {
                                        echo "<td class='action-buttons'>
                                <a href='show-admin-card.php?edit_id=" . $result['admin_card_id'] . "' class='btn-edit' title='Edit'>
                                    <i class='fa-solid fa-pen-to-square'></i>
                                </a>

                                <a href='show-admin-card.php?delete_id=" . $result['admin_card_id'] . "&csrf_token=" . urlencode($csrf_token) . "' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete?\")' title='Delete'>
                                    <i class='fa-solid fa-trash'></i>
                                </a>
                            </td>";
                                    }

                                    echo "</tr>";
                                }
                            }
                        } else {
                            // Column count adjust kiya taaki 'No Records' center me aaye
                            // : means Ternary Operator mein iska matlab "Else" (Warna / Nahi toh) hota hai.
                            $colspan = $isAdmin ? 16 : 15;
                            echo "<tr><td colspan='$colspan' style='text-align:center;'>No Records Found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</body>

</html>
