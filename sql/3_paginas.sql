CREATE TABLE `paginas` (
`id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`titulo` VARCHAR( 150 ) NOT NULL ,
`contenido` TEXT NOT NULL ,
`fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
`id_usuario` INT NOT NULL
) ENGINE = MYISAM ;


INSERT INTO `paginas` VALUES (1, 'pagina1', 'cuerpo de la primera pagina', '2007-08-01 01:15:13', 1);
INSERT INTO `paginas` VALUES (3, 'pagina2', 'contenido de la segunda pagina', '2007-08-01 01:25:40', 0);
