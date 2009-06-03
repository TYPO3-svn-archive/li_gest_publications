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

/**
 *
 *   46: class tx_ligestpublications_annee
 *   52: function returnFieldJS()
 *   69: function evaluateFieldValue($value, $is_in, &$set)
 *
 * TOTAL FUNCTIONS: 2
 *
 */

 
/**
 * Plugin 'Managing Publication' for the 'tx_ligestpublications' extension.
 * Teste de la présence d'une date dans un formulaire
 * 
 * @author Bruno Gallet <gallet.bruno@gmail.com>
 * @package TYPO3
 * @subpackage tx_ligestpublications
 */


class tx_ligestpublications_annee {

	/**
	 * Teste du champ lors de la validation du formulaire
	 * On teste si le champ est bien rempli
	 * Sinon si le champ date de fin possède une date, on y met la la même année
	 * @param $value Valeur du champ
	 * @return Retourne la nouvelle valeur du champ
	 */
	function evaluateFieldValue($value, $is_in, &$set) {
		$date=$value;
		if($date=='' || $date=='0')
		{

			$uid='0';
			foreach($_POST['data']['tx_ligestpublications_Publication'] as $id =>$idvalue)
			{
				$uid=$id;
			}
			if($uid<>'0')
			{
				//Création de requête
				$select_fields = 'tx_ligestpublications_Publication.DateFin, tx_ligestpublications_Publication.DateDebut';
				$from_table = 'tx_ligestpublications_Publication';
				$where_clause = 'tx_ligestpublications_Publication.uid='.$uid;
				$groupBy = '';
				$orderBy = '';
				$limit = '';

				$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select_fields, $from_table, $where_clause, $groupBy, $orderBy, $limit);

				if($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res))
				{
					$dateFin_explosee = explode("-", $row['DateFin']);

					$anneeFin = (int)$dateFin_explosee[0];
					
					if($anneeFin<>'0000' && $anneeFin<>'')
					{
						$date = $anneeFin;
					}
				}
			}
	
		}

		return $date;
	}

	
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/li_gest_publications/class.tx_ligestpublications_annee.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/li_gest_publications/class.tx_ligestpublications_annee.php']);
}

?>