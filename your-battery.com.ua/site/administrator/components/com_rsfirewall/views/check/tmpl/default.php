<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009-2011 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');
?>
<?php if (RSFirewallHelper::isIE()) { ?>
<div class="rsfirewall_tooltip rsfirewall_warning">
	<strong><?php echo JText::_('RSF_IE_WARNING'); ?></strong>
	<p><?php echo JText::_('RSF_IE_WARNING_DESC'); ?></p>
</div>
<?php } ?>

<div class="rsfirewall_tooltip rsfirewall_warning" id="rsfirewall_check_error" style="display: none">
	<?php echo JText::_('RSF_SYSTEM_CHECK_ERROR'); ?><br />
</div>

<h3><?php echo JText::_('RSF_SYSTEM_CHECK'); ?></h3>
<p id="rsfirewall_desc"><?php echo JText::_('RSF_CHECK_SYSTEM_DESC'); ?></p>
<button type="button" onclick="rsfirewall_check();" id="rsfirewall_button_check"><?php echo JText::_('RSF_CHECK_SYSTEM'); ?></button>

<?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/loading.gif', JText::_('Loading'), 'id="rsfirewall_loading"'); ?>
<p id="rsfirewall_status"></p>
<p id="rsfirewall_status_current"></p>

<h3 id="rsfirewall_grade_heading" style="display: none">&rarr; <?php echo JText::_('RSF_GRADE'); ?></h3>
<div id="rsfirewall_grade"></div>
<span class="rsfirewall_clear"></span>

<div id="rsfirewall_response" style="display: none">

<!-- version check -->

<h3>&rarr; <?php echo JText::_('RSF_SOFTWARE_VERSION_CHECK'); ?></h3>
	<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="1%">&nbsp;</th>
			<th class="title" width="20%"><?php echo JText::_('RSF_ACTION'); ?></th>
			<th><?php echo JText::_('RSF_DESCRIPTION'); ?></th>
			<th><?php echo JText::_('RSF_RESULT'); ?></th>
		</tr>
	</thead>
		<tr>
			<td><img src="<?php echo $this->root; ?>administrator/components/com_rsfirewall/assets/images/nocheck24.png" alt="" id="rsfirewall_joomla_check" /></td>
			<td><?php echo JText::_('RSF_JOOMLA_VERSION_CHECK'); ?></td>
			<td><?php echo JText::_('RSF_INSTALLED_VERSION'); ?> <span id="rsfirewall_joomla_current"></span><br />
			<?php echo JText::_('RSF_LATEST_VERSION'); ?> <span id="rsfirewall_joomla_latest"></span></td>
			<td><span id="rsfirewall_joomla_message"></span> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=redirect&code=JOOMLA_VERSION" target="_blank"><?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/readmore.png', ''); ?></a></td>
		</tr>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/nocheck24.png" alt="" id="rsfirewall_firewall_check" /></td>
			<td><?php echo JText::_('RSF_FIREWALL_VERSION_CHECK'); ?></td>
			<td><?php echo JText::_('RSF_INSTALLED_VERSION'); ?> <span id="rsfirewall_firewall_current"></span><br />
			<?php echo JText::_('RSF_LATEST_VERSION'); ?> <span id="rsfirewall_firewall_latest"></span></td>
			<td><span id="rsfirewall_firewall_message"></span> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=redirect&code=FIREWALL_VERSION" target="_blank"><?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/readmore.png', ''); ?></a></td>
		</tr>
	</table>

<!-- file integrity check -->
	
<h3>&rarr; <?php echo JText::_('RSF_FILE_INTEGRITY_CHECK'); ?></h3>

	<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="1%">&nbsp;</th>
			<th class="title" width="70%"><?php echo JText::_('RSF_FILE'); ?></th>
			<th width="20%"><?php echo JText::_('RSF_RESULT'); ?></th>
		</tr>
	</thead>
	</table>
	
	<div class="noscrolling" id="rsfirewall_integrity_scroll">
	<table class="adminlist" cellspacing="1" id="rsfirewall_integrity_table">
	</table>
	</div>
	
	<div class="rsfirewall_click" id="rsfirewall_integrity">
	<?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/loading.gif', '', 'id="rsfirewall_integrity_loading" style="display: none"'); ?>
	<p id="rsfirewall_integrity_wrong" style="display: none;"><?php echo JText::_('RSF_FILE_INTEGRITY_WRONG_ERROR'); ?> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=redirect&code=FILE_INTEGRITY_WRONG" target="_blank"><?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/readmore.png', ''); ?></a></p>
	<p id="rsfirewall_integrity_missing" style="display: none;"><?php echo JText::_('RSF_FILE_INTEGRITY_MISSING_ERROR'); ?> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=redirect&code=FILE_INTEGRITY_MISSING" target="_blank"><?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/readmore.png', ''); ?></a></p>
	<p id="rsfirewall_integrity_button"><button type="button" onclick="rsfirewall_fix_integrity(this);"><?php echo JText::_('RSF_CLICK_FIX'); ?></button></p>
	</div>

