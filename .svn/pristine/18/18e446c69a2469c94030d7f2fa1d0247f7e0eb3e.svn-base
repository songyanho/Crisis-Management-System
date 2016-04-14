<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1456846526.
 * Generated on 2016-03-01 15:35:26 by liyingho
 */
class PropelMigration_1456846526
{
    public $comment = '';

    public function preUp($manager)
    {
        // add the pre-migration code here
    }

    public function postUp($manager)
    {
        // add the post-migration code here
    }

    public function preDown($manager)
    {
        // add the pre-migration code here
    }

    public function postDown($manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'cms' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

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

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'cms' => '
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `resource`;

DROP TABLE IF EXISTS `incident_resource`;

DROP TABLE IF EXISTS `incident_resource_record`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}