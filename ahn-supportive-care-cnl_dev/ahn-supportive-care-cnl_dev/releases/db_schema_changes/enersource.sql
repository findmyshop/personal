-- add postal_code column to the master_users table
ALTER TABLE `medrespond_anthony_dev`.`master_users`
ADD COLUMN `postal_code` CHAR(6) NOT NULL AFTER `email`;

-- create master_user_experience_state_map table
CREATE TABLE `master_user_experience_state_map` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `experience_state` enum('INITIALIZED','RELIABILITY_COMPLETED','TEST_IN_PROGRESS','TEST_COMPLETED') COLLATE utf8_bin NOT NULL,
  `active` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY `KEY` (`id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- insert master_courses entry
INSERT INTO `master_courses` (
	id,
	organization_id,
	course_name,
	max_iterations,
	url,
	after_disclaimer,
	before_certification,
	after_certification,
	last_rid,
	total_sections,
	total_tests_surveys,
	active
) VALUES (
	'1',
	'11',
	'Enersource Contest',
	'1',
	NULL,
	NULL,
	NULL,
	NULL,
	NULL,
	'0',
	'0',
	'1'
);

-- insert master_tests entries
-- question 1
INSERT INTO `master_tests` (
  `key`,
  `test_name`,
  `course_id`
) VALUES (
  'enr0806',
  'Question 1',
  1
);
INSERT INTO `master_tests` (
  `key`,
  `test_name`,
  `course_id`
) VALUES (
  'enr0807',
  'Question 1 - Long Term Plan 007',
  1
);
-- question 2
INSERT INTO `master_tests` (
  `key`,
  `test_name`,
  `course_id`
) VALUES (
  'enr0808',
  'Question 2',
  1
);
INSERT INTO `master_tests` (
  `key`,
  `test_name`,
  `course_id`
) VALUES (
  'enr0809',
  'Question 2 - Long Term Plan 009',
  1
);
-- question 3
INSERT INTO `master_tests` (
  `key`,
  `test_name`,
  `course_id`
) VALUES (
  'enr0810',
  'Question 3',
  1
);
-- question 4
INSERT INTO `master_tests` (
  `key`,
  `test_name`,
  `course_id`
) VALUES (
  'enr0914',
  'Question 4',
  1
);
INSERT INTO `master_tests` (
  `key`,
  `test_name`,
  `course_id`
) VALUES (
  'enr0915',
  'Question 4 - Long Term Plan 015',
  1
);
-- question 5
INSERT INTO `master_tests` (
  `key`,
  `test_name`,
  `course_id`
) VALUES (
  'enr0916',
  'Question 5',
  1
);
INSERT INTO `master_tests` (
  `key`,
  `test_name`,
  `course_id`
) VALUES (
  'enr0917',
  'Question 5 - Long Term Plan 017',
  1
);
-- question 6
INSERT INTO `master_tests` (
  `key`,
  `test_name`,
  `course_id`
) VALUES (
  'enr0918',
  'Question 6',
  1
);
-- question 7
INSERT INTO `master_tests` (
  `key`,
  `test_name`,
  `course_id`
) VALUES (
  'enr1022',
  'Question 7',
  1
);
INSERT INTO `master_tests` (
  `key`,
  `test_name`,
  `course_id`
) VALUES (
  'enr1023',
  'Question 7 - Long Term Plan 023',
  1
);
-- question 8
INSERT INTO `master_tests` (
  `key`,
  `test_name`,
  `course_id`
) VALUES (
  'enr1024',
  'Question 8',
  1
);
INSERT INTO `master_tests` (
  `key`,
  `test_name`,
  `course_id`
) VALUES (
  'enr1025',
  'Question 8 - Long Term Plan 025',
  1
);
-- question 9
INSERT INTO `master_tests` (
  `key`,
  `test_name`,
  `course_id`
) VALUES (
  'enr1026',
  'Question 9',
  1
);
INSERT INTO `master_tests` (
  `key`,
  `test_name`,
  `course_id`
) VALUES (
  'enr1304',
  'Question 9 - Benefits 004',
  1
);
-- question 10
INSERT INTO `master_tests` (
  `key`,
  `test_name`,
  `course_id`
) VALUES (
  'enr1305',
  'Question 10',
  1
);
INSERT INTO `master_tests` (
  `key`,
  `test_name`,
  `course_id`
) VALUES (
  'enr1306',
  'Question 10 - Benefits 006',
  1
);
-- question 11
INSERT INTO `master_tests` (
  `key`,
  `test_name`,
  `course_id`
) VALUES (
  'enr1307',
  'Question 11',
  1
);

-- insert master_test_elements and master_test_elements_schemes records
-- question 1
INSERT INTO `medrespond_anthony_dev`.`master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests where `key` = 'enr0806'), -- test_id
	'enr0806', -- response_id
	0, -- question_number
	0, -- question_number_display_text
	'Given this brief description of what we are considering, what are your thoughts about our plans for the System Service and System Access components of our Long Term Plan?', -- question
	'', -- correct_answer
	0,
	'' -- heading
);

