<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009-2011 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

$db = &JFactory::getDBO();

// Get a new installer
$plg_installer = new JInstaller();

@$plg_installer->install($this->parent->getPath('source').DS.'plg_rsfirewall');
$db->setQuery("UPDATE #__plugins SET published=1 WHERE `element`='rsfirewall' AND `folder`='system'");
$db->query();

@$plg_installer->install($this->parent->getPath('source').DS.'mod_rsfirewall');
$db->setQuery("UPDATE #__modules SET published=1, position='cpanel', ordering='1' WHERE `module`='mod_rsfirewall' AND `client_id`='1'");
$db->query();

$db->setQuery("SELECT `value` FROM #__rsfirewall_configuration WHERE `name`='log_emails'");
$log_emails = $db->loadResult();
if ($log_emails == 'admin@localhost')
{
	$db->setQuery("SELECT `email` FROM #__users WHERE `gid`='25' AND `block`='0' ORDER BY `id` LIMIT 1");
	$email = $db->loadResult();
	
	if (empty($email))
	{
		$user =& JFactory::getUser();
		$email = $user->get('email');
	}
	
	if (!empty($email))
	{
		$db->setQuery("UPDATE #__rsfirewall_configuration SET `value`='".$email."' WHERE `name`='log_emails'");
		$db->query();
	}
}

$db->setQuery("SHOW COLUMNS FROM #__rsfirewall_ignored WHERE `Field`='type' AND `Key` != ''");
if ($db->loadResult())
{
	$db->setQuery("ALTER TABLE `#__rsfirewall_ignored` DROP INDEX `type`");
	$db->query();
}

function RSFirewall_isJ16()
{
	jimport('joomla.version');
	$version = new JVersion();
	return $version->isCompatible('1.6.0');
}
?>
	<?php if (RSFirewall_isJ16()) { ?>
	<p align="center">If you've received the &quot;Error Building Admin Menus&quot; error, please <a href="<?php echo JRoute::_('index.php?option=com_rsfirewall&task=fixadminmenus'); ?>">click here to attempt to fix it.</a></p>
	<?php } ?>
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
			<td><strong><?php echo JText::_('Installed'); ?></strong></td>
		</tr>
		<tr>
			<th><?php echo JText::_('Plugin'); ?></th>
			<th><?php echo JText::_('Group'); ?></th>
			<th></th>
		</tr>
		<tr class="row1">
			<td class="key">System - RSFirewall! Active Scanner Plugin</td>
			<td class="key">system</td>
			<td><strong><?php echo JText::_('Installed'); ?></strong></td>
		</tr>
		<tr>
			<th><?php echo JText::_('Module'); ?></th>
			<th><?php echo JText::_('Type'); ?></th>
			<th></th>
		</tr>
		<tr class="row1">
			<td class="key">RSFirewall! Cpanel Module</td>
			<td class="key">mod_rsfirewall</td>
			<td><strong><?php echo JText::_('Installed'); ?></strong></td>
		</tr>
	</tbody>
</table>
<table>
	<tr>
		<td width="1%"><img src="components/com_rsfirewall/assets/images/rsfirewall-box.jpg" alt="RSFirewall! Box" /></td>
		<td align="left">
		<div id="rsfirewall_message">
		<p>Thank you for choosing RSFirewall!</p>
		<p>New in this version:</p>
		<ul id="rsfirewall_changelog">
			<li><img src="components/com_rsfirewall/assets/images/native25.png" alt="1.7 Native" /> Joomla! 2.5 Compatibility</li>
			<li>Increased protection with new SQL injection, LFI and &quot;PHP shell&quot; detection algorithms</li>
			<li>Updated hash files for Joomla! 2.5.1</li>
		</ul>
		<a href="http://www.rsjoomla.com/customer-support/documentations/49-general-overview-of-the-component/219-rsfirewall-changelog.html" target="_blank">Full Changelog</a>
		<ul id="rsfirewall_links">
			<li>
				<div class="button2-left">
					<div class="next">
						<a href="index.php?option=com_rsfirewall">Start using RSFirewall!</a>
					</div>
				</div>
			</li>
			<li>
				<div class="button2-left">
					<div class="readmore">
						<a href="http://www.rsjoomla.com/customer-support/documentations/48-rsfirewall-user-guide.html" target="_blank">Read the RSFirewall! User Guide</a>
					</div>
				</div>
			</li>
			<li>
				<div class="button2-left">
					<div class="blank">
						<a href="http://www.rsjoomla.com/customer-support/tickets.html" target="_blank">Get Support!</a>
					</div>
				</div>
			</li>
		</ul>
		</div>
		</td>
	</tr>	
</table>
<div align="left" width="100%"><b>RSFirewall! 1.0.0 Installed</b></div>
	
<style type="text/css">
.green { color: #009E28; }
.red { color: #B8002E; }
.greenbg { background: #B8FFC9 !important; }
.redbg { background: #FFB8C9 !important; }
#rsfirewall_changelog
{
	list-style-type: none;
	padding: 0;
}
#rsfirewall_changelog li
{
	background: url(components/com_rsfirewall/assets/images/legacy/tick.png) no-repeat center left;
	padding-left: 24px;
}

#rsfirewall_links
{
	list-style-type: none;
	padding: 0;
}
</style>