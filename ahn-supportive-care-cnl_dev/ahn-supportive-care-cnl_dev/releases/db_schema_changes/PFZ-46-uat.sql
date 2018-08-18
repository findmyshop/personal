-- create master_password_rules table

DROP TABLE IF EXISTS `ahn_f4s_uat`.`master_password_rules`;
CREATE TABLE `ahn_f4s_uat`.`master_password_rules` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`type` enum('min_length','max_length','regex') COLLATE utf8_bin NOT NULL,
	`rule` varchar(128) COLLATE utf8_bin NOT NULL,
	`form_validation_text` varchar(256) COLLATE utf8_bin NOT NULL,
	`default` bit(1) NOT NULL DEFAULT b'0',
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `ahn_scc_uat`.`master_password_rules`;
CREATE TABLE `ahn_scc_uat`.`master_password_rules` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`type` enum('min_length','max_length','regex') COLLATE utf8_bin NOT NULL,
	`rule` varchar(128) COLLATE utf8_bin NOT NULL,
	`form_validation_text` varchar(256) COLLATE utf8_bin NOT NULL,
	`default` bit(1) NOT NULL DEFAULT b'0',
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `dod_asb_uat`.`master_password_rules`;
CREATE TABLE `dod_asb_uat`.`master_password_rules` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`type` enum('min_length','max_length','regex') COLLATE utf8_bin NOT NULL,
	`rule` varchar(128) COLLATE utf8_bin NOT NULL,
	`form_validation_text` varchar(256) COLLATE utf8_bin NOT NULL,
	`default` bit(1) NOT NULL DEFAULT b'0',
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `ed_ens_uat`.`master_password_rules`;
CREATE TABLE `ed_ens_uat`.`master_password_rules` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`type` enum('min_length','max_length','regex') COLLATE utf8_bin NOT NULL,
	`rule` varchar(128) COLLATE utf8_bin NOT NULL,
	`form_validation_text` varchar(256) COLLATE utf8_bin NOT NULL,
	`default` bit(1) NOT NULL DEFAULT b'0',
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `mmg_chet_lilly_uat`.`master_password_rules`;
CREATE TABLE `mmg_chet_lilly_uat`.`master_password_rules` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`type` enum('min_length','max_length','regex') COLLATE utf8_bin NOT NULL,
	`rule` varchar(128) COLLATE utf8_bin NOT NULL,
	`form_validation_text` varchar(256) COLLATE utf8_bin NOT NULL,
	`default` bit(1) NOT NULL DEFAULT b'0',
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `mmg_chet_otsuka_uat`.`master_password_rules`;
CREATE TABLE `mmg_chet_otsuka_uat`.`master_password_rules` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`type` enum('min_length','max_length','regex') COLLATE utf8_bin NOT NULL,
	`rule` varchar(128) COLLATE utf8_bin NOT NULL,
	`form_validation_text` varchar(256) COLLATE utf8_bin NOT NULL,
	`default` bit(1) NOT NULL DEFAULT b'0',
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `mmg_jcc_uat`.`master_password_rules`;
CREATE TABLE `mmg_jcc_uat`.`master_password_rules` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`type` enum('min_length','max_length','regex') COLLATE utf8_bin NOT NULL,
	`rule` varchar(128) COLLATE utf8_bin NOT NULL,
	`form_validation_text` varchar(256) COLLATE utf8_bin NOT NULL,
	`default` bit(1) NOT NULL DEFAULT b'0',
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `mmg_lilly_uat`.`master_password_rules`;
CREATE TABLE `mmg_lilly_uat`.`master_password_rules` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`type` enum('min_length','max_length','regex') COLLATE utf8_bin NOT NULL,
	`rule` varchar(128) COLLATE utf8_bin NOT NULL,
	`form_validation_text` varchar(256) COLLATE utf8_bin NOT NULL,
	`default` bit(1) NOT NULL DEFAULT b'0',
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `mmg_otsuka_uat`.`master_password_rules`;
CREATE TABLE `mmg_otsuka_uat`.`master_password_rules` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`type` enum('min_length','max_length','regex') COLLATE utf8_bin NOT NULL,
	`rule` varchar(128) COLLATE utf8_bin NOT NULL,
	`form_validation_text` varchar(256) COLLATE utf8_bin NOT NULL,
	`default` bit(1) NOT NULL DEFAULT b'0',
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `mmg_t2d_uat`.`master_password_rules`;
CREATE TABLE `mmg_t2d_uat`.`master_password_rules` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`type` enum('min_length','max_length','regex') COLLATE utf8_bin NOT NULL,
	`rule` varchar(128) COLLATE utf8_bin NOT NULL,
	`form_validation_text` varchar(256) COLLATE utf8_bin NOT NULL,
	`default` bit(1) NOT NULL DEFAULT b'0',
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `mmg_ysc_uat`.`master_password_rules`;
CREATE TABLE `mmg_ysc_uat`.`master_password_rules` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`type` enum('min_length','max_length','regex') COLLATE utf8_bin NOT NULL,
	`rule` varchar(128) COLLATE utf8_bin NOT NULL,
	`form_validation_text` varchar(256) COLLATE utf8_bin NOT NULL,
	`default` bit(1) NOT NULL DEFAULT b'0',
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `nami_sd_uat`.`master_password_rules`;
CREATE TABLE `nami_sd_uat`.`master_password_rules` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`type` enum('min_length','max_length','regex') COLLATE utf8_bin NOT NULL,
	`rule` varchar(128) COLLATE utf8_bin NOT NULL,
	`form_validation_text` varchar(256) COLLATE utf8_bin NOT NULL,
	`default` bit(1) NOT NULL DEFAULT b'0',
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `pfizer_ra_uat`.`master_password_rules`;
CREATE TABLE `pfizer_ra_uat`.`master_password_rules` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`type` enum('min_length','max_length','regex') COLLATE utf8_bin NOT NULL,
	`rule` varchar(128) COLLATE utf8_bin NOT NULL,
	`form_validation_text` varchar(256) COLLATE utf8_bin NOT NULL,
	`default` bit(1) NOT NULL DEFAULT b'0',
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- create master_property_password_rule_map table
DROP TABLE IF EXISTS `ahn_f4s_uat`.`master_project_password_rule_map`;
DROP TABLE IF EXISTS `ahn_f4s_uat`.`master_property_password_rule_map`;
CREATE TABLE `ahn_f4s_uat`.`master_property_password_rule_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_id` int(11) unsigned NOT NULL,
	`password_rule_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `project_id_password_rule_id_UNIQUE` (`property_id`,`password_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `ahn_scc_uat`.`master_project_password_rule_map`;
