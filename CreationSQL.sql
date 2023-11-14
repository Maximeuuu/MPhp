drop table MCommunication;
drop table MMessage;
drop table MContact;
drop table MPersonne;

create table MCommunication(
idPersonneE REFERENCE(),
idPersonneR REFERENCE(),
idMessage REFERENCE()
);

create table MMessage(
idMessage int PRIMARY KEY,
personne REFERENCE(),
dateEnvois date;
);

create table MContact(
idContact int PRIMARY KEY,
idPersonneContact int REFERENCE(),
idPersonneCreation int REFERENCE(),
pseudo varchar(20),
dateCreation date
);

create table MPersonne(
idPersonne int PRIMARY KEY,
prenom varchar(20),
dateConnexion date
);
