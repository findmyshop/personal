-- master_users columns
-- 'id'
-- 'user_type_id'
-- 'first_name'
-- 'last_name'
-- 'username'
-- 'password'
-- 'email'
-- 'created_by'
-- 'created_date'
-- 'last_modified_by'
-- 'last_modified_date'
-- 'login_enabled'
-- 'active'
-- 'questions_asked'
-- 'responses_given'
-- 'minutes_online'

-- DEV
-- create master_audit table
DROP TABLE IF EXISTS `master_audit`;
CREATE TABLE `master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- create master_actions table
DROP TABLE IF EXISTS `master_actions`;
CREATE TABLE `master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- create insert trigger
DROP TRIGGER IF EXISTS master_users_insert_trigger;
DELIMITER $$
CREATE TRIGGER master_users_insert_trigger AFTER INSERT ON master_users
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

-- create update trigger
DROP TRIGGER IF EXISTS master_users_update_trigger;
DELIMITER $$
CREATE TRIGGER master_users_update_trigger AFTER UPDATE ON master_users
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

-- insert initial audit records for users that haven't been modified
INSERT INTO master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM master_users WHERE last_modified_date IS NULL;
INSERT INTO master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM master_users WHERE last_modified_date IS NULL;
INSERT INTO master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM master_users WHERE last_modified_date IS NULL;
INSERT INTO master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM master_users WHERE last_modified_date IS NULL;
INSERT INTO master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM master_users WHERE last_modified_date IS NULL;
INSERT INTO master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM master_users WHERE last_modified_date IS NULL;
INSERT INTO master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM master_users WHERE last_modified_date IS NULL;
INSERT INTO master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM master_users WHERE last_modified_date IS NULL;
INSERT INTO master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM master_users WHERE last_modified_date IS NULL;
INSERT INTO master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM master_users WHERE last_modified_date IS NULL;
INSERT INTO master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM master_users WHERE last_modified_date IS NULL;
INSERT INTO master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM master_users WHERE last_modified_date IS NULL;
INSERT INTO master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM master_users WHERE last_modified_date IS NULL;
INSERT INTO master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM master_users WHERE last_modified_date IS NULL;
INSERT INTO master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM master_users WHERE last_modified_date IS NULL;


-- ************************************************************************************************************************************************
-- UAT
-- ************************************************************************************************************************************************
-- create master_audit table
DROP TABLE IF EXISTS `ahn_f4s_uat`.`master_audit`;
CREATE TABLE `ahn_f4s_uat`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `ahn_scc_uat`.`master_audit`;
CREATE TABLE `ahn_scc_uat`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `az_ddk_uat`.`master_audit`;
CREATE TABLE `az_ddk_uat`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `dod_asb_uat`.`master_audit`;
CREATE TABLE `dod_asb_uat`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `ed_ens_uat`.`master_audit`;
CREATE TABLE `ed_ens_uat`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_chet_lilly_uat`.`master_audit`;
CREATE TABLE `mmg_chet_lilly_uat`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_chet_otsuka_uat`.`master_audit`;
CREATE TABLE `mmg_chet_otsuka_uat`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_jcc_uat`.`master_audit`;
CREATE TABLE `mmg_jcc_uat`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_lilly_uat`.`master_audit`;
CREATE TABLE `mmg_lilly_uat`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_otsuka_uat`.`master_audit`;
CREATE TABLE `mmg_otsuka_uat`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_t2d_uat`.`master_audit`;
CREATE TABLE `mmg_t2d_uat`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_ysc_uat`.`master_audit`;
CREATE TABLE `mmg_ysc_uat`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `nami_sd_uat`.`master_audit`;
CREATE TABLE `nami_sd_uat`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `pfizer_ra_uat`.`master_audit`;
CREATE TABLE `pfizer_ra_uat`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- create master_actions table

DROP TABLE IF EXISTS `ahn_f4s_uat`.`master_actions`;
CREATE TABLE `ahn_f4s_uat`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `ahn_scc_uat`.`master_actions`;
CREATE TABLE `ahn_scc_uat`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `az_ddk_uat`.`master_actions`;
CREATE TABLE `az_ddk_uat`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `dod_asb_uat`.`master_actions`;
CREATE TABLE `dod_asb_uat`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `ed_ens_uat`.`master_actions`;
CREATE TABLE `ed_ens_uat`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_chet_lilly_uat`.`master_actions`;
CREATE TABLE `mmg_chet_lilly_uat`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_chet_otsuka_uat`.`master_actions`;
CREATE TABLE `mmg_chet_otsuka_uat`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_jcc_uat`.`master_actions`;
CREATE TABLE `mmg_jcc_uat`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_lilly_uat`.`master_actions`;
CREATE TABLE `mmg_lilly_uat`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_otsuka_uat`.`master_actions`;
CREATE TABLE `mmg_otsuka_uat`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_t2d_uat`.`master_actions`;
CREATE TABLE `mmg_t2d_uat`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_ysc_uat`.`master_actions`;
CREATE TABLE `mmg_ysc_uat`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `nami_sd_uat`.`master_actions`;
CREATE TABLE `nami_sd_uat`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `pfizer_ra_uat`.`master_actions`;
CREATE TABLE `pfizer_ra_uat`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- create insert trigger
DROP TRIGGER IF EXISTS `ahn_f4s_uat`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER ahn_f4s_uat.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `ahn_scc_uat`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER ahn_scc_uat.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `az_ddk_uat`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER az_ddk_uat.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `dod_asb_uat`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER dod_asb_uat.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `mmg_chet_lilly_uat`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER mmg_chet_lilly_uat.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `mmg_chet_otsuka_uat`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER mmg_chet_otsuka_uat.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `mmg_jcc_uat`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER mmg_jcc_uat.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `mmg_lilly_uat`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER mmg_lilly_uat.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `mmg_otsuka_uat`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER mmg_otsuka_uat.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `mmg_t2d_uat`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER mmg_t2d_uat.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `mmg_ysc_uat`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER mmg_ysc_uat.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `nami_sd_uat`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER nami_sd_uat.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `pfizer_ra_uat`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER pfizer_ra_uat.master_users_insert_trigger AFTER INSERT ON master_users
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

