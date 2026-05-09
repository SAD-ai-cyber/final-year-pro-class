<?php
require '../includes/security.php';
require '../includes/config.php';
require '../includes/notification_helper.php';

// Start secure session and headers
start_secure_session();
// Apply security headers for this request.
send_security_headers();
$csrf_token = csrf_token();

function formatExtraFieldLabel($label)
{
    $label = trim($label);
    if ($label === '') {
        return $label;
    }
    $label = str_replace(['_', '-'], ' ', $label);
    $label = preg_replace('/\s+/', ' ', $label);
    return 'Extra: ' . ucwords($label);
}

[$fields_table, $values_table, $id_field] = ensure_extra_tables($con, 'parent');
$extra_fields = [];
$extra_field_query = mysqli_query($con, "SELECT field_id, field_label FROM {$fields_table} ORDER BY field_label ASC");
if ($extra_field_query) {
    while ($row = mysqli_fetch_assoc($extra_field_query)) {
        $extra_fields[] = $row;
    }
}

//  DELETE LOGIC
if (isset($_GET['delete_id'])) {
    $token = $_GET['csrf_token'] ?? '';
    if (!verify_csrf_token($token)) {
        die('Invalid request.');
    }
    $id = (int) $_GET['delete_id'];
    $parent_name = '';
    $parent_email = '';
    $stmt = $con->prepare('SELECT parent_name, parent_email FROM add_parents WHERE parent_id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && ($row = $res->fetch_assoc())) {
            $parent_name = $row['parent_name'] ?? '';
            $parent_email = $row['parent_email'] ?? '';
        }
        $stmt->close();
    }

    deleteLatestNotificationForUser(
        $con,
        'parent',
        $id,
        'Welcome',
        'Your parent account has been created successfully.',
        'dashboard/parent-dashboard.php'
    );

    if ($parent_name !== '' && $parent_email !== '') {
        $admin_title = 'New Parent Added';
        $admin_message = "Parent: {$parent_name} ({$parent_email})";
        deleteNotificationsByContent($con, $admin_title, $admin_message, 'show-details/show-parent.php');
    }
    $stmt = $con->prepare("DELETE FROM {$values_table} WHERE {$id_field} = ?");
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }
    $stmt = $con->prepare('DELETE FROM add_parents WHERE parent_id = ?');
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: show-parent.php");
}

//  UPDATE LOGIC 
if (isset($_POST['save_btn'])) {
    require_post_csrf();
    $id = (int) $_POST['id'];
    $p_name = $_POST['pname'];
    $p_email = $_POST['pemail'];
    $p_num = $_POST['pnum'];
   

    $stmt = $con->prepare('UPDATE add_parents SET parent_name = ?, parent_email = ?, parent_num = ? WHERE parent_id = ?');
    if ($stmt) {
        $stmt->bind_param('sssi', $p_name, $p_email, $p_num, $id);
        $stmt->execute();
        $stmt->close();
    }

    $stmt = $con->prepare("DELETE FROM {$values_table} WHERE {$id_field} = ?");
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

    if (!empty($_POST['extra_fields']) && is_array($_POST['extra_fields'])) {
        $insert_stmt = $con->prepare("INSERT INTO {$values_table} ({$id_field}, field_id, field_value) VALUES (?, ?, ?)");
        if ($insert_stmt) {
            foreach ($_POST['extra_fields'] as $field_id => $field_value) {
                $field_id = (int) $field_id;
                $field_value = trim($field_value);
                if ($field_id > 0 && $field_value !== '') {
                    $insert_stmt->bind_param('iis', $id, $field_id, $field_value);
                    $insert_stmt->execute();
                }
            }
            $insert_stmt->close();
        }
    }
    header("Location: show-parent.php");
}

// --- FETCH DATA ---
$data = mysqli_query($con, 'SELECT * FROM add_parents');
$total = mysqli_num_rows($data);
?>

<html>
<head>
    <title>Parent Details</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    

    <!--  php echo time();  har second URL ko badal deta hai-->
     <link rel="stylesheet" href="../css/details/parent.css?v=<?php echo time(); ?>">

    <style>
        .pass-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .pass-wrapper input {
            border: 1px solid #ddd;
            padding: 5px;
            border-radius: 4px;
            width: 100px;
        }
        .pass-wrapper i {
            margin-left: -25px;
            cursor: pointer;
            color: #555;
            z-index: 10;
        }
    </style>
</head>

