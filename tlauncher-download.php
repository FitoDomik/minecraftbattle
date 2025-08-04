<?php
error_reporting(0);
ini_set('display_errors', 0);
$local_file = __DIR__ . '/TLauncher-Installer.exe';
$filename = 'TLauncher-Installer.exe';
if (!file_exists($local_file)) {
    header('Location: https://tlauncher.org/installer');
    exit;
}
$file_size = filesize($local_file);
$ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
$log_dir = __DIR__ . '/logs';
if (!is_dir($log_dir)) {
    mkdir($log_dir, 0755, true);
}
$log_entry = date('Y-m-d H:i:s') . " - Download: $filename by $ip\n";
file_put_contents($log_dir . '/downloads.log', $log_entry, FILE_APPEND | LOCK_EX);
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . $file_size);
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
if (ob_get_level()) {
    ob_end_clean();
}
readfile($local_file);
exit;
?>