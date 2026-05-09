<?php
require '../includes/security.php';
require '../includes/config.php';

// Start secure session and token for forms
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Parents</title>
    <link rel="stylesheet" href="../css/forms/teacher-form.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/responsive-core.css?v=<?php echo time(); ?>">
</head>

<body>
    <?php if (!empty($_SESSION['import_message'])) { ?>
        <script>
            alert("<?php echo addslashes($_SESSION['import_message']); ?>");
            if (window.location.search.indexOf('import=1') !== -1) {
                window.history.replaceState({}, document.title, window.location.pathname);
                window.location.replace(window.location.pathname);
            }
        </script>
        <?php unset($_SESSION['import_message']); ?>
    <?php } ?>
    <div class="page-container flex-stack" style="padding: 20px;">
        <!-- Left: Add Parent Form -->
        <div class="form-container" style="flex: 2;">
            <h2>Add Parent</h2>
            <form id="add-parent-form" action="../includes/parent_add.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

                <div class="form-row">
                    <div class="form-group">
                        <label for="add-parent-name">Parent's Name *</label>
                        <input type="text" id="add-parent-name" name="parent_name" placeholder="Enter full name" required>
                    </div>
                    <div class="form-group">
                        <label for="add-email">Email *</label>
                        <input type="email" id="add-email" name="parent_email" placeholder="Enter email address" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="add-mobile">Mobile Number *</label>
                        <input type="tel" id="add-mobile" name="mobile_number" placeholder="Enter 10-digit mobile number" maxlength="10" required>
                    </div>
                </div>

                <p style="color:#666; margin: 5px 0 15px;">Password auto-generate hoga, aapko manual dalna nahi padega.</p>

                <h3 style="color: #333; margin-top: 20px; border-bottom: 2px solid #4e73df; padding-bottom: 10px;">Extra Fields</h3>
                <?php if (!empty($extra_fields)) { ?>
                    <?php foreach ($extra_fields as $field) { ?>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="extra-field-<?php echo (int)$field['field_id']; ?>"><?php echo htmlspecialchars(formatExtraFieldLabel($field['field_label'])); ?></label>
                                <input type="text" id="extra-field-<?php echo (int)$field['field_id']; ?>" name="extra_fields[<?php echo (int)$field['field_id']; ?>]" placeholder="Enter <?php echo htmlspecialchars(formatExtraFieldLabel($field['field_label'])); ?>">
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p style="color:#666;">Abhi koi extra field nahi hai. CSV import ke time pe auto add ho jayega.</p>
                <?php } ?>

                <div class="form-group">
                    <label for="parent-photo">Upload Photo *</label>
                    <input type="file" id="parent-photo" name="parent_photo" accept="image/*" required>
                </div>

                <div class="button-container">
                    <button type="submit" name="Add_parent" class="btn btn-add">Add Parent</button>
                </div>
            </form>
        </div>

        <!-- Right: Import and Remove Forms -->
        <div class="right-column" style="flex: 1; display: flex; flex-direction: column; gap: 32px;">
            <!-- Import Parents (CSV/XLSX) -->
            <div class="form-container">
                <h2>Import Parents (CSV/XLSX)</h2>
                <form action="../includes/parent_add.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="parent-csv">Upload File *</label>
                            <input type="file" id="parent-csv" name="parent_csv" accept=".csv,.xlsx" required>
                        </div>
                    </div>
                    <div class="button-container">
                        <button type="submit" name="import_parents" class="btn btn-add">Import Parents</button>
                    </div>
                </form>
            </div>
            <!-- Remove Parent -->
            <div class="form-container">
                <h2>Remove Parent</h2>
                <form id="delete-parent-form" action="../includes/parent_add.php" method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="delete-id">Parent ID *</label>
                            <input type="text" id="delete-id" name="parent_id" placeholder="Enter Parent ID" required>
                        </div>
                        <div class="form-group">
                            <label for="delete-name">Parent's Name *</label>
                            <input type="text" id="delete-name" name="parent_name_confirm" placeholder="Enter name to confirm" required>
                        </div>
                    </div>
                    <div class="button-container">
                        <button type="submit" name="Remove_Parent" class="btn btn-remove">Remove Parent</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
