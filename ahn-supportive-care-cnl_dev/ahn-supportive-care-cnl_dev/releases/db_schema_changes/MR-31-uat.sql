-- SQL to create user hierarchies schemas in the UAT databases

-- 1. drop the existing master_projects table
DROP TABLE IF EXISTS `ahn_f4s_uat`.`master_projects`;
DROP TABLE IF EXISTS `ahn_scc_uat`.`master_projects`;
DROP TABLE IF EXISTS `dod_asb_uat`.`master_projects`;
DROP TABLE IF EXISTS `ed_ens_uat`.`master_projects`;
DROP TABLE IF EXISTS `mmg_chet_lilly_uat`.`master_projects`;
DROP TABLE IF EXISTS `mmg_chet_otsuka_uat`.`master_projects`;
DROP TABLE IF EXISTS `mmg_jcc_uat`.`master_projects`;
DROP TABLE IF EXISTS `mmg_lilly_uat`.`master_projects`;
DROP TABLE IF EXISTS `mmg_otsuka_uat`.`master_projects`;
DROP TABLE IF EXISTS `mmg_t2d_uat`.`master_projects`;
DROP TABLE IF EXISTS `mmg_ysc_uat`.`master_projects`;
DROP TABLE IF EXISTS `nami_sd_uat`.`master_projects`;
DROP TABLE IF EXISTS `pfizer_ra_uat`.`master_projects`;
-- *************************************************************************************

-- 2. drop the master_organizations_map table
DROP TABLE IF EXISTS `ahn_f4s_uat`.`master_organizations_map`;
DROP TABLE IF EXISTS `ahn_scc_uat`.`master_organizations_map`;
DROP TABLE IF EXISTS `dod_asb_uat`.`master_organizations_map`;
DROP TABLE IF EXISTS `ed_ens_uat`.`master_organizations_map`;
DROP TABLE IF EXISTS `mmg_chet_lilly_uat`.`master_organizations_map`;
DROP TABLE IF EXISTS `mmg_chet_otsuka_uat`.`master_organizations_map`;
DROP TABLE IF EXISTS `mmg_jcc_uat`.`master_organizations_map`;
DROP TABLE IF EXISTS `mmg_lilly_uat`.`master_organizations_map`;
DROP TABLE IF EXISTS `mmg_otsuka_uat`.`master_organizations_map`;
DROP TABLE IF EXISTS `mmg_t2d_uat`.`master_organizations_map`;
DROP TABLE IF EXISTS `mmg_ysc_uat`.`master_organizations_map`;
DROP TABLE IF EXISTS `nami_sd_uat`.`master_organizations_map`;
DROP TABLE IF EXISTS `pfizer_ra_uat`.`master_organizations_map`;
-- *************************************************************************************

-- 3. create the new master_properties table using the structure of master_organizations
CREATE TABLE `ahn_f4s_uat`.`master_properties` LIKE `ahn_f4s_uat`.`master_organizations`;
CREATE TABLE `ahn_scc_uat`.`master_properties` LIKE `ahn_scc_uat`.`master_organizations`;
CREATE TABLE `dod_asb_uat`.`master_properties` LIKE `dod_asb_uat`.`master_organizations`;
CREATE TABLE `ed_ens_uat`.`master_properties` LIKE `ed_ens_uat`.`master_organizations`;
CREATE TABLE `mmg_chet_lilly_uat`.`master_properties` LIKE `mmg_chet_lilly_uat`.`master_organizations`;
CREATE TABLE `mmg_chet_otsuka_uat`.`master_properties` LIKE `mmg_chet_otsuka_uat`.`master_organizations`;
CREATE TABLE `mmg_jcc_uat`.`master_properties` LIKE `mmg_jcc_uat`.`master_organizations`;
CREATE TABLE `mmg_lilly_uat`.`master_properties` LIKE `mmg_lilly_uat`.`master_organizations`;
CREATE TABLE `mmg_otsuka_uat`.`master_properties` LIKE `mmg_otsuka_uat`.`master_organizations`;
CREATE TABLE `mmg_t2d_uat`.`master_properties` LIKE `mmg_t2d_uat`.`master_organizations`;
CREATE TABLE `mmg_ysc_uat`.`master_properties` LIKE `mmg_ysc_uat`.`master_organizations`;
CREATE TABLE `nami_sd_uat`.`master_properties` LIKE `nami_sd_uat`.`master_organizations`;
CREATE TABLE `pfizer_ra_uat`.`master_properties` LIKE `pfizer_ra_uat`.`master_organizations`;
-- *************************************************************************************

-- 4. insert master_organizations data into master_properties;
INSERT INTO `ahn_f4s_uat`.`master_properties` SELECT * FROM `ahn_f4s_uat`.`master_organizations`;
INSERT INTO `ahn_scc_uat`.`master_properties` SELECT * FROM `ahn_scc_uat`.`master_organizations`;
INSERT INTO `dod_asb_uat`.`master_properties` SELECT * FROM `dod_asb_uat`.`master_organizations`;
INSERT INTO `ed_ens_uat`.`master_properties` SELECT * FROM `ed_ens_uat`.`master_organizations`;
INSERT INTO `mmg_chet_lilly_uat`.`master_properties` SELECT * FROM `mmg_chet_lilly_uat`.`master_organizations`;
INSERT INTO `mmg_chet_otsuka_uat`.`master_properties` SELECT * FROM `mmg_chet_otsuka_uat`.`master_organizations`;
INSERT INTO `mmg_jcc_uat`.`master_properties` SELECT * FROM `mmg_jcc_uat`.`master_organizations`;
INSERT INTO `mmg_lilly_uat`.`master_properties` SELECT * FROM `mmg_lilly_uat`.`master_organizations`;
INSERT INTO `mmg_otsuka_uat`.`master_properties` SELECT * FROM `mmg_otsuka_uat`.`master_organizations`;
INSERT INTO `mmg_t2d_uat`.`master_properties` SELECT * FROM `mmg_t2d_uat`.`master_organizations`;
INSERT INTO `mmg_ysc_uat`.`master_properties` SELECT * FROM `mmg_ysc_uat`.`master_organizations`;
INSERT INTO `nami_sd_uat`.`master_properties` SELECT * FROM `nami_sd_uat`.`master_organizations`;
INSERT INTO `pfizer_ra_uat`.`master_properties` SELECT * FROM `pfizer_ra_uat`.`master_organizations`
-- *************************************************************************************

-- 5. modify the newly created master_properties table schema
ALTER TABLE `ahn_f4s_uat`.`master_properties` DROP COLUMN `organization_name`, CHANGE COLUMN `project_name` `name` VARCHAR(45) NOT NULL ,DROP INDEX `project_name_UNIQUE` , ADD UNIQUE INDEX `name_UNIQUE` (`name` ASC), DROP INDEX `index_organization_name`;
ALTER TABLE `ahn_scc_uat`.`master_properties` DROP COLUMN `organization_name`, CHANGE COLUMN `project_name` `name` VARCHAR(45) NOT NULL ,DROP INDEX `project_name_UNIQUE` , ADD UNIQUE INDEX `name_UNIQUE` (`name` ASC), DROP INDEX `index_organization_name`;
ALTER TABLE `dod_asb_uat`.`master_properties` DROP COLUMN `organization_name`, CHANGE COLUMN `project_name` `name` VARCHAR(45) NOT NULL ,DROP INDEX `project_name_UNIQUE` , ADD UNIQUE INDEX `name_UNIQUE` (`name` ASC), DROP INDEX `index_organization_name`;
ALTER TABLE `ed_ens_uat`.`master_properties` DROP COLUMN `organization_name`, CHANGE COLUMN `project_name` `name` VARCHAR(45) NOT NULL ,DROP INDEX `project_name_UNIQUE` , ADD UNIQUE INDEX `name_UNIQUE` (`name` ASC), DROP INDEX `index_organization_name`;
ALTER TABLE `mmg_chet_lilly_uat`.`master_properties` DROP COLUMN `organization_name`, CHANGE COLUMN `project_name` `name` VARCHAR(45) NOT NULL ,DROP INDEX `project_name_UNIQUE` , ADD UNIQUE INDEX `name_UNIQUE` (`name` ASC), DROP INDEX `index_organization_name`;
ALTER TABLE `mmg_chet_otsuka_uat`.`master_properties` DROP COLUMN `organization_name`, CHANGE COLUMN `project_name` `name` VARCHAR(45) NOT NULL ,DROP INDEX `project_name_UNIQUE` , ADD UNIQUE INDEX `name_UNIQUE` (`name` ASC), DROP INDEX `index_organization_name`;
ALTER TABLE `mmg_jcc_uat`.`master_properties` DROP COLUMN `organization_name`, CHANGE COLUMN `project_name` `name` VARCHAR(45) NOT NULL ,DROP INDEX `project_name_UNIQUE` , ADD UNIQUE INDEX `name_UNIQUE` (`name` ASC), DROP INDEX `index_organization_name`;
ALTER TABLE `mmg_lilly_uat`.`master_properties` DROP COLUMN `organization_name`, CHANGE COLUMN `project_name` `name` VARCHAR(45) NOT NULL ,DROP INDEX `project_name_UNIQUE` , ADD UNIQUE INDEX `name_UNIQUE` (`name` ASC), DROP INDEX `index_organization_name`;
ALTER TABLE `mmg_otsuka_uat`.`master_properties` DROP COLUMN `organization_name`, CHANGE COLUMN `project_name` `name` VARCHAR(45) NOT NULL ,DROP INDEX `project_name_UNIQUE` , ADD UNIQUE INDEX `name_UNIQUE` (`name` ASC), DROP INDEX `index_organization_name`;
ALTER TABLE `mmg_t2d_uat`.`master_properties` DROP COLUMN `organization_name`, CHANGE COLUMN `project_name` `name` VARCHAR(45) NOT NULL ,DROP INDEX `project_name_UNIQUE` , ADD UNIQUE INDEX `name_UNIQUE` (`name` ASC), DROP INDEX `index_organization_name`;
ALTER TABLE `mmg_ysc_uat`.`master_properties` DROP COLUMN `organization_name`, CHANGE COLUMN `project_name` `name` VARCHAR(45) NOT NULL ,DROP INDEX `project_name_UNIQUE` , ADD UNIQUE INDEX `name_UNIQUE` (`name` ASC), DROP INDEX `index_organization_name`;
ALTER TABLE `nami_sd_uat`.`master_properties` DROP COLUMN `organization_name`, CHANGE COLUMN `project_name` `name` VARCHAR(45) NOT NULL ,DROP INDEX `project_name_UNIQUE` , ADD UNIQUE INDEX `name_UNIQUE` (`name` ASC), DROP INDEX `index_organization_name`;
ALTER TABLE `pfizer_ra_uat`.`master_properties` DROP COLUMN `organization_name`, CHANGE COLUMN `project_name` `name` VARCHAR(45) NOT NULL ,DROP INDEX `project_name_UNIQUE` , ADD UNIQUE INDEX `name_UNIQUE` (`name` ASC), DROP INDEX `index_organization_name`;
-- *************************************************************************************

