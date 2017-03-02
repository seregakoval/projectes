<?php
/**
* Template configurator file paths
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: templateconfigurator_images.php 1117 2010-01-01 21:39:52Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
?>
<table class="adminlist" id="template_images">
	<!-- Automatic thumbnail creation -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('If enabled, thumbnails will be created automatically of image files'), JText::_('Automatic thumbnail creation'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('Automatic thumbnail creation'); ?></td>
		<td><input class="template_input checkbox" type="checkbox" id="thumb_create" name="thumb_create" value="1"
		<?php if ($this->template->thumb_create) echo ' checked=checked'; ?>></td>
	</tr>
	
	<!-- Thumbnail format -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('Select the output format of the thumbnails. Leave on default to use the format of the master file. This can be used to create thumbnails that are all in the same format.'), JText::_('Thumbnail format'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('Thumbnail format'); ?></td>
		<td><?php echo $this->lists['thumbnailformat']; ?></td>
	</tr>
	
	<!-- Thumbnail width -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('Importing image files will create thumbnails of the size set here'), JText::_('Thumbnail width x height'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('Thumbnail width x height'); ?></td>
		<td><input class="template_input thumbs" type="text" maxlength="4" id="thumb_width" name="thumb_width" value="<?php echo $this->template->thumb_width;?>">
		<span class="template_img_symbol">x</span>
		<input class="thumbs" type="text" maxlength="4" id="thumb_height" name="thumb_height" value="<?php echo $this->template->thumb_height; ?>">
		</td>
	</tr>
	
	<!-- Auto generate image names -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('AUTO_GENERATE_IMAGE_NAME_TIP'), JText::_('AUTO_GENERATE_IMAGE_NAME'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('AUTO_GENERATE_IMAGE_NAME'); ?></td>
		<td><input class="template_input checkbox" type="checkbox" id="auto_generate_image_name" name="auto_generate_image_name" value="1"
		<?php if ($this->template->auto_generate_image_name) echo ' checked=checked'; ?>></td>
	</tr>
	
	<!-- Auto generate image name extension -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('AUTO_GENERATE_IMAGE_NAME_EXT_TIP'), JText::_('AUTO_GENERATE_IMAGE_NAME_EXT'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('AUTO_GENERATE_IMAGE_NAME_EXT'); ?></td>
		<td><?php echo $this->lists['autogenerateext']; ?></td>
	</tr>
	
	<!-- Save images on server -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('SAVE_IMAGES_ON_SERVER_TIP'), JText::_('SAVE_IMAGES_ON_SERVER'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('SAVE_IMAGES_ON_SERVER'); ?></td>
		<td><input class="template_input checkbox" type="checkbox" id="save_images_on_server" name="save_images_on_server" value="1"
		<?php if ($this->template->save_images_on_server) echo ' checked=checked'; ?>></td>
	</tr>
</table>
<script type="text/javascript">
UpdateRowClass('template_images');
</script>
