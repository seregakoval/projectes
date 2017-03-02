<?php
/**
* Maintenance controller
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: maintenance.php 1117 2010-01-01 21:39:52Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport('joomla.application.component.controller');

/**
* Maintenance Controller
*
* @package    CSVIVirtueMart
 */
class CsvivirtuemartControllerMaintenance extends JController
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
	* Shows the maintenance screen
	 */
	public function Maintenance() {
		/* Create the view object */
		$view = $this->getView('maintenance', 'html');
		
		/* Standard model */
		$view->setModel( $this->getModel( 'maintenance', 'CsvivirtuemartModel' ), true );
		
		/* Extra models */
		$view->setModel( $this->getModel( 'log', 'CsvivirtuemartModel' ));
		$view->setModel( $this->getModel( 'availablefields', 'CsvivirtuemartModel' ));
		
		/* View */
		if (!JRequest::getBool('cron', false)) {
			if (JRequest::getBool('boxchecked')) $view->setLayout('maintenancelog');
			else $view->setLayout('maintenance');
		}
		else $view->setLayout('maintenancecron');
		
		
		/* Now display the view */
		$view->display();
	}
}
?>
