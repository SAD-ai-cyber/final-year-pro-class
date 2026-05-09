<?php
// Prevent double-inclusion / redeclaration when the file is required more than once.
if (function_exists('sendStudentCredentialsEmail')) {
    return;
}

function sendStudentCredentialsEmail($toEmail, $studentName, $plainPassword, $studentNum)
{
    $GLOBALS['email_last_error'] = '';
    $logFile = __DIR__ . '/../material_upload/email_debug.log';
    $toEmail = trim($toEmail);
    if ($toEmail === '') {
        return false;
    }

    $baseUrl = isset($GLOBALS['app_base_url']) ? rtrim($GLOBALS['app_base_url'], '/') : '';
    $loginUrl = $baseUrl !== '' ? $baseUrl . '/login.php' : '';

    $subject = 'Student Account Details';
    $message = "Hello {$studentName},\n\n" .
        "Your student account has been created successfully.\n\n" .
        "Login Email: {$toEmail}\n" .
        "Mobile: {$studentNum}\n" .
        "Password: {$plainPassword}\n\n";

    if ($loginUrl !== '') {
        $message .= "Login here: {$loginUrl}\n\n";
    }

    $message .= "Note: You can change your password later if needed.\n" .
        "Please keep this information safe.\n\n" .
        "Thanks.";

    $fromAddress = isset($GLOBALS['email_from_address']) ? $GLOBALS['email_from_address'] : '';
    $fromName = isset($GLOBALS['email_from_name']) ? $GLOBALS['email_from_name'] : '';

    $smtpHost = isset($GLOBALS['smtp_host']) ? $GLOBALS['smtp_host'] : '';
    $smtpUser = isset($GLOBALS['smtp_user']) ? $GLOBALS['smtp_user'] : '';
    $smtpPass = isset($GLOBALS['smtp_pass']) ? $GLOBALS['smtp_pass'] : '';
    $smtpPort = isset($GLOBALS['smtp_port']) ? $GLOBALS['smtp_port'] : 587;
    $smtpSecure = isset($GLOBALS['smtp_secure']) ? $GLOBALS['smtp_secure'] : 'tls';

    if ($smtpHost === '' || $smtpUser === '' || $smtpPass === '') {
        $GLOBALS['email_last_error'] = 'SMTP config missing';
        @file_put_contents($logFile, date('Y-m-d H:i:s') . " SMTP config missing\n", FILE_APPEND);
        return false;
    }

    $autoload_path = __DIR__ . '/../vendor/autoload.php';
    if (file_exists($autoload_path)) {
        require_once $autoload_path;
    } else {
        $phpmailer_base = __DIR__ . '/../includes/third_party/phpmailer/src';
        if (file_exists($phpmailer_base . '/PHPMailer.php')) {
            require_once $phpmailer_base . '/Exception.php';
            require_once $phpmailer_base . '/PHPMailer.php';
            require_once $phpmailer_base . '/SMTP.php';
        }
    }

    if (class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();

            $mail->Host = $smtpHost;
            $mail->SMTPAuth = true;
            $mail->Username = $smtpUser;
            $mail->Password = $smtpPass;
            $mail->SMTPSecure = $smtpSecure;
            $mail->Port = $smtpPort;

            $mail->setFrom($fromAddress !== '' ? $fromAddress : $smtpUser, $fromName !== '' ? $fromName : 'Admin');
            $mail->addAddress($toEmail, $studentName);

            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();
            return true;
        } catch (Exception $e) {
            $GLOBALS['email_last_error'] = $e->getMessage();
            @file_put_contents($logFile, date('Y-m-d H:i:s') . " PHPMailer error: " . $e->getMessage() . "\n", FILE_APPEND);
            return false;
        }
    }

    $result = sendViaSmtpSocket($smtpHost, $smtpPort, $smtpUser, $smtpPass, $fromAddress, $fromName, $toEmail, $subject, $message, $smtpSecure);
    if (!$result && $GLOBALS['email_last_error'] !== '') {
        @file_put_contents($logFile, date('Y-m-d H:i:s') . " SMTP socket error: " . $GLOBALS['email_last_error'] . "\n", FILE_APPEND);
    }
    return $result;
}

