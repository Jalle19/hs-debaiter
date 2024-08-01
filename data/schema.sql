CREATE TABLE `articles`
(
    `id`         INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `guid`       VARCHAR(16)  NOT NULL COLLATE 'utf8mb4_general_ci',
    `title`      VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
    `url`        VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
    `image_url`  VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
    `created_at` TIMESTAMP    NOT NULL DEFAULT current_timestamp(),
    `updated_at` TIMESTAMP NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `guid` (`guid`) USING BTREE,
    INDEX        `url` (`url`) USING BTREE
) COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=414
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

ALTER TABLE `articles`
    ADD COLUMN `category` VARCHAR(255) NULL DEFAULT NULL AFTER `guid`;

ALTER TABLE `articles`
    ADD INDEX `category` (`category`);

UPDATE articles SET image_url = NULL WHERE image_url = ''
