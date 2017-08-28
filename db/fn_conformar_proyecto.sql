CREATE DEFINER=`root`@`localhost` FUNCTION `conformarProyecto`(visto text,considerando text,articulos text,tipo varchar(45), incluyeVistosYConsiderandos tinyint(1), esDictamen tinyint(1)) RETURNS text CHARSET utf8mb4
BEGIN
    
    declare html text default '';
    
    SET lc_time_names = 'es_AR';
    
    set html=concat('<div style="text-align:right">Lomas de Zamora, ',
					replace(DATE_FORMAT(curdate(),  "%d %M %Y"),' ',' de '),'.-<\/div>');
    if (incluyeVistosYConsiderandos=1) then
		set html=concat(html,'<div style="text-align:center"><h3><u>PROYECTO DE ',
						upper(tipo),'<\/u></h3></div>');
		set html=concat(html,'<h4><u>Vistos<\/u></h4>');
		set html=concat(html,formatParrafo(visto));
		set html=concat(html,'<h4><u>Considerandos<\/u></h4>');
		set html=concat(html,formatParrafo(considerando));
	end if;
    if(esDictamen=0) then
		set html=concat(html,'<h4><u>Por todo ello:<\/u><\/h4>');
        set @parrafo=concat('<p>EL HONORABLE CONCEJO DELIBERANTE DE LOMAS DE ZAMORA EN EL USO DE LAS FACULTADES QUE LE SON PROPIAS SANCIONA ',
							if (tipo=4,'EL','LA'),' SIGUIENTE:<\/p>');
        set html=concat(html,'<strong>',formatParrafo(@parrafo),'<\/strong>');    
    end if;
    set html=concat(html,'<div style="text-align:center"><h3><u>',upper(tipo),'<\/u></h3></div>');
    set html=concat(html,formatArticulos(articulos));
    
	RETURN html;
END