#version 1.4.0-dev

ALTER TABLE `sistema_legislativo`.`proyecto` 
DROP FOREIGN KEY `fk_proyecto_proyectoRevision`;

ALTER TABLE `sistema_legislativo`.`proyecto` 
DROP COLUMN `idUltimaRevision`,
ADD COLUMN `idConcejal` INT NULL AFTER `idTipoProyecto`,
ADD COLUMN `clavesBusqueda` VARCHAR(120) NOT NULL AFTER `idConcejal`,
ADD INDEX `proyecto_concejal_idx` (`idConcejal` ASC),
DROP INDEX `UNIQ_proyecto_ultimaRevision_idx` ;

ALTER TABLE `sistema_legislativo`.`proyecto` 
ADD CONSTRAINT `fk_proyecto_concejal`
  FOREIGN KEY (`idConcejal`)
  REFERENCES `sistema_legislativo`.`perfil` (`idPerfil`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
DROP TABLE `sistema_legislativo`.`legisladores_proyectos`;

DELETE FROM `sistema_legislativo`.`proyecto`;

INSERT INTO `sistema_legislativo`.`tipoExpediente` (`tipoExpediente`, `letra`) VALUES ('Poder Ejecutivo B)', 'D');
UPDATE `sistema_legislativo`.`tipoExpediente` SET `tipoExpediente`='Poder Ejecutivo A)' WHERE `idTipoExpediente`='4';

ALTER TABLE `sistema_legislativo`.`expedienteComision` 
DROP COLUMN `publicado`;

ALTER TABLE `sistema_legislativo`.`tipoSesion` 
CHANGE COLUMN `abreviacion` `abreviacion` VARCHAR(2) NOT NULL ;

INSERT INTO `sistema_legislativo`.`tipoSesion` (`tipoSesion`, `abreviacion`) VALUES ('Especial', 'ES');

ALTER TABLE `sistema_legislativo`.`expedienteComision` 
ADD COLUMN `idMovimiento` INT NULL AFTER `idSesion`,
ADD INDEX `expedienteComision_movimiento_idx` (`idMovimiento` ASC);

ALTER TABLE `sistema_legislativo`.`expedienteComision` 
ADD CONSTRAINT `fk_expedienteComision_movimiento`
  FOREIGN KEY (`idMovimiento`)
  REFERENCES `sistema_legislativo`.`movimiento` (`idMovimiento`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
 CREATE TABLE `estadoExpedienteSesion` (
  `idEstadoExpedienteSesion` smallint(6) NOT NULL AUTO_INCREMENT,
  `estadoExpedienteSesion` varchar(45) NOT NULL,
  PRIMARY KEY (`idEstadoExpedienteSesion`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4; 
  
CREATE TABLE `expedienteSesion` (
  `idExpedienteSesion` int(11) NOT NULL AUTO_INCREMENT,
  `ordenSesion` tinyint(4) DEFAULT NULL,
  `discriminador` varchar(5) DEFAULT NULL,
  `idExpediente` int(11) DEFAULT NULL,
  `idSesion` int(11) DEFAULT NULL,
  `idEstadoExpedienteSesion` smallint(6) DEFAULT NULL,
  `aFavor` smallint(6) NOT NULL DEFAULT '0',
  `enContra` smallint(6) NOT NULL DEFAULT '0',
  `abstenciones` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idExpedienteSesion`),
  KEY `expedienteSesion_estadoExpedienteSesion_idx` (`idEstadoExpedienteSesion`),
  KEY `expedienteSesion_sesion_idx` (`idSesion`),
  KEY `expedienteSesion_expediente_idx` (`idExpediente`),
  CONSTRAINT `fk_expedienteSesion_estadoExpedienteSesion` FOREIGN KEY (`idEstadoExpedienteSesion`) REFERENCES `estadoExpedienteSesion` (`idEstadoExpedienteSesion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedienteSesion_expediente` FOREIGN KEY (`idExpediente`) REFERENCES `expediente` (`idExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedienteSesion_sesion` FOREIGN KEY (`idSesion`) REFERENCES `sesion` (`idSesion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE `sistema_legislativo`.`agendaSesion`;

DROP TABLE `sistema_legislativo`.`estadoAgendaSesion`;

DROP table `sistema_legislativo`.`proyectoFirma`



