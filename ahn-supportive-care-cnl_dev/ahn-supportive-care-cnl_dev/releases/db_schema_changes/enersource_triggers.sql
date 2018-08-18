ALTER TABLE `master_users` ADD COLUMN `customer_type` VARCHAR(64) NULL DEFAULT NULL AFTER `is_customer`;

-- UAT
DROP TRIGGER IF EXISTS `ed_ens_uat`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER ed_ens_uat.master_users_insert_trigger AFTER INSERT ON master_users
FOR EACH ROW
BEGIN
	INSERT INTO master_audit
		(admin_id, table_id, table_name, column_name, new_value)
	VALUES
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'user_type_id', NEW.user_type_id),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'first_name', NEW.first_name),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'last_name', NEW.last_name),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'username', NEW.username),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'password', NEW.password),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'email', NEW.email),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'phone', NEW.phone),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'address_line_1', NEW.address_line_1),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'address_line_2', NEW.address_line_2),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'municipality', NEW.municipality),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'province_id', NEW.province_id),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'postal_code', NEW.postal_code),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'is_customer', NEW.is_customer),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'customer_type', NEW.customer_type),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'entered_contest', NEW.entered_contest),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'created_by', NEW.created_by),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'created_date', NEW.created_date),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'last_modified_by', NEW.last_modified_by),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'last_modified_date', NEW.last_modified_date),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'login_enabled', NEW.login_enabled),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'active', NEW.active),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'questions_asked', NEW.questions_asked),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'responses_given', NEW.responses_given),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'minutes_online', NEW.minutes_online);
END$$

DROP TRIGGER IF EXISTS `ed_ens_uat`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `ed_ens_uat`.master_users_update_trigger AFTER UPDATE ON master_users
FOR EACH ROW
BEGIN
	IF NEW.user_type_id != OLD.user_type_id
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'user_type_id', OLD.user_type_id, NEW.user_type_id);
	END IF;

	IF NEW.first_name != OLD.first_name
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'first_name', OLD.first_name, NEW.first_name);
	END IF;

	IF NEW.last_name != OLD.last_name
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'last_name', OLD.last_name, NEW.last_name);
	END IF;

	IF NEW.username != OLD.username
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'username', OLD.username, NEW.username);
	END IF;

	IF NEW.password != OLD.password
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'password', OLD.password, NEW.password);
	END IF;

	IF NEW.email != OLD.email
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'email', OLD.email, NEW.email);
	END IF;

	IF NEW.phone != OLD.phone
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'phone', OLD.phone, NEW.phone);
	END IF;

	IF NEW.address_line_1 != OLD.address_line_1
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'address_line_1', OLD.address_line_1, NEW.address_line_1);
	END IF;

	IF NEW.address_line_2 != OLD.address_line_2
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'address_line_2', OLD.address_line_2, NEW.address_line_2);
	END IF;

	IF NEW.municipality != OLD.municipality
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'municipality', OLD.municipality, NEW.municipality);
	END IF;

	IF NEW.province_id != OLD.province_id
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'province_id', OLD.province_id, NEW.province_id);
	END IF;

	IF NEW.postal_code != OLD.postal_code
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'postal_code', OLD.postal_code, NEW.postal_code);
	END IF;

	IF NEW.is_customer != OLD.is_customer
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'is_customer', OLD.is_customer, NEW.is_customer);
	END IF;

	IF NEW.customer_type != OLD.customer_type
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'customer_type', OLD.customer_type, NEW.customer_type);
	END IF;

	IF NEW.entered_contest != OLD.entered_contest
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'entered_contest', OLD.entered_contest, NEW.entered_contest);
	END IF;

	IF NEW.created_by != OLD.created_by
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'created_by', OLD.created_by, NEW.created_by);
	END IF;

	IF NEW.created_date != OLD.created_date
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'created_date', OLD.created_date, NEW.created_date);
	END IF;

	IF NEW.last_modified_by != OLD.last_modified_by
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'last_modified_by', OLD.last_modified_by, NEW.last_modified_by);
	END IF;

	IF NEW.last_modified_date != OLD.last_modified_date
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'last_modified_date', OLD.last_modified_date, NEW.last_modified_date);
	END IF;

	IF NEW.login_enabled != OLD.login_enabled
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'login_enabled', OLD.login_enabled, NEW.login_enabled);
	END IF;

	IF NEW.active != OLD.active
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'active', OLD.active, NEW.active);
	END IF;

	IF NEW.questions_asked != OLD.questions_asked
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'questions_asked', OLD.questions_asked, NEW.questions_asked);
	END IF;

	IF NEW.responses_given != OLD.responses_given
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'responses_given', OLD.responses_given, NEW.responses_given);
	END IF;

	IF NEW.minutes_online != OLD.minutes_online
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'minutes_online', OLD.minutes_online, NEW.minutes_online);
	END IF;
