-- drop master_patients and master_users_patients_map tables
DROP TABLE IF EXISTS master_patients;
DROP TABLE IF EXISTS master_users_patients_map;

-- UAT
-- drop master_patients and master_users_patients_map tables
DROP TABLE IF EXISTS ahn_f4s_uat.master_patients;
DROP TABLE IF EXISTS ahn_f4s_uat.master_users_patients_map;
DROP TABLE IF EXISTS ahn_ppc_uat.master_patients;
DROP TABLE IF EXISTS ahn_ppc_uat.master_users_patients_map;
DROP TABLE IF EXISTS ahn_scc_uat.master_patients;
DROP TABLE IF EXISTS ahn_scc_uat.master_users_patients_map;
DROP TABLE IF EXISTS az_ddk_uat.master_patients;
DROP TABLE IF EXISTS az_ddk_uat.master_users_patients_map;
DROP TABLE IF EXISTS dod_asb_uat.master_patients;
DROP TABLE IF EXISTS dod_asb_uat.master_users_patients_map;
DROP TABLE IF EXISTS ed_ens_uat.master_patients;
DROP TABLE IF EXISTS ed_ens_uat.master_users_patients_map;
DROP TABLE IF EXISTS mmg_chet_lilly_uat.master_patients;
DROP TABLE IF EXISTS mmg_chet_lilly_uat.master_users_patients_map;
DROP TABLE IF EXISTS mmg_chet_otsuka_uat.master_patients;
DROP TABLE IF EXISTS mmg_chet_otsuka_uat.master_users_patients_map;
DROP TABLE IF EXISTS mmg_jcc_uat.master_patients;
DROP TABLE IF EXISTS mmg_jcc_uat.master_users_patients_map;
DROP TABLE IF EXISTS mmg_lilly_uat.master_patients;
DROP TABLE IF EXISTS mmg_lilly_uat.master_users_patients_map;
DROP TABLE IF EXISTS mmg_otsuka_uat.master_patients;
DROP TABLE IF EXISTS mmg_otsuka_uat.master_users_patients_map;
DROP TABLE IF EXISTS mmg_t2d_uat.master_patients;
DROP TABLE IF EXISTS mmg_t2d_uat.master_users_patients_map;
DROP TABLE IF EXISTS mmg_ysc_uat.master_patients;
DROP TABLE IF EXISTS mmg_ysc_uat.master_users_patients_map;
DROP TABLE IF EXISTS nami_sd_uat.master_patients;
DROP TABLE IF EXISTS nami_sd_uat.master_users_patients_map;
DROP TABLE IF EXISTS pfizer_ra_uat.master_patients;
DROP TABLE IF EXISTS pfizer_ra_uat.master_users_patients_map;
DROP TABLE IF EXISTS rush_sbirt_uat.master_patients;
DROP TABLE IF EXISTS rush_sbirt_uat.master_users_patients_map;

-- create guest login account
INSERT INTO ahn_scc_uat.master_users (
	user_type_id,
	first_name,
	last_name,
	username,
	password,
	email,
	created_by,
	created_date,
	login_enabled
) VALUES (
	4,
	'Anonymous',
	'User',
	'Guest',
	'',
	'',
	0,
	NOW(),
	0
);
INSERT INTO ahn_scc_uat.master_users_map (
	user_id,
	organization_id
) VALUES (
	(
		SELECT
			id
		FROM master_users
		WHERE
			username = 'Guest'
	),
	(
		SELECT
			id
		FROM master_organizations
		WHERE name = 'Allegheny Health Network'
	)
);

