-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: localhost    Database: sistema_legislativo
-- ------------------------------------------------------
-- Server version	5.7.18-0ubuntu0.16.04.1

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
-- Table structure for table `AgendaSesion`
--

DROP TABLE IF EXISTS `AgendaSesion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AgendaSesion` (
  `idAgendaSesion` int(11) NOT NULL AUTO_INCREMENT,
  `idExpediente` int(11) DEFAULT NULL,
  `idSesion` int(11) DEFAULT NULL,
  `idEstadoAgendaSesion` smallint(6) DEFAULT NULL,
  `aFavor` smallint(6) NOT NULL DEFAULT '0',
  `enContra` smallint(6) NOT NULL DEFAULT '0',
  `abstenciones` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idAgendaSesion`),
  KEY `agendaSesion_estadoAgendaSesion_idx` (`idEstadoAgendaSesion`),
  KEY `agendaSesion_sesion_idx` (`idSesion`),
  KEY `agendaSesion_expediente_idx` (`idExpediente`),
  CONSTRAINT `fk_agendaSesion_estadoAgendaSesion` FOREIGN KEY (`idEstadoAgendaSesion`) REFERENCES `estadoAgendaSesion` (`idEstadoAgendaSesion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_agendaSesion_expediente` FOREIGN KEY (`idExpediente`) REFERENCES `expediente` (`idExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_agendaSesion_sesion` FOREIGN KEY (`idSesion`) REFERENCES `sesion` (`idSesion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AgendaSesion`
--

LOCK TABLES `AgendaSesion` WRITE;
/*!40000 ALTER TABLE `AgendaSesion` DISABLE KEYS */;
/*!40000 ALTER TABLE `AgendaSesion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bloque`
--

DROP TABLE IF EXISTS `bloque`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bloque` (
  `idBloque` smallint(6) NOT NULL AUTO_INCREMENT,
  `bloque` varchar(100) NOT NULL,
  PRIMARY KEY (`idBloque`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bloque`
--

LOCK TABLES `bloque` WRITE;
/*!40000 ALTER TABLE `bloque` DISABLE KEYS */;
INSERT INTO `bloque` VALUES (1,'Frente Renovador'),(2,'Frente Para la Victoria'),(3,'UNA'),(4,'UCR'),(5,'GEN'),(6,'Cambiemos');
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
  `activa` tinyint(1) NOT NULL,
  PRIMARY KEY (`idComision`),
  KEY `comision_tipoComision_idx` (`idTipoComision`),
  KEY `comision_perfilPresidente_idx` (`idPerfilPresidente`),
  KEY `comision_perfilVicePresidente_idx` (`idPerfilVicePresidente`),
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
INSERT INTO `comision` VALUES (1,2,3,2,'Defensa del Usuario',1),(2,19,5,2,'Promoción de la Comunidad',1),(3,14,3,2,'Seguridad y Justicia',1),(4,5,22,2,'Mujeres y Equidad de Género',1),(5,11,9,2,'Presupuesto y Hacienda',1),(6,18,15,2,'Derechos y Garantías',1),(7,6,19,2,'Interpretación y Reglamento',1),(8,16,13,2,'Asistencia Social',1),(9,22,5,2,'Planeamiento',1),(10,16,13,2,'Ecología y Protección del Medio Ambiente',1),(11,8,3,2,'Obras Públicas y Urbanismo',1),(12,14,15,2,'Servicios Públicos',1),(13,13,4,2,'Salud Publica',1),(14,15,23,2,'Cultura y Educación',1),(15,9,4,2,'Industria y Comercio Interior y Exterior',1),(16,16,5,2,'Medios de Comunicación Social',1);
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
INSERT INTO `comision_legisladorSuplente` VALUES (2,2),(3,2),(4,2),(5,2),(6,2),(7,2),(8,2),(9,2),(10,2),(11,2),(12,2),(13,2),(14,2),(16,2),(2,3),(5,3),(14,3),(2,4),(7,4),(8,4),(9,4),(10,4),(12,4),(16,4),(3,5),(5,5),(6,5),(7,5),(11,5),(12,5),(15,5),(3,6),(11,6),(13,6),(14,6),(15,6),(9,7),(4,8),(5,8),(7,8),(16,8),(2,9),(3,9),(4,9),(6,9),(8,9),(9,9),(12,9),(13,9),(14,9),(1,11),(3,11),(4,11),(6,11),(8,11),(13,11),(15,11),(16,11),(1,12),(3,12),(4,12),(6,12),(8,12),(9,12),(10,12),(12,12),(13,12),(15,12),(1,13),(4,13),(5,13),(7,13),(9,13),(11,13),(12,13),(1,14),(2,14),(4,14),(5,14),(7,14),(10,14),(11,14),(14,14),(16,14),(1,15),(13,15),(1,16),(4,16),(11,16),(12,16),(14,16),(15,16),(1,17),(6,17),(9,17),(11,17),(1,18),(5,18),(7,18),(11,18),(15,18),(16,18),(2,19),(3,19),(8,19),(10,19),(12,19),(13,19),(14,19),(15,19),(7,20),(8,20),(10,20),(2,22),(5,22),(6,22),(8,22),(14,22),(16,22),(2,23),(3,23),(4,23),(6,23),(9,23),(10,23),(13,23),(16,23);
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
INSERT INTO `comision_legisladorTitular` VALUES (15,2),(4,3),(6,3),(7,3),(9,3),(10,3),(12,3),(13,3),(15,3),(16,3),(1,4),(3,4),(4,4),(5,4),(6,4),(11,4),(1,5),(8,5),(13,5),(14,5),(2,6),(4,6),(5,6),(6,6),(8,6),(9,6),(10,6),(12,6),(1,7),(3,7),(5,7),(7,7),(10,7),(11,7),(13,7),(14,7),(16,7),(1,8),(8,8),(12,8),(15,8),(1,9),(7,9),(11,9),(16,9),(1,10),(9,10),(10,10),(12,10),(15,10),(7,11),(11,11),(12,11),(14,11),(5,12),(7,12),(11,12),(2,13),(3,13),(14,13),(16,13),(13,14),(2,15),(3,15),(4,15),(5,15),(7,15),(8,15),(9,15),(10,15),(11,15),(15,15),(16,15),(2,16),(6,16),(9,16),(3,17),(4,17),(10,17),(13,17),(14,17),(16,17),(2,18),(3,18),(4,18),(8,18),(9,18),(12,18),(13,18),(14,18),(5,19),(6,19),(9,19),(2,20),(4,20),(6,20),(12,20),(2,21),(8,21),(10,21),(14,21),(15,21),(16,21),(9,22),(15,22),(8,23),(3,24),(5,24),(6,24),(7,24),(11,24),(13,24);
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
  `documento` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`idDemandanteParticular`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demandanteParticular`
--

LOCK TABLES `demandanteParticular` WRITE;
/*!40000 ALTER TABLE `demandanteParticular` DISABLE KEYS */;
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
  `idTipoDictamen` smallint(6) DEFAULT NULL,
  `idProyectoRevision` int(11) DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuarioCreacion` varchar(70) NOT NULL,
  PRIMARY KEY (`idDictamen`),
  UNIQUE KEY `UNIQ_dictamen_proyectoRevision_idx` (`idProyectoRevision`),
  KEY `dictamen_tipoDictamen_idx` (`idTipoDictamen`),
  CONSTRAINT `fk_dictamen_proyectoRevision` FOREIGN KEY (`idProyectoRevision`) REFERENCES `proyectoRevision` (`idProyectoRevision`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_dictamen_tipoDictamen` FOREIGN KEY (`idTipoDictamen`) REFERENCES `tipoDictamen` (`idTipoDictamen`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dictamen`
--

LOCK TABLES `dictamen` WRITE;
/*!40000 ALTER TABLE `dictamen` DISABLE KEYS */;
/*!40000 ALTER TABLE `dictamen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estadoAgendaSesion`
--

DROP TABLE IF EXISTS `estadoAgendaSesion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estadoAgendaSesion` (
  `idEstadoAgendaSesion` smallint(6) NOT NULL AUTO_INCREMENT,
  `estadoAgendaSesion` varchar(45) NOT NULL,
  PRIMARY KEY (`idEstadoAgendaSesion`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estadoAgendaSesion`
--

LOCK TABLES `estadoAgendaSesion` WRITE;
/*!40000 ALTER TABLE `estadoAgendaSesion` DISABLE KEYS */;
INSERT INTO `estadoAgendaSesion` VALUES (1,'Aprobado'),(2,'Aprobado Tablas'),(3,'No Aprobado'),(4,'Veto Ejecutivo'),(5,'Es Ley');
/*!40000 ALTER TABLE `estadoAgendaSesion` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estadoExpediente`
--

LOCK TABLES `estadoExpediente` WRITE;
/*!40000 ALTER TABLE `estadoExpediente` DISABLE KEYS */;
INSERT INTO `estadoExpediente` VALUES (1,'Entrado'),(2,'Asignado Comision'),(3,'Dictamen Comisión'),(4,'Asignado Sessión'),(5,'Incorporación');
/*!40000 ALTER TABLE `estadoExpediente` ENABLE KEYS */;
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
  `idOficina` int(11) DEFAULT NULL,
  `idOrigenExterno` int(11) DEFAULT NULL,
  `idDemandanteParticular` int(11) DEFAULT NULL,
  `caratula` varchar(500) NOT NULL,
  `folios` varchar(4) NOT NULL,
  `listaImagenes` longtext COMMENT '(DC2Type:object)',
  `fechaCreacion` datetime NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`idExpediente`),
  UNIQUE KEY `numeroExpediente_idx` (`numeroExpediente`),
  UNIQUE KEY `expediente_demandanteParticular_idx` (`idDemandanteParticular`),
  UNIQUE KEY `expediente_origenExterno_idx` (`idOrigenExterno`),
  KEY `expediente_estadoExpediente_idx` (`idEstadoExpediente`),
  KEY `expediente_tipoExpediente_idx` (`idTipoExpediente`),
  KEY `expediente_oficina_idx` (`idOficina`),
  CONSTRAINT `FK_expediente_oficina_` FOREIGN KEY (`idOficina`) REFERENCES `oficina` (`idOficina`),
  CONSTRAINT `fk_expediente_demandanteParticular` FOREIGN KEY (`idDemandanteParticular`) REFERENCES `demandanteParticular` (`idDemandanteParticular`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expediente_estadoExpediente` FOREIGN KEY (`idEstadoExpediente`) REFERENCES `estadoExpediente` (`idEstadoExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expediente_origenExterno` FOREIGN KEY (`idOrigenExterno`) REFERENCES `origenExterno` (`idOrigenExterno`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expediente_tipoExpediente` FOREIGN KEY (`idTipoExpediente`) REFERENCES `tipoExpediente` (`idTipoExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expediente`
--

LOCK TABLES `expediente` WRITE;
/*!40000 ALTER TABLE `expediente` DISABLE KEYS */;
/*!40000 ALTER TABLE `expediente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expedienteComision`
--

DROP TABLE IF EXISTS `expedienteComision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expedienteComision` (
  `idExpedienteComision` int(11) NOT NULL AUTO_INCREMENT,
  `idComision` int(11) DEFAULT NULL,
  `idExpediente` int(11) DEFAULT NULL,
  `idDictamen` int(11) DEFAULT NULL,
  `asignacionActual` tinyint(1) NOT NULL,
  `fechaAsignacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idExpedienteComision`),
  UNIQUE KEY `UNIQ_expedienteComision_dictamen_idx` (`idDictamen`),
  KEY `expedienteComision_expediente_idx` (`idExpediente`),
  KEY `expedienteComision_comision_idx` (`idComision`),
  CONSTRAINT `fk_expedienteComision_comision` FOREIGN KEY (`idComision`) REFERENCES `comision` (`idComision`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedienteComision_dictamen` FOREIGN KEY (`idDictamen`) REFERENCES `dictamen` (`idDictamen`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedienteComision_expediente` FOREIGN KEY (`idExpediente`) REFERENCES `expediente` (`idExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expedienteComision`
--

LOCK TABLES `expedienteComision` WRITE;
/*!40000 ALTER TABLE `expedienteComision` DISABLE KEYS */;
/*!40000 ALTER TABLE `expedienteComision` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `legisladores_proyectos`
--

DROP TABLE IF EXISTS `legisladores_proyectos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `legisladores_proyectos` (
  `idProyecto` int(11) NOT NULL,
  `idPerfil` int(11) NOT NULL,
  PRIMARY KEY (`idProyecto`,`idPerfil`),
  KEY `IDX_D0FD43D4F574DEDD` (`idPerfil`),
  KEY `IDX_D0FD43D43C7128E2` (`idProyecto`),
  CONSTRAINT `fk_autores_proyectos_perfil` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_autores_proyectos_proyectos` FOREIGN KEY (`idProyecto`) REFERENCES `proyecto` (`idProyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `legisladores_proyectos`
--

LOCK TABLES `legisladores_proyectos` WRITE;
/*!40000 ALTER TABLE `legisladores_proyectos` DISABLE KEYS */;
/*!40000 ALTER TABLE `legisladores_proyectos` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'Gestión Expedientes','EXP_MAIN'),(2,'Remitos de Movimientos (Giros)','MOV_MAIN'),(3,'Remitos de Informes (CH)','REP_MAIN'),(4,'Proyectos','PROJ_MAIN'),(5,'Comisiones-AM','COM_MAIN'),(6,'Comisiones-Expedientes','COM_EXP_MAIN'),(7,'Concejales','CON_MAIN'),(8,'Usuarios','USR_MAIN');
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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menuItem`
--

LOCK TABLES `menuItem` WRITE;
/*!40000 ALTER TABLE `menuItem` DISABLE KEYS */;
INSERT INTO `menuItem` VALUES (1,1,'Nuevo','EXP_NEW'),(2,1,'Ingresar Proyecto','EXP_ADD'),(3,1,'Editar','EXP_EDIT'),(4,1,'Descargar','EXP_DOWNLOAD'),(5,1,'Consulta Movimientos e Informes','EXP_MOVEMENT'),(6,2,'Agregar','MOV_NEW'),(7,3,'Agregar','REP_NEW'),(8,4,'Nuevo','PROJ_NEW'),(9,4,'Editar','PROJ_EDIT'),(10,4,'Descargar','PROJ_DOWNLOAD'),(11,5,'Agregar','COM_ADD'),(12,5,'Editar','COM_EDIT'),(13,5,'Eliminar','COM_DEL'),(14,5,'Detalle','COM_DET'),(15,6,'Agregar','CON_ADD'),(16,6,'Editar','CON_EDIT'),(17,6,'Eliminar','CON_DEL'),(18,7,'Agregar','USR_ADD'),(19,7,'Editar','USR_EDIT'),(20,7,'Bloquear','USR_LOCK'),(21,7,'Desbloquear','USR_UNLOK'),(22,2,'Anular','MOV_ABORT'),(23,2,'Recibir','MOV_RECEIVE'),(24,2,'Descargar','MOV_DOWNLOAD'),(25,1,'Retornar ','EXP_RETURN'),(26,1,'Marcar Respuesta CH','EXP_REPORT_RETURN');
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
  `idTipoMovimiento` smallint(6) DEFAULT NULL,
  `idExpediente` int(11) DEFAULT NULL,
  `idRemito` int(11) DEFAULT NULL,
  `observacion` varchar(200) DEFAULT NULL,
  `fojas` smallint(6) NOT NULL,
  `anulado` tinyint(1) DEFAULT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `fechaRespuestaInforme` datetime DEFAULT NULL,
  PRIMARY KEY (`idMovimiento`),
  KEY `movimiento_remito_idx` (`idRemito`),
  KEY `movimiento_tipoMovimiento_idx` (`idTipoMovimiento`),
  KEY `movimiento_expediente_idx` (`idExpediente`),
  CONSTRAINT `fk_movimiento_expediente` FOREIGN KEY (`idExpediente`) REFERENCES `expediente` (`idExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_movimiento_remito` FOREIGN KEY (`idRemito`) REFERENCES `remito` (`idRemito`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_movimiento_tipoMovimiento` FOREIGN KEY (`idTipoMovimiento`) REFERENCES `tipoMovimiento` (`idTipoMovimiento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movimiento`
--

LOCK TABLES `movimiento` WRITE;
/*!40000 ALTER TABLE `movimiento` DISABLE KEYS */;
/*!40000 ALTER TABLE `movimiento` ENABLE KEYS */;
UNLOCK TABLES;

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
  PRIMARY KEY (`idOficina`),
  KEY `oficina_tipoOficina_idx` (`idTipoOficina`),
  CONSTRAINT `fk_oficina_tipoOficina` FOREIGN KEY (`idTipoOficina`) REFERENCES `tipoOficina` (`idTipoOficina`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oficina`
--

LOCK TABLES `oficina` WRITE;
/*!40000 ALTER TABLE `oficina` DISABLE KEYS */;
INSERT INTO `oficina` VALUES (2,'ARCHIVO GENERAL','190',2),(3,'COMISIONES','',1),(4,'CONTADURÍA MUNICIPAL','32',2),(5,'DESPACHO','',1),(6,'DIRECCIÓN DE LIQUIDACIÓN DE HABERES','38',2),(7,'DIRECCIÓN GENERAL DE CONTENCIOSO','4017',2),(8,'DIRECCIÓN GENERAL DE OFICIOS','3202',2),(9,'MESA DE ENTRADAS','',1),(10,'SECRETARIA DE HACIENDA','30',2),(11,'SECRETARIA DE LEGAL Y TÉCNICA','3200',2),(12,'SECRETARIA GENERAL','2200',2),(13,'SUBSECRETARIA DE RECURSOS HUMANOS','2201',2),(14,'SECRETARIA','',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `origenExterno`
--

LOCK TABLES `origenExterno` WRITE;
/*!40000 ALTER TABLE `origenExterno` DISABLE KEYS */;
/*!40000 ALTER TABLE `origenExterno` ENABLE KEYS */;
UNLOCK TABLES;

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
  `numeroDocumento` int(11) DEFAULT NULL,
  `domicilio` varchar(100) DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`idPerfil`),
  KEY `perfil_bloque_idx` (`idBloque`),
  CONSTRAINT `fk_perfil_bloque` FOREIGN KEY (`idBloque`) REFERENCES `bloque` (`idBloque`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil`
--

LOCK TABLES `perfil` WRITE;
/*!40000 ALTER TABLE `perfil` DISABLE KEYS */;
INSERT INTO `perfil` VALUES (1,'basico',NULL,'Administrador','Sistema',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(2,'legislador',NULL,'Fuente Buena','Hector',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(3,'legislador',NULL,'Font','Miguel',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(4,'legislador',NULL,'Guirliddo','Gabriel',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(5,'legislador',NULL,'Vilar','Daniela',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(6,'legislador',NULL,'Tranfo','Ana ',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(7,'legislador',NULL,'Mercuri','Gabriel',NULL,NULL,6,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(8,'legislador',NULL,'Castagnini','Juan Manuel',NULL,NULL,3,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(9,'legislador',NULL,'Veliz','Juan Carlos',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(10,'legislador',NULL,'Figuerón','Luis',NULL,NULL,5,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(11,'legislador',NULL,'Menéndez','Claudio',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(12,'legislador',NULL,'Oyhaburu','Sergio',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(13,'legislador',NULL,'Llambi','Alvaro',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(14,'legislador',NULL,'Baloira','Emilano',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(15,'legislador',NULL,'Lopez','Vanesa',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(16,'legislador',NULL,'Coba','José',NULL,NULL,6,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(17,'legislador',NULL,'Vázquez','María Fernanda',NULL,NULL,3,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(18,'legislador',NULL,'Herrera','Maria Elena ',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(19,'legislador',NULL,'Trezza Silva','Ramiro',NULL,NULL,3,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(20,'legislador',NULL,'Cordera','Diego',NULL,NULL,6,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(21,'legislador',NULL,'Rivero','Julio',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(22,'legislador',NULL,'Sierra','Silvia',NULL,NULL,6,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(23,'legislador',NULL,'Denuchi','Fabio',NULL,NULL,6,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(24,'legislador',NULL,'Pellegrini','Marcelo',NULL,NULL,4,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(25,'legislador',NULL,'Carasatorre','Santiago Alberto',NULL,NULL,2,NULL,NULL,'2017-09-01 14:53:53',NULL,NULL,'2017-06-12 14:53:53','administrador',NULL,NULL);
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
-- Table structure for table `proyecto`
--

DROP TABLE IF EXISTS `proyecto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyecto` (
  `idProyecto` int(11) NOT NULL AUTO_INCREMENT,
  `idExpediente` int(11) DEFAULT NULL,
  `idTipoProyecto` smallint(6) DEFAULT NULL,
  `visto` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `considerandos` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `articulos` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json_array)',
  `fechaCreacion` datetime NOT NULL,
  `usuarioCreacion` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `usuarioModificacion` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idUltimaRevision` int(11) DEFAULT NULL,
  PRIMARY KEY (`idProyecto`),
  UNIQUE KEY `UNIQ_proyecto_expediente_idx` (`idExpediente`),
  UNIQUE KEY `UNIQ_proyecto_ultimaRevision_idx` (`idUltimaRevision`),
  KEY `proyecto_tipoProyecto_idx` (`idTipoProyecto`),
  CONSTRAINT `fk_proyecto_expediente` FOREIGN KEY (`idExpediente`) REFERENCES `expediente` (`idExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyecto_proyectoRevision` FOREIGN KEY (`idUltimaRevision`) REFERENCES `proyectoRevision` (`idProyectoRevision`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyecto_tipoProyecto` FOREIGN KEY (`idTipoProyecto`) REFERENCES `tipoProyecto` (`idTipoProyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyecto`
--

LOCK TABLES `proyecto` WRITE;
/*!40000 ALTER TABLE `proyecto` DISABLE KEYS */;
/*!40000 ALTER TABLE `proyecto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyectoFirma`
--

DROP TABLE IF EXISTS `proyectoFirma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyectoFirma` (
  `idProyectoFirma` int(11) NOT NULL AUTO_INCREMENT,
  `idPerfil` int(11) DEFAULT NULL,
  `idProyecto` int(11) DEFAULT NULL,
  `confirmado` tinyint(1) NOT NULL,
  `fechaConfirmacion` datetime DEFAULT NULL,
  PRIMARY KEY (`idProyectoFirma`),
  KEY `proyectoFirma_perfil_idx` (`idPerfil`),
  KEY `proyectoFirma_proyecto_idx` (`idProyecto`),
  CONSTRAINT `fk_proyectoFirma_perfil` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyectoFirma_proyecto` FOREIGN KEY (`idProyecto`) REFERENCES `proyecto` (`idProyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyectoFirma`
--

LOCK TABLES `proyectoFirma` WRITE;
/*!40000 ALTER TABLE `proyectoFirma` DISABLE KEYS */;
/*!40000 ALTER TABLE `proyectoFirma` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyectoRevision`
--

LOCK TABLES `proyectoRevision` WRITE;
/*!40000 ALTER TABLE `proyectoRevision` DISABLE KEYS */;
/*!40000 ALTER TABLE `proyectoRevision` ENABLE KEYS */;
UNLOCK TABLES;

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
  `numeroRemito` int(11) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `remito`
--

LOCK TABLES `remito` WRITE;
/*!40000 ALTER TABLE `remito` DISABLE KEYS */;
/*!40000 ALTER TABLE `remito` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `sistema_legislativo`.`remito_BEFORE_INSERT` BEFORE INSERT ON `remito` FOR EACH ROW
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
-- Table structure for table `rol_menu`
--

DROP TABLE IF EXISTS `rol_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol_menu` (
  `idRol` smallint(6) NOT NULL,
  `idMenu` smallint(6) NOT NULL,
  PRIMARY KEY (`idRol`,`idMenu`),
  KEY `IDX_6F9D073CEF8640D` (`idMenu`),
  CONSTRAINT `fk_rol_menu_menu` FOREIGN KEY (`idMenu`) REFERENCES `menu` (`idMenu`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rol_menu_rol` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol_menu`
--

LOCK TABLES `rol_menu` WRITE;
/*!40000 ALTER TABLE `rol_menu` DISABLE KEYS */;
INSERT INTO `rol_menu` VALUES (2,1),(4,1),(2,2),(4,2),(5,2),(6,2),(7,2),(2,3),(4,3),(2,4),(4,4),(2,5),(5,5),(6,5),(7,5),(2,6),(5,6),(6,6),(7,6),(2,7),(2,8);
/*!40000 ALTER TABLE `rol_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sesion`
--

DROP TABLE IF EXISTS `sesion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sesion` (
  `idSesion` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `presentes` smallint(6) NOT NULL,
  `quorum` tinyint(1) NOT NULL,
  `periodo` smallint(6) NOT NULL,
  PRIMARY KEY (`idSesion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sesion`
--

LOCK TABLES `sesion` WRITE;
/*!40000 ALTER TABLE `sesion` DISABLE KEYS */;
/*!40000 ALTER TABLE `sesion` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Table structure for table `tipoDictamen`
--

DROP TABLE IF EXISTS `tipoDictamen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoDictamen` (
  `idTipoDictamen` smallint(6) NOT NULL AUTO_INCREMENT,
  `tipoDictamen` varchar(45) NOT NULL,
  PRIMARY KEY (`idTipoDictamen`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoDictamen`
--

LOCK TABLES `tipoDictamen` WRITE;
/*!40000 ALTER TABLE `tipoDictamen` DISABLE KEYS */;
INSERT INTO `tipoDictamen` VALUES (1,'Mayoría'),(2,'Primer Minoría'),(3,'Segunda Minoría');
/*!40000 ALTER TABLE `tipoDictamen` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoExpediente`
--

LOCK TABLES `tipoExpediente` WRITE;
/*!40000 ALTER TABLE `tipoExpediente` DISABLE KEYS */;
INSERT INTO `tipoExpediente` VALUES (1,'Comunicacion','P'),(2,'Ordenanza','P'),(3,'Particular','W'),(4,'Poder Ejecutivo','D'),(5,'Interno','I'),(6,'Resolucion','P'),(7,'Decreto','P'),(8,'Sesion Extraodinaria','V');
/*!40000 ALTER TABLE `tipoExpediente` ENABLE KEYS */;
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
-- Table structure for table `tipoOficina`
--

DROP TABLE IF EXISTS `tipoOficina`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipoOficina` (
  `idTipoOficina` smallint(6) NOT NULL AUTO_INCREMENT,
  `tipoOficina` varchar(15) NOT NULL,
  PRIMARY KEY (`idTipoOficina`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoOficina`
--

LOCK TABLES `tipoOficina` WRITE;
/*!40000 ALTER TABLE `tipoOficina` DISABLE KEYS */;
INSERT INTO `tipoOficina` VALUES (1,'Interna'),(2,'Externa'),(3,'Virtual');
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
  `idPerfil` int(11) NOT NULL,
  `idRol` smallint(6) DEFAULT NULL,
  `permisos` longtext COMMENT '(DC2Type:json_array)',
  `activo` tinyint(1) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `UNIQ_usuario_perfil_idx` (`idPerfil`),
  UNIQUE KEY `UNIQ_usuario_idx` (`usuario`),
  KEY `usuario_rol_idx` (`idRol`),
  CONSTRAINT `fk_usuario_perfil` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'administrador','$2y$13$PV2vHlAy.LwjXtLetaUM3uJcDmduhPQ2Zpz2rj.Em1I/atyLxiiTW',1,2,'[\"EXP_NEW\",\"EXP_ADD\",\"EXP_EDIT\",\"EXP_DOWNLOAD\",\"EXP_MOVEMENT\",\"MOV_NEW\",\"REP_NEW\",\"PROJ_NEW\",\"PROJ_EDIT\",\"PROJ_DOWNLOAD\",\"COM_ADD\",\"COM_EDIT\",\"COM_DEL\",\"COM_DET\",\"CON_ADD\",\"CON_EDIT\",\"CON_DEL\",\"USR_ADD\",\"USR_EDIT\", \"USR_LOCK\", \"USR_UNLOK\"]',1,'2017-05-21 21:27:30','administrador',NULL,NULL);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'sistema_legislativo'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-27 22:02:49
