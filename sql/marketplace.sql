-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 07-12-2022 a las 09:22:23
-- Versión del servidor: 5.6.51-cll-lve
-- Versión de PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bu23ef02_tecno`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `affiliate_compartir_empresas`
--

DROP TABLE IF EXISTS `affiliate_compartir_empresas`;
CREATE TABLE IF NOT EXISTS `affiliate_compartir_empresas` (
  `id_banners` int(11) NOT NULL AUTO_INCREMENT,
  `url_empresa_catalog` varchar(255) NOT NULL DEFAULT 'http://',
  `url_enlace` varchar(255) NOT NULL,
  `numero_productos` int(2) NOT NULL DEFAULT '1',
  `nombre` varchar(255) NOT NULL DEFAULT '',
  `url_web` varchar(255) NOT NULL DEFAULT '',
  `url_affiliate` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `aut` int(11) NOT NULL,
  `epigrafe_sector` varchar(244) NOT NULL DEFAULT 'inactivo',
  `nombre_sector` varchar(255) NOT NULL,
  `nombre_ciudad` varchar(54) NOT NULL,
  `desactivar` int(1) NOT NULL DEFAULT '1',
  KEY `id` (`id_banners`)
) ENGINE=MyISAM AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `affiliate_compartir_empresas`
--

INSERT INTO `affiliate_compartir_empresas` (`id_banners`, `url_empresa_catalog`, `url_enlace`, `numero_productos`, `nombre`, `url_web`, `url_affiliate`, `email`, `aut`, `epigrafe_sector`, `nombre_sector`, `nombre_ciudad`, `desactivar`) VALUES
(93, 'https://elcogollo2.com/affiliate_banners_products.php?pro_ale=', 'https://elcogollo2.com/enlace.php', 10, 'El Cogollo 2', 'https://elcogollo2.com/', '', 'marinsweed@gmail.com', 1, 'inactivo', 'Grow Shop', 'San Isidro, Granadilla', 1),
(94, 'https://insideseed.es/affiliate_banners_products.php?pro_ale=', 'https://insideseed.es/enlace.php', 10, 'Insideseed', 'https://insideseed.es/', '', 'simervimportacion@gmail.com', 1, 'inactivo', 'Grow Shop', 'San Isidro, Granadilla', 1),
(75, 'https://tasmaniapetshop.es/affiliate_banners_products.php?pro_ale=', 'https://tasmaniapetshop.es/enlace.php', 10, 'Tasmania Pet Shop', 'https://tasmaniapetshop.es/', 'https://tasmaniapetshop.es/index.php?ref=1', 'tasmaniadvilshop@hotmail.es', 1, 'inactivo', 'Animales', 'Granadilla Pueblo', 1),
(99, 'https://theovergrown.es/affiliate_banners_products.php?pro_ale=', 'https://theovergrown.es/enlace.php', 1, 'The Over Grow', 'https://theovergrown.es/', 'https://theovergrown.es/index.php?ref=1', 'email@gmail.com', 1, 'inactivo', 'Grow Shop', 'Los Majuelos', 1),
(92, 'https://masko.es/affiliate_banners_products.php?pro_ale=', 'https://masko.es/enlace.php', 10, 'Maskot', 'https://masko.es/', 'https://masko.es/index.php?ref=1', 'maskotenerife@gmail.com', 1, 'inactivo', 'Animales', 'La Orotava', 1),
(101, 'https://amanova.me/affiliate_banners_products.php?pro_ale=', 'https://amanova.me/enlace.php', 10, 'AMANOVA', 'https://amanova.me/', 'https://amanova.me/index.php?ref=1', 'email@gmail.com', 1, 'inactivo', 'Animales', 'SPAIN', 1),
(103, 'https://lumatek.es/affiliate_banners_products.php?pro_ale=', 'https://lumatek.es/enlace.php', 10, 'Lumatek Tienda Oficial Spain', 'https://lumatek.es/', 'https://lumatek.es/index.php?ref=1', 'email@gmail.com', 1, 'inactivo', 'Grow Shop', 'SPAIN', 1),
(104, 'https://ownat.store/affiliate_banners_products.php?pro_ale=', 'https://ownat.store/enlace.php', 10, 'OWNAT', 'https://ownat.store/', 'https://ownat.store/index.php?ref=1', 'email@gmail.com', 1, 'inactivo', 'Animales', 'SPAIN', 1),
(105, 'https://qic.es/affiliate_banners_products.php?pro_ale=', 'https://qic.es/enlace.php', 10, 'Qic Informatica', 'https://qic.es/', 'https://qic.es/index.php?ref=1', 'tasmaniadvilshop@hotmail.es', 1, 'inactivo', 'Informatica', 'Tenerife', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marketplace`
--

