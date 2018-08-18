-- SET @accreditation_type = 'Social Work';
SET @accreditation_type = 'CE';
-- SET @accreditation_type = 'CME';
-- SET @accreditation_type = 'APA';

SELECT
	muc.user_id AS `User ID`,
	mu.first_name AS `First Name`,
	mu.middle_initial AS `Middle Initial`,
	mu.last_name AS `Last Name`,
	mr.role_name AS `Role`,
	ma.address_1 AS `Address 1`,
	ma.address_2 AS `Address 2`,
	ma.city AS `City`,
	ma.province AS `Province`,
	ms.abbreviation AS `State`,
	ma.zip AS `Zip`,
	mco.name AS `Country`,
	mu.email AS Email,
	mc.course_name AS `Course Name`,
	IF(muc.course_id = 1, '1', '3') AS `Credit Hours`,
	mut.date_completed AS `Test Date`,
	IF(mucert.certificate_page_accepted OR mucert.certificate_accepted_by_user, 'Yes', 'No') AS `Certificate Printed`,
	mt.passing_score AS `Number of Correct Answers Needed to Pass`,
	SUM(IF(mtes_given.text = mtes_correct.text, 1 , 0)) AS `Number of Correct Answers`,
	mt.total_points AS `Total Number of Questions`,
	ROUND(SUM(IF(mtes_given.text = mtes_correct.text, 1 , 0))/mt.total_points * 100, 2) AS `Percent Correct`,
	MAX(IF(mte.question_number_display_text = '1', mte.question, NULL)) AS `Question 1`,
	MAX(IF(mte.question_number_display_text = '1', mtes_correct.text, NULL)) AS `Question 1 Correct Answer`,
	MAX(IF(mte.question_number_display_text = '1', mtes_given.text, NULL)) AS `Question 1 Answer Given`,
	MAX(IF(mte.question_number_display_text = '2', mte.question, NULL)) AS `Question 2`,
	MAX(IF(mte.question_number_display_text = '2', mtes_correct.text, NULL)) AS `Question 2 Correct Answer`,
	MAX(IF(mte.question_number_display_text = '2', mtes_given.text, NULL)) AS `Question 2 Answer Given`,
	MAX(IF(mte.question_number_display_text = '3', mte.question, NULL)) AS `Question 3`,
	MAX(IF(mte.question_number_display_text = '3', mtes_correct.text, NULL)) AS `Question 3 Correct Answer`,
	MAX(IF(mte.question_number_display_text = '3', mtes_given.text, NULL)) AS `Question 3 Answer Given`,
	MAX(IF(mte.question_number_display_text = '4', mte.question, NULL)) AS `Question 4`,
	MAX(IF(mte.question_number_display_text = '4', mtes_correct.text, NULL)) AS `Question 4 Correct Answer`,
	MAX(IF(mte.question_number_display_text = '4', mtes_given.text, NULL)) AS `Question 4 Answer Given`,
	MAX(IF(mte.question_number_display_text = '5', mte.question, NULL)) AS `Question 5`,
	MAX(IF(mte.question_number_display_text = '5', mtes_correct.text, NULL)) AS `Question 5 Correct Answer`,
	MAX(IF(mte.question_number_display_text = '5', mtes_given.text, NULL)) AS `Question 5 Answer Given`,
	MAX(IF(mte.question_number_display_text = '6', mte.question, NULL)) AS `Question 6`,
	MAX(IF(mte.question_number_display_text = '6', mtes_correct.text, NULL)) AS `Question 6 Correct Answer`,
	MAX(IF(mte.question_number_display_text = '6', mtes_given.text, NULL)) AS `Question 6 Answer Given`,
	MAX(IF(mte.question_number_display_text = '7', mte.question, NULL)) AS `Question 7`,
	MAX(IF(mte.question_number_display_text = '7', mtes_correct.text, NULL)) AS `Question 7 Correct Answer`,
	MAX(IF(mte.question_number_display_text = '7', mtes_given.text, NULL)) AS `Question 7 Answer Given`,
	MAX(IF(mte.question_number_display_text = '8', mte.question, NULL)) AS `Question 8`,
	MAX(IF(mte.question_number_display_text = '8', mtes_correct.text, NULL)) AS `Question 8 Correct Answer`,
	MAX(IF(mte.question_number_display_text = '8', mtes_given.text, NULL)) AS `Question 8 Answer Given`,
	MAX(IF(mte.question_number_display_text = '9', mte.question, NULL)) AS `Question 9`,
	MAX(IF(mte.question_number_display_text = '9', mtes_correct.text, NULL)) AS `Question 9 Correct Answer`,
	MAX(IF(mte.question_number_display_text = '9', mtes_given.text, NULL)) AS `Question 9 Answer Given`,
	MAX(IF(mte.question_number_display_text = '10', mte.question, NULL)) AS `Question 10`,
	MAX(IF(mte.question_number_display_text = '10', mtes_correct.text, NULL)) AS `Question 10 Correct Answer`,
	MAX(IF(mte.question_number_display_text = '10', mtes_given.text, NULL)) AS `Question 10 Answer Given`,
	MAX(IF(mte.question_number_display_text = '11', mte.question, NULL)) AS `Question 11`,
	MAX(IF(mte.question_number_display_text = '11', mtes_correct.text, NULL)) AS `Question 11 Correct Answer`,
	MAX(IF(mte.question_number_display_text = '11', mtes_given.text, NULL)) AS `Question 11 Answer Given`,
	MAX(IF(mte.question_number_display_text = '12', mte.question, NULL)) AS `Question 12`,
	MAX(IF(mte.question_number_display_text = '12', mtes_correct.text, NULL)) AS `Question 12 Correct Answer`,
	MAX(IF(mte.question_number_display_text = '12', mtes_given.text, NULL)) AS `Question 12 Answer Given`,
	MAX(IF(mte.question_number_display_text = '13', mte.question, NULL)) AS `Question 13`,
	MAX(IF(mte.question_number_display_text = '13', mtes_correct.text, NULL)) AS `Question 13 Correct Answer`,
	MAX(IF(mte.question_number_display_text = '13', mtes_given.text, NULL)) AS `Question 13 Answer Given`,
	MAX(IF(mte.question_number_display_text = '14', mte.question, NULL)) AS `Question 14`,
	MAX(IF(mte.question_number_display_text = '14', mtes_correct.text, NULL)) AS `Question 14 Correct Answer`,
	MAX(IF(mte.question_number_display_text = '14', mtes_given.text, NULL)) AS `Question 14 Answer Given`,
	MAX(IF(mte.question_number_display_text = '15', mte.question, NULL)) AS `Question 15`,
	MAX(IF(mte.question_number_display_text = '15', mtes_correct.text, NULL)) AS `Question 15 Correct Answer`,
	MAX(IF(mte.question_number_display_text = '15', mtes_given.text, NULL)) AS `Question 15 Answer Given`,
	MAX(IF(mte.question_number_display_text = '16', mte.question, NULL)) AS `Question 16`,
	MAX(IF(mte.question_number_display_text = '16', mtes_correct.text, NULL)) AS `Question 16 Correct Answer`,
	MAX(IF(mte.question_number_display_text = '16', mtes_given.text, NULL)) AS `Question 16 Answer Given`,
	MAX(IF(mte.question_number_display_text = '17', mte.question, NULL)) AS `Question 17`,
	MAX(IF(mte.question_number_display_text = '17', mtes_correct.text, NULL)) AS `Question 17 Correct Answer`,
	MAX(IF(mte.question_number_display_text = '17', mtes_given.text, NULL)) AS `Question 17 Answer Given`,
	MAX(IF(mte.question_number_display_text = '18', mte.question, NULL)) AS `Question 18`,
	MAX(IF(mte.question_number_display_text = '18', mtes_correct.text, NULL)) AS `Question 18 Correct Answer`,
	MAX(IF(mte.question_number_display_text = '18', mtes_given.text, NULL)) AS `Question 18 Answer Given`,
	MAX(IF(mte.question_number_display_text = '19', mte.question, NULL)) AS `Question 19`,
	MAX(IF(mte.question_number_display_text = '19', mtes_correct.text, NULL)) AS `Question 19 Correct Answer`,
	MAX(IF(mte.question_number_display_text = '19', mtes_given.text, NULL)) AS `Question 19 Answer Given`,
	MAX(IF(mte.question_number_display_text = '20', mte.question, NULL)) AS `Question 20`,
	MAX(IF(mte.question_number_display_text = '20', mtes_correct.text, NULL)) AS `Question 20 Correct Answer`,
	MAX(IF(mte.question_number_display_text = '20', mtes_given.text, NULL)) AS `Question 20 Answer Given`,
	MAX(IF(mte.question_number_display_text = '21', mte.question, NULL)) AS `Question 21`,
	MAX(IF(mte.question_number_display_text = '21', mtes_correct.text, NULL)) AS `Question 21 Correct Answer`,
	MAX(IF(mte.question_number_display_text = '21', mtes_given.text, NULL)) AS `Question 21 Answer Given`
