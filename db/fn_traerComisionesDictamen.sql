CREATE DEFINER=`root`@`localhost` FUNCTION `traerComisionesDictamen`(_idDictamen int) RETURNS text CHARSET utf8mb4
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
END