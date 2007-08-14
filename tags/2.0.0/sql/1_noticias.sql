CREATE TABLE `noticias` (
`id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`titulo` VARCHAR( 150 ) NOT NULL ,
`contenido` TEXT NOT NULL ,
`fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
`id_usuario` INT NOT NULL
) ENGINE = MYISAM ;


INSERT INTO `noticias` VALUES (1, 'primera noticia', 'cuerpo de la primera noticia', '2007-08-01 01:15:13', 1);
INSERT INTO `noticias` VALUES (3, 'tercera noticia', 'contenido de la tercera noticia', '2007-08-01 01:25:40', 0);
