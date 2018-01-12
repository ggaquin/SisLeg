CREATE DEFINER=`root`@`localhost` FUNCTION `conformarProyecto`(visto text,considerando text,articulos text,tipo varchar(45), incluyeVistosYConsiderandos tinyint(1), esDictamen tinyint(1), imprimeFecha tinyint(1)) RETURNS text CHARSET utf8mb4
BEGIN
    
    declare html text default '';
    
    SET lc_time_names = 'es_AR';
    if (imprimeFecha=1) then
		set html=concat('<h6>Lomas de Zamora, ',
						replace(DATE_FORMAT(curdate(),  "%d %M %Y"),' ',' de '),
                        '.-<\/h6>');
	end if;
    if (incluyeVistosYConsiderandos=1) then
		set html=concat(html,'<h5><u>PROYECTO DE ',
						upper(tipo),'<\/u></h5>');
		set html=concat(html,'<h7><u>VISTOS<\/u></h7>');
		set html=concat(html,formatParrafo(visto));
		set html=concat(html,'<h7><u>CONSIDERANDOS<\/u></h7>');
		set html=concat(html,formatParrafo(considerando));
	end if;
    if(esDictamen=0) then
		set html=concat(html,'<h7><u>POR TODO ELLO:<\/u><\/h7>');
        set @parrafo=concat('<p>EL HONORABLE CONCEJO DELIBERANTE DE LOMAS DE ZAMORA EN EL USO DE LAS FACULTADES QUE LE SON PROPIAS SANCIONA ',
							if (tipo='decreto','EL','LA'),' SIGUIENTE:<\/p>');
        set html=concat(html,'<strong>',formatParrafo(@parrafo),'<\/strong>');    
    end if;
    set html=concat(html,'<h5><u>',upper(tipo),'<\/u></h5>');
    set html=concat(html,formatArticulos(articulos));
    
    select replace(html,'<br>','<p></p>') into html;
    
	RETURN html;
END