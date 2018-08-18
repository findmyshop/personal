-- reset user course
SET SQL_SAFE_UPDATES = 0;

set @user_id = (select id from master_users where username = 'test.user.14');
set @course_id = 1;

update master_user_courses
set
	has_completed = 0,
	has_passed = 0,
	date_completed = null,
	total_sections_visited = 0,
	total_tests_surveys_visited = 0,
	percent_complete = 0,
	active = 1
where
	user_id = @user_id
	and course_id = @course_id;

update master_user_certificates
set
	certificate_page_accepted = 0,
	date_certificate_page_accepted = null,
	certificate_accepted_by_user = 0,
	date_certificate_accepted_by_user = null,
	certificate_issued = 0,
	date_certificate_issued = null,
	certificate_reported = 0,
	date_certificate_reported = null,
	certificate_viewed = 0,
	date_certificate_first_viewed = null,
	date_certificate_last_viewed = null
where
	user_id = @user_id
	and course_id = @course_id;

delete master_activity_logs
from master_activity_logs
join master_user_course_activity
	on master_user_course_activity.activity_log_id = master_activity_logs.id
where
	master_user_course_activity.user_id = @user_id
	and master_user_course_activity.course_id = @course_id;

delete master_user_course_activity
from master_user_course_activity
where
	master_user_course_activity.user_id = @user_id
	and master_user_course_activity.course_id = @course_id;

delete master_user_test_activity
from master_user_test_activity
join master_test_elements
	on master_test_elements.id = master_user_test_activity.test_element_id
join master_tests
	on master_tests.id = master_test_elements.test_id
where
	master_user_test_activity.user_id = @user_id
	and master_tests.course_id = @course_id;

delete master_user_tests
from master_user_tests
join master_tests
	on master_tests.id = master_user_tests.test_id
where
	master_user_tests.user_id = @user_id
	and master_tests.course_id = @course_id;
  

update master_user_accreditation_map
set
  disclaimer_accepted = 0,
  date_disclaimer_accepted = NULL
where user_id = @user_id;
-- end of reset user course

