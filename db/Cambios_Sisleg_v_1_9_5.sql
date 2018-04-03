ALTER TABLE `tipoAutoridad` 
CHANGE COLUMN `tipoAutoridad` `tipoAutoridad` VARCHAR(15) NOT NULL ;

INSERT INTO `tipoAutoridad` (`tipoAutoridad`) VALUES ('vice presidente');

ALTER TABLE `sancion` 
ADD COLUMN `firmaVicePresidente` INT NULL DEFAULT NULL AFTER `firmaPresidente`;
