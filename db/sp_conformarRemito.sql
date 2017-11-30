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
	join	sancion s
	on		s.idNotificacion=m.idMovimiento
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

END