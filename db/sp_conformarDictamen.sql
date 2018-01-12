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

	select 	concat('<h3><strong>Expediente: ',_numeroExpediente,'<\/strong><\/h3>',
			traerComisionesDictamen(_idDictamen),'<em><p><\/p>',
			formatParrafo(d.textoLibre),'<\/em><p><\/p>',
			if(d.discriminador='revision' and incluyeVistosYConsiderandos=1,
				concat('<h5><u>PROYECTO DE ', upper(tpp.tipoProyecto),'<\/u><\/h5>'),
                ''),
			case when d.discriminador='revision' and
					  pr.incluyeVistosYConsiderandos=1
                      then concat('<h7><u>VISTOS<\/u><\/h7>',formatParrafo(pr.visto))
				 else ''
			end,
            case when d.discriminador='revision' and
					  pr.incluyeVistosYConsiderandos=1
                      then concat('<h7><u>CONSIDERANDOS<\/u><\/h7>',formatParrafo(pr.considerandos))
				 else ''
			end,
            if (d.discriminador='revision' and  pr.incluyeVistosYConsiderandos=1,
				concat('<h7><u>POR TODO ELLO:<\/u><\/h7>',
						formatParrafo(concat('<p><strong>SE SUGIERE LA SANCIÓN DE ',
                               IF (tpd.idTipoProyecto=4,'EL','LA'),' SIGUIENTE:<\/strong></p>'))),
				''),
            if (d.discriminador<>'basico','<h5><u>',''),
            case when d.discriminador='articulado' 
                      then upper(tpd.tipoProyecto)
				 when d.discriminador='revision' 
                      then upper(tpp.tipoProyecto)
				 else ''
			end,
			if (d.discriminador<>'basico','<\/u><\/h5>',''),
            case when d.discriminador='articulado'
					  then formatArticulos(d.textoArticulado)
				 when d.discriminador='revision'
					  then formatArticulos(pr.articulos)
				 else ''
			end) as texto,
            _numeroExpediente as expediente,
            traerComisionesExpedienteParaTitulo(_idDictamen) as comisiones
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