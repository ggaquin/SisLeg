-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema sistema_legislativo
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema sistema_legislativo
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sistema_legislativo` DEFAULT CHARACTER SET utf8mb4 ;
USE `sistema_legislativo` ;

-- -----------------------------------------------------
-- Table `sistema_legislativo`.`perfil`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistema_legislativo`.`perfil` (
  `idPerfil` INT NOT NULL AUTO_INCREMENT,
  `discriminador` VARCHAR(45) NOT NULL,
  `bloque` VARCHAR(100) NOT NULL,
  `imagen` VARCHAR(150) NULL,
  `apellidos` VARCHAR(70) NOT NULL,
  `nombres` VARCHAR(70) NOT NULL,
  PRIMARY KEY (`idPerfil`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `sistema_legislativo`.`rol`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistema_legislativo`.`rol` (
  `idRol` SMALLINT NOT NULL,
  `rol` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idRol`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `sistema_legislativo`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistema_legislativo`.`usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT,
  `usuario` VARCHAR(70) NOT NULL,
  `clave` VARCHAR(45) NOT NULL,
  `idPerfil` INT NOT NULL,
  `idRol` SMALLINT NOT NULL,
  PRIMARY KEY (`idUsuario`),
  INDEX `fk_usuario_perfil_idx` (`idPerfil` ASC),
  INDEX `fk_usuario_rol1_idx` (`idRol` ASC),
  CONSTRAINT `fk_usuario_perfil`
    FOREIGN KEY (`idPerfil`)
    REFERENCES `sistema_legislativo`.`perfil` (`idPerfil`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_rol1`
    FOREIGN KEY (`idRol`)
    REFERENCES `sistema_legislativo`.`rol` (`idRol`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `sistema_legislativo`.`sesion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistema_legislativo`.`sesion` (
  `idSesion` INT NOT NULL,
  `fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `presentes` VARCHAR(200) NOT NULL,
  `quorum` TINYINT(1) NOT NULL,
  `periodo` SMALLINT NOT NULL,
  PRIMARY KEY (`idSesion`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `sistema_legislativo`.`estadoPoyecto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistema_legislativo`.`estadoPoyecto` (
  `idEstadoPoyecto` SMALLINT NOT NULL,
  `estadoProyecto` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idEstadoPoyecto`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `sistema_legislativo`.`tipoProyecto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistema_legislativo`.`tipoProyecto` (
  `idTipoProyecto` SMALLINT NOT NULL,
  `tipoProyecto` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idTipoProyecto`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `sistema_legislativo`.`proyecto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistema_legislativo`.`proyecto` (
  `idProyecto` INT NOT NULL AUTO_INCREMENT,
  `idEstadoProyecto` SMALLINT NOT NULL,
  `idTpoProyecto` SMALLINT NOT NULL,
  `nombreProyecto` VARCHAR(200) NOT NULL,
  `texto` VARCHAR(500) NOT NULL,
  `resumen` VARCHAR(100) NOT NULL,
  `fechaPresentacion` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechaModificacion` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `usuarioPublicacion` VARCHAR(70) NOT NULL,
  `usuarioEdicion` VARCHAR(70) NULL,
  PRIMARY KEY (`idProyecto`),
  INDEX `fk_proyecto_estadoPoyecto1_idx` (`idEstadoProyecto` ASC),
  INDEX `fk_proyecto_tipoProyecto1_idx` (`idTpoProyecto` ASC),
  CONSTRAINT `fk_proyecto_estadoPoyecto1`
    FOREIGN KEY (`idEstadoProyecto`)
    REFERENCES `sistema_legislativo`.`estadoPoyecto` (`idEstadoPoyecto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyecto_tipoProyecto1`
    FOREIGN KEY (`idTpoProyecto`)
    REFERENCES `sistema_legislativo`.`tipoProyecto` (`idTipoProyecto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `sistema_legislativo`.`estadoProyectoSesion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistema_legislativo`.`estadoProyectoSesion` (
  `idEstadoSesionProyecto` SMALLINT NOT NULL,
  `estadoProyectoSesion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idEstadoSesionProyecto`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `sistema_legislativo`.`sesionProyecto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistema_legislativo`.`sesionProyecto` (
  `idSesionProyecto` INT NOT NULL AUTO_INCREMENT,
  `idProyecto` INT NOT NULL,
  `idSesion` INT NOT NULL,
  `idEstadoProyectoSesion` SMALLINT NOT NULL,
  `aFavor` SMALLINT NOT NULL DEFAULT 0,
  `enContra` SMALLINT NOT NULL DEFAULT 0,
  `abstenciones` SMALLINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`idSesionProyecto`),
  INDEX `fk_sesionProyecto_proyecto1_idx` (`idProyecto` ASC),
  INDEX `fk_sesionProyecto_sesion1_idx` (`idSesion` ASC),
  INDEX `fk_sesionProyecto_estadoProyecto1_idx` (`idEstadoProyectoSesion` ASC),
  CONSTRAINT `fk_sesionProyecto_proyecto1`
    FOREIGN KEY (`idProyecto`)
    REFERENCES `sistema_legislativo`.`proyecto` (`idProyecto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sesionProyecto_sesion1`
    FOREIGN KEY (`idSesion`)
    REFERENCES `sistema_legislativo`.`sesion` (`idSesion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sesionProyecto_estadoProyecto1`
    FOREIGN KEY (`idEstadoProyectoSesion`)
    REFERENCES `sistema_legislativo`.`estadoProyectoSesion` (`idEstadoSesionProyecto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `sistema_legislativo`.`proyectoAutor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistema_legislativo`.`proyectoAutor` (
  `idProyectoAutor` INT NOT NULL AUTO_INCREMENT,
  `idProyecto` INT NOT NULL,
  `idPerfil` INT NOT NULL,
  PRIMARY KEY (`idProyectoAutor`),
  INDEX `fk_proyectoAutor_proyecto1_idx` (`idProyecto` ASC),
  INDEX `fk_proyectoAutor_perfil1_idx` (`idPerfil` ASC),
  CONSTRAINT `fk_proyectoAutor_proyecto1`
    FOREIGN KEY (`idProyecto`)
    REFERENCES `sistema_legislativo`.`proyecto` (`idProyecto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyectoAutor_perfil1`
    FOREIGN KEY (`idPerfil`)
    REFERENCES `sistema_legislativo`.`perfil` (`idPerfil`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `sistema_legislativo`.`tipoVoto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistema_legislativo`.`tipoVoto` (
  `idTipoVoto` SMALLINT NOT NULL,
  `tipoVoto` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idTipoVoto`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `sistema_legislativo`.`perfilProyecto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistema_legislativo`.`perfilProyecto` (
  `idPerfilProyecto` INT NOT NULL AUTO_INCREMENT,
  `idPerfil` INT NOT NULL,
  `idProyecto` INT NOT NULL,
  `idTipoVoto` SMALLINT NOT NULL,
  PRIMARY KEY (`idPerfilProyecto`),
  INDEX `fk_perfilProyecto_perfil1_idx` (`idPerfil` ASC),
  INDEX `fk_perfilProyecto_proyecto1_idx` (`idProyecto` ASC),
  INDEX `fk_perfilProyecto_tipoVoto1_idx` (`idTipoVoto` ASC),
  CONSTRAINT `fk_perfilProyecto_perfil1`
    FOREIGN KEY (`idPerfil`)
    REFERENCES `sistema_legislativo`.`perfil` (`idPerfil`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfilProyecto_proyecto1`
    FOREIGN KEY (`idProyecto`)
    REFERENCES `sistema_legislativo`.`proyecto` (`idProyecto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfilProyecto_tipoVoto1`
    FOREIGN KEY (`idTipoVoto`)
    REFERENCES `sistema_legislativo`.`tipoVoto` (`idTipoVoto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `sistema_legislativo`.`modificacionProyecto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistema_legislativo`.`modificacionProyecto` (
  `idModificacionProyecto` INT NOT NULL AUTO_INCREMENT,
  `idProyecto` INT NOT NULL,
  `usuarioEdicion` VARCHAR(70) NOT NULL,
  `fechaEdicion` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `textoOriginal` VARCHAR(500) NOT NULL,
  `textoModificado` VARCHAR(500) NOT NULL,
  PRIMARY KEY (`idModificacionProyecto`),
  INDEX `fk_modificacionProyecto_proyecto1_idx` (`idProyecto` ASC),
  CONSTRAINT `fk_modificacionProyecto_proyecto1`
    FOREIGN KEY (`idProyecto`)
    REFERENCES `sistema_legislativo`.`proyecto` (`idProyecto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

