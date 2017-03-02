<?php
/**
* Virtuemart Coupons table
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: vm_coupons.php 1117 2010-01-01 21:39:52Z Roland $
 */

/* No direct access */
defined('_JEXEC') or die('Restricted access');

/**
* @package CSVIVirtueMart
 */
class TableVm_coupons extends JTable {
	
	/* Sets whether the database columns have been loaded */
	private $_loaded = false;
	
	/**
	* @param database A database connector object
	 */
	function __construct($db) {
		$this->reset();
		parent::__construct('#__vm_coupons', 'coupon_id', $db );
	}
	
	/**
	* Resets the default properties
	* @return	void
	 */
	function reset() {
		if (!$this->_loaded) {
			$this->setProperties(CsvivirtuemartModelAvailablefields::DbFields('vm_coupons'));
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
	* Check if a coupon already exists
	 */
	public function check() {
		if (isset($this->coupon_id)) return true;
		else {
			$db = JFactory::getDBO();
			$csvilog = JRequest::getVar('csvilog');
			$q = "SELECT ".$this->_tbl_key."
				FROM ".$this->_tbl."
				WHERE coupon_code='".$this->coupon_code."'";
			$db->setQuery($q);
			$csvilog->AddMessage('debug', JText::_('CHECK_COUPON_CODE_EXISTS'), true);
			$db->query();
			if ($db->getAffectedRows() > 0) {
				$this->coupon_id = $db->loadResult();
			}
		}
	}
}
?>
