-- Test ELEMENTS 
INSERT INTO
master_test_elements (`test_id`, `response_id`, `question`, `question_number`, `question_number_display_text`, `correct_answer`, `heading`)
VALUES
(
1,
"cnl011",
"What type of lung cancer?",
1,
1,
1,
1
);

INSERT INTO
master_test_elements (`test_id`, `response_id`, `question`, `question_number`, `question_number_display_text`, `correct_answer`, `heading`)
VALUES
(
1,
"cnl353",
"Update profile?",
1,
1,
1,
1
);

INSERT INTO
master_test_elements (`test_id`, `response_id`, `question`, `question_number`, `question_number_display_text`, `correct_answer`, `heading`)
VALUES
(
1,
"cnl034",
"What type of Non-small cell lung cancer?",
1,
1,
1,
1
);

INSERT INTO
master_test_elements (`test_id`, `response_id`, `question`, `question_number`, `question_number_display_text`, `correct_answer`, `heading`)
VALUES
(
1,
"cnl041",
"What stage is your Non-small cell lung cancer?",
1,
1,
1,
1
);

INSERT INTO
master_test_elements (`test_id`, `response_id`, `question`, `question_number`, `question_number_display_text`, `correct_answer`, `heading`)
VALUES
(
1,
"cnl071",
"What stage is your small cell lung cancer?",
1,
1,
1,
1
);

INSERT INTO
master_test_elements (`test_id`, `response_id`, `question`, `question_number`, `question_number_display_text`, `correct_answer`, `heading`)
VALUES
(
1,
"cnl123",
"So you want to know what your prognosis is?",
1,
1,
1,
1
);
-- ////////

CREATE TABLE IF NOT EXISTS master_user_test_activity (
    user_id int,
    test_element_id int,
    answer varchar(255),
    response_id varchar(255),
    activity_log_id int,
    date_completed date
);


-- //Update master_properties with welcome back message
UPDATE master_properties SET general_welcome_response = 'cnl353', welcome_back_response='cnl353' WHERE name = 'cnl';
-- ///////