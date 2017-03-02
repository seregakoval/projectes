<?php
/**
* Import controller
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: import.php 1130 2010-01-16 09:16:29Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport('joomla.application.component.controller');

/**
* Import Controller
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartControllerImport extends JController
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
	* Shows the import option screen
	 */
	function Import() {
		/* Create the view object */
		$view = $this->getView('import', 'html');
		
		/* Standard model */
		$view->setModel( $this->getModel( 'import', 'CsvivirtuemartModel' ), true );
		$view->setModel( $this->getModel( 'templates', 'CsvivirtuemartModel' ));
		$view->setLayout('import');
		
		
		/* Now display the view */
		$view->display();
	}
	
	/**
	* Import is all finished, show the results page
	*/
	public function finished() {
		/* Create the view object */
		$view = $this->getView('import', 'html');
		
		/* Standard model */
		$view->setModel( $this->getModel( 'import', 'CsvivirtuemartModel' ), true );
		
		/* Log functions */
		$view->setModel( $this->getModel( 'log', 'CsvivirtuemartModel' ));
		
		/* Set the layout file */
		$view->setLayout('import_result');
		
		/* Now display the view */
		$view->display();
	}
	
	/**
	* Cancel a running import
	*/
	public function cancelImport() {
		$model = $this->getModel('import');
		$model->getImportCleanup();
		$this->setRedirect('index.php?option='.JRequest::getCmd('option').'&controller=import&task=finished&import_id='.JRequest::getInt('import_id'), JText::_('IMPORT_CANCELLED'), 'notice');
	}
}
?>
