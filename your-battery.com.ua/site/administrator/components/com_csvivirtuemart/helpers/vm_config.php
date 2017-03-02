<?php
/**
* VirtueMart config class
*
* @package CSVIVirtueMart
* @subpackage Log
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: vm_config.php 1117 2010-01-01 21:39:52Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/**
* The central logging class
*
* @package CSVIVirtueMart
* @subpackage Log
 */
class CsviVmConfig {
	
	private $_vmcfgfile = null;
	private $_vmcfg = array();
	
	public function __construct() {
		$this->_vmcfgfile = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'virtuemart.cfg.php';
		$this->_vmcfg = file($this->_vmcfgfile);
	}
	
	/**
	* Finds a given VirtueMart setting
	* @var string $setting The config value to find
	* @return string the value of the config setting
	 */
	public function getSetting($setting) {
		$key = $this->array_find($setting, $this->_vmcfg);
		if ($key) {
			$find_setting = explode(',', $this->_vmcfg[$key]);
			return JFilterInput::clean($find_setting[1], 'cmd');
		}
		else return false;
	}
	
	/**
	* Searched the array for a partial value
	* @return mixed Array key if found otherwise false
	 */
	private function array_find($needle, $haystack) {
	   foreach ($haystack as $key => $item) {
		  if (stripos($item, $needle) !== FALSE) {
			 return $key;
			 break;
		  }
	   }
	   /* Nothing found return false */
	   return false;
	}
}
?>