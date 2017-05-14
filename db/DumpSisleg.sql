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
  KEY `agendaSesion_expediente_idx` (`idExpediente`),
  KEY `agendaSesion_sesion_idx` (`idSesion`),
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
-- Table structure for table `autores_proyectos`
--

DROP TABLE IF EXISTS `autores_proyectos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autores_proyectos` (
  `idProyecto` int(11) NOT NULL,
  `idPerfil` int(11) NOT NULL,
  PRIMARY KEY (`idProyecto`,`idPerfil`),
  KEY `IDX_C4A9BE80F574DEDD` (`idPerfil`),
  KEY `IDX_C4A9BE803C7128E2` (`idProyecto`),
  CONSTRAINT `fk_autores_proyectos_perfil` FOREIGN KEY (`idPerfil`) REFERENCES `perfil` (`idPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_autores_proyectos_proyectos` FOREIGN KEY (`idProyecto`) REFERENCES `proyecto` (`idProyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autores_proyectos`
--

LOCK TABLES `autores_proyectos` WRITE;
/*!40000 ALTER TABLE `autores_proyectos` DISABLE KEYS */;
INSERT INTO `autores_proyectos` VALUES (1,3),(2,3),(3,3),(4,3),(5,3),(6,3),(7,3),(8,3),(9,3),(11,3),(12,3),(13,3),(14,3),(15,3),(16,3),(17,3),(18,3),(19,3),(20,3),(21,3),(22,3),(11,5),(12,5),(13,5),(14,5),(15,5),(16,5),(17,5),(18,5),(19,5),(20,5),(21,5),(22,5);
/*!40000 ALTER TABLE `autores_proyectos` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bloque`
--

LOCK TABLES `bloque` WRITE;
/*!40000 ALTER TABLE `bloque` DISABLE KEYS */;
INSERT INTO `bloque` VALUES (1,'Frente Renovador'),(2,'Frente Para la Victoria'),(3,'Partido Justicialista');
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
  `idTipoComision` smallint(6) DEFAULT NULL,
  `activa` tinyint(1) NOT NULL,
  PRIMARY KEY (`idComision`),
  KEY `comision_tipoComision_idx` (`idTipoComision`),
  CONSTRAINT `fk_comision_tipoComision` FOREIGN KEY (`idTipoComision`) REFERENCES `tipoComision` (`idTipoComision`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comision`
--

LOCK TABLES `comision` WRITE;
/*!40000 ALTER TABLE `comision` DISABLE KEYS */;
INSERT INTO `comision` VALUES (1,'Salud Pública',2,1),(2,'Obras Públicas y Urbanismo',2,1),(3,'Servicios Públicos',2,1),(4,'Interpretación y Reglamento',2,1),(5,'Presupuesto y Hacienda',2,1),(6,'Cultura y Educación',2,1),(7,'Industria y Comercio Interior y Exterior',2,1),(8,'Planeamiento',2,1),(9,'Seguridad',2,1),(10,'Promoción de la Comunidad',2,1),(11,'Defensa del Usuario',2,1),(12,'Medios de Comunicación Social',2,1),(13,'Ecología y Protección del Medio Ambiente',2,1),(14,'Tierra y Viviendas',2,1),(15,'Labor Legislativa',2,1),(16,'Derechos y Garantías',2,1),(17,'Asistencia Social',2,1);
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
  `hashId` varchar(32) NOT NULL,
  `idEstadoExpediente` smallint(6) DEFAULT NULL,
  `numeroExpediente` varchar(50) NOT NULL,
  `idTipoExpediente` smallint(6) DEFAULT NULL,
  `caratula` varchar(500) NOT NULL,
  `folios` varchar(4) NOT NULL DEFAULT '0',
  `apellidosSiParticular` varchar(80) DEFAULT NULL,
  `nombresSiParticular` varchar(80) DEFAULT NULL,
  `listaImagenes` longtext COMMENT '(DC2Type:object)',
  `fechaCreacion` datetime NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `fechaAprobacion` datetime DEFAULT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  `usuarioAprobacion` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`idExpediente`),
  UNIQUE KEY `numeroExpediente_idx` (`numeroExpediente`),
  KEY `expediente_estadoExpediente_idx` (`idEstadoExpediente`),
  KEY `expediente_tipoExpediente_idx` (`idTipoExpediente`),
  CONSTRAINT `fk_expediente_estadoExpediente` FOREIGN KEY (`idEstadoExpediente`) REFERENCES `estadoExpediente` (`idEstadoExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_expediente_tipoExpediente` FOREIGN KEY (`idTipoExpediente`) REFERENCES `tipoExpediente` (`idTipoExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expediente`
--

LOCK TABLES `expediente` WRITE;
/*!40000 ALTER TABLE `expediente` DISABLE KEYS */;
INSERT INTO `expediente` VALUES (1,'c4ca4238a0b923820dcc509a6f75849b',1,'1',2,'<p>algun estracto</p>','0',NULL,NULL,'a:0:{}  ','2017-04-26 00:54:08','2017-05-02 21:48:51',NULL,'primero','primero',NULL),(2,'c81e728d9d4c2f636f067f89cc14862c',1,'2',5,'<p>&nbsp;nbvnbv</p>','0',NULL,NULL,'a:3:{i:0;O:20:\"AppBundle\\Popo\\Image\":2:{s:30:\"\0AppBundle\\Popo\\Image\0fileName\";s:37:\"b43fd6167dba3b44a5bd785d364b0949.jpeg\";s:33:\"\0AppBundle\\Popo\\Image\0imageConfig\";O:26:\"AppBundle\\Popo\\ImageConfig\":5:{s:35:\"\0AppBundle\\Popo\\ImageConfig\0caption\";s:13:\"foja 1-20.jpg\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0size\";i:211411;s:33:\"\0AppBundle\\Popo\\ImageConfig\0width\";s:5:\"120px\";s:31:\"\0AppBundle\\Popo\\ImageConfig\0key\";s:70:\"c81e728d9d4c2f636f067f89cc14862c/b43fd6167dba3b44a5bd785d364b0949.jpeg\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0type\";s:5:\"image\";}}i:1;O:20:\"AppBundle\\Popo\\Image\":2:{s:30:\"\0AppBundle\\Popo\\Image\0fileName\";s:36:\"f84bebc97ff21d5e0858fb174f021a84.pdf\";s:33:\"\0AppBundle\\Popo\\Image\0imageConfig\";O:26:\"AppBundle\\Popo\\ImageConfig\":5:{s:35:\"\0AppBundle\\Popo\\ImageConfig\0caption\";s:34:\"scoring_terminos_y_condiciones.pdf\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0size\";i:214315;s:33:\"\0AppBundle\\Popo\\ImageConfig\0width\";s:5:\"120px\";s:31:\"\0AppBundle\\Popo\\ImageConfig\0key\";s:69:\"c81e728d9d4c2f636f067f89cc14862c/f84bebc97ff21d5e0858fb174f021a84.pdf\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0type\";s:3:\"pdf\";}}i:2;O:20:\"AppBundle\\Popo\\Image\":2:{s:30:\"\0AppBundle\\Popo\\Image\0fileName\";s:36:\"ceeba1d2ce85a7d30c91169f4bfcc7b6.pdf\";s:33:\"\0AppBundle\\Popo\\Image\0imageConfig\";O:26:\"AppBundle\\Popo\\ImageConfig\":5:{s:35:\"\0AppBundle\\Popo\\ImageConfig\0caption\";s:18:\"Orden_del_Día.pdf\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0size\";i:702898;s:33:\"\0AppBundle\\Popo\\ImageConfig\0width\";s:5:\"120px\";s:31:\"\0AppBundle\\Popo\\ImageConfig\0key\";s:69:\"c81e728d9d4c2f636f067f89cc14862c/ceeba1d2ce85a7d30c91169f4bfcc7b6.pdf\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0type\";s:3:\"pdf\";}}}','2017-05-01 02:14:16','2017-05-03 03:09:03',NULL,'primero','primero',NULL),(3,'eccbc87e4b5ce2fe28308fd9f2a7baf3',1,'3',2,'<p>ddshkjhdkjshhadkjdhas</p>','0',NULL,NULL,'a:2:{i:2;O:20:\"AppBundle\\Popo\\Image\":2:{s:30:\"\0AppBundle\\Popo\\Image\0fileName\";s:37:\"fab40d3deda3b92d54425a52f30b6351.jpeg\";s:33:\"\0AppBundle\\Popo\\Image\0imageConfig\";O:26:\"AppBundle\\Popo\\ImageConfig\":5:{s:35:\"\0AppBundle\\Popo\\ImageConfig\0caption\";s:23:\"IMG-20161108-WA0001.jpg\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0size\";i:163954;s:33:\"\0AppBundle\\Popo\\ImageConfig\0width\";s:5:\"120px\";s:31:\"\0AppBundle\\Popo\\ImageConfig\0key\";s:70:\"eccbc87e4b5ce2fe28308fd9f2a7baf3/fab40d3deda3b92d54425a52f30b6351.jpeg\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0type\";s:5:\"image\";}}i:3;O:20:\"AppBundle\\Popo\\Image\":2:{s:30:\"\0AppBundle\\Popo\\Image\0fileName\";s:37:\"bd9479dc8c3e8b58a59cde19b8fe721d.jpeg\";s:33:\"\0AppBundle\\Popo\\Image\0imageConfig\";O:26:\"AppBundle\\Popo\\ImageConfig\":5:{s:35:\"\0AppBundle\\Popo\\ImageConfig\0caption\";s:23:\"IMG-20161107-WA0009.jpg\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0size\";i:104920;s:33:\"\0AppBundle\\Popo\\ImageConfig\0width\";s:5:\"120px\";s:31:\"\0AppBundle\\Popo\\ImageConfig\0key\";s:70:\"eccbc87e4b5ce2fe28308fd9f2a7baf3/bd9479dc8c3e8b58a59cde19b8fe721d.jpeg\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0type\";s:5:\"image\";}}}','2017-05-01 16:52:34','2017-05-02 21:28:40',NULL,'primero','primero',NULL),(4,'a87ff679a2f3e71d9181a67b7542122c',1,'4',1,'<p>ghfhgfhfhfhgffhfh</p>','0',NULL,NULL,'a:1:{i:0;O:20:\"AppBundle\\Popo\\Image\":2:{s:30:\"\0AppBundle\\Popo\\Image\0fileName\";s:37:\"2f464afd4e1da93ad9382df58b452a19.jpeg\";s:33:\"\0AppBundle\\Popo\\Image\0imageConfig\";O:26:\"AppBundle\\Popo\\ImageConfig\":5:{s:35:\"\0AppBundle\\Popo\\ImageConfig\0caption\";s:30:\"IMG_20160606_104128-perfil.jpg\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0size\";i:526762;s:33:\"\0AppBundle\\Popo\\ImageConfig\0width\";s:5:\"120px\";s:31:\"\0AppBundle\\Popo\\ImageConfig\0key\";s:70:\"a87ff679a2f3e71d9181a67b7542122c/2f464afd4e1da93ad9382df58b452a19.jpeg\";s:32:\"\0AppBundle\\Popo\\ImageConfig\0type\";s:5:\"image\";}}}','2017-05-01 19:36:36','2017-05-01 22:38:06',NULL,'primero','primero',NULL),(5,'6be79387cf426fe3b783ad30bf234677',1,'12145',3,'<p>dsdsd</p>','3','11111111111','22222222222','a:0:{}','2017-05-06 03:50:21','2017-05-06 15:14:25',NULL,'primero','primero',NULL);
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
  `fechaAsignacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechaAprobacion` datetime DEFAULT NULL,
  `aprobado` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`idExpedienteComision`),
  KEY `expedienteComision_expediente_idx` (`idExpediente`),
  KEY `expedienteComision_comision_idx` (`idComision`),
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
  `fechaCreacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuarioCreacion` varchar(70) NOT NULL,
  PRIMARY KEY (`idExpedienteComisionDictamen`),
  KEY `expedienteComisionDictamen_expedienteComision_idx` (`idExpedienteComision`),
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
  KEY `perfil_bloque_idx` (`idBloque`),
  CONSTRAINT `fk_perfil_bloque` FOREIGN KEY (`idBloque`) REFERENCES `bloque` (`idBloque`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil`
--

LOCK TABLES `perfil` WRITE;
/*!40000 ALTER TABLE `perfil` DISABLE KEYS */;
INSERT INTO `perfil` VALUES (3,'legislador',NULL,'primer','legislador','','gustavo_aquin@yahoo.com.ar',2,NULL,NULL,NULL,'2017-04-11 01:42:06','administrador','2017-04-19 23:32:01','primero'),(4,'basico','d41d8cd98f00b204e9800998ecf8427e_2f464afd4e1da93ad9382df58b452a19.jpeg','sasasa','asas','','',NULL,NULL,NULL,NULL,'2017-04-28 21:16:35','primero','2017-05-02 20:57:25','primero'),(5,'legislador',NULL,'SASAS','SASASAS','','ggaquin@hotmail.com',2,'',NULL,NULL,'2017-05-03 23:06:33','primero','2017-05-03 23:10:51','primero'),(6,'basico',NULL,'adasd','dadsad','','',NULL,NULL,NULL,NULL,'2017-05-03 23:14:50','primero','2017-05-03 23:15:27','primero');
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
  KEY `perfilExpedienteVoto_perfil_idx` (`idPerfil`),
  KEY `perfilExpedienteVoto_expediente_idx` (`idExpediente`),
  KEY `perfilExpedienteVoto_tipoVoto_idx` (`idTipoVoto`),
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
  `idBloque` smallint(6) NOT NULL,
  `visto` text NOT NULL,
  `considerandos` longtext NOT NULL,
  `quienSanciona` varchar(130) NOT NULL,
  `articulos` longtext NOT NULL,
  `fechaCreacion` datetime NOT NULL,
  `usuarioCreacion` varchar(70) NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `usuarioModificacion` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`idProyecto`),
  UNIQUE KEY `UNIQ_proyecto_expediente_idx` (`idExpediente`),
  UNIQUE KEY `UNIQ_6FD202B95768BAF9` (`idExpediente`),
  KEY `fk_proyecto_tipoproyecto_idx` (`idTipoProyecto`),
  CONSTRAINT `fk_proyecto_expediente` FOREIGN KEY (`idExpediente`) REFERENCES `expediente` (`idExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyecto_tipoproyecto` FOREIGN KEY (`idTipoProyecto`) REFERENCES `tipoProyecto` (`idTipoProyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyecto`
--

LOCK TABLES `proyecto` WRITE;
/*!40000 ALTER TABLE `proyecto` DISABLE KEYS */;
INSERT INTO `proyecto` VALUES (1,1,2,1,'GHGHJGHJGJH','DGFHFHFLLH','FFFGLDFLGKJDFLK','DLFKGDFLKG','2017-04-27 22:19:32','PEPE',NULL,NULL),(2,3,2,1,'<p>gdsgdshdgshgd</p>','<p>shagshagshagshags</p>','1','[{\"texto\":\"<p>hdjkshdkhsdksdhs<\\/p>\",\"incisos\":[{\"orden\":\"a) -\",\"texto\":\"<p>gjhgjhgjgjhgh<\\/p>\"},{\"orden\":\"b) -\",\"texto\":\"<p>dhdsjdgsgdjshdg<\\/p>\"}]},{\"texto\":\"<p>sahkjhakshaksjhaskj<\\/p>\",\"incisos\":[{\"orden\":\"a) -\",\"texto\":\"<p>saksjalkjsalsk<\\/p>\"}]}]','2017-05-01 05:32:38','primero',NULL,NULL),(3,4,1,1,'<p>visto que ...</p>','<p>considerando el...</p>','1','[{\"texto\":\"<p>articulo 1<\\/p>\",\"incisos\":[{\"orden\":\"a) -\",\"texto\":\"<p>inciso cualquiera<\\/p>\"}],\"numero\":1}]','2017-05-01 19:32:36','primero',NULL,NULL),(4,NULL,1,1,'<p>sasasasas</p>','<p>sasasasa</p>','1','[{\"texto\":\"<p>ssedwweweew<\\/p>\",\"incisos\":[],\"numero\":1}]','2017-05-05 22:22:05','primero',NULL,NULL),(5,NULL,1,1,'<p>dasdasdsad</p>','<p>dadsadsdsa</p>','1','[{\"texto\":\"<p>daaslkas\\u00f1lk\\u00f1lasd<\\/p><p>laskdjadjlaskjd<\\/p>\",\"incisos\":[],\"numero\":1}]','2017-05-05 22:59:51','primero',NULL,NULL),(6,NULL,2,1,'<p>dsdsds</p>','<p>dsdssdsd</p>','1','[{\"texto\":\"<p>dshgdgsdjhsgdhgsd<\\/p><p>dskdlsdk<\\/p>\",\"incisos\":[],\"numero\":1}]','2017-05-05 23:05:50','primero',NULL,NULL),(7,NULL,1,2,'<p>dsdshdjshdkshdk</p>','<p>sdsdkjshdjksd</p>','1','[{\"texto\":\"<p>sds\\u00f1dk\\u00f1lsdk7k<\\/p><p>kdsjhdskjdhksjd<\\/p>\",\"incisos\":[],\"numero\":1}]','2017-05-05 23:09:06','primero',NULL,NULL),(8,NULL,1,3,'<p>Esto agrega una sangría solamente a la primera línea de aquellos párrafos que están después de otros párrafos. Además, elimina el espacio debajo de todos los párrafos y encima de los que tienen sangría. Pero en la práctica observará que todavía hacen falta excepciones.Por ejemplo, en esta página hay elementos P que se usan como leyendas de imágenes (ver el ejemplo \"Figuras y leyendas\"). Puesto que hemos centrado esos párrafos, no deberían tener sangría. Una sencilla regla basta para lograr lo que deseamos. Puede ver que de hecho hemos usado esa regla en el ejemplo</p><p>Veamos algo muy sencillo: ponerle sangría a la primera línea de cada párrafo. A muchas personas esto les facilita la lectura más que si se agregan líneas vacías entre los párrafos (especialmente cuando el texto es largo) y además permite reservar las líneas vacías para indicar cortes más importantes.\nEl truco consiste en poner sangría solamente a los párrafos que siguen a otros párrafos. El primer párrafo de la página no necesita sangría, ni tampoco los que siguen a un diagrama, un encabezado o cualquier otra cosa que esté separada del texto. Las reglas son verdaderamente muy sencillas</p>','<p>adhakjhdkjashdkjashdjkas</p><p>lldjkjsda</p><p>ñkdlñask</p>','1','[{\"texto\":\"<p>hdgsdhjgsdjsgds<\\/p><p>dsdshds<\\/p><p>lsdjdlksdj<\\/p>\",\"incisos\":[{\"orden\":\"a) -\",\"texto\":\"<p>\\u00f1lskd\\u00f1sdkl\\u00f1skd<\\/p>\"},{\"orden\":\"b) -\",\"texto\":\"<p>mdnmsndnms,dnm,s<\\/p>\"}],\"numero\":1},{\"texto\":\"<p>dkajdlakjdsldkjalk<\\/p>\",\"incisos\":[],\"numero\":2}]','2017-05-08 10:13:21','primero',NULL,NULL),(9,NULL,2,1,'<p>jkhdkjhdfkjhsdkjfhsdkjfksfsd</p><p>fdsfsdfhjskhfjkshfkjsdhkjfsfhskdjhfkjsdhfksjdhfksdjf</p><p>fhdfkjshfksd</p>','<p><small>kjfhsdkfkjdsfjsdhfkjsdhfjsd</small><br></p><p><small>fhdjfkdshdkjfhksdj</small></p>','1','[{\"texto\":\"<p>lfdfjsdfshfjskdf<\\/p><p><br><\\/p><p>fdjsljflkdjflkdsjfklsjdlfkjs<\\/p>\",\"incisos\":[{\"orden\":\"a) -\",\"texto\":\"<p>fdhsfkjsfjsd<\\/p>\"},{\"orden\":\"b) -\",\"texto\":\"<p>dlsahajhdjksakda<\\/p>\"}],\"numero\":1}]','2017-05-09 01:34:21','primero',NULL,NULL),(11,NULL,1,2,'<p>ddladakjsjas</p>','<p>jasdlksajdlaksjdlksa</p>','1','[{\"texto\":\"<p>skdaslkdjlasjdlkasjdlaksjda<\\/p>\",\"incisos\":[{\"orden\":\"a) -\",\"texto\":\"<p>d{al{s\\u00f1ld{as<\\/p>\"},{\"orden\":\"b) -\",\"texto\":\"<p>daskdlaksd\\u00f1laskd<\\/p>\"}],\"numero\":1}]','2017-05-09 02:34:26','primero',NULL,NULL),(12,NULL,1,2,'<p>dkshdhskdhskjh</p>','<p>sdsdhsdkjshd</p>','1','[{\"texto\":\"<p>dksjdksljdlksjdlksjdlsk<\\/p>\",\"incisos\":[{\"orden\":\"a) -\",\"texto\":\"<p>\\u00f1kds\\u00f1dk\\u00f1sdks<\\/p>\"},{\"orden\":\"b) -\",\"texto\":\"<p>kds\\u00f1ldk\\u00f1sldk\\u00f1dslk<\\/p>\"}],\"numero\":1}]','2017-05-09 02:46:48','primero',NULL,NULL),(13,NULL,1,2,'<p>dkshdhskdhskjh</p>','<p>sdsdhsdkjshd</p>','1','[{\"texto\":\"<p>dksjdksljdlksjdlksjdlsk<\\/p>\",\"incisos\":[{\"orden\":\"a) -\",\"texto\":\"<p>\\u00f1kds\\u00f1dk\\u00f1sdks<\\/p>\"},{\"orden\":\"b) -\",\"texto\":\"<p>kds\\u00f1ldk\\u00f1sldk\\u00f1dslk<\\/p>\"}],\"numero\":1}]','2017-05-09 02:52:13','primero',NULL,NULL),(14,NULL,1,2,'<p>dkshdhskdhskjh</p>','<p>sdsdhsdkjshd</p>','1','[{\"texto\":\"<p>dksjdksljdlksjdlksjdlsk<\\/p>\",\"incisos\":[{\"orden\":\"a) -\",\"texto\":\"<p>\\u00f1kds\\u00f1dk\\u00f1sdks<\\/p>\"},{\"orden\":\"b) -\",\"texto\":\"<p>kds\\u00f1ldk\\u00f1sldk\\u00f1dslk<\\/p>\"}],\"numero\":1}]','2017-05-09 02:54:30','primero',NULL,NULL),(15,NULL,1,2,'<p>fsfsdfs</p>','<p>fsfsdfsdf</p>','1','[{\"texto\":\"<p>fdfsdfsdfsdfsfs<\\/p>\",\"incisos\":[{\"orden\":\"a) -\",\"texto\":\"<p>dffsfsd<\\/p>\"},{\"orden\":\"b) -\",\"texto\":\"<p>gfdgfdgfdgd<\\/p>\"}],\"numero\":1}]','2017-05-09 03:31:06','primero',NULL,NULL),(16,NULL,1,2,'<p>sadkasdñkñasdlkas</p>','<p>askdjalskjdlkas</p>','1','[{\"texto\":\"<p>dsldkl\\u00f1aksd\\u00f1lakd<\\/p>\",\"incisos\":[{\"orden\":\"a) -\",\"texto\":\"<p>sakjdalsjlkasjd<\\/p>\"}],\"numero\":1}]','2017-05-10 22:49:49','primero',NULL,NULL),(17,NULL,1,1,'<p>dñksakdlñaskdñlakd</p>','<p>111111111111111111</p>','1','[{\"texto\":\"<p>777777777777777<\\/p>\",\"incisos\":[{\"orden\":\"a) -\",\"texto\":\"<p>77777777777<\\/p>\"}],\"numero\":1},{\"texto\":\"<p>888888888888888888<\\/p>\",\"incisos\":[{\"orden\":\"a) -\",\"texto\":\"<p>888888888888888<\\/p>\"}],\"numero\":2}]','2017-05-10 23:15:22','primero',NULL,NULL),(18,NULL,1,2,'<p>99999999999999999999</p>','<p>9999999999999999999</p>','1','[{\"texto\":\"<p>999999999999999<\\/p>\",\"incisos\":[{\"orden\":\"a) -\",\"texto\":\"<p>9999999999999999999999<\\/p>\"},{\"orden\":\"b) -\",\"texto\":\"<p>9999999999999999<\\/p>\"}],\"numero\":1},{\"texto\":\"<p>333333333333333333333<\\/p>\",\"incisos\":[{\"orden\":\"a) -\",\"texto\":\"<p>333333333333333<\\/p>\"}],\"numero\":2}]','2017-05-10 23:17:58','primero',NULL,NULL),(19,NULL,1,1,'<p>shkahskajhsjak</p>','<p>asjjakshkasjhakj</p>','1','[{\"texto\":\"<p>ajsajshkjash<\\/p>\",\"incisos\":[],\"numero\":1}]','2017-05-10 23:21:29','primero',NULL,NULL),(20,NULL,1,2,'<p>dsadgasgdjag</p>','<p>dkjashdkjashdkj</p>','1','[{\"texto\":\"<p>dsldjalsdjasldjdlskajdaklsj<\\/p>\",\"incisos\":[],\"numero\":1}]','2017-05-10 23:24:47','primero',NULL,NULL),(21,NULL,1,2,'<p>sakskakjs</p>','<p>shakjshakjh</p>','1','[{\"texto\":\"<p>aks\\u00f1aks\\u00f1lask<\\/p>\",\"incisos\":[],\"numero\":1}]','2017-05-10 23:27:10','primero',NULL,NULL),(22,NULL,1,2,'<p>sakskakjs</p>','<p>shakjshakjh</p>','1','[{\"texto\":\"<p>aks\\u00f1aks\\u00f1lask<\\/p>\",\"incisos\":[],\"numero\":1}]','2017-05-10 23:27:41','primero',NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyectoFirma`
--

LOCK TABLES `proyectoFirma` WRITE;
/*!40000 ALTER TABLE `proyectoFirma` DISABLE KEYS */;
INSERT INTO `proyectoFirma` VALUES (1,3,11,0,NULL),(2,5,11,0,NULL),(3,3,12,0,NULL),(4,5,12,0,NULL),(5,3,13,0,NULL),(6,5,13,0,NULL),(7,3,14,0,NULL),(8,5,14,0,NULL),(9,5,15,0,NULL),(10,3,15,0,NULL),(11,3,16,0,NULL),(12,5,16,0,NULL),(13,3,17,0,NULL),(14,5,17,0,NULL),(15,3,18,0,NULL),(16,5,18,0,NULL),(17,3,19,0,NULL),(18,5,19,0,NULL),(19,3,20,0,NULL),(20,5,20,0,NULL),(21,3,21,0,NULL),(22,5,21,0,NULL),(23,3,22,0,NULL),(24,5,22,0,NULL);
/*!40000 ALTER TABLE `proyectoFirma` ENABLE KEYS */;
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
INSERT INTO `rol` VALUES (1,'ROLE_LEGISLADOR'),(2,'ROLE_ADMINISTRADOR'),(3,'ROLE_SESION'),(4,'ROLE_MESA_ENTRADA');
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
INSERT INTO `usuario` VALUES (1,'primero','$2y$13$RNuGUqpo1u/Qq7PEM26pBe3vNxGJwMMFaAvzCR4WxfrwS0CugfXCG',3,2,1,'2017-03-08 23:10:05','administrador','2017-04-19 23:32:01','primero'),(2,'consejal','$2y$13$MMvsLpfs50WmzC60TdV.p.q7Kw/60sTlB/.mpkGMMupyV2.K50yXG',4,1,1,'2017-04-28 21:16:35','primero','2017-05-02 20:57:25','primero'),(3,'SADADAS','$2y$13$1laAOrMg44Ma3oXjjPiG8.f38bD52ka.nDBXRv7d//yX9a/wKHLyS',5,2,1,'2017-05-03 23:06:33','primero','2017-05-03 23:10:51','primero'),(4,'fdfdfdf','$2y$13$wSdKTWpH7pmHXPWpW0sFiOcgE5slXuvThRQhtMJsiRlah6iVv0w2q',6,4,1,'2017-05-03 23:14:50','primero','2017-05-03 23:15:27','primero');
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

-- Dump completed on 2017-05-14 12:26:52
