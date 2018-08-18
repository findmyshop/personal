-- SQL to create user hierarchies schemas in the DEV databases
-- set sql_safe_updates = 0;
-- update master_users set password = 'dad3a37aa9d50688b5157698acfd7aee';

-- 1. drop the existing master_projects table
DROP TABLE IF EXISTS `medrespond_anthony_dev`.`master_projects`;
-- *************************************************************************************

-- 2. drop the master_organizations_map table
DROP TABLE IF EXISTS `medrespond_anthony_dev`.`master_organizations_map`;
-- *************************************************************************************

-- 3. create the new master_properties table using the structure of master_organizations
DROP TABLE IF EXISTS `medrespond_anthony_dev`.`master_properties`;
CREATE TABLE `medrespond_anthony_dev`.`master_properties` LIKE `medrespond_anthony_dev`.`master_organizations`;
-- *************************************************************************************

-- 4. insert master_organizations data into master_properties;
-- INSERT INTO `medrespond_anthony_dev`.`master_properties` SELECT * FROM `medrespond_anthony_dev`.`master_organizations`;
-- *************************************************************************************

-- 5. modify the newly created master_properties table schema
ALTER TABLE `medrespond_anthony_dev`.`master_properties` DROP COLUMN `organization_name`, CHANGE COLUMN `project_name` `name` VARCHAR(45) NOT NULL ,DROP INDEX `project_name_UNIQUE` , ADD UNIQUE INDEX `name_UNIQUE` (`name` ASC), DROP INDEX `index_organization_name`;
INSERT INTO `medrespond_anthony_dev`.`master_properties` (
	`id`,
	`name`,
	`title`,
	`domain`,
	`case_name`,
	`response_prefix`,
	`general_welcome_response`,
	`decision_flow_welcome_response`,
	`welcome_back_response`,
	`web_video_domain`,
	`rtmp_video_domain`,
	`provider_organization_name`,
	`top_level_unit_name`,
	`second_level_unit_name`,
	`active`
) VALUES (
	'1','default','Medrespond','-','MDR_ACC','acc','acc001','acc001','acc001','d15kr0v9f7zpvj.cloudfront.net','s1lj1k83sti2pu.cloudfront.net','','','','1'), (
	'2','scc','Supportive Care Options','supportivecareoptions.com','AHN_SCC_General','scc','scc187','scc125','scc176','dbs2vpmfemq2h.cloudfront.net','s1q31g3otue4ve.cloudfront.net','','','','1'), (
	'4','otsuka','ADPKD Clinical Research','pkdconversations.com','Otsuka_PKD','pkd','pkd005','pkd005','pkd005','d17rlwzo3thikw.cloudfront.net','s31eoa4prx71fe.cloudfront.net','','','','1'), (
	'5','lilly','Breast Cancer Clinical Research','monarch2conversations.com','EliLilly_JPBL','jpbl','jpbl005','jpbl003','jpbl005','dytwkr6wwwcbt.cloudfront.net','s22jphh4cfemjf.cloudfront.net','','','','1'), (
	'6','dod','AlcoholSBIRT','alcoholsbirt.com','DOD_ASB1_GenMADIO','asb','asb3_mod1','asb3_mod1','asb3_mod1','d1bpe7oalp3frq.cloudfront.net','syfmrplygh2kt.cloudfront.net','','','','1'), (
	'7','f4s','Fit For Surgery','fit-for-surgery.com','AHN_F4S_Gen','f4s','f4s001','f4s001','f4s001','d3rhvdt5ooaqry.cloudfront.net','s35qebpkxw5uvm.cloudfront.net','','','','1'), (
	'8','jcc','Lung Cancer Clinical Trials','juniperconversations.com','EliLilly_JCC','jcc','jcc005','jcc005','jcc005','d2enijuwy6g8pk.cloudfront.net','s36wn0lwl56mli.cloudfront.net','','','','1'), (
	'9','t2d','Type 2 Diabetes Clinical Research','situpconversations.com','Merck_t2d','t2d','t2d005','t2d005','t2d005','da0cngxdx94ff.cloudfront.net','szv3vu8edn50t.cloudfront.net','','','','1'), (
	'10','nsd','Ask NAMI San Diego','asknamisandiego.org','NAMISD_Gen','nsd','nsd001','nsd001','nsd001','dryncbex7m2o2.cloudfront.net','s1r8jxh0fc0r0b.cloudfront.net','','','','1'), (
	'11','pra','Participating in a Clinical Trial','medrespond-pfra.com/pra','Pfizer_PRA','pra','pra005','pra005','pra005','dnhglljvfoddb.cloudfront.net','s3amv0at4gehhr.cloudfront.net','','','','1'), (
	'12','prb','B537-02','medrespond-pfra.com/prb','Pfizer_PRB','prb','prb005','prb005','prb005','dnhglljvfoddb.cloudfront.net','s3amv0at4gehhr.cloudfront.net','','','','1'), (
	'13','prc','B538-02','medrespond-pfra.com/prc','Pfizer_PRC','prc','prb005','prb005','prb005','dnhglljvfoddb.cloudfront.net','s3amv0at4gehhr.cloudfront.net','','','','1'), (
	'14','ens','Enersource','electricitydialogue.ca/ens','Enersource','acc','acc001','acc001','acc001','d15kr0v9f7zpvj.cloudfront.net','s1lj1k83sti2pu.cloudfront.net','','','','1'), (
	'15','ysc','Your Study Conversations','yourstudyconversations.com','Pfizer_YSC','ysc','ysc005','ysc005','ysc005','d35wl8u722qezn.cloudfront.net','skwcylqapvufw.cloudfront.net','','','','1'
);
-- *************************************************************************************