function sendRoleCredentialsEmail($toEmail, $displayName, $plainPassword, $userNum, $roleLabel)
{
    $GLOBALS['email_last_error'] = '';
    $logFile = __DIR__ . '/../material_upload/email_debug.log';
    $toEmail = trim($toEmail);
    if ($toEmail === '') {
        return false;
    }

    $baseUrl = isset($GLOBALS['app_base_url']) ? rtrim($GLOBALS['app_base_url'], '/') : '';
    $loginPath = (strtolower($roleLabel) === 'student') ? '/login.php' : '/admin_login.php';
    $loginUrl = $baseUrl !== '' ? $baseUrl . $loginPath : '';

    $subject = $roleLabel . ' Account Details';
    $message = "Hello {$displayName},\n\n" .
        "Your {$roleLabel} account has been created successfully.\n\n" .
        "Login Email: {$toEmail}\n" .
        "Mobile: {$userNum}\n" .
        "Password: {$plainPassword}\n\n";

    if ($loginUrl !== '') {
        $message .= "Login here: {$loginUrl}\n\n";
    }

    $message .= "Note: You can change your password later if needed.\n" .
        "Please keep this information safe.\n\n" .
        "Thanks.";

    $fromAddress = isset($GLOBALS['email_from_address']) ? $GLOBALS['email_from_address'] : '';
    $fromName = isset($GLOBALS['email_from_name']) ? $GLOBALS['email_from_name'] : '';

    $smtpHost = isset($GLOBALS['smtp_host']) ? $GLOBALS['smtp_host'] : '';
    $smtpUser = isset($GLOBALS['smtp_user']) ? $GLOBALS['smtp_user'] : '';
    $smtpPass = isset($GLOBALS['smtp_pass']) ? $GLOBALS['smtp_pass'] : '';
    $smtpPort = isset($GLOBALS['smtp_port']) ? $GLOBALS['smtp_port'] : 587;
    $smtpSecure = isset($GLOBALS['smtp_secure']) ? $GLOBALS['smtp_secure'] : 'tls';

    if ($smtpHost === '' || $smtpUser === '' || $smtpPass === '') {
        $GLOBALS['email_last_error'] = 'SMTP config missing';
        @file_put_contents($logFile, date('Y-m-d H:i:s') . " SMTP config missing\n", FILE_APPEND);
        return false;
    }

    $autoload_path = __DIR__ . '/../vendor/autoload.php';
    if (file_exists($autoload_path)) {
        require_once $autoload_path;
    } else {
        $phpmailer_base = __DIR__ . '/../includes/third_party/phpmailer/src';
        if (file_exists($phpmailer_base . '/PHPMailer.php')) {
            require_once $phpmailer_base . '/Exception.php';
            require_once $phpmailer_base . '/PHPMailer.php';
            require_once $phpmailer_base . '/SMTP.php';
        }
    }

    if (class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();

            $mail->Host = $smtpHost;
            $mail->SMTPAuth = true;
            $mail->Username = $smtpUser;
            $mail->Password = $smtpPass;
            $mail->SMTPSecure = $smtpSecure;
            $mail->Port = $smtpPort;

            $mail->setFrom($fromAddress !== '' ? $fromAddress : $smtpUser, $fromName !== '' ? $fromName : 'Admin');
            $mail->addAddress($toEmail, $displayName);

            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();
            return true;
        } catch (Exception $e) {
            $GLOBALS['email_last_error'] = $e->getMessage();
            @file_put_contents($logFile, date('Y-m-d H:i:s') . " PHPMailer error: " . $e->getMessage() . "\n", FILE_APPEND);
            return false;
        }
    }

    $result = sendViaSmtpSocket($smtpHost, $smtpPort, $smtpUser, $smtpPass, $fromAddress, $fromName, $toEmail, $subject, $message, $smtpSecure);
    if (!$result && $GLOBALS['email_last_error'] !== '') {
        @file_put_contents($logFile, date('Y-m-d H:i:s') . " SMTP socket error: " . $GLOBALS['email_last_error'] . "\n", FILE_APPEND);
    }
    return $result;
}

