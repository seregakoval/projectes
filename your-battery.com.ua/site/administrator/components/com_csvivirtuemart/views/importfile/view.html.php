<?php
/**
* Import file view
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
* Import file View
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartViewImportFile extends JView {
	
	/** @var object Holds the active template details  */
	public $template = null;
	
	/** @var object Holds the file class  */
	private $handlefile = null;
	
	/**
	* Templates view display method
	*/
	public function display($tpl = null) {
		$mainframe = JFactory::getApplication();
		/* Get the toolbar title */
		JToolBarHelper::title(JText::_( 'IMPORTING' ), 'csvivirtuemart_import_48');
		JRequest::setVar('hidemainmenu', 1);
		
		/* Get the logger class */
		$csvilog = JRequest::getVar('csvilog');
		
		/* Get the template */
		$template = JRequest::getVar('template');
		
		/* Get the file details */
		$csvifile = JRequest::getVar('csvifile');
		
		/* Process the data */
		$redirect = $this->get('ProcessData');
		
		/* Store the log results, only if we are not doing a preview */
		$settings_model = new CsvivirtuemartModelSettings();
		if ($settings_model->getSetting('log_store') && !$template->show_preview) {
			$this->get('StoreLogResults', 'log');
		}
		
		/* Assign some standard values */
		$this->assignRef('filename', $csvifile->filename);		
		$this->assignRef('template', $template);
		$this->assignRef('import_id', $csvilog->getImportId());
		
		if (JRequest::getVar('layout', false)) {
			$this->setLayout(JRequest::getVar('layout'));
			$this->assignRef('redirect', $redirect);
		}
		else {
			if ($redirect && !JRequest::getBool('cron', false) && !JRequest::getBool('error_found', false)) {
				/* Check if we need to do a redirect */
				if (!JRequest::getBool('finished', false)) {
					sleep($settings_model->getSetting('import_wait', 0));
					echo '<script type="text/javascript">
							jQuery(this).parents("div").find(\'span\').stopTime(\'importcounter\');
							jQuery(".uncontrolled-interval ", window.parent.document).everyTime(1000, \'importcounter\', function(i) {
								if ('.ini_get('max_execution_time').' > 0 && i > '.ini_get('max_execution_time').') {
									jQuery("#loading", window.parent).remove();
									jQuery("#progress", window.parent).remove();
									jQuery(this).html(\''.JText::_('MAX_IMPORT_TIME_PASSED').'\');
								}
								else jQuery(this).html(i);
							});
							jQuery(function(){window.location=\''.$redirect.'\'});
						</script>';
				}
				else echo '<script type="text/javascript">jQuery(function(){window.parent.location=\''.$redirect.'\'});</script>';
			}
			else {
				/* Assign the values */
				if ($template->show_preview && !JRequest::getBool('error_found', false)) {
					JToolBarHelper::title(JText::_( 'Import preview' ), 'csvivirtuemart_import_48');
					if (!JRequest::getVar('upload_file_error') && (!JRequest::getVar('error_found'))) {
						JToolBarHelper::custom( 'importfile', 'csvivirtuemart_import_32', 'csvivirtuemart_import_32', JText::_('Import'), false);
					}
					$this->assignRef('csvfields', JRequest::getVar('csv_fields'));
					$this->assignRef('datapreview', JRequest::getVar('data_preview', '', 'default', 'none', 2));
					$this->assignRef('template_id', $template->template_id);
					$this->assignRef('csvfile', JRequest::getVar('csv_file'));
				}
				else {
					JToolBarHelper::title(JText::_('Import result'), 'csvivirtuemart_import_48');
					$this->assignRef('redirect', $redirect);
					
					if (JRequest::getBool('finished', false)) {
						/* Set the unique ID */
						JRequest::setVar('import_id', $csvilog->getImportId());
						
						/* Load the results */
						$logresult = $this->get('Stats', 'log');
						
						/* Assign the data */
						$this->assignRef('logresult', $logresult);
					}
				}
			}
		}
		
		if (JRequest::getBool('error_found', false)) $settask = 'import';
		else $settask = 'cancelimport';
		JToolBarHelper::custom( $settask, 'csvivirtuemart_cancel_32', 'csvivirtuemart_cancel_32', JText::_('CANCEL'), false);
		
		/* Display it all */
		parent::display($tpl);
	}
}
?>