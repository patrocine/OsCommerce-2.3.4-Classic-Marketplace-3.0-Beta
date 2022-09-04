-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: localhost:3306
-- Tiempo de generación: 06-12-2014 a las 11:41:16
-- Versión del servidor: 5.0.95
-- Versión de PHP: 5.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `admin_angiesat`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compbuild_categories`
--

DROP TABLE IF EXISTS `compbuild_categories`;
CREATE TABLE IF NOT EXISTS `compbuild_categories` (
  `pc_category_id` int(11) NOT NULL default '0',
  `pc_depends_category_id` int(11) NOT NULL default '0',
  `pc_category_name` varchar(32) NOT NULL default '',
  `pc_category_image` varchar(32) NOT NULL default '',
  `osc_category_id` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `compbuild_categories`
--

INSERT INTO `compbuild_categories` (`pc_category_id`, `pc_depends_category_id`, `pc_category_name`, `pc_category_image`, `osc_category_id`) VALUES
(15, 0, 'MEMORIA1', 'memorias.png', 5515),
(11, 0, 'Micro Procesadores', 'micro-proc.png', 5444),
(45, 0, 'TARJETA GRAFICA', 'tarjeta-grafica.png', 942),
(20, 0, 'DISCO DURO', 'disco-duro.png', 9090),
(40, 0, 'MONITOR/LCD', 'monitores.png', 892),
(10, 0, 'PLACA BASE', 'placa-base.png', 917),
(25, 0, 'DISQUETERA', 'disquetera.png', 947),
(30, 0, 'CARCASA', 'carcasa.png', 2405),
(55, 0, 'LECTOR/GRAV DVD', 'dvd.png', 992),
(60, 0, 'TECLADO', 'teclado.png', 9096),
(65, 0, 'RATONES', 'ratones.png', 9097),
(70, 0, 'WEBCAM', 'webcam.png', 968),
(75, 0, 'ALTAVOCES', 'altavoces.png', 1083),
(80, 0, 'AURICULARES', 'auriculares.png', 1084),
(85, 0, 'IMPRESORA', 'impresora.png', 5284),
(31, 0, 'FUENTES DE ALIMENTACION', 'carcasa.png', 5567);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compbuild_dependence`
--

DROP TABLE IF EXISTS `compbuild_dependence`;
CREATE TABLE IF NOT EXISTS `compbuild_dependence` (
  `product1_id` int(11) NOT NULL default '0',
  `product2_id` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `compbuild_dependence`
--

INSERT INTO `compbuild_dependence` (`product1_id`, `product2_id`) VALUES
(39970, 46391),
(46391, 39970),
(69343, 69344);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compbuild_options`
--

DROP TABLE IF EXISTS `compbuild_options`;
CREATE TABLE IF NOT EXISTS `compbuild_options` (
  `pc_system_assembly` int(11) NOT NULL default '0',
  `pc_assembly_osccat` int(11) NOT NULL default '0',
  `pc_use_dependence` int(11) NOT NULL default '0',
  `pc_use_software` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `compbuild_options`
--

INSERT INTO `compbuild_options` (`pc_system_assembly`, `pc_assembly_osccat`, `pc_use_dependence`, `pc_use_software`) VALUES
(0, 5515, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
