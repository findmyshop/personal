-- UAT
ALTER TABLE `ahn_f4s_uat`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `ahn_scc_uat`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `az_ddk_uat`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `dod_asb_uat`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `ed_ens_uat`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `mmg_chet_lilly_uat`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `mmg_chet_otsuka_uat`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `mmg_jcc_uat`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `mmg_lilly_uat`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `mmg_otsuka_uat`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `mmg_t2d_uat`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `mmg_ysc_uat`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `nami_sd_uat`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `pfizer_ra_uat`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;

-- PROD
ALTER TABLE `ahn_f4s_production`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `ahn_scc_production`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `dod_asb_production`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `ed_ens_production`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `mmg_jcc_production`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `mmg_lilly_production`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `mmg_otsuka_production`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `mmg_t2d_production`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `mmg_ysc_production`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `mr_demo_production`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `mr_wordpress_production`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `nami_sd_production`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;
ALTER TABLE `pfizer_ra_production`.`master_users_map` ADD COLUMN `video_bit_rate` VARCHAR(16) NOT NULL DEFAULT '512k' AFTER `video_player`;