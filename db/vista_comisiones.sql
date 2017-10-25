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
        ((`sistema_legislativo`.`sesion` `s`
        JOIN (SELECT 
            `sistema_legislativo`.`sesion`.`idTipoSesion` AS `idTipoSesion`,
                MIN(`sistema_legislativo`.`sesion`.`fecha`) AS `fechaProxima`
        FROM
            `sistema_legislativo`.`sesion`
        WHERE
            ((`sistema_legislativo`.`sesion`.`fecha` >= CURDATE())
                AND (`sistema_legislativo`.`sesion`.`tieneUltimoMomento` = 0))
        GROUP BY `sistema_legislativo`.`sesion`.`idTipoSesion`) `ss` ON (((`s`.`idTipoSesion` = `ss`.`idTipoSesion`)
            AND (`s`.`fecha` = `ss`.`fechaProxima`))))
        JOIN `sistema_legislativo`.`tipoSesion` `ts` ON ((`s`.`idTipoSesion` = `ts`.`idTipoSesion`)))