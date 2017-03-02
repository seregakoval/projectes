<?php
/**
* Maintenance page
*
* @package CSVIVirtueMart
* @subpackage Maintenance
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: maintenance.php 1117 2010-01-01 21:39:52Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
JHTML::_('behavior.tooltip');
$cb = 0;
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" name="adminForm">
	<table id="maintenance" class="adminlist">
	<thead>
		<tr>
			<th><?php echo JText::_('TYPE');?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<input type="radio" id="cb<?php echo $cb; ?>" name="operation[]" value="RemoveOrphan" onclick="isChecked(this.checked);" />
				<?php echo JHTML::tooltip(JText::_('REMOVEORPHAN_TIP'), JText::_('REMOVEORPHAN'), 'tooltip.png', '', '', false); ?>
				<?php echo JText::_('REMOVEORPHAN'); ?>
			</td>
		</tr>
		<tr>
			<td>
				<input type="radio" id="cb<?php echo $cb++; ?>" name="operation[]" value="OptimizeTables" onclick="isChecked(this.checked);" />
				<?php echo JHTML::tooltip(JText::_('OPTIMIZETABLES_TIP'), JText::_('OPTIMIZETABLES'), 'tooltip.png', '', '', false); ?>
				<?php echo JText::_('OPTIMIZETABLES'); ?>
			</td>
		</tr>
		<tr>
			<td>
				<input type="radio" id="cb<?php echo $cb++; ?>" name="operation[]" value="SortCategories" onclick="isChecked(this.checked);" />
				<?php echo JHTML::tooltip(JText::_('SORTCATEGORIES_TIP'), JText::_('SORTCATEGORIES'), 'tooltip.png', '', '', false); ?>
				<?php echo JText::_('SORTCATEGORIES'); ?>
			</td>
		</tr>
		<tr>
			<td>
				<input type="radio" id="cb<?php echo $cb++; ?>" name="operation[]" value="RemoveEmptyCategories" onclick="if (confirm('<?php echo JText::_('CONFIRM_CATEGORY_DELETE'); ?>')) { isChecked(this.checked); } else { jQuery(this).attr('checked', ''); jQuery('input[name=\'boxchecked\']').val('0'); }" />
				<?php echo JHTML::tooltip(JText::_('REMOVEEMPTYCATEGORIES_TIP'), JText::_('REMOVEEMPTYCATEGORIES'), 'tooltip.png', '', '', false); ?>
				<?php echo JText::_('REMOVEEMPTYCATEGORIES'); ?>
			</td>
		</tr>
		<tr>
			<td>
				<input type="radio" id="cb<?php echo $cb++; ?>" name="operation[]" value="UpdateAvailableFields" onclick="isChecked(this.checked);" />
				<?php echo JHTML::tooltip(JText::_('UPDATEAVAILABLEFIELDS_TIP'), JText::_('UPDATEAVAILABLEFIELDS'), 'tooltip.png', '', '', false); ?>
				<?php echo JText::_('UPDATEAVAILABLEFIELDS'); ?>
			</td>
		</tr>
		<tr>
			<td>
				<input type="radio" id="cb<?php echo $cb++; ?>" name="operation[]" value="InstallDefaultTemplates" onclick="isChecked(this.checked);" />
				<?php echo JHTML::tooltip(JText::_('INSTALLDEFAULTTEMPLATES_TIP'), JText::_('INSTALLDEFAULTTEMPLATES'), 'tooltip.png', '', '', false); ?>
				<?php echo JText::_('INSTALLDEFAULTTEMPLATES'); ?>
			</td>
		</tr>
		<tr id="resizeproducttitle">
			<td>
			<input type="radio" id="cb<?php echo $cb++; ?>" name="operation[]" value="ResizeProductName" onclick="AddProductNameField('<?php echo JText::_('NAME_LENGTH')?>','<?php echo JText::_('NAME_LENGTH_MAX')?>', '<?php echo str_ireplace('{cursize}', $this->sizeproductname, JText::_('CURRENT_NAME_LENGTH'));?>'); isChecked(this.checked);" />
				<?php echo JHTML::tooltip(JText::_('RESIZEPRODUCTNAME_TIP'), JText::_('RESIZEPRODUCTNAME'), 'tooltip.png', '', '', false); ?>
				<?php echo JText::_('RESIZEPRODUCTNAME'); ?>
			</td>
		</tr>
		<tr id="currency_exchange_rates">
			<td>
			<input type="radio" id="cb<?php echo $cb++; ?>" name="operation[]" value="ExchangeRates" onclick="isChecked(this.checked);" />
				<?php echo JHTML::tooltip(JText::_('EXCHANGERATES_TIP'), JText::_('EXCHANGERATES'), 'tooltip.png', '', '', false); ?>
				<?php echo JText::_('EXCHANGERATES'); ?>
			</td>
		</tr>
		<tr id="debug_logs">
			<td>
			<input type="radio" id="cb<?php echo $cb++; ?>" name="operation[]" value="CleanCache" onclick="isChecked(this.checked);" />
				<?php echo JHTML::tooltip(JText::_('CLEANCACHE_TIP'), JText::_('CLEANCACHE'), 'tooltip.png', '', '', false); ?>
				<?php echo JText::_('CLEANCACHE'); ?>
			</td>
		</tr>
		<tr>
			<td>
			<input type="radio" id="cb<?php echo $cb++; ?>" name="operation[]" value="EmptyDatabase" onclick="confirmDelete(this);" />
				<?php echo JHTML::tooltip(JText::_('EMPTYDATABASE_TIP'), JText::_('EMPTYDATABASE'), 'tooltip.png', '', '', false); ?>
				<?php echo JText::_('EMPTYDATABASE'); ?>
			</td>
		</tr>
	</tbody>
	<input type="hidden" name="controller" value="maintenance" />
	<input type="hidden" name="task" value="maintenance" />
	<input type="hidden" name="option" value="com_csvivirtuemart" />
	<input type="hidden" name="boxchecked" value="" />
	</table>
</form>
<script type="text/javascript">
	function confirmDelete(el) {
		jConfirm('<?php echo JText::_('CONFIRM_DB_DELETE'); ?>', '<?php echo JText::_('EMPTYDATABASE'); ?>', function(r) {
			if (r) isChecked(jQuery(el).checked);
			else {
				jQuery(el).attr('checked', ''); jQuery('input[name=\'boxchecked\']').val('0');
			}
		})
	}
	UpdateRowClass('maintenance');
</script>
