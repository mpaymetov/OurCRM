ALTER TABLE `ourcrm`.`project` 
ADD COLUMN `creation_date` DATE NULL AFTER `version`;


ALTER TABLE `ourcrm`.`serviceset` 
ADD COLUMN `creation_date` DATE NULL AFTER `is_open`,
ADD COLUMN `close_date` DATE NULL AFTER `creation_date`,
ADD COLUMN `prev_state` BIGINT(11) NULL AFTER `close_date`;