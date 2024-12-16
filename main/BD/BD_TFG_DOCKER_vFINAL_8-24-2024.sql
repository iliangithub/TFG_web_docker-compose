-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-06-2024 a las 11:43:31
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

-- NO HAY QUE PONER CREATE DATABASE NI DROP DATABASE NI EL USE
-- YA HAY UN SCRIPT QUE TE HACE ESO el init-db.sh

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tfg_docker`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_compra`
--

CREATE TABLE `carrito_compra` (
  `id_curso_fk` int(11) NOT NULL,
  `id_usuario_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprados`
--

CREATE TABLE `comprados` (
  `id_comprado` int(11) NOT NULL,
  `id_curso_comprado_fk` int(11) NOT NULL,
  `id_usuario_comprado_fk` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cupones`
--

CREATE TABLE `cupones` (
  `id_cupon` int(11) NOT NULL,
  `codigo_cupon` varchar(25) NOT NULL,
  `descuento` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cupones`
--

INSERT INTO `cupones` (`id_cupon`, `codigo_cupon`, `descuento`) VALUES
(1, 'abcd1234', '10'),
(2, '1234canovas2024', '9'),
(3, 'ilianilievlubenov', '50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cupones_son_canjeados`
--

CREATE TABLE `cupones_son_canjeados` (
  `id_cupon_fk` int(11) NOT NULL,
  `id_usuario_fk` int(11) NOT NULL,
  `ha_sido_utilizado` varchar(4) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id_curso` int(11) NOT NULL,
  `curso` varchar(100) NOT NULL,
  `profesor` varchar(50) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `precio` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id_curso`, `curso`, `profesor`, `tipo`, `precio`) VALUES
(1, 'Módulo 1: Presentación del Programa Avanzado', 'Javier Ibañez', 'trading', '15.89'),
(2, 'Módulo 2: Macroeconomía y Política Monetaria', 'Javier Ibañez', 'trading', '15.89'),
(3, 'Módulo 3: Análisis Fundamental', 'Javier Ibañez', 'trading', '15.89'),
(4, 'Módulo 4: Análisis Técnico. Teoría de Dow', 'Javier Ibañez', 'trading', '15.89'),
(5, 'Módulo 5: Análisis Técnico. Ondas de Elliot', 'Javier Ibañez', 'trading', '15.89'),
(6, 'Módulo 6: Chartismo', 'Javier Ibañez', 'trading', '15.89'),
(7, 'Módulo 7: Indicadores técnicos', 'Javier Ibañez', 'trading', '15.89'),
(8, 'Módulo 8: Gestión monetaria y control del riesgo', 'Javier Ibañez', 'trading', '15.89'),
(9, 'Módulo 9: Sistemas de Trading', 'Javier Ibañez', 'trading', '15.89'),
(10, 'Módulo 10: Plan de Trading', 'Javier Ibañez', 'trading', '15.89'),
(11, 'Módulo 11: Estrategias de Trading', 'Javier Ibañez', 'trading', '15.89'),
(12, 'Módulo 12: Price Action', 'Javier Ibañez', 'trading', '15.89'),
(13, 'Módulo 13: Psicotrading', 'Javier Ibañez', 'trading', '15.89'),
(14, 'Módulo 14: Herramientas de Trading', 'Javier Ibañez', 'trading', '10.50'),
(15, 'Módulo 1: Introducción al comercio electrónico', 'Ignacio Pedrosa Robles', 'ecommerce', '15.89'),
(16, 'Módulo 2: Investigación', 'Javier Pedrosa Robles', 'ecommerce', '15.89'),
(17, 'Módulo 3: Mejores prácticas, Benchmarking aprendizaje de los competidores', 'Ignacio Pedrosa Robles', 'ecommerce', '15.89'),
(18, 'Módulo 4: Método CANVAS', 'Ignacio Pedrosa Robles', 'ecommerce', '15.89'),
(19, 'Módulo 5: Técnicas LEAN', 'Ignacio Pedrosa Robles', 'ecommerce', '15.89'),
(20, 'Módulo 6: Digitalización de negocios existentes', 'Ignacio Pedrosa Robles', 'ecommerce', '15.89'),
(21, 'Módulo 7: Productos digitales', 'Ignacio Pedrosa Robles', 'ecommerce', '15.89'),
(22, 'Módulo 8: Multiplataforma', 'Ignacio Pedrosa Robles', 'ecommerce', '15.89'),
(23, 'Módulo 9: Disrupción', 'Ignacio Pedrosa Robles', 'ecommerce', '15.89'),
(24, 'Módulo 10: Fijación de precios', 'Ignacio Pedrosa Robles', 'ecommerce', '15.89'),
(25, 'Módulo 11: Logística', 'Ignacio Pedrosa Robles', 'ecommerce', '15.89'),
(26, 'Módulo 12: Fiscalidad', 'Ignacio Pedrosa Robles', 'ecommerce', '15.89'),
(27, 'Módulo 13: Ofertas locales', 'Ignacio Pedrosa Robles', 'ecommerce', '15.89'),
(28, 'Módulo 14: Tipos de redes sociales', 'Ignacio Pedrosa Robles', 'ecommerce', '10.50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `email` varchar(75) NOT NULL,
  `nombre` varchar(75) DEFAULT NULL,
  `primerapellido` varchar(75) DEFAULT NULL,
  `segundoapellido` varchar(75) DEFAULT NULL,
  `prefijo_telefono` varchar(25) DEFAULT NULL,
  `telefono` varchar(12) DEFAULT NULL,
  `direccion` varchar(125) DEFAULT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expira_en` datetime DEFAULT NULL,
  `saldo` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito_compra`
--
ALTER TABLE `carrito_compra`
  ADD KEY `id_curso_fk` (`id_curso_fk`),
  ADD KEY `id_usuario_fk` (`id_usuario_fk`);

--
-- Indices de la tabla `comprados`
--
ALTER TABLE `comprados`
  ADD PRIMARY KEY (`id_comprado`),
  ADD KEY `id_curso_comprado_fk` (`id_curso_comprado_fk`),
  ADD KEY `id_usuario_comprado_fk` (`id_usuario_comprado_fk`);

--
-- Indices de la tabla `cupones`
--
ALTER TABLE `cupones`
  ADD PRIMARY KEY (`id_cupon`);

--
-- Indices de la tabla `cupones_son_canjeados`
--
ALTER TABLE `cupones_son_canjeados`
  ADD PRIMARY KEY (`id_cupon_fk`,`id_usuario_fk`),
  ADD KEY `fk_usuario_cupon` (`id_usuario_fk`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id_curso`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comprados`
--
ALTER TABLE `comprados`
  MODIFY `id_comprado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cupones`
--
ALTER TABLE `cupones`
  MODIFY `id_cupon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito_compra`
--
ALTER TABLE `carrito_compra`
  ADD CONSTRAINT `fk_curso_carrito` FOREIGN KEY (`id_curso_fk`) REFERENCES `cursos` (`id_curso`),
  ADD CONSTRAINT `fk_usuario_carrito` FOREIGN KEY (`id_usuario_fk`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `comprados`
--
ALTER TABLE `comprados`
  ADD CONSTRAINT `fk_curso_comprado` FOREIGN KEY (`id_curso_comprado_fk`) REFERENCES `cursos` (`id_curso`),
  ADD CONSTRAINT `fk_usuario_comprado` FOREIGN KEY (`id_usuario_comprado_fk`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `cupones_son_canjeados`
--
ALTER TABLE `cupones_son_canjeados`
  ADD CONSTRAINT `fk_cupon_canjeado` FOREIGN KEY (`id_cupon_fk`) REFERENCES `cupones` (`id_cupon`),
  ADD CONSTRAINT `fk_usuario_cupon` FOREIGN KEY (`id_usuario_fk`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
