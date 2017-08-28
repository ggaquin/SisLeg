CREATE DEFINER=`root`@`localhost` PROCEDURE `traerApartadoOrdenDelDia`(_idSesion int, _idTipoExpedienteSesion int)
BEGIN

	SET group_concat_max_len = 1024*1024;

	select 	group_concat(texto separator '<br>') as apartado
	from	expedienteSesion
	where	idSesion=_idSesion and 
			idTipoExpedienteSesion=_idTipoExpedienteSesion
	group
	by		idTipoExpedienteSesion;

END