<?php
/**
* Export controller
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: export.php 1117 2010-01-01 21:39:52Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport('joomla.application.component.controller');

/**
* Import Controller
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartControllerExport extends JController
{
	/**
	* Method to display the view
	*
	* @access	public
	 */
	function __construct() {
		parent::__construct();
		
		$this->registerTask('getUser','getData');
		$this->registerTask('getProduct','getData');
	}	
	
	/**
	* Shows the import option screen
	 */
	function Export() {
		/* Create the view object. */
		$view = $this->getView('export', JRequest::getVar('format', 'html'));
		
		/* Standard model */
		$view->setModel( $this->getModel( 'export', 'CsvivirtuemartModel' ), true );
		$view->setModel( $this->getModel( 'templates', 'CsvivirtuemartModel' ));
		$view->setLayout('export');
		
		/* Now display the view. */
		$view->display();
	}
	
	/**
	* Retrieves usernames
	 */
	function getData() {
		/* Create the view object. */
		$view = $this->getView('export', 'json');
		
		/* Standard model */
		$view->setModel( $this->getModel( 'export', 'CsvivirtuemartModel' ), true );
		$view->setLayout('export');
		
		/* Now display the view. */
		$view->display();
	}
}
?>
