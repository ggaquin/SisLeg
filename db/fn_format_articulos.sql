CREATE DEFINER=`root`@`localhost` FUNCTION `formatArticulos`(arrayArticulosJSON text) RETURNS text CHARSET utf8mb4
BEGIN
	
    declare cantidadArticulos INT;
    declare cantidadIncisos int;
    declare articuloJSON text;
    declare articulo text;
    declare ordenArticulo varchar(2);
    declare incisoJSON text;
    declare arrayIncisosJSON text;
    declare ordenInciso varchar(2);
    declare inciso text;
    
    declare representacionHTML text default '';
    declare representacionIncisosHTML text default '';
    declare pgph_style_inciso varchar(70) default '<p style="text-align: justify;margin-top: 0;">';
    declare pgph_style_articulo varchar(88) default '<p style="text-align: justify;margin-top: 0;">';
    declare list_style varchar(100) default '<ul style="list-style-type: none;">';
    
    set cantidadArticulos=JSON_LENGTH(arrayArticulosJSON);
    set @numeroArticulo:=0;
    
    repeat
    
		set @articuloActual:=concat('$[',convert(@numeroArticulo,char(2)),']');
        set articuloJSON=json_extract(arrayArticulosJSON,@articuloActual);
        set ordenArticulo=trim(both '"'from json_extract(articuloJSON,'$.numero'));
        set articulo=trim(both '"'from json_extract(articuloJSON,'$.texto'));
		
        set @primerParrafo:=concat('<p><strong><u>Artículo ',ordenArticulo,'<\/u>°.-<\/strong> ',substr(articulo,4,position('<\/p>'in articulo)));
        set @demasParrafos:=replace(
									  substr(articulo,
											 position('<\/p>'in articulo)+4,
                                             length(articulo)
                                             ),
										'<p>',
                                        pgph_style_articulo
                                        );
        
		set representacionHTML=concat(representacionHTML,@primerParrafo,@demasParrafos);
		
         
        set arrayIncisosJSON=json_extract(articuloJSON,'$.incisos');
        set cantidadIncisos=JSON_LENGTH(arrayIncisosJSON);
        
        if cantidadIncisos>0 then
        
			set representacionIncisosHTML='';
			set @numeroInciso:=0;
            
			repeat
								
                set @incisoActual:=concat('$[',convert(@numeroInciso,char(2)),']');
				set incisoJSON=json_extract(arrayIncisosJSON,@incisoActual);
				set ordenInciso=trim( both '"' from json_extract(incisoJSON,'$.orden'));
                set inciso=trim(both '"' from json_extract(incisoJSON,'$.texto'));
				
				set @primerParrafo:=concat(pgph_style_inciso,'<strong>',ordenInciso,')<\/strong> ',substr(inciso,4,position('<\/p>'in inciso)));
				
                set @demasParrafos:=replace(
									  substr(inciso,
											 position('<\/p>' in inciso)+4,
                                             length(inciso)
                                             ),
										'<p>',
                                        pgph_style_inciso
                                        );
        
				set representacionIncisosHTML=concat(representacionIncisosHTML,@primerParrafo,@demasParrafos);
                
                set @numeroInciso:=@numeroInciso+1;
                
			until @numeroInciso=cantidadIncisos end repeat;
			
            set representacionHTML=concat(representacionHTML,list_style,representacionIncisosHTML,'<\/ul>');
            
        end if;
        
        
        set @numeroArticulo:=@numeroArticulo+1;
        
	until @numeroArticulo=cantidadArticulos end repeat;
        
RETURN representacionHTML;
END