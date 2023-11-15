drop table if exists MCommunication;
drop table if exists MMessage;
drop table if exists MContact;
drop table if exists MUtilisateur;

create table MUtilisateur(
	idUtilisateur	int PRIMARY KEY,
	prenom			varchar(20),
	dateConnexion	date
);

create table MMessage(
	idMessage	int	PRIMARY KEY,
	dateEnvois	date
);

create table MContact(
	idContact				int PRIMARY KEY,
	idUtilisateurContact	int REFERENCES MUtilisateur(idUtilisateur),
	idUtilisateurCreation	int REFERENCES MUtilisateur(idUtilisateur),
	pseudo					varchar(20),
	dateCreation			date
);

create table MCommunication(
	idUserSource		int REFERENCES MUtilisateur(idUtilisateur),
	idUserDestination	int REFERENCES MUtilisateur(idUtilisateur),
	idMessage			int REFERENCES MMEssage(idMessage),
	PRIMARY KEY ( idUserSource, idUserDestination, idMessage )
);
