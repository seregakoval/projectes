<?php
/**
* Replacement view
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: view.html.php 1138 2010-01-27 22:54:36Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.view' );

/**
* Templates View
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartViewReplacement extends JView {
	
	/**
	* About view display method
	* @return void
	* */
	function display($tpl = null) {
		
		/* Perform some task first */
		switch (JRequest::getCmd('task')) {
			case 'save':
				$this->get('SaveReplacement');
				break;
			case 'remove_all':
				$this->get('RemoveReplacement');
				break;
		}
		
		/* Load the replacement table */
		$replacements = $this->get('Data');
		
		/* Get the filter */
		$filter = JRequest::getVar('filterfield', false);
		
		/* Get the pagination */
        $pagination = $this->get('Pagination');
        
        /* Set the regex options */
        $regex_options[] = JHTML::_('select.option', '1', JText::_('REPLACEMENT_REGEX'));
		$regex_options[] = JHTML::_('select.option', '0', JText::_('REPLACEMENT_REGULAR'));
        
		/* Get the templates */
		JRequest::setVar('templatetype', 'export');
		$templates = $this->get('Data', 'templates');
		
		/* Get the template fields */
		$template_fields = array();
		$model = $this->getModel();
		foreach ($templates as $template) {
			if (!array_key_exists($template->template_id, $template_fields)) {
				$template_fields[$template->template_id] = $model->getLoadFields($template->template_id);
			}
		}
		
		/* Assign the values */
		$this->assignRef('replacements', $replacements);
        $this->assignRef('pagination', $pagination);
		$this->assignRef('filter', $filter);
		$this->assignRef('regex_options', $regex_options);
		$this->assignRef('templates', $templates);
		$this->assignRef('template_fields', $template_fields);
		
		/* Show the toolbar */
		$this->toolbar();
		
		/* Display it all */
		parent::display($tpl);
	}
	
	/**
	* Displays a toolbar for a specific page
	 */
	function toolbar() {
		JToolBarHelper::title(JText::_('REPLACEMENT'), 'csvivirtuemart_replacement_48');
		JToolBarHelper::custom('save', 'csvivirtuemart_save_32', 'csvivirtuemart_save_32', JText::_('SAVE'), false);
		JToolBarHelper::custom('remove_all', 'csvivirtuemart_delete_32', 'csvivirtuemart_delete_32', JText::_('DELETE'), true);
	}
}
?>