DROP TABLE IF EXISTS `ahn_scc_uat`.`master_property_password_rule_map`;
CREATE TABLE `ahn_scc_uat`.`master_property_password_rule_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_id` int(11) unsigned NOT NULL,
	`password_rule_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `project_id_password_rule_id_UNIQUE` (`property_id`,`password_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `dod_asb_uat`.`master_project_password_rule_map`;
DROP TABLE IF EXISTS `dod_asb_uat`.`master_property_password_rule_map`;
CREATE TABLE `dod_asb_uat`.`master_property_password_rule_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_id` int(11) unsigned NOT NULL,
	`password_rule_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `project_id_password_rule_id_UNIQUE` (`property_id`,`password_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `ed_ens_uat`.`master_project_password_rule_map`;
DROP TABLE IF EXISTS `ed_ens_uat`.`master_property_password_rule_map`;
CREATE TABLE `ed_ens_uat`.`master_property_password_rule_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_id` int(11) unsigned NOT NULL,
	`password_rule_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `project_id_password_rule_id_UNIQUE` (`property_id`,`password_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `mmg_chet_lilly_uat`.`master_project_password_rule_map`;
DROP TABLE IF EXISTS `mmg_chet_lilly_uat`.`master_property_password_rule_map`;
CREATE TABLE `mmg_chet_lilly_uat`.`master_property_password_rule_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_id` int(11) unsigned NOT NULL,
	`password_rule_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `project_id_password_rule_id_UNIQUE` (`property_id`,`password_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `mmg_chet_otsuka_uat`.`master_project_password_rule_map`;
DROP TABLE IF EXISTS `mmg_chet_otsuka_uat`.`master_property_password_rule_map`;
CREATE TABLE `mmg_chet_otsuka_uat`.`master_property_password_rule_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_id` int(11) unsigned NOT NULL,
	`password_rule_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `project_id_password_rule_id_UNIQUE` (`property_id`,`password_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `mmg_jcc_uat`.`master_project_password_rule_map`;
DROP TABLE IF EXISTS `mmg_jcc_uat`.`master_property_password_rule_map`;
CREATE TABLE `mmg_jcc_uat`.`master_property_password_rule_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_id` int(11) unsigned NOT NULL,
	`password_rule_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `project_id_password_rule_id_UNIQUE` (`property_id`,`password_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `mmg_lilly_uat`.`master_project_password_rule_map`;
