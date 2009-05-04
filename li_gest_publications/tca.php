<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA["tx_ligestpublications_Publication"] = array (
	"ctrl" => $TCA["tx_ligestpublications_Publication"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden, Titre, TypePublication, EstEditeur, EstInternationale, EstInvite, EstUnChapitre, EstDeLaVulgarisation, Pages, EstParu, TauxSelection, MediaDePublication, ISBN, Notes, PublisherOrSchool, Volume, Serie, Numero, Edition, Annee, DateDebut, DateFin, VilleEtPays, Lien, Afficher_Themes, Afficher_Equipes, Afficher_Auteurs, Afficher_Fichiers"
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
		/*'sys_language_uid' => array (		
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
				'foreign_table'       => 'tx_ligestpublications_Publication',
				'foreign_table_where' => 'AND tx_ligestpublications_Publication.pid=###CURRENT_PID### AND tx_ligestpublications_Publication.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array (		
			'config' => array (
				'type' => 'passthrough'
			)
		),*/
		"Titre" => Array (		
			"exclude" => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.titre",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"TypePublication" => Array (		
			"exclude" => 1,
			'l10n_display' => 'defaultAsReadonly',	
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.typepublication",		
			"config" => Array (
				"type" => "select",	
				"foreign_table" => "tx_ligestpublications_TypePublication",	
				"foreign_table_where" => "AND tx_ligestpublications_TypePublication.sys_language_uid=0 ORDER BY tx_ligestpublications_TypePublication.Libelle",	
				"size" => 1,
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
		"EstEditeur" => Array (		
			"exclude" => 1,
			'l10n_display' => 'defaultAsReadonly',	
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
		"EstInternationale" => Array (		
			"exclude" => 1,
			'l10n_display' => 'defaultAsReadonly',	
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
		"EstInvite" => Array (		
			"exclude" => 1,
			'l10n_display' => 'defaultAsReadonly',	
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
		"EstUnChapitre" => Array (		
			"exclude" => 1,
			'l10n_display' => 'defaultAsReadonly',
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
		"EstDeLaVulgarisation" => Array (		
			"exclude" => 1,
			'l10n_display' => 'defaultAsReadonly',
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
		"Annee" => Array (
			"exclude" => 1,
			'l10n_display' => 'defaultAsReadonly',
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.annee",		
			"config" => Array (
				"type" => "input",
				"size" => "10",
				"max" => "4",
				"eval" => "trim, int, tx_ligestpublications_annee",
				//"eval" => "trim, int",
			)
		),
		"Pages" => Array (
			"exclude" => 1,
			'l10n_display' => 'defaultAsReadonly',
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.pages",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"EstParu" => Array (		
			"exclude" => 1,
			'l10n_display' => 'defaultAsReadonly',
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estparu",		
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estparu.I.0", "E"),
					Array("LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estparu.I.1", "V"),
					Array("LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.estparu.I.2", "F"),
				),
				"size" => 1,	
				"maxitems" => 1,
			)
		),
		"TauxSelection" => Array (		
			"exclude" => 1,
			'l10n_display' => 'defaultAsReadonly',
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.tauxselection",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim, double2",
			)
		),
		"MediaDePublication" => Array (		
			"exclude" => 1,
			'l10n_display' => 'defaultAsReadonly',
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.mediadepublication",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"ISBN" => Array (
			"exclude" => 1,
			'l10n_display' => 'defaultAsReadonly',
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.isbn",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"Notes" => Array (
			"exclude" => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.notes",		
			"config" => Array (
				"type" => "text",
				"cols" => "30",	
				"rows" => "15",
			)
		),
		"PublisherOrSchool" => Array (
			"exclude" => 1,
			'l10n_display' => 'defaultAsReadonly',
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.publisherorschool",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"Volume" => Array (
			"exclude" => 1,
			'l10n_display' => 'defaultAsReadonly',
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.volume",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"Serie" => Array (
			"exclude" => 1,
			'l10n_display' => 'defaultAsReadonly',
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.serie",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"Numero" => Array (
			"exclude" => 1,
			'l10n_display' => 'defaultAsReadonly',
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.numero",			"config" => Array (
				"type" => "input",
				"size" => "10",
				"max" => "8",
				"eval" => "trim, int",
			)
		),
		"Edition" => Array (
			"exclude" => 1,
			'l10n_display' => 'defaultAsReadonly',
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.edition",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"DateDebut" => Array (
			"exclude" => 1,
			'l10n_display' => 'defaultAsReadonly',
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.datedebut",			
			"config" => Array (
				"type"     => "input",
				"size"     => "10",
				"max"      => "10",
				"eval"     => "trim,tx_ligestmembrelabo_dateValide",
				'default' => '0000-00-00'
			)
		),
		"DateFin" => Array (
			"exclude" => 1,
			'l10n_display' => 'defaultAsReadonly',
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.datefin",		
			"config" => Array (
				"type"     => "input",
				"size"     => "10",
				"max"      => "10",
				"eval"     => "trim,tx_ligestmembrelabo_dateValide",
				'default' => '0000-00-00'
			)
		),
		"VilleEtPays" => Array (
			"exclude" => 1,
			'l10n_display' => 'defaultAsReadonly',
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.villeetpays",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"Lien" => Array (
			"exclude" => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.Lien",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"Afficher_Themes" => Array (
			"exclude" => 1,
			"l10n_mode" => "exclude",
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.Afficher_Themes",		
			"config" => Array (
				"type" => "select",
				"foreign_table" => "tx_ligestpublications_Theme_Publication",	
				"foreign_table_where" => "AND tx_ligestpublications_Theme_Publication.IdPublication=###THIS_UID### ORDER BY tx_ligestpublications_Theme_Publication.uid",
				"size" => 6,
				"minitems" => 0,
				"maxitems" => 1,
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
							"table"			=> "tx_ligestpublications_Theme_Publication",
							"champ"			=> "IdPublication",
							"lien"			=> Array('tx_ligestpublications_Theme')
						),
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"notNewRecords" => 1,
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
							'table'=>'tx_ligestpublications_Theme_Publication'
						),
						"script" => t3lib_extMgm::extRelPath("li_gest_membre_labo")."wizard/delete.php",
						"JSopenParams" => "height=1,width=1,status=0,menubar=0,scrollbars=1",
					),
					"reload" => Array(
						"title" => "Refresh",
						"type" => "popup",
						"icon" => "refresh_n.gif",
						"notNewRecords" => 1,
						"script" => t3lib_extMgm::extRelPath("li_gest_membre_labo")."wizard/reload.php",
						"JSopenParams" => "height=1,width=1,status=0,menubar=0,scrollbars=1",
					),
					
				),
			),
		),
		"Afficher_Equipes" => Array (
			"exclude" => 1,
			"l10n_mode" => "exclude",
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.Afficher_Equipes",		
			"config" => Array (
				"type" => "select",
				"foreign_table" => "tx_ligestpublications_Appartenir",	
				"foreign_table_where" => "AND tx_ligestpublications_Appartenir.idPublication=###THIS_UID### ORDER BY tx_ligestpublications_Appartenir.uid",
				"size" => 6,
				"minitems" => 0,
				"maxitems" => 1,
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
							"table"			=> "tx_ligestpublications_Appartenir",
							"champ"			=> "idPublication",
							"lien"			=> Array('tx_ligestmembrelabo_Equipe')
						),
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
					
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"notNewRecords" => 1,
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
							'table'=>'tx_ligestpublications_Appartenir'
						),
						"script" => t3lib_extMgm::extRelPath("li_gest_membre_labo")."wizard/delete.php",
						"JSopenParams" => "height=1,width=1,status=0,menubar=0,scrollbars=1",
					),
					"reload" => Array(
						"title" => "Refresh",
						"type" => "popup",
						"icon" => "refresh_n.gif",
						"notNewRecords" => 1,
						"script" => t3lib_extMgm::extRelPath("li_gest_membre_labo")."wizard/reload.php",
						"JSopenParams" => "height=1,width=1,status=0,menubar=0,scrollbars=1",
					),
					
				),
			),
		),
		"Afficher_Auteurs" => Array (
			"exclude" => 1,
			"l10n_mode" => "exclude",
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.Afficher_Auteurs",		
			"config" => Array (
				"type" => "select",
				"foreign_table" => "tx_ligestpublications_Publication_Auteur",	
				"foreign_table_where" => "AND tx_ligestpublications_Publication_Auteur.idPublication=###THIS_UID### ORDER BY tx_ligestpublications_Publication_Auteur.Ordre",
				"size" => 6,
				"minitems" => 0,
				"maxitems" => 1,
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
							"table"			=> "tx_ligestpublications_Publication_Auteur",
							"champ"			=> "idPublication",
							"lien"			=> Array('tx_ligestpublications_Auteur')
						),
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"notNewRecords" => 1,
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
							'table'=>'tx_ligestpublications_Publication_Auteur'
						),
						"script" => t3lib_extMgm::extRelPath("li_gest_membre_labo")."wizard/delete.php",
						"JSopenParams" => "height=1,width=1,status=0,menubar=0,scrollbars=1",
					),
					"reload" => Array(
						"title" => "Refresh",
						"type" => "popup",
						"icon" => "refresh_n.gif",
						"notNewRecords" => 1,
						"script" => t3lib_extMgm::extRelPath("li_gest_membre_labo")."wizard/reload.php",
						"JSopenParams" => "height=1,width=1,status=0,menubar=0,scrollbars=1",
					),
					
				),
			),
		),
		"Afficher_Fichiers" => Array (
			"exclude" => 1,
			"l10n_mode" => "exclude",
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.Afficher_Fichiers",		
			"config" => Array (
				"type" => "select",
				"foreign_table" => "tx_ligestpublications_Fichier",	
				"foreign_table_where" => "AND tx_ligestpublications_Fichier.idPublication=###THIS_UID### ORDER BY tx_ligestpublications_Fichier.NomFichier",
				"size" => 6,
				"minitems" => 0,
				"maxitems" => 1,
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
							"table"			=> "tx_ligestpublications_Fichier",
							"champ"			=> "idPublication"
						),
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"notNewRecords" => 1,
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
							'table'=>'tx_ligestpublications_Fichier'
						),
						"script" => t3lib_extMgm::extRelPath("li_gest_membre_labo")."wizard/delete.php",
						"JSopenParams" => "height=1,width=1,status=0,menubar=0,scrollbars=1",
					),
					"reload" => Array(
						"title" => "Refresh",
						"type" => "popup",
						"icon" => "refresh_n.gif",
						"notNewRecords" => 1,
						"script" => t3lib_extMgm::extRelPath("li_gest_membre_labo")."wizard/reload.php",
						"JSopenParams" => "height=1,width=1,status=0,menubar=0,scrollbars=1",
					),
					
				),
			),
		),
	),
	"types" => array (
		"0" => array("showitem" => "hidden;;1;;1-1-1, Titre,  TypePublication, EstEditeur, EstInternationale, EstInvite, EstUnChapitre, EstDeLaVulgarisation, Pages, EstParu, TauxSelection, MediaDePublication, ISBN, Notes, PublisherOrSchool, Volume, Serie, Numero, Edition, Annee, DateDebut, DateFin, VilleEtPays, Lien, Afficher_Themes, Afficher_Equipes, Afficher_Auteurs, Afficher_Fichiers")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);