-- 6. rename the existing master_organizations table
RENAME TABLE `ahn_f4s_uat`.`master_organizations` TO `ahn_f4s_uat`.`master_organizations_bak`;
RENAME TABLE `ahn_scc_uat`.`master_organizations` TO `ahn_scc_uat`.`master_organizations_bak`;
RENAME TABLE `dod_asb_uat`.`master_organizations` TO `dod_asb_uat`.`master_organizations_bak`;
RENAME TABLE `ed_ens_uat`.`master_organizations` TO `ed_ens_uat`.`master_organizations_bak`;
RENAME TABLE `mmg_chet_lilly_uat`.`master_organizations` TO `mmg_chet_lilly_uat`.`master_organizations_bak`;
RENAME TABLE `mmg_chet_otsuka_uat`.`master_organizations` TO `mmg_chet_otsuka_uat`.`master_organizations_bak`;
RENAME TABLE `mmg_jcc_uat`.`master_organizations` TO `mmg_jcc_uat`.`master_organizations_bak`;
RENAME TABLE `mmg_lilly_uat`.`master_organizations` TO `mmg_lilly_uat`.`master_organizations_bak`;
RENAME TABLE `mmg_otsuka_uat`.`master_organizations` TO `mmg_otsuka_uat`.`master_organizations_bak`;
RENAME TABLE `mmg_t2d_uat`.`master_organizations` TO `mmg_t2d_uat`.`master_organizations_bak`;
RENAME TABLE `mmg_ysc_uat`.`master_organizations` TO `mmg_ysc_uat`.`master_organizations_bak`;
RENAME TABLE `nami_sd_uat`.`master_organizations` TO `nami_sd_uat`.`master_organizations_bak`;
RENAME TABLE `pfizer_ra_uat`.`master_organizations` TO `pfizer_ra_uat`.`master_organizations_bak`;
-- *************************************************************************************

-- 7. create the new master_organizations table
CREATE TABLE `ahn_f4s_uat`.`master_organizations` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `ahn_scc_uat`.`master_organizations` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `dod_asb_uat`.`master_organizations` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `ed_ens_uat`.`master_organizations` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `mmg_chet_lilly_uat`.`master_organizations` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `mmg_chet_otsuka_uat`.`master_organizations` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `mmg_jcc_uat`.`master_organizations` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `mmg_lilly_uat`.`master_organizations` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `mmg_otsuka_uat`.`master_organizations` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `mmg_t2d_uat`.`master_organizations` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `mmg_ysc_uat`.`master_organizations` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `nami_sd_uat`.`master_organizations` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `pfizer_ra_uat`.`master_organizations` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- *************************************************************************************

-- 8. insert records into the new master_organizations table
-- Current Organizations Below
-- ****************************
-- 'Allegheny Health Network'
-- 'Otsuka'
-- 'Eli Lilly and Company'
-- 'Merck'
-- 'Pfizer'
-- 'MMG'
-- 'Department of Defense'
-- 'NAMI San Diego'
-- 'Oncology Nursing Society' -- @TODO No database yet.  Need to create the DB and insert records for ONS
-- 'Enersource'
-- ****************************
INSERT INTO `ahn_f4s_uat`.`master_organizations` (`name`) VALUES ('MedRespond');
INSERT INTO `ahn_f4s_uat`.`master_organizations` (`name`) VALUES ('Allegheny Health Network');
INSERT INTO `ahn_scc_uat`.`master_organizations` (`name`) VALUES ('MedRespond');
INSERT INTO `ahn_scc_uat`.`master_organizations` (`name`) VALUES ('Allegheny Health Network');
INSERT INTO `dod_asb_uat`.`master_organizations` (`name`) VALUES ('MedRespond');
INSERT INTO `dod_asb_uat`.`master_organizations` (`name`) VALUES ('Department of Defense');
INSERT INTO `ed_ens_uat`.`master_organizations` (`name`) VALUES ('MedRespond');
INSERT INTO `ed_ens_uat`.`master_organizations` (`name`) VALUES ('Enersource');
INSERT INTO `mmg_chet_lilly_uat`.`master_organizations` (`name`) VALUES ('MedRespond');
INSERT INTO `mmg_chet_lilly_uat`.`master_organizations` (`name`) VALUES ('Eli Lilly and Company');
INSERT INTO `mmg_chet_otsuka_uat`.`master_organizations` (`name`) VALUES ('MedRespond');
INSERT INTO `mmg_chet_otsuka_uat`.`master_organizations` (`name`) VALUES ('Otsuka');
INSERT INTO `mmg_jcc_uat`.`master_organizations` (`name`) VALUES ('MedRespond');
INSERT INTO `mmg_jcc_uat`.`master_organizations` (`name`) VALUES ('Eli Lilly and Company');
INSERT INTO `mmg_lilly_uat`.`master_organizations` (`name`) VALUES ('MedRespond');
INSERT INTO `mmg_lilly_uat`.`master_organizations` (`name`) VALUES ('Eli Lilly and Company');
INSERT INTO `mmg_otsuka_uat`.`master_organizations` (`name`) VALUES ('MedRespond');
INSERT INTO `mmg_otsuka_uat`.`master_organizations` (`name`) VALUES ('Otsuka');
INSERT INTO `mmg_t2d_uat`.`master_organizations` (`name`) VALUES ('MedRespond');
INSERT INTO `mmg_t2d_uat`.`master_organizations` (`name`) VALUES ('Merck');
INSERT INTO `mmg_ysc_uat`.`master_organizations` (`name`) VALUES ('MedRespond');
INSERT INTO `mmg_ysc_uat`.`master_organizations` (`name`) VALUES ('Pfizer');
INSERT INTO `nami_sd_uat`.`master_organizations` (`name`) VALUES ('MedRespond');
INSERT INTO `nami_sd_uat`.`master_organizations` (`name`) VALUES ('NAMI San Diego');
INSERT INTO `pfizer_ra_uat`.`master_organizations` (`name`) VALUES ('MedRespond');
INSERT INTO `pfizer_ra_uat`.`master_organizations` (`name`) VALUES ('Pfizer');
-- *************************************************************************************