function sendTeacherCredentialsEmail($toEmail, $teacherName, $plainPassword, $teacherNum)
{
    return sendRoleCredentialsEmail($toEmail, $teacherName, $plainPassword, $teacherNum, 'Teacher');
}

function sendParentCredentialsEmail($toEmail, $parentName, $plainPassword, $parentNum)
{
    return sendRoleCredentialsEmail($toEmail, $parentName, $plainPassword, $parentNum, 'Parent');
}

function sendUserOtpEmail($toEmail, $otp, $roleLabel)
{
    $GLOBALS['email_last_error'] = '';
    $logFile = __DIR__ . '/../material_upload/email_debug.log';
    $toEmail = trim($toEmail);
    if ($toEmail === '') {
        return false;
    }

    $subject = $roleLabel . ' Password Reset OTP';
    $message = "Hello,\n\n" .
        "Your OTP for {$roleLabel} password reset is: {$otp}\n\n" .
        "This OTP will expire in 10 minutes. If you did not request this, please ignore this email.";

    $fromAddress = isset($GLOBALS['email_from_address']) ? $GLOBALS['email_from_address'] : '';
    $fromName = isset($GLOBALS['email_from_name']) ? $GLOBALS['email_from_name'] : '';

    $smtpHost = isset($GLOBALS['smtp_host']) ? $GLOBALS['smtp_host'] : '';
    $smtpUser = isset($GLOBALS['smtp_user']) ? $GLOBALS['smtp_user'] : '';
    $smtpPass = isset($GLOBALS['smtp_pass']) ? $GLOBALS['smtp_pass'] : '';
    $smtpPort = isset($GLOBALS['smtp_port']) ? $GLOBALS['smtp_port'] : 587;
    $smtpSecure = isset($GLOBALS['smtp_secure']) ? $GLOBALS['smtp_secure'] : 'tls';

    if ($smtpHost === '' || $smtpUser === '' || $smtpPass === '') {
        $GLOBALS['email_last_error'] = 'SMTP config missing';
        @file_put_contents($logFile, date('Y-m-d H:i:s') . " SMTP config missing\n", FILE_APPEND);
        return false;
    }

    $autoload_path = __DIR__ . '/../vendor/autoload.php';
    if (file_exists($autoload_path)) {
        require_once $autoload_path;
    } else {
        $phpmailer_base = __DIR__ . '/../includes/third_party/phpmailer/src';
        if (file_exists($phpmailer_base . '/PHPMailer.php')) {
            require_once $phpmailer_base . '/Exception.php';
            require_once $phpmailer_base . '/PHPMailer.php';
            require_once $phpmailer_base . '/SMTP.php';
        }
    }

    if (class_exists('PHPMailer\\PHPMailer\\PHPMailer')) {
        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();

            $mail->Host = $smtpHost;
            $mail->SMTPAuth = true;
            $mail->Username = $smtpUser;
            $mail->Password = $smtpPass;
            $mail->SMTPSecure = $smtpSecure;
            $mail->Port = $smtpPort;

            $mail->setFrom($fromAddress !== '' ? $fromAddress : $smtpUser, $fromName !== '' ? $fromName : 'Admin');
            $mail->addAddress($toEmail);

            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();
            return true;
        } catch (Exception $e) {
            $GLOBALS['email_last_error'] = $e->getMessage();
            @file_put_contents($logFile, date('Y-m-d H:i:s') . " PHPMailer error: " . $e->getMessage() . "\n", FILE_APPEND);
            return false;
        }
    }

    $result = sendViaSmtpSocket($smtpHost, $smtpPort, $smtpUser, $smtpPass, $fromAddress, $fromName, $toEmail, $subject, $message, $smtpSecure);
    if (!$result && $GLOBALS['email_last_error'] !== '') {
        @file_put_contents($logFile, date('Y-m-d H:i:s') . " SMTP socket error: " . $GLOBALS['email_last_error'] . "\n", FILE_APPEND);
    }
    return $result;
}

function sendNotificationEmail($toEmail, $title, $message, $link = '')
{
    // Silenced by user request - only ID/Password and OTP emails allowed.
    return true;
}

