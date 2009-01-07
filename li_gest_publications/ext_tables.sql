#
# Table structure for table 'tx_ligestmembrelabo_MembreDuLabo'
#
CREATE TABLE tx_ligestmembrelabo_MembreDuLabo (
	tx_ligestpublications_afficher_auteur int(11) DEFAULT '0' NOT NULL,
	tx_ligestpublications_afficher_publication int(11) DEFAULT '0' NOT NULL
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
	typepublication int(11) DEFAULT '0' NOT NULL,
	estediteur char(1) DEFAULT '' NOT NULL,
	estinternationale char(1) DEFAULT '' NOT NULL,
	estinvite char(1) DEFAULT '' NOT NULL,
	estunchapitre char(1) DEFAULT '' NOT NULL,
	estdelavulgarisation char(1) DEFAULT '' NOT NULL,
	titre varchar(255) DEFAULT '' NOT NULL,
	annee int(11) DEFAULT '0' NOT NULL,
	pages varchar(255) DEFAULT '' NOT NULL,
	estparu char(1) DEFAULT '' NOT NULL,
	tauxselection varchar(255) DEFAULT '' NOT NULL,
	mediadepublication varchar(255) DEFAULT '' NOT NULL,
	isbn varchar(255) DEFAULT '' NOT NULL,
	notes text NOT NULL,
	publisherorschool varchar(255) DEFAULT '' NOT NULL,
	volume varchar(255) DEFAULT '' NOT NULL,
	serie varchar(255) DEFAULT '' NOT NULL,
	numero int(11) DEFAULT '0' NOT NULL,
	edition varchar(255) DEFAULT '' NOT NULL,
	datedebut int(11) DEFAULT '0' NOT NULL,
	datefin int(11) DEFAULT '0' NOT NULL,
	villeetpays varchar(255) DEFAULT '' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_ligestpublications_Theme_Publication '
#
CREATE TABLE tx_ligestpublications_Theme_Publication  (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	idpublication int(11) DEFAULT '0' NOT NULL,
	idtheme int(11) DEFAULT '0' NOT NULL,
	
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
	libelle varchar(255) DEFAULT '' NOT NULL,
	
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
	idpublication int(11) DEFAULT '0' NOT NULL,
	idequipe int(11) DEFAULT '0' NOT NULL,
	
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
	idpublication int(11) DEFAULT '0' NOT NULL,
	lienfichier varchar(255) DEFAULT '' NOT NULL,
	
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
	code varchar(5) DEFAULT '' NOT NULL,
	libelle varchar(255) DEFAULT '' NOT NULL,
	
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
	idpublication int(11) DEFAULT '0' NOT NULL,
	ordre int(11) DEFAULT '0' NOT NULL,
	idauteur int(11) DEFAULT '0' NOT NULL,
	
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
	nom varchar(255) DEFAULT '' NOT NULL,
	prenom varchar(255) DEFAULT '' NOT NULL,
	idmembrelabo int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);