-- create update trigger

DROP TRIGGER IF EXISTS `ahn_f4s_uat`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `ahn_f4s_uat`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `ahn_scc_uat`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `ahn_scc_uat`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `az_ddk_uat`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `az_ddk_uat`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `dod_asb_uat`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `dod_asb_uat`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `mmg_chet_lilly_uat`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `mmg_chet_lilly_uat`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `mmg_chet_otsuka_uat`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `mmg_chet_otsuka_uat`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `mmg_jcc_uat`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `mmg_jcc_uat`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `mmg_lilly_uat`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `mmg_lilly_uat`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `mmg_otsuka_uat`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `mmg_otsuka_uat`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `mmg_t2d_uat`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `mmg_t2d_uat`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `mmg_ysc_uat`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `mmg_ysc_uat`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `nami_sd_uat`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `nami_sd_uat`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `pfizer_ra_uat`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `pfizer_ra_uat`.master_users_update_trigger AFTER UPDATE ON master_users
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

-- insert initial audit records for users that haven't been modified
INSERT INTO ahn_f4s_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM ahn_f4s_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM ahn_f4s_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM ahn_f4s_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM ahn_f4s_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM ahn_f4s_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM ahn_f4s_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM ahn_f4s_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM ahn_f4s_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM ahn_f4s_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM ahn_f4s_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM ahn_f4s_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM ahn_f4s_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM ahn_f4s_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM ahn_f4s_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM ahn_f4s_uat.master_users WHERE last_modified_date IS NULL;

INSERT INTO ahn_scc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM ahn_scc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM ahn_scc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM ahn_scc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM ahn_scc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM ahn_scc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM ahn_scc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM ahn_scc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM ahn_scc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM ahn_scc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM ahn_scc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM ahn_scc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM ahn_scc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM ahn_scc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM ahn_scc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM ahn_scc_uat.master_users WHERE last_modified_date IS NULL;

INSERT INTO az_ddk_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM az_ddk_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM az_ddk_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM az_ddk_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM az_ddk_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM az_ddk_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM az_ddk_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM az_ddk_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM az_ddk_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM az_ddk_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM az_ddk_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM az_ddk_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM az_ddk_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM az_ddk_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM az_ddk_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM az_ddk_uat.master_users WHERE last_modified_date IS NULL;

