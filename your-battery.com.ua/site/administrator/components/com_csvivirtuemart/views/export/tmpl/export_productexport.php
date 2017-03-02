<?php
/**
* Export products
*
* @package CSVIVirtueMart
* @subpackage Export
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: export_productexport.php 1137 2010-01-23 15:27:16Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' ); 
?>
<div id="productexport">
	<table class="adminlist">
		<thead>
			<tr><th colspan="2"><?php echo JText::_('EXPORT_PRODUCTEXPORT'); ?></th></tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<?php echo JHTML::tooltip(JText::_('EXPORT_PRODUCT_CATEGORY_INFO'), JText::_('EXPORT_PRODUCT_CATEGORY'), 'tooltip.png', '', '', false); ?>
					<?php echo JText::_('EXPORT_PRODUCT_CATEGORY'); ?>
				</td>
				<td>
					<?php echo $this->lists['product_categories']; ?></td>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JHTML::tooltip(JText::_('EXPORT_PRODUCT_SKU_FILTER_INFO'), JText::_('EXPORT_PRODUCT_SKU_FILTER'), 'tooltip.png', '', '', false); ?>
					<?php echo JText::_('EXPORT_PRODUCT_SKU_FILTER'); ?>
				</td>
				<td>
					<input type="text" name="productskufilter" id="productskufilter" />
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JHTML::tooltip(JText::_('EXPORT_PRODUCT_PRICE_QUANTITY_START_INFO'), JText::_('EXPORT_PRODUCT_PRICE_QUANTITY_START'), 'tooltip.png', '', '', false); ?>
					<?php echo JText::_('EXPORT_PRODUCT_PRICE_QUANTITY_START'); ?>
				</td>
				<td>
					<input type="text" name="pricequantitystartfrom" id="pricequantitystartfrom" /> - <input type="text" name="pricequantitystartto" id="pricequantitystartto" />
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JHTML::tooltip(JText::_('EXPORT_PRODUCT_PRICE_QUANTITY_END_INFO'), JText::_('EXPORT_PRODUCT_PRICE_QUANTITY_END'), 'tooltip.png', '', '', false); ?>
					<?php echo JText::_('EXPORT_PRODUCT_PRICE_QUANTITY_END'); ?>
				</td>
				<td>
					<input type="text" name="pricequantityendfrom" id="pricequantityendfrom" /> - <input type="text" name="pricequantityendto" id="pricequantityendto" />
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JHTML::tooltip(JText::_('EXPORT_PRODUCT_STOCK_LEVEL_INFO'), JText::_('EXPORT_PRODUCT_STOCK_LEVEL'), 'tooltip.png', '', '', false); ?>
					<?php echo JText::_('EXPORT_PRODUCT_STOCK_LEVEL'); ?>
				</td>
				<td>
					<input type="text" name="stocklevelstart" id="stocklevelstart" /> - <input type="text" name="stocklevelend" id="stocklevelend" />
				</td>
			</tr>
			<tr>
				<td>
					<?php echo JHTML::tooltip(JText::_('EXPORT_CURRENCY_INFO'), JText::_('EXPORT_CURRENCY'), 'tooltip.png', '', '', false); ?>
					<?php echo JText::_('EXPORT_CURRENCY'); ?>
				</td>
				<td>
					<?php echo $this->lists['targetcurrency']; ?>
				</td>
			</tr>
		</tbody>
	</table>
</div>