-- 6. rename the existing master_organizations table
DROP TABLE IF EXISTS `medrespond_anthony_dev`.`master_organizations_bak`;
RENAME TABLE `medrespond_anthony_dev`.`master_organizations` TO `medrespond_anthony_dev`.`master_organizations_bak`;
-- *************************************************************************************

-- 7. create the new master_organizations table
CREATE TABLE `medrespond_anthony_dev`.`master_organizations` (
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
INSERT INTO `medrespond_anthony_dev`.`master_organizations` (
	`id`,
	`name`,
	`active`
) VALUES (
	'1', 'MedRespond', '1'), (
	'2', 'Allegheny Health Network', '1'), (
	'3', 'Otsuka', '1'), (
	'4', 'Eli Lilly and Company', '1'), (
	'5', 'Merck', '1'), (
	'6', 'Pfizer', '1'), (
	'7', 'MMG', '1'), (
	'8', 'Department of Defense', '1'), (
	'9', 'NAMI San Diego', '1'), (
	'10', 'Oncology Nursing Society', '1'), (
	'11', 'Enersource', '1'
);

-- *************************************************************************************

-- 9. create the master_organization_property_map table
DROP TABLE IF EXISTS `medrespond_anthony_dev`.`master_organization_property_map`;
CREATE TABLE `medrespond_anthony_dev`.`master_organization_property_map` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`organization_id` int(11) unsigned NOT NULL,
	`property_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `organization_id_property_id_UNIQUE` (`organization_id`,`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- *************************************************************************************

-- 10. insert master_organization_property_map records
INSERT INTO `medrespond_anthony_dev`.`master_organization_property_map` (
	`id`,
	`organization_id`,
	`property_id`,
	`active`
) VALUES (
	'1','1','7','1'), (
	'2','2','7','1'), (
	'3','1','2','1'), (
	'4','2','2','1'), (
	'5','1','6','1'), (
	'6','8','6','1'), (
	'7','1','14','1'), (
	'8','11','14','1'), (
	'9','1','8','1'), (
	'10','4','8','1'), (
	'11','1','5','1'), (
	'12','4','5','1'), (
	'13','1','4','1'), (
	'14','3','4','1'), (
	'15','1','9','1'), (
	'16','5','9','1'), (
	'17','1','15','1'), (
	'18','6','15','1'), (
	'19','1','10','1'), (
	'20','9','10','1'), (
	'21','1','11','1'), (
	'22','6','11','1'), (
	'23','1','12','1'), (
	'24','6','12','1'), (
	'25','1','13','1'), (
	'26','6','13','1'
);

-- *************************************************************************************

-- 11. master_users_map.organization_id updates
UPDATE `medrespond_anthony_dev`.`master_users_map` AS `mum`
JOIN `medrespond_anthony_dev`.`master_organizations_bak` AS `mob`
	ON `mob`.`id` = `mum`.`organization_id`
SET `mum`.`organization_id` = CASE
	WHEN `mob`.`organization_name` = 'DoD' THEN (SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `name` = 'Department of Defense')
	WHEN `mob`.`organization_name` = 'Enersource' THEN (SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `name` = 'Enersource')
	WHEN `mob`.`organization_name` = 'Fit For Surgery' THEN (SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'Lilly JCC' THEN (SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Lilly JPBL' THEN (SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `name` = 'Eli Lilly and Company')
	WHEN `mob`.`organization_name` = 'Medrespond' THEN (SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `name` = 'MedRespond')
	WHEN `mob`.`organization_name` = 'NAMI SD' THEN (SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `name` = 'NAMI San Diego')
	WHEN `mob`.`organization_name` = 'Otsuka' THEN (SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `name` = 'Otsuka')
	WHEN `mob`.`organization_name` = 'Pfizer PRA' THEN (SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRB' THEN (SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer PRC' THEN (SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Pfizer YSC' THEN (SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `name` = 'Pfizer')
	WHEN `mob`.`organization_name` = 'Supportive Care' THEN (SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `name` = 'Allegheny Health Network')
	WHEN `mob`.`organization_name` = 'T2D' THEN (SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `name` = 'Merck')
	ELSE `mum`.`organization_id`
END;
-- *************************************************************************************

-- 12. drop the master_organizations_bak table
DROP TABLE IF EXISTS `medrespond_anthony_dev`.`master_organizations_bak`;
-- *************************************************************************************

-- 13. create master_organization_hierarchy_levels table
DROP TABLE IF EXISTS `medrespond_anthony_dev`.`master_organization_hierarchy_levels`;
CREATE TABLE `medrespond_anthony_dev`.`master_organization_hierarchy_levels` (
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
DROP TABLE IF EXISTS `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements`;
CREATE TABLE `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_id` int(11) unsigned NOT NULL,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- *************************************************************************************

-- 15. create master_organization_hierarchy_level_element_relationship_map table
DROP TABLE IF EXISTS `medrespond_anthony_dev`.`master_organization_hierarchy_level_element_relationship_map`;
CREATE TABLE `medrespond_anthony_dev`.`master_organization_hierarchy_level_element_relationship_map` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`organization_hierarchy_level_element_parent_id` INT(11) UNSIGNED,
	`organization_hierarchy_level_element_id` INT(11) UNSIGNED NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `relationship_UNIQUE` (`organization_hierarchy_level_element_parent_id` ASC, `organization_hierarchy_level_element_id` ASC));
-- *************************************************************************************

-- 16. create master_users_organization_hierarchy_level_element_map table
DROP TABLE IF EXISTS `medrespond_anthony_dev`.`master_users_organization_hierarchy_level_element_map`;
CREATE TABLE `medrespond_anthony_dev`.`master_users_organization_hierarchy_level_element_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(11) unsigned NOT NULL,
	`organization_hierarchy_level_element_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
-- *************************************************************************************

-- 17. create master_user_type_organization_hierarchy_level_map table
DROP TABLE IF EXISTS `medrespond_anthony_dev`.`master_user_type_organization_hierarchy_level_map`;
CREATE TABLE `medrespond_anthony_dev`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id` INT(11) UNSIGNED NOT NULL,
	`organization_hierarchy_level_id` INT(11) UNSIGNED NOT NULL,
	`display` BIT(1) NOT NULL,
	`required` BIT(1) NOT NULL,
	`active` BIT(1) NOT NULL DEFAULT 1,
	PRIMARY KEY (`user_type_id`, `organization_hierarchy_level_id`));
-- *************************************************************************************

-- 18. insert master_organization_hierarchy_levels records for Fit For Surgery
INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_levels` (
	`organization_id`,
	`name`,
	`plural_name`,
	`parent_id`,
	`multi_sibling_membership_allowed`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `name` = 'Allegheny Health Network'),
	'Hospital',
	'Hospitals',
	NULL,
	1
);

INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_levels` (
	`organization_id`,
	`name`,
	`plural_name`,
	`parent_id`,
	`multi_sibling_membership_allowed`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `name` = 'Allegheny Health Network'),
	'Physician',
	'Physicians',
	(SELECT `t`.`id` FROM (SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_levels` WHERE `name` = 'Hospital') AS `t`),
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
INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` (
	`organization_hierarchy_level_id`,
	`name`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_levels` WHERE `name` = 'Hospital'),
	'Allegheny General Hospital'
);

