CREATE PROCEDURE `conformarSancion` (IN _idSancion INT)
BEGIN

	select 	concat('<div style="text-align:center"><h1>Expediente: ',e.numeroExpediente,
				   '-',t.letra,'-',e.periodo,'</h1></div>',
                   ifnull(formatParrafo(ph.plantillaTexto),''),
                   case when s.discriminador='basico' then
							 formatParrafo(s.textoLibre)
						when s.discriminador='articulado' then
							 concat('<div style="text-align:center"><h3><u>',
									upper(tps.tipoProyecto),'</u></h3></div>',
                                    formatArticulos(s.textoArticulado))
						else concat('<div style="text-align:center"><h3><u>',
									upper(tpp.tipoProyecto),'</u></h3></div>',
                                    if (pr.incluyeVistosYConsiderandos=1,
										concat('<h4><u>Vistos<\/u></h4>',formatParrafo(pr.visto),
											   '<h4><u>Considerandos<\/u></h4>',formatParrafo(pr.considerandos))
										,''),
                                    formatArticulos(pr.articulos))
					end,
                    ifnull(formatParrafo(pf.plantillaTexto) ,''),
                    
                    if(s.numeroSancion<>'',
					   concat('<div "text-align:center" ><u>Número Sanción: ',
							  s.numeroSancion),
					   '')                  
                   )
    from	sancion s
    left
    join	tipoPlantillaTexto ph
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
    where 	s.idSancion=_idSancion;

END
