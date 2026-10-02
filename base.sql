-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               11.4.2-MariaDB-ubu2404 - mariadb.org binary distribution
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             12.14.0.7165
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table hs_debaiter.article_test_titles
CREATE TABLE IF NOT EXISTS `article_test_titles` (
                                                     `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                                     `article_id` int(10) unsigned NOT NULL,
                                                     `variant_id` int(10) unsigned NOT NULL,
                                                     `title` varchar(255) NOT NULL,
                                                     PRIMARY KEY (`id`),
                                                     KEY `article_id_variant_id` (`article_id`,`variant_id`),
                                                     FULLTEXT KEY `title` (`title`),
                                                     CONSTRAINT `article_test_titles_article_id_fk` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- Data exporting was unselected.

-- Dumping structure for table hs_debaiter.article_titles
CREATE TABLE IF NOT EXISTS `article_titles` (
                                                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                                `article_id` int(10) unsigned NOT NULL,
                                                `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                                                `title` varchar(255) NOT NULL,
                                                PRIMARY KEY (`id`),
                                                KEY `article_id_fk` (`article_id`),
                                                FULLTEXT KEY `title` (`title`),
                                                CONSTRAINT `article_id_fk` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=73190 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table hs_debaiter.articles
CREATE TABLE IF NOT EXISTS `articles` (
                                          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                                          `guid` varchar(16) NOT NULL,
                                          `category` varchar(255) DEFAULT NULL,
                                          `title` varchar(255) NOT NULL,
                                          `url` varchar(255) NOT NULL,
                                          `image_url` varchar(255) DEFAULT NULL,
                                          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                                          `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                                          PRIMARY KEY (`id`),
                                          UNIQUE KEY `guid` (`guid`),
                                          KEY `url` (`url`),
                                          KEY `category` (`category`),
                                          FULLTEXT KEY `title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=46623 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
