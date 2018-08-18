-- completed flow attempts query
SELECT
	mal_completed_flow_attempts.user_id,
	mal_completed_flow_attempts.flow_attempt
FROM master_activity_logs AS mal_completed_flow_attempts
WHERE
	mal_completed_flow_attempts.mr_project = 'tss'
	AND mal_completed_flow_attempts.response_id = 'HEndD001'
GROUP BY mal_completed_flow_attempts.user_id, mal_completed_flow_attempts.flow_attempt;

-- (1) moving through the interview query
SELECT
	mal_start_response.user_id,
	mal_start_response.flow_attempt,
	MIN(mal_start_response.date) AS start_datetime,
	MIN(mal_end_response.date) AS end_datetime,
	TIMEDIFF(MIN(mal_end_response.date), MIN(mal_start_response.date)) AS duration
FROM master_activity_logs AS mal_start_response
JOIN master_activity_logs AS mal_end_response
	ON mal_end_response.user_id = mal_start_response.user_id
	AND mal_end_response.flow_attempt = mal_start_response.flow_attempt
WHERE
	mal_start_response.mr_project = 'tss'
	AND mal_start_response.response_id = 'HIntroD001'
	AND mal_end_response.response_id = 'HEndD001'
GROUP BY mal_start_response.user_id, mal_start_response.flow_attempt;

-- gathering stars response ids and scoring
-- HS1FW001: -5
-- HS1MF001: -5
-- HS2FW001: 10
-- HS2MF001: 10
-- HS3FW001: -5
-- HS3MF001: 10
-- HS4FW001: -5
-- HS4MF001: -5
-- HS5FW001: 10
-- HS5MF001: 10
-- HS6FW001: 10
-- HS6MF001: 10

-- (2) gatherings stars query
SELECT
	master_activity_logs_stars.user_id,
	master_activity_logs_stars.flow_attempt,
	SUM(
		CASE master_activity_logs_stars.response_id
		WHEN 'HS1FW001' THEN -5
		WHEN 'HS2FW001' THEN 10
		WHEN 'HS3FW001' THEN -5
		WHEN 'HS4FW001' THEN -5
		WHEN 'HS5FW001' THEN 10
		WHEN 'HS6FW001' THEN 10
		ELSE 0
		END
	) AS follow_up_score,
	SUM(
		CASE master_activity_logs_stars.response_id
		WHEN 'HS1MF001' THEN -5
		WHEN 'HS2MF001' THEN 10
		WHEN 'HS3MF001' THEN 10
		ELSE 0
		END
	) AS motivational_fit_planning_and_organizing_score,
	SUM(
		CASE master_activity_logs_stars.response_id
		WHEN 'HS4MF001' THEN -5
		WHEN 'HS5MF001' THEN 10
		WHEN 'HS6MF001' THEN 10
		ELSE 0
		END
	) AS motivational_fit_decision_making_score
FROM (
	SELECT
		mal_outer.user_id,
		mal_outer.flow_attempt,
		mal_outer.response_id
	FROM master_activity_logs AS mal_outer
	WHERE
		mal_outer.mr_project = 'tss'
		AND mal_outer.response_id IN (
			'HIntroD001', -- added to ensure that rows for users who completed the simulation but didn't collect any of the FW|MF stars below are included in the result set with zero scores
			'HS1FW001',
			'HS2FW001',
			'HS3FW001',
			'HS4FW001',
			'HS5FW001',
			'HS6FW001',
			'HS1MF001',
			'HS2MF001',
			'HS3MF001',
			'HS4MF001',
			'HS5MF001',
			'HS6MF001'
		)
		AND EXISTS (
			SELECT
				id
			FROM master_activity_logs AS mal_inner
			WHERE
				mal_inner.mr_project = 'tss'
				AND mal_inner.user_id = mal_outer.user_id
				AND mal_inner.flow_attempt = mal_outer.flow_attempt
				AND mal_inner.response_id = 'HEndD001'
			LIMIT 1
		)
	GROUP BY user_id, flow_attempt, response_id
) AS master_activity_logs_stars
GROUP BY user_id, flow_attempt;

-- (3) candidate experience scoring
SELECT
	mal_completed_flow_attempts.user_id,
	mal_completed_flow_attempts.flow_attempt,
	100 - (
		IF(
			mal_negative_response_counts.count IS NULL,
			0,
			IF(
				mal_negative_response_counts.count < 20,
				mal_negative_response_counts.count * 5,
				100
			)
		)
	) AS candidate_experience_score
FROM master_activity_logs AS mal_completed_flow_attempts
LEFT JOIN (
	SELECT
		user_id,
		flow_attempt,
		COUNT(1) AS count
	FROM master_activity_logs
	WHERE
		mr_project = 'tss'
		AND response_id REGEXP '^PS[1-6](Null|Shame|Illegal|Brain|Impolite)$'
		AND input_question != ''
	GROUP BY user_id, flow_attempt
) AS mal_negative_response_counts
	ON mal_negative_response_counts.user_id = mal_completed_flow_attempts.user_id
	AND mal_negative_response_counts.flow_attempt = mal_completed_flow_attempts.flow_attempt
