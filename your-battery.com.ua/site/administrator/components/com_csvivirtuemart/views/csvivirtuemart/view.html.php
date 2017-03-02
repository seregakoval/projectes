<?php
/**
* Default view
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
* Default View
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartViewCsvivirtuemart extends JView {
	/**
	* CSV Improved view display method
	*
	* @return void
	* */
	function display($tpl = null) {
		/* Show the toolbar */
		$this->toolbar();
		
		/* Assign data for display */
	    $this->assignRef('cpanel_images', $this->get('Buttons'));
		
		/* Display the page */
		parent::display($tpl);
	}
	
	function toolbar() {
		JToolBarHelper::title(JText::_('CSVI_VIRTUEMART_CONTROL_PANEL'), 'csvivirtuemart_logo_48.png' );
	}
}
?>
