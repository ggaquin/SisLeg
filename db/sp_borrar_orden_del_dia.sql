CREATE DEFINER=`root`@`localhost` PROCEDURE `borrarOrdenDelDia`(_idSesion int)
BEGIN
	
    delete from expedienteSesion where idSesion=_idSesion;
    
    delete 	s
	from 	sancion s
    left
    join	expedienteSesion es
    on		s.idSancion=es.idSancion
    where   es.idSancion is null;
		
	update 	sesion
    set		tieneOrdenDelDia=0,
			tieneUltimoMomento=0,
			cantidadExpedientes=0
	where 	idSesion=_idSesion;
    
END