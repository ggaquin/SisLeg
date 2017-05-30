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
  `folios` varchar(4) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil`
--

LOCK TABLES `perfil` WRITE;
/*!40000 ALTER TABLE `perfil` DISABLE KEYS */;
INSERT INTO `perfil` VALUES (1,'basico',NULL,'Administrador','Sistema',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(2,'legislador',NULL,'Fuente Buena','Hector',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(3,'legislador',NULL,'Font','Miguel',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(4,'legislador',NULL,'Guirliddo','Gabriel',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(5,'legislador',NULL,'Vilar','Daniela',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(6,'legislador',NULL,'Tranfo','Ana ',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(7,'legislador',NULL,'Mercuri','Gabriel',NULL,NULL,6,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(8,'legislador',NULL,'Castagnini','Juan Manuel',NULL,NULL,3,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(9,'legislador',NULL,'Veliz','Juan Carlos',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(10,'legislador',NULL,'Figuerón','Luis',NULL,NULL,5,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(11,'legislador',NULL,'Menéndez','Claudio',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(12,'legislador',NULL,'Oyhaburu','Sergio',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(13,'legislador',NULL,'Llambi','Alvaro',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(14,'legislador',NULL,'Baloira','Emilano',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(15,'legislador',NULL,'Lopez','Vanesa',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(16,'legislador',NULL,'Coba','José',NULL,NULL,6,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(17,'legislador',NULL,'Vázquez','María Fernanda',NULL,NULL,3,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(18,'legislador',NULL,'Herrera','Maria Elena ',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(19,'legislador',NULL,'Trezza Silva','Ramiro',NULL,NULL,3,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(20,'legislador',NULL,'Cordera','Diego',NULL,NULL,6,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(21,'legislador',NULL,'Rivero','Julio',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(22,'legislador',NULL,'Sierra','Silvia',NULL,NULL,6,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(23,'legislador',NULL,'Denuchi','Fabio',NULL,NULL,6,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL),(24,'legislador',NULL,'Pellegrini','Marcelo',NULL,NULL,4,NULL,NULL,NULL,NULL,NULL,'2017-05-21 19:23:20','administrador',NULL,NULL);
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
  `visto` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `considerandos` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `quienSanciona` varchar(130) COLLATE utf8mb4_unicode_ci NOT NULL,
  `articulos` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json_array)',
  `fechaCreacion` datetime NOT NULL,
  `usuarioCreacion` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fechaModificacion` datetime DEFAULT NULL,
  `usuarioModificacion` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idProyecto` int(11) NOT NULL AUTO_INCREMENT,
  `idExpediente` int(11) DEFAULT NULL,
  `idTipoProyecto` smallint(6) DEFAULT NULL,
  `idBloque` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`idProyecto`),
  UNIQUE KEY `UNIQ_proyecto_expediente_idx` (`idExpediente`),
  KEY `proyecto_tipoProyecto_idx` (`idTipoProyecto`),
  KEY `proyecto_bloque_idx` (`idBloque`),
  CONSTRAINT `fk_proyecto_bloque` FOREIGN KEY (`idBloque`) REFERENCES `bloque` (`idBloque`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyecto_expediente` FOREIGN KEY (`idExpediente`) REFERENCES `expediente` (`idExpediente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyecto_tipoProyecto` FOREIGN KEY (`idTipoProyecto`) REFERENCES `tipoProyecto` (`idTipoProyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
INSERT INTO `tipoPerfil` VALUES (1,'Básico'),(2,'Legislador'),(3,'Público');
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
  KEY `tipoPerfil_rol_rol_idx` (`idRol`),
  KEY `tipoPerfil_rol_tipoPerfil` (`idTipoPerfil`),
  CONSTRAINT `fk_tipoPerfil_rol_rol` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tipoPerfil_rol_tipoPerfil` FOREIGN KEY (`idTipoPerfil`) REFERENCES `tipoPerfil` (`idTipoPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipoPerfil_rol`
--

LOCK TABLES `tipoPerfil_rol` WRITE;
/*!40000 ALTER TABLE `tipoPerfil_rol` DISABLE KEYS */;
INSERT INTO `tipoPerfil_rol` VALUES (2,1),(1,2),(2,2),(2,3),(1,4);
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
INSERT INTO `usuario` VALUES (1,'administrador','$2y$13$PV2vHlAy.LwjXtLetaUM3uJcDmduhPQ2Zpz2rj.Em1I/atyLxiiTW',1,2,1,'2017-05-21 21:27:30','administrador',NULL,NULL);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-30 13:28:47