-- 9. create the master_organization_property_map table
CREATE TABLE `ahn_f4s_uat`.`master_organization_property_map` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`property_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `organization_id_property_id_UNIQUE` (`organization_id`,`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `ahn_scc_uat`.`master_organization_property_map` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`property_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `organization_id_property_id_UNIQUE` (`organization_id`,`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `dod_asb_uat`.`master_organization_property_map` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`property_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `organization_id_property_id_UNIQUE` (`organization_id`,`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `ed_ens_uat`.`master_organization_property_map` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`property_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `organization_id_property_id_UNIQUE` (`organization_id`,`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_chet_lilly_uat`.`master_organization_property_map` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`property_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `organization_id_property_id_UNIQUE` (`organization_id`,`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_chet_otsuka_uat`.`master_organization_property_map` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`property_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `organization_id_property_id_UNIQUE` (`organization_id`,`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_jcc_uat`.`master_organization_property_map` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`property_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `organization_id_property_id_UNIQUE` (`organization_id`,`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_lilly_uat`.`master_organization_property_map` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`property_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `organization_id_property_id_UNIQUE` (`organization_id`,`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_otsuka_uat`.`master_organization_property_map` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`property_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `organization_id_property_id_UNIQUE` (`organization_id`,`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_t2d_uat`.`master_organization_property_map` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`property_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `organization_id_property_id_UNIQUE` (`organization_id`,`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_ysc_uat`.`master_organization_property_map` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`property_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `organization_id_property_id_UNIQUE` (`organization_id`,`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `nami_sd_uat`.`master_organization_property_map` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`property_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `organization_id_property_id_UNIQUE` (`organization_id`,`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `pfizer_ra_uat`.`master_organization_property_map` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`property_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `organization_id_property_id_UNIQUE` (`organization_id`,`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- *************************************************************************************

-- 10. insert master_organization_property_map records
INSERT INTO `ahn_f4s_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organizations` WHERE `name` = 'MedRespond'),
	(SELECT `id` FROM `ahn_f4s_uat`.`master_properties` WHERE `name` = 'f4s')
);
INSERT INTO `ahn_f4s_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network'),
	(SELECT `id` FROM `ahn_f4s_uat`.`master_properties` WHERE `name` = 'f4s')
);
INSERT INTO `ahn_scc_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `ahn_scc_uat`.`master_organizations` WHERE `name` = 'MedRespond'),
	(SELECT `id` FROM `ahn_scc_uat`.`master_properties` WHERE `name` = 'scc')
);
INSERT INTO `ahn_scc_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `ahn_scc_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network'),
	(SELECT `id` FROM `ahn_scc_uat`.`master_properties` WHERE `name` = 'scc')
);
INSERT INTO `dod_asb_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `dod_asb_uat`.`master_organizations` WHERE `name` = 'MedRespond'),
	(SELECT `id` FROM `dod_asb_uat`.`master_properties` WHERE `name` = 'dod')
);
INSERT INTO `dod_asb_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `dod_asb_uat`.`master_organizations` WHERE `name` = 'Department of Defense'),
	(SELECT `id` FROM `dod_asb_uat`.`master_properties` WHERE `name` = 'dod')
);
INSERT INTO `ed_ens_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `ed_ens_uat`.`master_organizations` WHERE `name` = 'MedRespond'),
	(SELECT `id` FROM `ed_ens_uat`.`master_properties` WHERE `name` = 'ens')
);
INSERT INTO `ed_ens_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `ed_ens_uat`.`master_organizations` WHERE `name` = 'Enersource'),
	(SELECT `id` FROM `ed_ens_uat`.`master_properties` WHERE `name` = 'ens')
);
INSERT INTO `mmg_chet_lilly_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `mmg_chet_lilly_uat`.`master_organizations` WHERE `name` = 'MedRespond'),
	(SELECT `id` FROM `mmg_chet_lilly_uat`.`master_properties` WHERE `name` = 'lilly')
);
INSERT INTO `mmg_chet_lilly_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `mmg_chet_lilly_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company'),
	(SELECT `id` FROM `mmg_chet_lilly_uat`.`master_properties` WHERE `name` = 'lilly')
);
INSERT INTO `mmg_chet_otsuka_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `mmg_chet_otsuka_uat`.`master_organizations` WHERE `name` = 'MedRespond'),
	(SELECT `id` FROM `mmg_chet_otsuka_uat`.`master_properties` WHERE `name` = 'otsuka')
);
INSERT INTO `mmg_chet_otsuka_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `mmg_chet_otsuka_uat`.`master_organizations` WHERE `name` = 'Otsuka'),
	(SELECT `id` FROM `mmg_chet_otsuka_uat`.`master_properties` WHERE `name` = 'otsuka')
);
INSERT INTO `mmg_jcc_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `mmg_jcc_uat`.`master_organizations` WHERE `name` = 'MedRespond'),
	(SELECT `id` FROM `mmg_jcc_uat`.`master_properties` WHERE `name` = 'jcc')
);
INSERT INTO `mmg_jcc_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `mmg_jcc_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company'),
	(SELECT `id` FROM `mmg_jcc_uat`.`master_properties` WHERE `name` = 'jcc')
);
INSERT INTO `mmg_lilly_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `mmg_lilly_uat`.`master_organizations` WHERE `name` = 'MedRespond'),
	(SELECT `id` FROM `mmg_lilly_uat`.`master_properties` WHERE `name` = 'lilly')
);
INSERT INTO `mmg_lilly_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `mmg_lilly_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company'),
	(SELECT `id` FROM `mmg_lilly_uat`.`master_properties` WHERE `name` = 'lilly')
);
INSERT INTO `mmg_otsuka_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `mmg_otsuka_uat`.`master_organizations` WHERE `name` = 'MedRespond'),
	(SELECT `id` FROM `mmg_otsuka_uat`.`master_properties` WHERE `name` = 'otsuka')
);
INSERT INTO `mmg_otsuka_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `mmg_otsuka_uat`.`master_organizations` WHERE `name` = 'Otsuka'),
	(SELECT `id` FROM `mmg_otsuka_uat`.`master_properties` WHERE `name` = 'otsuka')
);
INSERT INTO `mmg_t2d_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `mmg_t2d_uat`.`master_organizations` WHERE `name` = 'MedRespond'),
	(SELECT `id` FROM `mmg_t2d_uat`.`master_properties` WHERE `name` = 't2d')
);
INSERT INTO `mmg_t2d_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `mmg_t2d_uat`.`master_organizations` WHERE `name` = 'Merck'),
	(SELECT `id` FROM `mmg_t2d_uat`.`master_properties` WHERE `name` = 't2d')
);
INSERT INTO `mmg_ysc_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `mmg_ysc_uat`.`master_organizations` WHERE `name` = 'MedRespond'),
	(SELECT `id` FROM `mmg_ysc_uat`.`master_properties` WHERE `name` = 'ysc')
);
INSERT INTO `mmg_ysc_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `mmg_ysc_uat`.`master_organizations` WHERE `name` = 'Pfizer'),
	(SELECT `id` FROM `mmg_ysc_uat`.`master_properties` WHERE `name` = 'ysc')
);
INSERT INTO `nami_sd_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `nami_sd_uat`.`master_organizations` WHERE `name` = 'MedRespond'),
	(SELECT `id` FROM `nami_sd_uat`.`master_properties` WHERE `name` = 'nsd')
);
INSERT INTO `nami_sd_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `nami_sd_uat`.`master_organizations` WHERE `name` = 'NAMI San Diego'),
	(SELECT `id` FROM `nami_sd_uat`.`master_properties` WHERE `name` = 'nsd')
);
INSERT INTO `pfizer_ra_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `name` = 'MedRespond'),
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'pra')
);
INSERT INTO `pfizer_ra_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `name` = 'Pfizer'),
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'pra')
);
INSERT INTO `pfizer_ra_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `name` = 'MedRespond'),
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'prb')
);
INSERT INTO `pfizer_ra_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `name` = 'Pfizer'),
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'prb')
);
INSERT INTO `pfizer_ra_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `name` = 'MedRespond'),
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'prc')
);
INSERT INTO `pfizer_ra_uat`.`master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `name` = 'Pfizer'),
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'prc')
);
-- *************************************************************************************

-- 11. master_users_map.organization_id updates
UPDATE `ahn_f4s_uat`.`master_users_map` AS `mum`
JOIN `ahn_f4s_uat`.`master_organizations_bak` AS `mob`
	ON `mob`.`id` = `mum`.`organization_id`
