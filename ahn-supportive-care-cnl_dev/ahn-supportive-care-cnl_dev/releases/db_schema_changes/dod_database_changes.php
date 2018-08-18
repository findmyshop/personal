<?php
/*

DROP TABLE master_accreditation_types;
DROP TABLE master_ranks;
DROP TABLE master_user_rank_map;
DROP TABLE master_credential_types;
DROP TABLE master_user_credential_map;
DROP TABLE master_departments;

CREATE TABLE `master_accreditation_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accreditation_type` varchar(45) NOT NULL,
  `order` int(11) DEFAULT '0',
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `index_accreditation_type` (`accreditation_type`)
) AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `master_accreditation_types` VALUES
	(1,'CE',0,1),
	(2,'CME',0,1),
	(3,'Social Work',0,1),
	(4,'APA',0,1),
	(5,'Not Seeking Accrediation',9999,1)
;


CREATE TABLE `master_accreditation_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accreditation_type` varchar(45) NOT NULL,
  `order` int(11) DEFAULT '0',
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `index_accreditation_type` (`accreditation_type`)
) AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;

INSERT INTO `master_accreditation_types` VALUES
	(1,'CE',0,1),
	(2,'CME',0,1),
	(3,'Social Work',0,1),
	(4,'APA',0,1),
	(5,'Not Seeking Accrediation',9999,1)
;

CREATE TABLE `master_departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(45) NOT NULL,
  `active` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `index_department_name` (`department_name`)
) AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;


INSERT INTO `master_departments` VALUES
	(1,'MedRespond',1),
	(2,'Army',1),
	(3,'Navy',1),
	(4,'Air Force',1),
	(5,'National Capital Region',1)
;

CREATE TABLE `user_department_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`department_id`)
) AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;

CREATE TABLE `master_pay_grades` (
	`id` int NOT NULL AUTO_INCREMENT,
	`pay_grade_name` varchar(32) NOT NULL,
	`pay_grade_type_id` int NOT NULL,
	`active` tinyint DEFAULT 1,
	PRIMARY KEY (`id`),
	INDEX  (`pay_grade_name`),
	INDEX  (`pay_grade_type_id`)
) AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;

INSERT INTO `master_pay_grades` VALUES
	(1,'Contractor',1,1),
	(2,'Government Civilian',2,1),
	(3,'E-1',3,1),(4,'E-2',3,1),
	(5,'E-3',3,1),
	(6,'E-4',3,1),
	(7,'E-5',3,1),
	(8,'E-6',3,1),
	(9,'E-7',3,1),
	(10,'E-8',3,1),
	(11,'E-9',3,1),
	(12,'O-1',3,1),
	(13,'O-2',3,1),
	(14,'O-3',3,1),
	(15,'O-4',3,1),
	(16,'O-5',3,1),
	(17,'O-6',3,1),
	(18,'O-7',3,1),
	(19,'O-8',3,1),
	(20,'O-9',3,1),
	(21,'O-10',3,1),
	(22,'W-1',3,1),
	(23,'W-2',3,1),
	(24,'W-3',3,1),
	(25,'W-4',3,1),
	(26,'W-5',3,1)
;

CREATE TABLE `master_pay_grade_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pay_grade_type_name` varchar(32) NOT NULL,
  `active` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `pay_grade_type_name` (`pay_grade_type_name`)
) AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;

INSERT INTO `master_pay_grade_types` VALUES
	(1,'Contractor',1),
	(2,'Government Civlilian',1),
	(3,'Military',1)
;

CREATE TABLE `master_user_pay_grade_map` (
	`id` int NOT NULL AUTO_INCREMENT,
	`user_id` int NOT NULL,
	`pay_grade_id` int NOT NULL,
	`active` tinyint DEFAULT 1,
	PRIMARY KEY (`id`),
	INDEX  (`user_id`, `pay_grade_id`) comment ''
) AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;

CREATE TABLE `master_roles` (
	`id` int NOT NULL AUTO_INCREMENT,
	`role_name` varchar(128) NOT NULL,
	`active` tinyint DEFAULT 1,
	PRIMARY KEY (`id`),
	INDEX  (`role_name`)
) AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;

INSERT INTO `master_roles` (master_roles.role_name) VALUES
	('Primary Care Manager: physician'),
	('Primary Care Manager: physician assistant'), 
	('Primary Care Manager: nurse practitioner'),
	('Internal Behavioral Health Consultant (IBHC): psychologist'), 
	('Internal Behavioral Health Consultant (IBHC): social worker'), 
	('Behavioral Health Care Facilitator (BHCF)'),
	('Medical Home Nurse (other than BHCF)'),
	('Nursing Assistant'),
	('Medical Assistant'), 
	('Corpsman/Medic'),
	('Medical Support Assistant'),
	('Medical Home Physician, Nurse Practitioner, or Physician Assistant (other than Primary Care Manager)'),
	('Pharmacist'),
	('Case Manager'),
	('Nutritionist'), 
	('Other PCMH staff'), 
	('External Behavioral Health Consultant (EBHC)'), 
	('Social Worker (other than IBHC)'),
	('Psychologist (other than IBHC or EBHC)'), 
	('Psychiatrist (other than EBHC)'),
	('Psychiatric nurse practitioner (other than EBHC)') 
;

CREATE TABLE `master_user_role_map` (
	`id` int NOT NULL AUTO_INCREMENT,
	`user_id` int NOT NULL,
	`role_id` int NOT NULL,
	`active` tinyint DEFAULT 1,
	PRIMARY KEY (`id`),
	INDEX  (`user_id`, `role_id`)
) AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;

CREATE TABLE `master_treatment_facilities` (
	`id` int NOT NULL AUTO_INCREMENT,
	`department_id` int NOT NULL,
	`country_id` int,
	`state_id` int,
	`base` varchar(64),
	`clinic` varchar(64),
	`region` varchar(64),
	`parent_command` varchar(64),
	`enrollment_site` varchar(64),
	`active` tinyint(1) DEFAULT 1,
	PRIMARY KEY (`id`),
	INDEX  (`department_id`),
	INDEX  (`country_id`),
	INDEX  (`state_id`),
	INDEX  (`base`),
	INDEX  (`clinic`),
	INDEX  (`region`),
	INDEX  (`parent_command`),
	INDEX  (`enrollment_site`)
) AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;

insert into `master_treatment_facilities` (
	master_treatment_facilities.department_id,
	master_treatment_facilities.country_id,
	master_treatment_facilities.state_id,
	master_treatment_facilities.base
) VALUES
(4, 230, 3, 'Maxwell Air Force Base'),
(4, 230, 4, 'Eielson Air Force Base'),
(4, 230, 4, 'Joint Base Elmendorf Richardson'),
(4, 230, 6, 'DavisÐMonthan Air Force Base'),
(4, 230, 6, 'Luke Air Force Base'),
(4, 230, 7, 'Little Rock Air Force Base'),
(4, 230, 9, 'Beale Air Force Base'),
(4, 230, 9, 'Edwards Air Force Base'),
(4, 230, 9, 'Los Angeles Air Force Base'),
(4, 230, 9, 'Travis Air Force Base'),
(4, 230, 9, 'Vandenberg Air Force Base'),
(4, 230, 10, 'Buckley Air Force Base'),
(4, 230, 10, 'Peterson Air Force Base'),
(4, 230, 10, 'United States Air Force Academy'),
(4, 230, 13, 'Dover Air Force Base'),
(4, 230, 12, 'Bolling Air Force Base'),
(4, 230, 14, 'Eglin Air Force Base'),
(4, 230, 14, 'Hurlburt Field'),
(4, 230, 14, 'MacDill Air Force Base'),
(4, 230, 14, 'Patrick Air Force Base'),
(4, 230, 14, 'Tyndall Air Force Base'),
(4, 230, 15, 'Moody Air Force Base'),
(4, 230, 15, 'Robins Air Force Base'),
(4, 230, 18, 'Joint Base Pearl Harbor Hickam'),
(4, 230, 19, 'Mountain Home Air Force Base'),
(4, 230, 20, 'Scott Air Force Base'),
(4, 230, 23, 'McConnell Air Force Base'),
(4, 230, 25, 'Barksdale Air Force Base'),
(4, 230, 27, 'Joint Base Andrews Naval Air Facility'),
(4, 230, 28, 'Hanscom Air Force Base'),
(4, 230, 31, 'Columbus Air Force Base'),
(4, 230, 31, 'Keesler Air Force Base'),
(4, 230, 32, 'Whiteman Air Force Base'),
(4, 230, 33, 'Malmstrom Air Force Base'),
(4, 230, 34, 'Offutt Air Force Base'),
(4, 230, 35, 'Nellis Air Force Base'),
(4, 230, 37, 'Joint Base McGuire-Dix-Lakehurst'),
(4, 230, 38, 'Cannon Air Force Base'),
(4, 230, 38, 'Holloman Air Force Base'),
(4, 230, 38, 'Kirtland Air Force Base'),
(4, 230, 40, 'Seymour Johnson Air Force Base'),
(4, 230, 41, 'Grand Forks Air Force Base'),
(4, 230, 41, 'Minot Air Force Base'),
(4, 230, 42, 'Wright-Patterson Air Force Base'),
(4, 230, 43, 'Tinker Air Force Base'),
(4, 230, 48, 'Charleston Air Force Base'),
(4, 230, 48, 'Shaw Air Force Base'),
(4, 230, 49, 'Ellsworth Air Force Base'),
(4, 230, 51, 'Dyess Air Force Base'),
(4, 230, 51, 'Goodfellow Air Force Base'),
(4, 230, 51, 'Lackland Air Force Base'),
(4, 230, 51, 'Laughlin Air Force Base'),
(4, 230, 51, 'Randolph Air Force Base'),
(4, 230, 51, 'Sheppard Air Force Base'),
(4, 230, 52, 'Hill Air Force Base'),
(4, 230, 54, 'Langley Air Force Base'),
(4, 230, 56, 'Fairchild Air Force Base'),
(4, 230, 56, 'JBLM McChord Field, Joint Base Lewis-McChord'),
(4, 230, 59, 'Francis E. Warren Air Force Base')
;

insert into `master_treatment_facilities` (
	master_treatment_facilities.department_id, 
	master_treatment_facilities.country_id,
	master_treatment_facilities.base
) VALUES
-- Germany
(4, 56, 'Ramstein Air Base'),
(4, 56, 'Spangdahlem Air Base'),
-- Guam
(4, 91, 'Andersen Air Force Base'),
-- Italy
(4, 109, 'Aviano Air Base'),
-- Japan
(4, 113, 'Kadena Air Base, Okinawa Prefecture'),
(4, 113, 'Misawa Air Base, Misawa, Aomori'),
(4, 113, 'Yokota Air Base, Tokyo'),
-- South Korea
(4, 121, 'Kunsan Air Base'),
(4, 121, 'Osan Air Base'),
-- United Kingdom
(4, 76, 'RAF Alconbury, Huntingdonshire'),
(4, 76, 'RAF Lakenheath, Brandon, Suffolk [2]')
;
insert into `master_treatment_facilities` (
	master_treatment_facilities.department_id, 
	master_treatment_facilities.country_id,
	master_treatment_facilities.base,
	master_treatment_facilities.clinic
) VALUES

(2, 230, 'Ft. Bragg', 'CLARK CLINIC'),
(2, 230, 'Ft. Bragg', 'FAYETTEVILLE CLINIC MEDICAL HOME'),
(2, 230, 'Ft. Bragg', 'HOPE MILLS CLINIC MEDICAL HOME'),
(2, 230, 'Ft. Bragg', 'IV'),
(2, 230, 'Ft. Bragg', 'JOEL CLINIC'),
(2, 230, 'Ft. Bragg', 'ROBINSON CLINIC (SMCH)'),
(2, 230, 'Ft. Bragg', 'TROOP & FAMILY MEDICAL CLINIC-BRAGG'),
(2, 230, 'Ft. Bragg', 'V'),
(2, 230, 'Ft. Bragg', 'WOMACK AMC'),
(2, 230, 'Ft. Bragg', 'WOMACK AMC - WFMR'),
(2, 230, 'Ft. Drum', 'GUTHRIE AHC'),
(2, 230, 'Ft. Drum', 'DRUM CTMC CONNOR (SCMH)'),
(2, 230, 'Ft. Knox', 'IRELAND ACH - MRC'),
(2, 230, 'Ft. Knox', 'Bullion'),
(2, 230, 'Ft. Knox', 'IRELAND ACH - Green, Yellow, Red, White, Blue Medical Homes (former IM/PEDS/FCC)'),
(2, 230, 'Ft. Lee', 'KENNER AHC'),
(2, 230, 'Ft. Lee', 'MOSIER'),
(2, 230, 'Ft. Lee', 'TMC#1'),
(2, 230, 'Ft. Meade', 'KIMBROUGH AMBULATORY CARE CENTER'),
(2, 230, 'Ft. Meade', 'ANDREW RADER AHC FMC'),
(2, 230, 'Ft. Meade', 'BARQUIST AHC'),
(2, 230, 'Ft. Meade', 'CARLISLE BARRACKS - PA'),
(2, 230, 'Ft. Meade', 'KIRK AHC'),
(2, 230, 'JB Langley-Eustis', 'MCDONALD AHC'),
(2, 230, 'JB Langley-Eustis', 'TMC-2-FT. EUSTIS'),
(2, 230, 'West Point', 'KELLER ACH'),
(2, 230, 'West Point', 'MOLOGNE TMC'),
(2, 230, 'Tripler AMC', 'FT SHAFTER'),
(2, 230, 'Tripler AMC', 'TRIPLER AMC - FPC'),
(2, 230, 'Tripler AMC', 'TRIPLER AMC - IM'),
(2, 230, 'Tripler AMC', 'WARRIOR OHANA MEDICAL HOME'),
(2, 230, 'Tripler AMC', 'SCHOFIELD BARRACKS - PEDS'),
(2, 230, 'Tripler AMC', 'SCHOFIELD BARRACKS-TMC'),
(2, 230, 'Tripler AMC', 'SCHOFIELD BARRACKS AHC - FPC'),
(2, 230, 'Ft. Benning', 'MARTIN APC'),
(2, 230, 'Ft. Benning', 'MARTIN - SLEDGEHAMMER 3/3BCT (SCMH)'),
(2, 230, 'Ft. Benning', 'MARTIN ACH - FP'),
(2, 230, 'Ft. Benning', 'CTMC 2-HARMONY CHURCH'),
(2, 230, 'Ft. Benning', 'NORTH COLUMBUS MEDICAL HOME (CBMH)'),
(2, 230, 'Ft. Benning', 'TMC-5'),
(2, 230, 'Ft. Benning', 'CTMC'),
(2, 230, 'Ft. Benning', 'WINDER FPC - FT BENNING'),
(2, 230, 'Ft. Benning', 'MARTIN ACH - PEDS'),
(2, 230, 'Ft. Campbell', 'BLANCHFIELD ACH'),
(2, 230, 'Ft. Campbell', 'BLANCHFIELD ACH - GOLD (IM)'),
(2, 230, 'Ft. Campbell', 'BLANCHFIELD ACH - AIR ASSAULT MH'),
(2, 230, 'Ft. Campbell', 'SCREAMING EAGLE MEDICAL HOME'),
(2, 230, 'Ft. Campbell', 'BYRD HEALTH CLINIC 101SB/EAD FORSCOM, 159 CAB'),
(2, 230, 'Ft. Campbell', 'LA POINTE HEALTH CLINIC 2/101, 3/101, 1/101 BCT (SCMH)'),
(2, 230, 'Ft. Campbell', 'BLANCHFIELD ACH - YOUNG EAGLE MH(Peds)'),
(2, 230, 'Ft. Gordon', 'EISENHOWER AMC - IM'),
(2, 230, 'Ft. Gordon', 'EISENHOWER AMC - FPC'),
(2, 230, 'Ft. Gordon', 'TMC-4 '),
(2, 230, 'Ft. Gordon', 'RODRIGUEZ AHC-FT. BUCHANAN'),
(2, 230, 'Ft. Gordon', 'SOUTHCOM CLINIC'),
(2, 230, 'Ft. Gordon', 'CONNELLY'),
(2, 230, 'Ft. Hood', 'DARNALL AMC '),
(2, 230, 'Ft. Hood', 'Internal Medicine'),
(2, 230, 'Ft. Hood', 'DARNALL AMC - FRMC'),
(2, 230, 'Ft. Hood', 'DARNALL - IM'),
(2, 230, 'Ft. Hood', 'BENNETT FCC'),
(2, 230, 'Ft. Hood', 'MONROE CONSOLIDATED-FT. HOOD  (SCMH)'),
(2, 230, 'Ft. Hood', 'HARKER HEIGHTS MED HOME'),
(2, 230, 'Ft. Hood', 'COPPERAS COVE MED HOME'),
(2, 230, 'Ft. Hood', 'CHARLES MOORE HEALTH CLINI'),
(2, 230, 'Ft. Hood', 'KILLEEN MEDICAL HOME'),
(2, 230, 'Ft. Hood', 'DARNALL AMC - PEDS'),
(2, 230, 'Ft. Hood', 'TMC-12-FT. HOOD 1 CAV CAB (SCMH)'),
(2, 230, 'Ft. Jackson', 'MONCRIEF ACH '),
(2, 230, 'Ft. Jackson', 'MONCRIEF MEDICAL HOME'),
(2, 230, 'Ft. Polk', 'BAYNE-JONES ACH - FPC'),
(2, 230, 'Ft. Polk', 'BAYNE-JONES ACH-FT. POLK CTMC'),
(2, 230, 'Ft. Polk', 'BAYNE-JONES ACH - PEDS'),
(2, 230, 'Ft. Rucker', 'LYSTER AHC - FPC'),
(2, 230, 'Ft. Sill', 'REYNOLDS ACH FM/less PEDS'),
(2, 230, 'Ft. Sill', 'REYNOLDS ACH - FIRES  (SCMH)'),
(2, 230, 'Ft. Sill', 'BLEAK (SCMH)'),
(2, 230, 'Ft. Stewart HAWKS', 'WINN ACH - FPC'),
(2, 230, 'Ft. Stewart HAWKS', 'RICHMOND HILL MEDICAL HOME - FT STEWART'),
(2, 230, 'Ft. Stewart HAWKS', 'TROOP MEDICAL CLINIC - FT. STEWART'),
(2, 230, 'Ft. Stewart HAWKS', 'TUTTLE AHC-HUNTER ARMY AIRFIELD 3CAB/3ID (SCMH)'),
(2, 230, 'Ft. Stewart HAWKS', 'WINN ACH - PEDS'),
(2, 230, 'JB San Antonio', 'BROOK AMC'),
(2, 230, 'JB San Antonio', 'BROOK FM'),
(2, 230, 'JB San Antonio', 'BROOKE AMC - IM'),
(2, 230, 'JB San Antonio', 'BROOKE AMC - TAYLOR BURK'),
(2, 230, 'JB San Antonio', 'SCHERTZ MEDICAL HOME'),
(2, 230, 'JB San Antonio', 'BROOKE AMC - PEDS'),
(2, 230, 'JB San Antonio', 'BROOKE AMC - ADOL'),
(2, 230, 'Redstone Arsenal', 'FOX ARMY HEALTH CENTER'),
(2, 230, 'Ft. Bliss', 'EAST BLISS CLINIC'),
(2, 230, 'Ft. Bliss', 'MENDOZA SOLDIER FAMILY CC - FPC'),
(2, 230, 'Ft. Bliss', 'MENDOZA SOLDIER FAMILY CC - SOLDIER CARE'),
(2, 230, 'Ft. Bliss', 'WILLIAM BEAUMONT AMC - IM'),
(2, 230, 'Ft. Bliss', 'RIO BRAVO MEDICAL HOME'),
(2, 230, 'Ft. Bliss', 'TMC MEDICAL EXAM STATION'),
(2, 230, 'Ft. Bliss', 'AHC MCAFEE (WBAMC WSMR)'),
(2, 230, 'Ft. Bliss', 'MENDOZA SOLDIER FAMILY CC - PEDS'),
(2, 230, 'Ft. Carson', 'EVANS WARRIOR'),
(2, 230, 'Ft. Carson', 'EVANS ACH - WARRIOR CLINIC'),
(2, 230, 'Ft. Carson', 'MOUNTAIN POST MEDICAL HOME'),
(2, 230, 'Ft. Carson', 'PREMIER ARMY HEALTH CLINIC'),
(2, 230, 'Ft. Carson', 'TMC 10  - FT. CARSON -ROBINSON FAMILY'),
(2, 230, 'Ft. Carson', 'ROBINSON HEALTH CLINIC (TMC 10)'),
(2, 230, 'Ft. Carson', 'TMC9'),
(2, 230, 'Ft. Carson', 'EVANS ACH - IM'),
(2, 230, 'Ft. Carson', 'EVANS - IRONHORSE FMC'),
(2, 230, 'Ft. Carson', 'EVANS - PEDS'),
(2, 230, 'Ft. Huachuca', 'R. W.  BLISS  AHC'),
(2, 230, 'Ft. Irwin', 'WEED ACH'),
(2, 230, 'Ft. Irwin', 'TMC 1 - FT. IRWIN'),
(2, 230, 'Ft. Leavenworth', 'MUNSON AHC'),
(2, 230, 'Ft. Leonard Wood', 'LEONARD WOOD ACH'),
(2, 230, 'Ft. Leonard Wood', 'OZARK MEDICAL HOME'),
(2, 230, 'Ft. Riley', 'AMH FARRELLY AHC (SCMH)'),
(2, 230, 'Ft. Riley', 'CUSTER HILL CTMC SCMH/PCMH '),
(2, 230, 'Ft. Riley', 'IRWIN ACH PC'),
(2, 230, 'Ft. Riley', 'JUNCTION CITY'),
(2, 230, 'Ft. Riley', 'IACH SCMH Ft Riley (Aviation Clinic)'),
(2, 230, 'Ft. Wainwright', 'BASSETT ACH'),
(2, 230, 'Ft. Wainwright', 'TMC FT. RICHARDSON'),
(2, 230, 'JB Lewis-McChord', '555 EN/17 FIB SOLDIER CARE MH'),
(2, 230, 'JB Lewis-McChord', 'OLYMPIA SOUTH SOUND'),
(2, 230, 'JB Lewis-McChord', 'MADIGAN AMC - FPC'),
(2, 230, 'JB Lewis-McChord', 'MADIGAN AMC - IM'),
(2, 230, 'JB Lewis-McChord', 'MADIGAN-PUYALLUP MEDICAL HOME'),
(2, 230, 'JB Lewis-McChord', 'MONTEREY AHC (MAMC POM)'),
(2, 230, 'JB Lewis-McChord', 'OKUBO FAMILY PRACTICE CLINIC - FMC'),
(2, 230, 'JB Lewis-McChord', 'WINDER FPC '),
(2, 230, 'JB Lewis-McChord', 'WINDER FMC'),
(2, 230, 'JB Lewis-McChord', '3/2 BCT - SCMH'),
(2, 230, 'JB Lewis-McChord', 'AVIATION SCMH-JBLM'),
(2, 230, 'JB Lewis-McChord', 'Madigan PEDS')
;

insert into `master_treatment_facilities` (
	master_treatment_facilities.department_id, 
	master_treatment_facilities.country_id,
	master_treatment_facilities.base,
	master_treatment_facilities.clinic
) VALUES

(2, 56, 'Landstuhl RMC', 'LANDSTUL REGIONAL MEDCEN'),
(2, 56, 'Landstuhl RMC', 'LANDSTUHL REGIONAL MEDCEN - FPC'),
(2, 56, 'Landstuhl RMC', 'AHC BAUMHOLDER'),
(2, 56, 'Landstuhl RMC', 'AHC KAISERSLAUTERN (Kleber)'),
(2, 56, 'Landstuhl RMC', 'AHC VICENZA'),
(2, 56, 'Landstuhl RMC', 'AHC WIESBADEN'),
(2, 56, 'Landstuhl RMC', 'AHC BRUSSELS'),
(2, 56, 'Landstuhl RMC', 'AHC LIVORNO'),
(2, 56, 'Landstuhl RMC', 'AHC SHAPE'),
(2, 56, 'Landstuhl RMC', 'Bavaria MEDDAC'),
(2, 56, 'Bavaria MEDDAC', 'AHC GRAFENWOEHR'),
(2, 56, 'Bavaria MEDDAC', 'AHC HONENFELS'),
(2, 56, 'Bavaria MEDDAC', 'AHC KATTERBACH'),
(2, 56, 'Bavaria MEDDAC', 'AHC PATCH BKS (Stuttgart)'),
(2, 56, 'Bavaria MEDDAC', 'AHC VILSECK'),
(2, 56, 'Bavaria MEDDAC', 'AHC ILLESHEIM'),
(2, 113, 'Japan', 'BG CRAWFORD F. SAMS USAHC-CAMP ZAMA'),
(2, 121, 'Seoul', '65th Medical Bridge Korea'),
(2, 121, 'Seoul', 'CAMP CARROL'),
(2, 121, 'Seoul', 'CAMP CASEY'),
(2, 121, 'Seoul', 'CAMP HUMPHREYS'),
(2, 121, 'Seoul', 'CAMP WALKER'),
(2, 121, 'Seoul', 'YONGSAN'),
(2, 121, 'Seoul', 'BRIAN ALLGOOD ACH')
;
insert into `master_treatment_facilities` (
	master_treatment_facilities.department_id, 
	master_treatment_facilities.country_id,
	master_treatment_facilities.region,
	master_treatment_facilities.parent_command,
	master_treatment_facilities.enrollment_site
) VALUES

(3, 230, 'NAVMED_W', 'NMC SAN DIEGO', 'NBHC NAS NORTH ISLAND'),
(3, 230, 'NAVMED_W', 'NMC SAN DIEGO', 'NORTH ISLAND FCMH'),
(3, 230, 'NAVMED_W', 'NMC SAN DIEGO', 'NBHC NTC SAN DIEGO'),
(3, 230, 'NAVMED_W', 'NMC SAN DIEGO', 'TRICARE OUTPATIENT-CHULA VISTA'),
(3, 230, 'NAVMED_W', 'NMC SAN DIEGO', 'NEW CLINIC - EAST LAKE'),
(3, 230, 'NAVMED_W', 'NMC SAN DIEGO', 'BMC MCAS MIRAMAR '),
(3, 230, 'NAVMED_W', 'NMC SAN DIEGO', 'BMC MCAS MIRAMAR MCMH'),
(3, 230, 'NAVMED_W', 'NMC SAN DIEGO', 'TRICARE OUTPATIENT-CLAIRMONT- Kearney Mesa'),
(3, 230, 'NAVMED_W', 'NMC SAN DIEGO', 'NEW CLINIC - RANCHO BERNADO'),
(3, 230, 'NAVMED_W', 'NMC SAN DIEGO', 'NBHC NAVSTA SAN DIEGO'),
(3, 230, 'NAVMED_W', 'NMC SAN DIEGO', 'NMC SAN DIEGO - Internal Medicine'),
(3, 230, 'NAVMED_W', 'NMC SAN DIEGO', 'NMC SAN DIEGO - Military Health Center'),
(3, 230, 'NAVMED_W', 'NH BREMERTON', 'NH BREMERTON - Family Med'),
(3, 230, 'NAVMED_W', 'NH BREMERTON', 'NH BREMERTON - Internal Med'),
(3, 230, 'NAVMED_W', 'NH CAMP PENDLETON', 'NBHC PORT HUENEME'),
(3, 230, 'NAVMED_W', 'NH CAMP PENDLETON', 'NH CAMP PENDLETON Fam Med'),
(3, 230, 'NAVMED_W', 'NH CAMP PENDLETON', 'NH CAMP PENDLETON  Internal Medicine'),
(3, 230, 'NAVMED_W', 'NH CAMP PENDLETON', 'BMC YUMA'),
(3, 230, 'NAVMED_W', 'NH CAMP PENDLETON', 'MCMH/ Area 62'),
(3, 230, 'NAVMED_W', 'NH CAMP PENDLETON', '21 Area MCMH'),
(3, 230, 'NAVMED_W', 'NH CAMP PENDLETON', '43 Area MCMH'),
(3, 230, 'NAVMED_W', 'NH CAMP PENDLETON', '22 Area MCMH'),
(3, 230, 'NAVMED_W', 'NH CAMP PENDLETON', '33 Area MCMH'),
(3, 230, 'NAVMED_W', 'NH CAMP PENDLETON', '53 Area MCMH'),
(3, 230, 'NAVMED_W', 'NH CAMP PENDLETON', 'YUMA MCMH'),
(3, 230, 'NAVMED_W', 'NH CAMP PENDLETON', 'Area 41'),
(3, 230, 'NAVMED_W', 'NH OAK HARBOR', 'NH OAK HARBOR'),
(3, 230, 'NAVMED_W', 'NH OAK HARBOR', 'Oak Harbor FCMH'),
(3, 230, 'NAVMED_W', 'NH LEMOORE', 'NH LEMOORE'),
(3, 230, 'NAVMED_W', 'NH TWENTYNINE PALMS', 'NH TWENTYNINE PALMS'),

(3, 230, 'NAVMED_E', 'NMC PORTSMOUTH', 'NMC PORTSMOUTH Family Med'),
(3, 230, 'NAVMED_E', 'NMC PORTSMOUTH', 'NMC PORTSMOUTH Internal Med Med'),
(3, 230, 'NAVMED_E', 'NMC PORTSMOUTH', 'NBHC NAVSTA SEWELLS'),
(3, 230, 'NAVMED_E', 'NMC PORTSMOUTH', 'NBHC LITTLE CREEK/BOONE'),
(3, 230, 'NAVMED_E', 'NMC PORTSMOUTH', 'NBHC DAM NECK'),
(3, 230, 'NAVMED_E', 'NMC PORTSMOUTH', 'NBHC OCEANA'),
(3, 230, 'NAVMED_E', 'NMC PORTSMOUTH', 'TRICARE OUTPATIENT CHESAPEAKE'),
(3, 230, 'NAVMED_E', 'NMC PORTSMOUTH', 'TRICARE OUTPATIENT CL VA BEACH'),
(3, 230, 'NAVMED_E', 'NH JACKSONVILLE', 'NH JACKSONVILLE Family med'),
(3, 230, 'NAVMED_E', 'NH JACKSONVILLE', 'NH JAX Internal Med'),
(3, 230, 'NAVMED_E', 'NH JACKSONVILLE', 'NBHC jacksonville'),
(3, 230, 'NAVMED_E', 'NH JACKSONVILLE', 'NBHC MAYPORT'),
(3, 230, 'NAVMED_E', 'NH JACKSONVILLE', 'NBHC KINGS BAY'),
(3, 230, 'NAVMED_E', 'NH PENSACOLA', 'NBHC NATTC PENSACOLA'),
(3, 230, 'NAVMED_E', 'NH PENSACOLA', 'NH PENSACOLA'),
(3, 230, 'NAVMED_E', 'NH PENSACOLA', 'NBHC GULFPORT'),
(3, 230, 'NAVMED_E', 'NH PENSACOLA', 'NBHC NAS BELLE CHASE'),
(3, 230, 'NAVMED_E', 'NH PENSACOLA', 'NBHC NAS PENSACOLA '),
(3, 230, 'NAVMED_E', 'NH PENSACOLA', 'NBHC NSA MID-SOUTH'),
(3, 230, 'NAVMED_E', 'NH PENSACOLA', 'NBHC MILTON WHITING FIELD'),
(3, 230, 'NAVMED_E', 'NACC NEW ENGLAND', 'NACC NEW ENGLAND'),
(3, 230, 'NAVMED_E', 'NACC NEW ENGLAND', 'NBHC GROTON'),
(3, 230, 'NAVMED_E', 'NH CAMP LEJEUNE', 'NH CAMP LEJEUNE'),
(3, 230, 'NAVMED_E', 'NH CAMP LEJEUNE', 'MCMH FRENCH CREEK'),
(3, 230, 'NAVMED_E', 'NH CAMP LEJEUNE', 'Courthouse Bay MCMH'),
(3, 230, 'NAVMED_E', 'NH CAMP LEJEUNE', 'New River MCMH'),
(3, 230, 'NAVMED_E', 'NH CAMP LEJEUNE', 'Hadnot Point MCMH'),
(3, 230, 'NAVMED_E', 'NH CHERRY POINT', 'NH CHERRY POINT'),
(3, 230, 'NAVMED_E', 'NH CHERRY POINT', 'MCMH CHERRY POINT'),
(3, 230, 'NAVMED_E', 'NH GREAT LAKES', 'NH GREAT LAKES'),
(3, 230, 'NAVMED_E', 'NH BEAUFORT', 'NH BEAUFORT'),
(3, 230, 'NAVMED_E', 'NH BEAUFORT', 'Beaufort MCMH at Air Station'),
(3, 230, 'NAVMED_E', 'NH BEAUFORT', 'Parris Island'),
(3, 230, 'NAVMED_E', 'NH CHARLESTON', 'NH CHARLESTON'),
(3, 230, 'NAVMED_E', 'NH GUANTANAMO BAY', 'NH GUANTANAMO BAY'),
(3, 230, 'NAVMED_E', 'NH CORPUS CHRISTI', 'NH CORPUS CHRISTI'),
(3, 230, 'NAVMED_E', 'NHC QUANTICO', 'NHC QUANTICO'),
(3, 230, 'NAVMED_E', 'NHC QUANTICO', 'NBHC WASHINGTON NAVY YARD'),
(3, 230, 'NAVMED_E', 'NHC PATUXENT RIVER', 'NHC PATUXENT RIVER'),
(3, 230, 'NAVMED_E', 'NHC ANNAPOLIS', 'NHC ANNAPOLIS')
;
insert into `master_treatment_facilities` (
	master_treatment_facilities.department_id, 
	master_treatment_facilities.country_id,
	master_treatment_facilities.region,
	master_treatment_facilities.parent_command,
	master_treatment_facilities.enrollment_site
) VALUES

(3, 113, 'NAVMED_W', 'NH OKINAWA', 'BMC CAMP KINSER MCMH'),
(3, 113, 'NAVMED_W', 'NH OKINAWA', 'BMC CAMP BUSH/COURTNEY'),
(3, 113, 'NAVMED_W', 'NH OKINAWA', 'NH OKINAWA FMP'),
(3, 113, 'NAVMED_W', 'NH OKINAWA', 'NH OKINAWA IMC'),
(3, 113, 'NAVMED_W', 'NH OKINAWA', 'MCMH HANSEN'),
(3, 113, 'NAVMED_W', 'NH OKINAWA', 'Foster MCMH'),
(3, 113, 'NAVMED_W', 'NH OKINAWA', 'Courtney MCMH'),
(3, 113, 'NAVMED_W', 'NH OKINAWA', 'Schwab MCMH'),
(3, 113, 'NAVMED_W', 'NH OKINAWA', 'Futenma MCMH'),
(3, 230, 'NAVMED_W', 'NHC HAWAII', 'BMC MCAS KANEOHE BAY'),
(3, 230, 'NAVMED_W', 'NHC HAWAII', 'NHC HAWAII'),
(3, 91, 'NAVMED_W', 'NH GUAM-AGANA', 'NH GUAM-AGANA'),
(3, 113, 'NAVMED_W', 'NH YOKOSUKA', 'BMC IWAKUNI'),
(3, 113, 'NAVMED_W', 'NH YOKOSUKA', 'NBHC COMFLEACT SASEBO'),
(3, 113, 'NAVMED_W', 'NH YOKOSUKA', 'NBHC NAF ATSUGI'),
(3, 113, 'NAVMED_W', 'NH YOKOSUKA', 'NH YOKOSUKA'),
(3, 113, 'NAVMED_W', 'NH YOKOSUKA', 'Iwakuni MCMH'),
(3, 67, 'NAVMED_E', 'NH ROTA', 'NH ROTA'),
(3, 109, 'NAVMED_E', 'NH SIGONELLA', 'NH SIGONELLA'),
(3, 109, 'NAVMED_E', 'NH SIGONELLA', 'NBHC NSA BAHRAIN')
;

insert into `master_treatment_facilities` (
	master_treatment_facilities.department_id, 
	master_treatment_facilities.country_id,
	master_treatment_facilities.clinic
) VALUES
(5, 230, 'Walter Reed National Military Medical Center'),
(5, 230, 'Fort Belvoir Community Hospital'),
(5, 230, 'DiLorenzo Tricare Health Clinic'),
(5, 230, 'Fairfax Health Clinic'),
(5, 230, 'Dumfries Health Clinic')
;

-- update master_treatment_facilities set master_treatment_facilities.country_id=230 where master_treatment_facilities.country_id=130

CREATE TABLE `master_user_treatment_facility_map` (
	`id` int NOT NULL AUTO_INCREMENT,
	`user_id` int NOT NULL,
	`treatment_facility_id` int NOT NULL,
	`active` tinyint DEFAULT 1,
	PRIMARY KEY (`id`),
	INDEX  (`user_id`, `treament_facility_id`)
) AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;

CREATE TABLE `master_addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address_1` varchar(128) NOT NULL,
  `address_2` varchar(128) NOT NULL,
  `city` varchar(128) NOT NULL,
  `state_id` int(11) DEFAULT NULL,
  `province` varchar(64) DEFAULT NULL,
  `zip` varchar(10) NOT NULL,
  `country_id` int(2) NOT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `city` (`city`),
  KEY `state_id` (`state_id`),
  KEY `province` (`province`),
  KEY `zip` (`zip`),
  KEY `country_id` (`country_id`)
) AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;

ALTER TABLE master_addresses
	CHANGE COLUMN `state_id` `state_id` int(11),
	ADD COLUMN `province` varchar(64) AFTER `state_id`,
	CHANGE COLUMN `zip` `zip` varchar(10) NOT NULL AFTER `province`,
	CHANGE COLUMN `country_id` `country_id` int(2) NOT NULL AFTER `zip`,
	CHANGE COLUMN `active` `active` tinyint(1) DEFAULT 1 AFTER `country_id`,
	ADD INDEX  (`city`) comment '', ADD INDEX  (`state_id`) comment '',
	ADD INDEX  (`province`) comment '', ADD INDEX  (`zip`) comment '',
	ADD INDEX  (`country_id`) comment ''
;

CREATE TABLE `master_user_address_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `address_type_id` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`address_id`,`address_type_id`)
) AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;

CREATE TABLE `master_states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `abbreviation` varchar(2) NOT NULL,
  `name` varchar(32) NOT NULL,
  `active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `abbreviation` (`abbreviation`),
  KEY `name` (`name`)
) AUTO_INCREMENT=0 DEFAULT CHARSET=utf8
;

INSERT INTO `master_states` VALUES (1,'AA','U.S. Armed Forces Ð Americas',1),(2,'AE','U.S. Armed Forces Ð Europe',1),(3,'AL','Alabama',1),(4,'AK','Alaska',1),(5,'AP','U.S. Armed Forces Ð Pacific',1),(6,'AZ','Arizona',1),(7,'AR','Arkansas',1),(8,'AS','American Samoa',1),(9,'CA','California',1),(10,'CO','Colorado',1),(11,'CT','Connecticut',1),(12,'DC','District of Columbia',1),(13,'DE','Delaware',1),(14,'FL','Florida',1),(15,'GA','Georgia',1),(16,'GU','Guam',1),(17,'MP','Northern Mariana Islands',1),(18,'HI','Hawaii',1),(19,'ID','Idaho',1),(20,'IL','Illinois',1),(21,'IN','Indiana',1),(22,'IA','Iowa',1),(23,'KS','Kansas',1),(24,'KY','Kentucky',1),(25,'LA','Louisiana',1),(26,'ME','Maine',1),(27,'MD','Maryland',1),(28,'MA','Massachusetts',1),(29,'MI','Michigan',1),(30,'MN','Minnesota',1),(31,'MS','Mississippi',1),(32,'MO','Missouri',1),(33,'MT','Montana',1),(34,'NE','Nebraska',1),(35,'NV','Nevada',1),(36,'NH','New Hampshire',1),(37,'NJ','New Jersey',1),(38,'NM','New Mexico',1),(39,'NY','New York',1),(40,'NC','North Carolina',1),(41,'ND','North Dakota',1),(42,'OH','Ohio',1),(43,'OK','Oklahoma',1),(44,'OR','Oregon',1),(45,'PA','Pennsylvania',1),(46,'PR','Puerto Rico',1),(47,'RI','Rhode Island',1),(48,'SC','South Carolina',1),(49,'SD','South Dakota',1),(50,'TN','Tennessee',1),(51,'TX','Texas',1),(52,'UT','Utah',1),(53,'VT','Vermont',1),(54,'VA','Virginia',1),(55,'VI','Virgin Islands',1),(56,'WA','Washington',1),(57,'WV','West Virginia',1),(58,'WI','Wisconsin',1),(59,'WY','Wyoming',1),(60,'DC','District of Columbia',1)
;



*/