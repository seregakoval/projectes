<?php
/**
* Templates view
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: view.html.php 1118 2010-01-04 11:39:59Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.view' );
jimport('joomla.html.pane');

/**
* Templates View
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartViewTemplates extends JView {
	/**
	* Templates view display method
	* @return void
	* */
	function display($tpl = null) {
		$task = JRequest::getCmd('task');
		switch ($task) {
			/* Creating a new template */
			case 'newtemplate':
			/* Editing an existing template */
			case 'edittemplate':
				$this->TemplateConfigurator();
				break;
			/* Default show the list of templates */
			default:
				/* Saving a new template */
				switch ($task) {
					case 'save':
						$this->get('SaveTemplate');
						break;
					/* Clone selected template */
					case 'clonetemplate':
						$this->CloneTemplate();
						break;
					/* Delete selected template */
					case 'deletetemplate':
						$this->DeleteTemplate();
						break;
				}
				$mainframe = Jfactory::getApplication();
				
				/* Load the filters */
				$lists['filter_order']		= $mainframe->getUserStateFromRequest('templateslist.filter_order',		'filter_order',		'',	'cmd');
				$lists['filter_order_Dir']	= $mainframe->getUserStateFromRequest('templateslist.filter_order_Dir',	'filter_order_Dir',	'',	'word');
				$lists['filter_state']		= $mainframe->getUserStateFromRequest('templateslist.filter_state',		'filter_state',		'',	'word');
				$lists['templatetype']		= $mainframe->getUserStateFromRequest('templateslist.templatetype',	'templatetype',	'',	'word');
				
				$templatetypes = array();
				/* Add a dont use option */
				$templatetype = new StdClass();
				$templatetype->template_code = '';
				$templatetype->template_name = JText::_('ALL');
				$templatetypes[] = $templatetype;
				$templatetype = new StdClass();
				$templatetype->template_code = 'import';
				$templatetype->template_name = JText::_('IMPORT');
				$templatetypes[] = $templatetype;
				$templatetype = new StdClass();
				$templatetype->template_code = 'export';
				$templatetype->template_name = JText::_('EXPORT');
				$templatetypes[] = $templatetype;
				$lists['templatetypes'] = JHTML::_('select.genericlist', $templatetypes, 'templatetype', '' , 'template_code', 'template_name', $lists['templatetype']);
				$this->assignRef('lists', $lists);
				$this->TemplateList();
				break;
		}
		
		/* Get the toolbar */
		$this->toolbar();
		
		/* Display it all */
		parent::display($tpl);
	}
	
	/**
	* Displays a toolbar for a specific page
	 */
	function toolbar() {
		switch (JRequest::getCmd('task')) {
			case 'newtemplate':
				JToolBarHelper::title(JText::_('New template'), 'csvivirtuemart_new_48');
				JToolBarHelper::custom('save', 'csvivirtuemart_save_32', 'csvivirtuemart_save_32', JText::_('Save'), false);
				JToolBarHelper::custom('cancel', 'csvivirtuemart_cancel_32', 'csvivirtuemart_cancel_32', JText::_('Cancel'), false);
				break;
			case 'edittemplate':
				JToolBarHelper::title(JText::_('Edit template').'::'.$this->template->template_name, 'csvivirtuemart_edit_48');
				JToolBarHelper::custom('save', 'csvivirtuemart_save_32', 'csvivirtuemart_save_32', JText::_('Save'), false);
				JToolBarHelper::custom('cancel', 'csvivirtuemart_cancel_32', 'csvivirtuemart_cancel_32', JText::_('Cancel'), false);
				break;
			default:
				JToolBarHelper::title(JText::_('Templates'), 'csvivirtuemart_templates_48');
				JToolBarHelper::custom('newtemplate', 'csvivirtuemart_new_32', 'csvivirtuemart_new_32', JText::_('New'), false);
				JToolBarHelper::custom('edittemplate', 'csvivirtuemart_edit_32', 'csvivirtuemart_edit_32', JText::_('Edit'), true);
				JToolBarHelper::custom('clonetemplate', 'csvivirtuemart_clone_32', 'csvivirtuemart_clone_32', JText::_('Clone'), true);
				JToolBarHelper::custom('deletetemplate', 'csvivirtuemart_delete_32', 'csvivirtuemart_delete_32', JText::_('Delete'), true);
				JToolBarHelper::divider();
				JToolBarHelper::custom('fieldstemplate', 'csvivirtuemart_fields_32', 'csvivirtuemart_fields_32', JText::_('Fields'), true);
				break;
		}
	}
	
	/**
	* Show a list of templates limited by the limit settings
	 */
	function TemplateList() {
		$mainframe = Jfactory::getApplication();
		$option	= JRequest::getCmd('option');
		
		/* Get data from the model */
        $pagination = $this->get('Pagination');
		
		/* Create an array of templates */
		$rawtemplateslist = $this->get('Data');
		$templateslist = new stdClass();
		
		if (count($rawtemplateslist) < 1 
			&& (!JRequest::getWord('templatetype', false)
			|| !JRequest::getWord('filter_templates', false))
			) { 
				JError::raiseNotice(0, JText::_('NO_TEMPLATES_DEFINED'));
			}
		else if (count($rawtemplateslist) < 1 
			&& (JRequest::getWord('templatetype', false)
			|| JRequest::getWord('filter_templates', false))
			) {
				JError::raiseNotice(0, JText::_('NO_TEMPLATES_FOUND'));
			}
		else {
			$template_model = $this->getModel('templates');
			foreach ($rawtemplateslist as $id => $details) {
				$templateslist->$id->name = $details->template_name;
				$templateslist->$id->type = $details->template_type;
				$templateslist->$id->id = $details->template_id;
				/* Set the template ID */
				$template_model->setTemplateId($details->template_id);
				$templateslist->$id->nrfields = $this->get('NumberOfFields');
			}
		}
		
		/* Assign the data so it can be displayed */
		$this->assignRef('templateslist', $templateslist);
		$this->assignRef('pagination', $pagination);
	}
	
	/**
	* Template configurator
	 */
	function TemplateConfigurator() {
		
		/* Get the task */
		$task = JRequest::getCmd('task');
		
		/* Get the template ID */
		$template_id = JRequest::getInt('template_id', 0);
		
		/* Load template model */
		$template_model = $this->getModel('templates');
		
		/* Set the template ID */
		if ($template_id > 0) $template_model->setTemplateId($template_id);
		
		if ($task != 'newtemplate') {
			/* Get the template details */
			$template = $this->get('Template');
		}
		else if ($task == 'newtemplate') {
			/* For new templates load an empty template */
			$template = $this->get('EmptyTemplate');
			$template->setStandardValues();
		}
		
		/* Get the template type */
		$options = array();
		$options[] = JHTML::_('select.option', 'import', 'IMPORT');
		$options[] = JHTML::_('select.option', 'export', 'EXPORT');
		$selected = stristr($template->template_type, 'export') ? 'export' : 'import';
		$lists['template_type'] = JHTML::_('select.radiolist',  $options, 'type', null, 'value', 'text', $selected, true, true);
		
		/* Auto detect delimiters */
		$lists['auto_detect_delimiters'] = JHTML::_('select.booleanlist', 'auto_detect_delimiters', 'id="auto_detect_delimiters"', $template->auto_detect_delimiters);
		
		/* Get the supported fields */
		$templatetypes = $template_model->getTemplateTypes('import');
		$lists['importtypes'] = JHTML::_('select.genericlist', $templatetypes, 'template_type_import', '' , 'name', 'value', $template->template_type, false, true);
		$templatetypes = $template_model->getTemplateTypes('export');
		$lists['exporttypes'] = JHTML::_('select.genericlist', $templatetypes, 'template_type_export', '' , 'name', 'value', $template->template_type, false, true);
		
		/* Get the thumbnail formats */
		$options = array();
		$options[] = JHTML::_('select.option', 'none', 'DEFAULT');
		$options[] = JHTML::_('select.option', 'jpg', 'JPG');
		$options[] = JHTML::_('select.option', 'png', 'PNG');
		$options[] = JHTML::_('select.option', 'gif', 'GIF');
		
		$lists['thumbnailformat'] = JHTML::_('select.genericlist', $options, 'thumb_extension', null , 'value', 'text', $template->thumb_extension, false, true);
		array_shift($options);
		$lists['autogenerateext'] = JHTML::_('select.genericlist', $options, 'auto_generate_image_name_ext', null , 'value', 'text', $template->auto_generate_image_name_ext, false, true);
		
		/* Get the VirtueMart ID's */
		$vm_itemids = $this->get('VmItemids');
		if (count($vm_itemids) == 0) {
			$vm_itemids[] = JHTML::_('select.option', '1', 'DEFAULT');
		}
		$lists['vm_itemid'] = JHTML::_('select.genericlist', $vm_itemids, 'vm_itemid', null , 'value', 'text', $template->vm_itemid, false, true);
		
		/* Export frontend */
		$lists['export_frontend'] = JHTML::_('select.booleanlist', 'export_frontend', null, $template->export_frontend);
		
		/* Get the shopper groups */
		$shopper_groups = $this->get('shoppergroups');
		
		/* Get the shopper groups */
		$manufacturers = $this->get('manufacturers');
		
		/* Load the editor */
		$editor = JFactory::getEditor();
		
		/* Assign the data so it can be displayed */
		$this->assignRef('task', $task);
		$this->assignRef('template', $template);
		$this->assignRef('lists', $lists);
		$this->assignRef('shopper_groups', $shopper_groups);
		$this->assignRef('manufacturers', $manufacturers);
		$this->assignRef('editor', $editor);
		 
	}
	
	/**
	* Clone an existing template
	*
	* Creates a copy of an existing template and gives it the same name with
	* a timestamp added to it. The fields are also duplicated.
	 */
	function CloneTemplate() {
		global $mainframe, $option;
		
		/* Get the template ID */
		$template_id = JRequest::getCmd('template_id');
		
		/* Load template model */
		$template_model = $this->getModel('templates');
		
		/* Set the template ID */
		if ($template_id > 0) {
			$template_model->setTemplateId($template_id);
			$this->get('CloneTemplate');
		}
		else $mainframe->enqueueMessage(JText::_('No template ID found to clone'));
	}
	
	/**
	* Delete an existing template
	 */
	function DeleteTemplate() {
		global $mainframe, $option;
		
		/* Get the template ID */
		$template_id = JRequest::getCmd('template_id');
		
		/* Set the template ID */
		if ($template_id > 0) {
			/* Load template model */
			$template_model = $this->getModel('templates');
			$template_model->setTemplateId($template_id);
			$this->get('DeleteTemplate');
		}
		else $mainframe->enqueueMessage(JText::_('No template ID found to delete'));
	}
}
?>