FROM master_user_courses AS muc
JOIN master_courses AS mc
	ON mc.id = muc.course_id
JOIN master_users AS mu
	ON mu.id = muc.user_id
JOIN master_user_address_map AS muaddm
	ON muaddm.user_id = mu.id
JOIN master_addresses AS ma
	ON ma.id = muaddm.user_id
JOIN master_states AS ms
	ON ms.id = ma.state_id
JOIN master_countries AS mco
	ON mco.country_id = ma.country_id
JOIN master_user_accreditation_map AS muam
	ON muam.user_id = mu.id
JOIN master_accreditation_types AS mat
	ON mat.id = muam.accreditation_type_id
	AND mat.accreditation_type = @accreditation_type
JOIN master_user_role_map AS murm
	ON murm.user_id = mu.id
JOIN master_roles AS mr
	ON mr.id = murm.role_id
JOIN master_user_certificates AS mucert
	ON mucert.user_id = mu.id
	AND mucert.course_id = muc.course_id
JOIN master_tests AS mt
	ON mt.course_id = muc.course_id
	AND mt.required = 1
	AND mt.passing_score > 0
JOIN master_user_tests AS mut
	ON mut.user_id = mu.id
	AND mut.course_iteration = muc.current_iteration
	AND mut.test_id = mt.id
	AND mut.has_completed = 1
	AND mut.has_passed = 1
JOIN master_test_elements AS mte
	ON mte.test_id = mt.id
JOIN master_test_elements_schemes AS mtes_correct
	ON mtes_correct.scheme_id = mte.scheme
	AND mtes_correct.answer = mte.correct_answer
JOIN master_user_test_activity AS muta
	ON muta.user_id = mut.user_id
	AND muta.course_iteration = mut.course_iteration
	AND muta.test_element_id = mte.id
	AND muta.iteration = mut.current_iteration
JOIN master_test_elements_schemes AS mtes_given
	ON mtes_given.scheme_id = mte.scheme
	AND mtes_given.answer = muta.answer
WHERE
	muc.percent_complete = 100.00
	AND muc.has_passed = 1
GROUP BY muc.user_id, muc.course_id
ORDER BY muc.course_id ASC, mut.date_completed ASC;
