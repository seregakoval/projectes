<?php
/**
* Virtuemart Product Type Cross reference table
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: vm_product_product_type_xref.php 1117 2010-01-01 21:39:52Z Roland $
 */

/* No direct access */
defined('_JEXEC') or die('Restricted access');

/**
* @package CSVIVirtueMart
* @todo Jtext strings
 */
class TableVm_product_product_type_xref extends JTable {
	
	/* Sets whether the database columns have been loaded */
	private $_loaded = false;
	
	/**
	* @param database A database connector object
	 */
	function __construct($db) {
		$this->reset();
		parent::__construct('#__vm_product_product_type_xref', 'product_id', $db );
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
			$this->setProperties(CsvivirtuemartModelAvailablefields::DbFields('vm_product_product_type_xref'));
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
	* Store a value
	 */
	public function store() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		if (!$this->check()) {
			$q = "INSERT INTO ".$db->nameQuote( $this->_tbl )."
				VALUES (".$db->Quote($this->product_id).", ".$db->Quote($this->product_type_id).")";
			$db->setQuery($q);
			return $db->query();
		}
		else {
			$csvilog->AddMessage('debug', JText::_('CROSS_REFERENCE_EXISTS'));
		}
	}
	
	/**
	* Function to check if cross reference already exists
	 */
	public function check() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		$q = "SELECT COUNT(product_id) AS total
			FROM ".$db->nameQuote( $this->_tbl )."
			WHERE product_id = ".$db->Quote($this->product_id)."
			AND product_type_id = ".$db->Quote($this->product_type_id);
		$db->setQuery($q);
		$csvilog->AddMessage('debug', JText::_('PRODUCT_TYPE_XREF_CHECK'), true);
		if ($db->loadResult() > 0) return true;
		else return false;
	}
}
?>