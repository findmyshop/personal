ALTER TABLE `master_users_map`
ADD COLUMN `show_asl_videos` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 AFTER `video_bit_rate`;

ALTER TABLE `master_activity_logs`
ADD COLUMN `was_asl_response` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Whether or not current_response was shown in american sign language.' AFTER `response_type`;
