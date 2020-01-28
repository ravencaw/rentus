-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-01-2020 a las 21:01:47
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `rentus`
--
CREATE DATABASE IF NOT EXISTS `rentus` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `rentus`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alerta`
--

DROP TABLE IF EXISTS `alerta`;
CREATE TABLE `alerta` (
  `id` int(11) NOT NULL,
  `id_inmueble` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `alerta`
--

INSERT INTO `alerta` (`id`, `id_inmueble`, `id_usuario`) VALUES
(4, 5, 34);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

DROP TABLE IF EXISTS `cita`;
CREATE TABLE `cita` (
  `id` int(11) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `id_usuario1` int(11) NOT NULL,
  `id_usuario2` int(11) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `ciudad` varchar(255) NOT NULL,
  `longitud` varchar(255) NOT NULL,
  `latitud` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`id`, `fecha_hora`, `id_usuario1`, `id_usuario2`, `direccion`, `ciudad`, `longitud`, `latitud`) VALUES
(1, '2020-02-04 19:00:00', 34, 1, 'Calle Galera 17', 'Sevilla', '-5.999035', '37.3880055'),
(2, '2020-01-18 20:15:00', 2, 1, 'Plaza Nueva 7', 'Granada', '', ''),
(3, '2020-02-03 21:10:00', 2, 34, 'Calle Imperial 43', 'Sevilla', '-5.985995', '37.3901403'),
(5, '2020-01-29 16:30:00', 34, 1, 'Coso Viejo', 'ANTEQUERA', '-4.5579117', '37.0169032');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favorito`
--

DROP TABLE IF EXISTS `favorito`;
CREATE TABLE `favorito` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_inmueble` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `favorito`
--

INSERT INTO `favorito` (`id`, `id_usuario`, `id_inmueble`) VALUES
(4, 34, 1),
(7, 34, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foto`
--

