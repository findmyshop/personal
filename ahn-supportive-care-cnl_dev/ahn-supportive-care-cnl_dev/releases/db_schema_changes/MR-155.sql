-- delete bogus master_users_map records
SELECT count('master_users_map - before') FROM master_users_map;
DELETE FROM master_users_map
WHERE
	user_id NOT IN (
		SELECT id FROM master_users
	)
	OR organization_id NOT IN (
		SELECT id FROM master_organizations
	);
SELECT count('master_users_map - after') FROM master_users_map;

-- delete users that dont have a master_users_map record
SELECT count('master_users - before') FROM master_users;
DELETE FROM master_users
WHERE id NOT IN (
	SELECT user_id FROM master_users_map
);
SELECT count('master_users - after') FROM master_users;

-- delete activity associated with a property that doesnt exist in the experience
SELECT count('master_activity_logs - before') FROM master_activity_logs;
DELETE FROM master_activity_logs
WHERE mr_project NOT IN (
	SELECT name FROM master_properties
);
SELECT count('master_activity_logs - after') FROM master_activity_logs;

-- delete activity associated with users that dont exist in the experience
SELECT count('master_activity_logs - before') FROM master_activity_logs;
DELETE FROM master_activity_logs
WHERE user_id NOT IN (
	SELECT id FROM master_users
);
SELECT count('master_activity_logs - after') FROM master_activity_logs;

-- delete question and answer activity that has a blank input question
SELECT count('master_activity_logs - before') FROM master_activity_logs;
DELETE FROM master_activity_logs
WHERE
	(master_activity_logs.action = 'Question' OR master_activity_logs.action = 'Answer')
	AND master_activity_logs.input_question = '';
SELECT count('master_activity_logs - after') FROM master_activity_logs;
