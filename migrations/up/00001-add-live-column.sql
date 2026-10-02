ALTER TABLE `articles`
    ADD COLUMN `live` TINYINT(1) NOT NULL DEFAULT '0' AFTER `image_url`;
