<?php
/**
* Template fields view
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: view.html.php 1139 2010-01-28 18:34:11Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.view' );

/**
* Template fields View
*
* @package CSVIVirtueMart
* @todo redo pagination
 */
class CsvivirtuemartViewTemplateFields extends JView {
	
	/**
	* Templates view display method
	* @return void
	* */
	function display($tpl = null) {
		$mainframe = Jfactory::getApplication();
		
		/* Perform task */
		switch (JRequest::getCmd('task')) {
			case 'addfield':
				$this->get('AddField');
				break;
			case 'savefieldstable':
				$this->get('SaveFieldsTable');
				break;
			case 'deletefield':
				$this->get('DeleteField');
				break;
			case 'renumber':
				$this->get('RenumberFields');
				break;
			case 'publish':
				if ($this->get('SwitchPublishFields')) $mainframe->enqueueMessage(JText::_('Template fields have been published'));
				else $mainframe->enqueueMessage(JText::_( 'Template fields have not been published'), 'error');
				break;
			case 'unpublish':
				if ($this->get('SwitchPublishFields')) $mainframe->enqueueMessage(JText::_('Template fields have been unpublished'));
				else $mainframe->enqueueMessage(JText::_( 'Template fields have not been unpublished'), 'error');
				break;
			case 'saveq':
				if ($this->get('SaveFieldsQ')) $mainframe->enqueueMessage(JText::_('TEMPLATE_FIELDS_HAVE_BEEN_ADDED'));
				else $mainframe->enqueueMessage(JText::_( 'TEMPLATE_FIELDS_HAVE_NOT_BEEN_ADDED'), 'error');
				break;
		}
		
		/* Get data from the model */
        $pagination = $this->get('Pagination');
        
        /* Assign the values */
		$this->assignRef('pagination', $pagination);
        
		/* Show the fields */
		$this->FieldsList();
		
		/* Get the toolbar */
		$this->toolbar();
		
		/* Display it all */
		parent::display($tpl);
	}
	
	/**
	* Displays a toolbar for a specific page
	 */
	function toolbar() {
		if (JRequest::getWord('view') != 'quicktemplatefields') {
			JToolBarHelper::title(JText::_('Template fields'). '::'.$this->template->template_name, 'csvivirtuemart_fields_48');
			JToolBarHelper::custom( 'templates', 'csvivirtuemart_templates_32', 'csvivirtuemart_templates_32', JText::_('Templates'), false);
			JToolBarHelper::custom( 'quickadd', 'csvivirtuemart_add_32', 'csvivirtuemart_add_32', JText::_('QUICK_ADD_TEMPLATE'), false);
			JToolBarHelper::custom( 'publish', 'csvivirtuemart_publish_32', 'csvivirtuemart_publish_32', JText::_('Publish'), true);
			JToolBarHelper::custom( 'unpublish', 'csvivirtuemart_unpublish_32', 'csvivirtuemart_unpublish_32', JText::_('Unpublish'), true);
			JToolBarHelper::custom( 'savefieldstable', 'csvivirtuemart_save_32', 'csvivirtuemart_save_32', JText::_('Save'), false);
			JToolBarHelper::custom( 'deletefield', 'csvivirtuemart_delete_32', 'csvivirtuemart_delete_32', JText::_('Delete'), false);
		}
		else {
			JToolBarHelper::title(JText::_('QUICK_ADD_TEMPLATE_FIELDS'). '::'.$this->template->template_name, 'csvivirtuemart_fields_48');
			JToolBarHelper::custom('saveq', 'csvivirtuemart_save_32', 'csvivirtuemart_save_32', JText::_('Save'), false);
			JToolBarHelper::custom('cancel', 'csvivirtuemart_cancel_32', 'csvivirtuemart_cancel_32', JText::_('Cancel'), false);
		}
	}
	
	/**
	* Show a list of templates limited by the limit settings
	*
	* @author RolandD
	*/
	public function FieldsList() {
		$mainframe = JFactory::getApplication();
		
		/* Get the template ID */
		$template_id = JRequest::getInt('template_id', 0);
		
		if ($template_id > 0) {
			/* Load template model */
			$template_model = $this->getModel('templates');
			
			/* Set the template ID */
			$template_model->setTemplateId($template_id);
			
			/* Get the current template */
			$template = $template_model->getTemplate();
			
			/* Get the supported fields for the template */
			$availablefields_model = $this->getModel('availablefields');
			$csvisupportedfields = $availablefields_model->GetAvailableFields($template->template_type);
			$csvifields = array();
			foreach ($csvisupportedfields as $key => $fieldname) {
				$csvifields[] = JHTML::_('select.option', $fieldname, $fieldname);
			}
			
			/* Get the fields for the active template */
			/* See if we need to filter the result */
			$filter = JRequest::getVar('filterfield', false);
			$fields = $template_model->GetFields($template_id, $filter);
			
			/* Assign the data so it can be displayed */
			$this->assignRef('template_id', $template_id);
			$this->assignRef('template', $template);
			$this->assignRef('csvisupportedfields', $csvifields);
			$this->assignRef('filter', $filter);
			$this->assignRef('fields', $fields);
			$this->assignRef('totalfields', $template_model->getNextFieldNumber());
		}
		else $mainframe->enqueueMessage(JText::_('No template found'));
	}
	
	/**
	* Delete selected field from the selected template
	*/
	function DeleteField() {
		$mainframe = Jfactory::getApplication();
		
		/* Get the field id */
		$fields = JRequest::getVar('cid');
		
		/* Execute query */
		$return = CsvivirtuemartModelTemplates::DeleteConfigField($fields[0]);
		
		if ($return) $mainframe->enqueueMessage(JText::_('Template field has been deleted'));
		else $mainframe->enqueueMessage(JText::_('Not able to delete template field').'<br />'.CsviLog::GetLogMessage(), 'error');
	}
}
?>
