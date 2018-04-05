ALTER TABLE `tipoAutoridad` 
CHANGE COLUMN `tipoAutoridad` `tipoAutoridad` VARCHAR(15) NOT NULL ;

INSERT INTO `tipoAutoridad` (`tipoAutoridad`) VALUES ('vice presidente');

ALTER TABLE `sancion` 
ADD COLUMN `firmaVicePresidente` INT NULL DEFAULT NULL AFTER `firmaPresidente`;


DROP function IF EXISTS `conformarNumerosSancion`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `conformarNumerosSancion`(_idSancion int) RETURNS text CHARSET utf8mb4
BEGIN
	
	set @representacionHTML='';
               
	select conformarNumerosExternosParaSancion(o.numeracionOrigen,e.numeroExpediente,
											   te.letra,e.periodo)
	into 	@representacionHTML
    from 	sancion s
    inner
    join	expedienteSesion es
    on		s.idSancion=es.idSancion
    inner
    join	expediente e
    on		es.idExpediente=e.idExpediente
	inner
    join	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
	left
    join	origenExterno o
    on		e.idOrigenExterno=o.idOrigenExterno
    where	s.idSancion=_idSancion
    group
    by		e.numeroExpediente,te.tipoExpediente,e.periodo;
    
	select concat(@representacionHTML,
				  group_concat(
								conformarNumerosExternosParaSancion(o.numeracionOrigen,eeca.numeroExpediente,
																	teca.letra,eeca.periodo)
																	
								separator ','
							  )
			   )
	into 	@representacionHTML
    from 	sancion s
    inner
    join	dictamen d
    on		s.idDictamen=d.idDictamen
    inner
    join	expedienteComision ec
    on		d.idDictamen=ec.idDictamenMayoria
    left
    join	expedienteComision eca
    on		eca.idDictamenMayoriaQueAgrega=d.idDictamen
    left
    join	expediente eeca
    on		eeca.idExpediente=eca.idExpediente
    left
    join	tipoExpediente teca
    on		eeca.idTipoExpediente=teca.idTipoExpediente
    left
    join	origenExterno o
    on		eeca.idOrigenExterno=o.idOrigenExterno
    where	s.idSancion=_idSancion
    group
    by		eeca.numeroExpediente,teca.tipoExpediente,eeca.periodo;

    select concat(@representacionHTML,
				  group_concat(
								conformarNumerosExternosParaSancion(o.numeracionOrigen,eeca.numeroExpediente,
																	teca.letra,eeca.periodo)
																	
								separator ','
							  )
				   )
	into 	@representacionHTML
    from 	sancion s
    inner
    join	dictamen d
    on		s.idDictamen=d.idDictamen
    inner
    join	expedienteComision ec
    on		d.idDictamen=ec.idDictamenPrimeraMinoria
    left
    join	expedienteComision eca
    on		eca.idDictamenPrimeraMinoriaQueAgrega=d.idDictamen
    left
    join	expediente eeca
    on		eeca.idExpediente=eca.idExpediente
    left
    join	tipoExpediente teca
    on		eeca.idTipoExpediente=teca.idTipoExpediente
    left
    join	origenExterno o
    on		eeca.idOrigenExterno=o.idOrigenExterno
    where	s.idSancion=_idSancion
    group
    by		eeca.numeroExpediente,teca.tipoExpediente,eeca.periodo;
    
    select concat(@representacionHTML,
			  group_concat(
							conformarNumerosExternosParaSancion(o.numeracionOrigen,eeca.numeroExpediente,
																teca.letra,eeca.periodo)
																
							separator ','
						  )
			   )
	into 	@representacionHTML
    from 	sancion s
    inner
    join	dictamen d
    on		s.idDictamen=d.idDictamen
    inner
    join	expedienteComision ec
    on		d.idDictamen=ec.idDictamenSegundaMinoria
    left
    join	expedienteComision eca
    on		eca.idDictamenSegundaMinoriaQueAgrega=d.idDictamen
    left
    join	expediente eeca
    on		eeca.idExpediente=eca.idExpediente
    left
    join	tipoExpediente teca
    on		eeca.idTipoExpediente=teca.idTipoExpediente
    left
    join	origenExterno o
    on		eeca.idOrigenExterno=o.idOrigenExterno
    where	s.idSancion=_idSancion
    group
    by		eeca.numeroExpediente,teca.tipoExpediente,eeca.periodo;
    
