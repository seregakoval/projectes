<?php defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' ); ?>
<table class="adminlist" id="template_export">
	<!-- Template type -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('TEMPLATE_TYPE_TIP'), JText::_('TEMPLATE_TYPE'), 'tooltip.png', '', '', false); ?>
		<?php echo JText::_('TEMPLATE_TYPE'); ?></td>
		<td><?php echo $this->lists['exporttypes']; ?></td>
	</tr>
	<!-- Export type -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('EXPORT_TYPE_TIP'), JText::_('EXPORT_TYPE'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('EXPORT_TYPE'); ?></td>
		<td>
			<select id="export_type" name="export_type">
				<option value="csv" <?php if ($this->template->export_type == "csv") echo 'selected="selected"'; ?>>CSV</option>
				<option value="xml" <?php if ($this->template->export_type == "xml") echo 'selected="selected"'; ?>>XML</option>
				<option value="html" <?php if ($this->template->export_type == "html") echo 'selected="selected"'; ?>>HTML</option>
			</select>
		</td>
	</tr>
	
	<!-- Export site -->
	<?php
		$display = ($this->template->export_type == "xml") ? 'display' : 'none';
	?>
	<tr id="div_export_site" style="display: <?php echo $display ?>;">
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('EXPORT_SITE_TIP'), JText::_('EXPORT_SITE'), 'tooltip.png', '', '', false); ?>
		<?php echo JText::_('EXPORT_SITE');?></td>
		<td><select name="export_site" id="export_site">
		<option value="" <?php if ($this->template->export_site == "") echo 'selected="selected"';?>><?php echo JText::_('Choose website...');?></option>
		<option value="csvi" <?php if ($this->template->export_site == "csvi") echo 'selected="selected"'; ?>>CSV Improved</option>
		<option value="beslist" <?php if ($this->template->export_site == "beslist") echo 'selected="selected"'; ?>>beslist.nl</option>
		<option value="froogle" <?php if ($this->template->export_site == "froogle") echo 'selected="selected"'; ?>>Google Base</option>
		<option value="oodle" <?php if ($this->template->export_site == "oodle") echo 'selected="selected"'; ?>>Oodle</option>
		</select>
		</td>
	</tr>
	
	<!-- Include column headers -->
	<tr id="div_include_column_headers">
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('INCLUDE_COLUMN_HEADERS_TIP'), JText::_('INCLUDE_COLUMN_HEADERS'), 'tooltip.png', '', '', false); ?>
		<?php echo JText::_('INCLUDE_COLUMN_HEADERS'); ?></td>
		<td><input class="template_input checkbox" type="checkbox" id="include_column_headers" name="include_column_headers" value="1" 
		<?php if ($this->template->include_column_headers) echo 'checked=checked'; ?>></td>
	</tr>
	
	<!-- Export filename -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('EXPORT_FILENAME_TIP.'), JText::_('EXPORT_FILENAME'), 'tooltip.png', '', '', false); ?>
		<?php echo JText::_('EXPORT_FILENAME');?></td>
		<td><input class="template_input longtext" type="text" id="export_filename" name="export_filename" value="<?php echo $this->template->export_filename; ?>" /></td>
	</tr>
	
	<!-- Export frontend -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('EXPORT_FRONTEND_TIP'), JText::_('EXPORT_FRONTEND'), 'tooltip.png', '', '', false); ?>
		<?php echo JText::_('EXPORT_FRONTEND');?></td>
		<td><?php echo $this->lists['export_frontend']; ?></td>
	</tr>
	
	<!-- VirtueMart ID -->
	<tr>
	<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('EXPORT_VM_ID_TIP'), JText::_('EXPORT_VM_ID'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('EXPORT_VM_ID');?></td>
		<td><?php echo $this->lists['vm_itemid']; ?></td>
	</tr>
	
	<!-- Set shopper group name the user wants to export -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('Select a shopper group name to export products of that particular shopper group.'), JText::_('Shopper group name'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('Shopper group name');?></td>
		<td><select name="shopper_group_id">
		<option value="0"><?php echo JText::_('All');?></option>
		<?php foreach ($this->shopper_groups as $key => $group) { ?>
			<option value="<?php echo $group->shopper_group_id;?>"
			<?php if ($this->template->shopper_group_id == $group->shopper_group_id) echo 'selected="selected"'; ?>
			><?php echo $group->shopper_group_name;?></option>
		<?php } ?>
		</select>
	</tr>
	
	<!-- Set manufacturer name the user wants to export -->
	<?php $template_mf = explode(",", $this->template->manufacturer); ?>
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('MANUFACTURER_TIP'), JText::_('MANUFACTURER'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('MANUFACTURER');?></td>
		<td><select multiple name="manufacturer[]" size="7">
		<option value="0"
		<?php if (in_array("0", $template_mf)) echo 'selected="selected"'; ?>
		><?php echo JText::_('All');?></option>
		<?php foreach ($this->manufacturers as $key => $mf) { ?>
			<option value="<?php echo $mf->manufacturer_id;?>"
			<?php if (in_array($mf->manufacturer_id, $template_mf)) echo 'selected="selected"'; ?>
			><?php echo $mf->mf_name;?></option>
		<?php } ?>
		</select>
	</tr>
	
	<!-- Check which state of products the user want to export -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('EXPORT_STATE_TIP'), JText::_('EXPORT_STATE'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('EXPORT_STATE');?></td>
		<td><input type="radio" id="product_publish" name="product_publish" value=""
		<?php if ($this->template->product_publish == '') echo 'checked=checked'; ?>
		><?php echo JText::_('Both'); ?>
		<br />
		<input type="radio" id="product_publish" name="product_publish" value="Y"
		<?php if ($this->template->product_publish == 'Y') echo 'checked=checked'; ?>
		><?php echo JText::_('Published'); ?>
		<br />
		<input type="radio" id="product_publish" name="product_publish" value="N"
		<?php if ($this->template->product_publish == 'N') echo 'checked=checked'; ?>
		><?php echo JText::_('Unpublished'); ?></td>
	</tr>
	
	<!-- Product URL suffix -->
	<tr>
	<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('PRODUCT_URL_SUFFIX_TIP'), JText::_('PRODUCT_URL_SUFFIX'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('PRODUCT_URL_SUFFIX');?></td>
		<td><input class="template_input longtext" type="text" id="producturl_suffix" name="producturl_suffix" value="<?php echo $this->template->producturl_suffix; ?>" /></td>
	</tr>
	
	<!-- Date format -->
	<tr>
	<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('EXPORT_DATE_FORMAT_TIP'), JText::_('EXPORT_DATE_FORMAT'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('EXPORT_DATE_FORMAT');?></td>
		<td><input class="template_input" type="text" id="export_date_format" name="export_date_format" value="<?php echo $this->template->export_date_format; ?>" /></td>
	</tr>
	<!-- Price format -->
	<tr>
	<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('EXPORT_PRICE_FORMAT_TIP'), JText::_('EXPORT_PRICE_FORMAT'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('EXPORT_PRICE_FORMAT');?></td>
		<td><input class="template_input" type="text" id="export_price_format" name="export_price_format" value="<?php echo $this->template->export_price_format; ?>" /></td>
	</tr>
	<!-- Add currency to price -->
	<tr>
	<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('EXPORT_ADD_CURRENCY_TO_PRICE_TIP'), JText::_('EXPORT_ADD_CURRENCY_TO_PRICE'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('EXPORT_ADD_CURRENCY_TO_PRICE');?></td>
		<td><?php echo JHTML::_('select.booleanlist', 'add_currency_to_price', '', $this->template->add_currency_to_price); ?></td>
	</tr>
</table>
<script type="text/javascript">
jQuery("#export_type").live('click', function() {
	if (jQuery(this).val() == 'xml') {
		jQuery('#div_export_site').show();
		if (jQuery('#export_site').val() == '') {
			jQuery('#toolbar-csvi_save_32').hide();
		}
		else jQuery('#toolbar-csvi_save_32').show();
	}
	else {
		jQuery('#div_export_site').hide();
		jQuery('#toolbar-csvi_save_32').show();
	}
})

jQuery("#export_site").blur(function() {
	if (jQuery('#export_site').val() == '') {
		jQuery('#toolbar-csvi_save_32').hide();
	}
	else jQuery('#toolbar-csvi_save_32').show();
})

UpdateRowClass('template_export');

function submitbutton(pressbutton) {
	if (jQuery('#export_type').val() == 'xml' && jQuery('#export_site').val() == '') {
		jAlert('<?php echo JText::_('NO_SITE_FOR_EXPORT_TYPE'); ?>', '<?php echo JText::_('FAILURE'); ?>');
		return false;
	}
	else submitform(pressbutton);
}
</script>
