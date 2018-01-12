#Cambios_Sisleg_v_1_6_0

ALTER TABLE `movimiento` 
ADD COLUMN `idComision` INT NULL AFTER `idSesion`,
ADD INDEX `movimiento_comision_idx` (`idComision` ASC);

ALTER TABLE `movimiento` 
ADD CONSTRAINT `fk_movimiento_comision`
  FOREIGN KEY (`idComision`)
  REFERENCES `comision` (`idComision`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

CREATE TABLE `resolucion` (
  `idResolucion` INT NOT NULL AUTO_INCREMENT,
  `discriminador` VARCHAR(45) NULL,
  `textoLibre` LONGTEXT NULL,
  `idTipoResolucion` SMALLINT(6) NULL,
  `textoArticulado` LONGTEXT NULL,
  `idProyectoRevision` INT NULL,
  `tieneNotificacion` TINYINT(1) NULL,
  `idNotificacion` INT NULL,
  `tieneSancion` TINYINT(1) NULL,
  `numeroSancion` VARCHAR(6) NULL,
  `fechaCreacion` DATETIME NULL,
  `usuarioCreacion` VARCHAR(70) NULL,
  PRIMARY KEY (`idResolucion`),
  INDEX `resolucion_tipoResolucion_idx` (`idTipoResolucion` ASC),
  INDEX `resolucion_proyectoRevision_idx` (`idProyectoRevision` ASC),
  INDEX `resolucion_notificacion_idx` (`idNotificacion` ASC),
  CONSTRAINT `fk_resolucion_tipoResolucion`
    FOREIGN KEY (`idTipoResolucion`)
    REFERENCES `tipoProyecto` (`idTipoProyecto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_resolucion_proyectoRevision`
    FOREIGN KEY (`idProyectoRevision`)
    REFERENCES `proyectoRevision` (`idProyectoRevision`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_resolucion_notificacion`
    FOREIGN KEY (`idNotificacion`)
    REFERENCES `movimiento` (`idMovimiento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
    
ALTER TABLE `expediente` 
ADD COLUMN `idResolucion` INT NULL AFTER `idSesion`,
ADD INDEX `expediente_resolucion_idx` (`idResolucion` ASC);

ALTER TABLE `expediente` 
ADD CONSTRAINT `fk_expediente_resolucion`
  FOREIGN KEY (`idResolucion`)
  REFERENCES `resolucion` (`idResolucion`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;
