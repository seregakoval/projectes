<?php
/**
* Import file
*
* @package CSVIVirtueMart
* @subpackage Import
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: importfile.php 1138 2010-01-27 22:54:36Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
if (isset($this->redirect)) {
	?>
	<div id="maincontent">
		<div id="loading" style="float: left;">
			<?php echo JHTML::_('image', JURI::root().'administrator/components/com_csvivirtuemart/assets/images/csvivirtuemart_ajax-loading.gif', JText::_('LOADING')) ;?>
		</div>
		<br />
		<?php echo JText::_('TIME_RUNNING'); ?>
		<div class="uncontrolled-interval">
			<span></span>
		</div>
		<br clear="all" />
		<div id="status" style="float: left;"></div>
		<div id="progress" style="float: left; display: none;">
		<?php
			$attribs = array('frameborder' => "0",  'scrolling' => "yes",  'width' => "500", 'height' => "400");
			echo JHTML::_('iframe', $this->redirect, 'importframe', $attribs); 
			?>
		</div>
	</div>
<?php } ?>
<form method="post" action="index.php" name="adminForm"> 
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="option" value="com_csvivirtuemart" />
	<input type="hidden" name="controller" value="import" />
	<input type="hidden" name="import_id" value="<?php echo $this->import_id; ?>" />
	<input type="hidden" name="filename" value="<?php echo basename($this->filename); ?>" />
	<input type="hidden" name="template_name" value="<?php echo $this->template->template_name; ?>" />
	<input type="hidden" name="action_type" value="<?php echo $this->template->template_type; ?>" />
</form>
<script type="text/javascript">
jQuery(function() { 
	jQuery(".uncontrolled-interval span").everyTime(1000, 'importcounter', function(i) {
		if (<?php echo ini_get('max_execution_time'); ?> > 0 && i > <?php echo ini_get('max_execution_time'); ?>) {
			jQuery("#loading").remove();
			jQuery("#progress").remove();
			jQuery(this).html('<?php echo JText::_('MAX_IMPORT_TIME_PASSED'); ?>');
		}
		else jQuery(this).html(i);
	});
});
</script>
