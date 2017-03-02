<?php
/**
* Settings import page
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: settings_import.php 1119 2010-01-04 23:31:29Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
echo $this->params->render( 'params', 'import' );
?>
<script type="text/javascript">
	function submitbutton(pressbutton) {
		var nolines = parseInt(jQuery('#paramsimport_nolines').val());
		var preview = parseInt(jQuery('#paramsimport_preview').val());
		if (nolines > 0 && nolines <= preview) {
			jAlert('<?php echo JText::_('PREVIEW_NOT_GREATER_NOLINES'); ?>', '<?php echo JText::_('FAILURE'); ?>');
			return false;
		}
		else submitform(pressbutton);
	}
</script>