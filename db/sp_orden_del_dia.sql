CREATE DEFINER=`root`@`localhost` PROCEDURE `crearOrdenDelDia`(IN _idSesion int)
BEGIN

	declare _cantidadExpedientes int default 0;
	declare _idEstado int default 6;
    set @idTipo:=0;
    
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
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',e.año,
                   ')</strong></p>',e.caratula,
                   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				  ),
			'A',e.año, e.numeroExpediente
	from  	expediente e
	inner
    join 	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    where	e.idTipoExpediente=4 and e.idSesion=_idSesion;
    
    #Mensajes del ejecutivo con giro a comisiones (Ordenanzas)
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='B';
  
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
	select 
			@idTipo,e.idExpediente,
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',e.año,
                   ')</strong></p>',e.caratula,
                   traerComisionesExpediente(e.idExpediente),
				   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				 ),
            'B',e.año, e.numeroExpediente
	from  	expediente e
	inner
    join 	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    where	e.idTipoExpediente=9 and e.idSesion=_idSesion;
    
    #proyectos de los concejales (comunicaciones y resoluciones)
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='C';
    
     INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			@idTipo,e.idExpediente,
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',e.año,
                   ' / ',b.bloque ,')</strong></p>',
                   conformarProyecto(p.visto,p.considerandos,p.articulos,te.tipoExpediente,1,0),
				   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				 ),
			'C',e.año, e.numeroExpediente
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
    where	e.idTipoExpediente in (1,6) and e.idSesion=_idSesion;	
    
    #proyectos de los concejales (ordenanzas)
 
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='D';
  
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			@idTipo,e.idExpediente,
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',e.año,
                   ' / ',b.bloque ,')</strong></p>',
                   traerComisionesExpediente(e.idExpediente),
                   conformarProyecto(p.visto,p.considerandos,p.articulos,te.tipoExpediente,1,0),
				   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				  ),
			'D',e.año, e.numeroExpediente
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
    where	e.idTipoExpediente=2 and e.idSesion=_idSesion;

	#pedidos de informes (ordenanzas)
    /*
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='CH';
    
    set @acumulador_orden:=0;
    
    select 
			@idTipo,@acumulador_orden:=1+
			(select count(ordenSesion) from expedienteSesion 
			 where idTipoExpedienteSesion=t.idTipoExpedienteSesion and idSesion=_idSesion),
            e.idExpediente,_idSesion,_idEstado,
            concat('<strong>',upper(replace(e.caratula,'<p>','<p style="text-align: justify;margin-top: 0;text-indent: 1.5em">')),
				   '<p>CH</p><p>',@acumulador_orden,'<\/p>',
				   '<p>(Expediente N ',e.numeroExpediente,'<span style="padding-left:50px;"></span>',
                   te.letra,' ??/??/??? <\/p><p>',te.tipoExpediente,'[¿sancion?][¿comision?]<\/p>'),
			0,0,0
	from  	expediente e
	inner
    join 	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	movimiento m
    on		m.idExpediente=e.idExpediente
    where	m.idSesion=_idSesion
    order 	
	by		e.año, e.numeroExpediente;
    */
    
    #Exedientes Particulares
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='E';
  
	INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
	select 
			@idTipo, e.idExpediente,
            concat('<p><strong>E ',@acumulador_orden,'.- ',
				   upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',e.año,
                   ')</strong></p>',e.caratula,
				   '<div style="text-align:center">-----------------------------------------------------------------------<\/div>'
				  ),
			'E',e.año, e.numeroExpediente
	from  	expediente e
	inner
    join 	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    where	e.idTipoExpediente=3 and e.idSesion=_idSesion;
    
    #id's de dictamenes conjuntos
    
    create temporary table dictamenesConjuntos(idDictamen int);
    
    insert 	into dictamenesConjuntos(idDictamen)
    select 	d.idDictamen
    from	dictamen d
    inner
    join	expedienteComision_dictamenesMayoria dm
    on		d.idDictamen=dm.idDictamen
    where	d.idSesion=_idSesion
    group
    by		d.idDictamen
    having	count(dm.idExpedienteComision)>1;
    
    insert 	into dictamenesConjuntos(idDictamen)
    select 	d.idDictamen
    from	dictamen d
    inner
    join	expedienteComision_dictamenesPrimeraMinoria dpm
    on		d.idDictamen=dpm.idDictamen
    where	d.idSesion=_idSesion
    group
    by		d.idDictamen
    having	count(dpm.idExpedienteComision)>1;
    
    insert 	into dictamenesConjuntos(idDictamen)
    select 	d.idDictamen
    from	dictamen d
    inner
    join	expedienteComision_dictamenesPrimeraMinoria dsm
    on		d.idDictamen=dsm.idDictamen
    where	d.idSesion=_idSesion
    group
    by		d.idDictamen
    having	count(dsm.idExpedienteComision)>1;
    
    #dictamenes de comisiones
    	
    #dictamenes por mayoria
    
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			tes.idTipoExpedienteSesion, e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',e.año,
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
			c.letraOrdenDelDia, e.año, e.numeroExpediente
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
    join	expedienteComision_dictamenesMayoria dm
    on		ec.idExpedienteComision=dm.idExpedienteComision
    inner
    join	dictamen d
    on		dm.idDictamen=d.idDictamen
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
    where	d.idDictamen not in (select idDictamen from dictamenesConjuntos) and 
			d.idSesion=_idSesion;
    
    #dictamenes por primera minoria
    
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			tes.idTipoExpedienteSesion, e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',e.año,
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
			c.letraOrdenDelDia, e.año, e.numeroExpediente
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
    join	expedienteComision_dictamenesPrimeraMinoria dpm
    on		ec.idExpedienteComision=dpm.idExpedienteComision
    inner
    join	dictamen d
    on		dpm.idDictamen=d.idDictamen
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
    where	d.idDictamen not in (select idDictamen from dictamenesConjuntos) and 
			d.idSesion=_idSesion;
    
     #dictamenes por segunda minoria
    
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			tes.idTipoExpedienteSesion, e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',e.año,
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
			c.letraOrdenDelDia, e.año, e.numeroExpediente
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
    join	expedienteComision_dictamenesSegundaMinoria dsm
    on		ec.idExpedienteComision=dsm.idExpedienteComision
    inner
    join	dictamen d
    on		dsm.idDictamen=d.idDictamen
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
    where	d.idDictamen not in (select idDictamen from dictamenesConjuntos) and 
			d.idSesion=_idSesion;
    
	#dictamenes conjuntos
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='Z';
    
    #dictamenes por mayoria
	
	INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			@idTipo, e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',e.año,
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
				 ),'Z', e.año, e.numeroExpediente
	from  	expediente e
    inner
    join	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	expedienteComision ec
    on		e.idExpediente=ec.idExpediente
    inner	 
    join	expedienteComision_dictamenesMayoria dm
    on		ec.idExpedienteComision=dm.idExpedienteComision
    inner
    join	dictamen d
    on		dm.idDictamen=d.idDictamen
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
    where	d.idDictamen in (select idDictamen from dictamenesConjuntos) and 
			d.idSesion=_idSesion
    order   
    by		e.año, e.numeroExpediente;
    
    #dictamenes por primera minoria
	
	INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			@idTipo, e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',e.año,
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
				 ),'Z', e.año, e.numeroExpediente
	from  	expediente e
    inner
    join	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	expedienteComision ec
    on		e.idExpediente=ec.idExpediente
    inner	 
    join	expedienteComision_dictamenesPrimeraMinoria dpm
    on		ec.idExpedienteComision=dpm.idExpedienteComision
    inner
    join	dictamen d
    on		dpm.idDictamen=d.idDictamen
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
    where	d.idDictamen in (select idDictamen from dictamenesConjuntos) and 
			d.idSesion=_idSesion
    order   
    by		e.año, e.numeroExpediente;
    
	#dictamenes por segunda minoria
	
	INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			@idTipo, e.idExpediente, 
            concat(upper(replace(replace(e.caratula,'<p>',''),'<\/p>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',e.año,
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
				 ),'Z', e.año, e.numeroExpediente
	from  	expediente e
    inner
    join	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    inner
    join	expedienteComision ec
    on		e.idExpediente=ec.idExpediente
    inner	 
    join	expedienteComision_dictamenesSegundaMinoria dsm
    on		ec.idExpedienteComision=dsm.idExpedienteComision
    inner
    join	dictamen d
    on		dsm.idDictamen=d.idDictamen
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
    where	d.idDictamen in (select idDictamen from dictamenesConjuntos) and 
			d.idSesion=_idSesion
    order   
    by		e.año, e.numeroExpediente;

	#insercion en la tabla de la bd
    
    INSERT INTO `expedienteSesion`
		(`idTipoExpedienteSesion`, `ordenSesion`,`idExpediente`,`idSesion`,
         `idEstadoExpedienteSesion`,`texto`,`aFavor`, `enContra`, `abstenciones`)
	select 
			t.idTipoExpedienteSesion, 0,
            t.idExpediente, _idSesion, _idEstado,
            concat('<p><strong>',t.letra,') Δ.- ',
				   t.texto
				 ),0,0,0
	from	expedienteSesionTemporal t
    order 
    by		t.letra ASC,t.añoExpediente ASC,t.numeroExpediente ASC;
    
    select count(distinct idExpediente) into _cantidadExpedientes
    from `expedienteSesion` where idSesion=_idSesion;
    
    update 	sesion
    set		tieneOrdenDelDia=1,
			cantidadExpedientes=_cantidadExpedientes
	where 	idSesion=_idSesion;
    
END