RETURN @representacionHTML;
END$$
DELIMITER ;

DROP procedure IF EXISTS `crearOrdenDelDia`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `crearOrdenDelDia`(IN _idSesion int, IN _tipo tinyint(1))
BEGIN
	
    declare _cantidadExpedientes int default 0;
	declare _idEstado int default 6;
    set @idTipo:=0;
    set @ultimoMomento:=0;
    set	@cuenta_dictamenes_con_error:=0;
    
    select 	count(distinct e.idExpediente) 
	into	@cuenta_dictamenes_con_error
	from 	expediente e
	inner
	join	expedienteComision ec
	on		e.idExpediente=ec.idExpediente
	left
	join	expedienteSesion es
	on		e.idExpediente=es.idExpediente
	where 	es.idExpediente is null and 
			ec.idSesion=_idSesion and
            ec.anulado=0 and
			e.idTipoExpediente in (1,4,6) and
			(ec.idDictamenMayoria is not null or
			ec.idDictamenPrimeraMinoria is not null or
			ec.idDictamenSegundaMinoria is not null);
            
	if @cuenta_dictamenes_con_error>0 then
		SIGNAL SQLSTATE '40000' 
			SET MESSAGE_TEXT = 'Error en asignación de dictamenes';
    end if;
    
    select 	count(distinct e.idExpediente) 
	into	@cuenta_dictamenes_con_error
    from 	expediente e
    left
    join	sesion se
    on		e.idSesion=se.idSesion
	inner
	join	expedienteComision ec
	on		e.idExpediente=ec.idExpediente
	left
	join	expedienteSesion es
	on		e.idExpediente=es.idExpediente
    inner
    join	sesion ses
    on		es.idSesion=ses.idSesion
	where 	es.idExpediente is null and 
			ec.idSesion=_idSesion and
            ec.anulado=0 and 
            (se.fecha is null or se.fecha>ses.fecha) and
			e.idTipoExpediente in (2,7,9) and
			(ec.idDictamenMayoria is not null or
			ec.idDictamenPrimeraMinoria is not null or
			ec.idDictamenSegundaMinoria is not null);
    
	if @cuenta_dictamenes_con_error>0 then
		SIGNAL SQLSTATE '40000'
			SET MESSAGE_TEXT = 'Error en asignación de dictamenes';
    end if;
    
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
       
    #Tipo último momento
    
    select idTipoExpedienteSesion into @ultimoMomento 
    from tipoExpedienteSesion where letra='U';
       
    #Mensajes del ejecutivo sin giro a comisiones
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='A';
    
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
	select 
			if(_tipo=0,@idTipo,@ultimoMomento),e.idExpediente,
            concat(upper(replace(replace(replace(e.caratula,'<p>',''),'<\/p>',''),'<br>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
                   ')<\/strong></h8><p>',repeat('-',104),'<\/p>'),
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
			if(_tipo=0,@idTipo,@ultimoMomento),e.idExpediente,
            concat(upper(replace(replace(replace(e.caratula,'<p>',''),'<\/p>',''),'<br>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
                   ')<\/strong><\/h8>',traerComisionesExpediente(e.idExpediente),
				   '<p>',repeat('-',104),'<\/p>'),'B',(e.periodo-2000), e.numeroExpediente
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
			if(_tipo=0,@idTipo,@ultimoMomento),e.idExpediente,
            concat(upper(replace(replace(replace(e.caratula,'<p>',''),'<\/p>',''),'<br>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
                   ' / ',b.bloque ,')<\/strong><\/h8>',
                   conformarProyecto(p.visto,p.considerandos,p.articulos,te.tipoExpediente,1,0,1),
				   '<p>',repeat('-',104),'<\/p>'),'C',(e.periodo-2000), e.numeroExpediente
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
			if(_tipo=0,@idTipo,@ultimoMomento),e.idExpediente,
            concat(upper(replace(replace(replace(e.caratula,'<p>',''),'<\/p>',''),'<br>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
                   ' / ',b.bloque ,')<\/strong><\/h8>',
                   traerComisionesExpediente(e.idExpediente),
                   conformarProyecto(p.visto,p.considerandos,p.articulos,te.tipoExpediente,1,0,1),
				   '<p>',repeat('-',104),'<\/p>'),'D',(e.periodo-2000), e.numeroExpediente
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
    where	e.idTipoExpediente in (2,7) and 
			e.idSesion=_idSesion and
            e.ultimoMomento=_tipo;

	#pedidos de informes y notificaciones
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='CH';
    
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			@idTipo, e.idExpediente,
            concat(upper(replace(replace(replace(e.caratula,'<p>',''),'<\/p>',''),'<br>','')),
				  '<\/strong><\/h10><h7>CH<\/h7><h7>Δ<\/h7>',
				   '<h10><strong>Expediente N ° ', e.numeroExpediente,
                   '            ',te.letra,'            ',
                   DATE_FORMAT(m.fechaRespuesta, "%d/%m/%Y"),
                   '<\/strong><\/h10>',
                   case when m.discriminador = 'notificacion' 
							then concat('<h10><strong>',te.tipoExpediente,' ',e.numeroSancion,
										' - ',c.comision,'.-<\/strong><\/h10>')
							else ''
					end,
				   '<p>',repeat('-',104),'<\/p>'),'CH',(e.periodo-2000), e.numeroExpediente
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
			if(_tipo=0,@idTipo,@ultimoMomento), e.idExpediente,
            concat(upper(replace(replace(replace(e.caratula,'<p>',''),'<\/p>',''),'<br>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
                   ')<\/strong><\/h8><p>',repeat('-',104),'<\/p>'),
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
			ec.anulado=0 and
            d.ultimoMomento=_tipo and 
            ec.idDictamenMayoriaQueAgrega is null and
            ec.idDictamenPrimeraMinoriaQueAgrega is null and 
            ec.idDictamenSegundaMinoriaQueAgrega is null	
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
			ec.anulado=0 and
            d.ultimoMomento=_tipo and 
            ec.idDictamenMayoriaQueAgrega is null and
            ec.idDictamenPrimeraMinoriaQueAgrega is null and 
            ec.idDictamenSegundaMinoriaQueAgrega is null
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
			ec.anulado=0 and
            d.ultimoMomento=_tipo and 
            ec.idDictamenMayoriaQueAgrega is null and
            ec.idDictamenPrimeraMinoriaQueAgrega is null and 
            ec.idDictamenSegundaMinoriaQueAgrega is null
    group
    by		d.idDictamen
    having	count(ec.idExpedienteComision)>1;
    
    #dictamenes de comisiones
    	
    #dictamenes por mayoria
    
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			if(_tipo=0,tes.idTipoExpedienteSesion,@ultimoMomento), e.idExpediente, 
            concat(upper(replace(replace(replace(e.caratula,'<p>',''),'<\/p>',''),'<br>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')<\/strong><\/h8>',
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1,1)
				   end,
                   '<p>',repeat('-',104),'<\/p>'),c.letraOrdenDelDia, (e.periodo-2000), e.numeroExpediente
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
			ec.anulado=0 and
			dc.idDictamen is null and
            d.ultimoMomento=_tipo and 
            ec.idDictamenMayoriaQueAgrega is null and
            ec.idDictamenPrimeraMinoriaQueAgrega is null and 
            ec.idDictamenSegundaMinoriaQueAgrega is null;
    
    #dictamenes por primera minoria
    
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			if(_tipo=0,tes.idTipoExpedienteSesion,@ultimoMomento), e.idExpediente, 
            concat(upper(replace(replace(replace(e.caratula,'<p>',''),'<\/p>',''),'<br>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')<\/strong><\/h8>',
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1,1)
				   end,
				   '<p>',repeat('-',104),'<\/p>'),c.letraOrdenDelDia, (e.periodo-2000), e.numeroExpediente
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
			ec.anulado=0 and
			dc.idDictamen is null and
            d.ultimoMomento=_tipo and 
            ec.idDictamenMayoriaQueAgrega is null and
            ec.idDictamenPrimeraMinoriaQueAgrega is null and 
            ec.idDictamenSegundaMinoriaQueAgrega is null;
    
     #dictamenes por segunda minoria
    
    INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			if(_tipo=0,tes.idTipoExpedienteSesion,@ultimoMomento), e.idExpediente, 
            concat(upper(replace(replace(replace(e.caratula,'<p>',''),'<\/p>',''),'<br>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')<\/strong><\/h8>',
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1,1)
				   end,
                   '<p>',repeat('-',104),'<\/p>'),c.letraOrdenDelDia, (e.periodo-2000), e.numeroExpediente
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
			ec.anulado=0 and
			dc.idDictamen is null and
            d.ultimoMomento=_tipo and 
            ec.idDictamenMayoriaQueAgrega is null and
            ec.idDictamenPrimeraMinoriaQueAgrega is null and 
            ec.idDictamenSegundaMinoriaQueAgrega is null;
    
	#dictamenes conjuntos
    
    select idTipoExpedienteSesion into @idTipo 
    from tipoExpedienteSesion where letra='Z';
    
    #dictamenes por mayoria
	
	INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			if(_tipo=0,@idTipo,@ultimoMomento), e.idExpediente, 
            concat(upper(replace(replace(replace(e.caratula,'<p>',''),'<\/p>',''),'<br>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')<\/strong><\/h8>',
                   traerComisionesDictamen(d.idDictamen),
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1,1)
				   end,
                   '<p>',repeat('-',104),'<\/p>'),'Z', (e.periodo-2000), e.numeroExpediente
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
			ec.anulado=0 and
            d.ultimoMomento=_tipo and 
            ec.idDictamenMayoriaQueAgrega is null and
            ec.idDictamenPrimeraMinoriaQueAgrega is null and 
            ec.idDictamenSegundaMinoriaQueAgrega is null
    order   
    by		e.periodo, e.numeroExpediente;
    
    #dictamenes por primera minoria
	
	INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			if(_tipo=0,@idTipo,@ultimoMomento), e.idExpediente, 
            concat(upper(replace(replace(replace(e.caratula,'<p>',''),'<\/p>',''),'<br>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')<\/strong><\/h8>',
                   traerComisionesDictamen(d.idDictamen),
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1,1)
				   end,
				   '<p>',repeat('-',104),'<\/p>'),'Z', (e.periodo-2000), e.numeroExpediente
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
			ec.anulado=0 and
            d.ultimoMomento=_tipo and 
            ec.idDictamenMayoriaQueAgrega is null and
            ec.idDictamenPrimeraMinoriaQueAgrega is null and 
            ec.idDictamenSegundaMinoriaQueAgrega is null
    order   
    by		e.periodo, e.numeroExpediente;
    
	#dictamenes por segunda minoria
	
	INSERT INTO expedienteSesionTemporal
		(`idTipoExpedienteSesion`,`idExpediente`,`texto`,`letra`,`añoExpediente`,`numeroExpediente`)
    select 
			if(_tipo=0,@idTipo,@ultimoMomento), e.idExpediente, 
            concat(upper(replace(replace(replace(e.caratula,'<p>',''),'<\/p>',''),'<br>','')),
				   '(EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
				   case when b.bloque is null then ''
						else concat(' / ',b.bloque)
				   end ,')<\/strong><\/h8>',
                   traerComisionesDictamen(d.idDictamen),
				   case when d.discriminador='basico' then
							formatParrafo(d.textoLibre)
					    when d.discriminador='articulado' then
							conformarDictamenArticulado(d.textoLibre,d.textoArticulado,tpd.tipoProyecto)
					    else
							conformarProyecto(pr.visto,pr.considerandos,pr.articulos,
											  tp.tipoProyecto,pr.incluyeVistosYConsiderandos,1,1)
				   end,
                   '<p>',repeat('-',104),'<\/p>'),'Z', (e.periodo-2000), e.numeroExpediente
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
			ec.anulado=0 and
            d.ultimoMomento=_tipo and 
            ec.idDictamenMayoriaQueAgrega is null and
            ec.idDictamenPrimeraMinoriaQueAgrega is null and 
            ec.idDictamenSegundaMinoriaQueAgrega is null
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
						concat('<h8><strong>',if(_tipo=1,'U',t.letra),') Δ.- ',t.texto)
				 else concat('<h10><strong>',t.texto)
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
    set		idOficina=5;
    
    update 	sesion
    set		tieneOrdenDelDia=1,
			tieneUltimoMomento=_tipo,
			cantidadExpedientes=_cantidadExpedientes
	where 	idSesion=_idSesion;
    
    commit;
    
END$$
DELIMITER ;

DROP function IF EXISTS `traer_expedientes_error`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` FUNCTION `traer_expedientes_error`(_idSesion int) RETURNS text CHARSET utf8mb4
BEGIN
	
	set @detalle_dictamenes_con_error:='';
    set	@cuenta_dictamenes_con_error:=0;
    set @detalle_error:='';
	
	select 	group_concat(distinct concat(e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000)) 
						separator ','),
			count(distinct e.idExpediente)
	into	@detalle_dictamenes_con_error,@cuenta_dictamenes_con_error
	from 	expediente e
	inner
	join	expedienteComision ec
	on		e.idExpediente=ec.idExpediente
	inner
	join	tipoExpediente te
	on		e.idTipoExpediente=te.idTipoExpediente
	left
	join	expedienteSesion es
	on		e.idExpediente=es.idExpediente
	where 	es.idExpediente is null and 
			ec.idSesion=_idSesion and
            ec.anulado=0 and
			e.idTipoExpediente in (1,4,6) and
			(ec.idDictamenMayoria is not null or
			ec.idDictamenPrimeraMinoria is not null or
			ec.idDictamenSegundaMinoria is not null);

            
	if @cuenta_dictamenes_con_error>0 then
		set @detalle_error:=concat(if (@cuenta_dictamenes_con_error>1,
									   'Los expedientes ',
                                       'El expediente '),
									@detalle_dictamenes_con_error,
                                    if (@cuenta_dictamenes_con_error>1,
									   ' poseen ',
                                       ' posee '),
									'dictamen/es de comisión,',
                                    if (@cuenta_dictamenes_con_error>1,
									   ' pero los mismos nunca fueron presentados ',
                                       ' pero este nunca fue presentado '),
									'en una orden del día anteriormente. Considere cambiar la fecha de de sesión de ',
									'este/estos dictamen/es o anularlo/s desde el apartado de Expedientes Girados ',
									'a comisiones');
		return @detalle_error;
	end if;
    
    select 	group_concat(distinct concat(e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000)) 
						 separator ','),
			count(distinct e.idExpediente)
	into	@detalle_dictamenes_con_error,@cuenta_dictamenes_con_error
    from 	expediente e
    left
    join	sesion se
    on		e.idSesion=se.idSesion
	inner
	join	expedienteComision ec
	on		e.idExpediente=ec.idExpediente
    inner
	join	tipoExpediente te
	on		e.idTipoExpediente=te.idTipoExpediente
	left
	join	expedienteSesion es
	on		e.idExpediente=es.idExpediente
    inner
    join	sesion ses
    on		es.idSesion=ses.idSesion
	where 	es.idExpediente is null and 
			ec.idSesion=_idSesion and
            ec.anulado=0 and 
            (se.fecha is null or se.fecha>ses.fecha) and
			e.idTipoExpediente in (2,7,9) and
			(ec.idDictamenMayoria is not null or
			ec.idDictamenPrimeraMinoria is not null or
			ec.idDictamenSegundaMinoria is not null);
            
	if @cuenta_dictamenes_con_error>0 then
		set @detalle_error:=concat(if (@cuenta_dictamenes_con_error>1,
									   'Los expedientes ',
                                       'El expediente '),
									@detalle_dictamenes_con_error,
                                    if (@cuenta_dictamenes_con_error>1,
									   ' poseen ',
                                       ' posee '),
									'dictamen/es de comisión,',
                                    if (@cuenta_dictamenes_con_error>1,
									   ' pero los mismos nunca fueron presentados ',
                                       ' pero este nunca fue presentado '),
									'en una orden del dia anteriormente. Considere asignar la presente fecha de de sesión',
									if (@cuenta_dictamenes_con_error>1,
									   ' a estos expedientes ',
                                       ' a este expediente '),
                                    'desde el apartado de Expedientes o anular el/los ',
									'dictamen/es en cuestión desde el apartado de Expedientes Girados a Comisiones');
		return @detalle_error;
	end if;
END$$
DELIMITER ;