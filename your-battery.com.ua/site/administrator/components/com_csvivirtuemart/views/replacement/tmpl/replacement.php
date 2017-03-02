<?php
/**
* About page
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: replacement.php 1140 2010-01-28 18:59:45Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
?>
<form action="index.php" method="post" id="adminForm" name="adminForm">
	<div id="fieldlistdiv">
		<table class="adminlist">
			<thead>
				<tr>
					<th><?php echo JText::_('NEW_REPLACEMENT_OLD_VALUE'); ?></th>
					<th><?php echo JText::_('NEW_REPLACEMENT_NEW_VALUE'); ?></th>
					<th><?php echo JText::_('REPLACEMENT_TYPE'); ?></th>
					<th><?php echo JText::_('TEMPLATE'); ?></th>
					<th><?php echo JText::_('NEW_FIELD_NAME'); ?></th>
					<th><?php echo JText::_('Add'); ?></th>
				</tr>
			</thead>
			<tr class="row0">
				<td>
					<input type="text" class="replaceinput" name="_old_value" value="" />
				</td>
				<td>
					<input type="text" class="replaceinput" name="_new_value" value="" />
				</td>
				<!-- Regex? -->
				<td>
					<?php 
						echo JHTMLSelect::genericlist($this->regex_options, '_regex', null, 'value', 'text'); 
					?>
				</td>
				<!-- Template -->
				<td>
					<?php 
					echo JHTMLSelect::genericlist($this->templates, '_template_id', '', 'template_id', 'template_name'); 
					?>
				</td>
				<!-- Field -->
				<td>
					<?php
					if (array_key_exists(0, $this->templates)) echo JHTMLSelect::genericlist($this->template_fields[$this->templates[0]->template_id], '_field_id');
					?>
				</td>
				<td class="center">
					<?php echo JHTML::_('link', JRoute::_('index.php?option=com_csvivirtuemart&controller=replacement'), '<img src="'.JURI::root().'administrator/components/com_csvivirtuemart/assets/images/csvivirtuemart_add_32.png" width="20" height="20" alt="'.JText::_('Add').'" />', 'id="addnew"'); ?>
				</td>
			</tr>
			
			</table>
			<br clear="all" />
			<!-- Search field for limiting the fields -->
			<div id="filterbox">
				<?php echo JText::_('Filter'); ?> <input type="text" id="filterfield" name="filterfield" value="<?php echo $this->filter; ?>" />
				<input type="submit" value="<?php echo JText::_('GO'); ?>" />
				<input type="reset" value="<?php echo JText::_('RESET'); ?>" onclick="jQuery('#filterfield').val(''); jQuery('#adminForm').submit();" />
			</div>
			<table id="replacement_table" class="adminlist">
			<thead>
				<tr>
					<th width="20" class="title"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->replacements); ?>);" /></th>
					<th><?php echo JText::_('REPLACEMENT_OLD_VALUE'); ?></th>
					<th><?php echo JText::_('REPLACEMENT_NEW_VALUE'); ?></th>
					<th><?php echo JText::_('REPLACEMENT_TYPE'); ?></th>
					<th><?php echo JText::_('TEMPLATE'); ?></th>
					<th><?php echo JText::_('FIELD_NAME'); ?></th>
					<th><?php echo JText::_('PUBLISHED'); ?></th>
					<th><?php echo JText::_('DELETE'); ?></th>
				</tr>
			</thead>
			<tfoot>
			<tr>
				<td colspan="8"><?php echo $this->pagination->getListFooter(); 
				?></td>
			</tr>
			</tfoot>
			<?php
			for ($i=0, $n=count($this->replacements); $i < $n; $i++) {
				if (isset($this->replacements[$i])) {
					$field = $this->replacements[$i];
					$field->checked_out = 0;
					$img 	= $field->published ? 'tick.png' : 'publish_x.png';
					$task 	= $field->published ? 'unpublish' : 'publish';
					$alt 	= $field->published ? JText::_('Published') : JText::_('Unpublished');
					
					$checked = JHTML::_('grid.checkedout', $field, $i);
				}
				?>
				<tr id="tr<?php echo $i;?>">
					<!-- Checkbox -->
					<td>
						<?php echo $checked; ?>
					</td>
					<!-- Old value -->
					<td>
						<input type="text" class="replaceinput" name="field[<?php echo $field->id ?>][old_value]" value="<?php echo $field->old_value ?>" />
					</td>
					<!-- New value -->
					<td>
						<input type="text" class="replaceinput" name="field[<?php echo $field->id ?>][new_value]" value="<?php echo $field->new_value ?>" />
					</td>
					<!-- Regex? -->
					<td>
						<?php 
							echo JHTMLSelect::genericlist($this->regex_options, 'field['.$field->id.'][regex]', null, 'value', 'text', $field->regex); 
						?>
					</td>
					<!-- Template -->
					<td>
						<?php 
							echo JHTMLSelect::genericlist($this->templates, 'field['.$field->id.'][template_id]', null, 'template_id', 'template_name', $field->template_id); 
						?>
					</td>
					<!-- Field -->
					<td>
						<?php 
							echo JHTMLSelect::genericlist($this->template_fields[$field->template_id], 'field['.$field->id.'][field_id]', null, 'value', 'text', $field->field_id); 
						?>
					</td>
					<!-- Published -->
					<td class="center">
						<a id="publish" href="index.php">
						<img id="image<?php echo $field->id; ?>" src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" title="<?php echo $alt; ?>" />
						</a>
					</td>
					<!-- Delete -->
					<td class="center">
						<a id="delete" href="index.php">
							<img src="<?php echo JURI::root().'/administrator/components/com_csvivirtuemart/assets/images/csvivirtuemart_delete_32.png'; ?>" width="20" height="20" border="0" alt="<?php echo $alt; ?>" />
						</a>
					</td>
				</tr>
				<?php
			}
			?>
		</table>
	</div> <!-- End replacement list  -->
	<input type="hidden" name="option" value="com_csvivirtuemart" />
	<input type="hidden" id="task" name="task" value="replacement" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="controller" value="replacement" />
</form>
<script type="text/javascript">
UpdateRowClass('replacement_table');

jQuery('a#addnew').live('click', function() {
	jQuery('#task').val('add');
	jQuery('#adminForm').submit();
	return false;
});

jQuery('a#delete').live('click', function() {
	jQuery('#system-message').remove();
	jQuery('#submenu-box').after('<dl id="system-message"></dl>');
	var trid = jQuery(this).parent().parent().attr('id');
	var replacement_id = jQuery('#'+trid+' input').val();
	jQuery.getJSON("index.php",{option: 'com_csvivirtuemart', 
								controller: 'replacement', 
								task: 'remove',  
								format: 'json', 
								cid: replacement_id}, function(data){
		if (data.result == 1) {
			/* Remove the table row */
			jQuery('#'+trid).remove();
			
			/* Output message */
			jQuery('#system-message').append('<dt class="message">Message</dt><dd class="message fade"><ul><li><?php echo JText::_('REPLACEMENT_REMOVED');?></li></ul></dd>');
		}
		else if (data.result == 0) {
			/* Output message */
			jQuery('#system-message').append('<dt class="message">Message</dt><dd class="message fade"><ul><li><?php echo JText::_('REPLACEMENT_NOT_REMOVED');?></li></ul></dd>');
		}
		
		/* Update the row classes */
		UpdateRowClass('replacement_table');
	});
	return false;
});

