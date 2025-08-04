<?php
header('Cache-Control: public, max-age=3600');
header('Vary: Accept-Encoding');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎮 Minecraft Battle - Эпический PvP Сервер!</title>
    <meta name="description" content="Лучший PvP сервер Minecraft с кланами, эпическими битвами и уникальными модами. Присоединяйся к битве!">
    <meta name="keywords" content="minecraft, сервер, pvp, клан, битва, mods, coreprotect, simpleclans">
    <meta name="author" content="Minecraft Battle">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://minecraftbattle.ru/">
    <meta property="og:title" content="🎮 Minecraft Battle - Эпический PvP Сервер!">
    <meta property="og:description" content="Лучший PvP сервер Minecraft с кланами, эпическими битвами и уникальными модами. Присоединяйся к битве!">
    <meta property="og:image" content="https://minecraftbattle.ru/favicons/android-chrome-192x192.png">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://minecraftbattle.ru/">
    <meta property="twitter:title" content="🎮 Minecraft Battle - Эпический PvP Сервер!">
    <meta property="twitter:description" content="Лучший PvP сервер Minecraft с кланами, эпическими битвами и уникальными модами. Присоединяйся к битве!">
    <meta property="twitter:image" content="https://minecraftbattle.ru/favicons/android-chrome-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="192x192" href="favicons/android-chrome-192x192.png">
    <link rel="manifest" href="favicons/site.webmanifest">
    <link rel="shortcut icon" href="favicons/favicon.ico">
    <meta name="msapplication-TileColor" content="#00AA00">
    <meta name="theme-color" content="#00AA00">
    <meta name="application-name" content="Minecraft Battle">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="MC Battle">
    <meta name="mobile-web-app-capable" content="yes">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        :root {
            --primary-green: #00AA00;
            --dark-green: #006600;
            --gold: #FFD700;
            --dark-gold: #B8860B;
            --bg-dark: rgba(0, 0, 0, 0.9);
            --text-light: #FFFFFF;
            --text-gray: #CCCCCC;
            --danger: #FF5722;
            --success: #4CAF50;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background: 
                linear-gradient(45deg, rgba(0,0,0,0.8), rgba(20,30,20,0.9)),
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64"><rect width="32" height="32" fill="%23654321"/><rect x="32" y="0" width="32" height="32" fill="%23543210"/><rect x="0" y="32" width="32" height="32" fill="%23543210"/><rect x="32" y="32" width="32" height="32" fill="%23654321"/><rect x="16" y="16" width="32" height="32" fill="%23876543" opacity="0.3"/></svg>');
            background-size: 128px 128px;
            background-attachment: fixed;
            min-height: 100vh;
            color: var(--text-light);
            position: relative;
            overflow-x: hidden;
            animation: backgroundPulse 20s ease-in-out infinite;
        }
        @keyframes backgroundPulse {
            0%, 100% { background-position: 0 0; }
            50% { background-position: 64px 64px; }
        }
        .particles-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            overflow: hidden;
        }
        .minecraft-block {
            position: absolute;
            width: 16px;
            height: 16px;
            background: var(--primary-green);
            box-shadow: 
                2px 2px 0 var(--dark-green),
                0 0 10px rgba(0, 170, 0, 0.5);
            animation: blockFall linear infinite;
            border-radius: 1px;
        }
        .minecraft-block::before {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            right: 2px;
            bottom: 2px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 1px;
        }
        .diamond-particle {
            position: absolute;
            width: 12px;
            height: 12px;
            background: linear-gradient(45deg, #00FFFF, #0080FF);
            clip-path: polygon(50% 0%, 0% 50%, 50% 100%, 100% 50%);
            animation: diamondFloat linear infinite;
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.7);
        }
        .experience-orb {
            position: absolute;
            width: 10px;
            height: 10px;
            background: radial-gradient(circle, #FFD700, #FFA500);
            border-radius: 50%;
            animation: orbFloat linear infinite;
            box-shadow: 
                0 0 10px var(--gold),
                inset 2px 2px 0 rgba(255, 255, 255, 0.3);
        }
        @keyframes blockFall {
            0% {
                transform: translateY(-100vh) rotateZ(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotateZ(180deg);
                opacity: 0;
            }
        }
        @keyframes diamondFloat {
            0% {
                transform: translateY(-100vh) scale(0.5) rotateZ(0deg);
                opacity: 0.8;
            }
            50% {
                transform: translateY(50vh) scale(1) rotateZ(180deg);
                opacity: 1;
            }
            100% {
                transform: translateY(150vh) scale(0.5) rotateZ(360deg);
                opacity: 0;
            }
        }
        @keyframes orbFloat {
            0% {
                transform: translateY(-100vh) translateX(0px);
                opacity: 1;
            }
            25% {
                transform: translateY(-25vh) translateX(20px);
                opacity: 1;
            }
            50% {
                transform: translateY(50vh) translateX(-15px);
                opacity: 1;
            }
            75% {
                transform: translateY(75vh) translateX(25px);
                opacity: 1;
            }
            100% {
                transform: translateY(150vh) translateX(0px);
                opacity: 0;
            }
        }
        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }
        .star {
            position: absolute;
            width: 2px;
            height: 2px;
            background: white;
            border-radius: 50%;
            animation: twinkle 3s ease-in-out infinite;
        }
        @keyframes twinkle {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.5); }
        }
        .header {
            text-align: center;
            padding: 40px 20px;
            position: relative;
            z-index: 10;
            background: linear-gradient(180deg, rgba(0,0,0,0.3), transparent);
        }
        .logo {
            font-family: 'Press Start 2P', monospace;
            font-size: clamp(2rem, 6vw, 5rem);
            background: linear-gradient(45deg, var(--primary-green), var(--gold));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 
                4px 4px 0px var(--dark-green),
                8px 8px 20px rgba(0, 170, 0, 0.8);
            margin-bottom: 15px;
            animation: logoGlow 3s ease-in-out infinite alternate;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .logo:hover {
            transform: scale(1.05) rotateY(5deg);
            filter: drop-shadow(0 0 30px var(--primary-green));
        }
        @keyframes logoGlow {
            from { 
                text-shadow: 
                    4px 4px 0px var(--dark-green),
                    8px 8px 20px rgba(0, 170, 0, 0.8);
            }
            to { 
                text-shadow: 
                    4px 4px 0px var(--dark-green),
                    8px 8px 40px rgba(0, 170, 0, 1),
                    12px 12px 60px rgba(255, 215, 0, 0.5);
            }
        }
        .subtitle {
            font-size: 1.3rem;
            color: var(--text-gray);
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
            animation: subtitleFloat 4s ease-in-out infinite;
        }
        @keyframes subtitleFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }
        .participant-counter {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, var(--gold), #FFA500, var(--dark-gold));
            color: #000;
            padding: 15px 25px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 1.1rem;
            box-shadow: 
                0 8px 25px rgba(255, 215, 0, 0.4),
                inset 0 2px 0 rgba(255, 255, 255, 0.3);
            z-index: 1000;
            border: 3px solid var(--dark-gold);
            animation: counterPulse 2s ease-in-out infinite;
            cursor: pointer;
            transition: all 0.3s ease;
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);
        }
        .participant-counter:hover {
            transform: scale(1.1) rotateZ(-2deg);
            box-shadow: 0 12px 35px rgba(255, 215, 0, 0.6);
        }
        @keyframes counterPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 10;
        }
        /* Супер крутой таймер */
        .countdown-section {
            text-align: center;
            margin: 50px 0 70px;
            background: 
                linear-gradient(135deg, rgba(0,0,0,0.9), rgba(20,50,20,0.8)),
                radial-gradient(circle at center, rgba(0, 170, 0, 0.1), transparent);
            border-radius: 25px;
            padding: 50px;
            border: 4px solid var(--primary-green);
            box-shadow: 
                0 0 50px rgba(0, 170, 0, 0.4),
                inset 0 0 30px rgba(0, 170, 0, 0.1);
            position: relative;
            overflow: hidden;
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);
        }
        .countdown-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(0, 170, 0, 0.05), transparent);
            animation: shimmer 3s linear infinite;
        }
        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotateZ(0deg); }
            100% { transform: translateX(100%) translateY(100%) rotateZ(360deg); }
        }
        .countdown-title {
            font-family: 'Press Start 2P', monospace;
            font-size: 1.8rem;
            margin-bottom: 40px;
            background: linear-gradient(45deg, var(--gold), #FFA500, var(--gold));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 2px 2px 0px var(--dark-gold);
            position: relative;
            z-index: 1;
        }
        .countdown-timer {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-bottom: 25px;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }
        .time-block {
            background: 
                linear-gradient(145deg, #2E7D32, #4CAF50, #66BB6A),
                radial-gradient(circle at 30% 30%, rgba(255,255,255,0.2), transparent);
            border: 4px solid var(--primary-green);
            border-radius: 20px;
            padding: 25px 20px;
            min-width: 140px;
            box-shadow: 
                0 12px 30px rgba(0, 0, 0, 0.4),
                inset 0 2px 0 rgba(255, 255, 255, 0.2),
                inset 0 -2px 0 rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        .time-block::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        .time-block:hover::before {
            left: 100%;
        }
        .time-block:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 
                0 20px 40px rgba(0, 170, 0, 0.3),
                inset 0 2px 0 rgba(255, 255, 255, 0.3);
        }
        .time-number {
            font-family: 'Press Start 2P', monospace;
            font-size: 2.8rem;
            color: #fff;
            text-shadow: 
                3px 3px 0px rgba(0, 0, 0, 0.8),
                0 0 20px rgba(255, 255, 255, 0.5);
            margin-bottom: 10px;
            animation: numberGlow 2s ease-in-out infinite alternate;
        }
        @keyframes numberGlow {
            0% { text-shadow: 3px 3px 0px rgba(0, 0, 0, 0.8), 0 0 20px rgba(255, 255, 255, 0.5); }
            100% { text-shadow: 3px 3px 0px rgba(0, 0, 0, 0.8), 0 0 30px rgba(255, 255, 255, 0.8); }
        }
        .time-label {
            font-size: 1rem;
            color: #B8F5B8;
            margin-top: 8px;
            font-weight: 600;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.8);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            margin-bottom: 80px;
        }
        .section {
            background: 
                linear-gradient(135deg, rgba(0,0,0,0.9), rgba(10,30,10,0.9)),
                radial-gradient(circle at top right, rgba(0, 170, 0, 0.1), transparent);
            border-radius: 25px;
            padding: 40px;
            border: 3px solid rgba(0, 170, 0, 0.6);
            box-shadow: 
                0 15px 40px rgba(0, 0, 0, 0.6),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        .section:hover {
            transform: translateY(-5px);
            border-color: var(--primary-green);
            box-shadow: 
                0 25px 60px rgba(0, 170, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }
        .section::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 170, 0, 0.1), transparent);
            transition: left 0.8s ease;
        }
        .section:hover::before {
            left: 100%;
        }
        .section-title {
            font-family: 'Press Start 2P', monospace;
            font-size: 1.4rem;
            background: linear-gradient(45deg, var(--gold), #FFA500);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 30px;
            text-align: center;
            text-shadow: 2px 2px 0px var(--dark-gold);
            position: relative;
        }
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        .form-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--text-gray);
            font-size: 1rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
        }
        .form-input {
            width: 100%;
            padding: 18px 20px;
            border: 3px solid rgba(85, 85, 85, 0.8);
            border-radius: 12px;
            background: 
                linear-gradient(135deg, rgba(0,0,0,0.8), rgba(20,20,20,0.8)),
                radial-gradient(circle at center, rgba(255,255,255,0.05), transparent);
            color: #fff;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            -webkit-backdrop-filter: blur(5px);
            backdrop-filter: blur(5px);
            position: relative;
        }
        .form-input:focus {
            outline: none;
            border-color: var(--primary-green);
            box-shadow: 
                0 0 20px rgba(0, 170, 0, 0.4),
                inset 0 2px 4px rgba(0, 170, 0, 0.1);
            transform: translateY(-2px);
        }
        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }
        .minecraft-btn {
            width: 100%;
            padding: 18px 25px;
            background: 
                linear-gradient(145deg, #4CAF50, #2E7D32, #1B5E20),
                radial-gradient(circle at 30% 30%, rgba(255,255,255,0.2), transparent);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: 'Roboto', sans-serif;
            box-shadow: 
                0 8px 20px rgba(0, 0, 0, 0.3),
                inset 0 2px 0 rgba(255, 255, 255, 0.2),
                inset 0 -2px 0 rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }
        .minecraft-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s ease;
        }
        .minecraft-btn:hover::before {
            left: 100%;
        }
        .minecraft-btn:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 
                0 15px 35px rgba(76, 175, 80, 0.4),
                inset 0 2px 0 rgba(255, 255, 255, 0.3);
        }
        .minecraft-btn:active {
            transform: translateY(-1px) scale(0.98);
        }
        .minecraft-btn:disabled {
            background: linear-gradient(145deg, #666, #444);
            cursor: not-allowed;
            transform: none;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);
            animation: modalFadeIn 0.3s ease;
        }
        @keyframes modalFadeIn {
            from { opacity: 0; -webkit-backdrop-filter: blur(0px); backdrop-filter: blur(0px); }
            to { opacity: 1; -webkit-backdrop-filter: blur(10px); backdrop-filter: blur(10px); }
        }
        .modal-content {
            background: 
                linear-gradient(135deg, rgba(0,0,0,0.95), rgba(20,40,20,0.95)),
                radial-gradient(circle at center, rgba(0, 170, 0, 0.1), transparent);
            margin: 3% auto;
            padding: 40px;
            border-radius: 25px;
            width: 90%;
            max-width: 900px;
            max-height: 85vh;
            overflow-y: auto;
            border: 3px solid var(--primary-green);
            box-shadow: 
                0 25px 80px rgba(0, 0, 0, 0.8),
                0 0 50px rgba(0, 170, 0, 0.3);
            animation: modalSlideIn 0.4s ease;
            position: relative;
        }
        @keyframes modalSlideIn {
            from { transform: translateY(-50px) scale(0.9); opacity: 0; }
            to { transform: translateY(0) scale(1); opacity: 1; }
        }
        .notification {
            position: fixed;
            top: 30px;
            left: 50%;
            transform: translateX(-50%);
            padding: 20px 30px;
            border-radius: 15px;
            font-weight: bold;
            z-index: 1001;
            opacity: 0;
            transition: all 0.4s ease;
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);
            border: 2px solid transparent;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        .notification.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
        .notification.success {
            background: linear-gradient(135deg, rgba(76, 175, 80, 0.9), rgba(46, 125, 50, 0.9));
            border-color: var(--success);
            color: white;
        }
        .notification.error {
            background: linear-gradient(135deg, rgba(244, 67, 54, 0.9), rgba(211, 47, 47, 0.9));
            border-color: var(--danger);
            color: white;
        }
        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
                gap: 30px;
            }
            .countdown-timer {
                gap: 15px;
            }
            .time-block {
                min-width: 100px;
                padding: 20px 15px;
            }
            .time-number {
                font-size: 2rem;
            }
            .participant-counter {
                position: fixed;
                top: 10px;
                right: 10px;
                font-size: 0.9rem;
                padding: 12px 18px;
                transform: scale(0.9);
            }
            .header {
                padding: 60px 15px 30px 15px;
            }
            .logo {
                font-size: clamp(1.5rem, 8vw, 3rem);
                margin-top: 20px;
            }
            .subtitle {
                font-size: 1rem;
            }
            
            /* Мобильные стили для server-info */
            .server-info {
                padding: 25px 15px;
                margin: 20px 10px;
            }
            .server-info-title {
                font-size: 1.3rem;
                margin-bottom: 20px;
                text-align: center;
            }
            .server-details {
                grid-template-columns: 1fr;
                gap: 12px;
                margin: 20px 0;
                justify-items: center;
            }
            .detail-card {
                padding: 15px;
                max-width: 100%;
                width: 100%;
                margin: 0 auto;
            }
            
            /* Мобильные стили для кнопок сервера */
            .server-buttons-container {
                flex-direction: column;
                gap: 15px;
                margin-top: 20px;
            }
            .server-button, .download-button {
                flex: none;
                min-width: auto;
                width: 100%;
                max-width: 100%;
            }
            
            /* Мобильные стили для модов */
            .mods-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            .mod-button {
                max-width: 100%;
                padding: 18px;
                font-size: 1rem;
            }
            
            /* Улучшения для секций */
            .section {
                padding: 25px 20px;
                margin-bottom: 20px;
            }
            .section-title {
                font-size: 1.2rem;
                margin-bottom: 20px;
            }
            .section-description {
                font-size: 1rem;
                margin-bottom: 20px;
            }
        }
        
        /* Стили для очень узких экранов (iPhone SE и подобные) */
        @media (max-width: 375px) {
            .server-info {
                margin: 15px 5px;
                padding: 20px 10px;
            }
            .server-details {
                grid-template-columns: 1fr;
                gap: 10px;
                margin: 15px 0;
                padding: 0 5px;
            }
            .detail-card {
                padding: 12px;
                margin: 0;
                width: calc(100% - 10px);
                max-width: none;
            }
            .detail-title {
                font-size: 1rem;
                margin-bottom: 8px;
            }
            .detail-value {
                font-size: 1.1rem;
            }
            .server-buttons-container {
                gap: 10px;
                margin-top: 15px;
                padding: 0 5px;
            }
            .server-button, .download-button {
                padding: 15px;
                font-size: 1rem;
            }
        }
        .server-info {
            display: none;
            text-align: center;
            background: 
                linear-gradient(135deg, rgba(0,0,0,0.95), rgba(20,50,20,0.9)),
                radial-gradient(circle at center, rgba(0, 170, 0, 0.2), transparent);
            border-radius: 25px;
            padding: 50px;
            border: 4px solid var(--primary-green);
            margin: 50px 0;
            box-shadow: 
                0 0 60px rgba(0, 170, 0, 0.4),
                inset 0 0 30px rgba(0, 170, 0, 0.1);
            animation: serverInfoSlide 0.8s ease;
        }
        @keyframes serverInfoSlide {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .server-info.active {
            display: block;
        }
        .server-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin: 40px 0;
            justify-items: center;
            padding: 0 10px;
        }
        .detail-card {
            background: 
                linear-gradient(135deg, rgba(255,255,255,0.1), rgba(255,255,255,0.05)),
                radial-gradient(circle at top, rgba(0, 170, 0, 0.1), transparent);
            padding: 25px;
            border-radius: 15px;
            border: 2px solid rgba(0, 170, 0, 0.3);
            -webkit-backdrop-filter: blur(5px);
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
            width: 100%;
            max-width: 320px;
            text-align: center;
        }
        .detail-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary-green);
            box-shadow: 0 10px 25px rgba(0, 170, 0, 0.2);
        }
        .detail-title {
            color: var(--gold);
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }
        .detail-value {
            color: var(--primary-green);
            font-family: 'Courier New', monospace;
            font-size: 1.2rem;
            font-weight: bold;
        }
        ::-webkit-scrollbar {
            width: 12px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 6px;
        }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(45deg, var(--primary-green), var(--dark-green));
            border-radius: 6px;
            border: 2px solid rgba(0, 0, 0, 0.3);
        }
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, var(--gold), var(--dark-gold));
        }
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: var(--primary-green);
            animation: spin 1s ease-in-out infinite;
            margin-left: 10px;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .server-info-title {
            font-family: 'Press Start 2P', monospace; 
            color: var(--gold); 
            margin-bottom: 30px; 
            font-size: 2rem;
        }
        
        .server-buttons-container {
            display: flex; 
            gap: 20px; 
            justify-content: center; 
            flex-wrap: wrap;
            margin-top: 30px;
        }
        
        .server-button {
            flex: 1; 
            min-width: 250px;
        }
        
        .download-button {
            flex: 1; 
            min-width: 250px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            text-decoration: none; 
            background: linear-gradient(145deg, #4CAF50, #388E3C);
        }
        
        .nick-validation {
            margin-top: 8px; 
            font-size: 0.9rem;
        }
        
        .section-description {
            text-align: center; 
            color: var(--text-gray); 
            margin-bottom: 30px; 
            font-size: 1.1rem;
        }
        
        .mods-grid {
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); 
            gap: 20px;
            justify-items: center;
        }
        
        .mod-button {
            padding: 20px; 
            font-size: 1.1rem;
            width: 100%;
            max-width: 320px;
        }
        
        .mod-description {
            font-size: 0.8rem; 
            margin-top: 8px; 
            color: var(--text-gray);
        }
        
        .suggestion-section {
            grid-column: 1 / -1; 
            margin-top: 30px;
        }
        
        .suggestion-form {
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 25px; 
            align-items: end;
        }
        
        .suggestion-submit {
            grid-column: 1 / -1;
        }
        
        .modal-close {
            color: #aaa; 
            float: right; 
            font-size: 28px; 
            font-weight: bold; 
            cursor: pointer;
        }
        
        .modal-title {
            color: var(--gold); 
            margin-bottom: 25px; 
            font-family: 'Press Start 2P', monospace;
        }
    </style>
