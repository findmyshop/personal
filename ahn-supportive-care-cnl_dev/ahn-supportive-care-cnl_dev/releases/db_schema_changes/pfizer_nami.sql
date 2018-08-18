ALTER TABLE master_activity_logs add column mr_project VARCHAR(28) NOT NULL after id;

INSERT INTO master_users (
	user_type_id,
	first_name,
	middle_initial,
	last_name,
	username,
	password,
	email,
	patient_id,
	created_by,
	created_date,
	login_enabled
) VALUES (
	4,
	'Anonymous',
	'',
	'User',
	'Guest',
	'',
	'',
	0,
	0,
	NOW(),
	0
);

INSERT INTO master_users_map (
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
		WHERE organization_name = 'Medrespond'
	)
);

-- Fit For Surgery - f4s
USE ahn_f4s_production;
ALTER TABLE master_activity_logs add column mr_project VARCHAR(28) NOT NULL after id;
UPDATE master_activity_logs
SET master_activity_logs.mr_project = 'f4s';

USE ahn_f4s_uat;
ALTER TABLE master_activity_logs add column mr_project VARCHAR(28) NOT NULL after id;
UPDATE master_activity_logs
SET master_activity_logs.mr_project = 'f4s';

-- Supportive Care - scc
USE ahn_scc_production;
ALTER TABLE master_activity_logs add column mr_project VARCHAR(28) NOT NULL after id;
UPDATE master_activity_logs
SET master_activity_logs.mr_project = 'scc';

USE ahn_scc_uat;
ALTER TABLE master_activity_logs add column mr_project VARCHAR(28) NOT NULL after id;
UPDATE master_activity_logs
SET master_activity_logs.mr_project = 'scc';

-- AssBIRT - dod
USE dod_asb_production;
ALTER TABLE master_activity_logs add column mr_project VARCHAR(28) NOT NULL after id;
UPDATE master_activity_logs
SET master_activity_logs.mr_project = 'dod';

USE dod_asb_uat;
ALTER TABLE master_activity_logs add column mr_project VARCHAR(28) NOT NULL after id;
UPDATE master_activity_logs
SET master_activity_logs.mr_project = 'dod';

-- Juniper Conversations - jcc
USE mmg_jcc_production;
ALTER TABLE master_activity_logs add column mr_project VARCHAR(28) NOT NULL after id;
UPDATE master_activity_logs
SET master_activity_logs.mr_project = 'jcc';

USE mmg_jcc_uat;
ALTER TABLE master_activity_logs add column mr_project VARCHAR(28) NOT NULL after id;
UPDATE master_activity_logs
SET master_activity_logs.mr_project = 'jcc';

-- Monarch 2 Conversations - lilly
USE mmg_lilly_production;
ALTER TABLE master_activity_logs add column mr_project VARCHAR(28) NOT NULL after id;
UPDATE master_activity_logs
SET master_activity_logs.mr_project = 'lilly';

USE mmg_lilly_uat;
ALTER TABLE master_activity_logs add column mr_project VARCHAR(28) NOT NULL after id;
UPDATE master_activity_logs
SET master_activity_logs.mr_project = 'lilly';

USE mmg_chet_lilly_uat;
ALTER TABLE master_activity_logs add column mr_project VARCHAR(28) NOT NULL after id;
UPDATE master_activity_logs
SET master_activity_logs.mr_project = 'lilly';

-- PKD Conversations - otsuka
USE mmg_otsuka_production;
ALTER TABLE master_activity_logs add column mr_project VARCHAR(28) NOT NULL after id;
UPDATE master_activity_logs
SET master_activity_logs.mr_project = 'otsuka';

USE mmg_otsuka_uat;
ALTER TABLE master_activity_logs add column mr_project VARCHAR(28) NOT NULL after id;
UPDATE master_activity_logs
SET master_activity_logs.mr_project = 'otsuka';

USE mmg_chet_otsuka_uat;
ALTER TABLE master_activity_logs add column mr_project VARCHAR(28) NOT NULL after id;
UPDATE master_activity_logs
SET master_activity_logs.mr_project = 'otsuka';

-- Situp Conversations - t2d
USE mmg_t2d_production;
ALTER TABLE master_activity_logs add column mr_project VARCHAR(28) NOT NULL after id;
UPDATE master_activity_logs
SET master_activity_logs.mr_project = 't2d';

USE mmg_t2d_uat;
ALTER TABLE master_activity_logs add column mr_project VARCHAR(28) NOT NULL after id;
UPDATE master_activity_logs
SET master_activity_logs.mr_project = 't2d';

-- Demo - default
USE mr_demo_production;
ALTER TABLE master_activity_logs add column mr_project VARCHAR(28) NOT NULL after id;
UPDATE master_activity_logs
SET master_activity_logs.mr_project = 'default';

-- Nami San Diego - nsd
USE nami_sd_production;
ALTER TABLE master_activity_logs add column mr_project VARCHAR(28) NOT NULL after id;
UPDATE master_activity_logs
SET master_activity_logs.mr_project = 'nsd';

USE nami_sd_uat;
ALTER TABLE master_activity_logs add column mr_project VARCHAR(28) NOT NULL after id;
UPDATE master_activity_logs
SET master_activity_logs.mr_project = 'nsd';




