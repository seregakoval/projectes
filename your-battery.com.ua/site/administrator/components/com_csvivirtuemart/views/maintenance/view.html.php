<?php
/**
* Maintenance view
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
class CsvivirtuemartViewMaintenance extends JView {
	
	/**
	* About view display method
	* @todo Add result to log screen
	* */
	function display($tpl = null) {
		$mainframe = Jfactory::getApplication();
		$document = JFactory::getDocument();
		$document->addScript($mainframe->getSiteURL().'administrator/components/com_csvivirtuemart/assets/js/jquery.alphanumeric.js');
		/* Get the logger class */
		JView::loadHelper('csvi_class_log');
		$csvilog = new CsviLog();
		$import_id = $csvilog->setImportId();
		JRequest::setVar('import_id', $import_id);
		JRequest::setVar('csvilog', $csvilog);
		
		$operation = JRequest::getVar('operation');
		if (!is_array($operation)) $operation = (array)$operation;
		
		if (array_key_exists('0', $operation)) {
			$csvilog->SetAction('Maintenance');
			switch(strtolower($operation[0])) {
				case 'emptydatabase':
					$csvilog->SetActionType('EmptyDatabase');
					$this->get('EmptyDatabase');
					break;
				case 'removeorphan':
					$csvilog->SetActionType('RemoveOrphan');
					$this->get('RemoveOrphan');
					break;
				case 'optimizetables':
					$csvilog->SetActionType('OptimizeTables');
					$this->get('OptimizeTables');
					break;
				case 'sortcategories':
					$csvilog->SetActionType('SortCategories');
					$this->get('SortCategories');
					break;
				case 'updateavailablefields':
					$csvilog->SetActionType('UpdateAvailableFields');
					$this->get('FillAvailableFields', 'Availablefields');
					break;
				case 'resizeproductname':
					$csvilog->SetActionType('ResizeProductName');
					$this->get('ResizeProductName');
					break;
				case 'exchangerates':
					$csvilog->SetActionType('ExchangeRates');
					$this->get('ExchangeRates');
					break;
				case 'removeemptycategories':
					$csvilog->SetActionType('RemoveEmptyCategories');
					$this->get('RemoveEmptyCategories');
					break;
				case 'installdefaulttemplates':
					$csvilog->SetActionType('InstallDefaultTemplates');
					$this->get('InstallDefaultTemplates');
					break;
				case 'cleancache':
					$csvilog->SetActionType('CleanCache');
					$this->get('CleanCache');
					break;
			}
			$this->get('StoreLogResults', 'log');
		}
		$this->assignRef('sizeproductname', $this->get('SizeProductName'));
		
		/* Load the results */
		$logresult = $this->get('Stats', 'log');
		$logmessage = $this->get('StatsMessage', 'log');
		$this->assignRef('logresult', $logresult);
		$this->assignRef('logmessage', $logmessage);
		
		/* Show the toolbar */
		$this->toolbar();
		
		/* Display it all */
		parent::display($tpl);
	}
	
	/**
	* Displays a toolbar for a specific page
	 */
	function toolbar() {
		JToolBarHelper::title(JText::_('Maintenance'), 'csvivirtuemart_maintenance_48');
		if (!JRequest::getBool('boxchecked')) JToolBarHelper::custom('maintenance', 'csvivirtuemart_continue_32.png', 'csvivirtuemart_continue_32.png', JText::_('CONTINUE'), true );
	}
}
?>
