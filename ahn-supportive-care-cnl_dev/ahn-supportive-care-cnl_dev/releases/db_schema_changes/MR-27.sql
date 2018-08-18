SET SQL_SAFE_UPDATES = 0;

-- drop the master_projects table from all production and uat databases
-- DROP TABLE IF EXISTS `ahn_f4s_production`.`master_projects`;
-- DROP TABLE IF EXISTS `ahn_f4s_uat`.`master_projects`;
-- DROP TABLE IF EXISTS `ahn_scc_production`.`master_projects`;
-- DROP TABLE IF EXISTS `ahn_scc_uat`.`master_projects`;
-- DROP TABLE IF EXISTS `dod_asb_production`.`master_projects`;
-- DROP TABLE IF EXISTS `dod_asb_uat`.`master_projects`;
-- DROP TABLE IF EXISTS `mmg_chet_lilly_uat`.`master_projects`;
-- DROP TABLE IF EXISTS `mmg_chet_otsuka_uat`.`master_projects`;
-- DROP TABLE IF EXISTS `mmg_jcc_production`.`master_projects`;
-- DROP TABLE IF EXISTS `mmg_jcc_uat`.`master_projects`;
-- DROP TABLE IF EXISTS `mmg_lilly_production`.`master_projects`;
-- DROP TABLE IF EXISTS `mmg_lilly_uat`.`master_projects`;
-- DROP TABLE IF EXISTS `mmg_otsuka_production`.`master_projects`;
-- DROP TABLE IF EXISTS `mmg_otsuka_uat`.`master_projects`;
-- DROP TABLE IF EXISTS `mmg_t2d_production`.`master_projects`;
-- DROP TABLE IF EXISTS `mmg_t2d_uat`.`master_projects`;
-- DROP TABLE IF EXISTS `mr_demo_production`.`master_projects`;
-- DROP TABLE IF EXISTS `nami_sd_production`.`master_projects`;
-- DROP TABLE IF EXISTS `nami_sd_uat`.`master_projects`;
-- DROP TABLE IF EXISTS `pfizer_ra_production`.`master_projects`;
-- DROP TABLE IF EXISTS `pfizer_ra_uat`.`master_projects`;

-- drop the master_organizations_map.project_id column
-- ALTER TABLE `ahn_f4s_production`.`master_organizations_map` DROP COLUMN `project_id`;
-- ALTER TABLE `ahn_f4s_uat`.`master_organizations_map` DROP COLUMN `project_id`;
-- ALTER TABLE `ahn_scc_production`.`master_organizations_map` DROP COLUMN `project_id`;
-- ALTER TABLE `ahn_scc_uat`.`master_organizations_map` DROP COLUMN `project_id`;
-- ALTER TABLE `dod_asb_production`.`master_organizations_map` DROP COLUMN `project_id`;
-- ALTER TABLE `dod_asb_uat`.`master_organizations_map` DROP COLUMN `project_id`;
-- ALTER TABLE `mmg_chet_lilly_uat`.`master_organizations_map` DROP COLUMN `project_id`;
-- ALTER TABLE `mmg_chet_otsuka_uat`.`master_organizations_map` DROP COLUMN `project_id`;
-- ALTER TABLE `mmg_jcc_production`.`master_organizations_map` DROP COLUMN `project_id`;
-- ALTER TABLE `mmg_jcc_uat`.`master_organizations_map` DROP COLUMN `project_id`;
-- ALTER TABLE `mmg_lilly_production`.`master_organizations_map` DROP COLUMN `project_id`;
-- ALTER TABLE `mmg_lilly_uat`.`master_organizations_map` DROP COLUMN `project_id`;
-- ALTER TABLE `mmg_otsuka_production`.`master_organizations_map` DROP COLUMN `project_id`;
-- ALTER TABLE `mmg_otsuka_uat`.`master_organizations_map` DROP COLUMN `project_id`;
-- ALTER TABLE `mmg_t2d_production`.`master_organizations_map` DROP COLUMN `project_id`;
-- ALTER TABLE `mmg_t2d_uat`.`master_organizations_map` DROP COLUMN `project_id`;
-- ALTER TABLE `mr_demo_production`.`master_organizations_map` DROP COLUMN `project_id`;
-- ALTER TABLE `nami_sd_production`.`master_organizations_map` DROP COLUMN `project_id`;
-- ALTER TABLE `nami_sd_uat`.`master_organizations_map` DROP COLUMN `project_id`;
-- ALTER TABLE `pfizer_ra_production`.`master_organizations_map` DROP COLUMN `project_id`;
-- ALTER TABLE `pfizer_ra_uat`.`master_organizations_map` DROP COLUMN `project_id`;

-- create master_patients_users_map tables
CREATE TABLE `ahn_f4s_production`.`master_users_patients_map` (
	`user_id` INT UNSIGNED NOT NULL,
	`patient_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`user_id`, `patient_id`));

CREATE TABLE `ahn_scc_production`.`master_users_patients_map` (
	`user_id` INT UNSIGNED NOT NULL,
	`patient_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`user_id`, `patient_id`));

CREATE TABLE `ahn_scc_uat`.`master_users_patients_map` (
	`user_id` INT UNSIGNED NOT NULL,
	`patient_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`user_id`, `patient_id`));

CREATE TABLE `dod_asb_production`.`master_users_patients_map` (
	`user_id` INT UNSIGNED NOT NULL,
	`patient_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`user_id`, `patient_id`));

CREATE TABLE `dod_asb_uat`.`master_users_patients_map` (
	`user_id` INT UNSIGNED NOT NULL,
	`patient_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`user_id`, `patient_id`));

CREATE TABLE `mmg_chet_lilly_uat`.`master_users_patients_map` (
	`user_id` INT UNSIGNED NOT NULL,
	`patient_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`user_id`, `patient_id`));

