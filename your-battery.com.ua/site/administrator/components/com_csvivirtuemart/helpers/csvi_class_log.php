<?php
/**
* Logging class
*
* @package CSVIVirtueMart
* @subpackage Log
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: csvi_class_log.php 1117 2010-01-01 21:39:52Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/**
* The central logging class
*
* @package CSVIVirtueMart
* @subpackage Log
 */
class CsviLog {
	
	/* Private variables */
	/** @var int contains the current line number */
	private $_linenumber = 1;
	/** @var int contains a unique id for the import */
	private $_import_id = 0;
	/** @var string The name of the file being imported */
	private $_file_name = '';
	/** @var bool The status if debug info is to be collected */
	private $_debug = false;
	
	/* Public variables */
	/** @var string contains the log messages */
	public $logmessage = '';
	/** @var string contains the debug messages */
	public $debug_message = '';
	/** @var array contains the import statistics */
	public $stats = array();
	
	public function __construct() {
	}
	
	/**
	* Set the current line number
	*/
	public function setLinenumber($linenumber) {
		$this->_linenumber = $linenumber;
		return true;
	}
	
	/**
	* Set the import ID
	*/
	public function setImportId($import_id=false) {
		if ($import_id) $this->_import_id = $import_id;
		else $this->_import_id = time();
		return $this->_import_id;
	}
	
	/**
	* Get the import ID
	*/
	public function getImportId() {
		return $this->_import_id;
	}
	
	/**
	* Set the import filename
	*/
	public function setFilename($filename) {
		$this->_file_name = $filename;
	}
	
	/**
	* Get the import ID
	*/
	public function getFilename() {
		return $this->_file_name;
	}
	
	/**
	* Set the debug status
	*/
	public function setDebug($val) {
		$this->_debug = $val;
	}
	
	/**
	* Adds a message to the log stack
	*
	* @param string $type type of message
	* @param string $message message to add to the stack
	* @param boolean $sql if true adds a div box with the sql statement
	*/
	function AddMessage($type, $message, $sql=false) {
		switch ($type) {
			case 'debug':
				if ($this->_debug) {
					$querymsg = '';
					if ($sql) {
						$db = JFactory::getDBO();
						if ($db->getErrorNum() > 0) $querymsg .= '[SQL ERROR] '.$db->getErrorMsg();
						else $querymsg .= '[QUERY] '.$db->getQuery();
						$querymsg = "\n\t\t\t\t\t\t\t".str_replace(array("\r\n", "\n", "\r", "\t"), ' ', $querymsg);
					}
					CsviHelperLog::simpleLog($message.$querymsg, (JRequest::getInt('currentline')+JRequest::getInt('totalline')));
				}
				break;
			default:
				$this->logmessage .= $message."<br />\n";
				break;
		}
	}
	
	/**
	* Adds a message to the statistics stack
	*
	* <p>
	* Types:
	* --> Products
	* updated
	* deleted
	* added
	* skipped
	* incorrect
	* --> DB tables
	* empty
	* --> Fields
	* nosupport
	* --> No files found multiple images
	* nofiles
	* --> General information
	* information
	* </p>
	*
	* @param string $type type of message
	* @param string $message message to add to the stack
	* @param boolean $line prefix linenumber to message
	 */
	function AddStats($type, $message, $line=false) {
		/* Set the result */
		$success = array('updated', 'deleted', 'added', 'empty');
		$failure = array('skipped', 'incorrect', 'nosupport');
		$notice = array('information', 'nofiles');
		if (in_array($type, $success)) $result = JText::_('SUCCESS');
		else if (in_array($type, $failure)) $result = JText::_('FAILURE');
		else if (in_array($type, $notice)) $result = JText::_('NOTICE');
		
		/* Set the message */
		if ($line) $message = str_replace('{currentline}', $this->_linenumber, JText::_('LINENUMBER')).' '.$message;
		
		if (!isset($this->stats[$this->_linenumber]['status'][$type])) {
			$this->stats[$this->_linenumber]['status'][$type]['message'] = $message."<br />\n";
		}
		else {
			$this->stats[$this->_linenumber]['status'][$type]['message'] .= $message."<br />\n";
		}
		$this->stats[$this->_linenumber]['status'][$type]['result'] = $result;
	}
	
	/**
	* Retrieves the log message
	* @return string returns the log message
	 */
	function GetLogMessage() {
		return $this->logmessage;
	}
	
	/**
	* Retrieves the debug message
	* @return string returns the debug message
	 */
	function GetDebugMessage() {
		return $this->debug_message;
	}
	
	/**
	* Retrieves the statistics array
	* @return array returns the statistics array
	 */
	function GetStats() {
		return $this->stats;
	}
	
	/**
	* Set the type of action the log is for
	 */
	public function SetAction($action) {
		$this->stats['action'] = strtolower($action);
	}
	
	/**
	* Set the type of action the log is for
	 */
	public function SetActionType($action, $template_name='') {
		$this->stats['action_type'] = strtolower($action);
		$this->stats['action_template'] = $template_name;
	}
}
?>
