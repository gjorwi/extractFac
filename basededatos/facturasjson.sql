-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-04-2023 a las 09:46:54
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `facturasjson`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datafields`
--

CREATE TABLE `datafields` (
  `id` int(11) NOT NULL,
  `idDocJson` varchar(50) NOT NULL,
  `custName` varchar(200) NOT NULL,
  `date` date NOT NULL,
  `docType` varchar(30) NOT NULL,
  `dueDate` date NOT NULL,
  `invoNum` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datajson`
--

CREATE TABLE `datajson` (
  `id` int(11) NOT NULL COMMENT 'Id extract facturajson',
  `idDoc` varchar(50) NOT NULL COMMENT 'Id del doumento extraido',
  `jsonDatFact` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'datos facturajson' CHECK (json_valid(`jsonDatFact`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itemsfact`
--

CREATE TABLE `itemsfact` (
  `id` int(11) NOT NULL,
  `idDocFact` varchar(50) NOT NULL,
  `unitPrice` int(11) NOT NULL,
  `totAmount` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `datafields`
--
ALTER TABLE `datafields`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `idDocJson` (`idDocJson`);

--
-- Indices de la tabla `datajson`
--
ALTER TABLE `datajson`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idDoc` (`idDoc`);

--
-- Indices de la tabla `itemsfact`
--
ALTER TABLE `itemsfact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idDocFact` (`idDocFact`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `datafields`
--
ALTER TABLE `datafields`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `datajson`
--
ALTER TABLE `datajson`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id extract facturajson', AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `itemsfact`
--
ALTER TABLE `itemsfact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `datafields`
--
ALTER TABLE `datafields`
  ADD CONSTRAINT `datafields_ibfk_1` FOREIGN KEY (`idDocJson`) REFERENCES `datajson` (`idDoc`);

--
-- Filtros para la tabla `itemsfact`
--
ALTER TABLE `itemsfact`
  ADD CONSTRAINT `itemsfact_ibfk_1` FOREIGN KEY (`idDocFact`) REFERENCES `datafields` (`idDocJson`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
