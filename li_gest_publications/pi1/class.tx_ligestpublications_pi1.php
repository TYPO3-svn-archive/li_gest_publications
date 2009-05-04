<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Bruno Gallet <gallet.bruno@gmail.com>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Managing Publication' for the 'li_gest_publications' extension.
 *
 * @author	Bruno Gallet <gallet.bruno@gmail.com>
 * @package	TYPO3
 * @subpackage	tx_ligestpublications
 */
class tx_ligestpublications_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_ligestpublications_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_ligestpublications_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'li_gest_publications';	// The extension key.
	var $pi_checkCHash = true;

	
	/**
	 * Recherche des sous-dossiers contenant les membres du laboratoire...
	 * @param $pid_parent identifiant du dossier à explorer
	 * @return Un tableau contenant tous les sous-dossiers trouvés...
	 */
	private function rechercheFils($pid_parent)
	{
		$tableau = array(); //tableau contenant tous les sous-dossiers trouvés...
		
		$tableau_temp = array(); //tableau intermédiaire contenant les sous-dossiers à stocker
		
		//Requête pour trouver tous les sous-dossiers du dossier courant
		$select_fields_pid = 'pages.uid';
		$from_table_pid = 'pages';
		$where_clause_pid = 'pages.pid='.$pid_parent;
		$groupBy_pid = '';
		$orderBy_pid = '';
		$limit_pid = '';

		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select_fields_pid, $from_table_pid, $where_clause_pid, $groupBy_pid, $orderBy_pid, $limit_pid);

		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
		{
			$pid_courant = $row['uid'];


			//On stocke l'uid courant dans le tableau
			$taille_tableau = count($tableau);
						
			$tableau[$taille_tableau] = $pid_courant;

			$tableau_temp = $this->rechercheFils($pid_courant);

			foreach ($tableau_temp as $value) {
				$taille_tableau = count($tableau);
					
				$tableau[$taille_tableau] = $value;
			}
		}
		return $tableau;
	}
	
	/**
	 * Gestion du multilangue
	 * Cette fonction recherche le texte le plus approprié par rapport à la page chargée
	 * Cette fonction est utilisée à la suite d'une requête permettant de connaître les paramètres $uid, $sys_language_uid, $uid_parent et $texte_champ.
	 * @param $uid L'identifiant de l'enregistrement pour lequel on recherche la meilleur traduction.
	 * @param $sys_language_uid L'identifiant de la langue de l'enregistrement pour lequel on recherche la meilleur traduction.
	 * @param $uid_parent L'identifiant du parent  de l'enregistrement pour lequel on recherche la meilleur traduction.
	 * @param $texte_champ La traduction de l'enregistrement pour lequel on recherche la meilleur traduction.
	 * @param $table Le nom de la table dans laquel se trouve le champ à traduire
	 * @param $nom_champ Le nom du champ à traduire
	 * @return Une chaîne de caratères contenant la traduction a afficher
	 */
	private function rechercherUidLangue($uid,$sys_language_uid,$uid_parent,$texte_champ,$table,$nom_champ)
	{
		$texte=$texte_champ;
		//On teste si le libellé est déjà dans la bonne langue...
		if ($sys_language_uid<>$GLOBALS['TSFE']->sys_language_content)
		{
			$uid_recherche=$uid;
			$trouve=false;
			// Si on a l'id du parent
			if($uid_parent<>'0')
			{

				//Requête pour trouver les infos du parent
				$select_fields_uid = $table.'.uid, '.$table.'.sys_language_uid, '.$table.'.'.$nom_champ;
				$from_table_uid = $table;
				$where_clause_uid = $table.'.uid='.$uid_parent.' AND '.$table.'.deleted<>1';
				$groupBy_uid = '';
				$orderBy_uid = '';
				$limit_uid = '';

				$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select_fields_uid, $from_table_uid, $where_clause_uid, $groupBy_uid, $orderBy_uid, $limit_uid);

				while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
				{
					if($row['sys_language_uid']==$GLOBALS['TSFE']->sys_language_content)
					{
						$texte=$row[$nom_champ];
						$trouve=true;
					}
					else
					{
						$uid_recherche=$row['uid'];
					}
				}
			}
			
			if($trouve==false)
			{
				//Requête pour trouver les infos du parent
				$select_fields_uid = $table.'.uid, '.$table.'.sys_language_uid, '.$table.'.'.$nom_champ;
				$from_table_uid = $table;
				$where_clause_uid = $table.'.l18n_parent='.$uid_recherche.' AND '.$table.'.deleted<>1';
				$groupBy_uid = '';
				$orderBy_uid = '';
				$limit_uid = '';

				$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select_fields_uid, $from_table_uid, $where_clause_uid, $groupBy_uid, $orderBy_uid, $limit_uid);

				while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
				{
					if($row['sys_language_uid']==$GLOBALS['TSFE']->sys_language_content)
					{
						$texte=$row[$nom_champ];
					}
				}
			}
		}

		return $texte;
	}
	

	
	/**
	 * Choix de l'équipe
	 * Cette fonction permet de créer une contrainte concernant les équipes
	 * @param $equipe Chaîne de caractères contenant les identifiants des équipes(uid) séparés par des virgules
	 * @return Une chaîne de caratères contenant une contrainte à rajouter à une requête
	 */
	private function equipe($uid_equipes)
	{
			//Création de la contrainte permettant l'affichage que de certains types de postes...
			$equipes='';
	

			if($uid_equipes<>'')
			{
				$equipes=' AND ( ';
				$premier=true;

				$tableau_equipes = Explode(",",$uid_equipes);

				foreach ($tableau_equipes as $equipe_courante) {
					if ($premier <> true)
					{
						$equipes = $equipes.' OR ';
					}
					else
					{
						$premier=false;
					}
					$equipes=$equipes.'tx_ligestmembrelabo_Equipe.uid='.$equipe_courante;
				}

				$equipes = $equipes.' )';

			}


			return $equipes;
	}

	/**
	 * Choix des membres
	 * Cette fonction permet de créer une contrainte concernant les membres
	 * @param $equipe Chaîne de caractères contenant les identifiants des membres(uid) séparés par des virgules
	 * @return Une chaîne de caratères contenant une contrainte à rajouter à une requête
	 */
	private function membre($uid_membres)
	{
			//Création de la contrainte permettant l'affichage que de certains types de postes...
			$membres='';
	

			if($uid_membres<>'')
			{
				$membres=' AND ( ';
				$premier=true;

				$tableau_membres = Explode(",",$uid_membres);

				foreach ($tableau_membres as $membre_courant) {
					if ($premier <> true)
					{
						$membres = $membres.' OR ';
					}
					else
					{
						$premier=false;
					}
					$membres=$membres.'tx_ligestmembrelabo_MembreDuLabo.uid='.$membre_courant;
				}

				$membres = $membres.' )';

			}


			return $membres;
	}
	
	
	/**
	 * Choix des auteurs
	 * Cette fonction permet de créer une contrainte concernant les auteurs
	 * @param $equipe Chaîne de caractères contenant les identifiants des auteurs(uid) séparés par des virgules
	 * @return Une chaîne de caratères contenant une contrainte à rajouter à une requête
	 */
	private function auteur($uid_auteurs)
	{
			//Création de la contrainte permettant l'affichage que de certains types de postes...
			$auteurs='';
	

			if($uid_auteurs<>'')
			{
				$auteurs=' AND ( ';
				$premier=true;

				$tableau_auteurs = Explode(",",$uid_auteurs);

				foreach ($tableau_auteurs as $auteur_courant) {
					if ($premier <> true)
					{
						$auteurs = $auteurs.' OR ';
					}
					else
					{
						$premier=false;
					}
					$auteurs=$auteurs.'tx_ligestpublications_Auteur.uid='.$auteur_courant;
				}

				$auteurs = $auteurs.' )';

			}


			return $auteurs;
	}
	
	
	/**
	 * Choix des themes
	 * Cette fonction permet de créer une contrainte concernant les themes
	 * @param $equipe Chaîne de caractères contenant les identifiants des themes(uid) séparés par des virgules
	 * @return Une chaîne de caratères contenant une contrainte à rajouter à une requête
	 */
	private function theme($uid_themes)
	{
			//Création de la contrainte permettant l'affichage que de certains types de postes...
			$themes='';
	

			if($uid_themes<>'')
			{
				$themes=' AND ( ';
				$premier=true;

				$tableau_themes = Explode(",",$uid_themes);

				foreach ($tableau_themes as $theme_courant) {
					if ($premier <> true)
					{
						$themes = $themes.' OR ';
					}
					else
					{
						$premier=false;
					}
					$themes=$themes.'tx_ligestpublications_Theme.uid='.$theme_courant;
				}

				$themes = $themes.' )';

			}


			return $themes;
	}
	
	/**
	 * Choix des types de publications
	 * Cette fonction permet de créer une contrainte concernant les types de publications
	 * @param $equipe Chaîne de caractères contenant les identifiants des types de publications(uid) séparés par des virgules
	 * @return Une chaîne de caratères contenant une contrainte à rajouter à une requête
	 */
	private function type($uid_types)
	{
			//Création de la contrainte permettant l'affichage que de certains types de postes...
			$types='';
	

			if($uid_types<>'')
			{
				$types=' AND ( ';
				$premier=true;

				$tableau_types = Explode(",",$uid_types);

				foreach ($tableau_types as $type_courant) {
					if ($premier <> true)
					{
						$types = $types.' OR ';
					}
					else
					{
						$premier=false;
					}
					$types=$types.'tx_ligestpublications_TypePublication.uid='.$type_courant;
				}

				$types = $types.' )';

			}


			return $types;
	}
	
	
	
	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content,$conf)	{
		//Initialisation
		$this->conf=$conf;
		$this->pi_initPIflexForm(); // Init and get the flexform data of the plugin
		
		$this->lConf = array(); // Setup our storage array...
		// Il est possible de récupérer les informations des options du plugin à partir de $this->lConf['nom_de_l_option'];
		
		
		// Assign the flexform data to a local variable for easier access
		$this->pi_setPiVarDefaults();
		
		$piFlexForm = $this->cObj->data['pi_flexform'];
		 // Traverse the entire array based on the language...
		 // and assign each configuration option to $this->lConf array...
		
		foreach ( $piFlexForm['data'] as $sheet => $data )
		{
			foreach ( $data as $lang => $value )
			{
				foreach ( $value as $key => $val )
				{
					$this->lConf[$key] = $this->pi_getFFvalue($piFlexForm, $key, $sheet);			


					if(ereg('groupe',$key)){
						$temp = $key;
						foreach ($val as $key2 => $val2 )
						{
							$temp = $temp.'/'.$key2;
							foreach ($val2 as $key3 => $val3 )
							{
								$this->lConf[$key3] = $this->pi_getFFvalue($piFlexForm, $key.'/'.$key2.'/'.$key3, $sheet);
							}
						}
		
					
					}
				}

			}

		}
		
		$this->pi_loadLL();
		
		//Gestion de gabarits (Template)
		$this->templateCode = $this->cObj->fileResource($this->lConf["template_file"]);

		$template = array();

		$template['total'] = $this->cObj->getSubpart($this->templateCode, '###TEMPLATE###');
		
		$template['item'] = $this->cObj->getSubpart($template['total'], '###ITEM###');
		

		$template['publications_par_titres'] = $this->cObj->getSubpart($template['item'], '###PUBLICATIONS_PAR_TITRES###');
		
		$template['publications_par_titres_publications'] = $this->cObj->getSubpart($template['publications_par_titres'], '###PUBLICATIONS###');

		$template['publications_par_titres_auteurs'] = $this->cObj->getSubpart($template['publications_par_titres_publications'], '###AUTEURS###');
		$template['publications_par_titres_equipes'] = $this->cObj->getSubpart($template['publications_par_titres_publications'], '###EQUIPES###');
		$template['publications_par_titres_themes'] = $this->cObj->getSubpart($template['publications_par_titres_publications'], '###THEMES###');
		$template['publications_par_titres_fichiers'] = $this->cObj->getSubpart($template['publications_par_titres_publications'], '###FICHIERS###');

		$template['publications_par_annees'] = $this->cObj->getSubpart($template['item'], '###PUBLICATIONS_PAR_ANNEES###');
				
		$template['publications_par_annees_publications'] = $this->cObj->getSubpart($template['publications_par_annees'], '###PUBLICATIONS###');
		
		$template['publications_par_annees_auteurs'] = $this->cObj->getSubpart($template['publications_par_annees_publications'], '###AUTEURS###');
		$template['publications_par_annees_equipes'] = $this->cObj->getSubpart($template['publications_par_annees_publications'], '###EQUIPES###');
		$template['publications_par_annees_themes'] = $this->cObj->getSubpart($template['publications_par_annees_publications'], '###THEMES###');
		$template['publications_par_annees_fichiers'] = $this->cObj->getSubpart($template['publications_par_annees_publications'], '###FICHIERS###');
		
		
		//Exemple de création de requêtes
		/*----------------------------------------------------------------------------------------
		//Création de requête
		$select_fields = '*';
		$from_table = 'test';
		$where_clause = '';
		$groupBy = '';
		$orderBy = 'champ1';
		$limit = '';

		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select_fields, $from_table, $where_clause, $groupBy, $orderBy, $limit);

		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
		{
			$test = $test.$row['champ1'].' ';
		}
		----------------------------------------------------------------------------------------*/
		
		//On initialise la requête avec rien...
		$select_fields = '';
		$from_table = '';
		$where_clause = '';
		$groupBy = '';
		$orderBy = '';
		$limit = '';
		$tryMemcached = '';

		if(($this->lConf['requete'])<>true){

			// Récupération de toutes les publications à afficher

			// Construction de la requête
			$select = 'DISTINCT tx_ligestpublications_Publication.uid AS uidpublication, tx_ligestpublications_Publication.*';
			$table = 'tx_ligestpublications_Publication';
			$where = 'tx_ligestpublications_Publication.deleted<>1';


			// Gestion du nom de l'Equipe
			$equipes = $this->equipe($this->lConf['equipe']);
			if($equipes<>""){
				$table = $table.', tx_ligestpublications_Appartenir, tx_ligestmembrelabo_Equipe';
				$where = $where.' AND tx_ligestpublications_Appartenir.deleted<>1 AND tx_ligestmembrelabo_Equipe.deleted<>1 AND tx_ligestpublications_Appartenir.idPublication = tx_ligestpublications_Publication.uid AND tx_ligestpublications_Appartenir.idEquipe = tx_ligestmembrelabo_Equipe.uid';
				$where = $where.$equipes;
			}

			
			// Gestion du nom des membres
			$membres = $this->membre($this->lConf['membres']);
			if($membres<>""){
				$where = $where.' AND EXISTS (SELECT * FROM tx_ligestmembrelabo_MembreDuLabo, tx_ligestpublications_Auteur, tx_ligestpublications_Publication_Auteur WHERE tx_ligestmembrelabo_MembreDuLabo.deleted<>1 AND tx_ligestmembrelabo_MembreDuLabo.uid = tx_ligestpublications_Auteur.idMembreLabo AND tx_ligestpublications_Auteur.deleted<>1 AND tx_ligestpublications_Auteur.uid = tx_ligestpublications_Publication_Auteur.idAuteur AND tx_ligestpublications_Publication_Auteur.deleted<>1 AND tx_ligestpublications_Publication_Auteur.idPublication = tx_ligestpublications_Publication.uid'.$membres.')';
			}
			
			// Gestion des auteurs
			$auteurs = $this->auteur($this->lConf['auteurs']);
			if($auteurs<>""){
				$where = $where.' AND EXISTS (SELECT * FROM tx_ligestpublications_Auteur, tx_ligestpublications_Publication_Auteur WHERE tx_ligestpublications_Auteur.deleted<>1 AND tx_ligestpublications_Auteur.uid = tx_ligestpublications_Publication_Auteur.idAuteur AND tx_ligestpublications_Publication_Auteur.deleted<>1 AND tx_ligestpublications_Publication_Auteur.idPublication = tx_ligestpublications_Publication.uid'.$auteurs.')';
			}
			
			// Gestion des thèmes
			$themes = $this->theme($this->lConf['themes']);
			if($themes<>""){
				$where = $where.' AND EXISTS (SELECT * FROM tx_ligestpublications_Theme, tx_ligestpublications_Theme_Publication WHERE tx_ligestpublications_Theme.deleted<>1 AND tx_ligestpublications_Theme.uid = tx_ligestpublications_Theme_Publication.idTheme AND tx_ligestpublications_Theme_Publication.deleted<>1 AND tx_ligestpublications_Theme_Publication.idPublication = tx_ligestpublications_Publication.uid'.$themes.')';
			}

			// Gestion des types de publication
			$types = $this->type($this->lConf['typePublication']);
			if($types<>""){
				$where = $where.' AND EXISTS (SELECT * FROM tx_ligestpublications_TypePublication WHERE tx_ligestpublications_TypePublication.deleted<>1 AND tx_ligestpublications_TypePublication.uid = tx_ligestpublications_Publication.TypePublication'.$types.')';
			}
			

			//Gestion de la date de publication
			$datepublication = $this->lConf['datepublication'];

			if($datepublication=='En Cours')
			{
				$where = $where.' AND ((tx_ligestpublications_Publication.DateDebut<="'.date('Y-m-d').'" AND (tx_ligestpublications_Publication.DateFin>="'.date('Y-m-d').'" OR (tx_ligestpublications_Publication.DateFin="0000-00-00" AND tx_ligestpublications_Publication.DateDebut<>"0000-00-00"))) OR tx_ligestpublications_Publication.Annee='.date('Y').')';
			}
			else if($datepublication=='Terminées')
			{
				$where = $where.' AND ((tx_ligestpublications_Publication.DateFin<"'.date('Y-m-d').'" AND tx_ligestpublications_Publication.DateFin<>"0000-00-00") OR (tx_ligestpublications_Publication.Annee<'.date('Y').'))';
			}

			
			// Afficher les publications à partir d'une date
			
			$publicationdepuis= $this->lConf['limitationdate'];
			
			if($publicationdepuis<>false)
			{
				$where = $where.' AND ((year(tx_ligestpublications_Publication.DateFin)>="'.$publicationdepuis.'" AND tx_ligestpublications_Publication.DateFin<>"0000-00-00") OR (tx_ligestpublications_Publication.Annee>='.$publicationdepuis.'))';
			}
			
			
			// Publication internationale?
			$internationale = $this->lConf['internationale'];

			if($internationale=="Est internationale")
			{
				$where = $where.' AND tx_ligestpublications_Publication.EstInternationale="I"';
			}
			else if($internationale=="N'est pas internationale")
			{
				$where = $where.' AND tx_ligestpublications_Publication.EstInternationale="N"';
			}
			
			
			// Type de conférence
			$typeconference = $this->lConf['typeconference'];

			if($typeconference=="Conference normale")
			{
				$where = $where.' AND tx_ligestpublications_Publication.EstInvite="F"';
			}
			else if($typeconference=="Invite")
			{
				$where = $where.' AND tx_ligestpublications_Publication.EstInvite="V"';
			}
			
			
			
			// Est un chapitre?
			$chapitre = $this->lConf['chapitre'];

			if($chapitre=="Pas un ouvrage")
			{
				$where = $where.' AND tx_ligestpublications_Publication.EstUnChapitre="R"';
			}
			else if($chapitre=="Est un chapitre")
			{
				$where = $where.' AND tx_ligestpublications_Publication.EstUnChapitre="V"';
			}
			else if($chapitre=="Est un livre")
			{
				$where = $where.' AND tx_ligestpublications_Publication.EstUnChapitre="F"';
			}

			// Est de la vulgarisation?
			$vulgarisation = $this->lConf['vulgarisation'];

			if($vulgarisation=="Oui")
			{
				$where = $where.' AND tx_ligestpublications_Publication.EstDeLaVulgarisation="V"';
			}
			else if($vulgarisation=="Non")
			{
				$where = $where.' AND tx_ligestpublications_Publication.EstDeLaVulgarisation="F"';
			}

			// Est paru?
			$parution = $this->lConf['parution'];

			if($parution=="Oui")
			{
				$where = $where.' AND tx_ligestpublications_Publication.EstParu="V"';
			}
			else if($parution=="En Cours")
			{
				$where = $where.' AND tx_ligestpublications_Publication.EstParu="E"';
			}
			else if($parution=="Non")
			{
				$where = $where.' AND tx_ligestpublications_Publication.EstParu="F"';
			}
			else if($parution=="Parue ou en cours de parution")
			{
				$where = $where.' AND tx_ligestpublications_Publication.EstParu<>"F"';
			}
			
			// Date de parution?
			$anneeparution = $this->lConf['anneeparution'];

			if($anneeparution<>false)
			{
				$where = $where.' AND tx_ligestpublications_Publication.Annee='.$anneeparution;
			}








			// Création de la clause permettant de ne choisir que certains membres selon les dossiers sélectionnés
			// On récupère tous les sous-dossiers...
			$dossiers = '';	
			
			$pid = array(); //dossiers sélectionnés
			$pages = array(); //dossiers et sous dossiers...
			
			$chaine = $this->lConf['pid'];
			
			if ($chaine!=''){
				$dossiers = $dossiers.' AND (';
				$pid = explode(",",$chaine);
				
				$premier = true;
				
				foreach ($pid as $pid_courant) {
					$pages = array_merge($pages,$this->rechercheFils($pid_courant));
				}
				
				foreach ($pid as $value) {
					$taille_tableau = count($pages);

					$pages[$taille_tableau] = $value;
				}
				
				
				foreach ($pages as $value) {
					if ($premier == true){
						$dossiers = $dossiers.'tx_ligestpublications_Publication.pid='.$value;
						$premier = false;
					}
					else{
						$dossiers = $dossiers.' OR tx_ligestpublications_Publication.pid='.$value;
					}
				}

				$dossiers = $dossiers.')';
			}

			$where = $where.$dossiers;


			// On écrit la requête
			$select_fields = $select;
			$from_table = $table;
			$where_clause = $where;
			$groupBy = '';
			$orderBy = 'tx_ligestpublications_Publication.Titre '.$this->lConf['ordretitre'];
			$limit = '';
		}
		else
		{
			// Cas où l'on utilise une requête personnelle
			$select_fields = $this->lConf['select'];
			$from_table = $this->lConf['from_table'];
			$where_clause = $this->lConf['where_clause'];
			$groupBy = $this->lConf['groupBy'];
			$orderBy = $this->lConf['orderBy'];
			$limit = $this->lConf['limit'];
		}
		
		// Initialisation des tableaux contenant les marqeurs
		$markerArray = array();
		$markerArray_publications_par_titres = array();
		$markerArray_publications_par_titres_publications = array();
		$markerArray_publications_par_titres_auteurs = array();
		$markerArray_publications_par_titres_equipes = array();
		$markerArray_publications_par_titres_themes = array();
		$markerArray_publications_par_titres_fichiers = array();


		$contentItem='';

		$contentItem_publications_par_titres_publications='';
		$content_publications_par_titres='';
		// Requête permettant de récupérer les informations des publications sélectionnés 
		

		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select_fields, $from_table, $where_clause, $groupBy, $orderBy, $limit);
		
		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)){
		
			//**************************************
			// Table Publication
			//**************************************
		
			$uid=$row['uidpublication'];
			//$markerArray_publications_par_titres_publications['###uid###'] = $row['uidpublication'];

			
			$markerArray_publications_par_titres_publications['###Annee###'] = $row['Annee'];
			if($row['Annee']<>''){
				$markerArray_publications_par_titres_publications['###Annee_Separateur###'] = $this->lConf['Annee_Separateur'];
			}
			else{
				$markerArray_publications_par_titres_publications['###Annee_Separateur###'] = '';
			}
			
			if($row['DateDebut']=='0000-00-00'){
				$markerArray_publications_par_titres_publications['###DateDebut###'] = $this->lConf['DateDebut'];
				if($this->lConf['DateDebut']<>''){
					$markerArray_publications_par_titres_publications['###DateDebut_Separateur###'] = $this->lConf['DateDebut_Separateur'];
				}
				else{
					$markerArray_publications_par_titres_publications['###DateDebut_Separateur###'] = '';
				}
			}
			else{
				$date_explosee = explode("-", $row['DateDebut']);

				$annee = (int)$date_explosee[0];
				$mois = (int)$date_explosee[1];
				$jour = (int)$date_explosee[2];

				// la fonction date permet de reformater une date au format souhaité
				$markerArray_publications_par_titres_publications['###DateDebut###'] = date($this->lConf['formatdate'],mktime(0, 0, 0, $mois, $jour, $annee));

				if($row['DateDebut']<>''){
					$markerArray_publications_par_titres_publications['###DateDebut_Separateur###'] = $this->lConf['DateDebut_Separateur'];
				}
				else{
					$markerArray_publications_par_titres_publications['###DateDebut_Separateur###'] = '';
				}
			}

			if($row['DateFin']=='0000-00-00'){
				$markerArray_publications_par_titres_publications['###DateFin###'] = $this->lConf['DateFin'];
				if($this->lConf['DateFin']<>''){
					$markerArray_publications_par_titres_publications['###DateFin_Separateur###'] = $this->lConf['DateFin_Separateur'];
				}
				else{
					$markerArray_publications_par_titres_publications['###DateFin_Separateur###'] = '';
				}
			}
			else{
				$date_explosee = explode("-", $row['DateFin']);

				$annee = (int)$date_explosee[0];
				$mois = (int)$date_explosee[1];
				$jour = (int)$date_explosee[2];

				// la fonction date permet de reformater une date au format souhaité
				$markerArray_publications_par_titres_publications['###DateFin###'] = date($this->lConf['formatdate'],mktime(0, 0, 0, $mois, $jour, $annee));

				if($row['DateFin']<>''){
					$markerArray_publications_par_titres_publications['###DateFin_Separateur###'] = $this->lConf['DateFin_Separateur'];
				}
				else{
					$markerArray_publications_par_titres_publications['###DateFin_Separateur###'] = '';
				}
			}
			
			$markerArray_publications_par_titres_publications['###Edition###'] = $row['Edition'];
			if($row['Edition']<>''){
				$markerArray_publications_par_titres_publications['###Edition_Separateur###'] = $this->lConf['Edition_Separateur'];
			}
			else{
				$markerArray_publications_par_titres_publications['###Edition_Separateur###'] = '';
			}

			
			
			if($row['EstEditeur']=='F'){
				$markerArray_publications_par_titres_publications['###EstEditeur###'] = $this->lConf['NEstPasEditeur'];
				
				if($this->lConf['NEstPasEditeur']<>''){
					$markerArray_publications_par_titres_publications['###EstEditeur_Separateur###'] = $this->lConf['EstEditeur_Separateur'];
				}
				else{
					$markerArray_publications_par_titres_publications['###EstEditeur_Separateur###'] = '';
				}
			}
			else{
				$markerArray_publications_par_titres_publications['###EstEditeur###'] = $this->lConf['EstEditeur'];
				
				if($this->lConf['EstEditeur']<>''){
					$markerArray_publications_par_titres_publications['###EstEditeur_Separateur###'] = $this->lConf['EstEditeur_Separateur'];
				}
				else{
					$markerArray_publications_par_titres_publications['###EstEditeur_Separateur###'] = '';
				}
			}
			
			if($row['EstDeLaVulgarisation']=='F'){
				$markerArray_publications_par_titres_publications['###EstDeLaVulgarisation###'] = $this->lConf['NEstPasDeLaVulgarisation'];
				
				if($this->lConf['NEstPasDeLaVulgarisation']<>''){
					$markerArray_publications_par_titres_publications['###EstDeLaVulgarisation_Separateur###'] = $this->lConf['EstDeLaVulgarisation_Separateur'];
				}
				else{
					$markerArray_publications_par_titres_publications['###EstDeLaVulgarisation_Separateur###'] = '';
				}
			}
			else{
				$markerArray_publications_par_titres_publications['###EstDeLaVulgarisation###'] = $this->lConf['EstDeLaVulgarisation'];
				
				if($this->lConf['EstDeLaVulgarisation']<>''){
					$markerArray_publications_par_titres_publications['###EstDeLaVulgarisation_Separateur###'] = $this->lConf['EstDeLaVulgarisation_Separateur'];
				}
				else{
					$markerArray_publications_par_titres_publications['###EstDeLaVulgarisation_Separateur###'] = '';
				}
			}
			
			if($row['EstInternationale']=='N'){
				$markerArray_publications_par_titres_publications['###EstInternationale###'] = $this->lConf['NEstPasInternationale'];
				
				if($this->lConf['NEstPasInternationale']<>''){
					$markerArray_publications_par_titres_publications['###EstInternationale_Separateur###'] = $this->lConf['EstInternationale_Separateur'];
				}
				else{
					$markerArray_publications_par_titres_publications['###EstInternationale_Separateur###'] = '';
				}
			}
			else{
				$markerArray_publications_par_titres_publications['###EstInternationale###'] = $this->lConf['EstInternationale'];
				
				if($this->lConf['EstInternationale']<>''){
					$markerArray_publications_par_titres_publications['###EstInternationale_Separateur###'] = $this->lConf['EstInternationale_Separateur'];
				}
				else{
					$markerArray_publications_par_titres_publications['###EstInternationale_Separateur###'] = '';
				}
			}
			
			if($row['EstInvite']=='F'){
				$markerArray_publications_par_titres_publications['###EstInvite###'] = $this->lConf['NEstPasInvite'];
				
				if($this->lConf['NEstPasInvite']<>''){
					$markerArray_publications_par_titres_publications['###EstInvite_Separateur###'] = $this->lConf['EstInvite_Separateur'];
				}
				else{
					$markerArray_publications_par_titres_publications['###EstInvite_Separateur###'] = '';
				}
			}
			else{
				$markerArray_publications_par_titres_publications['###EstInvite###'] = $this->lConf['EstInvite'];
				
				if($this->lConf['EstInvite']<>''){
					$markerArray_publications_par_titres_publications['###EstInvite_Separateur###'] = $this->lConf['EstInvite_Separateur'];
				}
				else{
					$markerArray_publications_par_titres_publications['###EstInvite_Separateur###'] = '';
				}
			}

			if($row['EstParu']=='F'){
				$markerArray_publications_par_titres_publications['###EstParu###'] = $this->lConf['NEstPasParu'];
				
				if($this->lConf['NEstPasParu']<>''){
					$markerArray_publications_par_titres_publications['###EstParu_Separateur###'] = $this->lConf['EstParu_Separateur'];
				}
				else{
					$markerArray_publications_par_titres_publications['###EstParu_Separateur###'] = '';
				}
			}
			else if($row['EstParu']=='E'){
				$markerArray_publications_par_titres_publications['###EstParu###'] = $this->lConf['EnCoursDeParution'];
				
				if($this->lConf['EnCoursDeParution']<>''){
					$markerArray_publications_par_titres_publications['###EstParu_Separateur###'] = $this->lConf['EstParu_Separateur'];
				}
				else{
					$markerArray_publications_par_titres_publications['###EstParu_Separateur###'] = '';
				}
			}
			else{
				$markerArray_publications_par_titres_publications['###EstParu###'] = $this->lConf['EstParu'];
				
				if($this->lConf['EstParu']<>''){
					$markerArray_publications_par_titres_publications['###EstParu_Separateur###'] = $this->lConf['EstInvite_Separateur'];
				}
				else{
					$markerArray_publications_par_titres_publications['###EstParu_Separateur###'] = '';
				}
			}
			
			if($row['EstUnChapitre']=='R'){
				$markerArray_publications_par_titres_publications['###EstUnChapitre###'] = $this->lConf['EstUnChapitreR'];
				
				if($this->lConf['EstUnChapitreR']<>''){
					$markerArray_publications_par_titres_publications['###EstUnChapitre_Separateur###'] = $this->lConf['EstUnChapitre_Separateur'];
				}
				else{
					$markerArray_publications_par_titres_publications['###EstUnChapitre_Separateur###'] = '';
				}
			}
			else if($row['EstUnChapitre']=='V'){
				$markerArray_publications_par_titres_publications['###EstUnChapitre###'] = $this->lConf['EstUnChapitreV'];
				
				if($this->lConf['EstUnChapitreV']<>''){
					$markerArray_publications_par_titres_publications['###EstUnChapitre_Separateur###'] = $this->lConf['EstUnChapitre_Separateur'];
				}
				else{
					$markerArray_publications_par_titres_publications['###EstUnChapitre_Separateur###'] = '';
				}
			}
			else{
				$markerArray_publications_par_titres_publications['###EstUnChapitre###'] = $this->lConf['EstUnChapitreF'];
				
				if($this->lConf['EstUnChapitreF']<>''){
					$markerArray_publications_par_titres_publications['###EstUnChapitre_Separateur###'] = $this->lConf['EstUnChapitre_Separateur'];
				}
				else{
					$markerArray_publications_par_titres_publications['###EstUnChapitre_Separateur###'] = '';
				}
			}
			
			
			$markerArray_publications_par_titres_publications['###ISBN###'] = $row['ISBN'];
			if($row['ISBN']<>''){
				$markerArray_publications_par_titres_publications['###ISBN_Separateur###'] = $this->lConf['ISBN_Separateur'];
			}
			else{
				$markerArray_publications_par_titres_publications['###ISBN_Separateur###'] = '';
			}
			
			
			$markerArray_publications_par_titres_publications['###MediaDePublication###'] = $row['MediaDePublication'];
			if($row['MediaDePublication']<>''){
				$markerArray_publications_par_titres_publications['###MediaDePublication_Separateur###'] = $this->lConf['MediaDePublication_Separateur'];
			}
			else{
				$markerArray_publications_par_titres_publications['###MediaDePublication_Separateur###'] = '';
			}
			
			$markerArray_publications_par_titres_publications['###Notes###'] = $row['Notes'];
			if($row['Notes']<>''){
				$markerArray_publications_par_titres_publications['###Notes_Separateur###'] = $this->lConf['Notes_Separateur'];
			}
			else{
				$markerArray_publications_par_titres_publications['###Notes_Separateur###'] = '';
			}
			
			$markerArray_publications_par_titres_publications['###Numero###'] = $row['Numero'];
			if($row['Numero']<>''){
				$markerArray_publications_par_titres_publications['###Numero_Separateur###'] = $this->lConf['Numero_Separateur'];
			}
			else{
				$markerArray_publications_par_titres_publications['###Numero_Separateur###'] = '';
			}
			
			
			$pages = '';
			// Affichage du nombre de page ou d'une plage de pages.
			
			if($row['Pages']<>'')
			{
				$pos_tiret = strpos($row['Pages'], '-');
				
				if ($pos_tiret === false) { // Il s'agit d'un nombre de pages
					$pages = str_replace('###Pages###', $row['Pages'], $this->lConf['nbpages']);
				}
				else // Il s'agit d'une plage de pages
				{
					$pages_explosee = explode("-", $row['Pages']);

					$page_debut = $pages_explosee[0];
					$page_fin = $pages_explosee[1];
				
					$pages = str_replace('###PageDebut###', $page_debut, $this->lConf['plagepages']);
					$pages = str_replace('###PageFin###', $page_fin, $pages);
				
				}
			}

			
			$markerArray_publications_par_titres_publications['###Pages###'] = $pages;
			if($pages<>''){
				$markerArray_publications_par_titres_publications['###Pages_Separateur###'] = $this->lConf['Pages_Separateur'];
			}
			else{
				$markerArray_publications_par_titres_publications['###Pages_Separateur###'] = '';
			}
			

			$markerArray_publications_par_titres_publications['###PublisherOrSchool###'] = $row['PublisherOrSchool'];
			if($row['PublisherOrSchool']<>''){
				$markerArray_publications_par_titres_publications['###PublisherOrSchool_Separateur###'] = $this->lConf['PublisherOrSchool_Separateur'];
			}
			else{
				$markerArray_publications_par_titres_publications['###PublisherOrSchool_Separateur###'] = '';
			}
			
			
			
			
			
			$markerArray_publications_par_titres_publications['###Serie###'] = $row['Serie'];
			if($row['Serie']<>''){
				$markerArray_publications_par_titres_publications['###Serie_Separateur###'] = $this->lConf['Serie_Separateur'];
			}
			else{
				$markerArray_publications_par_titres_publications['###Serie_Separateur###'] = '';
			}
			
			$markerArray_publications_par_titres_publications['###TauxSelection###'] = $row['TauxSelection'];
			if($row['TauxSelection']<>''){
				$markerArray_publications_par_titres_publications['###TauxSelection_Separateur###'] = $this->lConf['TauxSelection_Separateur'];
			}
			else{
				$markerArray_publications_par_titres_publications['###TauxSelection_Separateur###'] = '';
			}
			
			
			$markerArray_publications_par_titres_publications['###Titre###'] = $row['Titre'];
			if($row['Titre']<>''){
				$markerArray_publications_par_titres_publications['###Titre_Separateur###'] = $this->lConf['Titre_Separateur'];
			}
			else{
				$markerArray_publications_par_titres_publications['###Titre###'] = '';
			}
			
			$markerArray_publications_par_titres_publications['###VilleEtPays###'] = $row['VilleEtPays'];
			if($row['VilleEtPays']<>''){
				$markerArray_publications_par_titres_publications['###VilleEtPays_Separateur###'] = $this->lConf['VilleEtPays_Separateur'];
			}
			else{
				$markerArray_publications_par_titres_publications['###VilleEtPays_Separateur###'] = '';
			}

			$markerArray_publications_par_titres_publications['###Volume###'] = $row['Volume'];
			if($row['Volume']<>''){
				$markerArray_publications_par_titres_publications['###Volume_Separateur###'] = $this->lConf['Volume_Separateur'];
			}
			else{
				$markerArray_publications_par_titres_publications['###Volume_Separateur###'] = '';
			}
			
			

			
			//Configuration du lien vers le fichier
				// configure the typolink
				$this->local_cObj = t3lib_div::makeInstance('tslib_cObj');
				$this->local_cObj->setCurrentVal($GLOBALS['TSFE']->id);
				$this->typolink_conf = $this->conf['typolink.'];
				// configure typolink
				$temp_conf = $this->typolink_conf;
				$temp_conf['parameter'] = $row['Lien'];
				$temp_conf['extTarget'] = '';				
				$temp_conf['parameter.']['wrap'] = "|";
				// Fill wrapped subpart marker
			$wrappedSubpartContentArray_publications_par_titres_publications['###Lien###'] = $this->local_cObj->typolinkWrap($temp_conf);
			
			$markerArray_publications_par_titres_publications['###LienDur###'] = $row['Lien'];

			if($row['Lien']<>''){
				$markerArray_publications_par_titres_publications['###LienDur_Separateur###'] = $this->lConf['LienDur_Separateur'];
			}
			else{
				$markerArray_publications_par_titres_publications['###LienDur_Separateur###'] = '';
			}



			
			//**************************************
			// Table Auteur
			//**************************************
				$contentAuteurs='';

				$auteurs_select_fields = "tx_ligestpublications_Auteur.uid AS uidAuteur, tx_ligestpublications_Auteur.*, tx_ligestpublications_Publication.*, tx_ligestpublications_Publication_Auteur.*, tx_ligestmembrelabo_MembreDuLabo.PageWeb, tx_ligestmembrelabo_Equipe.uid AS uidequipe";
				$auteurs_from_table = "tx_ligestpublications_Auteur, tx_ligestpublications_Publication, tx_ligestpublications_Publication_Auteur, tx_ligestmembrelabo_MembreDuLabo, tx_ligestmembrelabo_Equipe, tx_ligestmembrelabo_EstMembreDe";
				$auteurs_where_clause = "tx_ligestpublications_Publication.uid = ".$uid." AND tx_ligestpublications_Publication.uid = tx_ligestpublications_Publication_Auteur.idPublication AND tx_ligestpublications_Publication_Auteur.deleted<>1 AND tx_ligestpublications_Publication_Auteur.idAuteur = tx_ligestpublications_Auteur.uid AND tx_ligestpublications_Auteur.deleted<>1 AND tx_ligestpublications_Auteur.idMembreLabo = tx_ligestmembrelabo_MembreDuLabo.uid AND tx_ligestmembrelabo_MembreDuLabo.deleted<>1 AND tx_ligestmembrelabo_MembreDuLabo.uid = tx_ligestmembrelabo_EstMembreDe.idMembreLabo AND tx_ligestmembrelabo_EstMembreDe.deleted<>1 AND tx_ligestmembrelabo_EstMembreDe.idEquipe = tx_ligestmembrelabo_Equipe.uid AND tx_ligestmembrelabo_Equipe.deleted<>1";
				$auteurs_groupBy = "";
				$auteurs_orderBy = "tx_ligestpublications_Publication_Auteur.Ordre, tx_ligestpublications_Auteur.Nom, tx_ligestpublications_Auteur.Prenom";
				$auteurs_limit = "";


				$auteurs_res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($auteurs_select_fields, $auteurs_from_table, $auteurs_where_clause, $auteurs_groupBy, $auteurs_orderBy, $auteurs_limit);


				while($auteurs_row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($auteurs_res)){
					$idEquipe = $auteurs_row['uidequipe'];
					
					//Nom de l'auteur
					$markerArray_publications_par_titres_auteurs['###Auteurs_Nom###'] = $auteurs_row['Nom'];
					if($auteurs_row['Nom']<>''){
						$markerArray_publications_par_titres_auteurs['###Auteurs_Nom_Separateur###'] = $this->lConf['Auteurs_Nom_Separateur'];
					}
					else{
						$markerArray_publications_par_titres_auteurs['###Auteurs_Nom_Separateur###'] = '';
					}
					
					$markerArray_publications_par_titres_auteurs['###Auteurs_NOM###'] = mb_strtoupper($auteurs_row['Nom'],"UTF-8");
					if($auteurs_row['Nom']<>''){
						$markerArray_publications_par_titres_auteurs['###Auteurs_NOM_Separateur###'] = $this->lConf['Auteurs_Nom_Separateur'];
					}
					else{
						$markerArray_publications_par_titres_auteurs['###Auteurs_NOM_Separateur###'] = '';
					}

					//Prénom de l'auteur
					$markerArray_publications_par_titres_auteurs['###Auteurs_Prenom###'] = $auteurs_row['Prenom'];
					if($auteurs_row['Prenom']<>''){
						$markerArray_publications_par_titres_auteurs['###Auteurs_Prenom_Separateur###'] = $this->lConf['PrenomAuteur_Separateur'];
					}
					else{
						$markerArray_publications_par_titres_auteurs['###Auteurs_PRENOM_Separateur###'] = '';
					}
					
					$markerArray_publications_par_titres_auteurs['###Auteurs_PRENOM###'] = mb_strtoupper($auteurs_row['Prenom'],"UTF-8");
					if($auteurs_row['Prenom']<>''){
						$markerArray_publications_par_titres_auteurs['###Auteurs_PRENOM_Separateur###'] = $this->lConf['Auteurs_Prenom_Separateur'];
					}
					else{
						$markerArray_publications_par_titres_auteurs['###Auteurs_PRENOM_Separateur###'] = '';
					}
					
					//Gestion des initiales

					$markerArray_publications_par_titres_auteurs['###Auteurs_InitialeNom###'] = substr($auteurs_row['Nom'],0,1).".";
					if($auteurs_row['Nom']<>''){
						$markerArray_publications_par_titres_auteurs['###Auteurs_InitialeNom_Separateur###'] = $this->lConf['Auteurs_InitialeNom_Separateur'];
					}
					else{
						$markerArray_publications_par_titres_auteurs['###Auteurs_InitialeNom_Separateur###'] = '';
					}
					
					// On sépare les prénoms s'ils contiennent un - (cas des prénoms composés)
					$prenoms = explode("-",$auteurs_row['Prenom']);
					$initiales_prenom = "";
					$premier_prenom = true;
					// Pour chaque prénom, on récupère l'initiale. On sépare ces initiales par des tirets
					foreach ($prenoms as $prenom_courant) {
						if($premier_prenom != true)
						{
							$initiales_prenom = $initiales_prenom."-";
						}
						$initiales_prenom = $initiales_prenom.substr($prenom_courant,0,1);
						$premier_prenom = false;
					}
					if($initiales_prenom != '')
					{
						$markerArray_publications_par_titres_auteurs['###Auteurs_InitialePrenom###'] = $initiales_prenom.".";
					}	
					
					
					
					if($auteurs_row['Prenom']<>''){
						$markerArray_publications_par_titres_auteurs['###Auteurs_InitialePrenom_Separateur###'] = $this->lConf['Auteurs_InitialePrenom_Separateur'];
					}
					else{
						$markerArray_publications_par_titres_auteurs['###Auteurs_InitialePrenom_Separateur###'] = '';
					}


					//Configuration du lien PageWeb
						// configure the typolink
						$this->local_cObj = t3lib_div::makeInstance('tslib_cObj');
						$this->local_cObj->setCurrentVal($GLOBALS['TSFE']->id);
						$this->typolink_conf = $this->conf['typolink.'];
						// configure typolink
						$temp_conf = $this->typolink_conf;
						$temp_conf['parameter'] = $auteurs_row['PageWeb'];
						$temp_conf['extTarget'] = '';				
						$temp_conf['parameter.']['wrap'] = "|";
						// Fill wrapped subpart marker
					$wrappedSubpartContentArray_publications_par_titres_auteurs['###Auteurs_PageWebLien###'] = $this->local_cObj->typolinkWrap($temp_conf);
					
					$markerArray_publications_par_titres_auteurs['###Auteurs_PageWeb###'] = $auteurs_row['PageWeb'];

					if($auteurs_row['PageWeb']<>''){
						$markerArray_publications_par_titres_auteurs['###Auteurs_PageWeb_Separateur###'] = $this->lConf['Auteurs_PageWeb_Separateur'];
					}
					else{
						$markerArray_publications_par_titres_auteurs['###Auteurs_PageWeb_Separateur###'] = '';
					}
				
					//Le contenu de cette balise est modifié, si besoin dans la partie concernant l'équipe du membre.
					$wrappedSubpartContentArray_publications_par_titres_auteurs['###Auteurs_Surlignes###'] = array('','');
					
					//On ajoute ou non les balises pour surligner le membre si sa dernière équipe a été sélectionnée

					$tableau_equipes = explode(",",$this->lConf['baliseequipe']);
					
					foreach ($tableau_equipes as $equipe_courante) {
						if($idEquipe==$equipe_courante)
						{
							$wrappedSubpartContentArray_publications_par_titres_auteurs['###Auteurs_Surlignes###'] = array($this->lConf['balisedebut'],$this->lConf['balisefin']);
						}					
					}
				
				
				
				
					$contentAuteurs .= $this->cObj->substituteMarkerArrayCached($template['publications_par_titres_auteurs'],$markerArray_publications_par_titres_auteurs,array(),$wrappedSubpartContentArray_publications_par_titres_auteurs);

				}


				$subpartArray_publications_par_titres_publications['###AUTEURS###'] = $contentAuteurs;




			//**************************************
			// Table Fichier
			//**************************************
				$contentFichiers='';

				$utilisateur_uid = $GLOBALS['TSFE']->fe_user->user['uid'];
				$utilisateur_login = $GLOBALS['TSFE']->fe_user->user['username'];
				$utilisateur_groupes = $GLOBALS['TSFE']->fe_user->user['usergroup']; // renvoie une liste d'uid des groupes séparés par des virgules
				$tableau_groupes = Explode(",",$utilisateur_groupes);
				
				
				$fichiers_select_fields = "tx_ligestpublications_Fichier.uid AS uidFichier, tx_ligestpublications_Fichier.*";
				$fichiers_from_table = "tx_ligestpublications_Fichier, tx_ligestpublications_Publication";
				$fichiers_where_clause = "tx_ligestpublications_Publication.uid = ".$uid." AND tx_ligestpublications_Publication.uid = tx_ligestpublications_Fichier.idPublication AND tx_ligestpublications_Fichier.deleted<>1";
				$fichiers_groupBy = "";
				$fichiers_orderBy = "tx_ligestpublications_Fichier.NomFichier";
				$fichiers_limit = "";

				$fichiers_res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fichiers_select_fields, $fichiers_from_table, $fichiers_where_clause, $fichiers_groupBy, $fichiers_orderBy, $fichiers_limit);


				while($fichiers_row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($fichiers_res)){

					$autorisation = false;


					if($tableau_groupes<>'')
					{
						foreach ($tableau_groupes as $groupe_courant) {
							if ($groupe_courant == $fichiers_row['fe_group'])
							{
								$autorisation = true;
							}
						}
					}
					

					if($fichiers_row['fe_group']==0 || $fichiers_row['fe_group']==-2 ||$autorisation==true){




						$markerArray_publications_par_titres_fichiers['###Fichiers_Nom###'] = $fichiers_row['NomFichier'];
						if($fichiers_row['Nom']<>''){
							$markerArray_publications_par_titres_fichiers['###Fichiers_Nom_Separateur###'] = $this->lConf['Fichiers_Nom_Separateur'];
						}
						else{
							$markerArray_publications_par_titres_fichiers['###Fichiers_Nom_Separateur###'] = '';
						}


						//Configuration du lien vers le fichier
							// configure the typolink
							$this->local_cObj = t3lib_div::makeInstance('tslib_cObj');
							$this->local_cObj->setCurrentVal($GLOBALS['TSFE']->id);
							$this->typolink_conf = $this->conf['typolink.'];
							// configure typolink
							$temp_conf = $this->typolink_conf;
							$temp_conf['parameter'] = $fichiers_row['LienFichier'];
							$temp_conf['extTarget'] = '';				
							$temp_conf['parameter.']['wrap'] = "|";
							// Fill wrapped subpart marker
						$wrappedSubpartContentArray_publications_par_titres_fichiers['###Fichiers_Lien###'] = $this->local_cObj->typolinkWrap($temp_conf);
						
						$markerArray_publications_par_titres_fichiers['###Fichiers_LienDur###'] = $fichiers_row['LienFichier'];

						if($fichiers_row['LienFichier']<>''){
							$markerArray_publications_par_titres_fichiers['###Fichiers_LienDur_Separateur###'] = $this->lConf['Fichiers_LienDur_Separateur'];
						}
						else{
							$markerArray_publications_par_titres_fichiers['###Fichiers_LienDur_Separateur###'] = '';
						}
					
					
						$contentFichiers .= $this->cObj->substituteMarkerArrayCached($template['publications_par_titres_fichiers'],$markerArray_publications_par_titres_fichiers,array(),$wrappedSubpartContentArray_publications_par_titres_fichiers);
					
					}
					
				}


				$subpartArray_publications_par_titres_publications['###FICHIERS###'] = $contentFichiers;

			//**************************************
			// Table Equipe
			//**************************************
				
				$contentEquipes='';

				$equipes_select_fields = "tx_ligestmembrelabo_Equipe.uid AS uidequipe, tx_ligestmembrelabo_Equipe.*, tx_ligestpublications_Appartenir.*";
				$equipes_from_table = "tx_ligestpublications_Publication, tx_ligestmembrelabo_Equipe, tx_ligestpublications_Appartenir";
				$equipes_where_clause = "tx_ligestpublications_Publication.uid = ".$uid." AND tx_ligestpublications_Publication.uid = tx_ligestpublications_Appartenir.idPublication AND tx_ligestpublications_Appartenir.deleted<>1 AND tx_ligestpublications_Appartenir.idEquipe = tx_ligestmembrelabo_Equipe.uid AND tx_ligestmembrelabo_Equipe.deleted<>1";
				$equipes_groupBy = "";
				$equipes_orderBy = "tx_ligestmembrelabo_Equipe.Abreviation";
				$equipes_limit = "";

				$equipes_res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($equipes_select_fields, $equipes_from_table, $equipes_where_clause, $equipes_groupBy, $equipes_orderBy, $equipes_limit);


				while($equipes_row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($equipes_res)){
					$idEquipe = $equipes_row['uidequipe'];

					//Nom de l'équipe
					//Champ Nom (multilingue)
						$champNom='';
						$champNom=$equipes_row['Nom'];
							//On recherche le libellé traduit de Libelle
						$champNom=$this->rechercherUidLangue($equipes_row['uidequipe'],$equipes_row['sys_language_uid'],$equipes_row['l18n_parent'],$equipes_row['Nom'],'tx_ligestmembrelabo_Equipe','Nom');

					
					$markerArray_publications_par_titres_equipes['###Equipes_Nom###'] = $champNom;
					if($champNom<>''){
						$markerArray_publications_par_titres_equipes['###Equipes_Nom_Separateur###'] = $this->lConf['Equipes_Nom_Separateur'];
					}
					else{
						$markerArray_publications_par_titres_equipes['###Equipes_Nom_Separateur###'] = '';
					}

					//Abreviation de l'équipe
					
					//Champ Nom (multilingue)
						$champAbreviation='';
						$champAbreviation=$equipes_row['Abreviation'];
							//On recherche le libellé traduit de Libelle
						$champAbreviation=$this->rechercherUidLangue($equipes_row['uidequipe'],$equipes_row['sys_language_uid'],$equipes_row['l18n_parent'],$equipes_row['Abreviation'],'tx_ligestmembrelabo_Equipe','Abreviation');

					$markerArray_publications_par_titres_equipes['###Equipes_Abreviation###'] = $champAbreviation;
					if($champAbreviation<>''){
						$markerArray_publications_par_titres_equipes['###Equipes_Abreviation_Separateur###'] = $this->lConf['Equipes_Abreviation_Separateur'];
					}
					else{
						$markerArray_publications_par_titres_equipes['###Equipes_Abreviation_Separateur###'] = '';
					}


					$wrappedSubpartContentArray_publications_par_titres_equipes['###Equipes_Surlignes###'] = array('','');
					
					//On ajoute ou non les balises pour surligner le membre si sa dernière équipe a été sélectionnée

					$tableau_equipes = explode(",",$this->lConf['baliseequipe']);
					
					foreach ($tableau_equipes as $equipe_courante) {
						if($idEquipe==$equipe_courante)
						{
							$wrappedSubpartContentArray_publications_par_titres_equipes['###Equipes_Surlignes###'] = array($this->lConf['balisedebut'],$this->lConf['balisefin']);
						}					
					}




					$contentEquipes .= $this->cObj->substituteMarkerArrayCached($template['publications_par_titres_equipes'],$markerArray_publications_par_titres_equipes,array(),$wrappedSubpartContentArray_publications_par_titres_equipes);

				}


				$subpartArray_publications_par_titres_publications['###EQUIPES###'] = $contentEquipes;
				
			//**************************************
			// Table Theme
			//**************************************

				$contentThemes='';

				$themes_select_fields = "tx_ligestpublications_Theme.uid AS uidtheme, tx_ligestpublications_Theme.*";
				$themes_from_table = "tx_ligestpublications_Publication, tx_ligestpublications_Theme, tx_ligestpublications_Theme_Publication";
				$themes_where_clause = "tx_ligestpublications_Publication.uid = ".$uid." AND tx_ligestpublications_Publication.uid = tx_ligestpublications_Theme_Publication.idPublication AND tx_ligestpublications_Theme_Publication.deleted<>1 AND tx_ligestpublications_Theme_Publication.idTheme = tx_ligestpublications_Theme.uid AND tx_ligestpublications_Theme.deleted<>1";
				$themes_groupBy = "";
				$themes_orderBy = "tx_ligestpublications_Theme.Libelle";
				$themes_limit = "";

				$themes_res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($themes_select_fields, $themes_from_table, $themes_where_clause, $themes_groupBy, $themes_orderBy, $themes_limit);


				while($themes_row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($themes_res)){
					$idTheme = $themes_row['uidtheme'];

					//Libellé du thème
					
					//Champ Libelle (multilingue)
						$champLibelle='';
						$champLibelle=$themes_row['Libelle'];
							//On recherche le libellé traduit de Libelle
						$champLibelle=$this->rechercherUidLangue($themes_row['uidtheme'],$themes_row['sys_language_uid'],$themes_row['l18n_parent'],$themes_row['Libelle'],'tx_ligestpublications_Theme','Libelle');

					
					$markerArray_publications_par_titres_themes['###Themes_Libelle###'] = $champLibelle;
					if($champLibelle<>''){
						$markerArray_publications_par_titres_themes['###Themes_Libelle_Separateur###'] = $this->lConf['Themes_Libelle_Separateur'];
					}
					else{
						$markerArray_publications_par_titres_themes['###Themes_Libelle_Separateur###'] = '';
					}

					$contentThemes .= $this->cObj->substituteMarkerArrayCached($template['publications_par_titres_themes'],$markerArray_publications_par_titres_themes,array(),array());

				}


				$subpartArray_publications_par_titres_publications['###THEMES###'] = $contentThemes;
			
				
			//**************************************
			// Table Type Publication
			//**************************************
				$markerArray_publications_par_titres_publications['###TypePublication_Libelle###'] = '';
				$markerArray_publications_par_titres_publications['###TypePublication_Libelle_Separateur###'] = '';
				$markerArray_publications_par_titres_publications['###TypePublication_Code###'] = '';
				$markerArray_publications_par_titres_publications['###TypePublication_Code_Separateur###'] = '';

				$type_select_fields = "tx_ligestpublications_TypePublication.uid AS uidtype, tx_ligestpublications_TypePublication.*";
				$type_from_table = "tx_ligestpublications_Publication, tx_ligestpublications_TypePublication";
				$type_where_clause = "tx_ligestpublications_Publication.uid = ".$uid." AND tx_ligestpublications_Publication.TypePublication = tx_ligestpublications_TypePublication.uid AND tx_ligestpublications_TypePublication.deleted<>1";
				$type_groupBy = "";
				$type_orderBy = "tx_ligestpublications_TypePublication.Libelle";
				$type_limit = "";

				$type_res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($type_select_fields, $type_from_table, $type_where_clause, $type_groupBy, $type_orderBy, $type_limit);


				while($type_row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($type_res)){
					$idType = $type_row['uidtype'];

					//Libellé de la publication
					
					//Champ Libelle (multilingue)
						$champLibelle='';
						$champLibelle=$type_row['Nom'];
							//On recherche le libellé traduit de Libelle
						$champLibelle=$this->rechercherUidLangue($type_row['uidtype'],$type_row['sys_language_uid'],$type_row['l18n_parent'],$type_row['Libelle'],'tx_ligestpublications_TypePublication','Libelle');

					$markerArray_publications_par_titres_publications['###TypePublication_Libelle###'] = $champLibelle;
					if($champLibelle<>''){
						$markerArray_publications_par_titres_publications['###TypePublication_Libelle_Separateur###'] = $this->lConf['TypePublication_Libelle_Separateur'];
					}
					else{
						$markerArray_publications_par_titres_publications['###TypePublication_Libelle_Separateur###'] = '';
					}
					
					//Champ Code
					$champCode=$type_row['Code'];

					$markerArray_publications_par_titres_publications['###TypePublication_Code###'] = $champCode;
					if($champCode<>''){
						$markerArray_publications_par_titres_publications['###TypePublication_Code_Separateur###'] = $this->lConf['TypePublication_Code_Separateur'];
					}
					else{
						$markerArray_publications_par_titres_publications['###TypePublication_Code_Separateur###'] = '';
					}
					
					
				}




			$contentItem_publications_par_titres_publications .= $this->cObj->substituteMarkerArrayCached($template['publications_par_titres_publications'],$markerArray_publications_par_titres_publications,$subpartArray_publications_par_titres_publications,$wrappedSubpartContentArray_publications_par_titres_publications);

		}



		$subpartArray_publications_par_titres_publications['###PUBLICATIONS###'] = $contentItem_publications_par_titres_publications;

		
		
		$contentItem_publications_par_titres .= $this->cObj->substituteMarkerArrayCached($template['publications_par_titres'],array(), $subpartArray_publications_par_titres_publications, array());
		
		
		$subpartArray_Item['###PUBLICATIONS_PAR_TITRES###'] = $contentItem_publications_par_titres;
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		// ************************************************************
		// Tri par années
		// ************************************************************
		
		
		$markerArray_publications_par_annees = array();
		$markerArray_publications_par_annees_publications = array();
		$markerArray_publications_par_annees_auteurs = array();
		$markerArray_publications_par_annees_equipes = array();
		$markerArray_publications_par_annees_themes = array();
		$markerArray_publications_par_annees_fichiers = array();
		
		$contentItem_publications_par_annees_publications='';
		$content_publications_par_annees='';
		
		
		//SELECT tx_ligestpublications_Publication.Annee FROM tx_ligestpublications_Publication GROUP BY tx_ligestpublications_Publication.Annee
		
		
		$annee_select_fields = "tx_ligestpublications_Publication.Annee";
		$annee_from_table = $from_table;
		$annee_where_clause = $where_clause;
		$annee_groupBy = "tx_ligestpublications_Publication.Annee";
		$annee_orderBy = "tx_ligestpublications_Publication.Annee ".$this->lConf['ordreannee'];
		$annee_limit = "";

		$annee_res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($annee_select_fields, $annee_from_table, $annee_where_clause, $annee_groupBy, $annee_orderBy, $annee_limit);

		$orderBy_annee = 'tx_ligestpublications_Publication.Titre '.$this->lConf['ordretitre'];
		
		while($row_annee = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($annee_res)){
		
			$markerArray_publications_par_annees = array();


			$markerArray_publications_par_annees['###Annee###'] = $row_annee['Annee'];
		
		
			// Requête permettant de récupérer les informations des publications sélectionnés 
		
			$where_clause_annee = $where_clause." AND tx_ligestpublications_Publication.Annee=".$row_annee["Annee"];


			$res_annees = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select_fields, $from_table, $where_clause_annee, $groupBy, $orderBy_annee, $limit);

			$contentItem_publications_par_annees_publications='';
		
			while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res_annees)){

				$markerArray_publications_par_annees_publications = array();
				$markerArray_publications_par_annees_auteurs = array();
				$markerArray_publications_par_annees_equipes = array();
				$markerArray_publications_par_annees_themes = array();
				$markerArray_publications_par_annees_fichiers = array();

				//**************************************
				// Table Publication
				//**************************************

				$uid=$row['uidpublication'];
				//$markerArray['###uid###'] = $row['uidpublication'];

				$markerArray_publications_par_annees_publications['###Annee###'] = $row['Annee'];

				
				$annees_precedente = $row['Annee'];
				if($row['Annee']<>''){
					$markerArray_publications_par_annees_publications['###Annee_Separateur###'] = $this->lConf['Annee_Separateur'];
				}
				else{
					$markerArray_publications_par_annees_publications['###Annee_Separateur###'] = '';
				}
				
				if($row['DateDebut']=='0000-00-00'){
					$markerArray_publications_par_annees_publications['###DateDebut###'] = $this->lConf['DateDebut'];
					if($this->lConf['DateDebut']<>''){
						$markerArray_publications_par_annees_publications['###DateDebut_Separateur###'] = $this->lConf['DateDebut_Separateur'];
					}
					else{
						$markerArray_publications_par_annees_publications['###DateDebut_Separateur###'] = '';
					}
				}
				else{
					$date_explosee = explode("-", $row['DateDebut']);

					$annee = (int)$date_explosee[0];
					$mois = (int)$date_explosee[1];
					$jour = (int)$date_explosee[2];

					// la fonction date permet de reformater une date au format souhaité
					$markerArray_publications_par_annees_publications['###DateDebut###'] = date($this->lConf['formatdate'],mktime(0, 0, 0, $mois, $jour, $annee));

					if($row['DateDebut']<>''){
						$markerArray_publications_par_annees_publications['###DateDebut_Separateur###'] = $this->lConf['DateDebut_Separateur'];
					}
					else{
						$markerArray_publications_par_annees_publications['###DateDebut_Separateur###'] = '';
					}
				}

				if($row['DateFin']=='0000-00-00'){
					$markerArray_publications_par_annees_publications['###DateFin###'] = $this->lConf['DateFin'];
					if($this->lConf['DateFin']<>''){
						$markerArray_publications_par_annees_publications['###DateFin_Separateur###'] = $this->lConf['DateFin_Separateur'];
					}
					else{
						$markerArray_publications_par_annees_publications['###DateFin_Separateur###'] = '';
					}
				}
				else{
					$date_explosee = explode("-", $row['DateFin']);

					$annee = (int)$date_explosee[0];
					$mois = (int)$date_explosee[1];
					$jour = (int)$date_explosee[2];

					// la fonction date permet de reformater une date au format souhaité
					$markerArray_publications_par_annees_publications['###DateFin###'] = date($this->lConf['formatdate'],mktime(0, 0, 0, $mois, $jour, $annee));

					if($row['DateFin']<>''){
						$markerArray_publications_par_annees_publications['###DateFin_Separateur###'] = $this->lConf['DateFin_Separateur'];
					}
					else{
						$markerArray_publications_par_annees_publications['###DateFin_Separateur###'] = '';
					}
				}
				
				$markerArray_publications_par_annees_publications['###Edition###'] = $row['Edition'];
				if($row['Edition']<>''){
					$markerArray_publications_par_annees_publications['###Edition_Separateur###'] = $this->lConf['Edition_Separateur'];
				}
				else{
					$markerArray_publications_par_annees_publications['###Edition_Separateur###'] = '';
				}

				
				
				if($row['EstEditeur']=='F'){
					$markerArray_publications_par_annees_publications['###EstEditeur###'] = $this->lConf['NEstPasEditeur'];
					
					if($this->lConf['NEstPasEditeur']<>''){
						$markerArray_publications_par_annees_publications['###EstEditeur_Separateur###'] = $this->lConf['EstEditeur_Separateur'];
					}
					else{
						$markerArray_publications_par_annees_publications['###EstEditeur_Separateur###'] = '';
					}
				}
				else{
					$markerArray_publications_par_annees_publications['###EstEditeur###'] = $this->lConf['EstEditeur'];
					
					if($this->lConf['EstEditeur']<>''){
						$markerArray_publications_par_annees_publications['###EstEditeur_Separateur###'] = $this->lConf['EstEditeur_Separateur'];
					}
					else{
						$markerArray_publications_par_annees_publications['###EstEditeur_Separateur###'] = '';
					}
				}
				
				if($row['EstDeLaVulgarisation']=='F'){
					$markerArray_publications_par_annees_publications['###EstDeLaVulgarisation###'] = $this->lConf['NEstPasDeLaVulgarisation'];
					
					if($this->lConf['NEstPasDeLaVulgarisation']<>''){
						$markerArray_publications_par_annees_publications['###EstDeLaVulgarisation_Separateur###'] = $this->lConf['EstDeLaVulgarisation_Separateur'];
					}
					else{
						$markerArray_publications_par_annees_publications['###EstDeLaVulgarisation_Separateur###'] = '';
					}
				}
				else{
					$markerArray_publications_par_annees_publications['###EstDeLaVulgarisation###'] = $this->lConf['EstDeLaVulgarisation'];
					
					if($this->lConf['EstDeLaVulgarisation']<>''){
						$markerArray_publications_par_annees_publications['###EstDeLaVulgarisation_Separateur###'] = $this->lConf['EstDeLaVulgarisation_Separateur'];
					}
					else{
						$markerArray_publications_par_annees_publications['###EstDeLaVulgarisation_Separateur###'] = '';
					}
				}
				
				if($row['EstInternationale']=='N'){
					$markerArray_publications_par_annees_publications['###EstInternationale###'] = $this->lConf['NEstPasInternationale'];
					
					if($this->lConf['NEstPasInternationale']<>''){
						$markerArray_publications_par_annees_publications['###EstInternationale_Separateur###'] = $this->lConf['EstInternationale_Separateur'];
					}
					else{
						$markerArray_publications_par_annees_publications['###EstInternationale_Separateur###'] = '';
					}
				}
				else{
					$markerArray_publications_par_annees_publications['###EstInternationale###'] = $this->lConf['EstInternationale'];
					
					if($this->lConf['EstInternationale']<>''){
						$markerArray_publications_par_annees_publications['###EstInternationale_Separateur###'] = $this->lConf['EstInternationale_Separateur'];
					}
					else{
						$markerArray_publications_par_annees_publications['###EstInternationale_Separateur###'] = '';
					}
				}
				
				if($row['EstInvite']=='F'){
					$markerArray_publications_par_annees_publications['###EstInvite###'] = $this->lConf['NEstPasInvite'];
					
					if($this->lConf['NEstPasInvite']<>''){
						$markerArray_publications_par_annees_publications['###EstInvite_Separateur###'] = $this->lConf['EstInvite_Separateur'];
					}
					else{
						$markerArray_publications_par_annees_publications['###EstInvite_Separateur###'] = '';
					}
				}
				else{
					$markerArray_publications_par_annees_publications['###EstInvite###'] = $this->lConf['EstInvite'];
					
					if($this->lConf['EstInvite']<>''){
						$markerArray_publications_par_annees_publications['###EstInvite_Separateur###'] = $this->lConf['EstInvite_Separateur'];
					}
					else{
						$markerArray_publications_par_annees_publications['###EstInvite_Separateur###'] = '';
					}
				}

				if($row['EstParu']=='F'){
					$markerArray_publications_par_annees_publications['###EstParu###'] = $this->lConf['NEstPasParu'];
					
					if($this->lConf['NEstPasParu']<>''){
						$markerArray_publications_par_annees_publications['###EstParu_Separateur###'] = $this->lConf['EstParu_Separateur'];
					}
					else{
						$markerArray_publications_par_annees_publications['###EstParu_Separateur###'] = '';
					}
				}
				else{
					$markerArray_publications_par_annees_publications['###EstParu###'] = $this->lConf['EstParu'];
					
					if($this->lConf['EstParu']<>''){
						$markerArray_publications_par_annees_publications['###EstParu_Separateur###'] = $this->lConf['EstInvite_Separateur'];
					}
					else{
						$markerArray_publications_par_annees_publications['###EstParu_Separateur###'] = '';
					}
				}
				
				if($row['EstUnChapitre']=='R'){
					$markerArray_publications_par_annees_publications['###EstUnChapitre###'] = $this->lConf['EstUnChapitreR'];
					
					if($this->lConf['EstUnChapitreR']<>''){
						$markerArray_publications_par_annees_publications['###EstUnChapitre_Separateur###'] = $this->lConf['EstUnChapitre_Separateur'];
					}
					else{
						$markerArray_publications_par_annees_publications['###EstUnChapitre_Separateur###'] = '';
					}
				}
				else if($row['EstUnChapitre']=='V'){
					$markerArray_publications_par_annees_publications['###EstUnChapitre###'] = $this->lConf['EstUnChapitreV'];
					
					if($this->lConf['EstUnChapitreV']<>''){
						$markerArray_publications_par_annees_publications['###EstUnChapitre_Separateur###'] = $this->lConf['EstUnChapitre_Separateur'];
					}
					else{
						$markerArray_publications_par_annees_publications['###EstUnChapitre_Separateur###'] = '';
					}
				}
				else{
					$markerArray_publications_par_annees_publications['###EstUnChapitre###'] = $this->lConf['EstUnChapitreF'];
					
					if($this->lConf['EstUnChapitreF']<>''){
						$markerArray_publications_par_annees_publications['###EstUnChapitre_Separateur###'] = $this->lConf['EstUnChapitre_Separateur'];
					}
					else{
						$markerArray_publications_par_annees_publications['###EstUnChapitre_Separateur###'] = '';
					}
				}
				
				
				$markerArray_publications_par_annees_publications['###ISBN###'] = $row['ISBN'];
				if($row['ISBN']<>''){
					$markerArray_publications_par_annees_publications['###ISBN_Separateur###'] = $this->lConf['ISBN_Separateur'];
				}
				else{
					$markerArray_publications_par_annees_publications['###ISBN_Separateur###'] = '';
				}
				
				
				$markerArray_publications_par_annees_publications['###MediaDePublication###'] = $row['MediaDePublication'];
				if($row['MediaDePublication']<>''){
					$markerArray_publications_par_annees_publications['###MediaDePublication_Separateur###'] = $this->lConf['MediaDePublication_Separateur'];
				}
				else{
					$markerArray_publications_par_annees_publications['###MediaDePublication_Separateur###'] = '';
				}
				
				$markerArray_publications_par_annees_publications['###Notes###'] = $row['Notes'];
				if($row['Notes']<>''){
					$markerArray_publications_par_annees_publications['###Notes_Separateur###'] = $this->lConf['Notes_Separateur'];
				}
				else{
					$markerArray_publications_par_annees_publications['###Notes_Separateur###'] = '';
				}
				
				$markerArray_publications_par_annees_publications['###Numero###'] = $row['Numero'];
				if($row['Numero']<>''){
					$markerArray_publications_par_annees_publications['###Numero_Separateur###'] = $this->lConf['Numero_Separateur'];
				}
				else{
					$markerArray_publications_par_annees_publications['###Numero_Separateur###'] = '';
				}
				
				$pages = '';
				// Affichage du nombre de page ou d'une plage de pages.
				
				if($row['Pages']<>'')
				{
					$pos_tiret = strpos($row['Pages'], '-');
					
					if ($pos_tiret === false) { // Il s'agit d'un nombre de pages
						$pages = str_replace('###Pages###', $row['Pages'], $this->lConf['nbpages']);
					}
					else // Il s'agit d'une plage de pages
					{
						$pages_explosee = explode("-", $row['Pages']);

						$page_debut = $pages_explosee[0];
						$page_fin = $pages_explosee[1];
					
						$pages = str_replace('###PageDebut###', $page_debut, $this->lConf['plagepages']);
						$pages = str_replace('###PageFin###', $page_fin, $pages);
					
					}
				}
				
				$markerArray_publications_par_annees_publications['###Pages###'] = $pages;
				if($pages<>''){
					$markerArray_publications_par_annees_publications['###Pages_Separateur###'] = $this->lConf['Pages_Separateur'];
				}
				else{
					$markerArray_publications_par_annees_publications['###Pages_Separateur###'] = '';
				}
				

				$markerArray_publications_par_annees_publications['###PublisherOrSchool###'] = $row['PublisherOrSchool'];
				if($row['PublisherOrSchool']<>''){
					$markerArray_publications_par_annees_publications['###PublisherOrSchool_Separateur###'] = $this->lConf['PublisherOrSchool_Separateur'];
				}
				else{
					$markerArray_publications_par_annees_publications['###PublisherOrSchool_Separateur###'] = '';
				}
				
				
				
				
				
				$markerArray_publications_par_annees_publications['###Serie###'] = $row['Serie'];
				if($row['Serie']<>''){
					$markerArray_publications_par_annees_publications['###Serie_Separateur###'] = $this->lConf['Serie_Separateur'];
				}
				else{
					$markerArray_publications_par_annees_publications['###Serie_Separateur###'] = '';
				}
				
				$markerArray_publications_par_annees_publications['###TauxSelection###'] = $row['TauxSelection'];
				if($row['TauxSelection']<>''){
					$markerArray_publications_par_annees_publications['###TauxSelection_Separateur###'] = $this->lConf['TauxSelection_Separateur'];
				}
				else{
					$markerArray_publications_par_annees_publications['###TauxSelection_Separateur###'] = '';
				}
				
				$markerArray_publications_par_annees_publications['###Titre###'] = $row['Titre'];
				if($row['Titre']<>''){
					$markerArray_publications_par_annees_publications['###Titre_Separateur###'] = $this->lConf['Titre_Separateur'];
				}
				else{
					$markerArray_publications_par_annees_publications['###Titre###'] = '';
				}
				
				$markerArray_publications_par_annees_publications['###VilleEtPays###'] = $row['VilleEtPays'];
				if($row['VilleEtPays']<>''){
					$markerArray_publications_par_annees_publications['###VilleEtPays_Separateur###'] = $this->lConf['VilleEtPays_Separateur'];
				}
				else{
					$markerArray_publications_par_annees_publications['###VilleEtPays_Separateur###'] = '';
				}

				$markerArray_publications_par_annees_publications['###Volume###'] = $row['Volume'];
				if($row['Volume']<>''){
					$markerArray_publications_par_annees_publications['###Volume_Separateur###'] = $this->lConf['Volume_Separateur'];
				}
				else{
					$markerArray_publications_par_annees_publications['###Volume_Separateur###'] = '';
				}
				
				
				
				//Configuration du lien vers le fichier
					// configure the typolink
					$this->local_cObj = t3lib_div::makeInstance('tslib_cObj');
					$this->local_cObj->setCurrentVal($GLOBALS['TSFE']->id);
					$this->typolink_conf = $this->conf['typolink.'];
					// configure typolink
					$temp_conf = $this->typolink_conf;
					$temp_conf['parameter'] = $row['Lien'];
					$temp_conf['extTarget'] = '';				
					$temp_conf['parameter.']['wrap'] = "|";
					// Fill wrapped subpart marker
				$wrappedSubpartContentArray_publications_par_annees_publications['###Lien###'] = $this->local_cObj->typolinkWrap($temp_conf);
				
				$markerArray_publications_par_annees_publications['###LienDur###'] = $row['Lien'];

				if($row['Lien']<>''){
					$markerArray_publications_par_annees_publications['###LienDur_Separateur###'] = $this->lConf['LienDur_Separateur'];
				}
				else{
					$markerArray_publications_par_annees_publications['###LienDur_Separateur###'] = '';
				}



				
				//**************************************
				// Table Auteur
				//**************************************
					$contentAuteurs='';

					$auteurs_select_fields = "tx_ligestpublications_Auteur.uid AS uidAuteur, tx_ligestpublications_Auteur.*, tx_ligestpublications_Publication.*, tx_ligestpublications_Publication_Auteur.*, tx_ligestmembrelabo_MembreDuLabo.PageWeb, tx_ligestmembrelabo_Equipe.uid AS uidequipe";
					$auteurs_from_table = "tx_ligestpublications_Auteur, tx_ligestpublications_Publication, tx_ligestpublications_Publication_Auteur, tx_ligestmembrelabo_MembreDuLabo, tx_ligestmembrelabo_Equipe, tx_ligestmembrelabo_EstMembreDe";
					$auteurs_where_clause = "tx_ligestpublications_Publication.uid = ".$uid." AND tx_ligestpublications_Publication.uid = tx_ligestpublications_Publication_Auteur.idPublication AND tx_ligestpublications_Publication_Auteur.deleted<>1 AND tx_ligestpublications_Publication_Auteur.idAuteur = tx_ligestpublications_Auteur.uid AND tx_ligestpublications_Auteur.deleted<>1 AND tx_ligestpublications_Auteur.idMembreLabo = tx_ligestmembrelabo_MembreDuLabo.uid AND tx_ligestmembrelabo_MembreDuLabo.deleted<>1 AND tx_ligestmembrelabo_MembreDuLabo.uid = tx_ligestmembrelabo_EstMembreDe.idMembreLabo AND tx_ligestmembrelabo_EstMembreDe.deleted<>1 AND tx_ligestmembrelabo_EstMembreDe.idEquipe = tx_ligestmembrelabo_Equipe.uid AND tx_ligestmembrelabo_Equipe.deleted<>1";
					$auteurs_groupBy = "";
					$auteurs_orderBy = "tx_ligestpublications_Publication_Auteur.Ordre, tx_ligestpublications_Auteur.Nom, tx_ligestpublications_Auteur.Prenom";
					$auteurs_limit = "";


					$auteurs_res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($auteurs_select_fields, $auteurs_from_table, $auteurs_where_clause, $auteurs_groupBy, $auteurs_orderBy, $auteurs_limit);


					while($auteurs_row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($auteurs_res)){
						$idEquipe = $auteurs_row['uidequipe'];
						
						//Nom de l'auteur
						$markerArray_publications_par_annees_auteurs['###Auteurs_Nom###'] = $auteurs_row['Nom'];
						if($auteurs_row['Nom']<>''){
							$markerArray_publications_par_annees_auteurs['###Auteurs_Nom_Separateur###'] = $this->lConf['Auteurs_Nom_Separateur'];
						}
						else{
							$markerArray_publications_par_annees_auteurs['###Auteurs_Nom_Separateur###'] = '';
						}
						
						$markerArray_publications_par_annees_auteurs['###Auteurs_NOM###'] = mb_strtoupper($auteurs_row['Nom'],"UTF-8");
						if($auteurs_row['Nom']<>''){
							$markerArray_publications_par_annees_auteurs['###Auteurs_NOM_Separateur###'] = $this->lConf['Auteurs_Nom_Separateur'];
						}
						else{
							$markerArray_publications_par_annees_auteurs['###Auteurs_NOM_Separateur###'] = '';
						}

						//Prénom de l'auteur
						$markerArray_publications_par_annees_auteurs['###Auteurs_Prenom###'] = $auteurs_row['Prenom'];
						if($auteurs_row['Prenom']<>''){
							$markerArray_publications_par_annees_auteurs['###Auteurs_Prenom_Separateur###'] = $this->lConf['PrenomAuteur_Separateur'];
						}
						else{
							$markerArray_publications_par_annees_auteurs['###Auteurs_PRENOM_Separateur###'] = '';
						}
						
						$markerArray_publications_par_annees_auteurs['###Auteurs_PRENOM###'] = mb_strtoupper($auteurs_row['Prenom'],"UTF-8");
						if($auteurs_row['Prenom']<>''){
							$markerArray_publications_par_annees_auteurs['###Auteurs_PRENOM_Separateur###'] = $this->lConf['Auteurs_Prenom_Separateur'];
						}
						else{
							$markerArray_publications_par_annees_auteurs['###Auteurs_PRENOM_Separateur###'] = '';
						}
						
						//Gestion des initiales

						$markerArray_publications_par_annees_auteurs['###Auteurs_InitialeNom###'] = substr($auteurs_row['Nom'],0,1).".";
						if($auteurs_row['Nom']<>''){
							$markerArray_publications_par_annees_auteurs['###Auteurs_InitialeNom_Separateur###'] = $this->lConf['Auteurs_InitialeNom_Separateur'];
						}
						else{
							$markerArray_publications_par_annees_auteurs['###Auteurs_InitialeNom_Separateur###'] = '';
						}
						
						// On sépare les prénoms s'ils contiennent un - (cas des prénoms composés)
						$prenoms = explode("-",$auteurs_row['Prenom']);
						$initiales_prenom = "";
						$premier_prenom = true;
						// Pour chaque prénom, on récupère l'initiale. On sépare ces initiales par des tirets
						foreach ($prenoms as $prenom_courant) {
							if($premier_prenom != true)
							{
								$initiales_prenom = $initiales_prenom."-";
							}
							$initiales_prenom = $initiales_prenom.substr($prenom_courant,0,1);
							$premier_prenom = false;
						}
						if($initiales_prenom != '')
						{
							$markerArray_publications_par_annees_auteurs['###Auteurs_InitialePrenom###'] = $initiales_prenom.".";
						}	
						
						
						
						if($auteurs_row['Prenom']<>''){
							$markerArray_publications_par_annees_auteurs['###Auteurs_InitialePrenom_Separateur###'] = $this->lConf['Auteurs_InitialePrenom_Separateur'];
						}
						else{
							$markerArray_publications_par_annees_auteurs['###Auteurs_InitialePrenom_Separateur###'] = '';
						}


						//Configuration du lien PageWeb
							// configure the typolink
							$this->local_cObj = t3lib_div::makeInstance('tslib_cObj');
							$this->local_cObj->setCurrentVal($GLOBALS['TSFE']->id);
							$this->typolink_conf = $this->conf['typolink.'];
							// configure typolink
							$temp_conf = $this->typolink_conf;
							$temp_conf['parameter'] = $auteurs_row['PageWeb'];
							$temp_conf['extTarget'] = '';				
							$temp_conf['parameter.']['wrap'] = "|";
							// Fill wrapped subpart marker
						$wrappedSubpartContentArray_publications_par_annees_auteurs['###Auteurs_PageWebLien###'] = $this->local_cObj->typolinkWrap($temp_conf);
						
						$markerArray_publications_par_annees_auteurs['###Auteurs_PageWeb###'] = $auteurs_row['PageWeb'];

						if($auteurs_row['PageWeb']<>''){
							$markerArray_publications_par_annees_auteurs['###Auteurs_PageWeb_Separateur###'] = $this->lConf['Auteurs_PageWeb_Separateur'];
						}
						else{
							$markerArray_publications_par_annees_auteurs['###Auteurs_PageWeb_Separateur###'] = '';
						}
					
						//Le contenu de cette balise est modifié, si besoin dans la partie concernant l'équipe du membre.
						$wrappedSubpartContentArray_publications_par_annees_auteurs['###Auteurs_Surlignes###'] = array('','');
						
						//On ajoute ou non les balises pour surligner le membre si sa dernière équipe a été sélectionnée

						$tableau_equipes = explode(",",$this->lConf['baliseequipe']);
						
						foreach ($tableau_equipes as $equipe_courante) {
							if($idEquipe==$equipe_courante)
							{
								$wrappedSubpartContentArray_publications_par_annees_auteurs['###Auteurs_Surlignes###'] = array($this->lConf['balisedebut'],$this->lConf['balisefin']);
							}					
						}
					
					
					
					
						$contentAuteurs .= $this->cObj->substituteMarkerArrayCached($template['publications_par_annees_auteurs'],$markerArray_publications_par_annees_auteurs,array(),$wrappedSubpartContentArray_publications_par_annees_auteurs);

					}


					$subpartArray_publications_par_annees_publications['###AUTEURS###'] = $contentAuteurs;




				//**************************************
				// Table Fichier
				//**************************************
					$contentFichiers='';

					$utilisateur_uid = $GLOBALS['TSFE']->fe_user->user['uid'];
					$utilisateur_login = $GLOBALS['TSFE']->fe_user->user['username'];
					$utilisateur_groupes = $GLOBALS['TSFE']->fe_user->user['usergroup']; // renvoie une liste d'uid des groupes séparés par des virgules
					$tableau_groupes = Explode(",",$utilisateur_groupes);
					
					
					$fichiers_select_fields = "tx_ligestpublications_Fichier.uid AS uidFichier, tx_ligestpublications_Fichier.*";
					$fichiers_from_table = "tx_ligestpublications_Fichier, tx_ligestpublications_Publication";
					$fichiers_where_clause = "tx_ligestpublications_Publication.uid = ".$uid." AND tx_ligestpublications_Publication.uid = tx_ligestpublications_Fichier.idPublication AND tx_ligestpublications_Fichier.deleted<>1";
					$fichiers_groupBy = "";
					$fichiers_orderBy = "tx_ligestpublications_Fichier.NomFichier";
					$fichiers_limit = "";

					$fichiers_res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($fichiers_select_fields, $fichiers_from_table, $fichiers_where_clause, $fichiers_groupBy, $fichiers_orderBy, $fichiers_limit);


					while($fichiers_row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($fichiers_res)){

						$autorisation = false;


						if($tableau_groupes<>'')
						{
							foreach ($tableau_groupes as $groupe_courant) {
								if ($groupe_courant == $fichiers_row['fe_group'])
								{
									$autorisation = true;
								}
							}
						}
						

						if($fichiers_row['fe_group']==0 || $fichiers_row['fe_group']==-2 ||$autorisation==true){




							$markerArray_publications_par_annees_fichiers['###Fichiers_Nom###'] = $fichiers_row['NomFichier'];
							if($fichiers_row['Nom']<>''){
								$markerArray_publications_par_annees_fichiers['###Fichiers_Nom_Separateur###'] = $this->lConf['Fichiers_Nom_Separateur'];
							}
							else{
								$markerArray_publications_par_annees_fichiers['###Fichiers_Nom_Separateur###'] = '';
							}


							//Configuration du lien vers le fichier
								// configure the typolink
								$this->local_cObj = t3lib_div::makeInstance('tslib_cObj');
								$this->local_cObj->setCurrentVal($GLOBALS['TSFE']->id);
								$this->typolink_conf = $this->conf['typolink.'];
								// configure typolink
								$temp_conf = $this->typolink_conf;
								$temp_conf['parameter'] = $fichiers_row['LienFichier'];
								$temp_conf['extTarget'] = '';				
								$temp_conf['parameter.']['wrap'] = "|";
								// Fill wrapped subpart marker
							$wrappedSubpartContentArray_publications_par_annees_fichiers['###Fichiers_Lien###'] = $this->local_cObj->typolinkWrap($temp_conf);
							
							$markerArray_publications_par_annees_fichiers['###Fichiers_LienDur###'] = $fichiers_row['LienFichier'];

							if($fichiers_row['LienFichier']<>''){
								$markerArray_publications_par_annees_fichiers['###Fichiers_LienDur_Separateur###'] = $this->lConf['Fichiers_LienDur_Separateur'];
							}
							else{
								$markerArray_publications_par_annees_fichiers['###Fichiers_LienDur_Separateur###'] = '';
							}
						
						
							$contentFichiers .= $this->cObj->substituteMarkerArrayCached($template['publications_par_annees_fichiers'],$markerArray_publications_par_annees_fichiers,array(),$wrappedSubpartContentArray_publications_par_annees_fichiers);
						
						}
						
					}


					$subpartArray_publications_par_annees_publications['###FICHIERS###'] = $contentFichiers;

				//**************************************
				// Table Equipe
				//**************************************
					
					$contentEquipes='';

					$equipes_select_fields = "tx_ligestmembrelabo_Equipe.uid AS uidequipe, tx_ligestmembrelabo_Equipe.*, tx_ligestpublications_Appartenir.*";
					$equipes_from_table = "tx_ligestpublications_Publication, tx_ligestmembrelabo_Equipe, tx_ligestpublications_Appartenir";
					$equipes_where_clause = "tx_ligestpublications_Publication.uid = ".$uid." AND tx_ligestpublications_Publication.uid = tx_ligestpublications_Appartenir.idPublication AND tx_ligestpublications_Appartenir.deleted<>1 AND tx_ligestpublications_Appartenir.idEquipe = tx_ligestmembrelabo_Equipe.uid AND tx_ligestmembrelabo_Equipe.deleted<>1";
					$equipes_groupBy = "";
					$equipes_orderBy = "tx_ligestmembrelabo_Equipe.Abreviation";
					$equipes_limit = "";

					$equipes_res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($equipes_select_fields, $equipes_from_table, $equipes_where_clause, $equipes_groupBy, $equipes_orderBy, $equipes_limit);


					while($equipes_row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($equipes_res)){
						$idEquipe = $equipes_row['uidequipe'];

						//Nom de l'équipe
						//Champ Nom (multilingue)
							$champNom='';
							$champNom=$equipes_row['Nom'];
								//On recherche le libellé traduit de Libelle
							$champNom=$this->rechercherUidLangue($equipes_row['uidequipe'],$equipes_row['sys_language_uid'],$equipes_row['l18n_parent'],$equipes_row['Nom'],'tx_ligestmembrelabo_Equipe','Nom');

						
						$markerArray_publications_par_annees_equipes['###Equipes_Nom###'] = $champNom;
						if($champNom<>''){
							$markerArray_publications_par_annees_equipes['###Equipes_Nom_Separateur###'] = $this->lConf['Equipes_Nom_Separateur'];
						}
						else{
							$markerArray_publications_par_annees_equipes['###Equipes_Nom_Separateur###'] = '';
						}

						//Abreviation de l'équipe
						
						//Champ Nom (multilingue)
							$champAbreviation='';
							$champAbreviation=$equipes_row['Abreviation'];
								//On recherche le libellé traduit de Libelle
							$champAbreviation=$this->rechercherUidLangue($equipes_row['uidequipe'],$equipes_row['sys_language_uid'],$equipes_row['l18n_parent'],$equipes_row['Abreviation'],'tx_ligestmembrelabo_Equipe','Abreviation');

						$markerArray_publications_par_annees_equipes['###Equipes_Abreviation###'] = $champAbreviation;
						if($champAbreviation<>''){
							$markerArray_publications_par_annees_equipes['###Equipes_Abreviation_Separateur###'] = $this->lConf['Equipes_Abreviation_Separateur'];
						}
						else{
							$markerArray_publications_par_annees_equipes['###Equipes_Abreviation_Separateur###'] = '';
						}


						$wrappedSubpartContentArray_publications_par_annees_equipes['###Equipes_Surlignes###'] = array('','');
						
						//On ajoute ou non les balises pour surligner le membre si sa dernière équipe a été sélectionnée

						$tableau_equipes = explode(",",$this->lConf['baliseequipe']);
						
						foreach ($tableau_equipes as $equipe_courante) {
							if($idEquipe==$equipe_courante)
							{
								$wrappedSubpartContentArray_publications_par_annees_equipes['###Equipes_Surlignes###'] = array($this->lConf['balisedebut'],$this->lConf['balisefin']);
							}					
						}




						$contentEquipes .= $this->cObj->substituteMarkerArrayCached($template['publications_par_annees_equipes'],$markerArray_publications_par_annees_equipes,array(),$wrappedSubpartContentArray_publications_par_annees_equipes);

					}


					$subpartArray_publications_par_annees_publications['###EQUIPES###'] = $contentEquipes;
					
				//**************************************
				// Table Theme
				//**************************************

					$contentThemes='';

					$themes_select_fields = "tx_ligestpublications_Theme.uid AS uidtheme, tx_ligestpublications_Theme.*";
					$themes_from_table = "tx_ligestpublications_Publication, tx_ligestpublications_Theme, tx_ligestpublications_Theme_Publication";
					$themes_where_clause = "tx_ligestpublications_Publication.uid = ".$uid." AND tx_ligestpublications_Publication.uid = tx_ligestpublications_Theme_Publication.idPublication AND tx_ligestpublications_Theme_Publication.deleted<>1 AND tx_ligestpublications_Theme_Publication.idTheme = tx_ligestpublications_Theme.uid AND tx_ligestpublications_Theme.deleted<>1";
					$themes_groupBy = "";
					$themes_orderBy = "tx_ligestpublications_Theme.Libelle";
					$themes_limit = "";

					$themes_res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($themes_select_fields, $themes_from_table, $themes_where_clause, $themes_groupBy, $themes_orderBy, $themes_limit);


					while($themes_row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($themes_res)){
						$idTheme = $themes_row['uidtheme'];

						//Libellé du thème
						
						//Champ Libelle (multilingue)
							$champLibelle='';
							$champLibelle=$themes_row['Libelle'];
								//On recherche le libellé traduit de Libelle
							$champLibelle=$this->rechercherUidLangue($themes_row['uidtheme'],$themes_row['sys_language_uid'],$themes_row['l18n_parent'],$themes_row['Libelle'],'tx_ligestpublications_Theme','Libelle');

						
						$markerArray_publications_par_annees_themes['###Themes_Libelle###'] = $champLibelle;
						if($champLibelle<>''){
							$markerArray_publications_par_annees_themes['###Themes_Libelle_Separateur###'] = $this->lConf['Themes_Libelle_Separateur'];
						}
						else{
							$markerArray_publications_par_annees_themes['###Themes_Libelle_Separateur###'] = '';
						}

						$contentThemes .= $this->cObj->substituteMarkerArrayCached($template['publications_par_annees_themes'],$markerArray_publications_par_annees_themes,array(),array());

					}


					$subpartArray_publications_par_annees_publications['###THEMES###'] = $contentThemes;
				
					
				//**************************************
				// Table Type Publication
				//**************************************
					$markerArray_publications_par_annees_publications['###TypePublication_Libelle###'] = '';
					$markerArray_publications_par_annees_publications['###TypePublication_Libelle_Separateur###'] = '';
					$markerArray_publications_par_annees_publications['###TypePublication_Code###'] = '';
					$markerArray_publications_par_annees_publications['###TypePublication_Code_Separateur###'] = '';

					$type_select_fields = "tx_ligestpublications_TypePublication.uid AS uidtype, tx_ligestpublications_TypePublication.*";
					$type_from_table = "tx_ligestpublications_Publication, tx_ligestpublications_TypePublication";
					$type_where_clause = "tx_ligestpublications_Publication.uid = ".$uid." AND tx_ligestpublications_Publication.TypePublication = tx_ligestpublications_TypePublication.uid AND tx_ligestpublications_TypePublication.deleted<>1";
					$type_groupBy = "";
					$type_orderBy = "tx_ligestpublications_TypePublication.Libelle";
					$type_limit = "";

					$type_res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($type_select_fields, $type_from_table, $type_where_clause, $type_groupBy, $type_orderBy, $type_limit);


					while($type_row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($type_res)){
						$idType = $type_row['uidtype'];

						//Libellé de la publication
						
						//Champ Libelle (multilingue)
							$champLibelle='';
							$champLibelle=$type_row['Nom'];
								//On recherche le libellé traduit de Libelle
							$champLibelle=$this->rechercherUidLangue($type_row['uidtype'],$type_row['sys_language_uid'],$type_row['l18n_parent'],$type_row['Libelle'],'tx_ligestpublications_TypePublication','Libelle');

						$markerArray_publications_par_annees_publications['###TypePublication_Libelle###'] = $champLibelle;
						if($champLibelle<>''){
							$markerArray_publications_par_annees_publications['###TypePublication_Libelle_Separateur###'] = $this->lConf['TypePublication_Libelle_Separateur'];
						}
						else{
							$markerArray_publications_par_annees_publications['###TypePublication_Libelle_Separateur###'] = '';
						}
						
						//Champ Code
						$champCode=$type_row['Code'];

						$markerArray_publications_par_annees_publications['###TypePublication_Code###'] = $champCode;
						if($champCode<>''){
							$markerArray_publications_par_annees_publications['###TypePublication_Code_Separateur###'] = $this->lConf['TypePublication_Code_Separateur'];
						}
						else{
							$markerArray_publications_par_annees_publications['###TypePublication_Code_Separateur###'] = '';
						}
						
						
					}




				$contentItem_publications_par_annees_publications .= $this->cObj->substituteMarkerArrayCached($template['publications_par_annees_publications'],$markerArray_publications_par_annees_publications,$subpartArray_publications_par_annees_publications,$wrappedSubpartContentArray_publications_par_annees_publications);

			}
		
		
			$subpartArray_publications_par_annees_publications['###PUBLICATIONS###'] = $contentItem_publications_par_annees_publications;

		
			$contentItem_publications_par_annees .= $this->cObj->substituteMarkerArrayCached($template['publications_par_annees'],$markerArray_publications_par_annees, $subpartArray_publications_par_annees_publications, array());
		
		}
		
		$subpartArray_Item['###PUBLICATIONS_PAR_ANNEES###'] = $contentItem_publications_par_annees;
		
		
		$contentItem .= $this->cObj->substituteMarkerArrayCached($template['item'],array(), $subpartArray_Item, array());
		
		
		// Fill the content with items in $contentItem
		$subpartArray['###CONTENT###'] = $contentItem;



		// Fill the TEMPLATE subpart
		$content = $this->cObj->substituteMarkerArrayCached($template['total'], array(), $subpartArray);
		
		//$content=$code;
	
		return $this->pi_wrapInBaseClass($content);
	}
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/li_gest_publications/pi1/class.tx_ligestpublications_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/li_gest_publications/pi1/class.tx_ligestpublications_pi1.php']);
}

?>