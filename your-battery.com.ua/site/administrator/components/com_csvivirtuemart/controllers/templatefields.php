<?php
/**
* Default view
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: templatefields.php 1117 2010-01-01 21:39:52Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport('joomla.application.component.controller');

/**
* Templates Controller
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartControllerTemplatefields extends JController {
	/**
	* Method to display the view
	*
	* @access	public
	 */
	function __construct() {
		parent::__construct();
		
		$this->registerTask('unpublish','templatefields');
		$this->registerTask('publish','templatefields');
		$this->registerTask('savefieldstable','templatefields');
		$this->registerTask('addfield','templatefields');
		$this->registerTask('renumber','templatefields');
		$this->registerTask('deletefield','templatefields');
		$this->registerTask('saveq','templatefields');
		$this->registerTask('cancel','templatefields');
	}
	
	/**
	* Creates a list of templates in the database
	 */
	function TemplateFields() {
		/* Create the view */
		$view = $this->getView('templatefields', 'html');
		
		/* Add the models */
		$view->setModel( $this->getModel( 'templatefields', 'CsvivirtuemartModel' ), true );
		/* Templates */
		$view->setModel( $this->getModel( 'templates', 'CsvivirtuemartModel' ));
		/* Available fields */
		$view->setModel( $this->getModel( 'availablefields', 'CsvivirtuemartModel' ));
		
		/* Set the layout */
		$view->setLayout(JRequest::getWord('view', 'templatefields'));
		
		/* Display it all */
		$view->display();
	}
	
	/**
	* Redirect back to the templates list
	 */
	public function Templates() {
		$mainframe = JFactory::getApplication();
		$mainframe->redirect('index.php?option=com_csvivirtuemart&controller=templates');
	}
	
	/**
	* Redirect for the quick add template fields
	 */
	public function QuickAdd() {
		$mainframe = JFactory::getApplication();
		$template_id = JRequest::getInt('template_id');
		$mainframe->redirect('index.php?option=com_csvivirtuemart&controller=templatefields&template_id='.$template_id.'&view=quicktemplatefields');
	}
}
?>