INSERT INTO dod_asb_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM dod_asb_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM dod_asb_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM dod_asb_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM dod_asb_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM dod_asb_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM dod_asb_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM dod_asb_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM dod_asb_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM dod_asb_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM dod_asb_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM dod_asb_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM dod_asb_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM dod_asb_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM dod_asb_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM dod_asb_uat.master_users WHERE last_modified_date IS NULL;

INSERT INTO ed_ens_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM ed_ens_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM ed_ens_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM ed_ens_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM ed_ens_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM ed_ens_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM ed_ens_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM ed_ens_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM ed_ens_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM ed_ens_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM ed_ens_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM ed_ens_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM ed_ens_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM ed_ens_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM ed_ens_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM ed_ens_uat.master_users WHERE last_modified_date IS NULL;

INSERT INTO mmg_chet_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM mmg_chet_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM mmg_chet_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM mmg_chet_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM mmg_chet_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM mmg_chet_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM mmg_chet_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM mmg_chet_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM mmg_chet_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM mmg_chet_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM mmg_chet_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM mmg_chet_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM mmg_chet_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM mmg_chet_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM mmg_chet_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM mmg_chet_lilly_uat.master_users WHERE last_modified_date IS NULL;

INSERT INTO mmg_chet_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM mmg_chet_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM mmg_chet_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM mmg_chet_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM mmg_chet_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM mmg_chet_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM mmg_chet_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM mmg_chet_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM mmg_chet_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM mmg_chet_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM mmg_chet_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM mmg_chet_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM mmg_chet_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM mmg_chet_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM mmg_chet_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_chet_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM mmg_chet_otsuka_uat.master_users WHERE last_modified_date IS NULL;

INSERT INTO mmg_jcc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM mmg_jcc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM mmg_jcc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM mmg_jcc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM mmg_jcc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM mmg_jcc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM mmg_jcc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM mmg_jcc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM mmg_jcc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM mmg_jcc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM mmg_jcc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM mmg_jcc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM mmg_jcc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM mmg_jcc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM mmg_jcc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM mmg_jcc_uat.master_users WHERE last_modified_date IS NULL;

INSERT INTO mmg_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM mmg_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM mmg_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM mmg_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM mmg_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM mmg_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM mmg_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM mmg_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM mmg_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM mmg_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM mmg_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM mmg_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM mmg_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM mmg_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM mmg_lilly_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM mmg_lilly_uat.master_users WHERE last_modified_date IS NULL;

INSERT INTO mmg_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM mmg_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM mmg_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM mmg_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM mmg_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM mmg_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM mmg_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM mmg_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM mmg_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM mmg_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM mmg_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM mmg_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM mmg_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM mmg_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM mmg_otsuka_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM mmg_otsuka_uat.master_users WHERE last_modified_date IS NULL;

INSERT INTO mmg_t2d_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM mmg_t2d_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM mmg_t2d_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM mmg_t2d_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM mmg_t2d_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM mmg_t2d_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM mmg_t2d_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM mmg_t2d_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM mmg_t2d_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM mmg_t2d_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM mmg_t2d_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM mmg_t2d_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM mmg_t2d_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM mmg_t2d_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM mmg_t2d_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM mmg_t2d_uat.master_users WHERE last_modified_date IS NULL;

INSERT INTO mmg_ysc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM mmg_ysc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM mmg_ysc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM mmg_ysc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM mmg_ysc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM mmg_ysc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM mmg_ysc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM mmg_ysc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM mmg_ysc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM mmg_ysc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM mmg_ysc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM mmg_ysc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM mmg_ysc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM mmg_ysc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM mmg_ysc_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM mmg_ysc_uat.master_users WHERE last_modified_date IS NULL;

INSERT INTO nami_sd_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM nami_sd_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM nami_sd_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM nami_sd_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM nami_sd_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM nami_sd_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM nami_sd_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM nami_sd_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM nami_sd_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM nami_sd_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM nami_sd_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM nami_sd_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM nami_sd_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM nami_sd_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM nami_sd_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM nami_sd_uat.master_users WHERE last_modified_date IS NULL;

INSERT INTO pfizer_ra_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM pfizer_ra_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM pfizer_ra_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM pfizer_ra_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM pfizer_ra_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM pfizer_ra_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM pfizer_ra_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM pfizer_ra_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM pfizer_ra_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM pfizer_ra_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM pfizer_ra_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM pfizer_ra_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM pfizer_ra_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM pfizer_ra_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM pfizer_ra_uat.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_uat.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM pfizer_ra_uat.master_users WHERE last_modified_date IS NULL;

