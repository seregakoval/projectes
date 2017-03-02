<?php
/**
* Shows the cronline to use for the chosen export
*
* @package CSVIVirtueMart
* @subpackage Export
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: exportcronline.php 1117 2010-01-01 21:39:52Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
?>
<div id="crontitle"><?php echo JText::_('CRONTITLE'); ?></div>
<div id="cronline"><?php echo $this->cronline; ?></div>
<div id="cronnote"><?php echo JText::_('CRONNOTE'); ?></div>