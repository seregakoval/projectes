<?php
/**
* Maintenance log
*
* @package CSVIVirtueMart
* @subpackage Maintenance
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: maintenancelog.php 1117 2010-01-01 21:39:52Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' ); 
?>
<table class="adminlist">
<thead>
<tr>
	<th class="title" colspan="3"><?php echo JText::_($this->logresult['action_type']); ?></th>
</tr>
<tr>
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
</table>
