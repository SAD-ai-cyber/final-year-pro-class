<?php
require 'config.php';
require 'security.php';

start_secure_session();
require_role('admin');

// Suppress accidental inline HTML from warnings and ensure clean JSON-only output
if (ob_get_level()) ob_end_clean();
ob_start();

header('Content-Type: application/json');

$sql = "CREATE TABLE IF NOT EXISTS `activity_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT DEFAULT NULL,
    `role` VARCHAR(50) DEFAULT NULL,
    `full_name` VARCHAR(255) DEFAULT NULL,
    `batch` VARCHAR(100) DEFAULT NULL,
    `page_url` VARCHAR(255) DEFAULT NULL,
    `action_type` VARCHAR(50) DEFAULT NULL,
    `element_text` VARCHAR(255) DEFAULT NULL,
    `timestamp` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `ip_address` VARCHAR(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

// If table exists but older schema, try to add missing columns (safe, idempotent)
$alter_changes = [
    "ALTER TABLE activity_logs ADD COLUMN IF NOT EXISTS full_name VARCHAR(255) DEFAULT NULL",
    "ALTER TABLE activity_logs ADD COLUMN IF NOT EXISTS batch VARCHAR(100) DEFAULT NULL"
];
foreach ($alter_changes as $alter_sql) {
    @mysqli_query($con, $alter_sql);
}

if (mysqli_query($con, $sql)) {
    ob_end_clean();
    echo json_encode(['status' => 'ok']);
    exit;
} else {
    $err = mysqli_error($con);
    ob_end_clean();
    echo json_encode(['status' => 'error', 'message' => $err]);
    exit;
}
?>
