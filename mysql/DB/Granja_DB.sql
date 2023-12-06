-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 03-12-2023 a las 00:38:49
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
CREATE DATABASE Granja;

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`%` PROCEDURE `BorrarDieta` (IN `dieta_id` INT)   BEGIN
    START TRANSACTION;
    -- Borra los detalles de la dieta en la tabla DetalleDieta
    DELETE FROM Granja.DetalleDieta WHERE id_dieta = dieta_id;

    -- Borra la dieta en la tabla Dieta
    DELETE FROM Granja.Dieta WHERE id_dieta = dieta_id;
    COMMIT;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `EditarProducto` (IN `p_id_producto` INT, IN `p_nuevo_producto` TEXT, IN `p_nueva_cantidad` FLOAT, IN `p_nuevo_precio` FLOAT)   BEGIN
    START TRANSACTION;
    -- Actualizar la tabla Producto
    UPDATE Granja.Producto
    SET Producto = p_nuevo_producto
    WHERE id_producto = p_id_producto;

    -- Actualizar la tabla Stock
    UPDATE Granja.Stock
    SET cantidad = p_nueva_cantidad,
        precio = p_nuevo_precio
    WHERE id_producto = p_id_producto;

    COMMIT;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `EliminarDetalleDieta` (IN `p_id_dieta` INT, IN `p_id_producto` INT)   BEGIN
    START TRANSACTION;
    DELETE FROM Granja.DetalleDieta
    WHERE id_dieta = p_id_dieta AND id_producto = p_id_producto;
    COMMIT;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `EliminarProducto` (IN `p_id_producto` INT)   BEGIN
    START TRANSACTION;
    -- Eliminar de la tabla Stock
    DELETE FROM Granja.Stock WHERE id_producto = p_id_producto;

    -- Eliminar de la tabla Producto
    DELETE FROM Granja.Producto WHERE id_producto = p_id_producto;
    COMMIT;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `InsertarDetalleDieta` (IN `p_id_dieta` INT, IN `p_id_producto` INT, IN `p_cantidad` FLOAT)   BEGIN
    START TRANSACTION;
    INSERT INTO Granja.DetalleDieta (id_dieta, id_producto, cantidad)
    VALUES (p_id_dieta, p_id_producto, p_cantidad);
    COMMIT;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `InsertarDieta` (IN `p_Dieta` TEXT)   BEGIN
    START TRANSACTION;
    -- Insertar en la tabla Dieta
    INSERT INTO Granja.Dieta (Dieta)
    VALUES (p_Dieta);

    -- Imprimir el último ID generado
    SELECT LAST_INSERT_ID() AS 'UltimoIDGenerado';
    COMMIT;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `InsertarGanadero` (IN `p_psg` VARCHAR(255), IN `p_nombre` VARCHAR(255), IN `p_razonsocial` VARCHAR(255), IN `p_domicilio` VARCHAR(255), IN `p_localidad` VARCHAR(255), IN `p_Municipio` VARCHAR(255), IN `p_Estado` VARCHAR(255))   BEGIN
    START TRANSACTION;
    INSERT INTO `ganadero`(`psg`, `nombre`, `razonsocial`, `domicilio`, `localidad`, `Municipio`, `Estado`)
    VALUES (p_psg, p_nombre, p_razonsocial, p_domicilio, p_localidad, p_Municipio, p_Estado);
    COMMIT;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `InsertarLoteConGanado` ()   BEGIN
    START TRANSACTION;
    -- Declarar variables para almacenar el último valor de lote y el consecutivo
    DECLARE ultimoLote INT;
    DECLARE nuevoConsecutivo INT;

    -- Obtener el último valor de lote
    SELECT MAX(Lote) INTO ultimoLote FROM Granja.Lote;

    -- Calcular el nuevo consecutivo
    SET nuevoConsecutivo = COALESCE(ultimoLote, 0) + 1;

    -- Insertar el nuevo lote con el consecutivo
    INSERT INTO Granja.Lote(Lote, Peso_Lote, Estado, Llegada, Salida, Cantidad)
    VALUES (nuevoConsecutivo, NULL, 'Engorda', NOW(), NULL, 0);

    COMMIT;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `InsertarMedicamentoStock` (IN `p_Producto` TEXT, IN `p_Cantidad` FLOAT, IN `p_Precio` FLOAT)   BEGIN
    START TRANSACTION;
    DECLARE v_id_producto INT;

    -- Insertar en la tabla Producto
    INSERT INTO Granja.Producto (Producto, categoria)
    VALUES (p_Producto, 2);

    -- Obtener el ID del producto recién insertado
    SET v_id_producto = LAST_INSERT_ID();

    -- Insertar en la tabla Stock
    INSERT INTO Granja.Stock (id_producto, cantidad, precio)
    VALUES (v_id_producto, p_Cantidad, p_Precio);
    COMMIT;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `InsertarProductoStock` (IN `p_Producto` TEXT, IN `p_Cantidad` FLOAT, IN `p_Precio` FLOAT)   BEGIN
    START TRANSACTION;
    DECLARE v_id_producto INT;

    -- Insertar en la tabla Producto
    INSERT INTO Granja.Producto (Producto, categoria)
    VALUES (p_Producto, 1);

    -- Obtener el ID del producto recién insertado
    SET v_id_producto = LAST_INSERT_ID();

    -- Insertar en la tabla Stock
    INSERT INTO Granja.Stock (id_producto, cantidad, precio)
    VALUES (v_id_producto, p_Cantidad, p_Precio);
    COMMIT;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `MostrarConsumos` ()   BEGIN
    SELECT 
        c.id_consumo,
        COALESCE(d.Dieta, 'Medicina') AS Dieta,
        c.fecha,
        c.lote,
        c.inversion
    FROM
        Granja.consumos c
    LEFT JOIN
        Granja.Dieta d ON c.id_dieta = d.id_dieta;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `MostrarDetallesDieta` (IN `dieta_id` INT)   BEGIN
    SELECT d.Dieta AS NombreDieta, 
           GROUP_CONCAT(CONCAT(p.Producto, ' - ', dd.cantidad) SEPARATOR '<br>') AS DetalleProducto
    FROM Granja.Dieta d
    INNER JOIN Granja.DetalleDieta dd ON d.id_dieta = dd.id_dieta
    INNER JOIN Granja.Producto p ON dd.id_producto = p.id_producto
    WHERE d.id_dieta = dieta_id
    GROUP BY d.id_dieta;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `MostrarDetallesDieta_General` ()   BEGIN
    SELECT d.Dieta AS NombreDieta, 
           GROUP_CONCAT(CONCAT(p.Producto, ' - ', dd.cantidad) SEPARATOR '<br>') AS DetalleProducto,
           d.id_dieta
    FROM Granja.Dieta d
    INNER JOIN Granja.DetalleDieta dd ON d.id_dieta = dd.id_dieta
    INNER JOIN Granja.Producto p ON dd.id_producto = p.id_producto
    GROUP BY d.id_dieta;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `MostrarFacturas` ()   BEGIN
    SELECT 
        f.Fecha,
        g.nombre AS Ganadero,
        f.Tipo_VC,
        f.Total,
        f.Lote,
        f.Origen,
        f.Destino,
        f.Proposito AS Comentario
    FROM
        Granja.Factura f
    JOIN
        Granja.Lote l ON f.Lote = l.Lote
    JOIN
        Granja.Transaccion t ON f.No_trans = t.No_trans
    JOIN
        Granja.ganadero g ON t.psg_ganadero = g.psg;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `ObtenerDetallesDieta` (IN `p_id_dieta` INT)   BEGIN
    SELECT D.id_dieta, D.Dieta, P.Producto, DD.idDetalleDieta, DD.id_producto, DD.cantidad, S.precio
    FROM Granja.Dieta D
    INNER JOIN Granja.DetalleDieta DD ON D.id_dieta = DD.id_dieta
    INNER JOIN Granja.Producto P ON DD.id_producto = P.id_producto
    INNER JOIN Granja.Stock S ON DD.id_producto = S.id_producto
    WHERE D.id_dieta = p_id_dieta;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `ObtenerProductosCategoria1` ()   BEGIN
    SELECT P.Producto, S.cantidad, S.precio, P.id_producto
    FROM Granja.Producto P
    INNER JOIN Granja.Stock S ON P.id_producto = S.id_producto
    WHERE P.categoria = 1;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `ObtenerUltimoIdDieta` ()   BEGIN
    -- Obtener el último ID insertado
    SELECT MAX(id_dieta) AS 'UltimoIdInsertado' FROM Granja.Dieta;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `ObtenerUltimoNumeroLote` ()   BEGIN
    -- Obtener el número de lote más grande o el último agregado
    SELECT MAX(Lote) AS 'UltimoNumeroLote' FROM Granja.Lote;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `RegistrarConsumo` (IN `p_id_dieta` INT, IN `p_id_lote` INT)   BEGIN
    DECLARE v_id_producto INT;
    DECLARE v_cantidad_consumida FLOAT;
    DECLARE v_precio_producto FLOAT;
    
    -- Declarar variables para controlar el cursor
    DECLARE no_more_rows BOOLEAN DEFAULT FALSE;
    
    -- Declarar cursor para los productos en la dieta
    DECLARE cursor_productos CURSOR FOR
        SELECT DD.id_producto, DD.cantidad
        FROM Granja.DetalleDieta DD
        WHERE DD.id_dieta = p_id_dieta;
    
    -- Declarar handler para no encontrados
    DECLARE CONTINUE HANDLER FOR NOT FOUND
        SET no_more_rows = TRUE;

    OPEN cursor_productos;
    
    -- Inicializar variables del cursor
    SET no_more_rows = FALSE;
    
    -- Iniciar el loop
    read_loop: LOOP
        -- Obtener valores del cursor
        FETCH cursor_productos INTO v_id_producto, v_cantidad_consumida;
        
        -- Salir si no hay más filas
        IF no_more_rows THEN
            LEAVE read_loop;
        END IF;
        
        -- Obtener el precio del producto desde el stock
        SELECT precio INTO v_precio_producto
        FROM Granja.Stock
        WHERE id_producto = v_id_producto;
        
        -- Restar la cantidad consumida del stock
        UPDATE Granja.Stock
        SET cantidad = cantidad - v_cantidad_consumida
        WHERE id_producto = v_id_producto;

        -- Registrar el consumo en la tabla consumos
        INSERT INTO Granja.consumos (id_dieta, fecha, lote, inversion)
        VALUES (p_id_dieta, NOW(), p_id_lote, v_cantidad_consumida * v_precio_producto);
    END LOOP;

    CLOSE cursor_productos;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `RegistrarConsumo_medicina` (IN `p_id_producto` INT, IN `p_lote` INT)   BEGIN
    START TRANSACTION;
    DECLARE v_cantidad_stock FLOAT;
    DECLARE v_precio_producto FLOAT;

    -- Obtener la cantidad y el precio del producto desde el stock
    SELECT cantidad, precio
    INTO v_cantidad_stock, v_precio_producto
    FROM Granja.Stock
    WHERE id_producto = p_id_producto;

    -- Validar si hay suficiente cantidad en el stock
    IF v_cantidad_stock >= 1 THEN
        -- Actualizar la cantidad en el stock
        UPDATE Granja.Stock
        SET cantidad = cantidad - 1
        WHERE id_producto = p_id_producto;

        -- Registrar el consumo en la tabla consumos
        INSERT INTO Granja.consumos (fecha, lote, inversion)
        VALUES (NOW(), p_lote, v_precio_producto);

        -- Puedes hacer más acciones aquí si es necesario
        COMMIT;
        SELECT 'Éxito' AS mensaje; -- Puedes devolver un mensaje de éxito si lo deseas
    ELSE
        ROLLBACK;
        SELECT 'No hay suficiente cantidad en el stock' AS mensaje;
    END IF;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `RegistrarFactura` (IN `p_psg_ganadero` VARCHAR(12), IN `p_id_usuario` INT, IN `p_Origen` VARCHAR(150), IN `p_Destino` VARCHAR(150), IN `p_Total` FLOAT, IN `p_Tipo_VC` VARCHAR(25), IN `p_Proposito` TEXT, IN `p_Especie` VARCHAR(50), IN `p_Lote` INT)   BEGIN
    DECLARE v_No_trans INT;

    -- Iniciar una transacción
    START TRANSACTION;

    -- Insertar en la tabla Transaccion
    INSERT INTO Granja.Transaccion (psg_ganadero, id_usuario)
    VALUES (p_psg_ganadero, p_id_usuario);

    -- Obtener el número de transacción generado por auto_increment
    SET v_No_trans = LAST_INSERT_ID();

    -- Insertar en la tabla Factura
    INSERT INTO Granja.Factura (Origen, Destino, Total, Tipo_VC, Proposito, Especie, Lote, Fecha, No_trans)
    VALUES (p_Origen, p_Destino, p_Total, p_Tipo_VC, p_Proposito, p_Especie, p_Lote, NOW(), v_No_trans);

    -- Confirmar la transacción
    COMMIT;
