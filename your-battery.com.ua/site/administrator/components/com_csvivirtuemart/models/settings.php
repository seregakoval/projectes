<?php
/**
* Settings model
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: settings.php 1117 2010-01-01 21:39:52Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.model' );

/**
* Settings Model
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartModelSettings extends JModel {
	
	/** @var string Path to the configuration file */
	var $_paramdefs = null;
	
	/**
	* Basic settings
	*/
	public function __construct() {
		$this->_paramsdefs = JPATH_COMPONENT_ADMINISTRATOR.DS.'views'.DS.'settings'.'config.xml';
		parent::__construct();
	}
	
	/**
	* Load the CSVI VitueMart settings
	*
	* Id is fixed for 1
	*/
	public function getSettings() {
		$db = JFactory::getDBO();
		$row  = $this->getTable('csvivirtuemart_settings');
		$row->load(1);
		return $row->params;
	}
	
	/**
	* Store the component parameters
	 */
	 public function getSaveSettings() {
		$row  = $this->getTable('csvivirtuemart_settings');
		$params = new JParameter('', $this->_paramsdefs);
		$post = JRequest::get('post');
		$params->bind($post['params']);
		
		/* Set the values */
		$row->id = 1;
		$row->params = $params->toString();
		if ($row->store()) return true;
		else return false;
	 }
	 
	 /**
	* Get a requested value
	 */
	 public function getSetting($setting) {
		$paramsdata = $this->getSettings();
		$params = new JParameter($paramsdata, $this->_paramsdefs);
		return $params->get($setting, false);
	 }
}
?>