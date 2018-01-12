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
ADD CONSTRAINT `FK_expedienteComision_sesion` FOREIGN KEY (`idSesion`) REFERENCES `sesion` (`idSesion`);

ALTER TABLE `sistema_legislativo`.`expedienteComision` 
ADD CONSTRAINT `fk_expedienteComision_movimiento`
  FOREIGN KEY (`idMovimiento`)
  REFERENCES `sistema_legislativo`.`movimiento` (`idMovimiento`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
ALTER TABLE `sistema_legislativo`.`expediente`
ADD CONSTRAINT `FK_expediente_sesion` FOREIGN KEY (`idSesion`) REFERENCES `sesion` (`idSesion`);

ALTER TABLE `sistema_legislativo`.`movimiento` CHANGE `fojas` `fojas` SMALLINT DEFAULT NULL;
  
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

DROP table `sistema_legislativo`.`proyectoFirma`;

#1.5.0-dev

CREATE TABLE `tipoExpedienteSesion` (
  `idTipoExpedienteSesion` INT(11) NOT NULL AUTO_INCREMENT,
  `tipoExpedienteSesion` VARCHAR(70) NOT NULL,
  `letra` VARCHAR(2) NOT NULL,
  PRIMARY KEY (`idTipoExpedienteSesion`));
  
INSERT INTO `tipoExpedienteSesion` (`tipoExpedienteSesion`, `letra`) 
VALUES ('Mensajes del Departamento Ejecutivo', 'A'),('Mensajes del Departamento Ejecutivo Girado a Comisiones', 'B'),
('Comunicaciones y REsoluciones', 'C'),('Expedientes con Respuesta del Departamento Ejecutivo', 'CH'),
('Ordenanzas', 'D'),('Peticiones Particulares', 'E'),('Presupesto y Hacienda', 'F'),('Obras Publicas y Urbanismo', 'G'),
('Servicios Publicos', 'H'), ('Derechos y Garantias', 'K'),('Labor Legislativa', 'L'),
('Industria y Comercio Interior y Exterior', 'M'),('Habitat, Tierrras y Viviendas', 'N'),
('Medios de Comunicación Social', 'O'),('Seguridad y Justicia', 'p'),('Mujeres y Equidad de Genero', 'Q'),
('Cultura y Educación ', 'R'),('Promocion de la Comunidad', 'S'),('Defensa del Usuario', 'T'),
('Planeamiento', 'W'),('Interpretacion y Reglamento', 'X'),('Ecología y Protección del Medio Ambiente', 'Y'),('Dictamen Conjunto', 'Z');


ALTER TABLE `expedienteSesion` 
CHANGE COLUMN `discriminador` `idTipoExpedienteSesion` INT NULL DEFAULT NULL ,
ADD COLUMN `texto` LONGTEXT NOT NULL AFTER `idEstadoExpedienteSesion`;

ALTER TABLE `expedienteSesion` 
ADD INDEX `expedienteSesion_tipoExpedienteSesion_idx` (`idTipoExpedienteSesion` ASC);

ALTER TABLE `expedienteSesion` 
ADD CONSTRAINT `fk_expedienteSesion_tipoExpedienteSesion`
  FOREIGN KEY (`idTipoExpedienteSesion`)
  REFERENCES `tipoExpedienteSesion` (`idTipoExpedienteSesion`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
ALTER TABLE `comision` 
ADD COLUMN `letraOrdenDelDia` VARCHAR(2) NULL AFTER `comision`;

UPDATE `comision` SET `letraOrdenDelDia`='T' WHERE `idComision`='1';
UPDATE `comision` SET `letraOrdenDelDia`='S' WHERE `idComision`='2';
UPDATE `comision` SET `letraOrdenDelDia`='P' WHERE `idComision`='3';
UPDATE `comision` SET `letraOrdenDelDia`='Q' WHERE `idComision`='4';
UPDATE `comision` SET `letraOrdenDelDia`='F' WHERE `idComision`='5';
UPDATE `comision` SET `letraOrdenDelDia`='K' WHERE `idComision`='6';
UPDATE `comision` SET `letraOrdenDelDia`='X' WHERE `idComision`='7';
UPDATE `comision` SET `letraOrdenDelDia`='W' WHERE `idComision`='9';
UPDATE `comision` SET `letraOrdenDelDia`='Y' WHERE `idComision`='10';
UPDATE `comision` SET `letraOrdenDelDia`='G' WHERE `idComision`='11';
UPDATE `comision` SET `letraOrdenDelDia`='H' WHERE `idComision`='12';
UPDATE `comision` SET `letraOrdenDelDia`='R' WHERE `idComision`='14';
UPDATE `comision` SET `letraOrdenDelDia`='M' WHERE `idComision`='15';
UPDATE `comision` SET `letraOrdenDelDia`='O' WHERE `idComision`='16';
UPDATE `comision` SET `comision`='Labor Legislativa', `letraOrdenDelDia`='L' WHERE `idComision`='13';
UPDATE `comision` SET `comision`='Habitat, Tierras y Viendas', `letraOrdenDelDia`='N' WHERE `idComision`='8';

ALTER TABLE `comision` 
CHANGE COLUMN `letraOrdenDelDia` `letraOrdenDelDia` VARCHAR(2) NOT NULL ;

ALTER TABLE `dictamen` 
ADD COLUMN `idSesion` INT NULL AFTER `idDictamen`,
ADD INDEX `dictamen_sesion_idx` (`idSesion` ASC);

ALTER TABLE `dictamen` 
ADD CONSTRAINT `fk_dictamen_sesion`
  FOREIGN KEY (`idSesion`)
  REFERENCES `sistema_legislativo`.`sesion` (`idSesion`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
  
update 	dictamen d
left 
join	expedienteComision ecM
on		ecM.idDictamenMayoria=d.idDictamen
left 
join	expedienteComision ecPm
on		ecPm.idDictamenPrimeraMinoria=d.idDictamen
left 
join	expedienteComision ecSm
on		ecSm.idDictamenSegundaMinoria=d.idDictamen
set		d.idSesion=case when ecM.idDictamenMayoria is not null then ecM.idSesion
					  when ecPm.idDictamenPrimeraMinoria is not null then ecPm.idSesion
                      else ecPm.idSesion
				 end;
                 
ALTER TABLE `expedienteComision` 
DROP FOREIGN KEY `fk_expedienteComision_sesion`;

ALTER TABLE `expedienteComision` 
DROP INDEX `expedienteComision_sesion_idx`;

ALTER TABLE `expedienteComision` 
DROP COLUMN `idSesion`;

CREATE TABLE `expedienteComision_dictamenesMayoria` (
  `idexpedienteComision` INT NOT NULL,
  `idDictamen` INT NOT NULL,
  PRIMARY KEY (`idExpedienteComision`, `idDictamen`));

CREATE TABLE `expedienteComision_dictamenesPrimeraMinoria` (
  `idexpedienteComision` INT NOT NULL,
  `idDictamen` INT NOT NULL,
  PRIMARY KEY (`idExpedienteComision`, `idDictamen`));
  
CREATE TABLE `expedienteComision_dictamenesSegundaMinoria` (
  `idexpedienteComision` INT NOT NULL,
  `idDictamen` INT NOT NULL,
  PRIMARY KEY (`idExpedienteComision`, `idDictamen`));
  
insert 	into expedienteComision_dictamenesMayoria(idExpedienteComision,idDictamen)
select 	idExpedienteComision,idDictamenMayoria
from 	expedienteComision
where	idDictamenMayoria is not null;

insert 	into expedienteComision_dictamenesPrimeraMinoria(idExpedienteComision,idDictamen)
select 	idExpedienteComision,idDictamenMayoria
from 	expedienteComision
where	idDictamenMayoria is not null;

insert 	into expedienteComision_dictamenesSegundaMinoria(idExpedienteComision,idDictamen)
select 	idExpedienteComision,idDictamenMayoria
from 	expedienteComision
where	idDictamenMayoria is not null;

ALTER TABLE `expedienteComision` 
DROP FOREIGN KEY `fk_expedienteComision_dictamenSegundaMinoria`,
DROP FOREIGN KEY `fk_expedienteComision_dictamenPrimeraMinoria`,
DROP FOREIGN KEY `fk_expedienteComision_dictamenMayoria`;

ALTER TABLE `expedienteComision` 
DROP INDEX `expedienteComision_dictamenMayoria_idx` ,
DROP INDEX `expedienteComision_dictamenSegundaMinoria_idx` ,
DROP INDEX `expedienteComision_dictamenPrimeraMinoria_idx` ;

ALTER TABLE `expedienteComision` 
DROP COLUMN `idDictamenSegundaMinoria`,
DROP COLUMN `idDictamenPrimeraMinoria`,
DROP COLUMN `idDictamenMayoria`;

ALTER TABLE expedienteComision_dictamenesMayoria ADD CONSTRAINT FK_3BBFCEC8E3D06A5A FOREIGN KEY (idExpedienteComision) REFERENCES expedienteComision (idExpedienteComision);
ALTER TABLE expedienteComision_dictamenesMayoria ADD CONSTRAINT FK_3BBFCEC88F297216 FOREIGN KEY (idDictamen) REFERENCES dictamen (idDictamen);
CREATE INDEX IDX_3BBFCEC8E3D06A5A ON expedienteComision_dictamenesMayoria (idExpedienteComision);
CREATE INDEX IDX_3BBFCEC88F297216 ON expedienteComision_dictamenesMayoria (idDictamen);
ALTER TABLE expedienteComision_dictamenesPrimeraMinoria ADD CONSTRAINT FK_D485C5CE3D06A5A FOREIGN KEY (idExpedienteComision) REFERENCES expedienteComision (idExpedienteComision);
ALTER TABLE expedienteComision_dictamenesPrimeraMinoria ADD CONSTRAINT FK_D485C5C8F297216 FOREIGN KEY (idDictamen) REFERENCES dictamen (idDictamen);
CREATE INDEX IDX_D485C5CE3D06A5A ON expedienteComision_dictamenesPrimeraMinoria (idExpedienteComision);
CREATE INDEX IDX_D485C5C8F297216 ON expedienteComision_dictamenesPrimeraMinoria (idDictamen);
ALTER TABLE expedienteComision_dictamenesSegundaMinoria ADD CONSTRAINT FK_6263EF99E3D06A5A FOREIGN KEY (idExpedienteComision) REFERENCES expedienteComision (idExpedienteComision);
ALTER TABLE expedienteComision_dictamenesSegundaMinoria ADD CONSTRAINT FK_6263EF998F297216 FOREIGN KEY (idDictamen) REFERENCES dictamen (idDictamen);
CREATE INDEX IDX_6263EF99E3D06A5A ON expedienteComision_dictamenesSegundaMinoria (idExpedienteComision);
CREATE INDEX IDX_6263EF998F297216 ON expedienteComision_dictamenesSegundaMinoria (idDictamen);

ALTER TABLE `expedienteComision` 
DROP COLUMN `fechaPublicacion`;

ALTER TABLE `tipoExpedienteSesion` 
ADD INDEX `letra_idx` (`letra` ASC);

ALTER TABLE `comision` 
ADD INDEX `letra_idx` (`letraOrdenDelDia` ASC);

ALTER TABLE `expedienteSesion` 
ADD INDEX `expedienteSesion_idx` (`idTipoExpedienteSesion` ASC, `idSesion` ASC);













