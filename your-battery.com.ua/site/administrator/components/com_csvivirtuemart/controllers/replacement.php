<?php
/**
* Replacement controller
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: replacement.php 1138 2010-01-27 22:54:36Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport('joomla.application.component.controller');

/**
* Replacement Controller
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartControllerReplacement extends JController {
	/**
	* Method to display the view
	*
	* @access	public
	 */
	public function __construct() {
		parent::__construct();
		
		/* Redirects */
		$this->registerTask('remove','json');
		$this->registerTask('publish','json');
		$this->registerTask('loadfields','json');
		$this->registerTask('save','replacement');
		$this->registerTask('remove_all','replacement');
	}
	
	/**
	* Shows the replacements
	 */
	public function Replacement() {
		/* Create the view object */
		$view = $this->getView('replacement', 'html');
		
		/* Standard model */
		$view->setModel( $this->getModel( 'replacement', 'CsvivirtuemartModel' ), true );
		
		/* Template settings */
		$view->setModel( $this->getModel( 'templates', 'CsvivirtuemartModel' ));
		
		/* Set layout */
		$view->setLayout('replacement');
			
		/* Now display the view */
		$view->display();
	}
	
	/**
	* Adds a new replacement
	 */
	public function Add() {
		$model = $this->getModel('replacement');
		
		if ($model->getAddReplacement()) {
			$msg = JText::_('REPLACEMENT_ADDED');
		}
		else {
			$msg = JText::_($model->getError());
		}
		
		$this->setRedirect('index.php?option='.jRequest::getCmd('option').'&controller=replacement', $msg);
	}
	
	/**
	* Handles JSON requests
	 */
	 public function Json() {
	 	 /* Create the view object. */
		$view = $this->getView('replacement', 'json');
		
		/* Standard model */
		$view->setModel( $this->getModel( 'replacement', 'CsvivirtuemartModel' ), true );
		
		/* Now display the view. */
		$view->display();
	 }
}
?>
