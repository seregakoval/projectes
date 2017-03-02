<?php
/**
* Replacement view
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: view.json.php 1138 2010-01-27 22:54:36Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.view' );

/**
* Replacement View
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartViewReplacement extends JView {
	
	/**
	* Templates view display method
	* @return void
	* */
	function display($tpl = null) {
		switch (JRequest::getVar('task')) {
			case 'remove':
				$result = $this->get('RemoveReplacement');
				break;
			case 'publish':
				$result = $this->get('SwitchPublish');
				break;
			case 'loadfields':
				$result = $this->get('LoadFields');
				break;
			default:
				break;
		}
		/* Send the result */
		echo json_encode($result);
	}
}
?>