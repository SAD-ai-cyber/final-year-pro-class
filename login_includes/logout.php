<?php
require '../includes/security.php';

// Start session safely before destroying it
start_secure_session();
// Apply security headers for this request.
send_security_headers();

session_unset();
session_destroy();
header('location: ../index.php');
?>
