
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

/* Tabla Dictamen ***********************************************************************************************/
ALTER TABLE `sistema_legislativo`.`dictamen` 
ADD COLUMN `discriminador` VARCHAR(15) NOT NULL COMMENT 'los valores posibles son basico | articulado' AFTER `idDictamen`,
ADD COLUMN `textoLibre` LONGTEXT NOT NULL AFTER `usuarioCreacion`,
ADD COLUMN `idTipoDictamen` SMALLINT NULL DEFAULT NULL AFTER `textoLibre`,
ADD COLUMN `textoArticulado` LONGTEXT NULL COMMENT 'dictamen articulado' AFTER `idTipoDictamen`;
ADD INDEX  `dictamen_tipoProyecto_idx` (`idTipoDictamen` ASC);

ALTER TABLE `sistema_legislativo`.`dictamen` 
ADD CONSTRAINT `fk_dictamen_tipoProyecto`
  FOREIGN KEY (`idTipoDictamen`)
  REFERENCES `sistema_legislativo`.`tipoProyecto` (`idTipoProyecto`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
/****************************************************************************************************************/
 
/* Tabla Tipo Dictamen *******************************************************************************************/
ALTER TABLE `sistema_legislativo`.`tipoDictamen` 
CHANGE COLUMN `idTipoDictamen` `idTipoNumeroDictamen` SMALLINT(6) NOT NULL AUTO_INCREMENT ,
CHANGE COLUMN `tipoDictamen` `tipoNumeroDictamen` VARCHAR(45) NOT NULL , 
RENAME TO  `sistema_legislativo`.`tipoNumeroDictamen` ;
/****************************************************************************************************************/

/* Tabla Dictamen ***********************************************************************************************/
ALTER TABLE `sistema_legislativo`.`dictamen` 
DROP FOREIGN KEY `fk_dictamen_tipoDictamen`;

ALTER TABLE `sistema_legislativo`.`dictamen` 
CHANGE COLUMN `idTipoDictamen` `idTipoNumeroDictamen` SMALLINT(6) NULL DEFAULT NULL ,
DROP INDEX `dictamen_tipoDictamen_idx` ,
ADD INDEX `dictamen_tipoNumeroDictamen_idx` (`idTipoNumeroDictamen` ASC);

ALTER TABLE `sistema_legislativo`.`dictamen` 
ADD CONSTRAINT `fk_dictamen_tipoNumeroDictamen`
  FOREIGN KEY (`idTipoNumeroDictamen`)
  REFERENCES `sistema_legislativo`.`tipoNumeroDictamen` (`idTipoNumeroDictamen`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
/****************************************************************************************************************/

