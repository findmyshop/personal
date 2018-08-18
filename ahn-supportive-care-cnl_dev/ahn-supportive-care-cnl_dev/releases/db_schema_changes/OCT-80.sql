DROP TABLE IF EXISTS `master_session_processor_runs`;
CREATE TABLE `master_session_processor_runs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `property_id` int(11) unsigned NOT NULL,
  `first_activity_id` int(11) unsigned DEFAULT NULL,
  `last_activity_id` int(11) unsigned DEFAULT NULL,
  `start_timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `end_timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `session_processor_runs_index` (`property_id`, `first_activity_id`, `last_activity_id`, `start_timestamp`, `end_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


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
  `input_question_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `timestamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `processed_sessions_index` (`session_processor_run_id`,`session_id`,`user_id`,`start_datetime`,`end_datetime`,`seconds`,`activity_count`, `input_question_count`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