jQuery('a#publish').live('click', function() {
	jQuery('#system-message').remove();
	jQuery('#submenu-box').after('<dl id="system-message"></dl>');
	var trid = jQuery(this).parent().parent().attr('id');
	var replacement_id = jQuery('#'+trid+' input').val();
	jQuery.getJSON("index.php",{option: 'com_csvivirtuemart', 
								controller: 'replacement', 
								task: 'publish',  
								format: 'json', 
								id: replacement_id}, 
		function(data){
			/* Published field */
			if (data.result == 1) {
				/* Change the image */
				jQuery('#image'+replacement_id).attr("src", jQuery('#image'+replacement_id).attr("src").replace('publish_x', 'tick'));
				
				/* Output message */
				jQuery('#system-message').append('<dt class="message">Message</dt><dd class="message fade"><ul><li><?php echo JText::_('REPLACEMENT_PUBLISHED');?></li></ul></dd>');
			}
			/* Unpublished field */
			else if (data.result == 0) {
				/* Change the image */
				jQuery('#image'+replacement_id).attr("src", jQuery('#image'+replacement_id).attr("src").replace('tick', 'publish_x'));
				
				/* Output message */
				jQuery('#system-message').append('<dt class="message">Message</dt><dd class="message fade"><ul><li><?php echo JText::_('REPLACEMENT_UNPUBLISHED');?></li></ul></dd>');
		}
	});
	return false;
});

jQuery('#_template_id').live('change', function() {
	var template_id = jQuery(this).val();
	jQuery.getJSON("index.php",{option: 'com_csvivirtuemart', 
								controller: 'replacement', 
								task: 'loadfields',  
								format: 'json', 
								template_id: template_id}, 
	function(data){
		var optionsValues = '<select id="_field_id">';
		for (var i = 0; i < data.length; i++) {
                optionsValues += '<option value="' + data[i].value + '">' + data[i].text + '</option>';
        };
        optionsValues += '</select>';
        jQuery('#_field_id').replaceWith(optionsValues);
								
	});
})

jQuery("select[id^='field']").each(function() {
		var foundid = jQuery(this).attr('id').match(/^field\d+template_id/);
		if (foundid) {
			var selectid = jQuery('#'+foundid);
			jQuery(selectid).live('change', function() {
				var template_id = jQuery(selectid).val();
				jQuery.getJSON("index.php",{option: 'com_csvivirtuemart', 
											controller: 'replacement', 
											task: 'loadfields',  
											format: 'json', 
											template_id: template_id}, 
				function(data){
					var idname = jQuery(selectid).attr('id').replace('template_id', 'template_field');
					var tagname = jQuery(selectid).attr('name').replace('template_id', 'field_id');
					var optionsValues = '<select id="'+idname+'" name="'+tagname+'">';
					for (var i = 0; i < data.length; i++) {
							optionsValues += '<option value="' + data[i].value + '">' + data[i].text + '</option>';
					};
					optionsValues += '</select>';
					jQuery('#'+idname).replaceWith(optionsValues);
											
				});
			})
		}
});


</script>