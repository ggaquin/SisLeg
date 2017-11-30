CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `vw_sesiones_habiles` AS
    SELECT 
        `s`.`idSesion` AS `idSesion`,
        CONCAT(CONVERT( CAST(DATE_FORMAT(`s`.`fecha`, '%d/%m/%Y') AS CHAR (10) CHARSET UTF8) USING UTF8MB4),
                ' (',
                `ts`.`abreviacion`,
                ')') AS `descripcion`
    FROM
        (`sesion` `s`
        JOIN `tipoSesion` `ts` ON ((`s`.`idTipoSesion` = `ts`.`idTipoSesion`)))
    WHERE
        ((`s`.`fecha` >= CURDATE())
            AND (`s`.`tieneUltimoMomento` = 0))
    ORDER BY `s`.`fecha`
    LIMIT 6