DROP TABLE IF EXISTS `mmg_lilly_uat`.`master_property_password_rule_map`;
CREATE TABLE `mmg_lilly_uat`.`master_property_password_rule_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_id` int(11) unsigned NOT NULL,
	`password_rule_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `project_id_password_rule_id_UNIQUE` (`property_id`,`password_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `mmg_otsuka_uat`.`master_project_password_rule_map`;
DROP TABLE IF EXISTS `mmg_otsuka_uat`.`master_property_password_rule_map`;
CREATE TABLE `mmg_otsuka_uat`.`master_property_password_rule_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_id` int(11) unsigned NOT NULL,
	`password_rule_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `project_id_password_rule_id_UNIQUE` (`property_id`,`password_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `mmg_t2d_uat`.`master_project_password_rule_map`;
DROP TABLE IF EXISTS `mmg_t2d_uat`.`master_property_password_rule_map`;
CREATE TABLE `mmg_t2d_uat`.`master_property_password_rule_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_id` int(11) unsigned NOT NULL,
	`password_rule_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `project_id_password_rule_id_UNIQUE` (`property_id`,`password_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `mmg_ysc_uat`.`master_project_password_rule_map`;
DROP TABLE IF EXISTS `mmg_ysc_uat`.`master_property_password_rule_map`;
CREATE TABLE `mmg_ysc_uat`.`master_property_password_rule_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_id` int(11) unsigned NOT NULL,
	`password_rule_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `project_id_password_rule_id_UNIQUE` (`property_id`,`password_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `nami_sd_uat`.`master_project_password_rule_map`;
DROP TABLE IF EXISTS `nami_sd_uat`.`master_property_password_rule_map`;
CREATE TABLE `nami_sd_uat`.`master_property_password_rule_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_id` int(11) unsigned NOT NULL,
	`password_rule_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `project_id_password_rule_id_UNIQUE` (`property_id`,`password_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `pfizer_ra_uat`.`master_project_password_rule_map`;
DROP TABLE IF EXISTS `pfizer_ra_uat`.`master_property_password_rule_map`;
CREATE TABLE `pfizer_ra_uat`.`master_property_password_rule_map` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_id` int(11) unsigned NOT NULL,
	`password_rule_id` int(11) unsigned NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`),
	UNIQUE KEY `project_id_password_rule_id_UNIQUE` (`property_id`,`password_rule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- insert master_password_rules records
INSERT INTO `ahn_f4s_uat`.`master_password_rules` (
	`type`,
	`rule`,
	`form_validation_text`,
	`default`
) VALUES (
	'regex','/[0-9]+/','at least one number', 0), (
	'regex','/[a-z]+/','at least one lowercase letter', 0), (
	'regex','/[A-Z]+/','at least one uppercase letter',0), (
	'regex','/[\\!\"#\\$%&\'\\(\\)\\*\\+,\\-\\.\\/\\:;\\<\\=\\>\\?@\\[\\\\\\]\\^_`\\{\\|\\}~]+/','at least one of the following special characters !\"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~', 0), (
	'min_length','6','at least 6 characters', 1), (
	'min_length','8','at least 8 characters', 0), (
	'max_length','32','no more than 32 characters', 1
);

INSERT INTO `ahn_scc_uat`.`master_password_rules` (
	`type`,
	`rule`,
	`form_validation_text`,
	`default`
) VALUES (
	'regex','/[0-9]+/','at least one number', 0), (
	'regex','/[a-z]+/','at least one lowercase letter', 0), (
	'regex','/[A-Z]+/','at least one uppercase letter',0), (
	'regex','/[\\!\"#\\$%&\'\\(\\)\\*\\+,\\-\\.\\/\\:;\\<\\=\\>\\?@\\[\\\\\\]\\^_`\\{\\|\\}~]+/','at least one of the following special characters !\"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~', 0), (
	'min_length','6','at least 6 characters', 1), (
	'min_length','8','at least 8 characters', 0), (
	'max_length','32','no more than 32 characters', 1
);

INSERT INTO `dod_asb_uat`.`master_password_rules` (
	`type`,
	`rule`,
	`form_validation_text`,
	`default`
) VALUES (
	'regex','/[0-9]+/','at least one number', 0), (
	'regex','/[a-z]+/','at least one lowercase letter', 0), (
	'regex','/[A-Z]+/','at least one uppercase letter',0), (
	'regex','/[\\!\"#\\$%&\'\\(\\)\\*\\+,\\-\\.\\/\\:;\\<\\=\\>\\?@\\[\\\\\\]\\^_`\\{\\|\\}~]+/','at least one of the following special characters !\"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~', 0), (
	'min_length','6','at least 6 characters', 1), (
	'min_length','8','at least 8 characters', 0), (
	'max_length','32','no more than 32 characters', 1
);

