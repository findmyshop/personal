DROP TABLE IF EXISTS `master_response_categories`;
CREATE TABLE `master_response_categories` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `property_id` INT(11) UNSIGNED NOT NULL,
  `name` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`id`));

DROP TABLE IF EXISTS `master_responses`;
CREATE TABLE `master_responses` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC));

DROP TABLE IF EXISTS `master_response_response_category_map`;
CREATE TABLE `master_response_response_category_map` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `response_id` INT(11) UNSIGNED NOT NULL,
  `response_category_id` INT(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`));

-- excecute on mmg_msp_uat and mmg_msp_production

SET @property_id = (SELECT `id` FROM `master_properties` WHERE `name` = 'msp');

-- insert master_response_categories for msp
INSERT INTO `master_response_categories` (
	`property_id`,
	`name`
) VALUES (
	@property_id,
	'Clinical Trials'
);
INSERT INTO `master_response_categories` (
	`property_id`,
	`name`
) VALUES (
	@property_id,
	'PSVT'
);
INSERT INTO `master_response_categories` (
	`property_id`,
	`name`
) VALUES (
	@property_id,
	'NODE-1'
);
INSERT INTO `master_response_categories` (
	`property_id`,
	`name`
) VALUES (
	@property_id,
	'Etripamil'
);
INSERT INTO `master_response_categories` (
	`property_id`,
	`name`
) VALUES (
	@property_id,
	'Placebo'
);
INSERT INTO `master_response_categories` (
	`property_id`,
	`name`
) VALUES (
	@property_id,
	'Safety'
);
INSERT INTO `master_response_categories` (
	`property_id`,
	`name`
) VALUES (
	@property_id,
	'Admin'
);

SET @clinical_trials_response_category_id = (SELECT `id` FROM `master_response_categories` WHERE `name` = 'Clinical Trials');
SET @psvt_response_category_id = (SELECT `id` FROM `master_response_categories` WHERE `name` = 'PSVT');
SET @node_response_category_id = (SELECT `id` FROM `master_response_categories` WHERE `name` = 'NODE-1');
SET @etripamil_response_category_id = (SELECT `id` FROM `master_response_categories` WHERE `name` = 'Etripamil');
SET @placebo_response_category_id = (SELECT `id` FROM `master_response_categories` WHERE `name` = 'Placebo');
SET @safety_response_category_id = (SELECT `id` FROM `master_response_categories` WHERE `name` = 'Safety');
SET @admin_response_category_id = (SELECT `id` FROM `master_response_categories` WHERE `name` = 'Admin');

-- insert master_response for msp
INSERT INTO `master_responses` (`name`) VALUES ('msp000');
INSERT INTO `master_responses` (`name`) VALUES ('msp001');
INSERT INTO `master_responses` (`name`) VALUES ('msp002');
INSERT INTO `master_responses` (`name`) VALUES ('msp003');
INSERT INTO `master_responses` (`name`) VALUES ('msp004');
INSERT INTO `master_responses` (`name`) VALUES ('msp005');
INSERT INTO `master_responses` (`name`) VALUES ('msp007');
INSERT INTO `master_responses` (`name`) VALUES ('msp008');
INSERT INTO `master_responses` (`name`) VALUES ('msp101');
INSERT INTO `master_responses` (`name`) VALUES ('msp104');
INSERT INTO `master_responses` (`name`) VALUES ('msp105');
INSERT INTO `master_responses` (`name`) VALUES ('msp107');
INSERT INTO `master_responses` (`name`) VALUES ('msp110');
INSERT INTO `master_responses` (`name`) VALUES ('msp113');
INSERT INTO `master_responses` (`name`) VALUES ('msp119');
INSERT INTO `master_responses` (`name`) VALUES ('msp123');
INSERT INTO `master_responses` (`name`) VALUES ('msp124');
INSERT INTO `master_responses` (`name`) VALUES ('msp126');
INSERT INTO `master_responses` (`name`) VALUES ('msp127');
INSERT INTO `master_responses` (`name`) VALUES ('msp137');
INSERT INTO `master_responses` (`name`) VALUES ('msp138');
INSERT INTO `master_responses` (`name`) VALUES ('msp139');
INSERT INTO `master_responses` (`name`) VALUES ('msp140');
INSERT INTO `master_responses` (`name`) VALUES ('msp142');
INSERT INTO `master_responses` (`name`) VALUES ('msp146');
INSERT INTO `master_responses` (`name`) VALUES ('msp147');
INSERT INTO `master_responses` (`name`) VALUES ('msp148');
INSERT INTO `master_responses` (`name`) VALUES ('msp153');
INSERT INTO `master_responses` (`name`) VALUES ('msp155');
INSERT INTO `master_responses` (`name`) VALUES ('msp163');
INSERT INTO `master_responses` (`name`) VALUES ('msp176');
INSERT INTO `master_responses` (`name`) VALUES ('msp181');
INSERT INTO `master_responses` (`name`) VALUES ('msp186');
INSERT INTO `master_responses` (`name`) VALUES ('msp188');
INSERT INTO `master_responses` (`name`) VALUES ('msp190');
INSERT INTO `master_responses` (`name`) VALUES ('msp242');
INSERT INTO `master_responses` (`name`) VALUES ('msp258');
INSERT INTO `master_responses` (`name`) VALUES ('msp259');
INSERT INTO `master_responses` (`name`) VALUES ('msp260');
INSERT INTO `master_responses` (`name`) VALUES ('msp261');
INSERT INTO `master_responses` (`name`) VALUES ('msp262');
INSERT INTO `master_responses` (`name`) VALUES ('msp263');
INSERT INTO `master_responses` (`name`) VALUES ('msp264');
INSERT INTO `master_responses` (`name`) VALUES ('msp265');
INSERT INTO `master_responses` (`name`) VALUES ('msp266');
INSERT INTO `master_responses` (`name`) VALUES ('msp267');
INSERT INTO `master_responses` (`name`) VALUES ('msp268');
INSERT INTO `master_responses` (`name`) VALUES ('msp269');
INSERT INTO `master_responses` (`name`) VALUES ('msp270');
INSERT INTO `master_responses` (`name`) VALUES ('msp271');
INSERT INTO `master_responses` (`name`) VALUES ('msp272');
INSERT INTO `master_responses` (`name`) VALUES ('msp273');
INSERT INTO `master_responses` (`name`) VALUES ('msp274');
INSERT INTO `master_responses` (`name`) VALUES ('msp275');
INSERT INTO `master_responses` (`name`) VALUES ('msp276');
INSERT INTO `master_responses` (`name`) VALUES ('msp277');
INSERT INTO `master_responses` (`name`) VALUES ('msp278');
INSERT INTO `master_responses` (`name`) VALUES ('msp279');

-- insert response category mappings for the following
-- @clinical_trials_response_category_id
-- @psvt_response_category_id
-- @node_response_category_id
-- @etripamil_response_category_id
-- @placebo_response_category_id
-- @safety_response_category_id
-- @admin_response_category_id

-- insert Clinical Trials Response Category Mappings
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp000'),
	@clinical_trials_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp101'),
	@clinical_trials_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp104'),
	@clinical_trials_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp107'),
	@clinical_trials_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp110'),
	@clinical_trials_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp113'),
	@clinical_trials_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp119'),
	@clinical_trials_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp123'),
	@clinical_trials_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp124'),
	@clinical_trials_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp126'),
	@clinical_trials_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp127'),
	@clinical_trials_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp137'),
	@clinical_trials_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp138'),
	@clinical_trials_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp148'),
	@clinical_trials_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp153'),
	@clinical_trials_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp155'),
	@clinical_trials_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp242'),
	@clinical_trials_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp259'),
	@clinical_trials_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp260'),
	@clinical_trials_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp261'),
	@clinical_trials_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp278'),
	@clinical_trials_response_category_id
);

-- insert PSVT Response Category Mappings
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp262'),
	@psvt_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp263'),
	@psvt_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp264'),
	@psvt_response_category_id
);

-- insert NODE-1 Response Category Mappings
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp105'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp139'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp140'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp142'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp146'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp147'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp163'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp176'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp181'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp186'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp188'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp190'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp258'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp265'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp266'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp267'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp268'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp269'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp270'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp271'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp272'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp273'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp274'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp275'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp276'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp277'),
	@node_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp279'),
	@node_response_category_id
);

-- insert Entripamil Response Category Mappings
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp101'),
	@etripamil_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp119'),
	@etripamil_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp140'),
	@etripamil_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp142'),
	@etripamil_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp147'),
	@etripamil_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp190'),
	@etripamil_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp258'),
	@etripamil_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp261'),
	@etripamil_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp263'),
	@etripamil_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp265'),
	@etripamil_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp267'),
	@etripamil_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp269'),
	@etripamil_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp271'),
	@etripamil_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp275'),
	@etripamil_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp279'),
	@etripamil_response_category_id
);

-- insert Placebo Response Category Mappings
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp104'),
	@placebo_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp107'),
	@placebo_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp139'),
	@placebo_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp258'),
	@placebo_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp259'),
	@placebo_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp261'),
	@placebo_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp263'),
	@placebo_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp267'),
	@placebo_response_category_id
);

-- insert Safety Response Category Mappings
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp140'),
	@safety_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp147'),
	@safety_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp163'),
	@safety_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp181'),
	@safety_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp260'),
	@safety_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp266'),
	@safety_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp267'),
	@safety_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp270'),
	@safety_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp271'),
	@safety_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp273'),
	@safety_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp274'),
	@safety_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp275'),
	@safety_response_category_id
);

-- insert Admin Response Category Mappings
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp001'),
	@admin_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp002'),
	@admin_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp003'),
	@admin_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp004'),
	@admin_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp005'),
	@admin_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp007'),
	@admin_response_category_id
);
INSERT INTO `master_response_response_category_map` (
	`response_id`,
	`response_category_id`
) VALUES (
	(SELECT `id` FROM `master_responses` WHERE `name` = 'msp008'),
	@admin_response_category_id
);
