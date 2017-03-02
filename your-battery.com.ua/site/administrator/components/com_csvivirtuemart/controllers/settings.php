<?php
/**
* Settings controller
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: settings.php 1117 2010-01-01 21:39:52Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport('joomla.application.component.controller');

/**
* Settings Controller
*
* @package    CSVIVirtueMart
 */
class CsvivirtuemartControllerSettings extends JController
{
	/**
	* Method to display the view
	*
	* @access	public
	 */
	function __construct() {
		parent::__construct();
	}
	
	/**
	* Loads the settings view
	 */
	public function Settings() {
		/* Create the view object */
		$view = $this->getView('settings', 'html');
		
		/* Standard model */
		$view->setModel( $this->getModel( 'settings', 'CsvivirtuemartModel' ), true );
		$view->setLayout('settings');
		
		/* Now display the view */
		$view->display();
	}
	
	/**
	* Save the settings
	*/
	public function save() {
		$mainframe = JFactory::getApplication();
		$model = $this->getModel('settings');
		
		if ($model->getSaveSettings()) {
			$msg = JText::_('SETTINGS_SAVED_SUCCESSFULLY');
			$msgtype = '';
		}
		else {
			$msg = JText::_('SETTINGS_NOT_SAVED_SUCCESSFULLY');
			$msgtype = 'error';
		}
		$mainframe->redirect('index.php?option=com_csvivirtuemart&controller=settings', $msg, $msgtype);

	}
}
?>