INSERT INTO `ed_ens_uat`.`master_password_rules` (
	`type`,
	`rule`,
	`form_validation_text`,
	`default`
) VALUES (
	'regex','/[0-9]+/','at least one number', 0), (
	'regex','/[a-z]+/','at least one lowercase letter', 0), (
	'regex','/[A-Z]+/','at least one uppercase letter',0), (
	'regex','/[\\!\"#\\$%&\'\\(\\)\\*\\+,\\-\\.\\/\\:;\\<\\=\\>\\?@\\[\\\\\\]\\^_`\\{\\|\\}~]+/','at least one of the following special characters !\"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~', 0), (
	'min_length','6','at least 6 characters', 1), (
	'min_length','8','at least 8 characters', 0), (
	'max_length','32','no more than 32 characters', 1
);

INSERT INTO `mmg_chet_lilly_uat`.`master_password_rules` (
	`type`,
	`rule`,
	`form_validation_text`,
	`default`
) VALUES (
	'regex','/[0-9]+/','at least one number', 0), (
	'regex','/[a-z]+/','at least one lowercase letter', 0), (
	'regex','/[A-Z]+/','at least one uppercase letter',0), (
	'regex','/[\\!\"#\\$%&\'\\(\\)\\*\\+,\\-\\.\\/\\:;\\<\\=\\>\\?@\\[\\\\\\]\\^_`\\{\\|\\}~]+/','at least one of the following special characters !\"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~', 0), (
	'min_length','6','at least 6 characters', 1), (
	'min_length','8','at least 8 characters', 0), (
	'max_length','32','no more than 32 characters', 1
);

INSERT INTO `mmg_chet_otsuka_uat`.`master_password_rules` (
	`type`,
	`rule`,
	`form_validation_text`,
	`default`
) VALUES (
	'regex','/[0-9]+/','at least one number', 0), (
	'regex','/[a-z]+/','at least one lowercase letter', 0), (
	'regex','/[A-Z]+/','at least one uppercase letter',0), (
	'regex','/[\\!\"#\\$%&\'\\(\\)\\*\\+,\\-\\.\\/\\:;\\<\\=\\>\\?@\\[\\\\\\]\\^_`\\{\\|\\}~]+/','at least one of the following special characters !\"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~', 0), (
	'min_length','6','at least 6 characters', 1), (
	'min_length','8','at least 8 characters', 0), (
	'max_length','32','no more than 32 characters', 1
);

INSERT INTO `mmg_jcc_uat`.`master_password_rules` (
	`type`,
	`rule`,
	`form_validation_text`,
	`default`
) VALUES (
	'regex','/[0-9]+/','at least one number', 0), (
	'regex','/[a-z]+/','at least one lowercase letter', 0), (
	'regex','/[A-Z]+/','at least one uppercase letter',0), (
	'regex','/[\\!\"#\\$%&\'\\(\\)\\*\\+,\\-\\.\\/\\:;\\<\\=\\>\\?@\\[\\\\\\]\\^_`\\{\\|\\}~]+/','at least one of the following special characters !\"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~', 0), (
	'min_length','6','at least 6 characters', 1), (
	'min_length','8','at least 8 characters', 0), (
	'max_length','32','no more than 32 characters', 1
);

INSERT INTO `mmg_lilly_uat`.`master_password_rules` (
	`type`,
	`rule`,
	`form_validation_text`,
	`default`
) VALUES (
	'regex','/[0-9]+/','at least one number', 0), (
	'regex','/[a-z]+/','at least one lowercase letter', 0), (
	'regex','/[A-Z]+/','at least one uppercase letter',0), (
	'regex','/[\\!\"#\\$%&\'\\(\\)\\*\\+,\\-\\.\\/\\:;\\<\\=\\>\\?@\\[\\\\\\]\\^_`\\{\\|\\}~]+/','at least one of the following special characters !\"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~', 0), (
	'min_length','6','at least 6 characters', 1), (
	'min_length','8','at least 8 characters', 0), (
	'max_length','32','no more than 32 characters', 1
);

