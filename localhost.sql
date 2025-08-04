SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `u3212739_minecraftbattle` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `u3212739_minecraftbattle`;

CREATE TABLE `mod_suggestions` (
  `id` int NOT NULL,
  `mod_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `mod_suggestions` (`id`, `mod_name`, `description`, `ip_address`, `created_at`) VALUES
(13, 'dsfsdafsadfasdfsa', 'afasdfasfasfasdfdsa', '207.148.26.62', '2025-08-02 12:43:51'),
(14, 'Mo’ Bends', 'изменяет вид передвижения', '94.140.146.76', '2025-08-04 06:00:06');

CREATE TABLE `site_settings` (
  `id` int NOT NULL,
  `setting_key` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` text COLLATE utf8mb4_unicode_ci,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `site_settings` (`id`, `setting_key`, `setting_value`, `updated_at`) VALUES
(1, 'server_ip', '1', '2025-07-31 17:40:35'),
(2, 'server_port', '1', '2025-07-31 17:40:42'),
(3, 'minecraft_version', '1.16.1', '2025-08-01 05:08:00'),
(4, 'max_players', '100', '2025-07-31 19:16:37'),
(5, 'countdown_end', '2025-08-06 12:00:59', '2025-08-02 12:13:11'),
(6, 'site_title', 'Minecraft Battle', '2025-07-31 16:51:47');

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nickname` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telegram` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `mod_suggestions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_created` (`created_at`),
  ADD KEY `idx_ip` (`ip_address`);

ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`),
  ADD KEY `idx_key` (`setting_key`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nickname` (`nickname`),
  ADD UNIQUE KEY `ip_address` (`ip_address`),
  ADD KEY `idx_nickname` (`nickname`),
  ADD KEY `idx_ip` (`ip_address`),
  ADD KEY `idx_created` (`created_at`);


ALTER TABLE `mod_suggestions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

ALTER TABLE `site_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