DROP TABLE IF EXISTS `foto`;
CREATE TABLE `foto` (
  `id` int(11) NOT NULL,
  `id_inmueble` int(11) NOT NULL,
  `ruta` text COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `foto`
--

INSERT INTO `foto` (`id`, `id_inmueble`, `ruta`) VALUES
(1, 1, 'maxresdefault.jpg'),
(2, 1, 'maxresdefault1.jpg'),
(3, 2, 'maxresdefault2.jpg'),
(4, 2, 'maxresdefault3.jpg'),
(6, 5, 'apartamento-samy-e-ricky-lapa360-01.jpg'),
(7, 5, 'imagem31-4.jpg'),
(8, 5, 'skyline.jpg'),
(9, 1, 'skyline.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inmobiliaria`
--

DROP TABLE IF EXISTS `inmobiliaria`;
CREATE TABLE `inmobiliaria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `direccion` text COLLATE utf8_spanish2_ci NOT NULL,
  `nif` varchar(7) COLLATE utf8_spanish2_ci NOT NULL,
  `telefono` int(9) NOT NULL,
  `id_usuario_admin` int(11) NOT NULL,
  `logo` text COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `inmobiliaria`
--

INSERT INTO `inmobiliaria` (`id`, `nombre`, `direccion`, `nif`, `telefono`, `id_usuario_admin`, `logo`) VALUES
(5, 'Inmo1', 'Calle nueva', '2433543', 656345345, 34, 'C:\\xampp\\tmp\\phpCC24.tmp'),
(6, 'Inmobiliaria Juan Alberto', 'Calle Falsa 2', '342344A', 667678678, 36, 'C:\\xampp\\tmp\\php1DC4.tmp');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inmueble`
--

DROP TABLE IF EXISTS `inmueble`;
CREATE TABLE `inmueble` (
  `id` int(11) NOT NULL,
  `tipo_inmueble` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `precio` float NOT NULL,
  `superficie` float NOT NULL,
  `direccion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `zona` varchar(255) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'centro',
  `ciudad` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `cp` int(11) NOT NULL,
  `longitud` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `latitud` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `habitaciones` int(11) NOT NULL,
  `bathroom` int(11) NOT NULL,
  `comentarios` text COLLATE utf8_spanish2_ci NOT NULL,
  `extras` text COLLATE utf8_spanish2_ci NOT NULL,
  `id_creador` int(11) NOT NULL,
  `disponible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `inmueble`
--

INSERT INTO `inmueble` (`id`, `tipo_inmueble`, `precio`, `superficie`, `direccion`, `zona`, `ciudad`, `cp`, `longitud`, `latitud`, `habitaciones`, `bathroom`, `comentarios`, `extras`, `id_creador`, `disponible`) VALUES
(1, 'venta', 260000, 150, 'Calle Encarnacion nº9', 'centro', 'ANTEQUERA', 29202, '-4.5579117', '37.0169032', 3, 2, 'Piso en pleno centro de Antequera', 'Terraza, calefaccion, aire acondicionado', 34, 1),
(2, 'venta', 160000, 100, 'Calle Toril nº12 2ºA', 'centro', 'ANTEQUERA', 29200, '', '', 2, 1, 'Piso en la calle Toril', 'Calefaccion, bañera', 2, 0),
(3, 'alquiler', 420, 90, 'Calle Galera 17', 'centro', 'SEVILLA', 41001, '-5.999035', '37.3880055', 2, 2, 'Piso en pleno centro de Sevilla', '1 sala de estar\r\n1 salon\r\n1 cocina\r\nAmueblado', 34, 1),
(5, 'venta', 350000, 100, 'Calle Trasierras 5', 'centro', 'ANTEQUERA', 29200, '-4.5574382', '37.0198236', 3, 1, 'Piso amueblado en pleno centro de Antequera', 'Amueblado\r\nTerraza', 34, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

DROP TABLE IF EXISTS `mensaje`;
CREATE TABLE `mensaje` (
  `id` int(11) NOT NULL,
  `id_receptor` int(11) NOT NULL,
  `id_inmueble` int(11) NOT NULL,
  `correo` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `telefono` int(11) NOT NULL,
  `asunto` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `texto` text COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `mensaje`
--

INSERT INTO `mensaje` (`id`, `id_receptor`, `id_inmueble`, `correo`, `telefono`, `asunto`, `fecha`, `texto`) VALUES
(1, 34, 1, 'pabloz@mail.com', 667786786, 'Concertar visita', '2020-01-28 18:12:07', 'dfsdfdfsdf'),
(2, 34, 1, 'pedroperez@mail.com', 654789821, 'Concertar visita', '2020-01-28 18:13:07', 'Quisiera concertar una cita para ver el inmueble'),
(3, 34, 1, 'mepicaunpie@mail.com', 675893290, 'Concertar visita', '2020-01-28 18:17:16', 'Quiero concertar una cita'),
(4, 2, 2, 'mepicaunpie@mail.com', 654789821, 'Concertar visita', '2020-01-28 18:36:29', 'Quisiera concertar una cita'),
(5, 34, 1, 'pepe@mail.com', 685903102, 'Concertar visita', '2020-01-28 19:43:44', 'Quiero concertar una cita');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `correo` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `telefono` int(9) NOT NULL,
  `password` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `id_inmobiliaria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `correo`, `telefono`, `password`, `id_inmobiliaria`) VALUES
(1, 'Pepe', 'pepe@mail.com', 645556677, 'pepe1234', NULL),
(2, 'Juan', 'juan@mail.com', 657452375, 'juan1234', NULL),
(7, 'Pablo Perez', 'pabper@mail.com', 685749632, 'pabper', NULL),
(34, 'Pedro Perez', 'pedper@mail.com', 685849632, 'pedper', 5),
(35, 'Juan Benitez', 'juaben@mail.com', 684990930, 'juaben', NULL),
(36, 'Juan Alberto', 'juanalb@mail.com', 677867876, 'juanalb', 6);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alerta`
--
ALTER TABLE `alerta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `favorito`
--
ALTER TABLE `favorito`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `foto`
--
ALTER TABLE `foto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inmobiliaria`
--
ALTER TABLE `inmobiliaria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inmueble`
--
ALTER TABLE `inmueble`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alerta`
--
ALTER TABLE `alerta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `favorito`
--
ALTER TABLE `favorito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `foto`
--
ALTER TABLE `foto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `inmobiliaria`
--
ALTER TABLE `inmobiliaria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `inmueble`
--
ALTER TABLE `inmueble`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
