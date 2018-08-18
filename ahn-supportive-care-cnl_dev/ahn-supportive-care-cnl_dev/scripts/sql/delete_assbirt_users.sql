-- DELETES ALL ASBIRT USERS EXCEPT @user_id
set @user_id = (select id from master_users where username = 'anthony.jack');

delete from master_activity_logs where user_id != @user_id;
delete from master_user_accreditation_map where user_id != @user_id;
delete from master_user_address_map where user_id != @user_id;
delete from master_user_certificates where user_id != @user_id;
delete from master_user_course_activity where user_id != @user_id;
delete from master_user_course_map where user_id != @user_id;
delete from master_user_courses where user_id != @user_id;
delete from master_user_department_map where user_id != @user_id;
delete from master_user_number_map where user_id != @user_id;
delete from master_user_numbers where user_id != @user_id;
delete from master_user_password_reset where user_id != @user_id;
delete from master_user_pay_grade_map where user_id != @user_id;
delete from master_user_role_map where user_id != @user_id;
delete from master_user_test_activity where user_id != @user_id;
delete from master_user_tests where user_id != @user_id;
delete from master_user_treatment_facility_map where user_id != @user_id;
delete from master_users where id != @user_id;
delete from master_users_map where user_id != @user_id;

-- DELETES  @user_id
set @user_id = (select id from master_users where username = 'anthony.jack');

delete from master_activity_logs where user_id = @user_id;
delete from master_user_accreditation_map where user_id = @user_id;
delete from master_user_address_map where user_id = @user_id;
delete from master_user_certificates where user_id = @user_id;
delete from master_user_course_activity where user_id = @user_id;
delete from master_user_course_map where user_id = @user_id;
delete from master_user_courses where user_id = @user_id;
delete from master_user_department_map where user_id = @user_id;
delete from master_user_number_map where user_id = @user_id;
delete from master_user_numbers where user_id = @user_id;
delete from master_user_password_reset where user_id = @user_id;
delete from master_user_pay_grade_map where user_id = @user_id;
delete from master_user_role_map where user_id = @user_id;
delete from master_user_test_activity where user_id = @user_id;
delete from master_user_tests where user_id = @user_id;
delete from master_user_treatment_facility_map where user_id = @user_id;
delete from master_users where id = @user_id;
delete from master_users_map where user_id = @user_id;
