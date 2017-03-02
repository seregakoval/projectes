<?php
/**
* Virtuemart Product Attribute SKU table
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: vm_product_attribute_sku.php 1117 2010-01-01 21:39:52Z Roland $
 */

/* No direct access */
defined('_JEXEC') or die('Restricted access');

/**
* @package CSVIVirtueMart
 */
class TableVm_product_attribute_sku extends JTable {
	
	/* Sets whether the database columns have been loaded */
	private $_loaded = false;
	
	/**
	* @param database A database connector object
	 */
	function __construct($db) {
		$this->reset();
		parent::__construct('#__vm_product_attribute_sku', 'product_id', $db );
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
			$this->setProperties(CsvivirtuemartModelAvailablefields::DbFields('vm_product_attribute_sku'));
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
	* Stores a category relation
	*
	* The product relation is always inserted
	 */
	public function store() {
		$k = $this->check();
		if(!$k) {
			$ret = $this->_db->insertObject( $this->_tbl, $this, $this->_tbl_key );
		}
		else $ret = $k;
		if( !$ret )
		{
			$this->setError(get_class( $this ).'::store failed - '.$this->_db->getErrorMsg());
			return false;
		}
		else
		{
			return true;
		}
	}
	
	/**
	* Check if a product attribute already exists. If so, get the attribute ID
	*
	* Criteria for an existing attribute:
	* - product_id
	* - attribute_name
	 */
	public function check() {
		/* Check if the attribute in the database */
		$q = "SELECT ".$this->_tbl_key."
			FROM ".$this->_tbl."
			WHERE product_id = '".$this->product_id."'
			AND attribute_name = '".$this->attribute_name."'";
		// $csvilog->AddMessage('debug', 'Discount exists, return discount id: <a onclick="switchMenu(\''.$this->product_sku.'_discount_id\');" title="Show/hide query">Show/hide query</a><div id="'.$this->product_sku.'_discount_id" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q_discount).'</div>');
		$this->_db->setQuery($q);
		$this->_db->query($q);
		if ($this->_db->getAffectedRows() > 0) return true;
		else return false;
	}
}
?>