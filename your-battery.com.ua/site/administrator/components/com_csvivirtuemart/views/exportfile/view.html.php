<?php
/**
* Export file view
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
* Export file View
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartViewExportfile extends JView {
	
	/**
	* Templates view display method
	*
	* @todo Handle not loading of XML file
	* @return void
	* */
	public function display($tpl = null) {
		/* Load template model */
		$template_model = $this->getModel('templates');
		
		/* Set the template ID */
		$template_model->setTemplateId(JRequest::getCmd('template_id', 0));
		$template = $this->get('Template', 'templates');
			
		/* Check what task we are doing */
		if (JRequest::getWord('task') == 'cronline') {
			
			/* The basics of the cronline */
			$cronline = 'php "'.JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'cron.php" username="" passwd="" template_name="'.$template->template_name.'" ';
			
			/* Start the export from the chosen template type */
			$cronline .= $this->get('CronLine');
			
			$this->assignRef('cronline', $cronline);
			JToolBarHelper::title(JText::_('EXPORT'), 'csvivirtuemart_export_48');
		}
		else {
			/* Load the settings */
			$settings_model = $this->getModel('settings');
			
			/* Make the template global available */
			JRequest::setVar('template', $template);
			
			/* Get the logger class */
			JView::loadHelper('csvi_class_log');
			$csvilog = new CsviLog();
			$import_id = $csvilog->setImportId();
			JRequest::setVar('import_id', $import_id);
			JRequest::setVar('csvilog', $csvilog);
			
			/* Load replacement model */
			$replacement_model = $this->getModel('replacement');
			
			/* Set some log info */
			$csvilog->SetAction('export');
			$csvilog->SetActionType($template->template_type, $template->template_name);
			
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
					if ($template->include_column_headers) {
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
					if ($template->include_column_headers) {
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
					CsvivirtuemartModelExportfile::writeOutput($exportclass->FooterText());
				}
				
				/* Set the toolbar */
				switch (JRequest::getVar('exportto')) {
					case 'tofile':
					case 'toemail':
						JToolBarHelper::title(JText::_('EXPORT'), 'csvivirtuemart_export_48');
						break;
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
		
		/* Display it all */
		parent::display($tpl);
	}
	
	/**
	* Get some basic details for the export
	 */
	private function ExportDetails() {
		$template = JRequest::getVar('template');
		JRequest::setVar('exportfilename', $this->get('ExportFilename'));
		JRequest::setVar('exportfields', $this->get('ExportFields'));
		if ($template->export_email) $exportto = 'toemail';
		else $exportto = JRequest::getVar('exportto');
		JRequest::setVar('exportto', $exportto);
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
							$csvilog->AddStats('incorrect', JText::_("No XML class found"));
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