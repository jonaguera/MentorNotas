-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 30-09-2012 a las 23:40:01
-- Versión del servidor: 5.5.24
-- Versión de PHP: 5.3.10-1ubuntu3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `mentornotas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alimentos`
--

CREATE TABLE IF NOT EXISTS `alimentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_bin NOT NULL,
  `energia` decimal(10,0) NOT NULL,
  `proteina` decimal(10,0) NOT NULL,
  `hidratocarbono` decimal(10,0) NOT NULL,
  `fibra` decimal(10,0) NOT NULL,
  `grasatotal` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `alimentos`
--

INSERT INTO `alimentos` (`id`, `nombre`, `energia`, `proteina`, `hidratocarbono`, `fibra`, `grasatotal`) VALUES
(1, 'Chorizo', 100, 120, 140, 160, 180),
(2, 'Alubia', 80, 90, 100, 110, 100),
(3, 'Garbanzos', 5, 6, 7, 8, 9),
(4, 'Platano', 100, 101, 100, 10, 12),
(5, 'Platano', 10, 10, 10, 10, 10),
(6, 'Nombre del alimento', 0, 0, 0, 0, 0),
(7, 'Nombre del alimento', 0, 0, 0, 0, 0),
(8, 'Pipas', 78, 78, 78, 79, 7),
(9, 'Patata', 52, 24, 65, 89, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Contrato`
--

