-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 02-12-2023 a las 22:12:59
-- Versión del servidor: 8.0.34
-- Versión de PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `Granja`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consumos`
--

CREATE TABLE `consumos` (
  `id_consumo` int NOT NULL,
  `id_dieta` int DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `lote` int NOT NULL,
  `inversion` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Disparadores `consumos`
--
DELIMITER $$
CREATE TRIGGER `AfterInsertConsumos` AFTER INSERT ON `consumos` FOR EACH ROW BEGIN
    DECLARE p_TotalInversion FLOAT;

    -- Calcular la inversión total de consumos actualizados
    SELECT COALESCE(SUM(inversion), 0) INTO p_TotalInversion
    FROM Granja.consumos
    WHERE lote = NEW.lote;

    -- Actualizar el historial existente para ese lote
    UPDATE Granja.historial
    SET fecha_2 = NEW.fecha, dinero = p_TotalInversion
    WHERE lote = NEW.lote AND fecha_2 IS NULL;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `DetalleDieta`
--

CREATE TABLE `DetalleDieta` (
  `idDetalleDieta` int NOT NULL,
  `id_dieta` int NOT NULL,
  `id_producto` int NOT NULL,
  `cantidad` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Dieta`
--

CREATE TABLE `Dieta` (
  `id_dieta` int NOT NULL,
  `Dieta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Factura`
--

CREATE TABLE `Factura` (
  `No_fact` int NOT NULL,
  `Origen` varchar(150) NOT NULL,
  `Destino` varchar(150) NOT NULL,
  `Total` float NOT NULL,
  `Tipo_VC` varchar(25) NOT NULL,
  `Proposito` text NOT NULL,
  `Especie` varchar(50) NOT NULL,
  `Lote` int NOT NULL,
  `Fecha` datetime NOT NULL,
  `No_trans` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Disparadores `Factura`
--
DELIMITER $$
CREATE TRIGGER `AfterInsertFactura` AFTER INSERT ON `Factura` FOR EACH ROW BEGIN
    IF NEW.Tipo_VC = 'venta' THEN
        -- Insertar o actualizar Lote con Factura
        INSERT INTO Granja.Lote(Lote, Peso_Lote, Estado, Llegada, Salida, Cantidad)
        VALUES (NEW.Lote, NULL, 'Engorda', NEW.Fecha, NULL, 0)
        ON DUPLICATE KEY UPDATE
            Llegada = NEW.Fecha;

        -- Actualizar el historial
        INSERT INTO Granja.historial(lote, fecha_1, fecha_2, dinero)
        VALUES (NEW.Lote, NEW.Fecha, NULL, 0);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `AfterInsertFacturaVenta` AFTER INSERT ON `Factura` FOR EACH ROW BEGIN
    CALL UpdateHistorialAfterInsertFactura(NEW.Lote, NEW.Tipo_VC, NEW.Fecha, NEW.Total);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ganadero`
--

CREATE TABLE `ganadero` (
  `psg` varchar(12) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `razonsocial` varchar(100) NOT NULL,
  `domicilio` varchar(150) NOT NULL,
  `localidad` varchar(150) NOT NULL,
  `Municipio` varchar(100) NOT NULL,
  `Estado` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Ganado`
--

CREATE TABLE `Ganado` (
  `No_Arete` varchar(50) NOT NULL,
  `Sexo` bit(1) NOT NULL,
  `Edad` int NOT NULL,
  `Lote` int NOT NULL,
  `Peso` float NOT NULL,
  `Estado` varchar(50) NOT NULL,
  `Precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Disparadores `Ganado`
--
DELIMITER $$
CREATE TRIGGER `ActualizarPesoCantidadLote_Delete` AFTER DELETE ON `Ganado` FOR EACH ROW BEGIN
    UPDATE Granja.Lote
    SET Peso_Lote = (SELECT SUM(Peso) FROM Granja.Ganado WHERE Lote = OLD.Lote),
        Cantidad = (SELECT COUNT(*) FROM Granja.Ganado WHERE Lote = OLD.Lote)
    WHERE Lote = OLD.Lote;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ActualizarPesoCantidadLote_Insert` AFTER INSERT ON `Ganado` FOR EACH ROW BEGIN
    UPDATE Granja.Lote
    SET Peso_Lote = (SELECT SUM(Peso) FROM Granja.Ganado WHERE Lote = NEW.Lote),
        Cantidad = (SELECT COUNT(*) FROM Granja.Ganado WHERE Lote = NEW.Lote)
    WHERE Lote = NEW.Lote;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ActualizarPesoCantidadLote_Update` AFTER UPDATE ON `Ganado` FOR EACH ROW BEGIN
    UPDATE Granja.Lote
    SET Peso_Lote = (SELECT SUM(Peso) FROM Granja.Ganado WHERE Lote = NEW.Lote),
        Cantidad = (SELECT COUNT(*) FROM Granja.Ganado WHERE Lote = NEW.Lote)
    WHERE Lote = NEW.Lote;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Ganado_gasto`
--

CREATE TABLE `Ganado_gasto` (
  `id_gasto_ganado` int NOT NULL,
  `Lote` int NOT NULL,
  `precio_comida` float NOT NULL,
  `precio_medicina` float NOT NULL,
  `Total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `id_monetario` int NOT NULL,
  `lote` int NOT NULL,
  `fecha_1` datetime NOT NULL,
  `fecha_2` datetime DEFAULT NULL,
  `dinero` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Lote`
--

CREATE TABLE `Lote` (
  `Lote` int NOT NULL,
  `Peso_Lote` float DEFAULT NULL,
  `Estado` varchar(50) NOT NULL,
  `Llegada` datetime NOT NULL,
  `Salida` datetime DEFAULT NULL,
  `Cantidad` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Disparadores `Lote`
--
DELIMITER $$
CREATE TRIGGER `BeforeInsertOrUpdateLote` BEFORE INSERT ON `Lote` FOR EACH ROW BEGIN
    DECLARE p_TotalInversion FLOAT;

    -- Calcular la inversión total de consumos
    SELECT COALESCE(SUM(inversion), 0) INTO p_TotalInversion
    FROM Granja.consumos
    WHERE lote = NEW.Lote;

    -- Actualizar el historial
    INSERT INTO Granja.historial(lote, fecha_1, fecha_2, dinero)
    VALUES (NEW.Lote, NEW.Llegada, NEW.Salida, p_TotalInversion);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Producto`
--

CREATE TABLE `Producto` (
  `id_producto` int NOT NULL,
  `Producto` text NOT NULL,
  `Categoria` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Stock`
--

CREATE TABLE `Stock` (
  `id_stock` int NOT NULL,
  `id_producto` int NOT NULL,
  `cantidad` float NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Transaccion`
--

CREATE TABLE `Transaccion` (
  `No_trans` int NOT NULL,
  `psg_ganadero` varchar(12) NOT NULL,
  `id_usuario` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuarios` int NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `consumos`
--
ALTER TABLE `consumos`
  ADD PRIMARY KEY (`id_consumo`),
  ADD KEY `id_dieta` (`id_dieta`);

--
-- Indices de la tabla `DetalleDieta`
--
ALTER TABLE `DetalleDieta`
  ADD PRIMARY KEY (`idDetalleDieta`),
  ADD KEY `id_dieta` (`id_dieta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `Dieta`
--
ALTER TABLE `Dieta`
  ADD PRIMARY KEY (`id_dieta`);

--
-- Indices de la tabla `Factura`
--
ALTER TABLE `Factura`
  ADD PRIMARY KEY (`No_fact`),
  ADD KEY `Lote` (`Lote`),
  ADD KEY `No_trans` (`No_trans`);

--
-- Indices de la tabla `ganadero`
--
ALTER TABLE `ganadero`
  ADD PRIMARY KEY (`psg`);

--
-- Indices de la tabla `Ganado`
--
ALTER TABLE `Ganado`
  ADD PRIMARY KEY (`No_Arete`),
  ADD KEY `Lote` (`Lote`);

--
-- Indices de la tabla `Ganado_gasto`
--
ALTER TABLE `Ganado_gasto`
  ADD PRIMARY KEY (`id_gasto_ganado`),
  ADD KEY `Lote` (`Lote`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id_monetario`);

--
-- Indices de la tabla `Lote`
--
ALTER TABLE `Lote`
  ADD PRIMARY KEY (`Lote`);

--
-- Indices de la tabla `Producto`
--
ALTER TABLE `Producto`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `Stock`
--
ALTER TABLE `Stock`
  ADD PRIMARY KEY (`id_stock`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `Transaccion`
--
ALTER TABLE `Transaccion`
  ADD PRIMARY KEY (`No_trans`),
  ADD KEY `psg_ganadero` (`psg_ganadero`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuarios`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `consumos`
--
ALTER TABLE `consumos`
  MODIFY `id_consumo` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `DetalleDieta`
--
ALTER TABLE `DetalleDieta`
  MODIFY `idDetalleDieta` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Dieta`
--
ALTER TABLE `Dieta`
  MODIFY `id_dieta` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Factura`
--
ALTER TABLE `Factura`
  MODIFY `No_fact` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Ganado_gasto`
--
ALTER TABLE `Ganado_gasto`
  MODIFY `id_gasto_ganado` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id_monetario` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Producto`
--
ALTER TABLE `Producto`
  MODIFY `id_producto` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Stock`
--
ALTER TABLE `Stock`
  MODIFY `id_stock` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `Transaccion`
--
ALTER TABLE `Transaccion`
  MODIFY `No_trans` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuarios` int NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consumos`
--
ALTER TABLE `consumos`
  ADD CONSTRAINT `consumos_ibfk_1` FOREIGN KEY (`id_dieta`) REFERENCES `Dieta` (`id_dieta`);

--
-- Filtros para la tabla `DetalleDieta`
--
ALTER TABLE `DetalleDieta`
  ADD CONSTRAINT `detalledieta_ibfk_1` FOREIGN KEY (`id_dieta`) REFERENCES `Dieta` (`id_dieta`),
  ADD CONSTRAINT `detalledieta_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `Producto` (`id_producto`);

--
-- Filtros para la tabla `Factura`
--
ALTER TABLE `Factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`Lote`) REFERENCES `Lote` (`Lote`),
  ADD CONSTRAINT `factura_ibfk_2` FOREIGN KEY (`No_trans`) REFERENCES `Transaccion` (`No_trans`);

--
-- Filtros para la tabla `Ganado`
--
ALTER TABLE `Ganado`
  ADD CONSTRAINT `ganado_ibfk_1` FOREIGN KEY (`Lote`) REFERENCES `Lote` (`Lote`);

--
-- Filtros para la tabla `Ganado_gasto`
--
ALTER TABLE `Ganado_gasto`
  ADD CONSTRAINT `ganado_gasto_ibfk_1` FOREIGN KEY (`Lote`) REFERENCES `Lote` (`Lote`);

--
-- Filtros para la tabla `Stock`
--
ALTER TABLE `Stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `Producto` (`id_producto`);

--
-- Filtros para la tabla `Transaccion`
--
ALTER TABLE `Transaccion`
  ADD CONSTRAINT `transaccion_ibfk_1` FOREIGN KEY (`psg_ganadero`) REFERENCES `ganadero` (`psg`),
  ADD CONSTRAINT `transaccion_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuarios`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
