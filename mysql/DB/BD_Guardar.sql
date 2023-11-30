
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
    id_receta_comida int not null,
    cantidad float not null,
    INDEX (cantidad),
    foreign key (id_comida) references Granja.Comida(id_comida)
);
create table Granja.detallerecetas(
    id_detalle_receta int not null auto_increment primary key,
    id_comida int,
    id_receta_comida int not null,
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

