<?php
/**
* Template fields
*
* @package CSVIVirtueMart
* @subpackage Templates
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: quicktemplatefields.php 1138 2010-01-27 22:54:36Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' ); 
$hiddenfields = '';
?>
<form action="index.php" method="post" name="adminForm">
	<div id="fieldlistdiv">
		<table id="fieldslist" class="adminlist">
			<thead>
			<tr>
				<th width="20" class="title"></th>
				<th width="20" class="title"><?php echo JText::_('FIELD_ORDERING'); ?></th>
				<th class="title"><?php echo JText::_('FIELD_NAME'); ?></th>
			</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="2"></td>
				</tr>
			</tfoot>
			<?php
			for ($i=0, $n=count($this->csvisupportedfields); $i < $n; $i++) {
				if (isset($this->csvisupportedfields[$i])) {
					$field = $this->csvisupportedfields[$i];
				}
				?>
				<tr id="tr<?php echo $i;?>">
				<td>
					<input type="checkbox" id="cb<?php echo $i; ?>" name="cid[]" value="<?php echo $field->value; ?>" onClick="document.adminForm.getElementById('field<?php echo $i; ?>').value = 0;" />
				</td>
				<td>
					<input type="text" id="field<?php echo $i; ?>" name="field_order[]" value="" size="2" />
				</td>
				<td>
					<?php echo $field->text; ?>
				
				</td>
				</tr>
				<?php
			}
			?>
		</table>
		<?php
		/* All fields have been added, lets add the hidden fields */
		echo '<div id="formhiddenfields">';
		echo $hiddenfields;
		echo '</div>';
		?>
	</div> <!-- End fieldslist  -->
	<input type="hidden" name="option" value="com_csvivirtuemart" />
	<input type="hidden" name="task" value="templatefields" />
	<input type="hidden" name="controller" value="templatefields" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="template_id" value="<?php echo $this->template_id; ?>" />
	<input type="hidden" name="type" value="quick" />
</form>
<script type="text/javascript">
UpdateRowClass('newfieldlist');
UpdateRowClass('fieldslist');
</script>