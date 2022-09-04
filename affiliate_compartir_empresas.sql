-- phpMyAdmin SQL Dump
-- version 2.11.9.6
-- http://www.phpmyadmin.net
--
-- Servidor: localhost:3306
-- Tiempo de generación: 19-05-2013 a las 00:40:59
-- Versión del servidor: 5.0.95
-- Versión de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `admin_eleconomato`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `affiliate_compartir_empresas`
--

DROP TABLE IF EXISTS `affiliate_compartir_empresas`;
CREATE TABLE IF NOT EXISTS `affiliate_compartir_empresas` (
  `id_banners` int(11) NOT NULL auto_increment,
  `url_empresa_catalog` varchar(255) NOT NULL default 'http://',
  `numero_productos` int(2) NOT NULL default '1',
  `nombre` varchar(255) NOT NULL default '',
  `url_web` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  KEY `id` (`id_banners`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Volcar la base de datos para la tabla `affiliate_compartir_empresas`
--

INSERT INTO `affiliate_compartir_empresas` (`id_banners`, `url_empresa_catalog`, `numero_productos`, `nombre`, `url_web`, `email`) VALUES
(18, 'http://www.radioservicio.com/affiliate_banners_products.php?pro_ale=', 5, 'radio servicio tenerife.s.l', 'http://www.radioservicio.com', 'rstenerife@gmail.com'),
(6, 'http://www.solominibike.com/affiliate_banners_products.php?pro_ale=', 5, 'SOLOMINIBIKE', 'www.solominibike.com', 'solominibike@gmail.com'),
(7, 'http://www.truecanary.es/affiliate_banners_products.php?pro_ale=', 5, 'TrueCanary', 'www.truecanary.es', 'truecanary@gmail.com'),
(29, 'http://www.elclam.es/affiliate_banners_products.php?pro_ale=', 5, 'ElClam', 'www.elclam.es', 'elclames@gmail.com'),
(33, 'http://www.eleconomato.es/affiliate_banners_products.php?pro_ale=', 5, 'ELeconomato', 'www.eleconomato.es', 'eleconomatoes@gmail.com'),
(27, 'http://www.tualoecanario.com/affiliate_banners_products.php?pro_ale=', 5, 'TuAloeCanario', 'www.tualoecanario.com', 'tualoevera100@gmail.com'),
(28, 'http://www.euroconsolas.com/euroconsolas/spain/affiliate_banners_products.php?pro_ale=', 5, 'EuroConsolas', 'www.euroconsolas.com', 'euroconsolas@gmail.com'),
(26, 'http://www.boncasacandelaria.es/affiliate_banners_products.php?pro_ale=', 5, 'Boncasa', 'www.boncasacandelaria.es', 'boncasa.es@hotmail.com, patrocinees@gmail.com'),
(31, 'http://www.eroticsecrets.net/affiliate_banners_products.php?pro_ale=', 5, 'eroticsecrets.net', 'www.eroticsecrets.net', 'eroticsecretsnet@gmail.com'),
(32, 'http://www.tumundoportable.com/affiliate_banners_products.php?pro_ale=', 5, 'TuMundoPortable', 'www.tumundoportable.com', 'cermaicoat@hotmail.com');
