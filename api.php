<?php
require_once 'config.php';
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}
$action = $_GET['action'] ?? $_POST['action'] ?? '';
$response = ['success' => false, 'message' => 'Неизвестное действие'];
try {
    switch ($action) {
        case 'register':
            $response = handleRegistration();
            break;
        case 'getParticipants':
            $response = getParticipantsCount();
            break;
        case 'suggestMod':
            $response = handleModSuggestion();
            break;
                 // getMods удален - больше не нужен
        case 'getSettings':
            $response = getSettings();
            break;
        case 'getCountdown':
            $response = getCountdownData();
            break;
        case 'getServerInfo':
            $response = getServerInfo();
            break;
        default:
            $response = ['success' => false, 'message' => 'Действие не найдено'];
    }
} catch (Exception $e) {
    logAction("API Error: " . $e->getMessage());
    $response = ['success' => false, 'message' => 'Произошла ошибка'];
}
echo json_encode($response, JSON_UNESCAPED_UNICODE);
function handleRegistration() {
    $nickname = cleanInput($_POST['nickname'] ?? '');
    $telegram = cleanInput($_POST['telegram'] ?? '');
    $ip = getUserIP();
    if (empty($nickname) || empty($telegram)) {
        return ['success' => false, 'message' => 'Заполните все поля'];
    }
    if (strlen($nickname) < 3 || strlen($nickname) > 16) {
        return ['success' => false, 'message' => 'Никнейм должен быть от 3 до 16 символов'];
    }
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $nickname)) {
        return ['success' => false, 'message' => 'Никнейм может содержать только латинские буквы, цифры и _'];
    }
    $db = getDatabase();
    if (!$db) {
        return ['success' => false, 'message' => 'Ошибка подключения к базе данных'];
    }
    try {
        $stmt = $db->prepare("SELECT id FROM users WHERE nickname = ? OR telegram = ? OR ip_address = ?");
        $stmt->execute([$nickname, $telegram, $ip]);
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'Пользователь уже зарегистрирован'];
        }
        $stmt = $db->prepare("INSERT INTO users (nickname, telegram, ip_address, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$nickname, $telegram, $ip]);
        logAction("New registration: $nickname ($telegram) from $ip");
        return ['success' => true, 'message' => 'Регистрация успешна! Добро пожаловать на сервер!'];
    } catch (PDOException $e) {
        logAction("Registration error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Ошибка регистрации'];
    }
}
function getParticipantsCount() {
    $db = getDatabase();
    if (!$db) {
        return ['success' => false, 'count' => 0];
    }
    try {
        $stmt = $db->query("SELECT COUNT(*) as count FROM users");
        $result = $stmt->fetch();
        return ['success' => true, 'count' => (int)$result['count']];
    } catch (PDOException $e) {
        return ['success' => false, 'count' => 0];
    }
}
function handleModSuggestion() {
    try {
        $pdo = new PDO(
            "mysql:host=localhost;dbname=u3212739_minecraftbattle;charset=utf8mb4",
            "u3212739_minecraftbattle",
            "u3212739_minecraftbattle"
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $mod_name = trim($_POST['mod_name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        logAction("MOD SUGGESTION: mod_name='$mod_name', description='$description', ip='$ip'");
        if (empty($mod_name)) {
            return ['success' => false, 'message' => 'Введите название мода'];
        }
        $stmt = $pdo->prepare("SELECT id FROM mod_suggestions WHERE ip_address = ?");
        $stmt->execute([$ip]);
        if ($stmt->fetch()) {
            return ['success' => false, 'message' => 'Вы уже отправили предложение мода. Одно предложение с IP адреса.'];
        }
        $stmt = $pdo->prepare("INSERT INTO mod_suggestions (mod_name, description, ip_address, created_at) VALUES (?, ?, ?, NOW())");
        $result = $stmt->execute([$mod_name, $description, $ip]);
        $insertId = $pdo->lastInsertId();
        logAction("MOD SUGGESTION SUCCESS: ID=$insertId, mod='$mod_name', ip='$ip'");
        return ['success' => true, 'message' => 'Предложение отправлено! Спасибо за участие!'];
    } catch (Exception $e) {
        logAction("MOD SUGGESTION ERROR: " . $e->getMessage());
        return ['success' => false, 'message' => 'Ошибка отправки: ' . $e->getMessage()];
    }
}
function getSettings() {
    $db = getDatabase();
    if (!$db) {
        return ['success' => false, 'settings' => []];
    }
    try {
        $stmt = $db->query("SELECT setting_key, setting_value FROM site_settings");
        $settings = [];
        while ($row = $stmt->fetch()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return ['success' => true, 'settings' => $settings];
    } catch (PDOException $e) {
        return ['success' => false, 'settings' => []];
    }
}
function getCountdownData() {
    $db = getDatabase();
    if (!$db) {
        $default_end = date('Y-m-d\TH:i:s', strtotime('+1 week'));
        return [
            'success' => true, 
            'countdown_end' => $default_end,
            'timestamp' => strtotime($default_end) * 1000 
        ];
    }
    try {
        $stmt = $db->prepare("SELECT setting_value FROM site_settings WHERE setting_key = 'countdown_end'");
        $stmt->execute();
        $result = $stmt->fetch();
        if ($result && $result['setting_value']) {
            $countdown_end = $result['setting_value'];
            $timestamp = strtotime($countdown_end) * 1000; 
            return [
                'success' => true,
                'countdown_end' => $countdown_end,
                'timestamp' => $timestamp,
                'formatted' => date('d.m.Y H:i', strtotime($countdown_end))
            ];
        } else {
            $default_end = date('Y-m-d H:i:s', strtotime('+1 week'));
            $stmt = $db->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES ('countdown_end', ?) ON DUPLICATE KEY UPDATE setting_value = ?");
            $stmt->execute([$default_end, $default_end]);
            return [
                'success' => true,
                'countdown_end' => $default_end,
                'timestamp' => strtotime($default_end) * 1000,
                'formatted' => date('d.m.Y H:i', strtotime($default_end))
            ];
        }
    } catch (PDOException $e) {
        logAction("Countdown data error: " . $e->getMessage());
        $default_end = date('Y-m-d\TH:i:s', strtotime('+1 week'));
        return [
            'success' => true,
            'countdown_end' => $default_end,
            'timestamp' => strtotime($default_end) * 1000
        ];
    }
}
function getServerInfo() {
    $db = getDatabase();
    if (!$db) {
        return [
            'success' => true,
            'server_ip' => 'minecraftbattle.ru',
            'server_port' => '25565',
            'minecraft_version' => '1.16.1',
            'max_players' => '100'
        ];
    }
    try {
        $stmt = $db->query("SELECT setting_key, setting_value FROM site_settings WHERE setting_key IN ('server_ip', 'server_port', 'minecraft_version', 'max_players')");
        $settings = [];
        while ($row = $stmt->fetch()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        $defaults = [
            'server_ip' => 'minecraftbattle.ru',
            'server_port' => '25565',
            'minecraft_version' => '1.16.1',
            'max_players' => '100'
        ];
        foreach ($defaults as $key => $default) {
            if (!isset($settings[$key])) {
                $settings[$key] = $default;
            }
        }
        return array_merge(['success' => true], $settings);
    } catch (PDOException $e) {
        logAction("Server info error: " . $e->getMessage());
        return [
            'success' => true,
            'server_ip' => 'minecraftbattle.ru',
            'server_port' => '25565',
            'minecraft_version' => '1.16.1',
            'max_players' => '100'
        ];
    }
}
if ($action === 'getStats' && isset($_GET['admin_key']) && $_GET['admin_key'] === 'admin_stats_key') {
    $db = getDatabase();
    if ($db) {
        try {
            $stats = [];
            $stmt = $db->query("SELECT * FROM site_statistics LIMIT 1");
            $stats = $stmt->fetch() ?: [];
            $stmt = $db->query("
                SELECT DATE(created_at) as date, COUNT(*) as count 
                FROM users 
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                GROUP BY DATE(created_at) 
                ORDER BY date DESC
            ");
            $stats['daily_registrations'] = $stmt->fetchAll();
            $stmt = $db->query("
                SELECT ip_address, COUNT(*) as count 
                FROM users 
                GROUP BY ip_address 
                ORDER BY count DESC 
                LIMIT 10
            ");
            $stats['top_ips'] = $stmt->fetchAll();
            echo json_encode(['success' => true, 'stats' => $stats], JSON_UNESCAPED_UNICODE);
            exit;
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }
}
?>