<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA["tx_ligestpublications_Publication"] = array (
	"ctrl" => $TCA["tx_ligestpublications_Publication"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden,typepublication,estediteur,estinternationale,estinvite,estunchapitre,estdelavulgarisation,titre,annee,pages,estparu,tauxselection,mediadepublication,isbn,notes,publisherorschool,volume,serie,numero,edition,datedebut,datefin,villeetpays"
	),
	"feInterface" => $TCA["tx_ligestpublications_Publication"]["feInterface"],
	"columns" => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		"typepublication" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.typepublication",		
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
		"estediteur" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estediteur",		
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estediteur.I.0", "F"),
					Array("LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estediteur.I.1", "V"),
				),
				"size" => 1,	
				"maxitems" => 1,
			)
		),
		"estinternationale" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estinternationale",		
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estinternationale.I.0", "I"),
					Array("LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estinternationale.I.1", "N"),
				),
				"size" => 1,	
				"maxitems" => 1,
			)
		),
		"estinvite" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estinvite",		
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estinvite.I.0", "F"),
					Array("LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estinvite.I.1", "V"),
				),
				"size" => 1,	
				"maxitems" => 1,
			)
		),
		"estunchapitre" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estunchapitre",		
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estunchapitre.I.0", "R"),
					Array("LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estunchapitre.I.1", "V"),
					Array("LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estunchapitre.I.2", "F"),
				),
				"size" => 1,	
				"maxitems" => 1,
			)
		),
		"estdelavulgarisation" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estdelavulgarisation",		
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estdelavulgarisation.I.0", "F"),
					Array("LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estdelavulgarisation.I.1", "V"),
				),
				"size" => 1,	
				"maxitems" => 1,
			)
		),
		"titre" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.titre",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "required,trim",
			)
		),
		"annee" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.annee",		
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
		"pages" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.pages",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"estparu" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estparu",		
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estparu.I.0", "F"),
					Array("LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estparu.I.1", "V"),
				),
				"size" => 1,	
				"maxitems" => 1,
			)
		),
		"tauxselection" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.tauxselection",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"mediadepublication" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.mediadepublication",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"isbn" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.isbn",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"notes" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.notes",		
			"config" => Array (
				"type" => "text",
				"cols" => "30",	
				"rows" => "15",
			)
		),
		"publisherorschool" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.publisherorschool",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"volume" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.volume",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"serie" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.serie",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"numero" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.numero",		
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
		"edition" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.edition",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"datedebut" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.datedebut",		
			"config" => Array (
				"type"     => "input",
				"size"     => "8",
				"max"      => "20",
				"eval"     => "date",
				"checkbox" => "0",
				"default"  => "0"
			)
		),
		"datefin" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.datefin",		
			"config" => Array (
				"type"     => "input",
				"size"     => "8",
				"max"      => "20",
				"eval"     => "date",
				"checkbox" => "0",
				"default"  => "0"
			)
		),
		"villeetpays" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.villeetpays",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "hidden;;1;;1-1-1, typepublication, estediteur, estinternationale, estinvite, estunchapitre, estdelavulgarisation, titre, annee, pages, estparu, tauxselection, mediadepublication, isbn, notes, publisherorschool, volume, serie, numero, edition, datedebut, datefin, villeetpays")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);



$TCA["tx_ligestpublications_Theme_Publication "] = array (
	"ctrl" => $TCA["tx_ligestpublications_Theme_Publication "]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden,idpublication,idtheme"
	),
	"feInterface" => $TCA["tx_ligestpublications_Theme_Publication "]["feInterface"],
	"columns" => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		"idpublication" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Theme_Publication .idpublication",		
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
		"idtheme" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Theme_Publication .idtheme",		
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
	),
	"types" => array (
		"0" => array("showitem" => "hidden;;1;;1-1-1, idpublication, idtheme")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);



$TCA["tx_ligestpublications_Theme"] = array (
	"ctrl" => $TCA["tx_ligestpublications_Theme"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,libelle"
	),
	"feInterface" => $TCA["tx_ligestpublications_Theme"]["feInterface"],
	"columns" => array (
		'sys_language_uid' => array (		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l18n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_ligestpublications_Theme',
				'foreign_table_where' => 'AND tx_ligestpublications_Theme.pid=###CURRENT_PID### AND tx_ligestpublications_Theme.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		"libelle" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Theme.libelle",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, libelle")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);



$TCA["tx_ligestpublications_Appartenir"] = array (
	"ctrl" => $TCA["tx_ligestpublications_Appartenir"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden,idpublication,idequipe"
	),
	"feInterface" => $TCA["tx_ligestpublications_Appartenir"]["feInterface"],
	"columns" => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		"idpublication" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Appartenir.idpublication",		
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
		"idequipe" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Appartenir.idequipe",		
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
	),
	"types" => array (
		"0" => array("showitem" => "hidden;;1;;1-1-1, idpublication, idequipe")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);



$TCA["tx_ligestpublications_Fichier"] = array (
	"ctrl" => $TCA["tx_ligestpublications_Fichier"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden,idpublication,lienfichier"
	),
	"feInterface" => $TCA["tx_ligestpublications_Fichier"]["feInterface"],
	"columns" => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		"idpublication" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Fichier.idpublication",		
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
		"lienfichier" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Fichier.lienfichier",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "hidden;;1;;1-1-1, idpublication, lienfichier")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);



$TCA["tx_ligestpublications_TypePublication"] = array (
	"ctrl" => $TCA["tx_ligestpublications_TypePublication"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,code,libelle"
	),
	"feInterface" => $TCA["tx_ligestpublications_TypePublication"]["feInterface"],
	"columns" => array (
		'sys_language_uid' => array (		
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l18n_parent' => array (		
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_ligestpublications_TypePublication',
				'foreign_table_where' => 'AND tx_ligestpublications_TypePublication.pid=###CURRENT_PID### AND tx_ligestpublications_TypePublication.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		"code" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_TypePublication.code",		
			"config" => Array (
				"type" => "input",	
				"size" => "5",	
				"max" => "5",	
				"eval" => "trim",
			)
		),
		"libelle" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_TypePublication.libelle",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, code, libelle")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);



$TCA["tx_ligestpublications_Publication_Auteur"] = array (
	"ctrl" => $TCA["tx_ligestpublications_Publication_Auteur"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden,idpublication,ordre,idauteur"
	),
	"feInterface" => $TCA["tx_ligestpublications_Publication_Auteur"]["feInterface"],
	"columns" => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		"idpublication" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication_Auteur.idpublication",		
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
		"ordre" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication_Auteur.ordre",		
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
		"idauteur" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication_Auteur.idauteur",		
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
	),
	"types" => array (
		"0" => array("showitem" => "hidden;;1;;1-1-1, idpublication, ordre, idauteur")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);



$TCA["tx_ligestpublications_Auteur"] = array (
	"ctrl" => $TCA["tx_ligestpublications_Auteur"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden,nom,prenom,idmembrelabo"
	),
	"feInterface" => $TCA["tx_ligestpublications_Auteur"]["feInterface"],
	"columns" => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		"nom" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Auteur.nom",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"prenom" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Auteur.prenom",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"idmembrelabo" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Auteur.idmembrelabo",		
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
	),
	"types" => array (
		"0" => array("showitem" => "hidden;;1;;1-1-1, nom, prenom, idmembrelabo")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);
?>