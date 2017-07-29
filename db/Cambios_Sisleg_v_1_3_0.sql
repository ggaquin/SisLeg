
/* Tabla expedienteComision ************************************************************************************/
ALTER TABLE `sistema_legislativo`.`expedienteComision` 
ADD COLUMN `publicado` TINYINT(1) NOT NULL AFTER `idDictamen`;

ALTER TABLE `sistema_legislativo`.`expedienteComision` 
CHANGE COLUMN `fechaAsignacion` `fechaPublicacion` DATETIME NULL AFTER `publicado`,
CHANGE COLUMN `asignacionActual` `anulado` TINYINT(1) NOT NULL,
ADD COLUMN `usuarioCreacion` VARCHAR(70) NOT NULL AFTER `anulado`,
ADD COLUMN `fechaCreacion` DATETIME NOT NULL AFTER `usuarioCreacion`,
ADD COLUMN `usuarioModificacion` VARCHAR(70) NULL AFTER `fechaCreacion`,
ADD COLUMN `fechaModificacion` DATETIME NULL AFTER `usuarioModificacion`,
ADD COLUMN `expedienteComisioncol` VARCHAR(45) NULL AFTER `fechaModificacion`;

/****************************************************************************************************************/
 