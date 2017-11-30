CREATE DEFINER=`root`@`localhost` FUNCTION `formatArticulos`(arrayArticulosJSON text) RETURNS text CHARSET utf8mb4
BEGIN
	
    declare cantidadArticulos INT;
    declare cantidadIncisos int;
    declare articuloJSON text;
    declare articulo text; 
    declare articuloPreFormateado text;
    declare ordenArticulo varchar(2);
    declare incisoJSON text;
    declare arrayIncisosJSON text;
    declare ordenInciso varchar(2);
    declare inciso text;
    declare incisoPreFormateado text;
    
    
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
        
		#reemplaza los <p> por h9 al principio y al final de los parrafos del artículo
		set articuloPreFormateado:=replace(replace(replace(articulo,'<p>','<h9>'),'<\/p>','<\/h9>'),'<br>','<p><\/p>');
		#primer parrafo del artículo
        set @primerParrafo:=concat('<h9><strong><u>ARTICULO ',ordenArticulo,
							       '<\/u>°.-<\/strong> ',
                                   substr(articuloPreFormateado,5,position('<\/h9>'in articuloPreFormateado)));
        #resto de los parrafos del artículo
        set @demasParrafos:=substr(articuloPreFormateado,position('<\/h9>'in articuloPreFormateado)+5,length(articuloPreFormateado));
		#contenido del artículo formateado
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
				
                #reemplaza los <p> por h9 al principio y al final de los parrafos del inciso
                set incisoPreFormateado:=replace(replace(replace(inciso,'<p>','<h10>'),'<\/p>','<\/h10>'),'<br>','<p><\/p>');
                #primer parrafo del inciso
				set @primerParrafo:=concat('<h10><strong>',ordenInciso,')<\/strong> ',
										   substr(incisoPreFormateado,6,position('<\/h10>'in incisoPreFormateado)));
				#resto de los parrafos del inciso
                set @demasParrafos:=substr(incisoPreFormateado,position('<\/h10>' in incisoPreFormateado)+6,
										   length(incisoPreFormateado));
				#contenido del inciso formateado
				set representacionIncisosHTML=concat(representacionIncisosHTML,@primerParrafo,@demasParrafos);
                
                set @numeroInciso:=@numeroInciso+1;
                
			until @numeroInciso=cantidadIncisos end repeat;
			
            set representacionHTML=concat(representacionHTML,list_style,representacionIncisosHTML,'</ul>');
            
        end if;
        
        set @numeroArticulo:=@numeroArticulo+1;
        
	until @numeroArticulo=cantidadArticulos end repeat;
        
RETURN representacionHTML;
END