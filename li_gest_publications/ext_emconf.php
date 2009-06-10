<?php

########################################################################
# Extension Manager/Repository config file for ext: "li_gest_publications"
#
# Auto generated 03-06-2009 14:35
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Managing Publications',
	'description' => 'Insert a list of publications',
	'category' => 'plugin',
	'author' => 'Bruno Gallet',
	'author_email' => 'gallet.bruno@gmail.com',
	'shy' => '',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => 'tx_ligestmembrelabo_MembreDuLabo',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '1.0.3',
	'constraints' => array(
		'depends' => array(
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:81:{s:9:"ChangeLog";s:4:"3699";s:10:"README.txt";s:4:"ee2d";s:37:"class.tx_ligestpublications_annee.php";s:4:"0764";s:12:"ext_icon.gif";s:4:"52a7";s:17:"ext_localconf.php";s:4:"b38f";s:14:"ext_tables.php";s:4:"8166";s:14:"ext_tables.sql";s:4:"4657";s:19:"flexform_ds_pi1.xml";s:4:"a239";s:41:"icon_tx_ligestpublications_Appartenir.gif";s:4:"52a7";s:37:"icon_tx_ligestpublications_Auteur.gif";s:4:"52a7";s:38:"icon_tx_ligestpublications_Fichier.gif";s:4:"52a7";s:42:"icon_tx_ligestpublications_Publication.gif";s:4:"52a7";s:49:"icon_tx_ligestpublications_Publication_Auteur.gif";s:4:"52a7";s:36:"icon_tx_ligestpublications_Theme.gif";s:4:"52a7";s:48:"icon_tx_ligestpublications_Theme_Publication.gif";s:4:"52a7";s:46:"icon_tx_ligestpublications_TypePublication.gif";s:4:"52a7";s:13:"locallang.xml";s:4:"801e";s:16:"locallang_db.xml";s:4:"5375";s:7:"tca.php";s:4:"4de5";s:52:"pi1/Copie de li_gest_publications_template_test.html";s:4:"31cf";s:14:"pi1/ce_wiz.gif";s:4:"f2ae";s:39:"pi1/class.tx_ligestpublications_pi1.php";s:4:"ecb7";s:47:"pi1/class.tx_ligestpublications_pi1_wizicon.php";s:4:"f24f";s:13:"pi1/clear.gif";s:4:"cc11";s:38:"pi1/li_gest_publications_template.html";s:4:"95e0";s:39:"pi1/li_gest_publications_template2.html";s:4:"dbc1";s:43:"pi1/li_gest_publications_template_test.html";s:4:"b528";s:17:"pi1/locallang.xml";s:4:"e1e4";s:24:"pi1/static/editorcfg.txt";s:4:"702b";s:73:"csh/ligestpublications_locallang_csh_tx_ligestmembrelabo_MembreDuLabo.xml";s:4:"72b8";s:73:"csh/ligestpublications_locallang_csh_tx_ligestpublications_Appartenir.xml";s:4:"81e4";s:69:"csh/ligestpublications_locallang_csh_tx_ligestpublications_Auteur.xml";s:4:"09e0";s:70:"csh/ligestpublications_locallang_csh_tx_ligestpublications_Fichier.xml";s:4:"b2dd";s:74:"csh/ligestpublications_locallang_csh_tx_ligestpublications_Publication.xml";s:4:"e4bd";s:81:"csh/ligestpublications_locallang_csh_tx_ligestpublications_Publication_Auteur.xml";s:4:"abe6";s:68:"csh/ligestpublications_locallang_csh_tx_ligestpublications_Theme.xml";s:4:"7ea9";s:80:"csh/ligestpublications_locallang_csh_tx_ligestpublications_Theme_Publication.xml";s:4:"7171";s:78:"csh/ligestpublications_locallang_csh_tx_ligestpublications_TypePublication.xml";s:4:"1592";s:12:"doc/Doxyfile";s:4:"c6df";s:31:"doc/Typo3_Gallet_RapportPFE.pdf";s:4:"c864";s:38:"doc/bd_membres_theses_publications.pdf";s:4:"6110";s:25:"doc/doxygen_main_page.dox";s:4:"a2da";s:19:"doc/wizard_form.dat";s:4:"f94f";s:20:"doc/wizard_form.html";s:4:"a0a6";s:23:"doc/html/annotated.html";s:4:"d475";s:62:"doc/html/class_8tx__ligestpublications__annee_8php-source.html";s:4:"4c73";s:55:"doc/html/class_8tx__ligestpublications__annee_8php.html";s:4:"99b1";s:60:"doc/html/class_8tx__ligestpublications__pi1_8php-source.html";s:4:"81c6";s:53:"doc/html/class_8tx__ligestpublications__pi1_8php.html";s:4:"d764";s:69:"doc/html/class_8tx__ligestpublications__pi1__wizicon_8php-source.html";s:4:"d473";s:62:"doc/html/class_8tx__ligestpublications__pi1__wizicon_8php.html";s:4:"bedc";s:21:"doc/html/classes.html";s:4:"90c5";s:48:"doc/html/classtx__ligestpublications__annee.html";s:4:"48c8";s:46:"doc/html/classtx__ligestpublications__pi1.html";s:4:"7b1d";s:55:"doc/html/classtx__ligestpublications__pi1__wizicon.html";s:4:"6302";s:20:"doc/html/doxygen.css";s:4:"2468";s:20:"doc/html/doxygen.png";s:4:"33f8";s:38:"doc/html/doxygen__main__page_8dox.html";s:4:"14e0";s:37:"doc/html/ext__emconf_8php-source.html";s:4:"d3fb";s:30:"doc/html/ext__emconf_8php.html";s:4:"ae6b";s:40:"doc/html/ext__localconf_8php-source.html";s:4:"e493";s:33:"doc/html/ext__localconf_8php.html";s:4:"8f2e";s:37:"doc/html/ext__tables_8php-source.html";s:4:"530b";s:30:"doc/html/ext__tables_8php.html";s:4:"dccf";s:19:"doc/html/files.html";s:4:"2d36";s:23:"doc/html/functions.html";s:4:"2663";s:28:"doc/html/functions_func.html";s:4:"0638";s:28:"doc/html/functions_vars.html";s:4:"6177";s:21:"doc/html/globals.html";s:4:"7772";s:26:"doc/html/globals_vars.html";s:4:"0c7f";s:25:"doc/html/graph_legend.dot";s:4:"7395";s:26:"doc/html/graph_legend.html";s:4:"fe9d";s:19:"doc/html/index.html";s:4:"ff4d";s:32:"doc/html/namespace_t_y_p_o3.html";s:4:"0942";s:24:"doc/html/namespaces.html";s:4:"c8af";s:18:"doc/html/tab_b.gif";s:4:"a22e";s:18:"doc/html/tab_l.gif";s:4:"749f";s:18:"doc/html/tab_r.gif";s:4:"9802";s:17:"doc/html/tabs.css";s:4:"ceb0";s:29:"doc/html/tca_8php-source.html";s:4:"8ad5";s:22:"doc/html/tca_8php.html";s:4:"dcda";}',
	'suggests' => array(
	),
);

?>