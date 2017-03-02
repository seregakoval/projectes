<?php
/**
* Cron result page
*
* @package CSVIVirtueMart
* @subpackage Cron
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: importfilecron.php 1118 2010-01-04 11:39:59Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' ); 

$csvilog = JRequest::getVar('csvilog');

/* Display any messages there are */
if (!empty($csvilog->logmessage)) echo $csvilog->logmessage;
else {
	/* strings to find */
	$find = array();
	$find[] = '<br />';
	$find[] = '<strong>';
	$find[] = '</strong>';
	$find[] = '<hr />';
	
	/* strings to replace with */
	$replace = array();
	$replace[] = "";
	$replace[] = "";
	$replace[] = "";
	$replace[] = "\n";
	
	/* Strings to replace linebreaks */
	$findbr = array();
	$findbr[] = "\r\n";
	$findbr[] = "\r";
	$findbr[] = "\n";
	
	/* String to replace linebreaks with */
	$replacebr = " ";
	
	echo JText::_('Results for').' '.JRequest::getVar('filename')."\n";
	echo str_repeat("=", (strlen(JText::_('Results for'))+strlen(JRequest::getVar('filename'))+1))."\n";
	if (count($this->logresult['result']) > 0) {
		echo JText::_('Total')."\t\t".JText::_('Result')."\t\t".JText::_('STATUS')."\n";
		foreach ($this->logresult['result'] as $result => $log) {
			echo $log->total_result."\t\t".$log->result."\t\t".JText::_($log->status)."\n";
		}
	}
	else echo JText::_('NO_RESULTS_FOUND'); 
}
?>