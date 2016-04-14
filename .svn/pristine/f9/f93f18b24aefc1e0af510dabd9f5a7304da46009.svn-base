
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `tel` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `descendant_class` VARCHAR(100),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- call_operator
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `call_operator`;

CREATE TABLE `call_operator`
(
    `id` INTEGER NOT NULL,
    `username` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `tel` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    CONSTRAINT `call_operator_fk_ffc53a`
        FOREIGN KEY (`id`)
        REFERENCES `user` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- minister
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `minister`;

CREATE TABLE `minister`
(
    `id` INTEGER NOT NULL,
    `username` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `tel` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    CONSTRAINT `minister_fk_ffc53a`
        FOREIGN KEY (`id`)
        REFERENCES `user` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- key_decision_maker
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `key_decision_maker`;

CREATE TABLE `key_decision_maker`
(
    `id` INTEGER NOT NULL,
    `username` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `tel` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    CONSTRAINT `key_decision_maker_fk_ffc53a`
        FOREIGN KEY (`id`)
        REFERENCES `user` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- agency
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `agency`;

CREATE TABLE `agency`
(
    `id` INTEGER NOT NULL,
    `username` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `tel` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    CONSTRAINT `agency_fk_ffc53a`
        FOREIGN KEY (`id`)
        REFERENCES `user` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- login_session
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `login_session`;

CREATE TABLE `login_session`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `user_type` VARCHAR(255) NOT NULL,
    `user_id` INTEGER NOT NULL,
    `session_id` VARCHAR(255) NOT NULL,
    `session_key` VARCHAR(255) NOT NULL,
    `disabled` TINYINT(1) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- incident
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `incident`;

CREATE TABLE `incident`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `location` VARCHAR(255),
    `latitude` DOUBLE,
    `longitude` DOUBLE,
    `active` TINYINT(1),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- category
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- reporter
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `reporter`;

CREATE TABLE `reporter`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `tel` VARCHAR(255) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- incident_category
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `incident_category`;

CREATE TABLE `incident_category`
(
    `incident_id` INTEGER NOT NULL,
    `category_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`incident_id`,`category_id`),
    INDEX `incident_category_fi_904832` (`category_id`),
    CONSTRAINT `incident_category_fk_13d7a3`
        FOREIGN KEY (`incident_id`)
        REFERENCES `incident` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `incident_category_fk_904832`
        FOREIGN KEY (`category_id`)
        REFERENCES `category` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- incident_reporter
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `incident_reporter`;

CREATE TABLE `incident_reporter`
(
    `incident_id` INTEGER NOT NULL,
    `reporter_id` INTEGER NOT NULL,
    `description` VARCHAR(1000),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`incident_id`,`reporter_id`),
    INDEX `incident_reporter_fi_b5a95c` (`reporter_id`),
    CONSTRAINT `incident_reporter_fk_13d7a3`
        FOREIGN KEY (`incident_id`)
        REFERENCES `incident` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `incident_reporter_fk_b5a95c`
        FOREIGN KEY (`reporter_id`)
        REFERENCES `reporter` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- resource
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `resource`;

CREATE TABLE `resource`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `image` VARCHAR(255) NOT NULL,
    `tel` VARCHAR(255),
    `Sms` TINYINT(1) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- incident_resource
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `incident_resource`;

CREATE TABLE `incident_resource`
(
    `incident_id` INTEGER NOT NULL,
    `resource_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`incident_id`,`resource_id`),
    INDEX `incident_resource_fi_0cb2ad` (`resource_id`),
    CONSTRAINT `incident_resource_fk_13d7a3`
        FOREIGN KEY (`incident_id`)
        REFERENCES `incident` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `incident_resource_fk_0cb2ad`
        FOREIGN KEY (`resource_id`)
        REFERENCES `resource` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- incident_resource_record
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `incident_resource_record`;

CREATE TABLE `incident_resource_record`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `incident_id` INTEGER,
    `resource_id` INTEGER,
    `reporter_id` INTEGER,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`),
    INDEX `incident_resource_record_fi_13d7a3` (`incident_id`),
    INDEX `incident_resource_record_fi_0cb2ad` (`resource_id`),
    INDEX `incident_resource_record_fi_b5a95c` (`reporter_id`),
    CONSTRAINT `incident_resource_record_fk_13d7a3`
        FOREIGN KEY (`incident_id`)
        REFERENCES `incident` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `incident_resource_record_fk_0cb2ad`
        FOREIGN KEY (`resource_id`)
        REFERENCES `resource` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `incident_resource_record_fk_b5a95c`
        FOREIGN KEY (`reporter_id`)
        REFERENCES `reporter` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- information
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `information`;

CREATE TABLE `information`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `content` VARCHAR(1000) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
