<?php
/**
* Template fields
*
* @package CSVIVirtueMart
* @subpackage Templates
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: templatefields.php 1139 2010-01-28 18:34:11Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' ); 

$hiddenfields = '';
?>
<form action="index.php" method="post" name="adminForm">
	<div id="fieldlistdiv">
		<table id="newfieldlist" class="adminlist">
			<thead>
				<tr>
					<th class="title"><?php echo JText::_('NEW_FIELD_ORDERING'); ?></th>
					<th class="title"><?php echo JText::_('NEW_FIELD_NAME'); ?></th>
					<?php if (substr($this->template->template_type, -6) == 'export') { ?>  <th class="title"><?php echo JText::_('NEW_COLUMN_HEADER'); ?></th> <?php } ?>
					<th class="title"><?php echo JText::_('NEW_DEFAULT_VALUE'); ?></th>
					<th class="title"><?php echo JText::_('NEW_REPLACE'); ?></th>
					<th class="title"><?php echo JText::_('Add'); ?></th>
			</thead>
			<tbody>
				<tr>
					<!-- Field ordering -->
					<td class="center">
						<input type="text" name="field[{fill}][_order]" value="<?php echo $this->totalfields; ?>" size="4" />
					</td>
					<!-- Field name -->
					<td>
						<?php echo JHTML::_('select.genericlist', $this->csvisupportedfields, 'field[{fill}][_field_name]'); ?>
					</td>
					<!-- Column header -->
					<?php if (substr($this->template->template_type, -6) == 'export') { ?> 
						<td>
							<input type="text" name="field[{fill}][_column_header]" value="" />
						</td>
					<?php } 
					else { ?>
						<input type="hidden" name="field[{fill}][_column_header]" value="" />
					<?php } ?>
					<!-- Default value -->
					<td id="newfield_defaultvalue">
						<input type="text" name="field[{fill}][_default_value]" value="" />
					</td>
					<!-- Replace -->
					<td class="center">
						<?php echo JHTML::_('select.booleanlist', 'field[{fill}][_replace]'); ?>
					</td>
					<!-- Add -->
					<td class="center">
						<?php echo JHTML::_('link', JRoute::_('index.php?option=com_csvivirtuemart&controller=templates&task=fieldstemplate&template_id='.$this->template_id), '<img src="'.JURI::root().'administrator/components/com_csvivirtuemart/assets/images/csvivirtuemart_add_32.png" width="20" height="20" alt="'.JText::_('Add').'" />', 'onClick="document.adminForm.task.value = \'addfield\';document.adminForm.submit();return false;"'); ?>
					</td>
				</tr>
			</tbody>
			
		</table>
		<br clear="all" />
		<!-- Search field for limiting the fields -->
		<div id="filterbox">
			<?php echo JText::_('Filter'); ?> <input type="text" id="filterfield" name="filterfield" value="<?php echo $this->filter; ?>" onChange="document.adminForm.submit();" />
		</div>
		<table id="fieldslist" class="adminlist">
			<thead>
			<tr>
				<th width="20" class="title"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->fields); ?>);" /></th>
				<th width="10%" class="title"><?php echo JText::_('Field ordering'); ?> <a href="index2.php" onclick="document.adminForm.task.value='renumber'; document.adminForm.submit(); return false;"><img src="<?php echo JURI::root().'administrator/components/com_csvivirtuemart/assets/images/csvivirtuemart_order_16.png'; ?>" alt="<?php echo JText::_('Renumber');?>" title="<?php echo JText::_('Renumber');?>"></a></th>
				<th class="title"><?php echo JText::_('FIELD_NAME'); ?></th>
				<?php if (substr($this->template->template_type, -6) == 'export') { ?>  <th class="title"><?php echo JText::_('COLUMN_HEADER'); ?></th> <?php } ?>
				<th class="title"><?php echo JText::_('DEFAULT_VALUE'); ?></th>
				<th class="title"><?php echo JText::_('REPLACE'); ?></th>
				<th class="title"><?php echo JText::_('PUBLISHED') ?></th>
				<th class="title"><?php echo JText::_('DELETE'); ?></th>
			</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="8"><?php echo $this->pagination->getListFooter(); ?></td>
				</tr>
			</tfoot>
			<?php
			for ($i=0, $n=count($this->fields); $i < $n; $i++) {
				if (isset($this->fields[$i])) {
					$field = $this->fields[$i];
					
					$img 	= $field->published ? 'tick.png' : 'publish_x.png';
					$task 	= $field->published ? 'unpublish' : 'publish';
					$alt 	= $field->published ? JText::_('Published') : JText::_('Unpublished');
					
					$checked = JHTML::_('grid.checkedout', $field, $i);
				}
				?>
				<tr id="tr<?php echo $i;?>">
				<td>
				<?php echo $checked; ?>
				</td>
				<td class="center"><input type="text" name="field[<?php echo $i ?>][_order]" value="<?php echo $field->field_order ?>"
				size="4" /></td>
				<td>
					<?php echo JHTML::_('select.genericlist', $this->csvisupportedfields, 'field['.$i.'][_field_name]', '', 'value', 'text', $field->field_name); ?>
				
				</td>
				<!-- Column header -->
				<?php if (substr($this->template->template_type, -6) == 'export') { ?> 
					<td>
						<input class="column_header_input" type="text" name="field[<?php echo $i ?>][_column_header]" value="<?php echo $field->field_column_header ?>" />
					</td>
				<?php } 
				else { ?>
					<input class="column_header_input" type="hidden" name="field[<?php echo $i ?>][_column_header]" value="<?php echo $field->field_column_header ?>" />
				<?php } ?>
				<!-- Default value -->
				<td>
					<input type="text" name="field[<?php echo $i ?>][_default_value]" value="<?php echo $field->field_default_value ?>" size="75"/>
				</td>
				<!-- Replace -->
				<td class="center">
					<?php echo JHTML::_('select.booleanlist', 'field['.$i.'][_replace]', null, $field->field_replace); ?>
				</td>
				<!-- Published -->
				<td class="center">
					<a href="index.php" onClick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
						<img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" title="<?php echo $alt; ?>" />
					</a>
				</td>
				<!-- Delete -->
				<td class="center">
				<a href="index.php" onClick="document.adminForm.cb<?php echo $i;?>.checked = true; document.adminForm.task.value='deletefield'; document.adminForm.submit(); return false;">
                    <img src="<?php echo JURI::root().'/administrator/components/com_csvivirtuemart/assets/images/csvivirtuemart_delete_32.png'; ?>" width="20" height="20" border="0" alt="<?php echo $alt; ?>" />
                </a>
				</td>
				</tr>
				<?php
					$hiddenfields .= '<input type="hidden" name="field['.$i.'][_id]" value="'.$field->id.'" />'.chr(10);
				?>
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
</form>
<script type="text/javascript">
UpdateRowClass('newfieldlist');
UpdateRowClass('fieldslist');
</script>