<?php
/**
* Export page
*
* @package CSVIVirtueMart
* @subpackage Export
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: export.php 1128 2010-01-11 18:36:29Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
JHTML::_('behavior.modal');
JHTML::_('behavior.tooltip');
JHTML::_('behavior.calendar');
?>
<form action="index.php" method="post" name="adminForm">
	<table id="templates" class="adminlist">
	<thead><tr>
		<th class="showallbutton">
			<?php echo JHTML::tooltip(JText::_('SHOW_ALL_BUTTON_EXPORT'), JText::_('EXPORT'), 'tooltip.png', '', '', false); ?>
			<a class="showexportoption" onclick="switchRow('all'); showExportDiv();" title="<?php echo JText::_('Template name'); ?>"><?php echo JText::_('Template name'); ?></a>
		</th>
		<th><?php echo JText::_('Template type'); ?></th>
		<th><?php echo JText::_('Field delimiter'); ?></th>
		<th><?php echo JText::_('Text delimiter'); ?></th>
		<th><?php echo JText::_('EXPORT_TYPE'); ?></th>
		<th><?php echo JText::_('Use column headers'); ?></th>
		<th><?php echo JText::_('Number of fields'); ?></th>
	</tr></thead>
	<tbody>
	<?php 
		$selected = JRequest::getInt('template_id', $this->templates[0]->template_id);
		foreach ($this->templates as $key => $details) { ?>
		<?php $rid = rand(); ?>
		<tr id="<?php echo $rid; ?>" class="optionrow_block">
			<td>
				<?php $active = ($details->numberoffields > 0) ? '' : 'disabled';
				echo JHTML::_('select.radiolist', array($details), 'template_id', $active.' class="inputbox" onclick="switchRow(\''.$rid.'\'); showExportDiv(\''.strtolower($details->template_type).'\');"', 'template_id', 'template_name', $selected); ?>
			</td>
			<td><?php echo JText::_($details->template_type); ?></td>
			<td><?php echo $details->field_delimiter; ?></td>
			<td><?php echo $details->text_enclosure; ?></td>
			<td><?php echo JText::_($details->export_type); ?></td>
			<td><?php if ($details->include_column_headers) echo JText::_('Yes');
				else echo JText::_('No');?></td>
			<?php $link = JRoute::_('index3.php?option=com_csvivirtuemart&controller=templates&task=listfields&template_id='.$details->template_id); ?>
			<td><?php echo JHTML::_('link', $link, $details->numberoffields.' '.JText::_('FIELDS'), array('class' => 'modal', 'rel' => '{handler: \'iframe\', size: {x: 600, y: 400}}')); ?></td>
		</tr>
	<?php } ?>
	</tbody>
	<tfoot>
		<tr><td colspan="9"></td></tr>
	</tfoot>
	</table>
	<br />
	<div id="extraoptions">
		<?php echo $this->loadTemplate('general'); ?>
	</div>
	<input type="hidden" name="option" value="com_csvivirtuemart" />
	<input type="hidden" name="task" value="exportfile" />
	<input type="hidden" name="controller" value="exportfile" />
</form>
<script type="text/javascript">
	UpdateRowClass('templates');
</script>