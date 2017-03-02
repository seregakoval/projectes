<?php
/**
* Virtuemart Discount table
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: vm_product_discount.php 1117 2010-01-01 21:39:52Z Roland $
 */

/* No direct access */
defined('_JEXEC') or die('Restricted access');

/**
* @package CSVIVirtueMart
 */
class TableVm_product_discount extends JTable {
	
	/* Sets whether the database columns have been loaded */
	private $_loaded = false;

	/**
	* @param database A database connector object
	 */
	public function __construct($db) {
		$this->reset();
		parent::__construct('#__vm_product_discount', 'discount_id', $db );
	}
	
	/**
	* Resets the default properties
	* @return	void
	 */
	function reset() {
		if (!$this->_loaded) {
			$this->setProperties(CsvivirtuemartModelAvailablefields::DbFields('vm_product_discount'));
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
	* Check if a discount already exists. If so, retrieve the discount ID
	 */
	public function check() {
		$db = JFactory::getDBO();
		/* Check if the amount exists in the database */
		$q_discount = "SELECT COUNT(discount_id) AS total_discount_ids 
					FROM #__vm_product_discount 
					WHERE amount = '".$this->amount."' ";
		$q_discount .= "AND is_percent = '".$this->is_percent."' ";
		$q_discount .= "AND start_date = '".$this->start_date."' ";
		$q_discount .= "AND end_date = '".$this->end_date."'";
		// $csvilog->AddMessage('debug', 'Check if a discount exists: <a onclick="switchMenu(\''.$this->product_sku.'_product_discount\');" title="Show/hide query">Show/hide query</a><div id="'.$this->product_sku.'_product_discount" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q_discount).'</div>');
		$db->setQuery($q_discount);
		$db->query();
		/* There are multiple discount ids, we take the first one */
		if ($db->loadResult() > 0) {
			$q_discount = "SELECT MIN(discount_id) AS discount_id 
						FROM #__vm_product_discount 
						WHERE amount = '".$this->amount."' ";
			$q_discount .= "AND is_percent = '".$this->is_percent."' ";
			$q_discount .= "AND start_date = '".$this->start_date."' ";
			$q_discount .= "AND end_date = '".$this->end_date."'";
			// $csvilog->AddMessage('debug', 'Discount exists, return discount id: <a onclick="switchMenu(\''.$this->product_sku.'_discount_id\');" title="Show/hide query">Show/hide query</a><div id="'.$this->product_sku.'_discount_id" style="display: none; border: 1px solid #000000; padding: 5px;">'.htmlentities($q_discount).'</div>');
			$db->setQuery($q_discount);
			$this->setValue('discount_id', $db->loadResult());
		}
		else $this->setValue('discount_id', 0);
		return true;
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
}
?>