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

CREATE table Granja.CoComidas(
    id_Cocomida int not null auto_increment primary key,
    id_comida int,
    cantidad_almacen float,
    Cantidad_receta float,
    precio float,
    INDEX (id_comida),
    INDEX (cantidad_almacen),
    INDEX (Cantidad_receta),
    INDEX (precio),
    foreign key (id_comida) references Granja.Comida(id_comida),
    foreign key (cantidad_almacen) references Granja.Comida(cantidad),
    foreign key (Cantidad_receta) references Granja.recetas(cantidad),
    foreign key (precio) references Granja.Comida(precio)
);

create table Granja.Medicina(
    id_medicina int not null auto_increment primary key,
    Descripcion varchar(100) not null,
    cantidad float not null,
    precio float not null,
    INDEX (cantidad),
    INDEX (precio)
);

create table Granja.Medcetas(
    id_medceta int not null auto_increment primary key,
    id_medicina int,
    cantidad float not null,
    INDEX (cantidad),
    foreign key (id_medicina) references Granja.Medicina(id_medicina)
);

CREATE table Granja.CoMediciona(
    id_CoMedicina int not null auto_increment primary key,
    id_medicina int,
    cantidad_almacen float,
    Cantidad_receta float,
    precio float,
    INDEX (id_medicina),
    INDEX (cantidad_almacen),
    INDEX (Cantidad_receta),
    INDEX (precio),
    foreign key (id_medicina) references Granja.Medicina(id_medicina),
    foreign key (cantidad_almacen) references Granja.Medicina(cantidad),
    foreign key (Cantidad_receta) references Granja.Medcetas(cantidad),
    foreign key (precio) references Granja.Medicina(precio)
);

create table Granja.Ganado_gasto(
    Lote int not null,
    precio_comida float not null,
    precio_medicina float not null,
    Total float not null,
    foreign key (Lote) references Granja.Lote(Lote)
);
