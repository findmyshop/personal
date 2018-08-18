<?php
/*
ALTER TABLE `master_user_course_activity`
	ADD COLUMN `course_id` int NOT NULL AFTER `user_id`,
	CHANGE COLUMN `response_id` `response_id` varchar(32) NOT NULL AFTER `course_id`,
	CHANGE COLUMN `iteration` `iteration` int(11) NOT NULL DEFAULT 1 AFTER `response_id`,
	CHANGE COLUMN `status` `status` varchar(11) NOT NULL AFTER `iteration`,
	CHANGE COLUMN `activity_log_id` `activity_log_id` int(11) NOT NULL AFTER `status`,
	CHANGE COLUMN `active` `active` int(11) DEFAULT 1 AFTER `activity_log_id`,
	DROP INDEX `user_id`,
	ADD INDEX `user_id` USING BTREE (`user_id`, `response_id`, `course_id`)
;

SELECT		master_users.username,
			-- master_organizations.title,
			master_courses.course_name,
			master_user_course_activity.response_id,
			master_user_course_activity.`status`,
			master_user_course_activity.response_id
FROM		master_users
JOIN		master_users_map
			ON master_users_map.user_id=master_users.id
			AND master_users_map.active=1
-- JOIN		master_organizations
--			ON master_organizations.id=master_users_map.organization_id
--			AND master_organizations.id=6
--			AND master_organizations.active=1
JOIN		master_user_courses
			ON master_user_courses.user_id=master_users.id
			AND master_user_courses.active=1
JOIN		master_courses
			ON master_courses.id=master_user_courses.course_id
			AND master_courses.active=1
JOIN		master_user_course_activity
			ON master_user_course_activity.user_id=master_users.id
			AND master_user_course_activity.course_id=master_user_courses.course_id
			AND master_user_course_activity.iteration=master_user_courses.current_iteration
			AND master_user_course_activity.`status`!='locked'
			AND master_user_course_activity.active=1
WHERE		master_users.id=289
-- GROUP BY		master_courses.course_name
ORDER BY	master_user_course_activity.response_id
-- ORDER BY master_users.id

*/

