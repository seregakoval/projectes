<?php
/**
* Template configurator
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: templateconfigurator.php 1117 2010-01-01 21:39:52Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
JHTML::_('behavior.tooltip');
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
	<?php $pane = JPane::getInstance('tabs'); 
	echo $pane->startPane("configurator");
	echo $pane->startPanel( JText::_('GENERAL_SETTINGS'), 'settings_tab' );
		echo $this->loadTemplate('general_settings');
	echo $pane->endPanel();
	
	echo $pane->startPanel( JText::_('IMPORT'), 'import_tab' );
		echo $this->loadTemplate('config_import');
	echo $pane->endPanel();
	
	echo $pane->startPanel( JText::_('IMAGES'), 'images_tab' );
		echo $this->loadTemplate('images');
	echo $pane->endPanel();

	echo $pane->startPanel( JText::_('EXPORT'), 'export_tab' );
		echo $this->loadTemplate('config_export');
	echo $pane->endPanel();
	
	echo $pane->startPanel( JText::_('EMAIL'), 'email_tab' );
		echo $this->loadTemplate('email');
	echo $pane->endPanel();
	
	echo $pane->startPanel( JText::_('FILE_PATHS'), 'paths_tab' );
		echo $this->loadTemplate('file_paths');
	echo $pane->endPanel();
	
	echo $pane->startPanel( JText::_('SYSTEM_LIMITS'), 'limits_tab' );
		echo $this->loadTemplate('system_limits');
	echo $pane->endPanel();
	
	echo $pane->endPane();
	?>
	<input type="hidden" name="option" value="com_csvivirtuemart" />
	<input type="hidden" name="controller" value="templates" />
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="template_id" value ="<?php echo $this->template->template_id; ?>" />
</form>
<script type="text/javascript">
jQuery(document).ready(function() {
		var type = '<?php echo stristr($this->template->template_type, 'export') ? 'export' : 'import';?>';
		jQuery('#'+type+'_tab').show();
		if (type == 'import') {
			jQuery('#images_tab').show();
			if (<?php echo $this->template->auto_detect_delimiters; ?> == '1') {
				jQuery('#field_delimiter').attr("disabled", true);
				jQuery('#text_enclosure').attr("disabled", true);
			}
		}
		else if (type == 'export') {
			jQuery('#email_tab').show();
			jQuery('#auto_detect_delimiters').hide();
		}
});
jQuery('#1import').live('click', function() {
	jQuery('#export_tab').hide();
	jQuery('#email_tab').hide();
	jQuery('#import_tab').show();
	jQuery('#images_tab').show();
	jQuery('#auto_detect_delimiters').show();
	if (jQuery('input[name=auto_detect_delimiters]:checked').val() == 1) {
		jQuery('#field_delimiter').attr("disabled", true);
		jQuery('#text_enclosure').attr("disabled", true);
	}
	else {
		jQuery('#field_delimiter').attr("disabled", false);
		jQuery('#text_enclosure').attr("disabled", false);
	}
});

jQuery('#1export').live('click', function() {
	jQuery('#import_tab').hide();
	jQuery('#images_tab').hide();
	jQuery('#auto_detect_delimiters').hide();
	jQuery('#export_tab').show();
	jQuery('#email_tab').show();
	jQuery('#field_delimiter').attr("disabled", false);
	jQuery('#text_enclosure').attr("disabled", false);
})

jQuery('#auto_detect_delimiters0').live('click', function() {
	jQuery('#field_delimiter').attr("disabled", false);
	jQuery('#text_enclosure').attr("disabled", false);
});

jQuery('#auto_detect_delimiters1').live('click', function() {
	jQuery('#field_delimiter').attr("disabled", true);
	jQuery('#text_enclosure').attr("disabled", true);
});
</script>
