create database biblioteca;
use biblioteca;

    create table usuarios( 
    usuario_id int not null auto_increment primary key, 
    usuario_nombre varchar(25) not null, 
    usuario_apellido varchar(30) not null,
    usuario_telefono varchar(30) not null,
    usuario_direccion varchar(150) not null,
    usuario_correo varchar(58) not null,
    usuario_usuario varchar(30) not null,
    usuario_clave varchar(500) not null, 
    usuario_estado varchar(13) not null,
    usuario_privilegio int not null
    );

    INSERT INTO usuarios VALUES (null, "Arely", "Lopez", 9531876389, "Miahuatlan", "areloma26@gmail.com", "arely", "maldonado", "Habilitada",1);

    INSERT INTO usuarios VALUES (null, "Administrador", "Principal", 9531876389, "Direccion", "areloma26@gmail.com", "Administrador", "Administrador", "Habilitada",1);

    INSERT INTO editorial VALUES (null, "123489256", "Blanca Nieves");

    INSERT INTO usuarios VALUES (null, "Administrador", "Principal", 9531876389, "Direccion", "areloma26@gmail.com", "Administrador", "Administrador", "Habilitada",1);

    create table autor(    
        autor_id int not null auto_increment primary key,
        autor_nombre varchar(30) not null,
        autor_apellido varchar(50) not null     
    );

    create table editorial (
        editorial_id int not null auto_increment primary key,
        editorial_codigo int not null,
        editorial_nombre varchar(50) not null
    );

    create table categoria (
        categoria_id not null auto_increment primary key,
        categoria_nombre varchar(25) not null
    );

    create table ejemplar( 
        ejemplar_id int not null auto_increment primary key,
        ejemplar_codigo int not null,
        ejemplar_libro int not null,
        ejemplar_estado varchar(10) not null,
        foreign key (ejemplar_libro) references libro(libro_id)
    );

create table cliente (
    cliente_id int not null auto_increment primary key,
    cliente_nombre varchar(25) not null,
    cliente_apellido varchar(30) not null,
    cliente_direccion varchar(150) not null, 
    cliente_telefono varchar(13) not null    
);


create table libro(
    libro_id int not null auto_increment primary key,
    libro_codigo int(10) not null,
    libro_titulo varchar(25)not null,
    libro_autor int not null,
    libro_editorial int not null,
    libro_categoria int not null,
    foreign key (libro_autor) references autor(autor_id),
    foreign key (libro_editorial) references editorial(editorial_id),
    foreign key (libro_categoria) references categoria(categoria_id)     
);


create table prestamo(
    prestamo_id int not null auto_increment primary key,
    libro_codigo int not null,
    libro_cliente int not null,
    fecha_salida varchar(25) not null,
    fecha_entrega varchar(25),
    foreign key (libro_codigo)references libro(libro_id),
    foreign key (libro_cliente)references cliente(cliente_id)      
);
