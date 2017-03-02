<?php
/**
* Log results
*
* @todo add link to online documentation
* @package CSVIVirtueMart
* @subpackage Log
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: availablefields.php 1118 2010-01-04 11:39:59Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' ); 
?>
<form action="index.php" method="post" name="adminForm">
	<div id="header">
		<div id="filterbox" style="float: left;">
			<table class="adminlist">
				<tr>
					<td>
						<?php echo JText::_('Filter'); ?>:
						<?php echo $this->list['templatetypes']; ?>
						<input type="text" value="<?php echo JRequest::getVar('filter_avfields'); ?>" name="filter_avfields" id="filter_avfields" size="25" />
						<input type="submit" onclick="this.form.submit();" value="<?php echo JText::_('Go'); ?>" />
						<input type="submit" onclick="document.adminForm.filter_avfields.value = ''; document.adminForm.searchtemplatetype.value='';" value="<?php echo JText::_('Reset'); ?>" />
					 </td>
				</tr>
			</table>
		</div>
	</div>
	<br clear="all" />
	<div id="availablefieldslist" style="text-align: left;">
		<table id="available_fields" class="adminlist">
			<thead>
			<tr>
				<th width="20">
				<?php echo JText::_('ID'); ?>
				</th>
				<th class="title">
				<?php echo JHTML::_('grid.sort', 'CSVI NAME', 'c.csvi_name', $this->list['filter_order_Dir'], $this->list['filter_order'] ); ?>
				</th>
				<th class="title">
				<?php echo JText::_('VM NAME'); ?>
				</th>
				<th class="title">
				<?php echo JText::_('TABLE'); ?>
				</th>
			</tr>
			</thead>
			<?php
			for ($i=0, $n=count( $this->availablefields ); $i < $n; $i++) {
				$row = $this->availablefields[$i];
				?>
				<tr>
					<td align="center">
					<?php echo $this->pagination->getRowOffset($i); ?>
					</td>
					<td>
						<?php echo JHTML::_('link', 'http://www.csvimproved.com/csv-improved-documentation/available-fields/'.str_replace('_', '', $row->csvi_name).'.html', $row->csvi_name, 'target="_blank"'); ?>
					</td>
					<td>
						<?php echo $row->vm_name; ?>
					</td>
					<td>
						<?php echo $row->vm_table; ?>
					</td>
				</tr>
				<?php
			}
			?>
			<tr>
				<td colspan="7"><?php echo $this->pagination->getListFooter(); ?></td>
			 </tr>
		</table>
	</div>
	<input type="hidden" name="option" value="com_csvivirtuemart" />
	<input type="hidden" name="task" value="availablefields" />
	<input type="hidden" name="controller" value="availablefields" />
	<input type="hidden" name="filter_order" value="<?php echo $this->list['filter_order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->list['filter_order_Dir']; ?>" />
</form>
<script type="text/javascript">
	UpdateRowClass('available_fields');
</script>