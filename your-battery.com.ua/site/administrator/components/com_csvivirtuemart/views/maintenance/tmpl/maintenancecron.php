<?php
/**
* Cron result page
*
* @package CSVIVirtueMart
* @subpackage Cron
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: maintenancecron.php 1117 2010-01-01 21:39:52Z Roland $
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
	
	/* String to replace linebreaks with */
	$replacebr = "\n";
	
	/* Get the operation type */
	$operation = JRequest::getVar('operation');
	
	echo JText::_('Results for').' '.JText::_($operation[0])."\n";
	echo str_repeat("=", (strlen(JText::_('Results for'))+strlen(JText::_($operation[0]))+1))."\n";
	$logresult = $csvilog->GetStats();
	$logcount = array();
	for ($i=1, $n = count($logresult); $i <= $n; $i++) {
		if (isset($logresult[$i])) {
			$row = $logresult[$i];
			echo JText::_('Result'); ?>:<?php echo $row['result']."\n";
			echo JText::_('Message')."\n";
			if (count($row['status']) > 0) {
				foreach ($row['status'] as $result => $details) {
					echo str_ireplace($findbr, $replacebr, str_ireplace($find, $replace, $details['message']))."\n";
				}
			}
		}
	}
   /* Show debug log */
   if ($csvilog->debug_message != '') {
	   echo JText::_('Debug message');
	   echo str_ireplace($find, $replace, $csvilog->debug_message);
   }
}
?>