<body class="fixed-scroll-page">
    <div class="card fixed-scroll-card">
        <div class="card-header fixed-scroll-header">
            <h2 class="card-title">All Parents Details</h2>
        </div>

        <form action="" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
            <div class="card-body">
                <table class="details-table">
                    <thead>
                        <tr>
                            <th>Parent ID</th>
                            <th>Parent Name</th>
                            <th>Parent Email </th>
                            <th> Mobile Number </th>
                            <?php foreach ($extra_fields as $field) { ?>
                                <th><?php echo htmlspecialchars(formatExtraFieldLabel($field['field_label'])); ?></th>
                            <?php } ?>
                            <th>Photo</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
            <?php
            if ($total > 0) {
                while ($result = mysqli_fetch_assoc($data)) {
                    
                    $image_src = "../material_upload/parent_photo/" . $result['photo'];

                    $extra_values = [];
                    if (!empty($extra_fields)) {
                        $extra_stmt = $con->prepare("SELECT field_id, field_value FROM {$values_table} WHERE {$id_field} = ?");
                        if ($extra_stmt) {
                            $parent_id = (int) $result['parent_id'];
                            $extra_stmt->bind_param('i', $parent_id);
                            $extra_stmt->execute();
                            $extra_res = $extra_stmt->get_result();
                            if ($extra_res) {
                                while ($ev = $extra_res->fetch_assoc()) {
                                    $extra_values[(int) $ev['field_id']] = $ev['field_value'];
                                }
                            }
                            $extra_stmt->close();
                        }
                    }
                 
// Handle GET query action.
                    if (isset($_GET['edit_id']) && $_GET['edit_id'] == $result['parent_id']) {
                        $extra_cells = '';
                        if (!empty($extra_fields)) {
                            foreach ($extra_fields as $field) {
                                $field_id = (int) $field['field_id'];
                                $value = isset($extra_values[$field_id]) ? htmlspecialchars($extra_values[$field_id]) : '';
                                $extra_cells .= "<td><input type='text' name='extra_fields[{$field_id}]' value='{$value}'></td>";
                            }
                        }
                      
                    //   edit karne vala code
                        echo "<tr>
                            <td>" . $result['parent_id'] . "<input type='hidden' name='id' value='" . $result['parent_id'] . "'></td>
                            
                            <td><input type='text' name='pname' value='" . $result['parent_name'] . "'></td>
                            <td><input type='email' name='pemail' value='" . $result['parent_email'] . "'></td>
                             <td> <input type='tel' name='pnum' maxlength='10' value='" . $result['parent_num'] . "'></td>
                            {$extra_cells}
                            <td>
                                <img src='$image_src' alt='parent Img' style='width:100px; height:100px; object-fit:cover; border-radius:4px;'>
                            </td>

                            <td>" . $result['created_at'] . "</td>
                            
                            <td class='action-buttons'>
                                <button type='submit' name='save_btn'><i class='fa-solid fa-check'></i></button>
                                <a href='show-parent.php' class='btn-cancel'><i class='fa-solid fa-xmark'></i></a>
                            </td>
                        </tr>";

                    } else {
                        $extra_cells = '';
                        if (!empty($extra_fields)) {
                            foreach ($extra_fields as $field) {
                                $field_id = (int) $field['field_id'];
                                $value = isset($extra_values[$field_id]) ? htmlspecialchars($extra_values[$field_id]) : '-';
                                $extra_cells .= "<td>{$value}</td>";
                            }
                        }
                        echo "<tr>
                           
                             <td>" . $result['parent_id'] . "</td>
                            <td>" . $result['parent_name'] . "</td>
                            <td>" . $result['parent_email'] . "</td>
                            <td>" . $result['parent_num'] . "</td>
                            {$extra_cells}
                            
                            <td>
                                <img src='$image_src' alt='No Image' style='width:100px; height:100px; object-fit:cover; border-radius:4px; border:1px solid #ccc;'>
                            </td>

                             <td>" . $result['created_at'] . "</td>
                            <td class='action-buttons'>
                                <a href='show-parent.php?edit_id=" . $result['parent_id'] . "' class='btn-edit'><i class='fa-solid fa-pen-to-square'></i></a>
                                <a href='show-parent.php?delete_id=" . $result['parent_id'] . "&csrf_token=" . urlencode($csrf_token) . "' class='btn-delete' onclick='return confirm(\"Delete Parent?\")'><i class='fa-solid fa-trash'></i></a>
                            </td>
                        </tr>";
                    }
                }
            } else {
                $colspan = 7 + count($extra_fields);
                echo "<tr><td colspan='" . $colspan . "' style='text-align:center;'>No Parents Found</td></tr>";
            }
            ?>
                    </tbody>
                </table>
            </div> 
        </form> 
    </div>

  
</body>
</html>
