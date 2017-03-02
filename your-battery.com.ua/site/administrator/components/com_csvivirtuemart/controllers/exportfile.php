<?php
/**
* Export controller
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: exportfile.php 1117 2010-01-01 21:39:52Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport('joomla.application.component.controller');

/**
* Export Controller
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartControllerExportfile extends JController {
	/**
	* Method to display the view
	*
	* @access	public
	 */
	function __construct() {
		parent::__construct();
	}
	
	/**
	* Load export model files
	*
	* Here the models are loaded that are used for import. Special is the
	* import model file as this is included based on the template type
	 */
	public function ExportFile() {
		/* Create the view object */
		$view = $this->getView('exportfile', 'html');
		
		/* Default model */
		$view->setModel( $this->getModel( 'exportfile', 'CsvivirtuemartModel' ), true );
		/* Log functions */
		$view->setModel( $this->getModel( 'log', 'CsvivirtuemartModel' ));
		/* Settings functions */
		$view->setModel( $this->getModel( 'settings', 'CsvivirtuemartModel' ));
		/* General import functions */
		$view->setModel( $this->getModel( 'export', 'CsvivirtuemartModel' ));
		/* General category functions */
		$view->setModel( $this->getModel( 'category', 'CsvivirtuemartModel' ));
		/* Template settings */
		$view->setModel( $this->getModel( 'templates', 'CsvivirtuemartModel' ));
		/* Available fields */
		$view->setModel( $this->getModel( 'availablefields', 'CsvivirtuemartModel' ));
		/* Export specific model */
		$view->setModel( $this->getModel( $this->getTemplateType(), 'CsvivirtuemartModel' ));
		/* Replacement model */
		$view->setModel( $this->getModel( 'replacement', 'CsvivirtuemartModel' ));
		
		/* Set the layout */
		if (!JRequest::getBool('cron', false)) $view->setLayout('exportfile');
		else $view->setLayout('exportfilecron');
		
		/* Now display the view. */
		$view->display();
	}
	
	/**
	* Load export model files
	*
	* Here the models are loaded that are used for import. Special is the
	* import model file as this is included based on the template type
	 */
	public function CronLine() {
		/* Create the view object */
		$view = $this->getView('exportfile', 'html');
		
		/* Default model */
		$view->setModel( $this->getModel( 'exportfile', 'CsvivirtuemartModel' ), true );
		/* Template settings */
		$view->setModel( $this->getModel( 'templates', 'CsvivirtuemartModel' ));
		/* Export specific model */
		$view->setModel( $this->getModel( $this->getTemplateType(), 'CsvivirtuemartModel' ));
		
		/* Set the layout */
		$view->setLayout('exportcronline');
		
		/* Now display the view. */
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