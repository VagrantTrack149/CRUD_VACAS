CREATE DATABASE Granja;
CREATE table Granja.ganadero(
    psg varchar(12) not null primary key,
    nombre varchar(150) not null,
    razonsocial varchar(100) not null,
    domicilio varchar(150) not null,
    localidad varchar(150) not null,
    Municipio varchar(100) not null,
    Estado varchar(100) not null
);

CREATE table Granja.usuarios(
    id_usuarios int not null auto_increment,
    nombre varchar(50) not null,
    email varchar(100) not null,
    password varchar(100) not null,
    primary key (id_usuarios)
);

CREATE table Granja.Lote(
    Lote int not null Primary key,
    Peso_Lote float,
    Estado varchar(50) not null,
    Llegada DATETIME not null,
    Salida DATETIME,
    Cantidad int not null
);

CREATE table Granja.Transaccion(
    No_trans int not null auto_increment primary key,
    psg_ganadero varchar(12) not null,
    id_usuario int,
    foreign key (psg_ganadero) references Granja.ganadero(psg),
    foreign key (id_usuario) references Granja.usuarios(id_usuarios)
);

CREATE table Granja.Factura(
    No_fact int not null auto_increment primary key,
    Origen varchar(150) not null,
    Destino varchar(150) not null,
    Total float not null,
    Tipo_VC varchar(25) not null,
    Proposito text not null,
    Especie varchar(50) not null,
    Lote int not null,
    Fecha DATETIME not null,
    No_trans int,
    foreign key (Lote) references Granja.Lote(Lote),
    foreign key (No_trans) references Granja.Transaccion(No_trans)
);


CREATE table Granja.Ganado(
    No_Arete varchar(50) not null primary key,
    Sexo bit not null,
    Edad int not null,
    Lote int not null,
    Peso float not null,
    Estado varchar(50) not null,
    Precio float not null,
    foreign key (Lote) references Granja.Lote(Lote)
);

CREATE TABLE Granja.Dieta(
    id_dieta int primary key auto_increment,
    Dieta text not null
);
CREATE TABLE Granja.Producto(
    id_producto int primary key auto_increment,
    Producto text not null,
    categoria int not null
);
CREATE TABLE Granja.DetalleDieta(
    idDetalleDieta int not null primary key auto_increment,
    id_dieta int not null,
    id_producto int not null,
    cantidad float not null
    foreign key (id_dieta) references Granja.Dieta(id_dieta),
    foreign key (id_producto) references Granja.Producto(id_producto)
);
CREATE TABLE Granja.Stock(
    id_stock int primary key auto_increment,
    id_producto int not null,
    cantidad float not null,
    precio float not null,
    foreign key (id_producto) references Granja.Producto(id_producto)
);
CREATE TABLE Granja.consumos(
    id_consumo int primary key auto_increment,
    id_dieta int,
    fecha DATETIME not null,
    lote int not null,
    inversion float not null,
    foreign key (id_dieta) references Granja.Dieta(id_dieta)
);
CREATE TABLE Granja.historial(
    id_monetario int primary key auto_increment,
    lote int not null,
    fecha_1 DATETIME not null,
    fecha_2 DATETIME not null,
    dinero float not null
);

DELIMITER $$
CREATE DEFINER=`root`@`%` PROCEDURE `InsertarLoteConGanado`()
BEGIN
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

 
END$$
DELIMITER ;


-- Trigger para AFTER INSERT
DELIMITER //

CREATE TRIGGER ActualizarPesoCantidadLote_Insert
AFTER INSERT ON Granja.Ganado
FOR EACH ROW
BEGIN
    UPDATE Granja.Lote
    SET Peso_Lote = (SELECT SUM(Peso) FROM Granja.Ganado WHERE Lote = NEW.Lote),
        Cantidad = (SELECT COUNT(*) FROM Granja.Ganado WHERE Lote = NEW.Lote)
    WHERE Lote = NEW.Lote;
END //

DELIMITER ;

-- Trigger para AFTER UPDATE
DELIMITER //

CREATE TRIGGER ActualizarPesoCantidadLote_Update
AFTER UPDATE ON Granja.Ganado
FOR EACH ROW
BEGIN
    UPDATE Granja.Lote
    SET Peso_Lote = (SELECT SUM(Peso) FROM Granja.Ganado WHERE Lote = NEW.Lote),
        Cantidad = (SELECT COUNT(*) FROM Granja.Ganado WHERE Lote = NEW.Lote)
    WHERE Lote = NEW.Lote;
END //

DELIMITER ;

-- Trigger para AFTER DELETE
DELIMITER //

CREATE TRIGGER ActualizarPesoCantidadLote_Delete
AFTER DELETE ON Granja.Ganado
FOR EACH ROW
BEGIN
    UPDATE Granja.Lote
    SET Peso_Lote = (SELECT SUM(Peso) FROM Granja.Ganado WHERE Lote = OLD.Lote),
        Cantidad = (SELECT COUNT(*) FROM Granja.Ganado WHERE Lote = OLD.Lote)
    WHERE Lote = OLD.Lote;
END //

DELIMITER ;
