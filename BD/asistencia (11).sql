-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2014 at 11:04 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `asistencia`
--

-- --------------------------------------------------------

--
-- Table structure for table `asistencia`
--

CREATE TABLE IF NOT EXISTS `asistencia` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `horaentrada` time NOT NULL,
  `horasalida` time DEFAULT NULL,
  `almuerzoentrada` time DEFAULT NULL,
  `almuerzosalida` time DEFAULT NULL,
  `fotoentrada` varchar(35) NOT NULL,
  `empleado` int(3) unsigned NOT NULL,
  `motivo` varchar(200) DEFAULT NULL,
  `fotosalida` varchar(35) DEFAULT NULL,
  `fotoalmuerzoent` varchar(35) DEFAULT NULL,
  `fotoalmuerzosal` varchar(35) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_asistencia_empleado1_idx` (`empleado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=118 ;

--
-- Dumping data for table `asistencia`
--

INSERT INTO `asistencia` (`id`, `fecha`, `horaentrada`, `horasalida`, `almuerzoentrada`, `almuerzosalida`, `fotoentrada`, `empleado`, `motivo`, `fotosalida`, `fotoalmuerzoent`, `fotoalmuerzosal`) VALUES
(36, '2014-04-27', '08:00:00', '00:00:00', '00:00:00', '00:00:00', 'V13774186_2014-04-28.jpg', 1, 'prueba', '', NULL, ''),
(48, '2014-05-03', '10:00:55', '00:00:00', '00:00:00', '00:00:00', 'V13774186_2014-04-30.jpg', 1, 'prueba', '', NULL, ''),
(83, '2014-05-06', '15:21:08', '15:22:48', '00:00:00', '00:00:00', 'V13774186_2014-05-06_..jpg', 1, 'prueba', 'V13774186_2014-05-06_15.22.jpg', '', ''),
(84, '2014-05-06', '15:23:03', '15:23:14', '00:00:00', '00:00:00', 'V11882813_2014-05-06_15.23.jpg', 2, 'prueba', 'V11882813_2014-05-06_15.23.jpg', '', ''),
(90, '2014-05-04', '14:17:21', '14:18:13', '00:00:00', '00:00:00', 'V13774186_2014-05-07_14.17.jpg', 1, '1234', 'V13774186_2014-05-07_14.18.jpg', '', ''),
(91, '2014-05-05', '14:18:56', '00:00:00', '00:00:00', '00:00:00', 'V13774186_2014-05-07_14.18.jpg', 1, 'prueba', '', '', ''),
(110, '2014-05-07', '16:17:55', '16:18:00', '00:00:00', '00:00:00', 'V13774186_2014-05-07_16.17.jpg', 1, '1www', 'V13774186_2014-05-07_16.18.jpg', '', ''),
(111, '2014-05-07', '16:18:21', '00:00:00', '16:19:36', '16:19:28', 'V11882813_2014-05-07_16.18.jpg', 2, 'kkk', NULL, 'V11882813_2014-05-07_16.19.jpg', 'V11882813_2014-05-07_16.19.jpg'),
(114, '2014-05-09', '10:38:25', '00:00:00', '00:00:00', '00:00:00', 'V11882813_2014-05-09_10.38.jpg', 2, 'hhhhh', '', '', ''),
(115, '2014-05-09', '10:38:35', '00:00:00', '00:00:00', '00:00:00', 'V13774186_2014-05-09_10.38.jpg', 1, 'ppp', '', '', ''),
(116, '2014-05-12', '09:35:07', '09:35:19', '00:00:00', '00:00:00', 'V11882813_2014-05-12_09.35.jpg', 2, 'pppp', 'V11882813_2014-05-12_09.35.jpg', '', ''),
(117, '2014-05-12', '10:13:09', '10:16:47', '00:00:00', '00:00:00', 'V13774186_10.13.jpg', 1, 'prueba', 'V13774186_10.16.jpg', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `autorizacion`
--

CREATE TABLE IF NOT EXISTS `autorizacion` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `asistencia` int(3) unsigned NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `estatus` tinyint(1) NOT NULL,
  `usuario` int(3) unsigned NOT NULL,
  `tipoautorizacion` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`,`asistencia`),
  KEY `fk_autorizacion_asistencia1_idx` (`asistencia`),
  KEY `fk_autorizacion_usuario1_idx` (`usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `autorizacion`
--

INSERT INTO `autorizacion` (`id`, `asistencia`, `nombre`, `estatus`, `usuario`, `tipoautorizacion`) VALUES
(2, 115, 'ppp', 1, 1, 1),
(3, 116, 'pppp', 1, 1, 1),
(4, 116, 'ppppp', 1, 1, 0),
(5, 117, 'prueba', 1, 1, 1),
(6, 117, 'lll', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `departamento`
--

CREATE TABLE IF NOT EXISTS `departamento` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `piso` int(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_departamento_piso1_idx` (`piso`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `departamento`
--

INSERT INTO `departamento` (`id`, `nombre`, `piso`) VALUES
(1, 'Informática', 0);

-- --------------------------------------------------------

--
-- Table structure for table `division`
--

CREATE TABLE IF NOT EXISTS `division` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `departamento` int(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_division_departamento1_idx` (`departamento`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `division`
--

INSERT INTO `division` (`id`, `nombre`, `departamento`) VALUES
(1, 'Desarrollo', 1);

-- --------------------------------------------------------

--
-- Table structure for table `empleado`
--

CREATE TABLE IF NOT EXISTS `empleado` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `nacionalidad` char(1) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `cedula` int(8) unsigned NOT NULL,
  `estatus` tinyint(1) unsigned NOT NULL,
  `division` int(3) unsigned NOT NULL,
  `horario` int(3) unsigned NOT NULL,
  `foto` varchar(35) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_empleado_division1_idx` (`division`),
  KEY `fk_empleado_horario1_idx` (`horario`),
  KEY `fk_empleado_persona1_idx` (`cedula`,`nacionalidad`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `empleado`
--

INSERT INTO `empleado` (`id`, `nacionalidad`, `cedula`, `estatus`, `division`, `horario`, `foto`) VALUES
(1, 'V', 13774186, 1, 1, 2, ''),
(2, 'V', 11882813, 1, 1, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `horario`
--

CREATE TABLE IF NOT EXISTS `horario` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `horaentrada` time DEFAULT NULL,
  `horasalida` time DEFAULT NULL,
  `tiempoalmuerzo` time DEFAULT NULL,
  `horarioespecial` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `horario`
--

INSERT INTO `horario` (`id`, `nombre`, `horaentrada`, `horasalida`, `tiempoalmuerzo`, `horarioespecial`) VALUES
(1, 'Normal', '08:30:00', '15:00:00', '00:30:00', 0),
(2, 'Materno', '08:00:00', '15:30:00', '00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `institucion`
--

CREATE TABLE IF NOT EXISTS `institucion` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `siglas` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `institucion`
--

INSERT INTO `institucion` (`id`, `nombre`, `siglas`) VALUES
(1, 'Gobernacion', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `iconCls` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `className` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Menu_Menu` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `permisos`
--

CREATE TABLE IF NOT EXISTS `permisos` (
  `menuid` int(11) NOT NULL DEFAULT '0',
  `grupoid` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menuid`,`grupoid`),
  KEY `grupoid` (`grupoid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permisosemp`
--

CREATE TABLE IF NOT EXISTS `permisosemp` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `empleado` int(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_permisosemp_empleado1_idx` (`empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `persona`
--

CREATE TABLE IF NOT EXISTS `persona` (
  `cedula` int(8) unsigned NOT NULL,
  `nacionalidad` char(1) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `apellido` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `direccion` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci,
  `movil` int(10) unsigned zerofill DEFAULT NULL,
  `fijo` int(10) unsigned DEFAULT NULL,
  `correo` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fechanac` date DEFAULT NULL,
  `edocivil` tinyint(1) DEFAULT NULL,
  `sexo` tinyint(1) DEFAULT NULL,
  `estatus` tinyint(1) NOT NULL,
  PRIMARY KEY (`cedula`,`nacionalidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `persona`
--

INSERT INTO `persona` (`cedula`, `nacionalidad`, `nombre`, `apellido`, `direccion`, `movil`, `fijo`, `correo`, `fechanac`, `edocivil`, `sexo`, `estatus`) VALUES
(11882813, 'V', 'Jinme', 'mirabal', 'urb Pastoreña', 4164572434, NULL, NULL, NULL, NULL, 0, 1),
(13774186, 'V', 'Isabel', 'Pineda', 'Urb. La pastoreña', 4164518440, NULL, NULL, '1979-09-12', 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `piso`
--

CREATE TABLE IF NOT EXISTS `piso` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `piso` varchar(2) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `institucion` int(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_piso_institucion1_idx` (`institucion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `piso`
--

INSERT INTO `piso` (`id`, `piso`, `institucion`) VALUES
(5, '5', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reposos`
--

CREATE TABLE IF NOT EXISTS `reposos` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `diagnostico` varchar(45) DEFAULT NULL,
  `fechaini` date NOT NULL,
  `fechafin` date NOT NULL,
  `empleado` int(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_reposos_empleado1_idx` (`empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tipousuario`
--

CREATE TABLE IF NOT EXISTS `tipousuario` (
  `id` int(3) NOT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `tipousuario`
--

INSERT INTO `tipousuario` (`id`, `nombre`) VALUES
(1, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `nacionalidad` char(1) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `cedula` int(8) unsigned NOT NULL,
  `usuario` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `password` varchar(35) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `tipousuario` int(3) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `claveautorizada` varchar(45) DEFAULT NULL,
  `clavenoautorizada` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_usuario_tipousuario_idx` (`tipousuario`),
  KEY `fk_usuario_persona1_idx` (`cedula`,`nacionalidad`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `nacionalidad`, `cedula`, `usuario`, `password`, `tipousuario`, `status`, `claveautorizada`, `clavenoautorizada`) VALUES
(1, 'V', 13774186, 'jinme', '123456', 1, 1, '1234', '4321');

-- --------------------------------------------------------

--
-- Table structure for table `vacaciones`
--

CREATE TABLE IF NOT EXISTS `vacaciones` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fechaini` date NOT NULL,
  `fechafin` date NOT NULL,
  `empleado` int(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_vacaciones_empleado1_idx` (`empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `asistencia`
--
ALTER TABLE `asistencia`
  ADD CONSTRAINT `fk_asistencia_empleado1` FOREIGN KEY (`empleado`) REFERENCES `empleado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `autorizacion`
--
ALTER TABLE `autorizacion`
  ADD CONSTRAINT `autorizacion_ibfk_1` FOREIGN KEY (`asistencia`) REFERENCES `asistencia` (`id`),
  ADD CONSTRAINT `fk_autorizacion_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
