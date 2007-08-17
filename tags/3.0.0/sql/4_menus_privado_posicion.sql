ALTER TABLE `menu` ADD `posicion` SMALLINT(4) NOT NULL DEFAULT '0' AFTER `destino`;
ALTER TABLE `menu` ADD `privado` CHAR(1) NOT NULL DEFAULT '1' AFTER `posicion`;