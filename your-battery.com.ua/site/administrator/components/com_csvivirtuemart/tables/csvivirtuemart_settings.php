<?php
/**
* Settings table
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: csvivirtuemart_settings.php 1117 2010-01-01 21:39:52Z Roland $
 */

/* No direct access */
defined('_JEXEC') or die('Restricted access');

/**
* @package CSVIVirtueMart
*/
class TableCsvivirtuemart_settings extends JTable {
	/** @var int Primary key */
	var $id = 0;
	/** @var string The settings */
	var $params = null;
	
	/**
	* @param database A database connector object
	*/
	function __construct($db) {
		parent::__construct('#__csvivirtuemart_settings', 'id', $db );
	}
}
?>