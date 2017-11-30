CREATE DEFINER=`root`@`localhost` FUNCTION `traerLetrasExpedienteSesion`(_idExpediente int, _idSesion int) RETURNS varchar(255) CHARSET utf8mb4
BEGIN
	declare letras varchar(255) default '';

	select 	group_concat(temp.orden separator ' / ' )
    into  	letras
    from	(
			 select concat(t.letra,' ',es.ordenSesion) as orden, es.idExpediente
             from 	expedienteSesion es
             inner
             join	tipoExpedienteSesion t
             on		es.idTipoExpedienteSesion=t.idTipoExpedienteSesion
             where  es.idSesion=_idSesion and es.idExpediente=_idExpediente
    ) as temp
    group 
    by	temp.idExpediente;
    
RETURN letras;
END