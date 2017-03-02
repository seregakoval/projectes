<?php
/**
* Import view
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: view.json.php 1117 2010-01-01 21:39:52Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.view' );

/**
* Import View
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartViewExport extends JView {
	
	/**
	* Templates view display method
	* @return void
	* */
	function display($tpl = null) {
		switch (JRequest::getVar('task')) {
			case 'getuser':
				$users = $this->get('OrderUser');
				echo json_encode($users);
				break;
			case 'getproduct':
				$products = $this->get('OrderProduct');
				echo json_encode($products);
				break;
			default:
				break;
		}
	}
}
?>