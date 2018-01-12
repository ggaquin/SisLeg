CREATE DEFINER=`root`@`localhost` PROCEDURE `conformarProyecto`(in _idProyecto int)
BEGIN
		
        select 
				conformarProyecto(p.visto,p.considerandos,p.articulos,
								  tp.tipoProyecto,1,0,0) as textoProyecto,
				concat(pe.apellidos,', ',pe.nombres) as autor,
                b.bloque
        from 	proyecto p
        inner
        join	tipoProyecto tp
        on		p.idTipoProyecto=tp.idTipoProyecto
        inner
        join	perfil pe
        on		p.idConcejal=pe.idPerfil
        inner
        join	bloque b
        on		pe.idBloque=b.idBloque
        where	p.idProyecto=_idProyecto;
        
        
END