<?php
date_default_timezone_set('Asia/Kolkata');
$app_env = getenv('APP_ENV') ?: 'development';
if ($app_env === 'production') {
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    error_reporting(0);
} else {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}

$servername = getenv('DB_HOST') ?: 'localhost';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: '';
$dbname = getenv('DB_NAME') ?: 'project';
$dbport = getenv('DB_PORT') ? (int)getenv('DB_PORT') : 3306;

$con = mysqli_connect($servername, $username, $password, $dbname, $dbport);
if (!$con) {
    die("Couldn't Connect Database: " . mysqli_connect_error());
}
mysqli_set_charset($con, "utf8");
mysqli_query($con, "SET time_zone = '+05:30'");

// Email settings (SMTP)
$email_from_address = getenv('APP_EMAIL_FROM') ?: 'abhi142045@gmail.com';
$email_from_name = getenv('APP_EMAIL_NAME') ?: 'Institute Admin';
$smtp_host = getenv('SMTP_HOST') ?: 'smtp.gmail.com';
$smtp_user = getenv('SMTP_USER') ?: 'abhi142045@gmail.com';
$smtp_pass = getenv('SMTP_PASS') ?: 'tpysoomsvirmuzcf';
$smtp_port = getenv('SMTP_PORT') ? (int) getenv('SMTP_PORT') : 587;
$smtp_secure = getenv('SMTP_SECURE') ?: 'tls';

// App base URL (auto-detect for Railway.app or any domain)
$proto = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $proto = 'https';
}
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$default_base_url = "{$proto}://{$host}";
$app_base_url = getenv('APP_BASE_URL') ?: $default_base_url;

// Set GLOBALS for email functions
$GLOBALS['email_from_address'] = $email_from_address;
$GLOBALS['email_from_name'] = $email_from_name;
$GLOBALS['smtp_host'] = $smtp_host;
$GLOBALS['smtp_user'] = $smtp_user;
$GLOBALS['smtp_pass'] = $smtp_pass;
$GLOBALS['smtp_port'] = $smtp_port;
$GLOBALS['smtp_secure'] = $smtp_secure;
$GLOBALS['app_base_url'] = $app_base_url;

// --- GEMINI API KEY ---
define('GEMINI_API_KEY', 'AIzaSyANAHuwSW0zp_VZ0su05Wb5TZfRTIuh_qY');
$GLOBALS['gemini_api_key'] = GEMINI_API_KEY;

?>
