-- Adminer 6.1.1 MariaDB 13.0.2-MariaDB-ubu2604 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `vaiicko_db`;
CREATE DATABASE `vaiicko_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_uca1400_ai_ci */;
USE `vaiicko_db`;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
                              `id` int(11) NOT NULL AUTO_INCREMENT,
                              `name` varchar(64) NOT NULL,
                              PRIMARY KEY (`id`),
                              UNIQUE KEY uq_categories_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;


DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `user_id` int(11) NOT NULL,
                            `title` varchar(128) NOT NULL,
                            `short_description` varchar(256) NOT NULL,
                            `cover_image_path` varchar(128) NOT NULL,
                            `is_public` tinyint(1) NOT NULL DEFAULT 1,
                            `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                            `updated_at` datetime NOT NULL ON UPDATE current_timestamp(),
                            PRIMARY KEY (`id`),
                            KEY `user_id` (`user_id`),
                            CONSTRAINT `fk_projects_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;


DROP TABLE IF EXISTS `project_blocks`;
CREATE TABLE `project_blocks` (
                                 `id` int(11) NOT NULL AUTO_INCREMENT,
                                 `project_id` int(11) NOT NULL,
                                 `type` varchar(64) NOT NULL,
                                 `position` int(11) NOT NULL,
                                 `heading` varchar(64) NOT NULL,
                                 `body` varchar(256) NOT NULL,
                                 `image_path` varchar(128) NOT NULL DEFAULT '',
                                 `url` varchar(256) NOT NULL DEFAULT '',
                                 PRIMARY KEY (`id`),
                                 KEY `project_id` (`project_id`),
                                 CONSTRAINT `fk_project_blocks_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;


DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
                        `id` int(11) NOT NULL AUTO_INCREMENT,
                        `category_id` int(11) NOT NULL,
                        `name` varchar(64) NOT NULL,
                        PRIMARY KEY (`id`),
                        KEY `category_id` (`category_id`),
                        UNIQUE KEY uq_tags_category_name (category_id, name),
                        CONSTRAINT `fk_tags_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;


DROP TABLE IF EXISTS `themes`;
CREATE TABLE `themes` (
                          `id` int(11) NOT NULL AUTO_INCREMENT,
                          `name` varchar(64) NOT NULL,
                          `layout` varchar(64) NOT NULL,
                          `color_primary` char(8) NOT NULL,
                          `color_background` char(8) NOT NULL,
                          `color_text` char(8) NOT NULL,
                          `font` varchar(64) NOT NULL,
                          `preview_image_path` varchar(128) NOT NULL,
                          PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
                         `id` int(11) NOT NULL AUTO_INCREMENT,
                         `username` varchar(64) NOT NULL,
                         `email` varchar(128) NOT NULL,
                         `password_hash` varchar(255) NOT NULL,
                         `role` varchar(16) NOT NULL,
                         `display_name` varchar(64) NOT NULL,
                         `bio` varchar(1024) NOT NULL,
                         `avatar_path` varchar(128) NOT NULL,
                         `is_banned` tinyint(1) NOT NULL DEFAULT 0,
                         `theme_id` int(11) NOT NULL,
                         `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                         PRIMARY KEY (`id`),
                         KEY `theme_id` (`theme_id`),
                         UNIQUE KEY `username_unique` (`username`),
                         UNIQUE KEY `email_unique` (`email`),
                         CONSTRAINT `fk_users_theme` FOREIGN KEY (`theme_id`) REFERENCES `themes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;


DROP TABLE IF EXISTS `project_tag`;
CREATE TABLE `project_tag` (
    `project_id` int(11) NOT NULL,
    `tag_id`     int(11) NOT NULL,
    PRIMARY KEY (`project_id`, `tag_id`),
    CONSTRAINT `fk_project_tag_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_project_tag_tag`     FOREIGN KEY (`tag_id`)     REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;


-- 2026-11-04 15:47:46 UTC