INSERT INTO `mmg_otsuka_uat`.`master_password_rules` (
	`type`,
	`rule`,
	`form_validation_text`,
	`default`
) VALUES (
	'regex','/[0-9]+/','at least one number', 0), (
	'regex','/[a-z]+/','at least one lowercase letter', 0), (
	'regex','/[A-Z]+/','at least one uppercase letter',0), (
	'regex','/[\\!\"#\\$%&\'\\(\\)\\*\\+,\\-\\.\\/\\:;\\<\\=\\>\\?@\\[\\\\\\]\\^_`\\{\\|\\}~]+/','at least one of the following special characters !\"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~', 0), (
	'min_length','6','at least 6 characters', 1), (
	'min_length','8','at least 8 characters', 0), (
	'max_length','32','no more than 32 characters', 1
);

INSERT INTO `mmg_t2d_uat`.`master_password_rules` (
	`type`,
	`rule`,
	`form_validation_text`,
	`default`
) VALUES (
	'regex','/[0-9]+/','at least one number', 0), (
	'regex','/[a-z]+/','at least one lowercase letter', 0), (
	'regex','/[A-Z]+/','at least one uppercase letter',0), (
	'regex','/[\\!\"#\\$%&\'\\(\\)\\*\\+,\\-\\.\\/\\:;\\<\\=\\>\\?@\\[\\\\\\]\\^_`\\{\\|\\}~]+/','at least one of the following special characters !\"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~', 0), (
	'min_length','6','at least 6 characters', 1), (
	'min_length','8','at least 8 characters', 0), (
	'max_length','32','no more than 32 characters', 1
);

INSERT INTO `mmg_ysc_uat`.`master_password_rules` (
	`type`,
	`rule`,
	`form_validation_text`,
	`default`
) VALUES (
	'regex','/[0-9]+/','at least one number', 0), (
	'regex','/[a-z]+/','at least one lowercase letter', 0), (
	'regex','/[A-Z]+/','at least one uppercase letter',0), (
	'regex','/[\\!\"#\\$%&\'\\(\\)\\*\\+,\\-\\.\\/\\:;\\<\\=\\>\\?@\\[\\\\\\]\\^_`\\{\\|\\}~]+/','at least one of the following special characters !\"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~', 0), (
	'min_length','6','at least 6 characters', 1), (
	'min_length','8','at least 8 characters', 0), (
	'max_length','32','no more than 32 characters', 1
);

INSERT INTO `nami_sd_uat`.`master_password_rules` (
	`type`,
	`rule`,
	`form_validation_text`,
	`default`
) VALUES (
	'regex','/[0-9]+/','at least one number', 0), (
	'regex','/[a-z]+/','at least one lowercase letter', 0), (
	'regex','/[A-Z]+/','at least one uppercase letter',0), (
	'regex','/[\\!\"#\\$%&\'\\(\\)\\*\\+,\\-\\.\\/\\:;\\<\\=\\>\\?@\\[\\\\\\]\\^_`\\{\\|\\}~]+/','at least one of the following special characters !\"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~', 0), (
	'min_length','6','at least 6 characters', 1), (
	'min_length','8','at least 8 characters', 0), (
	'max_length','32','no more than 32 characters', 1
);

INSERT INTO `pfizer_ra_uat`.`master_password_rules` (
	`type`,
	`rule`,
	`form_validation_text`,
	`default`
) VALUES (
	'regex','/[0-9]+/','at least one number', 0), (
	'regex','/[a-z]+/','at least one lowercase letter', 0), (
	'regex','/[A-Z]+/','at least one uppercase letter',0), (
	'regex','/[\\!\"#\\$%&\'\\(\\)\\*\\+,\\-\\.\\/\\:;\\<\\=\\>\\?@\\[\\\\\\]\\^_`\\{\\|\\}~]+/','at least one of the following special characters !\"#$%&\'()*+,-./:;<=>?@[\\]^_`{|}~', 0), (
	'min_length','6','at least 6 characters', 1), (
	'min_length','8','at least 8 characters', 0), (
	'max_length','32','no more than 32 characters', 1
);

-- insert master_property_password_rules_map records
INSERT INTO `pfizer_ra_uat`.`master_property_password_rule_map` (
	`property_id`,
	`password_rule_id`
) VALUES (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'pra'), 1
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'pra'), 2
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'pra'), 3
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'pra'), 4
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'pra'), 6
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'pra'), 7
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'prb'), 1
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'prb'), 2
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'prb'), 3
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'prb'), 4
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'prb'), 6
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'prb'), 7
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'prc'), 1
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'prc'), 2
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'prc'), 3
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'prc'), 4
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'prc'), 6
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_properties` WHERE `name` = 'prc'), 7
);
