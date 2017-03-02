<?php defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' ); ?>
<table class="adminlist" id="template_email">
	<!-- E-mail exported file -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('EXPORT_EMAIL_FILE_TIP'), JText::_('EXPORT_EMAIL_FILE'), 'tooltip.png', '', '', false); ?>
		<?php echo JText::_('EXPORT_EMAIL_FILE');?></td>
		<td><?php echo JHTML::_('select.booleanlist', 'export_email', '', $this->template->export_email); ?>
	</tr>
	
	<!-- E-mail addresses -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('EXPORT_EMAIL_ADDRESSES_TIP'), JText::_('EXPORT_EMAIL_ADDRESSES'), 'tooltip.png', '', '', false); ?>
		<?php echo JText::_('EXPORT_EMAIL_ADDRESSES');?></td>
		<td><textarea id="export_email_addresses" name="export_email_addresses" cols="50"><?php echo $this->template->export_email_addresses; ?></textarea></td>
	</tr>
	
	<!-- CC E-mail addresses -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('EXPORT_EMAIL_ADDRESSES_CC_TIP'), JText::_('EXPORT_EMAIL_ADDRESSES_CC'), 'tooltip.png', '', '', false); ?>
		<?php echo JText::_('EXPORT_EMAIL_ADDRESSES_CC');?></td>
		<td><textarea id="export_email_addresses_cc" name="export_email_addresses_cc" cols="50"><?php echo $this->template->export_email_addresses_cc; ?></textarea></td>
	</tr>
	
	<!-- BCC E-mail addresses -->
	<tr>
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('EXPORT_EMAIL_ADDRESSES_BCC_TIP'), JText::_('EXPORT_EMAIL_ADDRESSES_BCC'), 'tooltip.png', '', '', false); ?>
		<?php echo JText::_('EXPORT_EMAIL_ADDRESSES_BCC');?></td>
		<td><textarea id="export_email_addresses_bcc" name="export_email_addresses_bcc" cols="50"><?php echo $this->template->export_email_addresses_bcc; ?></textarea></td>
	</tr>
	
	<!-- E-mail subject -->
	<tr id="email_subject">
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('EXPORT_EMAIL_SUBJECT_TIP'), JText::_('EXPORT_EMAIL_SUBJECT'), 'tooltip.png', '', '', false); ?>
		<?php echo JText::_('EXPORT_EMAIL_SUBJECT');?></td>
		<td><input class="template_input longtext" type="text" id="export_email_subject" name="export_email_subject" value="<?php echo $this->template->export_email_subject; ?>" /></td>
	</tr>
	
	<!-- E-mail body -->
	<tr id="email_body">
		<td class="template_config_label"><?php echo JHTML::tooltip(JText::_('EXPORT_EMAIL_BODY_TIP'), JText::_('EXPORT_EMAIL_BODY'), 'tooltip.png', '', '', false); ?>
		<?php echo JText::_('EXPORT_EMAIL_BODY');?></td>
		<td><?php echo $this->editor->display( 'export_email_body',  $this->template->export_email_body, '100%;', '550', '75', '20', array('pagebreak', 'readmore') ) ; ?></td>
	</tr>
</table>
<script type="text/javascript">
UpdateRowClass('template_email');
</script>
