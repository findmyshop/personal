-- dev
TRUNCATE TABLE `medrespond_anthony_dev`.`master_project_password_rule_map`;
INSERT INTO `medrespond_anthony_dev`.`master_project_password_rule_map` (
	`project_id`,
	`password_rule_id`
) VALUES (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `project_name` = 'pra'), 1
), (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `project_name` = 'pra'), 2
), (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `project_name` = 'pra'), 3
), (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `project_name` = 'pra'), 4
), (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `project_name` = 'pra'), 6
), (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `project_name` = 'pra'), 7
), (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `project_name` = 'prb'), 1
), (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `project_name` = 'prb'), 2
), (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `project_name` = 'prb'), 3
), (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `project_name` = 'prb'), 4
), (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `project_name` = 'prb'), 6
), (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `project_name` = 'prb'), 7
), (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `project_name` = 'prc'), 1
), (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `project_name` = 'prc'), 2
), (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `project_name` = 'prc'), 3
), (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `project_name` = 'prc'), 4
), (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `project_name` = 'prc'), 6
), (
	(SELECT `id` FROM `medrespond_anthony_dev`.`master_organizations` WHERE `project_name` = 'prc'), 7
);

-- uat
TRUNCATE TABLE `pfizer_ra_uat`.`master_project_password_rule_map`;
INSERT INTO `pfizer_ra_uat`.`master_project_password_rule_map` (
	`project_id`,
	`password_rule_id`
) VALUES (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `project_name` = 'pra'), 1
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `project_name` = 'pra'), 2
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `project_name` = 'pra'), 3
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `project_name` = 'pra'), 4
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `project_name` = 'pra'), 6
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `project_name` = 'pra'), 7
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `project_name` = 'prb'), 1
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `project_name` = 'prb'), 2
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `project_name` = 'prb'), 3
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `project_name` = 'prb'), 4
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `project_name` = 'prb'), 6
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `project_name` = 'prb'), 7
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `project_name` = 'prc'), 1
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `project_name` = 'prc'), 2
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `project_name` = 'prc'), 3
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `project_name` = 'prc'), 4
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `project_name` = 'prc'), 6
), (
	(SELECT `id` FROM `pfizer_ra_uat`.`master_organizations` WHERE `project_name` = 'prc'), 7
);

--prod
TRUNCATE TABLE `pfizer_ra_production`.`master_project_password_rule_map`;
INSERT INTO `pfizer_ra_production`.`master_project_password_rule_map` (
	`project_id`,
	`password_rule_id`
) VALUES (
	(SELECT `id` FROM `pfizer_ra_production`.`master_organizations` WHERE `project_name` = 'pra'), 1
), (
	(SELECT `id` FROM `pfizer_ra_production`.`master_organizations` WHERE `project_name` = 'pra'), 2
), (
	(SELECT `id` FROM `pfizer_ra_production`.`master_organizations` WHERE `project_name` = 'pra'), 3
), (
	(SELECT `id` FROM `pfizer_ra_production`.`master_organizations` WHERE `project_name` = 'pra'), 4
), (
	(SELECT `id` FROM `pfizer_ra_production`.`master_organizations` WHERE `project_name` = 'pra'), 6
), (
	(SELECT `id` FROM `pfizer_ra_production`.`master_organizations` WHERE `project_name` = 'pra'), 7
), (
	(SELECT `id` FROM `pfizer_ra_production`.`master_organizations` WHERE `project_name` = 'prb'), 1
), (
	(SELECT `id` FROM `pfizer_ra_production`.`master_organizations` WHERE `project_name` = 'prb'), 2
), (
	(SELECT `id` FROM `pfizer_ra_production`.`master_organizations` WHERE `project_name` = 'prb'), 3
), (
	(SELECT `id` FROM `pfizer_ra_production`.`master_organizations` WHERE `project_name` = 'prb'), 4
), (
	(SELECT `id` FROM `pfizer_ra_production`.`master_organizations` WHERE `project_name` = 'prb'), 6
), (
	(SELECT `id` FROM `pfizer_ra_production`.`master_organizations` WHERE `project_name` = 'prb'), 7
), (
	(SELECT `id` FROM `pfizer_ra_production`.`master_organizations` WHERE `project_name` = 'prc'), 1
), (
	(SELECT `id` FROM `pfizer_ra_production`.`master_organizations` WHERE `project_name` = 'prc'), 2
), (
	(SELECT `id` FROM `pfizer_ra_production`.`master_organizations` WHERE `project_name` = 'prc'), 3
), (
	(SELECT `id` FROM `pfizer_ra_production`.`master_organizations` WHERE `project_name` = 'prc'), 4
), (
	(SELECT `id` FROM `pfizer_ra_production`.`master_organizations` WHERE `project_name` = 'prc'), 6
), (
	(SELECT `id` FROM `pfizer_ra_production`.`master_organizations` WHERE `project_name` = 'prc'), 7
);