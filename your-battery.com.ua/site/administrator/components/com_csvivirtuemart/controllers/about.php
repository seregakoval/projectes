<?php
/**
* About controller
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: about.php 1117 2010-01-01 21:39:52Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport('joomla.application.component.controller');

/**
* About Controller
*
* @package    CSVIVirtueMart
 */
class CsvivirtuemartControllerAbout extends JController
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
	* Shows the about screen
	 */
	function About() {
		JRequest::setVar('view', 'about');
		JRequest::setVar('layout', 'about');
		
		parent::display();
	}
}
?>
