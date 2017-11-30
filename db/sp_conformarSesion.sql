CREATE DEFINER=`root`@`localhost` PROCEDURE `conformarSancion`(IN _idSancion INT)
BEGIN

	select 	distinct
			concat('<h3><strong>Expediente: ',e.numeroExpediente,
				   '-',te.letra,'-',e.periodo,'<\/strong><\/h3>',
                   ifnull(concat('<p><\/p>',
								 formatParrafo(ph.plantillaTexto)),
						  ''),
                   case when s.discriminador='basica' then
							 concat('<em>',formatParrafo(s.textoLibre),'<\/em>')
						when s.discriminador='articulado' then
							 concat('<h5><u>',upper(tps.tipoProyecto),'<\/u><\/h5>',
                                    formatArticulos(s.textoArticulado))
						else concat(if (pr.incluyeVistosYConsiderandos=1,
										concat('<h7><u>VISTOS<\/u><\/h7>',formatParrafo(pr.visto),
											   '<h7><u>CONSIDERANDOS<\/u><\/h7>',formatParrafo(pr.considerandos)),
										''),
									'<h5><u>',upper(tpp.tipoProyecto),'<\/u><\/h5>',
                                    formatArticulos(pr.articulos))
					end,
                    ifnull(concat('<p><\/p>',
								  formatParrafo(pf.plantillaTexto)),
							''),
                    if(s.numeroSancion<>'',
					   concat('<h3><strong>Registrado bajo el N°: ',
							  s.numeroSancion,'<\/strong><\/h3>'),
					   '')                  
                   ) as texto, 
                   concat(e.numeroExpediente,'-',te.letra,'-',e.periodo) as expediente,
                   if(s.numeroSancion<>'',replace(s.numeroSancion,'/','_'),'') as numeroSancion
    from	sancion s
    left
    join	plantillaTexto ph
    on		s.idEncabezadoRedaccion=ph.idPlantillaTexto
    left
    join	plantillaTexto pf
    on		s.idPieRedaccion=pf.idPlantillaTexto
    left
    join	tipoProyecto tps
    on		s.idTipoSancion=tps.idTipoProyecto
    left
    join	proyectoRevision pr
    on		s.idProyectoRevision=pr.idProyectoRevision
    left
    join	proyecto p
    on		p.idProyecto=pr.idProyecto
    left
    join	tipoProyecto tpp
    on		p.idTipoProyecto=tpp.idTipoProyecto
    inner
    join	expedienteSesion es
    on		s.idSancion=es.idSancion
    inner
    join	expediente e
    on		es.idExpediente=e.idExpediente
    inner
    join	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    where 	s.idSancion=_idSancion;

END