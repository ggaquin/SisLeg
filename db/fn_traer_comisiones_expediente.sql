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
END