$TCA["tx_ligestpublications_Theme_Publication"] = array (
	"ctrl" => $TCA["tx_ligestpublications_Theme_Publication"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden, idPublication, idTheme"
	),
	"feInterface" => $TCA["tx_ligestpublications_Theme_Publication"]["feInterface"],
	"columns" => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		"idPublication" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Theme_Publication.idpublication",		
			"config" => Array (
				"type" => "select",	
				"foreign_table" => "tx_ligestpublications_Publication",	
				"foreign_table_where" => "AND tx_ligestpublications_Publication.sys_language_uid=0 ORDER BY tx_ligestpublications_Publication.Titre",	
				"size" => 1,
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
		"idTheme" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Theme.idtheme",
			"config" => Array (
				"type" => "select",
				"foreign_table" => "tx_ligestpublications_Theme",	
				"foreign_table_where" => "AND tx_ligestpublications_Theme.sys_language_uid=0 ORDER BY tx_ligestpublications_Theme.Libelle",	
				"size" => 1,
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "hidden;;1;;1-1-1, idPublication, idTheme")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);



$TCA["tx_ligestpublications_Theme"] = array (
	"ctrl" => $TCA["tx_ligestpublications_Theme"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden, sys_language_uid, l18n_parent, l18n_diffsource, Libelle"
	),
	"feInterface" => $TCA["tx_ligestpublications_Theme"]["feInterface"],
	"columns" => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
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
		"Libelle" => Array (		
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
		"0" => array("showitem" => "hidden;;1;;1-1-1, sys_language_uid, l18n_parent, l18n_diffsource, Libelle")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);



$TCA["tx_ligestpublications_Appartenir"] = array (
	"ctrl" => $TCA["tx_ligestpublications_Appartenir"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden, idPublication, idEquipe"
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
		"idPublication" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Appartenir.idpublication",		
			"config" => Array (
				"type" => "select",
				"foreign_table" => "tx_ligestpublications_Publication",	
				"foreign_table_where" => "AND tx_ligestpublications_Publication.sys_language_uid=0 ORDER BY tx_ligestpublications_Publication.Titre",	
				"size" => 1,
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
		"idEquipe" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Appartenir.idequipe",			
			"config" => Array (
				"type" => "select",
				"foreign_table" => "tx_ligestmembrelabo_Equipe",	
				"foreign_table_where" => "AND tx_ligestmembrelabo_Equipe.sys_language_uid=0 ORDER BY tx_ligestmembrelabo_Equipe.Abreviation",	
				"size" => 1,
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "hidden;;1;;1-1-1, idPublication, idEquipe")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);



$TCA["tx_ligestpublications_Fichier"] = array (
	"ctrl" => $TCA["tx_ligestpublications_Fichier"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden, idPublication, NomFichier, LienFichier, fe_group"
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
		"idPublication" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Fichier.idpublication",		
			"config" => Array (
				"type" => "select",
				"foreign_table" => "tx_ligestpublications_Publication",	
				"foreign_table_where" => "AND tx_ligestpublications_Publication.sys_language_uid=0 ORDER BY tx_ligestpublications_Publication.Titre",	
				"size" => 1,
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
		"NomFichier" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Fichier.nomfichier",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"LienFichier" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Fichier.lienfichier",
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"link" => Array(
						"type" => "popup",
						"title" => "Link",
						"icon" => "link_popup.gif",
						"script" => "browse_links.php?mode=wizard&amp;act=file",
						"params" => Array(
							"blindLinkOptions"			=> "page,url,mail,spec",
							//"allowedExtensions"			=> "htm,html,tmpl,tpl"
						),
						"JSopenParams" => "height=300,width=500,status=0,menubar=0,scrollbars=1",
					),
					/*"add" => Array(
						"type" => "popup",
						"title" => "Create new record",
						"notNewRecords" => 1,
						"script" => t3lib_extMgm::extRelPath("li_gest_publications")."wizard/add_file.php",
						"icon" => "add.gif",
						"params" => Array(

						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
					"del" => Array(
						"title" => "Delete record",
						"type" => "popup",
						"notNewRecords" => 1,
						"icon" => "clearout.gif",
						"popup_onlyOpenIfSelected" => 1,
						'params' => Array(
							'table'=>'tx_ligestpublications_Theme_Publication'
						),
						"script" => t3lib_extMgm::extRelPath("li_gest_publications")."wizard/delete_file.php",
						"JSopenParams" => "height=1,width=1,status=0,menubar=0,scrollbars=1",
					),*/
				),
			),
		),
		'fe_group' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
			'config'  => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'foreign_table' => 'fe_groups'
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "hidden;;1;;1-1-1, idPublication, NomFichier, LienFichier, fe_group")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);



$TCA["tx_ligestpublications_TypePublication"] = array (
	"ctrl" => $TCA["tx_ligestpublications_TypePublication"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden, sys_language_uid, l18n_parent, l18n_diffsource, Code, Libelle"
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
		"Code" => Array (		
			"exclude" => 1,	
			'l10n_display' => 'defaultAsReadonly',
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_TypePublication.code",		
			"config" => Array (
				"type" => "input",	
				"size" => "5",	
				"max" => "5",	
				"eval" => "trim",
			)
		),
		"Libelle" => Array (		
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
		"0" => array("showitem" => "hidden;;;;1-1-1, sys_language_uid, l18n_parent, l18n_diffsource;;1, Code, Libelle")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);



$TCA["tx_ligestpublications_Publication_Auteur"] = array (
	"ctrl" => $TCA["tx_ligestpublications_Publication_Auteur"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden, idPublication, idAuteur, Ordre"
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
		"idPublication" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication_Auteur.idpublication",		
			"config" => Array (
				"type" => "select",
				"foreign_table" => "tx_ligestpublications_Publication",	
				"foreign_table_where" => "AND tx_ligestpublications_Publication.sys_language_uid=0 ORDER BY tx_ligestpublications_Publication.Titre",	
				"size" => 1,
				"minitems" => 0,
				"maxitems" => 1,
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"notNewRecords" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
					"reload" => Array(
						"title" => "Refresh",
						"type" => "popup",
						"icon" => "refresh_n.gif",
						"notNewRecords" => 1,
						"script" => t3lib_extMgm::extRelPath("li_gest_membre_labo")."wizard/reload.php",
						"JSopenParams" => "height=1,width=1,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"idAuteur" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication_Auteur.idauteur",		
			"config" => Array (
				"type" => "select",
				"foreign_table" => "tx_ligestpublications_Auteur",	
				"foreign_table_where" => "ORDER BY tx_ligestpublications_Auteur.Nom, tx_ligestpublications_Auteur.Prenom",	
				"size" => 1,
				"minitems" => 0,
				"maxitems" => 1,
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"notNewRecords" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
					"reload" => Array(
						"title" => "Refresh",
						"type" => "popup",
						"icon" => "refresh_n.gif",
						"notNewRecords" => 1,
						"script" => t3lib_extMgm::extRelPath("li_gest_membre_labo")."wizard/reload.php",
						"JSopenParams" => "height=1,width=1,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"Ordre" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication_Auteur.ordre",		
			"config" => Array (
				"type" => "input",
				"size" => "10",
				"max" => "8",
				"eval" => "trim, int",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "hidden;;1;;1-1-1, idPublication, idAuteur, Ordre")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);



$TCA["tx_ligestpublications_Auteur"] = array (
	"ctrl" => $TCA["tx_ligestpublications_Auteur"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden, Nom, Prenom, idMembreLabo, Afficher_Publications"
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
		"Nom" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Auteur.nom",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"Prenom" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Auteur.prenom",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"max" => "255",	
				"eval" => "trim",
			)
		),
		"idMembreLabo" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Auteur.idmembrelabo",		
			"config" => Array (
				"type" => "select",	
				"foreign_table" => "tx_ligestmembrelabo_MembreDuLabo",	
				"foreign_table_where" => "ORDER BY tx_ligestmembrelabo_MembreDuLabo.NomDUsage, tx_ligestmembrelabo_MembreDuLabo.Prenom",		
				"size" => 1,
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
		"Afficher_Publications" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:li_gest_publications/locallang_db.xml:tx_ligestpublications_Publication.Afficher_Publications",		
			"config" => Array (
				"type" => "select",
				"foreign_table" => "tx_ligestpublications_Publication_Auteur",	
				"foreign_table_where" => "AND tx_ligestpublications_Publication_Auteur.idAuteur=###THIS_UID### ORDER BY tx_ligestpublications_Publication_Auteur.Ordre",
				"size" => 6,
				"minitems" => 0,
				"maxitems" => 1,
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
							"table"			=> "tx_ligestpublications_Publication_Auteur",
							"champ"			=> "idAuteur",
							"lien"			=> Array('tx_ligestpublications_Auteur')
						),
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"notNewRecords" => 1,
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
							'table'=>'tx_ligestpublications_Publication_Auteur'
						),
						"script" => t3lib_extMgm::extRelPath("li_gest_membre_labo")."wizard/delete.php",
						"JSopenParams" => "height=1,width=1,status=0,menubar=0,scrollbars=1",
					),
					"reload" => Array(
						"title" => "Refresh",
						"type" => "popup",
						"icon" => "refresh_n.gif",
						"notNewRecords" => 1,
						"script" => t3lib_extMgm::extRelPath("li_gest_membre_labo")."wizard/reload.php",
						"JSopenParams" => "height=1,width=1,status=0,menubar=0,scrollbars=1",
					),
					
				),
			),
		),
	),
	"types" => array (
		"0" => array("showitem" => "hidden;;1;;1-1-1, Nom, Prenom, idMembreLabo, Afficher_Publications")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);
?>