<?php
/**
* Import result file
*
* @package CSVIVirtueMart
* @subpackage Import
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: import_result.php 1117 2010-01-01 21:39:52Z Roland $
*/
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
?>
<table id="importlog" class="adminlist">
	<thead>
		<tr>
			<th colspan="4" class="message"><?php echo JText::_('Results for').' '.$this->logresult['file_name']; ?></th>
		</tr>
		<tr>
			<th class="title" width="5%">
			<?php echo JText::_('Total'); ?>
			</th>
			<th class="title">
			<?php echo JText::_('Result'); ?>
			</th>
			<th class="title">
			<?php echo JText::_('STATUS'); ?>
			</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="2">
				<?php
				/* Show debug log */
				echo JHTML::_('link', JRoute::_('index2.php?option=com_csvivirtuemart&task=logdetails&controller=log&import_id='.JRequest::getInt('import_id')), JText::_('SHOW_FULL_LOG'));
				?>
			</td>
			<td>
				<?php
				/* Show debug log */
				echo $this->logresult['debug'];
				?>
			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php
	if (count($this->logresult['result']) > 0) {
		foreach ($this->logresult['result'] as $result => $log) { ?>
			<tr>
				<td align="center">
					<?php echo $log->total_result; ?>
				</td>
				<td>
					<?php echo $log->result; ?>
				</td>
				<td>
					<?php echo JText::_($log->status); ?>
				</td>
			</tr>
		<?php }
	}
	else { ?>
		<tr><td colspan="3"><?php echo JText::_('NO_RESULTS_FOUND'); ?></td></tr>
	<?php } ?>
	</tbody>
</table>
<script type="text/javascript">
	UpdateRowClass('importlog');
</script> 
