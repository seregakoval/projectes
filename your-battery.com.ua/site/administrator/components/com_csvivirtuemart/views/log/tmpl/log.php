<?php
/**
* Log results
*
* @package CSVIVirtueMart
* @subpackage Log
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: log.php 1118 2010-01-04 11:39:59Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' ); 
?>
<div class="resultscounter"><?php echo $this->pagination->getResultsCounter(); ?></div>
<br clear="all" />
<div>
<form action="index.php" method="post" name="adminForm">
	<table class="adminlist" id="logs">
		<thead>
		<tr>
			<th width="20">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->logentries); ?>);" />
			</th>
			<th class="title">
			<?php echo JText::_('ACTION'); ?>
			</th>
			<th class="title">
			<?php echo JText::_('ACTION_TYPE'); ?>
			</th>
			<th class="title">
			<?php echo JText::_('TEMPLATE_NAME'); ?>
			</th>
			<th class="title">
			<?php echo JText::_('TIMESTAMP'); ?>
			</th>
			<th class="title">
			<?php echo JText::_('USER'); ?>
			</th>
			<th class="title">
			<?php echo JText::_('RECORDS'); ?>
			</th>
			<th class="title">
			<?php echo JText::_('FILENAME'); ?>
			</th>
			<th class="title">
			<?php echo JText::_('IMPORT_ID'); ?>
			</th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="9"><?php echo $this->pagination->getListFooter(); ?></td>
			 </tr>
        </tfoot>
        <tbody>
		<?php
		/* Check for logentries */
		if ($this->logentries) {
			for ($i=0, $n=count( $this->logentries ); $i < $n; $i++) {
				$row = $this->logentries[$i];
				
				/* Pseudo entry for satisfying Joomla */
				$row->checked_out = 0;
				
				$link 	= 'index2.php?option=com_csvivirtuemart&task=logdetails&controller=log&import_id='. $row->import_id;
				$checked = JHTML::_('grid.checkedout',  $row, $i, 'import_id');
				$user = JFactory::getUser($row->userid);
				?>
				<tr>
					<td>
					<?php echo $checked; ?>
					</td>
					<td>
						<a href="<?php echo $link; ?>"><?php echo JText::_($row->action); ?></a>
					</td>
					<td>
						<?php echo JText::_($row->action_type); ?>
					</td>
					<td>
						<?php echo $row->template_name; ?>
					</td>
					<td>
						<?php echo $row->logstamp; ?>
					</td>
					<td>
						<?php echo $user->name; ?>
					</td>
					<td>
						<?php echo $row->records; ?>
					</td>
					<td>
						<?php echo $row->file_name; ?>
					</td>
					<td>
						<?php echo $row->import_id; ?>
					</td>
				</tr>
				<?php
			}
		}
		else echo '<tr><td colspan="9" class="center">'.JText::_('NO_LOG_ENTRIES_FOUND').'</td></tr>';
		?>
		</tbody>
		</table>
	<input type="hidden" name="option" value="com_csvivirtuemart" />
	<input type="hidden" name="task" value="log" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="controller" value="log" />
</form>
</div>
<script type="text/javascript">
	function submitbutton(pressbutton) {
		// Some conditions
		document.adminForm.task.value=pressbutton;
		if (pressbutton != 'logdetails') {
			if (pressbutton == 'remove') {
				var msg = '<?php echo JText::_('LOG_ARE_YOU_SURE_REMOVE');?>';
				var title = '<?php echo JText::_('DELETE');?>';
			}
			else if (pressbutton == 'remove_all') {
				var msg = '<?php echo JText::_('LOG_ARE_YOU_SURE_REMOVE_ALL');?>';
				var title = '<?php echo JText::_('DELETE_ALL');?>';
			}
			jConfirm(msg, title, function(r) {
				if (r) submitform(pressbutton);
				else return false;
			})
		}
		else submitform(pressbutton);
	}
	UpdateRowClass('logs');
</script>
