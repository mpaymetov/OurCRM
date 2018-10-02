ALTER TABLE `ourcrm`.`serviceset` 
ADD COLUMN `is_open` TINYINT NOT NULL DEFAULT '1' AFTER `version`;