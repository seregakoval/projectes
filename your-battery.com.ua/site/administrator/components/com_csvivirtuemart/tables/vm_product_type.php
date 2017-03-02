<?php
/**
* Virtuemart Product Type table
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: vm_product_type.php 1117 2010-01-01 21:39:52Z Roland $
 */

/* No direct access */
defined('_JEXEC') or die('Restricted access');

/**
* @package CSVIVirtueMart
 */
class TableVm_product_type extends JTable {
	
	/* Sets whether the database columns have been loaded */
	private $_loaded = false;
	
	/**
	* @param database A database connector object
	 */
	function __construct($db) {
		$this->reset();
		parent::__construct('#__vm_product_type', 'product_type_id', $db );
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
			$this->setProperties(CsvivirtuemartModelAvailablefields::DbFields('vm_product_type'));
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
	* Check if a product type already exists
	*
	* Criteria for an existing product type are:
	* - product id
	* - shopper group id
	* If both exists, price will be updated
	 */
	public function check() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		$q = "SELECT ".$this->_tbl_key."
			FROM ".$this->_tbl."
			WHERE product_type_name='".$this->product_type_name."'";
		$db->setQuery($q);
		$csvilog->AddMessage('debug', JText::_('CHECK_PRODUCT_TYPE_NAME_EXISTS'), true);
		$db->query();
		if ($db->getAffectedRows() > 0) {
			$this->product_type_id = $db->loadResult();
		}
	}
}
?>
