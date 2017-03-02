<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009-2011 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

?>
<?php if (count($this->files) > 0) { ?>
	<h3><?php echo JText::_('RSF_LATEST_FILES_CHANGED'); ?></h3>
	<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="5"><?php echo JText::_('#'); ?></th>
			<th><?php echo JText::_('RSF_DATE_EVENT'); ?></th>
			<th><?php echo JText::_('RSF_FILE'); ?></th>
			<th><?php echo JText::_('RSF_ORIGINAL_HASH'); ?></th>
			<th><?php echo JText::_('RSF_MODIFIED_HASH'); ?></th>
			<th><?php echo JText::_('RSF_ACCEPT_CHANGE'); ?></th>
		</tr>
	</thead>
	<?php foreach ($this->files as $i => $file) { ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo date('d.m.Y H:i:s', $file->date); ?></td>
		<td><?php echo $file->file; ?></td>
		<td><?php echo $file->hash; ?></td>
		<?php if ($file->type == 'protect') { ?>
		<td class="rsfirewall_critical"><?php echo md5_file($file->file); ?></td>
		<?php } else { ?>
		<td class="rsfirewall_critical"><?php echo md5_file(JPATH_SITE.DS.$file->file); ?></td>
		<?php } ?>
		<td align="center"><a href="index.php?option=com_rsfirewall&task=acceptHash&cid=<?php echo $file->id; ?>"><?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/legacy/tick.png', JText::_('RSF_ACCEPT_CHANGE')); ?></a></td>
	</tr>
	<?php } ?>
	</table>
<?php } ?>
