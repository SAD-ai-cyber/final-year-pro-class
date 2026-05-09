<?php
// Simple Device Management Panel for Admin
// File: AI_Attendance/admin_devices.php

$host = "localhost";
$username = "root";
$password = "";
$database = "project";

$con = new mysqli($host, $username, $password, $database);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Ensure custom_name column exists
$check_col = $con->query("SHOW COLUMNS FROM device_permissions LIKE 'custom_name'");
if ($check_col->num_rows == 0) {
    $con->query("ALTER TABLE device_permissions ADD COLUMN custom_name VARCHAR(100) DEFAULT NULL AFTER ip_address");
}

// Handle Actions (Approve/Block/Delete)
if (isset($_POST['action'])) {
    $id = intval($_POST['id']);
    $action = $_POST['action'];
    
    if ($action === 'approve') {
        $sql = "UPDATE device_permissions SET status = 'allowed' WHERE id = $id";
    } elseif ($action === 'block') {
        $sql = "UPDATE device_permissions SET status = 'blocked' WHERE id = $id";
    } elseif ($action === 'delete') {
        $sql = "DELETE FROM device_permissions WHERE id = $id";
    } elseif ($action === 'update_name') {
        $new_name = $con->real_escape_string($_POST['name']);
        $sql = "UPDATE device_permissions SET custom_name = '$new_name' WHERE id = $id";
    }
    
    if (isset($sql)) {
        $con->query($sql);
    }
}

// Fetch Devices
$pending_sql = "SELECT * FROM device_permissions WHERE status = 'pending' ORDER BY request_time DESC";
$allowed_sql = "SELECT * FROM device_permissions WHERE status = 'allowed' ORDER BY last_accessed DESC";
$blocked_sql = "SELECT * FROM device_permissions WHERE status = 'blocked' ORDER BY last_accessed DESC";

