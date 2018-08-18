-- master_user_courses data integrity checks
-- the following queries should all return empty result sets
-- each row returned by each query indicates a data integrity issue described by the problem_description field

select
  'percent_complete should be 100% when has_completed = 1' as problem_description,
  master_user_courses.*
from master_user_courses
where
  percent_complete != 100.00
  and has_completed = 1;

select
  'has_completed should be equal to 1 when the user has accepted their certificate' as problem_description,
  muco.*,
  muce.*
from master_user_courses as muco
join(
  select
    user_id,
    course_id,
    max(current_iteration) as most_recent_course_iteration
  from master_user_courses
  group by user_id, course_id
) as mrmuco
  on mrmuco.user_id = muco.user_id
  and mrmuco.course_id = muco.course_id
  and mrmuco.most_recent_course_iteration = muco.current_iteration
join master_user_certificates as muce
  on muce.user_id = muco.user_id
  and muce.course_id = muco.course_id
where
  muce.date_certificate_page_accepted is not null
  and muco.has_completed = 0;

select
  'has_passed should be equal to 1 when the user has accepted their certificate' as problem_description,
  muco.*,
  muce.*
from master_user_courses as muco
join(
  select
    user_id,
    course_id,
    max(current_iteration) as most_recent_course_iteration
  from master_user_courses
  group by user_id, course_id
) as mrmuco
  on mrmuco.user_id = muco.user_id
  and mrmuco.course_id = muco.course_id
  and mrmuco.most_recent_course_iteration = muco.current_iteration
join master_user_certificates as muce
  on muce.user_id = muco.user_id
  and muce.course_id = muco.course_id
where
  muce.date_certificate_page_accepted is not null
  and muco.has_passed = 0;
  
select
  'percent_complete value not in line with total_sections_visited and/or total_tests_surveys_visited values' as problem_description,
  muc.*
from master_user_courses as muc
join master_courses as mc
  on mc.id = muc.course_id
where (
  muc.total_sections_visited = mc.total_sections
  and muc.total_tests_surveys_visited = mc.total_tests_surveys
  and percent_complete != 100.00
) or (
  percent_complete = 100.00
  and (
    muc.total_sections_visited != mc.total_sections
    or muc.total_tests_surveys_visited != mc.total_tests_surveys
  )
);




