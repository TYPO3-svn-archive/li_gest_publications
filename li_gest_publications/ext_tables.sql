#
# Table structure for table 'tx_ligestmembrelabo_MembreDuLabo'
#
CREATE TABLE tx_ligestmembrelabo_MembreDuLabo (
	Afficher_auteur int(11) DEFAULT '0' NOT NULL,
);



#
# Table structure for table 'tx_ligestpublications_Publication'
#
CREATE TABLE tx_ligestpublications_Publication (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	/*sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,*/
	TypePublication int(11) DEFAULT '0' NOT NULL,
	EstEditeur char(1) DEFAULT '' NOT NULL,
	EstInternationale char(1) DEFAULT '' NOT NULL,
	EstInvite char(1) DEFAULT '' NOT NULL,
	EstUnChapitre char(1) DEFAULT '' NOT NULL,
	EstDeLaVulgarisation char(1) DEFAULT '' NOT NULL,
	Titre varchar(255) DEFAULT '' NOT NULL,
	Annee int(11) DEFAULT '0' NOT NULL,
	Pages varchar(255) DEFAULT '' NOT NULL,
	EstParu char(1) DEFAULT '' NOT NULL,
	TauxSelection varchar(255) DEFAULT '' NOT NULL,
	MediaDePublication varchar(255) DEFAULT '' NOT NULL,
	ISBN varchar(255) DEFAULT '' NOT NULL,
	Notes text NOT NULL,
	PublisherOrSchool varchar(255) DEFAULT '' NOT NULL,
	Volume varchar(255) DEFAULT '' NOT NULL,
	Serie varchar(255) DEFAULT '' NOT NULL,
	Numero varchar(255) DEFAULT '0' NOT NULL,
	Edition varchar(255) DEFAULT '' NOT NULL,
	DateDebut date DEFAULT '0000-00-00' NOT NULL,
	DateFin date DEFAULT '0000-00-00' NOT NULL,
	Lien varchar(255) DEFAULT '' NOT NULL,
	VilleEtPays varchar(255) DEFAULT '' NOT NULL,
	Afficher_Themes int(11) DEFAULT '0' NOT NULL,
	Afficher_Equipes int(11) DEFAULT '0' NOT NULL,
	Afficher_Auteurs int(11) DEFAULT '0' NOT NULL,
	Afficher_Fichiers int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_ligestpublications_Theme_Publication'
#
CREATE TABLE tx_ligestpublications_Theme_Publication (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	idPublication int(11) DEFAULT '0' NOT NULL,
	idTheme int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_ligestpublications_Theme'
#
CREATE TABLE tx_ligestpublications_Theme (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	Libelle varchar(255) DEFAULT '' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_ligestpublications_Appartenir'
#
CREATE TABLE tx_ligestpublications_Appartenir (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	idPublication int(11) DEFAULT '0' NOT NULL,
	idEquipe int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_ligestpublications_Fichier'
#
CREATE TABLE tx_ligestpublications_Fichier (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	idPublication int(11) DEFAULT '0' NOT NULL,
	NomFichier varchar(255) DEFAULT '' NOT NULL,
	LienFichier varchar(255) DEFAULT '' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_ligestpublications_TypePublication'
#
CREATE TABLE tx_ligestpublications_TypePublication (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	Code varchar(5) DEFAULT '' NOT NULL,
	Libelle varchar(255) DEFAULT '' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_ligestpublications_Publication_Auteur'
#
CREATE TABLE tx_ligestpublications_Publication_Auteur (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	idPublication int(11) DEFAULT '0' NOT NULL,
	idAuteur int(11) DEFAULT '0' NOT NULL,
	Ordre int(11) DEFAULT '0' NOT NULL,
	
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_ligestpublications_Auteur'
#
CREATE TABLE tx_ligestpublications_Auteur (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	Nom varchar(255) DEFAULT '' NOT NULL,
	Prenom varchar(255) DEFAULT '' NOT NULL,
	idMembreLabo int(11) DEFAULT '0' NOT NULL,
	Afficher_Publications int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);