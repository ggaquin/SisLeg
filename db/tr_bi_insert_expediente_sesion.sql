CREATE DEFINER = CURRENT_USER TRIGGER `sistema_legislativo`.`expedienteSesion_BEFORE_INSERT` BEFORE INSERT ON `expedienteSesion` FOR EACH ROW
BEGIN
	set @ordenSesion:=((select count(*) from expedienteSesionPrueba)+1)
	set NEW.ordenSesion=@ordenSesion;
	set NEW.texto=replace(NEW.texto,'Δ',@ordenSesion);
END
