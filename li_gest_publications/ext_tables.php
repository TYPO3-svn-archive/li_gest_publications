<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

// Classe pour la gestion des dates obligatoires dans les formulaires
$TYPO3_CONF_VARS['SC_OPTIONS']['tce']['formevals']['tx_ligestpublications_annee'] = 'EXT:li_gest_publications/class.tx_ligestpublications_annee.php';



// Ajout de champs dans le formulaire de la table tx_ligestmembrelabo_MembreDuLabo

$tempColumns = Array (
	"Afficher_auteur" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestmembrelabo_MembreDuLabo.Afficher_auteur",		
		"config" => Array (
			"type" => "select",
			"foreign_table" => "tx_ligestpublications_Auteur",	
			"foreign_table_where" => "AND tx_ligestpublications_Auteur.idMembreLabo=###THIS_UID### AND tx_ligestpublications_Auteur.idMembreLabo!=0 ORDER BY tx_ligestpublications_Auteur.Nom",
			"size" => 6,
			"minitems" => 0,
			"maxitems" => 0,
			"wizards" => Array(
				"_PADDING" => 2,
				"_VERTICAL" => 1,
				"add" => Array(
					"type" => "popup",
					"title" => "Create new record",
					"notNewRecords" => 1,
					"script" => t3lib_extMgm::extRelPath("li_gest_membre_labo")."wizard/add.php",
					"icon" => "add.gif",
					"params" => Array(
						"table"			=> "tx_ligestpublications_Auteur",
						"champ"			=> "idMembreLabo"
					),
					"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
				),
				"edit" => Array(
					"type" => "popup",
					"title" => "Edit",
					"script" => "wizard_edit.php",
					"notNewRecords" => 1,
					"popup_onlyOpenIfSelected" => 1,
					"icon" => "edit2.gif",
					"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
				),
				"del" => Array(
					"title" => "Delete record",
					"type" => "popup",
					"notNewRecords" => 1,
					"icon" => "clearout.gif",
					"popup_onlyOpenIfSelected" => 1,
					'params' => Array(
						'table'=>'tx_ligesttheses_TheseHDR',
					),
					"script" => t3lib_extMgm::extRelPath("li_gest_membre_labo")."wizard/delete.php",
					"JSopenParams" => "height=1,width=1,status=0,menubar=0,scrollbars=1",
				),
			),
		),
	),
);



t3lib_div::loadTCA("tx_ligestmembrelabo_MembreDuLabo");
t3lib_extMgm::addTCAcolumns("tx_ligestmembrelabo_MembreDuLabo",$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes("tx_ligestmembrelabo_MembreDuLabo","Afficher_auteur;;;;1-1-1");




// Paramétrage de l'affichage de listes d'enregistrement de la table tx_ligestpublications_Publication dans le backend.

// allow Publication records on normal pages
t3lib_extMgm::allowTableOnStandardPages('tx_ligestpublications_Publication');
// add the Publication record to the insert records content element
t3lib_extMgm::addToInsertRecords('tx_ligestpublications_Publication');

$TCA["tx_ligestpublications_Publication"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication',		
		'label'     => 'Titre',
		'label_alt' => '',
		'label_alt_force' => '1',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY Titre, Annee",
/*
		'copyAfterDuplFields' => 'sys_language_uid',
		'useColumnsForDefaultValues' => 'sys_language_uid',
		'transOrigPointerField' => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
		'languageField' => 'sys_language_uid',
		'shadowColumnsForNewPlaceholders' => 'sys_language_uid,l18n_parent',
*/
		'delete' => 'deleted',
		'enablecolumns' => array (
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ligestpublications_Publication.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "hidden, TypePublication, EstEditeur, EstInternationale, EstInvite, EstUnChapitre, EstDeLaVulgarisation, Titre, Annee, Pages, EstParu, TauxSelection, MediaDePublication, ISBN, Notes, PublisherOrSchool, Volume, Serie, Numero, Edition, DateDebut, DateFin, VilleEtPays, Afficher_Themes, Afficher_Equipes, Afficher_Auteurs, Afficher_Fichiers",
	)
);


// Paramétrage de l'affichage de listes d'enregistrement de la table tx_ligestpublications_Theme_Publication dans le backend.

// allow Theme_Publication records on normal pages
//t3lib_extMgm::allowTableOnStandardPages('tx_ligestpublications_Theme_Publication');
// add the Theme_Publication record to the insert records content element
//t3lib_extMgm::addToInsertRecords('tx_ligestpublications_Theme_Publication');

$TCA["tx_ligestpublications_Theme_Publication"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Theme_Publication',
		'label'     => 'idTheme',
		'label_alt' => '',
		'label_alt_force' => '1',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY crdate",
		'delete' => 'deleted',
		'enablecolumns' => array (
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ligestpublications_Theme_Publication.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "hidden, idPublication, idTheme",
	)
);



// Paramétrage de l'affichage de listes d'enregistrement de la table tx_ligestpublications_Theme dans le backend.

// allow Theme records on normal pages
t3lib_extMgm::allowTableOnStandardPages('tx_ligestpublications_Theme');
// add the Theme record to the insert records content element
t3lib_extMgm::addToInsertRecords('tx_ligestpublications_Theme');

$TCA["tx_ligestpublications_Theme"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Theme',		
		'label'     => 'Libelle',
		'label_alt' => '',
		'label_alt_force' => '1',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		
		'copyAfterDuplFields' => 'sys_language_uid',
		'useColumnsForDefaultValues' => 'sys_language_uid',
		'transOrigPointerField' => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
		'languageField' => 'sys_language_uid',
		'shadowColumnsForNewPlaceholders' => 'sys_language_uid,l18n_parent',
		
		'default_sortby' => "ORDER BY Libelle",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ligestpublications_Theme.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "hidden, sys_language_uid, l18n_parent, l18n_diffsource, Libelle",
	)
);

