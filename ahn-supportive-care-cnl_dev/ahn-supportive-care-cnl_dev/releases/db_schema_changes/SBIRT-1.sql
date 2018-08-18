-- property and organization SQL
INSERT INTO `master_properties` (
		`name`,
		`title`,
		`domain`,
		`case_name`,
		`response_prefix`,
		`general_welcome_response`,
		`decision_flow_welcome_response`,
		`welcome_back_response`,
		`web_video_domain`,
		`rtmp_video_domain`,
		`active`
	) VALUES (
		'sbirt',
		'SBIRT',
		'sbirtmentor.com',
		'MDR_ACC',
		'acc',
		'acc001',
		'acc001',
		'acc001',
		'dgotwa0f4krct.cloudfront.net',
		's3v1lnb41xy7lb.cloudfront.net',
		'1'
	);

INSERT INTO `master_organization_property_map` (
	`organization_id`,
	`property_id`
) VALUES (
	(SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond'),
	(SELECT `id` FROM `master_properties` WHERE `name` = 'sbirt')
);

-- master_courses sql
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
	`total_tests_surveys`,
	`active`
) VALUES (
	(SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond'),
	'AlcoholSBIRT 1 Hour',
	'2',
	'asb0_1',
	'dod_1hr_pre_test',
	'dod_1hr_post_test_satisfaction',
	'dod_1hr_post_test_competence',
	'dod_1hr_practice',
	'9',
	'5',
	'1'
);

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
	`total_tests_surveys`,
	`active`
) VALUES (
	(SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond'),
	'SBIRT Mentor',
	'2',
	'pas_p1_ts1a',
	'pas_p1_pre_test',
	'pas_p1_post_test',
	'pas_p1_post_test',
	'pas_p1_post_test',
	'105',
	'14',
	'1'
);

-- master_course_elements sql
INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
	(SELECT `id` FROM `master_courses` WHERE `course_name` = 'AlcoholSBIRT 1 Hour' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
	'asb0_1',
	'Module 1: Overview',
	'1',
	'',
	'0',
	'0',
	'0',
	'0',
	'1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
	(SELECT `id` FROM `master_courses` WHERE `course_name` = 'AlcoholSBIRT 1 Hour' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
	'asb0_2',
	'Module 2: Introduction to AlcoholSBIRT',
	'2',
	'',
	'0',
	'0',
	'0',
	'0',
	'1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
	(SELECT `id` FROM `master_courses` WHERE `course_name` = 'AlcoholSBIRT 1 Hour' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
	'asb0_3',
	'Module 3: Screening using the AUDIT-C',
	'3',
	'',
	'0',
	'0',
	'0',
	'0',
	'1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
	(SELECT `id` FROM `master_courses` WHERE `course_name` = 'AlcoholSBIRT 1 Hour' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
	'asb0_4',
	'Module 4: Bring Attention to Elevated Drinking Level',
	'4',
	'',
	'0',
	'0',
	'0',
	'0',
	'1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
	(SELECT `id` FROM `master_courses` WHERE `course_name` = 'AlcoholSBIRT 1 Hour' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
	'asb0_5',
	'Module 5: Recommending Limiting Use or Abstaining',
	'5',
	'',
	'0',
	'0',
	'0',
	'0',
	'1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
	(SELECT `id` FROM `master_courses` WHERE `course_name` = 'AlcoholSBIRT 1 Hour' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
	'asb0_6',
	'Module 6: Inform About the Effects of Alcohol',
	'6',
	'',
	'0',
	'0',
	'0',
	'0',
	'1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
	(SELECT `id` FROM `master_courses` WHERE `course_name` = 'AlcoholSBIRT 1 Hour' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
	'asb0_7',
	'Module 7: Exploring Low-Risk Drinking Goals',
	'7',
	'',
	'0',
	'0',
	'0',
	'0',
	'1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
	(SELECT `id` FROM `master_courses` WHERE `course_name` = 'AlcoholSBIRT 1 Hour' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
	'asb0_8',
	'Module 8: Follow-Up',
	'8',
	'',
	'0',
	'0',
	'0',
	'0',
	'1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
	(SELECT `id` FROM `master_courses` WHERE `course_name` = 'AlcoholSBIRT 1 Hour' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
	'asb0_9',
	'Module 9: Referral to Treatment',
	'9',
	'',
	'0',
	'0',
	'0',
	'0',
	'1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
	(SELECT `id` FROM `master_courses` WHERE `course_name` = 'AlcoholSBIRT 1 Hour' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
	'dod_1hr_pre_test',
	'Pre-Test',
	'1',
	'',
	'0',
	'0',
	'0',
	'1',
	'1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
	(SELECT `id` FROM `master_courses` WHERE `course_name` = 'AlcoholSBIRT 1 Hour' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
	'dod_1hr_post_test_content',
	'Content/Knowledge Questions',
	'1',
	'',
	'0',
	'0',
	'0',
	'1',
	'1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
	(SELECT `id` FROM `master_courses` WHERE `course_name` = 'AlcoholSBIRT 1 Hour' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
	'dod_1hr_practice',
	'Practice Questions',
	'1',
	'',
	'0',
	'0',
	'0',
	'1',
	'1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
	(SELECT `id` FROM `master_courses` WHERE `course_name` = 'AlcoholSBIRT 1 Hour' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
	'dod_1hr_post_test_competence',
	'Competence Questions',
	'1',
	'',
	'0',
	'0',
	'0',
	'1',
	'1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
	(SELECT `id` FROM `master_courses` WHERE `course_name` = 'AlcoholSBIRT 1 Hour' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
	'dod_1hr_post_test_satisfaction',
	'Satisfaction Survey',
	'1',
	'',
	'0',
	'0',
	'0',
	'1',
	'1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
	(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts1a','Segment 1: Screening','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts1b','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts1c','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts1d','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_pv1','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts1e','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_pv2','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts1f','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts1g','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_pv3','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts1h','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_pv4','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts1i','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp1_intro','Skill Practice 1','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp1_s1','Skill Practice 1: Part 1','1','','1','193','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp1_s2','Skill Practice 1: Part 2','1','','1','193','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp1_s3','Skill Practice 1: Part 3','1','','1','193','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts2a','Segment 2: Raising The Subject','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_pv5','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts2b','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp2_intro','Skill Practice 2','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp2_s17nm','Skill Practice 2: Part 1','1','','1','200','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp2_s26m','Skill Practice 2: Part 2','1','','1','200','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp2_s35nm','Skill Practice 2: Part 3','1','','1','200','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp2_s44nm','Skill Practice 2: Part 4','1','','1','200','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp2_s53m','Skill Practice 2: Part 5','1','','1','200','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp2_s62m','Skill Practice 2: Part 6','1','','1','200','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp2_s73m','Skill Practice 2: Part 7','1','','1','200','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts3a','Segment 3: Providing Feedback','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_pv6','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts3b','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp3_s27','Skill Practice 3: Part 1','1','','2','0','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp3_s36','Skill Practice 3: Part 2','1','','2','211','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp3_s54','Skill Practice 3: Part 3','1','','2','211','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp3_s74','Skill Practice 3: Part 4','1','','2','211','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts4a','Segment 4: Open-ended Questions','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_pv71','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts4b','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_pv7','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts4c','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp4_intro','Skill Practice 4','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp4_s19','Skill Practice 4: Part 1','1','','2','220','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp4_s37','Skill Practice 4: Part 2','1','','2','220','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp4_s55','Skill Practice 4: Part 3','1','','2','220','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp4_s64','Skill Practice 4: Part 4','1','','2','220','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp4_s75','Skill Practice 4: Part 5','1','','2','220','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts5a','Segment 5: Importance &amp; Confidence','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_pv8','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts5b','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_pv9','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts5c','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts6a','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_pv10','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts6b','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_pv11','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts6c','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp6_intro','Skill Practice 6','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp6_s30','Skill Practice 6: Part 1','1','','2','236','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp6_s39','Skill Practice 6: Part 2','1','','2','236','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp6_s48','Skill Practice 6: Part 3','1','','2','236','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp7_intro','Skill Practice 7','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp7_s31','Skill Practice 7: Part 1','1','','2','240','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp7_s40','Skill Practice 7: Part 2','1','','2','240','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp7_s49','Skill Practice 7: Part 3','1','','2','240','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts6d','Segment 7: Readiness to Change','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_pv12','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts7a','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_pv13','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts7b','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_pv14','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts7c','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp8_intro','Skill Practice 8','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp8_s23','Skill Practice 8: Part 1','1','','2','251','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp8_s32','Skill Practice 8: Part 2','1','','2','251','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp8_s79','Skill Practice 8: Part 3','1','','2','251','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts8a','Segment 8: Negotiate &amp; Advise','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_pv15','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts8b','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp9_intro','Skill Practice 9','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp9_s33','Skill Practice 9: Part 1','1','','2','258','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp9_s42','Skill Practice 9: Part 2','1','','2','258','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp9_s51','Skill Practice 9: Part 3','1','','2','258','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts8c','Segment 9: Referral to Treatment','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts9a','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_pv72','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts9b','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_pv16','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts9c','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp10_intro','Skill Practice 10','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp10_s52','Skill Practice 10: Part 1','1','','2','268','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp10_s61','Skill Practice 10: Part 2','1','','2','268','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp10_s70','Skill Practice 10: Part 3','1','','2','268','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_sp10_s81','Skill Practice 10: Part 4','1','','2','268','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts9d','Conclusion','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ts9e','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ps1_introa','Patient Simulation 1: Introduction','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ps1_introc','','1','','0','0','0','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ps1_s1_mdir','Patient Simulation 1: Introducing the Full Screen','1','','2','275','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ps1_s2_mdir','Patient Simulation 2: Raising the Subject','1','','2','0','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ps1_s3_mdir','Patient Simulation 3: Providing Feedback','1','','2','0','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ps1_s4_mdir','Patient Simulation 4: Open-ended Questions','1','','2','0','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ps1_s5_mdir','Patient Simulation 5: Reflections','1','','2','0','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ps1_s6_mdir','Patient Simulation 6: Affirmations','1','','2','0','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ps1_s7_mdir','Patient Simulation 7: Negotiate &amp; Advise','1','','2','0','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_ps1_s8_mdir','Patient Simulation 8: Referral to Treatment','1','','2','0','1','0','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_post_test_content','Content/Knowledge Questions','1','','1','0','0','1','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_pre_test','Pre-Test','1','','0','0','0','1','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_post_test_competence','Competence Questions','1','','0','0','0','1','1'
);

INSERT INTO `master_course_elements` (
	`course_id`,
	`response_id`,
	`tltle`,
	`sequence_number`,
	`base_question`,
	`number_of_atttempts_allowed`,
	`parent`,
	`is_skill_practice`,
	`is_test`,
	`active`
) VALUES (
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),'pas_p1_post_test_satisfaction','Satisfaction Survey','1','','0','0','0','1','1'
);

-- master_tests sql

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`max_iterations`,
	`total_points`,
	`passing_score`,
	`required`,
	`active`
) VALUES (
'dod_1hr_pre_test',
'Pre-Test',
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'AlcoholSBIRT 1 Hour' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
'Please indicate how professionally competent you feel in performing these alcohol-related aspects of patient care.',
'1',
'0',
'0',
'0',
'1'
);

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`max_iterations`,
	`total_points`,
	`passing_score`,
	`required`,
	`active`
) VALUES (
'dod_1hr_post_test_content',
'Content/Knowledge Questions',
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'AlcoholSBIRT 1 Hour' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
'',
'3',
'6',
'5',
'1',
'1'
);

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`max_iterations`,
	`total_points`,
	`passing_score`,
	`required`,
	`active`
) VALUES (
'dod_1hr_practice',
'Questions about Your Practice',
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'AlcoholSBIRT 1 Hour' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
'Please indicate the frequency with which you perform each alcohol-related aspect of care. How often do you:',
'1',
'0',
'0',
'0',
'1'
);

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`max_iterations`,
	`total_points`,
	`passing_score`,
	`required`,
	`active`
) VALUES (
'dod_1hr_post_test_competence',
'Competence Questions',
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'AlcoholSBIRT 1 Hour' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
'Please indicate how professionally competent you feel in performing these alcohol-related aspects of patient care.',
'1',
'0',
'0',
'0',
'1'
);

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`max_iterations`,
	`total_points`,
	`passing_score`,
	`required`,
	`active`
) VALUES (
'dod_1hr_post_test_satisfaction',
'Satisfaction Survey',
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'AlcoholSBIRT 1 Hour' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
'',
'1',
'0',
'0',
'1',
'1'
);

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`max_iterations`,
	`total_points`,
	`passing_score`,
	`required`,
	`active`
) VALUES (
'pas_p1_sp1_s1',
'Skill Practice 1: Part 1',
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
'',
'1',
'1',
'1',
'0',
'1'
);

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`max_iterations`,
	`total_points`,
	`passing_score`,
	`required`,
	`active`
) VALUES (
'pas_p1_sp1_s2',
'Skill Practice 1: Part 2',
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
'',
'1',
'1',
'1',
'0',
'1'
);

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`max_iterations`,
	`total_points`,
	`passing_score`,
	`required`,
	`active`
) VALUES (
'pas_p1_sp1_s3',
'Skill Practice 1: Part 3',
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
'',
'1',
'1',
'1',
'0',
'1'
);

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`max_iterations`,
	`total_points`,
	`passing_score`,
	`required`,
	`active`
) VALUES (
'pas_p1_sp2_s17nm',
'Skill Practice 2: Part 1',
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
'Did the healthcare professional use Motivational Interviewing principles?',
'1',
'1',
'1',
'0',
'1'
);

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`max_iterations`,
	`total_points`,
	`passing_score`,
	`required`,
	`active`
) VALUES (
'pas_p1_sp2_s26m',
'Skill Practice 2: Part 2',
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
'Did the healthcare professional use Motivational Interviewing principles?',
'1',
'1',
'1',
'0',
'1'
);

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`max_iterations`,
	`total_points`,
	`passing_score`,
	`required`,
	`active`
) VALUES (
'pas_p1_sp2_s35nm',
'Skill Practice 2: Part 3',
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
'Did the healthcare professional use Motivational Interviewing principles?',
'1',
'1',
'1',
'0',
'1'
);

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`max_iterations`,
	`total_points`,
	`passing_score`,
	`required`,
	`active`
) VALUES (
'pas_p1_sp2_s44nm',
'Skill Practice 2: Part 4',
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
'Did the healthcare professional use Motivational Interviewing principles?',
'1',
'1',
'1',
'0',
'1'
);

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`max_iterations`,
	`total_points`,
	`passing_score`,
	`required`,
	`active`
) VALUES (
'pas_p1_sp2_s53m',
'Skill Practice 2: Part 5',
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
'Did the healthcare professional use Motivational Interviewing principles?',
'1',
'1',
'1',
'0',
'1'
);

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`max_iterations`,
	`total_points`,
	`passing_score`,
	`required`,
	`active`
) VALUES (
'pas_p1_sp2_s62m',
'Skill Practice 2: Part 6',
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
'Did the healthcare professional use Motivational Interviewing principles?',
'1',
'1',
'1',
'0',
'1'
);

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`max_iterations`,
	`total_points`,
	`passing_score`,
	`required`,
	`active`
) VALUES (
'pas_p1_sp2_s73m',
'Skill Practice 2: Part 7',
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
'Did the healthcare professional use Motivational Interviewing principles?',
'1',
'1',
'1',
'0',
'1'
);

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`max_iterations`,
	`total_points`,
	`passing_score`,
	`required`,
	`active`
) VALUES (
'pas_p1_post_test_content',
'Content/Knowledge Questions',
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
'Successful completion of this activity will be based on the learner passing the post-test at 70% or better. Your instructor\'s passing criteria for the class may be different. ',
'3',
'15',
'11',
'1',
'1'
);

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`max_iterations`,
	`total_points`,
	`passing_score`,
	`required`,
	`active`
) VALUES (
'pas_p1_pre_test',
'Pre-Test',
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
'Please indicate how professionally competent you feel in performing these alcohol-related aspects of patient care.',
'1',
'0',
'0',
'0',
'1'
);

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`max_iterations`,
	`total_points`,
	`passing_score`,
	`required`,
	`active`
) VALUES (
'pas_p1_post_test_competence',
'Competence Questions',
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
'Please indicate how professionally competent you feel in performing these alcohol-related aspects of patient care.',
'1',
'0',
'0',
'0',
'1'
);

