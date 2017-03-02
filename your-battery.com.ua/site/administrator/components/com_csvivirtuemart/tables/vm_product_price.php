<?php
/**
* Virtuemart Product Price table
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: vm_product_price.php 1117 2010-01-01 21:39:52Z Roland $
 */

/* No direct access */
defined('_JEXEC') or die('Restricted access');

/**
* @package CSVIVirtueMart
 */
class TableVm_product_price extends JTable {
	
	/* Sets whether the database columns have been loaded */
	private $_loaded = false;
	
	/**
	* @param database A database connector object
	 */
	function __construct($db) {
		$this->reset();
		parent::__construct('#__vm_product_price', 'product_price_id', $db );
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
			$this->setProperties(CsvivirtuemartModelAvailablefields::DbFields('vm_product_price'));
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
	* Check if a price already exists
	*
	* Criteria for an existing price are:
	* - product id
	* - shopper group id
	* If both exists, price will be updated
	 */
	public function check() {
		$db = JFactory::getDBO();
		$q = "SELECT ".$this->_tbl_key."
			FROM ".$this->_tbl."
			WHERE product_id='".$this->product_id."'
			AND shopper_group_id = '".$this->shopper_group_id."'";
		$db->setQuery($q);
		$this->setValue('product_price_id', $db->loadResult());
	}
	
	/**
	* Check if a price already exists for multiple prices import
	*
	* Criteria for an existing price are:
	* - product id
	* - shopper group id
	* - product currency
	* - price quantity start
	* - price quantity end
	* If both exists, price will be updated
	 */
	public function checkMultiple() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		$q = "SELECT ".$this->_tbl_key."
			FROM ".$this->_tbl."
			WHERE product_id='".$this->product_id."'
			AND product_currency = '".$this->product_currency."' 
			AND shopper_group_id = '".$this->shopper_group_id."'
			AND price_quantity_start = '".$this->price_quantity_start."' 
			AND price_quantity_end = '".$this->price_quantity_end."'";
		$db->setQuery($q);
		$csvilog->AddMessage('debug', JText::_('Finding a product_price_id'), true);
		$this->setValue('product_price_id', $db->loadResult());
	}
	/**
	* See if we can find a shopper group ID
	 */
	public function getShopperGroupID() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		$q = "SELECT shopper_group_id
			FROM ".$this->_tbl."
			WHERE product_id = ".$this->product_id;
		$db->setQuery($q);
		$csvilog->AddMessage('debug', JText::_('Finding a product price shopper group ID'), true);
		return $db->loadResultArray();
	}
	/**
	* This function calculates the new price by adding the uploaded value
	* to the current price
	*
	* Prices can be calculated with:
	* - Add (+)
	* - Subtract (-)
	* - Divide (/)
	* - Multiply (*)
	*
	* Add and subtract support percentages
	*
	* @todo logging
	 */
	public function CalculatePrice() {
		/* Get the price value */
		$modify = $this->product_price;
		
		/* Clone the current instance as we don't want the DB values overwrite the uploaded values */
		$newprice = clone $this;
		
		/* Get the current price in the database */
		$newprice->check();
		$newprice->load($this->product_price_id);
		$this->product_price_id = $newprice->product_price_id;
		
		/* Set the price to calculate with */
		$price = $newprice->product_price;
		
		/* Check if we have a percentage value */
		if (substr($modify, -1) == '%') {
			$modify = substr($modify, 0, -1);
			$percent = true;
		}
		else {
			$percent = false;
		}
		
		/* Split the modification */
		$operation = substr($modify, 0, 1);
		$value = substr($modify, 1);
		
		/* Check what modification we need to do and apply it */
		switch ($operation) {
			case '+':
				if ($percent) $price += $price* ($value/100);
				else $price += $value;
				break;
			case '-':
				if ($percent) $price -= $price* ($value/100);
				else $price -= $value;
				break;
			case '/':
				$price /= $value;
				break;
			case '*':
				$price*= $value;
				break;
			default:
				/* Assign the current price to prevent it being overwritten */
				$price = $this->product_price;
				break;
		}
		/* Set the new price */
		$this->product_price = $price;
	}
}
?>