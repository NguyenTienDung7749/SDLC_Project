-- ============================================================
-- SE08102_SDLC – Full Database Setup Script
-- Run this in HeidiSQL / phpMyAdmin / MySQL CLI before starting
-- ============================================================

-- 1. Create (or reuse) the database
CREATE DATABASE IF NOT EXISTS `SE08102_SDLC`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `SE08102_SDLC`;

-- 2. Users table
--    id       – AUTO_INCREMENT primary key (never entered by the user)
--    username – must be unique
--    password – stored as a bcrypt hash (password_hash / password_verify)
--    role     – 'user' (default) or 'admin'
CREATE TABLE IF NOT EXISTS `users` (
  `id`       INT          NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role`     VARCHAR(20)  NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Default admin account
--    Username : admin
--    Password : admin123   ← change this after first login!
--    The hash below is password_hash('admin123', PASSWORD_DEFAULT)
INSERT IGNORE INTO `users` (`username`, `password`, `role`)
VALUES (
  'admin',
  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
  'admin'
);

-- 4. Products table
CREATE TABLE IF NOT EXISTS `products` (
  `id`         INT          NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(255) NOT NULL,
  `price`      INT          NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================================
-- That's it! Go to http://localhost/SDLC_Project/login.php
-- and log in as admin / admin123
-- ============================================================
