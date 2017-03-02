<?php
/**
* Joomla User table
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: users.php 1117 2010-01-01 21:39:52Z Roland $
 */

/* No direct access */
defined('_JEXEC') or die('Restricted access');

/**
* @package CSVIVirtueMart
 */
class TableUsers extends JTable {
	
	/**
	* @param database A database connector object
	 */
	function __construct($db) {
		$this->reset();
		parent::__construct('#__users', 'id', $db );
	}
	
	/**
	* Cleans the class variables
	 */
	public function reset() {
		$this->setProperties(CsvivirtuemartModelAvailablefields::DbFields('users'));
	}
}
?>