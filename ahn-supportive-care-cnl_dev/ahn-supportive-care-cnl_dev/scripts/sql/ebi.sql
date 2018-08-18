-- add third_party_id column to master_organization_hierarchy_level_elements table
ALTER TABLE `master_organization_hierarchy_level_elements` ADD COLUMN `third_party_id` VARCHAR(128) NULL DEFAULT NULL AFTER `id`;

