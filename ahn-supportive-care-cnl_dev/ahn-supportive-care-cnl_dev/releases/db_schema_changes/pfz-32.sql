CREATE TABLE `ahn_f4s_production`.`master_user_authentication_attempts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(10) unsigned NOT NULL,
	`successful` bit(1) NOT NULL,
	`datetime` datetime NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `ahn_f4s_uat`.`master_user_authentication_attempts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(10) unsigned NOT NULL,
	`successful` bit(1) NOT NULL,
	`datetime` datetime NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `ahn_scc_production`.`master_user_authentication_attempts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(10) unsigned NOT NULL,
	`successful` bit(1) NOT NULL,
	`datetime` datetime NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `ahn_scc_uat`.`master_user_authentication_attempts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(10) unsigned NOT NULL,
	`successful` bit(1) NOT NULL,
	`datetime` datetime NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `dod_asb_production`.`master_user_authentication_attempts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(10) unsigned NOT NULL,
	`successful` bit(1) NOT NULL,
	`datetime` datetime NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `dod_asb_uat`.`master_user_authentication_attempts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(10) unsigned NOT NULL,
	`successful` bit(1) NOT NULL,
	`datetime` datetime NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `mmg_chet_lilly_uat`.`master_user_authentication_attempts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(10) unsigned NOT NULL,
	`successful` bit(1) NOT NULL,
	`datetime` datetime NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `mmg_chet_otsuka_uat`.`master_user_authentication_attempts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(10) unsigned NOT NULL,
	`successful` bit(1) NOT NULL,
	`datetime` datetime NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `mmg_jcc_production`.`master_user_authentication_attempts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(10) unsigned NOT NULL,
	`successful` bit(1) NOT NULL,
	`datetime` datetime NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `mmg_jcc_uat`.`master_user_authentication_attempts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(10) unsigned NOT NULL,
	`successful` bit(1) NOT NULL,
	`datetime` datetime NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `mmg_lilly_production`.`master_user_authentication_attempts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(10) unsigned NOT NULL,
	`successful` bit(1) NOT NULL,
	`datetime` datetime NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `mmg_lilly_uat`.`master_user_authentication_attempts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(10) unsigned NOT NULL,
	`successful` bit(1) NOT NULL,
	`datetime` datetime NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `mmg_otsuka_production`.`master_user_authentication_attempts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(10) unsigned NOT NULL,
	`successful` bit(1) NOT NULL,
	`datetime` datetime NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `mmg_otsuka_uat`.`master_user_authentication_attempts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(10) unsigned NOT NULL,
	`successful` bit(1) NOT NULL,
	`datetime` datetime NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `mmg_t2d_production`.`master_user_authentication_attempts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(10) unsigned NOT NULL,
	`successful` bit(1) NOT NULL,
	`datetime` datetime NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `mmg_t2d_uat`.`master_user_authentication_attempts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(10) unsigned NOT NULL,
	`successful` bit(1) NOT NULL,
	`datetime` datetime NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `mr_demo_production`.`master_user_authentication_attempts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(10) unsigned NOT NULL,
	`successful` bit(1) NOT NULL,
	`datetime` datetime NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `nami_sd_production`.`master_user_authentication_attempts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(10) unsigned NOT NULL,
	`successful` bit(1) NOT NULL,
	`datetime` datetime NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `nami_sd_uat`.`master_user_authentication_attempts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(10) unsigned NOT NULL,
	`successful` bit(1) NOT NULL,
	`datetime` datetime NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `pfizer_ra_production`.`master_user_authentication_attempts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(10) unsigned NOT NULL,
	`successful` bit(1) NOT NULL,
	`datetime` datetime NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `pfizer_ra_uat`.`master_user_authentication_attempts` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(10) unsigned NOT NULL,
	`successful` bit(1) NOT NULL,
	`datetime` datetime NOT NULL,
	`active` bit(1) NOT NULL DEFAULT b'1',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
