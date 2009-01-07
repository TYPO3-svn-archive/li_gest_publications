<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$tempColumns = Array (
	"tx_ligestpublications_afficher_auteur" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestmembrelabo_MembreDuLabo.tx_ligestpublications_afficher_auteur",		
		"config" => Array (
			"type"     => "input",
			"size"     => "4",
			"max"      => "4",
			"eval"     => "int",
			"checkbox" => "0",
			"range"    => Array (
				"upper" => "1000",
				"lower" => "10"
			),
			"default" => 0
		)
	),
	"tx_ligestpublications_afficher_publication" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestmembrelabo_MembreDuLabo.tx_ligestpublications_afficher_publication",		
		"config" => Array (
			"type"     => "input",
			"size"     => "4",
			"max"      => "4",
			"eval"     => "int",
			"checkbox" => "0",
			"range"    => Array (
				"upper" => "1000",
				"lower" => "10"
			),
			"default" => 0
		)
	),
);


t3lib_div::loadTCA("tx_ligestmembrelabo_MembreDuLabo");
t3lib_extMgm::addTCAcolumns("tx_ligestmembrelabo_MembreDuLabo",$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes("tx_ligestmembrelabo_MembreDuLabo","tx_ligestpublications_afficher_auteur;;;;1-1-1, tx_ligestpublications_afficher_publication");

$TCA["tx_ligestpublications_Publication"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication',		
		'label'     => 'uid',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY crdate",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ligestpublications_Publication.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "hidden, typepublication, estediteur, estinternationale, estinvite, estunchapitre, estdelavulgarisation, titre, annee, pages, estparu, tauxselection, mediadepublication, isbn, notes, publisherorschool, volume, serie, numero, edition, datedebut, datefin, villeetpays",
	)
);

$TCA["tx_ligestpublications_Theme_Publication "] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Theme_Publication ',		
		'label'     => 'uid',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY crdate",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ligestpublications_Theme_Publication .gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "hidden, idpublication, idtheme",
	)
);

$TCA["tx_ligestpublications_Theme"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Theme',		
		'label'     => 'uid',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l18n_parent',	
		'transOrigDiffSourceField' => 'l18n_diffsource',	
		'default_sortby' => "ORDER BY crdate",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ligestpublications_Theme.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, libelle",
	)
);

$TCA["tx_ligestpublications_Appartenir"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Appartenir',		
		'label'     => 'uid',	
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
		"fe_admin_fieldList" => "hidden, idpublication, idequipe",
	)
);

$TCA["tx_ligestpublications_Fichier"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Fichier',		
		'label'     => 'uid',	
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
		"fe_admin_fieldList" => "hidden, idpublication, lienfichier",
	)
);

$TCA["tx_ligestpublications_TypePublication"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_TypePublication',		
		'label'     => 'uid',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'languageField'            => 'sys_language_uid',	
		'transOrigPointerField'    => 'l18n_parent',	
		'transOrigDiffSourceField' => 'l18n_diffsource',	
		'default_sortby' => "ORDER BY crdate",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ligestpublications_TypePublication.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, code, libelle",
	)
);

$TCA["tx_ligestpublications_Publication_Auteur"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication_Auteur',		
		'label'     => 'uid',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY crdate",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ligestpublications_Publication_Auteur.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "hidden, idpublication, ordre, idauteur",
	)
);

$TCA["tx_ligestpublications_Auteur"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Auteur',		
		'label'     => 'uid',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY crdate",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_ligestpublications_Auteur.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "hidden, nom, prenom, idmembrelabo",
	)
);


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';


t3lib_extMgm::addPlugin(array('LLL:EXT:li_gest_publications/locallang_db.xml:tt_content.list_type_pi1', $_EXTKEY.'_pi1'),'list_type');


t3lib_extMgm::addStaticFile($_EXTKEY,"pi1/static/","Managing Publication");
?>