END$$

CREATE DEFINER=`root`@`%` PROCEDURE `ShowHistorial` ()   BEGIN
    SELECT id_monetario, lote, fecha_1, IFNULL(fecha_2, 'Sigue en el rancho') as fecha_2, dinero
    FROM Granja.historial;

END$$

CREATE DEFINER=`root`@`%` PROCEDURE `UpdateHistorialAfterInsertFactura` (IN `newLote` INT, IN `newTipoVC` VARCHAR(25), IN `newFecha` DATETIME, IN `newTotal` FLOAT)   BEGIN
    START TRANSACTION;
    DECLARE p_TotalVenta FLOAT;
    DECLARE p_TotalCompra FLOAT;
    DECLARE p_TotalConsumos FLOAT;

    IF newTipoVC = 'venta' THEN
        -- Calcular la suma de ventas y compras
        SELECT COALESCE(SUM(CASE WHEN Tipo_VC = 'venta' THEN newTotal ELSE 0 END), 0) INTO p_TotalVenta
        FROM Granja.Factura
        WHERE Lote = newLote;

        SELECT COALESCE(SUM(CASE WHEN Tipo_VC = 'compra' THEN newTotal ELSE 0 END), 0) INTO p_TotalCompra
        FROM Granja.Factura
        WHERE Lote = newLote;

        -- Calcular la suma de consumos relacionados con el lote
        SELECT COALESCE(SUM(inversion), 0) INTO p_TotalConsumos
        FROM Granja.consumos
        WHERE lote = newLote;

        -- Actualizar Lote (establecer Salida como Fecha de Factura)
        UPDATE Granja.Lote
        SET Salida = newFecha
        WHERE Lote = newLote;

        -- Actualizar el historial restando la diferencia entre ventas y compras, y restando los consumos
        UPDATE Granja.historial
        SET fecha_2 = NOW(),
            dinero = (p_TotalVenta - p_TotalCompra - p_TotalConsumos)
        WHERE lote = newLote AND fecha_2 IS NULL;
        COMMIT;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consumos`
--

CREATE TABLE `consumos` (
  `id_consumo` int NOT NULL,
  `id_dieta` int DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `lote` int NOT NULL,
  `inversion` float NOT NULL CHECK (inversion >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `consumos`
--

INSERT INTO `consumos` (`id_consumo`, `id_dieta`, `fecha`, `lote`, `inversion`) VALUES
(66, NULL, '2023-12-02 00:55:41', 1, 50),
(67, NULL, '2023-12-02 01:12:29', 1, 50),
(68, NULL, '2023-12-02 01:19:47', 1, 50),
(69, 28, '2023-12-02 21:07:56', 1, 101),
(70, 28, '2023-12-02 21:29:20', 3, 101),
(71, 28, '2023-12-02 21:39:35', 3, 101),
(72, 28, '2023-12-02 21:59:01', 3, 101);

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
  `cantidad` float NOT NULL CHECK (cantidad >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `DetalleDieta`
--

INSERT INTO `DetalleDieta` (`idDetalleDieta`, `id_dieta`, `id_producto`, `cantidad`) VALUES
(40, 28, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Dieta`
--

