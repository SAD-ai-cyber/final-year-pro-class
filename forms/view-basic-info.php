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
    <link rel="stylesheet" href="../css/paper-schedule-view.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="paper-card">
        <div class="paper-header">
            <h1 class="paper-title">Computer Institute Information</h1>
            <p class="paper-subtitle">Complete Institute Details</p>
        </div>

        <?php if ($data): ?>
            <!-- Basic Information Section -->
            <div class="info-section">
                <h2 class="section-title">Basic Information</h2>
                
                <div class="info-row">
                    <div class="info-item">
                        <span class="info-label">Institute Name</span>
                        <span class="info-value highlight"><?php echo htmlspecialchars($data['institute_name']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Institute Code</span>
                        <span class="info-value"><?php echo htmlspecialchars($data['institute_code']); ?></span>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-item">
                        <span class="info-label">Director/Owner Name</span>
                        <span class="info-value"><?php echo htmlspecialchars($data['director_name']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Established Year</span>
                        <span class="info-value"><?php echo htmlspecialchars($data['established_year']); ?></span>
                    </div>
                </div>
            </div>

            <!-- Contact Information Section -->
            <div class="info-section">
                <h2 class="section-title">Contact Information</h2>
                
                <div class="info-row">
                    <div class="info-item">
                        <span class="info-label">Email Address</span>
                        <span class="info-value">
                            <a href="mailto:<?php echo htmlspecialchars($data['institute_email']); ?>" 
                               style="color: #2196f3; text-decoration: none;">
                                <i class="fa-solid fa-envelope"></i> <?php echo htmlspecialchars($data['institute_email']); ?>
                            </a>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Phone Number</span>
                        <span class="info-value">
                            <a href="tel:<?php echo htmlspecialchars($data['institute_phone']); ?>" 
                               style="color: #2196f3; text-decoration: none;">
                                <i class="fa-solid fa-phone"></i> <?php echo htmlspecialchars($data['institute_phone']); ?>
                            </a>
                        </span>
                    </div>
                </div>

                <?php if (!empty($data['institute_website'])): ?>
                <div class="info-row">
                    <div class="info-item">
                        <span class="info-label">Website URL</span>
                        <span class="info-value">
                            <a href="<?php echo htmlspecialchars($data['institute_website']); ?>" 
                               target="_blank" 
                               style="color: #2196f3; text-decoration: none;">
                                <i class="fa-solid fa-globe"></i> <?php echo htmlspecialchars($data['institute_website']); ?>
                            </a>
                        </span>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Address Section -->
            <div class="info-section">
                <h2 class="section-title">Address Details</h2>
                
                <div class="info-full">
                    <div class="info-item">
                        <span class="info-label">Street Address</span>
                        <span class="info-value"><?php echo nl2br(htmlspecialchars($data['institute_address'])); ?></span>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-item">
                        <span class="info-label">City</span>
                        <span class="info-value"><?php echo htmlspecialchars($data['institute_city']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">State</span>
                        <span class="info-value"><?php echo htmlspecialchars($data['institute_state']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">PIN Code</span>
                        <span class="info-value"><?php echo htmlspecialchars($data['institute_pincode']); ?></span>
                    </div>
                </div>
            </div>

            <!-- Registration Details Section -->
            <div class="info-section">
                <h2 class="section-title">Registration Details</h2>
                
                <div class="info-row">
                    <div class="info-item">
                        <span class="info-label">Registration Authority</span>
                        <span class="info-value highlight"><?php echo htmlspecialchars($data['registration_authority']); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Registration Number</span>
                        <span class="info-value"><?php echo htmlspecialchars($data['registration_number']); ?></span>
                    </div>
                </div>
            </div>

            <!-- Courses Offered Section -->
            <div class="info-section">
                <h2 class="section-title">Courses Offered</h2>
                
                <div class="info-full">
                    <div class="info-item">
                        <span class="info-value"><?php echo nl2br(htmlspecialchars($data['courses_offered'])); ?></span>
                    </div>
                </div>
            </div>

            <?php if (isset($data['updated_at']) && !empty($data['updated_at'])): ?>
            <!-- Last Updated -->
            <div class="info-section">
                <div class="info-item">
                    <span class="info-label">Last Updated</span>
                    <span class="info-value">
                        <i class="fa-solid fa-clock"></i> <?php echo date('F d, Y \a\t h:i A', strtotime($data['updated_at'])); ?>
                    </span>
                </div>
            </div>
            <?php endif; ?>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="basic-info.php" class="btn btn-primary">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Information
                </a>
                <button onclick="window.print()" class="btn btn-success">
                    <i class="fa-solid fa-print"></i> Print
                </button>
                <a href="../dashboard/dashboard.php" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>

        <?php else: ?>
            <div class="no-data">
                <i class="fa-solid fa-inbox"></i>
                <h3>No Information Available</h3>
                <p>Institute basic information has not been added yet.</p>
                <div class="action-buttons">
                    <a href="basic-info.php" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Add Basic Information
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