<!-- folder permissions -->
	
<h3>&rarr; <?php echo JText::_('RSF_FOLDER_PERMISSIONS_CHECK'); ?></h3>

	<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="1%">&nbsp;</th>
			<th class="title" width="70%"><?php echo JText::_('RSF_PATH'); ?></th>
			<th width="20%"><?php echo JText::_('RSF_RESULT'); ?></th>
		</tr>
	</thead>
	</table>
	
	<div class="noscrolling" id="rsfirewall_folders_scroll">
	<table class="adminlist" cellspacing="1" id="rsfirewall_folders_table">
	</table>
	</div>
	
	<div class="rsfirewall_click" id="rsfirewall_folder_permissions">
	<?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/loading.gif', '', 'id="rsfirewall_folder_permissions_loading" style="display: none"'); ?>
	<p id="rsfirewall_folders_wrong" style="display: none"><?php echo JText::_('RSF_FOLDER_PERMISSIONS_ERROR'); ?> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=redirect&code=FOLDER_PERMISSIONS" target="_blank"><?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/readmore.png', ''); ?></a></p>
	<p id="rsfirewall_folders_button" style="display: none"><button type="button" onclick="rsfirewall_fix_folder_permissions(this);"><?php echo JText::_('RSF_CLICK_FIX'); ?></button></p>
	</div>

<!-- file permissions -->
	
<h3>&rarr; <?php echo JText::_('RSF_FILE_PERMISSIONS_CHECK'); ?></h3>

	<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="1%">&nbsp;</th>
			<th class="title" width="70%"><?php echo JText::_('RSF_PATH'); ?></th>
			<th width="20%"><?php echo JText::_('RSF_RESULT'); ?></th>
		</tr>
	</thead>
	</table>
	
	<div class="noscrolling" id="rsfirewall_files_scroll">
	<table class="adminlist" cellspacing="1" id="rsfirewall_files_table">
	</table>
	</div>
	
	<div class="rsfirewall_click" id="rsfirewall_file_permissions">
	<?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/loading.gif', '', 'id="rsfirewall_file_permissions_loading" style="display: none"'); ?>
	<p id="rsfirewall_files_wrong" style="display: none"><?php echo JText::_('RSF_FILE_PERMISSIONS_ERROR'); ?> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=redirect&code=FILE_PERMISSIONS" target="_blank"><?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/readmore.png', ''); ?></a></p>
	<p id="rsfirewall_files_button" style="display: none"><button type="button" onclick="rsfirewall_fix_file_permissions(this);"><?php echo JText::_('RSF_CLICK_FIX'); ?></button></p>
	</div>
	
<!-- malware patterns -->

<h3>&rarr; <?php echo JText::_('RSF_PATTERNS_CHECK'); ?></h3>
	<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="1%">&nbsp;</th>
			<th class="title" width="70%"><?php echo JText::_('RSF_FILE'); ?></th>
			<th width="20%"><?php echo JText::_('RSF_RESULT'); ?></th>
		</tr>
	</thead>
	</table>
	
	<div class="noscrolling" id="rsfirewall_patterns_scroll">
	<table class="adminlist" cellspacing="1" id="rsfirewall_patterns_table">
	</table>
	</div>
	
	<div class="rsfirewall_click" id="rsfirewall_patterns">
	<?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/loading.gif', '', 'id="rsfirewall_patterns_loading" style="display: none"'); ?>
	<p id="rsfirewall_patterns_wrong" style="display: none"><?php echo JText::_('RSF_PATTERNS_ERROR'); ?> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&task=redirect&code=PATTERNS_ERROR" target="_blank"><?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/readmore.png', ''); ?></a></p>
	<p id="rsfirewall_patterns_button" style="display: none"><button type="button" onclick="rsfirewall_fix_patterns(this);"><?php echo JText::_('RSF_CLICK_FIX'); ?></button></p>
	</div>
	