INSERT INTO `medrespond_anthony_dev`.`master_test_elements_schemes` (
	`scheme_id`,
	`answer`,
	`text`
) VALUES (
	1, -- scheme_id
	'1', -- answer
	'Not Very Critical' -- text
);

INSERT INTO `medrespond_anthony_dev`.`master_test_elements_schemes` (
	`scheme_id`,
	`answer`,
	`text`
) VALUES (
	1, -- scheme_id
	'2', -- answer
	'Somewhat Critical' -- text
);

INSERT INTO `medrespond_anthony_dev`.`master_test_elements_schemes` (
	`scheme_id`,
	`answer`,
	`text`
) VALUES (
	1, -- scheme_id
	'3', -- answer
	'Very Critical' -- text
);

INSERT INTO `medrespond_anthony_dev`.`master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests where `key` = 'enr0807'), -- test_id
	'enr0807', -- response_id
	0, -- question_number
	0, -- question_number_display_text
	'How critical would you say investments in the System Service and System Access areas are?  Would you say very critical, somewhat critical, or not very critical?', -- question
	'', -- correct_answer
	1, -- scheme
	'' -- heading
);

-- question 2
INSERT INTO `medrespond_anthony_dev`.`master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests where `key` = 'enr0808'), -- test_id
	'enr0808', -- response_id
	0, -- question_number
	0, -- question_number_display_text
	'Why do you say that?', -- question
	'', -- correct_answer
	0, -- scheme
	'' -- heading
);

INSERT INTO `medrespond_anthony_dev`.`master_test_elements_schemes` (
	`scheme_id`,
	`answer`,
	`text`
) VALUES (
	2, -- scheme_id
	'1', -- answer
	'Not Very Appropriate' -- text
);

INSERT INTO `medrespond_anthony_dev`.`master_test_elements_schemes` (
	`scheme_id`,
	`answer`,
	`text`
) VALUES (
	2, -- scheme_id
	'2', -- answer
	'Somewhat Appropriate' -- text
);

INSERT INTO `medrespond_anthony_dev`.`master_test_elements_schemes` (
	`scheme_id`,
	`answer`,
	`text`
) VALUES (
	2, -- scheme_id
	'3', -- answer
	'Very Appropriate' -- text
);

INSERT INTO `medrespond_anthony_dev`.`master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests where `key` = 'enr0809'), -- test_id
	'enr0809', -- response_id
	0, -- question_number
	0, -- question_number_display_text
	'Next, to what degree do you think that the proposed 30% increase in investment in the System Service and System Access areas is appropriate?  Would you say very appropriate, somewhat appropriate, or not very appropriate?', -- question
	'', -- correct_answer
	2, -- scheme
	'' -- heading
);

-- question 3
INSERT INTO `medrespond_anthony_dev`.`master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests where `key` = 'enr0810'), -- test_id
	'enr0810', -- response_id
	0, -- question_number
	0, -- question_number_display_text
	'Why do you say that?', -- question
	'', -- correct_answer
	0, -- scheme
	'' -- heading
);

-- question 4
INSERT INTO `medrespond_anthony_dev`.`master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests where `key` = 'enr0914'), -- test_id
	'enr0914', -- response_id
	0, -- question_number
	0, -- question_number_display_text
	'Given this brief description what are your thoughts about our plans for System Renewal?', -- question
	'', -- correct_answer
	0, -- scheme
	'' -- heading
);

INSERT INTO `medrespond_anthony_dev`.`master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests where `key` = 'enr0915'), -- test_id
	'enr0915', -- response_id
	0, -- question_number
	0, -- question_number_display_text
	'How critical would you say investments in the System Renewal area is?  Would you say very critical, somewhat critical, or not very critical?', -- question
	'', -- correct_answer
	1, -- scheme
	'' -- heading
);

-- question 5
INSERT INTO `medrespond_anthony_dev`.`master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests where `key` = 'enr0916'), -- test_id
	'enr0916', -- response_id
	0, -- question_number
	0, -- question_number_display_text
	'Why do you say that?', -- question
	'', -- correct_answer
	0, -- scheme
	'' -- heading
);

INSERT INTO `medrespond_anthony_dev`.`master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests where `key` = 'enr0917'), -- test_id
	'enr0917', -- response_id
	0, -- question_number
	0, -- question_number_display_text
	'Next, to what degree do you think that the proposed 20% increase in investment in the System Renewal area is appropriate?  Would you say very appropriate, somewhat appropriate, or not very appropriate?', -- question
	'', -- correct_answer
	2, -- scheme
	'' -- heading
);

