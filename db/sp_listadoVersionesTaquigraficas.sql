CREATE DEFINER=`root`@`localhost` PROCEDURE `listadoVersionesTaquigraficas`(IN _idSesion INT)
BEGIN
	declare separador varchar(200) default '';
    set separador =concat('<p>',repeat('-',107),'<\/p>');
	select 	group_concat(replace(
							replace(
								replace(
									replace(descripcion,'<p><br>','<p>'),
									'<br><\/p>','<\/p>'),
								'p>','h8>'),
							'<br>','<p></p>'),						  
                          separador
						 ) 
            as versiones
    from	versionTaquigrafica	
	where   idSesion=_idSesion;
END