-- -----------------------------------------------------
-- Schema medrespond_deployment_info
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `medrespond_deployment_info` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `medrespond_deployment_info` ;

-- -----------------------------------------------------
-- Table `medrespond_deployment_info`.`vhost`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `medrespond_deployment_info`.`vhost` (
  `name` VARCHAR(255) NOT NULL,
  `server` VARCHAR(255) NOT NULL,
  `active` BIT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`name`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `medrespond_deployment_info`.`branch`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `medrespond_deployment_info`.`branch` (
  `name` VARCHAR(255) NOT NULL,
  `vhost_name` VARCHAR(255) NOT NULL,
  `active` BIT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`name`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `medrespond_deployment_info`.`tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `medrespond_deployment_info`.`tag` (
  `name` VARCHAR(255) NOT NULL,
  `branch_name` VARCHAR(255) NOT NULL,
  `timestamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `active` BIT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`name`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `medrespond_deployment_info`.`deployment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `medrespond_deployment_info`.`deployment` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
  `vhost_name` VARCHAR(255) NOT NULL,
  `branch_name` VARCHAR(255) NOT NULL,
  `tag_name` VARCHAR(255) NOT NULL,
  `timstamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` BIT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Insert vhost records
-- -----------------------------------------------------
INSERT INTO `medrespond_deployment_info`.`vhost` (`name`, `server`) VALUES ('uat.alcoholsbirt.com', 'prod02.medrespond.net');
INSERT INTO `medrespond_deployment_info`.`vhost` (`name`, `server`) VALUES ('www.alcoholsbirt.com', 'prod02.medrespond.net');

INSERT INTO `medrespond_deployment_info`.`vhost` (`name`, `server`) VALUES ('uat.asknamisandiego.org', 'prod02.medrespond.net');
INSERT INTO `medrespond_deployment_info`.`vhost` (`name`, `server`) VALUES ('www.asknamisandiego.org', 'prod02.medrespond.net');

INSERT INTO `medrespond_deployment_info`.`vhost` (`name`, `server`) VALUES ('uat.electricitydialogue.ca', 'prod02.medrespond.net');
INSERT INTO `medrespond_deployment_info`.`vhost` (`name`, `server`) VALUES ('www.electricitydialogue.ca', 'prod02.medrespond.net');

INSERT INTO `medrespond_deployment_info`.`vhost` (`name`, `server`) VALUES ('uat.fit-for-surgery.com', 'prod02.medrespond.net');
INSERT INTO `medrespond_deployment_info`.`vhost` (`name`, `server`) VALUES ('www.fit-for-surgery.com', 'prod02.medrespond.net');

INSERT INTO `medrespond_deployment_info`.`vhost` (`name`, `server`) VALUES ('uat.juniperconversations.com', 'prod02.medrespond.net');
INSERT INTO `medrespond_deployment_info`.`vhost` (`name`, `server`) VALUES ('www.juniperconversations.com', 'prod02.medrespond.net');

INSERT INTO `medrespond_deployment_info`.`vhost` (`name`, `server`) VALUES ('uat.medrespond-pfra.com', 'prod02.medrespond.net');
INSERT INTO `medrespond_deployment_info`.`vhost` (`name`, `server`) VALUES ('www.medrespond-pfra.com', 'prod03.medrespond.net');

INSERT INTO `medrespond_deployment_info`.`vhost` (`name`, `server`) VALUES ('uat.monarch2conversations.com', 'prod02.medrespond.net');
INSERT INTO `medrespond_deployment_info`.`vhost` (`name`, `server`) VALUES ('www.monarch2conversations.com', 'prod02.medrespond.net');

INSERT INTO `medrespond_deployment_info`.`vhost` (`name`, `server`) VALUES ('uat.pkdconversations.com', 'prod02.medrespond.net');
INSERT INTO `medrespond_deployment_info`.`vhost` (`name`, `server`) VALUES ('www.pkdconversations.com', 'prod02.medrespond.net');

INSERT INTO `medrespond_deployment_info`.`vhost` (`name`, `server`) VALUES ('uat.situpconversations.com', 'prod02.medrespond.net');
INSERT INTO `medrespond_deployment_info`.`vhost` (`name`, `server`) VALUES ('www.situpconversations.com', 'prod02.medrespond.net');

INSERT INTO `medrespond_deployment_info`.`vhost` (`name`, `server`) VALUES ('uat.supportivecareoptions.com', 'prod02.medrespond.net');
INSERT INTO `medrespond_deployment_info`.`vhost` (`name`, `server`) VALUES ('www.supportivecareoptions.com', 'prod02.medrespond.net');

-- -----------------------------------------------------
-- Insert branch records
-- -----------------------------------------------------
INSERT INTO `medrespond_deployment_info`.`branch` (`name`, `vhost_name`) VALUES ('alcoholsbirt.com_uat', 'uat.alcoholsbirt.com');
INSERT INTO `medrespond_deployment_info`.`branch` (`name`, `vhost_name`) VALUES ('alcoholsbirt.com_master', 'www.alcoholsbirt.com');

INSERT INTO `medrespond_deployment_info`.`branch` (`name`, `vhost_name`) VALUES ('asknamisandiego.org_uat', 'uat.asknamisandiego.org');
INSERT INTO `medrespond_deployment_info`.`branch` (`name`, `vhost_name`) VALUES ('asknamesandiego.org_master', 'www.asknamisandiego.org');

INSERT INTO `medrespond_deployment_info`.`branch` (`name`, `vhost_name`) VALUES ('electricitydialogue.ca_uat', 'uat.electricitydialogue.ca');
INSERT INTO `medrespond_deployment_info`.`branch` (`name`, `vhost_name`) VALUES ('electricitydialogue.ca_master', 'www.electricitydialogue.ca');

INSERT INTO `medrespond_deployment_info`.`branch` (`name`, `vhost_name`) VALUES ('fit-for-surgery.com_uat', 'uat.fit-for-surgery.com');
INSERT INTO `medrespond_deployment_info`.`branch` (`name`, `vhost_name`) VALUES ('fit-for-surgery.com_master', 'www.fit-for-surgery.com');

INSERT INTO `medrespond_deployment_info`.`branch` (`name`, `vhost_name`) VALUES ('juniperconversations.com_uat', 'uat.juniperconversations.com');
INSERT INTO `medrespond_deployment_info`.`branch` (`name`, `vhost_name`) VALUES ('juniperconversations.com_master', 'www.juniperconversations.com');

INSERT INTO `medrespond_deployment_info`.`branch` (`name`, `vhost_name`) VALUES ('medrespond-pfra.com_uat', 'uat.medrespond-pfra.com');
INSERT INTO `medrespond_deployment_info`.`branch` (`name`, `vhost_name`) VALUES ('medrespond-pfra.com_master', 'www.medrespond-pfra.com');

INSERT INTO `medrespond_deployment_info`.`branch` (`name`, `vhost_name`) VALUES ('monarch2conversations.com_uat', 'uat.monarch2conversations.com');
INSERT INTO `medrespond_deployment_info`.`branch` (`name`, `vhost_name`) VALUES ('monarch2conversations.com_master', 'www.monarch2conversations.com');

INSERT INTO `medrespond_deployment_info`.`branch` (`name`, `vhost_name`) VALUES ('pkdconversations.com_uat', 'uat.pkdconversations.com');
INSERT INTO `medrespond_deployment_info`.`branch` (`name`, `vhost_name`) VALUES ('pkdconversations.com_master', 'www.pkdconversations.com');

INSERT INTO `medrespond_deployment_info`.`branch` (`name`, `vhost_name`) VALUES ('situpconversations.com_uat', 'uat.situpconversations.com');
INSERT INTO `medrespond_deployment_info`.`branch` (`name`, `vhost_name`) VALUES ('situpconversations.com_master', 'www.situpconversations.com');

INSERT INTO `medrespond_deployment_info`.`branch` (`name`, `vhost_name`) VALUES ('supportivecareoptions.com_uat', 'uat.supportivecareoptions.com');
INSERT INTO `medrespond_deployment_info`.`branch` (`name`, `vhost_name`) VALUES ('supportivecareoptions.com_master', 'www.supportivecareoptions.com');