-- question 6
INSERT INTO `medrespond_anthony_dev`.`master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests where `key` = 'enr0918'), -- test_id
	'enr0918', -- response_id
	0, -- question_number
	0, -- question_number_display_text
	'Why do you say that?', -- question
	'', -- correct_answer
	0, -- scheme
	'' -- heading
);

-- question 7
INSERT INTO `medrespond_anthony_dev`.`master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests where `key` = 'enr1022'), -- test_id
	'enr1022', -- response_id
	0, -- question_number
	0, -- question_number_display_text
	'Given this brief description what are your thoughts about the work we have included in the General Plant plan?', -- question
	'', -- correct_answer
	0, -- scheme
	'' -- heading
);

INSERT INTO `medrespond_anthony_dev`.`master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests where `key` = 'enr1023'), -- test_id
	'enr1023', -- response_id
	0, -- question_number
	0, -- question_number_display_text
	'Just a few more questions about the General Plant plan, if that\'s okay? First, how critical would you say investments in the General Plant area are?  Would you say very critical, somewhat critical, or not very critical?', -- question
	'', -- correct_answer
	1, -- scheme
	'' -- heading
);

-- question 8
INSERT INTO `medrespond_anthony_dev`.`master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests where `key` = 'enr1024'), -- test_id
	'enr1024', -- response_id
	0, -- question_number
	0, -- question_number_display_text
	'Why do you say that?', -- question
	'', -- correct_answer
	0, -- scheme
	'' -- heading
);

INSERT INTO `medrespond_anthony_dev`.`master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests where `key` = 'enr1025'), -- test_id
	'enr1025', -- response_id
	0, -- question_number
	0, -- question_number_display_text
	'Next, to what degree do you think that the unchanged level of investment in the General Plant area is appropriate?  Would you say very appropriate, somewhat appropriate, or not very appropriate?', -- question
	'', -- correct_answer
	2, -- scheme
	'' -- heading
);

-- question 9
INSERT INTO `medrespond_anthony_dev`.`master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests where `key` = 'enr1025'), -- test_id
	'enr1025', -- response_id
	0, -- question_number
	0, -- question_number_display_text
	'Why do you say that?', -- question
	'', -- correct_answer
	0, -- scheme
	'' -- heading
);

INSERT INTO `medrespond_anthony_dev`.`master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests where `key` = 'enr1304'), -- test_id
	'enr1304', -- response_id
	0, -- question_number
	0, -- question_number_display_text
	'When considering the combined investments mentioned earlier, the overall proposed level of expenditure in the next 5 years is about 35% higher than for the previous 5 years. Given everything we\'ve discussed, to what degree do you think that the proposed increase in investment is appropriate? Would you say they are Very Appropriate; Somewhat Appropriate; or Not Very Appropriate?', -- question
	'', -- correct_answer
	2, -- scheme
	'' -- heading
);

-- question 10
INSERT INTO `medrespond_anthony_dev`.`master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests where `key` = 'enr1305'), -- test_id
	'enr1305', -- response_id
	0, -- question_number
	0, -- question_number_display_text
	'Why do you say that?', -- question
	'', -- correct_answer
	0, -- scheme
	'' -- heading
);

INSERT INTO `medrespond_anthony_dev`.`master_test_elements_schemes` (
	`scheme_id`,
	`answer`,
	`text`
) VALUES (
	3, -- scheme_id
	'1', -- answer
	'Low Degree of Confidence' -- text
);

INSERT INTO `medrespond_anthony_dev`.`master_test_elements_schemes` (
	`scheme_id`,
	`answer`,
	`text`
) VALUES (
	3, -- scheme_id
	'2', -- answer
	'Medium Degree of Confidence' -- text
);

INSERT INTO `medrespond_anthony_dev`.`master_test_elements_schemes` (
	`scheme_id`,
	`answer`,
	`text`
) VALUES (
	3, -- scheme_id
	'3', -- answer
	'High Degree of Confidence' -- text
);

INSERT INTO `medrespond_anthony_dev`.`master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests where `key` = 'enr1306'), -- test_id
	'enr1306', -- response_id
	0, -- question_number
	0, -- question_number_display_text
	'Thinking about everything that we\'ve discussed about the Long Term Plan, how confident are you that our team at Enersource will continue to do a good job of providing safe, reliable, cost effective electricity by implementing the investments associated with the Long Term Plan? Would you say that you have a High, Medium, or Low degree of confidence?', -- question
	'', -- correct_answer
	3, -- scheme
	'' -- heading
);

-- question 11
INSERT INTO `medrespond_anthony_dev`.`master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests where `key` = 'enr1307'), -- test_id
	'enr1307', -- response_id
	0, -- question_number
	0, -- question_number_display_text
	'Why do you say that?', -- question
	'', -- correct_answer
	0, -- scheme
	'' -- heading
);

