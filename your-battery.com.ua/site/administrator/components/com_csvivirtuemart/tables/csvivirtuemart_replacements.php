<?php
/**
* Replacements table
*
* @package CSVIVirtueMart
* @subpackage Tables
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: csvivirtuemart_replacements.php 1138 2010-01-27 22:54:36Z Roland $
 */

/* No direct access */
defined('_JEXEC') or die('Restricted access');

/**
* @package CSVIVirtueMart
* @subpackage Tables
 */
class TableCsvivirtuemart_replacements extends JTable {
	/** @var int Primary key */
	public $id = 0;
	/** @var string Old value to be replaced */
	public $old_value = null;
	/** @var string New value to be applied */
	public $new_value = null;
	/** @var int The published state */
	public $published = 0;
	/** @var int Regular expression or not? */
	public $regex = 0;
	/** @var int Template the replacement belongs to */
	public $template_id = 0;
	/** @var int Template field the replacement belongs to */
	public $field_id = 0;
	
	/**
	* @param database A database connector object
	 */
	function __construct($db) {
		parent::__construct('#__csvivirtuemart_replacements', 'id', $db );
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