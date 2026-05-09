<?php
require '../includes/security.php';

// Start secure session and token for form
start_secure_session();
// Apply security headers for this request.
send_security_headers();
$csrf_token = csrf_token();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Study Material</title>
    <link rel="stylesheet" href="../css/forms/teacher-form.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/responsive-core.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="form-container">
        <h1>Study Material</h1>

        <form id="study-material-form" method="post" action="../includes/study_mat.php" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8'); ?>">

            <div class="form-group">
                <label for="title">Material Title *</label>
                <input type="text" id="title" name="title" placeholder="e.g., Java Chapter 1, Physics Notes" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" placeholder="Enter a detailed description of the material..."></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="course">For Course *</label>
                    <input type="text" name="course" id="course" placeholder="e.g., B.Tech, Diploma" required>
                </div>
                <div class="form-group">
                    <label for="subject">For Subject / Module *</label>
                    <input type="text" name="subject" id="subject" placeholder="e.g., Java, Physics" required>
                </div>
            </div>

            <div class="form-group">
                <label for="material-type">Material Type *</label>
                <select id="material-type" name="material_type" required onchange="toggleMaterialInput()">
                    <option value="" disabled selected>Select Material Type</option>
                    <option value="pdf">Notes (PDF)</option>
                    <option value="zip">Source Code (ZIP)</option>
                    <option value="video">Video Tutorial</option>
                    <option value="link">External Link</option>
                </select>
            </div>

            <div id="file-upload-group" class="form-group" style="display: none;">
                <label for="material-file">Upload File</label>
                <input type="file" id="material-file" name="material_file">
            </div>

            <div id="link-group" class="form-group" style="display: none;">
                <label for="material-link">URL / Link</label>
                <input type="url" id="material-link" name="material_link" placeholder="https://example.com/tutorial">
            </div>

            <button type="submit" name="upload_material" class="btn btn-add" style="width:100%;">Upload Material</button>
        </form>
    </div>

    <script>
        function toggleMaterialInput() {
            const type = document.getElementById('material-type').value;
            const fileGroup = document.getElementById('file-upload-group');
            const linkGroup = document.getElementById('link-group');

            fileGroup.style.display = (type === 'link') ? 'none' : 'block';
            linkGroup.style.display = (type === 'link') ? 'block' : 'none';
        }
    </script>

</body>

</html>