// Paramétrage de l'affichage de listes d'enregistrement de la table tx_ligestpublications_Appartenir dans le backend.

// allow Appartenir records on normal pages
//t3lib_extMgm::allowTableOnStandardPages('tx_ligestpublications_Appartenir');
// add the Appartenir record to the insert records content element
//t3lib_extMgm::addToInsertRecords('tx_ligestpublications_Appartenir');

$TCA["tx_ligestpublications_Appartenir"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Appartenir',		
		'label'     => 'idEquipe',
		'label_alt' => '',
		'label_alt_force' => '1',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY crdate",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ligestpublications_Appartenir.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "hidden, idPublication, idEquipe",
	)
);

// Paramétrage de l'affichage de listes d'enregistrement de la table tx_ligestpublications_Fichier dans le backend.

// allow Fichier records on normal pages
t3lib_extMgm::allowTableOnStandardPages('tx_ligestpublications_Fichier');
// add the Fichier record to the insert records content element
t3lib_extMgm::addToInsertRecords('tx_ligestpublications_Fichier');

$TCA["tx_ligestpublications_Fichier"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Fichier',		
		'label'     => 'NomFichier',
		'label_alt' => '',
		'label_alt_force' => '1',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY crdate",
		'delete' => 'deleted',
		'enablecolumns' => array (
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ligestpublications_Fichier.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "hidden, idPublication, NomFichier, LienFichier",
	)
);

// Paramétrage de l'affichage de listes d'enregistrement de la table tx_ligestpublications_TypePublication dans le backend.

// allow TypePublication records on normal pages
t3lib_extMgm::allowTableOnStandardPages('tx_ligestpublications_TypePublication');
// add the TypePublication record to the insert records content element
t3lib_extMgm::addToInsertRecords('tx_ligestpublications_TypePublication');

$TCA["tx_ligestpublications_TypePublication"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_TypePublication',		
		'label'     => 'Libelle',
		'label_alt' => '',
		'label_alt_force' => '1',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',

		'copyAfterDuplFields' => 'sys_language_uid',
		'useColumnsForDefaultValues' => 'sys_language_uid',
		'transOrigPointerField' => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
		'languageField' => 'sys_language_uid',
		'shadowColumnsForNewPlaceholders' => 'sys_language_uid,l18n_parent',
		
		'default_sortby' => "ORDER BY Libelle",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ligestpublications_TypePublication.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "hidden, sys_language_uid, l18n_parent, l18n_diffsource, Code, Libelle",
	)
);

// Paramétrage de l'affichage de listes d'enregistrement de la table tx_ligestpublications_Publication_Auteur dans le backend.

