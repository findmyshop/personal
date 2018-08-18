TRUNCATE TABLE master_processed_sessions;
TRUNCATE TABLE master_session_processor_runs;
ALTER TABLE `master_processed_sessions`
ADD COLUMN `ip_address` VARCHAR(45) NOT NULL AFTER `session_id`;

