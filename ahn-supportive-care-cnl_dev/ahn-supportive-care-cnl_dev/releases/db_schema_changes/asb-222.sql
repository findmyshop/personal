-- IMPORTANT - it's crucial that all of the updates in this file run sequentially.  DO NOT execute them out of order
SET SQL_SAFE_UPDATES = 0;

ALTER TABLE `master_courses` CHANGE `total_required_sections` `total_sections` INT UNSIGNED NOT NULL;
ALTER TABLE `master_courses` CHANGE `total_required_tests` `total_tests_surveys` INT UNSIGNED NOT NULL;
ALTER TABLE `master_user_courses` CHANGE `total_required_sections_visited` `total_sections_visited` INT UNSIGNED NOT NULL;
ALTER TABLE `master_user_courses` CHANGE `total_required_tests_completed` `total_tests_surveys_visited` INT UNSIGNED NOT NULL;

-- calculate and set master_courses.total_sections value
UPDATE master_courses
SET master_courses.total_sections = (
	SELECT count(DISTINCT master_course_elements.id)
	FROM master_course_elements
	WHERE
		master_course_elements.course_id = master_courses.id
		AND master_course_elements.response_id != ''
		AND master_course_elements.response_id IS NOT NULL
		AND master_course_elements.is_test = 0
		AND master_course_elements.active = 1
);

-- calculate and set master_courses.total_tests_surveys value
UPDATE master_courses
SET master_courses.total_tests_surveys = (
	SELECT count(master_tests.id)
	FROM master_tests
	WHERE
		master_tests.course_id = master_courses.id
		-- AND master_tests.required != 0
		AND master_tests.active = 1
);

-- calculate and set master_user_courses.total_sections_visited value
update master_user_courses
set master_user_courses.total_sections_visited = (
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
			-- AND master_user_course_activity.`status` != 'locked'
			AND master_user_course_activity.active = 1
);

