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
INSERT INTO `bloque` VALUES (1,'Frente Renovador',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(2,'Frente Para la Victoria',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(3,'UNA',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(4,'UCR',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(5,'GEN',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(6,'Cambiemos',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(7,'bloque modificado',0,'2017-08-12 22:02:22','administrador','2017-08-12 22:05:22','administrador');
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
  `letraOrdenDelDia` varchar(1) NOT NULL,
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
INSERT INTO `comision` VALUES (1,2,3,2,'Defensa del Usuario','T',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(2,19,5,2,'Promoción de la Comunidad','S',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(3,14,3,2,'Seguridad y Justicia','P',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(4,5,22,2,'Mujeres y Equidad de Género','Q',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(5,11,9,2,'Presupuesto y Hacienda','F',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(6,18,15,2,'Derechos y Garantías','K',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(7,6,19,2,'Interpretación y Reglamento','X',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(8,23,20,2,'Habitat, Tierras y Viendas','N',1,'2017-08-12 00:00:00','Administrador','2017-08-12 13:44:21','administrador'),(9,22,5,2,'Planeamiento','W',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(10,16,13,2,'Ecología y Protección del Medio Ambiente','Y',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(11,8,3,2,'Obras Públicas y Urbanismo','G',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(12,14,15,2,'Servicios Públicos','H',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(13,13,4,2,'Labor Legislativa','L',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(14,15,23,2,'Cultura y Educación','R',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(15,9,4,2,'Industria y Comercio Interior y Exterior','M',1,'2017-08-12 00:00:00','Administrador',NULL,NULL),(16,16,5,2,'Medios de Comunicación Social','O',1,'2017-08-12 00:00:00','Administrador',NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demandanteParticular`
--

LOCK TABLES `demandanteParticular` WRITE;
/*!40000 ALTER TABLE `demandanteParticular` DISABLE KEYS */;
INSERT INTO `demandanteParticular` VALUES (2,'sasajasgjs','agfshagfshaf','12121212');
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
  `idSesion` int(11) DEFAULT NULL,
  `discriminador` varchar(15) NOT NULL,
  `idProyectoRevision` int(11) DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `textoLibre` longtext NOT NULL,
  `idTipoDictamen` smallint(6) DEFAULT NULL,
  `textoArticulado` longtext COMMENT '(DC2Type:json_array)',
  PRIMARY KEY (`idDictamen`),
  KEY `dictamen_proyectoRevision_idx` (`idProyectoRevision`),
  KEY `dictamen_tipoProyecto_idx` (`idTipoDictamen`),
  KEY `dictamen_sesion_idx` (`idSesion`),
  CONSTRAINT `fk_dictamen_proyectoRevision` FOREIGN KEY (`idProyectoRevision`) REFERENCES `proyectoRevision` (`idProyectoRevision`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_dictamen_sesion` FOREIGN KEY (`idSesion`) REFERENCES `sesion` (`idSesion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_dictamen_tipoProyecto` FOREIGN KEY (`idTipoDictamen`) REFERENCES `tipoProyecto` (`idTipoProyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dictamen`
--

LOCK TABLES `dictamen` WRITE;
/*!40000 ALTER TABLE `dictamen` DISABLE KEYS */;
INSERT INTO `dictamen` VALUES (23,5,'basico',NULL,'2017-09-26 15:42:24','administrador','<p>hkjhjkhjk</p>',NULL,NULL),(24,NULL,'basico',NULL,'2017-09-26 15:43:05','administrador','<p>kjhkjhj</p>',NULL,NULL),(25,5,'basico',NULL,'2017-09-26 16:13:46','administrador','<p>dsdsdsdd</p>',NULL,NULL),(26,5,'basico',NULL,'2017-09-26 16:14:11','administrador','<p>hhffhfghfgh</p>',NULL,NULL),(27,5,'revision',6,'2017-09-26 16:14:16','administrador','<p>fhfghfgh</p>',NULL,NULL);
/*!40000 ALTER TABLE `dictamen` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estadoExpediente`
--

LOCK TABLES `estadoExpediente` WRITE;
/*!40000 ALTER TABLE `estadoExpediente` DISABLE KEYS */;
INSERT INTO `estadoExpediente` VALUES (1,'Ingresado'),(2,'Estudio Comisiones'),(3,'Dictamen Comisiones'),(4,'Reservado Comisión'),(5,'Sancionado'),(6,'Archivado'),(7,'Desarchivado'),(8,'Incorporado'),(9,'Esperando Recepción'),(10,'En trámite');
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
  `caratula` varchar(500) NOT NULL,
  `folios` varchar(4) NOT NULL,
  `listaImagenes` longtext COMMENT '(DC2Type:object)',
  `numeroSancion` varchar(20) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expediente`
--

LOCK TABLES `expediente` WRITE;
/*!40000 ALTER TABLE `expediente` DISABLE KEYS */;
INSERT INTO `expediente` VALUES (15,'9b7c80638945f86dcb9105906745382f',3,'1',2,'2017',3,5,NULL,NULL,'<p>dfddsdsdfsfds</p>','4','a:0:{}','8457','2017-08-18 11:46:04','2017-08-23 18:49:04','mesaHCD','administrador'),(16,'ce592a8e0cc8b8942685e51cc41f87d2',2,'2',1,'2017',3,5,NULL,NULL,'<p>ASAGSJGAJSGAJGSJS</p>','5','a:0:{}','','2017-08-19 21:34:51','2017-08-20 12:35:42','mesaHCD','comisionesHCD'),(17,'aae0cf303f9f16b8f73dbc593643ec5f',3,'3',4,'2017',3,5,2,NULL,'<p>gfsahfshagfsgahsf</p>','1','a:0:{}','','2017-08-19 21:34:51','2017-08-20 12:35:42','mesaHCD','comisionesHCD'),(18,'9ac32db801afa230c05becb9c5b1e846',2,'4',9,'2017',3,5,NULL,NULL,'<p>agsajsajsgasgasg</p>','2','a:0:{}','','2017-08-19 21:34:51','2017-08-20 12:35:42','mesaHCD','comisionesHCD'),(19,'1e3a4d06f093bb03ee37af63f1aaa430',10,'6',1,'2017',9,5,NULL,NULL,'<p>PROYECTO DE COMUNICACIÓN AL SR. INTENDENTE MUNICIPAL DON MARTIN INSAURRALDE REFERENTE PROGRAMA SAMO (SISTEMA DE ATENCION MEDICA ORGANIZADA).</p>','2','a:0:{}','','2017-09-09 21:22:59','2017-09-09 21:37:48','mesaHCD','mesaHCD'),(21,'4a4e99cc8c2ed86d17c3a93c7fbaf567',1,'5',4,'2017',9,4,4,NULL,'<p>asasasasasasas</p>','1','a:0:{}','','2017-09-05 10:27:55',NULL,'administrador',NULL),(23,'d0dca55313e75cfc5bdb9b36e1929ad2',1,'1',3,'2016',9,4,NULL,2,'<p>gsafhsgfahgsfhgasf</p>','1','a:0:{}','','2017-09-05 10:32:23',NULL,'administrador',NULL);
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
  `anulado` tinyint(1) NOT NULL,
  `idMovimiento` int(11) DEFAULT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  PRIMARY KEY (`idExpedienteComision`),
  KEY `expedienteComision_expediente_idx` (`idExpediente`),
  KEY `expedienteComision_movimiento_idx` (`idMovimiento`),
  KEY `expedienteComision_comision_idx` (`idComision`),
  CONSTRAINT `fk_expedienteComision_comision` FOREIGN KEY (`idComision`) REFERENCES `comision` (`idComision`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedienteComision_expediente` FOREIGN KEY (`idExpediente`) REFERENCES `expediente` (`idExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedienteComision_movimiento` FOREIGN KEY (`idMovimiento`) REFERENCES `movimiento` (`idMovimiento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expedienteComision`
--

LOCK TABLES `expedienteComision` WRITE;
/*!40000 ALTER TABLE `expedienteComision` DISABLE KEYS */;
INSERT INTO `expedienteComision` VALUES (20,1,15,0,1,'mesaHCD','2017-08-19 21:34:51','administrador','2017-08-26 21:12:32'),(21,2,16,0,2,'mesaHCD','2017-08-19 21:34:51',NULL,NULL),(22,3,17,0,3,'mesaHCD','2017-08-19 21:34:51',NULL,NULL),(23,4,18,0,4,'mesaHCD','2017-08-19 21:34:51',NULL,NULL),(24,3,15,0,1,'comisionesHCD','2017-08-20 12:42:49',NULL,NULL),(25,7,15,0,1,'comisionesHCD','2017-08-20 12:42:52',NULL,NULL),(26,4,19,1,5,'mesaHCD','2017-09-09 21:22:59','comisionesHCD','2017-09-09 21:35:42');
/*!40000 ALTER TABLE `expedienteComision` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expedienteComision_dictamenesMayoria`
--

DROP TABLE IF EXISTS `expedienteComision_dictamenesMayoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expedienteComision_dictamenesMayoria` (
  `idExpedienteComision` int(11) NOT NULL,
  `idDictamen` int(11) NOT NULL,
  PRIMARY KEY (`idExpedienteComision`,`idDictamen`),
  KEY `IDX_3BBFCEC8E3D06A5A` (`idExpedienteComision`),
  KEY `IDX_3BBFCEC88F297216` (`idDictamen`),
  CONSTRAINT `FK_3BBFCEC88F297216` FOREIGN KEY (`idDictamen`) REFERENCES `dictamen` (`idDictamen`),
  CONSTRAINT `FK_3BBFCEC8E3D06A5A` FOREIGN KEY (`idExpedienteComision`) REFERENCES `expedienteComision` (`idExpedienteComision`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expedienteComision_dictamenesMayoria`
--

LOCK TABLES `expedienteComision_dictamenesMayoria` WRITE;
/*!40000 ALTER TABLE `expedienteComision_dictamenesMayoria` DISABLE KEYS */;
INSERT INTO `expedienteComision_dictamenesMayoria` VALUES (20,25),(22,26),(24,27);
/*!40000 ALTER TABLE `expedienteComision_dictamenesMayoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expedienteComision_dictamenesPrimeraMinoria`
--

DROP TABLE IF EXISTS `expedienteComision_dictamenesPrimeraMinoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expedienteComision_dictamenesPrimeraMinoria` (
  `idExpedienteComision` int(11) NOT NULL,
  `idDictamen` int(11) NOT NULL,
  PRIMARY KEY (`idExpedienteComision`,`idDictamen`),
  KEY `IDX_D485C5CE3D06A5A` (`idExpedienteComision`),
  KEY `IDX_D485C5C8F297216` (`idDictamen`),
  CONSTRAINT `FK_D485C5C8F297216` FOREIGN KEY (`idDictamen`) REFERENCES `dictamen` (`idDictamen`),
  CONSTRAINT `FK_D485C5CE3D06A5A` FOREIGN KEY (`idExpedienteComision`) REFERENCES `expedienteComision` (`idExpedienteComision`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expedienteComision_dictamenesPrimeraMinoria`
--

LOCK TABLES `expedienteComision_dictamenesPrimeraMinoria` WRITE;
/*!40000 ALTER TABLE `expedienteComision_dictamenesPrimeraMinoria` DISABLE KEYS */;
INSERT INTO `expedienteComision_dictamenesPrimeraMinoria` VALUES (20,23),(24,23);
/*!40000 ALTER TABLE `expedienteComision_dictamenesPrimeraMinoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expedienteComision_dictamenesSegundaMinoria`
--

DROP TABLE IF EXISTS `expedienteComision_dictamenesSegundaMinoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expedienteComision_dictamenesSegundaMinoria` (
  `idExpedienteComision` int(11) NOT NULL,
  `idDictamen` int(11) NOT NULL,
  PRIMARY KEY (`idExpedienteComision`,`idDictamen`),
  KEY `IDX_6263EF99E3D06A5A` (`idExpedienteComision`),
  KEY `IDX_6263EF998F297216` (`idDictamen`),
  CONSTRAINT `FK_6263EF998F297216` FOREIGN KEY (`idDictamen`) REFERENCES `dictamen` (`idDictamen`),
  CONSTRAINT `FK_6263EF99E3D06A5A` FOREIGN KEY (`idExpedienteComision`) REFERENCES `expedienteComision` (`idExpedienteComision`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expedienteComision_dictamenesSegundaMinoria`
--

LOCK TABLES `expedienteComision_dictamenesSegundaMinoria` WRITE;
/*!40000 ALTER TABLE `expedienteComision_dictamenesSegundaMinoria` DISABLE KEYS */;
INSERT INTO `expedienteComision_dictamenesSegundaMinoria` VALUES (22,24);
/*!40000 ALTER TABLE `expedienteComision_dictamenesSegundaMinoria` ENABLE KEYS */;
UNLOCK TABLES;

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
  `idResolucion` int(11) DEFAULT NULL,
  `idEstadoExpedienteSesion` smallint(6) DEFAULT NULL,
  `texto` longtext NOT NULL,
  `aFavor` smallint(6) NOT NULL,
  `enContra` smallint(6) NOT NULL,
  `abstenciones` smallint(6) NOT NULL,
  PRIMARY KEY (`idExpedienteSesion`),
  UNIQUE KEY `expedienteSesion_resolucion_idx` (`idResolucion`),
  KEY `expedienteSesion_estadoExpedienteSesion_idx` (`idEstadoExpedienteSesion`),
  KEY `agendaSesion_sesion_idx` (`idSesion`),
  KEY `agendaSesion_expediente_idx` (`idExpediente`),
  KEY `expedienteSesion_tipoExpedienteSesion_idx` (`idTipoExpedienteSesion`),
  CONSTRAINT `fk_expedienteSesion_estadoExpedienteSesion` FOREIGN KEY (`idEstadoExpedienteSesion`) REFERENCES `estadoExpedienteSesion` (`idEstadoExpedienteSesion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedienteSesion_expediente` FOREIGN KEY (`idExpediente`) REFERENCES `expediente` (`idExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedienteSesion_resolucion` FOREIGN KEY (`idResolucion`) REFERENCES `resolucion` (`idResolucion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedienteSesion_sesion` FOREIGN KEY (`idSesion`) REFERENCES `sesion` (`idSesion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedienteSesion_tipoExpedienteSesion` FOREIGN KEY (`idTipoExpedienteSesion`) REFERENCES `tipoExpedienteSesion` (`idTipoExpedienteSesion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=483 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expedienteSesion`
--

LOCK TABLES `expedienteSesion` WRITE;
/*!40000 ALTER TABLE `expedienteSesion` DISABLE KEYS */;
INSERT INTO `expedienteSesion` VALUES (468,1,22,17,5,NULL,6,'<p><strong>A) 1.- GFSAHFSHAGFSGAHSF(EXPTE. 3-D-17)</strong></p><p>gfsahfshagfsgahsf</p><div style=\"text-align:center\">-----------------------------------------------------------------------</div>',0,0,0),(469,1,23,18,5,NULL,6,'<p><strong>B) 1.- AGSAJSAJSGASGASG(EXPTE. 4-D-17)</strong></p><p>agsajsajsgasgasg</p><p>Girado a:</p><ul><li>Mujeres y Equidad de Género</li></ul><div style=\"text-align:center\">-----------------------------------------------------------------------</div>',0,0,0),(470,1,24,16,5,NULL,6,'<p><strong>C) 1.- ASAGSJGAJSGAJGSJS(EXPTE. 2-P-17 / Cambiemos)</strong></p><div style=\"text-align:right\">Lomas de Zamora, 26 de septiembre de 2017.-</div><div style=\"text-align:center\"><h3><u>PROYECTO DE COMUNICACION</u></h3></div><h4><u>Vistos</u></h4><p style=\"text-align: justify;margin-top: 0\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;fhgfghfhgf</p><h4><u>Considerandos</u></h4><p style=\"text-align: justify;margin-top: 0\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ggjghghj</p><h4><u>Por todo ello:</u></h4><strong><p style=\"text-align: justify;margin-top: 0\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EL HONORABLE CONCEJO DELIBERANTE DE LOMAS DE ZAMORA EN EL USO DE LAS FACULTADES QUE LE SON PROPIAS SANCIONA LA SIGUIENTE:</p></strong><div style=\"text-align:center\"><h3><u>COMUNICACION</u></h3></div><p><strong><u>Artículo 1</u>°.-</strong> hhGDJHGDJASGD</p><ul style=\"list-style-type: none;\"><p style=\"text-align: justify;margin-top: 0;\"><strong>a)</strong> SGDASF</p></ul><div style=\"text-align:center\">-----------------------------------------------------------------------</div>',0,0,0),(471,2,24,19,5,NULL,6,'<p><strong>C) 2.- PROYECTO DE COMUNICACIÓN AL SR. INTENDENTE MUNICIPAL DON MARTIN INSAURRALDE REFERENTE PROGRAMA SAMO (SISTEMA DE ATENCION MEDICA ORGANIZADA).(EXPTE. 6-P-17 / Cambiemos)</strong></p><div style=\"text-align:right\">Lomas de Zamora, 26 de septiembre de 2017.-</div><div style=\"text-align:center\"><h3><u>PROYECTO DE COMUNICACION</u></h3></div><h4><u>Vistos</u></h4><p style=\"text-align: justify;margin-top: 0\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Que dicha asistencia encuadra dentro del Programa SAMO que depende del Ministerio de Salud de la Provincia de Buenos Aires, el cual de ser implementado por la dirección antes mencionada generaría recursos para este municipio y para la Provincia de Buenos Aires en el porcentaje de coparticipación que le correspondería.</p><p style=\"text-align: justify;margin-top: 0\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Que actualmente, el municipio de Lomas de Zamora cuenta con doce ambulancias propias y quince del Programa SAME, teniendo una estadística mensual de traslados de personas por emergencias, entre 2500 al 2800 por mes brindando este servicio en forma totalmente gratuita.<br></p><h4><u>Considerandos</u></h4><p style=\"text-align: justify;margin-top: 0\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Que dicha asistencia encuadra dentro del Programa SAMO que depende del Ministerio de Salud de la Provincia de Buenos Aires, el cual de ser implementado por la dirección antes mencionada generaría recursos para este municipio y para la Provincia de Buenos Aires en el porcentaje de coparticipación que le correspondería.&nbsp;</p><p style=\"text-align: justify;margin-top: 0\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Que actualmente, el municipio de Lomas de Zamora cuenta con doce ambulancias propias y quince del Programa SAME, teniendo una estadística mensual de traslados de personas por emergencias, entre 2500 al 2800 por mes brindando este servicio en forma totalmente gratuita.<br></p><h4><u>Por todo ello:</u></h4><strong><p style=\"text-align: justify;margin-top: 0\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EL HONORABLE CONCEJO DELIBERANTE DE LOMAS DE ZAMORA EN EL USO DE LAS FACULTADES QUE LE SON PROPIAS SANCIONA LA SIGUIENTE:</p></strong><div style=\"text-align:center\"><h3><u>COMUNICACION</u></h3></div><p><strong><u>Artículo 1</u>°.-</strong> no se me ocurre nada</p><ul style=\"list-style-type: none;\"><p style=\"text-align: justify;margin-top: 0;\"><strong>a)</strong> inciso a</p><p style=\"text-align: justify;margin-top: 0;\"><strong>b)</strong> inciso b</p></ul><p><strong><u>Artículo 2</u>°.-</strong> ahora se me ocurre menos</p><ul style=\"list-style-type: none;\"><p style=\"text-align: justify;margin-top: 0;\"><strong>a)</strong> otro inciso a</p><p style=\"text-align: justify;margin-top: 0;\"><strong>b)</strong> otro inciso b</p></ul><div style=\"text-align:center\">-----------------------------------------------------------------------</div>',0,0,0),(472,1,26,15,5,NULL,6,'<p><strong>D) 1.- DFDDSDSDFSFDS(EXPTE. 1-P-17 / Frente Para la Victoria)</strong></p><p>Girado a:</p><ul><li>Defensa del Usuario</li><li>Seguridad y Justicia</li><li>Interpretación y Reglamento</li></ul><div style=\"text-align:right\">Lomas de Zamora, 26 de septiembre de 2017.-</div><div style=\"text-align:center\"><h3><u>PROYECTO DE ORDENANZA</u></h3></div><h4><u>Vistos</u></h4><p style=\"text-align: justify;margin-top: 0\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;agsajgsajgs</p><p style=\"text-align: justify;margin-top: 0\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;gkfkjfklj</p><h4><u>Considerandos</u></h4><div>sjagsjagsjasg</div><div><p style=\"text-align: justify;margin-top: 0\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></div><h4><u>Por todo ello:</u></h4><strong><p style=\"text-align: justify;margin-top: 0\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EL HONORABLE CONCEJO DELIBERANTE DE LOMAS DE ZAMORA EN EL USO DE LAS FACULTADES QUE LE SON PROPIAS SANCIONA LA SIGUIENTE:</p></strong><div style=\"text-align:center\"><h3><u>ORDENANZA</u></h3></div><p><strong><u>Artículo 1</u>°.-</strong> ajsaskaj</p><ul style=\"list-style-type: none;\"><p style=\"text-align: justify;margin-top: 0;\"><strong>a)</strong> kakjslakjs</p></ul><p><strong><u>Artículo 2</u>°.-</strong> ,asaskjahskjah</p><p style=\"text-align: justify;margin-top: 0;\">saslk</p><ul style=\"list-style-type: none;\"><p style=\"text-align: justify;margin-top: 0;\"><strong>a)</strong> sa</p><p style=\"text-align: justify;margin-top: 0;\">blaclacla</p><p style=\"text-align: justify;margin-top: 0;\"><strong>b)</strong> sas</p></ul><p><strong><u>Artículo 3</u>°.-</strong> agsajgsjhga</p><p><strong><u>Artículo 4</u>°.-</strong> ajsakjhskajs</p><ul style=\"list-style-type: none;\"><p style=\"text-align: justify;margin-top: 0;\"><strong>a)</strong> sasas</p></ul><div style=\"text-align:center\">-----------------------------------------------------------------------</div>',0,0,0),(473,1,36,15,5,NULL,6,'<p><strong>P) 1.- DFDDSDSDFSFDS(EXPTE. 1-P-17 / Frente Para la Victoria)</strong></p><div style=\"text-align:right\">Lomas de Zamora, 26 de septiembre de 2017.-</div><div style=\"text-align:center\"><h3><u>PROYECTO DE ORDENANZA</u></h3></div><h4><u>Vistos</u></h4><p style=\"text-align: justify;margin-top: 0\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;agsajgsajgs</p><p style=\"text-align: justify;margin-top: 0\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;gkfkjfklj</p><h4><u>Considerandos</u></h4><div>sjagsjagsjasg</div><div><p style=\"text-align: justify;margin-top: 0\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p></div><div style=\"text-align:center\"><h3><u>ORDENANZA</u></h3></div><p><strong><u>Artículo 1</u>°.-</strong> ajsaskaj</p><ul style=\"list-style-type: none;\"><p style=\"text-align: justify;margin-top: 0;\"><strong>a)</strong> kakjslakjs</p></ul><p><strong><u>Artículo 2</u>°.-</strong> ,asaskjahskjah</p><p style=\"text-align: justify;margin-top: 0;\">saslk</p><ul style=\"list-style-type: none;\"><p style=\"text-align: justify;margin-top: 0;\"><strong>a)</strong> sa</p><p style=\"text-align: justify;margin-top: 0;\">blaclacla</p><p style=\"text-align: justify;margin-top: 0;\"><strong>b)</strong> sas</p></ul><p><strong><u>Artículo 3</u>°.-</strong> agsajgsjhga</p><p><strong><u>Artículo 4</u>°.-</strong> ajsakjhskajs</p><ul style=\"list-style-type: none;\"><p style=\"text-align: justify;margin-top: 0;\"><strong>a)</strong> sasas</p></ul><div style=\"text-align:center\">-----------------------------------------------------------------------</div>',0,0,0),(474,2,36,17,5,NULL,6,'<p><strong>P) 2.- GFSAHFSHAGFSGAHSF(EXPTE. 3-D-17)</strong></p><p style=\"text-align: justify;margin-top: 0\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;hhffhfghfgh</p><div style=\"text-align:center\">-----------------------------------------------------------------------</div>',0,0,0),(475,1,40,15,5,NULL,6,'<p><strong>T) 1.- DFDDSDSDFSFDS(EXPTE. 1-P-17)</strong></p><p style=\"text-align: justify;margin-top: 0\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;dsdsdsdd</p><div style=\"text-align:center\">-----------------------------------------------------------------------</div>',0,0,0),(476,1,44,15,5,NULL,6,'<p><strong>Z) 1.- DFDDSDSDFSFDS(EXPTE. 1-P-17)</strong></p><p>Comisiones:</p><ul><li>Defensa del Usuario</li><li>Seguridad y Justicia</li></ul><p style=\"text-align: justify;margin-top: 0\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;hkjhjkhjk</p><div style=\"text-align:center\">-----------------------------------------------------------------------</div>',0,0,0);
/*!40000 ALTER TABLE `expedienteSesion` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `sistema_legislativo`.`expedienteSesion_BEFORE_INSERT` BEFORE INSERT ON `expedienteSesion` FOR EACH ROW
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
-- Table structure for table `expedienteSesionPrueba`
--

DROP TABLE IF EXISTS `expedienteSesionPrueba`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expedienteSesionPrueba` (
  `idExpedienteSesion` int(11) NOT NULL AUTO_INCREMENT,
  `ordenSesion` smallint(6) NOT NULL,
  `idTipoExpedienteSesion` int(11) DEFAULT NULL,
  `idExpediente` int(11) DEFAULT NULL,
  `idSesion` int(11) DEFAULT NULL,
  `idEstadoExpedienteSesion` smallint(6) DEFAULT NULL,
  `texto` longtext NOT NULL,
  `aFavor` smallint(6) NOT NULL DEFAULT '0',
  `enContra` smallint(6) NOT NULL DEFAULT '0',
  `abstenciones` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idExpedienteSesion`)
) ENGINE=InnoDB AUTO_INCREMENT=227 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expedienteSesionPrueba`
--

LOCK TABLES `expedienteSesionPrueba` WRITE;
/*!40000 ALTER TABLE `expedienteSesionPrueba` DISABLE KEYS */;
INSERT INTO `expedienteSesionPrueba` VALUES (204,1,22,17,5,6,'<p><strong>A) 1.- GFSAHFSHAGFSGAHSF(EXPTE. 3-D-2017)</strong></p><p>gfsahfshagfsgahsf</p>',0,0,0),(205,1,23,18,5,6,'<p><strong>B) 1.- AGSAJSAJSGASGASG(EXPTE. 4-D-2017)</strong></p><p>agsajsajsgasgasg</p><p>Girado a:</p><ul><li>Mujeres y Equidad de Género</li></ul>',0,0,0),(206,1,24,16,5,6,'<p><strong>C) 1.- ASAGSJGAJSGAJGSJS(EXPTE. 2-P-2017 / Cambiemos)</strong></p><div style=\"text-align:center\"><h3>PROYECTO DE COMUNICACION</h3></div><h4>Vistos</h4><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\">fhgfghfhgf</p><h4>Considerandos</h4><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\">ggjghghj</p><div style=\"text-align:center\"><h3>COMUNICACION</h3></div><p>1°.- hhGDJHGDJASGD</p<ul style=\"list-style-type: none;\"><p style=\"text-align: justify;margin-top: 0;margin-left: 1.5em;\">a) SGDASF</p>',0,0,0),(207,2,24,19,5,6,'<p><strong>C) 2.- PROYECTO DE COMUNICACIÓN AL SR. INTENDENTE MUNICIPAL DON MARTIN INSAURRALDE REFERENTE PROGRAMA SAMO (SISTEMA DE ATENCION MEDICA ORGANIZADA).(EXPTE. 6-P-2017 / Cambiemos)</strong></p><div style=\"text-align:center\"><h3>PROYECTO DE COMUNICACION</h3></div><h4>Vistos</h4><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\">Que dicha asistencia encuadra dentro del Programa SAMO que depende del Ministerio de Salud de la Provincia de Buenos Aires, el cual de ser implementado por la dirección antes mencionada generaría recursos para este municipio y para la Provincia de Buenos Aires en el porcentaje de coparticipación que le correspondería.</p><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\">Que actualmente, el municipio de Lomas de Zamora cuenta con doce ambulancias propias y quince del Programa SAME, teniendo una estadística mensual de traslados de personas por emergencias, entre 2500 al 2800 por mes brindando este servicio en forma totalmente gratuita.<br></p><h4>Considerandos</h4><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\">Que dicha asistencia encuadra dentro del Programa SAMO que depende del Ministerio de Salud de la Provincia de Buenos Aires, el cual de ser implementado por la dirección antes mencionada generaría recursos para este municipio y para la Provincia de Buenos Aires en el porcentaje de coparticipación que le correspondería.&nbsp;</p><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\">Que actualmente, el municipio de Lomas de Zamora cuenta con doce ambulancias propias y quince del Programa SAME, teniendo una estadística mensual de traslados de personas por emergencias, entre 2500 al 2800 por mes brindando este servicio en forma totalmente gratuita.<br></p><div style=\"text-align:center\"><h3>COMUNICACION</h3></div><p>1°.- no se me ocurre nada</p<ul style=\"list-style-type: none;\"><p style=\"text-align: justify;margin-top: 0;margin-left: 1.5em;\">a) inciso a</p><p style=\"text-align: justify;margin-top: 0;margin-left: 1.5em;\">b) inciso b</p><p>2°.- ahora se me ocurre menos</p<ul style=\"list-style-type: none;\"><p style=\"text-align: justify;margin-top: 0;margin-left: 1.5em;\">a) otro inciso a</p><p style=\"text-align: justify;margin-top: 0;margin-left: 1.5em;\">b) otro inciso b</p>',0,0,0),(208,1,26,15,5,6,'<p><strong>D) 1.- DFDDSDSDFSFDS(EXPTE. 1-P-2017 / Frente Para la Victoria)</strong></p><p>Girado a:</p><ul><li>Defensa del Usuario</li><li>Seguridad y Justicia</li><li>Interpretación y Reglamento</li></ul><div style=\"text-align:center\"><h3>PROYECTO DE ORDENANZA</h3></div><h4>Vistos</h4><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\">agsajgsajgs</p><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\">gkfkjfklj</p><h4>Considerandos</h4><div>sjagsjagsjasg</div><div><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\"></p></div><div style=\"text-align:center\"><h3>ORDENANZA</h3></div><p>1°.- ajsaskaj</p<ul style=\"list-style-type: none;\"><p style=\"text-align: justify;margin-top: 0;margin-left: 1.5em;\">a) kakjslakjs</p><p>2°.- ,asaskjahskjah</p<p style=\"text-align: justify;margin-top: 0;\">saslk</p><ul style=\"list-style-type: none;\"><p style=\"text-align: justify;margin-top: 0;margin-left: 1.5em;\">a) sa</p><p style=\"text-align: justify;margin-top: 0;margin-left: 1.5em;\">blaclacla</p><p style=\"text-align: justify;margin-top: 0;margin-left: 1.5em;\">b) sas</p><p>3°.- agsajgsjhga</p<p>4°.- ajsakjhskajs</p<ul style=\"list-style-type: none;\"><p style=\"text-align: justify;margin-top: 0;margin-left: 1.5em;\">a) sasas</p>',0,0,0),(209,1,40,15,5,6,'<p><strong>T) 1.- DFDDSDSDFSFDS(EXPTE. 1-P-2017)</strong></p><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\">ghfhgfgghf</p>',0,0,0),(210,2,40,15,5,6,'<p><strong>T) 2.- DFDDSDSDFSFDS(EXPTE. 1-P-2017)</strong></p><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\">shgaJGSJHGAsjA</p>',0,0,0),(211,3,40,15,5,6,'<p><strong>T) 3.- DFDDSDSDFSFDS(EXPTE. 1-P-2017)</strong></p><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\">vxxvxvcxvcx</p>',0,0,0),(219,2,22,17,5,6,'<p><strong>A) 2.- GFSAHFSHAGFSGAHSF(EXPTE. 3-D-2017)</strong></p><p>gfsahfshagfsgahsf</p>',0,0,0),(220,2,23,18,5,6,'<p><strong>B) 2.- AGSAJSAJSGASGASG(EXPTE. 4-D-2017)</strong></p><p>agsajsajsgasgasg</p><p>Girado a:</p><ul><li>Mujeres y Equidad de Género</li></ul>',0,0,0),(221,3,24,16,5,6,'<p><strong>C) 3.- ASAGSJGAJSGAJGSJS(EXPTE. 2-P-2017 / Cambiemos)</strong></p><div style=\"text-align:center\"><h3>PROYECTO DE COMUNICACION</h3></div><h4>Vistos</h4><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\">fhgfghfhgf</p><h4>Considerandos</h4><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\">ggjghghj</p><div style=\"text-align:center\"><h3>COMUNICACION</h3></div><p>1°.- hhGDJHGDJASGD</p<ul style=\"list-style-type: none;\"><p style=\"text-align: justify;margin-top: 0;margin-left: 1.5em;\">a) SGDASF</p>',0,0,0),(222,4,24,19,5,6,'<p><strong>C) 4.- PROYECTO DE COMUNICACIÓN AL SR. INTENDENTE MUNICIPAL DON MARTIN INSAURRALDE REFERENTE PROGRAMA SAMO (SISTEMA DE ATENCION MEDICA ORGANIZADA).(EXPTE. 6-P-2017 / Cambiemos)</strong></p><div style=\"text-align:center\"><h3>PROYECTO DE COMUNICACION</h3></div><h4>Vistos</h4><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\">Que dicha asistencia encuadra dentro del Programa SAMO que depende del Ministerio de Salud de la Provincia de Buenos Aires, el cual de ser implementado por la dirección antes mencionada generaría recursos para este municipio y para la Provincia de Buenos Aires en el porcentaje de coparticipación que le correspondería.</p><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\">Que actualmente, el municipio de Lomas de Zamora cuenta con doce ambulancias propias y quince del Programa SAME, teniendo una estadística mensual de traslados de personas por emergencias, entre 2500 al 2800 por mes brindando este servicio en forma totalmente gratuita.<br></p><h4>Considerandos</h4><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\">Que dicha asistencia encuadra dentro del Programa SAMO que depende del Ministerio de Salud de la Provincia de Buenos Aires, el cual de ser implementado por la dirección antes mencionada generaría recursos para este municipio y para la Provincia de Buenos Aires en el porcentaje de coparticipación que le correspondería.&nbsp;</p><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\">Que actualmente, el municipio de Lomas de Zamora cuenta con doce ambulancias propias y quince del Programa SAME, teniendo una estadística mensual de traslados de personas por emergencias, entre 2500 al 2800 por mes brindando este servicio en forma totalmente gratuita.<br></p><div style=\"text-align:center\"><h3>COMUNICACION</h3></div><p>1°.- no se me ocurre nada</p<ul style=\"list-style-type: none;\"><p style=\"text-align: justify;margin-top: 0;margin-left: 1.5em;\">a) inciso a</p><p style=\"text-align: justify;margin-top: 0;margin-left: 1.5em;\">b) inciso b</p><p>2°.- ahora se me ocurre menos</p<ul style=\"list-style-type: none;\"><p style=\"text-align: justify;margin-top: 0;margin-left: 1.5em;\">a) otro inciso a</p><p style=\"text-align: justify;margin-top: 0;margin-left: 1.5em;\">b) otro inciso b</p>',0,0,0),(223,2,26,15,5,6,'<p><strong>D) 2.- DFDDSDSDFSFDS(EXPTE. 1-P-2017 / Frente Para la Victoria)</strong></p><p>Girado a:</p><ul><li>Defensa del Usuario</li><li>Seguridad y Justicia</li><li>Interpretación y Reglamento</li></ul><div style=\"text-align:center\"><h3>PROYECTO DE ORDENANZA</h3></div><h4>Vistos</h4><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\">agsajgsajgs</p><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\">gkfkjfklj</p><h4>Considerandos</h4><div>sjagsjagsjasg</div><div><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\"></p></div><div style=\"text-align:center\"><h3>ORDENANZA</h3></div><p>1°.- ajsaskaj</p<ul style=\"list-style-type: none;\"><p style=\"text-align: justify;margin-top: 0;margin-left: 1.5em;\">a) kakjslakjs</p><p>2°.- ,asaskjahskjah</p<p style=\"text-align: justify;margin-top: 0;\">saslk</p><ul style=\"list-style-type: none;\"><p style=\"text-align: justify;margin-top: 0;margin-left: 1.5em;\">a) sa</p><p style=\"text-align: justify;margin-top: 0;margin-left: 1.5em;\">blaclacla</p><p style=\"text-align: justify;margin-top: 0;margin-left: 1.5em;\">b) sas</p><p>3°.- agsajgsjhga</p<p>4°.- ajsakjhskajs</p<ul style=\"list-style-type: none;\"><p style=\"text-align: justify;margin-top: 0;margin-left: 1.5em;\">a) sasas</p>',0,0,0),(224,4,40,15,5,6,'<p><strong>T) 4.- DFDDSDSDFSFDS(EXPTE. 1-P-2017)</strong></p><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\">ghfhgfgghf</p>',0,0,0),(225,5,40,15,5,6,'<p><strong>T) 5.- DFDDSDSDFSFDS(EXPTE. 1-P-2017)</strong></p><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\">shgaJGSJHGAsjA</p>',0,0,0),(226,6,40,15,5,6,'<p><strong>T) 6.- DFDDSDSDFSFDS(EXPTE. 1-P-2017)</strong></p><p style=\"text-align: justify;margin-top: 0;text-indent: 1.5em\">vxxvxvcxvcx</p>',0,0,0);
/*!40000 ALTER TABLE `expedienteSesionPrueba` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `sistema_legislativo`.`expedienteSesionPrueba_BEFORE_INSERT` BEFORE INSERT ON `expedienteSesionPrueba` FOR EACH ROW
BEGIN
	set @ordenSesion:=((select count(*) from expedienteSesionPrueba
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
INSERT INTO `menu` VALUES (1,'Gestión Expedientes','EXP_MAIN'),(2,'Movimientos','MOV_MAIN'),(4,'Proyectos','PROJ_MAIN'),(5,'Comisiones-AM','COM_MAIN'),(6,'Comisiones-Expedientes','COM_EXP_MAIN'),(7,'Concejales','CON_MAIN'),(8,'Usuarios','USR_MAIN');
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
INSERT INTO `menuItem` VALUES (1,1,'Nuevo','EXP_NEW'),(2,1,'Ingresar Proyecto','EXP_ADD'),(3,1,'Editar','EXP_EDIT'),(4,1,'Descargar','EXP_DOWNLOAD'),(5,1,'Consulta Movimientos e Informes','EXP_MOVEMENT'),(6,2,'Agregar','MOV_NEW'),(8,4,'Nuevo','PROJ_NEW'),(9,4,'Editar','PROJ_EDIT'),(10,4,'Descargar','PROJ_DOWNLOAD'),(11,5,'Agregar','COM_ADD'),(12,5,'Editar','COM_EDIT'),(13,5,'Eliminar','COM_DEL'),(14,5,'Detalle','COM_DET'),(15,6,'Agregar','CON_ADD'),(16,6,'Editar','CON_EDIT'),(17,6,'Eliminar','CON_DEL'),(18,7,'Agregar','USR_ADD'),(19,7,'Editar','USR_EDIT'),(20,7,'Bloquear','USR_LOCK'),(21,7,'Desbloquear','USR_UNLOK'),(22,2,'Anular','MOV_ABORT'),(23,2,'Recibir','MOV_RECEIVE'),(24,2,'Descargar','MOV_DOWNLOAD'),(25,1,'Retornar ','EXP_RETURN'),(26,1,'Marcar Respuesta CH','EXP_REPORT_RETURN');
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
  `discriminador` varchar(7) NOT NULL,
  `idExpediente` int(11) DEFAULT NULL,
  `idRemito` int(11) DEFAULT NULL,
  `observacion` varchar(200) DEFAULT NULL,
  `anulado` tinyint(1) DEFAULT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `fojas` smallint(6) DEFAULT NULL,
  `remitoRetorno` datetime DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movimiento`
--

LOCK TABLES `movimiento` WRITE;
/*!40000 ALTER TABLE `movimiento` DISABLE KEYS */;
INSERT INTO `movimiento` VALUES (1,'pase',15,1,'',0,'mesaHCD','2017-08-19 21:34:51',NULL,NULL,4,NULL,NULL,NULL,NULL),(2,'pase',16,1,'',0,'mesaHCD','2017-08-19 21:34:51',NULL,NULL,5,NULL,NULL,NULL,NULL),(3,'pase',17,1,'',0,'mesaHCD','2017-08-19 21:34:51',NULL,NULL,1,NULL,NULL,NULL,NULL),(4,'pase',18,1,'',0,'mesaHCD','2017-08-19 21:34:51',NULL,NULL,2,NULL,NULL,NULL,NULL),(5,'pase',19,2,'kkljlkjjljlkj',0,'mesaHCD','2017-09-09 21:22:59',NULL,NULL,2,NULL,NULL,NULL,NULL),(6,'pase',19,3,'Devuelto por anulacion de comisiones',0,'comisionesHCD','2017-09-09 21:35:56',NULL,NULL,2,NULL,NULL,NULL,NULL);
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
  `$oficina` varchar(100) NOT NULL,
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
INSERT INTO `oficina` VALUES (2,'ARCHIVO GENERAL','190',2,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(3,'COMISIONES','',1,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(4,'CONTADURÍA MUNICIPAL','32',2,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(5,'DESPACHO','',1,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(6,'DIRECCIÓN DE LIQUIDACIÓN DE HABERES','38',2,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(7,'DIRECCIÓN GENERAL DE CONTENCIOSO','4017',2,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(8,'DIRECCIÓN GENERAL DE OFICIOS','3202',2,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(9,'MESA DE ENTRADAS','',1,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(10,'SECRETARIA DE HACIENDA','30',2,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(11,'SECRETARIA DE LEGAL Y TÉCNICA','3200',2,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(12,'SECRETARIA GENERAL','2200',2,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(13,'SUBSECRETARIA DE RECURSOS HUMANOS','2201',2,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(14,'SECRETARIA','',1,1,'2017-08-12 00:00:00','administrador',NULL,NULL),(15,'AAAAA','1602',2,0,'2017-08-12 23:13:45','administrador','2017-08-12 23:19:30','administrador'),(16,'AAAAA','1602',2,0,'2017-08-12 23:14:22','administrador','2017-08-12 23:19:32','administrador'),(17,'AAAAA','1601',2,0,'2017-08-12 23:17:15','administrador','2017-08-12 23:19:34','administrador');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `origenExterno`
--

LOCK TABLES `origenExterno` WRITE;
/*!40000 ALTER TABLE `origenExterno` DISABLE KEYS */;
INSERT INTO `origenExterno` VALUES (1,4,'[{\"ente\":\"5555\",\"numero\":\"555555\",\"letra\":\"l\",\"a\\u00f1o\":\"5555\",\"folios\":\"556\",\"cuerpos\":\"2\"}]'),(2,4,'[{\"ente\":\"5454\",\"numero\":\"45454\",\"letra\":\"m\",\"a\\u00f1o\":\"5454\",\"folios\":\"545\",\"cuerpos\":\"4\"}]'),(4,2,'[{\"ente\":\"4545\",\"numero\":\"4545454\",\"letra\":\"l\",\"a\\u00f1o\":\"5545\",\"folios\":\"545\",\"cuerpos\":\"4\"}]');
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
  `muneroDocumento` int(11) DEFAULT NULL,
  `domicilio` varchar(100) DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`idPerfil`),
  KEY `perfil_bloque_idx` (`idBloque`),
  CONSTRAINT `fk_perfil_bloque` FOREIGN KEY (`idBloque`) REFERENCES `bloque` (`idBloque`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil`
--

LOCK TABLES `perfil` WRITE;
/*!40000 ALTER TABLE `perfil` DISABLE KEYS */;
INSERT INTO `perfil` VALUES (1,'basico',NULL,'Administrador','Sistema',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(2,'legislador',NULL,'Fuente Buena','Hector',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(3,'legislador',NULL,'Font','Miguel',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(4,'legislador',NULL,'Guirliddo','Gabriel',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(5,'legislador',NULL,'Vilar','Daniela',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(6,'legislador',NULL,'Tranfo','Ana ',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(7,'legislador',NULL,'Mercuri','Gabriel',NULL,NULL,6,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(8,'legislador',NULL,'Castagnini','Juan Manuel',NULL,NULL,3,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(9,'legislador',NULL,'Veliz','Juan Carlos',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(10,'legislador',NULL,'Figuerón','Luis',NULL,NULL,5,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(11,'legislador',NULL,'Menéndez','Claudio',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(12,'legislador',NULL,'Oyhaburu','Sergio',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(13,'legislador',NULL,'Llambi','Alvaro',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(14,'legislador',NULL,'Baloira','Emilano',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(15,'legislador',NULL,'Lopez','Vanesa',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(16,'legislador',NULL,'Coba','José',NULL,NULL,6,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(17,'legislador',NULL,'Vázquez','María Fernanda',NULL,NULL,3,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(18,'legislador',NULL,'Herrera','Maria Elena ',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(19,'legislador',NULL,'Trezza Silva','Ramiro',NULL,NULL,3,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(20,'legislador',NULL,'Cordera','Diego',NULL,NULL,6,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(21,'legislador',NULL,'Rivero','Julio',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(22,'legislador',NULL,'Sierra','Silvia',NULL,NULL,6,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(23,'legislador',NULL,'Denuchi','Fabio',NULL,NULL,6,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(24,'legislador',NULL,'Pellegrini','Marcelo',NULL,NULL,4,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(25,'legislador',NULL,'Carasatorre','Santiago Alberto',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-06-12 14:53:53','administrador',NULL,NULL),(26,'basico',NULL,'Oficina Mesa Entradas','Usuario',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,'2017-07-28 17:39:45','administrador','2017-07-30 20:32:24','administrador'),(27,'basico',NULL,'Oficina Comisiones','Usuario',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL,'2017-07-28 17:51:54','administrador',NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyecto`
--

LOCK TABLES `proyecto` WRITE;
/*!40000 ALTER TABLE `proyecto` DISABLE KEYS */;
INSERT INTO `proyecto` VALUES (8,15,2,14,'asfalto, lima y cochabamba, asamblea vecinals','<p>agsajgsajgs</p><p>gkfkjfklj</p>','<div>sjagsjagsjasg</div><div><p></p></div>','[{\"texto\":\"<p>ajsaskaj<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>kakjslakjs<\\/p>\"}],\"numero\":1},{\"numero\":\"2\",\"texto\":\"<p>,asaskjahskjah<\\/p><p>saslk<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>sa<\\/p><p>blaclacla<\\/p>\"},{\"orden\":\"b\",\"texto\":\"<p>sas<\\/p>\"}]},{\"texto\":\"<p>agsajgsjhga<\\/p>\",\"incisos\":[],\"numero\":3},{\"texto\":\"<p>ajsakjhskajs<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>sasas<\\/p>\"}],\"numero\":4}]','2017-08-19 13:45:40','administrador','2017-08-23 21:41:04','administrador'),(9,16,1,22,'calle, pozo, intendencia','<p>fhgfghfhgf</p>','<p>ggjghghj</p>','[{\"texto\":\"<p>hhGDJHGDJASGD<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>SGDASF<\\/p>\"}],\"numero\":1}]','2017-08-19 18:52:23','administrador',NULL,NULL),(10,19,1,22,'samo','<p>Que dicha asistencia encuadra dentro del Programa SAMO que depende del Ministerio de Salud de la Provincia de Buenos Aires, el cual de ser implementado por la dirección antes mencionada generaría recursos para este municipio y para la Provincia de Buenos Aires en el porcentaje de coparticipación que le correspondería.</p><p>Que actualmente, el municipio de Lomas de Zamora cuenta con doce ambulancias propias y quince del Programa SAME, teniendo una estadística mensual de traslados de personas por emergencias, entre 2500 al 2800 por mes brindando este servicio en forma totalmente gratuita.<br></p>','<p>Que dicha asistencia encuadra dentro del Programa SAMO que depende del Ministerio de Salud de la Provincia de Buenos Aires, el cual de ser implementado por la dirección antes mencionada generaría recursos para este municipio y para la Provincia de Buenos Aires en el porcentaje de coparticipación que le correspondería.&nbsp;</p><p>Que actualmente, el municipio de Lomas de Zamora cuenta con doce ambulancias propias y quince del Programa SAME, teniendo una estadística mensual de traslados de personas por emergencias, entre 2500 al 2800 por mes brindando este servicio en forma totalmente gratuita.<br></p>','[{\"numero\":\"1\",\"texto\":\"<p>no se me ocurre nada<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>inciso a<\\/p>\"},{\"orden\":\"b\",\"texto\":\"<p>inciso b<\\/p>\"}]},{\"texto\":\"<p>ahora se me ocurre menos<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>otro inciso a<\\/p>\"},{\"orden\":\"b\",\"texto\":\"<p>otro inciso b<\\/p>\"}],\"numero\":2}]','2017-08-23 21:43:26','administrador','2017-08-23 22:54:10','administrador');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyectoRevision`
--

LOCK TABLES `proyectoRevision` WRITE;
/*!40000 ALTER TABLE `proyectoRevision` DISABLE KEYS */;
INSERT INTO `proyectoRevision` VALUES (1,8,NULL,1,'<p>agsajgsajgs</p><p>gkfkjfklj</p>','<div>sjagsjagsjasg</div><div><p></p></div>','[{\"texto\":\"<p>ajsaskaj<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>kakjslakjs<\\/p>\"}],\"numero\":1},{\"numero\":\"2\",\"texto\":\"<p>,asaskjahskjah<\\/p><p>saslk<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>sa<\\/p><p>blaclacla<\\/p>\"},{\"orden\":\"b\",\"texto\":\"<p>sas<\\/p>\"}]},{\"texto\":\"<p>agsajgsjhga<\\/p>\",\"incisos\":[],\"numero\":3},{\"texto\":\"<p>ajsakjhskajs<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>sasas<\\/p>\"}],\"numero\":4}]','2017-09-26 14:45:21','administrador',NULL,NULL),(2,8,NULL,1,'<p>agsajgsajgs</p><p>gkfkjfklj</p>','<div>sjagsjagsjasg</div><div><p></p></div>','[{\"texto\":\"<p>ajsaskaj<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>kakjslakjs<\\/p>\"}],\"numero\":1},{\"numero\":\"2\",\"texto\":\"<p>,asaskjahskjah<\\/p><p>saslk<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>sa<\\/p><p>blaclacla<\\/p>\"},{\"orden\":\"b\",\"texto\":\"<p>sas<\\/p>\"}]},{\"texto\":\"<p>agsajgsjhga<\\/p>\",\"incisos\":[],\"numero\":3},{\"texto\":\"<p>ajsakjhskajs<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>sasas<\\/p>\"}],\"numero\":4}]','2017-09-26 14:53:48','administrador',NULL,NULL),(3,8,NULL,1,'<p>agsajgsajgs</p><p>gkfkjfklj</p>','<div>sjagsjagsjasg</div><div><p></p></div>','[{\"texto\":\"<p>ajsaskaj<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>kakjslakjs<\\/p>\"}],\"numero\":1},{\"numero\":\"2\",\"texto\":\"<p>,asaskjahskjah<\\/p><p>saslk<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>sa<\\/p><p>blaclacla<\\/p>\"},{\"orden\":\"b\",\"texto\":\"<p>sas<\\/p>\"}]},{\"texto\":\"<p>agsajgsjhga<\\/p>\",\"incisos\":[],\"numero\":3},{\"texto\":\"<p>ajsakjhskajs<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>sasas<\\/p>\"}],\"numero\":4}]','2017-09-26 15:39:49','administrador',NULL,NULL),(4,8,NULL,1,'<p>agsajgsajgs</p><p>gkfkjfklj</p>','<div>sjagsjagsjasg</div><div><p></p></div>','[{\"texto\":\"<p>ajsaskaj<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>kakjslakjs<\\/p>\"}],\"numero\":1},{\"numero\":\"2\",\"texto\":\"<p>,asaskjahskjah<\\/p><p>saslk<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>sa<\\/p><p>blaclacla<\\/p>\"},{\"orden\":\"b\",\"texto\":\"<p>sas<\\/p>\"}]},{\"texto\":\"<p>agsajgsjhga<\\/p>\",\"incisos\":[],\"numero\":3},{\"texto\":\"<p>ajsakjhskajs<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>sasas<\\/p>\"}],\"numero\":4}]','2017-09-26 15:40:17','administrador',NULL,NULL),(5,8,NULL,1,'<p>agsajgsajgs</p><p>gkfkjfklj</p>','<div>sjagsjagsjasg</div><div><p></p></div>','[{\"texto\":\"<p>ajsaskaj<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>kakjslakjs<\\/p>\"}],\"numero\":1},{\"numero\":\"2\",\"texto\":\"<p>,asaskjahskjah<\\/p><p>saslk<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>sa<\\/p><p>blaclacla<\\/p>\"},{\"orden\":\"b\",\"texto\":\"<p>sas<\\/p>\"}]},{\"texto\":\"<p>agsajgsjhga<\\/p>\",\"incisos\":[],\"numero\":3},{\"texto\":\"<p>ajsakjhskajs<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>sasas<\\/p>\"}],\"numero\":4}]','2017-09-26 15:40:43','administrador',NULL,NULL),(6,8,NULL,1,'<p>agsajgsajgs</p><p>gkfkjfklj</p>','<div>sjagsjagsjasg</div><div><p></p></div>','[{\"texto\":\"<p>ajsaskaj<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>kakjslakjs<\\/p>\"}],\"numero\":1},{\"numero\":\"2\",\"texto\":\"<p>,asaskjahskjah<\\/p><p>saslk<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>sa<\\/p><p>blaclacla<\\/p>\"},{\"orden\":\"b\",\"texto\":\"<p>sas<\\/p>\"}]},{\"texto\":\"<p>agsajgsjhga<\\/p>\",\"incisos\":[],\"numero\":3},{\"texto\":\"<p>ajsakjhskajs<\\/p>\",\"incisos\":[{\"orden\":\"a\",\"texto\":\"<p>sasas<\\/p>\"}],\"numero\":4}]','2017-09-26 16:14:16','administrador',NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `remito`
--

LOCK TABLES `remito` WRITE;
/*!40000 ALTER TABLE `remito` DISABLE KEYS */;
INSERT INTO `remito` VALUES (1,3,9,0,'2017-08-20 12:35:42',0,NULL,'mesaHCD','2017-08-19 21:34:51','comisionesHCD','2017-08-20 12:35:42'),(2,3,9,0,'2017-09-09 21:23:49',0,NULL,'mesaHCD','2017-09-09 21:22:59','comisionesHCD','2017-09-09 21:23:49'),(3,9,3,0,'2017-09-09 21:37:48',0,NULL,'comisionesHCD','2017-09-09 21:35:54','mesaHCD','2017-09-09 21:37:48');
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
-- Table structure for table `resolucion`
--

DROP TABLE IF EXISTS `resolucion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resolucion` (
  `idResolucion` int(11) NOT NULL AUTO_INCREMENT,
  `idDictamen` int(11) DEFAULT NULL,
  `modificaDictamen` tinyint(1) NOT NULL,
  `discriminador` varchar(17) NOT NULL,
  `textoLibre` longtext,
  `textoArticulado` longtext,
  `idTipoResolucion` smallint(6) DEFAULT NULL,
  `idProyectoRevision` int(11) DEFAULT NULL,
  `idNotificacion` int(11) DEFAULT NULL,
  `numeroSancion` varchar(6) DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  PRIMARY KEY (`idResolucion`),
  KEY `resolucion_tipoResolucion_idx` (`idTipoResolucion`),
  KEY `resolucion_proyectoRevision_idx` (`idProyectoRevision`),
  KEY `resolucion_notificacion_idx` (`idNotificacion`),
  KEY `resolucion_dictamen_idx` (`idDictamen`),
  CONSTRAINT `fk_resolucion_dictamen` FOREIGN KEY (`idDictamen`) REFERENCES `dictamen` (`idDictamen`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_resolucion_notificacion` FOREIGN KEY (`idNotificacion`) REFERENCES `movimiento` (`idMovimiento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_resolucion_proyectoRevision` FOREIGN KEY (`idProyectoRevision`) REFERENCES `proyectoRevision` (`idProyectoRevision`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_resolucion_tipoResolucion` FOREIGN KEY (`idTipoResolucion`) REFERENCES `tipoProyecto` (`idTipoProyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resolucion`
--

LOCK TABLES `resolucion` WRITE;
/*!40000 ALTER TABLE `resolucion` DISABLE KEYS */;
/*!40000 ALTER TABLE `resolucion` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `rol_menu` VALUES (2,1),(4,1),(2,2),(4,2),(5,2),(6,2),(7,2),(2,4),(4,4),(2,5),(5,5),(6,5),(7,5),(2,6),(5,6),(6,6),(7,6),(2,7),(2,8);
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
  `idTipoSesion` smallint(6) DEFAULT NULL,
  `descripcion` varchar(50) NOT NULL,
  `fecha` datetime NOT NULL,
  `tieneOrdenDelDia` tinyint(1) NOT NULL,
  `presentes` smallint(6) DEFAULT NULL,
  `quorum` tinyint(1) DEFAULT NULL,
  `periodo` smallint(4) NOT NULL,
  `tieneEdicionBloqueada` tinyint(1) NOT NULL,
  `cantidadExpedientes` int(11) NOT NULL,
  PRIMARY KEY (`idSesion`),
  KEY `sesion_tipoSesion_idx` (`idTipoSesion`),
  CONSTRAINT `fk_sesion_tipoSesion` FOREIGN KEY (`idTipoSesion`) REFERENCES `tipoSesion` (`idTipoSesion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sesion`
--

LOCK TABLES `sesion` WRITE;
/*!40000 ALTER TABLE `sesion` DISABLE KEYS */;
INSERT INTO `sesion` VALUES (1,2,'ssagjsgajsgjags','2016-07-16 00:00:00',0,0,0,16,0,0),(2,1,'sagjagsjahgs','2017-08-16 00:00:00',1,0,0,17,0,0),(3,3,'gfsagfshagf','2017-10-15 00:00:00',0,0,0,17,0,0),(4,1,'shgasjasjgs','2017-10-15 00:00:00',0,0,0,17,0,0),(5,1,'sasassa','2017-10-08 00:00:00',1,0,0,17,1,5),(6,1,'asasas','2017-10-21 00:00:00',0,0,0,17,0,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoExpedienteSesion`
--

LOCK TABLES `tipoExpedienteSesion` WRITE;
/*!40000 ALTER TABLE `tipoExpedienteSesion` DISABLE KEYS */;
INSERT INTO `tipoExpedienteSesion` VALUES (22,'Mensajes del Departamento Ejecutivo','A'),(23,'Mensajes del Departamento Ejecutivo Girados a Comisiones','B'),(24,'Proyectos','C'),(25,'Expedientes con Respuesta del Departamento Ejecutivo','CH'),(26,'Proyectos Girados a Comisiones','D'),(27,'Peticiones Particulares','E'),(28,'Comisión de Presupesto y Hacienda','F'),(29,'Comisión de Obras Públicas y Urbanismo','G'),(30,'Comisión de Servicios Publicos','H'),(31,'Comisión de Derechos y Garantías','K'),(32,'Labor Legislativa','L'),(33,'Comisión de Industria y Comercio Interior y Exterior','M'),(34,'Comisión de Habitat, Tierrras y Viviendas','N'),(35,'Comisión de Medios de Comunicación Social','O'),(36,'Comisión de Seguridad y Justicia','P'),(37,'Comisión de Mujeres y Equidad de Genero','Q'),(38,'Comisión de Cultura y Educación ','R'),(39,'Comisión de Promoción de la Comunidad','S'),(40,'Comisión de Defensa del Usuario','T'),(41,'Comisión de Planeamiento','W'),(42,'Comisión de Interpretación y Reglamento','X'),(43,'Comisión de Ecología y Protección del Medio Ambiente','Y'),(44,'Dictamenes Conjuntos','Z');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'administrador','$2y$13$PV2vHlAy.LwjXtLetaUM3uJcDmduhPQ2Zpz2rj.Em1I/atyLxiiTW',1,2,'[\"EXP_NEW\",\"EXP_ADD\",\"EXP_EDIT\",\"EXP_DOWNLOAD\",\"EXP_MOVEMENT\",\"MOV_NEW\",\"REP_NEW\",\"PROJ_NEW\",\"PROJ_EDIT\",\"PROJ_DOWNLOAD\",\"COM_ADD\",\"COM_EDIT\",\"COM_DEL\",\"COM_DET\",\"CON_ADD\",\"CON_EDIT\",\"CON_DEL\",\"USR_ADD\",\"USR_EDIT\", \"USR_LOCK\", \"USR_UNLOK\"]',1,'2017-05-21 21:27:30','administrador',NULL,NULL),(2,'mesaHCD','$2y$13$Y5Gg/nStOtTu0QGernRlkOS66EtYAf/5Xoat8NIMETnC8e6JlZY/G',26,4,'[\"EXP_NEW\",\"EXP_ADD\",\"EXP_EDIT\",\"EXP_DOWNLOAD\",\"EXP_MOVEMENT\",\"EXP_RETURN\",\"EXP_REPORT_RETURN\",\"MOV_NEW\",\"MOV_ABORT\",\"MOV_RECEIVE\",\"MOV_DOWNLOAD\",\"PROJ_NEW\",\"PROJ_EDIT\",\"PROJ_DOWNLOAD\"]',1,'2017-07-28 17:39:45','administrador','2017-07-30 20:32:24','administrador'),(3,'comisionesHCD','$2y$13$5ErEhZZzRJozdaCm00G8NO/foaNWSEYkgbgB/s17aEH3Fe0PqME2O',27,5,'[\"MOV_NEW\",\"MOV_ABORT\",\"MOV_RECEIVE\",\"MOV_DOWNLOAD\",\"COM_ADD\",\"COM_EDIT\",\"COM_DEL\",\"COM_DET\",\"CON_ADD\",\"CON_EDIT\",\"CON_DEL\"]',1,'2017-07-28 17:51:54','administrador','2017-07-30 20:05:24','administrador'),(4,'baloiraE','$2y$13$CTxtKSJLsKP9DVA2pDja7.K0DVgJou4W1iIUbOKLFy6uacSLMBlYK',14,1,'[]',1,'2017-08-09 20:11:45','administrador',NULL,NULL);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

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
CREATE DEFINER=`root`@`localhost` FUNCTION `conformarDictamenArticulado`(texto text,articulos text,tipo varchar(45)) RETURNS text CHARSET utf8mb4
BEGIN
	
    declare html text default '';
	set html=concat(html,formatParrafo(texto));
    set html=concat(html,'<div style="text-align:center"><h3>',upper(tipo),'</h3></div>');
    set html=concat(html,formatArticulos(articulos));
    
	RETURN html;
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
CREATE DEFINER=`root`@`localhost` FUNCTION `conformarProyecto`(visto text,considerando text,articulos text,tipo varchar(45), incluyeVistosYConsiderandos tinyint(1), esDictamen tinyint(1)) RETURNS text CHARSET utf8mb4
BEGIN
    
    declare html text default '';
    
    SET lc_time_names = 'es_AR';
    
    set html=concat('<div style="text-align:right">Lomas de Zamora, ',
					replace(DATE_FORMAT(curdate(),  "%d %M %Y"),' ',' de '),'.-<\/div>');
    if (incluyeVistosYConsiderandos=1) then
		set html=concat(html,'<div style="text-align:center"><h3><u>PROYECTO DE ',
						upper(tipo),'<\/u></h3></div>');
		set html=concat(html,'<h4><u>Vistos<\/u></h4>');
		set html=concat(html,formatParrafo(visto));
		set html=concat(html,'<h4><u>Considerandos<\/u></h4>');
		set html=concat(html,formatParrafo(considerando));
	end if;
    if(esDictamen=0) then
		set html=concat(html,'<h4><u>Por todo ello:<\/u><\/h4>');
        set @parrafo=concat('<p>EL HONORABLE CONCEJO DELIBERANTE DE LOMAS DE ZAMORA EN EL USO DE LAS FACULTADES QUE LE SON PROPIAS SANCIONA ',
							if (tipo=4,'EL','LA'),' SIGUIENTE:<\/p>');
        set html=concat(html,'<strong>',formatParrafo(@parrafo),'<\/strong>');    
    end if;
    set html=concat(html,'<div style="text-align:center"><h3><u>',upper(tipo),'<\/u></h3></div>');
    set html=concat(html,formatArticulos(articulos));
    
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
CREATE DEFINER=`root`@`localhost` FUNCTION `formatArticulos`(arrayArticulosJSON text) RETURNS text CHARSET utf8mb4
BEGIN
	
    declare cantidadArticulos INT;
    declare cantidadIncisos int;
    declare articuloJSON text;
    declare articulo text;
    declare ordenArticulo varchar(2);
    declare incisoJSON text;
    declare arrayIncisosJSON text;
    declare ordenInciso varchar(2);
    declare inciso text;
    
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
		
        set @primerParrafo:=concat('<p><strong><u>Artículo ',ordenArticulo,'<\/u>°.-<\/strong> ',substr(articulo,4,position('<\/p>'in articulo)));
        set @demasParrafos:=replace(
									  substr(articulo,
											 position('<\/p>'in articulo)+4,
                                             length(articulo)
                                             ),
										'<p>',
                                        pgph_style_articulo
                                        );
        
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
				
				set @primerParrafo:=concat(pgph_style_inciso,'<strong>',ordenInciso,')<\/strong> ',substr(inciso,4,position('<\/p>'in inciso)));
				
                set @demasParrafos:=replace(
									  substr(inciso,
											 position('<\/p>' in inciso)+4,
                                             length(inciso)
                                             ),
										'<p>',
                                        pgph_style_inciso
                                        );
        
				set representacionIncisosHTML=concat(representacionIncisosHTML,@primerParrafo,@demasParrafos);
                
                set @numeroInciso:=@numeroInciso+1;
                
			until @numeroInciso=cantidadIncisos end repeat;
			
            set representacionHTML=concat(representacionHTML,list_style,representacionIncisosHTML,'<\/ul>');
            
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
CREATE DEFINER=`root`@`localhost` FUNCTION `formatParrafo`(parrafo text) RETURNS text CHARSET utf8mb4
BEGIN
	declare pgph_style varchar(111) default '<p style="text-align: justify;margin-top: 0">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	RETURN replace(parrafo,'<p>',pgph_style);
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
CREATE DEFINER=`root`@`localhost` FUNCTION `traerComisionesDictamen`(_idDictamen int) RETURNS text CHARSET utf8mb4
BEGIN

	declare comisiones text default '';
    
    SELECT 	concat('<p>Comisiones:</p><ul><li>',group_concat(c.comision separator '</li><li>'),'</li></ul>')
    INTO	comisiones
    FROM 	dictamen as d
    LEFT
    JOIN	expedienteComision_dictamenesMayoria dm
    ON		d.idDictamen=dm.idDictamen
    INNER
    JOIN	expedienteComision as ec
    ON		dm.idExpedienteComision=ec.idExpedienteComision
    INNER
    JOIN	comision as c
    ON		c.idComision=ec.idComision
    WHERE	d.idDictamen=_idDictamen
	GROUP
    BY		d.idDictamen;
    
    if (comisiones='') then

		SELECT 	concat('<p>Comisiones:</p><ul><li>',group_concat(c.comision separator '</li><li>'),'</li></ul>')
		INTO	comisiones
		FROM 	dictamen as d
		LEFT
		JOIN	expedienteComision_dictamenesPrimeraMinoria dpm
		ON		d.idDictamen=dpm.idDictamen
		INNER
		JOIN	expedienteComision as ec
		ON		dpm.idExpedienteComision=ec.idExpedienteComision
		INNER
		JOIN	comision as c
		ON		c.idComision=ec.idComision
		GROUP
		BY		d.idDictamen;
	end if;
    
    if (comisiones='') then

		SELECT 	concat('<p>Comisiones:</p><ul><li>',group_concat(c.comision separator '</li><li>'),'</li></ul>')
		INTO	comisiones
		FROM 	dictamen as d
		LEFT
		JOIN	expedienteComision_dictamenesSegundaMinoria dsm
		ON		d.idDictamen=dsm.idDictamen
		INNER
		JOIN	expedienteComision as ec
		ON		dsm.idExpedienteComision=ec.idExpedienteComision
		INNER
		JOIN	comision as c
		ON		c.idComision=ec.idComision
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
CREATE DEFINER=`root`@`localhost` FUNCTION `traerComisionesExpediente`(_idExpediente int) RETURNS text CHARSET utf8mb4
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
    WHERE	e.idExpediente=_idExpediente and
			ee.idEstadoExpediente in (2,3)
	GROUP
    BY		e.idExpediente;
			
RETURN comisiones;
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
CREATE DEFINER=`root`@`localhost` FUNCTION `traerLetrasExpedienteSesion`(_idExpediente int, _idSesion int) RETURNS varchar(255) CHARSET utf8mb4
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `borrarOrdenDelDia`(_idSesion int)
BEGIN
	
    delete from expedienteSesion where idSesion=_idSesion;
    
	update 	sesion
    set		tieneOrdenDelDia=0,
			cantidadExpedientes=0
	where 	idSesion=_idSesion;
    
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `crearOrdenDelDia`(IN _idSesion int)
BEGIN

	declare _cantidadExpedientes int default 0;
	declare _idEstado int default 6;
    set @idTipo:=0;
    
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
       
    #Mensajes del ejecutivo sin giro a comisiones
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='A';
    
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
	select 
			@idTipo,e.idExpediente,
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
                   ')</strong></p>',e.caratula,
                   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				  ),
			'A',(e.periodo-2000), e.numeroExpediente
	from  	expediente e
	inner
    join 	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    where	e.idTipoExpediente=4 and e.idSesion=_idSesion;
    
    #Mensajes del ejecutivo con giro a comisiones (Ordenanzas)
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='B';
  
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
	select 
			@idTipo,e.idExpediente,
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
                   ')</strong></p>',e.caratula,
                   traerComisionesExpediente(e.idExpediente),
				   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				 ),
            'B',(e.periodo-2000), e.numeroExpediente
	from  	expediente e
	inner
    join 	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    where	e.idTipoExpediente=9 and e.idSesion=_idSesion;
    
    #proyectos de los concejales (comunicaciones y resoluciones)
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='C';
    
     INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			@idTipo,e.idExpediente,
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
                   ' / ',b.bloque ,')</strong></p>',
                   conformarProyecto(p.visto,p.considerandos,p.articulos,te.tipoExpediente,1,0),
				   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				 ),
			'C',(e.periodo-2000), e.numeroExpediente
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
    where	e.idTipoExpediente in (1,6) and e.idSesion=_idSesion;	
    
    #proyectos de los concejales (ordenanzas)
 
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='D';
  
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			@idTipo,e.idExpediente,
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
                   ' / ',b.bloque ,')</strong></p>',
                   traerComisionesExpediente(e.idExpediente),
                   conformarProyecto(p.visto,p.considerandos,p.articulos,te.tipoExpediente,1,0),
				   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				  ),
			'D',(e.periodo-2000), e.numeroExpediente
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
    where	e.idTipoExpediente=2 and e.idSesion=_idSesion;

	#pedidos de informes (ordenanzas)
    /*
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='CH';
    
    set @acumulador_orden:=0;
    
    select 
			@idTipo,@acumulador_orden:=1+
			(select count(ordenSesion) from expedienteSesion 
			 where idTipoExpedienteSesion=t.idTipoExpedienteSesion and idSesion=_idSesion),
            e.idExpediente,_idSesion,_idEstado,
            concat('<strong>',upper(replace(e.caratula,'<p>','<p style="text-align: justify;margin-top: 0;text-indent: 1.5em">')),
				   '<p>CH</p><p>',@acumulador_orden,'<\/p>',
				   '<p>(Expediente N ',e.numeroExpediente,'<span style="padding-left:50px;"></span>',
                   te.letra,' ??/??/??? <\/p><p>',te.tipoExpediente,'[¿sancion?][¿comision?]<\/p>'),
			0,0,0
	from  	expediente e
	inner
    join 	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	movimiento m
    on		m.idExpediente=e.idExpediente
    where	m.idSesion=_idSesion
    order 	
	by		e.año, e.numeroExpediente;
    */
    
    #Exedientes Particulares
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='E';
  
	INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
	select 
			@idTipo, e.idExpediente,
            concat('<p><strong>E ',@acumulador_orden,'.- ',
				   upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
                   ')</strong></p>',e.caratula,
				   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				  ),
			'E',(e.periodo-2000), e.numeroExpediente
	from  	expediente e
	inner
    join 	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    where	e.idTipoExpediente=3 and e.idSesion=_idSesion;
    
    #id's de dictamenes conjuntos
    
    create temporary table dictamenesConjuntos(idDictamen int);
    
    insert 	into dictamenesConjuntos(idDictamen)
    select 	d.idDictamen
    from	dictamen d
    inner
    join	expedienteComision_dictamenesMayoria dm
    on		d.idDictamen=dm.idDictamen
    where	d.idSesion=_idSesion
    group
    by		d.idDictamen
    having	count(dm.idExpedienteComision)>1;
    
    insert 	into dictamenesConjuntos(idDictamen)
    select 	d.idDictamen
    from	dictamen d
    inner
    join	expedienteComision_dictamenesPrimeraMinoria dpm
    on		d.idDictamen=dpm.idDictamen
    where	d.idSesion=_idSesion
    group
    by		d.idDictamen
    having	count(dpm.idExpedienteComision)>1;
    
    insert 	into dictamenesConjuntos(idDictamen)
    select 	d.idDictamen
    from	dictamen d
    inner
    join	expedienteComision_dictamenesPrimeraMinoria dsm
    on		d.idDictamen=dsm.idDictamen
    where	d.idSesion=_idSesion
    group
    by		d.idDictamen
    having	count(dsm.idExpedienteComision)>1;
    
    #dictamenes de comisiones
    	
    #dictamenes por mayoria
    
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			tes.idTipoExpedienteSesion, e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')</strong></p>',
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1)
				   end,
                   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				 ),
			c.letraOrdenDelDia, (e.periodo-2000), e.numeroExpediente
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
    join	expedienteComision_dictamenesMayoria dm
    on		ec.idExpedienteComision=dm.idExpedienteComision
    inner
    join	dictamen d
    on		dm.idDictamen=d.idDictamen
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
    where	d.idDictamen not in (select idDictamen from dictamenesConjuntos) and 
			d.idSesion=_idSesion;
    
    #dictamenes por primera minoria
    
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			tes.idTipoExpedienteSesion, e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')</strong></p>',
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1)
				   end,
				   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				 ),
			c.letraOrdenDelDia, (e.periodo-2000), e.numeroExpediente
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
    join	expedienteComision_dictamenesPrimeraMinoria dpm
    on		ec.idExpedienteComision=dpm.idExpedienteComision
    inner
    join	dictamen d
    on		dpm.idDictamen=d.idDictamen
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
    where	d.idDictamen not in (select idDictamen from dictamenesConjuntos) and 
			d.idSesion=_idSesion;
    
     #dictamenes por segunda minoria
    
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			tes.idTipoExpedienteSesion, e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')</strong></p>',
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1)
				   end,
                   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				 ),
			c.letraOrdenDelDia, (e.periodo-2000), e.numeroExpediente
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
    join	expedienteComision_dictamenesSegundaMinoria dsm
    on		ec.idExpedienteComision=dsm.idExpedienteComision
    inner
    join	dictamen d
    on		dsm.idDictamen=d.idDictamen
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
    where	d.idDictamen not in (select idDictamen from dictamenesConjuntos) and 
			d.idSesion=_idSesion;
    
	#dictamenes conjuntos
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='Z';
    
    #dictamenes por mayoria
	
	INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			@idTipo, e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')</strong></p>',
                   traerComisionesDictamen(d.idDictamen),
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1)
				   end,
                   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				 ),'Z', (e.periodo-2000), e.numeroExpediente
	from  	expediente e
    inner
    join	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	expedienteComision ec
    on		e.idExpediente=ec.idExpediente
    inner	 
    join	expedienteComision_dictamenesMayoria dm
    on		ec.idExpedienteComision=dm.idExpedienteComision
    inner
    join	dictamen d
    on		dm.idDictamen=d.idDictamen
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
    where	d.idDictamen in (select idDictamen from dictamenesConjuntos) and 
			d.idSesion=_idSesion
    order   
    by		e.periodo, e.numeroExpediente;
    
    #dictamenes por primera minoria
	
	INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			@idTipo, e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')</strong></p>',
                   traerComisionesDictamen(d.idDictamen),
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1)
				   end,
				   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				 ),'Z', (e.periodo-2000), e.numeroExpediente
	from  	expediente e
    inner
    join	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	expedienteComision ec
    on		e.idExpediente=ec.idExpediente
    inner	 
    join	expedienteComision_dictamenesPrimeraMinoria dpm
    on		ec.idExpedienteComision=dpm.idExpedienteComision
    inner
    join	dictamen d
    on		dpm.idDictamen=d.idDictamen
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
    where	d.idDictamen in (select idDictamen from dictamenesConjuntos) and 
			d.idSesion=_idSesion
    order   
    by		e.periodo, e.numeroExpediente;
    
	#dictamenes por segunda minoria
	
	INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			@idTipo, e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')</strong></p>',
                   traerComisionesDictamen(d.idDictamen),
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1)
				   end,
                   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				 ),'Z', (e.periodo-2000), e.numeroExpediente
	from  	expediente e
    inner
    join	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	expedienteComision ec
    on		e.idExpediente=ec.idExpediente
    inner	 
    join	expedienteComision_dictamenesSegundaMinoria dsm
    on		ec.idExpedienteComision=dsm.idExpedienteComision
    inner
    join	dictamen d
    on		dsm.idDictamen=d.idDictamen
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
    where	d.idDictamen in (select idDictamen from dictamenesConjuntos) and 
			d.idSesion=_idSesion
    order   
    by		e.periodo, e.numeroExpediente;

	#insercion en la tabla de la bd
    
    INSERT INTO `expedienteSesion`
		(`idTipoExpedienteSesion`, `ordenSesion`,`idExpediente`,`idSesion`,
         `idEstadoExpedienteSesion`,`texto`,`aFavor`, `enContra`, `abstenciones`)
	select  
			t.idTipoExpedienteSesion, 0,
            t.idExpediente, _idSesion, _idEstado,
            concat('<p><strong>',t.letra,') Δ.- ',
				   t.texto
				 ),0,0,0
	from	(select distinct idTipoExpedienteSesion,idExpediente,
							 letra,texto,añoExpediente,numeroExpediente
			 from expedienteSesionTemporal
             ) t
    order 
    by		t.letra ASC,t.añoExpediente ASC,t.numeroExpediente ASC;
    
    select count(distinct idExpediente) into _cantidadExpedientes
    from `expedienteSesion` where idSesion=_idSesion;
    
    update 	sesion
    set		tieneOrdenDelDia=1,
			cantidadExpedientes=_cantidadExpedientes
	where 	idSesion=_idSesion;
    
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `listadoDictamenesExpedienteSesion`(in _idExpediente int, in _idSesion int)
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
		join	expedienteComision_dictamenesMayoria dm
		on		ec.idExpedienteComision=dm.idExpedienteComision
		inner
		join	dictamen dmd
		on		dm.idDictamen=dmd.idDictamen and dmd.idSesion=_idSesion
		inner
		join	comision c
		on		ec.idComision=c.idComision
		where 	ec.idExpediente=_idExpediente	
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
		join	expedienteComision_dictamenesPrimeraMinoria dpm
		on		ec.idExpedienteComision=dpm.idExpedienteComision
		inner
		join	dictamen dpmd
		on		dpm.idDictamen=dpmd.idDictamen and dpmd.idSesion=_idSesion
		inner
		join	comision c
		on		ec.idComision=c.idComision
		where 	ec.idExpediente=_idExpediente	
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
		join	expedienteComision_dictamenesSegundaMinoria dsm
		on 		ec.idExpedienteComision=dsm.idExpedienteComision
		inner
		join	dictamen dsmd
		on		dsm.idDictamen=dsmd.idDictamen and dsmd.idSesion=_idSesion
		inner
		join	comision c
		on		ec.idComision=c.idComision
		where 	ec.idExpediente=_idExpediente	
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `listadoExpedientesPorSesion`(in _idSesion int, in _numeroExpediente int,in _tipoExpediente int, in _letraOD char(1))
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
    join	expedienteComision_dictamenesMayoria dm
    on		ec.idExpedienteComision=dm.idExpedienteComision
    left
    join	dictamen dmd
    on		dm.idDictamen=dmd.idDictamen and dmd.idSesion=_idSesion
    left
    join	expedienteComision_dictamenesPrimeraMinoria dpm
    on		ec.idExpedienteComision=dpm.idExpedienteComision
	left
    join	dictamen dpmd
    on		dpm.idDictamen=dpmd.idDictamen and dpmd.idSesion=_idSesion
    left
    join	expedienteComision_dictamenesSegundaMinoria dsm
    on 		ec.idExpedienteComision=dsm.idExpedienteComision
	left
    join	dictamen dsmd
    on		dsm.idDictamen=dsmd.idDictamen and dsmd.idSesion=_idSesion
    group
    by		ec.idExpediente;
    
    
	select 	distinct e.idExpediente , case when p.idProyecto is null then 0 else p.idProyecto end as idProyecto,
			concat(e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000)) as numero_expediente, te.tipoExpediente, 
			traerLetrasExpedienteSesion(e.idExpediente,s.idSesion) as letrasOD, 
			case when esr.idResolucion is not null then 'Si' else 'No' end as tiene_resolucion,
            case when esr.idResolucion is not null then esr.idResolucion else 0 end as IdResolucion,
			case when esr.idResolucion is not null then esr.numeroSancion
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
	join	resolucion esr
	on		es.idResolucion=esr.idResolucion
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `traerApartadoOrdenDelDia`(_idSesion int, _idTipoExpedienteSesion int)
BEGIN

	SET group_concat_max_len = 1024*1024;

	select 	group_concat(texto separator '<br>') as apartado
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
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_sesiones_habiles` AS select `s`.`idSesion` AS `idSesion`,concat(convert(cast(date_format(`s`.`fecha`,'%d/%m/%Y') as char(10) charset utf8) using utf8mb4),' (',`ts`.`abreviacion`,')') AS `descripcion` from ((`sistema_legislativo`.`sesion` `s` join (select `sistema_legislativo`.`sesion`.`idTipoSesion` AS `idTipoSesion`,min(`sistema_legislativo`.`sesion`.`fecha`) AS `fechaProxima` from `sistema_legislativo`.`sesion` where (`sistema_legislativo`.`sesion`.`fecha` >= curdate()) group by `sistema_legislativo`.`sesion`.`idTipoSesion`) `ss` on(((`s`.`idTipoSesion` = `ss`.`idTipoSesion`) and (`s`.`fecha` = `ss`.`fechaProxima`)))) join `sistema_legislativo`.`tipoSesion` `ts` on((`s`.`idTipoSesion` = `ts`.`idTipoSesion`))) */;
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

-- Dump completed on 2017-09-27  2:16:09
