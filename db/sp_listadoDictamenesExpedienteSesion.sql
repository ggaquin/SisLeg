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
		join	dictamen dmd
		on		ec.idDictamenMayoria=dmd.idDictamen 
		inner
		join	comision c
		on		ec.idComision=c.idComision
		where 	ec.idExpediente=_idExpediente and ec.idSesion=_idSesion
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
		join	dictamen dpmd
		on		ec.idDictamenPrimeraMinoria=dpmd.idDictamen 
		inner
		join	comision c
		on		ec.idComision=c.idComision
		where 	ec.idExpediente=_idExpediente and ec.idSesion=_idSesion
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
		join	dictamen dsmd
		on		ec.idDictamenSegundaMinoria=dsmd.idDictamen 
		inner
		join	comision c
		on		ec.idComision=c.idComision
		where 	ec.idExpediente=_idExpediente and ec.idSesion=_idSesion
	) as t
group
by		t.idExpediente,
		t.idDictamen,
		t.redaccion,
		t.resuelve_por,
		t.fecha_creacion,
		t.usuario_creacion;
    
    
END