CREATE TABLE IF NOT EXISTS `Contrato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tarifa_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `referencia` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9F1F0775FE3B76B` (`tarifa_id`),
  KEY `IDX_9F1F0775DB38439E` (`usuario_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `Contrato`
--

INSERT INTO `Contrato` (`id`, `tarifa_id`, `usuario_id`, `fecha`, `referencia`) VALUES
(4, 3, 1, '2012-09-30', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Etiqueta`
--

CREATE TABLE IF NOT EXISTS `Etiqueta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `texto` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_942AC46CDB38439E` (`usuario_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=16 ;

--
-- Volcado de datos para la tabla `Etiqueta`
--

INSERT INTO `Etiqueta` (`id`, `usuario_id`, `texto`) VALUES
(1, 1, 'Notas'),
(2, 1, 'Recordatorios'),
(3, 1, 'Cumpleaños'),
(4, 4, 'Cumpleaños'),
(5, 4, 'Mis Cosas'),
(6, 4, 'Top Secret'),
(7, 3, 'Cumpleaños'),
(8, 3, 'Mis Cosas'),
(9, 3, 'Top Secret'),
(10, 2, 'Cumpleaños'),
(11, 2, 'Mis Cosas'),
(12, 2, 'Top Secret'),
(15, 5, 'Etiqueta1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Grupo`
--

CREATE TABLE IF NOT EXISTS `Grupo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_bin NOT NULL,
  `rol` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `Grupo`
--

INSERT INTO `Grupo` (`id`, `nombre`, `rol`) VALUES
(1, 'registrado', 'ROLE_REGISTRADO'),
(2, 'premium', 'ROLE_PREMIUM'),
(3, 'administrador', 'ROLE_ADMIN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Nota`
--

CREATE TABLE IF NOT EXISTS `Nota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `titulo` varchar(29) COLLATE utf8_bin NOT NULL,
  `texto` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_68E29133DB38439E` (`usuario_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `Nota`
--

INSERT INTO `Nota` (`id`, `usuario_id`, `titulo`, `texto`, `fecha`, `path`) VALUES
(1, 2, 'Mi primera nota', 'Lorem ipsum ad his scripta blandit partiendo, eum fastidii accumsan euripidis in, eum liber hendrerit an. Qui ut wisi vocibus suscipiantur, quo dicit ridens inciderint id. Quo mundi lobortis reformidans eu, legimus senserit definiebas an eos. Eu sit tinci', '2012-08-12 11:25:54', '/ruta/a/nota'),
(2, 2, 'Mi segunda nota', 'Lorem ipsum ad his scripta blandit partiendo, eum fastidii accumsan euripidis in, eum liber hendrerit an. Qui ut wisi vocibus suscipiantur, quo dicit ridens inciderint id. Quo mundi lobortis reformidans eu, legimus senserit definiebas an eos. Eu sit tinci', '2012-08-12 11:25:54', '/ruta/a/nota'),
(3, 2, 'Mi tercera nota', 'Lorem ipsum ad his scripta blandit partiendo, eum fastidii accumsan euripidis in, eum liber hendrerit an. Qui ut wisi vocibus suscipiantur, quo dicit ridens inciderint id. Quo mundi lobortis reformidans eu, legimus senserit definiebas an eos. Eu sit tinci', '2012-08-12 11:25:54', '/ruta/a/nota'),
(4, 3, 'Mi primera nota', 'Lorem ipsum ad his scripta blandit partiendo, eum fastidii accumsan euripidis in, eum liber hendrerit an. Qui ut wisi vocibus suscipiantur, quo dicit ridens inciderint id. Quo mundi lobortis reformidans eu, legimus senserit definiebas an eos. Eu sit tinci', '2012-08-12 11:25:54', '/ruta/a/nota'),
(5, 3, 'Mi segunda nota', 'Lorem ipsum ad his scripta blandit partiendo, eum fastidii accumsan euripidis in, eum liber hendrerit an. Qui ut wisi vocibus suscipiantur, quo dicit ridens inciderint id. Quo mundi lobortis reformidans eu, legimus senserit definiebas an eos. Eu sit tinci', '2012-08-12 11:25:54', '/ruta/a/nota'),
(6, 3, 'Mi tercera nota', 'Lorem ipsum ad his scripta blandit partiendo, eum fastidii accumsan euripidis in, eum liber hendrerit an. Qui ut wisi vocibus suscipiantur, quo dicit ridens inciderint id. Quo mundi lobortis reformidans eu, legimus senserit definiebas an eos. Eu sit tinci', '2012-08-12 11:25:54', '/ruta/a/nota'),
(7, 4, 'Mi primera nota', 'Lorem ipsum ad his scripta blandit partiendo, eum fastidii accumsan euripidis in, eum liber hendrerit an. Qui ut wisi vocibus suscipiantur, quo dicit ridens inciderint id. Quo mundi lobortis reformidans eu, legimus senserit definiebas an eos. Eu sit tinci', '2012-08-12 11:25:54', '/ruta/a/nota'),
(8, 4, 'Mi segunda nota', 'Lorem ipsum ad his scripta blandit partiendo, eum fastidii accumsan euripidis in, eum liber hendrerit an. Qui ut wisi vocibus suscipiantur, quo dicit ridens inciderint id. Quo mundi lobortis reformidans eu, legimus senserit definiebas an eos. Eu sit tinci', '2012-08-12 11:25:54', '/ruta/a/nota'),
(9, 4, 'Mi tercera nota', 'Lorem ipsum ad his scripta blandit partiendo, eum fastidii accumsan euripidis in, eum liber hendrerit an. Qui ut wisi vocibus suscipiantur, quo dicit ridens inciderint id. Quo mundi lobortis reformidans eu, legimus senserit definiebas an eos. Eu sit tinci', '2012-08-12 11:25:54', '/ruta/a/nota'),
(10, 1, 'Mi primera nota', 'DFHGHDFHLorem ipsum ad his scripta blandit partiendo, eum fastidii accumsan euripidis in, eum liber hendrerit an. Qui ut wisi vocibus suscipiantur, quo dicit ridens inciderint id. Quo mundi lobortis reformidans eu, legimus senserit definiebas an eos. Eu s', '2012-09-30 10:18:50', '/ruta/a/nota'),
(11, 1, 'Mi segunda nota', 'GFFFFFFDGHLorem ipsum ad his scripta blandit partiendo, eum fastidii accumsan euripidis in, eum liber hendrerit an. Qui ut wisi vocibus suscipiantur, quo dicit ridens inciderint id. Quo mundi lobortis reformidans eu, legimus senserit definiebas an eos. Eu', '2012-09-26 23:28:52', '/ruta/a/nota'),
(13, NULL, 'Nota de prueba 1', 'Texto para la nota de pruebas 1', '2012-09-23 18:17:53', 'ruta/a/nota1'),
(14, NULL, 'Nota de prueba 2', 'Texto para la nota de pruebas 2', '2012-09-23 18:17:53', 'ruta/a/nota2'),
(15, NULL, 'Ruta 1', NULL, NULL, 'La Padiorna desde Fuente de por los tornos de Liordes.gpx'),
(16, 5, 'nota2', 'lkadsfñla jsdfj', '2012-09-30 11:48:42', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_etiqueta`
--

CREATE TABLE IF NOT EXISTS `nota_etiqueta` (
  `nota_id` int(11) NOT NULL,
  `etiqueta_id` int(11) NOT NULL,
  PRIMARY KEY (`nota_id`,`etiqueta_id`),
  KEY `IDX_74ECDADEA98F9F02` (`nota_id`),
  KEY `IDX_74ECDADED53DA3AB` (`etiqueta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `nota_etiqueta`
--

INSERT INTO `nota_etiqueta` (`nota_id`, `etiqueta_id`) VALUES
(1, 10),
(2, 11),
(3, 12),
(4, 7),
(5, 8),
(6, 9),
(7, 4),
(8, 4),
(9, 4),
(10, 1),
(16, 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Publicidad`
--

CREATE TABLE IF NOT EXISTS `Publicidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_bin NOT NULL,
  `texto` varchar(255) COLLATE utf8_bin NOT NULL,
  `path` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Tarifa`
--

CREATE TABLE IF NOT EXISTS `Tarifa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_bin NOT NULL,
  `periodo` int(11) NOT NULL,
  `precio` double NOT NULL,
  `validoDesde` date NOT NULL,
  `validoHasta` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `Tarifa`
--

INSERT INTO `Tarifa` (`id`, `nombre`, `periodo`, `precio`, `validoDesde`, `validoHasta`) VALUES
(1, 'Mensual', 1, 5, '2012-09-01', '2013-09-30'),
(2, 'Trimestral', 3, 12, '2012-09-01', '2013-09-30'),
(3, 'Anual', 12, 40, '2012-09-01', '2013-09-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuario`
--

CREATE TABLE IF NOT EXISTS `Usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_bin NOT NULL,
  `apellidos` varchar(255) COLLATE utf8_bin NOT NULL,
  `salt` varchar(255) COLLATE utf8_bin NOT NULL,
  `username` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `isActive` tinyint(1) NOT NULL,
  `tokenRegistro` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `Usuario`
--

INSERT INTO `Usuario` (`id`, `nombre`, `apellidos`, `salt`, `username`, `password`, `email`, `isActive`, `tokenRegistro`) VALUES
(1, 'Alberto', 'Einstein', '', 'alberto', '620a7de82763527406a413ca7ee267816d332811', 'alberto@mentornotas.es', 1, ''),
(2, 'Máximo', 'Planck', '', 'maximo', '620a7de82763527406a413ca7ee267816d332811', 'maximo@mentornotas.es', 1, ''),
(3, 'María', 'Curie', '', 'maria', '620a7de82763527406a413ca7ee267816d332811', 'maria@mentornotas.es', 1, ''),
(4, 'Isaac', 'Newton', '', 'isaac', '620a7de82763527406a413ca7ee267816d332811', 'isaac@kk.es', 1, ''),
(5, 'Jon', 'Agüera', '12753c20d6', 'jonaguera', 'cf33e4cb1c31d362be360580d9c52cca471c909a', 'jonaguera@gmail.com', 1, '53e020d6876a30b6fb46299179e625f6');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_grupo`
--

CREATE TABLE IF NOT EXISTS `usuario_grupo` (
  `usuario_id` int(11) NOT NULL,
  `grupo_id` int(11) NOT NULL,
  PRIMARY KEY (`usuario_id`,`grupo_id`),
  KEY `IDX_91D0F1CDDB38439E` (`usuario_id`),
  KEY `IDX_91D0F1CD9C833003` (`grupo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `usuario_grupo`
--

INSERT INTO `usuario_grupo` (`usuario_id`, `grupo_id`) VALUES
(1, 1),
(1, 2),
(2, 2),
(3, 3),
(4, 2),
(4, 3),
(5, 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Contrato`
--
ALTER TABLE `Contrato`
  ADD CONSTRAINT `FK_9F1F0775DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `Usuario` (`id`),
  ADD CONSTRAINT `FK_9F1F0775FE3B76B` FOREIGN KEY (`tarifa_id`) REFERENCES `Tarifa` (`id`);

--
-- Filtros para la tabla `Etiqueta`
--
ALTER TABLE `Etiqueta`
  ADD CONSTRAINT `FK_942AC46CDB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `Usuario` (`id`);

--
-- Filtros para la tabla `Nota`
--
ALTER TABLE `Nota`
  ADD CONSTRAINT `FK_68E29133DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `Usuario` (`id`);

--
-- Filtros para la tabla `nota_etiqueta`
--
ALTER TABLE `nota_etiqueta`
  ADD CONSTRAINT `FK_74ECDADEA98F9F02` FOREIGN KEY (`nota_id`) REFERENCES `Nota` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_74ECDADED53DA3AB` FOREIGN KEY (`etiqueta_id`) REFERENCES `Etiqueta` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuario_grupo`
--
ALTER TABLE `usuario_grupo`
  ADD CONSTRAINT `FK_91D0F1CD9C833003` FOREIGN KEY (`grupo_id`) REFERENCES `Grupo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_91D0F1CDDB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `Usuario` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
