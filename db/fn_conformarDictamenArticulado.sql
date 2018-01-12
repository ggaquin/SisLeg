CREATE DEFINER=`root`@`localhost` FUNCTION `conformarDictamenArticulado`(texto text,articulos text,tipo varchar(45)) RETURNS text CHARSET utf8mb4
BEGIN
	
    declare html text default '';
	set html=concat(html,formatParrafo(texto));
    set html=concat(html,'<h5>',upper(tipo),'</h5>');
    set html=concat(html,formatArticulos(articulos));
    
    select replace(html,'<br>','<p></p>') into html;
    
	RETURN html;
END