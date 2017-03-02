<?php
/**
* Log details table
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: csvi_log_details.php 1117 2010-01-01 21:39:52Z Roland $
 */

/* No direct access */
defined('_JEXEC') or die('Restricted access');

/**
* @package CSVIVirtueMart
 */
class TableCsvi_log_details extends JTable {
	/** @var int Primary key */
	var $id = 0;
	/** @var int The ID of the log entry */
	var $log_id = null;
	/** @var string Description of the logging entry */
	var $description = null;
	/** @var int The result of the entry */
	var $result = null;
	/** @var string The status of action  */
	public $status = null;
	
	/**
	* @param database A database connector object
	 */
	function __construct($db) {
		parent::__construct('#__csvivirtuemart_log_details', 'id', $db );
	}
	
	/**
	* Cleans the class variables
	 */
	public function reset() {
		$class_vars = get_class_vars(get_class($this));
		foreach ($class_vars as $name => $value) {
			if (substr($name, 0, 1) != '_') $this->$name = $value;
		}
	}
}
?>