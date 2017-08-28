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
END