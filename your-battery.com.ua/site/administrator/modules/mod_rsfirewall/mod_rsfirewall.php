<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009-2011 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$document =& JFactory::getDocument();
$document->addStyleSheet(JURI::root().'administrator/modules/mod_rsfirewall/mod_rsfirewall.css');
$document->addStyleSheet(JURI::root().'administrator/components/com_rsfirewall/assets/css/rsfirewall.css');

require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rsfirewall'.DS.'helpers'.DS.'rsfirewall.php');
require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rsfirewall'.DS.'models'.DS.'rsfirewall.php');

RSFirewallHelper::readConfig();

$model = new RSFirewallModelRSFirewall();
$logs = $model->getLogs();

$lang =& JFactory::getLanguage();
$lang->load('com_rsfirewall');

$status = RSFirewallHelper::getConfig('active_scanner_status');
$lockdown = RSFirewallHelper::getConfig('lockdown');

$grade = RSFirewallHelper::getConfig('grade');
$color = '#C4C4C4'; // gray
if ($grade >= 75)
	$color = '#74B420'; // green
elseif ($grade > 0 && $grade < 75)
	$color = '#46AFCF'; // blue
?>
<div class="rsfirewall_cpanel_container">

	<a href="index.php?option=com_rsfirewall"><img src="<?php echo JURI::root(); ?>administrator/components/com_rsfirewall/assets/images/rsfirewall.jpg" alt="Protected by RSFirewall!" id="rsfirewall_cpanel_logo" width="279" height="70" /></a>
	<span class="rsfirewall_clear"></span>
	
<?php if (RSFirewallHelper::isMasterLogged()) { ?>
	<table class="adminlist" align="center">
	<tbody>
	<tr>
		<td width="50%"><strong><?php echo JText::_('RSF_GRADE'); ?></strong></td>
		<td style="background: <?php echo $color; ?>; color: #fff;"><big><strong><?php echo $grade ? $grade : '0.0'; ?></strong></big></td>
	</tr>
	<tr>
		<td width="50%"><strong><?php echo JText::_('RSF_FIREWALL_STATUS'); ?></strong></td>
		<td><strong class="rsfirewall_cpanel_<?php echo $status ? 'green' : 'red'; ?>"><?php echo $status ? JText::_('RSF_ACTIVE') : JText::_('RSF_PAUSED'); ?></strong></td>
	</tr>
	<tr>
		<td width="50%"><strong><?php echo JText::_('RSF_SYSTEM_LOCKDOWN'); ?></strong></td>
		<td><strong class="rsfirewall_cpanel_<?php echo $lockdown ? 'green' : 'red'; ?>"><?php echo $lockdown ? JText::_('RSF_ACTIVE') : JText::_('RSF_PAUSED'); ?></strong></td>
	</tr>
	<tr>
		<td><strong>RSFirewall!</strong></td>
		<td id="rsf_rsfirewall_version"><?php echo JText::_('RSF_CONNECTING'); ?></td>
	</tr>
	<tr>
		<td width="50%"><strong>Joomla!</strong></td>
		<td id="rsf_joomla_version"><?php echo JText::_('RSF_CONNECTING'); ?></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><a href="http://www.rsjoomla.com" target="_blank">www.rsjoomla.com</a></td>
	</tr>
	</tbody>
	</table>

	<?php if (count($logs) > 0) { ?>
	<h3><?php echo JText::_('RSF_LATEST_MESSAGES_SYSTEM_LOG'); ?></h3>
	<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th class="title"><?php echo JText::_('RSF_ALERT_LEVEL'); ?></th>
			<th><?php echo JText::_('RSF_DATE_EVENT'); ?></th>
			<th><?php echo JText::_('RSF_USERIP'); ?></th>
			<th><?php echo JText::_('RSF_USERID'); ?></th>
			<th><?php echo JText::_('RSF_USERNAME'); ?></th>
			<th><?php echo JText::_('RSF_PAGE'); ?></th>
			<th><?php echo JText::_('RSF_DESCRIPTION'); ?></th>
		</tr>
	</thead>
	<?php foreach ($logs as $i => $log) { ?>
	<tr>
		<td class="rsfirewall_<?php echo $log->level; ?>"><?php echo JText::_('RSF_'.strtoupper($log->level)); ?></td>
		<td><?php echo date('d.m.Y H:i:s', $log->date); ?></td>
		<td><a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&amp;task=whois&amp;ip=<?php echo $log->ip; ?>" target="_blank"><?php echo $log->ip; ?></a></td>
		<td><?php echo $log->userid; ?></td>
		<td><?php echo $log->username; ?></td>
		<td><?php echo $log->page; ?></td>
		<td><?php echo JText::_('RSF_EVENT_'.strtoupper($log->code)); ?></td>
	</tr>
	<?php } ?>
	</table>
	<?php } ?>
	
<?php } ?>
</div>

<?php if (RSFirewallHelper::isMasterLogged()) { ?>
<script type="text/javascript">	
	function rsf_get_latest_versions()
	{
		try
		{
			var myAjax = new Ajax( "index.php?option=com_rsfirewall&task=getlatestjoomlaversion", { method: "get", onComplete: rsf_show_joomla_version} ).request();
			var myAjax = new Ajax( "index.php?option=com_rsfirewall&task=getlatestfirewallversion", { method: "get", onComplete: rsf_show_firewall_version} ).request();
		}
		catch (err)
		{
			var myAjax = new Request({method: "get", url: "index.php?option=com_rsfirewall&task=getlatestjoomlaversion", onComplete: rsf_show_joomla_version} ).send();
			var myAjax = new Request({method: "get", url: "index.php?option=com_rsfirewall&task=getlatestfirewallversion", onComplete: rsf_show_firewall_version} ).send();
		}
	}
	
	function rsf_show_joomla_version(response)
	{
		document.getElementById('rsf_joomla_version').innerHTML = response;
	}
	
	function rsf_show_firewall_version(response)
	{
		document.getElementById('rsf_rsfirewall_version').innerHTML = response;
	}
	
	window.addEvent("domready", function() {
			rsf_get_latest_versions();
		}
	);
</script>
<?php } ?>