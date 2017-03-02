<?php
/**
* Log controller
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: log.php 1117 2010-01-01 21:39:52Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport('joomla.application.component.controller');

/**
* Log Controller
*
* @package    CSVIVirtueMart
 */
class CsvivirtuemartControllerLog extends JController {
	/**
	* Method to display the view
	*
	* @access	public
	*/
	public function __construct() {
		parent::__construct();
		
		/* Redirects */
		$this->registerTask('cancel','log');
		$this->registerTask('remove','log');
		$this->registerTask('remove_all','log');
	}
	
	/**
	* Shows the logs
	*/
	public function Log() {
		JRequest::setVar('view', 'log');
		JRequest::setVar('layout', 'log');
		
		parent::display();
	}
	
	/**
	* Shows the details of a log
	*/
	public function LogDetails() {
		JRequest::setVar('view', 'log');
		JRequest::setVar('layout', 'logdetails');
		JRequest::setVar('hidemainmenu', 1);
		
		parent::display();
	}
	
	/**
	* Download a debug log file
	*/
	public function downloadDebug() {
		$log = $this->getModel('log', 'CsvivirtuemartModel');
		$log->downloadDebug();
	}
}
?>