DROP TABLE IF EXISTS `marketplace`;
CREATE TABLE IF NOT EXISTS `marketplace` (
  `categories_id` int(11) NOT NULL AUTO_INCREMENT,
  `sistema_patrocine` int(1) NOT NULL DEFAULT '0',
  `categories_image` varchar(64) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `sort_order` int(3) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `last_modified` datetime DEFAULT NULL,
  `categories_time` int(50) NOT NULL,
  `categories_productos` int(11) NOT NULL,
  `categories_status` int(1) NOT NULL,
  `categories_marketplace` int(1) NOT NULL,
  PRIMARY KEY (`categories_id`),
  KEY `idx_categories_parent_id` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=100000016 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `marketplace`
--

INSERT INTO `marketplace` (`categories_id`, `sistema_patrocine`, `categories_image`, `parent_id`, `sort_order`, `date_added`, `last_modified`, `categories_time`, `categories_productos`, `categories_status`, `categories_marketplace`) VALUES
(99999999, 0, NULL, 0, NULL, NULL, NULL, 1670234910, 0, 0, 0),
(100000000, 0, NULL, 0, 0, '2022-12-05 06:32:39', NULL, 1670438392, 0, 0, 0),
(100000001, 0, NULL, 0, 0, '2022-12-05 06:33:11', NULL, 1670483009, 0, 0, 0),
(100000002, 0, NULL, 0, 0, '2022-12-05 06:33:37', NULL, 1670424839, 0, 0, 0),
(100000003, 0, 'https://qic.es/images/store_logo.png', 100000002, 0, '2022-12-05 06:34:15', NULL, 1670427831, 0, 0, 0),
(100000004, 0, 'https://elcogollo2.com/images/store_logo.png', 100000000, 0, '2022-12-05 07:40:56', NULL, 1670380828, 0, 0, 0),
(100000005, 0, 'https://theovergrown.es/images/store_logo.png', 100000000, 0, '2022-12-05 07:41:38', NULL, 1670404987, 0, 0, 0),
(100000006, 0, 'https://tasmaniapetshop.es/images/store_logo.png', 100000001, 0, '2022-12-05 07:42:02', NULL, 1670402743, 0, 0, 0),
(100000007, 0, 'https://masko.es/images/store_logo.png', 100000001, 0, '2022-12-05 07:42:41', NULL, 1670457645, 0, 0, 0),
(100000009, 0, 'https://ownat.empresa30.es/images/store_logo.png', 100000001, 2, '2022-12-05 09:32:54', NULL, 1670453147, 0, 0, 0),
(100000010, 0, 'https://amanova.me/images/store_logo.png', 100000001, 2, '2022-12-05 09:33:08', NULL, 1670407924, 0, 0, 0),
(100000011, 0, 'https://royalcanin.website/images/store_logo.png', 100000001, 2, '2022-12-05 09:33:21', NULL, 1670461906, 0, 0, 0),
(100000012, 0, 'https://optimanova.online/images/store_logo.png', 100000001, 2, '2022-12-05 09:33:52', NULL, 1670426753, 0, 0, 0),
(100000013, 0, 'https://lumatek.es/images/store_logo.png', 100000000, 2, '2022-12-05 09:52:08', NULL, 1670422002, 0, 0, 0),
(100000014, 0, NULL, 0, 3, '2022-12-05 14:48:50', NULL, 1670445024, 0, 0, 0),
(100000015, 0, 'https://insideseed.es/images/store_logo.png', 100000000, 0, '2022-12-07 09:07:31', NULL, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marketplace_description`
--

DROP TABLE IF EXISTS `marketplace_description`;
CREATE TABLE IF NOT EXISTS `marketplace_description` (
  `categories_id` int(11) NOT NULL DEFAULT '0',
  `language_id` int(11) NOT NULL DEFAULT '1',
  `categories_name` varchar(255) NOT NULL DEFAULT '',
  `categories_name_suple` varchar(255) NOT NULL,
  `categories_name_http` varchar(255) NOT NULL,
  `categories_name_http_mobil` varchar(244) NOT NULL,
  `categories_status_visible` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`categories_id`,`language_id`),
  KEY `idx_categories_name` (`categories_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `marketplace_description`
--

INSERT INTO `marketplace_description` (`categories_id`, `language_id`, `categories_name`, `categories_name_suple`, `categories_name_http`, `categories_name_http_mobil`, `categories_status_visible`) VALUES
(100000004, 1, 'San Isidro, El Cogollo 2', '', 'https://elcogollo2.com/', 'https://elcogollo2.com/', 1),
(100000000, 1, 'GROW SHOP', '', '/-c-100000000.html', '/-c-100000000.html', 1),
(100000001, 1, 'TIENDA DE ANIMALES', '', '/-c-100000001.html', '/-c-100000001.html', 1),
(100000002, 1, 'INFORMATICA', '', '/-c-100000002.html', '/-c-100000002.html', 1),
(100000003, 1, 'Tenerife, Qic.es', '', 'https://qic.es', 'https://qic.es', 1),
(100000005, 1, 'Los Majuelos, The Over Grown', '', 'https://theovergrown.es/', 'https://theovergrown.es/', 1),
(100000006, 1, 'Granadilla, Tasmina PetShop', '', 'https://tasmaniapetshop.es/', 'https://tasmaniapetshop.es/', 1),
(100000007, 1, 'La Orotava, Makot', '', 'https://masko.es/', 'https://masko.es/', 1),
(100000009, 1, 'OWNAT', '', 'https://ownat.store/', 'https://ownat.store/', 1),
(100000010, 1, 'AMANOVA', '', 'https://amanova.me/', 'https://amanova.me/', 1),
(100000011, 1, 'ROYAL CANIN', '', 'https://royalcanin.website/', 'https://royalcanin.website/', 1),
(100000012, 1, 'OPTIMA NOVA', '', 'https://optimanova.online/', 'https://optimanova.online/', 1),
(100000013, 1, 'LUMATEK', '', 'https://lumatek.es/', 'https://lumatek.es/', 1),
(100000014, 1, 'Añadir Tienda', '', 'https://walink.co/0430c5', 'https://walink.co/0430c5', 1),
(100000015, 1, 'San Isidro, Inside Seed', '', 'https://insideseed.es/', '', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