-- ************************************************************************************************************************************************
-- PROD
-- ************************************************************************************************************************************************
-- create master_audit table
DROP TABLE IF EXISTS `ahn_f4s_production`.`master_audit`;
CREATE TABLE `ahn_f4s_production`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `ahn_scc_production`.`master_audit`;
CREATE TABLE `ahn_scc_production`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `az_ddk_production`.`master_audit`;
CREATE TABLE `az_ddk_production`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `dod_asb_production`.`master_audit`;
CREATE TABLE `dod_asb_production`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `ed_ens_production`.`master_audit`;
CREATE TABLE `ed_ens_production`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_chet_lilly_production`.`master_audit`;
CREATE TABLE `mmg_chet_lilly_production`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_chet_otsuka_production`.`master_audit`;
CREATE TABLE `mmg_chet_otsuka_production`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_jcc_production`.`master_audit`;
CREATE TABLE `mmg_jcc_production`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_lilly_production`.`master_audit`;
CREATE TABLE `mmg_lilly_production`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_otsuka_production`.`master_audit`;
CREATE TABLE `mmg_otsuka_production`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_t2d_production`.`master_audit`;
CREATE TABLE `mmg_t2d_production`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_ysc_production`.`master_audit`;
CREATE TABLE `mmg_ysc_production`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `nami_sd_production`.`master_audit`;
CREATE TABLE `nami_sd_production`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `pfizer_ra_production`.`master_audit`;
CREATE TABLE `pfizer_ra_production`.`master_audit` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`table_name` varchar(64) COLLATE utf8_bin NOT NULL,
	`column_name` varchar(128) COLLATE utf8_bin NOT NULL,
	`table_id`  varchar(16) NOT NULL,
	`admin_id` int(11) unsigned NOT NULL DEFAULT 0,
	`old_value` varchar(256) COLLATE utf8_bin DEFAULT NULL,
	`new_value` varchar(256) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- create master_actions table

DROP TABLE IF EXISTS `ahn_f4s_production`.`master_actions`;
CREATE TABLE `ahn_f4s_production`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `ahn_scc_production`.`master_actions`;
CREATE TABLE `ahn_scc_production`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `az_ddk_production`.`master_actions`;
CREATE TABLE `az_ddk_production`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `dod_asb_production`.`master_actions`;
CREATE TABLE `dod_asb_production`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `ed_ens_production`.`master_actions`;
CREATE TABLE `ed_ens_production`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_chet_lilly_production`.`master_actions`;
CREATE TABLE `mmg_chet_lilly_production`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_chet_otsuka_production`.`master_actions`;
CREATE TABLE `mmg_chet_otsuka_production`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_jcc_production`.`master_actions`;
CREATE TABLE `mmg_jcc_production`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_lilly_production`.`master_actions`;
CREATE TABLE `mmg_lilly_production`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_otsuka_production`.`master_actions`;
CREATE TABLE `mmg_otsuka_production`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_t2d_production`.`master_actions`;
CREATE TABLE `mmg_t2d_production`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `mmg_ysc_production`.`master_actions`;
CREATE TABLE `mmg_ysc_production`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `nami_sd_production`.`master_actions`;
CREATE TABLE `nami_sd_production`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
DROP TABLE IF EXISTS `pfizer_ra_production`.`master_actions`;
CREATE TABLE `pfizer_ra_production`.`master_actions` (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`property_name` varchar(16) COLLATE utf8_bin NOT NULL,
	`user_id` int(11) unsigned NOT NULL,
	`session_id` varchar(40) COLLATE utf8_bin NOT NULL,
	`ip_address` varchar(45) COLLATE utf8_bin NOT NULL,
	`operating_system` varchar(255) COLLATE utf8_bin NOT NULL,
	`browser` varchar(255) COLLATE utf8_bin NOT NULL,
	`action_type` varchar(128) COLLATE utf8_bin NOT NULL,
	`timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin

