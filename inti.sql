-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-06-2019 a las 21:03:57
-- Versión del servidor: 10.1.26-MariaDB
-- Versión de PHP: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inti`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `idcargo` int(3) NOT NULL,
  `nombre` varchar(35) NOT NULL,
  `descripcion` varchar(60) NOT NULL,
  `estatus` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`idcargo`, `nombre`, `descripcion`, `estatus`) VALUES
(1, 'ANALISTA ATEN. CIUDADANO', 'ANALISTA DE ATENCION AL CIUDADANO', 1),
(2, 'ANALISTA REG. AGRARIO', 'ANALISTA DE REGISTRO AGRARIO', 1),
(3, 'ANALISTA REC. NATURALES', 'ANALISTA DE RECURSOS NATURALES', 1),
(4, 'ANALISTA AREA TEC.', 'ANALISTA DE AREA TECNICA', 1),
(5, 'ANALISTA AREA LEGAL', 'ANALISTA DE AREA LEGAL', 1),
(6, 'ADMINISTRADOR', 'ADMIN', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudadano`
--

CREATE TABLE `ciudadano` (
  `idciudadano` int(4) NOT NULL,
  `nacionalidad` int(2) NOT NULL,
  `cedula` varchar(12) NOT NULL,
  `tiporif` int(2) DEFAULT NULL,
  `rif` varchar(12) DEFAULT NULL,
  `primernombre` varchar(50) NOT NULL,
  `segundonombre` varchar(50) DEFAULT NULL,
  `primerapellido` varchar(50) NOT NULL,
  `segundoapellido` varchar(50) DEFAULT NULL,
  `direccion` varchar(100) NOT NULL,
  `telefono` varchar(14) NOT NULL,
  `email` varchar(50) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ciudadano`
--

INSERT INTO `ciudadano` (`idciudadano`, `nacionalidad`, `cedula`, `tiporif`, `rif`, `primernombre`, `segundonombre`, `primerapellido`, `segundoapellido`, `direccion`, `telefono`, `email`, `estatus`) VALUES
(1, 1, '26903546', 1, '269035468', 'CRISTIAN', 'YOHAN', 'DAZA', 'DIAZ', 'AV. 25 CALLE 36/37 GOAJIRA VIEJA', '04165239920', 'cristandaza21@gmail.com', 1),
(4, 1, '20391877', 1, '203918770', 'JUAN', 'JOSE', 'SOTO', 'PEÑA', 'URB. BELLAS ARTES CALLE FERNANDO DELGADO LOZANO MANZANA 15 SECTOR 4 CASA 304', '04245555800', 'juanjosexdd7@gmail.com', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dpto`
--

CREATE TABLE `dpto` (
  `id` int(2) NOT NULL,
  `coddpto` int(2) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `dpto`
--

INSERT INTO `dpto` (`id`, `coddpto`, `nombre`, `estatus`) VALUES
(1, 1, 'ATENCIÓN CIUDADANO', 1),
(2, 2, 'REGISTRO AGRARIO', 1),
(3, 3, 'RECURSOS NATURALES', 1),
(4, 4, 'AREA TECNICA', 1),
(5, 5, 'AREA LEGAL', 1),
(6, 6, 'INFORMATICA', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dptoestatus`
--

CREATE TABLE `dptoestatus` (
  `id` int(3) NOT NULL,
  `idestatus` int(2) NOT NULL,
  `coddpto` int(2) NOT NULL,
  `orden` int(3) NOT NULL,
  `fechacreacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idusuario` int(5) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `dptoestatus`
--

INSERT INTO `dptoestatus` (`id`, `idestatus`, `coddpto`, `orden`, `fechacreacion`, `idusuario`, `estatus`) VALUES
(1, 0, 1, 1, '2019-06-03 09:59:22', 1, 1),
(3, 1, 1, 2, '2019-06-03 10:00:02', 1, 1),
(4, 1, 2, 2, '2019-06-03 10:00:37', 1, 1),
(6, 2, 3, 3, '2019-06-03 10:01:17', 1, 1),
(9, 3, 4, 4, '2019-06-03 10:05:46', 1, 1),
(10, 4, 5, 5, '2019-06-03 10:05:51', 1, 1),
(15, -1, 1, 0, '2019-06-09 05:12:36', 1, 1),
(16, -1, 2, 0, '2019-06-09 05:12:45', 1, 1),
(17, -1, 3, 0, '2019-06-09 05:12:53', 1, 1),
(18, -1, 4, 0, '2019-06-09 05:13:01', 1, 1),
(19, -1, 5, 0, '2019-06-09 05:13:10', 1, 1),
(20, 5, 5, 6, '2019-06-09 12:52:25', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `codestado` int(2) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `codpais` int(2) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`codestado`, `nombre`, `codpais`, `estatus`) VALUES
(1, 'PORTUGUESA', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus`
--

CREATE TABLE `estatus` (
  `idestatus` int(2) NOT NULL,
  `codestatus` int(2) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `descripcion` varchar(60) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estatus`
--

INSERT INTO `estatus` (`idestatus`, `codestatus`, `nombre`, `descripcion`, `estatus`) VALUES
(1, 0, 'BORRADOR', 'BORRADOR', 1),
(2, 1, 'PENDIENTE', 'PENDIENTE', 1),
(3, 2, 'EN PROCESO', 'EN PROCESO', 1),
(4, 3, 'EN REVISION', 'EN REVISION', 1),
(5, 4, 'EN ESPERA', 'EN ESPERA', 1),
(6, 5, 'FINALIZADO', 'FINALIZADO', 1),
(7, -1, 'ANULADO', 'ANULADO', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maestrotramite`
--

CREATE TABLE `maestrotramite` (
  `codtramite` int(3) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` varchar(60) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `maestrotramite`
--

INSERT INTO `maestrotramite` (`codtramite`, `nombre`, `descripcion`, `estatus`) VALUES
(1, 'REGULARIZACION JURIDICA', 'REGULARIZACION JURIDICA', 1),
(2, 'REGULARIZACION PERSONA NATURAL', 'REGULARIZACION PERSONA NATURAL', 1),
(3, 'REVOCATORIA TITULO INDIVIDUAL', 'REVOCATORIA DE TITULO INDIVIDUAL', 1),
(4, 'REVOCATORIA TITULO COLECTIVO', 'REVOCATORIA DE TITULO COLECTIVO', 1),
(5, 'SUCESIONES', 'SUCESIONES', 1),
(6, 'DENUNCIA TIERRA OCIOSA', 'DENUNCIA DE TIERRA OCIOSA', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maestrotramiterecaudos`
--

CREATE TABLE `maestrotramiterecaudos` (
  `id` int(5) NOT NULL,
  `idrecaudos` int(3) NOT NULL,
  `codtramite` int(3) NOT NULL,
  `cantidad` int(3) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `maestrotramiterecaudos`
--

INSERT INTO `maestrotramiterecaudos` (`id`, `idrecaudos`, `codtramite`, `cantidad`, `estatus`) VALUES
(1, 1, 1, 2, 1),
(2, 2, 1, 1, 1),
(3, 13, 1, 1, 1),
(4, 3, 1, 1, 1),
(5, 5, 1, 2, 1),
(6, 6, 1, 2, 1),
(7, 1, 2, 2, 1),
(8, 3, 2, 2, 1),
(9, 7, 3, 1, 1),
(10, 1, 3, 2, 1),
(11, 8, 3, 1, 1),
(12, 10, 3, 1, 1),
(13, 7, 4, 1, 1),
(14, 1, 4, 2, 1),
(15, 9, 4, 1, 1),
(16, 10, 4, 1, 1),
(17, 11, 5, 2, 1),
(18, 12, 5, 2, 1),
(19, 14, 5, 2, 1),
(20, 4, 5, 1, 1),
(21, 15, 5, 2, 1),
(22, 10, 5, 1, 1),
(23, 1, 6, 2, 1),
(24, 16, 6, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `maestrovisita`
--

CREATE TABLE `maestrovisita` (
  `codvisita` int(3) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` varchar(60) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `maestrovisita`
--

INSERT INTO `maestrovisita` (`codvisita`, `nombre`, `descripcion`, `estatus`) VALUES
(1, 'VISITA PERSONAL', 'VISITA DE INDOLE PERSONAL', 1),
(2, 'VISITA FAMILIAR', 'VISITA DE INDOLE FAMILIAR', 1),
(3, 'VISITA LABORAL', 'VISITA DE INDOLE LABORAL', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipio`
--

CREATE TABLE `municipio` (
  `codmunicipio` int(2) NOT NULL,
  `nombre` varchar(35) NOT NULL,
  `codestado` int(2) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `municipio`
--

INSERT INTO `municipio` (`codmunicipio`, `nombre`, `codestado`, `estatus`) VALUES
(1, 'ARAURE', 1, 1),
(2, 'ESTELLER', 1, 1),
(3, 'GUANARE', 1, 1),
(4, 'GUANARITO', 1, 1),
(5, 'MONSEÑOR JOSE VICENTE UNDA', 1, 1),
(6, 'OSPINO', 1, 1),
(7, 'PAEZ', 1, 1),
(8, 'PAPELON', 1, 1),
(9, 'SAN GENARO DE BOCONOITO', 1, 1),
(10, 'SAN RAFAEL DE ONOTO', 1, 1),
(11, 'SANTA ROSALIA', 1, 1),
(12, 'SUCRE', 1, 1),
(13, 'TUREN', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nacionalidad`
--

CREATE TABLE `nacionalidad` (
  `id` int(2) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `abreviatura` varchar(1) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `nacionalidad`
--

INSERT INTO `nacionalidad` (`id`, `nombre`, `abreviatura`, `estatus`) VALUES
(1, 'VENEZOLANO', 'V', 1),
(2, 'EXTRANJERO', 'E', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetoroles`
--

CREATE TABLE `objetoroles` (
  `id` int(3) NOT NULL,
  `idroles` int(3) NOT NULL,
  `idobjeto` int(3) NOT NULL,
  `fechainicio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechafin` date DEFAULT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetos`
--

CREATE TABLE `objetos` (
  `idobjeto` int(3) NOT NULL,
  `nombre` varchar(35) NOT NULL,
  `descripcion` varchar(70) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetousers`
--

CREATE TABLE `objetousers` (
  `id` int(3) NOT NULL,
  `idusuario` int(5) NOT NULL,
  `idobjeto` int(3) NOT NULL,
  `fechainicio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechafin` date DEFAULT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE `pais` (
  `codpais` int(2) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pais`
--

INSERT INTO `pais` (`codpais`, `nombre`, `estatus`) VALUES
(1, 'VENEZUELA', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parroquia`
--

CREATE TABLE `parroquia` (
  `codparroquia` int(2) NOT NULL,
  `nombre` varchar(35) NOT NULL,
  `codmunicipio` int(2) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `parroquia`
--

INSERT INTO `parroquia` (`codparroquia`, `nombre`, `codmunicipio`, `estatus`) VALUES
(1, 'ARAURE', 1, 1),
(2, 'RIO ACARIGUA', 1, 1),
(3, 'PIRITU', 2, 1),
(4, 'UVERAL', 2, 1),
(5, 'CORDOVA', 3, 1),
(6, 'GUANARE', 3, 1),
(7, 'SAN JOSÉ DE LA MONTAÑA', 3, 1),
(8, 'SAN JUAN DE GUANAGUANARE', 3, 1),
(9, 'VIRGEN DE COROMOTO', 3, 1),
(10, 'GUANARITO', 4, 1),
(11, 'TRINIDAD DE LA CAPILLA', 4, 1),
(12, 'DIVINA PASTORA', 4, 1),
(13, 'PEÑA BLANCA', 5, 1),
(14, 'APARICIÓN', 6, 1),
(15, 'LA ESTACIÓN', 6, 1),
(16, 'OSPINO', 6, 1),
(17, 'ACARIGUA', 7, 1),
(18, 'PAYARA', 7, 1),
(19, 'PIMPINELA', 7, 1),
(20, 'RAMÓN PERAZA', 7, 1),
(21, 'CAÑO DELGADITO', 8, 1),
(22, 'PAPELÓN', 8, 1),
(23, 'ANTOLÍN TOVAR ANQUINO', 9, 1),
(24, 'BOCONOÍTO', 9, 1),
(25, 'SANTA FÉ', 10, 1),
(26, 'SAN RAFAEL DE ONOTO', 10, 1),
(27, 'THERMO MORALES', 10, 1),
(28, 'FLORIDA', 11, 1),
(29, 'EL PLAYÓN', 11, 1),
(30, 'BISCUCUY', 12, 1),
(31, 'CONCEPCIÓN', 12, 1),
(32, 'SAN JOSÉ DE SAGUAZ', 12, 1),
(33, 'SAN RAFAEL DE PALO ALZADO', 12, 1),
(34, 'UVENCIO ANTONIO VELÁSQUEZ', 12, 1),
(35, 'VILLA ROSA', 12, 1),
(36, 'VILLA BRUZUAL', 13, 1),
(37, 'CANELONES', 13, 1),
(38, 'SANTA CRUZ', 13, 1),
(39, 'SAN ISIDRO LABRADOR', 13, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recaudos`
--

CREATE TABLE `recaudos` (
  `idrecaudos` int(3) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `descripcion` varchar(180) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `recaudos`
--

INSERT INTO `recaudos` (`idrecaudos`, `nombre`, `descripcion`, `estatus`) VALUES
(1, 'COPIA CEDULA IDENTIDAD', 'COPIA DE LA CEDULA DE LOS INVOLUCRADOS', 1),
(2, 'ACTA CONSTITUTIVA EMPRESA', 'ACTA CONSTITUTIVA DE LA EMPRESA', 1),
(3, 'CONSTANCIA DE OCUPACIÓN', 'CONSTANCIA DE OCUPACIÓN DEL TERRENO EMITIDA POR EL CONSEJO COMUNAL, INDICANDO LOS LINDEROS.', 1),
(4, 'ORIGINAL DE CONSTANCIA DE OCUPACIÓN', 'FIRMADA POR 3 VOCEROS PRINCIPALES Y CON SELLO HÚMEDO, A NOMBRE DE LA SUCESIÓN Y QUE INDIQUE SUPERFICIE, LINDEROS Y TIEMPO DE OCUPACIÓN.', 1),
(5, 'ACTAS ASAMBLEAS EXTRAORDINARIAS', 'ACTAS DE ASAMBLEAS EXTRAORDINARIA', 1),
(6, 'DOCUMENTO DE TIERRAS', 'DOCUMENTO DE TIERRAS', 1),
(7, 'ORIGINAL DEL TÍTULO', 'ORIGINAL DEL TÍTULO', 1),
(8, 'FORMATO DE RENUNCIA INDIVIDUAL', 'FORMATO DE RENUNCIA INDIVIDUAL', 1),
(9, 'FORMATO DE RENUNCIA COLECTIVA', 'FORMATO DE RENUNCIA COLECTIVA', 1),
(10, 'CARPETA AMARILLA O MARRÓN', 'CARPETA AMARILLA O MARRÓN CON GANCHO TAMAÑO OFICIO', 1),
(11, 'COPIA DECLARACIÓN SUCESORAL', 'COPIA DE LA DECLARACIÓN SUCESORAL', 1),
(12, 'COPIA DEL ACTA DE DEFUNCIÓN', 'COPIA DEL ACTA DE DEFUNCIÓN', 1),
(13, 'RIF', 'REGISTRO DE IDENTIDAD FISCAL', 1),
(14, 'COPIA DE LA CÉDULA DE IDENTIDAD A COLOR', 'COPIA DE LA CÉDULA DE IDENTIDAD A COLOR', 1),
(15, 'COPIA DE RIF', 'COPIA DE RIF', 1),
(16, 'EXPOSICION DE MOTIVO', 'EXPOSICION DE MOTIVO', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rif`
--

CREATE TABLE `rif` (
  `id` int(2) NOT NULL,
  `nombre` varchar(35) NOT NULL,
  `abreviatura` varchar(1) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rif`
--

INSERT INTO `rif` (`id`, `nombre`, `abreviatura`, `estatus`) VALUES
(1, 'VENEZOLANO', 'V', 1),
(2, 'PASAPORTE', 'P', 1),
(3, 'GUBERNAMENTAL', 'G', 1),
(4, 'JURIDICO', 'J', 1),
(5, 'COMUNAS', 'C', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idroles` int(3) NOT NULL,
  `nombre` varchar(35) NOT NULL,
  `descripcion` varchar(70) NOT NULL,
  `fechainicio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechafin` date DEFAULT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idroles`, `nombre`, `descripcion`, `fechainicio`, `fechafin`, `estatus`) VALUES
(1, 'ANALISTA ATEN. CIUDADANO', 'analista', '2019-06-02 00:00:00', NULL, 1),
(2, 'ANALISTA REG. AGRARIO', 'analista', '2019-06-02 00:00:00', NULL, 1),
(3, 'ANALISTA REC. NATURALES', 'analista', '2019-06-05 16:25:39', NULL, 1),
(4, 'ANALISTA AREA TEC.', 'analista', '2019-06-05 16:25:34', NULL, 1),
(5, 'ANALISTA AREA LEGAL', 'analista', '2019-06-05 16:25:21', NULL, 1),
(6, 'ADMINISTRADOR', 'admin', '2019-06-05 16:26:04', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sector`
--

CREATE TABLE `sector` (
  `codsector` int(4) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `codparroquia` int(2) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sector`
--

INSERT INTO `sector` (`codsector`, `nombre`, `codparroquia`, `estatus`) VALUES
(1, 'SECTOR UNO', 1, 1),
(2, 'SECTOR UNO', 17, 1),
(3, 'SECTOR UNO', 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tramite`
--

CREATE TABLE `tramite` (
  `idtramite` int(5) NOT NULL,
  `cedulasolicitante` varchar(12) NOT NULL,
  `codtramite` int(3) NOT NULL,
  `loteterreno` varchar(100) NOT NULL,
  `superficie` varchar(30) NOT NULL,
  `codsector` int(4) NOT NULL,
  `fechainicio` date DEFAULT NULL,
  `fechacreacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `fechafin` datetime DEFAULT NULL,
  `idusuario` int(5) NOT NULL,
  `observacion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tramitedetalle`
--

CREATE TABLE `tramitedetalle` (
  `id` int(5) NOT NULL,
  `idtramite` int(5) NOT NULL,
  `codestatus` int(2) NOT NULL DEFAULT '0',
  `fechacreacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `fechafin` datetime DEFAULT NULL,
  `observaciones` varchar(150) NOT NULL,
  `idusuario` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tramiterecaudos`
--

CREATE TABLE `tramiterecaudos` (
  `id` int(5) NOT NULL,
  `idtramite` int(5) NOT NULL,
  `idrecaudo` int(3) NOT NULL,
  `fechacreacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechafin` datetime DEFAULT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usersroles`
--

CREATE TABLE `usersroles` (
  `id` int(3) NOT NULL,
  `idusuario` int(5) NOT NULL,
  `idroles` int(3) NOT NULL,
  `fechainicio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechafin` date DEFAULT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usersroles`
--

INSERT INTO `usersroles` (`id`, `idusuario`, `idroles`, `fechainicio`, `fechafin`, `estatus`) VALUES
(1, 1, 6, '2019-06-05 16:27:03', NULL, 1),
(2, 2, 1, '2019-06-05 16:48:30', NULL, 1),
(3, 3, 2, '2019-06-05 16:49:03', NULL, 1),
(4, 4, 3, '2019-06-05 16:49:09', NULL, 1),
(5, 5, 4, '2019-06-05 16:49:16', NULL, 1),
(8, 13, 5, '2019-06-05 16:50:43', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(5) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `apellido` varchar(60) NOT NULL,
  `nacionalidad` int(2) NOT NULL,
  `cedula` varchar(12) NOT NULL,
  `fechanacimiento` date NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `email` varchar(40) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `fechaingreso` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechaegreso` datetime DEFAULT NULL,
  `coddpto` int(2) NOT NULL,
  `cargo` int(3) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `password2` varchar(20) NOT NULL,
  `estatus` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `nombre`, `apellido`, `nacionalidad`, `cedula`, `fechanacimiento`, `telefono`, `email`, `direccion`, `fechaingreso`, `fechaegreso`, `coddpto`, `cargo`, `usuario`, `password`, `password2`, `estatus`) VALUES
(1, 'ADMIN', '', 1, '26903546', '1999-07-08', '04145659936', 'admin@inti.com.ve', 'Av. Principal Bellas Artes', '2019-01-01 00:00:00', NULL, 6, 6, 'admin@inti.com.ve', '123456', '123456', 1),
(2, 'ANALISTA 1', 'ANALISTA ATEN. CIUDADANO', 1, '0', '1994-05-03', '04125458136', 'analista1@inti.com.ve', '', '2019-06-05 16:32:12', NULL, 1, 1, 'analista1@inti.com.ve', '123456', '123456', 1),
(3, 'ANALISTA 2', 'ANALISTA REG. AGRARIO', 1, '0', '2019-06-03', '04125458796', 'analista2@inti.com.ve', '', '2019-06-04 16:35:02', NULL, 2, 2, 'analista2@inti.com.ve', '123456', '123456', 1),
(4, 'ANALISTA 3', 'ANALISTA REC. NATURALES', 1, '0', '2019-05-26', '04126985478', 'analista3@inti.com.ve', '', '2019-05-29 16:38:34', NULL, 3, 3, 'analista3@inti.com.ve', '123456', '123456', 1),
(5, 'ANALISTA 4', 'ANALISTA AREA TEC.', 1, '0', '2019-05-27', '04245698965', 'analista4@inti.com.ve', '', '2019-05-28 16:41:15', NULL, 4, 4, 'analista4@inti.com.ve', '123456', '123456', 1),
(13, 'ANALISTA 5', 'ANALISTA AREA LEGAL', 1, '0', '2019-05-16', '04245874123', 'analista5@inti.com.ve', '', '2019-06-05 16:45:48', NULL, 5, 5, 'analista5@inti.com.ve', '123456', '123456', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visita`
--

CREATE TABLE `visita` (
  `idvisita` int(5) NOT NULL,
  `cedulaciudadano` varchar(12) NOT NULL,
  `fechainicio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fechafin` datetime DEFAULT NULL,
  `codvisita` int(3) NOT NULL,
  `motivo` varchar(35) NOT NULL,
  `coddpto` int(2) NOT NULL,
  `idusuario` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `visita`
--

INSERT INTO `visita` (`idvisita`, `cedulaciudadano`, `fechainicio`, `fechafin`, `codvisita`, `motivo`, `coddpto`, `idusuario`) VALUES
(1, '26903546', '2019-06-09 19:46:48', NULL, 1, '', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`idcargo`);

--
-- Indices de la tabla `ciudadano`
--
ALTER TABLE `ciudadano`
  ADD PRIMARY KEY (`idciudadano`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `nacionalidad` (`nacionalidad`,`cedula`) USING BTREE,
  ADD UNIQUE KEY `tiporif` (`tiporif`,`rif`) USING BTREE;

--
-- Indices de la tabla `dpto`
--
ALTER TABLE `dpto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coddpto` (`coddpto`);

--
-- Indices de la tabla `dptoestatus`
--
ALTER TABLE `dptoestatus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idestatus` (`idestatus`) USING BTREE,
  ADD KEY `coddpto` (`coddpto`) USING BTREE,
  ADD KEY `idusuario` (`idusuario`) USING BTREE;

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`codestado`),
  ADD UNIQUE KEY `codpais` (`codpais`,`nombre`) USING BTREE;

--
-- Indices de la tabla `estatus`
--
ALTER TABLE `estatus`
  ADD PRIMARY KEY (`idestatus`),
  ADD UNIQUE KEY `codestatus` (`codestatus`);

--
-- Indices de la tabla `maestrotramite`
--
ALTER TABLE `maestrotramite`
  ADD PRIMARY KEY (`codtramite`);

--
-- Indices de la tabla `maestrotramiterecaudos`
--
ALTER TABLE `maestrotramiterecaudos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idrecaudos_codtramite` (`idrecaudos`,`codtramite`) USING BTREE,
  ADD KEY `idrecaudos` (`idrecaudos`) USING BTREE,
  ADD KEY `codtramite` (`codtramite`) USING BTREE;

--
-- Indices de la tabla `maestrovisita`
--
ALTER TABLE `maestrovisita`
  ADD PRIMARY KEY (`codvisita`);

--
-- Indices de la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD PRIMARY KEY (`codmunicipio`),
  ADD UNIQUE KEY `codestado` (`codestado`,`nombre`) USING BTREE;

--
-- Indices de la tabla `nacionalidad`
--
ALTER TABLE `nacionalidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `objetoroles`
--
ALTER TABLE `objetoroles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idroles` (`idroles`),
  ADD UNIQUE KEY `idobjeto` (`idobjeto`);

--
-- Indices de la tabla `objetos`
--
ALTER TABLE `objetos`
  ADD PRIMARY KEY (`idobjeto`);

--
-- Indices de la tabla `objetousers`
--
ALTER TABLE `objetousers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idusuario` (`idusuario`),
  ADD UNIQUE KEY `idobjeto` (`idobjeto`);

--
-- Indices de la tabla `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`codpais`);

--
-- Indices de la tabla `parroquia`
--
ALTER TABLE `parroquia`
  ADD PRIMARY KEY (`codparroquia`),
  ADD UNIQUE KEY `codmunicipio` (`codmunicipio`,`nombre`) USING BTREE;

--
-- Indices de la tabla `recaudos`
--
ALTER TABLE `recaudos`
  ADD PRIMARY KEY (`idrecaudos`);

--
-- Indices de la tabla `rif`
--
ALTER TABLE `rif`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idroles`);

--
-- Indices de la tabla `sector`
--
ALTER TABLE `sector`
  ADD PRIMARY KEY (`codsector`),
  ADD UNIQUE KEY `codparroquia` (`codparroquia`,`nombre`) USING BTREE;

--
-- Indices de la tabla `tramite`
--
ALTER TABLE `tramite`
  ADD PRIMARY KEY (`idtramite`),
  ADD KEY `cedulasolicitante` (`cedulasolicitante`) USING BTREE,
  ADD KEY `idusuario` (`idusuario`) USING BTREE,
  ADD KEY `codtramite` (`codtramite`) USING BTREE,
  ADD KEY `codsector` (`codsector`) USING BTREE;

--
-- Indices de la tabla `tramitedetalle`
--
ALTER TABLE `tramitedetalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idusuario` (`idusuario`,`id`) USING BTREE,
  ADD KEY `estatus` (`codestatus`,`id`) USING BTREE,
  ADD KEY `idtramite` (`idtramite`,`id`) USING BTREE;

--
-- Indices de la tabla `tramiterecaudos`
--
ALTER TABLE `tramiterecaudos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idtramite` (`idtramite`) USING BTREE,
  ADD KEY `idrecaudo` (`idrecaudo`) USING BTREE;

--
-- Indices de la tabla `usersroles`
--
ALTER TABLE `usersroles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`idusuario`) USING BTREE,
  ADD KEY `idroles` (`idroles`) USING BTREE;

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD KEY `nacionalidad` (`nacionalidad`,`cedula`) USING BTREE,
  ADD KEY `cargo` (`cargo`,`cedula`) USING BTREE,
  ADD KEY `coddpto` (`coddpto`,`cedula`) USING BTREE;

--
-- Indices de la tabla `visita`
--
ALTER TABLE `visita`
  ADD PRIMARY KEY (`idvisita`),
  ADD UNIQUE KEY `codvisita` (`codvisita`,`idvisita`) USING BTREE,
  ADD UNIQUE KEY `idusuario` (`idusuario`,`idvisita`) USING BTREE,
  ADD UNIQUE KEY `cedulaciudadano` (`cedulaciudadano`,`idvisita`) USING BTREE,
  ADD UNIQUE KEY `coddpto` (`coddpto`,`idvisita`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `idcargo` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `ciudadano`
--
ALTER TABLE `ciudadano`
  MODIFY `idciudadano` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `dpto`
--
ALTER TABLE `dpto`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `dptoestatus`
--
ALTER TABLE `dptoestatus`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `codestado` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `estatus`
--
ALTER TABLE `estatus`
  MODIFY `idestatus` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `maestrotramite`
--
ALTER TABLE `maestrotramite`
  MODIFY `codtramite` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `maestrotramiterecaudos`
--
ALTER TABLE `maestrotramiterecaudos`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT de la tabla `maestrovisita`
--
ALTER TABLE `maestrovisita`
  MODIFY `codvisita` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `municipio`
--
ALTER TABLE `municipio`
  MODIFY `codmunicipio` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `nacionalidad`
--
ALTER TABLE `nacionalidad`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `objetoroles`
--
ALTER TABLE `objetoroles`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `objetos`
--
ALTER TABLE `objetos`
  MODIFY `idobjeto` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `objetousers`
--
ALTER TABLE `objetousers`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pais`
--
ALTER TABLE `pais`
  MODIFY `codpais` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `parroquia`
--
ALTER TABLE `parroquia`
  MODIFY `codparroquia` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT de la tabla `recaudos`
--
ALTER TABLE `recaudos`
  MODIFY `idrecaudos` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `rif`
--
ALTER TABLE `rif`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idroles` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `sector`
--
ALTER TABLE `sector`
  MODIFY `codsector` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `tramite`
--
ALTER TABLE `tramite`
  MODIFY `idtramite` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tramitedetalle`
--
ALTER TABLE `tramitedetalle`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tramiterecaudos`
--
ALTER TABLE `tramiterecaudos`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usersroles`
--
ALTER TABLE `usersroles`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `visita`
--
ALTER TABLE `visita`
  MODIFY `idvisita` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ciudadano`
--
ALTER TABLE `ciudadano`
  ADD CONSTRAINT `ciudadano_ibfk_1` FOREIGN KEY (`nacionalidad`) REFERENCES `nacionalidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ciudadano_ibfk_2` FOREIGN KEY (`tiporif`) REFERENCES `rif` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `dptoestatus`
--
ALTER TABLE `dptoestatus`
  ADD CONSTRAINT `dptoestatus_ibfk_1` FOREIGN KEY (`coddpto`) REFERENCES `dpto` (`coddpto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `dptoestatus_ibfk_3` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `dptoestatus_ibfk_4` FOREIGN KEY (`idestatus`) REFERENCES `estatus` (`codestatus`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `estado`
--
ALTER TABLE `estado`
  ADD CONSTRAINT `estado_ibfk_1` FOREIGN KEY (`codpais`) REFERENCES `pais` (`codpais`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `maestrotramiterecaudos`
--
ALTER TABLE `maestrotramiterecaudos`
  ADD CONSTRAINT `maestrotramiterecaudos_ibfk_2` FOREIGN KEY (`codtramite`) REFERENCES `maestrotramite` (`codtramite`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `maestrotramiterecaudos_ibfk_3` FOREIGN KEY (`idrecaudos`) REFERENCES `recaudos` (`idrecaudos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD CONSTRAINT `municipio_ibfk_1` FOREIGN KEY (`codestado`) REFERENCES `estado` (`codestado`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `objetoroles`
--
ALTER TABLE `objetoroles`
  ADD CONSTRAINT `objetoroles_ibfk_1` FOREIGN KEY (`idroles`) REFERENCES `roles` (`idroles`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `objetoroles_ibfk_2` FOREIGN KEY (`idobjeto`) REFERENCES `objetos` (`idobjeto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `objetousers`
--
ALTER TABLE `objetousers`
  ADD CONSTRAINT `objetousers_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `objetousers_ibfk_2` FOREIGN KEY (`idobjeto`) REFERENCES `objetos` (`idobjeto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `parroquia`
--
ALTER TABLE `parroquia`
  ADD CONSTRAINT `parroquia_ibfk_1` FOREIGN KEY (`codmunicipio`) REFERENCES `municipio` (`codmunicipio`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sector`
--
ALTER TABLE `sector`
  ADD CONSTRAINT `sector_ibfk_1` FOREIGN KEY (`codparroquia`) REFERENCES `parroquia` (`codparroquia`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tramite`
--
ALTER TABLE `tramite`
  ADD CONSTRAINT `tramite_ibfk_1` FOREIGN KEY (`cedulasolicitante`) REFERENCES `ciudadano` (`cedula`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tramite_ibfk_4` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tramite_ibfk_5` FOREIGN KEY (`codtramite`) REFERENCES `maestrotramite` (`codtramite`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tramite_ibfk_6` FOREIGN KEY (`codsector`) REFERENCES `sector` (`codsector`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tramitedetalle`
--
ALTER TABLE `tramitedetalle`
  ADD CONSTRAINT `tramitedetalle_ibfk_1` FOREIGN KEY (`idtramite`) REFERENCES `tramite` (`idtramite`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tramitedetalle_ibfk_5` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tramitedetalle_ibfk_6` FOREIGN KEY (`codestatus`) REFERENCES `estatus` (`codestatus`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tramiterecaudos`
--
ALTER TABLE `tramiterecaudos`
  ADD CONSTRAINT `tramiterecaudos_ibfk_1` FOREIGN KEY (`idtramite`) REFERENCES `tramite` (`idtramite`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `tramiterecaudos_ibfk_2` FOREIGN KEY (`idrecaudo`) REFERENCES `maestrotramiterecaudos` (`idrecaudos`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usersroles`
--
ALTER TABLE `usersroles`
  ADD CONSTRAINT `usersroles_ibfk_2` FOREIGN KEY (`idroles`) REFERENCES `roles` (`idroles`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usersroles_ibfk_3` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`nacionalidad`) REFERENCES `nacionalidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`coddpto`) REFERENCES `dpto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `usuario_ibfk_3` FOREIGN KEY (`cargo`) REFERENCES `cargo` (`idcargo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `visita`
--
ALTER TABLE `visita`
  ADD CONSTRAINT `visita_ibfk_1` FOREIGN KEY (`cedulaciudadano`) REFERENCES `ciudadano` (`cedula`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `visita_ibfk_3` FOREIGN KEY (`codvisita`) REFERENCES `maestrovisita` (`codvisita`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `visita_ibfk_4` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `visita_ibfk_5` FOREIGN KEY (`coddpto`) REFERENCES `dpto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
