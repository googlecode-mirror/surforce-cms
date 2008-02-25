-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 25, 2008 at 07:34
-- Server version: 5.0.51
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `surforce-cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `paginas_menu`
--

CREATE TABLE IF NOT EXISTS `paginas_menu` (
  `id_pagina` int(255) NOT NULL,
  `id_menu` int(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `alt` varchar(255) NOT NULL,
  PRIMARY KEY  (`id_menu`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paginas_menu`
--

INSERT INTO `paginas_menu` (`id_pagina`, `id_menu`, `link`, `titulo`, `alt`) VALUES
(6, 1, 'http://infouruguay.codigolibre.net/serron', 'Quieres saber más?', 'Link a ver más'),
(6, 2, 'http://enriqueplace.blogspot.com', 'Artículos de interés', 'más info');
