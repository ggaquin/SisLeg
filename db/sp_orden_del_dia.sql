CREATE DEFINER=`root`@`localhost` PROCEDURE `crearOrdenDelDia`(IN _idSesion int, IN _tipo tinyint(1))
BEGIN

	declare _cantidadExpedientes int default 0;
	declare _idEstado int default 6;
    set @idTipo:=0;
    
    start transaction;
    
    DROP TEMPORARY TABLE IF EXISTS expedienteSesionTemporal;
    DROP TEMPORARY TABLE IF EXISTS dictamenesConjuntos;
    
    CREATE TEMPORARY TABLE expedienteSesionTemporal (
	  `idTipoExpedienteSesion` int(11) DEFAULT NULL,
	  `idExpediente` int(11) DEFAULT NULL,
	  `texto` longtext NOT NULL,
      `letra` varchar(2) NOT NULL,
      `añoExpediente` int NOT NULL,
      `numeroExpediente` int NOT NULL,
       INDEX `letra_idx` (`letra` ASC),
       INDEX `expediente` (`añoExpediente` ASC, `numeroExpediente` ASC)
	);
       
    #Mensajes del ejecutivo sin giro a comisiones
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='A';
    
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
	select 
			@idTipo,e.idExpediente,
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
                   ')</strong></p>',e.caratula,
                   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				  ),
			'A',(e.periodo-2000), e.numeroExpediente
	from  	expediente e
	inner
    join 	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    where	e.idTipoExpediente=4 and 
			e.idSesion=_idSesion and
            e.ultimoMomento=_tipo;
    
    #Mensajes del ejecutivo con giro a comisiones (Ordenanzas)
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='B';
  
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
	select 
			@idTipo,e.idExpediente,
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
                   ')</strong></p>',e.caratula,
                   traerComisionesExpediente(e.idExpediente),
				   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				 ),
            'B',(e.periodo-2000), e.numeroExpediente
	from  	expediente e
	inner
    join 	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    where	e.idTipoExpediente=9 and 
			e.idSesion=_idSesion and 
            e.ultimoMomento=_tipo;
    
    #proyectos de los concejales (comunicaciones y resoluciones)
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='C';
    
     INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			@idTipo,e.idExpediente,
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
                   ' / ',b.bloque ,')</strong></p>',
                   conformarProyecto(p.visto,p.considerandos,p.articulos,te.tipoExpediente,1,0),
				   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				 ),
			'C',(e.periodo-2000), e.numeroExpediente
	from  	expediente e
	inner
    join 	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	proyecto p
    on		e.IdExpediente=p.IdExpediente
    inner
    join	perfil pf
    on		p.idconcejal=pf.idPerfil
    inner
    join	bloque b
    on		b.idBloque=pf.idBloque
    where	e.idTipoExpediente in (1,6) and 
			e.idSesion=_idSesion and
            e.ultimoMomento=_tipo;	
    
    #proyectos de los concejales (ordenanzas)
 
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='D';
  
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			@idTipo,e.idExpediente,
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
                   ' / ',b.bloque ,')</strong></p>',
                   traerComisionesExpediente(e.idExpediente),
                   conformarProyecto(p.visto,p.considerandos,p.articulos,te.tipoExpediente,1,0),
				   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				  ),
			'D',(e.periodo-2000), e.numeroExpediente
	from  	expediente e
	inner
    join 	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	proyecto p
    on		e.IdExpediente=p.IdExpediente
    inner
    join	perfil pf
    on		p.idconcejal=pf.idPerfil
    inner
    join	bloque b
    on		b.idBloque=pf.idBloque
    where	e.idTipoExpediente=2 and 
			e.idSesion=_idSesion and
            e.ultimoMomento=_tipo;

	#pedidos de informes y notificaciones
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='CH';
    
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			@idTipo, e.idExpediente,
            concat('<strong>',upper(replace(e.caratula,'<p>','<p style="text-align: justify;margin-top: 0;text-indent: 15em">')),
				   '<p>CH</p><p>Δ<\/p>',
				   '<p style="margin-top: 0;text-indent: 5em">Expediente N ° ',
                   e.numeroExpediente,
                   '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                   te.letra,'&nbsp;&nbsp;&nbsp;&nbsp;',
                   DATE_FORMAT(m.fechaRespuesta, "%d/%m/%Y"),
                   '<\/p>',
                   case when m.discriminador = 'notificacion' 
							then concat('<p style="margin-top: 0;text-indent: 5em">',te.tipoExpediente,' ',e.numeroSancion,
										' - ',c.comision,'.-<\/p>')
							else ''
					end,
				   '</strong><div style="text-align:center">-----------------------------------------------------------------------<\/div>'),
				   'CH',(e.periodo-2000), e.numeroExpediente
	from  	expediente e
	inner
    join 	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	movimiento m
    on		m.idExpediente=e.idExpediente
    left
    join	comision c
    on		m.idComision=c.idComision
    where	m.idSesion=_idSesion and 
			fechaRespuesta is not null and
            discriminador in ('informe','notificacion')
    order 	
	by		m.discriminador,e.periodo, e.numeroExpediente;
    
    #Exedientes Particulares
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='E';
  
	INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
	select 
			@idTipo, e.idExpediente,
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
                   ')</strong></p>',e.caratula,
				   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				  ),
			'E',(e.periodo-2000), e.numeroExpediente
	from  	expediente e
	inner
    join 	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    where	e.idTipoExpediente=3 and 
			e.idSesion=_idSesion and
            e.ultimoMomento=_tipo;
    
    #id's de dictamenes conjuntos
    
    create temporary table dictamenesConjuntos(idDictamen int);
    
    insert 	into dictamenesConjuntos(idDictamen)
    select 	d.idDictamen
    from	dictamen d
    inner
    join	expedienteComision ec
    on		d.idDictamen=ec.idDictamenMayoria
    where	ec.idSesion=_idSesion and
            ec.ultimoMomento=_tipo	
    group
    by		d.idDictamen
    having	count(ec.idExpedienteComision)>1;
    
    insert 	into dictamenesConjuntos(idDictamen)
    select 	d.idDictamen
    from	dictamen d
    inner
    join	expedienteComision ec
    on		d.idDictamen=ec.idDictamenPrimeraMinoria
    where	ec.idSesion=_idSesion and
            ec.ultimoMomento=_tipo
    group
    by		d.idDictamen
    having	count(ec.idExpedienteComision)>1;
    
    insert 	into dictamenesConjuntos(idDictamen)
    select 	d.idDictamen
    from	dictamen d
    inner
    join	expedienteComision ec
    on		d.idDictamen=ec.idDictamenSegundaMinoria
    where	ec.idSesion=_idSesion and
            ec.ultimoMomento=_tipo
    group
    by		d.idDictamen
    having	count(ec.idExpedienteComision)>1;
    
    #dictamenes de comisiones
    	
    #dictamenes por mayoria
    
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			tes.idTipoExpedienteSesion, e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')</strong></p>',
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1)
				   end,
                   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				 ),
			c.letraOrdenDelDia, (e.periodo-2000), e.numeroExpediente
	from  	expediente e
    inner
    join	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	expedienteComision ec
    on		e.idExpediente=ec.idExpediente
    inner
    join	comision c
    on		ec.idComision=c.idComision
    inner
    join	tipoExpedienteSesion tes
    on 		tes.letra=c.letraOrdenDelDia
    inner
    join	dictamen d
    on		ec.idDictamenMayoria=d.idDictamen
    left
    join	tipoProyecto tpd
    on		d.idTipoDictamen=tpd.idTipoProyecto
    left
    join	proyectoRevision pr
    on		d.idProyectoRevision=pr.idProyectoRevision
    left	
    join	proyecto p
    on		pr.idProyecto=p.idProyecto
    left
    join	perfil pf
    on		p.idConcejal=pf.idPerfil
    left
    join	bloque b
    on		pf.idBloque=b.idBloque
    left
    join	tipoProyecto tp
    on		p.idTipoProyecto=tp.idTipoProyecto
    left
    join	dictamenesConjuntos dc
    on		d.idDictamen=dc.idDictamen
    where	ec.idSesion=_idSesion and 
			dc.idDictamen is null and
            ec.ultimoMomento=_tipo;
    
    #dictamenes por primera minoria
    
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			tes.idTipoExpedienteSesion, e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')</strong></p>',
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1)
				   end,
				   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				 ),
			c.letraOrdenDelDia, (e.periodo-2000), e.numeroExpediente
	from  	expediente e
    inner
    join	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	expedienteComision ec
    on		e.idExpediente=ec.idExpediente
    inner
    join	comision c
    on		ec.idComision=c.idComision
    inner
    join	tipoExpedienteSesion tes
    on 		tes.letra=c.letraOrdenDelDia
    inner
    join	dictamen d
    on		ec.idDictamenPrimeraMinoria=d.idDictamen
    left
    join	tipoProyecto tpd
    on		d.idTipoDictamen=tpd.idTipoProyecto
    left
    join	proyectoRevision pr
    on		d.idProyectoRevision=pr.idProyectoRevision
    left	
    join	proyecto p
    on		pr.idProyecto=p.idProyecto
    left
    join	perfil pf
    on		p.idConcejal=pf.idPerfil
    left
    join	bloque b
    on		pf.idBloque=b.idBloque
    left
    join	tipoProyecto tp
    on		p.idTipoProyecto=tp.idTipoProyecto
    left
    join	dictamenesConjuntos dc
    on		d.idDictamen=dc.idDictamen
    where	ec.idSesion=_idSesion and 
			dc.idDictamen is null and
            ec.ultimoMomento=_tipo;
    
     #dictamenes por segunda minoria
    
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			tes.idTipoExpedienteSesion, e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')</strong></p>',
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1)
				   end,
                   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				 ),
			c.letraOrdenDelDia, (e.periodo-2000), e.numeroExpediente
	from  	expediente e
    inner
    join	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	expedienteComision ec
    on		e.idExpediente=ec.idExpediente
    inner
    join	comision c
    on		ec.idComision=c.idComision
    inner
    join	tipoExpedienteSesion tes
    on 		tes.letra=c.letraOrdenDelDia
    inner
    join	dictamen d
    on		ec.idDictamenSegundaMinoria=d.idDictamen
    left
    join	tipoProyecto tpd
    on		d.idTipoDictamen=tpd.idTipoProyecto
    left
    join	proyectoRevision pr
    on		d.idProyectoRevision=pr.idProyectoRevision
    left	
    join	proyecto p
    on		pr.idProyecto=p.idProyecto
    left
    join	perfil pf
    on		p.idConcejal=pf.idPerfil
    left
    join	bloque b
    on		pf.idBloque=b.idBloque
    left
    join	tipoProyecto tp
    on		p.idTipoProyecto=tp.idTipoProyecto
    left
    join	dictamenesConjuntos dc
    on		d.idDictamen=dc.idDictamen
    where	ec.idSesion=_idSesion and 
			dc.idDictamen is null and
            ec.ultimoMomento=_tipo;
    
	#dictamenes conjuntos
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='Z';
    
    #dictamenes por mayoria
	
	INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			@idTipo, e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')</strong></p>',
                   traerComisionesDictamen(d.idDictamen),
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1)
				   end,
                   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				 ),'Z', (e.periodo-2000), e.numeroExpediente
	from  	expediente e
    inner
    join	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	expedienteComision ec
    on		e.idExpediente=ec.idExpediente
    inner
    join	dictamen d
    on		ec.idDictamenMayoria=d.idDictamen
    left
    join	tipoProyecto tpd
    on		d.idTipoDictamen=tpd.idTipoProyecto
    left
    join	proyectoRevision pr
    on		d.idProyectoRevision=pr.idProyectoRevision
    left	
    join	proyecto p
    on		pr.idProyecto=p.idProyecto
    left
    join	perfil pf
    on		p.idConcejal=pf.idPerfil
    left
    join	bloque b
    on		pf.idBloque=b.idBloque
    left
    join	tipoProyecto tp
    on		p.idTipoProyecto=tp.idTipoProyecto
    inner
    join	dictamenesConjuntos dc
    on		d.idDictamen=dc.idDictamen
    where	ec.idSesion=_idSesion and 
            ec.ultimoMomento=_tipo
    order   
    by		e.periodo, e.numeroExpediente;
    
    #dictamenes por primera minoria
	
	INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			@idTipo, e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')</strong></p>',
                   traerComisionesDictamen(d.idDictamen),
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1)
				   end,
				   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				 ),'Z', (e.periodo-2000), e.numeroExpediente
	from  	expediente e
    inner
    join	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	expedienteComision ec
    on		e.idExpediente=ec.idExpediente
    inner
    join	dictamen d
    on		ec.idDictamenPrimeraMinoria=d.idDictamen
    left
    join	tipoProyecto tpd
    on		d.idTipoDictamen=tpd.idTipoProyecto
    left
    join	proyectoRevision pr
    on		d.idProyectoRevision=pr.idProyectoRevision
    left	
    join	proyecto p
    on		pr.idProyecto=p.idProyecto
    left
    join	perfil pf
    on		p.idConcejal=pf.idPerfil
    left
    join	bloque b
    on		pf.idBloque=b.idBloque
    left
    join	tipoProyecto tp
    on		p.idTipoProyecto=tp.idTipoProyecto
	inner
    join	dictamenesConjuntos dc
    on		d.idDictamen=dc.idDictamen
    where	ec.idSesion=_idSesion and
            ec.ultimoMomento=_tipo
    order   
    by		e.periodo, e.numeroExpediente;
    
	#dictamenes por segunda minoria
	
	INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			@idTipo, e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')</strong></p>',
                   traerComisionesDictamen(d.idDictamen),
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1)
				   end,
                   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				 ),'Z', (e.periodo-2000), e.numeroExpediente
	from  	expediente e
    inner
    join	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	expedienteComision ec
    on		e.idExpediente=ec.idExpediente
    inner
    join	dictamen d
    on		ec.idDictamenSegundaMinoria=d.idDictamen
    left
    join	tipoProyecto tpd
    on		d.idTipoDictamen=tpd.idTipoProyecto
    left
    join	proyectoRevision pr
    on		d.idProyectoRevision=pr.idProyectoRevision
    left	
    join	proyecto p
    on		pr.idProyecto=p.idProyecto
    left
    join	perfil pf
    on		p.idConcejal=pf.idPerfil
    left
    join	bloque b
    on		pf.idBloque=b.idBloque
    left
    join	tipoProyecto tp
    on		p.idTipoProyecto=tp.idTipoProyecto
	inner
    join	dictamenesConjuntos dc
    on		d.idDictamen=dc.idDictamen
    where	ec.idSesion=_idSesion and
            ec.ultimoMomento=_tipo
    order   
    by		e.periodo, e.numeroExpediente;

	#insercion en la tabla de la bd
    
    INSERT INTO `expedienteSesion`
		(`idTipoExpedienteSesion`, `ordenSesion`,`idExpediente`,`idSesion`,
         `idEstadoExpedienteSesion`,`texto`,`aFavor`, `enContra`, `abstenciones`)
	select  
			t.idTipoExpedienteSesion, 0,
            t.idExpediente, _idSesion, _idEstado,
            case when idTipoExpedienteSesion<>25 then
						concat('<p><strong>',t.letra,') Δ.- ',t.texto)
				 else texto
			end,0,0,0
	from	(select distinct idTipoExpedienteSesion,idExpediente,
							 letra,texto,añoExpediente,numeroExpediente
			 from expedienteSesionTemporal
             ) t
    order 
    by		t.letra ASC,t.añoExpediente ASC,t.numeroExpediente ASC;
    
    select count(distinct idExpediente) into _cantidadExpedientes
    from `expedienteSesion` where idSesion=_idSesion;
    
    update 	expediente as e
    inner
    join	(select distinct idExpediente
			 from 	expedienteSesion
             where  idSesion=_idSesion
             ) as t
	on 		e.idExpediente=t.idExpediente
    set		idOficina=5,
			idEstadoExpediente=11;
    
    update 	sesion
    set		tieneOrdenDelDia=1,
			cantidadExpedientes=_cantidadExpedientes
	where 	idSesion=_idSesion;
    
    commit;
    
END