</div>

<div id="rsfirewall_response_misc">
</div>

<h3 id="rsfirewall_grade_up_heading" style="display: none">&rarr; <?php echo JText::_('RSF_GRADE'); ?></h3>
<div id="rsfirewall_grade_up"></div>
<span class="rsfirewall_clear"></span>

<script type="text/javascript">
var xmlHttp

// System Check
// start the System Check
function rsfirewall_check()
{
	// reload the page
	if (document.getElementById('rsfirewall_button_check').innerHTML == '<?php echo RSFirewallHelper::safeJavascript(JText::_('RSF_RECHECK_SYSTEM')); ?>')
	{
		document.location = 'index.php?option=com_rsfirewall&view=check&reload=1';
	}
	
	document.getElementById('rsfirewall_loading').style.display = 'block';
	document.getElementById('rsfirewall_button_check').style.display = 'none';
	document.getElementById('rsfirewall_button_check').innerHTML = '<?php echo RSFirewallHelper::safeJavascript(JText::_('RSF_RECHECK_SYSTEM')); ?>';
	document.getElementById('rsfirewall_response').style.display = 'none';
	document.getElementById('rsfirewall_response_misc').innerHTML = '';
	document.getElementById('rsfirewall_desc').innerHTML = '<?php echo RSFirewallHelper::safeJavascript(JText::_('RSF_CHECK_SYSTEM_DESC')); ?>';
	
	var table = document.getElementById('rsfirewall_integrity_table');
	while(table.rows.length >= 1)
		table.deleteRow(table.rows.length - 1);
	document.getElementById('rsfirewall_integrity_wrong').style.display = 'none';
	document.getElementById('rsfirewall_integrity_button').style.display = 'none';
	
	var table = document.getElementById('rsfirewall_folders_table');
	while(table.rows.length >= 1)
		table.deleteRow(table.rows.length - 1);
	document.getElementById('rsfirewall_folders_wrong').style.display = 'none';
	document.getElementById('rsfirewall_folders_button').style.display = 'none';
	
	var table = document.getElementById('rsfirewall_files_table');
	while(table.rows.length >= 1)
		table.deleteRow(table.rows.length - 1);
	document.getElementById('rsfirewall_files_wrong').style.display = 'none';
	document.getElementById('rsfirewall_files_button').style.display = 'none';
	
	var table = document.getElementById('rsfirewall_patterns_table');
	while(table.rows.length >= 1)
		table.deleteRow(table.rows.length - 1);
	document.getElementById('rsfirewall_patterns_wrong').style.display = 'none';
	document.getElementById('rsfirewall_patterns_button').style.display = 'none';
	
	document.getElementById('rsfirewall_grade_up_heading').style.display = 'none';
	document.getElementById('rsfirewall_grade_up').innerHTML = '';
	document.getElementById('rsfirewall_grade_heading').style.display = 'none';
	document.getElementById('rsfirewall_grade').innerHTML = '';
	
	// each function triggers the next one
	rsfirewall_check_version();
} 

