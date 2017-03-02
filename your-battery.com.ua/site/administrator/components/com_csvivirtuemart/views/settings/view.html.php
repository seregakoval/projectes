<?php
/**
* Settings view
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: view.html.php 1128 2010-01-11 18:36:29Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.view' );

/**
* Settings View
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartViewSettings extends JView {
	
	/**
	* About view display method
	* @return void
	* */
	function display($tpl = null) {
		/* Load some behaviour */
		jimport('joomla.html.pane');
		$pane = JPane::getInstance('tabs'); 
		JHTML::_('behavior.tooltip'); 
		
		/* Load the settings */
		$paramsdata = $this->get('Settings');
		$paramsdefs = JPATH_COMPONENT_ADMINISTRATOR.DS.'views'.DS.'settings'.DS.'config.xml';
		$params = new JParameter( $paramsdata, $paramsdefs );
		
		/* Assign the values */
		$this->assignRef('pane', $pane);
		$this->assignRef('params', $params);
		
		/* Show the toolbar */
		JToolBarHelper::title(JText::_('SETTINGS_TITLE'), 'csvivirtuemart_settings_48');
		JToolBarHelper::custom('save', 'csvivirtuemart_save_32', 'csvivirtuemart_save_32', JText::_('Save'), false);
		
		/* Display it all */
		parent::display($tpl);
	}
}
?>