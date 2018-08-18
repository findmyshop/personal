DROP TABLE IF EXISTS `master_surveys`;
CREATE TABLE `master_surveys` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `property_id` int(11) unsigned NOT NULL,
  `timestamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `master_survey_questions`;
CREATE TABLE `master_survey_questions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `survey_id` int(11) unsigned NOT NULL,
  `question_number` tinyint(3) unsigned NOT NULL,
  `input_type` enum('radio','text') NOT NULL,
  `text` varchar(1024) NOT NULL,
  `timestamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `master_survey_question_radio_options`;
CREATE TABLE `master_survey_question_radio_options` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` int(11) unsigned NOT NULL,
  `text` varchar(512) NOT NULL,
  `timestamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

DROP TABLE IF EXISTS `master_user_survey_submissions`;
CREATE TABLE `master_user_survey_submissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `session_id` varchar(40) NOT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `survey_id` int(11) unsigned NOT NULL,
  `timestamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `master_user_survey_responses`;
CREATE TABLE `master_user_survey_responses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `submission_id` int(11) unsigned NOT NULL,
  `question_id` int(11) unsigned NOT NULL,
  `selected_radio_option_id` int(11) unsigned DEFAULT NULL,
  `input_text` varchar(1024) DEFAULT NULL,
  `timestamp_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

-- wcrcanswers.com specific sql below
-- insert master_surveys record
INSERT INTO `master_surveys` (
    `property_id`
) VALUES (
    (SELECT `id` FROM `master_properties` WHERE `name` = 'bcran')
);

-- insert master_survey_questions records
INSERT INTO `master_survey_questions` (
    `survey_id`,
    `question_number`,
    `input_type`,
    `text`
) VALUES (
    1,
    1,
    'radio',
    'After viewing this program, are you more inclined to participate in a clinical trial?'
);

INSERT INTO `master_survey_questions` (
    `survey_id`,
    `question_number`,
    `input_type`,
    `text`
) VALUES (
    1,
    1,
    'radio',
    'How likely are you to recommend this program to a friend?'
);

INSERT INTO `master_survey_questions` (
    `survey_id`,
    `question_number`,
    `input_type`,
    `text`
) VALUES (
    1,
    1,
    'text',
    'How can wcrcanswers.com be improved?'
);

-- insert master_survey_question_radio_options records
-- question 1
INSERT INTO `master_survey_question_radio_options` (
    `question_id`,
    `text`
) VALUES (
    1,
    'Most Likely'
);

INSERT INTO `master_survey_question_radio_options` (
    `question_id`,
    `text`
) VALUES (
    1,
    'Somewhat Likely'
);

INSERT INTO `master_survey_question_radio_options` (
    `question_id`,
    `text`
) VALUES (
    1,
    'Neutral'
);

INSERT INTO `master_survey_question_radio_options` (
    `question_id`,
    `text`
) VALUES (
    1,
    'Somewhat Unlikely'
);

INSERT INTO `master_survey_question_radio_options` (
    `question_id`,
    `text`
) VALUES (
    1,
    'Very Unlikely'
);
-- question 2
INSERT INTO `master_survey_question_radio_options` (
    `question_id`,
    `text`
) VALUES (
    2,
    'Most Likely'
);

INSERT INTO `master_survey_question_radio_options` (
    `question_id`,
    `text`
) VALUES (
    2,
    'Somewhat Likely'
);

INSERT INTO `master_survey_question_radio_options` (
    `question_id`,
    `text`
) VALUES (
    2,
    'Neutral'
);

INSERT INTO `master_survey_question_radio_options` (
    `question_id`,
    `text`
) VALUES (
    2,
    'Somewhat Unlikely'
);

INSERT INTO `master_survey_question_radio_options` (
    `question_id`,
    `text`
) VALUES (
    2,
    'Very Unlikely'
);