-- Allegheny Valley Hospital
INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` (
	`organization_hierarchy_level_id`,
	`name`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_levels` WHERE `name` = 'Hospital'),
	'Allegheny Valley Hospital'
);

-- Canonsburg Hospital
INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` (
	`organization_hierarchy_level_id`,
	`name`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_levels` WHERE `name` = 'Hospital'),
	'Canonsburg Hospital'
);

-- Forbes Hospital
INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` (
	`organization_hierarchy_level_id`,
	`name`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_levels` WHERE `name` = 'Hospital'),
	'Forbes Hospital'
);

-- Jefferson Hospital
INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` (
	`organization_hierarchy_level_id`,
	`name`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_levels` WHERE `name` = 'Hospital'),
	'Jefferson Hospital'
);

-- Saint Vincent Hospital
INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` (
	`organization_hierarchy_level_id`,
	`name`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_levels` WHERE `name` = 'Hospital'),
	'Saint Vincent Hospital'
);

-- West Penn Hospital
INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` (
	`organization_hierarchy_level_id`,
	`name`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_levels` WHERE `name` = 'Hospital'),
	'West Penn Hospital'
);

-- insert physician records
-- Culig
-- Pellegrini

-- Culig
INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` (
	`organization_hierarchy_level_id`,
	`name`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_levels` WHERE `name` = 'Physician'),
	'Culig'
);

