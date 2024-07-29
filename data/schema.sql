CREATE
DATABASE `hs_debaiter` /*!40100 COLLATE 'utf8mb4_general_ci' */;

CREATE TABLE `articles`
(
    `id`         INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `guid`       VARCHAR(16)  NOT NULL,
    `title`      VARCHAR(255) NOT NULL,
    `url`        VARCHAR(255) NOT NULL,
    `image_url`  VARCHAR(255) NULL DEFAULT NULL,
    `created_at` TIMESTAMP    NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `guid` (`guid`),
    INDEX        `url` (`url`)
) COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=300
;


CREATE TABLE `article_titles`
(
    `id`         INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `article_id` INT(10) UNSIGNED NOT NULL,
    `created_at` TIMESTAMP    NOT NULL DEFAULT current_timestamp(),
    `title`      VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    INDEX        `article_id_fk` (`article_id`),
    CONSTRAINT `article_id_fk` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON UPDATE CASCADE ON DELETE CASCADE
) COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=197
;