-- delete non-guest user accounts
DELETE FROM ahn_scc_uat.master_actions WHERE user_id in (SELECT id FROM master_users WHERE user_type_id = 4 AND username != 'Guest');
DELETE FROM ahn_scc_uat.master_activity_logs WHERE user_id in (SELECT id FROM master_users WHERE user_type_id = 4 AND username != 'Guest');
DELETE FROM ahn_scc_uat.master_discount_codes_report WHERE user_id in (SELECT id FROM master_users WHERE user_type_id = 4 AND username != 'Guest');
DELETE FROM ahn_scc_uat.master_instructor_class_map WHERE user_id in (SELECT id FROM master_users WHERE user_type_id = 4 AND username != 'Guest');
DELETE FROM ahn_scc_uat.master_scores_report WHERE user_id in (SELECT id FROM master_users WHERE user_type_id = 4 AND username != 'Guest');
DELETE FROM ahn_scc_uat.master_students WHERE user_id in (SELECT id FROM master_users WHERE user_type_id = 4 AND username != 'Guest');
DELETE FROM ahn_scc_uat.master_user_authentication_attempts WHERE user_id in (SELECT id FROM master_users WHERE user_type_id = 4 AND username != 'Guest');
DELETE FROM ahn_scc_uat.master_user_password_reset WHERE user_id in (SELECT id FROM master_users WHERE user_type_id = 4 AND username != 'Guest');
DELETE FROM ahn_scc_uat.master_users_map WHERE user_id in (SELECT id FROM master_users WHERE user_type_id = 4 AND username != 'Guest');
DELETE FROM ahn_scc_uat.master_users_organization_hierarchy_level_element_map WHERE user_id in (SELECT id FROM master_users WHERE user_type_id = 4 AND username != 'Guest');
DELETE FROM ahn_scc_uat.master_users_patients_map WHERE user_id in (SELECT id FROM master_users WHERE user_type_id = 4 AND username != 'Guest');
DELETE FROM ahn_scc_uat.master_users where user_type_id = 4 AND username != 'Guest';

-- set the user id for each activity record to the new guest user account user_id
-- IMPORTANT - verify that this works properly in PRODUCTION
SET @guest_user_id = (SELECT id FROM ahn_scc_uat.master_users WHERE username = 'Guest');
UPDATE ahn_scc_uat.master_activity_logs
LEFT JOIN ahn_scc_uat.master_users
	ON master_users.id = master_activity_logs.user_id
SET user_id = @guest_user_id
WHERE
	master_users.id IS NULL;

-- PROD
-- drop master_patients and master_users_patients_map tables
DROP TABLE IF EXISTS ahn_f4s_production.master_patients;
DROP TABLE IF EXISTS ahn_f4s_production.master_users_patients_map;
DROP TABLE IF EXISTS ahn_ppc_production.master_patients;
DROP TABLE IF EXISTS ahn_ppc_production.master_users_patients_map;
DROP TABLE IF EXISTS ahn_scc_production.master_patients;
DROP TABLE IF EXISTS ahn_scc_production.master_users_patients_map;
DROP TABLE IF EXISTS az_ddk_production.master_patients;
DROP TABLE IF EXISTS az_ddk_production.master_users_patients_map;
DROP TABLE IF EXISTS dod_asb_production.master_patients;
DROP TABLE IF EXISTS dod_asb_production.master_users_patients_map;
DROP TABLE IF EXISTS ed_ens_production.master_patients;
DROP TABLE IF EXISTS ed_ens_production.master_users_patients_map;
DROP TABLE IF EXISTS mmg_jcc_production.master_patients;
DROP TABLE IF EXISTS mmg_jcc_production.master_users_patients_map;
DROP TABLE IF EXISTS mmg_lilly_production.master_patients;
DROP TABLE IF EXISTS mmg_lilly_production.master_users_patients_map;
DROP TABLE IF EXISTS mmg_otsuka_production.master_patients;
DROP TABLE IF EXISTS mmg_otsuka_production.master_users_patients_map;
DROP TABLE IF EXISTS mmg_t2d_production.master_patients;
DROP TABLE IF EXISTS mmg_t2d_production.master_users_patients_map;
DROP TABLE IF EXISTS mmg_ysc_production.master_patients;
DROP TABLE IF EXISTS mmg_ysc_production.master_users_patients_map;
DROP TABLE IF EXISTS mr_demo_production.master_patients;
DROP TABLE IF EXISTS mr_demo_production.master_users_patients_map;
DROP TABLE IF EXISTS mr_wordpress_production.master_patients;
DROP TABLE IF EXISTS mr_wordpress_production.master_users_patients_map;
DROP TABLE IF EXISTS nami_sd_production.master_patients;
DROP TABLE IF EXISTS nami_sd_production.master_users_patients_map;
DROP TABLE IF EXISTS pfizer_ra_production.master_patients;
DROP TABLE IF EXISTS pfizer_ra_production.master_users_patients_map;
DROP TABLE IF EXISTS rush_sbirt_production.master_patients;
DROP TABLE IF EXISTS rush_sbirt_production.master_users_patients_map;

