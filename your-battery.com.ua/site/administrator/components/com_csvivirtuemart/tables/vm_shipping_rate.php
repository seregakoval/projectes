<?php
/**
* Virtuemart Shipping rates table
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: vm_shipping_rate.php 1129 2010-01-14 10:33:40Z Roland $
 */

/* No direct access */
defined('_JEXEC') or die('Restricted access');

/**
* @package CSVIVirtueMart
 */
class TableVm_shipping_rate extends JTable {
	
	/* Sets whether the database columns have been loaded */
	private $_loaded = false;
	/**
	* @param database A database connector object
	 */
	function __construct($db) {
		$this->reset();
		parent::__construct('#__vm_shipping_rate', 'shipping_rate_id', $db );
	}
	
	/**
	* Resets the default properties
	* @return	void
	 */
	function reset() {
		if (!$this->_loaded) {
			$this->setProperties(CsvivirtuemartModelAvailablefields::DbFields('vm_shipping_rate'));
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
	* Check for an existing shipping rate
	*
	* Shipping rate ID is determined by the following criteria:
	* - shipping rate name
	* - shipping rate weight start
	* - shipping rate weight end
	* - shipping rate zip start
	* - shipping rate zip end
	*/
	public function check() {
		if (empty($this->shipping_rate_id)) {
			$db = JFactory::getDBO();
			$csvilog = JRequest::getVar('csvilog');
			/* Get the shipping rate ID */
			$q = "SELECT shipping_rate_id 
				FROM ".$db->nameQuote('#__vm_shipping_rate')." 
				WHERE ".$db->nameQuote('shipping_rate_name')." = ".$db->Quote($this->shipping_rate_name)." 
				AND ".$db->nameQuote('shipping_rate_weight_start')." = ".$db->Quote($this->shipping_rate_weight_start)."
				AND ".$db->nameQuote('shipping_rate_weight_end')." = ".$db->Quote($this->shipping_rate_weight_end)."
				AND ".$db->nameQuote('shipping_rate_zip_start')." = ".$db->Quote($this->shipping_rate_zip_start)."
				AND ".$db->nameQuote('shipping_rate_zip_end')." = ".$db->Quote($this->shipping_rate_zip_end)."
				LIMIT 1";
			$db->setQuery($q);
			$csvilog->AddMessage('debug', JText::_('DEBUG_FIND_SHIPPING_RATE_ID'), true);
			$this->shipping_rate_id = $db->loadResult();
		}
	}
}
?>
