<?php
/**
* Available Fields view
*
* Gives an overview of all available fields that can be used for import/export
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
* Available Fields View
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartViewAvailableFields extends JView {
	
	/**
	* About view display method
	* @return void
	*/
	function display($tpl = null) {
		$mainframe = Jfactory::getApplication();
		$option	= JRequest::getCmd('option');
		
		/* Load the filters */
		$list['filter_order']		= $mainframe->getUserStateFromRequest('availablefields.filter_order',		'filter_order',		'',	'cmd');
		$list['filter_order_Dir']	= $mainframe->getUserStateFromRequest('availablefields.filter_order_Dir',	'filter_order_Dir',	'',	'word');
		$list['filter_state']		= $mainframe->getUserStateFromRequest('availablefields.filter_state',		'filter_state',		'',	'word');
		$list['searchtemplatetype']		= $mainframe->getUserStateFromRequest('availablefields.searchtemplatetype',	'searchtemplatetype',	'',	'word');
		
		/* Get data from the model */
        $pagination = $this->get('Pagination');
		
		/* Get the list of available fields */
		$availablefields = $this->get('Data');
		
		/* Get the list of template types */
		$template_types = $this->get('TemplateTypes', 'templates');
		
		/* Add a show all */
		$showall = JHTML::_('select.option', '', JText::_('SHOW_ALL'), 'name', 'value');
		array_unshift($template_types, $showall);
		$list['templatetypes'] = JHTML::_('select.genericlist', $template_types, 'searchtemplatetype', '', 'name', 'value', $list['searchtemplatetype']);
		
		/* Assign the data */
		$this->assignRef('availablefields', $availablefields);
		$this->assignRef('list', $list);
		$this->assignRef('pagination', $pagination);
		
		/* Show the toolbar */
		$this->toolbar();
		
		/* Display it all */
		parent::display($tpl);
	}
	
	/**
	* Display the toolbar
	 */
	public function toolbar() {
		JToolBarHelper::title(JText::_('AVAILABLEFIELDS'), 'csvivirtuemart_availablefields_48');
	}
}
?>