CREATE TABLE `mmg_chet_otsuka_uat`.`master_users_patients_map` (
	`user_id` INT UNSIGNED NOT NULL,
	`patient_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`user_id`, `patient_id`));

CREATE TABLE `mmg_jcc_production`.`master_users_patients_map` (
	`user_id` INT UNSIGNED NOT NULL,
	`patient_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`user_id`, `patient_id`));

CREATE TABLE `mmg_jcc_uat`.`master_users_patients_map` (
	`user_id` INT UNSIGNED NOT NULL,
	`patient_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`user_id`, `patient_id`));

CREATE TABLE `mmg_lilly_production`.`master_users_patients_map` (
	`user_id` INT UNSIGNED NOT NULL,
	`patient_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`user_id`, `patient_id`));

CREATE TABLE `mmg_lilly_uat`.`master_users_patients_map` (
	`user_id` INT UNSIGNED NOT NULL,
	`patient_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`user_id`, `patient_id`));

CREATE TABLE `mmg_otsuka_production`.`master_users_patients_map` (
	`user_id` INT UNSIGNED NOT NULL,
	`patient_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`user_id`, `patient_id`));

CREATE TABLE `mmg_otsuka_uat`.`master_users_patients_map` (
	`user_id` INT UNSIGNED NOT NULL,
	`patient_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`user_id`, `patient_id`));

CREATE TABLE `mmg_t2d_production`.`master_users_patients_map` (
	`user_id` INT UNSIGNED NOT NULL,
	`patient_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`user_id`, `patient_id`));

CREATE TABLE `mmg_t2d_uat`.`master_users_patients_map` (
	`user_id` INT UNSIGNED NOT NULL,
	`patient_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`user_id`, `patient_id`));

CREATE TABLE `mr_demo_production`.`master_users_patients_map` (
	`user_id` INT UNSIGNED NOT NULL,
	`patient_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`user_id`, `patient_id`));

CREATE TABLE `nami_sd_production`.`master_users_patients_map` (
	`user_id` INT UNSIGNED NOT NULL,
	`patient_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`user_id`, `patient_id`));

CREATE TABLE `nami_sd_uat`.`master_users_patients_map` (
	`user_id` INT UNSIGNED NOT NULL,
	`patient_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`user_id`, `patient_id`));

CREATE TABLE `pfizer_ra_production`.`master_users_patients_map` (
	`user_id` INT UNSIGNED NOT NULL,
	`patient_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`user_id`, `patient_id`));

CREATE TABLE `pfizer_ra_uat`.`master_users_patients_map` (
	`user_id` INT UNSIGNED NOT NULL,
	`patient_id` INT UNSIGNED NOT NULL,
PRIMARY KEY (`user_id`, `patient_id`));


-- move patient mapping info from the master_users table to the master_users_patients_map for scc, the only property with patients
insert into ahn_scc_production.master_users_patients_map (
	user_id,
	patient_id
)
select
	mu.id,
	mu.patient_id
from ahn_scc_production.master_users as mu
join ahn_scc_production.master_patients as mp
	on mp.id = mu.patient_id;

insert into ahn_scc_uat.master_users_patients_map (
	user_id,
	patient_id
)
select
	mu.id,
	mu.patient_id
from ahn_scc_uat.master_users as mu
join ahn_scc_uat.master_patients as mp
	on mp.id = mu.patient_id;

-- drop the master_users.patient_id column from all properties
ALTER TABLE `ahn_f4s_production`.`master_users` DROP COLUMN `patient_id`;
ALTER TABLE `ahn_f4s_uat`.`master_users` DROP COLUMN `patient_id`;
ALTER TABLE `ahn_scc_production`.`master_users` DROP COLUMN `patient_id`;
ALTER TABLE `ahn_scc_uat`.`master_users` DROP COLUMN `patient_id`;
ALTER TABLE `dod_asb_production`.`master_users` DROP COLUMN `patient_id`;
ALTER TABLE `dod_asb_uat`.`master_users` DROP COLUMN `patient_id`;
ALTER TABLE `mmg_chet_lilly_uat`.`master_users` DROP COLUMN `patient_id`;
ALTER TABLE `mmg_chet_otsuka_uat`.`master_users` DROP COLUMN `patient_id`;
ALTER TABLE `mmg_jcc_production`.`master_users` DROP COLUMN `patient_id`;
ALTER TABLE `mmg_jcc_uat`.`master_users` DROP COLUMN `patient_id`;
ALTER TABLE `mmg_lilly_production`.`master_users` DROP COLUMN `patient_id`;
ALTER TABLE `mmg_lilly_uat`.`master_users` DROP COLUMN `patient_id`;
ALTER TABLE `mmg_otsuka_production`.`master_users` DROP COLUMN `patient_id`;
ALTER TABLE `mmg_otsuka_uat`.`master_users` DROP COLUMN `patient_id`;
ALTER TABLE `mmg_t2d_production`.`master_users` DROP COLUMN `patient_id`;
ALTER TABLE `mmg_t2d_uat`.`master_users` DROP COLUMN `patient_id`;
ALTER TABLE `mr_demo_production`.`master_users` DROP COLUMN `patient_id`;
ALTER TABLE `nami_sd_production`.`master_users` DROP COLUMN `patient_id`;
ALTER TABLE `nami_sd_uat`.`master_users` DROP COLUMN `patient_id`;
ALTER TABLE `pfizer_ra_production`.`master_users` DROP COLUMN `patient_id`;
ALTER TABLE `pfizer_ra_uat`.`master_users` DROP COLUMN `patient_id`;







