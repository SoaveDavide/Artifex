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
                               nome varchar(100) primary key,
                               n_minimo int,
                               n_massimo int,
                               prezzo double,
                               nome_lingua varchar(100),
                               nome_guida varchar(100),
                               cognome_guida varchar(100),
                               foreign key(nome_guida, cognome_guida) references artifex.guide(nome, cognome),
                               foreign key(nome_lingua) references artifex.lingue(nome)
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

-- Appartenere
create table artifex.appartenere(
                                    ora_inizio datetime,
                                    titolo_visita varchar(100),
                                    nome_evento varchar(100),
                                    foreign key(titolo_visita) references artifex.visite(titolo),
                                    foreign key(nome_evento) references artifex.eventi(nome)
);

-- Contenere
create table artifex.contenere(
                                  nome_evento varchar(100),
                                  data_creazione datetime,
                                  email_utente varchar(100),
                                  foreign key(email_utente, data_creazione) references artifex.carrelli(email_utente, data_creazione),
                                  foreign key(nome_evento) references artifex.eventi(nome)
);

create table artifex.amministratore(
                                       email varchar(100) primary key,
                                       password varchar(100)
);

-- Inserimento dati
insert into artifex.lingue(nome)
values ('italiano'), ('tedesco'), ('inglese'), ('francese'), ('spagnolo'), ('rumeno'), ('russo');

insert into artifex.amministratore(email, password) values ('davide.soave@gmail.com', '$2y$10$s86IsG7ZOwShQfg2bnki/.s/3.rSFaFINsLU/jErYaRts9T59IcX6');

insert into artifex.guide (nome, cognome, titolo_studio, luogo_nascita, data_nascita) values
    ('Laura', 'Bianchi', 'Laurea in Storia dell\'Arte', 'Firenze', '1985-04-12'),
('Marco', 'Rossi', 'Laurea in Archeologia', 'Roma', '1978-11-23'),
('Anna', 'Verdi', 'Laurea in Lingue Straniere', 'Milano', '1990-07-15'),
('Luca', 'Neri', 'Laurea in Turismo Culturale', 'Venezia', '1982-01-30'),
('Elena', 'Russo', 'Laurea in Beni Culturali', 'Napoli', '1988-09-05');

insert into artifex.visite (titolo, luogo, durata_media) values
('Tour del Colosseo', 'Roma', 90),
('Galleria degli Uffizi', 'Firenze', 120),
('Venezia Storica', 'Venezia', 100),
('Milano e il Duomo', 'Milano', 80),
('Pompei Antica', 'Pompei', 150);

insert into artifex.eventi (nome, n_minimo, n_massimo, prezzo, nome_lingua, nome_guida, cognome_guida) values
('Colosseo Classico', 5, 20, 25.00, 'italiano', 'Laura', 'Bianchi'),
('Roma Antica in Inglese', 6, 25, 30.00, 'inglese', 'Marco', 'Rossi'),
('Visita in Francese agli Uffizi', 4, 15, 20.00, 'francese', 'Anna', 'Verdi'),
('Tour Tedesco Venezia', 8, 30, 28.00, 'tedesco', 'Luca', 'Neri'),
('Pompei in Spagnolo', 5, 18, 22.50, 'spagnolo', 'Elena', 'Russo');