-- create insert trigger
DROP TRIGGER IF EXISTS `ahn_f4s_production`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER ahn_f4s_production.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `ahn_scc_production`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER ahn_scc_production.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `az_ddk_production`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER az_ddk_production.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `dod_asb_production`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER dod_asb_production.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `mmg_chet_lilly_production`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER mmg_chet_lilly_production.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `mmg_chet_otsuka_production`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER mmg_chet_otsuka_production.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `mmg_jcc_production`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER mmg_jcc_production.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `mmg_lilly_production`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER mmg_lilly_production.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `mmg_otsuka_production`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER mmg_otsuka_production.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `mmg_t2d_production`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER mmg_t2d_production.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `mmg_ysc_production`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER mmg_ysc_production.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `nami_sd_production`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER nami_sd_production.master_users_insert_trigger AFTER INSERT ON master_users
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

DROP TRIGGER IF EXISTS `pfizer_ra_production`.`master_users_insert_trigger`;
DELIMITER $$
CREATE TRIGGER pfizer_ra_production.master_users_insert_trigger AFTER INSERT ON master_users
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

-- create update trigger

DROP TRIGGER IF EXISTS `ahn_f4s_production`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `ahn_f4s_production`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `ahn_scc_production`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `ahn_scc_production`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `az_ddk_production`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `az_ddk_production`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `dod_asb_production`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `dod_asb_production`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `mmg_chet_lilly_production`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `mmg_chet_lilly_production`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `mmg_chet_otsuka_production`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `mmg_chet_otsuka_production`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `mmg_jcc_production`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `mmg_jcc_production`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `mmg_lilly_production`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `mmg_lilly_production`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `mmg_otsuka_production`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `mmg_otsuka_production`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `mmg_t2d_production`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `mmg_t2d_production`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `mmg_ysc_production`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `mmg_ysc_production`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `nami_sd_production`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `nami_sd_production`.master_users_update_trigger AFTER UPDATE ON master_users
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

DROP TRIGGER IF EXISTS `pfizer_ra_production`.`master_users_update_trigger`;
DELIMITER $$
CREATE TRIGGER `pfizer_ra_production`.master_users_update_trigger AFTER UPDATE ON master_users
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

-- insert initial audit records for users that haven't been modified
INSERT INTO ahn_f4s_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM ahn_f4s_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM ahn_f4s_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM ahn_f4s_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM ahn_f4s_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM ahn_f4s_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM ahn_f4s_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM ahn_f4s_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM ahn_f4s_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM ahn_f4s_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM ahn_f4s_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM ahn_f4s_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM ahn_f4s_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM ahn_f4s_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM ahn_f4s_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_f4s_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM ahn_f4s_production.master_users WHERE last_modified_date IS NULL;

INSERT INTO ahn_scc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM ahn_scc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM ahn_scc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM ahn_scc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM ahn_scc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM ahn_scc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM ahn_scc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM ahn_scc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM ahn_scc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM ahn_scc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM ahn_scc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM ahn_scc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM ahn_scc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM ahn_scc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM ahn_scc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ahn_scc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM ahn_scc_production.master_users WHERE last_modified_date IS NULL;

INSERT INTO az_ddk_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM az_ddk_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM az_ddk_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM az_ddk_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM az_ddk_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM az_ddk_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM az_ddk_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM az_ddk_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM az_ddk_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM az_ddk_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM az_ddk_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM az_ddk_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM az_ddk_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM az_ddk_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM az_ddk_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO az_ddk_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM az_ddk_production.master_users WHERE last_modified_date IS NULL;

INSERT INTO dod_asb_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM dod_asb_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM dod_asb_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM dod_asb_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM dod_asb_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM dod_asb_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM dod_asb_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM dod_asb_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM dod_asb_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM dod_asb_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM dod_asb_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM dod_asb_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM dod_asb_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM dod_asb_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM dod_asb_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO dod_asb_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM dod_asb_production.master_users WHERE last_modified_date IS NULL;

INSERT INTO ed_ens_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM ed_ens_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM ed_ens_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM ed_ens_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM ed_ens_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM ed_ens_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM ed_ens_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM ed_ens_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM ed_ens_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM ed_ens_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM ed_ens_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM ed_ens_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM ed_ens_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM ed_ens_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM ed_ens_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO ed_ens_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM ed_ens_production.master_users WHERE last_modified_date IS NULL;

