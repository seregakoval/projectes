<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009-2011 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');
?>
<h3><?php echo JText::_('RSF_DB_CHECK'); ?></h3>
<p id="rsfirewall_desc"><?php echo JText::_('RSF_DB_CHECK_DESC'); ?></p>
<button type="button" onclick="rsfirewall_check();" id="rsfirewall_button_check"><?php echo JText::_('RSF_CHECK_DB'); ?></button>

<?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/loading.gif', JText::_('Loading'), 'id="rsfirewall_loading"'); ?>
<span class="rsfirewall_clear"></span>

<div id="rsfirewall_response">
	<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="1%">&nbsp;</th>
			<th class="title" width="20%" nowrap="nowrap"><?php echo JText::_('RSF_TABLE_NAME'); ?></th>
			<th class="title" width="1%" nowrap="nowrap"><?php echo JText::_('RSF_TABLE_ENGINE'); ?></th>
			<th class="title" width="1%" nowrap="nowrap"><?php echo JText::_('RSF_TABLE_COLLATION'); ?></th>
			<th class="title" width="1%" nowrap="nowrap"><?php echo JText::_('RSF_TABLE_ROWS'); ?></th>
			<th class="title" width="1%" nowrap="nowrap"><?php echo JText::_('RSF_TABLE_DATA'); ?></th>
			<th class="title" width="1%" nowrap="nowrap"><?php echo JText::_('RSF_TABLE_INDEX'); ?></th>
			<th class="title" width="1%" nowrap="nowrap"><?php echo JText::_('RSF_TABLE_OVERHEAD'); ?></th>
			<th><?php echo JText::_('RSF_RESULT'); ?></th>
		</tr>
	</thead>
		<?php foreach ($this->tables as $i => $table) { ?>
		<tr>
			<td><img src="<?php echo $this->root; ?>administrator/components/com_rsfirewall/assets/images/db24.png" alt="" /></td>
			<td><?php echo $table->Name; ?></td>
			<td><?php echo $table->Engine; ?></td>
			<td><?php echo $table->Collation; ?></td>
			<td align="center"><?php echo $table->Rows; ?></td>
			<td align="center"><?php echo $this->_convert($table->Data_length); ?></td>
			<td align="center"><?php echo $this->_convert($table->Index_length); ?></td>
			<td align="center"><?php echo $table->Data_free > 0 ? '<b class="rsfirewall_red">'.$this->_convert($table->Data_free).'</b>' : $this->_convert($table->Data_free); ?></td>
			<td id="result<?php echo $i; ?>"></td>
		</tr>
		<?php } ?>
	</table>
</div>	

<script type="text/javascript">
var xmlHttp

// System Check
// start the System Check
function rsfirewall_check()
{	
	document.getElementById('rsfirewall_loading').style.display = 'block';
	document.getElementById('rsfirewall_button_check').style.display = 'none';
	document.getElementById('rsfirewall_button_check').innerHTML = '<?php echo RSFirewallHelper::safeJavascript(JText::_('RSF_RECHECK_DB')); ?>';
	document.getElementById('rsfirewall_desc').innerHTML = '<?php echo RSFirewallHelper::safeJavascript(JText::_('RSF_DB_CHECK_DESC')); ?>';
	
	var tables = Array();
	<?php krsort($this->tables); ?>
	<?php foreach ($this->tables as $table) { ?>
	tables.push('<?php echo addslashes($table->Name); ?>');
	<?php } ?>
	
	rsfirewall_check_table(tables, 0);
}

// stop and clean up the System Check
function rsfirewall_stop_check()
{
	document.getElementById('rsfirewall_loading').style.display = 'none';
	document.getElementById('rsfirewall_desc').innerHTML = '<?php echo RSFirewallHelper::safeJavascript(JText::_('RSF_DB_CHECK_COMPLETE_DESC')); ?>';
	document.getElementById('rsfirewall_button_check').style.display = '';
}

function rsfirewall_check_table(tables, index)
{
	if (tables.length == 0)
	{
		rsfirewall_stop_check();
		return false;
	}
		
	table_name = tables.pop();
	var url="index.php?option=com_rsfirewall&task=dbcheckrun&sid="+Math.random() + '&table_name=' + encodeURIComponent(table_name);
	
	var xmlHttp = rsfirewall_get_xml_http_object();
	if (xmlHttp==null)
	{
		alert ("Browser does not support HTTP Request");
		return false;
	}
	
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{
			document.getElementById('result' + index).innerHTML = xmlHttp.responseText;
			rsfirewall_check_table(tables, index+1);
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
	document.getElementById('result' + index).innerHTML = '<img src="components/com_rsfirewall/assets/images/loading-small.gif" alt="" />';
}

// XML HTTP Object
function rsfirewall_get_xml_http_object()
{
	var xmlHttp=null;
	try
	{
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e)
	{
		// Internet Explorer
		try
		{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp;
}
</script>