<?php
error_reporting(0);
ini_set('display_errors', 0);
function generateCSRFToken() {
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
function verifyCSRFToken($token) {
    if (!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
function generateSimpleCaptcha() {
    if (!isset($_SESSION)) {
        session_start();
    }
    $num1 = rand(1, 10);
    $num2 = rand(1, 10);
    $result = $num1 + $num2;
    $_SESSION['captcha_result'] = $result;
    return "$num1 + $num2 = ?";
}
function verifyCaptcha($answer) {
    if (!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['captcha_result']) && (int)$answer === (int)$_SESSION['captcha_result'];
}
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
function isValidMinecraftNickname($nickname) {
    return preg_match('/^[a-zA-Z0-9_]{3,16}$/', $nickname);
}
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}
?>