CREATE TABLE `Dieta` (
  `id_dieta` int NOT NULL,
  `Dieta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `Dieta`
--

INSERT INTO `Dieta` (`id_dieta`, `Dieta`) VALUES
(17, 'Luis'),
(18, 'Engorda'),
(19, 'Engorda'),
(20, 'Engorda'),
(21, 'Nose2'),
(24, 'Recién llegado'),
(25, 'Engorda'),
(27, 'Máxima Ganancia'),
(28, 'Recién llegado'),
(30, 'Medicina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Factura`
--

CREATE TABLE `Factura` (
  `No_fact` int NOT NULL,
  `Origen` varchar(150) NOT NULL,
  `Destino` varchar(150) NOT NULL,
  `Total` float NOT NULL CHECK (Total >= 0),
  `Tipo_VC` varchar(25) NOT NULL,
  `Proposito` text NOT NULL,
  `Especie` varchar(50) NOT NULL,
  `Lote` int NOT NULL,
  `Fecha` datetime NOT NULL,
  `No_trans` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `Factura`
--

INSERT INTO `Factura` (`No_fact`, `Origen`, `Destino`, `Total`, `Tipo_VC`, `Proposito`, `Especie`, `Lote`, `Fecha`, `No_trans`) VALUES
(7, 'San Luis', 'Yuriria', 500, 'venta', 'Prueba 2', 'bobino', 1, '2023-12-02 20:59:29', 7),
(8, 'Yuriria', 'San Luis', 1, 'venta', 'Prueba 29', 'bobino', 1, '2023-12-02 21:00:01', 8),
(9, 'Yuriria', 'San Luis', 1, 'venta', 'Prueba 29', 'bobino', 1, '2023-12-02 21:00:35', 9),
(13, 'San luis', 'Yuriria', 500, 'Compra', 'Prueba80', 'Bobino', 3, '2023-12-02 21:32:45', 13),
(16, 'San Luis', 'Yuriria', 500, 'venta', 'Prueba89', 'bobino', 3, '2023-12-02 21:38:42', 18);

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

--
-- Volcado de datos para la tabla `ganadero`
--

INSERT INTO `ganadero` (`psg`, `nombre`, `razonsocial`, `domicilio`, `localidad`, `Municipio`, `Estado`) VALUES
('1515161', 'NEIL OTNIEL MORENO RIVERA', 'SAN LUIS', 'MONTAÑITA 1', 'CRISTO REY', 'SAN LUIS', 'GUANAJUATO');

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
-- Volcado de datos para la tabla `Ganado`
--

INSERT INTO `Ganado` (`No_Arete`, `Sexo`, `Edad`, `Lote`, `Peso`, `Estado`, `Precio`) VALUES
('A205', b'1', 6, 3, 400, 'Engorda', 350);

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
  `precio_comida` float NOT NULL CHECK (precio_comida >= 0),
  `precio_medicina` float NOT NULL CHECK (precio_medicina >=0),
  `Total` float NOT NULL CHECK (Total >=0)
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
  `dinero` float NOT NULL CHECK (dinero >=0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`id_monetario`, `lote`, `fecha_1`, `fecha_2`, `dinero`) VALUES
(7, 3, '2023-12-02 21:38:42', '2023-12-02 21:59:01', 303);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Lote`
--

CREATE TABLE `Lote` (
  `Lote` int NOT NULL,
  `Peso_Lote` float DEFAULT NULL CHECK (Peso_Lote >=0),
  `Estado` varchar(50) NOT NULL,
  `Llegada` datetime NOT NULL,
  `Salida` datetime DEFAULT NULL,
  `Cantidad` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `Lote`
--

INSERT INTO `Lote` (`Lote`, `Peso_Lote`, `Estado`, `Llegada`, `Salida`, `Cantidad`) VALUES
(1, NULL, 'Engorda', '2023-12-01 23:21:51', NULL, 0),
(3, 400, 'Engorda', '2023-12-02 21:38:42', NULL, 1);

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

--
-- Volcado de datos para la tabla `Producto`
--

INSERT INTO `Producto` (`id_producto`, `Producto`, `Categoria`) VALUES
(1, 'Pollo', 1),
(4, 'Pan', 1),
(5, 'Pan', 1),
(6, 'Pedrigri', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Stock`
--

CREATE TABLE `Stock` (
  `id_stock` int NOT NULL,
  `id_producto` int NOT NULL,
  `cantidad` float NOT NULL CHECK (cantidad >=0),
  `precio` float NOT NULL CHECK (precio >=0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `Stock`
--

INSERT INTO `Stock` (`id_stock`, `id_producto`, `cantidad`, `precio`) VALUES
(1, 1, 61, 101),
(5, 5, 30, 10),
(6, 6, 17, 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Transaccion`
--

CREATE TABLE `Transaccion` (
  `No_trans` int NOT NULL,
  `psg_ganadero` varchar(12) NOT NULL,
  `id_usuario` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `Transaccion`
--

INSERT INTO `Transaccion` (`No_trans`, `psg_ganadero`, `id_usuario`) VALUES
(7, '1515161', 1),
(8, '1515161', 1),
(9, '1515161', 1),
(13, '1515161', 1),
(18, '1515161', 1);

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
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuarios`, `nombre`, `email`, `password`) VALUES
(1, 'Neil Moreno', 'neilotniel@gmail.com', '$2y$10$tJOD4Vp1mbgtszeRrHnDF.V.IgPeh2Wn0fNT0Wxs9yO4gahMG7byO');

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
  MODIFY `id_consumo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `DetalleDieta`
--
ALTER TABLE `DetalleDieta`
  MODIFY `idDetalleDieta` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `Dieta`
--
ALTER TABLE `Dieta`
  MODIFY `id_dieta` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `Factura`
--
ALTER TABLE `Factura`
  MODIFY `No_fact` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `Ganado_gasto`
--
ALTER TABLE `Ganado_gasto`
  MODIFY `id_gasto_ganado` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id_monetario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `Producto`
--
ALTER TABLE `Producto`
  MODIFY `id_producto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `Stock`
--
ALTER TABLE `Stock`
  MODIFY `id_stock` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `Transaccion`
--
ALTER TABLE `Transaccion`
  MODIFY `No_trans` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuarios` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
