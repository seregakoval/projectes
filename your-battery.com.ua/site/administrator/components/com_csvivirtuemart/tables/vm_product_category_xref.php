<?php
/**
* Virtuemart Product Category Cross reference table
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: vm_product_category_xref.php 1117 2010-01-01 21:39:52Z Roland $
 */

/* No direct access */
defined('_JEXEC') or die('Restricted access');

/**
* @package CSVIVirtueMart
 */
class TableVm_product_category_xref extends JTable {
	
	/* Sets whether the database columns have been loaded */
	private $_loaded = false;
	
	/**
	* @param database A database connector object
	 */
	function __construct($db) {
		$this->reset();
		parent::__construct('#__vm_product_category_xref', 'product_id', $db );
	}
	
	/**
	* Set a value for the class
	 */
	public function setValue($field, $value) {
		$this->$field = $value;
	}
	
	/**
	* Get a value from the class
	 */
	public function getValue($field) {
		return $this->$field;
	}
	
	/**
	* Resets the default properties
	* @return	void
	 */
	function reset() {
		if (!$this->_loaded) {
			$this->setProperties(CsvivirtuemartModelAvailablefields::DbFields('vm_product_category_xref'));
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
	* Stores a product category relation
	*
	* The product category relation is always inserted
	 */
	public function store() {
		$csvilog = JRequest::getVar('csvilog');
		/* Check if the entry already exists */
		if (!$this->checkDuplicate()) {
			$ret = $this->_db->insertObject( $this->_tbl, $this);
			$csvilog->AddMessage('debug', JText::_('Add new category references'), true);
			if (!$ret) {
				$this->setError(get_class($this).'::store failed - '.$this->_db->getErrorMsg());
				return false;
			}
			else return true;
		}
		else return true;
	}
	
	/**
	* Check if the entry already exists
	 */
	private function checkDuplicate() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		$q = "SELECT COUNT(*) AS total
			FROM ".$this->_tbl."
			WHERE product_id = ".$this->product_id."
			AND category_id = ".$this->category_id;
		$db->setQuery($q);
		$csvilog->AddMessage('debug', JText::_('Check if category reference already exists'), true);
		$total = $db->loadResult();
		if ($total > 0) {
			$csvilog->AddMessage('debug', JText::_('Category reference already exists'));
			return true;
		}
		else {
			$csvilog->AddMessage('debug', JText::_('Category reference does not yet exist'));
			return false;
		}
	}
	
}
?>