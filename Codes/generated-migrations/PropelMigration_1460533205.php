<?php

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1460533205.
 * Generated on 2016-04-13 07:40:05 by liyingho
 */
class PropelMigration_1460533205
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

ALTER TABLE `incident`

  ADD `version` INTEGER DEFAULT 0 AFTER `updated_at`;

CREATE TABLE `incident_version`
(
    `id` INTEGER NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `location` VARCHAR(255),
    `latitude` DOUBLE,
    `longitude` DOUBLE,
    `active` TINYINT(1),
    `severity` INTEGER DEFAULT 1,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    `version` INTEGER DEFAULT 0 NOT NULL,
    PRIMARY KEY (`id`,`version`),
    CONSTRAINT `incident_version_fk_db339f`
        FOREIGN KEY (`id`)
        REFERENCES `incident` (`id`)
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

DROP TABLE IF EXISTS `incident_version`;

ALTER TABLE `incident`

  DROP `version`;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
',
);
    }

}