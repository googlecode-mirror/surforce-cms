-- phpMyAdmin SQL Dump
-- version 2.9.2
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 03-07-2007 a las 23:48:03
-- Versión del servidor: 5.0.33
-- Versión de PHP: 5.2.1
-- 
-- Base de datos: `cms`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `usuarios`
-- 

CREATE TABLE `usuarios` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `usuario` varchar(32) collate utf8_unicode_ci NOT NULL,
  `password` varchar(32) collate utf8_unicode_ci NOT NULL,
  `nombre` varchar(40) collate utf8_unicode_ci NOT NULL,
  `apellido` varchar(40) collate utf8_unicode_ci NOT NULL,
  `mail` varchar(64) collate utf8_unicode_ci default NULL,
  `estado` int(2) NOT NULL,
  `creado` datetime NOT NULL,
  `modificado` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

-- 
-- Volcar la base de datos para la tabla `usuarios`
-- 

INSERT INTO `usuarios` VALUES (1, 'homero', 'clave', 'Homero', 'Simpson', 'homero@springfield.com', 1, '2007-07-03 21:11:50', '2007-07-03 23:32:19');
INSERT INTO `usuarios` VALUES (2, 'apu', 'clave', 'Apu', 'Nahasapeemapetilon', 'apu@springfield.com', 1, '2007-07-03 23:22:09', '2007-07-03 23:32:19');
INSERT INTO `usuarios` VALUES (3, 'moe', 'clave', 'Moe', 'Szyslak', 'moe@springfield.com', 1, '2007-07-03 23:22:09', '2007-07-03 23:22:09');
INSERT INTO `usuarios` VALUES (4, 'montgomery', 'clave', 'Montgomery', 'Burns', 'montgomery@springfield.com', 0, '2007-07-03 23:25:26', '2007-07-03 23:25:26');
INSERT INTO `usuarios` VALUES (5, 'kent', 'clave', 'Kent', 'Brockman', 'kent@springfield.com', 1, '2007-07-03 23:25:26', '2007-07-03 23:25:26');