// allow Publication_Auteur records on normal pages
//t3lib_extMgm::allowTableOnStandardPages('tx_ligestpublications_Publication_Auteur');
// add the Publication_Auteur record to the insert records content element
//t3lib_extMgm::addToInsertRecords('tx_ligestpublications_Publication_Auteur');

$TCA["tx_ligestpublications_Publication_Auteur"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication_Auteur',
		'label'     => 'idAuteur, Ordre, idPublication',
		'label_alt' => 'idAuteur, Ordre, idPublication',
		'label_alt_force' => '1',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY idPublication",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ligestpublications_Publication_Auteur.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "hidden, idPublication, idAuteur, Ordre",
	)
);

// Paramétrage de l'affichage de listes d'enregistrement de la table tx_ligestpublications_Auteur dans le backend.

// allow Auteur records on normal pages
t3lib_extMgm::allowTableOnStandardPages('tx_ligestpublications_Auteur');
// add the Auteur record to the insert records content element
t3lib_extMgm::addToInsertRecords('tx_ligestpublications_Auteur');

$TCA["tx_ligestpublications_Auteur"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Auteur',		
		'label'     => 'Nom, Prenom',
		'label_alt' => 'Nom, Prenom',
		'label_alt_force' => '1',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY Nom, Prenom",
		'delete' => 'deleted',
		'enablecolumns' => array (
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ligestpublications_Auteur.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "hidden, Nom, Prenom, idMembreLabo",
	)
);

// initalize "context sensitive help" (csh)
t3lib_extMgm::addLLrefForTCAdescr('tx_ligestmembrelabo_MembreDuLabo','EXT:li_gest_publications/csh/ligestpublications_locallang_csh_tx_ligestmembrelabo_MembreDuLabo.xml');
t3lib_extMgm::addLLrefForTCAdescr('tx_ligestpublications_Publication','EXT:li_gest_publications/csh/ligestpublications_locallang_csh_tx_ligestpublications_Publication.xml');
t3lib_extMgm::addLLrefForTCAdescr('tx_ligestpublications_Appartenir','EXT:li_gest_publications/csh/ligestpublications_locallang_csh_tx_ligestpublications_Appartenir.xml');
t3lib_extMgm::addLLrefForTCAdescr('tx_ligestpublications_Auteur','EXT:li_gest_publications/csh/ligestpublications_locallang_csh_tx_ligestpublications_Auteur.xml');
t3lib_extMgm::addLLrefForTCAdescr('tx_ligestpublications_Fichier','EXT:li_gest_publications/csh/ligestpublications_locallang_csh_tx_ligestpublications_Fichier.xml');
t3lib_extMgm::addLLrefForTCAdescr('tx_ligestpublications_Publication_Auteur','EXT:li_gest_publications/csh/ligestpublications_locallang_csh_tx_ligestpublications_Publication_Auteur.xml');
t3lib_extMgm::addLLrefForTCAdescr('tx_ligestpublications_Theme','EXT:li_gest_publications/csh/ligestpublications_locallang_csh_tx_ligestpublications_Theme.xml');
t3lib_extMgm::addLLrefForTCAdescr('tx_ligestpublications_Theme_Publication','EXT:li_gest_publications/csh/ligestpublications_locallang_csh_tx_ligestpublications_Theme_Publication.xml');
t3lib_extMgm::addLLrefForTCAdescr('tx_ligestpublications_TypePublication','EXT:li_gest_publications/csh/ligestpublications_locallang_csh_tx_ligestpublications_TypePublication.xml');





t3lib_div::loadTCA('tt_content');

$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key,pages';

// add FlexForm field to tt_content
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1']='pi_flexform';


t3lib_extMgm::addPlugin(array('LLL:EXT:li_gest_publications/locallang_db.xml:tt_content.list_type_pi1', $_EXTKEY.'_pi1'),'list_type');


t3lib_extMgm::addStaticFile($_EXTKEY,"pi1/static/","Managing Publication");

// switch the XML files for the FlexForm
t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_pi1', 'FILE:EXT:li_gest_publications/flexform_ds_pi1.xml');



if (TYPO3_MODE=="BE")	$TBE_MODULES_EXT["xMOD_db_new_content_el"]["addElClasses"]["tx_ligestpublications_pi1_wizicon"] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_ligestpublications_pi1_wizicon.php';
?>