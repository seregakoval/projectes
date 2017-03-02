<?php
/**
* Main file processor class
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: log.php 1117 2010-01-01 21:39:52Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/**
 * Helper class for logging
 * @package CSVIVirtueMart
 */
class CsviHelperLog {
    /**
     * Simple log
     * @param string $comment  The comment to log
     */
    public function simpleLog($comment, $linenr) {
        /* Include the library dependancies */
        jimport('joomla.error.log');
        $options = array('format' => "{DATE}\t{TIME}\t{LINE_NR}\t{COMMENT}");
        
        /* Set the logfile */
        self::getLogName();
        
        /* Create the instance of the log file in case we use it later */
        $log = JLog::getInstance($this->logfile, $options, $this->logpath);
        $log->addEntry(array('comment' => $comment, 'line_nr' => $linenr));
    }
    
    public function getLogName() {
    	$csvilog = JRequest::getVar('csvilog');
        $this->logfile = 'com_csvivirtuemart.log.'.$csvilog->getImportId().'.php';
        $this->logpath = JPATH_ROOT.DS.'administrator'.DS.'cache'.DS.'com_csvivirtuemart'.DS.'debug'.DS;
        
    	return $this->logpath.$this->logfile;
    }
}
?>
