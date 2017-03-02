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
class CsvivirtuemartViewImport extends JView {
	
	/**
	* Templates view display method
	* @return void
	* */
	function display($tpl = null) {
		$task = JRequest::getVar('task', 'import');
		if ($task == 'finished') {
			/* Load the results */
			$logresult = $this->get('Stats', 'log');
			
			/* Assign the data */
			$this->assignRef('logresult', $logresult);
			
			/* Get the toolbar title */
			JToolBarHelper::title(JText::_( 'IMPORT_RESULT' ), 'csvivirtuemart_import_48');
		}
		else {
			/* Show the import settings screen */
			$templates = $this->get('TemplatesListImport', 'templates');
			
			/* Get the toolbar title */
			JToolBarHelper::title(JText::_( 'Import' ), 'csvivirtuemart_import_48');
			
			if (count($templates) < 1) {
				$error = JError::getError();
				if (!is_object($error)) {
					JError::raiseWarning(0, JText::_('No import templates defined'));
				}
			}
			else {
				/* Assign the data */
				$this->assignRef('templates', $templates);
				
				/* Get the toolbar */
				JToolBarHelper::custom( 'importfile', 'csvivirtuemart_import_32', 'csvivirtuemart_import_32', JText::_('Import'), false);
			}
		}
		/* Display it all */
		parent::display($tpl);
	}
}
?>
