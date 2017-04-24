-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: localhost    Database: sistema_legislativo
-- ------------------------------------------------------
-- Server version	5.7.17-0ubuntu0.16.04.1

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
  KEY `expediente_idx` (`idExpediente`),
  KEY `sesion_idx` (`idSesion`),
  KEY `estadoAgendaSesion_idx` (`idEstadoAgendaSesion`),
  CONSTRAINT `fk_ordenDia_estadoAgendaSesion` FOREIGN KEY (`idEstadoAgendaSesion`) REFERENCES `estadoAgendaSesion` (`idEstadoAgendaSesion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ordenDia_expediente` FOREIGN KEY (`idExpediente`) REFERENCES `expediente` (`idExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ordenDia_sesion` FOREIGN KEY (`idSesion`) REFERENCES `sesion` (`idSesion`) ON DELETE NO ACTION ON UPDATE NO ACTION
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
-- Table structure for table `autores_expedientes`
--

DROP TABLE IF EXISTS `autores_expedientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autores_expedientes` (
  `idExpediente` int(11) NOT NULL,
  `idPerfil` int(11) NOT NULL,
  PRIMARY KEY (`idExpediente`,`idPerfil`),
  KEY `IDX_F074D976F574DEDD` (`idPerfil`),
  KEY `IDX_F074D9765768BAF9` (`idExpediente`),
  CONSTRAINT `fk_autores_expedientes_expediente` FOREIGN KEY (`idExpediente`) REFERENCES `expediente` (`idExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_autores_expedientes_perfil` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autores_expedientes`
--

LOCK TABLES `autores_expedientes` WRITE;
/*!40000 ALTER TABLE `autores_expedientes` DISABLE KEYS */;
INSERT INTO `autores_expedientes` VALUES (31,3),(32,3),(33,3),(34,3),(31,4),(35,4),(33,10);
/*!40000 ALTER TABLE `autores_expedientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autores_expedientesBorrador`
--

DROP TABLE IF EXISTS `autores_expedientesBorrador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autores_expedientesBorrador` (
  `idExpedienteBorrador` int(11) NOT NULL,
  `idPerfil` int(11) NOT NULL,
  PRIMARY KEY (`idExpedienteBorrador`,`idPerfil`),
  KEY `perfil_idx` (`idPerfil`),
  KEY `expedienteBorrador_ix` (`idExpedienteBorrador`),
  CONSTRAINT `fk_autores_expedienteBorrador_expedienteBorrador` FOREIGN KEY (`idExpedienteBorrador`) REFERENCES `expedienteBorrador` (`idExpedienteBorrador`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_autores_expedienteBorrador_perfil` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autores_expedientesBorrador`
--

LOCK TABLES `autores_expedientesBorrador` WRITE;
/*!40000 ALTER TABLE `autores_expedientesBorrador` DISABLE KEYS */;
/*!40000 ALTER TABLE `autores_expedientesBorrador` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bloque`
--

LOCK TABLES `bloque` WRITE;
/*!40000 ALTER TABLE `bloque` DISABLE KEYS */;
INSERT INTO `bloque` VALUES (1,'bloque1'),(2,'bloque2');
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
  `comision` varchar(100) NOT NULL,
  PRIMARY KEY (`idComision`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comision`
--

LOCK TABLES `comision` WRITE;
/*!40000 ALTER TABLE `comision` DISABLE KEYS */;
INSERT INTO `comision` VALUES (1,'Espacios publicos');
/*!40000 ALTER TABLE `comision` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comisiones_legisladores`
--

DROP TABLE IF EXISTS `comisiones_legisladores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comisiones_legisladores` (
  `idComision` int(11) NOT NULL,
  `idPerfil` int(11) NOT NULL,
  PRIMARY KEY (`idComision`,`idPerfil`),
  KEY `IDX_CB9D57FBF574DEDD` (`idPerfil`),
  KEY `IDX_CB9D57FB43B0A334` (`idComision`),
  CONSTRAINT `fk_comisiones_legisladores_comision` FOREIGN KEY (`idComision`) REFERENCES `comision` (`idComision`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_comisiones_legisladores_perfil` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comisiones_legisladores`
--

LOCK TABLES `comisiones_legisladores` WRITE;
/*!40000 ALTER TABLE `comisiones_legisladores` DISABLE KEYS */;
INSERT INTO `comisiones_legisladores` VALUES (1,3);
/*!40000 ALTER TABLE `comisiones_legisladores` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estadoExpediente`
--

LOCK TABLES `estadoExpediente` WRITE;
/*!40000 ALTER TABLE `estadoExpediente` DISABLE KEYS */;
INSERT INTO `estadoExpediente` VALUES (1,'Aprobado'),(2,'Asignado Comision'),(3,'Dictamen Comisión'),(4,'Asignado Sessión');
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
  `idEstadoExpediente` smallint(6) DEFAULT NULL,
  `numeroExpediente` varchar(50) NOT NULL,
  `idTipoExpediente` smallint(6) DEFAULT NULL,
  `asunto` varchar(200) NOT NULL,
  `extracto` varchar(500) NOT NULL,
  `listaImagenes` longtext COMMENT '(DC2Type:object)',
  `fechaCreacion` datetime NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `fechaAprobacion` datetime DEFAULT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  `usuarioAprobacion` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`idExpediente`),
  UNIQUE KEY `numeroExpediente_idx` (`numeroExpediente`),
  KEY `estadoExpediente_idx` (`idEstadoExpediente`),
  KEY `tipoExpediente_idx` (`idTipoExpediente`),
  CONSTRAINT `fk_expediente_estadoExpediente` FOREIGN KEY (`idEstadoExpediente`) REFERENCES `estadoExpediente` (`idEstadoExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expediente_tipoExpediente` FOREIGN KEY (`idTipoExpediente`) REFERENCES `tipoExpediente` (`idTipoExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expediente`
--

LOCK TABLES `expediente` WRITE;
/*!40000 ALTER TABLE `expediente` DISABLE KEYS */;
INSERT INTO `expediente` VALUES (31,1,'123456',1,'<h1>dasdasdadsada</h1>','<p><ul><li>ddsadasdas<br></li><li>dadsdad</li></ul></p>','a:1:{i:0;O:20:\"AppBundle\\Popo\\Image\":2:{s:30:\"\0AppBundle\\Popo\\Image\0fileName\";s:36:\"aa99128c996410c88d6b112698204ed8.pdf\";s:33:\"\0AppBundle\\Popo\\Image\0imageConfig\";O:26:\"AppBundle\\Popo\\ImageConfig\":5:{s:35:\"\0AppBundle\\Popo\\ImageConfig\0caption\";s:16:\"z2c3veww.ap4.pdf\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0size\";i:93760;s:33:\"\0AppBundle\\Popo\\ImageConfig\0width\";s:5:\"120px\";s:31:\"\0AppBundle\\Popo\\ImageConfig\0key\";s:69:\"e10adc3949ba59abbe56e057f20f883e/aa99128c996410c88d6b112698204ed8.pdf\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0type\";s:3:\"pdf\";}}}','2017-04-06 01:03:53',NULL,NULL,'primero',NULL,NULL),(32,1,'dsddssdsds',4,'<h2>dsdsdsdsd</h2><p><br></p><p><br></p><p><br></p><p><br></p><p><br></p><p>ddfdfdfdf</p><p><br></p><p><br></p><h3>ddddd</h3><p><br></p>','<p>dsdsdsds</p>','a:1:{i:0;O:20:\"AppBundle\\Popo\\Image\":2:{s:30:\"\0AppBundle\\Popo\\Image\0fileName\";s:37:\"25f43cdf47f4171a3b08bcdd388f9085.jpeg\";s:33:\"\0AppBundle\\Popo\\Image\0imageConfig\";O:26:\"AppBundle\\Popo\\ImageConfig\":5:{s:35:\"\0AppBundle\\Popo\\ImageConfig\0caption\";s:23:\"IMG-20161108-WA0000.jpg\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0size\";i:211411;s:33:\"\0AppBundle\\Popo\\ImageConfig\0width\";s:5:\"120px\";s:31:\"\0AppBundle\\Popo\\ImageConfig\0key\";s:70:\"c527e602a172ffc8723e3263bd81106a/25f43cdf47f4171a3b08bcdd388f9085.jpeg\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0type\";s:5:\"image\";}}}','2017-04-06 03:01:52','2017-04-06 17:57:34',NULL,'primero','primero',NULL),(33,1,'sd454545454',2,'<p>dsdsdsdsddsññññ</p>','<p>sdsaasdasdasd</p>','a:3:{i:0;O:20:\"AppBundle\\Popo\\Image\":2:{s:30:\"\0AppBundle\\Popo\\Image\0fileName\";s:36:\"71485823ac66d445ee9fa4d227ead507.png\";s:33:\"\0AppBundle\\Popo\\Image\0imageConfig\";O:26:\"AppBundle\\Popo\\ImageConfig\":5:{s:35:\"\0AppBundle\\Popo\\ImageConfig\0caption\";s:46:\"Captura de pantalla de 2016-08-19 22-37-11.png\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0size\";i:101593;s:33:\"\0AppBundle\\Popo\\ImageConfig\0width\";s:5:\"120px\";s:31:\"\0AppBundle\\Popo\\ImageConfig\0key\";s:69:\"a8541c31821d9fc0b027bd3a123ec738/71485823ac66d445ee9fa4d227ead507.png\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0type\";s:5:\"image\";}}i:1;O:20:\"AppBundle\\Popo\\Image\":2:{s:30:\"\0AppBundle\\Popo\\Image\0fileName\";s:36:\"9410972e515d4afe3fd87b3217d922bc.png\";s:33:\"\0AppBundle\\Popo\\Image\0imageConfig\";O:26:\"AppBundle\\Popo\\ImageConfig\":5:{s:35:\"\0AppBundle\\Popo\\ImageConfig\0caption\";s:46:\"Captura de pantalla de 2016-12-05 23-12-00.png\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0size\";i:190264;s:33:\"\0AppBundle\\Popo\\ImageConfig\0width\";s:5:\"120px\";s:31:\"\0AppBundle\\Popo\\ImageConfig\0key\";s:69:\"a8541c31821d9fc0b027bd3a123ec738/9410972e515d4afe3fd87b3217d922bc.png\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0type\";s:5:\"image\";}}i:2;O:20:\"AppBundle\\Popo\\Image\":2:{s:30:\"\0AppBundle\\Popo\\Image\0fileName\";s:36:\"3a9c7b1f6187b533e9d0c8e417e5efae.png\";s:33:\"\0AppBundle\\Popo\\Image\0imageConfig\";O:26:\"AppBundle\\Popo\\ImageConfig\":5:{s:35:\"\0AppBundle\\Popo\\ImageConfig\0caption\";s:46:\"Captura de pantalla de 2016-12-05 23-19-30.png\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0size\";i:198223;s:33:\"\0AppBundle\\Popo\\ImageConfig\0width\";s:5:\"120px\";s:31:\"\0AppBundle\\Popo\\ImageConfig\0key\";s:69:\"a8541c31821d9fc0b027bd3a123ec738/3a9c7b1f6187b533e9d0c8e417e5efae.png\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0type\";s:5:\"image\";}}}','2017-04-06 18:23:34',NULL,NULL,'primero',NULL,NULL),(34,1,'iiu',5,'<p>llkk5555</p>','<p>66556565</p>','a:0:{}','2017-04-06 18:56:52','2017-04-06 19:02:42',NULL,'primero','primero',NULL),(35,1,'457898',2,'<h1>un comentario</h1>','<p><blockquote>se prescribe ...</blockquote><blockquote><ul><li>lkllkklk</li><li>hghghg</li></ul></blockquote></p>','a:2:{i:0;O:20:\"AppBundle\\Popo\\Image\":2:{s:30:\"\0AppBundle\\Popo\\Image\0fileName\";s:36:\"71485823ac66d445ee9fa4d227ead507.png\";s:33:\"\0AppBundle\\Popo\\Image\0imageConfig\";O:26:\"AppBundle\\Popo\\ImageConfig\":5:{s:35:\"\0AppBundle\\Popo\\ImageConfig\0caption\";s:46:\"Captura de pantalla de 2016-08-19 22-37-11.png\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0size\";i:101593;s:33:\"\0AppBundle\\Popo\\ImageConfig\0width\";s:5:\"120px\";s:31:\"\0AppBundle\\Popo\\ImageConfig\0key\";s:69:\"8fbe2b75d9055de39c73eed52c91f3cc/71485823ac66d445ee9fa4d227ead507.png\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0type\";s:5:\"image\";}}i:1;O:20:\"AppBundle\\Popo\\Image\":2:{s:30:\"\0AppBundle\\Popo\\Image\0fileName\";s:36:\"9410972e515d4afe3fd87b3217d922bc.png\";s:33:\"\0AppBundle\\Popo\\Image\0imageConfig\";O:26:\"AppBundle\\Popo\\ImageConfig\":5:{s:35:\"\0AppBundle\\Popo\\ImageConfig\0caption\";s:46:\"Captura de pantalla de 2016-12-05 23-12-00.png\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0size\";i:190264;s:33:\"\0AppBundle\\Popo\\ImageConfig\0width\";s:5:\"120px\";s:31:\"\0AppBundle\\Popo\\ImageConfig\0key\";s:69:\"8fbe2b75d9055de39c73eed52c91f3cc/9410972e515d4afe3fd87b3217d922bc.png\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0type\";s:5:\"image\";}}}','2017-04-11 19:39:55',NULL,NULL,'primero',NULL,NULL);
/*!40000 ALTER TABLE `expediente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expedienteBorrador`
--

DROP TABLE IF EXISTS `expedienteBorrador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expedienteBorrador` (
  `idExpedienteBorrador` int(11) NOT NULL AUTO_INCREMENT,
  `idExpediente` int(11) DEFAULT NULL,
  `idTipoExpediente` smallint(6) NOT NULL,
  `asunto` varchar(200) NOT NULL,
  `extracto` varchar(500) NOT NULL,
  `fechaCreacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuarioCreacion` varchar(70) NOT NULL,
  PRIMARY KEY (`idExpedienteBorrador`),
  KEY `expediente_idx` (`idExpediente`),
  KEY `tipoExpediente_idx` (`idTipoExpediente`),
  CONSTRAINT `fk_expedienteBorrador_expediente` FOREIGN KEY (`idExpediente`) REFERENCES `expediente` (`idExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedienteBorrador_tipoExpediente` FOREIGN KEY (`idTipoExpediente`) REFERENCES `tipoExpediente` (`idTipoExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expedienteBorrador`
--

LOCK TABLES `expedienteBorrador` WRITE;
/*!40000 ALTER TABLE `expedienteBorrador` DISABLE KEYS */;
/*!40000 ALTER TABLE `expedienteBorrador` ENABLE KEYS */;
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
  `aprobado` tinyint(1) DEFAULT '0',
  `fechaAsignacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechaAprobacion` datetime DEFAULT NULL,
  PRIMARY KEY (`idExpedienteComision`),
  KEY `comision_idx` (`idComision`),
  KEY `expediente_idx` (`idExpediente`),
  CONSTRAINT `fk_expedienteComision_comision` FOREIGN KEY (`idComision`) REFERENCES `comision` (`idComision`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expedienteComision_expediente` FOREIGN KEY (`idExpediente`) REFERENCES `expediente` (`idExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expedienteComision`
--

LOCK TABLES `expedienteComision` WRITE;
/*!40000 ALTER TABLE `expedienteComision` DISABLE KEYS */;
/*!40000 ALTER TABLE `expedienteComision` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expedienteComisionDictamen`
--

DROP TABLE IF EXISTS `expedienteComisionDictamen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expedienteComisionDictamen` (
  `idExpedienteComisionDictamen` int(11) NOT NULL AUTO_INCREMENT,
  `idExpedienteComision` int(11) DEFAULT NULL,
  `dictamen` varchar(500) NOT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `fechaCreacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idExpedienteComisionDictamen`),
  KEY `expedienteComision_idx` (`idExpedienteComision`),
  CONSTRAINT `fk_expedienteComisionDictamen_expedienteComision` FOREIGN KEY (`idExpedienteComision`) REFERENCES `expedienteComision` (`idExpedienteComision`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expedienteComisionDictamen`
--

LOCK TABLES `expedienteComisionDictamen` WRITE;
/*!40000 ALTER TABLE `expedienteComisionDictamen` DISABLE KEYS */;
/*!40000 ALTER TABLE `expedienteComisionDictamen` ENABLE KEYS */;
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
  `numeroDocumento` int(11) DEFAULT NULL,
  `domicilio` varchar(100) DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`idPerfil`),
  KEY `IDX_9665764792CBC072` (`idBloque`),
  CONSTRAINT `fk_perfil_bloque` FOREIGN KEY (`idBloque`) REFERENCES `bloque` (`idBloque`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil`
--

LOCK TABLES `perfil` WRITE;
/*!40000 ALTER TABLE `perfil` DISABLE KEYS */;
INSERT INTO `perfil` VALUES (3,'legislador',NULL,'primer','legislador','','',2,NULL,NULL,NULL,'2017-04-11 01:42:06','administrador','2017-04-11 19:45:35','primero'),(4,'legislador',NULL,'segundo','legislador',NULL,NULL,2,NULL,NULL,NULL,'2017-04-11 01:42:06','administrador',NULL,NULL),(10,'legislador',NULL,'tercer','lgislador',NULL,NULL,1,NULL,NULL,NULL,'2017-04-11 01:42:06','administrador',NULL,NULL),(47,'basico',NULL,'tercer ','legislador',NULL,NULL,NULL,NULL,NULL,NULL,'2017-04-11 01:42:06','administrador',NULL,NULL),(50,'basico',NULL,'cuarto','legislador',NULL,NULL,NULL,NULL,NULL,NULL,'2017-04-11 01:42:06','administrador',NULL,NULL),(51,'legislador',NULL,'dsdsdsdsdsdsdsd','dsdsdsdsdsdsdsds',NULL,NULL,2,NULL,NULL,NULL,'2017-04-11 01:42:06','administrador',NULL,NULL),(52,'basico',NULL,'basico','usuario','4866559',NULL,NULL,NULL,NULL,NULL,'2017-04-11 01:42:06','administrador',NULL,NULL),(53,'basico',NULL,'hghghghg','lklklklk','',NULL,NULL,NULL,NULL,NULL,'2017-04-11 01:42:06','administrador',NULL,NULL),(54,'basico',NULL,'dsdsdsd','dsdsds','dsdsds',NULL,NULL,NULL,NULL,NULL,'2017-04-11 01:42:06','administrador',NULL,NULL),(55,'basico',NULL,'dsdsds','fdsfdsf','','',NULL,NULL,NULL,NULL,'2017-04-11 01:42:06','administrador','2017-04-11 03:39:44','primero'),(56,'basico',NULL,'dddddd','eeeeee','454787887','',NULL,NULL,NULL,NULL,'2017-04-11 01:42:06','administrador','2017-04-11 04:29:04','primero');
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
  KEY `perfil_idx` (`idPerfil`),
  KEY `expediente_idx` (`idExpediente`),
  KEY `tipoVoto_idx` (`idTipoVoto`),
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
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol` (
  `idRol` smallint(6) NOT NULL AUTO_INCREMENT,
  `rol` varchar(45) NOT NULL,
  PRIMARY KEY (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'ROLE_LEGISLADOR'),(2,'ROLE_ADMINISTRADOR'),(3,'ROLE_SESION'),(4,'ROLE_OPERADOR');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoExpediente`
--

LOCK TABLES `tipoExpediente` WRITE;
/*!40000 ALTER TABLE `tipoExpediente` DISABLE KEYS */;
INSERT INTO `tipoExpediente` VALUES (1,'Resolución','P'),(2,'Ordenanza','P'),(3,'Particular','W'),(4,'Poder Ejecutivo','D'),(5,'Interno','I');
/*!40000 ALTER TABLE `tipoExpediente` ENABLE KEYS */;
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
  `activo` tinyint(1) NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `UNIQ_2265B05DF574DEDD` (`idPerfil`),
  KEY `rol_idx` (`idRol`),
  KEY `usuario_idx` (`usuario`),
  CONSTRAINT `fk_usuario_perfil` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'primero','$2y$13$iYyqe5rHhFm8sX7rxZiLpuocB3IK7t8uAdySd5bHzXgAxI5el1c12',3,2,1,'2017-03-08 23:10:05','administrador','2017-04-11 14:00:00','primero'),(2,'segundo','$2y$13$kGsTd4q8MVni7UJgzNBcT.2Cc4Tnbo.9Fz6Iwz38f1XckmOINSEO.',4,3,1,'2017-03-08 23:10:05','administrador',NULL,NULL),(34,'primero123','$2y$13$vu/q/NCHQiWEeNv9lLUfM.LUTR9J4DEB9UZfzpQSKaLhdTfHu.pq6',47,1,1,'2017-03-18 12:40:11','administrador',NULL,NULL),(37,'cuarto123','$2y$13$7PxB6OM73YFFMaJEA1Vi5eJ0FyC1Lap15ibJ.Atpu1/sD50jZxLx2',50,1,1,'2017-03-18 12:51:46','administrador',NULL,NULL),(38,'dsdsdsdsdsd','$2y$13$uidpWckDP5n7Ml9NWChRX.z5HCykvwZC24CKGOn4fVRBtWXq1P9ny',51,1,1,'2017-03-19 05:33:43','administrador',NULL,NULL),(39,'basico','$2y$13$/CG67impDQ6k8Aabkch7temEoFmK88obkRDX8W6YY5gtnx.J6cqtm',52,4,1,'2017-04-07 23:59:31','administrador',NULL,NULL),(40,'jgjhgjhghj','$2y$13$Q7zKxc9xCH9xxwjW7QZr1upkba4yxuTeiGAqK/GTvH2sXSLULVMCS',53,1,1,'2017-04-08 02:40:47','administrador',NULL,NULL),(41,'dsdsdsds','$2y$13$uIYVeh6dHjNTKTWFepX7IeneexusBHqgRydOABKuKRXAQJP1G/gWK',54,2,1,'2017-04-08 04:22:44','administrador',NULL,NULL),(42,'ddsdfssdfsd','$2y$13$Dc3Px3BnE7gVmoM0dq1JnORC5EJPr3zd840iLg2lFSg.BHBopash.',55,1,1,'2017-04-08 12:10:59','administrador','2017-04-11 03:39:45','primero'),(43,'11111111111111','$2y$13$9zbQ.rSE9fk9//xClkzY5uRWXonB2X2xG3ZTkM8u6cQqFNu62dZYm',56,2,1,'2017-04-09 23:41:11','administrador','2017-04-11 04:28:53','primero');
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

-- Dump completed on 2017-04-17 19:18:48
