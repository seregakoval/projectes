<?php
/**
* Template configurator file paths
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: templateconfigurator_general_settings.php 1117 2010-01-01 21:39:52Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

$row = 0; ?>
<table class="adminlist" id="general_settings">
	<!-- Template type -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('CHOOSE_YOUR_TEMPLATE_TIP'), JText::_('CHOOSE_YOUR_TEMPLATE'), 'tooltip.png', '', '', false); ?>
		<?php echo JText::_('CHOOSE_YOUR_TEMPLATE');?>
		<td><?php echo $this->lists['template_type']; ?></td>
	</tr>
	
	<!-- Template name -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('The name of the template'), JText::_('Name'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('Name');?></td>
		<td><input class="template_input longtext" type="text" id="template_name" name="template_name" value="<?php echo $this->template->template_name; ?>"></td>
	</tr>
	
	<!-- Auto detect delimiters -->
	<tr id="auto_detect_delimiters">
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('IMPORT_AUTO_DETECT_DELIMITER_TIP'), JText::_('IMPORT_AUTO_DETECT_DELIMITER'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('IMPORT_AUTO_DETECT_DELIMITER');?></td>
		<td><?php echo $this->lists['auto_detect_delimiters']; ?></td>
	</tr>
	
	<!-- Field delimiter -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('FIELD_DELIMITER_TIP'), JText::_('FIELD_DELIMITER'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('FIELD_DELIMITER');?></td>
		<td><input class="template_input delimiter" type="text" maxlength="1" id="field_delimiter" name="field_delimiter" value="<?php echo $this->template->field_delimiter; ?>"></td>
	</tr>
	
	<!-- Text enclosure -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('TEXT_ENCLOSURE_TIP'), JText::_('TEXT_ENCLOSURE'), 'tooltip.png', '', '', false); ?> 
		<?php echo JText::_('TEXT_ENCLOSURE');?></td>
		<td><input class="template_input delimiter" type="text" maxlength="1" id="text_enclosure" name="text_enclosure"
		<?php 
			if ($this->template->text_enclosure == '"') echo "value='".$this->template->text_enclosure."'>";
			else echo '"value="'.$this->template->text_enclosure.'">';
		?>
		</td>
	</tr>
</table>
<script type="text/javascript">
UpdateRowClass('general_settings');
</script>
