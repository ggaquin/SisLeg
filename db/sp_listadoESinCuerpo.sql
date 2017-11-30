CREATE DEFINER=`root`@`localhost` PROCEDURE `listadoESinCuerpo`(in fechaInicio datetime, in fechaFin datetime)
BEGIN

	select  group_concat(
				concat('<h8><strong>EXPTE. ',e.numeroExpediente,'-',te.letra,'-',(e.periodo-2000),
					   '<\/strong><\/h8>',e.caratula)  
			separator '<h3>------------------------------------------------------<\/h3>')
            as texto
	from  	(select * from expediente order by numeroExpediente, periodo) e
	inner
    join 	tipoExpediente te
    on		e.idTipoExpediente=te.idTipoExpediente
    where	e.idTipoExpediente=3 and 
			e.idSesion is null and 
            e.fechaCreacion between fechaInicio and fechaFin
	group 
    by		e.idTipoExpediente;
END