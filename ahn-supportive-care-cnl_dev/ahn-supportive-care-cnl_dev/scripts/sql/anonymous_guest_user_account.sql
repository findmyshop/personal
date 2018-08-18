INSERT INTO master_users (
	user_type_id,
	first_name,
	middle_initial,
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
	'',
	'User',
	'Guest',
	'',
	'',
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
		WHERE name = 'Medrespond'
	)
);