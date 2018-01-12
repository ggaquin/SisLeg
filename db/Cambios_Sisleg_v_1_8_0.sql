
USE `sistema_legislativo`;
DROP procedure IF EXISTS `conformarRemito`;

DELIMITER $$
USE `sistema_legislativo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `conformarRemito`(in _idRemito int)
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
    join	sancion_notificacion sn
    on		sn.idMovimiento=m.idMovimiento
	left
	join	sancion s
	on		sn.idSancion=s.idSancion
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

END$$

DELIMITER ;


USE `sistema_legislativo`;
DROP function IF EXISTS `traerComisionesExpedienteParaTitulo`;

DELIMITER $$
USE `sistema_legislativo`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `traerComisionesExpedienteParaTitulo`(_idDictamen int) RETURNS text CHARSET utf8mb4
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
        WHERE	d.idDictamen=_idDictamen
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
		WHERE	d.idDictamen=_idDictamen
		GROUP
		BY		d.idDictamen;
	end if;
			
RETURN replace(comisiones,',',' ');

END$$

DELIMITER ;


