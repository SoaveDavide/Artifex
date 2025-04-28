create database artifex;
create table artifex.lingue(
    nome varchar(100) primary key
);
create table artifex.lvl_conoscenza(
    nome varchar(100) primary key
);
create table artifex.guide(
                              nome varchar(100),
                              cognome varchar(100),
                              primary key(nome, cognome),
                              titolo_studio varchar(100),
                              luogo_nascita varchar(100),
                              data_nascita varchar(100)
);
create table artifex.visite(
                               titolo varchar(100) primary key,
                               luogo varchar(100),
                               durata_media int
);
create table artifex.visitatori(
                                   email varchar(100) primary key,
                                   password varchar(100),
                                   numero_telefono varchar(100),
                                   nome varchar(100),
                                   nazionalita varchar(100),
                                   lingua_base varchar(100),
                                   foreign key(lingua_base) references artifex.lingue(nome)
);
create table artifex.eventi(
                               id int primary key auto_increment,
                               n_minimo int,
                               n_massimo int,
                               prezzo double,
                               nome_lingua varchar(100),
                               nome_guida varchar(100),
                               cognome_guida varchar(100),
                               foreign key(nome_guida, cognome_guida) references artifex.guide(nome, cognome),
                               foreign key(nome_lingua) references artifex.lingue(nome)
);
create table artifex.contenere(
                                  id_evento int,
                                  data_creazione datetime,
                                  email_utente varchar(100),
                                  foreign key(email_utente,data_creazione) references artifex.carrelli(email_utente,data_creazione),
                                  foreign key(id_evento) references artifex.eventi(id)

);
create table artifex.appartenere(
                                    ora_inizio datetime,
                                    titolo_visita varchar(100),
                                    id_evento int,
                                    foreign key(titolo_visita) references artifex.visite(titolo),
                                    foreign key(id_evento) references artifex.eventi(id)
);
create table artifex.carrelli(
                                 data_creazione datetime,
                                 email_utente varchar(100),
                                 primary key(email_utente, data_creazione),
                                 foreign key(email_utente) references artifex.visitatori(email)
);
create table artifex.conoscere(
                                  nome_guida varchar(100),
                                  cognome_guida varchar(100),
                                  nome_lingua varchar(100),
                                  nome_conoscenza varchar(100),
                                  foreign key(nome_guida, cognome_guida) references artifex.guide(nome, cognome),
                                  foreign key(nome_lingua) references artifex.lingue(nome),
                                  foreign key(nome_conoscenza) references artifex.lvl_conoscenza(nome)
);

insert into artifex.lingue(nome) values ('italiano'), ('tedesco'), ('inglese'), ('francese'), ('spagnolo'), ('rumeno'), ('russo')