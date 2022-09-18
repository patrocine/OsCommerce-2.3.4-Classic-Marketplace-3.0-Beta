-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 17-09-2022 a las 23:38:31
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
-- Base de datos: `cz4seo7z_shop007`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrators`
--

CREATE TABLE IF NOT EXISTS `administrators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `user_password` varchar(60) NOT NULL,
  `admin_id_remoto` int(11) NOT NULL DEFAULT '0',
  `admin_groups_id` int(11) DEFAULT NULL,
  `supervisor` int(1) NOT NULL DEFAULT '0',
  `admin_firstname` varchar(32) NOT NULL DEFAULT '',
  `admin_lastname` varchar(32) DEFAULT NULL,
  `admin_email_address` varchar(96) NOT NULL DEFAULT '',
  `admin_password` varchar(40) NOT NULL DEFAULT '',
  `admin_created` datetime DEFAULT NULL,
  `admin_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `admin_logdate` datetime DEFAULT NULL,
  `admin_lognum` int(11) NOT NULL DEFAULT '0',
  `code_admin` varchar(255) NOT NULL DEFAULT '',
  `no_recogido` int(11) NOT NULL DEFAULT '0',
  `procesando_reembolso_internacional` int(11) NOT NULL DEFAULT '0',
  `procesando_paypal` int(11) NOT NULL DEFAULT '0',
  `transferencia` int(11) NOT NULL DEFAULT '0',
  `transferencia_procesando` int(11) NOT NULL DEFAULT '0',
  `paypal_enviado` int(11) NOT NULL DEFAULT '0',
  `cambio_procesando` int(11) NOT NULL DEFAULT '0',
  `cambio_entregado` int(11) NOT NULL DEFAULT '0',
  `esperando_respuesta` int(11) NOT NULL DEFAULT '0',
  `cancelado` int(11) NOT NULL DEFAULT '0',
  `facturado` int(11) NOT NULL DEFAULT '0',
  `recoger` int(11) NOT NULL DEFAULT '0',
  `cobrado` int(11) NOT NULL DEFAULT '0',
  `reserva` int(11) NOT NULL,
  `abono` int(11) NOT NULL DEFAULT '0',
  `pagado` int(11) NOT NULL DEFAULT '0',
  `pagado_internacional` int(11) NOT NULL DEFAULT '0',
  `pagado_transferencia` int(11) NOT NULL DEFAULT '0',
  `pagado_paypal` int(11) NOT NULL DEFAULT '0',
  `entregas_stock` int(11) NOT NULL DEFAULT '0',
  `retirarado` int(11) NOT NULL DEFAULT '0',
  `mercancia_entregado_procesando` int(11) NOT NULL DEFAULT '0',
  `status_entregas` varchar(11) NOT NULL DEFAULT '',
  `status_liquidacion` varchar(11) NOT NULL DEFAULT '',
  `status_salidas` varchar(11) NOT NULL DEFAULT '',
  `peticiones_mercancias` int(11) NOT NULL DEFAULT '0',
  `pendiente_entrada` int(11) NOT NULL DEFAULT '0',
  `pendiente_entrada_entienda` int(11) NOT NULL DEFAULT '0',
  `presupuestos` int(11) NOT NULL DEFAULT '0',
  `credito` int(11) NOT NULL DEFAULT '0',
  `albaran` int(11) NOT NULL,
  `albaran_cobrar` int(11) NOT NULL,
  `status_pendiente` int(11) NOT NULL DEFAULT '0',
  `status_procesando` int(11) NOT NULL DEFAULT '0',
  `name_boxes` varchar(255) NOT NULL DEFAULT '',
  `tienda_cuenta_cliente` int(11) NOT NULL DEFAULT '0',
  `admin_cif` varchar(255) NOT NULL DEFAULT 'B000000',
  `admin_direccion` varchar(255) NOT NULL DEFAULT '',
  `admin_poblacion` varchar(255) NOT NULL DEFAULT '',
  `admin_provincia` varchar(255) NOT NULL DEFAULT 'Provincia',
  `admin_cp` varchar(155) NOT NULL DEFAULT '',
  `admin_state` varchar(255) NOT NULL,
  `admin_telefono` varchar(255) NOT NULL DEFAULT '',
  `admin_movil` varchar(255) NOT NULL DEFAULT '',
  `admin_titularbanco` varchar(255) NOT NULL DEFAULT 'Titular Banco',
  `admin_nombrebanco` varchar(255) NOT NULL DEFAULT 'Nombre Banco',
  `admin_cuentabancaria` varchar(255) NOT NULL DEFAULT '0&nbsp;0&nbsp;0&nbsp;0&nbsp;&nbsp;&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;&nbsp;&nbsp;0&nbsp;0&nbsp;&nbsp;&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0',
  `admin_boxes` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_email_address` (`admin_email_address`),
  KEY `admin_email_address_2` (`admin_email_address`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `administrators`
--

INSERT INTO `administrators` (`id`, `admin_id`, `user_name`, `user_password`, `admin_id_remoto`, `admin_groups_id`, `supervisor`, `admin_firstname`, `admin_lastname`, `admin_email_address`, `admin_password`, `admin_created`, `admin_modified`, `admin_logdate`, `admin_lognum`, `code_admin`, `no_recogido`, `procesando_reembolso_internacional`, `procesando_paypal`, `transferencia`, `transferencia_procesando`, `paypal_enviado`, `cambio_procesando`, `cambio_entregado`, `esperando_respuesta`, `cancelado`, `facturado`, `recoger`, `cobrado`, `reserva`, `abono`, `pagado`, `pagado_internacional`, `pagado_transferencia`, `pagado_paypal`, `entregas_stock`, `retirarado`, `mercancia_entregado_procesando`, `status_entregas`, `status_liquidacion`, `status_salidas`, `peticiones_mercancias`, `pendiente_entrada`, `pendiente_entrada_entienda`, `presupuestos`, `credito`, `albaran`, `albaran_cobrar`, `status_pendiente`, `status_procesando`, `name_boxes`, `tienda_cuenta_cliente`, `admin_cif`, `admin_direccion`, `admin_poblacion`, `admin_provincia`, `admin_cp`, `admin_state`, `admin_telefono`, `admin_movil`, `admin_titularbanco`, `admin_nombrebanco`, `admin_cuentabancaria`, `admin_boxes`) VALUES
(1, 1, 'tienda', '$P$D0feOHg.1m7k8lchs9Nada/NswGVlz1', 17, 1, 1, 'admin', '1', 'admin1@admin1.com', '', '2004-07-13 23:14:45', '2012-06-12 08:48:54', '2012-04-01 06:36:34', 15677, 'tienda1', 0, 0, 0, 0, 0, 0, 60, 10, 64, 0, 34, 29, 30, 0, 32, 33, 0, 0, 0, 38, 41, 77, '39', '37', '40', 42, 59, 116, 58, 125, 129, 130, 31, 86, 'Tienda1', 3, 'B000000', 'C/ tienda1', 'poblacion', 'Provincia', 'codigo postal', '', 'telefono', 'movil', 'Titular Banco', 'Nombre Banco', '0 0 0 0   0 0 0 0   0 0   0 0 0 0 0 0 0 0 0 0', 1),
(13, 13, 'tienda3', '$P$DKkPuu5wEmv.IKOXlxUfDSxJ1B0RZk1', 0, 6, 0, 'Tienda', '3', 'tienda3@tienda3.com', '', '0000-00-00 00:00:00', '2012-06-12 08:51:23', '2007-02-02 19:15:51', 193, 'tienda3', 0, 0, 0, 0, 0, 0, 62, 63, 65, 0, 48, 43, 44, 0, 46, 47, 0, 0, 0, 51, 54, 0, '53', '50', '52', 55, 57, 0, 56, 0, 0, 0, 45, 85, 'Tienda3', 7660, 'B000000', 'Calle Cologan,', 'Puerto de la Cruz', 'Provincia', '38400', '', '922381951', '', 'Titular Banco', 'Nombre Banco', '0&nbsp;0&nbsp;0&nbsp;0&nbsp;&nbsp;&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;&nbsp;&nbsp;0&nbsp;0&nbsp;&nbsp;&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0', 1),
(14, 14, 'almacena', '$P$D/bMouZkigc13K0P1dvdeoATlVNOPG0', 0, 6, 0, 'Almacen', '', 'admin@almacen.com', '', '2006-07-19 00:40:39', '2015-05-13 11:14:26', NULL, 0, '38350', 0, 6, 119, 24, 25, 0, 10, 10, 18, 0, 71, 66, 2, 0, 69, 15, 0, 26, 36, 75, 78, 77, '77', '74', '76', 79, 14, 117, 81, 126, 131, 132, 1, 5, 'Almacen', 3, '78613593f', 'calle la cantera 9', 'granadilla de abona', 'Santa Cruz de Tenerife', '38600', 'Provincia Almacen', '639135856', '639135856', 'Maria Lorena Garcia de la Cruz', 'Nombre Banco', '0 0 1 9   5 7 0 3   2 5   4 2 1 0 0 0 3 4 7 1', 1),
(17, 17, 'tienda1a', '$P$DIECXqFX7U.XVf7LIkirOoYw0Uip4Y.', 0, 6, 0, 'Tienda', '1', 'tienda1@tienda1.com', '', '2004-07-13 23:14:45', '2015-02-01 16:52:59', '2007-02-14 17:54:22', 926, 'tienda1', 0, 0, 0, 0, 0, 0, 60, 61, 64, 0, 34, 29, 30, 0, 32, 33, 0, 0, 0, 38, 41, 0, '39', '37', '40', 42, 59, 116, 58, 125, 129, 130, 31, 86, 'Tienda1', 3, 'B000000', 'C/ tienda1', 'poblacion', 'Provincia', 'codigo postal', '', 'telefono', 'movil', 'Titular Banco', 'Nombre Banco', '0 0 0 0   0 0 0 0   0 0   0 0 0 0 0 0 0 0 0 0', 1),
(35, 35, 'admin3', '$P$DNh4sQRa2GGezLni6tu8vRjxxCuXFi.', 17, 1, 0, 'admin', '3', 'admin3@admin3.com', '', '2012-04-07 15:56:03', '2012-04-07 17:52:48', NULL, 0, 'tienda1', 0, 0, 0, 0, 0, 0, 60, 0, 64, 0, 34, 29, 30, 0, 32, 33, 0, 0, 0, 38, 41, 0, '39', '37', '40', 42, 59, 116, 58, 125, 0, 0, 31, 86, 'Tienda1', 1, 'B000000', '', '', 'Provincia', '', '', '', '', 'Titular Banco', 'Nombre Banco', '0&nbsp;0&nbsp;0&nbsp;0&nbsp;&nbsp;&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;&nbsp;&nbsp;0&nbsp;0&nbsp;&nbsp;&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0', 1),
(16, 16, 'tienda2', '$P$D6uhpKRlfvoFigDoR9ITN2gKqStjQw0', 0, 6, 0, 'Tienda', '2', 'tienda2@tienda2.com', '', '2007-02-11 19:06:12', '2012-06-12 08:51:52', NULL, 0, 'tienda2', 0, 0, 0, 0, 0, 0, 103, 104, 105, 0, 93, 88, 89, 0, 91, 92, 0, 0, 0, 96, 99, 0, '98', '95', '97', 100, 101, 114, 102, 0, 0, 0, 90, 110, 'Tienda2', 7904, 'B000000', 'C/ Funador Gonzalo Gonzalez N', 'Granadilla de Abona', 'Provincia', '38600', '', '922770000', '600259909', 'Titular Banco', 'Nombre Banco', '0&nbsp;0&nbsp;0&nbsp;0&nbsp;&nbsp;&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;&nbsp;&nbsp;0&nbsp;0&nbsp;&nbsp;&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0&nbsp;0', 1),
(34, 34, 'almacen', '$P$D9eEjTnRKbHQlIHf3zNGQA7rJMOWkg.', 17, 1, 0, 'admin', '2', 'admin2@admin2.com', '', '2011-06-16 15:49:16', '2012-04-07 17:40:11', '2011-07-15 09:23:39', 43, 'tienda1', 0, 0, 0, 0, 0, 0, 60, 0, 64, 0, 34, 29, 30, 0, 32, 33, 0, 0, 0, 38, 41, 0, '39', '37', '40', 42, 59, 116, 58, 125, 129, 130, 31, 86, 'Tienda1', 3, 'B000000', 'C/ tienda1', 'poblacion', 'Provincia', 'codigo postal', '', 'telefono', 'movil', 'Titular Banco', 'Nombre Banco', '0 0 0 0   0 0 0 0   0 0   0 0 0 0 0 0 0 0 0 0', 1),
(36, 36, 'empleado', '$P$Dh/AQqkiIs8pQ86uvZkfEyucnRY.8f0', 17, 9, 0, 'Empleado1', 'Nombre', 'empleado@empleado.com', '$P$DB2IPbnsB/oGUTzdy7TqkUBjxGThQc.', '2014-10-26 16:44:38', '2014-11-08 15:03:32', NULL, 0, 'tienda1', 0, 0, 0, 0, 0, 0, 60, 0, 64, 0, 34, 29, 30, 0, 32, 33, 0, 0, 0, 38, 41, 0, '39', '37', '40', 42, 59, 116, 58, 125, 0, 0, 31, 86, 'Tienda1', 3, 'B000000', 'C/ tienda1', 'poblacion', 'Provincia', 'codigo postal', '', 'telefono', 'movil', 'Titular Banco', 'Nombre Banco', '0 0 0 0   0 0 0 0   0 0   0 0 0 0 0 0 0 0 0 0', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
