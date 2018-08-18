ALTER TABLE `master_activity_logs`
ADD COLUMN `flow_attempt` SMALLINT(5) UNSIGNED NULL DEFAULT NULL AFTER `was_asl_response`,
ADD COLUMN `flow_response_attempt` SMALLINT(5) UNSIGNED NULL DEFAULT NULL AFTER `flow_attempt`;
