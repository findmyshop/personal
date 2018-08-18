-- UAT
CREATE TABLE `ahn_f4s_uat`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ahn_ppc_uat`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ahn_scc_uat`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `az_ddk_uat`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `dod_asb_uat`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ed_ens_uat`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `exc_epr_uat`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_chet_lilly_uat`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_chet_otsuka_uat`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_jcc_uat`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_lilly_uat`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_msp_uat`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_otsuka_uat`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_t2d_uat`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_ysc_uat`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mr_sbirt_uat`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `nami_sd_uat`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ons_oct_uat`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `pfizer_ra_uat`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `rush_sbirt_uat`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ahn_f4s_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `ahn_ppc_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `ahn_scc_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `az_ddk_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `dod_asb_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `ed_ens_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `exc_epr_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `mmg_chet_lilly_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `mmg_chet_otsuka_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `mmg_jcc_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `mmg_lilly_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `mmg_msp_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `mmg_otsuka_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `mmg_t2d_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `mmg_ysc_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `mr_sbirt_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `nami_sd_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `ons_oct_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `pfizer_ra_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `rush_sbirt_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `ahn_f4s_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `ahn_ppc_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `ahn_scc_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `az_ddk_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `dod_asb_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `ed_ens_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `exc_epr_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `mmg_chet_lilly_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `mmg_chet_otsuka_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `mmg_jcc_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `mmg_lilly_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `mmg_msp_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `mmg_otsuka_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `mmg_t2d_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `mmg_ysc_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `mr_sbirt_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `nami_sd_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `ons_oct_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `pfizer_ra_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `rush_sbirt_uat`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

CREATE TABLE `ahn_f4s_uat`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ahn_ppc_uat`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ahn_scc_uat`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `az_ddk_uat`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `dod_asb_uat`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ed_ens_uat`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `exc_epr_uat`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_chet_lilly_uat`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_chet_otsuka_uat`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_jcc_uat`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_lilly_uat`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_msp_uat`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_otsuka_uat`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_t2d_uat`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_ysc_uat`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mr_sbirt_uat`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `nami_sd_uat`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ons_oct_uat`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `pfizer_ra_uat`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `rush_sbirt_uat`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- PROD
CREATE TABLE `mmg_alz_production`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ahn_f4s_production`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ahn_ppc_production`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ahn_scc_production`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `az_ddk_production`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `dod_asb_production`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ed_ens_production`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `exc_epr_production`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_chet_lilly_production`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_chet_otsuka_production`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_jcc_production`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_lilly_production`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_msp_production`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_otsuka_production`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_t2d_production`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_ysc_production`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mr_sbirt_production`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `nami_sd_production`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ons_oct_production`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `pfizer_ra_production`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `rush_sbirt_production`.`master_session_speaker_selection_options` (
    `post_name` char(1) NOT NULL,
    `display_name` varchar(56) NOT NULL,
    PRIMARY KEY (`post_name`,`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mmg_alz_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `ahn_f4s_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `ahn_ppc_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `ahn_scc_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `az_ddk_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `dod_asb_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `ed_ens_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `exc_epr_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `mmg_chet_lilly_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `mmg_chet_otsuka_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `mmg_jcc_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `mmg_lilly_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `mmg_msp_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `mmg_otsuka_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `mmg_t2d_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `mmg_ysc_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `mr_sbirt_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `nami_sd_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `ons_oct_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `pfizer_ra_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `rush_sbirt_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'a',
    'Male'
);

INSERT INTO `mmg_alz_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `ahn_f4s_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `ahn_ppc_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `ahn_scc_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `az_ddk_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `dod_asb_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `ed_ens_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `exc_epr_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `mmg_chet_lilly_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `mmg_chet_otsuka_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `mmg_jcc_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `mmg_lilly_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `mmg_msp_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `mmg_otsuka_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `mmg_t2d_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `mmg_ysc_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `mr_sbirt_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `nami_sd_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `ons_oct_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `pfizer_ra_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

INSERT INTO `rush_sbirt_production`.`master_session_speaker_selection_options` (
    `post_name`,
    `display_name`
) VALUES (
    'b',
    'Female'
);

CREATE TABLE `mmg_alz_production`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ahn_f4s_production`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ahn_ppc_production`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ahn_scc_production`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `az_ddk_production`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `dod_asb_production`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ed_ens_production`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `exc_epr_production`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_chet_lilly_production`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_chet_otsuka_production`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_jcc_production`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_lilly_production`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_msp_production`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_otsuka_production`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_t2d_production`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mmg_ysc_production`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `mr_sbirt_production`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `nami_sd_production`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ons_oct_production`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `pfizer_ra_production`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `rush_sbirt_production`.`master_session_speaker_selections` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `property_id` int(11) NOT NULL,
    `session_id` varchar(40) NOT NULL,
    `selection` char(1) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `property_id_selection_index` (`property_id`,`selection`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

