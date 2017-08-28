CREATE DEFINER=`root`@`localhost` FUNCTION `conformarDictamenArticulado`(texto text,articulos text,tipo varchar(45)) RETURNS text CHARSET utf8mb4
BEGIN
	
    declare html text default '';
	set html=concat(html,formatParrafo(texto));
    set html=concat(html,'<div style="text-align:center"><h3>',upper(tipo),'</h3></div>');
    set html=concat(html,formatArticulos(articulos));
    
	RETURN html;
END