// stop and clean up the System Check
function rsfirewall_stop_check()
{
	document.getElementById('rsfirewall_status').innerHTML = '';
	document.getElementById('rsfirewall_status_current').innerHTML = '';
	document.getElementById('rsfirewall_response').style.display = '';
	document.getElementById('rsfirewall_loading').style.display = 'none';
	document.getElementById('rsfirewall_desc').innerHTML = '<?php echo RSFirewallHelper::safeJavascript(JText::_('RSF_CHECK_SYSTEM_COMPLETE_DESC')); ?>';
	document.getElementById('rsfirewall_button_check').style.display = '';
	
	var xmlHttp = rsfirewall_get_xml_http_object();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}
	var url="index.php?option=com_rsfirewall&view=checkrun&task=grade&tmpl=component&format=raw&sid="+Math.random();
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{
			document.getElementById('rsfirewall_grade_up_heading').style.display = '';
			document.getElementById('rsfirewall_grade_up').style.display = '';
			document.getElementById('rsfirewall_grade_up').innerHTML = xmlHttp.responseText;
			
			document.getElementById('rsfirewall_grade_heading').style.display = '';
			document.getElementById('rsfirewall_grade').style.display = '';
			document.getElementById('rsfirewall_grade').innerHTML = xmlHttp.responseText;
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

// check versions - step 1
function rsfirewall_check_version()
{
	var xmlHttp = rsfirewall_get_xml_http_object();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}
	var url="index.php?option=com_rsfirewall&view=checkrun&task=version&tmpl=component&format=raw&sid="+Math.random();
	document.getElementById('rsfirewall_status').innerHTML = '<?php echo RSFirewallHelper::safeJavascript(JText::_('RSF_STEP_1_VERSION')); ?>';
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{
			var response = xmlHttp.responseText.split('|');
			
			try {
				if (response[0] == 'joomla')
				{
					var current = response[1];
					document.getElementById('rsfirewall_joomla_current').innerHTML = current;
					var latest = response[2];
					document.getElementById('rsfirewall_joomla_latest').innerHTML = latest;
					var check = response[3];
					document.getElementById('rsfirewall_joomla_check').src = '<?php echo $this->root; ?>administrator/components/com_rsfirewall/assets/images/' + check + '24.png';
					var message = check == 'check' ? '<?php echo RSFirewallHelper::safeJavascript(JText::_('RSF_JOOMLA_VERSION_OK')); ?>' : '<?php echo RSFirewallHelper::safeJavascript(JText::_('RSF_JOOMLA_VERSION_OLD'), false); ?>';
					document.getElementById('rsfirewall_joomla_message').innerHTML = message;
				}
				if (response[4] == 'firewall')
				{
					var current = response[5];
					document.getElementById('rsfirewall_firewall_current').innerHTML = current;
					var latest = response[6];
					document.getElementById('rsfirewall_firewall_latest').innerHTML = latest;
					var check = response[7];
					document.getElementById('rsfirewall_firewall_check').src = '<?php echo $this->root; ?>administrator/components/com_rsfirewall/assets/images/' + check + '24.png';
					var message = check == 'check' ? '<?php echo RSFirewallHelper::safeJavascript(JText::_('RSF_FIREWALL_VERSION_OK')); ?>' : '<?php echo RSFirewallHelper::safeJavascript(JText::_('RSF_FIREWALL_VERSION_OLD'), false); ?>';
					document.getElementById('rsfirewall_firewall_message').innerHTML = message;
				}
			}
			catch (err)
			{
				document.getElementById('rsfirewall_check_error').style.display = '';
				document.getElementById('rsfirewall_check_error').innerHTML += '<pre>' + err + '</pre><br />';
			}
			
			// trigger next function - step 2
			rsfirewall_check_integrity();
		}
	};
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

