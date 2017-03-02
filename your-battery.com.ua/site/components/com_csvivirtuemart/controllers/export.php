<?php
/**
* Export view
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 Roland Dalmulder
* @version $Id: export.php 1117 2010-01-01 21:39:52Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport('joomla.application.component.controller');

/**
* Api Controller
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartControllerExport extends JController {
	/**
	* Method to display the view
	*
	* @access	public
	 */
	function __construct() {
		parent::__construct();
		
		/* Redirect templates to templates as this is the standard call */
		// $this->registerTask('sendmail','api');
	}
	
	/**
	* Export for front-end
	 */
	function Export() {
		/* Create the view */
		$view = $this->getView('export', 'raw');
		
		/* Add the api */
		$view->setModel( $this->getModel( 'export', 'CsvivirtuemartModel' ), true );
		/* Add model path */
		JController::addModelPath(JPATH_COMPONENT_ADMINISTRATOR.DS.'models');
		/* Log functions */
		$view->setModel( $this->getModel( 'log', 'CsvivirtuemartModel' ));
		/* Settings functions */
		$view->setModel( $this->getModel( 'settings', 'CsvivirtuemartModel' ));
		/* General import functions */
		$view->setModel( $this->getModel( 'exportfile', 'CsvivirtuemartModel' ));
		/* General category functions */
		$view->setModel( $this->getModel( 'category', 'CsvivirtuemartModel' ));
		/* Template settings */
		$view->setModel( $this->getModel( 'templates', 'CsvivirtuemartModel' ));
		/* Available fields */
		$view->setModel( $this->getModel( 'availablefields', 'CsvivirtuemartModel' ));
		/* Model replacement */
		$view->setModel( $this->getModel( 'replacement', 'CsvivirtuemartModel' ));
		/* Export specific model */
		$view->setModel( $this->getModel( $this->getTemplateType(), 'CsvivirtuemartModel' ));		
		
		/* Set the layout */
		$view->setLayout('export');
		
		/* Display it all */
		$view->display();
	}
	
	/**
	* Retrieves the template type
	 */
	private function getTemplateType() {
		$db = JFactory::getDBO();
		
		$q = "SELECT LOWER(template_type) AS template_type
			FROM #__csvivirtuemart_templates
			WHERE template_id = ".JRequest::getInt('template_id');
		$db->setQuery($q);
		if ($db->query()) return $db->loadResult();
		else return false;
	}
}
?>