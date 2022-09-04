-- phpMyAdmin SQL Dump
-- version 2.11.9.6
-- http://www.phpmyadmin.net
--
-- Servidor: localhost:3306
-- Tiempo de generación: 26-03-2012 a las 20:34:32
-- Versión del servidor: 5.0.68
-- Versión de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `soporte_patrocinees`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `categories_id` int(11) NOT NULL auto_increment,
  `sistema_patrocine` int(1) NOT NULL default '0',
  `categories_image` varchar(64) default NULL,
  `parent_id` int(11) NOT NULL default '0',
  `sort_order` int(3) default NULL,
  `date_added` datetime default NULL,
  `last_modified` datetime default NULL,
  PRIMARY KEY  (`categories_id`),
  KEY `idx_categories_parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `categories`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories_description`
--

DROP TABLE IF EXISTS `categories_description`;
CREATE TABLE `categories_description` (
  `categories_id` int(11) NOT NULL default '0',
  `language_id` int(11) NOT NULL default '1',
  `categories_name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`categories_id`,`language_id`),
  KEY `idx_categories_name` (`categories_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `categories_description`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `products_id` int(11) NOT NULL auto_increment,
  `products_id_patrocine` varchar(255) NOT NULL default '',
  `products_url_patrocine` varchar(255) NOT NULL default '',
  `products_image_patrocine` varchar(255) NOT NULL default '',
  `sistema_patrocine` char(1) NOT NULL default '',
  `products_quantity` int(4) NOT NULL default '0',
  `products_model` varchar(255) default NULL,
  `products_image` varchar(255) default NULL,
  `products_price` decimal(15,4) NOT NULL default '0.0000',
  `products_date_added` datetime NOT NULL default '0000-00-00 00:00:00',
  `products_last_modified` datetime default NULL,
  `products_date_available` datetime default NULL,
  `products_featured` text NOT NULL,
  `products_featured_until` text NOT NULL,
  `products_weight` decimal(5,2) NOT NULL default '0.00',
  `products_extrapeso_precio` decimal(15,2) NOT NULL default '0.00',
  `products_status` tinyint(1) NOT NULL default '0',
  `products_tax_class_id` int(11) NOT NULL default '0',
  `manufacturers_id` int(11) default NULL,
  `products_ordered` int(11) NOT NULL default '0',
  `grupo_comision` int(11) NOT NULL default '1',
  `style_extra_images` int(11) NOT NULL default '1',
  `banners_affiliate` char(1) NOT NULL default '0',
  `filtro` int(2) NOT NULL default '1',
  `proveedor` varchar(255) NOT NULL default '',
  `proveedes` varchar(255) NOT NULL default '',
  `codigo_proveedor` int(11) NOT NULL default '1',
  `codigo_barras` varchar(255) NOT NULL default 'nd',
  `proveedor_price` decimal(11,2) NOT NULL default '0.00',
  `proveedor_price_general` decimal(11,2) NOT NULL default '0.00',
  `contencion` char(1) NOT NULL default '1',
  `stock_nivel` int(11) NOT NULL default '1',
  `products_regladeprecios` int(1) NOT NULL default '0',
  `regladeprecios` int(11) NOT NULL default '0',
  `time_proveedores` int(11) NOT NULL default '0',
  `time_pagado` int(11) NOT NULL default '0',
  `time_credito` int(11) NOT NULL default '0',
  `time_cobrados` int(11) NOT NULL default '0',
  `time_no_recogido` int(11) NOT NULL default '0',
  `time_pagado_transferencia` int(11) NOT NULL default '0',
  `time_paypal_enviado` int(11) NOT NULL default '0',
  `time_entregado` int(11) NOT NULL default '0',
  `time_pendiente_entrada_total` int(11) NOT NULL default '0',
  `time_entradasysalidas` int(11) NOT NULL default '0',
  `time_mercancia_entregado_procesando` int(11) NOT NULL default '0',
  `products_balance_stock` decimal(15,2) NOT NULL default '0.00',
  `products_balance_stock_control` int(11) NOT NULL default '0',
  `time_ultimaactualizacion` datetime NOT NULL default '0000-00-00 00:00:00',
  `modificar_precio_siempre` int(1) NOT NULL default '0',
  `pdf` varchar(255) NOT NULL default '',
  `priceminister` int(11) NOT NULL default '0',
  `costo` int(11) NOT NULL default '1',
  `referencia_fabricante` varchar(255) NOT NULL default '',
  `modificar_producto` int(1) NOT NULL default '1' COMMENT '1-si 0-no',
  `nobuscar` int(1) NOT NULL default '0',
  PRIMARY KEY  (`products_id`),
  KEY `stock_nivel` (`stock_nivel`),
  KEY `products_status` (`products_status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `products`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products_description`
--

DROP TABLE IF EXISTS `products_description`;
CREATE TABLE `products_description` (
  `products_id` int(11) NOT NULL auto_increment,
  `language_id` int(11) NOT NULL default '1',
  `products_name` varchar(255) NOT NULL default '',
  `products_short` text NOT NULL,
  `products_description` text,
  `products_add_1` varchar(255) NOT NULL default '',
  `products_url` varchar(255) default NULL,
  `products_viewed` int(5) default '0',
  PRIMARY KEY  (`products_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `products_description`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products_donde_esta`
--

DROP TABLE IF EXISTS `products_donde_esta`;
CREATE TABLE `products_donde_esta` (
  `id_donde_esta` int(11) NOT NULL auto_increment,
  `products_id` int(11) NOT NULL default '0',
  `products_model` varchar(255) NOT NULL default '',
  `donde_esta` varchar(255) NOT NULL default '',
  `login_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id_donde_esta`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `products_donde_esta`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products_extra_images`
--

DROP TABLE IF EXISTS `products_extra_images`;
CREATE TABLE `products_extra_images` (
  `products_extra_images_id` int(11) NOT NULL auto_increment,
  `products_id` int(11) default NULL,
  `products_extra_image` varchar(64) default NULL,
  KEY `products_extra_images_id` (`products_extra_images_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `products_extra_images`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products_groups`
--

DROP TABLE IF EXISTS `products_groups`;
CREATE TABLE `products_groups` (
  `customers_group_id` int(11) NOT NULL default '0',
  `customers_group_price` decimal(15,4) NOT NULL default '0.0000',
  `products_id` int(11) NOT NULL default '0',
  `products_price` decimal(15,4) NOT NULL default '0.0000'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `products_groups`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products_regladeprecios`
--

DROP TABLE IF EXISTS `products_regladeprecios`;
CREATE TABLE `products_regladeprecios` (
  `id_regladeprecios` int(11) NOT NULL auto_increment,
  `regladeprecios` int(11) NOT NULL default '0',
  `menor` decimal(15,2) NOT NULL default '0.00',
  `mayor` decimal(15,2) NOT NULL default '0.00',
  `porcent_value` decimal(15,2) NOT NULL default '0.00',
  PRIMARY KEY  (`id_regladeprecios`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `products_regladeprecios`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products_seguimientos_precios`
--

DROP TABLE IF EXISTS `products_seguimientos_precios`;
CREATE TABLE `products_seguimientos_precios` (
  `id` int(11) NOT NULL auto_increment,
  `fecha` date NOT NULL default '0000-00-00',
  `precio` decimal(15,2) NOT NULL default '0.00',
  `products_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `products_seguimientos_precios`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products_to_categories`
--

DROP TABLE IF EXISTS `products_to_categories`;
CREATE TABLE `products_to_categories` (
  `products_id` int(11) NOT NULL default '0',
  `categories_id` int(11) NOT NULL default '0',
  `sistema_patrocine` int(1) NOT NULL default '0',
  PRIMARY KEY  (`products_id`,`categories_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcar la base de datos para la tabla `products_to_categories`
--

