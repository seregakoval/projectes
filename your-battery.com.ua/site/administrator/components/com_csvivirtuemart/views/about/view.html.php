<?php
/**
* About view
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: view.html.php 1117 2010-01-01 21:39:52Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.view' );

/**
* Templates View
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartViewAbout extends JView {
	
	/**
	* About view display method
	* @return void
	* */
	function display($tpl = null) {
		
		/* Get the helper files */
		JView::loadHelper('subscription_check');
		
		$check = new SubscriptionCheck;
		$result = $check->CheckKey(JRequest::getVar('hostname'));
		
		/* Assign the values */
		$this->assignRef('result', $result['result']);
		$this->assignRef('expiredate', $result['uxdate']);
		$this->assignRef('hostname', $result['hostname']);
		
		/* Show the toolbar */
		$this->toolbar();
		
		/* Display it all */
		parent::display($tpl);
	}
	
	/**
	* Displays a toolbar for a specific page
	 */
	function toolbar() {
		JToolBarHelper::title(JText::_('About'), 'csvivirtuemart_about_48');
	}
}
?>