END$$

-- PROD
DROP TRIGGER IF EXISTS `ed_ens_production`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER ed_ens_production.master_users_insert_trigger AFTER INSERT ON master_users
FOR EACH ROW
BEGIN
	INSERT INTO master_audit
		(admin_id, table_id, table_name, column_name, new_value)
	VALUES
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'user_type_id', NEW.user_type_id),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'first_name', NEW.first_name),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'last_name', NEW.last_name),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'username', NEW.username),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'password', NEW.password),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'email', NEW.email),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'phone', NEW.phone),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'address_line_1', NEW.address_line_1),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'address_line_2', NEW.address_line_2),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'municipality', NEW.municipality),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'province_id', NEW.province_id),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'postal_code', NEW.postal_code),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'is_customer', NEW.is_customer),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'customer_type', NEW.customer_type),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'entered_contest', NEW.entered_contest),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'created_by', NEW.created_by),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'created_date', NEW.created_date),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'last_modified_by', NEW.last_modified_by),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'last_modified_date', NEW.last_modified_date),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'login_enabled', NEW.login_enabled),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'active', NEW.active),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'questions_asked', NEW.questions_asked),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'responses_given', NEW.responses_given),
		(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'minutes_online', NEW.minutes_online);
END$$

DROP TRIGGER IF EXISTS `ed_ens_production`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `ed_ens_production`.master_users_update_trigger AFTER UPDATE ON master_users
FOR EACH ROW
BEGIN
	IF NEW.user_type_id != OLD.user_type_id
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'user_type_id', OLD.user_type_id, NEW.user_type_id);
	END IF;

	IF NEW.first_name != OLD.first_name
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'first_name', OLD.first_name, NEW.first_name);
	END IF;

	IF NEW.last_name != OLD.last_name
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'last_name', OLD.last_name, NEW.last_name);
	END IF;

	IF NEW.username != OLD.username
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'username', OLD.username, NEW.username);
	END IF;

	IF NEW.password != OLD.password
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'password', OLD.password, NEW.password);
	END IF;

	IF NEW.email != OLD.email
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'email', OLD.email, NEW.email);
	END IF;

	IF NEW.phone != OLD.phone
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'phone', OLD.phone, NEW.phone);
	END IF;

	IF NEW.address_line_1 != OLD.address_line_1
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'address_line_1', OLD.address_line_1, NEW.address_line_1);
	END IF;

	IF NEW.address_line_2 != OLD.address_line_2
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'address_line_2', OLD.address_line_2, NEW.address_line_2);
	END IF;

	IF NEW.municipality != OLD.municipality
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'municipality', OLD.municipality, NEW.municipality);
	END IF;

	IF NEW.province_id != OLD.province_id
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'province_id', OLD.province_id, NEW.province_id);
	END IF;

	IF NEW.postal_code != OLD.postal_code
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'postal_code', OLD.postal_code, NEW.postal_code);
	END IF;

	IF NEW.is_customer != OLD.is_customer
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'is_customer', OLD.is_customer, NEW.is_customer);
	END IF;

	IF NEW.customer_type != OLD.customer_type
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'customer_type', OLD.customer_type, NEW.customer_type);
	END IF;

	IF NEW.entered_contest != OLD.entered_contest
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'entered_contest', OLD.entered_contest, NEW.entered_contest);
	END IF;

	IF NEW.created_by != OLD.created_by
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'created_by', OLD.created_by, NEW.created_by);
	END IF;

	IF NEW.created_date != OLD.created_date
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'created_date', OLD.created_date, NEW.created_date);
	END IF;

	IF NEW.last_modified_by != OLD.last_modified_by
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'last_modified_by', OLD.last_modified_by, NEW.last_modified_by);
	END IF;

	IF NEW.last_modified_date != OLD.last_modified_date
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'last_modified_date', OLD.last_modified_date, NEW.last_modified_date);
	END IF;

	IF NEW.login_enabled != OLD.login_enabled
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'login_enabled', OLD.login_enabled, NEW.login_enabled);
	END IF;

	IF NEW.active != OLD.active
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'active', OLD.active, NEW.active);
	END IF;

	IF NEW.questions_asked != OLD.questions_asked
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'questions_asked', OLD.questions_asked, NEW.questions_asked);
	END IF;

	IF NEW.responses_given != OLD.responses_given
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'responses_given', OLD.responses_given, NEW.responses_given);
	END IF;

	IF NEW.minutes_online != OLD.minutes_online
	THEN
		INSERT INTO master_audit (admin_id, table_id, table_name, column_name, old_value, new_value) VALUES(IFNULL(@current_authenticated_user_id, 0), NEW.id, 'master_users', 'minutes_online', OLD.minutes_online, NEW.minutes_online);
	END IF;
END$$
