ALTER TABLE informe 
	CHANGE idInforme idInforme SMALLINT AUTO_INCREMENT NOT NULL, 
	CHANGE idDestino idDestino SMALLINT DEFAULT NULL, 
	CHANGE fechaEmision fechaEmision DATETIME NOT NULL, 
	CHANGE fechaIngresoRespuesta fechaIngresoRespuesta DATETIME NOT NULL, 
	CHANGE fojas fojas VARCHAR(50) NOT NULL, 
	CHANGE usuarioModificacion usuarioModificacion VARCHAR(70) NOT NULL, 
	CHANGE fechaModificacion fechaModificacion DATETIME NOT NULL;
	
	
ALTER TABLE giro DROP idRespuestaDestino, CHANGE idGiro idGiro SMALLINT AUTO_INCREMENT NOT NULL, CHANGE idDestinoGiro idDestinoGiro SMALLINT DEFAULT NULL, CHANGE idOrigenGiro idOrigenGiro SMALLINT DEFAULT NULL, CHANGE idExpediente idExpediente INT DEFAULT NULL, CHANGE fechaEnvioRemito fechaEnvioRemito DATETIME NOT NULL, CHANGE fechaRecepcionRemito fechaRecepcionRemito DATETIME NOT NULL, CHANGE observacion observacion VARCHAR(200) NOT NULL, CHANGE usuarioModificacion usuarioModificacion VARCHAR(70) NOT NULL, CHANGE fechaModificacion fechaModificacion DATETIME NOT NULL;
ALTER TABLE oficina CHANGE idOficina idOficina SMALLINT AUTO_INCREMENT NOT NULL;
