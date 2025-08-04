<?php
error_reporting(0);
ini_set('display_errors', 0);
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
$blocked_agents = ['bot', 'crawler', 'spider', 'scraper'];
foreach ($blocked_agents as $agent) {
    if (stripos($user_agent, $agent) !== false) {
        if (!stripos($user_agent, 'googlebot') && !stripos($user_agent, 'bingbot')) {
            http_response_code(403);
            exit('Access denied');
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $referer = $_SERVER['HTTP_REFERER'] ?? '';
    $host = $_SERVER['HTTP_HOST'] ?? '';
    if (!empty($referer) && !stripos($referer, $host)) {
        http_response_code(403);
        exit('Invalid referer');
    }
}
$ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
$temp_dir = __DIR__ . '/temp';
if (!is_dir($temp_dir)) {
    mkdir($temp_dir, 0755, true);
}
$rate_file = $temp_dir . '/rate_' . md5($ip) . '.txt';
$current_time = time();
$max_requests = 100; 
$time_window = 60; 
if (file_exists($rate_file)) {
    $requests = json_decode(file_get_contents($rate_file), true) ?: [];
    $requests = array_filter($requests, function($timestamp) use ($current_time, $time_window) {
        return ($current_time - $timestamp) < $time_window;
    });
    if (count($requests) >= $max_requests) {
        http_response_code(429);
        exit('Too many requests');
    }
    $requests[] = $current_time;
} else {
    $requests = [$current_time];
}
file_put_contents($rate_file, json_encode($requests), LOCK_EX);
?>