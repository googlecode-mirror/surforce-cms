
DROP TABLE IF EXISTS `styles_propiedades`;
CREATE TABLE `styles_propiedades` (
  `id_propiedad` int(11) NOT NULL auto_increment,
  `propiedad` varchar(32) collate latin1_general_ci NOT NULL,
  PRIMARY KEY  (`id_propiedad`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=122 ;

--
-- Volcar la base de datos para la tabla `styles_propiedades`
--

INSERT INTO `styles_propiedades` VALUES (1, 'azimuth');
INSERT INTO `styles_propiedades` VALUES (2, 'background');
INSERT INTO `styles_propiedades` VALUES (3, 'background-attachment');
INSERT INTO `styles_propiedades` VALUES (4, 'background-color');
INSERT INTO `styles_propiedades` VALUES (5, 'background-image');
INSERT INTO `styles_propiedades` VALUES (6, 'background-position');
INSERT INTO `styles_propiedades` VALUES (7, 'background-repeat');
INSERT INTO `styles_propiedades` VALUES (8, 'border');
INSERT INTO `styles_propiedades` VALUES (9, 'border-collapse');
INSERT INTO `styles_propiedades` VALUES (10, 'border-color');
INSERT INTO `styles_propiedades` VALUES (11, 'border-spacing');
INSERT INTO `styles_propiedades` VALUES (12, 'border-style');
INSERT INTO `styles_propiedades` VALUES (13, 'border-top');
INSERT INTO `styles_propiedades` VALUES (14, 'border-right');
INSERT INTO `styles_propiedades` VALUES (15, 'border-bottom');
INSERT INTO `styles_propiedades` VALUES (16, 'border-left');
INSERT INTO `styles_propiedades` VALUES (17, 'border-right-color');
INSERT INTO `styles_propiedades` VALUES (18, 'border-top-color');
INSERT INTO `styles_propiedades` VALUES (19, 'border-bottom-color');
INSERT INTO `styles_propiedades` VALUES (20, 'border-left-color');
INSERT INTO `styles_propiedades` VALUES (21, 'border-top-style');
INSERT INTO `styles_propiedades` VALUES (22, 'border-right-style');
INSERT INTO `styles_propiedades` VALUES (23, 'border-bottom-style');
INSERT INTO `styles_propiedades` VALUES (24, 'border-left-style');
INSERT INTO `styles_propiedades` VALUES (25, 'border-top-width');
INSERT INTO `styles_propiedades` VALUES (26, 'border-right-width');
INSERT INTO `styles_propiedades` VALUES (27, 'border-bottom-width');
INSERT INTO `styles_propiedades` VALUES (28, 'border-left-width');
INSERT INTO `styles_propiedades` VALUES (29, 'border-width');
INSERT INTO `styles_propiedades` VALUES (30, 'bottom');
INSERT INTO `styles_propiedades` VALUES (31, 'caption-side');
INSERT INTO `styles_propiedades` VALUES (32, 'clear');
INSERT INTO `styles_propiedades` VALUES (33, 'clip');
INSERT INTO `styles_propiedades` VALUES (34, 'color');
INSERT INTO `styles_propiedades` VALUES (35, 'content');
INSERT INTO `styles_propiedades` VALUES (36, 'counter-increment');
INSERT INTO `styles_propiedades` VALUES (37, 'counter-reset');
INSERT INTO `styles_propiedades` VALUES (38, 'cue');
INSERT INTO `styles_propiedades` VALUES (39, 'cue-after');
INSERT INTO `styles_propiedades` VALUES (40, 'cue-before');
INSERT INTO `styles_propiedades` VALUES (41, 'cursor');
INSERT INTO `styles_propiedades` VALUES (42, 'direction');
INSERT INTO `styles_propiedades` VALUES (43, 'display');
INSERT INTO `styles_propiedades` VALUES (44, 'elevation');
INSERT INTO `styles_propiedades` VALUES (45, 'empty-cells');
INSERT INTO `styles_propiedades` VALUES (46, 'float');
INSERT INTO `styles_propiedades` VALUES (47, 'font');
INSERT INTO `styles_propiedades` VALUES (48, 'font-family');
INSERT INTO `styles_propiedades` VALUES (49, 'font-size');
INSERT INTO `styles_propiedades` VALUES (50, 'font-size-adjust');
INSERT INTO `styles_propiedades` VALUES (51, 'font-stretch');
INSERT INTO `styles_propiedades` VALUES (52, 'font-style');
INSERT INTO `styles_propiedades` VALUES (53, 'font-variant');
INSERT INTO `styles_propiedades` VALUES (54, 'heightfont-weight');
INSERT INTO `styles_propiedades` VALUES (55, 'left');
INSERT INTO `styles_propiedades` VALUES (56, 'letter-spacing');
INSERT INTO `styles_propiedades` VALUES (57, 'line-height');
INSERT INTO `styles_propiedades` VALUES (58, 'list-style');
INSERT INTO `styles_propiedades` VALUES (59, 'list-style-image');
INSERT INTO `styles_propiedades` VALUES (60, 'list-style-position');
INSERT INTO `styles_propiedades` VALUES (61, 'list-style-type');
INSERT INTO `styles_propiedades` VALUES (62, 'margin');
INSERT INTO `styles_propiedades` VALUES (63, 'margin-top');
INSERT INTO `styles_propiedades` VALUES (64, 'margin-right');
INSERT INTO `styles_propiedades` VALUES (65, 'margin-bottom');
INSERT INTO `styles_propiedades` VALUES (66, 'margin-left');
INSERT INTO `styles_propiedades` VALUES (67, 'marker-offset');
INSERT INTO `styles_propiedades` VALUES (68, 'marks');
INSERT INTO `styles_propiedades` VALUES (69, 'max-height');
INSERT INTO `styles_propiedades` VALUES (70, 'max-width');
INSERT INTO `styles_propiedades` VALUES (71, 'min-height');
INSERT INTO `styles_propiedades` VALUES (72, 'min-width');
INSERT INTO `styles_propiedades` VALUES (73, 'orphans');
INSERT INTO `styles_propiedades` VALUES (74, 'outline');
INSERT INTO `styles_propiedades` VALUES (75, 'outline-color');
INSERT INTO `styles_propiedades` VALUES (76, 'outline-style');
INSERT INTO `styles_propiedades` VALUES (77, 'outline-width');
INSERT INTO `styles_propiedades` VALUES (78, 'overflow');
INSERT INTO `styles_propiedades` VALUES (79, 'padding');
INSERT INTO `styles_propiedades` VALUES (80, 'padding-top');
INSERT INTO `styles_propiedades` VALUES (81, 'padding-right');
INSERT INTO `styles_propiedades` VALUES (82, 'padding-bottom');
INSERT INTO `styles_propiedades` VALUES (83, 'padding-left');
INSERT INTO `styles_propiedades` VALUES (84, 'page');
INSERT INTO `styles_propiedades` VALUES (85, 'page-break-after');
INSERT INTO `styles_propiedades` VALUES (86, 'page-break-before');
INSERT INTO `styles_propiedades` VALUES (87, 'age-break-inside');
INSERT INTO `styles_propiedades` VALUES (88, 'pause');
INSERT INTO `styles_propiedades` VALUES (89, 'pause-after');
INSERT INTO `styles_propiedades` VALUES (90, 'pause-before');
INSERT INTO `styles_propiedades` VALUES (91, 'pitch');
INSERT INTO `styles_propiedades` VALUES (92, 'pitch-range');
INSERT INTO `styles_propiedades` VALUES (93, 'play-during');
INSERT INTO `styles_propiedades` VALUES (94, 'position');
INSERT INTO `styles_propiedades` VALUES (95, 'quotes');
INSERT INTO `styles_propiedades` VALUES (96, 'richness');
INSERT INTO `styles_propiedades` VALUES (97, 'right');
INSERT INTO `styles_propiedades` VALUES (98, 'size');
INSERT INTO `styles_propiedades` VALUES (99, 'speak');
INSERT INTO `styles_propiedades` VALUES (100, 'speak-header');
INSERT INTO `styles_propiedades` VALUES (101, 'speak-numeral');
INSERT INTO `styles_propiedades` VALUES (102, 'speak-punctuation');
INSERT INTO `styles_propiedades` VALUES (103, 'speech-rate');
INSERT INTO `styles_propiedades` VALUES (104, 'tress');
INSERT INTO `styles_propiedades` VALUES (105, 'table-layout');
INSERT INTO `styles_propiedades` VALUES (106, 'text-align');
INSERT INTO `styles_propiedades` VALUES (107, 'text-decoration');
INSERT INTO `styles_propiedades` VALUES (108, 'text-indent');
INSERT INTO `styles_propiedades` VALUES (109, 'text-shadow');
INSERT INTO `styles_propiedades` VALUES (110, 'text-transform');
INSERT INTO `styles_propiedades` VALUES (111, 'top');
INSERT INTO `styles_propiedades` VALUES (112, 'unicode-bidi');
INSERT INTO `styles_propiedades` VALUES (113, 'vertical-align');
INSERT INTO `styles_propiedades` VALUES (114, 'visibility');
INSERT INTO `styles_propiedades` VALUES (115, 'voice-family');
INSERT INTO `styles_propiedades` VALUES (116, 'volume');
INSERT INTO `styles_propiedades` VALUES (117, 'white-space');
INSERT INTO `styles_propiedades` VALUES (118, 'widows');
INSERT INTO `styles_propiedades` VALUES (119, 'width');
INSERT INTO `styles_propiedades` VALUES (120, 'word-spacing');
INSERT INTO `styles_propiedades` VALUES (121, 'z-index');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `styles_propiedades_x_selectores`
--

DROP TABLE IF EXISTS `styles_propiedades_x_selectores`;
CREATE TABLE `styles_propiedades_x_selectores` (
  `id_selector` int(11) NOT NULL,
  `id_propiedad` int(11) NOT NULL,
  `valor` varchar(64) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id_selector`,`id_propiedad`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Volcar la base de datos para la tabla `styles_propiedades_x_selectores`
--

INSERT INTO `styles_propiedades_x_selectores` VALUES (1, 62, '5px');
INSERT INTO `styles_propiedades_x_selectores` VALUES (1, 48, 'Verdana, Arial, Helvetica, sans-serif');
INSERT INTO `styles_propiedades_x_selectores` VALUES (1, 49, '11px');
INSERT INTO `styles_propiedades_x_selectores` VALUES (2, 49, '22px');
INSERT INTO `styles_propiedades_x_selectores` VALUES (3, 62, '0 auto');
INSERT INTO `styles_propiedades_x_selectores` VALUES (4, 66, '10px');
INSERT INTO `styles_propiedades_x_selectores` VALUES (4, 79, '0');
INSERT INTO `styles_propiedades_x_selectores` VALUES (5, 46, 'left');
INSERT INTO `styles_propiedades_x_selectores` VALUES (5, 78, 'hidden');
INSERT INTO `styles_propiedades_x_selectores` VALUES (5, 119, '150px');
INSERT INTO `styles_propiedades_x_selectores` VALUES (6, 16, '1px solid #CCCCCC');
INSERT INTO `styles_propiedades_x_selectores` VALUES (6, 46, 'left');
INSERT INTO `styles_propiedades_x_selectores` VALUES (6, 79, '15px');
INSERT INTO `styles_propiedades_x_selectores` VALUES (6, 119, '550px');
INSERT INTO `styles_propiedades_x_selectores` VALUES (7, 13, '1px solid #CCCCCC');
INSERT INTO `styles_propiedades_x_selectores` VALUES (7, 32, 'both');
INSERT INTO `styles_propiedades_x_selectores` VALUES (7, 106, 'center');
INSERT INTO `styles_propiedades_x_selectores` VALUES (7, 119, '100%');
INSERT INTO `styles_propiedades_x_selectores` VALUES (8, 4, '#CCCC00');
INSERT INTO `styles_propiedades_x_selectores` VALUES (8, 79, '0 3px 0 3px');
INSERT INTO `styles_propiedades_x_selectores` VALUES (9, 14, '1px solid #f0f0f0');
INSERT INTO `styles_propiedades_x_selectores` VALUES (9, 15, '1px solid #f0f0f0');
INSERT INTO `styles_propiedades_x_selectores` VALUES (9, 79, '2px');
INSERT INTO `styles_propiedades_x_selectores` VALUES (10, 43, 'block');
INSERT INTO `styles_propiedades_x_selectores` VALUES (10, 46, 'left');
INSERT INTO `styles_propiedades_x_selectores` VALUES (10, 106, 'right');
INSERT INTO `styles_propiedades_x_selectores` VALUES (10, 119, '150px');
INSERT INTO `styles_propiedades_x_selectores` VALUES (11, 66, '100px');
INSERT INTO `styles_propiedades_x_selectores` VALUES (12, 34, '#FF0000');
INSERT INTO `styles_propiedades_x_selectores` VALUES (12, 62, '10px');
INSERT INTO `styles_propiedades_x_selectores` VALUES (13, 119, '205px');
INSERT INTO `styles_propiedades_x_selectores` VALUES (14, 46, 'right');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `styles_selectores`
--

DROP TABLE IF EXISTS `styles_selectores`;
CREATE TABLE `styles_selectores` (
  `id_selector` int(11) NOT NULL auto_increment,
  `selector` varchar(64) collate latin1_general_ci NOT NULL,
  `descripcion` varchar(255) collate latin1_general_ci default NULL,
  PRIMARY KEY  (`id_selector`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=17 ;

--
-- Volcar la base de datos para la tabla `styles_selectores`
--

INSERT INTO `styles_selectores` VALUES (1, 'BODY', 'Cuerpo principal de la pagina.');
INSERT INTO `styles_selectores` VALUES (2, 'H1', 'Titulos');
INSERT INTO `styles_selectores` VALUES (3, 'DIV#contenedor', '');
INSERT INTO `styles_selectores` VALUES (4, 'DIV#menu ul, DIV#menu li', '');
INSERT INTO `styles_selectores` VALUES (5, 'DIV#menu', '');
INSERT INTO `styles_selectores` VALUES (6, 'DIV#contenido', '');
INSERT INTO `styles_selectores` VALUES (7, 'DIV#pie', '');
INSERT INTO `styles_selectores` VALUES (8, 'TH', '');
INSERT INTO `styles_selectores` VALUES (9, 'TD', '');
INSERT INTO `styles_selectores` VALUES (10, 'label', '');
INSERT INTO `styles_selectores` VALUES (11, 'DIV#formbutton', '');
INSERT INTO `styles_selectores` VALUES (12, 'DIV#mensaje', '');
INSERT INTO `styles_selectores` VALUES (13, 'DIV#boton_formulario', '');
INSERT INTO `styles_selectores` VALUES (14, 'DIV#boton_formulario INPUT', 'Botones de formularios');
INSERT INTO `styles_selectores` VALUES (15, 'DIV#logueado', NULL);
