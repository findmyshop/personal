ALTER TABLE `master_feedback_logs` ADD COLUMN `session_id` VARCHAR(45) NOT NULL AFTER `id`, ADD COLUMN `ip_address` VARCHAR(45) NOT NULL AFTER `session_id`;


INSERT INTO `master_courses` (
	`organization_id`,
	`course_name`,
	`max_iterations`,
	`url`,
	`after_disclaimer`,
	`before_certification`,
	`after_certification`,
	`last_rid`,
	`total_sections`,
	`total_tests_surveys`
) VALUES (
	(SELECT id FROM master_organizations WHERE name = 'ONS'),
	'ONS Demographics and Feedback',
	1,
	NULL,
	NULL,
	NULL,
	NULL,
	NULL,
	0,
	0
);

-- create master_tests, master_test_elements, and master_test_element_schemes entries for ONS

-- oct142

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`total_points`
) VALUES (
	'oct142',
	'Demographics - Diagnosis - Cancer Type',
	(SELECT id FROM master_courses WHERE course_name = 'ONS Demographics and Feedback' LIMIT 1),
	'',
	0
);

INSERT INTO `master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests WHERE test_name = 'Demographics - Diagnosis - Cancer Type' LIMIT 1),
	'oct142',
	0,
	'',
	'Thank you.   My first question is about your diagnosis.  Can you tell me what type of cancer you have?',
	'',
	'',
	''
);

-- oct143

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`total_points`
) VALUES (
	'oct143',
	'Demographics - Diagnosis - Date',
	(SELECT id FROM master_courses WHERE course_name = 'ONS Demographics and Feedback' LIMIT 1),
	'',
	0
);

INSERT INTO `master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests WHERE test_name = 'Demographics - Diagnosis - Date' LIMIT 1),
	'oct143',
	0,
	'',
	'When were you diagnosed?',
	'',
	'',
	''
);

-- oct144

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`total_points`
) VALUES (
	'oct144',
	'Demographics - Current Age',
	(SELECT id FROM master_courses WHERE course_name = 'ONS Demographics and Feedback' LIMIT 1),
	'',
	0
);

INSERT INTO `master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests WHERE test_name = 'Demographics - Current Age'),
	'oct144',
	0,
	'',
	'Can you tell me your current age?',
	'',
	'',
	''
);

-- oct155

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`total_points`
) VALUES (
	'oct155',
	'Feedback - Effectiveness of Program',
	(SELECT id FROM master_courses WHERE course_name = 'ONS Demographics and Feedback' LIMIT 1),
	'',
	0
);

INSERT INTO `master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests WHERE test_name = 'Feedback - Effectiveness of Program'),
	'oct155',
	0,
	'',
	'Do you feel better equipped to manage your oral cancer drug treatment plan after using this program?',
	'',
	'43',
	''
);

INSERT INTO `master_test_elements_schemes` (
	`scheme_id`,
	`answer`,
	`text`
) VALUES (
	43,
	'1',
	'Yes'
);

INSERT INTO `master_test_elements_schemes` (
	`scheme_id`,
	`answer`,
	`text`
) VALUES (
	43,
	'2',
	'No'
);

-- oct156

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`total_points`
) VALUES (
	'oct156',
	'Feedback - Other Helpful Information',
	(SELECT id FROM master_courses WHERE course_name = 'ONS Demographics and Feedback' LIMIT 1),
	'',
	0
);

INSERT INTO `master_test_elements` (
	`test_id`,
	`response_id`,
	`question_number`,
	`question_number_display_text`,
	`question`,
	`correct_answer`,
	`scheme`,
	`heading`
) VALUES (
	(SELECT id FROM master_tests WHERE test_name = 'Feedback - Other Helpful Information'),
	'oct156',
	0,
	'',
	'What other information about oral cancer drugs would you find helpful?',
	'',
	'',
	''
);