-- Pellegrini
INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` (
	`organization_hierarchy_level_id`,
	`name`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_levels` WHERE `name` = 'Physician'),
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
INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	NULL,
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Allegheny General Hospital')
);

INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	NULL,
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Allegheny Valley Hospital')
);

INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	NULL,
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Canonsburg Hospital')
);

INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	NULL,
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Forbes Hospital')
);

INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	NULL,
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Jefferson Hospital')
);

INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	NULL,
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Saint Vincent Hospital')
);

INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	NULL,
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` WHERE `name` = 'West Penn Hospital')
);

-- insert physician relationships
-- Culig - Allegheny General Hospital
-- Culig - Allegheny Valley Hospital
-- Culig - Forbes Hospital
-- Culig - West Penn Hospital
-- Pellegrini - Forbes

INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Allegheny General Hospital'),
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Culig')
);

INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Allegheny Valley Hospital'),
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Culig')
);

INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Forbes Hospital'),
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Culig')
);

INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` WHERE `name` = 'West Penn Hospital'),
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Culig')
);

INSERT INTO `medrespond_anthony_dev`.`master_organization_hierarchy_level_element_relationship_map` (
	`organization_hierarchy_level_element_parent_id`,
	`organization_hierarchy_level_element_id`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Forbes Hospital'),
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_level_elements` WHERE `name` = 'Pellegrini')
);

-- *************************************************************************************

-- 21. insert master_user_type_organization_hierarchy_level_map records for Fit For Surgery
INSERT INTO `medrespond_anthony_dev`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id`,
	`organization_hierarchy_level_id`,
	`display`,
	`required`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_user_types` WHERE `type_name` = 'admin'),
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_levels` WHERE `name` = 'Hospital'),
	0,
	0
);

INSERT INTO `medrespond_anthony_dev`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id`,
	`organization_hierarchy_level_id`,
	`display`,
	`required`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_user_types` WHERE `type_name` = 'site_admin'),
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_levels` WHERE `name` = 'Hospital'),
	1,
	1
);

INSERT INTO `medrespond_anthony_dev`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id`,
	`organization_hierarchy_level_id`,
	`display`,
	`required`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_user_types` WHERE `type_name` = 'user'),
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_levels` WHERE `name` = 'Hospital'),
	1,
	1
);

INSERT INTO `medrespond_anthony_dev`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id`,
	`organization_hierarchy_level_id`,
	`display`,
	`required`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_user_types` WHERE `type_name` = 'admin'),
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_levels` WHERE `name` = 'Physician'),
	0,
	0
);

INSERT INTO `medrespond_anthony_dev`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id`,
	`organization_hierarchy_level_id`,
	`display`,
	`required`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_user_types` WHERE `type_name` = 'site_admin'),
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_levels` WHERE `name` = 'Physician'),
	1,
	0
);

INSERT INTO `medrespond_anthony_dev`.`master_user_type_organization_hierarchy_level_map` (
	`user_type_id`,
	`organization_hierarchy_level_id`,
	`display`,
	`required`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_user_types` WHERE `type_name` = 'user'),
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organization_hierarchy_levels` WHERE `name` = 'Physician'),
	1,
	1
);

-- *************************************************************************************

-- 22. indexing for master_users_organization_hierarchy_level_element_map
ALTER TABLE `medrespond_anthony_dev`.`master_users_organization_hierarchy_level_element_map`
ADD INDEX `mapping_index` (`user_id` ASC, `active` ASC, `organization_hierarchy_level_element_id` ASC);
-- *************************************************************************************








