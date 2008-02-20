CREATE TABLE `configuracion` (
  `id` int(10) NOT NULL,
  `sitio_titulo` varchar(200) collate utf8_spanish_ci NOT NULL,
  `sitio_titulo_color` varchar(10) collate utf8_spanish_ci NOT NULL,
  `sitio_color_fondo` varchar(10) collate utf8_spanish_ci NOT NULL,
  `sitio_color_cabezal` varchar(10) collate utf8_spanish_ci NOT NULL,
  `sitio_color_pie` varchar(10) collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcar la base de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `sitio_titulo`, `sitio_titulo_color`, `sitio_color_fondo`, `sitio_color_cabezal`, `sitio_color_pie`) VALUES
(1, 'Nuevo título', '#FFFFFF', 'white', 'green', 'yellow');