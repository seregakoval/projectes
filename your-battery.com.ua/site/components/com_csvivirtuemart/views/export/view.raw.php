<?php
/**
* Export view
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 Roland Dalmulder
* @version $Id: view.raw.php 1117 2010-01-01 21:39:52Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.view' );

/**
* Export View
*
* @todo Check if export template is allowed
* @todo Check if template is export template
* @package CSVIVirtueMart
 */
class CsvivirtuemartViewExport extends JView {
	/**
	* Production view display method
	* @return void
	* */
	function display($tpl = null) {
		global $mainframe, $option;
		/* Get the task to work on */
		$task = JRequest::getCmd('task');
		
		/* Perform the task needed */
		switch ($task) {
			default:
				/* Load template model */
				$template_model = $this->getModel('templates');
				
				/* Set the template ID */
				$template_model->setTemplateId(JRequest::getCmd('template_id', 0));
				$template = $this->get('Template', 'templates');
				
				/* Get the logger class */
				JView::addHelperPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers');
				JView::loadHelper('csvi_class_log');
				$csvilog = new CsviLog();
				JRequest::setVar('csvilog', $csvilog);
				
				/* Load the settings */
				$settings_model = $this->getModel('settings');
				
				/* Set some log info */
				$csvilog->SetAction('export');
				$csvilog->SetActionType($template->template_type, $template->template_name);
				
				/* Check if this template can be exported from frontend */
				if (!$template->export_frontend || strtolower(substr($template->template_type, -6)) != 'export') {
					$csvilog->AddStats('incorrect', JText::_('NO_EXPORT_ALLOWED'));
					JRequest::setVar('logcount', array('export' => 0));
					
					/* Store the log results */
					if ($settings_model->getSetting('log_store')) $this->get('StoreLogResults', 'log');
				}
				else {
					/* Make the template global available */
					JRequest::setVar('template', $template);
					
					/* Load replacement model */
					$replacement_model = $this->getModel('replacement');
					
					/* Get some global details for the export */
					$this->ExportDetails();
					
					/* Load some basic data */
					$export_fields = JRequest::getVar('exportfields');
					
					/* Only start the export if there are any fields to export */
					if (count($export_fields) > 0) {
						/* Add extra helper paths */
						JView::addHelperPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'xml');
						JView::addHelperPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'html');
						
						/* Load the helper classes */
						JView::loadHelper('csvidb');
						JView::loadHelper('vm_config');
						
						/* Check if tab delimiter needs to be used */
						if (strtolower($template->field_delimiter) == 't') $template->field_delimiter = "\t";
						
						/* See if we need to get an XML class */
						if ($template->export_type == 'xml' || $template->export_type == 'html') {
							$exportclass = $this->getClass();
						}
						
						/* Start the output */
						$this->get('OutputStart');
						
						$contents = '';
						if ($template->export_type == 'xml') {
							$contents .= $exportclass->HeaderText();
						}
						else if ($template->export_type == 'html') {
							$contents .= $exportclass->HeaderText();
							if ($template->include_column_headers && strtolower($template->template_type) != 'producttypenamesexport') {
								$contents .= $exportclass->StartTableHeaderText();
								foreach ($export_fields as $column_id => $field) {
									$contents .= $exportclass->TableHeaderText($field->column_header);
								}
								$contents .= $exportclass->EndTableHeaderText();
							}
							$contents .= $exportclass->BodyText();
						}
						else {
							/* See if the user wants column headers */
							/* Product type names export needs to be excluded here otherwise the column headers are incorrect */
							if ($template->include_column_headers && strtolower($template->template_type) != 'producttypenamesexport') {
								foreach ($export_fields as $column_id => $field) {
									$contents .= $template->text_enclosure.$field->column_header.$template->text_enclosure.$template->field_delimiter;
								}
								if ($template->include_column_headers) $contents = substr($contents, 0 , -1);
								
								/* No extra line for Product Type Names Export */
								$contents .= "\r\n";
							}
						}
						
						/* Output content */
						CsvivirtuemartModelExportfile::writeOutput($contents);
						
						/* Start the export from the chosen template type */
						$this->get('Start', $template->template_type);
						
						if ($template->export_type == 'xml' || $template->export_type == 'html') {
							echo $exportclass->FooterText();
						}
						
						/* Store the log results */
						if ($settings_model->getSetting('log_store')) $this->get('StoreLogResults', 'log');
						
						/* End the export */
						$this->get('OutputEnd');
					}
					else {
						$csvilog->AddStats('incorrect', JText::_('NO_EXPORT_FIELDS'));
						JRequest::setVar('logcount', array('export' => 0));
						
						/* Store the log results */
						if ($settings_model->getSetting('log_store')) $this->get('StoreLogResults', 'log');
					}
				}
			}
				
		/* Display it all */
		//parent::display($tpl);
	}
	
	/**
	* Get some basic details for the export
	 */
	private function ExportDetails() {
		JRequest::setVar('exportfields', $this->get('ExportFields', 'exportfile'));
		JRequest::setVar('exportto', 'todownload');
	}
	
	/**
	* Initiliase and export details
	*
	* @todo add check if class really exists
	* @return bool true|false true when xml class is found|false when when no site is given
	 */
	public function getClass() {
		$template = JRequest::getVar('template');
		$csvilog = JRequest::getVar('csvilog');
		$exportclass = false;
		
		switch ($template->export_type) {
			case 'html':
				JView::loadHelper('csvi_class_html');
				$exportclass = new CsviExportHtml();
				break;
			case 'xml':
				if (strlen($template->export_site) > 0) {
					switch ($template->export_site) {
						case 'csvi':
							JView::loadHelper('csvi_class_xml');
							$exportclass = new CsviXmlExport();
							break;
						case 'beslist':
							JView::loadHelper('csvi_class_xml_beslist');
							$exportclass = new CsviXmlBeslist();
							break;
						case 'froogle':
							JView::loadHelper('csvi_class_xml_froogle');
							$exportclass = new CsviXmlFroogle();
							break;
						case 'oodle':
							JView::loadHelper('csvi_class_xml_oodle');
							$exportclass = new CsviXmlOodle();
							break;
						default:
							$csvilog->AddStats('incorrect', JText::_("NO_XML_CLASS_FOUND"));
							return false;
							break;
					}
				}
				break;
		}
		if ($exportclass) JRequest::setVar('exportclass', $exportclass);
		return $exportclass;
	}
}
?>