SET `mum`.`organization_id` = CASE
	WHEN `mob`.`organization_name` = 'DoD' THEN (SELECT `id` FROM `ahn_f4s_uat`.`master_organizations` WHERE `name` = 'Department of Defense')
	WHEN `mob`.`organization_name` = 'Enersource' THEN (SELECT `id` FROM `ahn_f4s_uat`.`master_organizations` WHERE `name` = 'Enersource')
	WHEN `mob`.`organization_name` = 'Fit For Surgery' THEN (SELECT `id` FROM `ahn_f4s_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'Lilly JCC' THEN (SELECT `id` FROM `ahn_f4s_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Lilly JPBL' THEN (SELECT `id` FROM `ahn_f4s_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Medrespond' THEN (SELECT `id` FROM `ahn_f4s_uat`.`master_organizations` WHERE `name` = 'MedRespond')
	WHEN `mob`.`organization_name` = 'NAMI SD' THEN (SELECT `id` FROM `ahn_f4s_uat`.`master_organizations` WHERE `name` = 'NAMI San Diego')
	WHEN `mob`.`organization_name` = 'Otsuka' THEN (SELECT `id` FROM `ahn_f4s_uat`.`master_organizations` WHERE `name` = 'Otsuka')
	WHEN `mob`.`organization_name` = 'Pfizer PRA' THEN (SELECT `id` FROM `ahn_f4s_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRB' THEN (SELECT `id` FROM `ahn_f4s_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRC' THEN (SELECT `id` FROM `ahn_f4s_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer YSC' THEN (SELECT `id` FROM `ahn_f4s_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Supportive Care' THEN (SELECT `id` FROM `ahn_f4s_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'T2D' THEN (SELECT `id` FROM `ahn_f4s_uat`.`master_organizations` WHERE `name` = 'Merck')
	ELSE `mum`.`organization_id`
END;
UPDATE `ahn_scc_uat`.`master_users_map` AS `mum`
JOIN `ahn_scc_uat`.`master_organizations_bak` AS `mob`
	ON `mob`.`id` = `mum`.`organization_id`
SET `mum`.`organization_id` = CASE
	WHEN `mob`.`organization_name` = 'DoD' THEN (SELECT `id` FROM `ahn_scc_uat`.`master_organizations` WHERE `name` = 'Department of Defense')
	WHEN `mob`.`organization_name` = 'Enersource' THEN (SELECT `id` FROM `ahn_scc_uat`.`master_organizations` WHERE `name` = 'Enersource')
	WHEN `mob`.`organization_name` = 'Fit For Surgery' THEN (SELECT `id` FROM `ahn_scc_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'Lilly JCC' THEN (SELECT `id` FROM `ahn_scc_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Lilly JPBL' THEN (SELECT `id` FROM `ahn_scc_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Medrespond' THEN (SELECT `id` FROM `ahn_scc_uat`.`master_organizations` WHERE `name` = 'MedRespond')
	WHEN `mob`.`organization_name` = 'NAMI SD' THEN (SELECT `id` FROM `ahn_scc_uat`.`master_organizations` WHERE `name` = 'NAMI San Diego')
	WHEN `mob`.`organization_name` = 'Otsuka' THEN (SELECT `id` FROM `ahn_scc_uat`.`master_organizations` WHERE `name` = 'Otsuka')
	WHEN `mob`.`organization_name` = 'Pfizer PRA' THEN (SELECT `id` FROM `ahn_scc_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRB' THEN (SELECT `id` FROM `ahn_scc_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRC' THEN (SELECT `id` FROM `ahn_scc_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer YSC' THEN (SELECT `id` FROM `ahn_scc_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Supportive Care' THEN (SELECT `id` FROM `ahn_scc_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'T2D' THEN (SELECT `id` FROM `ahn_scc_uat`.`master_organizations` WHERE `name` = 'Merck')
	ELSE `mum`.`organization_id`
END;
UPDATE `dod_asb_uat`.`master_users_map` AS `mum`
JOIN `dod_asb_uat`.`master_organizations_bak` AS `mob`
	ON `mob`.`id` = `mum`.`organization_id`
SET `mum`.`organization_id` = CASE
	WHEN `mob`.`organization_name` = 'DoD' THEN (SELECT `id` FROM `dod_asb_uat`.`master_organizations` WHERE `name` = 'Department of Defense')
	WHEN `mob`.`organization_name` = 'Enersource' THEN (SELECT `id` FROM `dod_asb_uat`.`master_organizations` WHERE `name` = 'Enersource')
	WHEN `mob`.`organization_name` = 'Fit For Surgery' THEN (SELECT `id` FROM `dod_asb_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'Lilly JCC' THEN (SELECT `id` FROM `dod_asb_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Lilly JPBL' THEN (SELECT `id` FROM `dod_asb_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Medrespond' THEN (SELECT `id` FROM `dod_asb_uat`.`master_organizations` WHERE `name` = 'MedRespond')
	WHEN `mob`.`organization_name` = 'NAMI SD' THEN (SELECT `id` FROM `dod_asb_uat`.`master_organizations` WHERE `name` = 'NAMI San Diego')
	WHEN `mob`.`organization_name` = 'Otsuka' THEN (SELECT `id` FROM `dod_asb_uat`.`master_organizations` WHERE `name` = 'Otsuka')
	WHEN `mob`.`organization_name` = 'Pfizer PRA' THEN (SELECT `id` FROM `dod_asb_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRB' THEN (SELECT `id` FROM `dod_asb_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRC' THEN (SELECT `id` FROM `dod_asb_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer YSC' THEN (SELECT `id` FROM `dod_asb_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Supportive Care' THEN (SELECT `id` FROM `dod_asb_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'T2D' THEN (SELECT `id` FROM `dod_asb_uat`.`master_organizations` WHERE `name` = 'Merck')
	ELSE `mum`.`organization_id`
END;
UPDATE `ed_ens_uat`.`master_users_map` AS `mum`
JOIN `ed_ens_uat`.`master_organizations_bak` AS `mob`
	ON `mob`.`id` = `mum`.`organization_id`
SET `mum`.`organization_id` = CASE
	WHEN `mob`.`organization_name` = 'DoD' THEN (SELECT `id` FROM `ed_ens_uat`.`master_organizations` WHERE `name` = 'Department of Defense')
	WHEN `mob`.`organization_name` = 'Enersource' THEN (SELECT `id` FROM `ed_ens_uat`.`master_organizations` WHERE `name` = 'Enersource')
	WHEN `mob`.`organization_name` = 'Fit For Surgery' THEN (SELECT `id` FROM `ed_ens_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'Lilly JCC' THEN (SELECT `id` FROM `ed_ens_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Lilly JPBL' THEN (SELECT `id` FROM `ed_ens_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Medrespond' THEN (SELECT `id` FROM `ed_ens_uat`.`master_organizations` WHERE `name` = 'MedRespond')
	WHEN `mob`.`organization_name` = 'NAMI SD' THEN (SELECT `id` FROM `ed_ens_uat`.`master_organizations` WHERE `name` = 'NAMI San Diego')
	WHEN `mob`.`organization_name` = 'Otsuka' THEN (SELECT `id` FROM `ed_ens_uat`.`master_organizations` WHERE `name` = 'Otsuka')
	WHEN `mob`.`organization_name` = 'Pfizer PRA' THEN (SELECT `id` FROM `ed_ens_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRB' THEN (SELECT `id` FROM `ed_ens_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRC' THEN (SELECT `id` FROM `ed_ens_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer YSC' THEN (SELECT `id` FROM `ed_ens_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Supportive Care' THEN (SELECT `id` FROM `ed_ens_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'T2D' THEN (SELECT `id` FROM `ed_ens_uat`.`master_organizations` WHERE `name` = 'Merck')
	ELSE `mum`.`organization_id`
END;
UPDATE `mmg_chet_lilly_uat`.`master_users_map` AS `mum`
JOIN `mmg_chet_lilly_uat`.`master_organizations_bak` AS `mob`
	ON `mob`.`id` = `mum`.`organization_id`
SET `mum`.`organization_id` = CASE
	WHEN `mob`.`organization_name` = 'DoD' THEN (SELECT `id` FROM `mmg_chet_lilly_uat`.`master_organizations` WHERE `name` = 'Department of Defense')
	WHEN `mob`.`organization_name` = 'Enersource' THEN (SELECT `id` FROM `mmg_chet_lilly_uat`.`master_organizations` WHERE `name` = 'Enersource')
	WHEN `mob`.`organization_name` = 'Fit For Surgery' THEN (SELECT `id` FROM `mmg_chet_lilly_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'Lilly JCC' THEN (SELECT `id` FROM `mmg_chet_lilly_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Lilly JPBL' THEN (SELECT `id` FROM `mmg_chet_lilly_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Medrespond' THEN (SELECT `id` FROM `mmg_chet_lilly_uat`.`master_organizations` WHERE `name` = 'MedRespond')
	WHEN `mob`.`organization_name` = 'NAMI SD' THEN (SELECT `id` FROM `mmg_chet_lilly_uat`.`master_organizations` WHERE `name` = 'NAMI San Diego')
	WHEN `mob`.`organization_name` = 'Otsuka' THEN (SELECT `id` FROM `mmg_chet_lilly_uat`.`master_organizations` WHERE `name` = 'Otsuka')
	WHEN `mob`.`organization_name` = 'Pfizer PRA' THEN (SELECT `id` FROM `mmg_chet_lilly_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRB' THEN (SELECT `id` FROM `mmg_chet_lilly_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRC' THEN (SELECT `id` FROM `mmg_chet_lilly_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer YSC' THEN (SELECT `id` FROM `mmg_chet_lilly_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Supportive Care' THEN (SELECT `id` FROM `mmg_chet_lilly_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'T2D' THEN (SELECT `id` FROM `mmg_chet_lilly_uat`.`master_organizations` WHERE `name` = 'Merck')
	ELSE `mum`.`organization_id`
END;
UPDATE `mmg_chet_otsuka_uat`.`master_users_map` AS `mum`
JOIN `mmg_chet_otsuka_uat`.`master_organizations_bak` AS `mob`
	ON `mob`.`id` = `mum`.`organization_id`
SET `mum`.`organization_id` = CASE
	WHEN `mob`.`organization_name` = 'DoD' THEN (SELECT `id` FROM `mmg_chet_otsuka_uat`.`master_organizations` WHERE `name` = 'Department of Defense')
	WHEN `mob`.`organization_name` = 'Enersource' THEN (SELECT `id` FROM `mmg_chet_otsuka_uat`.`master_organizations` WHERE `name` = 'Enersource')
	WHEN `mob`.`organization_name` = 'Fit For Surgery' THEN (SELECT `id` FROM `mmg_chet_otsuka_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'Lilly JCC' THEN (SELECT `id` FROM `mmg_chet_otsuka_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Lilly JPBL' THEN (SELECT `id` FROM `mmg_chet_otsuka_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Medrespond' THEN (SELECT `id` FROM `mmg_chet_otsuka_uat`.`master_organizations` WHERE `name` = 'MedRespond')
	WHEN `mob`.`organization_name` = 'NAMI SD' THEN (SELECT `id` FROM `mmg_chet_otsuka_uat`.`master_organizations` WHERE `name` = 'NAMI San Diego')
	WHEN `mob`.`organization_name` = 'Otsuka' THEN (SELECT `id` FROM `mmg_chet_otsuka_uat`.`master_organizations` WHERE `name` = 'Otsuka')
	WHEN `mob`.`organization_name` = 'Pfizer PRA' THEN (SELECT `id` FROM `mmg_chet_otsuka_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRB' THEN (SELECT `id` FROM `mmg_chet_otsuka_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRC' THEN (SELECT `id` FROM `mmg_chet_otsuka_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer YSC' THEN (SELECT `id` FROM `mmg_chet_otsuka_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Supportive Care' THEN (SELECT `id` FROM `mmg_chet_otsuka_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'T2D' THEN (SELECT `id` FROM `mmg_chet_otsuka_uat`.`master_organizations` WHERE `name` = 'Merck')
	ELSE `mum`.`organization_id`
END;
UPDATE `mmg_jcc_uat`.`master_users_map` AS `mum`
JOIN `mmg_jcc_uat`.`master_organizations_bak` AS `mob`
	ON `mob`.`id` = `mum`.`organization_id`
SET `mum`.`organization_id` = CASE
	WHEN `mob`.`organization_name` = 'DoD' THEN (SELECT `id` FROM `mmg_jcc_uat`.`master_organizations` WHERE `name` = 'Department of Defense')
	WHEN `mob`.`organization_name` = 'Enersource' THEN (SELECT `id` FROM `mmg_jcc_uat`.`master_organizations` WHERE `name` = 'Enersource')
	WHEN `mob`.`organization_name` = 'Fit For Surgery' THEN (SELECT `id` FROM `mmg_jcc_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'Lilly JCC' THEN (SELECT `id` FROM `mmg_jcc_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Lilly JPBL' THEN (SELECT `id` FROM `mmg_jcc_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Medrespond' THEN (SELECT `id` FROM `mmg_jcc_uat`.`master_organizations` WHERE `name` = 'MedRespond')
	WHEN `mob`.`organization_name` = 'NAMI SD' THEN (SELECT `id` FROM `mmg_jcc_uat`.`master_organizations` WHERE `name` = 'NAMI San Diego')
	WHEN `mob`.`organization_name` = 'Otsuka' THEN (SELECT `id` FROM `mmg_jcc_uat`.`master_organizations` WHERE `name` = 'Otsuka')
	WHEN `mob`.`organization_name` = 'Pfizer PRA' THEN (SELECT `id` FROM `mmg_jcc_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRB' THEN (SELECT `id` FROM `mmg_jcc_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRC' THEN (SELECT `id` FROM `mmg_jcc_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer YSC' THEN (SELECT `id` FROM `mmg_jcc_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Supportive Care' THEN (SELECT `id` FROM `mmg_jcc_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'T2D' THEN (SELECT `id` FROM `mmg_jcc_uat`.`master_organizations` WHERE `name` = 'Merck')
	ELSE `mum`.`organization_id`
END;
UPDATE `mmg_lilly_uat`.`master_users_map` AS `mum`
JOIN `mmg_lilly_uat`.`master_organizations_bak` AS `mob`
	ON `mob`.`id` = `mum`.`organization_id`
SET `mum`.`organization_id` = CASE
	WHEN `mob`.`organization_name` = 'DoD' THEN (SELECT `id` FROM `mmg_lilly_uat`.`master_organizations` WHERE `name` = 'Department of Defense')
	WHEN `mob`.`organization_name` = 'Enersource' THEN (SELECT `id` FROM `mmg_lilly_uat`.`master_organizations` WHERE `name` = 'Enersource')
	WHEN `mob`.`organization_name` = 'Fit For Surgery' THEN (SELECT `id` FROM `mmg_lilly_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'Lilly JCC' THEN (SELECT `id` FROM `mmg_lilly_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Lilly JPBL' THEN (SELECT `id` FROM `mmg_lilly_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Medrespond' THEN (SELECT `id` FROM `mmg_lilly_uat`.`master_organizations` WHERE `name` = 'MedRespond')
	WHEN `mob`.`organization_name` = 'NAMI SD' THEN (SELECT `id` FROM `mmg_lilly_uat`.`master_organizations` WHERE `name` = 'NAMI San Diego')
	WHEN `mob`.`organization_name` = 'Otsuka' THEN (SELECT `id` FROM `mmg_lilly_uat`.`master_organizations` WHERE `name` = 'Otsuka')
	WHEN `mob`.`organization_name` = 'Pfizer PRA' THEN (SELECT `id` FROM `mmg_lilly_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRB' THEN (SELECT `id` FROM `mmg_lilly_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRC' THEN (SELECT `id` FROM `mmg_lilly_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer YSC' THEN (SELECT `id` FROM `mmg_lilly_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Supportive Care' THEN (SELECT `id` FROM `mmg_lilly_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'T2D' THEN (SELECT `id` FROM `mmg_lilly_uat`.`master_organizations` WHERE `name` = 'Merck')
	ELSE `mum`.`organization_id`
END;
UPDATE `mmg_otsuka_uat`.`master_users_map` AS `mum`
JOIN `mmg_otsuka_uat`.`master_organizations_bak` AS `mob`
	ON `mob`.`id` = `mum`.`organization_id`
SET `mum`.`organization_id` = CASE
	WHEN `mob`.`organization_name` = 'DoD' THEN (SELECT `id` FROM `mmg_otsuka_uat`.`master_organizations` WHERE `name` = 'Department of Defense')
	WHEN `mob`.`organization_name` = 'Enersource' THEN (SELECT `id` FROM `mmg_otsuka_uat`.`master_organizations` WHERE `name` = 'Enersource')
	WHEN `mob`.`organization_name` = 'Fit For Surgery' THEN (SELECT `id` FROM `mmg_otsuka_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'Lilly JCC' THEN (SELECT `id` FROM `mmg_otsuka_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Lilly JPBL' THEN (SELECT `id` FROM `mmg_otsuka_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Medrespond' THEN (SELECT `id` FROM `mmg_otsuka_uat`.`master_organizations` WHERE `name` = 'MedRespond')
	WHEN `mob`.`organization_name` = 'NAMI SD' THEN (SELECT `id` FROM `mmg_otsuka_uat`.`master_organizations` WHERE `name` = 'NAMI San Diego')
	WHEN `mob`.`organization_name` = 'Otsuka' THEN (SELECT `id` FROM `mmg_otsuka_uat`.`master_organizations` WHERE `name` = 'Otsuka')
	WHEN `mob`.`organization_name` = 'Pfizer PRA' THEN (SELECT `id` FROM `mmg_otsuka_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRB' THEN (SELECT `id` FROM `mmg_otsuka_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRC' THEN (SELECT `id` FROM `mmg_otsuka_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer YSC' THEN (SELECT `id` FROM `mmg_otsuka_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Supportive Care' THEN (SELECT `id` FROM `mmg_otsuka_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'T2D' THEN (SELECT `id` FROM `mmg_otsuka_uat`.`master_organizations` WHERE `name` = 'Merck')
	ELSE `mum`.`organization_id`
END;
UPDATE `mmg_t2d_uat`.`master_users_map` AS `mum`
JOIN `mmg_t2d_uat`.`master_organizations_bak` AS `mob`
	ON `mob`.`id` = `mum`.`organization_id`
SET `mum`.`organization_id` = CASE
	WHEN `mob`.`organization_name` = 'DoD' THEN (SELECT `id` FROM `mmg_t2d_uat`.`master_organizations` WHERE `name` = 'Department of Defense')
	WHEN `mob`.`organization_name` = 'Enersource' THEN (SELECT `id` FROM `mmg_t2d_uat`.`master_organizations` WHERE `name` = 'Enersource')
	WHEN `mob`.`organization_name` = 'Fit For Surgery' THEN (SELECT `id` FROM `mmg_t2d_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'Lilly JCC' THEN (SELECT `id` FROM `mmg_t2d_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Lilly JPBL' THEN (SELECT `id` FROM `mmg_t2d_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Medrespond' THEN (SELECT `id` FROM `mmg_t2d_uat`.`master_organizations` WHERE `name` = 'MedRespond')
	WHEN `mob`.`organization_name` = 'NAMI SD' THEN (SELECT `id` FROM `mmg_t2d_uat`.`master_organizations` WHERE `name` = 'NAMI San Diego')
	WHEN `mob`.`organization_name` = 'Otsuka' THEN (SELECT `id` FROM `mmg_t2d_uat`.`master_organizations` WHERE `name` = 'Otsuka')
	WHEN `mob`.`organization_name` = 'Pfizer PRA' THEN (SELECT `id` FROM `mmg_t2d_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRB' THEN (SELECT `id` FROM `mmg_t2d_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRC' THEN (SELECT `id` FROM `mmg_t2d_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer YSC' THEN (SELECT `id` FROM `mmg_t2d_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Supportive Care' THEN (SELECT `id` FROM `mmg_t2d_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'T2D' THEN (SELECT `id` FROM `mmg_t2d_uat`.`master_organizations` WHERE `name` = 'Merck')
	ELSE `mum`.`organization_id`
END;
UPDATE `mmg_ysc_uat`.`master_users_map` AS `mum`
JOIN `mmg_ysc_uat`.`master_organizations_bak` AS `mob`
	ON `mob`.`id` = `mum`.`organization_id`
SET `mum`.`organization_id` = CASE
	WHEN `mob`.`organization_name` = 'DoD' THEN (SELECT `id` FROM `mmg_ysc_uat`.`master_organizations` WHERE `name` = 'Department of Defense')
	WHEN `mob`.`organization_name` = 'Enersource' THEN (SELECT `id` FROM `mmg_ysc_uat`.`master_organizations` WHERE `name` = 'Enersource')
	WHEN `mob`.`organization_name` = 'Fit For Surgery' THEN (SELECT `id` FROM `mmg_ysc_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'Lilly JCC' THEN (SELECT `id` FROM `mmg_ysc_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Lilly JPBL' THEN (SELECT `id` FROM `mmg_ysc_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Medrespond' THEN (SELECT `id` FROM `mmg_ysc_uat`.`master_organizations` WHERE `name` = 'MedRespond')
	WHEN `mob`.`organization_name` = 'NAMI SD' THEN (SELECT `id` FROM `mmg_ysc_uat`.`master_organizations` WHERE `name` = 'NAMI San Diego')
	WHEN `mob`.`organization_name` = 'Otsuka' THEN (SELECT `id` FROM `mmg_ysc_uat`.`master_organizations` WHERE `name` = 'Otsuka')
	WHEN `mob`.`organization_name` = 'Pfizer PRA' THEN (SELECT `id` FROM `mmg_ysc_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRB' THEN (SELECT `id` FROM `mmg_ysc_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRC' THEN (SELECT `id` FROM `mmg_ysc_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer YSC' THEN (SELECT `id` FROM `mmg_ysc_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Supportive Care' THEN (SELECT `id` FROM `mmg_ysc_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'T2D' THEN (SELECT `id` FROM `mmg_ysc_uat`.`master_organizations` WHERE `name` = 'Merck')
	ELSE `mum`.`organization_id`
END;
UPDATE `nami_sd_uat`.`master_users_map` AS `mum`
JOIN `nami_sd_uat`.`master_organizations_bak` AS `mob`
	ON `mob`.`id` = `mum`.`organization_id`
SET `mum`.`organization_id` = CASE
	WHEN `mob`.`organization_name` = 'DoD' THEN (SELECT `id` FROM `nami_sd_uat`.`master_organizations` WHERE `name` = 'Department of Defense')
	WHEN `mob`.`organization_name` = 'Enersource' THEN (SELECT `id` FROM `nami_sd_uat`.`master_organizations` WHERE `name` = 'Enersource')
	WHEN `mob`.`organization_name` = 'Fit For Surgery' THEN (SELECT `id` FROM `nami_sd_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'Lilly JCC' THEN (SELECT `id` FROM `nami_sd_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Lilly JPBL' THEN (SELECT `id` FROM `nami_sd_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Medrespond' THEN (SELECT `id` FROM `nami_sd_uat`.`master_organizations` WHERE `name` = 'MedRespond')
	WHEN `mob`.`organization_name` = 'NAMI SD' THEN (SELECT `id` FROM `nami_sd_uat`.`master_organizations` WHERE `name` = 'NAMI San Diego')
	WHEN `mob`.`organization_name` = 'Otsuka' THEN (SELECT `id` FROM `nami_sd_uat`.`master_organizations` WHERE `name` = 'Otsuka')
	WHEN `mob`.`organization_name` = 'Pfizer PRA' THEN (SELECT `id` FROM `nami_sd_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRB' THEN (SELECT `id` FROM `nami_sd_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRC' THEN (SELECT `id` FROM `nami_sd_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer YSC' THEN (SELECT `id` FROM `nami_sd_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Supportive Care' THEN (SELECT `id` FROM `nami_sd_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'T2D' THEN (SELECT `id` FROM `nami_sd_uat`.`master_organizations` WHERE `name` = 'Merck')
	ELSE `mum`.`organization_id`
END;
UPDATE `pfizer_ra_uat`.`master_users_map` AS `mum`
JOIN `pfizer_ra_uat`.`master_organizations_bak` AS `mob`
	ON `mob`.`id` = `mum`.`organization_id`
SET `mum`.`organization_id` = CASE
	WHEN `mob`.`organization_name` = 'DoD' THEN (SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `name` = 'Department of Defense')
	WHEN `mob`.`organization_name` = 'Enersource' THEN (SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `name` = 'Enersource')
	WHEN `mob`.`organization_name` = 'Fit For Surgery' THEN (SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'Lilly JCC' THEN (SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Lilly JPBL' THEN (SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Medrespond' THEN (SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `name` = 'MedRespond')
	WHEN `mob`.`organization_name` = 'NAMI SD' THEN (SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `name` = 'NAMI San Diego')
	WHEN `mob`.`organization_name` = 'Otsuka' THEN (SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `name` = 'Otsuka')
	WHEN `mob`.`organization_name` = 'Pfizer PRA' THEN (SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRB' THEN (SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRC' THEN (SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer YSC' THEN (SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Supportive Care' THEN (SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'T2D' THEN (SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `name` = 'Merck')
	ELSE `mum`.`organization_id`
END;

-- *************************************************************************************

-- 12. drop the master_organizations_bak table
DROP TABLE IF EXISTS `ahn_f4s_uat`.`master_organizations_bak`;
DROP TABLE IF EXISTS `ahn_scc_uat`.`master_organizations_bak`;
DROP TABLE IF EXISTS `dod_asb_uat`.`master_organizations_bak`;
DROP TABLE IF EXISTS `ed_ens_uat`.`master_organizations_bak`;
DROP TABLE IF EXISTS `mmg_chet_lilly_uat`.`master_organizations_bak`;
DROP TABLE IF EXISTS `mmg_chet_otsuka_uat`.`master_organizations_bak`;
DROP TABLE IF EXISTS `mmg_jcc_uat`.`master_organizations_bak`;
DROP TABLE IF EXISTS `mmg_lilly_uat`.`master_organizations_bak`;
DROP TABLE IF EXISTS `mmg_otsuka_uat`.`master_organizations_bak`;
DROP TABLE IF EXISTS `mmg_t2d_uat`.`master_organizations_bak`;
DROP TABLE IF EXISTS `mmg_ysc_uat`.`master_organizations_bak`;
DROP TABLE IF EXISTS `nami_sd_uat`.`master_organizations_bak`;
DROP TABLE IF EXISTS `pfizer_ra_uat`.`master_organizations_bak`;
-- *************************************************************************************

-- 13. create master_organization_hierarchy_levels table
CREATE TABLE `ahn_f4s_uat`.`master_organization_hierarchy_levels` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`plural_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`parent_id` int(11) unsigned DEFAULT NULL,
	`multi_sibling_membership_allowed` bit(1) NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `ahn_scc_uat`.`master_organization_hierarchy_levels` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`plural_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`parent_id` int(11) unsigned DEFAULT NULL,
	`multi_sibling_membership_allowed` bit(1) NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `dod_asb_uat`.`master_organization_hierarchy_levels` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`plural_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`parent_id` int(11) unsigned DEFAULT NULL,
	`multi_sibling_membership_allowed` bit(1) NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `ed_ens_uat`.`master_organization_hierarchy_levels` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`plural_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`parent_id` int(11) unsigned DEFAULT NULL,
	`multi_sibling_membership_allowed` bit(1) NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_chet_lilly_uat`.`master_organization_hierarchy_levels` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`plural_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`parent_id` int(11) unsigned DEFAULT NULL,
	`multi_sibling_membership_allowed` bit(1) NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_chet_otsuka_uat`.`master_organization_hierarchy_levels` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`plural_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`parent_id` int(11) unsigned DEFAULT NULL,
	`multi_sibling_membership_allowed` bit(1) NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_jcc_uat`.`master_organization_hierarchy_levels` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`plural_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`parent_id` int(11) unsigned DEFAULT NULL,
	`multi_sibling_membership_allowed` bit(1) NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_lilly_uat`.`master_organization_hierarchy_levels` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`plural_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`parent_id` int(11) unsigned DEFAULT NULL,
	`multi_sibling_membership_allowed` bit(1) NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_otsuka_uat`.`master_organization_hierarchy_levels` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`plural_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`parent_id` int(11) unsigned DEFAULT NULL,
	`multi_sibling_membership_allowed` bit(1) NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_t2d_uat`.`master_organization_hierarchy_levels` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`plural_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`parent_id` int(11) unsigned DEFAULT NULL,
	`multi_sibling_membership_allowed` bit(1) NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_ysc_uat`.`master_organization_hierarchy_levels` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`plural_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`parent_id` int(11) unsigned DEFAULT NULL,
	`multi_sibling_membership_allowed` bit(1) NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `nami_sd_uat`.`master_organization_hierarchy_levels` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`plural_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`parent_id` int(11) unsigned DEFAULT NULL,
	`multi_sibling_membership_allowed` bit(1) NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `pfizer_ra_uat`.`master_organization_hierarchy_levels` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`plural_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`parent_id` int(11) unsigned DEFAULT NULL,
	`multi_sibling_membership_allowed` bit(1) NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- *************************************************************************************

-- 14. create master_organization_hierarchy_level_elements table
CREATE TABLE `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `ahn_scc_uat`.`master_organization_hierarchy_level_elements` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `dod_asb_uat`.`master_organization_hierarchy_level_elements` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `ed_ens_uat`.`master_organization_hierarchy_level_elements` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_chet_lilly_uat`.`master_organization_hierarchy_level_elements` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_chet_otsuka_uat`.`master_organization_hierarchy_level_elements` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_jcc_uat`.`master_organization_hierarchy_level_elements` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_lilly_uat`.`master_organization_hierarchy_level_elements` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_otsuka_uat`.`master_organization_hierarchy_level_elements` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_t2d_uat`.`master_organization_hierarchy_level_elements` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_ysc_uat`.`master_organization_hierarchy_level_elements` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `nami_sd_uat`.`master_organization_hierarchy_level_elements` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `pfizer_ra_uat`.`master_organization_hierarchy_level_elements` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- *************************************************************************************

-- 15. create master_organization_hierarchy_level_element_relationship_map table
CREATE TABLE `ahn_f4s_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_element_parent_id` INT(11) UNSIGNED,
	`organization_hierarchy_level_element_id` INT(11) UNSIGNED NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `relationship_UNIQUE` (`organization_hierarchy_level_element_parent_id` ASC, `organization_hierarchy_level_element_id` ASC));
CREATE TABLE `ahn_scc_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_element_parent_id` INT(11) UNSIGNED,
	`organization_hierarchy_level_element_id` INT(11) UNSIGNED NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `relationship_UNIQUE` (`organization_hierarchy_level_element_parent_id` ASC, `organization_hierarchy_level_element_id` ASC));
CREATE TABLE `dod_asb_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_element_parent_id` INT(11) UNSIGNED,
	`organization_hierarchy_level_element_id` INT(11) UNSIGNED NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `relationship_UNIQUE` (`organization_hierarchy_level_element_parent_id` ASC, `organization_hierarchy_level_element_id` ASC));
CREATE TABLE `ed_ens_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_element_parent_id` INT(11) UNSIGNED,
	`organization_hierarchy_level_element_id` INT(11) UNSIGNED NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `relationship_UNIQUE` (`organization_hierarchy_level_element_parent_id` ASC, `organization_hierarchy_level_element_id` ASC));
CREATE TABLE `mmg_chet_lilly_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_element_parent_id` INT(11) UNSIGNED,
	`organization_hierarchy_level_element_id` INT(11) UNSIGNED NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `relationship_UNIQUE` (`organization_hierarchy_level_element_parent_id` ASC, `organization_hierarchy_level_element_id` ASC));
CREATE TABLE `mmg_chet_otsuka_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_element_parent_id` INT(11) UNSIGNED,
	`organization_hierarchy_level_element_id` INT(11) UNSIGNED NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `relationship_UNIQUE` (`organization_hierarchy_level_element_parent_id` ASC, `organization_hierarchy_level_element_id` ASC));
CREATE TABLE `mmg_jcc_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_element_parent_id` INT(11) UNSIGNED,
	`organization_hierarchy_level_element_id` INT(11) UNSIGNED NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `relationship_UNIQUE` (`organization_hierarchy_level_element_parent_id` ASC, `organization_hierarchy_level_element_id` ASC));
CREATE TABLE `mmg_lilly_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_element_parent_id` INT(11) UNSIGNED,
	`organization_hierarchy_level_element_id` INT(11) UNSIGNED NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `relationship_UNIQUE` (`organization_hierarchy_level_element_parent_id` ASC, `organization_hierarchy_level_element_id` ASC));
CREATE TABLE `mmg_otsuka_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_element_parent_id` INT(11) UNSIGNED,
	`organization_hierarchy_level_element_id` INT(11) UNSIGNED NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `relationship_UNIQUE` (`organization_hierarchy_level_element_parent_id` ASC, `organization_hierarchy_level_element_id` ASC));
CREATE TABLE `mmg_t2d_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_element_parent_id` INT(11) UNSIGNED,
	`organization_hierarchy_level_element_id` INT(11) UNSIGNED NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `relationship_UNIQUE` (`organization_hierarchy_level_element_parent_id` ASC, `organization_hierarchy_level_element_id` ASC));
CREATE TABLE `mmg_ysc_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_element_parent_id` INT(11) UNSIGNED,
	`organization_hierarchy_level_element_id` INT(11) UNSIGNED NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `relationship_UNIQUE` (`organization_hierarchy_level_element_parent_id` ASC, `organization_hierarchy_level_element_id` ASC));
CREATE TABLE `nami_sd_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_element_parent_id` INT(11) UNSIGNED,
	`organization_hierarchy_level_element_id` INT(11) UNSIGNED NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `relationship_UNIQUE` (`organization_hierarchy_level_element_parent_id` ASC, `organization_hierarchy_level_element_id` ASC));
CREATE TABLE `pfizer_ra_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_element_parent_id` INT(11) UNSIGNED,
	`organization_hierarchy_level_element_id` INT(11) UNSIGNED NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `relationship_UNIQUE` (`organization_hierarchy_level_element_parent_id` ASC, `organization_hierarchy_level_element_id` ASC));
-- *************************************************************************************

-- 16. create master_users_organization_hierarchy_level_element_map table
CREATE TABLE `ahn_f4s_uat`.`master_users_organization_hierarchy_level_element_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(11) unsigned NOT NULL,
	`organization_hierarchy_level_element_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `ahn_scc_uat`.`master_users_organization_hierarchy_level_element_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(11) unsigned NOT NULL,
	`organization_hierarchy_level_element_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `dod_asb_uat`.`master_users_organization_hierarchy_level_element_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(11) unsigned NOT NULL,
	`organization_hierarchy_level_element_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `ed_ens_uat`.`master_users_organization_hierarchy_level_element_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(11) unsigned NOT NULL,
	`organization_hierarchy_level_element_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_chet_lilly_uat`.`master_users_organization_hierarchy_level_element_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(11) unsigned NOT NULL,
	`organization_hierarchy_level_element_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_chet_otsuka_uat`.`master_users_organization_hierarchy_level_element_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(11) unsigned NOT NULL,
	`organization_hierarchy_level_element_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_jcc_uat`.`master_users_organization_hierarchy_level_element_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(11) unsigned NOT NULL,
	`organization_hierarchy_level_element_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_lilly_uat`.`master_users_organization_hierarchy_level_element_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(11) unsigned NOT NULL,
	`organization_hierarchy_level_element_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_otsuka_uat`.`master_users_organization_hierarchy_level_element_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(11) unsigned NOT NULL,
	`organization_hierarchy_level_element_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_t2d_uat`.`master_users_organization_hierarchy_level_element_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(11) unsigned NOT NULL,
	`organization_hierarchy_level_element_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_ysc_uat`.`master_users_organization_hierarchy_level_element_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(11) unsigned NOT NULL,
	`organization_hierarchy_level_element_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `nami_sd_uat`.`master_users_organization_hierarchy_level_element_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(11) unsigned NOT NULL,
	`organization_hierarchy_level_element_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `pfizer_ra_uat`.`master_users_organization_hierarchy_level_element_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(11) unsigned NOT NULL,
	`organization_hierarchy_level_element_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- *************************************************************************************

-- 17. create master_user_type_organization_hierarchy_level_map table
CREATE TABLE `ahn_f4s_uat`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id` INT(11) UNSIGNED NOT NULL,
	`organization_hierarchy_level_id` INT(11) UNSIGNED NOT NULL,
	`display` BIT(1) NOT NULL,
	`required` BIT(1) NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`user_type_id`, `organization_hierarchy_level_id`));
CREATE TABLE `ahn_scc_uat`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id` INT(11) UNSIGNED NOT NULL,
	`organization_hierarchy_level_id` INT(11) UNSIGNED NOT NULL,
	`display` BIT(1) NOT NULL,
	`required` BIT(1) NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`user_type_id`, `organization_hierarchy_level_id`));
CREATE TABLE `dod_asb_uat`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id` INT(11) UNSIGNED NOT NULL,
	`organization_hierarchy_level_id` INT(11) UNSIGNED NOT NULL,
	`display` BIT(1) NOT NULL,
	`required` BIT(1) NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`user_type_id`, `organization_hierarchy_level_id`));
CREATE TABLE `ed_ens_uat`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id` INT(11) UNSIGNED NOT NULL,
	`organization_hierarchy_level_id` INT(11) UNSIGNED NOT NULL,
	`display` BIT(1) NOT NULL,
	`required` BIT(1) NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`user_type_id`, `organization_hierarchy_level_id`));
CREATE TABLE `mmg_chet_lilly_uat`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id` INT(11) UNSIGNED NOT NULL,
	`organization_hierarchy_level_id` INT(11) UNSIGNED NOT NULL,
	`display` BIT(1) NOT NULL,
	`required` BIT(1) NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`user_type_id`, `organization_hierarchy_level_id`));
CREATE TABLE `mmg_chet_otsuka_uat`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id` INT(11) UNSIGNED NOT NULL,
	`organization_hierarchy_level_id` INT(11) UNSIGNED NOT NULL,
	`display` BIT(1) NOT NULL,
	`required` BIT(1) NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`user_type_id`, `organization_hierarchy_level_id`));
CREATE TABLE `mmg_jcc_uat`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id` INT(11) UNSIGNED NOT NULL,
	`organization_hierarchy_level_id` INT(11) UNSIGNED NOT NULL,
	`display` BIT(1) NOT NULL,
	`required` BIT(1) NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`user_type_id`, `organization_hierarchy_level_id`));
CREATE TABLE `mmg_lilly_uat`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id` INT(11) UNSIGNED NOT NULL,
	`organization_hierarchy_level_id` INT(11) UNSIGNED NOT NULL,
	`display` BIT(1) NOT NULL,
	`required` BIT(1) NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`user_type_id`, `organization_hierarchy_level_id`));
CREATE TABLE `mmg_otsuka_uat`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id` INT(11) UNSIGNED NOT NULL,
	`organization_hierarchy_level_id` INT(11) UNSIGNED NOT NULL,
	`display` BIT(1) NOT NULL,
	`required` BIT(1) NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`user_type_id`, `organization_hierarchy_level_id`));
CREATE TABLE `mmg_t2d_uat`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id` INT(11) UNSIGNED NOT NULL,
	`organization_hierarchy_level_id` INT(11) UNSIGNED NOT NULL,
	`display` BIT(1) NOT NULL,
	`required` BIT(1) NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`user_type_id`, `organization_hierarchy_level_id`));
CREATE TABLE `mmg_ysc_uat`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id` INT(11) UNSIGNED NOT NULL,
	`organization_hierarchy_level_id` INT(11) UNSIGNED NOT NULL,
	`display` BIT(1) NOT NULL,
	`required` BIT(1) NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`user_type_id`, `organization_hierarchy_level_id`));
CREATE TABLE `nami_sd_uat`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id` INT(11) UNSIGNED NOT NULL,
	`organization_hierarchy_level_id` INT(11) UNSIGNED NOT NULL,
	`display` BIT(1) NOT NULL,
	`required` BIT(1) NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`user_type_id`, `organization_hierarchy_level_id`));
CREATE TABLE `pfizer_ra_uat`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id` INT(11) UNSIGNED NOT NULL,
	`organization_hierarchy_level_id` INT(11) UNSIGNED NOT NULL,
	`display` BIT(1) NOT NULL,
	`required` BIT(1) NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`user_type_id`, `organization_hierarchy_level_id`));
-- *************************************************************************************

-- 18. insert master_organization_hierarchy_levels records for Fit For Surgery
INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_levels` (
	`organization_id`,
	`name`,
	`plural_name`,
	`parent_id`,
	`multi_sibling_membership_allowed`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network'),
	'Hospital',
	'Hospitals',
	NULL,
	1
);

INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_levels` (
	`organization_id`,
	`name`,
	`plural_name`,
	`parent_id`,
	`multi_sibling_membership_allowed`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organizations` WHERE `name` = 'Allegheny Health Network'),
	'Physician',
	'Physicians',
	(SELECT `t`.`id` FROM (SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_levels` WHERE `name` = 'Hospital') AS `t`),
	1
);
-- *************************************************************************************

-- 19. insert master_organization_hierarchy_level_elements records for Fit For Surgery

-- insert hospital records
-- Allegheny General Hospital
-- Allegheny Valley Hospital
-- Canonsburg Hospital
-- Forbes Hospital
-- Jefferson Hospital
-- Saint Vincent Hospital
-- West Penn Hospital

-- Allegheny General Hospital
INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` (
	`organization_hierarchy_level_id`,
	`name`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_levels` WHERE `name` = 'Hospital'),
	'Allegheny General Hospital'
);

-- Allegheny Valley Hospital
INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` (
	`organization_hierarchy_level_id`,
	`name`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_levels` WHERE `name` = 'Hospital'),
	'Allegheny Valley Hospital'
);

-- Canonsburg Hospital
INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` (
	`organization_hierarchy_level_id`,
	`name`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_levels` WHERE `name` = 'Hospital'),
	'Canonsburg Hospital'
);

-- Forbes Hospital
INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` (
	`organization_hierarchy_level_id`,
	`name`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_levels` WHERE `name` = 'Hospital'),
	'Forbes Hospital'
);

-- Jefferson Hospital
INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` (
	`organization_hierarchy_level_id`,
	`name`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_levels` WHERE `name` = 'Hospital'),
	'Jefferson Hospital'
);

-- Saint Vincent Hospital
INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` (
	`organization_hierarchy_level_id`,
	`name`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_levels` WHERE `name` = 'Hospital'),
	'Saint Vincent Hospital'
);

