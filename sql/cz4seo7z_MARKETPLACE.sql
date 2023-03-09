-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 09-03-2023 a las 23:57:29
-- Versión del servidor: 5.7.36-cll-lve
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cz4seo7z_deliciaitaliana`
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
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `affiliate_compartir_empresas`
--

INSERT INTO `affiliate_compartir_empresas` (`id_banners`, `url_empresa_catalog`, `url_enlace`, `numero_productos`, `nombre`, `url_web`, `url_affiliate`, `email`, `aut`, `epigrafe_sector`, `nombre_sector`, `nombre_ciudad`, `desactivar`) VALUES
(93, 'https://elcogollo2.com/affiliate_banners_products.php?pro_ale=', 'https://elcogollo2.com/enlace.php', 10, 'El Cogollo 2', 'https://elcogollo2.com/', 'https://elcogollo2.com/index.php?ref=1', 'marinsweed@gmail.com', 1, '100000000', 'Grow Shop', 'San Isidro, Granadilla', 1),
(75, 'https://tasmaniapetshop.es/affiliate_banners_products.php?pro_ale=', 'https://tasmaniapetshop.es/enlace.php', 10, 'Tasmania Pet Shop', 'https://tasmaniapetshop.es/', 'https://tasmaniapetshop.es/index.php?ref=1', 'tasmaniadvilshop@hotmail.es', 1, '100000001', 'Animales', 'Granadilla Pueblo', 1),
(105, 'https://qic.es/affiliate_banners_products.php?pro_ale=', 'https://qic.es/enlace.php', 10, 'Qic Informatica', 'https://qic.es/', 'https://qic.es/index.php?ref=1', 'tasmaniadvilshop@hotmail.es', 1, '6597', 'Informatica', 'Tenerife', 1),
(109, 'https://deliciaitaliana.com/affiliate_banners_products.php?pro_ale=', 'https://deliciaitaliana.com/enlace.php', 10, 'Delicias Italianas', 'https://deliciaitaliana.com/', 'https://deliciaitaliana.com/index.php?ref=1', 'deliciaitalianaes@gmail.com', 1, '100000017', 'Alimentación', 'San Isidro', 1),
(111, 'https://srmarihuano.es/affiliate_banners_products.php?pro_ale=', 'https://srmarihuano.es/enlace.php', 10, 'Sr.Marihuano', 'https://srmarihuano.es/', 'https://srmarihuano.es/index.php?ref=1', 'clubgrowes@gmail.com', 1, '100000000', 'Grow Shop', 'Granadilla de Abona', 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=100000022 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `marketplace`
--

INSERT INTO `marketplace` (`categories_id`, `sistema_patrocine`, `categories_image`, `parent_id`, `sort_order`, `date_added`, `last_modified`, `categories_time`, `categories_productos`, `categories_status`, `categories_marketplace`) VALUES
(99999999, 0, NULL, 0, NULL, NULL, NULL, 1670234910, 0, 0, 0),
(100000000, 0, NULL, 0, 0, '2022-12-05 06:32:39', NULL, 1678373064, 0, 0, 0),
(100000001, 0, NULL, 0, 0, '2022-12-05 06:33:11', NULL, 1678362702, 0, 0, 0),
(100000002, 0, NULL, 0, 0, '2022-12-05 06:33:37', NULL, 1678366784, 0, 0, 0),
(100000003, 0, 'https://qic.es/images/store_logo.png', 100000002, 0, '2022-12-05 06:34:15', NULL, 1678328386, 0, 0, 0),
(100000004, 0, 'https://elcogollo2.com/images/store_logo.png', 100000000, 0, '2022-12-05 07:40:56', NULL, 1678433348, 0, 0, 0),
(100000021, 0, 'https://srmarihuano.es/images/store_logo.png', 100000000, 0, '2023-03-01 17:42:42', NULL, 1678387857, 0, 0, 0),
(100000006, 0, 'https://tasmaniapetshop.es/images/store_logo.png', 100000001, 0, '2022-12-05 07:42:02', NULL, 1678286295, 0, 0, 0),
(100000017, 0, NULL, 0, 0, '2023-01-13 06:44:53', NULL, 1678082142, 0, 0, 0),
(100000018, 0, 'https://deliciaitaliana.com/images/store_logo.png', 100000017, 0, '2023-01-13 06:45:46', NULL, 1678015187, 0, 0, 0),
(100000016, 0, NULL, 0, 3, '2022-12-18 14:51:50', NULL, 1678337941, 0, 0, 0),
(100000019, 0, NULL, 0, 0, '2023-02-17 21:20:05', NULL, 1678406131, 0, 0, 0),
(100000020, 0, 'https://vainillachocolate.enterprise30.es/images/store_logo.png', 100000019, 0, '2023-02-17 23:59:57', NULL, 1678427082, 0, 0, 0);

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
(100000006, 1, 'Granadilla, Tasmina PetShop', '', 'https://tasmaniapetshop.es/', 'https://tasmaniapetshop.es/', 1),
(100000021, 1, 'Granadilla, SrMarihuano', '', 'https://srmarihuano.es', '', 1),
(100000017, 1, 'ALIMENTACION', '', '/-c-100000017.html', '', 1),
(100000016, 1, 'CANARIAS TOKEN', '', 'https://canariastoken.marketplace30.es', '', 1),
(100000018, 1, 'DELICIA ITALIANA', '', 'https://deliciaitaliana.com', '', 1),
(100000019, 1, 'MODAS Y COMPLEMENTOS', '', '/-c-100000019.html', '', 1),
(100000020, 1, 'VAINILLA Y CHOCOLATE', '', 'https://vainillachocolate.enterprise30.es', '', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