INSERT INTO `master_tests` (
	`key`,
	`test_name`,
	`course_id`,
	`base_question`,
	`max_iterations`,
	`total_points`,
	`passing_score`,
	`required`,
	`active`
) VALUES (
'pas_p1_post_test_satisfaction',
'Satisfaction Survey',
(SELECT `id` FROM `master_courses` WHERE `course_name` = 'SBIRT Mentor' AND `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond')),
'',
'1',
'0',
'0',
'1',
'1'
);

-- master_test_elements sql
INSERT INTO `master_test_elements` (
`test_id`,
`response_id`,
`question_number`,
`question_number_display_text`,
`question`,
`correct_answer`,
`number_of_attempts_allowed`,
`active`,
`scheme`,
`heading`
)
SELECT
  mt_sbirt.id AS test_id,
  mte.response_id,
  mte.question_number,
  mte.question_number_display_text,
  mte.question,
  mte.correct_answer,
  mte.number_of_attempts_allowed,
  mte.active,
  mte.scheme,
  mte.heading
FROM master_test_elements AS mte
JOIN master_tests AS mt_rush
  ON mt_rush.id = mte.test_id
JOIN master_courses AS mc
  ON mc.id = mt_rush.course_id
JOIN master_tests AS mt_sbirt
  ON mt_sbirt.`key` = mt_rush.`key`
  AND mt_sbirt.id != mt_rush.id
WHERE
  mc.course_name = 'SBIRT Mentor';


INSERT INTO `master_test_elements` (
`test_id`,
`response_id`,
`question_number`,
`question_number_display_text`,
`question`,
`correct_answer`,
`number_of_attempts_allowed`,
`active`,
`scheme`,
`heading`
)
SELECT
  (SELECT master_tests.id FROM master_tests JOIN master_courses ON master_courses.id = master_tests.course_id WHERE master_tests.`key` = mt_rush.`key` and master_tests.id != mt_rush.id AND master_courses.organization_id = (SELECT id from master_organizations WHERE name = 'MedRespond')) AS test_id,
  mte.response_id,
  mte.question_number,
  mte.question_number_display_text,
  mte.question,
  mte.correct_answer,
  mte.number_of_attempts_allowed,
  mte.active,
  mte.scheme,
  mte.heading
FROM master_test_elements AS mte
JOIN master_tests AS mt_rush
  ON mt_rush.id = mte.test_id
JOIN master_courses AS mc
  ON mc.id = mt_rush.course_id
WHERE
  mc.course_name = 'AlcoholSBIRT 1 Hour'
  AND mc.organization_id = (SELECT id from master_organizations WHERE name = 'Rush University');

-- master_test_elements_schemes sql


-- master_roles sql
INSERT INTO `medrespond_anthony_dev`.`master_roles` (
	`organization_id`,
	`role_name`
) VALUES (
	(SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond'),
	'AlcoholSBIRT 1 Hour'
);

INSERT INTO `medrespond_anthony_dev`.`master_roles` (
	`organization_id`,
	`role_name`
) VALUES (
	(SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond'),
	'SBIRT Mentor'
);

-- master_role_course_map sql
INSERT INTO `master_role_course_map` (
	`organization_id`,
	`role_id`,
	`course_id`
) VALUES (
	(SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond'),
	(SELECT `id` FROM `master_roles` WHERE `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond') AND `role_name` = 'AlcoholSBIRT 1 Hour'),
	(SELECT `id` FROM `master_courses` WHERE `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond') AND `course_name` = 'AlcoholSBIRT 1 Hour')
);

INSERT INTO `master_role_course_map` (
	`organization_id`,
	`role_id`,
	`course_id`
) VALUES (
	(SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond'),
	(SELECT `id` FROM `master_roles` WHERE `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond') AND `role_name` = 'SBIRT Mentor'),
	(SELECT `id` FROM `master_courses` WHERE `organization_id` = (SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond') AND `course_name` = 'SBIRT Mentor')
);

-- master_accreditation_types
INSERT INTO `master_accreditation_types` (
	`organization_id`,
	`accreditation_type`,
	`order`
) VALUES (
	(SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond'),
	'CE',
	'0'
);

INSERT INTO `master_accreditation_types` (
	`organization_id`,
	`accreditation_type`,
	`order`
) VALUES (
	(SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond'),
	'CME',
	'0'
);

INSERT INTO `master_accreditation_types` (
	`organization_id`,
	`accreditation_type`,
	`order`
) VALUES (
	(SELECT `id` FROM `master_organizations` WHERE `name` = 'MedRespond'),
	'Not Seeking Accreditation',
	'9999'
);



