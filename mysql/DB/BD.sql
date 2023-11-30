CREATE DATABASE Granja;
CREATE table Granja.ganadero(
    id_ganadero int not null auto_increment PRIMARY KEY,
    psg varchar(12) not null,
    nombre varchar(150) not null,
    razonsocial varchar(100) not null,
    domicilio varchar(150) not null,
    localidad varchar(150) not null,
    Municipio varchar(100) not null,
    Estado varchar(100) not null
);

CREATE table Granja.responsables(
    id_responsable int not null auto_increment PRIMARY KEY,
    psg varchar(12) not null,
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
    Num_fact int not null auto_increment primary key,
    id_ganadero int,
    id_responsable int,
    foreign key (id_ganadero) references Granja.ganadero(id_ganadero),
    foreign key (id_responsable) references Granja.responsables(id_responsable)
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
    foreign key (No_trans) references Granja.Transaccion(Num_fact)
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


create table Granja.Comida(
    id_comida int not null auto_increment primary key,
    Descripcion varchar(50) not null,
    cantidad float not null,
    precio float not null,
    INDEX (cantidad),
    INDEX (precio)
);

create table Granja.recetas(
    id_receta int not null auto_increment primary key,
    id_comida int,
    cantidad float not null,
    INDEX (cantidad),
    foreign key (id_comida) references Granja.Comida(id_comida)
);
create table Granja.detallerecetas(
    id_detalle_receta int not null auto_increment primary key,
    id_comida int,
    cantidad float not null,
    INDEX (cantidad),
    foreign key (id_comida) references Granja.Comida(id_comida)
);

CREATE table Granja.CoComidas(
    id_Cocomida int not null auto_increment primary key,
    id_comida int,
    cantidad_resultante float,
    precio float,
    INDEX (id_comida),
    INDEX (precio),
    foreign key (id_comida) references Granja.Comida(id_comida)
);
CREATE TABLE Granja.costocomida (
    id_costocomida INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fecha DATETIME NOT NULL,
    Lote INT NOT NULL,
    precio FLOAT NOT NULL,
    INDEX (precio),
    FOREIGN KEY (Lote) REFERENCES Granja.Lote(Lote)
);

create table Granja.Medicina(
    id_medicina int not null auto_increment primary key,
    Descripcion varchar(100) not null,
    cantidad float not null,
    precio float not null,
    INDEX (cantidad),
    INDEX (precio)
);

CREATE TABLE Granja.costomedicina(
    id_costomedicina int not null auto_increment primary key,
    fecha DATETIME not null,
    Lote int not null,
    precio float not null,
    INDEX (precio),
    foreign key (Lote) references Granja.Lote(Lote)
);

create table Granja.Ganado_gasto(
    id_gasto_ganado int not null auto_increment primary key,
    Lote int not null,
    precio_comida float not null,
    precio_medicina float not null,
    Total float not null,
    foreign key (Lote) references Granja.Lote(Lote),
    foreign key (precio_medicina) references Granja.costomedicina(precio),
    foreign key (precio_comida) references Granja.costocomida(precio)  
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

DELIMITER //

CREATE PROCEDURE InsertarDetalleReceta(IN p_id_comida INT, IN p_cantidad FLOAT, IN v_id_receta_comida INT)
BEGIN

    -- Establecer un valor constante para id_receta_comida
    -- Insertar datos en DetalleRecetas
    INSERT INTO Granja.DetalleRecetas (id_comida, cantidad, id_receta_comida)
    VALUES (p_id_comida, p_cantidad, v_id_receta_comida);
END //

DELIMITER ;
