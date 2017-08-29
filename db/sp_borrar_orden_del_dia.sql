CREATE PROCEDURE `borrarOrdenDelDia` (_idSesion int)
BEGIN
	
    delete from expedienteSesion where idSesion=_idSesion;
    
	update 	sesion
    set		tieneOrdenDelDia=0,
			cantidadExpedientes=0
	where 	idSesion=_idSesion;
    
END