function sendViaSmtpSocket($host, $port, $username, $password, $fromAddress, $fromName, $toEmail, $subject, $body, $secure)
{
    $errno = 0;
    $errstr = '';
    $targetHost = (strtolower($secure) === 'ssl') ? 'ssl://' . $host : $host;
    $socket = fsockopen($targetHost, $port, $errno, $errstr, 20);
    if (!$socket) {
        $GLOBALS['email_last_error'] = $errstr;
        return false;
    }

    $write = function ($command) use ($socket) {
        fwrite($socket, $command . "\r\n");
    };

    $readResponse = function () use ($socket) {
        $data = '';
        while ($line = fgets($socket, 512)) {
            $data .= $line;
            if (strlen($line) >= 4 && $line[3] === ' ') {
                break;
            }
        }
        return $data;
    };

    $expectCode = function ($code) use ($readResponse) {
        $resp = $readResponse();
        $actual = (int)substr($resp, 0, 3);
        return [$actual, $resp, $actual === $code];
    };

    $resp = $readResponse();
    if ((int)substr($resp, 0, 3) !== 220) {
        $GLOBALS['email_last_error'] = trim($resp);
        fclose($socket);
        return false;
    }

    $write("EHLO localhost");
    [$code, $raw, $ok] = $expectCode(250);
    if (!$ok) {
        $GLOBALS['email_last_error'] = trim($raw);
        fclose($socket);
        return false;
    }

    if (strtolower($secure) === 'tls') {
        $write("STARTTLS");
        [$code, $raw, $ok] = $expectCode(220);
        if (!$ok) {
            $GLOBALS['email_last_error'] = trim($raw);
            fclose($socket);
            return false;
        }
        if (!stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) {
            $GLOBALS['email_last_error'] = 'TLS failed';
            fclose($socket);
            return false;
        }
        $write("EHLO localhost");
        [$code, $raw, $ok] = $expectCode(250);
        if (!$ok) {
            $GLOBALS['email_last_error'] = trim($raw);
            fclose($socket);
            return false;
        }
    }

    $write("AUTH LOGIN");
    [$code, $raw, $ok] = $expectCode(334);
    if (!$ok) {
        $GLOBALS['email_last_error'] = trim($raw);
        fclose($socket);
        return false;
    }
    $write(base64_encode($username));
    [$code, $raw, $ok] = $expectCode(334);
    if (!$ok) {
        $GLOBALS['email_last_error'] = trim($raw);
        fclose($socket);
        return false;
    }
    $write(base64_encode($password));
    [$code, $raw, $ok] = $expectCode(235);
    if (!$ok) {
        $GLOBALS['email_last_error'] = trim($raw);
        fclose($socket);
        return false;
    }

    $fromHeader = $fromAddress !== '' ? $fromAddress : $username;
    $fromNameHeader = $fromName !== '' ? $fromName : 'Admin';

    $write("MAIL FROM:<{$fromHeader}>");
    [$code, $raw, $ok] = $expectCode(250);
    if (!$ok) {
        $GLOBALS['email_last_error'] = trim($raw);
        fclose($socket);
        return false;
    }
    $write("RCPT TO:<{$toEmail}>");
    [$code, $raw, $ok] = $expectCode(250);
    if (!$ok) {
        $GLOBALS['email_last_error'] = trim($raw);
        fclose($socket);
        return false;
    }
    $write("DATA");
    [$code, $raw, $ok] = $expectCode(354);
    if (!$ok) {
        $GLOBALS['email_last_error'] = trim($raw);
        fclose($socket);
        return false;
    }

    $headers = "From: {$fromNameHeader} <{$fromHeader}>\r\n";
    $headers .= "To: {$toEmail}\r\n";
    $headers .= "Subject: {$subject}\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $message = $headers . "\r\n" . $body . "\r\n.\r\n";
    $write($message);
    [$code, $raw, $ok] = $expectCode(250);
    if (!$ok) {
        $GLOBALS['email_last_error'] = trim($raw);
        fclose($socket);
        return false;
    }

    $write("QUIT");
    fclose($socket);
    return true;
}

?>
