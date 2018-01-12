CREATE DEFINER=`root`@`localhost` PROCEDURE `listadoExpedientesPorSesion`(in _idSesion int, in _numeroExpediente int,in _tipoExpediente int, in _letraOD char(1))
BEGIN

    DROP TEMPORARY TABLE IF EXISTS dictamenesExpedientes;
    
    CREATE TEMPORARY TABLE dictamenesExpedientes (
	  `idExpediente` int(11) DEFAULT NULL,
	  `cuentaDictamenes` int(2) NOT NULL,
       INDEX `idExpediente_idx` (`idExpediente` ASC)
	);

	insert into dictamenesExpedientes (idExpediente,cuentaDictamenes)
	select ec.idExpediente, sum(if(dmd.idDictamen is not null,1,0) +
							    if(dpmd.idDictamen is not null,1,0) +
                                if(dsmd.idDictamen is not null,1,0)
								) as cuentaDictamenes
						
    from 	expedienteComision ec
    left
    join	dictamen dmd
    on		ec.idDictamenMayoria=dmd.idDictamen
	left
    join	dictamen dpmd
    on		ec.idDictamenPrimeraMinoria=dpmd.idDictamen
	left
    join	dictamen dsmd
    on		ec.idDictamenSegundaMinoria=dsmd.idDictamen
    where 	ec.idSesion=_idSesion
    group	
    by		ec.idExpediente;
    
    
	select 	distinct e.idExpediente , case when p.idProyecto is null then 0 else p.idProyecto end as idProyecto,
			concat(e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000)) as numero_expediente, te.tipoExpediente, 
			traerLetrasExpedienteSesion(e.idExpediente,s.idSesion) as letrasOD, 
			case when esr.idSancion is not null then 'Si' else 'No' end as tiene_sancion,
            case when esr.idSancion is not null then esr.idSancion else 0 end as idSancion,
            case when esr.idSancion is not null then esr.idDictamen else 0 end as idDictamen,
			case when esr.idSancion is not null then if(esr.numeroSancion is null,'',esr.numeroSancion)
				 else ''
			end as numero_sancion,
			case when m.idMovimiento is not null then 'Si'
				 else 'No'
			end as tiene_notificacion,
            case when de.idExpediente is null then 0
				 else de.cuentaDictamenes
			end as dictamenes
            
	from 	expedienteSesion es
	inner
	join	expediente e
	on		es.idExpediente=e.idExpediente
    left
    join	dictamenesExpedientes de
    on		e.idExpediente=de.idExpediente
    left
    join 	proyecto p
    on		p.idExpediente=e.idExpediente
	inner
	join	tipoExpediente te
	on		e.idTipoExpediente=te.IdTipoExpediente
	inner
	join	tipoExpedienteSesion tes
	on		es.idTipoExpedienteSesion=tes.idTipoExpedienteSesion
	left
	join	sancion esr
	on		es.idSancion=esr.idSancion
	left
	join	movimiento m
	on		esr.idNotificacion=m.idMovimiento
	inner
	join	sesion s
	on		es.idSesion=s.idSesion
	where   s.idSesion=_idSesion and 
			(_numeroExpediente is null or e.numeroExpediente=_numeroExpediente) and
            (_tipoExpediente is null or te.idTipoExpediente=_tipoExpediente) and 
            (_letraOD is null or instr(traerLetrasExpedienteSesion(e.idExpediente,s.idSesion),_letraOD)<>0);

END