// check file integrity - step 2
function rsfirewall_check_integrity(offset)
{
	if (!offset)
		offset = 0;
		
	var xmlHttp = rsfirewall_get_xml_http_object();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}
	var url="index.php?option=com_rsfirewall&view=checkrun&task=integrity&offset="+offset+"&tmpl=component&format=raw&sid="+Math.random();
	document.getElementById('rsfirewall_status').innerHTML = '<?php echo RSFirewallHelper::safeJavascript(JText::_('RSF_STEP_2_INTEGRITY')); ?>';
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{
			try {
				if (xmlHttp.responseText.indexOf('STOP|') == 0)
				{
					var table = document.getElementById('rsfirewall_integrity_table');
					var response = xmlHttp.responseText.split('|');
					if (response[1] == 'NOHASH')
					{
						var x = table.insertRow(table.rows.length);
						var y = x.insertCell(0);
						y.innerHTML = rsfirewall_get_image('error');
						y.width = '1%';
						var y = x.insertCell(1);
						y.innerHTML = response[2];
						y.colSpan = '2';
						document.getElementById('rsfirewall_integrity_scroll').className = 'noscrolling';
					}
					else if (response[1] == 'OK')
					{
						if (response[2] == 'SCROLL')
							document.getElementById('rsfirewall_integrity_scroll').className = 'scrolling';
						else
							document.getElementById('rsfirewall_integrity_scroll').className = 'noscrolling';
							
						if (response[3] != 'WRONG')
						{
							var x = table.insertRow(table.rows.length);
							var y = x.insertCell(0);
							y.innerHTML = rsfirewall_get_image('check');
							y.width = '1%';
							var y = x.insertCell(1);
							y.innerHTML = response[3];
							y.colSpan = '2';
						}
						if (response[4] != 'MISSING')
						{
							var x = table.insertRow(table.rows.length);
							var y = x.insertCell(0);
							y.innerHTML = rsfirewall_get_image('check');
							y.width = '1%';
							var y = x.insertCell(1);
							y.innerHTML = response[4];
							y.colSpan = '2';
						}
						
						if (document.getElementById('rsfirewall_integrity_table').innerHTML.indexOf('WRONG') != -1)
						{
							document.getElementById('rsfirewall_integrity_wrong').style.display = '';
							document.getElementById('rsfirewall_integrity_button').style.display = '';
						}
						if (document.getElementById('rsfirewall_integrity_table').innerHTML.indexOf('MISSING') != -1)
						{
							document.getElementById('rsfirewall_integrity_missing').style.display = '';
							document.getElementById('rsfirewall_integrity_button').style.display = '';
						}
					}
					// trigger next function - step 3
					document.getElementById('rsfirewall_status').innerHTML = '<?php echo RSFirewallHelper::safeJavascript(JText::_('RSF_STEP_3_FOLDERS')); ?>';
					rsfirewall_check_folders();
				}
				else
				{
					var table = document.getElementById('rsfirewall_integrity_table');
					var response = xmlHttp.responseText.split("\n");
					for (var i=0;i<response.length;i++)
					{
						var result = response[i].split('|');
						if (result.length == 1) continue;
						var x = table.insertRow(table.rows.length);
						var y = x.insertCell(0);
						y.innerHTML = rsfirewall_get_image(result[0]);
						y.width = '1%';
						var y = x.insertCell(1);
						y.innerHTML = result[1];
						var y = x.insertCell(2);
						y.innerHTML = result[2];
						y.width = '20%';
					}
					offset += <?php echo RSFirewallHelper::getConfig('offset'); ?>;
					rsfirewall_check_integrity(offset);
				}
			}
			catch (err)
			{
				document.getElementById('rsfirewall_check_error').style.display = '';
				document.getElementById('rsfirewall_check_error').innerHTML += '<pre>' + err + '</pre><br />';
				
				rsfirewall_check_folders();
			}
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

// check folder permissions - step 3
function rsfirewall_check_folders(folder)
{
	if (!folder)
		folder = '';
	
	if (folder != '')
	{
		try { document.getElementById('rsfirewall_status_current').innerHTML = '<img src="<?php echo JURI::root(true); ?>/administrator/components/com_rsfirewall/assets/images/folder.gif" alt="Folder" style="vertical-align: middle;" /> ' + rsfirewall_base64_decode(folder); }
		catch (err) { }
	}
	
	var xmlHttp = rsfirewall_get_xml_http_object();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}
	var url="index.php?option=com_rsfirewall&view=checkrun&task=folders&folder="+folder+"&tmpl=component&format=raw&sid="+Math.random();
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{
			try {
				if (xmlHttp.responseText.indexOf('STOP|') == 0)
				{
					var response = xmlHttp.responseText.split('|');
					if (response[1] == 'OK')
					{
						if (response[2] == 'SCROLL')
							document.getElementById('rsfirewall_folders_scroll').className = 'scrolling';
						else
							document.getElementById('rsfirewall_folders_scroll').className = 'noscrolling';
						if (document.getElementById('rsfirewall_folders_table').innerHTML.indexOf('WRONG') != -1)
						{
							document.getElementById('rsfirewall_folders_wrong').style.display = '';
							document.getElementById('rsfirewall_folders_button').style.display = '';
						}
						
						if (response[3] != 'WRONG')
						{
							var table = document.getElementById('rsfirewall_folders_table');
							var x = table.insertRow(table.rows.length);
							var y = x.insertCell(0);
							y.innerHTML = rsfirewall_get_image('check');
							y.width = '1%';
							var y = x.insertCell(1);
							y.innerHTML = response[3];
							y.colSpan = '2';
						}
					}
					if (response[5] == 'OK')
					{
						if (response[6] == 'SCROLL')
							document.getElementById('rsfirewall_files_scroll').className = 'scrolling';
						else
							document.getElementById('rsfirewall_files_scroll').className = 'noscrolling';
						if (document.getElementById('rsfirewall_files_table').innerHTML.indexOf('WRONG') != -1)
						{
							document.getElementById('rsfirewall_files_wrong').style.display = '';
							document.getElementById('rsfirewall_files_button').style.display = '';
						}
						
						if (response[7] != 'WRONG')
						{
							var table = document.getElementById('rsfirewall_files_table');
							var x = table.insertRow(table.rows.length);
							var y = x.insertCell(0);
							y.innerHTML = rsfirewall_get_image('check');
							y.width = '1%';
							var y = x.insertCell(1);
							y.innerHTML = response[7];
							y.colSpan = '2';
						}
					}
					if  (document.getElementById('rsfirewall_patterns_table').innerHTML.indexOf('WRONG') != -1)
					{
						document.getElementById('rsfirewall_patterns_wrong').style.display = '';
						document.getElementById('rsfirewall_patterns_button').style.display = '';
					}
					else
					{
						var table = document.getElementById('rsfirewall_patterns_table');
						var x = table.insertRow(table.rows.length);
						var y = x.insertCell(0);
						y.innerHTML = rsfirewall_get_image('check');
						y.width = '1%';
						var y = x.insertCell(1);
						y.innerHTML = '<?php echo RSFirewallHelper::safeJavascript(JText::_('RSF_OK_PATTERNS')); ?>';
						y.colSpan = '2';
					}
					
					// trigger next function - step 4
					rsfirewall_check_misc();
				}
				else
				{
					var response = xmlHttp.responseText.split('|');
					
					var table = document.getElementById('rsfirewall_folders_table');
					//table.innerHTML += response[0];
					var response2 = response[0].split("\n");
					for (var i=0;i<response2.length;i++)
					{
						var result = response2[i].split('*');
						if (result.length == 1) continue;
						var x = table.insertRow(table.rows.length);
						var y = x.insertCell(0);
						y.innerHTML = rsfirewall_get_image(result[0]);
						y.width = '1%';
						var y = x.insertCell(1);
						y.innerHTML = result[1];
						var y = x.insertCell(2);
						y.innerHTML = result[2];
						y.width = '20%';
					}
					
					var table = document.getElementById('rsfirewall_files_table');
					//table.innerHTML += response[2];
					var response2 = response[2].split("\n");
					for (var i=0;i<response2.length;i++)
					{
						var result = response2[i].split('*');
						if (result.length == 1) continue;
						var x = table.insertRow(table.rows.length);
						var y = x.insertCell(0);
						y.innerHTML = rsfirewall_get_image(result[0]);
						y.width = '1%';
						var y = x.insertCell(1);
						y.innerHTML = result[1];
						var y = x.insertCell(2);
						y.innerHTML = result[2];
						y.width = '20%';
					}
					
					var table = document.getElementById('rsfirewall_patterns_table');
					//table.innerHTML += response[3];
					var response2 = response[3].split("\n");
					for (var i=0;i<response2.length;i++)
					{
						var result = response2[i].split('*');
						if (result.length == 1) continue;
						var x = table.insertRow(table.rows.length);
						var y = x.insertCell(0);
						y.innerHTML = rsfirewall_get_image(result[0]);
						y.width = '1%';
						var y = x.insertCell(1);
						y.innerHTML = result[1];
						var y = x.insertCell(2);
						y.innerHTML = result[2];
						y.width = '20%';
					}
					
					var folders = response[4];
					var files = response[5];
					document.getElementById('rsfirewall_status').innerHTML = '<?php echo RSFirewallHelper::safeJavascript(JText::_('RSF_STEP_3_FOLDERS')); ?> ' + folders + ' folders and ' + files + ' files parsed';
					
					var nextfolder = response[1];
					rsfirewall_check_folders(nextfolder);
				}
			}
			catch (err)
			{
				document.getElementById('rsfirewall_check_error').style.display = '';
				document.getElementById('rsfirewall_check_error').innerHTML += '<pre>' + err + '</pre><br />';
				
				rsfirewall_check_misc();
			}
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

// check misc - final step
function rsfirewall_check_misc()
{
	document.getElementById('rsfirewall_status_current').innerHTML = '';
	
	var xmlHttp = rsfirewall_get_xml_http_object();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}
	var url="index.php?option=com_rsfirewall&view=checkrun&task=misc&tmpl=component&format=raw&sid="+Math.random();
	document.getElementById('rsfirewall_status').innerHTML = '<?php echo RSFirewallHelper::safeJavascript(JText::_('RSF_STEP_4_MISC')); ?>';
	xmlHttp.onreadystatechange = function() {
		if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
		{
			var response = xmlHttp.responseText;
			document.getElementById('rsfirewall_response_misc').innerHTML = response;
			
			rsfirewall_stop_check();
		}
	}
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

// Fix file permissions
function rsfirewall_fix_file_permissions(thebutton)
{
	document.getElementById('rsfirewall_file_permissions_loading').style.display = 'block';
	thebutton.style.display = 'none';
	
	xmlHttp = rsfirewall_get_xml_http_object();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}
	var url="index.php?option=com_rsfirewall&task=fix&what=filePermissions&tmpl=component&sid="+Math.random();
	xmlHttp.onreadystatechange=rsfirewall_fix_file_permissions_state_changed;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 

function rsfirewall_fix_file_permissions_state_changed() 
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById('rsfirewall_file_permissions').innerHTML=xmlHttp.responseText;
	}
}

