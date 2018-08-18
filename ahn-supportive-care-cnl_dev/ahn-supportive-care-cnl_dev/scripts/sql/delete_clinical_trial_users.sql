SET SQL_SAFE_UPDATES = 0;

DELETE FROM master_activity_logs
WHERE user_id IN (

);

DELETE FROM master_user_password_reset
WHERE user_id IN (

);

DELETE FROM master_users
WHERE id IN (

);

DELETE FROM master_users_map
WHERE user_id IN (

);
