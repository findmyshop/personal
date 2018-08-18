ALTER TABLE `master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;

-- UAT
ALTER TABLE `ahn_f4s_uat`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `ahn_ppc_uat`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `ahn_scc_uat`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `az_ddk_uat`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `dod_asb_uat`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `ed_ens_uat`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `mmg_chet_lilly_uat`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `mmg_chet_otsuka_uat`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `mmg_jcc_uat`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `mmg_lilly_uat`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `mmg_otsuka_uat`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `mmg_t2d_uat`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `mmg_ysc_uat`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `nami_sd_uat`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `pfizer_ra_uat`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `rush_sbirt_uat`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;

-- PROD
ALTER TABLE `ahn_f4s_production`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `ahn_ppc_production`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `ahn_scc_production`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `az_ddk_production`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `dod_asb_production`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `ed_ens_production`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `mmg_jcc_production`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `mmg_lilly_production`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `mmg_otsuka_production`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `mmg_t2d_production`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `mmg_ysc_production`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `mr_demo_production`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `mr_wordpress_production`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `nami_sd_production`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `pfizer_ra_production`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
ALTER TABLE `rush_sbirt_production`.`master_users` CHANGE COLUMN `username` `username` VARCHAR(255) NOT NULL;
