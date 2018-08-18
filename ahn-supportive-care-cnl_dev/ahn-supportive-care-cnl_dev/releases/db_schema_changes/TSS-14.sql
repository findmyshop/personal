DROP TABLE IF EXISTS `master_preprocessor_clause_segmenter_runs`;
CREATE TABLE `master_preprocessor_clause_segmenter_runs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `string` text NOT NULL,
  `curl_request_succeeded` tinyint(1) NOT NULL,
  `curl_error_message` text DEFAULT NULL,
  `timestamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

DROP TABLE IF EXISTS `master_preprocessor_clause_segments`;
CREATE TABLE `master_preprocessor_clause_segments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `run_id` int(11) NOT NULL,
  `clause_segment` text NOT NULL,
  `timestamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `master_features` (
	`name`,
	`admin`,
	`site_admin`,
	`user`,
	`unauthenticated`
) VALUES (
	'preprocessor_clause_segmenter',
	0,
	0,
	0,
	0
);

INSERT INTO `master_features` (
	`name`,
	`admin`,
	`site_admin`,
	`user`,
	`unauthenticated`
) VALUES (
	'preprocessor_clause_segmenter_error_message',
	0,
	0,
	0,
	0
);