</head>
<body>
    <div class="stars" id="stars"></div>
    <div class="particles-container" id="particlesContainer"></div>
    <div class="participant-counter" onclick="showParticipants()" 
         role="button" 
         aria-label="Счетчик участников сервера" 
         tabindex="0" 
         onkeydown="if(event.key==='Enter'||event.key===' ')showParticipants()">
        <span aria-label="Иконка людей">👥</span> Участников: <span id="participantCount">0</span>
    </div>
    <div class="header">
        <h1 class="logo" onclick="logoEasterEgg()" 
            role="button" 
            tabindex="0" 
            aria-label="Логотип Minecraft Battle - кликните для эффекта"
            onkeydown="if(event.key==='Enter'||event.key===' ')logoEasterEgg()">
            <span aria-label="Кирка">⛏️</span> MINECRAFT BATTLE <span aria-label="Кирка">⛏️</span>
        </h1>
    </div>
    <div class="container">
        <div class="countdown-section" role="region" aria-label="Таймер обратного отсчета до открытия сервера">
            <h2 class="countdown-title">
                <span aria-label="Часы">⏰</span> До открытия сервера осталось:
            </h2>
            <div class="countdown-timer" id="countdown" role="timer" aria-live="polite">
                <div class="time-block" onclick="timeBlockClick(this)" 
                     role="button" tabindex="0" 
                     aria-label="Дни до открытия"
                     onkeydown="if(event.key==='Enter'||event.key===' ')timeBlockClick(this)">
                    <div class="time-number" id="days" aria-label="Количество дней">00</div>
                    <div class="time-label">Дней</div>
                </div>
                <div class="time-block" onclick="timeBlockClick(this)" 
                     role="button" tabindex="0" 
                     aria-label="Часы до открытия"
                     onkeydown="if(event.key==='Enter'||event.key===' ')timeBlockClick(this)">
                    <div class="time-number" id="hours" aria-label="Количество часов">00</div>
                    <div class="time-label">Часов</div>
                </div>
                <div class="time-block" onclick="timeBlockClick(this)" 
                     role="button" tabindex="0" 
                     aria-label="Минуты до открытия"
                     onkeydown="if(event.key==='Enter'||event.key===' ')timeBlockClick(this)">
                    <div class="time-number" id="minutes" aria-label="Количество минут">00</div>
                    <div class="time-label">Минут</div>
                </div>
                <div class="time-block" onclick="timeBlockClick(this)" 
                     role="button" tabindex="0" 
                     aria-label="Секунды до открытия"
                     onkeydown="if(event.key==='Enter'||event.key===' ')timeBlockClick(this)">
                    <div class="time-number" id="seconds" aria-label="Количество секунд">00</div>
                    <div class="time-label">Секунд</div>
                </div>
            </div>
        </div>
        <div class="server-info" id="serverInfo" role="region" aria-label="Информация о сервере">
            <h2 class="server-info-title">
                <span aria-label="Праздник">🎉</span> СЕРВЕР ОТКРЫТ! <span aria-label="Праздник">🎉</span>
            </h2>
            <div class="server-details">
                <div class="detail-card" role="group" aria-label="IP адрес сервера">
                    <div class="detail-title">
                        <span aria-label="Интернет">🌐</span> IP Адрес сервера:
                    </div>
                    <div class="detail-value" data-server-ip>minecraftbattle.ru</div>
                </div>
                <div class="detail-card" role="group" aria-label="Порт сервера">
                    <div class="detail-title">
                        <span aria-label="Разъем">🔌</span> Порт:
                    </div>
                    <div class="detail-value" data-server-port>25565</div>
                </div>
                <div class="detail-card" role="group" aria-label="Версия игры">
                    <div class="detail-title">
                        <span aria-label="Геймпад">🎮</span> Версия Minecraft:
                    </div>
                    <div class="detail-value" data-mc-version>1.16.1</div>
                </div>
                <div class="detail-card" role="group" aria-label="Максимальное количество игроков">
                    <div class="detail-title">
                        <span aria-label="Группа людей">👥</span> Максимум игроков:
                    </div>
                    <div class="detail-value" data-max-players>100</div>
                </div>
            </div>
            <div class="server-buttons-container">
                <button class="minecraft-btn server-button" onclick="showAllCommands()" aria-label="Показать все команды и моды">
                    <span aria-label="Книга">📖</span> Все команды и моды
                </button>
                <a href="/download.html" class="minecraft-btn download-button" aria-label="Скачать TLauncher для игры">
                    <span aria-label="Загрузка">📦</span> Скачать TLauncher
                </a>
            </div>
        </div>
        <div class="main-content">
            <div class="section" role="region" aria-label="Форма регистрации на сервер">
                <h2 class="section-title">
                    <span aria-label="Цель">🎯</span> Регистрация на сервер
                </h2>
                <form id="registrationForm" role="form" aria-label="Форма регистрации пользователя">
                    <div class="form-group">
                        <label for="minecraftNick" class="form-label">
                            <span aria-label="Молния">⚡</span> Ник в Minecraft:
                        </label>
                        <input type="text" id="minecraftNick" name="minecraftNick" class="form-input" 
                               placeholder="Введите ваш игровой ник" maxlength="16" required
                               aria-describedby="nickValidation"
                               aria-label="Поле для ввода никнейма в Minecraft">
                        <div id="nickValidation" class="nick-validation" 
                             role="status" aria-live="polite"></div>
                    </div>
                    <div class="form-group">
                        <label for="telegram" class="form-label">
                            <span aria-label="Телефон">📱</span> Telegram:
                        </label>
                        <input type="text" id="telegram" name="telegram" class="form-input" 
                               placeholder="@ваш_username" required
                               aria-label="Поле для ввода Telegram username">
                    </div>
                    <button type="submit" class="minecraft-btn" id="submitBtn" 
                            aria-label="Отправить форму регистрации">
                        <span aria-label="Молния">⚡</span> Присоединиться к серверу
                    </button>
                </form>
            </div>
            <div class="section" role="region" aria-label="Информация об установленных модах">
                <h2 class="section-title">
                    <span aria-label="Гаечный ключ">🔧</span> Установленные моды
                </h2>
                <p class="section-description">
                    <span aria-label="Щит">🛡️</span> Изучите команды наших основных плагинов!
                </p>
                <div class="mods-grid">
                    <button class="minecraft-btn mod-button" onclick="window.open('/coreprotect_commands.html', '_blank')" 
                            aria-label="Открыть команды CoreProtect">
                        <span aria-label="Щит">🛡️</span> CoreProtect
                        <div class="mod-description">
                            Система защиты и логирования
                        </div>
                    </button>
                    <button class="minecraft-btn mod-button" onclick="window.open('/simpleclans_commands.html', '_blank')" 
                            aria-label="Открыть команды SimpleClans">
                        <span aria-label="Замок">🏰</span> SimpleClans
                        <div class="mod-description">
                            Система кланов и PvP
                        </div>
                    </button>
                </div>
            </div>
        </div>
        <div class="section suggestion-section" 
             role="region" aria-label="Форма предложения новых модов">
            <h2 class="section-title">
                <span aria-label="Лампочка">💡</span> Предложить мод
            </h2>
            <p class="section-description">
                <span aria-label="Цирк">🎪</span> Знаете интересный мод? Предложите его для установки на сервер!
            </p>
            <form id="suggestionForm" method="post" class="suggestion-form"
                  role="form" aria-label="Форма предложения мода">
                <div class="form-group">
                    <label for="modName" class="form-label">
                        <span aria-label="Цель">🎯</span> Название мода:
                    </label>
                    <input type="text" id="modName" name="modName" class="form-input" 
                           placeholder="Например: WorldEdit" required
                           aria-label="Поле для ввода названия мода">
                </div>
                <div class="form-group">
                    <label for="modDescription" class="form-label">
                        <span aria-label="Документ">📝</span> Описание (необязательно):
                    </label>
                    <input type="text" id="modDescription" name="modDescription" class="form-input" 
                           placeholder="Кратко опишите возможности мода"
                           aria-label="Поле для ввода описания мода">
                </div>

                <button type="submit" class="minecraft-btn suggestion-submit"
                        aria-label="Отправить предложение мода">
                    <span aria-label="Ракета">🚀</span> Отправить предложение
                </button>
            </form>
        </div>
    </div>
    <div id="commandsModal" class="modal" role="dialog" aria-modal="true" aria-hidden="true" tabindex="-1">
        <div class="modal-content" role="document">
            <span class="close modal-close" 
                  role="button" tabindex="0" aria-label="Закрыть модальное окно">&times;</span>
            <h2 class="modal-title">
                <span aria-label="Книга">📖</span> Команды всех плагинов
            </h2>
            <div id="commandsContent" role="region" aria-label="Список команд для плагинов">
            </div>
        </div>
    </div>
    <div id="notification" class="notification" role="alert" aria-live="polite" aria-atomic="true"></div>
    <script>
        const CONFIG = {
            countdownEndDate: new Date('2025-12-31T23:59:59').getTime(),
            apiUrl: 'api.php'
        };
        function createStars() {
            const starsContainer = document.getElementById('stars');
            for (let i = 0; i < 200; i++) {
                const star = document.createElement('div');
                star.className = 'star';
                star.style.left = Math.random() * 100 + '%';
                star.style.top = Math.random() * 100 + '%';
                star.style.animationDelay = Math.random() * 3 + 's';
                star.style.animationDuration = (Math.random() * 2 + 2) + 's';
                starsContainer.appendChild(star);
            }
        }
        function createAdvancedParticles() {
            const container = document.getElementById('particlesContainer');
            for (let i = 0; i < 15; i++) {
                const block = document.createElement('div');
                block.className = 'minecraft-block';
                block.style.left = Math.random() * 100 + '%';
                block.style.animationDelay = Math.random() * 15 + 's';
                block.style.animationDuration = (Math.random() * 20 + 15) + 's';
                const colors = ['#00AA00', '#FFD700', '#FF5722', '#2196F3', '#9C27B0'];
                const color = colors[Math.floor(Math.random() * colors.length)];
                block.style.background = color;
                block.style.boxShadow = `2px 2px 0 ${color}99, 0 0 10px ${color}80`;
                container.appendChild(block);
            }
            for (let i = 0; i < 8; i++) {
                const diamond = document.createElement('div');
                diamond.className = 'diamond-particle';
                diamond.style.left = Math.random() * 100 + '%';
                diamond.style.animationDelay = Math.random() * 20 + 's';
                diamond.style.animationDuration = (Math.random() * 15 + 20) + 's';
                container.appendChild(diamond);
            }
            for (let i = 0; i < 12; i++) {
                const orb = document.createElement('div');
                orb.className = 'experience-orb';
                orb.style.left = Math.random() * 100 + '%';
                orb.style.animationDelay = Math.random() * 10 + 's';
                orb.style.animationDuration = (Math.random() * 12 + 8) + 's';
                container.appendChild(orb);
            }
        }
        async function loadCountdownData() {
            try {
                const response = await fetch(CONFIG.apiUrl + '?action=getCountdown');
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                if (data.success && data.timestamp) {
                    CONFIG.countdownEndDate = data.timestamp;
                } else {
                    console.warn('Не удалось загрузить данные таймера, используется дефолтная дата');
                }
            } catch (error) {
                console.error('Ошибка загрузки данных таймера:', error);
            }
        }
        async function loadServerInfo() {
            try {
                const response = await fetch(CONFIG.apiUrl + '?action=getServerInfo');
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                if (data.success) {
                    const serverIPElements = document.querySelectorAll('[data-server-ip]');
                    const serverPortElements = document.querySelectorAll('[data-server-port]');
                    const versionElements = document.querySelectorAll('[data-mc-version]');
                    const maxPlayersElements = document.querySelectorAll('[data-max-players]');
                    serverIPElements.forEach(el => el.textContent = data.server_ip);
                    serverPortElements.forEach(el => el.textContent = data.server_port);
                    versionElements.forEach(el => el.textContent = data.minecraft_version);
                    maxPlayersElements.forEach(el => el.textContent = data.max_players);
                } else {
                    console.warn('Не удалось загрузить информацию о сервере');
                }
            } catch (error) {
                console.error('Ошибка загрузки информации о сервере:', error);
            }
        }
        function updateCountdown() {
            try {
                const now = new Date().getTime();
                const distance = CONFIG.countdownEndDate - now;
                if (distance < 0) {
                    const countdownSection = document.querySelector('.countdown-section');
                    const serverInfo = document.getElementById('serverInfo');
                    const commandsButton = document.querySelector('button[onclick="showAllCommands()"]');
                    if (countdownSection) countdownSection.style.display = 'none';
                    if (serverInfo) serverInfo.classList.add('active');
                    if (commandsButton) commandsButton.style.display = 'none';
                    return;
                }
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                const daysEl = document.getElementById('days');
                const hoursEl = document.getElementById('hours');
                const minutesEl = document.getElementById('minutes');
                const secondsEl = document.getElementById('seconds');
                if (daysEl) daysEl.textContent = days.toString().padStart(2, '0');
                if (hoursEl) hoursEl.textContent = hours.toString().padStart(2, '0');
                if (minutesEl) minutesEl.textContent = minutes.toString().padStart(2, '0');
                if (secondsEl) secondsEl.textContent = seconds.toString().padStart(2, '0');
                const countdownTimer = document.querySelector('.countdown-timer');
                if (countdownTimer) {
                    if (distance < 300000) { 
                        countdownTimer.style.animation = 'counterPulse 0.5s infinite';
                    } else if (distance < 3600000) { 
                        countdownTimer.style.animation = 'counterPulse 2s infinite';
                    }
                }
            } catch (error) {
                console.error('Ошибка в updateCountdown:', error);
            }
        }
        function timeBlockClick(element) {
            element.style.animation = 'none';
            element.offsetHeight; 
            element.style.animation = 'counterPulse 0.3s ease';
        }
        function logoEasterEgg() {
            const logo = document.querySelector('.logo');
            logo.style.animation = 'none';
            logo.offsetHeight;
            logo.style.animation = 'logoGlow 0.5s ease, spin 1s ease';
        }
        async function loadParticipantCount() {
            try {
                const response = await fetch(CONFIG.apiUrl + '?action=getParticipants');
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                const counter = document.getElementById('participantCount');
                if (!counter) {
                    console.error('Элемент participantCount не найден');
                    return;
                }
                const newCount = data.count || 0;
                counter.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    counter.textContent = newCount;
                    counter.style.transform = 'scale(1)';
                }, 150);
            } catch (error) {
                console.error('Ошибка загрузки счетчика:', error);
                const counter = document.getElementById('participantCount');
                if (counter && counter.textContent === '0') {
                }
            }
        }
        function showNotification(message, type = 'success') {
            const notification = document.getElementById('notification');
            if (!notification) {
                console.error('Элемент notification не найден');
                return;
            }
            notification.textContent = message || 'Неизвестная ошибка';
            notification.className = `notification ${type}`;
            notification.classList.add('show');
            setTimeout(() => {
                notification.classList.remove('show');
            }, 4000);
            notification.setAttribute('role', 'alert');
            notification.setAttribute('aria-live', 'polite');
        }
        async function validateNickname(nickname) {
            if (nickname.length < 3 || nickname.length > 16) {
                return { valid: false, message: 'Никнейм должен быть от 3 до 16 символов' };
            }
            if (!/^[a-zA-Z0-9_]+$/.test(nickname)) {
                return { valid: false, message: 'Никнейм может содержать только латинские буквы, цифры и _' };
            }
            return { valid: true, message: 'Никнейм соответствует требованиям' };
        }
        function initializeEventListeners() {
            const minecraftNickInput = document.getElementById('minecraftNick');
            const registrationForm = document.getElementById('registrationForm');
            const suggestionForm = document.getElementById('suggestionForm');
            if (minecraftNickInput) {
                minecraftNickInput.addEventListener('input', async (e) => {
                    const nickname = e.target.value;
                    const validation = document.getElementById('nickValidation');
                    if (!validation) return;
                    if (nickname.length >= 3) {
                        const result = await validateNickname(nickname);
                        validation.innerHTML = `
                            <span style="color: ${result.valid ? 'var(--success)' : 'var(--danger)'}; font-weight: bold;">
                                ${result.valid ? '✅' : '❌'} ${result.message}
                            </span>
                        `;
                    } else {
                        validation.innerHTML = '';
                    }
                });
            }
            if (registrationForm) {
                registrationForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const submitBtn = document.getElementById('submitBtn');
                    if (!submitBtn) return;
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '⏳ Регистрация...<span class="loading"></span>';
                    submitBtn.disabled = true;
                    try {
                        const formData = new FormData(e.target);
                        const nickname = formData.get('minecraftNick');
                        const telegram = formData.get('telegram');
                        const nicknameValidation = await validateNickname(nickname);
                        if (!nicknameValidation.valid) {
                            showNotification(nicknameValidation.message, 'error');
                            return;
                        }
                        if (!telegram || !telegram.startsWith('@')) {
                            showNotification('Telegram должен начинаться с @', 'error');
                            return;
                        }
                        const registrationData = new FormData();
                        registrationData.append('action', 'register');
                        registrationData.append('nickname', nickname);
                        registrationData.append('telegram', telegram);
                        const response = await fetch(CONFIG.apiUrl, {
                            method: 'POST',
                            body: registrationData
                        });
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        const data = await response.json();
                        if (data.success) {
                            showNotification('🎉 Регистрация успешна! Добро пожаловать на сервер!');
                            e.target.reset();
                            loadParticipantCount();
                            const validation = document.getElementById('nickValidation');
                            if (validation) validation.innerHTML = '';
                        } else {
                            showNotification(data.message || 'Ошибка регистрации', 'error');
                        }
                    } catch (error) {
                        console.error('Ошибка регистрации:', error);
                        showNotification('Ошибка сети. Попробуйте еще раз.', 'error');
                    } finally {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }
                });
            }
            if (suggestionForm) {
                suggestionForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const submitBtn = suggestionForm.querySelector('button[type="submit"]');
                    if (!submitBtn) return;
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '⏳ Отправка...<span class="loading"></span>';
                    submitBtn.disabled = true;
                    try {
                        const formData = new FormData(e.target);
                        const modName = formData.get('modName');
                        const modDescription = formData.get('modDescription') || '';
                        if (!modName || modName.trim().length < 2) {
                            showNotification('Введите название мода (минимум 2 символа)', 'error');
                            return;
                        }
                        const suggestionData = new FormData();
                        suggestionData.append('action', 'suggestMod');
                        suggestionData.append('mod_name', modName.trim());
                        suggestionData.append('description', modDescription.trim());
                        const response = await fetch(CONFIG.apiUrl, {
                            method: 'POST',
                            body: suggestionData
                        });
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        const data = await response.json();
                        if (data.success) {
                            showNotification('💡 Предложение отправлено! Спасибо за участие!');
                            e.target.reset();
                        } else {
                            console.error('API ошибка:', data);
                            showNotification(data.message || 'Ошибка отправки предложения', 'error');
                        }
                    } catch (error) {
                        console.error('Ошибка отправки предложения:', error);
                        console.error('Детали ошибки:', {
                            modName: modName
                        });
                        showNotification('Ошибка сети. Попробуйте еще раз.', 'error');
                    } finally {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }
                });
            }
        }
        function showCommandsModal() {
            const modal = document.getElementById('commandsModal');
            if (modal) {
                modal.style.display = 'block';
                modal.setAttribute('aria-hidden', 'false');
                loadCommands();
                modal.focus();
            } else {
                console.error('Модальное окно commandsModal не найдено');
            }
        }
        async function loadCommands() {
            try {
                const response = await fetch(CONFIG.apiUrl + '?action=getCommands');
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const mods = await response.json();
                const commandsContent = document.getElementById('commandsContent');
                if (!commandsContent) {
                    console.error('Элемент commandsContent не найден');
                    return;
                }
                if (!Array.isArray(mods) || mods.length === 0) {
                    commandsContent.innerHTML = '<div style="text-align: center; color: var(--text-gray); padding: 20px;">Команды загружаются...</div>';
                    return;
                }
                commandsContent.innerHTML = mods.map(mod => `
                    <div style="margin-bottom: 35px; padding: 25px; background: rgba(255,255,255,0.05); border-radius: 15px; border-left: 4px solid var(--primary-green);"
                         role="region" 
                         aria-label="Команды для мода ${mod.name || 'Неизвестный мод'}">
                        <h3 style="color: var(--primary-green); margin-bottom: 20px; font-size: 1.3rem;">${mod.name || 'Неизвестный мод'} v${mod.version || '1.0'}</h3>
                        <div style="display: grid; gap: 15px;">
                            ${JSON.parse(mod.commands || '[]').map(cmd => `
                                <div style="background: rgba(0,0,0,0.6); padding: 18px; border-radius: 10px; border-left: 3px solid var(--gold); transition: all 0.3s ease;" 
                                     onmouseover="this.style.transform='translateX(5px)'"
                                     onmouseout="this.style.transform='translateX(0)'"
                                     role="article"
                                     aria-label="Команда ${cmd.command || 'Неизвестная команда'}">
                                    <code style="color: #4FC3F7; font-weight: bold; font-size: 1.1rem;">${cmd.command || 'Неизвестная команда'}</code>
                                    <div style="color: var(--text-gray); margin-top: 8px; line-height: 1.5;">${cmd.description || 'Описание недоступно'}</div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `).join('');
            } catch (error) {
                console.error('Ошибка загрузки команд:', error);
                const commandsContent = document.getElementById('commandsContent');
                if (commandsContent) {
                    commandsContent.innerHTML = '<div style="text-align: center; color: var(--danger); padding: 20px;">⚠️ Ошибка загрузки команд. Попробуйте обновить страницу.</div>';
                }
            }
        }
        function showAllCommands() {
            showCommandsModal();
        }
        function hideCommandsModal() {
            const modal = document.getElementById('commandsModal');
            if (modal) {
                modal.style.display = 'none';
                modal.setAttribute('aria-hidden', 'true');
            }
        }
        function initializeModalHandlers() {
            const closeBtn = document.querySelector('.close');
            const modal = document.getElementById('commandsModal');
            if (closeBtn && modal) {
                closeBtn.addEventListener('click', () => {
                    hideCommandsModal();
                });
                closeBtn.setAttribute('aria-label', 'Закрыть модальное окно');
            }
            window.addEventListener('click', (e) => {
                if (modal && e.target === modal) {
                    hideCommandsModal();
                }
            });
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && modal && modal.style.display === 'block') {
                    hideCommandsModal();
                }
            });
        }
        function showParticipants() {
            showNotification('💎 Спасибо за интерес к нашему серверу!');
        }
        function showAllCommands() {
            showCommandsModal();
        }
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                createStars();
                createAdvancedParticles();
                await loadCountdownData();
                await loadServerInfo();
                updateCountdown();
                loadParticipantCount();
                initializeEventListeners();
                initializeModalHandlers();
                const modal = document.getElementById('commandsModal');
                if (modal) {
                    modal.setAttribute('role', 'dialog');
                    modal.setAttribute('aria-modal', 'true');
                    modal.setAttribute('aria-hidden', 'true');
                    modal.setAttribute('tabindex', '-1');
                }
                const notification = document.getElementById('notification');
                if (notification) {
                    notification.setAttribute('role', 'alert');
                    notification.setAttribute('aria-live', 'polite');
                }
                setInterval(updateCountdown, 1000);
                setInterval(loadParticipantCount, 30000);
                setInterval(loadCountdownData, 300000);
                setInterval(loadServerInfo, 600000);
                setInterval(() => {
                    const container = document.getElementById('particlesContainer');
                    if (container && container.children.length < 50) {
                        createAdvancedParticles();
                    }
                }, 10000);
                console.log('🎮 Minecraft Battle сайт успешно загружен!');
            } catch (error) {
                console.error('Ошибка инициализации сайта:', error);
            }
        });
    </script>
</body>
</html>