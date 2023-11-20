-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 20-11-2023 a las 13:55:20
-- Versión del servidor: 8.0.34-0ubuntu0.22.04.1
-- Versión de PHP: 8.1.2-1ubuntu2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `Wallapop`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Anuncios`
--

CREATE TABLE `Anuncios` (
  `id` int NOT NULL,
  `idUsuario` int DEFAULT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` text,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `Anuncios`
--

INSERT INTO `Anuncios` (`id`, `idUsuario`, `titulo`, `descripcion`, `fecha_creacion`, `precio`) VALUES
(2, 3, 'gallinas', '2', '2023-11-19 17:00:04', '2.00'),
(5, 5, 'tulipanes', 'ramos de tulipanes en rojo,naranja y amarillo', '2023-11-20 07:53:34', '12.00'),
(6, 5, 'rosas', 'ramos de rosas en blancco y rojo', '2023-11-20 07:54:24', '36.00'),
(7, 6, 'Iphone 13', 'casi nuevo', '2023-11-20 08:15:13', '540.00'),
(8, 3, 'paraguas', 'es plegable', '2023-11-20 08:43:25', '12.00'),
(9, 6, 'Jarrón', 'cerámica pintada a mano', '2023-11-20 08:57:47', '12.00'),
(10, 6, 'Maus ', 'novela gráfica', '2023-11-20 12:49:44', '12.00'),
(11, 3, 'skyrim', 'casi nuevo', '2023-11-20 12:52:55', '12.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FotosAnuncios`
--

CREATE TABLE `FotosAnuncios` (
  `id` int NOT NULL,
  `idAnuncio` int DEFAULT NULL,
  `ruta_foto` varchar(255) DEFAULT NULL,
  `foto_principal` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `FotosAnuncios`
--

INSERT INTO `FotosAnuncios` (`id`, `idAnuncio`, `ruta_foto`, `foto_principal`) VALUES
(1, 2, 'fotosAnuncios/557e40cfaeef0f8bc44c1d2e86461e63.', 1),
(2, 2, 'fotosAnuncios/7f48e10132622264f837d990a0561814.', NULL),
(8, 5, 'fotosAnuncios/2be3d7ba502574ada16c5f1b9b78b0f7.', 1),
(9, 5, 'fotosAnuncios/26ed1ac87b0d4a62388268a20c3dfc9c.', NULL),
(10, 5, 'fotosAnuncios/801d51be00fd77df75ab5a508271e840.', NULL),
(11, 6, 'fotosAnuncios/b472b45a0da89f48958cee7d98a1bb44.', 1),
(12, 6, 'fotosAnuncios/cf92316c7da548c957d12f484db955a7.', NULL),
(13, 7, 'fotosAnuncios/a6780eab4f351004b8bfec18c0c9ffc7.', 1),
(14, 8, 'fotosAnuncios/1c69751cf40309239f243b9797b15dde.', 1),
(15, 9, 'fotosAnuncios/7448b053a56506be66d11bb77ce5fbfb.', 1),
(16, 9, 'fotosAnuncios/93ad575537cc0b6bfd564c2fa54b6107.', NULL),
(17, 10, 'fotosAnuncios/45c5f8bfdb8d149e339f95833b54154d.', 1),
(18, 10, 'fotosAnuncios/98062c39659ee3dfba0e94aa539532ef.', NULL),
(19, 11, 'fotosAnuncios/33b2da35c6113c492b67ecef52f3f708.', 1),
(20, 11, 'fotosAnuncios/09402f20b656df0777faeea3d607e167.', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

CREATE TABLE `Usuarios` (
  `id` int NOT NULL,
  `sid` varchar(200) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `poblacion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `Usuarios`
--

INSERT INTO `Usuarios` (`id`, `sid`, `email`, `password`, `nombre`, `telefono`, `poblacion`) VALUES
(2, '4ed95f202d1a6005bf9b940da3c1ceb152aaa88c', 'nuevo@nuevo.com', '$2y$10$GM/6eGu4/XlC6TGaRxgry.yc/p5pQLijhbXqmviSPBfH.I.truE0y', 'nuevo', '636727272', 'Toledo'),
(3, '50b142d503fb27b1fd07fffcfb4365fe0142df68', 'san@correo.com', '$2y$10$.6jH1xQ2sOChuLaRbMjRFOEACipIgC27VfmWGnS2HBQfArVao31be', 'Sandra Bautista', '654232314', 'Toledo'),
(5, '7fb74fafb74d0b0271bfedade158095757864fe3', 'patri@hotmail.com', '$2y$10$l6N2yxVmaHc.s1cc.Hza9O5xW0cxv53IcVgoQmQQmacf/kVqNJk3a', 'Patricia Romero', '675949403', 'Madrid'),
(6, 'ae44c083e771d377d594917d88247e97f1d7068d', 'david@correo.com', '$2y$10$HhkvbZhUvul9Y5su8adFv.Wcy.m0Gt.xg62yYMo/2yzqqF//94pYW', 'David Barrilero', '675949403', 'Puertollano');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Anuncios`
--
ALTER TABLE `Anuncios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`idUsuario`);

--
-- Indices de la tabla `FotosAnuncios`
--
ALTER TABLE `FotosAnuncios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anuncio_id` (`idAnuncio`);

--
-- Indices de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Anuncios`
--
ALTER TABLE `Anuncios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `FotosAnuncios`
--
ALTER TABLE `FotosAnuncios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Anuncios`
--
ALTER TABLE `Anuncios`
  ADD CONSTRAINT `Anuncios_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `Usuarios` (`id`);

--
-- Filtros para la tabla `FotosAnuncios`
--
ALTER TABLE `FotosAnuncios`
  ADD CONSTRAINT `FotosAnuncios_ibfk_1` FOREIGN KEY (`idAnuncio`) REFERENCES `Anuncios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
