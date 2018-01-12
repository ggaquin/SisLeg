CREATE DEFINER=`root`@`localhost` PROCEDURE `traerApartadoOrdenDelDia`(_idSesion int, _idTipoExpedienteSesion int)
BEGIN

	SET group_concat_max_len = 1024*1024;

	select 	replace(group_concat(texto separator '<p></p>'),'<br>','<p></p>') as apartado
	from	expedienteSesion
	where	idSesion=_idSesion and 
			idTipoExpedienteSesion=_idTipoExpedienteSesion
	group
	by		idTipoExpedienteSesion;

END