// Fix folder permissions
function rsfirewall_fix_folder_permissions(thebutton)
{
	document.getElementById('rsfirewall_folder_permissions_loading').style.display = 'block';
	thebutton.style.display = 'none';
	
	xmlHttp = rsfirewall_get_xml_http_object();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}
	var url="index.php?option=com_rsfirewall&task=fix&what=folderPermissions&tmpl=component&sid="+Math.random();
	xmlHttp.onreadystatechange=rsfirewall_fix_folder_permissions_state_changed;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 

function rsfirewall_fix_folder_permissions_state_changed() 
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById('rsfirewall_folder_permissions').innerHTML=xmlHttp.responseText;
	}
}

// Fix patterns
function rsfirewall_fix_patterns(thebutton)
{
	if (!confirm('<?php echo RSFirewallHelper::safeJavascript(JText::_('RSF_FIX_PATTERNS_SURE')); ?>')) return;
	document.getElementById('rsfirewall_patterns_loading').style.display = 'block';
	thebutton.style.display = 'none';
	
	xmlHttp = rsfirewall_get_xml_http_object();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}
	var url="index.php?option=com_rsfirewall&task=fix&what=patterns&tmpl=component&sid="+Math.random();
	xmlHttp.onreadystatechange=rsfirewall_fix_patterns_state_changed;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 

