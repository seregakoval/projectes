<?php
/**
* Templates table
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: csvivirtuemart_template_fields.php 1117 2010-01-01 21:39:52Z Roland $
 */

/* No direct access */
defined('_JEXEC') or die('Restricted access');

/**
* @package CSVIVirtueMart
 */
class TableCsvivirtuemart_template_fields extends JTable {
	/** @var int Primary key */
	var $id = 0;
	/** @var int */
	var $field_template_id = null;
	/** @var string */
	var $field_name = null;
	/** @var string */
	var $field_column_header = 0;
	/** @var string */
	var $field_default_value = 0;
	/** @var int */
	var $field_order = 0;
	/** @var int */
	var $published = 0;
	/** @var int */
	var $checked_out = 0;
	/** @var bool Sets if the field needs to replaced during import/export */
	var $field_replace = 0;
	
	/**
	* @param database A database connector object
	 */
	function __construct($db) {
		parent::__construct('#__csvivirtuemart_template_fields', 'id', $db );
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