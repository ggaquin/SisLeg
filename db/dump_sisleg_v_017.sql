-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: localhost    Database: sistema_legislativo
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bloque`
--

DROP TABLE IF EXISTS `bloque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bloque` (
  `idBloque` smallint(6) NOT NULL AUTO_INCREMENT,
  `bloque` varchar(100) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`idBloque`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bloque`
--

LOCK TABLES `bloque` WRITE;
/*!40000 ALTER TABLE `bloque` DISABLE KEYS */;
INSERT INTO `bloque` VALUES (1,'Frente Renovador',1,'2017-08-12 00:00:00','Administrador','2017-10-14 19:11:43','mesaHCD'),(2,'Frente Para la Victoria',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(3,'UNA',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(4,'UCR',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(5,'GEN',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(6,'Cambiemos',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(7,'bloque modificado',0,'2017-08-12 22:02:22','administrador','2017-08-12 22:05:22','administrador');
/*!40000 ALTER TABLE `bloque` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comision`
--

DROP TABLE IF EXISTS `comision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comision` (
  `idComision` int(11) NOT NULL AUTO_INCREMENT,
  `idPerfilPresidente` int(11) DEFAULT NULL,
  `idPerfilVicePresidente` int(11) DEFAULT NULL,
  `idTipoComision` smallint(6) DEFAULT NULL,
  `comision` varchar(100) NOT NULL,
  `letraOrdenDelDia` varchar(2) NOT NULL,
  `activa` tinyint(1) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`idComision`),
  KEY `comision_tipoComision_idx` (`idTipoComision`),
  KEY `comision_perfilPresidente_idx` (`idPerfilPresidente`),
  KEY `comision_perfilVicePresidente_idx` (`idPerfilVicePresidente`),
  KEY `letra_idx` (`letraOrdenDelDia`),
  CONSTRAINT `fk_comision_perfilPresidente` FOREIGN KEY (`idPerfilPresidente`) REFERENCES `perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comision_perfilVicePresidente` FOREIGN KEY (`idPerfilVicePresidente`) REFERENCES `perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comision_tipoComision` FOREIGN KEY (`idTipoComision`) REFERENCES `tipoComision` (`idTipoComision`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comision`
--

LOCK TABLES `comision` WRITE;
/*!40000 ALTER TABLE `comision` DISABLE KEYS */;
INSERT INTO `comision` VALUES (1,2,3,2,'Defensa del Usuario','T',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(2,19,5,2,'Promoción de la Comunidad','S',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(3,14,3,2,'Seguridad y Justicia','P',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(4,5,22,2,'Mujeres y Equidad de Género','Q',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(5,11,9,2,'Presupuesto y Hacienda','F',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(6,18,15,2,'Derechos y Garantías','K',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(7,6,19,2,'Interpretación y Reglamento','X',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(8,23,20,2,'Habitat, Tierras y Viendas','N',1,'2017-08-12 00:00:00','Administrador','2017-08-12 13:44:21','administrador'),(9,22,5,2,'Planeamiento','W',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(10,16,13,2,'Ecología y Protección del Medio Ambiente','Y',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(11,8,3,2,'Obras Públicas y Urbanismo','G',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(12,14,15,2,'Servicios Públicos','H',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(13,13,4,2,'Labor Legislativa','L',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(14,15,23,2,'Cultura y Educación','R',1,'2017-08-12 00:00:00','Administrador','2017-10-19 23:51:05','administrador'),(15,9,4,2,'Industria y Comercio Interior y Exterior','M',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(16,16,5,2,'Medios de Comunicación Social','O',1,'2017-08-12 00:00:00','Administrador',NULL,NULL);
/*!40000 ALTER TABLE `comision` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comision_legisladorSuplente`
--

DROP TABLE IF EXISTS `comision_legisladorSuplente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comision_legisladorSuplente` (
  `idComision` int(11) NOT NULL,
  `idPerfil` int(11) NOT NULL,
  PRIMARY KEY (`idComision`,`idPerfil`),
  KEY `IDX_32E07B8EF574DEDD` (`idPerfil`),
  KEY `IDX_32E07B8E43B0A334` (`idComision`),
  CONSTRAINT `fk_comision_legisladorSuplente_comision` FOREIGN KEY (`idComision`) REFERENCES `comision` (`idComision`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comision_legisladorSuplente_perfil` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comision_legisladorSuplente`
--

LOCK TABLES `comision_legisladorSuplente` WRITE;
/*!40000 ALTER TABLE `comision_legisladorSuplente` DISABLE KEYS */;
INSERT INTO `comision_legisladorSuplente` VALUES (2,2),(3,2),(4,2),(5,2),(6,2),(7,2),(8,2),(9,2),(10,2),(11,2),(12,2),(13,2),(14,2),(16,2),(2,3),(5,3),(14,3),(2,4),(7,4),(8,4),(9,4),(10,4),(12,4),(16,4),(3,5),(5,5),(6,5),(7,5),(11,5),(12,5),(15,5),(3,6),(11,6),(13,6),(14,6),(15,6),(9,7),(4,8),(5,8),(7,8),(16,8),(2,9),(3,9),(4,9),(6,9),(8,9),(9,9),(12,9),(13,9),(14,9),(1,11),(3,11),(4,11),(6,11),(8,11),(13,11),(15,11),(16,11),(1,12),(3,12),(4,12),(6,12),(8,12),(9,12),(10,12),(12,12),(13,12),(15,12),(1,13),(4,13),(5,13),(7,13),(9,13),(11,13),(12,13),(1,14),(2,14),(4,14),(5,14),(7,14),(10,14),(11,14),(14,14),(16,14),(1,15),(13,15),(1,16),(4,16),(11,16),(12,16),(14,16),(15,16),(1,17),(6,17),(9,17),(11,17),(1,18),(5,18),(7,18),(11,18),(15,18),(16,18),(2,19),(3,19),(8,19),(10,19),(12,19),(13,19),(14,19),(15,19),(7,20),(10,20),(2,22),(5,22),(6,22),(8,22),(14,22),(16,22),(2,23),(3,23),(4,23),(6,23),(9,23),(10,23),(13,23),(16,23);
/*!40000 ALTER TABLE `comision_legisladorSuplente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comision_legisladorTitular`
--

DROP TABLE IF EXISTS `comision_legisladorTitular`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comision_legisladorTitular` (
  `idComision` int(11) NOT NULL,
  `idPerfil` int(11) NOT NULL,
  PRIMARY KEY (`idComision`,`idPerfil`),
  KEY `IDX_3F75DDA1F574DEDD` (`idPerfil`),
  KEY `IDX_3F75DDA143B0A334` (`idComision`),
  CONSTRAINT `fk_comision_legisladorTitular_comision` FOREIGN KEY (`idComision`) REFERENCES `comision` (`idComision`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comision_legisladorTitular_perfil` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comision_legisladorTitular`
--

LOCK TABLES `comision_legisladorTitular` WRITE;
/*!40000 ALTER TABLE `comision_legisladorTitular` DISABLE KEYS */;
INSERT INTO `comision_legisladorTitular` VALUES (15,2),(4,3),(6,3),(7,3),(9,3),(10,3),(12,3),(13,3),(15,3),(16,3),(1,4),(3,4),(4,4),(5,4),(6,4),(11,4),(1,5),(8,5),(13,5),(14,5),(2,6),(4,6),(5,6),(6,6),(8,6),(9,6),(10,6),(12,6),(1,7),(3,7),(5,7),(7,7),(10,7),(11,7),(13,7),(14,7),(16,7),(1,8),(8,8),(12,8),(15,8),(1,9),(7,9),(11,9),(16,9),(1,10),(9,10),(10,10),(12,10),(15,10),(7,11),(11,11),(12,11),(14,11),(5,12),(7,12),(11,12),(2,13),(3,13),(14,13),(16,13),(13,14),(2,15),(3,15),(4,15),(5,15),(7,15),(8,15),(9,15),(10,15),(11,15),(15,15),(16,15),(2,16),(6,16),(9,16),(3,17),(4,17),(10,17),(13,17),(14,17),(16,17),(2,18),(3,18),(4,18),(8,18),(9,18),(12,18),(13,18),(14,18),(5,19),(6,19),(9,19),(2,20),(4,20),(6,20),(12,20),(2,21),(8,21),(10,21),(14,21),(15,21),(16,21),(9,22),(15,22),(3,24),(5,24),(6,24),(7,24),(11,24),(13,24);
/*!40000 ALTER TABLE `comision_legisladorTitular` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `demandanteParticular`
--

DROP TABLE IF EXISTS `demandanteParticular`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `demandanteParticular` (
  `idDemandanteParticular` int(11) NOT NULL AUTO_INCREMENT,
  `apellidos` varchar(70) NOT NULL,
  `nombres` varchar(70) NOT NULL,
  `documento` varchar(8) NOT NULL,
  PRIMARY KEY (`idDemandanteParticular`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demandanteParticular`
--

LOCK TABLES `demandanteParticular` WRITE;
/*!40000 ALTER TABLE `demandanteParticular` DISABLE KEYS */;
INSERT INTO `demandanteParticular` VALUES (2,'sasajasgjs','agfshagfshaf','12121212'),(3,'dsdsds','dsdsdsd','5454'),(4,'sasajasgjs','agfshagfshaf','12121212'),(5,'sasajasgjs','agfshagfshaf','12121212'),(6,'perez','juan','25465877'),(7,'hasgjgsd','hdgasjgdjags','21212121');
/*!40000 ALTER TABLE `demandanteParticular` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dictamen`
--

DROP TABLE IF EXISTS `dictamen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dictamen` (
  `idDictamen` int(11) NOT NULL AUTO_INCREMENT,
  `discriminador` varchar(15) NOT NULL,
  `idProyectoRevision` int(11) DEFAULT NULL,
  `idTipoDictamen` smallint(6) DEFAULT NULL,
  `textoLibre` longtext NOT NULL,
  `textoArticulado` longtext COMMENT '(DC2Type:json_array)',
  `ultimoMomento` tinyint(1) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`idDictamen`),
  KEY `dictamen_proyectoRevision_idx` (`idProyectoRevision`),
  KEY `dictamen_tipoProyecto_idx` (`idTipoDictamen`),
  CONSTRAINT `fk_dictamen_proyectoRevision` FOREIGN KEY (`idProyectoRevision`) REFERENCES `proyectoRevision` (`idProyectoRevision`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_dictamen_tipoProyecto` FOREIGN KEY (`idTipoDictamen`) REFERENCES `tipoProyecto` (`idTipoProyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `dictamen_legislador`
--

DROP TABLE IF EXISTS `dictamen_legislador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dictamen_legislador` (
  `idDictamen` int(11) NOT NULL,
  `idPerfil` int(11) NOT NULL,
  PRIMARY KEY (`idDictamen`,`idPerfil`),
  KEY `IDX_CD661298F574DEDD` (`idPerfil`),
  KEY `IDX_CD6612988F297216` (`idDictamen`),
  CONSTRAINT `fk_dictamen_legislador_dictamen` FOREIGN KEY (`idDictamen`) REFERENCES `dictamen` (`idDictamen`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_dictamen_legislador_perfil` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dictamen_legislador`
--

LOCK TABLES `dictamen_legislador` WRITE;
/*!40000 ALTER TABLE `dictamen_legislador` DISABLE KEYS */;
/*!40000 ALTER TABLE `dictamen_legislador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estadoExpediente`
--

DROP TABLE IF EXISTS `estadoExpediente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estadoExpediente` (
  `idEstadoExpediente` smallint(6) NOT NULL AUTO_INCREMENT,
  `estadoExpediente` varchar(45) NOT NULL,
  PRIMARY KEY (`idEstadoExpediente`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estadoExpediente`
--

LOCK TABLES `estadoExpediente` WRITE;
/*!40000 ALTER TABLE `estadoExpediente` DISABLE KEYS */;
INSERT INTO `estadoExpediente` VALUES (1,'Ingresado'),(2,'Estudio Comisiones'),(3,'Dictamen Comisiones'),(4,'Reservado Comisión'),(5,'Sancionado'),(6,'Archivado'),(7,'Desarchivado'),(8,'Incorporado'),(9,'Esperando Recepción'),(10,'En trámite'),(11,'Orden del Día'),(12,'Revisión Despacho');
/*!40000 ALTER TABLE `estadoExpediente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estadoExpedienteSesion`
--

DROP TABLE IF EXISTS `estadoExpedienteSesion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estadoExpedienteSesion` (
  `idEstadoExpedienteSesion` smallint(6) NOT NULL AUTO_INCREMENT,
  `estadoExpedienteSesion` varchar(45) NOT NULL,
  PRIMARY KEY (`idEstadoExpedienteSesion`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estadoExpedienteSesion`
--

LOCK TABLES `estadoExpedienteSesion` WRITE;
/*!40000 ALTER TABLE `estadoExpedienteSesion` DISABLE KEYS */;
INSERT INTO `estadoExpedienteSesion` VALUES (1,'Aprobado'),(2,'Aprobado Tablas'),(3,'Solicitud Informe'),(4,'Giro a Comision'),(5,'Pase Archivo'),(6,'Cuerpo');
/*!40000 ALTER TABLE `estadoExpedienteSesion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expediente`
--

DROP TABLE IF EXISTS `expediente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expediente` (
  `idExpediente` int(11) NOT NULL AUTO_INCREMENT,
  `hashId` varchar(32) NOT NULL,
  `idEstadoExpediente` smallint(6) DEFAULT NULL,
  `numeroExpediente` varchar(50) NOT NULL,
  `idTipoExpediente` smallint(6) DEFAULT NULL,
  `periodo` varchar(4) NOT NULL,
  `idOficina` int(11) DEFAULT NULL,
  `idSesion` int(11) DEFAULT NULL,
  `idOrigenExterno` int(11) DEFAULT NULL,
  `idDemandanteParticular` int(11) DEFAULT NULL,
  `caratula` varchar(1000) NOT NULL,
  `folios` varchar(4) NOT NULL,
  `listaImagenes` longtext COMMENT '(DC2Type:object)',
  `numeroSancion` varchar(20) NOT NULL,
  `ultimoMomento` tinyint(1) NOT NULL,
  `fechaArchivo` datetime DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`idExpediente`),
  UNIQUE KEY `numeroExpediente_idx` (`numeroExpediente`,`periodo`),
  UNIQUE KEY `expediente_demandanteParticular_idx` (`idDemandanteParticular`),
  UNIQUE KEY `expediente_origenExterno_idx` (`idOrigenExterno`),
  KEY `expediente_estadoExpediente_idx` (`idEstadoExpediente`),
  KEY `expediente_tipoExpediente_idx` (`idTipoExpediente`),
  KEY `expediente_oficina_idx` (`idOficina`),
  KEY `expediente_sesion_idx` (`idSesion`),
  CONSTRAINT `FK_expediente_oficina_` FOREIGN KEY (`idOficina`) REFERENCES `oficina` (`idOficina`),
  CONSTRAINT `fk_expediente_demandanteParticular` FOREIGN KEY (`idDemandanteParticular`) REFERENCES `demandanteParticular` (`idDemandanteParticular`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expediente_estadoExpediente` FOREIGN KEY (`idEstadoExpediente`) REFERENCES `estadoExpediente` (`idEstadoExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expediente_origenExterno` FOREIGN KEY (`idOrigenExterno`) REFERENCES `origenExterno` (`idOrigenExterno`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expediente_sesion` FOREIGN KEY (`idSesion`) REFERENCES `sesion` (`idSesion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expediente_tipoExpediente` FOREIGN KEY (`idTipoExpediente`) REFERENCES `tipoExpediente` (`idTipoExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `expedienteComision`
--

DROP TABLE IF EXISTS `expedienteComision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expedienteComision` (
  `idExpedienteComision` int(11) NOT NULL AUTO_INCREMENT,
  `idSesion` int(11) DEFAULT NULL,
  `idComision` int(11) DEFAULT NULL,
  `idExpediente` int(11) DEFAULT NULL,
  `anulado` tinyint(1) NOT NULL,
  `idMovimiento` int(11) DEFAULT NULL,
  `idDictamenMayoria` int(11) DEFAULT NULL,
  `idDictamenPrimeraMinoria` int(11) DEFAULT NULL,
  `idDictamenSegundaMinoria` int(11) DEFAULT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `ultimoMomento` tinyint(1) NOT NULL,
  PRIMARY KEY (`idExpedienteComision`),
  KEY `expedienteComision_expediente_idx` (`idExpediente`),
  KEY `expedienteComision_movimiento_idx` (`idMovimiento`),
  KEY `expedienteComision_comision_idx` (`idComision`),
  KEY `expedienteComision_sesion_idx` (`idSesion`),
  KEY `expedienteComision_dictamenMayoria_idx` (`idDictamenMayoria`),
  KEY `expedienteComision_dictamenSegundaMinoria_idx` (`idDictamenSegundaMinoria`),
  KEY `expedienteComision_dictamenPrimeraMinoria_idx` (`idDictamenPrimeraMinoria`),
  CONSTRAINT `fk_expedienteComision_comision` FOREIGN KEY (`idComision`) REFERENCES `comision` (`idComision`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedienteComision_dictamenMayoria` FOREIGN KEY (`idDictamenMayoria`) REFERENCES `dictamen` (`idDictamen`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedienteComision_dictamenPrimeraMinoria` FOREIGN KEY (`idDictamenPrimeraMinoria`) REFERENCES `dictamen` (`idDictamen`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedienteComision_dictamenSegundaMinoria` FOREIGN KEY (`idDictamenSegundaMinoria`) REFERENCES `dictamen` (`idDictamen`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedienteComision_expediente` FOREIGN KEY (`idExpediente`) REFERENCES `expediente` (`idExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedienteComision_movimiento` FOREIGN KEY (`idMovimiento`) REFERENCES `movimiento` (`idMovimiento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedienteComision_sesion` FOREIGN KEY (`idSesion`) REFERENCES `sesion` (`idSesion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `expedienteSesion`
--

DROP TABLE IF EXISTS `expedienteSesion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expedienteSesion` (
  `idExpedienteSesion` int(11) NOT NULL AUTO_INCREMENT,
  `ordenSesion` smallint(6) NOT NULL,
  `idTipoExpedienteSesion` int(11) DEFAULT NULL,
  `idExpediente` int(11) DEFAULT NULL,
  `idSesion` int(11) DEFAULT NULL,
  `idSancion` int(11) DEFAULT NULL,
  `idEstadoExpedienteSesion` smallint(6) DEFAULT NULL,
  `texto` longtext NOT NULL,
  `aFavor` smallint(6) NOT NULL,
  `enContra` smallint(6) NOT NULL,
  `abstenciones` smallint(6) NOT NULL,
  PRIMARY KEY (`idExpedienteSesion`),
  KEY `expedienteSesion_estadoExpedienteSesion_idx` (`idEstadoExpedienteSesion`),
  KEY `agendaSesion_sesion_idx` (`idSesion`),
  KEY `agendaSesion_expediente_idx` (`idExpediente`),
  KEY `expedienteSesion_tipoExpedienteSesion_idx` (`idTipoExpedienteSesion`),
  KEY `expedienteSesion_sancion_idx` (`idSancion`),
  CONSTRAINT `fk_expedienteSesion_estadoExpedienteSesion` FOREIGN KEY (`idEstadoExpedienteSesion`) REFERENCES `estadoExpedienteSesion` (`idEstadoExpedienteSesion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedienteSesion_expediente` FOREIGN KEY (`idExpediente`) REFERENCES `expediente` (`idExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedienteSesion_sancion` FOREIGN KEY (`idSancion`) REFERENCES `sancion` (`idSancion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedienteSesion_sesion` FOREIGN KEY (`idSesion`) REFERENCES `sesion` (`idSesion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedienteSesion_tipoExpedienteSesion` FOREIGN KEY (`idTipoExpedienteSesion`) REFERENCES `tipoExpedienteSesion` (`idTipoExpedienteSesion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;


/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `expedienteSesion_BEFORE_INSERT` BEFORE INSERT ON `expedienteSesion` FOR EACH ROW
BEGIN
	set @ordenSesion:=((select count(*) from expedienteSesion
						where idTipoExpedienteSesion=NEW.idTipoExpedienteSesion
							  and idSesion=new.idSesion)+1);
	set NEW.ordenSesion=@ordenSesion;
	set NEW.texto=replace(NEW.texto,'Δ',@ordenSesion);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `idMenu` smallint(6) NOT NULL AUTO_INCREMENT,
  `menu` varchar(50) NOT NULL,
  `abreviacion` varchar(70) NOT NULL,
  PRIMARY KEY (`idMenu`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'Gestión Expedientes','EXP_MAIN'),(2,'Movimientos','MOV_MAIN'),(4,'Proyectos','PROJ_MAIN'),(5,'Comisiones-AM','COM_MAIN'),(6,'Giros Comisiones','COM_EXP_MAIN'),(7,'Concejales','CON_MAIN'),(8,'Usuarios','USR_MAIN'),(9,'Sesion','SES_MAIN'),(10,'Sanciones','DESP_SANC_MAIN'),(12,'Versiones Taquigráficas','DESP_VER_TAQ'),(13,'Oficinas','OFF_MAIN'),(14,'Bloques','BLOQ_MAIN');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menuItem`
--

DROP TABLE IF EXISTS `menuItem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menuItem` (
  `idMenuItem` smallint(6) NOT NULL AUTO_INCREMENT,
  `idMenu` smallint(6) DEFAULT NULL,
  `menuItem` varchar(50) NOT NULL,
  `abreviacion` varchar(70) NOT NULL,
  PRIMARY KEY (`idMenuItem`),
  KEY `menuItem_menu_idx` (`idMenu`),
  CONSTRAINT `fk_itemMenu_menu` FOREIGN KEY (`idMenu`) REFERENCES `menu` (`idMenu`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menuItem`
--

LOCK TABLES `menuItem` WRITE;
/*!40000 ALTER TABLE `menuItem` DISABLE KEYS */;
INSERT INTO `menuItem` VALUES (1,1,'Agregar','EXP_NEW'),(2,1,'Ingresar Proyecto','EXP_ADD'),(3,1,'Editar','EXP_EDIT'),(4,1,'Descargar','EXP_DOWNLOAD'),(5,1,'Consulta Movimientos e Informes','EXP_MOVEMENT'),(6,2,'Agregar','MOV_NEW'),(8,4,'Agregar','PROJ_NEW'),(9,4,'Editar','PROJ_EDIT'),(10,4,'Descargar','PROJ_DOWNLOAD'),(11,5,'Agregar','COM_ADD'),(12,5,'Editar','COM_EDIT'),(13,5,'Eliminar','COM_DEL'),(14,5,'Detalle','COM_DET'),(15,7,'Agregar','CON_ADD'),(16,7,'Editar','CON_EDIT'),(17,7,'Eliminar','CON_DEL'),(18,8,'Agregar','USR_ADD'),(19,8,'Editar','USR_EDIT'),(20,8,'Bloquear','USR_LOCK'),(21,8,'Desbloquear','USR_UNLOCK'),(22,2,'Anular','MOV_ABORT'),(23,2,'Recibir','MOV_RECEIVE'),(24,2,'Imprimir Remito','MOV_DOWNLOAD'),(25,1,'Reingresar Movimiento Externo','EXP_RETURN'),(26,1,'Marcar Respuesta CH','EXP_REPORT_RETURN'),(27,9,'Agregar','SES_ADD'),(28,9,'Editar','SES_EDIT'),(29,9,'Generar Orden del Día','SES_OD_NEW'),(30,9,'Eiminar Orden Del Día','SES_OD_DEL'),(31,9,'Descargar Orden Del Día','SES_OD_DOWNLOAD'),(32,12,'Eliminar Versión Taquigráfica','DESP_VER_TAQ_DEL'),(38,6,'Agregar Asignación','COM_EXP_ADD'),(39,6,'Eliminar Asignación','COM_EXP_DEL'),(40,6,'Cambiar Comisión','COM_EXP_COM_EDIT'),(41,6,'Cambiar Sesión','COM_EXP_EDIT_SES'),(42,6,'Agregar Dictamen','COM_EXP_DICT_ADD'),(43,6,'Editar Dictamen','COM_EXP_DICT_EDIT'),(44,6,'Descargar Dictamen','COM_EXP_DICT_DOWNLOAD'),(45,10,'Agregar Sancion','DESP_SANC_ADD'),(46,10,'Editar Sancion','DESP_SANC_EDIT'),(47,12,'Agregar Versión Taquigrafica','DESP_VER_TAQ_ADD'),(48,12,'Editar Versión Taquigráfica','DESP_VER_TAQ_EDIT'),(49,13,'Agregar','OFF_ADD'),(50,13,'Editar','OFF_EDIT'),(52,9,'Bloquear Edicion','SES_EDIT_BLOQ'),(53,1,'Editar Fecha Ingreso','EXP_FEC_ING_EDIT'),(54,14,'Agregar','BLOQ_ADD'),(55,14,'Editar','BLOQ_EDIT'),(56,14,'Eliminar','BLOQ_DEL'),(57,13,'Eliminar','OFF_DEL'),(58,1,'Archivar','EXP_ARCH'),(59,1,'Desarchivar','EXP_DES_ARCH'),(60,9,'Gererar Ultimo Momento','SES_UM_NEW'),(61,1,'Editar Sesion','EXP_SES_EDIT'),(62,1,'Quitar Ultimo Momento','EXP_ULT_MOM'),(63,6,'Quitar Ultimo Momento','DIC_ULT_MOM'),(64,9,'Descargar Ultimo Momento','SES_UM_DOWNLOAD');
/*!40000 ALTER TABLE `menuItem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movimiento`
--

DROP TABLE IF EXISTS `movimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `movimiento` (
  `idMovimiento` int(11) NOT NULL AUTO_INCREMENT,
  `discriminador` varchar(12) NOT NULL,
  `idExpediente` int(11) DEFAULT NULL,
  `idRemito` int(11) DEFAULT NULL,
  `observacion` varchar(200) DEFAULT NULL,
  `anulado` tinyint(1) DEFAULT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `fojas` smallint(6) DEFAULT NULL,
  `remitoRetorno` varchar(8) DEFAULT NULL,
  `fechaRespuesta` datetime DEFAULT NULL,
  `idSesion` int(11) DEFAULT NULL,
  `idComision` int(11) DEFAULT NULL,
  PRIMARY KEY (`idMovimiento`),
  KEY `movimiento_remito_idx` (`idRemito`),
  KEY `movimiento_expediente_idx` (`idExpediente`),
  KEY `movimiento_sesion_idx` (`idSesion`),
  KEY `movimiento_comision_idx` (`idComision`),
  CONSTRAINT `fk_movimiento_comision` FOREIGN KEY (`idComision`) REFERENCES `comision` (`idComision`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_movimiento_expediente` FOREIGN KEY (`idExpediente`) REFERENCES `expediente` (`idExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_movimiento_remito` FOREIGN KEY (`idRemito`) REFERENCES `remito` (`idRemito`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_movimiento_sesion` FOREIGN KEY (`idSesion`) REFERENCES `sesion` (`idSesion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `oficina`
--

DROP TABLE IF EXISTS `oficina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oficina` (
  `idOficina` int(11) NOT NULL AUTO_INCREMENT,
  `oficina` varchar(100) NOT NULL,
  `codigo` varchar(15) NOT NULL,
  `idTipoOficina` smallint(6) DEFAULT NULL,
  `activa` tinyint(1) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`idOficina`),
  KEY `oficina_tipoOficina_idx` (`idTipoOficina`),
  CONSTRAINT `fk_oficina_tipoOficina` FOREIGN KEY (`idTipoOficina`) REFERENCES `tipoOficina` (`idTipoOficina`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oficina`
--

LOCK TABLES `oficina` WRITE;
/*!40000 ALTER TABLE `oficina` DISABLE KEYS */;
INSERT INTO `oficina` VALUES (2,'ARCHIVO GENERAL','190',2,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(3,'COMISIONES','',1,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(4,'CONTADURÍA MUNICIPAL','32',2,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(5,'DESPACHO','',1,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(6,'DIRECCIÓN DE LIQUIDACIÓN DE HABERES','38',2,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(7,'DIRECCIÓN GENERAL DE CONTENCIOSO','4017',2,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(8,'DIRECCIÓN GENERAL DE OFICIOS','3202',2,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(9,'MESA DE ENTRADAS','',1,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(10,'SECRETARIA DE HACIENDA','30',2,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(11,'SECRETARIA DE LEGAL Y TÉCNICA','3200',2,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(12,'SECRETARIA GENERAL','2200',2,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(13,'SUBSECRETARIA DE RECURSOS HUMANOS','2201',2,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(14,'SECRETARIA','',1,1,'2017-08-12 00:00:00','administrador',NULL,NULL);
/*!40000 ALTER TABLE `oficina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `origenExterno`
--

DROP TABLE IF EXISTS `origenExterno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `origenExterno` (
  `idOrigenExterno` int(11) NOT NULL AUTO_INCREMENT,
  `idOficina` int(11) DEFAULT NULL,
  `numeracionOrigen` longtext NOT NULL COMMENT '(DC2Type:json_array)',
  PRIMARY KEY (`idOrigenExterno`),
  KEY `origenExterno_oficina_idx` (`idOficina`),
  CONSTRAINT `fk_origenExterno_oficina` FOREIGN KEY (`idOficina`) REFERENCES `oficina` (`idOficina`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `perfil`
--

DROP TABLE IF EXISTS `perfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfil` (
  `idPerfil` int(11) NOT NULL AUTO_INCREMENT,
  `discriminador` varchar(20) NOT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `apellidos` varchar(70) NOT NULL,
  `nombres` varchar(70) NOT NULL,
  `telefono` varchar(70) DEFAULT NULL,
  `correoElectronico` varchar(70) DEFAULT NULL,
  `idBloque` smallint(6) DEFAULT NULL,
  `oficina` varchar(50) DEFAULT NULL,
  `desde` datetime DEFAULT NULL,
  `hasta` datetime DEFAULT NULL,
  `muneroDocumento` int(11) DEFAULT NULL,
  `domicilio` varchar(100) DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`idPerfil`),
  KEY `perfil_bloque_idx` (`idBloque`),
  CONSTRAINT `fk_perfil_bloque` FOREIGN KEY (`idBloque`) REFERENCES `bloque` (`idBloque`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil`
--

LOCK TABLES `perfil` WRITE;
/*!40000 ALTER TABLE `perfil` DISABLE KEYS */;
INSERT INTO `perfil` VALUES (1,'basico',NULL,'Administrador','Sistema',NULL,'ggaquin@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador','2017-11-24 21:26:50','Administrador2'),(2,'legislador',NULL,'Fuente Buena','Hector',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(3,'legislador',NULL,'Font','Miguel',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(4,'legislador',NULL,'Guirliddo','Gabriel',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(5,'legislador',NULL,'Vilar','Daniela',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(6,'legislador',NULL,'Tranfo','Ana ',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(7,'legislador',NULL,'Mercuri','Gabriel',NULL,NULL,6,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(8,'legislador',NULL,'Castagnini','Juan Manuel',NULL,NULL,3,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(9,'legislador',NULL,'Veliz','Juan Carlos',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(10,'legislador',NULL,'Figuerón','Luis',NULL,NULL,5,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(11,'legislador',NULL,'Menéndez','Claudio',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(12,'legislador',NULL,'Oyhaburu','Sergio',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(13,'legislador',NULL,'Llambi','Alvaro',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(14,'legislador',NULL,'Baloira','Emilano',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(15,'legislador',NULL,'Lopez','Vanesa',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(16,'legislador',NULL,'Coba','José',NULL,NULL,6,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(17,'legislador',NULL,'Vázquez','María Fernanda',NULL,NULL,3,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(18,'legislador',NULL,'Herrera','Maria Elena ',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(19,'legislador',NULL,'Trezza Silva','Ramiro',NULL,NULL,3,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(20,'legislador',NULL,'Cordera','Diego',NULL,NULL,6,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(21,'legislador',NULL,'Rivero','Julio',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(22,'legislador',NULL,'Sierra','Silvia',NULL,NULL,6,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(23,'legislador',NULL,'Denuchi','Fabio',NULL,NULL,6,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(24,'legislador',NULL,'Pellegrini','Marcelo',NULL,NULL,4,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(25,'legislador',NULL,'Carasatorre','Santiago Alberto',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-06-12 14:53:53','administrador',NULL,NULL),(26,'basico',NULL,'Oficina Mesa Entradas','Usuario',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,'2017-07-28 17:39:45','administrador','2017-11-24 21:25:59','administrador'),(27,'basico',NULL,'Oficina Comisiones','Usuario',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,'2017-07-28 17:51:54','administrador','2017-11-23 10:48:21','administrador'),(28,'basico',NULL,'oficina','despacho',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,'2017-10-11 21:20:13','administrador','2017-11-24 21:26:13','administrador'),(29,'basico',NULL,'Administrador 2','Sistema',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,'2017-10-14 17:06:38','administrador','2017-10-14 20:58:12','administrador');
/*!40000 ALTER TABLE `perfil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfilExpedienteVoto`
--

DROP TABLE IF EXISTS `perfilExpedienteVoto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfilExpedienteVoto` (
  `idPerfilExpedienteVoto` int(11) NOT NULL AUTO_INCREMENT,
  `idPerfil` int(11) DEFAULT NULL,
  `idExpediente` int(11) DEFAULT NULL,
  `idTipoVoto` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`idPerfilExpedienteVoto`),
  KEY `perfilExpedienteVoto_tipoVoto_idx` (`idTipoVoto`),
  KEY `perfilExpedienteVoto_perfil_idx` (`idPerfil`),
  KEY `perfilExpedienteVoto_expediente_idx` (`idExpediente`),
  CONSTRAINT `fk_perfilExpedienteVoto_expediente` FOREIGN KEY (`idExpediente`) REFERENCES `expediente` (`idExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfilExpedienteVoto_perfil` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfilExpedienteVoto_tipoVoto` FOREIGN KEY (`idTipoVoto`) REFERENCES `tipoVoto` (`idTipoVoto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfilExpedienteVoto`
--

LOCK TABLES `perfilExpedienteVoto` WRITE;
/*!40000 ALTER TABLE `perfilExpedienteVoto` DISABLE KEYS */;
/*!40000 ALTER TABLE `perfilExpedienteVoto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plantillaTexto`
--

DROP TABLE IF EXISTS `plantillaTexto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plantillaTexto` (
  `idPlantillaTexto` int(11) NOT NULL AUTO_INCREMENT,
  `plantillaTexto` varchar(1000) NOT NULL,
  `idTipoPlantillaTexto` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`idPlantillaTexto`),
  KEY `plantillaTexto_tipoPlantillaTexto_idx` (`idTipoPlantillaTexto`),
  CONSTRAINT `fk_plantillaTexto_tipoPlantillaTexto` FOREIGN KEY (`idTipoPlantillaTexto`) REFERENCES `tipoPlantillaTexto` (`idTipoPlantillaTexto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `proyecto`
--

DROP TABLE IF EXISTS `proyecto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyecto` (
  `idProyecto` int(11) NOT NULL AUTO_INCREMENT,
  `idExpediente` int(11) DEFAULT NULL,
  `idTipoProyecto` smallint(6) DEFAULT NULL,
  `idConcejal` int(11) DEFAULT NULL,
  `clavesBusqueda` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visto` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `considerandos` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `articulos` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json_array)',
  `fechaCreacion` datetime NOT NULL,
  `usuarioCreacion` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `usuarioModificacion` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idProyecto`),
  UNIQUE KEY `UNIQ_proyecto_expediente_idx` (`idExpediente`),
  KEY `proyecto_tipoProyecto_idx` (`idTipoProyecto`),
  KEY `proyecto_concejal_idx` (`idConcejal`),
  CONSTRAINT `fk_proyecto_concejal` FOREIGN KEY (`idConcejal`) REFERENCES `perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyecto_expediente` FOREIGN KEY (`idExpediente`) REFERENCES `expediente` (`idExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyecto_tipoProyecto` FOREIGN KEY (`idTipoProyecto`) REFERENCES `tipoProyecto` (`idTipoProyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `proyectoRevision`
--

DROP TABLE IF EXISTS `proyectoRevision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyectoRevision` (
  `idProyectoRevision` int(11) NOT NULL AUTO_INCREMENT,
  `idProyecto` int(11) DEFAULT NULL,
  `idOficina` int(11) DEFAULT NULL,
  `incluyeVistosYConsiderandos` tinyint(1) NOT NULL,
  `visto` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `considerandos` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `articulos` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json_array)',
  `fechaCreacion` datetime NOT NULL,
  `usuarioCreacion` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `usuarioModificacion` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idProyectoRevision`),
  KEY `proyectoRevision_proyecto_idx` (`idProyecto`),
  KEY `proyectoRevision_oficina_idx` (`idOficina`),
  CONSTRAINT `fk_proyectoRevision_oficina` FOREIGN KEY (`idOficina`) REFERENCES `oficina` (`idOficina`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyectoRevision_proyecto` FOREIGN KEY (`idProyecto`) REFERENCES `proyecto` (`idProyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `remito`
--

DROP TABLE IF EXISTS `remito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `remito` (
  `idRemito` int(11) NOT NULL AUTO_INCREMENT,
  `idDestino` int(11) DEFAULT NULL,
  `idOrigen` int(11) DEFAULT NULL,
  `numeroRemito` int(11) DEFAULT NULL,
  `fechaRecepcion` datetime DEFAULT NULL,
  `anulado` tinyint(1) DEFAULT NULL,
  `motivoAnulacion` varchar(150) DEFAULT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`idRemito`),
  KEY `remito_oficinaDestino_idx` (`idDestino`),
  KEY `remito_oficinaOrigen_idx` (`idOrigen`),
  CONSTRAINT `fk_remito_oficinaDestino` FOREIGN KEY (`idDestino`) REFERENCES `oficina` (`idOficina`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_remito_oficinaOrigen` FOREIGN KEY (`idOrigen`) REFERENCES `oficina` (`idOficina`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;


/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/  /*!50003 TRIGGER `remito_BEFORE_INSERT` BEFORE INSERT ON `remito` FOR EACH ROW
BEGIN
    if(select IdtipoOficina from oficina where idOficina=NEW.idDestino)=2 then
		set NEW.numeroRemito=(select max(numeroRemito) from remito)+1;
	end if;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol` (
  `idRol` smallint(6) NOT NULL AUTO_INCREMENT,
  `rol` varchar(45) NOT NULL,
  `idOficina` int(11) DEFAULT NULL,
  `oficinaObligatoria` tinyint(1) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`idRol`),
  KEY `rol_oficina_idx` (`idOficina`),
  CONSTRAINT `fk_rol_Oficina` FOREIGN KEY (`idOficina`) REFERENCES `oficina` (`idOficina`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'ROLE_LEGISLADOR',NULL,0,1),(2,'ROLE_ADMINISTRADOR',NULL,0,1),(3,'ROLE_ADMINISTRADOR_SESION',NULL,0,0),(4,'ROLE_MESA_ENTRADA',9,0,1),(5,'ROLE_COMISIONES',3,0,1),(6,'ROLE_DESPACHO',5,0,1),(7,'ROLE_SECRETARIA',14,0,1);
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol_menuItem`
--

DROP TABLE IF EXISTS `rol_menuItem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol_menuItem` (
  `idRol` smallint(6) NOT NULL,
  `idMenuItem` smallint(6) NOT NULL,
  PRIMARY KEY (`idRol`,`idMenuItem`),
  KEY `IDX_197953222F1D22B0` (`idRol`),
  KEY `IDX_19795322394077B3` (`idMenuItem`),
  CONSTRAINT `FK_197953222F1D22B0` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`),
  CONSTRAINT `FK_19795322394077B3` FOREIGN KEY (`idMenuItem`) REFERENCES `menuItem` (`idMenuItem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol_menuItem`
--

LOCK TABLES `rol_menuItem` WRITE;
/*!40000 ALTER TABLE `rol_menuItem` DISABLE KEYS */;
INSERT INTO `rol_menuItem` VALUES (1,8),(1,9),(1,10),(2,3),(2,4),(2,5),(2,8),(2,9),(2,10),(2,11),(2,12),(2,13),(2,14),(2,15),(2,16),(2,17),(2,18),(2,19),(2,20),(2,21),(2,22),(2,24),(2,27),(2,28),(2,29),(2,30),(2,31),(2,52),(2,53),(2,54),(2,55),(2,56),(2,57),(2,58),(2,59),(2,60),(2,64),(4,1),(4,2),(4,3),(4,4),(4,5),(4,6),(4,8),(4,9),(4,10),(4,22),(4,23),(4,24),(4,25),(4,26),(4,31),(4,49),(4,50),(4,57),(4,58),(4,59),(4,61),(4,62),(4,64),(5,6),(5,11),(5,12),(5,13),(5,14),(5,22),(5,23),(5,24),(5,38),(5,39),(5,40),(5,41),(5,42),(5,43),(5,44),(5,63),(6,6),(6,15),(6,16),(6,17),(6,22),(6,23),(6,24),(6,27),(6,28),(6,29),(6,30),(6,31),(6,32),(6,41),(6,45),(6,46),(6,47),(6,48),(6,49),(6,50),(6,54),(6,55),(6,56),(6,57),(6,60),(6,61),(6,62),(6,63),(6,64);
/*!40000 ALTER TABLE `rol_menuItem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sancion`
--

DROP TABLE IF EXISTS `sancion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sancion` (
  `idSancion` int(11) NOT NULL AUTO_INCREMENT,
  `idDictamen` int(11) DEFAULT NULL,
  `idEncabezadoRedaccion` int(11) DEFAULT NULL,
  `idPieRedaccion` int(11) DEFAULT NULL,
  `discriminador` varchar(17) NOT NULL,
  `textoLibre` longtext,
  `textoArticulado` longtext COMMENT '(DC2Type:json_array)',
  `idTipoSancion` smallint(6) DEFAULT NULL,
  `idProyectoRevision` int(11) DEFAULT NULL,
  `idNotificacion` int(11) DEFAULT NULL,
  `idPase` int(11) DEFAULT NULL,
  `numeroSancion` varchar(9) DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  PRIMARY KEY (`idSancion`),
  KEY `sancion_proyectoRevision_idx` (`idProyectoRevision`),
  KEY `sancion_notificacion_idx` (`idNotificacion`),
  KEY `sancion_dictamen_idx` (`idDictamen`),
  KEY `sancion_tipoSancion_idx` (`idTipoSancion`),
  KEY `sancion_pase_idx` (`idPase`),
  KEY `sancion_encabezadoRedaccion_idx` (`idEncabezadoRedaccion`),
  KEY `sancion_pieRedaccion_idx` (`idPieRedaccion`),
  CONSTRAINT `fk_sancion_dictamen` FOREIGN KEY (`idDictamen`) REFERENCES `dictamen` (`idDictamen`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_sancion_encabezadoRedaccion` FOREIGN KEY (`idEncabezadoRedaccion`) REFERENCES `plantillaTexto` (`idPlantillaTexto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_sancion_notificacion` FOREIGN KEY (`idNotificacion`) REFERENCES `movimiento` (`idMovimiento`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_sancion_pase` FOREIGN KEY (`idPase`) REFERENCES `movimiento` (`idMovimiento`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_sancion_pieRedaccion` FOREIGN KEY (`idPieRedaccion`) REFERENCES `plantillaTexto` (`idPlantillaTexto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_sancion_proyectoRevision` FOREIGN KEY (`idProyectoRevision`) REFERENCES `proyectoRevision` (`idProyectoRevision`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_sancion_tipoResolucion` FOREIGN KEY (`idTipoSancion`) REFERENCES `tipoProyecto` (`idTipoProyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `sesion`
--

DROP TABLE IF EXISTS `sesion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sesion` (
  `idSesion` int(11) NOT NULL AUTO_INCREMENT,
  `idTipoSesion` smallint(6) DEFAULT NULL,
  `descripcion` varchar(50) NOT NULL,
  `fecha` datetime NOT NULL,
  `tieneOrdenDelDia` tinyint(1) NOT NULL,
  `tieneUltimoMomento` tinyint(1) NOT NULL,
  `presentes` smallint(6) DEFAULT NULL,
  `quorum` tinyint(1) DEFAULT NULL,
  `periodo` smallint(4) NOT NULL,
  `tieneEdicionBloqueada` tinyint(1) NOT NULL,
  `cantidadExpedientes` int(11) NOT NULL,
  PRIMARY KEY (`idSesion`),
  KEY `sesion_tipoSesion_idx` (`idTipoSesion`),
  CONSTRAINT `fk_sesion_tipoSesion` FOREIGN KEY (`idTipoSesion`) REFERENCES `tipoSesion` (`idTipoSesion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `tipoComision`
--

DROP TABLE IF EXISTS `tipoComision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoComision` (
  `idTipoComision` smallint(6) NOT NULL AUTO_INCREMENT,
  `tipoComision` varchar(20) NOT NULL,
  PRIMARY KEY (`idTipoComision`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoComision`
--

LOCK TABLES `tipoComision` WRITE;
/*!40000 ALTER TABLE `tipoComision` DISABLE KEYS */;
INSERT INTO `tipoComision` VALUES (1,'Transitoria'),(2,'Permanente');
/*!40000 ALTER TABLE `tipoComision` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoExpediente`
--

DROP TABLE IF EXISTS `tipoExpediente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoExpediente` (
  `idTipoExpediente` smallint(6) NOT NULL AUTO_INCREMENT,
  `tipoExpediente` varchar(45) NOT NULL,
  `letra` varchar(1) NOT NULL,
  PRIMARY KEY (`idTipoExpediente`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoExpediente`
--

LOCK TABLES `tipoExpediente` WRITE;
/*!40000 ALTER TABLE `tipoExpediente` DISABLE KEYS */;
INSERT INTO `tipoExpediente` VALUES (1,'Comunicacion','P'),(2,'Ordenanza','P'),(3,'Particular','W'),(4,'Poder Ejecutivo A)','D'),(5,'Interno','I'),(6,'Resolucion','P'),(7,'Decreto','P'),(8,'Sesion Extraodinaria','V'),(9,'Poder Ejecutivo B)','D');
/*!40000 ALTER TABLE `tipoExpediente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoExpedienteSesion`
--

DROP TABLE IF EXISTS `tipoExpedienteSesion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoExpedienteSesion` (
  `idTipoExpedienteSesion` int(11) NOT NULL AUTO_INCREMENT,
  `tipoExpedienteSesion` varchar(70) NOT NULL,
  `letra` varchar(2) NOT NULL,
  PRIMARY KEY (`idTipoExpedienteSesion`),
  KEY `letra_idx` (`letra`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoExpedienteSesion`
--

LOCK TABLES `tipoExpedienteSesion` WRITE;
/*!40000 ALTER TABLE `tipoExpedienteSesion` DISABLE KEYS */;
INSERT INTO `tipoExpedienteSesion` VALUES (22,'Mensajes del Departamento Ejecutivo','A'),(23,'Mensajes del Departamento Ejecutivo Girados a Comisiones','B'),(24,'Proyectos','C'),(25,'Expedientes con Respuesta','CH'),(26,'Proyectos Girados a Comisiones','D'),(27,'Peticiones Particulares','E'),(28,'Comisión de Presupesto y Hacienda','F'),(29,'Comisión de Obras Públicas y Urbanismo','G'),(30,'Comisión de Servicios Publicos','H'),(31,'Comisión de Derechos y Garantías','K'),(32,'Labor Legislativa','L'),(33,'Comisión de Industria y Comercio Interior y Exterior','M'),(34,'Comisión de Habitat, Tierrras y Viviendas','N'),(35,'Comisión de Medios de Comunicación Social','O'),(36,'Comisión de Seguridad y Justicia','P'),(37,'Comisión de Mujeres y Equidad de Genero','Q'),(38,'Comisión de Cultura y Educación ','R'),(39,'Comisión de Promoción de la Comunidad','S'),(40,'Comisión de Defensa del Usuario','T'),(41,'Comisión de Planeamiento','W'),(42,'Comisión de Interpretación y Reglamento','X'),(43,'Comisión de Ecología y Protección del Medio Ambiente','Y'),(44,'Dictamenes Conjuntos','Z'),(45,'Ultimo Momento','U');
/*!40000 ALTER TABLE `tipoExpedienteSesion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoMovimiento`
--

DROP TABLE IF EXISTS `tipoMovimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoMovimiento` (
  `idTipoMovimiento` smallint(6) NOT NULL AUTO_INCREMENT,
  `tipoMovimiento` varchar(55) NOT NULL,
  PRIMARY KEY (`idTipoMovimiento`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoMovimiento`
--

LOCK TABLES `tipoMovimiento` WRITE;
/*!40000 ALTER TABLE `tipoMovimiento` DISABLE KEYS */;
INSERT INTO `tipoMovimiento` VALUES (1,'Pase'),(2,'Solicitud Informe'),(3,'Solicitud Informe Con Pase');
/*!40000 ALTER TABLE `tipoMovimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoNumeroDictamen`
--

DROP TABLE IF EXISTS `tipoNumeroDictamen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoNumeroDictamen` (
  `idTipoNumeroDictamen` smallint(6) NOT NULL AUTO_INCREMENT,
  `tipoNumeroDictamen` varchar(15) NOT NULL,
  PRIMARY KEY (`idTipoNumeroDictamen`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoNumeroDictamen`
--

LOCK TABLES `tipoNumeroDictamen` WRITE;
/*!40000 ALTER TABLE `tipoNumeroDictamen` DISABLE KEYS */;
INSERT INTO `tipoNumeroDictamen` VALUES (1,'Mayoría'),(2,'Primer Minoría'),(3,'Segunda Minoría');
/*!40000 ALTER TABLE `tipoNumeroDictamen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoOficina`
--

DROP TABLE IF EXISTS `tipoOficina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoOficina` (
  `idTipoOficina` smallint(6) NOT NULL AUTO_INCREMENT,
  `tipoOficina` varchar(15) NOT NULL,
  PRIMARY KEY (`idTipoOficina`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoOficina`
--

LOCK TABLES `tipoOficina` WRITE;
/*!40000 ALTER TABLE `tipoOficina` DISABLE KEYS */;
INSERT INTO `tipoOficina` VALUES (1,'Interna'),(2,'Externa');
/*!40000 ALTER TABLE `tipoOficina` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoPerfil`
--

DROP TABLE IF EXISTS `tipoPerfil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoPerfil` (
  `idTipoPerfil` smallint(6) NOT NULL AUTO_INCREMENT,
  `tipoPerfil` varchar(50) NOT NULL,
  PRIMARY KEY (`idTipoPerfil`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoPerfil`
--

LOCK TABLES `tipoPerfil` WRITE;
/*!40000 ALTER TABLE `tipoPerfil` DISABLE KEYS */;
INSERT INTO `tipoPerfil` VALUES (1,'Administrativo'),(2,'Legislador'),(3,'Público');
/*!40000 ALTER TABLE `tipoPerfil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoPerfil_rol`
--

DROP TABLE IF EXISTS `tipoPerfil_rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoPerfil_rol` (
  `idTipoPerfil` smallint(6) NOT NULL,
  `idRol` smallint(6) NOT NULL,
  PRIMARY KEY (`idTipoPerfil`,`idRol`),
  KEY `IDX_F4C8E6BB2F1D22B0` (`idRol`),
  KEY `IDX_F4C8E6BB9FB91BCF` (`idTipoPerfil`),
  CONSTRAINT `fk_tipoPerfil_rol_rol` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tipoPerfil_rol_tipoPerfil` FOREIGN KEY (`idTipoPerfil`) REFERENCES `tipoPerfil` (`idTipoPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoPerfil_rol`
--

LOCK TABLES `tipoPerfil_rol` WRITE;
/*!40000 ALTER TABLE `tipoPerfil_rol` DISABLE KEYS */;
INSERT INTO `tipoPerfil_rol` VALUES (2,1),(1,2),(2,2),(2,3),(1,4),(1,5),(1,6),(1,7);
/*!40000 ALTER TABLE `tipoPerfil_rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoPlantillaTexto`
--

DROP TABLE IF EXISTS `tipoPlantillaTexto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoPlantillaTexto` (
  `idTipoPlantillaTexto` smallint(6) NOT NULL AUTO_INCREMENT,
  `tipoPlantillaTexto` varchar(15) NOT NULL,
  PRIMARY KEY (`idTipoPlantillaTexto`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoPlantillaTexto`
--

LOCK TABLES `tipoPlantillaTexto` WRITE;
/*!40000 ALTER TABLE `tipoPlantillaTexto` DISABLE KEYS */;
INSERT INTO `tipoPlantillaTexto` VALUES (1,'Encabezado'),(2,'Pie');
/*!40000 ALTER TABLE `tipoPlantillaTexto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoProyecto`
--

DROP TABLE IF EXISTS `tipoProyecto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoProyecto` (
  `idTipoProyecto` smallint(6) NOT NULL AUTO_INCREMENT,
  `tipoProyecto` varchar(30) NOT NULL,
  `idTipoExpediente` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`idTipoProyecto`),
  KEY `tipoProyecto_tipoExpediente_idx` (`idTipoExpediente`),
  CONSTRAINT `fk_tipoProyecto_tipoExpediente` FOREIGN KEY (`idTipoExpediente`) REFERENCES `tipoExpediente` (`idTipoExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoProyecto`
--

LOCK TABLES `tipoProyecto` WRITE;
/*!40000 ALTER TABLE `tipoProyecto` DISABLE KEYS */;
INSERT INTO `tipoProyecto` VALUES (1,'Comunicación',1),(2,'Ordenanza',2),(3,'Resolución',6),(4,'Decreto',7);
/*!40000 ALTER TABLE `tipoProyecto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoSesion`
--

DROP TABLE IF EXISTS `tipoSesion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoSesion` (
  `idTipoSesion` smallint(6) NOT NULL AUTO_INCREMENT,
  `tipoSesion` varchar(50) NOT NULL,
  `abreviacion` varchar(2) NOT NULL,
  PRIMARY KEY (`idTipoSesion`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoSesion`
--

LOCK TABLES `tipoSesion` WRITE;
/*!40000 ALTER TABLE `tipoSesion` DISABLE KEYS */;
INSERT INTO `tipoSesion` VALUES (1,'Ordinaria','O'),(2,'Extra Ordinaria','E'),(3,'Mayores Contribuyentes','M'),(4,'Especial','ES');
/*!40000 ALTER TABLE `tipoSesion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipoVoto`
--

DROP TABLE IF EXISTS `tipoVoto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoVoto` (
  `idTipoVoto` smallint(6) NOT NULL AUTO_INCREMENT,
  `tipoVoto` varchar(45) NOT NULL,
  PRIMARY KEY (`idTipoVoto`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoVoto`
--

LOCK TABLES `tipoVoto` WRITE;
/*!40000 ALTER TABLE `tipoVoto` DISABLE KEYS */;
INSERT INTO `tipoVoto` VALUES (1,'A Favor'),(2,'En Contra');
/*!40000 ALTER TABLE `tipoVoto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(70) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `idPerfil` int(11) DEFAULT NULL,
  `idRol` smallint(6) DEFAULT NULL,
  `permisos` longtext NOT NULL COMMENT '(DC2Type:json_array)',
  `activo` tinyint(1) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `UNIQ_usuario_idx` (`usuario`),
  UNIQUE KEY `UNIQ_usuario_perfil_idx` (`idPerfil`),
  KEY `usuario_rol_idx` (`idRol`),
  CONSTRAINT `fk_usuario_perfil` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'administrador','$2y$13$tn2xZbWlSbUt/wvy4HkwV.U5w5F.9ucCEGPcuvaqrVW2GK6PELRd6',1,2,'[\"BLOQ_ADD\",\"BLOQ_EDIT\",\"BLOQ_DEL\",\"COM_ADD\",\"COM_DET\",\"COM_EDIT\",\"COM_DEL\",\"CON_ADD\",\"CON_EDIT\",\"CON_DEL\",\"EXP_ARCH\",\"EXP_MOVEMENT\",\"EXP_DES_ARCH\",\"EXP_DOWNLOAD\",\"EXP_EDIT\",\"EXP_FEC_ING_EDIT\",\"MOV_ABORT\",\"MOV_DOWNLOAD\",\"OFF_DEL\",\"PROJ_NEW\",\"PROJ_DOWNLOAD\",\"PROJ_EDIT\",\"SES_ADD\",\"SES_EDIT_BLOQ\",\"SES_OD_DOWNLOAD\",\"SES_UM_DOWNLOAD\",\"SES_EDIT\",\"SES_OD_DEL\",\"SES_OD_NEW\",\"SES_UM_NEW\",\"USR_ADD\",\"USR_LOCK\",\"USR_UNLOCK\",\"USR_EDIT\"]',1,'2017-05-21 21:27:30','administrador','2017-11-24 21:26:50','Administrador2'),(2,'mesaHCD','$2y$13$Y5Gg/nStOtTu0QGernRlkOS66EtYAf/5Xoat8NIMETnC8e6JlZY/G',26,4,'[\"EXP_NEW\",\"EXP_ARCH\",\"EXP_MOVEMENT\",\"EXP_DES_ARCH\",\"EXP_DOWNLOAD\",\"EXP_EDIT\",\"EXP_SES_EDIT\",\"EXP_ADD\",\"EXP_REPORT_RETURN\",\"EXP_ULT_MOM\",\"EXP_RETURN\",\"MOV_NEW\",\"MOV_ABORT\",\"MOV_DOWNLOAD\",\"MOV_RECEIVE\",\"OFF_ADD\",\"OFF_EDIT\",\"OFF_DEL\",\"PROJ_NEW\",\"PROJ_DOWNLOAD\",\"PROJ_EDIT\",\"SES_OD_DOWNLOAD\",\"SES_UM_DOWNLOAD\"]',1,'2017-07-28 17:39:45','administrador','2017-11-24 21:25:59','administrador'),(3,'comisionesHCD','$2y$13$5ErEhZZzRJozdaCm00G8NO/foaNWSEYkgbgB/s17aEH3Fe0PqME2O',27,5,'[\"COM_ADD\",\"COM_DET\",\"COM_EDIT\",\"COM_DEL\",\"COM_EXP_ADD\",\"COM_EXP_DICT_ADD\",\"COM_EXP_COM_EDIT\",\"COM_EXP_EDIT_SES\",\"COM_EXP_DICT_DOWNLOAD\",\"COM_EXP_DICT_EDIT\",\"COM_EXP_DEL\",\"DIC_ULT_MOM\",\"MOV_NEW\",\"MOV_ABORT\",\"MOV_DOWNLOAD\",\"MOV_RECEIVE\"]',1,'2017-07-28 17:51:54','administrador','2017-11-23 10:48:21','administrador'),(4,'baloiraE','$2y$13$CTxtKSJLsKP9DVA2pDja7.K0DVgJou4W1iIUbOKLFy6uacSLMBlYK',14,1,'[\"PROJ_NEW\",\"PROJ_DOWNLOAD\",\"PROJ_EDIT\"]',1,'2017-08-09 20:11:45','administrador','2017-10-14 21:50:27','administrador'),(5,'despachoHCD','$2y$13$tHiDGagoize5Q5NEGpeSHeaH9mOhPqj19dXWB/h9dSBF8OB6PUWem',28,6,'[\"BLOQ_ADD\",\"BLOQ_EDIT\",\"BLOQ_DEL\",\"CON_ADD\",\"CON_EDIT\",\"CON_DEL\",\"EXP_SES_EDIT\",\"EXP_ULT_MOM\",\"COM_EXP_EDIT_SES\",\"DIC_ULT_MOM\",\"MOV_NEW\",\"MOV_ABORT\",\"MOV_DOWNLOAD\",\"MOV_RECEIVE\",\"OFF_ADD\",\"OFF_EDIT\",\"OFF_DEL\",\"DESP_SANC_ADD\",\"DESP_SANC_EDIT\",\"SES_ADD\",\"SES_OD_DOWNLOAD\",\"SES_UM_DOWNLOAD\",\"SES_EDIT\",\"SES_OD_DEL\",\"SES_OD_NEW\",\"SES_UM_NEW\",\"DESP_VER_TAQ_ADD\",\"DESP_VER_TAQ_EDIT\",\"DESP_VER_TAQ_DEL\"]',1,'2017-10-11 21:20:13','administrador','2017-11-24 21:26:13','administrador'),(6,'Administrador2','$2y$13$fuXM2jSl4ttvCCbFG6K0Re9.CAGMjdqZFOnIzLSLDfr80MgReTJ0W',29,2,'[\"BLOQ_ADD\",\"BLOQ_EDIT\",\"BLOQ_DEL\",\"COM_ADD\",\"COM_DET\",\"COM_EDIT\",\"COM_DEL\",\"CON_ADD\",\"CON_EDIT\",\"CON_DEL\",\"EXP_MOVEMENT\",\"EXP_DOWNLOAD\",\"EXP_EDIT\",\"EXP_FEC_ING_EDIT\",\"MOV_ABORT\",\"MOV_DOWNLOAD\",\"OFF_DEL\",\"PROJ_NEW\",\"PROJ_DOWNLOAD\",\"PROJ_EDIT\",\"SES_ADD\",\"SES_EDIT_BLOQ\",\"SES_OD_DOWNLOAD\",\"SES_EDIT\",\"SES_OD_DEL\",\"SES_OD_NEW\",\"USR_ADD\",\"USR_LOCK\",\"USR_UNLOCK\",\"USR_EDIT\"]',1,'2017-10-14 17:06:38','administrador','2017-10-14 20:58:12','administrador'),(7,'SierraS','$2y$13$B1kUQjGadzorksylUMSHeuj743S2Ic5aLJraAPAa4axJRSBlZ9e/a',22,1,'[\"PROJ_NEW\",\"PROJ_DOWNLOAD\",\"PROJ_EDIT\"]',1,'2017-10-17 23:21:33','administrador',NULL,NULL);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `versionTaquigrafica`
--

DROP TABLE IF EXISTS `versionTaquigrafica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `versionTaquigrafica` (
  `idVersionTaquigrafica` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(1000) NOT NULL,
  `idSesion` int(11) DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`idVersionTaquigrafica`),
  KEY `versionTaquigrafica_sesion_idx` (`idSesion`),
  CONSTRAINT `fk_versionTaquigrafica_sesion` FOREIGN KEY (`idSesion`) REFERENCES `sesion` (`idSesion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Temporary table structure for view `vw_sesiones_habiles`
--

DROP TABLE IF EXISTS `vw_sesiones_habiles`;
/*!50001 DROP VIEW IF EXISTS `vw_sesiones_habiles`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vw_sesiones_habiles` AS SELECT 
 1 AS `idSesion`,
 1 AS `descripcion`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping routines for database 'sistema_legislativo'
--
/*!50003 DROP FUNCTION IF EXISTS `conformarDictamenArticulado` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE FUNCTION `conformarDictamenArticulado`(texto text,articulos text,tipo varchar(45)) RETURNS text CHARSET utf8mb4
BEGIN
	
    declare html text default '';
	set html=concat(html,formatParrafo(texto));
    set html=concat(html,'<h5>',upper(tipo),'</h5>');
    set html=concat(html,formatArticulos(articulos));
    
    select replace(html,'<br>','<p></p>') into html;
    
	RETURN html;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `conformarNumerosExternos` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE FUNCTION `conformarNumerosExternos`(arrayNumeros text) RETURNS text CHARSET utf8mb4
BEGIN
	
    declare cantidadArticulos int default 0;
    declare numeroJSON text; 
    declare ente varchar(4);
	declare numero varchar(8);
	declare letra varchar(1);
	declare folios varchar(3);
	declare año varchar(4);
    -- declare representacionHTML text default '';
    
	set @cantidadElementos=JSON_LENGTH(arrayNumeros);
    set @elemento:=0;
    set @representacionHTML='';
    
    if @cantidadElementos>0 then
    
		repeat
		
			set @elementoActual:=concat('$[',convert(@elemento,char(2)),']');
			set numeroJSON=json_extract(arrayNumeros,@elementoActual);
			set ente=trim(both '"'from json_extract(numeroJSON,'$.ente'));
			set numero=trim(both '"'from json_extract(numeroJSON,'$.numero'));
			set letra=trim(both '"'from json_extract(numeroJSON,'$.letra'));
			set folios=trim(both '"'from json_extract(numeroJSON,'$.folios'));
			set año=trim(both '"'from json_extract(numeroJSON,'$.año'));
			
			set @representacionHTML=concat( 
											@representacionHTML,
											ente,'-',numero,'|',substring(año,3),
											'|',upper(letra),'|',folios,
											if (@elemento<@cantidadElementos,
											    ',','')
										   );
                                   
			set @elemento=@elemento+1;
                                   
		until @elemento=@cantidadElementos end repeat;
        
	end if;
		
RETURN @representacionHTML;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `conformarProyecto` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE FUNCTION `conformarProyecto`(visto text,considerando text,articulos text,tipo varchar(45), incluyeVistosYConsiderandos tinyint(1), esDictamen tinyint(1), imprimeFecha tinyint(1)) RETURNS text CHARSET utf8mb4
BEGIN
    
    declare html text default '';
    
    SET lc_time_names = 'es_AR';
    if (imprimeFecha=1) then
		set html=concat('<h6>Lomas de Zamora, ',
						replace(DATE_FORMAT(curdate(),  "%d %M %Y"),' ',' de '),
                        '.-<\/h6>');
	end if;
    if (incluyeVistosYConsiderandos=1) then
		set html=concat(html,'<h5><u>PROYECTO DE ',
						upper(tipo),'<\/u></h5>');
		set html=concat(html,'<h7><u>VISTOS<\/u></h7>');
		set html=concat(html,formatParrafo(visto));
		set html=concat(html,'<h7><u>CONSIDERANDOS<\/u></h7>');
		set html=concat(html,formatParrafo(considerando));
	end if;
    if(esDictamen=0) then
		set html=concat(html,'<h7><u>POR TODO ELLO:<\/u><\/h7>');
        set @parrafo=concat('<p>EL HONORABLE CONCEJO DELIBERANTE DE LOMAS DE ZAMORA EN EL USO DE LAS FACULTADES QUE LE SON PROPIAS SANCIONA ',
							if (tipo='decreto','EL','LA'),' SIGUIENTE:<\/p>');
        set html=concat(html,'<strong>',formatParrafo(@parrafo),'<\/strong>');    
    end if;
    set html=concat(html,'<h5><u>',upper(tipo),'<\/u></h5>');
    set html=concat(html,formatArticulos(articulos));
    
    select replace(html,'<br>','<p></p>') into html;
    
	RETURN html;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `formatArticulos` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE FUNCTION `formatArticulos`(arrayArticulosJSON text) RETURNS text CHARSET utf8mb4
BEGIN
	
    declare cantidadArticulos INT;
    declare cantidadIncisos int;
    declare articuloJSON text;
    declare articulo text; 
    declare articuloPreFormateado text;
    declare ordenArticulo varchar(2);
    declare incisoJSON text;
    declare arrayIncisosJSON text;
    declare ordenInciso varchar(2);
    declare inciso text;
    declare incisoPreFormateado text;
    
    
    declare representacionHTML text default '';
    declare representacionIncisosHTML text default '';
    declare pgph_style_inciso varchar(70) default '<p style="text-align: justify;margin-top: 0;">';
    declare pgph_style_articulo varchar(88) default '<p style="text-align: justify;margin-top: 0;">';
    declare list_style varchar(100) default '<ul style="list-style-type: none;">';
    
    set cantidadArticulos=JSON_LENGTH(arrayArticulosJSON);
    set @numeroArticulo:=0;
    
    repeat
    
		set @articuloActual:=concat('$[',convert(@numeroArticulo,char(2)),']');
        set articuloJSON=json_extract(arrayArticulosJSON,@articuloActual);
        set ordenArticulo=trim(both '"'from json_extract(articuloJSON,'$.numero'));
        set articulo=trim(both '"'from json_extract(articuloJSON,'$.texto'));
        
		#reemplaza los <p> por h9 al principio y al final de los parrafos del artículo
		set articuloPreFormateado:=replace(replace(replace(articulo,'<p>','<h9>'),'<\/p>','<\/h9>'),'<br>','<p><\/p>');
		#primer parrafo del artículo
        set @primerParrafo:=concat('<h9><strong><u>ARTICULO ',ordenArticulo,
							       '<\/u>°.-<\/strong> ',
                                   substr(articuloPreFormateado,5,position('<\/h9>'in articuloPreFormateado)));
        #resto de los parrafos del artículo
        set @demasParrafos:=substr(articuloPreFormateado,position('<\/h9>'in articuloPreFormateado)+5,length(articuloPreFormateado));
		#contenido del artículo formateado
		set representacionHTML=concat(representacionHTML,@primerParrafo,@demasParrafos);
		
        set arrayIncisosJSON=json_extract(articuloJSON,'$.incisos');
        set cantidadIncisos=JSON_LENGTH(arrayIncisosJSON);
        
        if cantidadIncisos>0 then
        
			set representacionIncisosHTML='';
			set @numeroInciso:=0;
            
			repeat
								
                set @incisoActual:=concat('$[',convert(@numeroInciso,char(2)),']');
				set incisoJSON=json_extract(arrayIncisosJSON,@incisoActual);
				set ordenInciso=trim( both '"' from json_extract(incisoJSON,'$.orden'));
                set inciso=trim(both '"' from json_extract(incisoJSON,'$.texto'));
				
                #reemplaza los <p> por h9 al principio y al final de los parrafos del inciso
                set incisoPreFormateado:=replace(replace(replace(inciso,'<p>','<h10>'),'<\/p>','<\/h10>'),'<br>','<p><\/p>');
                #primer parrafo del inciso
				set @primerParrafo:=concat('<h10><strong>',ordenInciso,')<\/strong> ',
										   substr(incisoPreFormateado,6,position('<\/h10>'in incisoPreFormateado)));
				#resto de los parrafos del inciso
                set @demasParrafos:=substr(incisoPreFormateado,position('<\/h10>' in incisoPreFormateado)+6,
										   length(incisoPreFormateado));
				#contenido del inciso formateado
				set representacionIncisosHTML=concat(representacionIncisosHTML,@primerParrafo,@demasParrafos);
                
                set @numeroInciso:=@numeroInciso+1;
                
			until @numeroInciso=cantidadIncisos end repeat;
			
            set representacionHTML=concat(representacionHTML,list_style,representacionIncisosHTML,'</ul>');
            
        end if;
        
        set @numeroArticulo:=@numeroArticulo+1;
        
	until @numeroArticulo=cantidadArticulos end repeat;
        
RETURN representacionHTML;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `formatParrafo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE FUNCTION `formatParrafo`(parrafo text) RETURNS text CHARSET utf8mb4
BEGIN
	#declare pgph_style varchar(111) default '<p style="text-align: justify;margin-top: 0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	RETURN replace(replace(replace(parrafo,'<p><br>','<p>'),'<br><\/p>','<\/p>'),'<br>','<p></p>');
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `traerComisionesDictamen` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE FUNCTION `traerComisionesDictamen`(_idDictamen int) RETURNS text CHARSET utf8mb4
BEGIN

	declare comisiones text default '';
    
    SELECT 	concat('<h9><strong>',if(count(*)>1,'Comisiones','Comision'),'</strong></h9><ul><li>',
				   group_concat(c.comision separator '</li><li>'),'</li></ul>')
    INTO	comisiones
    FROM 	dictamen as d
    LEFT
    JOIN	expedienteComision as ec
    ON		d.idDictamen=ec.idDictamenMayoria
    INNER
    JOIN	comision as c
    ON		c.idComision=ec.idComision
    WHERE	d.idDictamen=_idDictamen
	GROUP
    BY		d.idDictamen;
    
    if (comisiones='') then

		SELECT 	concat('<p>',if(count(*)>1,'Comisiones','Comision'),'</p><ul><li>',
				group_concat(c.comision separator '</li><li>'),'</li></ul>')
		INTO	comisiones
		FROM 	dictamen as d
		LEFT
		JOIN	expedienteComision as ec
		ON		d.idDictamen=ec.idDictamenPrimeraMinoria
		INNER
		JOIN	comision as c
		ON		c.idComision=ec.idComision
        WHERE	d.idDictamen=_idDictamen
		GROUP
		BY		d.idDictamen;
	end if;
    
    if (comisiones='') then

		SELECT 	concat('<p>',if(count(*)>1,'Comisiones','Comision'),'</p><ul><li>',
				group_concat(c.comision separator '</li><li>'),'</li></ul>')
		INTO	comisiones
		FROM 	dictamen as d
		LEFT
		JOIN	expedienteComision as ec
		ON		d.idDictamen=ec.idDictamenSegundaMinoria
		INNER
		JOIN	comision as c
		ON		c.idComision=ec.idComision
        WHERE	d.idDictamen=_idDictamen
		GROUP
		BY		d.idDictamen;
	end if;
    
RETURN comisiones;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `traerComisionesExpediente` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE FUNCTION `traerComisionesExpediente`(_idExpediente int) RETURNS text CHARSET utf8mb4
BEGIN

	declare comisiones text default '';
    
    SELECT 	concat('<p>Girado a:</p><ul><li>',group_concat(c.comision separator '</li><li>'),'</li></ul>')
    INTO	comisiones
    FROM 	expediente as e
    INNER
    JOIN	expedienteComision as ec
    ON		e.idExpediente=ec.idExpediente
    INNER
    JOIN	comision as c
    ON		c.idComision=ec.IdComision
    INNER
    JOIN	estadoExpediente as ee
    ON		ee.idEstadoExpediente=e.idEstadoExpediente
    WHERE	e.idExpediente=_idExpediente
	GROUP
    BY		e.idExpediente;
			
RETURN comisiones;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `traerComisionesExpedienteParaTitulo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE FUNCTION `traerComisionesExpedienteParaTitulo`(_idDictamen int) RETURNS text CHARSET utf8mb4
BEGIN
	declare comisiones text default '';
    
    SELECT 	group_concat(c.comision separator '_')
    INTO	comisiones
    FROM 	dictamen as d
    LEFT
    JOIN	expedienteComision as ec
    ON		d.idDictamen=ec.idDictamenMayoria
    INNER
    JOIN	comision as c
    ON		c.idComision=ec.idComision
    WHERE	d.idDictamen=_idDictamen
	GROUP
    BY		d.idDictamen;
    
    if (comisiones='') then

		SELECT 	group_concat(c.comision separator '_')
		INTO	comisiones
		FROM 	dictamen as d
		LEFT
		JOIN	expedienteComision as ec
		ON		d.idDictamen=ec.idDictamenPrimeraMinoria
		INNER
		JOIN	comision as c
		ON		c.idComision=ec.idComision
		GROUP
		BY		d.idDictamen;
	end if;
    
    if (comisiones='') then

		SELECT 	group_concat(c.comision separator '_')
		INTO	comisiones
		FROM 	dictamen as d
		LEFT
		JOIN	expedienteComision as ec
		ON		d.idDictamen=ec.idDictamenSegundaMinoria
		INNER
		JOIN	comision as c
		ON		c.idComision=ec.idComision
		GROUP
		BY		d.idDictamen;
	end if;
			
RETURN replace(comisiones,',',' ');

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `traerLetrasExpedienteSesion` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE FUNCTION `traerLetrasExpedienteSesion`(_idExpediente int, _idSesion int) RETURNS varchar(255) CHARSET utf8mb4
BEGIN
	declare letras varchar(255) default '';

	select 	group_concat(temp.orden separator ' / ' )
    into  	letras
    from	(
			 select concat(t.letra,' ',es.ordenSesion) as orden, es.idExpediente
             from 	expedienteSesion es
             inner
             join	tipoExpedienteSesion t
             on		es.idTipoExpedienteSesion=t.idTipoExpedienteSesion
             where  es.idSesion=_idSesion and es.idExpediente=_idExpediente
    ) as temp
    group 
    by	temp.idExpediente;
    
RETURN letras;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `borrarOrdenDelDia` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE PROCEDURE `borrarOrdenDelDia`(_idSesion int)
BEGIN
	
    delete from expedienteSesion where idSesion=_idSesion;
    
    delete 	s
	from 	sancion s
    left
    join	expedienteSesion es
    on		s.idSancion=es.idSancion
    where   es.idSancion is null;
		
	update 	sesion
    set		tieneOrdenDelDia=0,
			tieneUltimoMomento=0,
			cantidadExpedientes=0
	where 	idSesion=_idSesion;
    
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `conformarDictamen` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE PROCEDURE `conformarDictamen`(IN _idDictamen INT)
BEGIN

	declare _numeroExpediente varchar(12) default '';
    
    select  distinct concat(e.numeroExpediente,'-',t.letra,'-',e.periodo)
    into	_numeroExpediente
    from	expediente e
    inner
    join	tipoExpediente t
    on		e.idTipoExpediente=t.idTipoExpediente
    inner
    join	expedienteComision ec
    on		e.idExpediente=ec.idExpediente
    left
    join	dictamen dm
    on		ec.idDictamenMayoria=dm.idDictamen
    left
    join	dictamen dpm
    on		ec.idDictamenPrimeraMinoria=dpm.idDictamen
    left
    join	dictamen dsm
    on		ec.idDictamenSegundaMinoria=dsm.idDictamen
    where 	dm.idDictamen=_idDictamen or 
			dpm.idDictamen=_idDictamen or 
            dsm.idDictamen=_idDictamen;

	select 	concat('<h3><strong>Expediente: ',_numeroExpediente,'<\/strong><\/h3>',
			traerComisionesDictamen(_idDictamen),'<em><p><\/p>',
			formatParrafo(d.textoLibre),'<\/em><p><\/p>',
			if(d.discriminador='revision' and incluyeVistosYConsiderandos=1,
				concat('<h5><u>PROYECTO DE ', upper(tpp.tipoProyecto),'<\/u><\/h5>'),
                ''),
			case when d.discriminador='revision' and
					  pr.incluyeVistosYConsiderandos=1
                      then concat('<h7><u>VISTOS<\/u><\/h7>',formatParrafo(pr.visto))
				 else ''
			end,
            case when d.discriminador='revision' and
					  pr.incluyeVistosYConsiderandos=1
                      then concat('<h7><u>CONSIDERANDOS<\/u><\/h7>',formatParrafo(pr.considerandos))
				 else ''
			end,
            if (d.discriminador='revision' and  pr.incluyeVistosYConsiderandos=1,
				concat('<h7><u>POR TODO ELLO:<\/u><\/h7>',
						formatParrafo(concat('<p><strong>SE SUGIERE LA SANCIÓN DE ',
                               IF (tpd.idTipoProyecto=4,'EL','LA'),' SIGUIENTE:<\/strong></p>'))),
				''),
            if (d.discriminador<>'basico','<h5><u>',''),
            case when d.discriminador='articulado' 
                      then upper(tpd.tipoProyecto)
				 when d.discriminador='revision' 
                      then upper(tpp.tipoProyecto)
				 else ''
			end,
			if (d.discriminador<>'basico','<\/u><\/h5>',''),
            case when d.discriminador='articulado'
					  then formatArticulos(d.textoArticulado)
				 when d.discriminador='revision'
					  then formatArticulos(pr.articulos)
				 else ''
			end) as texto,
            _numeroExpediente as expediente,
            traerComisionesExpedienteParaTitulo(_idDictamen) as comisiones
    from 	dictamen d
    left
    join	tipoProyecto tpd
    on		d.idTipoDictamen=tpd.idTipoProyecto
    left
    join	proyectoRevision pr
    on 		d.idProyectoRevision=pr.idProyectoRevision
    left
    join	proyecto p
    on		pr.idProyecto=p.idProyecto
    left
    join	tipoProyecto tpp
    on		tpp.idTipoProyecto=p.idTipoProyecto
    where	d.idDictamen=_idDictamen;
    
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `conformarExpediente` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE PROCEDURE `conformarExpediente`(in _idExpediente int)
BEGIN
		 
		SET lc_time_names = 'es_AR';
        
       	select 	formatParrafo(e.caratula) as caratula,
				e.numeroExpediente, te.letra, e.periodo,
                DATE_FORMAT(e.fechaCreacion,  "%d/%m/%Y") as fechaIngreso,
                case when dp.idDemandanteParticular is not null
						  then upper(concat(dp.apellidos,', ',dp.nombres,'(DNI',dp.documento,')'))
					 when oe.idOrigenExterno is not null
						  then upper(concat(o.oficina,ifnull(concat('-',o.codigo),'')))
					 when p.idProyecto is not null
						  then upper(concat(b.bloque,' (',pe.apellidos,', ',pe.nombres,')'))
					 else 'SECRETARIA ADMINISTRATIVA'
				end as origen,
                case when p.idExpediente is not null
						  then conformarProyecto(p.visto,p.considerandos,p.articulos,
												 te.tipoExpediente,1,0,0)
					 else ''
				end as textoProyecto
        from	expediente e
        left
        join	proyecto p
        on		e.idExpediente=p.idExpediente
        left
        join	perfil pe
        on		pe.idPerfil=p.idConcejal
        left
        join	bloque b
        on		pe.idBloque=b.idBloque
        inner
        join	tipoExpediente te
        on		e.idTipoExpediente=te.idTipoExpediente
        left
        join	demandanteParticular dp
        on		dp.idDemandanteParticular=e.idDemandanteParticular
        left
        join	origenExterno oe
        on		oe.idOrigenExterno=e.idOrigenExterno
        left
        join	oficina o
        on		o.idOficina=oe.idOficina
        where   e.idExpediente=_idExpediente;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `conformarProyecto` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE PROCEDURE `conformarProyecto`(in _idProyecto int)
BEGIN
		
        select 
				conformarProyecto(p.visto,p.considerandos,p.articulos,
								  tp.tipoProyecto,1,0,0) as textoProyecto,
				concat(pe.apellidos,', ',pe.nombres) as autor,
                b.bloque
        from 	proyecto p
        inner
        join	tipoProyecto tp
        on		p.idTipoProyecto=tp.idTipoProyecto
        inner
        join	perfil pe
        on		p.idConcejal=pe.idPerfil
        inner
        join	bloque b
        on		pe.idBloque=b.idBloque
        where	p.idProyecto=_idProyecto;
        
        
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `conformarRemito` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE PROCEDURE `conformarRemito`(in _idRemito int)
BEGIN
	select  concat(o.oficina, 
				   if(o.codigo<>'',concat('(',o.codigo,')'),'')
				   ) as Destino,
			r.numeroRemito as Numero,
			group_concat(if(m.discriminador='Pase',
							concat(
									'HCD ',e.numeroExpediente,'|',e.periodo-2000,'|',te.letra,'|---,',
									if(oe.idOrigenExterno is not null,
									   conformarNumerosExternos(oe.numeracionOrigen),
									  '')
									),
							 '')
						 separator '') as Pases,
			group_concat(if(m.discriminador='informe',
							concat(
									'HCD ',e.numeroExpediente,'|',m.observacion,','
								  ),
							'')
						  separator '') as Informes,
			group_concat(if(m.discriminador='notificacion',
							concat(
									s.numeroSancion,'|',te.TipoExpediente,','
								  ),
							'')
						 separator '') as Notificaciones
	from 	remito r
	inner
	join 	oficina o
	on 		r.idDestino=o.idOficina
	inner
	join	movimiento m
	on		m.idRemito=r.idRemito
	left
	join	sancion s
	on		s.idNotificacion=m.idMovimiento
	inner
	join 	expediente e
	on		e.idExpediente=m.idExpediente
	inner
	join	tipoExpediente te
	on		te.idTipoExpediente=e.idTipoExpediente
	left 
	join	origenExterno oe
	on		oe.idOrigenExterno=e.idOrigenExterno
	where 	r.idRemito=_idRemito
	group
	by		r.idRemito;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `conformarSancion` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE PROCEDURE `conformarSancion`(IN _idSancion INT)
BEGIN

	select 	distinct
			concat('<h3><strong>Expediente: ',e.numeroExpediente,
				   '-',te.letra,'-',e.periodo,'<\/strong><\/h3>',
                   ifnull(concat('<p><\/p>',
								 formatParrafo(ph.plantillaTexto)),
						  ''),
                   case when s.discriminador='basica' then
							 concat('<em>',formatParrafo(s.textoLibre),'<\/em>')
						when s.discriminador='articulado' then
							 concat('<h5><u>',upper(tps.tipoProyecto),'<\/u><\/h5>',
                                    formatArticulos(s.textoArticulado))
						else concat(if (pr.incluyeVistosYConsiderandos=1,
										concat('<h7><u>VISTOS<\/u><\/h7>',formatParrafo(pr.visto),
											   '<h7><u>CONSIDERANDOS<\/u><\/h7>',formatParrafo(pr.considerandos)),
										''),
									'<h5><u>',upper(tpp.tipoProyecto),'<\/u><\/h5>',
                                    formatArticulos(pr.articulos))
					end,
                    ifnull(concat('<p><\/p>',
								  formatParrafo(pf.plantillaTexto)),
							''),
                    if(s.numeroSancion<>'',
					   concat('<h3><strong>Registrado bajo el N°: ',
							  s.numeroSancion,'<\/strong><\/h3>'),
					   '')                  
                   ) as texto, 
                   concat(e.numeroExpediente,'-',te.letra,'-',e.periodo) as expediente,
                   if(s.numeroSancion<>'',replace(s.numeroSancion,'/','_'),'') as numeroSancion
    from	sancion s
    left
    join	plantillaTexto ph
    on		s.idEncabezadoRedaccion=ph.idPlantillaTexto
    left
    join	plantillaTexto pf
    on		s.idPieRedaccion=pf.idPlantillaTexto
    left
    join	tipoProyecto tps
    on		s.idTipoSancion=tps.idTipoProyecto
    left
    join	proyectoRevision pr
    on		s.idProyectoRevision=pr.idProyectoRevision
    left
    join	proyecto p
    on		p.idProyecto=pr.idProyecto
    left
    join	tipoProyecto tpp
    on		p.idTipoProyecto=tpp.idTipoProyecto
    inner
    join	expedienteSesion es
    on		s.idSancion=es.idSancion
    inner
    join	expediente e
    on		es.idExpediente=e.idExpediente
    inner
    join	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    where 	s.idSancion=_idSancion;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `crearOrdenDelDia` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE PROCEDURE `crearOrdenDelDia`(IN _idSesion int, IN _tipo tinyint(1))
BEGIN

	declare _cantidadExpedientes int default 0;
	declare _idEstado int default 6;
    set @idTipo:=0;
    set @ultimoMomento:=0;
    
    start transaction;
    
    DROP TEMPORARY TABLE IF EXISTS expedienteSesionTemporal;
    DROP TEMPORARY TABLE IF EXISTS dictamenesConjuntos;
    
    CREATE TEMPORARY TABLE expedienteSesionTemporal (
	  `idTipoExpedienteSesion` int(11) DEFAULT NULL,
	  `idExpediente` int(11) DEFAULT NULL,
	  `texto` longtext NOT NULL,
      `letra` varchar(2) NOT NULL,
      `añoExpediente` int NOT NULL,
      `numeroExpediente` int NOT NULL,
       INDEX `letra_idx` (`letra` ASC),
       INDEX `expediente` (`añoExpediente` ASC, `numeroExpediente` ASC)
	);
       
    #Tipo último momento
    
    select idTipoExpedienteSesion into @ultimoMomento 
    from tipoExpedienteSesion where letra='U';
       
    #Mensajes del ejecutivo sin giro a comisiones
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='A';
    
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
	select 
			if(_tipo=0,@idTipo,@ultimoMomento),e.idExpediente,
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
                   ')<\/strong></h8>',e.caratula,'<p>',repeat('-',107),'<\/p>'),
			'A',(e.periodo-2000), e.numeroExpediente
	from  	expediente e
	inner
    join 	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    where	e.idTipoExpediente=4 and 
			e.idSesion=_idSesion and
            e.ultimoMomento=_tipo;
    
    #Mensajes del ejecutivo con giro a comisiones (Ordenanzas)
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='B';
  
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
	select 
			if(_tipo=0,@idTipo,@ultimoMomento),e.idExpediente,
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
                   ')<\/strong><\/h8>',e.caratula,traerComisionesExpediente(e.idExpediente),
				   '<p>',repeat('-',107),'<\/p>'),'B',(e.periodo-2000), e.numeroExpediente
	from  	expediente e
	inner
    join 	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    where	e.idTipoExpediente=9 and 
			e.idSesion=_idSesion and 
            e.ultimoMomento=_tipo;
    
    #proyectos de los concejales (comunicaciones y resoluciones)
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='C';
    
     INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			if(_tipo=0,@idTipo,@ultimoMomento),e.idExpediente,
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
                   ' / ',b.bloque ,')<\/strong><\/h8>',
                   conformarProyecto(p.visto,p.considerandos,p.articulos,te.tipoExpediente,1,0,1),
				   '<p>',repeat('-',107),'<\/p>'),'C',(e.periodo-2000), e.numeroExpediente
	from  	expediente e
	inner
    join 	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	proyecto p
    on		e.IdExpediente=p.IdExpediente
    inner
    join	perfil pf
    on		p.idconcejal=pf.idPerfil
    inner
    join	bloque b
    on		b.idBloque=pf.idBloque
    where	e.idTipoExpediente in (1,6) and 
			e.idSesion=_idSesion and
            e.ultimoMomento=_tipo;	
    
    #proyectos de los concejales (ordenanzas)
 
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='D';
  
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			if(_tipo=0,@idTipo,@ultimoMomento),e.idExpediente,
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
                   ' / ',b.bloque ,')<\/strong><\/h8>',
                   traerComisionesExpediente(e.idExpediente),
                   conformarProyecto(p.visto,p.considerandos,p.articulos,te.tipoExpediente,1,0,1),
				   '<p>',repeat('-',107),'<\/p>'),'D',(e.periodo-2000), e.numeroExpediente
	from  	expediente e
	inner
    join 	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	proyecto p
    on		e.IdExpediente=p.IdExpediente
    inner
    join	perfil pf
    on		p.idconcejal=pf.idPerfil
    inner
    join	bloque b
    on		b.idBloque=pf.idBloque
    where	e.idTipoExpediente in (2,7) and 
			e.idSesion=_idSesion and
            e.ultimoMomento=_tipo;

	#pedidos de informes y notificaciones
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='CH';
    
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			@idTipo, e.idExpediente,
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				  '<\/strong><\/h10><h7>CH<\/h7><h7>Δ<\/h7>',
				   '<h10><strong>Expediente N ° ', e.numeroExpediente,
                   '            ',te.letra,'            ',
                   DATE_FORMAT(m.fechaRespuesta, "%d/%m/%Y"),
                   '<\/strong><\/h10>',
                   case when m.discriminador = 'notificacion' 
							then concat('<h10><strong>',te.tipoExpediente,' ',e.numeroSancion,
										' - ',c.comision,'.-<\/strong><\/h10>')
							else ''
					end,
				   '<p>',repeat('-',107),'<\/p>'),'CH',(e.periodo-2000), e.numeroExpediente
	from  	expediente e
	inner
    join 	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	movimiento m
    on		m.idExpediente=e.idExpediente
    left
    join	comision c
    on		m.idComision=c.idComision
    where	m.idSesion=_idSesion and 
			fechaRespuesta is not null and
            discriminador in ('informe','notificacion')
    order 	
	by		m.discriminador,e.periodo, e.numeroExpediente;
    
    #Exedientes Particulares
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='E';
  
	INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
	select 
			if(_tipo=0,@idTipo,@ultimoMomento), e.idExpediente,
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
                   ')<\/strong><\/h8>',e.caratula,'<p>',repeat('-',107),'<\/p>'),
			'E',(e.periodo-2000), e.numeroExpediente
	from  	expediente e
	inner
    join 	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    where	e.idTipoExpediente=3 and 
			e.idSesion=_idSesion and
            e.ultimoMomento=_tipo;
    
    #id's de dictamenes conjuntos
    
    create temporary table dictamenesConjuntos(idDictamen int);
    
    insert 	into dictamenesConjuntos(idDictamen)
    select 	d.idDictamen
    from	dictamen d
    inner
    join	expedienteComision ec
    on		d.idDictamen=ec.idDictamenMayoria
    where	ec.idSesion=_idSesion and
            d.ultimoMomento=_tipo	
    group
    by		d.idDictamen
    having	count(ec.idExpedienteComision)>1;
    
    insert 	into dictamenesConjuntos(idDictamen)
    select 	d.idDictamen
    from	dictamen d
    inner
    join	expedienteComision ec
    on		d.idDictamen=ec.idDictamenPrimeraMinoria
    where	ec.idSesion=_idSesion and
            d.ultimoMomento=_tipo
    group
    by		d.idDictamen
    having	count(ec.idExpedienteComision)>1;
    
    insert 	into dictamenesConjuntos(idDictamen)
    select 	d.idDictamen
    from	dictamen d
    inner
    join	expedienteComision ec
    on		d.idDictamen=ec.idDictamenSegundaMinoria
    where	ec.idSesion=_idSesion and
            d.ultimoMomento=_tipo
    group
    by		d.idDictamen
    having	count(ec.idExpedienteComision)>1;
    
    #dictamenes de comisiones
    	
    #dictamenes por mayoria
    
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			if(_tipo=0,tes.idTipoExpedienteSesion,@ultimoMomento), e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')<\/strong><\/h8>',
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1,1)
				   end,
                   '<p>',repeat('-',107),'<\/p>'),c.letraOrdenDelDia, (e.periodo-2000), e.numeroExpediente
	from  	expediente e
    inner
    join	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	expedienteComision ec
    on		e.idExpediente=ec.idExpediente
    inner
    join	comision c
    on		ec.idComision=c.idComision
    inner
    join	tipoExpedienteSesion tes
    on 		tes.letra=c.letraOrdenDelDia
    inner
    join	dictamen d
    on		ec.idDictamenMayoria=d.idDictamen
    left
    join	tipoProyecto tpd
    on		d.idTipoDictamen=tpd.idTipoProyecto
    left
    join	proyectoRevision pr
    on		d.idProyectoRevision=pr.idProyectoRevision
    left	
    join	proyecto p
    on		pr.idProyecto=p.idProyecto
    left
    join	perfil pf
    on		p.idConcejal=pf.idPerfil
    left
    join	bloque b
    on		pf.idBloque=b.idBloque
    left
    join	tipoProyecto tp
    on		p.idTipoProyecto=tp.idTipoProyecto
    left
    join	dictamenesConjuntos dc
    on		d.idDictamen=dc.idDictamen
    where	ec.idSesion=_idSesion and 
			dc.idDictamen is null and
            d.ultimoMomento=_tipo;
    
    #dictamenes por primera minoria
    
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			if(_tipo=0,tes.idTipoExpedienteSesion,@ultimoMomento), e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')<\/strong><\/h8>',
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1,1)
				   end,
				   '<p>',repeat('-',107),'<\/p>'),c.letraOrdenDelDia, (e.periodo-2000), e.numeroExpediente
	from  	expediente e
    inner
    join	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	expedienteComision ec
    on		e.idExpediente=ec.idExpediente
    inner
    join	comision c
    on		ec.idComision=c.idComision
    inner
    join	tipoExpedienteSesion tes
    on 		tes.letra=c.letraOrdenDelDia
    inner
    join	dictamen d
    on		ec.idDictamenPrimeraMinoria=d.idDictamen
    left
    join	tipoProyecto tpd
    on		d.idTipoDictamen=tpd.idTipoProyecto
    left
    join	proyectoRevision pr
    on		d.idProyectoRevision=pr.idProyectoRevision
    left	
    join	proyecto p
    on		pr.idProyecto=p.idProyecto
    left
    join	perfil pf
    on		p.idConcejal=pf.idPerfil
    left
    join	bloque b
    on		pf.idBloque=b.idBloque
    left
    join	tipoProyecto tp
    on		p.idTipoProyecto=tp.idTipoProyecto
    left
    join	dictamenesConjuntos dc
    on		d.idDictamen=dc.idDictamen
    where	ec.idSesion=_idSesion and 
			dc.idDictamen is null and
            d.ultimoMomento=_tipo;
    
     #dictamenes por segunda minoria
    
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			if(_tipo=0,tes.idTipoExpedienteSesion,@ultimoMomento), e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')<\/strong><\/h8>',
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1,1)
				   end,
                   '<p>',repeat('-',107),'<\/p>'),c.letraOrdenDelDia, (e.periodo-2000), e.numeroExpediente
	from  	expediente e
    inner
    join	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	expedienteComision ec
    on		e.idExpediente=ec.idExpediente
    inner
    join	comision c
    on		ec.idComision=c.idComision
    inner
    join	tipoExpedienteSesion tes
    on 		tes.letra=c.letraOrdenDelDia
    inner
    join	dictamen d
    on		ec.idDictamenSegundaMinoria=d.idDictamen
    left
    join	tipoProyecto tpd
    on		d.idTipoDictamen=tpd.idTipoProyecto
    left
    join	proyectoRevision pr
    on		d.idProyectoRevision=pr.idProyectoRevision
    left	
    join	proyecto p
    on		pr.idProyecto=p.idProyecto
    left
    join	perfil pf
    on		p.idConcejal=pf.idPerfil
    left
    join	bloque b
    on		pf.idBloque=b.idBloque
    left
    join	tipoProyecto tp
    on		p.idTipoProyecto=tp.idTipoProyecto
    left
    join	dictamenesConjuntos dc
    on		d.idDictamen=dc.idDictamen
    where	ec.idSesion=_idSesion and 
			dc.idDictamen is null and
            d.ultimoMomento=_tipo;
    
	#dictamenes conjuntos
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='Z';
    
    #dictamenes por mayoria
	
	INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			if(_tipo=0,@idTipo,@ultimoMomento), e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')<\/strong><\/h8>',
                   traerComisionesDictamen(d.idDictamen),
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1,1)
				   end,
                   '<p>',repeat('-',107),'<\/p>'),'Z', (e.periodo-2000), e.numeroExpediente
	from  	expediente e
    inner
    join	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	expedienteComision ec
    on		e.idExpediente=ec.idExpediente
    inner
    join	dictamen d
    on		ec.idDictamenMayoria=d.idDictamen
    left
    join	tipoProyecto tpd
    on		d.idTipoDictamen=tpd.idTipoProyecto
    left
    join	proyectoRevision pr
    on		d.idProyectoRevision=pr.idProyectoRevision
    left	
    join	proyecto p
    on		pr.idProyecto=p.idProyecto
    left
    join	perfil pf
    on		p.idConcejal=pf.idPerfil
    left
    join	bloque b
    on		pf.idBloque=b.idBloque
    left
    join	tipoProyecto tp
    on		p.idTipoProyecto=tp.idTipoProyecto
    inner
    join	dictamenesConjuntos dc
    on		d.idDictamen=dc.idDictamen
    where	ec.idSesion=_idSesion and 
            d.ultimoMomento=_tipo
    order   
    by		e.periodo, e.numeroExpediente;
    
    #dictamenes por primera minoria
	
	INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			if(_tipo=0,@idTipo,@ultimoMomento), e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')<\/strong><\/h8>',
                   traerComisionesDictamen(d.idDictamen),
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1,1)
				   end,
				   '<p>',repeat('-',107),'<\/p>'),'Z', (e.periodo-2000), e.numeroExpediente
	from  	expediente e
    inner
    join	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	expedienteComision ec
    on		e.idExpediente=ec.idExpediente
    inner
    join	dictamen d
    on		ec.idDictamenPrimeraMinoria=d.idDictamen
    left
    join	tipoProyecto tpd
    on		d.idTipoDictamen=tpd.idTipoProyecto
    left
    join	proyectoRevision pr
    on		d.idProyectoRevision=pr.idProyectoRevision
    left	
    join	proyecto p
    on		pr.idProyecto=p.idProyecto
    left
    join	perfil pf
    on		p.idConcejal=pf.idPerfil
    left
    join	bloque b
    on		pf.idBloque=b.idBloque
    left
    join	tipoProyecto tp
    on		p.idTipoProyecto=tp.idTipoProyecto
	inner
    join	dictamenesConjuntos dc
    on		d.idDictamen=dc.idDictamen
    where	ec.idSesion=_idSesion and
            d.ultimoMomento=_tipo
    order   
    by		e.periodo, e.numeroExpediente;
    
	#dictamenes por segunda minoria
	
	INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			if(_tipo=0,@idTipo,@ultimoMomento), e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')<\/strong><\/h8>',
                   traerComisionesDictamen(d.idDictamen),
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1,1)
				   end,
                   '<p>',repeat('-',107),'<\/p>'),'Z', (e.periodo-2000), e.numeroExpediente
	from  	expediente e
    inner
    join	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	expedienteComision ec
    on		e.idExpediente=ec.idExpediente
    inner
    join	dictamen d
    on		ec.idDictamenSegundaMinoria=d.idDictamen
    left
    join	tipoProyecto tpd
    on		d.idTipoDictamen=tpd.idTipoProyecto
    left
    join	proyectoRevision pr
    on		d.idProyectoRevision=pr.idProyectoRevision
    left	
    join	proyecto p
    on		pr.idProyecto=p.idProyecto
    left
    join	perfil pf
    on		p.idConcejal=pf.idPerfil
    left
    join	bloque b
    on		pf.idBloque=b.idBloque
    left
    join	tipoProyecto tp
    on		p.idTipoProyecto=tp.idTipoProyecto
	inner
    join	dictamenesConjuntos dc
    on		d.idDictamen=dc.idDictamen
    where	ec.idSesion=_idSesion and
            d.ultimoMomento=_tipo
    order   
    by		e.periodo, e.numeroExpediente;

	#insercion en la tabla de la bd
    
    INSERT INTO `expedienteSesion`
		(`idTipoExpedienteSesion`, `ordenSesion`,`idExpediente`,`idSesion`,
         `idEstadoExpedienteSesion`,`texto`,`aFavor`, `enContra`, `abstenciones`)
	select  
			t.idTipoExpedienteSesion, 0,
            t.idExpediente, _idSesion, _idEstado,
            case when idTipoExpedienteSesion<>25 then
						concat('<h8><strong>',if(_tipo=1,'U',t.letra),') Δ.- ',t.texto)
				 else concat('<h10><strong>',t.texto)
			end,0,0,0
	from	(select distinct idTipoExpedienteSesion,idExpediente,
							 letra,texto,añoExpediente,numeroExpediente
			 from expedienteSesionTemporal
             ) t
    order 
    by		t.letra ASC,t.añoExpediente ASC,t.numeroExpediente ASC;
    
    select count(distinct idExpediente) into _cantidadExpedientes
    from `expedienteSesion` where idSesion=_idSesion;
    
    update 	expediente as e
    inner
    join	(select distinct idExpediente
			 from 	expedienteSesion
             where  idSesion=_idSesion
             ) as t
	on 		e.idExpediente=t.idExpediente
    set		idOficina=5,
			idEstadoExpediente=11;
    
    update 	sesion
    set		tieneOrdenDelDia=1,
			tieneUltimoMomento=_tipo,
			cantidadExpedientes=_cantidadExpedientes
	where 	idSesion=_idSesion;
    
    commit;
    
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `listadoDictamenesExpedienteSesion` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE PROCEDURE `listadoDictamenesExpedienteSesion`(in _idExpediente int, in _idSesion int)
BEGIN
	select 
		t.idExpediente,
		t.idDictamen,
		t.redaccion,
		t.resuelve_por,
		DATE_FORMAT(t.fecha_creacion,"%d/%m/%Y") as fecha_creacion,
		t.usuario_creacion,
        group_concat(t.comision separator '/') as comisiones
from(
		select 
				ec.idExpediente,
				dmd.idDictamen,
				dmd.discriminador  as redaccion,
				'Mayoria' as resuelve_por,
				dmd.fechaCreacion as fecha_creacion,
				dmd.usuarioCreacion usuario_creacion,
				c.comision
		from 	expedienteComision ec
		inner
		join	dictamen dmd
		on		ec.idDictamenMayoria=dmd.idDictamen 
		inner
		join	comision c
		on		ec.idComision=c.idComision
		where 	ec.idExpediente=_idExpediente and ec.idSesion=_idSesion
		union
		select 
				ec.idExpediente,
				dpmd.idDictamen,
				dpmd.discriminador as redaccion,
				'Primera Minoria' as resuelve_por,
				dpmd.fechaCreacion as fecha_creacion,
				dpmd.usuarioCreacion as usuario_creacion,
				c.comision
		from 	expedienteComision ec
		inner
		join	dictamen dpmd
		on		ec.idDictamenPrimeraMinoria=dpmd.idDictamen 
		inner
		join	comision c
		on		ec.idComision=c.idComision
		where 	ec.idExpediente=_idExpediente and ec.idSesion=_idSesion
		union
		select 
				ec.idExpediente,
				dsmd.idDictamen,
				dsmd.discriminador as redaccion,
				'Segunda Minoria' as resuelve_por,
				dsmd.fechaCreacion as fecha_creacion,
				dsmd.usuarioCreacion as usuario_creacion,
				c.comision
		from 	expedienteComision ec
		inner
		join	dictamen dsmd
		on		ec.idDictamenSegundaMinoria=dsmd.idDictamen 
		inner
		join	comision c
		on		ec.idComision=c.idComision
		where 	ec.idExpediente=_idExpediente and ec.idSesion=_idSesion
	) as t
group
by		t.idExpediente,
		t.idDictamen,
		t.redaccion,
		t.resuelve_por,
		t.fecha_creacion,
		t.usuario_creacion;
    
    
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `listadoESinCuerpo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE PROCEDURE `listadoESinCuerpo`(in fechaInicio datetime, in fechaFin datetime)
BEGIN

	select  group_concat(
				concat('<h8><strong>EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
					   '<\/strong><\/h8>',e.caratula)  
			separator '<h3>------------------------------------------------------<\/h3>')
            as texto
	from  	(select * from expediente order by numeroExpediente, periodo) e
	inner
    join 	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    where	e.idTipoExpediente=3 and 
			e.idSesion is null and 
            e.fechaCreacion between fechaInicio and fechaFin
	group 
    by		e.idTipoExpediente;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `listadoExpedientesPorSesion` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE PROCEDURE `listadoExpedientesPorSesion`(in _idSesion int, in _numeroExpediente int,in _tipoExpediente int, in _letraOD char(1))
BEGIN

    DROP TEMPORARY TABLE IF EXISTS dictamenesExpedientes;
    
    CREATE TEMPORARY TABLE dictamenesExpedientes (
	  `idExpediente` int(11) DEFAULT NULL,
	  `cuentaDictamenes` int(2) NOT NULL,
       INDEX `idExpediente_idx` (`idExpediente` ASC)
	);

	insert into dictamenesExpedientes (idExpediente,cuentaDictamenes)
	select ec.idExpediente, sum(if(dmd.idDictamen is not null,1,0) +
							    if(dpmd.idDictamen is not null,1,0) +
                                if(dsmd.idDictamen is not null,1,0)
								) as cuentaDictamenes
						
    from 	expedienteComision ec
    left
    join	dictamen dmd
    on		ec.idDictamenMayoria=dmd.idDictamen
	left
    join	dictamen dpmd
    on		ec.idDictamenPrimeraMinoria=dpmd.idDictamen
	left
    join	dictamen dsmd
    on		ec.idDictamenSegundaMinoria=dsmd.idDictamen
    where 	ec.idSesion=_idSesion
    group	
    by		ec.idExpediente;
    
    
	select 	distinct e.idExpediente , case when p.idProyecto is null then 0 else p.idProyecto end as idProyecto,
			concat(e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000)) as numero_expediente, te.tipoExpediente, 
			traerLetrasExpedienteSesion(e.idExpediente,s.idSesion) as letrasOD, 
			case when esr.idSancion is not null then 'Si' else 'No' end as tiene_sancion,
            case when esr.idSancion is not null then esr.idSancion else 0 end as idSancion,
            case when esr.idSancion is not null then esr.idDictamen else 0 end as idDictamen,
			case when esr.idSancion is not null then if(esr.numeroSancion is null,'',esr.numeroSancion)
				 else ''
			end as numero_sancion,
			case when m.idMovimiento is not null then 'Si'
				 else 'No'
			end as tiene_notificacion,
            case when de.idExpediente is null then 0
				 else de.cuentaDictamenes
			end as dictamenes
            
	from 	expedienteSesion es
	inner
	join	expediente e
	on		es.idExpediente=e.idExpediente
    left
    join	dictamenesExpedientes de
    on		e.idExpediente=de.idExpediente
    left
    join 	proyecto p
    on		p.idExpediente=e.idExpediente
	inner
	join	tipoExpediente te
	on		e.idTipoExpediente=te.IdTipoExpediente
	inner
	join	tipoExpedienteSesion tes
	on		es.idTipoExpedienteSesion=tes.idTipoExpedienteSesion
	left
	join	sancion esr
	on		es.idSancion=esr.idSancion
	left
	join	movimiento m
	on		esr.idNotificacion=m.idMovimiento
	inner
	join	sesion s
	on		es.idSesion=s.idSesion
	where   s.idSesion=_idSesion and 
			(_numeroExpediente is null or e.numeroExpediente=_numeroExpediente) and
            (_tipoExpediente is null or te.idTipoExpediente=_tipoExpediente) and 
            (_letraOD is null or instr(traerLetrasExpedienteSesion(e.idExpediente,s.idSesion),_letraOD)<>0);

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `listadoVersionesTaquigraficas` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE PROCEDURE `listadoVersionesTaquigraficas`(IN _idSesion INT)
BEGIN
	declare separador varchar(200) default '';
    set separador =concat('<p>',repeat('-',107),'<\/p>');
	select 	group_concat(replace(
							replace(
								replace(
									replace(descripcion,'<p><br>','<p>'),
									'<br><\/p>','<\/p>'),
								'p>','h8>'),
							'<br>','<p></p>'),						  
                          separador
						 ) 
            as versiones
    from	versionTaquigrafica	
	where   idSesion=_idSesion;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `traerApartadoOrdenDelDia` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE PROCEDURE `traerApartadoOrdenDelDia`(_idSesion int, _idTipoExpedienteSesion int)
BEGIN

	SET group_concat_max_len = 1024*1024;

	select 	replace(group_concat(texto separator '<p></p>'),'<br>','<p></p>') as apartado
	from	expedienteSesion
	where	idSesion=_idSesion and 
			idTipoExpedienteSesion=_idTipoExpedienteSesion
	group
	by		idTipoExpedienteSesion;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `vw_sesiones_habiles`
--

/*!50001 DROP VIEW IF EXISTS `vw_sesiones_habiles`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 SQL SECURITY DEFINER */
/*!50001 VIEW `vw_sesiones_habiles` AS select `s`.`idSesion` AS `idSesion`,concat(convert(cast(date_format(`s`.`fecha`,'%d/%m/%Y') as char(10) charset utf8) using utf8mb4),' (',`ts`.`abreviacion`,')') AS `descripcion` from (`sesion` `s` join `tipoSesion` `ts` on((`s`.`idTipoSesion` = `ts`.`idTipoSesion`))) where ((`s`.`fecha` >= curdate()) and (`s`.`tieneUltimoMomento` = 0)) order by `s`.`fecha` limit 6 */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-30 12:35:43
