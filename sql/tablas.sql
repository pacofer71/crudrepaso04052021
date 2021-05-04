drop table if exists poststemas;
drop table if exists posts;
drop table if exists users;
drop table if exists tags;
-- ----------------------------------------------------------------
create table tags(
    id int auto_increment primary key,
    categoria varchar(120) unique not null
);
create table users(
    id int auto_increment primary key,
    nombre varchar(40) not null,
    apellidos varchar(100) not null,
    username varchar(40) unique not null,
    mail varchar(60) unique not null,
    pass varchar(256) not null
);
create table posts(
    id int auto_increment primary key,
    titulo varchar(80) not null,
    cuerpo text not null,
    idUser int,
    fecha timestamp default CURRENT_TIMESTAMP,
    constraint postsUser foreign key(idUser) references users(id) on delete cascade on update cascade
);
create table poststemas(
    id int auto_increment primary key,
    idTag int default -1,
    idPost int,
    constraint reltag foreign key(idTag) references tags(id) on delete set default on update cascade,
    constraint relPost foreign key(idPost) references posts(id) on delete cascade on update cascade
);