$pending_result = $con->query($pending_sql);
$allowed_result = $con->query($allowed_sql);
$blocked_result = $con->query($blocked_sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Attendance Devices</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/responsive-core.css?v=<?php echo time(); ?>">
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f8f9fa; padding: 20px; margin: 0; }
        .container { width: 100%; max-width: 1000px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h2 { border-bottom: 2px solid #eee; padding-bottom: 10px; color: #333; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f1f3f5; color: #555; }
        
        .status { font-weight: bold; padding: 5px 10px; border-radius: 4px; font-size: 12px; text-transform: uppercase; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-allowed { background: #d4edda; color: #155724; }
        .status-blocked { background: #f8d7da; color: #721c24; }
        
        .btn { padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; color: white; font-weight: 500; margin-right: 5px; }
        .btn-approve { background: #28a745; }
        .btn-block { background: #dc3545; }
        .btn-delete { background: #6c757d; }
        .btn:hover { opacity: 0.9; }

        .section { margin-bottom: 30px; }
        .empty-msg { color: #888; font-style: italic; padding: 10px; text-align: center; background: #fafafa; border-radius: 5px; }
        .ip-badge { background: #e9ecef; padding: 2px 6px; border-radius: 4px; font-family: monospace; font-size: 12px; color: #444; border: 1px solid #ddd; }
    </style>
</head>
<body>

<div class="container">
    <h2><i class="fas fa-desktop"></i> Manage Authorized Devices</h2>
    <p>Approve devices that are allowed to mark attendance.</p>
    
    <!-- Pending Requests -->
    <div class="section">
        <h3 style="color: #fd7e14;"><i class="fas fa-clock"></i> Pending Requests</h3>
        <?php if ($pending_result->num_rows > 0): ?>
            <div class="table-responsive">
                <table>
                <thead>
                    <tr>
                        <th>Access Request Time</th>
                        <th>Device IP</th>
                        <th>PC Name</th>
                        <th>Device Name (User Agent)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $pending_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['request_time']; ?></td>
                            <td>
                                <strong><?php echo $row['ip_address']; ?></strong>

                            </td>
                            <td style="color:#333;">
                                <strong id="name-<?php echo $row['id']; ?>"><?php echo $row['custom_name'] ?: gethostbyaddr($row['ip_address']); ?></strong>
                                <a href="javascript:void(0)" onclick="editName(<?php echo $row['id']; ?>)" style="margin-left:5px; color:#007bff; font-size:12px;"><i class="fas fa-edit"></i></a>
                            </td>
                            <td style="font-size:12px; color:#666;"><?php echo substr($row['device_name'], 0, 50) . '...'; ?></td>
                            <td>
                                <form method="POST" style="display:inline-block;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="action" value="approve" class="btn btn-approve"><i class="fas fa-check"></i> Allow</button>
                                    <button type="submit" name="action" value="block" class="btn btn-block"><i class="fas fa-ban"></i> Block</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <div class="empty-msg">No new device requests pending.</div>
        <?php endif; ?>
    </div>

    <!-- Allowed Devices -->
    <div class="section">
        <h3 style="color: #28a745;"><i class="fas fa-check-circle"></i> Allowed Devices</h3>
        <?php if ($allowed_result->num_rows > 0): ?>
            <div class="table-responsive">
                <table>
                <thead>
                    <tr>
                        <th>Last Active</th>
                        <th>Device IP</th>
                        <th>PC Name</th>
                        <th>Device Name</th>
                        <th>Settings</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $allowed_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['last_accessed']; ?></td>
                            <td>
                                <strong><?php echo $row['ip_address']; ?></strong>

                            </td>
                            <td style="color:#333;">
                                <strong id="name-<?php echo $row['id']; ?>"><?php echo $row['custom_name'] ?: gethostbyaddr($row['ip_address']); ?></strong>
                                <a href="javascript:void(0)" onclick="editName(<?php echo $row['id']; ?>)" style="margin-left:5px; color:#007bff; font-size:12px;"><i class="fas fa-edit"></i></a>
                            </td>
                            <td style="font-size:12px; color:#666;"><?php echo substr($row['device_name'], 0, 50) . '...'; ?></td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="action" value="block" class="btn btn-block" style="font-size:11px;">Revoke Access</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
            <div class="empty-msg">No devices authorized yet.</div>
        <?php endif; ?>
    </div>

    <!-- Blocked Devices -->
    <?php if ($blocked_result->num_rows > 0): ?>
    <div class="section" style="opacity: 0.7;">
        <h3 style="color: #dc3545;"><i class="fas fa-ban"></i> Blocked Devices</h3>
        <div class="table-responsive">
            <table>
            <thead>
                <tr>
                    <th>Device IP</th>
                    <th>PC Name</th>
                    <th>Device Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $blocked_result->fetch_assoc()): ?>
                    <tr>
                        <td><strong><?php echo $row['ip_address']; ?></strong></td>
                        <td style="color:#333;">
                            <strong id="name-<?php echo $row['id']; ?>"><?php echo $row['custom_name'] ?: gethostbyaddr($row['ip_address']); ?></strong>
                            <a href="javascript:void(0)" onclick="editName(<?php echo $row['id']; ?>)" style="margin-left:5px; color:#007bff; font-size:12px;"><i class="fas fa-edit"></i></a>
                        </td>
                        <td><?php echo substr($row['device_name'], 0, 40); ?></td>
                        <td>
                            <form method="POST" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="action" value="approve" class="btn btn-approve" style="font-size:11px;">Unblock</button>
                                <button type="submit" name="action" value="delete" class="btn btn-delete" style="font-size:11px;">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

</div>

<form id="editForm" method="POST" style="display:none;">
    <input type="hidden" name="id" id="editId">
    <input type="hidden" name="name" id="editNameVal">
    <input type="hidden" name="action" value="update_name">
</form>

<script>
function editName(id) {
    var currentName = document.getElementById('name-' + id).innerText;
    var newName = prompt("Enter Custom PC Name:", currentName);
    if (newName !== null && newName.trim() !== "") {
        document.getElementById('editId').value = id;
        document.getElementById('editNameVal').value = newName;
        document.getElementById('editForm').submit();
    }
}
</script>

</body>
</html>
