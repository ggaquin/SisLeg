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

UPDATE `tipoExpedienteSesion` SET `tipoExpedienteSesion`='Mensajes del Departamento Ejecutivo Girados a Comisiones' WHERE `idTipoExpedienteSesion`='2';
UPDATE `tipoExpedienteSesion` SET `tipoExpedienteSesion`='Proyectos' WHERE `idTipoExpedienteSesion`='3';
UPDATE `tipoExpedienteSesion` SET `tipoExpedienteSesion`='Proyectos Girados a Comisiones' WHERE `idTipoExpedienteSesion`='5';
UPDATE `tipoExpedienteSesion` SET `tipoExpedienteSesion`='Comisión de Presupesto y Hacienda' WHERE `idTipoExpedienteSesion`='7';
UPDATE `tipoExpedienteSesion` SET `tipoExpedienteSesion`='Comisión de Obras Públicas y Urbanismo' WHERE `idTipoExpedienteSesion`='8';
UPDATE `tipoExpedienteSesion` SET `tipoExpedienteSesion`='Comisión de Servicios Públicos' WHERE `idTipoExpedienteSesion`='9';
UPDATE `tipoExpedienteSesion` SET `tipoExpedienteSesion`='Comisión de Derechos y Garantías' WHERE `idTipoExpedienteSesion`='10';
UPDATE `tipoExpedienteSesion` SET `tipoExpedienteSesion`='Comisión de Industria y Comercio Interior y Exterior' WHERE `idTipoExpedienteSesion`='12';
UPDATE `tipoExpedienteSesion` SET `tipoExpedienteSesion`='Comisión de Habitat, Tierrras y Viviendas' WHERE `idTipoExpedienteSesion`='13';
UPDATE `tipoExpedienteSesion` SET `tipoExpedienteSesion`='Comisión de Medios de Comunicación Social' WHERE `idTipoExpedienteSesion`='14';
UPDATE `tipoExpedienteSesion` SET `tipoExpedienteSesion`='Comisión de Seguridad y Justicia' WHERE `idTipoExpedienteSesion`='15';
UPDATE `tipoExpedienteSesion` SET `tipoExpedienteSesion`='Comisión de Mujeres y Equidad de Genero' WHERE `idTipoExpedienteSesion`='16';
UPDATE `tipoExpedienteSesion` SET `tipoExpedienteSesion`='Comisión de Cultura y Educación ' WHERE `idTipoExpedienteSesion`='17';
UPDATE `tipoExpedienteSesion` SET `tipoExpedienteSesion`='Comisión de Promoción de la Comunidad' WHERE `idTipoExpedienteSesion`='18';
UPDATE `tipoExpedienteSesion` SET `tipoExpedienteSesion`='Comisión de Defensa del Usuario' WHERE `idTipoExpedienteSesion`='19';
UPDATE `tipoExpedienteSesion` SET `tipoExpedienteSesion`='Comisión de Planeamiento' WHERE `idTipoExpedienteSesion`='20';
UPDATE `tipoExpedienteSesion` SET `tipoExpedienteSesion`='Comisión de Interpretación y Reglamento' WHERE `idTipoExpedienteSesion`='21';
UPDATE `tipoExpedienteSesion` SET `tipoExpedienteSesion`='Comisión de Ecología y Protección del Medio Ambiente' WHERE `idTipoExpedienteSesion`='22';
UPDATE `tipoExpedienteSesion` SET `tipoExpedienteSesion`='Dictamenes Conjunto' WHERE `idTipoExpedienteSesion`='23';

ALTER TABLE `sesion` 
ADD COLUMN `tieneEdicionBloqueada` TINYINT(1) NULL AFTER `tieneOrdenDelDia`;

UPDATE `sesion` SET `tieneEdicionBloqueada`='0' WHERE `idSesion`='1';
UPDATE `sesion` SET `tieneEdicionBloqueada`='0' WHERE `idSesion`='2';
UPDATE `sesion` SET `tieneEdicionBloqueada`='0' WHERE `idSesion`='3';
UPDATE `sesion` SET `tieneEdicionBloqueada`='0' WHERE `idSesion`='4';
UPDATE `sesion` SET `tieneEdicionBloqueada`='0' WHERE `idSesion`='5';
UPDATE `sesion` SET `tieneEdicionBloqueada`='0' WHERE `idSesion`='6';

ALTER TABLE `sesion` 
CHANGE COLUMN `tieneEdicionBloqueada` `tieneEdicionBloqueada` TINYINT(1) NOT NULL;

ALTER TABLE `sesion` 
ADD COLUMN `cantidadExpedientes` INT NOT NULL AFTER `tieneEdicionBloqueada`;


