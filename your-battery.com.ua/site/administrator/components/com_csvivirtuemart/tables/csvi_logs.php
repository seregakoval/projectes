<?php
/**
* Logs table
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: csvi_logs.php 1117 2010-01-01 21:39:52Z Roland $
 */

/* No direct access */
defined('_JEXEC') or die('Restricted access');

/**
* @package CSVIVirtueMart
 */
class TableCsvi_logs extends JTable {
	/** @var int Primary key */
	public $id = 0;
	/** @var int Joomla userid */
	public $userid = null;
	/** @var mixed Timestamp import/export took place */
	public $logstamp = null;
	/** @var string The action import or export */
	public $action = null;
	/** @var string The type of action  */
	public $action_type = null;
	/** @var string The name of the template used  */
	public $template_name = null;
	/** @var string The number of processed records  */
	public $records = 0;
	/** @var string A unique ID for the import  */
	public $import_id = 0;
	/** @var string The file that was imported  */
	public $file_name = '';
	
	
	/**
	* @param database A database connector object
	 */
	function __construct($db) {
		parent::__construct('#__csvivirtuemart_logs', 'id', $db );
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