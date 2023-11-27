-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 26-11-2023 a las 17:59:27
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `Anuncios`
--

INSERT INTO `Anuncios` (`id`, `idUsuario`, `titulo`, `descripcion`, `fecha_creacion`, `precio`) VALUES
(17, 5, 'Tulipanes', 'Vendo preciosos ramos de tulipanes en color rojo, amarillo y naranja.', '2023-11-26 10:46:35', '12.00'),
(19, 5, 'Rosas', 'Ramos en color rojo y blanco', '2023-11-26 10:54:02', '32.00'),
(20, 5, 'Lilium', 'Ramos de lilium en blanco y en rosa.', '2023-11-26 10:55:44', '24.00'),
(21, 3, 'paraguas', 'en perfecto estado.', '2023-11-26 10:59:27', '18.60'),
(22, 3, 'gallinas', 'pregunte sin compromiso', '2023-11-26 11:00:20', '6.50'),
(23, 3, 'abrigo', 'Abrigo reversible, practicamente nuevo.', '2023-11-26 11:03:37', '25.00'),
(24, 3, 'espejo', 'En perfecto estado.', '2023-11-26 11:04:53', '20.00'),
(25, 3, 'ropa bebe', 'lote de ropa variada de bebé', '2023-11-26 11:08:06', '50.00'),
(26, 6, 'iphone 13', 'a estrenar', '2023-11-26 11:09:29', '500.00'),
(27, 6, 'Maus ', 'novela gráfica.', '2023-11-26 11:10:04', '8.00'),
(28, 6, 'skyrim', 'juego en buen estado', '2023-11-26 11:10:33', '12.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `FotosAnuncios`
--

CREATE TABLE `FotosAnuncios` (
  `id` int NOT NULL,
  `idAnuncio` int DEFAULT NULL,
  `ruta_foto` varchar(255) DEFAULT NULL,
  `foto_principal` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `FotosAnuncios`
--

INSERT INTO `FotosAnuncios` (`id`, `idAnuncio`, `ruta_foto`, `foto_principal`) VALUES
(27, 17, 'fotosAnuncios/5cab8a722d2548b91643f22d136063a1.jpeg', 0),
(28, 17, 'fotosAnuncios/2953af0e2f472bb59f149cc8b7936382.jpeg', 1),
(29, 17, 'fotosAnuncios/46a56b0bdaeb096a731d98a023ada389.jpeg', 0),
(32, 19, 'fotosAnuncios/a13001222a69e0fdde32274214da219d.jpeg', 1),
(33, 19, 'fotosAnuncios/2c2c6666b8924d725c5bf1eddeb40147.jpeg', NULL),
(34, 20, 'fotosAnuncios/ea391beb4b03e3404fcf4c7275166f3a.jpeg', 1),
(35, 20, 'fotosAnuncios/a854527b8355d55c3ec460d5c3516532.jpeg', NULL),
(36, 21, 'fotosAnuncios/26e2d2ff73179d60aa2eedb8bdf3a343.webp', 1),
(37, 22, 'fotosAnuncios/eab03255e0640e994f4c8ddf7eb487af.jpeg', 1),
(38, 22, 'fotosAnuncios/d59836e0cc42871ad608b38a0bb5535f.jpg', NULL),
(39, 23, 'fotosAnuncios/02d0b1f185e9abcfe0cb4dceeb35a88f.webp', 1),
(40, 23, 'fotosAnuncios/c175cefa2b36386895f73b8b01d8f590.webp', NULL),
(41, 24, 'fotosAnuncios/43f8e0b193e224103f6751ee26215cd4.webp', 1),
(42, 25, 'fotosAnuncios/76f8b793e7cee5365ab1e983b85e5482.webp', 1),
(43, 25, 'fotosAnuncios/2897d45ee30e414ad89fbc5dc1adcc2d.webp', 0),
(44, 25, 'fotosAnuncios/619d8c3edcdae00fb85988db4547c83e.webp', 0),
(45, 25, 'fotosAnuncios/e5d7c0e0a72cd43b81e694e0a9566e53.webp', 0),
(46, 26, 'fotosAnuncios/3b9a0ec93fc10a3008d0b9ea842d5a0c.webp', 1),
(47, 27, 'fotosAnuncios/e30e89b8ac1673bb539a0c46fd026021.webp', 1),
(48, 27, 'fotosAnuncios/2c9d8b67f7370f0a67a6155193803e9f.webp', NULL),
(49, 28, 'fotosAnuncios/f8cd9171b56c3269ddddb774694e0238.webp', 1),
(50, 28, 'fotosAnuncios/58e521f7191c6714c8cacb420fd923a4.webp', NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `FotosAnuncios`
--
ALTER TABLE `FotosAnuncios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

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
