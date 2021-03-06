DROP TABLE IF EXISTS tss_user_input_response_ids;
CREATE TEMPORARY TABLE tss_user_input_response_ids (
    scenario TINYINT(1) UNSIGNED NOT NULL,
	response_id VARCHAR(32) NOT NULL
);

INSERT INTO tss_user_input_response_ids (response_id, scenario) VALUES
    ('PS2BQModel', 2),
    ('PS3BQModel', 3),
    ('PS4BQModel', 4),
    ('PS5BQModel', 5),
    ('PS6BQModel', 6),
    ('HS2BQModel', 2),
    ('HS3BQModel', 3),
    ('HS4BQModel', 4),
    ('HS5BQModel', 5),
    ('HS6BQModel', 6),
    ('PS2BQTheo', 2),
    ('PS2BQLeading', 2),
    ('PS3BQTheo', 3),
    ('PS3BQLeading', 3),
    ('PS4BQTheo', 4),
    ('PS4BQLeading', 4),
    ('PS5BQTheo', 5),
    ('PS5BQLeading', 5),
    ('PS6BQTheo', 6),
    ('PS6BQLeading', 6),
    ('HS2BQTheo1', 2),
    ('HS2BQTheo2', 2),
    ('HS2BQLeading1', 2),
    ('HS2BQLeading2', 2),
    ('HS3BQTheo1', 3),
    ('HS3BQTheo2', 3),
    ('HS3BQLeading1', 3),
    ('HS3BQLeading2', 3),
    ('HS4BQTheo1', 4),
    ('HS4BQTheo2', 4),
    ('HS4BQLeading1', 4),
    ('HS4BQLeading2', 4),
    ('HS5BQTheo1', 5),
    ('HS5BQTheo2', 5),
    ('HS5BQLeading1', 5),
    ('HS5BQLeading2', 5),
    ('HS6BQTheo1', 6),
    ('HS6BQTheo2', 6),
    ('HS6BQLeading1', 6),
    ('HS6BQLeading2', 6),
    ('PS1FWModel', 1),
    ('PS2FWModel', 2),
    ('PS3FWModel', 3),
    ('PS4FWModel', 4),
    ('PS5FWModel', 5),
    ('PS6FWModel', 6),
    ('HS1FWModel', 1),
    ('HS2FWModel', 2),
    ('HS3FWModel', 3),
    ('HS4FWModel', 4),
    ('HS5FWModel', 5),
    ('HS6FWModel', 6),
    ('PS1FWWrong', 1),
    ('PS1FWTheo', 1),
    ('PS1FWLeading', 1),
    ('PS4FWWrong', 4),
    ('PS4FWTheo', 4),
    ('PS4FWLeading', 4),
    ('HS1FWWrong', 1),
    ('HS1FWTheo', 1),
    ('HS1FWLeading', 1),
    ('HS4FWWrong', 4),
    ('HS4FWTheo', 4),
    ('HS4FWLeading', 4),
    ('PS3FWTheo', 3),
    ('PS3FWLeading', 3),
    ('HS3FWTheo1', 3),
    ('HS3FWTheo2', 3),
    ('HS3FWLeading1', 3),
    ('HS3FWLeading2', 3),
    ('PS2FWWrong', 2),
    ('PS2FWTheo', 2),
    ('PS2FWLeading', 2),
    ('PS5FWWrong', 5),
    ('PS5FWTheo', 5),
    ('PS5FWLeading', 5),
    ('PS6FWWrong', 6),
    ('PS6FWTheo', 6),
    ('PS6FWLeading', 6),
    ('HS2FWWrong1', 2),
    ('HS2FWWrong2', 2),
    ('HS2FWTheo1', 2),
    ('HS2FWTheo2', 2),
    ('HS2FWLeading1', 2),
    ('HS2FWLeading2', 2),
    ('HS5FWWrong1', 5),
    ('HS5FWWrong2', 5),
    ('HS5FWTheo1', 5),
    ('HS5FWTheo2', 5),
    ('HS5FWLeading1', 5),
    ('HS5FWLeading2', 5),
    ('HS6FWWrong1', 6),
    ('HS6FWWrong2', 6),
    ('HS6FWTheo1', 6),
    ('HS6FWTheo2', 6),
    ('HS6FWLeading1', 6),
    ('HS6FWLeading2', 6),
    ('PS1MFModel', 1),
    ('PS2MFModel', 2),
    ('PS3MFModel', 3),
    ('PS4MFModel', 4),
    ('PS5MFModel', 5),
    ('PS6MFModel', 6),
    ('HS1MFModel', 1),
    ('HS2MFModel', 2),
    ('HS3MFModel', 3),
    ('HS4MFModel', 4),
    ('HS5MFModel', 5),
    ('HS6MFModel', 6),
    ('PS1MFVague', 1),
    ('PS1MFLeading', 1),
    ('PS4MFVague', 4),
    ('PS4MFLeading', 4),
    ('HS1MFVague', 1),
    ('HS1MFLeading', 1),
    ('HS4MFVague', 4),
    ('HS4MFLeading', 4),
    ('PS2MFVague', 2),
    ('PS2MFLeading', 2),
    ('PS3MFVague', 3),
    ('PS3MFLeading', 3),
    ('PS5MFVague', 5),
    ('PS5MFLeading', 5),
    ('PS6MFVague', 6),
    ('PS6MFLeading', 6),
    ('HS2MFVague1', 2),
    ('HS2MFVague2', 2),
    ('HS2MFLeading1', 2),
    ('HS2MFLeading2', 2),
    ('HS3MFVague1', 3),
    ('HS3MFVague2', 3),
    ('HS3MFLeading1', 3),
    ('HS3MFLeading2', 3),
    ('HS5MFVague1', 5),
    ('HS5MFVague2', 5),
    ('HS5MFLeading1', 5),
    ('HS5MFLeading2', 5),
    ('HS6MFVague1', 6),
    ('HS6MFVague2', 6),
    ('HS6MFLeading1', 6),
    ('HS6MFLeading2', 6),
    ('PS1Shame', 1),
    ('PS1Illegal', 1),
    ('PS1Impolite', 1),
    ('PS1Brain', 1),
    ('PS1Null', 1),
    ('HS1Shame', 1),
    ('HS1Illegal', 1),
    ('HS1Impolite', 1),
    ('HS1Brain', 1),
    ('HS1Null', 1),
    ('PS2Shame', 2),
    ('PS2Illegal', 2),
    ('PS2Impolite', 2),
    ('PS2Brain', 2),
    ('PS2Null', 2),
    ('HS2Shame', 2),
    ('HS2Illegal', 2),
    ('HS2Impolite', 2),
    ('HS2Brain', 2),
    ('HS2Null', 2),
    ('PS3Shame', 3),
    ('PS3Illegal', 3),
    ('PS3Impolite', 3),
    ('PS3Brain', 3),
    ('PS3Null', 3),
    ('HS3Shame', 3),
    ('HS3Illegal', 3),
    ('HS3Impolite', 3),
    ('HS3Brain', 3),
    ('HS3Null', 3),
    ('PS4Shame', 4),
    ('PS4Illegal', 4),
    ('PS4Impolite', 4),
    ('PS4Brain', 4),
    ('PS4Null', 4),
    ('HS4Shame', 4),
    ('HS4Illegal', 4),
    ('HS4Impolite', 4),
    ('HS4Brain', 4),
    ('HS4Null', 4),
    ('PS5Shame', 5),
    ('PS5Illegal', 5),
    ('PS5Impolite', 5),
    ('PS5Brain', 5),
    ('PS5Null', 5),
    ('HS5Shame', 5),
    ('HS5Illegal', 5),
    ('HS5Impolite', 5),
    ('HS5Brain', 5),
    ('HS5Null', 5),
    ('PS6Shame', 6),
    ('PS6Illegal', 6),
    ('PS6Impolite', 6),
    ('PS6Brain', 6),
    ('PS6Null', 6),
    ('HS6Shame', 6),
    ('HS6Illegal', 6),
    ('HS6Impolite', 6),
    ('HS6Brain', 6),
    ('HS6Null', 6);

SELECT
	tss_user_input_response_ids.*
FROM tss_user_input_response_ids
LEFT JOIN master_activity_logs AS mal
	ON mal.response_id = tss_user_input_response_ids.response_id
WHERE
	mal.response_id IS NULL
ORDER BY scenario ASC, response_id ASC;