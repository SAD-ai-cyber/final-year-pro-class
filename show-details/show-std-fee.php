<?php
require '../includes/config.php';
require '../includes/security.php';
require '../includes/notification_helper.php';

// Security/session bootstrap.
start_secure_session();
// Apply security headers for this request.
apply_security_headers();
// Enforce role-based access control.
require_role(['admin', 'parent', 'student']);
$csrf_token = generate_csrf_token();

// Check Role
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$loggedInUser = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Admin check boolean
$isAdmin = ($role == 'admin');

// 1. DELETE LOGIC (Sirf Admin ke liye) 
if(isset($_GET['delete_id']) && $isAdmin)
{
    if (!verify_csrf_token($_GET['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }

    $id = (int)$_GET['delete_id'];
    $student_name = '';
    $course_name = '';
    $paid_price = '';
    $remaining_price = '';

    $stmt = mysqli_prepare($con, "SELECT student_name, course_name, paid_price, remaining_price FROM student_fees WHERE fee_id = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($res && ($row = mysqli_fetch_assoc($res))) {
            $student_name = $row['student_name'] ?? '';
            $course_name = $row['course_name'] ?? '';
            $paid_price = $row['paid_price'] ?? '';
            $remaining_price = $row['remaining_price'] ?? '';
        }
        mysqli_stmt_close($stmt);
    }

    if ($course_name !== '' && $paid_price !== '' && $remaining_price !== '') {
        $student_title = 'Fee Payment Updated';
        $student_message = "Course: {$course_name} | Paid: {$paid_price} | Remaining: {$remaining_price}";
        deleteNotificationsByContent($con, $student_title, $student_message, 'show-details/show-std-fee.php');
        deleteQueuedEmailsByContent($con, $student_title, $student_message, 'show-details/show-std-fee.php');
    }

    if ($student_name !== '' && $course_name !== '') {
        $admin_title = 'Fee Updated';
        $admin_message = "Student: {$student_name} | Course: {$course_name}";
        deleteNotificationsByContent($con, $admin_title, $admin_message, 'show-details/show-std-fee.php');
        deleteQueuedEmailsByContent($con, $admin_title, $admin_message, 'show-details/show-std-fee.php');
    }
    $stmt = mysqli_prepare($con, "DELETE FROM student_fees WHERE fee_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header( "location: show-std-fee.php");
}

// 2. UPDATE LOGIC (Sirf Admin ke liye) 
if(isset($_POST['save_btn']) && $isAdmin)
{
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        die('Invalid CSRF token.');
    }

    $id = (int)$_POST['id'];
    $s_id = $_POST['sid'];
    $s_name = $_POST['sname'];
    $s_email = $_POST['semail']; 
    $p_email = $_POST['pemail']; 
    $c_name = $_POST['cname'];
    $c_price = $_POST['cprice'];
    $p_price = $_POST['pprice'];
    $r_price = $_POST['rprice'];
    $pay_date = $_POST['paydate'];
    $pay_time = $_POST['paytime'];
    $payment_method = $_POST['payment_method'];
    $transaction_id = $_POST['transaction_id'];
    $receipt_number = $_POST['receipt_number'];
    $discount_amount = $_POST['discount_amount'];
    $payment_notes = $_POST['payment_notes'];

     $update = "UPDATE student_fees SET
                    student_id = ?,
                    student_name = ?,
                    student_email = ?,
                    parent_email = ?,
                    course_name = ?,
                    course_price = ?,
                    paid_price = ?,
                    remaining_price = ?,
                    payment_method = ?,
                    transaction_id = ?,
                    receipt_number = ?,
                    payment_date = ?,
                    payment_time = ?,
                    discount_amount = ?,
                    payment_notes = ?
                     WHERE fee_id = ?";

      $stmt = mysqli_prepare($con, $update);
      mysqli_stmt_bind_param(
          $stmt,
          "sssssssssssssssi",
          $s_id,
          $s_name,
          $s_email,
          $p_email,
          $c_name,
          $c_price,
          $p_price,
          $r_price,
          $payment_method,
          $transaction_id,
          $receipt_number,
          $pay_date,
          $pay_time,
          $discount_amount,
          $payment_notes,
          $id
      );
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
     header("location: show-std-fee.php");           
}


// 3. FETCH DATA LOGIC 

if ($isAdmin) {
    // Case 1: Admin - Show ALL Data
    $select = "SELECT * FROM student_fees";
    $data = mysqli_query($con, $select);
} 
elseif ($role == 'parent') {
    // Case 2: Parent - Session se direct Email lo
    if(isset($_SESSION['email'])) {
        $parent_email = $_SESSION['email'];
        $stmt = mysqli_prepare($con, "SELECT * FROM student_fees WHERE parent_email = ?");
        mysqli_stmt_bind_param($stmt, "s", $parent_email);
        mysqli_stmt_execute($stmt);
        $data = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
    } else {
        $data = mysqli_query($con, "SELECT * FROM student_fees WHERE 1=0");
    }

} 
else {
    // Case 3: Student - Show only their own data
    $stmt = mysqli_prepare($con, "SELECT * FROM student_fees WHERE student_email = ?");
    mysqli_stmt_bind_param($stmt, "s", $loggedInUser);
    mysqli_stmt_execute($stmt);
    $data = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
}

$total = mysqli_num_rows($data);

?>
<html>
    <head>
        <title>Fee Details</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
      

        <!--  php echo time();  har second URL ko badal deta hai-->
    <link rel="stylesheet" href="../css/details/parent.css?v=<?php echo time(); ?>">
    </head>

    <body class="fixed-scroll-page">
        <div class="card fixed-scroll-card">
            <div class="card-header fixed-scroll-header">
                <h2 class="card-title">All Students Fee Details</h2>
            </div>

            <form action="" method="post">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                <div class="card-body">
                    <table class="details-table">
                        <thead>
                            <tr>
                                <th>Fee Id</th>
                                <th>Student Id</th>
                                <th>Student Name</th>
                                <?php if ($isAdmin) { ?>
                                    <th>Student Email</th> 
                                    <th>Parent Email</th> 
                                <?php } ?>
                                <th>Course Name </th>
                                <th>Course Price</th>
                                <th>Paid Price</th>
                                <th>Remaining Price</th>
                                <?php if ($isAdmin) { ?>
                                    <th>Payment Method</th>
                                    <th>Transaction ID</th>
                                    <th>Receipt Number</th>
                                <?php } ?>
                                <th>Payment Date</th>
                                <?php if ($isAdmin) { ?>
                                    <th>Payment Time</th>
                                    <th>Discount</th>
                                    <th>Payment Notes</th>
                                <?php } ?>
                                <th>Receipt File</th>
                                <?php if ($isAdmin) { ?>
                                    <th>Created At</th>
                                    <th>Action</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                     
                    <?php
                    if($total > 0)
                    {
                        while($result = mysqli_fetch_assoc($data))
                        {
                            $image_src = "../material_upload/receipts/" . $result['receipt_file'];

                            // EDIT MODE (Only for Admin)
                            if(isset($_GET['edit_id']) && $_GET['edit_id'] == $result['fee_id'] && $isAdmin)
                            {
                                echo "<tr>
                                <td>". $result['fee_id']. "<input type='hidden' name='id' value='". $result['fee_id']."'></td>

                                 <td><input type='text' name='sid' value='" . $result['student_id'] . "'></td>
                                 <td><input type='text' name='sname' value='" . $result['student_name'] . "'></td>
                                 
                                 <td><input type='email' name='semail' value='" . $result['student_email'] . "'></td>
                                 <td><input type='email' name='pemail' value='" . $result['parent_email'] . "'></td>
                                 
                                 <td><input type='text' name='cname' value='" . $result['course_name'] . "'></td>
                                 <td><input type='number' name='cprice' value='" . $result['course_price'] . "'></td>
                                 <td><input type='number' name='pprice' value='" . $result['paid_price'] . "'></td>
                                 <td><input type='number' name='rprice' value='" . $result['remaining_price'] . "'></td>
                                 <td><input type='text' name='payment_method' value='" . $result['payment_method'] . "'></td>
                                 <td><input type='text' name='transaction_id' value='" . $result['transaction_id'] . "'></td>
                                 <td><input type='text' name='receipt_number' value='" . $result['receipt_number'] . "'></td>
                                 <td><input type='date' name='paydate' value='" . $result['payment_date'] . "'></td>
                                 <td><input type='time' name='paytime' value='" . $result['payment_time'] . "'></td>
                                 <td><input type='number' name='discount_amount' value='" . $result['discount_amount'] . "'></td>
                                 <td><input type='text' name='payment_notes' value='" . $result['payment_notes'] . "'></td>

                                 <td>
                                     <img src='$image_src' alt='result Img' style='width:100px; height:100px; object-fit:cover; border-radius:4px;'>
                                 </td>

                                 <td>" . $result['created_at'] . "</td>

                                 <td class='action-buttons'>
                                    <button type='submit' name='save_btn'><i class='fa-solid fa-check'></i></button>
                                    <a href='show-std-fee.php' class='btn-cancel'><i class='fa-solid fa-xmark'></i></a>
                                </td>
                                
                            </tr>";
                            }
                            else
                            {
                                // VIEW MODE 
                                echo "<tr>
                                <td>". $result['fee_id'] . "</td>
                                <td>". $result['student_id'] . "</td>
                                <td>". $result['student_name'] . "</td>";
                                
                                if($isAdmin) {
                                  echo "<td>". $result['student_email'] . "</td>
                                        <td>". $result['parent_email'] . "</td>";
                                }

                                echo "<td>". $result['course_name']. "</td>
                                <td>". $result['course_price']. "</td>
                                <td>". $result['paid_price']. "</td>
                                <td>". $result['remaining_price']. "</td>";

                                if($isAdmin) {
                                  echo "<td>". $result['payment_method']. "</td>
                                        <td>". $result['transaction_id']. "</td>
                                        <td>". $result['receipt_number']. "</td>";
                                }

                                echo "<td>". $result['payment_date']. "</td>";

                                if($isAdmin) {
                                   echo "<td>". $result['payment_time']. "</td>
                                         <td>". $result['discount_amount']. "</td>
                                         <td>". $result['payment_notes']. "</td>";
                                }

                                echo "<td>
                                    <img src='$image_src' alt='No image' style='width:100px; height:100px; object-fit:cover; border-radius:4px; border:1px solid #ccc;'>
                                 </td>";

                                if($isAdmin) {
                                   echo "<td>". $result['created_at']. "</td>"; 
                                   echo "<td class='action-buttons'>
                                     <a href='show-std-fee.php?edit_id=" . $result['fee_id'] . "' class='btn-edit'><i class='fa-solid fa-pen-to-square'></i></a>
                                      <a href='show-std-fee.php?delete_id=" . $result['fee_id'] . "&csrf_token=" . urlencode($csrf_token) . "' class='btn-delete' onclick='return confirm(\"Delete Fee Record?\")'><i class='fa-solid fa-trash'></i></a>
                                </td>";
                                }

                                echo "</tr>";
                            }
                        }
                    }
                    else{
                        // Colspan adjust kiya 
                        $colspan = $isAdmin ? 19 : 9;
                        echo"<tr><td colspan='$colspan' style='text-align:center;'>No Records Found</td></tr>";
                    }
                    ?>    
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </body>
</html>