-- West Penn Hospital
INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` (
	`organization_hierarchy_level_id`,
	`name`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_levels` WHERE `name` = 'Hospital'),
	'West Penn Hospital'
);

-- insert physician records
-- Culig
-- Pellegrini

-- Culig
INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` (
	`organization_hierarchy_level_id`,
	`name`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_levels` WHERE `name` = 'Physician'),
	'Culig'
);

-- Pellegrini
INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` (
	`organization_hierarchy_level_id`,
	`name`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_levels` WHERE `name` = 'Physician'),
	'Pellegrini'
);
-- *************************************************************************************

-- 20. insert master_organization_hierarchy_level_element_relationship_map records for Fit For Surgery
-- insert hospital relationships
-- Allegheny General Hospital
-- Allegheny Valley Hospital
-- Canonsburg Hospital
-- Forbes Hospital
-- Jefferson Hospital
-- Saint Vincent Hospital
-- West Penn Hospital
INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	NULL,
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Allegheny General Hospital')
);

INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	NULL,
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Allegheny Valley Hospital')
);

INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	NULL,
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Canonsburg Hospital')
);

INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	NULL,
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Forbes Hospital')
);

INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	NULL,
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Jefferson Hospital')
);

INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	NULL,
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Saint Vincent Hospital')
);

INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	NULL,
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` WHERE `name` = 'West Penn Hospital')
);

-- insert physician relationships
-- Culig - Allegheny General Hospital
-- Culig - Allegheny Valley Hospital
-- Culig - Forbes Hospital
-- Culig - West Penn Hospital
-- Pellegrini - Forbes

INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Allegheny General Hospital'),
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Culig')
);

INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Allegheny Valley Hospital'),
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Culig')
);

INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Forbes Hospital'),
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Culig')
);

INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` WHERE `name` = 'West Penn Hospital'),
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Culig')
);

INSERT INTO `ahn_f4s_uat`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Forbes Hospital'),
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Pellegrini')
);

-- *************************************************************************************

-- 21. insert master_user_type_organization_hierarchy_level_map records for Fit For Surgery
INSERT INTO `ahn_f4s_uat`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id`,
	`organization_hierarchy_level_id`,
	`display`,
	`required`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_user_types` WHERE `type_name` = 'admin'),
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_levels` WHERE `name` = 'Hospital'),
	0,
	0
);

INSERT INTO `ahn_f4s_uat`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id`,
	`organization_hierarchy_level_id`,
	`display`,
	`required`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_user_types` WHERE `type_name` = 'site_admin'),
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_levels` WHERE `name` = 'Hospital'),
	1,
	1
);

