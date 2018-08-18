TRUNCATE TABLE `master_session_processor_runs`;
DROP TABLE IF EXISTS `master_processed_sessions`;
CREATE TABLE `master_processed_sessions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `session_processor_run_id` int(11) NOT NULL,
  `session_id` varchar(40) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `start_activity_id` int(11) unsigned NOT NULL,
  `end_activity_id` int(11) unsigned NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL COMMENT 'NOTE that the end_datetime is determined by adding a padding (default of 90 seconds) to the datetime of the last session activity',
  `seconds` int(10) unsigned NOT NULL DEFAULT '90',
  `activity_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `start_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `replay_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `previous_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `next_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `input_question_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `related_question_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `left_rail_question_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `other_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `timestamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `processed_sessions_index` (`session_processor_run_id`,`session_id`,`user_id`,`start_datetime`,`end_datetime`,`seconds`,`activity_count`,`start_count`,`previous_count`,`next_count`,`input_question_count`,`related_question_count`,`left_rail_question_count`)
) ENGINE=InnoDB AUTO_INCREMENT=349 DEFAULT CHARSET=utf8;
