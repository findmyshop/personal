-- UAT
CREATE TABLE `ahn_f4s_uat`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `ahn_scc_uat`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `dod_asb_uat`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `ed_ens_uat`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_chet_lilly_uat`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_chet_otsuka_uat`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_jcc_uat`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_lilly_uat`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_otsuka_uat`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_t2d_uat`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_ysc_uat`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `nami_sd_uat`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `pfizer_ra_uat`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `ahn_f4s_uat`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `ahn_f4s_uat`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `ahn_scc_uat`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `ahn_scc_uat`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `dod_asb_uat`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `dod_asb_uat`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `ed_ens_uat`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `ed_ens_uat`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `mmg_chet_lilly_uat`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `mmg_chet_lilly_uat`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `mmg_chet_otsuka_uat`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `mmg_chet_otsuka_uat`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `mmg_jcc_uat`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `mmg_jcc_uat`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `mmg_lilly_uat`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `mmg_lilly_uat`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `mmg_otsuka_uat`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `mmg_otsuka_uat`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `mmg_t2d_uat`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `mmg_t2d_uat`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `mmg_ysc_uat`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `mmg_ysc_uat`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `nami_sd_uat`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `nami_sd_uat`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `pfizer_ra_uat`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `pfizer_ra_uat`.`master_features` (`name`) VALUES ('registration');

-- PROD
CREATE TABLE `ahn_f4s_production`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `ahn_scc_production`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `dod_asb_production`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `ed_ens_production`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_jcc_production`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_lilly_production`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_otsuka_production`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_t2d_production`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mmg_ysc_production`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mr_demo_production`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `mr_wordpress_production`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `nami_sd_production`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `pfizer_ra_production`.`master_features` (
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`site_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`user` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`unauthenticated` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`name`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


INSERT INTO `ahn_f4s_production`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `ahn_f4s_production`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `ahn_scc_production`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `ahn_scc_production`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `dod_asb_production`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `dod_asb_production`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `ed_ens_production`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `ed_ens_production`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `mmg_jcc_production`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `mmg_jcc_production`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `mmg_lilly_production`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `mmg_lilly_production`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `mmg_otsuka_production`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `mmg_otsuka_production`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `mmg_t2d_production`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `mmg_t2d_production`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `mmg_ysc_production`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `mmg_ysc_production`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `mr_demo_production`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `mr_demo_production`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `mr_wordpress_production`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `mr_wordpress_production`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `nami_sd_production`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `nami_sd_production`.`master_features` (`name`) VALUES ('registration');

INSERT INTO `pfizer_ra_production`.`master_features` (`name`) VALUES ('authentication');
INSERT INTO `pfizer_ra_production`.`master_features` (`name`) VALUES ('registration');
