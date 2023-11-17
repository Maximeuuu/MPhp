--drop table if exists MCommunication;
drop table if exists MMessage;
drop table if exists MContact;
drop table if exists MUtilisateur;

create table MUtilisateur(
	idu	int PRIMARY KEY,
	prenom			varchar(20),
	dateconnexion	date
);

create table MMessage(
	idmessage	int	PRIMARY KEY,
	idusource	int REFERENCES MUtilisateur(idu),
	idudest		int REFERENCES MUtilisateur(idu),
	dateenvois	date,
	contenu		text
);

create table MContact(
	idc				int PRIMARY KEY,
	iducontact		int REFERENCES MUtilisateur(idu),
	iducreation		int REFERENCES MUtilisateur(idu),
	pseudo			varchar(20),
	datecreation	date
);

/*
create table MCommunication(
	idUserSource		int REFERENCES MUtilisateur(idUtilisateur),
	idUserDestination	int REFERENCES MUtilisateur(idUtilisateur),
	idMessage			int REFERENCES MMEssage(idMessage),
	PRIMARY KEY ( idUserSource, idUserDestination, idMessage )
);*/
