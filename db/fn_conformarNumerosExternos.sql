CREATE DEFINER=`root`@`localhost` FUNCTION `conformarNumerosExternos`(arrayNumeros text) RETURNS text CHARSET utf8mb4
BEGIN
	
    declare cantidadArticulos int default 0;
    declare numeroJSON text; 
    declare ente varchar(4);
	declare numero varchar(8);
	declare letra varchar(1);
	declare folios varchar(3);
	declare año varchar(4);
    -- declare representacionHTML text default '';
    
	set @cantidadElementos=JSON_LENGTH(arrayNumeros);
    set @elemento:=0;
    set @representacionHTML='';
    
    if @cantidadElementos>0 then
    
		repeat
		
			set @elementoActual:=concat('$[',convert(@elemento,char(2)),']');
			set numeroJSON=json_extract(arrayNumeros,@elementoActual);
			set ente=trim(both '"'from json_extract(numeroJSON,'$.ente'));
			set numero=trim(both '"'from json_extract(numeroJSON,'$.numero'));
			set letra=trim(both '"'from json_extract(numeroJSON,'$.letra'));
			set folios=trim(both '"'from json_extract(numeroJSON,'$.folios'));
			set año=trim(both '"'from json_extract(numeroJSON,'$.año'));
			
			set @representacionHTML=concat( 
											@representacionHTML,
											ente,'-',numero,'|',substring(año,3),
											'|',upper(letra),'|',folios,
											if (@elemento<@cantidadElementos,
											    ',','')
										   );
                                   
			set @elemento=@elemento+1;
                                   
		until @elemento=@cantidadElementos end repeat;
        
	end if;
		
RETURN @representacionHTML;
END