WHERE
	mal_completed_flow_attempts.mr_project = 'tss'
	AND mal_completed_flow_attempts.response_id = 'HEndD001'
GROUP BY mal_completed_flow_attempts.user_id, mal_completed_flow_attempts.flow_attempt, mal_completed_flow_attempts.response_id;

-- Model 10/5
-- Wrong -2/-5
-- Theo -2/-5
-- Leading -2/-5
-- Vague -2/-5

-- (4) Behavioral Question Skills
SELECT
	mal_outer.user_id,
	mal_outer.flow_attempt,
	SUM(
		IF(
			response_id REGEXP '^PS[2-6]BQ(Wrong|Theo|Leading|Vague)$',
			IF(
				EXISTS(
					SELECT
						id
					FROM master_activity_logs AS mal_inner
					WHERE
						mal_inner.user_id = mal_outer.user_id
						AND mal_inner.flow_attempt = mal_outer.flow_attempt
						AND mal_inner.current_response = mal_outer.current_response
						AND mal_inner. id < mal_outer.id
					LIMIT 1
				),
				-5,
				-2
			),
			IF(
				response_id REGEXP '^PS[2-6]BQModel$',
				IF(
					EXISTS(
						SELECT
							id
						FROM master_activity_logs AS mal_inner
						WHERE
							mal_inner.user_id = mal_outer.user_id
							AND mal_inner.flow_attempt = mal_outer.flow_attempt
							AND mal_inner.current_response = mal_outer.current_response
							AND mal_inner. id < mal_outer.id
						LIMIT 1
					),
					5,
					10
				),
				0
			)
		)
	) AS behavioral_question_skills_score
FROM master_activity_logs AS mal_outer
WHERE
	mal_outer.mr_project = 'tss'
	AND mal_outer.action = 'Answer'
	AND mal_outer.current_response REGEXP '^HS[2-6]D001$'
	AND mal_outer.input_question != ''

	AND EXISTS (
		SELECT
			id
		FROM master_activity_logs AS mal_inner
		WHERE
			mal_inner.mr_project = 'tss'
			AND mal_inner.user_id = mal_outer.user_id
			AND mal_inner.flow_attempt = mal_outer.flow_attempt
			AND mal_inner.response_id = 'HEndD001'
	)
GROUP BY mal_outer.user_id, mal_outer.flow_attempt;

-- (5) Follow-up Question Skills
SELECT
	mal_outer.user_id,
	mal_outer.flow_attempt,
	SUM(
		IF(
			response_id REGEXP '^PS[1-6]FW(Wrong|Theo|Leading|Vague)$',
			IF(
				EXISTS(
					SELECT
						id
					FROM master_activity_logs AS mal_inner
					WHERE
						mal_inner.user_id = mal_outer.user_id
						AND mal_inner.flow_attempt = mal_outer.flow_attempt
						AND mal_inner.current_response = mal_outer.current_response
						AND mal_inner. id < mal_outer.id
					LIMIT 1
				),
				-5,
				-2
			),
			IF(
				response_id REGEXP '^PS[1-6]FWModel$',
				IF(
					EXISTS(
						SELECT
							id
						FROM master_activity_logs AS mal_inner
						WHERE
							mal_inner.user_id = mal_outer.user_id
							AND mal_inner.flow_attempt = mal_outer.flow_attempt
							AND mal_inner.current_response = mal_outer.current_response
							AND mal_inner. id < mal_outer.id
						LIMIT 1
					),
					5,
					10
				),
				0
			)
		)
	) AS follow_up_question_skills_score
FROM master_activity_logs AS mal_outer
WHERE
	mal_outer.mr_project = 'tss'
	AND (
		mal_outer.response_id = 'HIntroD001' -- added to ensure that rows for users who completed the simulation but didn't collect any of the FW|MF stars below are included in the result set with zero scores
		OR (
			mal_outer.action = 'Answer'
			AND mal_outer.current_response REGEXP '^HS[1-6]FW001$'
			AND mal_outer.input_question != ''
		)
	)
	AND EXISTS (
		SELECT
			id
		FROM master_activity_logs AS mal_inner
		WHERE
			mal_inner.mr_project = 'tss'
			AND mal_inner.user_id = mal_outer.user_id
			AND mal_inner.flow_attempt = mal_outer.flow_attempt
			AND mal_inner.response_id = 'HEndD001'
	)
GROUP BY mal_outer.user_id, mal_outer.flow_attempt;

-- (6) Motivational Fit Question Skills
SELECT 1;

-- () user and flow attempt query
SELECT
	mal_outer.user_id,
	mal_outer.flow_attempt
FROM master_activity_logs AS mal_outer
WHERE
	mal_outer.mr_project = 'tss'
	AND EXISTS (
		SELECT
			mal_inner.id
		FROM master_activity_logs AS mal_inner
		WHERE
			mal_inner.user_id = mal_outer.user_id
			AND mal_inner.flow_attempt = mal_outer.flow_attempt
			AND mal_inner.response_id = 'HEndD001'
	)
GROUP BY mal_outer.user_id, mal_outer.flow_attempt
ORDER BY mal_outer.user_id, mal_outer.flow_attempt;