-- create guest login account
INSERT INTO ahn_scc_production.master_users (
	user_type_id,
	first_name,
	last_name,
	username,
	password,
	email,
	created_by,
	created_date,
	login_enabled
) VALUES (
	4,
	'Anonymous',
	'User',
	'Guest',
	'',
	'',
	0,
	NOW(),
	0
);
INSERT INTO ahn_scc_production.master_users_map (
	user_id,
	organization_id
) VALUES (
	(
		SELECT
			id
		FROM master_users
		WHERE
			username = 'Guest'
	),
	(
		SELECT
			id
		FROM master_organizations
		WHERE name = 'Allegheny Health Network'
	)
);

-- delete non-guest user accounts
DELETE FROM ahn_scc_production.master_actions WHERE user_id in (SELECT id FROM master_users WHERE user_type_id = 4 AND username != 'Guest');
DELETE FROM ahn_scc_production.master_activity_logs WHERE user_id in (SELECT id FROM master_users WHERE user_type_id = 4 AND username != 'Guest');
DELETE FROM ahn_scc_production.master_discount_codes_report WHERE user_id in (SELECT id FROM master_users WHERE user_type_id = 4 AND username != 'Guest');
DELETE FROM ahn_scc_production.master_instructor_class_map WHERE user_id in (SELECT id FROM master_users WHERE user_type_id = 4 AND username != 'Guest');
DELETE FROM ahn_scc_production.master_scores_report WHERE user_id in (SELECT id FROM master_users WHERE user_type_id = 4 AND username != 'Guest');
DELETE FROM ahn_scc_production.master_students WHERE user_id in (SELECT id FROM master_users WHERE user_type_id = 4 AND username != 'Guest');
DELETE FROM ahn_scc_production.master_user_authentication_attempts WHERE user_id in (SELECT id FROM master_users WHERE user_type_id = 4 AND username != 'Guest');
DELETE FROM ahn_scc_production.master_user_password_reset WHERE user_id in (SELECT id FROM master_users WHERE user_type_id = 4 AND username != 'Guest');
DELETE FROM ahn_scc_production.master_users_map WHERE user_id in (SELECT id FROM master_users WHERE user_type_id = 4 AND username != 'Guest');
DELETE FROM ahn_scc_production.master_users_organization_hierarchy_level_element_map WHERE user_id in (SELECT id FROM master_users WHERE user_type_id = 4 AND username != 'Guest');
DELETE FROM ahn_scc_production.master_users_patients_map WHERE user_id in (SELECT id FROM master_users WHERE user_type_id = 4 AND username != 'Guest');
DELETE FROM ahn_scc_production.master_users where user_type_id = 4 AND username != 'Guest';

-- set the user id for each activity record to the new guest user account user_id
-- IMPORTANT - verify that this works properly in PRODUCTION
SET @guest_user_id = (SELECT id FROM ahn_scc_production.master_users WHERE username = 'Guest');
UPDATE ahn_scc_production.master_activity_logs
LEFT JOIN ahn_scc_production.master_users
	ON master_users.id = master_activity_logs.user_id
SET user_id = @guest_user_id
WHERE
	master_users.id IS NULL;


