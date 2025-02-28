-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-02-2025 a las 14:46:49
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `base_free`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `armas`
--

CREATE TABLE `armas` (
  `ID_arma` int(10) UNSIGNED NOT NULL,
  `ID_tipo` int(10) UNSIGNED NOT NULL,
  `daño` int(10) UNSIGNED DEFAULT NULL CHECK (`daño` >= 0),
  `municion_maxima` int(10) UNSIGNED DEFAULT NULL CHECK (`municion_maxima` >= 0),
  `imagen` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `avatar`
--

CREATE TABLE `avatar` (
  `ID_avatar` int(10) UNSIGNED NOT NULL,
  `imagen` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `avatar`
--

INSERT INTO `avatar` (`ID_avatar`, `imagen`) VALUES
(1, 'avatar/one.gif'),
(2, 'avatar\\two.gif'),
(3, 'avatar/three.gif');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `daño`
--

CREATE TABLE `daño` (
  `ID_daño` int(10) UNSIGNED NOT NULL,
  `daño` int(10) UNSIGNED DEFAULT NULL CHECK (`daño` >= 0),
  `ID_usuario` int(10) UNSIGNED NOT NULL,
  `ID_atacado` int(10) UNSIGNED NOT NULL,
  `ID_arma` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_partidas`
--

CREATE TABLE `detalles_partidas` (
  `ID_det_partida` int(10) UNSIGNED NOT NULL,
  `ID_sala` int(10) UNSIGNED NOT NULL,
  `ID_usuario` int(10) UNSIGNED NOT NULL,
  `partidas_ganadas` int(10) UNSIGNED DEFAULT 0 CHECK (`partidas_ganadas` >= 0),
  `partidas_perdidas` int(10) UNSIGNED DEFAULT 0 CHECK (`partidas_perdidas` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_historial`
--

CREATE TABLE `detalle_historial` (
  `ID_detalle_historial` int(10) UNSIGNED NOT NULL,
  `ID_usuario` int(10) UNSIGNED NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `ID_estado` int(10) UNSIGNED NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`ID_estado`, `estado`) VALUES
(1, 'Activo'),
(2, 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mapas`
--

CREATE TABLE `mapas` (
  `ID_mapa` int(10) UNSIGNED NOT NULL,
  `nombre` enum('BR_clasificatoria','DE_clasificatoria') NOT NULL,
  `imagen` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel`
--

CREATE TABLE `nivel` (
  `id_nivel` int(11) NOT NULL,
  `nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `nivel`
--

INSERT INTO `nivel` (`id_nivel`, `nivel`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidas`
--

CREATE TABLE `partidas` (
  `ID_partida` int(10) UNSIGNED NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `ID_usuario` int(10) UNSIGNED NOT NULL,
  `ID_sala` int(10) UNSIGNED NOT NULL,
  `ID_arma` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `ID_rol` int(10) UNSIGNED NOT NULL,
  `rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`ID_rol`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salas`
--

CREATE TABLE `salas` (
  `ID_sala` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `jugadores_maximos` int(10) UNSIGNED DEFAULT NULL CHECK (`jugadores_maximos` > 0),
  `nivel_requerido` int(10) UNSIGNED DEFAULT NULL CHECK (`nivel_requerido` >= 0),
  `ID_mapa` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_armas`
--

CREATE TABLE `tipo_armas` (
  `ID_tipo` int(10) UNSIGNED NOT NULL,
  `tipo` enum('francotirador','pistola','ametralladora','puño') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID_usuario` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `contrasena` varchar(250) NOT NULL,
  `ID_rol` int(10) UNSIGNED NOT NULL,
  `ID_avatar` int(10) UNSIGNED DEFAULT NULL,
  `ID_estado` int(10) UNSIGNED NOT NULL,
  `puntos` int(10) UNSIGNED DEFAULT 0,
  `vida` int(10) UNSIGNED DEFAULT 100,
  `id_nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID_usuario`, `username`, `email`, `contrasena`, `ID_rol`, `ID_avatar`, `ID_estado`, `puntos`, `vida`, `id_nivel`) VALUES
(475739379, 'TENIENTERADA', 'tenienterada@gmail.com', '$2y$12$kVbXtcMn/U/K5QwoPCjfHu/mRunYCnIpGO5Ko.t0v04.WdAjMDeFW', 2, 3, 1, 0, 100, 1),
(742766878, 'moto292', 'moto292@gmail.com', '$2y$12$ibt9ZngFSHz5QVxcuFus.OkpEgcZC3RfXIsnEW0VBDVqhInGmAh0O', 2, 2, 1, 0, 100, 1),
(3585789783, 'edwar', 'edwar@gmail.com', '$2y$12$yLZfgT4/7d/1eBrBVx59KOMS4dllsXvlSGl0IBhUmtTjtGNLYlXpe', 1, 1, 1, 0, 100, 1),
(4294967295, 'JUANDURAN', 'JUANDURA@gmail.com', '$2y$12$crazscaVJN/tr244qA2Q5evx80olCqXMpqRT9sQSBFxdcbPImSFUm', 2, 2, 1, 0, 100, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `armas`
--
ALTER TABLE `armas`
  ADD PRIMARY KEY (`ID_arma`),
  ADD KEY `ID_tipo` (`ID_tipo`);

--
-- Indices de la tabla `avatar`
--
ALTER TABLE `avatar`
  ADD PRIMARY KEY (`ID_avatar`);

--
-- Indices de la tabla `daño`
--
ALTER TABLE `daño`
  ADD PRIMARY KEY (`ID_daño`),
  ADD KEY `ID_usuario` (`ID_usuario`),
  ADD KEY `ID_atacado` (`ID_atacado`),
  ADD KEY `ID_arma` (`ID_arma`);

--
-- Indices de la tabla `detalles_partidas`
--
ALTER TABLE `detalles_partidas`
  ADD PRIMARY KEY (`ID_det_partida`),
  ADD KEY `ID_sala` (`ID_sala`),
  ADD KEY `ID_usuario` (`ID_usuario`);

--
-- Indices de la tabla `detalle_historial`
--
ALTER TABLE `detalle_historial`
  ADD PRIMARY KEY (`ID_detalle_historial`),
  ADD KEY `ID_usuario` (`ID_usuario`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`ID_estado`);

--
-- Indices de la tabla `mapas`
--
ALTER TABLE `mapas`
  ADD PRIMARY KEY (`ID_mapa`);

--
-- Indices de la tabla `nivel`
--
ALTER TABLE `nivel`
  ADD PRIMARY KEY (`id_nivel`);

--
-- Indices de la tabla `partidas`
--
ALTER TABLE `partidas`
  ADD PRIMARY KEY (`ID_partida`),
  ADD KEY `ID_usuario` (`ID_usuario`),
  ADD KEY `ID_sala` (`ID_sala`),
  ADD KEY `ID_arma` (`ID_arma`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`ID_rol`);

--
-- Indices de la tabla `salas`
--
ALTER TABLE `salas`
  ADD PRIMARY KEY (`ID_sala`),
  ADD KEY `ID_mapa` (`ID_mapa`);

--
-- Indices de la tabla `tipo_armas`
--
ALTER TABLE `tipo_armas`
  ADD PRIMARY KEY (`ID_tipo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `ID_rol` (`ID_rol`),
  ADD KEY `ID_avatar` (`ID_avatar`),
  ADD KEY `ID_estado` (`ID_estado`),
  ADD KEY `id_nivel` (`id_nivel`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `armas`
--
ALTER TABLE `armas`
  MODIFY `ID_arma` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `avatar`
--
ALTER TABLE `avatar`
  MODIFY `ID_avatar` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `daño`
--
ALTER TABLE `daño`
  MODIFY `ID_daño` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalles_partidas`
--
ALTER TABLE `detalles_partidas`
  MODIFY `ID_det_partida` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_historial`
--
ALTER TABLE `detalle_historial`
  MODIFY `ID_detalle_historial` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `ID_estado` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `mapas`
--
ALTER TABLE `mapas`
  MODIFY `ID_mapa` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `partidas`
--
ALTER TABLE `partidas`
  MODIFY `ID_partida` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `ID_rol` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `salas`
--
ALTER TABLE `salas`
  MODIFY `ID_sala` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_armas`
--
ALTER TABLE `tipo_armas`
  MODIFY `ID_tipo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID_usuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4294967296;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `armas`
--
ALTER TABLE `armas`
  ADD CONSTRAINT `armas_ibfk_1` FOREIGN KEY (`ID_tipo`) REFERENCES `tipo_armas` (`ID_tipo`) ON DELETE CASCADE;

--
-- Filtros para la tabla `daño`
--
ALTER TABLE `daño`
  ADD CONSTRAINT `daño_ibfk_1` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `daño_ibfk_2` FOREIGN KEY (`ID_atacado`) REFERENCES `usuarios` (`ID_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `daño_ibfk_3` FOREIGN KEY (`ID_arma`) REFERENCES `armas` (`ID_arma`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalles_partidas`
--
ALTER TABLE `detalles_partidas`
  ADD CONSTRAINT `detalles_partidas_ibfk_1` FOREIGN KEY (`ID_sala`) REFERENCES `salas` (`ID_sala`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalles_partidas_ibfk_2` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_historial`
--
ALTER TABLE `detalle_historial`
  ADD CONSTRAINT `detalle_historial_ibfk_1` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `partidas`
--
ALTER TABLE `partidas`
  ADD CONSTRAINT `partidas_ibfk_1` FOREIGN KEY (`ID_usuario`) REFERENCES `usuarios` (`ID_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `partidas_ibfk_2` FOREIGN KEY (`ID_sala`) REFERENCES `salas` (`ID_sala`) ON DELETE CASCADE,
  ADD CONSTRAINT `partidas_ibfk_3` FOREIGN KEY (`ID_arma`) REFERENCES `armas` (`ID_arma`) ON DELETE CASCADE;

--
-- Filtros para la tabla `salas`
--
ALTER TABLE `salas`
  ADD CONSTRAINT `salas_ibfk_1` FOREIGN KEY (`ID_mapa`) REFERENCES `mapas` (`ID_mapa`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`ID_rol`) REFERENCES `roles` (`ID_rol`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`ID_avatar`) REFERENCES `avatar` (`ID_avatar`) ON DELETE SET NULL,
  ADD CONSTRAINT `usuarios_ibfk_3` FOREIGN KEY (`ID_estado`) REFERENCES `estado` (`ID_estado`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuarios_ibfk_4` FOREIGN KEY (`id_nivel`) REFERENCES `nivel` (`id_nivel`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
