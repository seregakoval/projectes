<?php
/**
* Templates list view
*
* @package CSVIVirtueMart
* @subpackage Templates
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: templateslist.php 1118 2010-01-04 11:39:59Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );?>
<form action="index.php" method="post" name="adminForm">
	<div id="header">
		<div id="filterbox" style="float: left;">
		<table class="adminlist">
		  <tr>
			 <td align="left" width="100%">
				<?php echo JText::_('Filter'); ?>:
				<?php echo $this->lists['templatetypes']; ?>
				<input type="text" value="<?php echo JRequest::getVar('filter_templates'); ?>" name="filter_templates" id="filter_templates" size="25" />
				<input type="submit" onclick="this.form.submit();" value="<?php echo JText::_('Go'); ?>" />
				<input type="submit" onclick="document.adminForm.templatetype.value='';" value="<?php echo JText::_('Reset'); ?>" />
			 </td>
		  </tr>
		</table>
		</div>
	</div>
	<br clear="all" />
	<div id="templateslist" style="text-align: left;">
		<table id="templates" class="adminlist">
			<thead>
			<tr>
				<th width="5%"></th>
				<th><?php echo JHTML::_('grid.sort', 'NAME', 'template_name', $this->lists['filter_order_Dir'], $this->lists['filter_order'] ); ?></th>
				<th><?php echo JText::_('Number of fields'); ?></th>
				<th><?php echo JHTML::_('grid.sort', 'TYPE', 'template_type', $this->lists['filter_order_Dir'], $this->lists['filter_order'] ); ?></th>
				<th><?php echo JText::_('FIELDS'); ?></th>
			</tr>
			</thead>
			<?php
			$rowcolor = 0;
			$i=0;
			foreach ($this->templateslist as $id => $details) {
				$link = JRoute::_( 'index.php?option=com_csvivirtuemart&controller=templates&task=edittemplate&template_id='. $details->id);
				?>
                <tr>
                <?php
				/* Checkbox */
				echo "<td><input type=\"radio\" id=\"cb".$i++."\" name=\"template_id\" value=\"".$details->id."\" onclick=\"isChecked(this.checked);\" /></td>";
				/* Name */
				echo "<td><a href=".$link.">".$details->name."</a></td>";
				/* Number of fields */
				echo "<td>".$details->nrfields."</td>";
				/* Template type */
				echo "<td>".JText::_($details->type)."</td>\n";
				/* Edit button*/  ?>
				<td>
					<?php
						$url_edit = JRoute::_('index.php?option=com_csvivirtuemart&controller=templatefields&template_id='.$details->id);
						$url_add = JRoute::_('index.php?option=com_csvivirtuemart&controller=templatefields&template_id='.$details->id.'&view=quicktemplatefields');
						$attribs['style'] = 'margin: 5px';
						echo JHTML::_('link', $url_edit, JHTML::_('image', JURI::root().'administrator/components/com_csvivirtuemart/assets/images/csvivirtuemart_edit_16.png', JText::_('EDIT'), $attribs));
						echo JHTML::_('link', $url_add, JHTML::_('image', JURI::root().'administrator/components/com_csvivirtuemart/assets/images/csvivirtuemart_add_16.png', JText::_('QUICK_ADD_TEMPLATE'), $attribs));
					?>
				</td>
				</tr>
				<?php
			}
			?>
			<tr>
				<td colspan="5"><?php echo $this->pagination->getListFooter(); ?></td>
			</tr>
		</table>
	</div>
	<input type="hidden" name="option" value="com_csvivirtuemart" />
	<input type="hidden" name="task" value="templates" />
	<input type="hidden" name="boxchecked" value="0" />
	<!-- Only used to reset the entries counter in the page navigation -->
	<input type="hidden" name="fromtemplatelist" value="1" />
	<input type="hidden" name="controller" value="templates" />
	<input type="hidden" name="filter_order" value="<?php echo $this->lists['filter_order']; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['filter_order_Dir']; ?>" />
</form>
<script type="text/javascript">
	UpdateRowClass('templates');
</script>
