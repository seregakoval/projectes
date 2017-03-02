<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009-2011 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');
?>
<script type="text/javascript">
function rsfirewall_lockdown(value)
{
	if (value == 0)
		document.adminForm.lockdown.value = 0;
	else
		document.adminForm.lockdown.value = 1;
	
	document.adminForm.submit();
}
</script>

<div class="rsfirewall_tooltip rsfirewall_lockdown">
	<strong><?php echo JText::_('RSF_SYSTEM_LOCKDOWN'); ?></strong>
	<p><?php echo JText::_('RSF_SYSTEM_LOCKDOWN_DESC'); ?></p>
</div>

<form method="post" action="index.php?option=com_rsfirewall&view=lockdown" name="adminForm" id="adminForm">
	<button type="button" onclick="rsfirewall_lockdown(1)" <?php echo $this->lockdown == 1 ? 'disabled="disabled"' : '' ?>><?php echo RSFirewallHelper::isJ16() ? JText::_('JTOOLBAR_ENABLE') : JText::_('ENABLE'); ?></button>
	<button type="button" onclick="rsfirewall_lockdown(0)" <?php echo $this->lockdown == 0 ? 'disabled="disabled"' : '' ?>><?php echo RSFirewallHelper::isJ16() ? JText::_('JTOOLBAR_DISABLE') : JText::_('DISABLE'); ?></button>
	<input type="hidden" name="lockdown" value="" />
	
<?php echo JHTML::_('form.token'); ?>
<input type="hidden" name="option" value="com_rsfirewall" />
<input type="hidden" name="task" value="lockdown" />
<input type="hidden" name="controller" value="lockdown" />
</form>