-- calculate and set master_user_courses.total_tests_surveys_visited value
update master_user_courses as t
join (
	select
	user_id,
	course_id,
	course_iteration,
	count(distinct test_key) as tests_surveys_visited
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
			on master_user_course_activity.response_id = master_tests.`key`
		where master_tests.active = 1
			and master_user_course_activity.active = 1
			-- and master_tests.required != 0
	) union (
		select
			master_user_tests.user_id,
			master_tests.course_id,
			master_user_tests.course_iteration,
			master_user_tests.test_id,
			master_tests.`key` as test_key
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
set t.total_tests_surveys_visited = r.tests_surveys_visited;

-- calculate and set master_user_courses.percent_complete
update master_user_courses
join master_courses
	on master_courses.id = master_user_courses.course_id
set percent_complete = ROUND(((master_user_courses.total_tests_surveys_visited + master_user_courses.total_sections_visited) / (master_courses.total_tests_surveys + master_courses.total_sections)) * 100, 2);

-- cleanup master_user_courses records for users that somehow managed to complete the course while percent_complete != 100.00
update master_user_courses
join master_courses
	on master_courses.id = master_user_courses.course_id
set
	master_user_courses.total_sections_visited = master_courses.total_sections,
	master_user_courses.total_tests_surveys_visited = master_courses.total_tests_surveys,
	master_user_courses.percent_complete = 100.00
where
	master_user_courses.has_completed = 1
	and master_user_courses.percent_complete != 100.00;

-- set master_user_courses.has_passed = 1 for all users that have passed the required test
update master_user_courses
join master_tests
	on master_tests.course_id = master_user_courses.course_id
	and master_tests.required = 1
	and master_tests.passing_score > 0
join master_user_tests
	on master_user_tests.test_id = master_tests.id
	and master_user_tests.user_id = master_user_courses.user_id
	and master_user_tests.course_iteration = master_user_courses.current_iteration
	and master_user_tests.has_passed = 1
set master_user_courses.has_passed = 1;

-- set master_user_courses.has_completed = 1 and master_user_courses.date_completed = master_user_certificates.date_certificate_page_accepted on courses where the user has accepted their certificate
update master_user_courses
join master_user_certificates
	on master_user_certificates.user_id = master_user_courses.user_id
	and master_user_certificates.course_id = master_user_courses.course_id
	and master_user_certificates.certificate_page_accepted = 1
set
	master_user_courses.has_completed = 1,
	master_user_courses.date_completed = master_user_certificates.date_certificate_page_accepted
where
	master_user_courses.has_passed = 1
	and master_user_courses.has_completed = 0
	and master_user_courses.percent_complete = 100.00;

-- manually insert master_activity_logs entries for users that have had their course force completed
insert into master_activity_logs (
	mr_project,
	session_id,
	ip_address,
	operating_system,
	browser,
	user_id,
	action,
	input_question,
	case_name,
	current_response,
	response_id,
	response_question,
	response_type,
	date
)
select
	mal.mr_project,                         -- mr_project
	mal.session_id,                         -- session_id
	mal.ip_address,                         -- ip_address
	mal.operating_system,                   -- operating_system
	mal.browser,                            -- browser
	mal.user_id,                            -- user_id
	'Next',                                 -- action
	'manually_inserted_activity',           -- input_question
	mal.case_name,                          -- case_name
	mal.response_id,                        -- current_response
	mt.`key`,                               -- response_id
	mt.test_name,                           -- response_question
	'',                                     -- response_type
	date_add(mal.date, interval 1 second) 	-- date
from master_users as mu
join master_user_courses as muco
	on muco.user_id = mu.id
	and muco.has_passed = 1
	and muco.has_completed = 0
	and muco.percent_complete != 100.00
join master_user_certificates as muce
	on muce.user_id = mu.id
	and muce.course_id = muco.course_id
	and muce.date_certificate_page_accepted is not null
join master_tests as mt
	on mt.course_id = muco.course_id
join master_activity_logs as mal
	on mal.user_id = mu.id
join (
	select
		user_id,
		max(date) as most_recent_activity_date
	from master_activity_logs
	group by user_id
) as mrmal
	on mrmal.user_id = mal.user_id
	and mrmal.most_recent_activity_date = mal.date
where
	mu.active = 1
	and mu.user_type_id not in(1, 2)
	and mt.`key` not in (
		select response_id
		from master_user_course_activity
		where
			user_id = mu.id
			and response_id = mt.`key`
	);

-- insert a master_user_course_activity record for each manually inserted master_activity_logs record
insert into master_user_course_activity (
	user_id,
	course_id,
	response_id,
	iteration,
	status,
	activity_log_id,
	attempt,
	active
)
select
	mu.id,                   -- user_id,
	muco.course_id,          -- course_id,
	mt.`key`,                -- response_id,
	muco.current_iteration,  -- iteration,
	'unlocked',              -- status,
	mal.id,                  -- activity_log_id,
	1,                       -- attempt,
	1
from master_users as mu
join master_user_courses as muco
	on muco.user_id = mu.id
	and muco.has_passed = 1
	and muco.has_completed = 0
	and muco.percent_complete != 100.00
join master_user_certificates as muce
	on muce.user_id = mu.id
	and muce.course_id = muco.course_id
	and muce.date_certificate_page_accepted is not null
join master_tests as mt
	on mt.course_id = muco.course_id
join master_activity_logs as mal
	on mal.user_id = mu.id
	and mal.input_question = 'manually_inserted_activity'
where
	mu.active = 1
	and mu.user_type_id not in(1, 2)
	and mt.`key` not in (
		select response_id
		from master_user_course_activity
		where
			user_id = mu.id
			and response_id = mt.`key`
	);

-- force course completion for users that haven't finished the last two surveys after accepting their certificate
update master_user_courses
join master_courses
	on master_courses.id = master_user_courses.course_id
join master_user_certificates
	on master_user_certificates.user_id = master_user_courses.user_id
	and master_user_certificates.course_id = master_user_courses.course_id
	and master_user_certificates.date_certificate_page_accepted is not null
set
	master_user_courses.total_sections_visited = master_courses.total_sections,
	master_user_courses.total_tests_surveys_visited = master_courses.total_tests_surveys,
	master_user_courses.percent_complete = 100.00,
	master_user_courses.has_completed = 1,
	master_user_courses.date_completed = master_user_certificates.date_certificate_page_accepted
where
	master_user_courses.has_passed = 1
	and master_user_courses.has_completed = 0
	and master_user_courses.percent_complete != 100.00;

-- IMPORTANT - MAKE SURE TO RUN THESE TWO QUERIES AND RECORD THE MANUALLY CREATED master_activity_logs and master_user_course_activity entries before running the updates below
select * from master_activity_logs where input_question = 'manually_inserted_activity';

select master_user_course_activity.*
from master_user_course_activity
join master_activity_logs
	on master_activity_logs.id = master_user_course_activity.activity_log_id
	and master_activity_logs.input_question = 'manually_inserted_activity';

-- clean up the manually inserted master_activity_log entries for users that have had their course force completed
update master_activity_logs
set input_question = ''
where input_question = 'manually_inserted_activity';

