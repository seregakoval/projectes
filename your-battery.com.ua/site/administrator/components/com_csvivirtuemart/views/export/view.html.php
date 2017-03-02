<?php
/**
* Import view
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
		/* Show the export settings screen */
		$templates = $this->get('TemplatesListExport', 'templates');
		
		/* Toolbar title */
		JToolBarHelper::title(JText::_( 'Export' ), 'csvivirtuemart_export_48');
		if (count($templates) < 1) {
			$error = JError::getError();
			if (!is_object($error)) {
				JError::raiseWarning(0, JText::_('NO_EXPORT_TEMPLATES_DEFINED'));
			}
		}
		else {
			/* Toolbar buttons */
			/* Check if we can show the export button */
			if ($this->get('CountTemplateFields')) {
				JToolBarHelper::custom( 'cronline', 'csvivirtuemart_cron_32', 'csvivirtuemart_cron_32', JText::_('CRONLINE'), false);
				JToolBarHelper::custom( 'exportfile', 'csvivirtuemart_export_32', 'csvivirtuemart_export_32', JText::_('EXPORT'), false);
			}
			
			/* Assign the data */
			$this->assignRef('templates', $templates);
			
			/* Display it all */
			parent::display($tpl);
		}
	}
}
?>