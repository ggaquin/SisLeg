ALTER TABLE `sancion` 
CHANGE COLUMN `numeroSancion` `numeroSancion` VARCHAR(9) NULL DEFAULT NULL ;

ALTER TABLE `dictamen` 
ADD COLUMN `ultimoMomento` TINYINT(1) NULL AFTER `textoArticulado`,
ADD COLUMN `usuarioModificacion` VARCHAR(70) NULL AFTER `usuarioCreacion`,
ADD COLUMN `fechaModificacion` DATETIME NULL AFTER `usuarioModificacion`;

update dictamen
set ultimoMomento=0;

ALTER TABLE `sistema_legislativo`.`dictamen` 
CHANGE COLUMN `ultimoMomento` `ultimoMomento` TINYINT(1) NOT NULL ;


INSERT INTO `menuItem` (`idMenu`, `menuItem`, `abreviacion`) 
VALUES ('1', 'Editar Sesion', 'EXP_SES_EDIT');
INSERT INTO `menuItem` (`idMenu`, `menuItem`, `abreviacion`) 
VALUES ('1', 'Quitar Ultimo Momento', 'EXP_ULT_MOM');
INSERT INTO `menuItem` (`idMenu`, `menuItem`, `abreviacion`) 
VALUES ('6', 'Quitar Ultimo Momento', 'DIC_ULT_MOM');
INSERT INTO `menuItem` (`idMenu`, `menuItem`, `abreviacion`) 
VALUES ('9', 'Descargar Ultimo Momento', 'SES_UM_DOWNLOAD');

UPDATE `menuItem` SET `menuItem`='Imprimir Remito' WHERE `idMenuItem`='24';

INSERT INTO `rol_menuItem` (`idRol`, `idMenuItem`) VALUES ('4', '61');
INSERT INTO `rol_menuItem` (`idRol`, `idMenuItem`) VALUES ('4', '62');
INSERT INTO `rol_menuItem` (`idRol`, `idMenuItem`) VALUES ('6', '61');
INSERT INTO `rol_menuItem` (`idRol`, `idMenuItem`) VALUES ('6', '62');
INSERT INTO `rol_menuItem` (`idRol`, `idMenuItem`) VALUES ('5', '63');
INSERT INTO `rol_menuItem` (`idRol`, `idMenuItem`) VALUES ('5', '39');
INSERT INTO `rol_menuItem` (`idRol`, `idMenuItem`) VALUES ('6', '41');
INSERT INTO `rol_menuItem` (`idRol`, `idMenuItem`) VALUES ('6', '63');
INSERT INTO `rol_menuItem` (`idRol`, `idMenuItem`) VALUES ('2', '64');
INSERT INTO `rol_menuItem` (`idRol`, `idMenuItem`) VALUES ('4', '64');
INSERT INTO `rol_menuItem` (`idRol`, `idMenuItem`) VALUES ('6', '64');


ALTER TABLE `sistema_legislativo`.`sancion` 
ADD COLUMN `firmaPresidente` VARCHAR(150) NOT NULL AFTER `numeroSancion`,
ADD COLUMN `firmaSecretario` VARCHAR(150) NOT NULL AFTER `firmaPresidente`;





