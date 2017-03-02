<?php
/**
* Import controller
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: importfile.php 1136 2010-01-23 14:05:53Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport('joomla.application.component.controller');

/**
* Import Controller
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartControllerImportfile extends JController {
	/**
	* Method to display the view
	*
	* @access	public
	 */
	function __construct() {
		parent::__construct();
	}
	
	/**
	* Load import model files
	*
	* Here the models are loaded that are used for import. Special is the
	* import model file as this is included based on the template type
	 */
	public function importFile() {
		/* Create the view object */
		$view = $this->getView('importfile', 'html');
		
		/* Load the models */
		/* Standard model */
		$view->setModel( $this->getModel( 'importfile', 'CsvivirtuemartModel' ), true );
		
		/* Log functions */
		$view->setModel( $this->getModel( 'log', 'CsvivirtuemartModel' ));
		/* Settings functions */
		$view->setModel( $this->getModel( 'settings', 'CsvivirtuemartModel' ));
		/* General import functions */
		$view->setModel( $this->getModel( 'import', 'CsvivirtuemartModel' ));
		/* General category functions */
		$view->setModel( $this->getModel( 'category', 'CsvivirtuemartModel' ));
		/* Template settings */
		$view->setModel( $this->getModel( 'templates', 'CsvivirtuemartModel' ));
		/* Available fields */
		$view->setModel( $this->getModel( 'availablefields', 'CsvivirtuemartModel' ));
		
		/* Load the helpers */
		/* Add extra helper paths */
		$view->addHelperPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'excel');
		$view->addHelperPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'helpers'.DS.'ods');
		
		/* Get the helper files */
		$view->loadHelper('csvi_class_log');
		$view->loadHelper('csvi_class_file');
		$view->loadHelper('excel_reader2');
		$view->loadHelper('ods');
		$view->loadHelper('csvi_class_mime_type_detect');
		$view->loadHelper('csvi_class_image_converter');
		$view->loadHelper('vm_config');
		
		/* Get the logger class */
		$csvilog = new CsviLog();
		$this->import_id = JRequest::getInt('import_id', false);
		if (!$this->import_id) $this->import_id = $csvilog->setImportId();
		else $csvilog->setImportId($this->import_id);
		JRequest::setVar('csvilog', $csvilog);
		
		/* Set the template */
		$template_model = $this->getModel('Templates');
		$template_model->setTemplateId(JRequest::getInt('template_id', 0));
		$template = $template_model->getTemplate();
		
		/* Check if the preview has already been done */
		if (JRequest::getVar('was_preview', false)) $template->show_preview = false;
		
		JRequest::setVar('template', $template);
		$csvilog->setDebug($template->collect_debug_info);
		
		/* Store the URL */
		$uri = JURI::getInstance();
		$csvilog->AddMessage('debug', $uri->toString());
		
		/* Load the import routine */
		$view->setModel( $this->getModel( $template->template_type, 'CsvivirtuemartModel' ));
		
		/* Set the system limits */
		$view->get('SystemLimits');
		
		/* Check the system limits */
		$view->get('CheckLimits');
		
		/* Set the line counter */
		JRequest::setVar('currentline', 1);
		JRequest::setVar('totalline', JRequest::getInt('totalline', 1));
		
		/* Retrieve the available fields */
		$availablefields = $this->getModel('Availablefields');
		JRequest::setVar('supported_fields', $availablefields->GetAvailableFields($template->template_type));
		
		/* Get the file contents so we can start processing */
		/* Handle the upload here */
		$csvifile = new CsviFile();
		JRequest::setVar('csvifile', $csvifile);
		$csvifile->validateFile();
		$csvifile->processFile();
		
		/* Set some log info */
		$csvilog->SetAction('import');
		$csvilog->SetActionType($template->template_type, $template->template_name);
		
		/* Load the settings */
		$settings_model = new CsvivirtuemartModelSettings();
		
		/* Check if the file is OK, if not do not continue */
		if (!$csvifile->fp) {
			$csvilog->AddStats('incorrect', JText::_('FAILURE'));
			/* Store the log results */
			if ($settings_model->getSetting('log_store')) {
				$log_model = $this->getModel('Log');
				$log_model->getStoreLogResults();
			}
			/* Redirect to final page */
			if (!JRequest::getBool('cron', false)) {
				$redirect = JURI::root().'administrator/index.php?option=com_csvivirtuemart&controller=import&task=finished&import_id='.$csvilog->getImportId();
				echo '<script type="text/javascript">window.top.location=\''.$redirect.'\';</script>';
				jexit();
			}
			else $view->setLayout('importfilecron');
		}
		else {
			/* Set some variables */
			$data_preview = array();
			$processdata = true;
			$finished = false;
			
			/* Set the position in the file to read from */
			if (JRequest::getInt('filepos', 0) > 0) $csvifile->setFilePos(JRequest::getInt('filepos', 0));
			
			/* Do we need to get the column headers? */
			if ($template->use_column_headers) $csvifile->loadColumnHeaders();
			
			/* Skip the first line? */
			if ($template->skip_first_line && JRequest::getInt('totalline') == 1) $csvifile->next(); 
			
			/* Validate the import choices */
			$view->get('ValidateImportChoices');
			
			/* Print out the import details */
			$view->get('ImportDetails');
			
			/* Unpublish any products if needed */
			if ($template->unpublish_before_import) $view->get('UnpublishProducts');
			
			/* Set the template type */
			$csvilog->AddMessage('debug', 'Doing a '.JText::_($template->template_type).' import');
			
			/* Retrieve the fields to import */
			if ($view->get('RetrieveConfigFields')) {
				/* All is good to import, go to the view */
				if ($template->show_preview && !JRequest::getBool('cron', false)) {
					$view->setLayout('importpreview');
				}
				else if (!JRequest::getBool('cron', false)) {
					$view->setLayout('importfile');
				}
				else {
					$view->setLayout('importfilecron');
				}
			}
			/* There is a configuration issue */
			else {
				/* Redirect to the import result page */
				/* Store the log results */
				if ($settings_model->getSetting('log_store')) {
					$log_model = $this->getModel('Log');
					$log_model->getStoreLogResults();
				}
				/* Redirect to final page */
				if (!JRequest::getBool('cron', false)) {
					$mainframe = JFactory::getApplication();
					$mainframe->redirect(JURI::root().'administrator/index.php?option=com_csvivirtuemart&controller=import&task=finished&import_id='.$csvilog->getImportId());
				}
				else $view->setLayout('importfilecron');
			}
		}
		
		/* Now display the view */
		$view->display();
		
	}
}
?>
