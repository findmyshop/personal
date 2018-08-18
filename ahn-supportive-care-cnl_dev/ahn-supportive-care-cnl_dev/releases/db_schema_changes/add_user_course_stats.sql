SET SQL_SAFE_UPDATES = 0;

ALTER TABLE `master_courses`
ADD COLUMN `total_required_sections` INT UNSIGNED NOT NULL AFTER `last_rid`,
ADD COLUMN `total_required_tests` INT UNSIGNED NOT NULL AFTER `total_required_sections`;

-- calculate and set master_courses.total_required_sections value
UPDATE master_courses
SET master_courses.total_required_sections = (
	SELECT count(DISTINCT master_course_elements.id)
	FROM master_course_elements
	WHERE
		master_course_elements.course_id = master_courses.id
		AND master_course_elements.response_id != ''
		AND master_course_elements.response_id IS NOT NULL
		AND master_course_elements.is_test = 0
		AND master_course_elements.active = 1
);

-- calculate and set master_courses.total_required_tests value
UPDATE master_courses
SET master_courses.total_required_tests = (
	SELECT count(master_tests.id)
	FROM master_tests
	WHERE
		master_tests.course_id = master_courses.id
		-- AND master_tests.required != 0
		AND master_tests.active = 1
);

ALTER TABLE `master_user_courses`
ADD COLUMN `total_required_sections_visited` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `date_completed`,
ADD COLUMN `total_required_tests_completed` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `total_required_sections_visited`,
ADD COLUMN `percent_complete` DECIMAL(5,2) UNSIGNED NOT NULL DEFAULT 0 AFTER `total_required_tests_completed`;

-- calculate and set master_user_courses.total_required_sections_visited value
update master_user_courses
set master_user_courses.total_required_sections_visited = (
	SELECT count(DISTINCT master_user_course_activity.id)
	FROM master_course_elements
	JOIN	master_user_course_activity
			ON master_user_course_activity.response_id = master_course_elements.response_id
	WHERE
			master_course_elements.response_id != ''
			AND master_course_elements.response_id IS NOT NULL
			AND master_course_elements.is_test = 0
			AND master_course_elements.active = 1
			AND master_user_course_activity.user_id = master_user_courses.user_id
			AND master_user_course_activity.course_id = master_user_courses.course_id
			AND master_user_course_activity.iteration = master_user_courses.current_iteration
			AND master_user_course_activity.`status` != 'locked'
			AND master_user_course_activity.active = 1
);

-- calculate and set master_user_courses.total_required_tests_completed value
update master_user_courses as t
join (
	select
	user_id,
	course_id,
	course_iteration,
	count(distinct test_key) as tests_completed
	from (
	(
		select
			master_user_course_activity.user_id,
			master_user_course_activity.course_id,
			master_user_course_activity.iteration as course_iteration,
			master_tests.id as test_id,
			master_user_course_activity.response_id as test_key
		from master_tests
		join master_user_course_activity
			on master_user_course_activity.response_id = master_tests.key
		where master_tests.active = 1
			and master_user_course_activity.active = 1
			-- and master_tests.required != 0
	) union (
		select
			master_user_tests.user_id,
			master_tests.course_id,
			master_user_tests.course_iteration,
			master_user_tests.test_id,
			master_tests.key as test_key
		from master_tests
		join master_user_tests
			on master_user_tests.test_id = master_tests.id
		where
			master_tests.active = 0
			and master_user_tests.active = 1
			-- and master_tests.required != 0
	)) as test_activity
	group by test_activity.user_id, test_activity.course_id, test_activity.course_iteration
) as r
on
	r.user_id = t.user_id
	and r.course_id = t.course_id
	and r.course_iteration = t.current_iteration
set t.total_required_tests_completed = r.tests_completed;

-- calculate and set master_user_courses.percent_complete
update master_user_courses
join master_courses
	on master_courses.id = master_user_courses.course_id
set percent_complete = ROUND(((master_user_courses.total_required_tests_completed + master_user_courses.total_required_sections_visited) / (master_courses.total_required_tests + master_courses.total_required_sections)) * 100, 2);

