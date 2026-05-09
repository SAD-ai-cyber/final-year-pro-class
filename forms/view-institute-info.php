<?php
require '../includes/security.php';
require '../includes/config.php';

start_secure_session();
send_security_headers();
require_role('admin');

// Fetch institute basic information
$query = mysqli_query($con, "SELECT * FROM institute_basic_info LIMIT 1");
$data = mysqli_num_rows($query) > 0 ? mysqli_fetch_assoc($query) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Institute Information</title>
    <link rel="stylesheet" href="../css/view-layout.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="fixed-scroll-page">
    <div class="card fixed-scroll-card">
        <div class="card-header fixed-scroll-header">
            <h2 class="card-title">Computer Institute Basic Information</h2>
        </div>

        <div class="card-body">
            <?php if ($data): ?>
                <table class="details-table">
                    <thead>
                        <tr>
                            <th style="width: 30%;">Field</th>
                            <th>Information</th>
                            <th style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Institute Name</strong></td>
                            <td><?php echo htmlspecialchars($data['institute_name']); ?></td>
                            <td rowspan="15" class="action-buttons" style="vertical-align: middle; text-align: center;">
                                <a href="institute-basic-info.php" class="btn-edit" title="Edit Information">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <button onclick="window.print()" class="btn-save" title="Print" style="border-radius: 50%;">
                                    <i class="fa-solid fa-print"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Institute Code</strong></td>
                            <td><?php echo htmlspecialchars($data['institute_code']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Director/Owner Name</strong></td>
                            <td><?php echo htmlspecialchars($data['director_name']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Established Year</strong></td>
                            <td><?php echo htmlspecialchars($data['established_year']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Email Address</strong></td>
                            <td>
                                <a href="mailto:<?php echo htmlspecialchars($data['institute_email']); ?>" 
                                   style="color: #4361ee; text-decoration: none;">
                                    <?php echo htmlspecialchars($data['institute_email']); ?>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Phone Number</strong></td>
                            <td>
                                <a href="tel:<?php echo htmlspecialchars($data['institute_phone']); ?>" 
                                   style="color: #4361ee; text-decoration: none;">
                                    <?php echo htmlspecialchars($data['institute_phone']); ?>
                                </a>
                            </td>
                        </tr>
                        <?php if (!empty($data['institute_website'])): ?>
                        <tr>
                            <td><strong>Website URL</strong></td>
                            <td>
                                <a href="<?php echo htmlspecialchars($data['institute_website']); ?>" 
                                   target="_blank" 
                                   style="color: #4361ee; text-decoration: none;">
                                    <?php echo htmlspecialchars($data['institute_website']); ?>
                                </a>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td><strong>Street Address</strong></td>
                            <td><?php echo nl2br(htmlspecialchars($data['institute_address'])); ?></td>
                        </tr>
                        <tr>
                            <td><strong>City</strong></td>
                            <td><?php echo htmlspecialchars($data['institute_city']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>State</strong></td>
                            <td><?php echo htmlspecialchars($data['institute_state']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>PIN Code</strong></td>
                            <td><?php echo htmlspecialchars($data['institute_pincode']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Registration Authority</strong></td>
                            <td><?php echo htmlspecialchars($data['registration_authority']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Registration Number</strong></td>
                            <td><?php echo htmlspecialchars($data['registration_number']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Courses Offered</strong></td>
                            <td><?php echo nl2br(htmlspecialchars($data['courses_offered'])); ?></td>
                        </tr>
                        <?php if (isset($data['updated_at']) && !empty($data['updated_at'])): ?>
                        <tr>
                            <td><strong>Last Updated</strong></td>
                            <td><?php echo date('F d, Y \a\t h:i A', strtotime($data['updated_at'])); ?></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-records">
                    <i class="fa-solid fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 15px;"></i>
                    <h3>No Information Available</h3>
                    <p>Institute basic information has not been added yet.</p>
                    <a href="institute-basic-info.php" class="btn-edit" style="display: inline-block; padding: 12px 25px; border-radius: 8px; margin-top: 15px; width: auto; height: auto;">
                        <i class="fa-solid fa-plus"></i> Add Basic Information
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
