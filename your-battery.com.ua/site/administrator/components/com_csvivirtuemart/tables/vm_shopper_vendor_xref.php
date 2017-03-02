<?php
/**
* Virtuemart Shopper Vendor cross table
*
* @package CSVIVirtueMart
* @subpackage Tables
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: vm_shopper_vendor_xref.php 1117 2010-01-01 21:39:52Z Roland $
 */

/* No direct access */
defined('_JEXEC') or die('Restricted access');

/**
* @package CSVIVirtueMart
* @subpackage Tables
 */
class TableVm_shopper_vendor_xref extends JTable {
	
	/* Sets whether the database columns have been loaded */
	private $_loaded = false;
	
	/**
	* @param database A database connector object
	 */
	function __construct($db) {
		$this->reset();
		parent::__construct('#__vm_shopper_vendor_xref', 'user_id', $db );
	}
	
	/**
	* Resets the default properties
	* @return	void
	 */
	function reset() {
		if (!$this->_loaded) {
			$this->setProperties(CsvivirtuemartModelAvailablefields::DbFields('vm_shopper_vendor_xref'));
			$this->_loaded = true;
		}
		else {
			$class_vars = get_class_vars(get_class($this));
			foreach ($this as $name => $value) {
				if (substr($name, 0, 1) != '_') {
					$this->$name = null;
				}
			}
		}
	}
	
	/**
	* Stores a shopper vendor relation
	 */
	public function store() {
		$csvilog = JRequest::getVar('csvilog');
		
		if($this->check()) {
			$ret = $this->_db->updateObject( $this->_tbl, $this, $this->_tbl_key, false );
		}
		else {
			$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );
		}
		if(!$ret) return false;
		else return true;
	}
	
	/**
	* Check if the shopper <--> vendor relation exists
	 */
	public function check() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		/* Check if the shopper vendor xref is in the database */
		$q = "SELECT ".$this->_tbl_key."
			FROM ".$this->_tbl."
			WHERE ".$db->nameQuote('vendor_id')." = ".$db->Quote($this->vendor_id)."
			AND ".$db->nameQuote('shopper_group_id')." = ".$db->Quote($this->shopper_group_id)."
			AND ".$db->nameQuote('user_id')." = ".$db->Quote($this->user_id);
		$db->setQuery($q);
		$db->query();
		$csvilog->AddMessage('debug', JText::_('DEBUG_SHOPPER_VENDOR_EXISTS'), true);
		if ($db->getAffectedRows() > 0) {
			return true;
		}
		else {
			$this->customer_number = uniqid( rand() );
			return false;
		}
	}
}
?>