INSERT INTO mmg_jcc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM mmg_jcc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM mmg_jcc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM mmg_jcc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM mmg_jcc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM mmg_jcc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM mmg_jcc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM mmg_jcc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM mmg_jcc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM mmg_jcc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM mmg_jcc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM mmg_jcc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM mmg_jcc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM mmg_jcc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM mmg_jcc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_jcc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM mmg_jcc_production.master_users WHERE last_modified_date IS NULL;

INSERT INTO mmg_lilly_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM mmg_lilly_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM mmg_lilly_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM mmg_lilly_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM mmg_lilly_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM mmg_lilly_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM mmg_lilly_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM mmg_lilly_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM mmg_lilly_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM mmg_lilly_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM mmg_lilly_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM mmg_lilly_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM mmg_lilly_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM mmg_lilly_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM mmg_lilly_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_lilly_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM mmg_lilly_production.master_users WHERE last_modified_date IS NULL;

INSERT INTO mmg_otsuka_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM mmg_otsuka_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM mmg_otsuka_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM mmg_otsuka_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM mmg_otsuka_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM mmg_otsuka_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM mmg_otsuka_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM mmg_otsuka_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM mmg_otsuka_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM mmg_otsuka_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM mmg_otsuka_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM mmg_otsuka_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM mmg_otsuka_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM mmg_otsuka_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM mmg_otsuka_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_otsuka_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM mmg_otsuka_production.master_users WHERE last_modified_date IS NULL;

INSERT INTO mmg_t2d_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM mmg_t2d_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM mmg_t2d_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM mmg_t2d_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM mmg_t2d_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM mmg_t2d_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM mmg_t2d_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM mmg_t2d_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM mmg_t2d_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM mmg_t2d_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM mmg_t2d_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM mmg_t2d_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM mmg_t2d_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM mmg_t2d_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM mmg_t2d_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_t2d_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM mmg_t2d_production.master_users WHERE last_modified_date IS NULL;

INSERT INTO mmg_ysc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM mmg_ysc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM mmg_ysc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM mmg_ysc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM mmg_ysc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM mmg_ysc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM mmg_ysc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM mmg_ysc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM mmg_ysc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM mmg_ysc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM mmg_ysc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM mmg_ysc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM mmg_ysc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM mmg_ysc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM mmg_ysc_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO mmg_ysc_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM mmg_ysc_production.master_users WHERE last_modified_date IS NULL;

INSERT INTO nami_sd_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM nami_sd_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM nami_sd_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM nami_sd_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM nami_sd_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM nami_sd_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM nami_sd_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM nami_sd_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM nami_sd_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM nami_sd_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM nami_sd_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM nami_sd_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM nami_sd_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM nami_sd_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM nami_sd_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO nami_sd_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM nami_sd_production.master_users WHERE last_modified_date IS NULL;

INSERT INTO pfizer_ra_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'user_type_id', user_type_id, TIMESTAMP(created_date) FROM pfizer_ra_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'first_name', first_name, TIMESTAMP(created_date) FROM pfizer_ra_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_name', last_name, TIMESTAMP(created_date) FROM pfizer_ra_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'username', username, TIMESTAMP(created_date) FROM pfizer_ra_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'password', password, TIMESTAMP(created_date) FROM pfizer_ra_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'email', email, TIMESTAMP(created_date) FROM pfizer_ra_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_by', created_by, TIMESTAMP(created_date) FROM pfizer_ra_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'created_date', created_date, TIMESTAMP(created_date) FROM pfizer_ra_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_by', last_modified_by, TIMESTAMP(created_date) FROM pfizer_ra_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'last_modified_date', last_modified_date, TIMESTAMP(created_date) FROM pfizer_ra_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'login_enabled', login_enabled, TIMESTAMP(created_date) FROM pfizer_ra_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'active', active, TIMESTAMP(created_date) FROM pfizer_ra_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'questions_asked', questions_asked, TIMESTAMP(created_date) FROM pfizer_ra_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'responses_given', responses_given, TIMESTAMP(created_date) FROM pfizer_ra_production.master_users WHERE last_modified_date IS NULL;
INSERT INTO pfizer_ra_production.master_audit (table_id, table_name, column_name, new_value, timestamp) SELECT id, 'master_users', 'minutes_online', minutes_online, TIMESTAMP(created_date) FROM pfizer_ra_production.master_users WHERE last_modified_date IS NULL;


