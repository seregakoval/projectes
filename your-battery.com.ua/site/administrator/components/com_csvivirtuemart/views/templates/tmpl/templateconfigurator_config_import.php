<?php
/**
* Template configurator file paths
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: templateconfigurator_config_import.php 1117 2010-01-01 21:39:52Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
?>
<table class="adminlist" id="template_import">
	<!-- Template type -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('Choose the type of import the template has to make'), JText::_('Template type'), 'tooltip.png', '', '', false); ?>
		<?php echo JText::_('Template type'); ?></td>
		<td><?php echo $this->lists['importtypes']; ?></td>
	</tr>
	<!-- Use column headers -->
	<tr>
	<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('Use the first line of the imported file as configuration instead of the fields assigned to this template.'), JText::_('Use column headers as configuration'), 'tooltip.png', '', '', false); ?> 
	<?php echo JText::_('Use column headers as configuration');?></td>
	<td><input class="template_input checkbox" type="checkbox" id="use_column_headers" name="use_column_headers" value="1"
	<?php if ($this->template->use_column_headers == 1) echo ' checked=checked'; ?>
	onClick="if (document.adminForm.use_column_headers.checked == true) { 
			document.adminForm.skip_first_line.checked = false; 
			}">
	</td>
	</tr>
	<!-- Skip first line -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('Skip the first line on import. Use this if the import file contains column headers but the fields assigned to this template need to be used.'), JText::_('Skip first line'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('Skip first line'); ?></td>
		<td><input class="template_input checkbox" type="checkbox" id="skip_first_line" name="skip_first_line" value="1"
		<?php if ($this->template->skip_first_line == 1) echo ' checked=checked'; ?>
		onClick="if (document.adminForm.skip_first_line.checked == true) { 
				document.adminForm.use_column_headers.checked = false; 
				}">
	</td>
	</tr>
	
	<!-- Unpublish before import -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('UNPUBLISH_BEFORE_IMPORT_TIP'), JText::_('UNPUBLISH_BEFORE_IMPORT'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('UNPUBLISH_BEFORE_IMPORT'); ?></td>
		<td><input class="template_input checkbox" type="checkbox" id="unpublish_before_import" name="unpublish_before_import" value="1"
		<?php if ($this->template->unpublish_before_import == 1) echo ' checked=checked'; ?> />
		</td>
	</tr>
	
	<!-- Overwrite existing data -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('Overwrite existing data will overwrite all data for each record. When not set, a record will be skipped if it exists.'), JText::_('Overwrite existing data'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('Overwrite existing data'); ?></td>
		<td><input class="template_input checkbox" type="checkbox" id="overwrite_existing_data" name="overwrite_existing_data" value="1"
		<?php if ($this->template->overwrite_existing_data) echo ' checked=checked'; ?>
		>
		</td>
	</tr>
	
	<!-- Append categories -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('Append categories to existing categories instead of overwriting them'), JText::_('Append categories'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('Append categories'); ?></td>
		<td><input class="template_input checkbox" type="checkbox" id="append_categories" name="append_categories" value="1"
		<?php if ($this->template->append_categories) echo ' checked=checked'; ?>
		>
		</td>
	</tr>
	
	<!-- Ignore non-existent products -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('Ignore non-existing products will not create any new products if the product SKU cannot be found.'), JText::_('Ignore non-existing products'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('Ignore non-existing products'); ?></td>
		<td><input class="template_input checkbox" type="checkbox" id="ignore_non_exist" name="ignore_non_exist" value="1"
		<?php if ($this->template->ignore_non_exist) echo ' checked=checked'; ?>
		>
		</td>
	</tr>
	
	<!-- Skip default value -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('Default values set in the assigned fields will not be used when set.'), JText::_('Skip default value'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('Skip default value'); ?></td>
		<td><input class="template_input checkbox" type="checkbox" id="skip_default_value" name="skip_default_value" value="1"
		<?php if ($this->template->skip_default_value) echo ' checked=checked'; ?>
		>
		</td>
	</tr>
	
	<!-- Show preview -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('Show a 5-line preview before importing'), JText::_('Show preview'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('Show preview'); ?></td>
		<td><input class="template_input checkbox" type="checkbox" id="show_preview" name="show_preview" value="1"
		<?php if ($this->template->show_preview) echo ' checked=checked'; ?>>
		</td>
	</tr>
	
	<!-- Collect debug info -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('Collect debug information to see what is happening on import.<br /><br />Use with caution on big files as the output will be a lot.'), JText::_('Collect debug information'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('Collect debug information'); ?></td>
		<td><input class="template_input checkbox" type="checkbox" id="collect_debug_info" name="collect_debug_info" value="1"
		<?php if ($this->template->collect_debug_info) echo ' checked=checked'; ?>
		>
		</td>
	</tr>
</table>
<script type="text/javascript">
UpdateRowClass('template_import');
</script>
