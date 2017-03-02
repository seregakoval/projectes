<?php
/**
* Joomla User ARO table
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: core_acl_aro.php 1117 2010-01-01 21:39:52Z Roland $
 */

/* No direct access */
defined('_JEXEC') or die('Restricted access');

/**
* @package CSVIVirtueMart
 */
class TableCore_acl_aro extends JTable {
	
	/**
	* @param database A database connector object
	 */
	function __construct($db) {
		$this->reset();
		parent::__construct('#__core_acl_aro', 'id', $db );
	}
	
	/**
	* Cleans the class variables
	 */
	public function reset() {
		$this->setProperties(CsvivirtuemartModelAvailablefields::DbFields('core_acl_aro'));
	}
	
	public function check() {
		$db = JFactory::getDBO();
		$q = "SELECT ".$this->_tbl_key."
			FROM ".$this->_tbl."
			WHERE `section_value` = ".$db->Quote($this->section_value)."
			AND `value` = ".$db->Quote($this->value);
		$db->setQuery($q);
		$this->id = $db->loadResult();
	}
}
?>