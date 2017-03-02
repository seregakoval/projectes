<?php
/**
* Installation file for CSV Improved
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: install.csvivirtuemart.php 1152 2010-02-07 09:42:42Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Joomla installer
*
* The Joomla installer calls this function on installation, here process
* some tasks to prepare for use
 */
function com_install() {
	/* Some installation maintenance */
	$db = JFactory::getDBO();
	$error = false;
	$errors = array();
	
	/* Check if we have new tables that are empty */
	$q = "SELECT COUNT(*) FROM #__csvivirtuemart_templates";
	$db->setQuery($q);
	$ctemplates = $db->loadResult();
	
	if ($ctemplates == 0) {
		/* Copy the old tables to the new tables */
		/* Check first if there are old tables */
		$q = "SHOW TABLES LIKE '%".$db->_table_prefix."csvi\_%'";
		$db->setQuery($q);
		$oldtables = $db->loadResultArray();
		
		/* 1. Templates table */
		if (in_array($db->_table_prefix.'csvi_templates', $oldtables)) {
			$q = 'SELECT * FROM #__csvi_templates';
			$db->setQuery($q);
			$list = $db->loadAssocList();
			if ($list) {
				$qvalues = array();
				$qfields = array();
				$qinsert = '';
				foreach ($list as $key => $template) {
					foreach ($template as $table => $value) {
						if ($key == 0) {
							if ($table == 'file_location') $table = 'file_location_product_images';
							$qfields[] = $table;
						}
						$qvalues[$key][] = $db->Quote($value);
					}
				}
				$qinsert = 'INSERT IGNORE INTO #__csvivirtuemart_templates ('.implode(',', $qfields).') VALUES ';
				foreach ($qvalues as $key => $value) {
					$qinsert .= '('.implode(',', $value).'),'."\n";
				}
				
				$qinsert = substr(trim($qinsert), 0, -1).';';
				$db->setQuery($qinsert);
				if (!$db->query()) {
					$error = true;
					$errors[] = $db->getErrorMsg();
				}
			}
		}
		
		/* 2. Template fields table */
		if (in_array($db->_table_prefix.'csvi_template_fields', $oldtables)) {
			$q = 'SELECT * FROM #__csvi_template_fields';
			$db->setQuery($q);
			$list = $db->loadAssocList();
			if ($list) {
				$qvalues = array();
				$qfields = array();
				$qinsert = '';
				foreach ($list as $key => $template) {
					foreach ($template as $table => $value) {
						if ($key == 0) {
							$qfields[] = $table;
						}
						$qvalues[$key][] = $db->Quote($value);
					}
				}
				$qinsert = 'INSERT IGNORE INTO #__csvivirtuemart_template_fields ('.implode(',', $qfields).') VALUES ';
				foreach ($qvalues as $key => $value) {
					$qinsert .= '('.implode(',', $value).'),'."\n";
				}
				$qinsert = substr(trim($qinsert), 0, -1).';';
				$db->setQuery($qinsert);
				if (!$db->query()) {
					$error = true;
					$errors[] = $db->getErrorMsg();
				}
			}
		}
		
		/* 3. Logs table */
		if (in_array($db->_table_prefix.'csvi_logs', $oldtables)) {
			$q = 'SELECT * FROM #__csvi_logs LIMIT 100';
			$db->setQuery($q);
			$list = $db->loadAssocList();
			if ($list) {
				$qvalues = array();
				$qfields = array();
				$qinsert = '';
				$keys = array();
				foreach ($list as $key => $log) {
					foreach ($log as $field => $value) {
						if ($key == 0) {
							$qfields[] = $field;
						}
						$qvalues[$key][] = $db->Quote($value);
					}
					/* Collect the keys */
					$keys[] = $log['id'];
				}
				$qinsert = 'INSERT IGNORE INTO #__csvivirtuemart_logs ('.implode(',', $qfields).') VALUES ';
				foreach ($qvalues as $key => $value) {
					$qinsert .= '('.implode(',', $value).'),'."\n";
				}
				$qinsert = substr(trim($qinsert), 0, -1).';';
				$db->setQuery($qinsert);
				if (!$db->query()) {
					$error = true;
					$errors[] = $db->getErrorMsg();
				}
			}
		}
		else $list = false;
		
		/* 4. Log details table */
		if ($list && in_array($db->_table_prefix.'csvi_log_details', $oldtables)) {
			$q = 'SELECT * FROM #__csvi_log_details WHERE log_id IN ('.implode(',', $keys).')';
			$db->setQuery($q);
			$list = $db->loadAssocList();
			if ($list) {
				$qvalues = array();
				$qfields = array();
				$qinsert = '';
				foreach ($list as $key => $template) {
					foreach ($template as $table => $value) {
						if ($key == 0) {
							$qfields[] = $table;
						}
						$qvalues[$key][] = $db->Quote($value);
					}
				}
				$qinsert = 'INSERT IGNORE INTO #__csvivirtuemart_log_details ('.implode(',', $qfields).') VALUES ';
				foreach ($qvalues as $key => $value) {
					$qinsert .= '('.implode(',', $value).'),'."\n";
				}
				$qinsert = substr(trim($qinsert), 0, -1).';';
				$db->setQuery($qinsert);
				if (!$db->query()) {
					$error = true;
					$errors[] = $db->getErrorMsg();
				}
			}
		}
	}
	
	/* Alter the available fields table */
	$q = "ALTER TABLE `#__csvivirtuemart_available_fields`  CHANGE COLUMN `vm_name` `vm_name` VARCHAR(255) NOT NULL AFTER `csvi_name`,  
		CHANGE COLUMN `vm_table` `vm_table` VARCHAR(255) NOT NULL AFTER `vm_name`;";
	$db->setQuery($q);
	$db->query();
	
	/* Alter the currency table */
	$q = "ALTER TABLE `#__csvivirtuemart_currency`  CHANGE COLUMN `currency_rate` `currency_rate` DECIMAL(12,5) NULL DEFAULT NULL AFTER `currency_code`;";
	$db->setQuery($q);
	$db->query();
	
	/* Alter the log table */
	$q = "ALTER TABLE `#__csvivirtuemart_logs`  CHANGE COLUMN `records` `records` INT(11) NULL DEFAULT NULL;";
	$db->setQuery($q);
	$db->query();
	
	$q = "SHOW COLUMNS FROM #__csvivirtuemart_logs";
	$db->setQuery($q);
	$columns = $db->loadResultArray();
	if (!in_array('import_id', $columns)) {
		$q = "ALTER TABLE `#__csvivirtuemart_logs`    
			ADD COLUMN `import_id` INT(11) NULL DEFAULT NULL AFTER `records`;";
		$db->setQuery($q);
		$db->query();
	}
	if (!in_array('file_name', $columns)) {
		$q = "ALTER TABLE `#__csvivirtuemart_logs`    
			ADD COLUMN `file_name` VARCHAR(255) NULL DEFAULT NULL AFTER `import_id`;";
		$db->setQuery($q);
		$db->query();
	}
	/* Alter the log details table */
	$q = "SHOW COLUMNS FROM #__csvivirtuemart_log_details";
	$db->setQuery($q);
	$columns = $db->loadResultArray();
		
	if (!in_array('line', $columns)) {
		$q = "ALTER TABLE `#__csvivirtuemart_log_details`    
			ADD COLUMN `line` INT(11) NULL DEFAULT NULL AFTER `status`;";
		$db->setQuery($q);
		$db->query();
	}
	
	/* Alter the templates table */
	$q = "ALTER TABLE `#__csvivirtuemart_template_types`  CHANGE COLUMN `template_type_name` `template_type_name` VARCHAR(255) NOT NULL AFTER `id`,  CHANGE COLUMN `template_type` `template_type` VARCHAR(255) NOT NULL AFTER `template_type_name`;";
	$db->setQuery($q);
	$db->query();
	
	/* Alter the replacements table */
	$q = "ALTER TABLE `#__csvivirtuemart_replacements`  CHANGE COLUMN `template_id` `template_id` INT(11) NOT NULL default '0';";
	$db->setQuery($q);
	$db->query();
	
	$q = "SHOW COLUMNS FROM #__csvivirtuemart_replacements";
	$db->setQuery($q);
	$columns = $db->loadResultArray();
	/* Alter the replacements table */
	if (!in_array('field_id', $columns)) {
		$q = "ALTER TABLE `#__csvivirtuemart_replacements` ADD COLUMN `field_id` INT(11) NOT NULL DEFAULT '0';";
		$db->setQuery($q);
		$db->query();
	}
	
	$q = "SHOW COLUMNS FROM #__csvivirtuemart_templates";
	$db->setQuery($q);
	$columns = $db->loadResultArray();
	/* Alter the replacements table */
	if (!in_array('export_price_format', $columns)) {
		$q = "ALTER TABLE `#__csvivirtuemart_templates` ADD COLUMN `export_price_format` VARCHAR(25) NULL DEFAULT '%01.2f';";
		$db->setQuery($q);
		$db->query();
	}
	
	?>
	<div><?php echo JHTML::_('image', JURI::root().'/administrator/components/com_csvivirtuemart/assets/images/csvivirtuemart_logo.png', 'CSVI VirtueMart'); ?></div>
	<table class="adminlist">
		<thead>
		<tr>
			<th colspan="3">
				Installation report
			</th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="3">
					Start using <?php echo JHTML::_('link', JURI::root().'administrator/index.php?option=com_csvivirtuemart', 'CSVI VirtueMart'); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<tr>
				<td><?php echo JText::_('Installation'); ?></td>
				<td style="text-align: center; ">
					<?php 
					if ($error) echo JHTML::_('image', JURI::root().'/administrator/components/com_csvivirtuemart/assets/images/csvivirtuemart_unpublish_32.png', JText::_('ERROR'));
					else echo JHTML::_('image', JURI::root().'/administrator/components/com_csvivirtuemart/assets/images/csvivirtuemart_publish_32.png', JText::_('PASS'));
					?>
				</td>
				<td>
					<?php if ($error) { ?>
						CSVI VirtueMart 2.1.3 installation reported the following errors:<br />
						<?php echo implode("<br /><br />", $errors);
					}
					else { ?>
						CSVI VirtueMart 2.1.3 has been succesfully installed.
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td><?php echo JText::_('Available fields'); ?></td>
				<td style="text-align: center; ">
					<?php
						/* Check if the user has any Available Fields */
						$q = "SELECT COUNT(*) AS total FROM #__csvivirtuemart_available_fields";
						$db->setQuery($q);
						$av_fields = $db->loadResult();
						if ($av_fields < 10) echo JHTML::_('image', JURI::root().'/administrator/components/com_csvivirtuemart/assets/images/csvivirtuemart_unpublish_32.png', JText::_('ERROR'));
						else echo JHTML::_('image', JURI::root().'/administrator/components/com_csvivirtuemart/assets/images/csvivirtuemart_publish_32.png', JText::_('PASS')); 
					?>
				</td>
				<td>
					<?php
					if ($av_fields < 10) {
						/* Update the Available Fields */
						$uri = JURI::getInstance();
					?>
					Your available fields need updating 
					<?php 
						echo JHTML::_('link', $uri->toString(array('scheme','host','path')).'?option=com_csvivirtuemart&task=maintenance&controller=maintenance&operation=updateavailablefields&boxchecked=1', 'Update Available Fields', array('target' => '_blank'));
					}
					else echo 'Your available fields are up-to-date';
					?>
				</td>
			</tr>
			<tr>
				<td><?php echo JText::_('Configuration'); ?></td>
				<td style="text-align: center; ">
					<?php
						/* Check the configuration */
						$q = "SELECT params FROM #__csvivirtuemart_settings";
						$db->setQuery($q);
						$settings = $db->loadResult();
						$paramsdefs = JPATH_COMPONENT_ADMINISTRATOR.DS.'views'.DS.'settings'.'config.xml';
						$params = new JParameter($settings, $paramsdefs);
						$hostname = $params->get('hostname', false);
						if (!$hostname) echo JHTML::_('image', JURI::root().'/administrator/components/com_csvivirtuemart/assets/images/csvivirtuemart_unpublish_32.png', JText::_('ERROR'));
						else echo JHTML::_('image', JURI::root().'/administrator/components/com_csvivirtuemart/assets/images/csvivirtuemart_publish_32.png', JText::_('PASS')); 
					?>
				</td>
				<td>
					<?php
					if (!$hostname) {
						/* Update the configuration */
						$uri = JURI::getInstance();
					?>
					Your configuration isn't set yet 
					<?php 
						echo JHTML::_('link', $uri->toString(array('scheme','host','path')).'?option=com_csvivirtuemart&controller=settings', 'Set configuration', array('target' => '_blank'));
					}
					else echo 'Your configuration is set';
					?>
				</td>
			</tr>
		</tbody>
	</table>		
	<br /><br />
		For support visit the website at <?php echo JHTML::_('link', 'http://www.csvimproved.com/', 'www.csvimproved.com', 'target="_new"'); ?>
	<br clear="all" />
	<?php
}

/**
* Creates an array of custom database fields the user can use for import/export
*/
function DbFields($table) {
	$db = JFactory::getDBO();
	$q = "SHOW COLUMNS FROM ".$db->nameQuote('#__'.$table);
	$db->setQuery($q);
	$fields = $db->loadObjectList();
	$customfields = array();
	if (count($fields) > 0) {
		foreach ($fields as $key => $field) {
			$customfields[$field->Field] = null;
		}
	}
	return $customfields;
}
?>