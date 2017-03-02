<?php
/**
* Product reviews import
*
* @package CSVIVirtueMart
* @subpackage Import
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: productreviewsimport.php 1117 2010-01-01 21:39:52Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Processor for shipping rates
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartModelProductreviewsimport extends JModel {
	
	/* Private tables */
	private $_vm_product_reviews = null;
	/* Public variables */
	
	/* Private variables */
	/** @var mixed contains the data of the current field being processed */
	private $_datafield = null;
	/** @var object contains general import functions */
	private $_importmodel = null;
	
	/**
	* Here starts the processing
	 */
	public function getStart() {
		/* Get the general import functions */
		$this->_importmodel = new CsvivirtuemartModelimport();
		
		/* Get the imported fields */
		$csv_fields = JRequest::getVar('csv_fields');
		
		/* Get the statistics */
		$csvilog = JRequest::getVar('csvilog');
		
		/* Get the product ID */
		$this->product_id = $this->_importmodel->GetProductId();
		
		/* Check if the fields match the data */
		if (count($csv_fields) != count(JRequest::getVar('csvi_data'))) {
			$find = array('{configfields}', '{filefields}');
			$replace = array(count($csv_fields), count(JRequest::getVar('csvi_data')));
			$csvilog->AddStats('incorrect', str_ireplace($find, $replace, JText::_('INCORRECT_COLUMN_COUNT')), true);
			return false;
		}
		/* All good, let's continue */
		else {
			/* Get the uploaded values */
			foreach ($csv_fields as $name => $details) {
				if ($details['published']) {
					$this->_datafield = $this->_importmodel->ValidateCsvInput($name);
					if ($this->_datafield !== false) {
						/* Check if the field needs extra treatment */
						switch ($name) {
							case 'time':
								$this->$name = $this->ConvertDate();
								break;
							default:
								$this->$name = $this->_datafield;
								break;
						}
					}
					else {
						/* Columns do not match */
						JRequest::setVar('error_found', true);
						$csvi_data = JRequest::getVar('csvi_data');
						$find = array('{configfields}', '{filefields}');
						$replace = array(count($csv_fields), count($csvi_data));
						$fields = array_keys($csv_fields);
						$message =  str_ireplace($find, $replace, JText::_('INCORRECT_COLUMN_COUNT'));
						$message .= '<br />'.JText::_('FIELDS');
						foreach($csv_fields as $fieldname => $field_details) {
							$message .= '<br />'.$field_details['order'].': '.$fieldname;
						}
						$message .= '<br />'.JText::_('VALUE');
						foreach ($csvi_data AS $key => $data) {
							$message .= '<br />'.$key.': '.$data;
						}
						$csvilog->AddStats('incorrect', $message, true);
						
						return false;
					}
				}
			}
		}
		return true;
	}
	
	/**
	* Getting the product table info
	 */
	private function getTables() {
		$this->_vm_product_reviews = $this->getTable('vm_product_reviews');
	}
	
	/**
	* Getting the product table info
	 */
	private function getCleanTables() {
		$this->_vm_product_reviews->reset();
		$this->reset();
	}
	
	/**
	* Clean the variables
	 */
	private function reset() {
		$class_vars = get_class_vars(get_class($this));
		foreach ($class_vars as $name => $value) {
			if (substr($name, 0, 1) != '_') $this->$name = $value;
		}
	}
	
	/**
	* Process each record and store it in the database
	*
	* @todo Add logging
	 */
	public function getProcessRecord() {
		/* Get the imported values */
		$csv_fields = JRequest::getVar('csv_fields');
		$product_data = JRequest::getVar('csvi_data');
		$csvilog = JRequest::getVar('csvilog');
		$db = JFactory::getDBO();
		
		/* Get the tables loaded */
		$this->getTables();
		
		/* Get the currency ID, the code takes preference over the name because it is less error prone */
		if (isset($this->username)) {
			$q = "SELECT id FROM #__users WHERE username = ".$db->Quote($this->username);
			$db->setQuery($q);
			$this->userid = $db->loadResult();
		}
		$this->_vm_product_reviews->bind($this);
		if ($this->_vm_product_reviews->store()) {
			$csvilog->AddMessage('debug', JText::_('DEBUG_PRODUCT_REVIEW_ADDED'), true);
			$csvilog->AddStats('added', JText::_('PRODUCT_REVIEW_ADDED'));
		}
		else {
			$csvilog->AddMessage('debug', JText::_('DEBUG_PRODUCT_REVIEW_NOT_ADDED'), true);
			$csvilog->AddStats('incorrect', JText::_('PRODUCT_REVIEW_NOT_ADDED'));
		}
		
		/* Clean the tables */
		$this->getCleanTables();
	}
	
	/**
	* Format a date to unix timestamp
	*
	* Format of the date is day/month/year or day-month-year.
	*
	* @link http://www.csvimproved.com/wiki/doku.php/csvimproved:availablefields:product_available_date
	* @return integer UNIX timestamp if date is valid otherwise return 0
	* @todo use JDate
	 */
	private function ConvertDate() {
		/* Date must be in the format of day/month/year or day-month-year */
		$new_date = preg_replace('/-|\./', '/', $this->_datafield);
		$date_parts = explode('/', $new_date);
		if ((count($date_parts) == 3) && ($date_parts[0] > 0 && $date_parts[0] < 32 && $date_parts[1] > 0 && $date_parts[1] < 13 && (strlen($date_parts[2]) == 4))) {
			$old_date = mktime(0,0,0,$date_parts[1],$date_parts[0],$date_parts[2]);
		}
		else $old_date = 0;
		return $old_date;
	}
}
?>
