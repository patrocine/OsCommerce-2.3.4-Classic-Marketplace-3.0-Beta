-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 17-07-2023 a las 23:45:49
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
-- Base de datos: `bu23ef02_theower`
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
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `affiliate_compartir_empresas`
--

INSERT INTO `affiliate_compartir_empresas` (`id_banners`, `url_empresa_catalog`, `url_enlace`, `numero_productos`, `nombre`, `url_web`, `url_affiliate`, `email`, `aut`, `epigrafe_sector`, `nombre_sector`, `nombre_ciudad`, `desactivar`) VALUES
(93, 'https://elcogollo2.com/affiliate_banners_products.php?pro_ale=', 'https://elcogollo2.com/enlace.php', 10, 'El Cogollo 2', 'https://elcogollo2.com/', 'https://elcogollo2.com/index.php?ref=1', 'marinsweed@gmail.com', 1, '100000000', 'Grow Shop', 'San Isidro, Granadilla', 1),
(75, 'https://tasmaniapetshop.es/affiliate_banners_products.php?pro_ale=', 'https://tasmaniapetshop.es/enlace.php', 10, 'Tasmania Pet Shop', 'https://tasmaniapetshop.es/', 'https://tasmaniapetshop.es/index.php?ref=1', 'tasmaniadvilshop@hotmail.es', 1, '100000001', 'Animales', 'Granadilla Pueblo', 1),
(109, 'https://deliciaitaliana.com/affiliate_banners_products.php?pro_ale=', 'https://deliciaitaliana.com/enlace.php', 10, 'Delicias Italianas', 'https://deliciaitaliana.com/', 'https://deliciaitaliana.com/index.php?ref=1', 'deliciaitalianaes@gmail.com', 1, '100000017', 'Alimentación', 'San Isidro', 1),
(111, 'https://srmarihuano.es/affiliate_banners_products.php?pro_ale=', 'https://srmarihuano.es/enlace.php', 10, 'Sr.Marihuano', 'https://srmarihuano.es/', 'https://srmarihuano.es/index.php?ref=1', 'clubgrowes@gmail.com', 1, '100000000', 'Grow Shop', 'Granadilla de Abona', 1),
(118, 'https://tecnocomink.fun/affiliate_banners_products.php?pro_ale=', 'https://tecnocomink.fun/enlace.php', 10, 'Tecno Comink', 'https://tecnocomink.fun/', 'https://tecnocomink.fun/index.php?ref=1', 'email@gmail.com', 1, '6597', 'Informatica', 'San Isidro', 1),
(113, 'https://oasiitaliana.com/affiliate_banners_products.php?pro_ale=', 'https://oasiitaliana.com/enlace.php', 10, 'Oasi Italiana', 'https://oasiitaliana.com/', 'https://oasiitaliana.com/index.php?ref=1', 'oasiitalitanacom@gmail.com', 1, '100000017', 'Alimentación', 'Las Americas', 1),
(119, 'https://theovergrown.es/affiliate_banners_products.php?pro_ale=', 'https://theovergrown.es/enlace.php', 10, 'The Over Grown', 'https://theovergrown.es/', 'https://theovergrown.es/index.php?ref=1', 'elcogollotenerife@gmail.com', 1, '100000000', 'GROW SHOP', 'Santa Cruz', 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=100000029 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `marketplace`
--

INSERT INTO `marketplace` (`categories_id`, `sistema_patrocine`, `categories_image`, `parent_id`, `sort_order`, `date_added`, `last_modified`, `categories_time`, `categories_productos`, `categories_status`, `categories_marketplace`) VALUES
(99999999, 0, NULL, 0, NULL, NULL, NULL, 1670234910, 0, 0, 0),
(100000000, 0, NULL, 0, 0, '2022-12-05 06:32:39', NULL, 1688947668, 0, 0, 0),
(100000001, 0, NULL, 0, 0, '2022-12-05 06:33:11', NULL, 1688948787, 0, 0, 0),
(100000004, 0, 'https://elcogollo2.com/images/store_logo.png', 100000000, 0, '2022-12-05 07:40:56', NULL, 1685953119, 0, 0, 0),
(100000021, 0, 'https://srmarihuano.es/images/store_logo.png', 100000000, 0, '2023-03-01 17:42:42', NULL, 1686020566, 0, 0, 0),
(100000006, 0, 'https://tasmaniapetshop.es/images/store_logo.png', 100000001, 0, '2022-12-05 07:42:02', NULL, 1688879675, 0, 0, 0),
(100000017, 0, NULL, 0, 0, '2023-01-13 06:44:53', NULL, 1688931813, 0, 0, 0),
(100000018, 0, 'https://deliciaitaliana.com/images/store_logo.png', 100000017, 0, '2023-01-13 06:45:46', NULL, 1688880115, 0, 0, 0),
(100000016, 0, NULL, 0, 3, '2022-12-18 14:51:50', NULL, 1688806904, 0, 0, 0),
(100000022, 0, 'https://xuxes.cat/images/store_logo.png', 100000000, 0, '2023-03-23 14:32:44', NULL, 1686029982, 0, 0, 0),
(100000023, 0, 'https://oasiitaliana.com/images/store_logo.png', 100000017, 0, '2023-04-02 16:00:16', NULL, 1688806624, 0, 0, 0),
(100000026, 0, NULL, 0, 0, '2023-06-04 20:24:58', NULL, 1688949880, 0, 0, 0),
(100000027, 0, 'https://tecnocomink.fun/images/store_logo.png', 100000026, 0, '2023-06-04 20:25:27', NULL, 1688823591, 0, 0, 0),
(100000028, 0, 'https://theovergrown.es/images/store_logo.png', 100000000, 0, '2023-07-17 23:13:51', NULL, 0, 0, 0, 0);

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
(100000004, 1, 'EL COGOLLLO 2', '', 'https://elcogollo2.com/', 'https://elcogollo2.com/', 1),
(100000000, 1, 'GROW SHOP', '', '', '/-c-100000000.html', 1),
(100000001, 1, 'TIENDA DE ANIMALES', '', '', '/-c-100000001.html', 1),
(100000006, 1, 'TASMANIA PETSHOP', '', 'https://tasmaniapetshop.es/', 'https://tasmaniapetshop.es/', 1),
(100000021, 1, 'SR.MARIHUANO', '', 'https://srmarihuano.es', '', 1),
(100000017, 1, 'ALIMENTACION', '', '', '', 1),
(100000016, 1, 'CANARIAS TOKEN', '', 'https://canariastoken.marketplace30.es', '', 1),
(100000018, 1, 'DELICIA ITALIANA', '', 'https://deliciaitaliana.com', '', 1),
(100000022, 1, 'XUXES CBD', '', 'https://xuxes.cat', '', 1),
(100000023, 1, 'OASI ITALIANA', '', 'https://oasiitaliana.com', '', 1),
(100000026, 1, 'INFORMATICA', '', '', '', 1),
(100000027, 1, 'TECNOCOMINK', '', 'https://tecnocomink.fun', '', 1),
(100000028, 1, 'THEOVERGROWN', '', 'https://theovergrown.es/', '', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
