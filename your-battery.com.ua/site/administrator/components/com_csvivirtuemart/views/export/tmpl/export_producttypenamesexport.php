<?php
/**
* Export products
*
* @package CSVIVirtueMart
* @subpackage Export
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: export_producttypenamesexport.php 1117 2010-01-01 21:39:52Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' ); 
?>
<div id="producttypenamesexport">
	<table class="adminlist">
		<thead>
			<tr><th colspan="2"><?php echo JText::_('EXPORT_PRODUCTTYPENAMES'); ?></th></tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<?php echo JHTML::tooltip(JText::_('EXPORT_PRODUCT_TYPE_NAMES_INFO'), JText::_('EXPORT_PRODUCT_TYPE_NAMES'), 'tooltip.png', '', '', false); ?>
					<?php echo JText::_('EXPORT_PRODUCT_TYPE_NAMES'); ?>
				</td>
				<td>
					<?php echo $this->lists['producttypenames']; ?></td>
				</td>
			</tr>
		</tbody>
	</table>
</div>