function rsfirewall_fix_patterns_state_changed() 
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById('rsfirewall_patterns').innerHTML=xmlHttp.responseText;
	}
}

// Fix integrity
function rsfirewall_fix_integrity(thebutton)
{
	document.getElementById('rsfirewall_integrity_loading').style.display = 'block';
	thebutton.style.display = 'none';
	
	xmlHttp = rsfirewall_get_xml_http_object();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}
	var url="index.php?option=com_rsfirewall&task=fix&what=integrity&tmpl=component&sid="+Math.random();
	xmlHttp.onreadystatechange=rsfirewall_fix_integrity_state_changed;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 

function rsfirewall_fix_integrity_state_changed() 
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById('rsfirewall_integrity').innerHTML=xmlHttp.responseText;
	}
}

// Fix PHP
function rsfirewall_fix_php(thebutton)
{
	document.getElementById('rsfirewall_php_loading').style.display = 'block';
	thebutton.style.display = 'none';
	
	xmlHttp = rsfirewall_get_xml_http_object();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}
	var url="index.php?option=com_rsfirewall&task=fix&what=php&tmpl=component&sid="+Math.random();
	xmlHttp.onreadystatechange=rsfirewall_fix_php_state_changed;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 

function rsfirewall_fix_php_state_changed() 
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById('rsfirewall_php').innerHTML=xmlHttp.responseText;
	}
}

// Fix JUMI
function rsfirewall_fix_jumi(thebutton)
{
	document.getElementById('rsfirewall_jumi_loading').style.display = 'block';
	thebutton.style.display = 'none';
	
	xmlHttp = rsfirewall_get_xml_http_object();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}
	var url="index.php?option=com_rsfirewall&task=fix&what=jumi&tmpl=component&sid="+Math.random();
	xmlHttp.onreadystatechange=rsfirewall_fix_juma_state_changed;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 

function rsfirewall_fix_juma_state_changed() 
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById('rsfirewall_jumi').innerHTML=xmlHttp.responseText;
	}
}

