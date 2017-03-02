<?php
/**
* CSV Improved Database class
*
* @package CSVIVirtueMart
* @subpackage Database
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: csvidb.php 1117 2010-01-01 21:39:52Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package CSVIVirtueMart
* @subpackage Database
 */
class CsviDb {
	
	private $_database = null;
	
	public function __construct() {
		$this->_database = JFactory::getDBO();
	}
	
	public function setQuery($sql) {
		$this->_database->setQuery($sql);
		$this->cur = $this->_database->query();
	}
	
	public function getRow() {
		if (!is_object($this->cur)) $array = mysql_fetch_object($this->cur);
		else $array = $this->cur->fetch_object();
		if ($array) {
			return $array;
		}
		else {
			if (!is_object($this->cur)) mysql_free_result( $this->cur );
			else $this->cur->free_result();
			return false;
		}
	}
	
	public function getErrorNum() {
		return $this->_database->getErrorNum();
	}
	
	public function getErrorMsg() {
		return $this->_database->getErrorMsg();
	}
}
?>