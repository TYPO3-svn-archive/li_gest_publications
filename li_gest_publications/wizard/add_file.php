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



unset($MCONF);
define('TYPO3_MOD_PATH', '../typo3conf/ext/li_gest_membre_labo/wizard/');
$BACK_PATH='../../../../typo3/';

require_once($BACK_PATH.'init.php');
require_once($BACK_PATH.'template.php');

require_once(PATH_t3lib.'class.t3lib_scbase.php');
 

//$BACK_PATH = '';
//require ('init.php');
//require ('template.php');
$LANG->includeLLFile('EXT:lang/locallang_wizards.xml');




/**
 * La classe tx_ligestmembrelabo_add permet de créer un enregistrement contenant des champs préremplis puis d'appeler la classe d'édition d'enregistrement
 *
 * @author	Bruno Gallet <gallet.bruno@gmail.com>
 * @package	TYPO3
 * @subpackage tx_ligestmembrelabo
 */


class tx_ligestmembrelabo_add {


		// Internal, static: GPvars
		
		/// Wizard parameters, coming from TCEforms linking to the wizard.
	var $P;
		/// Boolean; if set, the window will be closed by JavaScript	
	var $doClose;				




	/**
	 * Initialization of the script
	 *
	 * @return	void
	 */
	function init()	{
		$this->P = t3lib_div::_GP('P');
		$this->doClose = t3lib_div::_GP('doClose');		// Used for the return URL to alt_doc.php so that we can close the window.
	}

	/**
	 * Main function
	 * Makes a header-location redirect to an edit form IF POSSIBLE from the passed data - otherwise the window will just close.
	 *
	 * @return	void
	 */
	function main()	{
		$BACK_PATH='../../../../typo3/';
		global $TCA;

		
		
		
		if ($this->doClose)	{
			$this->closeWindow();
		} else {

				// Initialize:
			$table = $this->P['table'];
			$field = $this->P['field'];
			t3lib_div::loadTCA($table);
			$config = $TCA[$table]['columns'][$field]['config'];
			$fTable = $this->P['currentValue']<0 ? $config['neg_foreign_table'] : $config['foreign_table'];
			
			$table_enregistrement = $this->P['params']['table']; // Table où sera créé l'enregistrement
			$champ_enregistrement = $this->P['params']['champ']; // Champ que l'on veut préremplir
			
			
			
			// on vérifie s'il y a bien au moins un enregistrement dans la table que l'on veut lier...

			$tables_a_tester = Array();
			$tables_a_tester = $this->P['params']['lien'];
			
			$enregistrement_possible = false;
			if ($tables_a_tester == Array()){
				$enregistrement_possible = true;
			}
			$message_erreur = '';
			$nb_tables = 0;
			$nb_tables_remplies = 0;
			
			if($enregistrement_possible <> true)
			{
				$premier = true;
				foreach ($tables_a_tester as $table_courante)
				{
					if($premier == true)
					{
						$message_erreur = $table_courante;
						$premier = false;
					}
					else
					{
						$message_erreur = $message_erreur.' AND/OR '.$table_courante;
					}
				
					$select_fields_existance_enregistrement = '*';
					$from_table_existance_enregistrement = $table_courante;
					$where_clause_existance_enregistrement = 'deleted<>1';
					$groupBy_existance_enregistrement = '';
					$orderBy_existance_enregistrement = '';
					$limit_existance_enregistrement = '';
					$tryMemcached_existance_enregistrement = '';

					$res_existance_enregistrement = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select_fields_existance_enregistrement, $from_table_existance_enregistrement, $where_clause_existance_enregistrement, $groupBy_existance_enregistrement, $orderBy_existance_enregistrement, $tryMemcached_existance_enregistrement);
					
					if($row_existance_enregistrement = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res_existance_enregistrement))
					{
						$nb_tables_remplies++;
					}
					$nb_tables++;

				}

				if ($nb_tables_remplies == $nb_tables){
					$enregistrement_possible = true;
				}
				

			}


			if($enregistrement_possible <> true)
			{
				if ($nb_tables ==1){
					echo '<SCRIPT language="Javascript">
						<!--
						alert("'.$message_erreur.' is empty!");
						// -->
						</SCRIPT>';
				}
				else if ($nb_tables >1){
					echo '<SCRIPT language="Javascript">
						<!--
						alert("'.$message_erreur.' are empty!");
						// -->
						</SCRIPT>';
				}


				$this->closeWindow();
			}

			
			

			// On créé l'enregisterment avec notre utilisateur courant
			$tstamp = time();
			
			$insertFields = array(
				'pid' => $this->P['pid'],
				'tstamp' => $tstamp,
				'crdate' => $tstamp,
				$champ_enregistrement => $this->P['uid']
			);
			
			

			$res = $GLOBALS['TYPO3_DB']->exec_INSERTquery($table_enregistrement, $insertFields);

			// On recherche l'enregistrement que l'on vient de créer
			
			$select_fields = '*';
			$from_table = $table_enregistrement;
			$where_clause = '';
			$groupBy = '';
			$orderBy = 'crdate DESC';
			$limit = '';
			$tryMemcached = '';
			
			
			$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select_fields, $from_table, $where_clause, $groupBy, $orderBy, $tryMemcached);

			$row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);

			// Enregistrement à éditer
			$uid = 0;
			$uid = intval($row['uid']);

			if (is_array($config) && $config['type']=='select' && !$config['MM'] && $config['maxitems']<=1 && $fTable && $enregistrement_possible == true)	{	// SINGLE value:
				header('Location: '.t3lib_div::locationHeaderUrl($BACK_PATH.'alt_doc.php?returnUrl='.rawurlencode('wizard_edit.php?doClose=1').'&edit['.$fTable.']['.$uid.']=edit'));
			
			} elseif (is_array($config) && $this->P['currentSelectedValues'] && (($config['type']=='select' && $config['foreign_table']) || ($config['type']=='group' && $config['internal_type']=='db')) && $enregistrement_possible == true)	{	// MULTIPLE VALUES:

					// Init settings:
				$allowedTables = $config['type']=='group' ? $config['allowed'] : $config['foreign_table'].','.$config['neg_foreign_table'];
				$prependName=1;
				$params='';

					// Selecting selected values into an array:
				$dbAnalysis = t3lib_div::makeInstance('t3lib_loadDBGroup');
				$dbAnalysis->start($this->P['currentSelectedValues'],$allowedTables);
				$value = $dbAnalysis->getValueArray($prependName);

					// Traverse that array and make parameters for alt_doc.php:
				foreach($value as $rec)	{
					$recTableUidParts = t3lib_div::revExplode('_',$rec,2);
					$params.='&edit['.$recTableUidParts[0].']['.$recTableUidParts[1].']=edit';
				}
					// Redirect to alt_doc.php:
				header('Location: '.t3lib_div::locationHeaderUrl($BACK_PATH.'alt_doc.php?returnUrl='.rawurlencode('wizard_edit.php?doClose=1').$params));
			
			} else {
				$this->closeWindow();
			}
		}
	}

	/**
	 * Printing a little JavaScript to close the open window.
	 *
	 * @return	void
	 */
	function closeWindow()	{
		echo '<script language="javascript" type="text/javascript">close();</script>';
		exit;
	}
}

// Include extension?
if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/li_gest_membre_labo/wizard/add.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/li_gest_membre_labo/wizard/add.php']);
}






// Make instance:

$SOBE = t3lib_div::makeInstance('tx_ligestmembrelabo_add');

$SOBE->init();
$SOBE->main();
?>