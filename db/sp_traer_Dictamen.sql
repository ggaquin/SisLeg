CREATE DEFINER=`root`@`localhost` PROCEDURE `conformarDictamen`(IN _idDictamen INT)
BEGIN

	declare _numeroExpediente varchar(12) default '';
    
    select  distinct concat(e.numeroExpediente,'-',t.letra,'-',e.periodo)
    into	_numeroExpediente
    from	expediente e
    inner
    join	tipoExpediente t
    on		e.idTipoExpediente=t.idTipoExpediente
    inner
    join	expedienteComision ec
    on		e.idExpediente=ec.idExpediente
    left
    join	dictamen dm
    on		ec.idDictamenMayoria=dm.idDictamen
    left
    join	dictamen dpm
    on		ec.idDictamenPrimeraMinoria=dpm.idDictamen
    left
    join	dictamen dsm
    on		ec.idDictamenSegundaMinoria=dsm.idDictamen
    where 	dm.idDictamen=_idDictamen or 
			dpm.idDictamen=_idDictamen or 
            dsm.idDictamen=_idDictamen;

	select 	concat('<div style="text-align:center"><h1>Expediente: ',
			_numeroExpediente,'</h1></div>'
			'<div style="text-align:left"><strong>',
			traerComisionesDictamen(_idDictamen),'</strong></div><i>',
			formatParrafo(d.textoLibre),'</i>',
			if(d.discriminador='revision' and incluyeVistosYConsiderandos=1,
				concat('<div style="text-align:center"><h3><u>PROYECTO DE ',
					   upper(tpp.tipoProyecto),'<\/u></h3></div>'),''),
			case when d.discriminador='revision' and
					  pr.incluyeVistosYConsiderandos=1
                      then concat('<h4><u>Vistos<\/u></h4>',formatParrafo(pr.visto))
				 else ''
			end,
            case when d.discriminador='revision' and
					  pr.incluyeVistosYConsiderandos=1
                      then concat('<h4><u>Considerandos<\/u></h4>',formatParrafo(pr.considerandos))
				 else ''
			end,
            if (d.discriminador='revision' and  pr.incluyeVistosYConsiderandos=1,
				concat('<h4><u>Por todo ello:<\/u><\/h4>',
						formatParrafo(concat('<p>SE SUGIERE LA SANCIÓN DE ',
                               IF (tpd.idTipoProyecto=4,'EL','LA'),' SIGUIENTE:</p>'))),
				''),
            if (d.discriminador<>'basico','<div style="text-align:center"><h3><u>',''),
            case when d.discriminador='articulado' 
                      then upper(tpd.tipoProyecto)
				 when d.discriminador='revision' 
                      then upper(tpp.tipoProyecto)
				 else ''
			end,
			if (d.discriminador<>'basico','<\/u></h3></div>',''),
            case when d.discriminador='articulado'
					  then formatArticulos(d.textoArticulado)
				 when d.discriminador='revision'
					  then formatArticulos(pr.articulos)
				 else ''
			end) as texto     
    from 	dictamen d
    left
    join	tipoProyecto tpd
    on		d.idTipoDictamen=tpd.idTipoProyecto
    left
    join	proyectoRevision pr
    on 		d.idProyectoRevision=pr.idProyectoRevision
    left
    join	proyecto p
    on		pr.idProyecto=p.idProyecto
    left
    join	tipoProyecto tpp
    on		tpp.idTipoProyecto=p.idTipoProyecto
    where	d.idDictamen=_idDictamen;
    
END