

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `admin_infodemsa2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products_fabricantes`
--

DROP TABLE IF EXISTS `products_fabricantes`;
CREATE TABLE IF NOT EXISTS `products_fabricantes` (
  `id` int(11) NOT NULL auto_increment,
  `products_reemplazar_este` varchar(255) NOT NULL,
  `products_reemplazar_poreste` varchar(255) NOT NULL,
  `concepto` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `products_fabricantes`
--



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


INSERT INTO `products_fabricantes` (`id`, `products_reemplazar_este`, `products_reemplazar_poreste`, `concepto`) VALUES
(1, 'KINGSTON', 'Kingston Technology', 'cambio'),
(2, 'WESTERNDIGITAL', '', 'eliminar'),
(3, 'WD', 'Western Digital', 'cambio'),
(4, 'SMART', '', 'eliminar'),
(5, 'Mustek', '', 'eliminar');