
-- SQL to be run on the dod sites

-- add organization_id column to master_roles
ALTER TABLE `master_roles` ADD COLUMN `organization_id` INT(11) UNSIGNED NOT NULL AFTER `id`;

-- set the organization id for dod AlcoholSBIRT master_roles entries
update master_roles set organization_id = (select id from master_organizations where name = 'Department of Defense');

-- add organization_id column to master_accreditation_types
ALTER TABLE `master_accreditation_types` ADD COLUMN `organization_id` INT(11) UNSIGNED NOT NULL AFTER `id`;

-- set the organization id for dod AlcoholSBIRT master_accreditation_types entries
update master_accreditation_types set organization_id = (select id from master_organizations where name = 'Department of Defense');

