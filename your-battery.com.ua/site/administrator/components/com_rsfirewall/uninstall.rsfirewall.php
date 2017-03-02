<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009-2011 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

function RSFirewall_isJ16()
{
	jimport('joomla.version');
	$version = new JVersion();
	return $version->isCompatible('1.6.0');
}

// Get a new installer
$plg_installer = new JInstaller();

$db = JFactory::getDBO();

if (!RSFirewall_isJ16())
	$db->setQuery("SELECT id FROM #__plugins WHERE `element`='rsfirewall' AND `folder`='system' LIMIT 1");
else
	$db->setQuery("SELECT extension_id FROM #__extensions WHERE `element`='rsfirewall' AND `folder`='system' AND `type`='plugin' LIMIT 1");
$plg_id = $db->loadResult();
if ($plg_id)
	$plg_installer->uninstall('plugin', $plg_id);

$db->setQuery("SELECT id FROM #__modules WHERE `module`='mod_rsfirewall' AND `client_id`='1' LIMIT 1");
$plg_id = $db->loadResult();
if ($plg_id)
	$plg_installer->uninstall('module', $plg_id);
?>
<p><strong>RSFirewall! 1.0.0 uninstalled</strong></p>
<table class="adminlist">
	<thead>
		<tr>
			<th class="title" colspan="2"><?php echo JText::_('Extension'); ?></th>
			<th width="30%"><?php echo JText::_('Status'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="3"></td>
		</tr>
	</tfoot>
	<tbody>
		<tr class="row0">
			<td class="key" colspan="2"><?php echo 'RSFirewall! '.JText::_('Component'); ?></td>
			<td><strong><?php echo JText::_('Removed'); ?></strong></td>
		</tr>
		<tr>
			<th><?php echo JText::_('Plugin'); ?></th>
			<th><?php echo JText::_('Group'); ?></th>
			<th></th>
		</tr>
		<tr class="row1">
			<td class="key">System - RSFirewall! Active Scanner Plugin</td>
			<td class="key">system</td>
			<td><strong><?php echo JText::_('Removed'); ?></strong></td>
		</tr>
		<tr>
			<th><?php echo JText::_('Module'); ?></th>
			<th><?php echo JText::_('Type'); ?></th>
			<th></th>
		</tr>
		<tr class="row1">
			<td class="key">RSFirewall! Cpanel Module</td>
			<td class="key">mod_rsfirewall</td>
			<td><strong><?php echo JText::_('Removed'); ?></strong></td>
		</tr>
	</tbody>
</table>