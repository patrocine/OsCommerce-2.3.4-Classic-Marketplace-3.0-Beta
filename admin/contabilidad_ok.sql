-- phpMyAdmin SQL Dump
-- version 2.11.9.6
-- http://www.phpmyadmin.net
--
-- Servidor: localhost:3306
-- Tiempo de generación: 13-03-2013 a las 19:57:05
-- Versión del servidor: 5.0.95
-- Versión de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `admin_truecanary`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contabilidad_st`
--

DROP TABLE IF EXISTS `contabilidad_st`;
CREATE TABLE IF NOT EXISTS `contabilidad_st` (
  `id` int(11) NOT NULL auto_increment,
  `importe` decimal(15,2) NOT NULL default '0.00',
  `fianza` decimal(15,2) NOT NULL default '0.00',
  `total_presupuesto` decimal(15,2) NOT NULL default '0.00',
  `observaciones` text NOT NULL,
  `email_cliente` varchar(255) NOT NULL default '',
  `concepto` int(11) NOT NULL default '0',
  `nombre` varchar(255) NOT NULL default '',
  `telefono` varchar(255) NOT NULL default '',
  `asiento_identificativo` varchar(255) NOT NULL default '',
  `tienda` varchar(255) NOT NULL default '',
  `fecha_insercion` date NOT NULL default '0000-00-00',
  `fecha_valor` date NOT NULL default '0000-00-00',
  `fecha_modificacion` date NOT NULL default '0000-00-00',
  `tienda_conjunto` int(11) NOT NULL default '0',
  `traking` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcar la base de datos para la tabla `contabilidad_st`
--

INSERT INTO `contabilidad_st` (`id`, `importe`, `fianza`, `total_presupuesto`, `observaciones`, `email_cliente`, `concepto`, `nombre`, `telefono`, `asiento_identificativo`, `tienda`, `fecha_insercion`, `fecha_valor`, `fecha_modificacion`, `tienda_conjunto`, `traking`) VALUES
(1, 0.00, 2.00, 1.00, 'Descripcion', '', 2, 'Nombre ', 'Telefono', '', 'admin', '2013-03-13', '0000-00-00', '2013-03-13', 0, 'ST417511'),
(2, 0.00, 10.00, 30.00, 'Todo lo que queramos escribir sobre el servicio que vamos a prestar, este se suele utlizar como comprobante de algo que nos dejan en custodia, como un aparato para reparacion.', '', 1, 'Nombre del Servicio', 'Telefono de Contacto', '', 'admin', '2013-03-13', '0000-00-00', '2013-03-13', 0, 'ST372901');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contabilidad_st_conceptos`
--

DROP TABLE IF EXISTS `contabilidad_st_conceptos`;
CREATE TABLE IF NOT EXISTS `contabilidad_st_conceptos` (
  `concepto_id` int(11) NOT NULL auto_increment,
  `concepto_nombre` varchar(255) NOT NULL default '',
  `concepto_observaciones` text NOT NULL,
  `customers_st_group` int(11) NOT NULL default '0',
  PRIMARY KEY  (`concepto_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Volcar la base de datos para la tabla `contabilidad_st_conceptos`
--

INSERT INTO `contabilidad_st_conceptos` (`concepto_id`, `concepto_nombre`, `concepto_observaciones`, `customers_st_group`) VALUES
(1, 'Pendiente', 'La reparacion esta siendo reparada por nuestro servicio técnico, si esta se demora es debido a que no disponemos del repuesto y estamos a la espera de recibirlo para la reparación, en cualquier momento puede reclamarla y pasar por nuestra tienda a recogerla.', 0),
(2, 'En Tienda', 'Ya se encuentra terminado y puede pasar por nuestra tienda a recogerlo.', 0),
(3, 'Pendiente Tienda', 'Se le entrego correctamente', 0);
