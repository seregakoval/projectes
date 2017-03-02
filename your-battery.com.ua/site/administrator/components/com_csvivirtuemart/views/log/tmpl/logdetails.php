<?php
/**
* Details for a log entry
*
* @package CSVIVirtueMart
* @subpackage Log
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: logdetails.php 1117 2010-01-01 21:39:52Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );?>
<table class="adminlist">
	<thead>
	<tr>
		<th colspan="2"><?php echo JText::_('LOG_DETAILS'); ?></th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td><?php echo JText::_('TEMPLATE_TYPE'); ?></td><td><?php echo JText::_($this->logresult['action_type']); ?></td>
	</tr>
	<tr>
		<td><?php echo JText::_('FILE_NAME'); ?></td><td><?php echo JText::_($this->logresult['file_name']); ?></td>
	</tr>
	<tr>
		<td><?php echo JText::_('RECORDS_PROCESSED'); ?></td><td><?php echo JText::_($this->logresult['total_records']); ?></td>
	</tr>
	<tr>
		<td><?php echo JText::_('DEBUG_LOG'); ?></td><td><?php echo $this->logresult['debug']; ?></td>
	</tr>
	</tbody>
</table>
<table class="adminlist">
	<thead>
	<tr>
		<th colspan="3"><?php echo JText::_('LOG_STATISTICS'); ?></th>
	</tr>
	</thead>
	<tbody>
		<?php
		if (empty($this->logresult['result'])) { ?>
			<tr><td><?php echo JText::_('NO_DETAILS_FOUND'); ?></td></tr>
		<?php }
		else { 
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
			<?php } ?> 
		</tbody>
	</table>
	<table class="adminlist">
		<thead>
		<tr>
			<th class="title">
			<?php echo JText::_('LINE'); ?>
			</th>
			<th class="title">
			<?php echo JText::_('ACTION'); ?>
			</th>
			<th class="title">
			<?php echo JText::_('Result'); ?>
			</th>
			<th class="title">
			<?php echo JText::_('Message'); ?>
			</th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach ($this->logmessage as $key => $log) { ?>
			<tr>
				<td>
					<?php echo $log->line; ?>
				</td>
				<td>
					<?php echo JText::_($log->status); ?>
				</td>
				<td>
					<?php echo JText::_($log->result); ?>
				</td>
				<td>
					<?php echo $log->description; ?>
				</td>
			</tr>
			<?php
		}
		?>
		</tbody>
	<?php } ?>
</table>
<form action="index.php" method="post" name="adminForm">
	<input type="hidden" name="option" value="com_csvivirtuemart" />
	<input type="hidden" name="task" value="log" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="controller" value="log" />
</form>
