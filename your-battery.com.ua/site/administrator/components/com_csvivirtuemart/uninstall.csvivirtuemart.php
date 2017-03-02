<?php
/**
* Un-installation file for CSVI VirtueMart
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: uninstall.csvivirtuemart.php 1152 2010-02-07 09:42:42Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Uninstaller
 */
function com_uninstall() {
	$mainframe = JFactory::getApplication();
	$mainframe->enqueueMessage('CSVI VirtueMart 2.1.3 has been uninstalled');
}
?>