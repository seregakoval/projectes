<?php
/**
* Export template fields
*
* @package CSVIVirtueMart
* @subpackage Export
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: export_templatefieldsexport.php 1117 2010-01-01 21:39:52Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' ); 
?>
<div id="templatefieldsexport">
	<table class="adminlist">
		<thead>
			<tr><th colspan="2"><?php echo JText::_('Export template fields options'); ?></th></tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<?php echo JHTML::tooltip(JText::_('EXPORT_TEMPLATEFIELDS_LIST_INFO'), JText::_('EXPORT_TEMPLATEFIELDS_LIST'), 'tooltip.png', '', '', false); ?>
					<?php echo JText::_('EXPORT_TEMPLATEFIELDS_LIST'); ?>
				</td>
				<td>
					<?php echo $this->lists['exporttemplatefields']; ?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
