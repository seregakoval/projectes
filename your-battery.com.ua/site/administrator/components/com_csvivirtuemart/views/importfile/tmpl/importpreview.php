<?php
/**
* Import preview
*
* @package CSVIVirtueMart
* @subpackage Import
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: importpreview.php 1136 2010-01-23 14:05:53Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
?>
<form method="post" action="index.php" name="adminForm"> 
	<input type="hidden" name="option" value="com_csvivirtuemart" />
	<?php
	if (!JRequest::getBool('error_found', false)) { ?>
		<input type="hidden" name="task" value="importfile" />
		<input type="hidden" name="controller" value="importfile" />
		<input type="hidden" name="template_id" value="<?php echo $this->template_id; ?>" />
		<input type="hidden" name="was_preview" value="Y" />
		<input type="hidden" name="selectfile" value="2" />
		<input type="hidden" name="local_csv_file" value="<?php echo $this->csvfile;?>" />
		<div style="width: 100%; float: left; overflow: auto;">
			<div id="importcontinue"><?php echo JText::_('CLICK_IMPORT_CONTINUE'); ?></div>
			<div class="userfilename"><?php echo JText::_('PREVIEW_FOR').' '.basename($this->filename); ?></div>
			<table class="adminlist" style="empty-cells: show;">
				<thead>
					<tr>
						<?php
						foreach ($this->csvfields as $name => $order) {
							echo '<th>'.$name.'</th>';
						}
						?>
					</tr>
				</thead>
				<tbody>
				<tr>
				<?php
				foreach ($this->datapreview as $id => $data) {
					foreach( $this->csvfields as $fieldname ) {
						if (isset($data[$fieldname["order"]])) {
							echo '<td>'.$data[$fieldname["order"]].'</td>';
						}
						else echo '<td></td>';
					}
					echo '</tr><tr>';
				}
				?>
				</tr>
				</tbody>
			</table>
		</div>
	<?php }
	else {
	?>
		<input type="hidden" name="task" value="import" />
		<input type="hidden" name="controller" value="import" />
	<?php 
		echo JText::_('ERROR_FOUND_IN_FILE');
	}
	?>
</form>
