-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-11-2025 a las 01:59:23
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
-- Base de datos: `db_asus`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(2) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `icono` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `icono`) VALUES
(1, 'Gaming', 'Potencia y velocidad para dominar cualquier juego', 'assets/icon/target.png'),
(2, 'Oficina', 'Rendimiento confiable para tu productividad diaria', 'assets/icon/balance-scale.png'),
(3, 'Estudio', 'Ligeras y eficientes, ideales para tus tareas y clases', 'assets/icon/code.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notebooks`
--

CREATE TABLE `notebooks` (
  `id` int(11) NOT NULL,
  `modelo` varchar(30) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` int(15) NOT NULL,
  `categoria_id` int(2) NOT NULL,
  `img` varchar(10000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `notebooks`
--

INSERT INTO `notebooks` (`id`, `modelo`, `descripcion`, `precio`, `categoria_id`, `img`) VALUES
(1, 'ASUS ROG Strix G15', 'Notebook Gamer con procesador AMD Ryzen 9, 16GB RAM, RTX 3070', 650000, 1, 'assets/img/notebooks/1.png'),
(2, 'ASUS TUF Dash F15', 'Notebook Gamer con Intel i7, 16GB RAM, RTX 3060', 580000, 1, 'assets/img/notebooks/2.png'),
(3, 'ASUS ZenBook 14', 'Notebook ultradelgada para oficina, Intel i5, 8GB RAM, SSD 512GB', 220000, 2, 'assets/img/notebooks/3.png'),
(4, 'ASUS VivoBook 15', 'Notebook para oficina con Intel i3, 8GB RAM, SSD 256GB', 150000, 2, 'assets/img/notebooks/4.png'),
(5, 'ASUS ROG Zephyrus G14', 'Notebook Gamer con AMD Ryzen 9, 16GB RAM, RTX 3060', 620000, 1, 'assets/img/notebooks/5.png'),
(6, 'ASUS ExpertBook B1', 'Notebook para estudio y oficina, Intel i5, 8GB RAM, SSD 512GB', 180000, 3, 'assets/img/notebooks/6.png'),
(7, 'ASUS TUF Gaming A15', 'Notebook Gamer con AMD Ryzen 7, 16GB RAM, GTX 1660Ti', 550000, 1, 'assets/img/notebooks/7.png'),
(8, 'ASUS ZenBook 13', 'Notebook ultracompacta para estudio, Intel i5, 8GB RAM, SSD 256GB', 170000, 3, 'assets/img/notebooks/8.png'),
(9, 'ASUS VivoBook S14', 'Notebook para oficina y estudio, Intel i5, 8GB RAM, SSD 512GB', 200000, 2, 'assets/img/notebooks/9.png'),
(10, 'ASUS ROG Flow X13', 'Notebook Gamer convertible, AMD Ryzen 9, 16GB RAM, RTX 3050', 650000, 1, 'assets/img/notebooks/10.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ofertas`
--

CREATE TABLE `ofertas` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `img` varchar(10000) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ofertas`
--

INSERT INTO `ofertas` (`id`, `titulo`, `descripcion`, `img`, `fecha_inicio`, `fecha_fin`) VALUES
(1, 'black friday', 'wdwdwd', 'dwdwd', '2025-11-12', '2025-11-20'),
(2, 'ro', 'wdwd', 'wdd', '2025-11-04', '2025-11-11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta_notebooks`
--

CREATE TABLE `oferta_notebooks` (
  `id` int(11) NOT NULL,
  `id_oferta` int(11) NOT NULL,
  `id_notebook` int(11) NOT NULL,
  `precio_descuento` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `oferta_notebooks`
--

INSERT INTO `oferta_notebooks` (`id`, `id_oferta`, `id_notebook`, `precio_descuento`) VALUES
(1, 1, 10, 150000.00),
(3, 1, 2, 600000.00),
(5, 1, 9, 100000.00),
(9, 1, 6, 600000.00),
(10, 2, 7, 150.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`user_id`, `username`, `password`, `role`) VALUES
(1, 'webadmin', '$2y$10$Yc2nfHhQlOiHy0HR.mhlku..uZfKFGLwkfCPa77eQ6KzfRzq57ckK', 'Admin'),
(2, 'thiago', '$2y$10$.ULev5kg294pR465YOyME.g3PnH01aQRuQbcee3KC2/wcOQtG9qh.', 'Admin'),
(3, '1234', '$2y$10$TMgbV.6jpsaj6M08XU0LTOeFyYfikAHDU4OPfn8qWuvdBwVRaejw6', 'Admin'),
(4, 'asustechfinal', '$2y$10$Bswf80KSqk5QsVwiM4uaP.XR263WuRL3pxFS7AIKnIG3NszeTFv2m', 'Cliente'),
(5, 'matthew', '$2y$10$xK8Yn4l8VpXJXcKW2ryK6.Sal7ANqOWEBzh.XKCo4JnDicD0JR.mW', 'Cliente'),
(6, 'xd', '$2y$10$8iULknT5trevhDapbrDNkulTtMBafMyhR5rdXHJychsbfIIkvRn5O', 'Cliente');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `notebooks`
--
ALTER TABLE `notebooks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categoria` (`categoria_id`);

--
-- Indices de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `oferta_notebooks`
--
ALTER TABLE `oferta_notebooks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unica_oferta_por_notebook` (`id_notebook`),
  ADD KEY `id_notebook` (`id_notebook`),
  ADD KEY `id_oferta` (`id_oferta`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `notebooks`
--
ALTER TABLE `notebooks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `ofertas`
--
ALTER TABLE `ofertas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `oferta_notebooks`
--
ALTER TABLE `oferta_notebooks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `notebooks`
--
ALTER TABLE `notebooks`
  ADD CONSTRAINT `notebooks_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

--
-- Filtros para la tabla `oferta_notebooks`
--
ALTER TABLE `oferta_notebooks`
  ADD CONSTRAINT `oferta_notebooks_ibfk_1` FOREIGN KEY (`id_notebook`) REFERENCES `notebooks` (`id`),
  ADD CONSTRAINT `oferta_notebooks_ibfk_2` FOREIGN KEY (`id_oferta`) REFERENCES `ofertas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
