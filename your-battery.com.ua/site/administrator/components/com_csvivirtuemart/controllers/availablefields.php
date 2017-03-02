<?php
/**
* Available Fields controller
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: availablefields.php 1117 2010-01-01 21:39:52Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport('joomla.application.component.controller');

/**
* Available Fields Controller
*
* @package    CSVIVirtueMart
 */
class CsvivirtuemartControllerAvailableFields extends JController
{
	/**
	* Method to display the view
	*
	* @access	public
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	* Shows the logs
	 */
	public function AvailableFields() {
		/* Create the view */
		$view = $this->getView('availablefields', 'html');
		
		/* Add the models */
		$view->setModel( $this->getModel( 'availablefields', 'CsvivirtuemartModel' ), true );
		/* Available fields */
		$view->setModel( $this->getModel( 'templates', 'CsvivirtuemartModel' ));
		
		/* Set the layout */
		$view->setLayout('availablefields');
		
		/* Display it all */
		$view->display();
	}
}
?>