INSERT INTO `ahn_f4s_uat`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id`,
	`organization_hierarchy_level_id`,
	`display`,
	`required`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_user_types` WHERE `type_name` = 'user'),
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_levels` WHERE `name` = 'Hospital'),
	1,
	1
);

INSERT INTO `ahn_f4s_uat`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id`,
	`organization_hierarchy_level_id`,
	`display`,
	`required`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_user_types` WHERE `type_name` = 'admin'),
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_levels` WHERE `name` = 'Physician'),
	0,
	0
);

INSERT INTO `ahn_f4s_uat`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id`,
	`organization_hierarchy_level_id`,
	`display`,
	`required`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_user_types` WHERE `type_name` = 'site_admin'),
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_levels` WHERE `name` = 'Physician'),
	1,
	0
);

INSERT INTO `ahn_f4s_uat`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id`,
	`organization_hierarchy_level_id`,
	`display`,
	`required`
) VALUES (
	(SELECT `id` FROM `ahn_f4s_uat`.`master_user_types` WHERE `type_name` = 'user'),
	(SELECT `id` FROM `ahn_f4s_uat`.`master_organization_hierarchy_levels` WHERE `name` = 'Physician'),
	1,
	1
);
-- *************************************************************************************

-- 22. indexing for master_users_organization_hierarchy_level_element_map
ALTER TABLE `ahn_f4s_uat`.`master_users_organization_hierarchy_level_element_map`
ADD INDEX `mapping_index` (`user_id` ASC, `active` ASC, `organization_hierarchy_level_element_id` ASC);
ALTER TABLE `ahn_scc_uat`.`master_users_organization_hierarchy_level_element_map`
ADD INDEX `mapping_index` (`user_id` ASC, `active` ASC, `organization_hierarchy_level_element_id` ASC);
ALTER TABLE `dod_asb_uat`.`master_users_organization_hierarchy_level_element_map`
ADD INDEX `mapping_index` (`user_id` ASC, `active` ASC, `organization_hierarchy_level_element_id` ASC);
ALTER TABLE `ed_ens_uat`.`master_users_organization_hierarchy_level_element_map`
ADD INDEX `mapping_index` (`user_id` ASC, `active` ASC, `organization_hierarchy_level_element_id` ASC);
ALTER TABLE `mmg_chet_lilly_uat`.`master_users_organization_hierarchy_level_element_map`
ADD INDEX `mapping_index` (`user_id` ASC, `active` ASC, `organization_hierarchy_level_element_id` ASC);
ALTER TABLE `mmg_chet_otsuka_uat`.`master_users_organization_hierarchy_level_element_map`
ADD INDEX `mapping_index` (`user_id` ASC, `active` ASC, `organization_hierarchy_level_element_id` ASC);
ALTER TABLE `mmg_jcc_uat`.`master_users_organization_hierarchy_level_element_map`
ADD INDEX `mapping_index` (`user_id` ASC, `active` ASC, `organization_hierarchy_level_element_id` ASC);
ALTER TABLE `mmg_lilly_uat`.`master_users_organization_hierarchy_level_element_map`
ADD INDEX `mapping_index` (`user_id` ASC, `active` ASC, `organization_hierarchy_level_element_id` ASC);
ALTER TABLE `mmg_otsuka_uat`.`master_users_organization_hierarchy_level_element_map`
ADD INDEX `mapping_index` (`user_id` ASC, `active` ASC, `organization_hierarchy_level_element_id` ASC);
ALTER TABLE `mmg_t2d_uat`.`master_users_organization_hierarchy_level_element_map`
ADD INDEX `mapping_index` (`user_id` ASC, `active` ASC, `organization_hierarchy_level_element_id` ASC);
ALTER TABLE `mmg_ysc_uat`.`master_users_organization_hierarchy_level_element_map`
ADD INDEX `mapping_index` (`user_id` ASC, `active` ASC, `organization_hierarchy_level_element_id` ASC);
ALTER TABLE `nami_sd_uat`.`master_users_organization_hierarchy_level_element_map`
ADD INDEX `mapping_index` (`user_id` ASC, `active` ASC, `organization_hierarchy_level_element_id` ASC);
ALTER TABLE `pfizer_ra_uat`.`master_users_organization_hierarchy_level_element_map`
ADD INDEX `mapping_index` (`user_id` ASC, `active` ASC, `organization_hierarchy_level_element_id` ASC);
-- *************************************************************************************

-- 23. dod org updates to master_organization_department_map
update dod_asb_uat.master_organization_department_map
set organization_id = 2
where organization_id = 6;
-- *************************************************************************************

-- 24. dod org updates to master_courses
update dod_asb_uat.master_courses
set organization_id = 2
where organization_id = 6;
-- *************************************************************************************

-- 25. dod org updates to master_courses
update dod_asb_uat.master_role_course_map
set organization_id = 2
where organization_id = 6;
-- *************************************************************************************






