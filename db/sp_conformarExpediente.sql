CREATE DEFINER=`root`@`localhost` PROCEDURE `conformarExpediente`(in _idExpediente int)
BEGIN
		 
		SET lc_time_names = 'es_AR';
        
       	select 	formatParrafo(e.caratula) as caratula,
				e.numeroExpediente, te.letra, e.periodo,
                DATE_FORMAT(e.fechaCreacion,  "%d/%m/%Y") as fechaIngreso,
                case when dp.idDemandanteParticular is not null
						  then upper(concat(dp.apellidos,', ',dp.nombres,'(DNI',dp.documento,')'))
					 when oe.idOrigenExterno is not null
						  then upper(concat(o.oficina,ifnull(concat('-',o.codigo),'')))
					 when p.idProyecto is not null
						  then upper(concat(b.bloque,' (',pe.apellidos,', ',pe.nombres,')'))
					 else 'SECRETARIA ADMINISTRATIVA'
				end as origen,
                case when p.idExpediente is not null
						  then conformarProyecto(p.visto,p.considerandos,p.articulos,
												 te.tipoExpediente,1,0,0)
					 else ''
				end as textoProyecto
        from	expediente e
        left
        join	proyecto p
        on		e.idExpediente=p.idExpediente
        left
        join	perfil pe
        on		pe.idPerfil=p.idConcejal
        left
        join	bloque b
        on		pe.idBloque=b.idBloque
        inner
        join	tipoExpediente te
        on		e.idTipoExpediente=te.idTipoExpediente
        left
        join	demandanteParticular dp
        on		dp.idDemandanteParticular=e.idDemandanteParticular
        left
        join	origenExterno oe
        on		oe.idOrigenExterno=e.idOrigenExterno
        left
        join	oficina o
        on		o.idOficina=oe.idOficina
        where   e.idExpediente=_idExpediente;
END