// Fix Temporary Files
function rsfirewall_fix_temp_files(thebutton)
{
	if (!confirm('<?php echo RSFirewallHelper::safeJavascript(JText::_('RSF_FIX_TEMP_FILES_SURE')); ?>')) return;
	document.getElementById('rsfirewall_temp_files_loading').style.display = 'block';
	thebutton.style.display = 'none';
	
	xmlHttp = rsfirewall_get_xml_http_object();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}
	var url="index.php?option=com_rsfirewall&task=fix&what=tempFiles&tmpl=component&sid="+Math.random();
	xmlHttp.onreadystatechange=rsfirewall_fix_temp_files_state_changed;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
} 

function rsfirewall_fix_temp_files_state_changed() 
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		document.getElementById('rsfirewall_temp_files').innerHTML=xmlHttp.responseText;
	}
}

// Fix accept change
function rsfirewall_fix_accept_change(thebutton, thefile)
{
	thebutton.style.display = 'none';
	
	xmlHttp = rsfirewall_get_xml_http_object();
	if (xmlHttp==null)
	{
	  alert ("Browser does not support HTTP Request");
	  return;
	}
	var url="index.php?option=com_rsfirewall&task=fix&what=acceptChange&file="+thefile+"&tmpl=component&sid="+Math.random();
	xmlHttp.onreadystatechange=rsfirewall_fix_accept_change_state_changed;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}

function rsfirewall_fix_accept_change_state_changed() 
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{
		return true;
	}
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

function rsfirewall_get_image(type)
{
	if (type == 'check')
		return '<?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/check24.png', ''); ?>';
	else if (type == 'nocheck')
		return '<?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/nocheck24.png', ''); ?>';
	else if (type == 'nochecku')
		return '<?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/nocheck24.png', 'UNINSTALLED'); ?>';
	else if (type == 'nocheckw')
		return '<?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/nocheck24.png', 'WRONG'); ?>';
	else if (type == 'error')
		return '<?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/error24.png', ''); ?>';
	else if (type == 'errorm')
		return '<?php echo JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/error24.png', 'MISSING'); ?>';
}

function rsfirewall_base64_decode(data)
{
    var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    var o1, o2, o3, h1, h2, h3, h4, bits, i = 0, ac = 0, dec = "", tmp_arr = [];

    if (!data) {
        return data;
    }

    data += '';

    do {  // unpack four hexets into three octets using index points in b64
        h1 = b64.indexOf(data.charAt(i++));
        h2 = b64.indexOf(data.charAt(i++));
        h3 = b64.indexOf(data.charAt(i++));
        h4 = b64.indexOf(data.charAt(i++));

        bits = h1<<18 | h2<<12 | h3<<6 | h4;

        o1 = bits>>16 & 0xff;
        o2 = bits>>8 & 0xff;
        o3 = bits & 0xff;

        if (h3 == 64) {
            tmp_arr[ac++] = String.fromCharCode(o1);
        } else if (h4 == 64) {
            tmp_arr[ac++] = String.fromCharCode(o1, o2);
        } else {
            tmp_arr[ac++] = String.fromCharCode(o1, o2, o3);
        }
    } while (i < data.length);

    dec = tmp_arr.join('');
    dec = rsfirewall_utf8_decode(dec);

    return dec;
}

function rsfirewall_utf8_decode ( str_data )
{
    var tmp_arr = [], i = 0, ac = 0, c1 = 0, c2 = 0, c3 = 0;
    
    str_data += '';
    
    while ( i < str_data.length ) {
        c1 = str_data.charCodeAt(i);
        if (c1 < 128) {
            tmp_arr[ac++] = String.fromCharCode(c1);
            i++;
        } else if ((c1 > 191) && (c1 < 224)) {
            c2 = str_data.charCodeAt(i+1);
            tmp_arr[ac++] = String.fromCharCode(((c1 & 31) << 6) | (c2 & 63));
            i += 2;
        } else {
            c2 = str_data.charCodeAt(i+1);
            c3 = str_data.charCodeAt(i+2);
            tmp_arr[ac++] = String.fromCharCode(((c1 & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
            i += 3;
        }
    }

    return tmp_arr.join('');
}

<?php if ($this->reloaded) { ?>
	rsfirewall_check();
<?php } ?>
</script>