<?php
session_start();
require_once 'config.php';
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
$admin_password = 'Slavik365!';
if (isset($_POST['login'])) {
    if ($_POST['password'] === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Неверный пароль';
    }
}
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}
$is_logged_in = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'];
if (!$is_logged_in) {
    ?>
    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Админ-панель | Minecraft Battle</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: linear-gradient(135deg, #1a1a2e, #16213e);
                color: white;
                margin: 0;
                padding: 20px;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .login-form {
                background: rgba(255,255,255,0.1);
                padding: 30px;
                border-radius: 10px;
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255,255,255,0.2);
                text-align: center;
                max-width: 400px;
                width: 100%;
            }
            h1 { color: #00AA00; margin-bottom: 20px; }
            input[type="password"] {
                width: 100%;
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #ccc;
                border-radius: 5px;
                font-size: 16px;
                box-sizing: border-box;
            }
            button {
                background: #00AA00;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 16px;
            }
            button:hover { background: #007700; }
            .error { color: #ff4444; margin: 10px 0; }
        </style>
    </head>
    <body>
        <div class="login-form">
            <h1>⚡ Админ-панель</h1>
            <?php if (isset($error)): ?>
                <div class="error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="POST">
                <input type="password" name="password" placeholder="Пароль" required>
                <br>
                <button type="submit" name="login">Войти</button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}
$message = '';
$db = getDatabase();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    try {
        switch ($action) {
            case 'delete_user':
                $user_id = (int)$_POST['user_id'];
                $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
                $stmt->execute([$user_id]);
                $message = "Игрок удален успешно!";
                logAction("Admin: Deleted user ID $user_id");
                break;
            case 'edit_user':
                $user_id = (int)$_POST['user_id'];
                $nickname = cleanInput($_POST['nickname']);
                $telegram = cleanInput($_POST['telegram']);
                $stmt = $db->prepare("UPDATE users SET nickname = ?, telegram = ? WHERE id = ?");
                $stmt->execute([$nickname, $telegram, $user_id]);
                $message = "Информация об игроке обновлена!";
                logAction("Admin: Updated user ID $user_id - $nickname ($telegram)");
                break;
            case 'update_countdown':
                $countdown_date = $_POST['countdown_date'];
                $countdown_time = $_POST['countdown_time'] ?? '23:59';
                $full_datetime = $countdown_date . ' ' . $countdown_time . ':59';
                $stmt = $db->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = 'countdown_end'");
                $stmt->execute([$full_datetime]);
                $message = "Дата окончания таймера обновлена!";
                logAction("Admin: Updated countdown to $full_datetime");
                break;
            case 'update_server_info':
                $server_ip = cleanInput($_POST['server_ip']);
                $server_port = cleanInput($_POST['server_port']);
                $minecraft_version = cleanInput($_POST['minecraft_version']);
                $max_players = (int)$_POST['max_players'];
                $settings = [
                    'server_ip' => $server_ip,
                    'server_port' => $server_port,
                    'minecraft_version' => $minecraft_version,
                    'max_players' => $max_players
                ];
                foreach ($settings as $key => $value) {
                    $stmt = $db->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = ?");
                    $stmt->execute([$value, $key]);
                }
                $message = "Информация о сервере обновлена!";
                logAction("Admin: Updated server info - $server_ip:$server_port v$minecraft_version ($max_players players)");
                break;
            case 'clear_suggestions':
                try {
                    $pdo = new PDO(
                        "mysql:host=localhost;dbname=u3212739_minecraftbattle;charset=utf8mb4",
                        "u3212739_minecraftbattle",
                        "u3212739_minecraftbattle"
                    );
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $pdo->query("DELETE FROM mod_suggestions");
                    $message = "Все предложения модов очищены!";
                    logAction("Admin: Cleared all mod suggestions");
                } catch (Exception $e) {
                    $message = "Ошибка очистки: " . $e->getMessage();
                }
                break;
        }
    } catch (Exception $e) {
        $message = "Ошибка: " . $e->getMessage();
        logAction("Admin error: " . $e->getMessage());
    }
}
function getStats() {
    global $db;
    if (!$db) return ['users' => 0, 'suggestions' => 0];
    try {
        $users = $db->query("SELECT COUNT(*) as count FROM users")->fetch()['count'] ?? 0;
        $suggestions = $db->query("SELECT COUNT(*) as count FROM mod_suggestions")->fetch()['count'] ?? 0;
        return ['users' => $users, 'suggestions' => $suggestions];
    } catch (Exception $e) {
        return ['users' => 0, 'suggestions' => 0];
    }
}
function getUsers() {
    global $db;
    if (!$db) return [];
    try {
        $stmt = $db->query("SELECT id, nickname, telegram, ip_address, created_at FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}
function getServerSettings() {
    global $db;
    if (!$db) return [];
    try {
        $stmt = $db->query("SELECT setting_key, setting_value FROM site_settings");
        $settings = [];
        while ($row = $stmt->fetch()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    } catch (Exception $e) {
        return [];
    }
}
function getModSuggestions() {
    try {
        $pdo = new PDO(
            "mysql:host=localhost;dbname=u3212739_minecraftbattle;charset=utf8mb4",
            "u3212739_minecraftbattle",
            "u3212739_minecraftbattle"
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->query("SELECT id, mod_name, description, ip_address, created_at FROM mod_suggestions ORDER BY created_at DESC LIMIT 50");
        return $stmt->fetchAll();
    } catch (Exception $e) {
        error_log("getModSuggestions error: " . $e->getMessage());
        return [];
    }
}
$stats = getStats();
$users = getUsers();
$settings = getServerSettings();
$suggestions = getModSuggestions();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель | Minecraft Battle</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: white;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }
        .container { max-width: 1400px; margin: 0 auto; }
        .header {
            background: rgba(255,255,255,0.1);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        .stat-card {
            background: rgba(0,170,0,0.2);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border: 1px solid rgba(0,170,0,0.3);
        }
        .stat-number { font-size: 2rem; font-weight: bold; color: #00AA00; }
        .stat-label { font-size: 1.1rem; margin-top: 5px; }
        .logout-btn, .btn {
            background: #ff4444;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            display: inline-block;
            margin: 5px;
        }
        .logout-btn:hover { background: #cc0000; }
        .btn-success { background: #00AA00; }
        .btn-success:hover { background: #007700; }
        .btn-warning { background: #ff9800; }
        .btn-warning:hover { background: #e68900; }
        .btn-danger { background: #f44336; }
        .btn-danger:hover { background: #d32f2f; }
        h1 { color: #00AA00; margin: 0; }
        h2 { color: #FFD700; margin-top: 30px; margin-bottom: 15px; }
        .section {
            background: rgba(255,255,255,0.05);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #FFD700;
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #444;
            border-radius: 5px;
            background: rgba(255,255,255,0.1);
            color: white;
            font-size: 14px;
        }
        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #00AA00;
            background: rgba(255,255,255,0.15);
        }
        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: rgba(0,0,0,0.3);
            border-radius: 8px;
            overflow: hidden;
        }
        .table th, .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .table th {
            background: rgba(0,170,0,0.3);
            color: #FFD700;
            font-weight: bold;
        }
        .table tr:hover {
            background: rgba(255,255,255,0.05);
        }
        .message {
            background: rgba(0,170,0,0.2);
            color: #4CAF50;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid rgba(0,170,0,0.3);
        }
        .error {
            background: rgba(244,67,54,0.2);
            color: #f44336;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid rgba(244,67,54,0.3);
        }
        .tabs {
            display: flex;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .tab {
            background: rgba(255,255,255,0.1);
            padding: 10px 20px;
            border-radius: 5px 5px 0 0;
            cursor: pointer;
            margin-right: 5px;
            margin-bottom: 5px;
            border: 1px solid rgba(255,255,255,0.2);
        }
        .tab.active {
            background: rgba(0,170,0,0.3);
            color: #00AA00;
            border-color: rgba(0,170,0,0.5);
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
        .small { font-size: 0.8rem; color: #ccc; }
        .text-center { text-align: center; }
        .mb-20 { margin-bottom: 20px; }
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                text-align: center;
            }
            .form-row {
                grid-template-columns: 1fr;
            }
            .table {
                font-size: 14px;
            }
            .table th, .table td {
                padding: 8px 4px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚡ Админ-панель Minecraft Battle</h1>
            <a href="?logout=1" class="logout-btn">Выйти</a>
        </div>
        <?php if ($message): ?>
            <div class="message">✅ <?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?= $stats['users'] ?></div>
                <div class="stat-label">👥 Зарегистрировано игроков</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $stats['suggestions'] ?></div>
                <div class="stat-label">💡 Предложений модов</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= date('d.m.Y') ?></div>
                <div class="stat-label">📅 Сегодняшняя дата</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $settings['server_ip'] ?? 'minecraftbattle.ru' ?></div>
                <div class="stat-label">🌐 IP сервера</div>
            </div>
        </div>
        <div class="tabs">
            <div class="tab active" onclick="showTab('players')">👥 Игроки</div>
            <div class="tab" onclick="showTab('countdown')">⏰ Таймер</div>
            <div class="tab" onclick="showTab('server')">🎮 Сервер</div>
            <div class="tab" onclick="showTab('suggestions')">💡 Предложения</div>
            <div class="tab" onclick="showTab('logs')">📋 Логи</div>
        </div>
        <!-- Управление игроками -->
        <div id="players" class="tab-content active">
            <div class="section">
                <h2>👥 Управление игроками</h2>
                <?php if (empty($users)): ?>
                    <p class="text-center">Пока нет зарегистрированных игроков</p>
                <?php else: ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Никнейм</th>
                                <th>Telegram</th>
                                <th>IP адрес</th>
                                <th>Дата регистрации</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr id="user-<?= $user['id'] ?>">
                                    <td><?= $user['id'] ?></td>
                                    <td>
                                        <span class="nickname-display"><?= htmlspecialchars($user['nickname']) ?></span>
                                        <input type="text" class="nickname-edit" value="<?= htmlspecialchars($user['nickname']) ?>" style="display:none;">
                                    </td>
                                    <td>
                                        <span class="telegram-display"><?= htmlspecialchars($user['telegram']) ?></span>
                                        <input type="text" class="telegram-edit" value="<?= htmlspecialchars($user['telegram']) ?>" style="display:none;">
                                    </td>
                                    <td class="small"><?= htmlspecialchars($user['ip_address']) ?></td>
                                    <td class="small"><?= date('d.m.Y H:i', strtotime($user['created_at'])) ?></td>
                                    <td>
                                        <button class="btn btn-warning btn-edit" onclick="editUser(<?= $user['id'] ?>)">✏️</button>
                                        <button class="btn btn-success btn-save" onclick="saveUser(<?= $user['id'] ?>)" style="display:none;">💾</button>
                                        <button class="btn btn-danger" onclick="deleteUser(<?= $user['id'] ?>, '<?= htmlspecialchars($user['nickname']) ?>')">🗑️</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
        <!-- Управление таймером -->
        <div id="countdown" class="tab-content">
            <div class="section">
                <h2>⏰ Управление таймером обратного отсчета</h2>
                <form method="POST">
                    <input type="hidden" name="action" value="update_countdown">
                    <div class="form-row">
                        <div class="form-group">
                            <label>📅 Дата окончания:</label>
                            <input type="date" name="countdown_date" value="<?= date('Y-m-d', strtotime($settings['countdown_end'] ?? '+1 week')) ?>" required>
                        </div>
                        <div class="form-group">
                            <label>🕐 Время окончания:</label>
                            <input type="time" name="countdown_time" value="<?= date('H:i', strtotime($settings['countdown_end'] ?? '23:59')) ?>" required>
                        </div>
                    </div>
                    <p class="small">
                        <strong>Текущая дата окончания:</strong> 
                        <?= date('d.m.Y H:i', strtotime($settings['countdown_end'] ?? 'now')) ?>
                    </p>
                    <button type="submit" class="btn btn-success">💾 Обновить таймер</button>
                </form>
            </div>
        </div>
        <!-- Управление сервером -->
        <div id="server" class="tab-content">
            <div class="section">
                <h2>🎮 Настройки сервера</h2>
                <form method="POST">
                    <input type="hidden" name="action" value="update_server_info">
                    <div class="form-row">
                        <div class="form-group">
                            <label>🌐 IP адрес сервера:</label>
                            <input type="text" name="server_ip" value="<?= htmlspecialchars($settings['server_ip'] ?? 'minecraftbattle.ru') ?>" required>
                        </div>
                        <div class="form-group">
                            <label>🔌 Порт сервера:</label>
                            <input type="number" name="server_port" value="<?= htmlspecialchars($settings['server_port'] ?? '25565') ?>" min="1" max="65535" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>🎮 Версия Minecraft:</label>
                            <input type="text" name="minecraft_version" value="<?= htmlspecialchars($settings['minecraft_version'] ?? '1.16.1') ?>" required>
                        </div>
                        <div class="form-group">
                            <label>👥 Максимум игроков:</label>
                            <input type="number" name="max_players" value="<?= htmlspecialchars($settings['max_players'] ?? '100') ?>" min="1" max="1000" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">💾 Сохранить настройки</button>
                </form>
            </div>
        </div>
        <!-- Предложения модов -->
        <div id="suggestions" class="tab-content">
            <div class="section">
                <h2>💡 Предложения модов</h2>
                <?php if (empty($suggestions)): ?>
                    <p class="text-center">Нет предложений модов</p>
                <?php else: ?>
                    <div class="mb-20">
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="action" value="clear_suggestions">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Удалить все предложения?')">🗑️ Очистить все</button>
                        </form>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Название мода</th>
                                <th>Описание</th>
                                <th>IP адрес</th>
                                <th>Дата</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($suggestions as $suggestion): ?>
                                <tr>
                                    <td><?= $suggestion['id'] ?></td>
                                    <td><strong><?= htmlspecialchars($suggestion['mod_name']) ?></strong></td>
                                    <td><?= htmlspecialchars($suggestion['description'] ?: 'Без описания') ?></td>
                                    <td class="small"><?= htmlspecialchars($suggestion['ip_address']) ?></td>
                                    <td class="small"><?= date('d.m.Y H:i', strtotime($suggestion['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
        <!-- Логи -->
        <div id="logs" class="tab-content">
            <div class="section">
                <h2>📋 Системные логи</h2>
                <div class="form-row">
                    <div class="stat-card">
                        <div class="stat-number"><?= file_exists('logs/site.log') ? count(file('logs/site.log')) : 0 ?></div>
                        <div class="stat-label">📝 Записей в site.log</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?= file_exists('logs/downloads.log') ? count(file('logs/downloads.log')) : 0 ?></div>
                        <div class="stat-label">📦 Записей в downloads.log</div>
                    </div>
                </div>
                <p class="small">
                    <strong>Расположение логов:</strong><br>
                    • Основные действия: <code>logs/site.log</code><br>
                    • Скачивания: <code>logs/downloads.log</code><br>
                    • Счетчик скачиваний: <code>temp/download_counter.txt</code><br>
                    • Лимиты IP: <code>temp/download_limits.json</code>
                </p>
                <div class="text-center" style="margin-top: 20px;">
                    <a href="/" class="btn btn-success">🏠 Перейти на сайт</a>
                    <a href="/test.php" class="btn btn-warning">🔧 Тест системы</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showTab(tabName) {
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(content => content.classList.remove('active'));
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => tab.classList.remove('active'));
            document.getElementById(tabName).classList.add('active');
            event.target.classList.add('active');
        }
        function editUser(userId) {
            const row = document.getElementById('user-' + userId);
            const nicknameDisplay = row.querySelector('.nickname-display');
            const nicknameEdit = row.querySelector('.nickname-edit');
            const telegramDisplay = row.querySelector('.telegram-display');
            const telegramEdit = row.querySelector('.telegram-edit');
            const editBtn = row.querySelector('.btn-edit');
            const saveBtn = row.querySelector('.btn-save');
            nicknameDisplay.style.display = 'none';
            nicknameEdit.style.display = 'inline';
            telegramDisplay.style.display = 'none';
            telegramEdit.style.display = 'inline';
            editBtn.style.display = 'none';
            saveBtn.style.display = 'inline';
        }
        function saveUser(userId) {
            const row = document.getElementById('user-' + userId);
            const nickname = row.querySelector('.nickname-edit').value;
            const telegram = row.querySelector('.telegram-edit').value;
            if (!nickname || !telegram) {
                alert('Заполните все поля!');
                return;
            }
            const form = document.createElement('form');
            form.method = 'POST';
            form.innerHTML = `
                <input type="hidden" name="action" value="edit_user">
                <input type="hidden" name="user_id" value="${userId}">
                <input type="hidden" name="nickname" value="${nickname}">
                <input type="hidden" name="telegram" value="${telegram}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
        function deleteUser(userId, nickname) {
            if (confirm(`Удалить игрока "${nickname}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete_user">
                    <input type="hidden" name="user_id" value="${userId}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
        console.log('⚡ Админ-панель Minecraft Battle загружена');
    </script>
</body>
</html>