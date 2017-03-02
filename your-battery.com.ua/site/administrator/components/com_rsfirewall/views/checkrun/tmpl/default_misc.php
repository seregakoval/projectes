<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009-2011 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');
?>

<!-- file and folder access -->

<h3>&rarr; <?php echo JText::_('RSF_FILE_ACCESS_CHECK'); ?></h3>
	<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="1%">&nbsp;</th>
			<th class="title" width="20%"><?php echo JText::_('RSF_ACTION'); ?></th>
			<th><?php echo JText::_('RSF_RESULT'); ?></th>
		</tr>
	</thead>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo $this->tempIsOutside ? 'check' : 'nocheck'; ?>24.png" alt="" /></td>
			<td><?php echo JText::_('RSF_TEMP_OUTSIDE'); ?></td>
			<td><?php echo $this->tempIsOutside ? JText::_('RSF_OK_TEMP_OUTSIDE') : JText::_('RSF_NO_TEMP_OUTSIDE'); ?> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&amp;task=redirect&amp;code=TEMP_OUTSIDE" target="_blank"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/readmore.png" alt="" /></a></td>
		</tr>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo $this->logIsOutside ? 'check' : 'nocheck'; ?>24.png" alt="" /></td>
			<td><?php echo JText::_('RSF_LOG_OUTSIDE'); ?></td>
			<td><?php echo $this->logIsOutside ? JText::_('RSF_OK_LOG_OUTSIDE') : JText::_('RSF_NO_LOG_OUTSIDE'); ?> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&amp;task=redirect&amp;code=LOG_OUTSIDE" target="_blank"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/readmore.png" alt="" /></a></td>
		</tr>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo $this->tempFiles == 0 ? 'check' : 'nocheck'; ?>24.png" alt="" /></td>
			<td><?php echo JText::_('RSF_TEMP_FILES'); ?></td>
			<td>
			<?php if ($this->tempFiles > 0) {
			echo $this->tempFiles.JText::_('RSF_NOT_OK_TEMP_FILES') ?>
			<span id="rsfirewall_temp_files">
			<img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/loading.gif" alt="" id="rsfirewall_temp_files_loading" style="display: none" />
			<button type="button" onclick="rsfirewall_fix_temp_files(this);"><?php echo JText::_('RSF_CLICK_FIX'); ?></button>
			</span>
			<?php } else
				echo JText::_('RSF_OK_TEMP_FILES'); ?> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&amp;task=redirect&amp;code=TEMP_FILES" target="_blank"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/readmore.png" alt="" /></a></td>
		</tr>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo $this->configurationIsOk ? 'check' : 'nocheck'; ?>24.png" alt="" /></td>
			<td><?php echo JText::_('RSF_CONFIGURATION_FILE'); ?></td>
			<td><?php echo $this->configurationIsOk ? JText::_('RSF_OK_CONFIGURATION_FILE') : JText::_('RSF_NOT_OK_CONFIGURATION_FILE'); ?> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&amp;task=redirect&amp;code=CONFIGURATION_FILE" target="_blank"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/readmore.png" alt="" /></a><br />
			<?php if (count($this->configurationErrors) > 0)
			foreach ($this->configurationErrors as $configuration_error) { ?>
			<p><b><?php echo JText::_('RSF_LINE'); ?> <?php echo $configuration_error['i']; ?>:</b> <?php echo $configuration_error['line']; ?><p>
			<?php } ?>
			</td>
		</tr>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo $this->configurationIsOutside ? 'check' : 'nocheck'; ?>24.png" alt="" /></td>
			<td><?php echo JText::_('RSF_CONFIGURATION_OUTSIDE'); ?></td>
			<td><?php echo $this->configurationIsOutside ? JText::_('RSF_OK_CONFIGURATION_OUTSIDE') : JText::_('RSF_NO_CONFIGURATION_OUTSIDE'); ?> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&amp;task=redirect&amp;code=CONFIGURATION_OUTSIDE" target="_blank"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/readmore.png" alt="" /></a></td>
		</tr>
	</table>

<!-- php checks -->

<h3>&rarr; <?php echo JText::_('RSF_PHP_CHECK'); ?></h3>
	<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="1%">&nbsp;</th>
			<th class="title" width="20%"><?php echo JText::_('RSF_ACTION'); ?></th>
			<th><?php echo JText::_('RSF_DESCRIPTION'); ?></th>
			<th><?php echo JText::_('RSF_RESULT'); ?></th>
		</tr>
	</thead>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo $this->PHPSettings->register_globals ? 'nocheck' : 'check'; ?>24.png" alt="" /></td>
			<td>register_globals</td>
			<td><?php echo JText::_('RSF_REGISTER_GLOBALS_DESC'); ?></td>
			<td><?php echo $this->PHPSettings->register_globals ? JText::_('RSF_REGISTER_GLOBALS_ON') : JText::_('RSF_REGISTER_GLOBALS_OFF'); ?></td>
		</tr>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo $this->PHPSettings->safe_mode ? 'nocheck' : 'check'; ?>24.png" alt="" /></td>
			<td>safe_mode</td>
			<td><?php echo JText::_('RSF_SAFE_MODE_DESC'); ?></td>
			<td><?php echo $this->PHPSettings->safe_mode ? JText::_('RSF_SAFE_MODE_ON') : JText::_('RSF_SAFE_MODE_OFF'); ?></td>
		</tr>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo $this->PHPSettings->allow_url_fopen ? 'nocheck' : 'check'; ?>24.png" alt="" /></td>
			<td>allow_url_fopen</td>
			<td><?php echo JText::_('RSF_ALLOW_URL_FOPEN_DESC'); ?></td>
			<td><?php echo $this->PHPSettings->allow_url_fopen ? JText::_('RSF_ALLOW_URL_FOPEN_ON') : JText::_('RSF_ALLOW_URL_FOPEN_OFF'); ?></td>
		</tr>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo $this->PHPSettings->allow_url_include ? 'nocheck' : 'check'; ?>24.png" alt="" /></td>
			<td>allow_url_include</td>
			<td><?php echo JText::_('RSF_ALLOW_URL_INCLUDE_DESC'); ?></td>
			<td><?php echo $this->PHPSettings->allow_url_include ? JText::_('RSF_ALLOW_URL_INCLUDE_ON') : JText::_('RSF_ALLOW_URL_INCLUDE_OFF'); ?></td>
		</tr>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo !$this->PHPSettings->disable_functions_check ? 'nocheck' : 'check'; ?>24.png" alt="" /></td>
			<td>disable_functions</td>
			<td><?php echo JText::_('RSF_DISABLE_FUNCTIONS_DESC'); ?></td>
			<td><?php echo $this->PHPSettings->disable_functions_check ? JText::_('RSF_DISABLE_FUNCTIONS_ON') : JText::_('RSF_DISABLE_FUNCTIONS_OFF').' '.implode(',', $this->PHPSettings->disable_functions); ?></td>
		</tr>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo !$this->PHPSettings->open_basedir ? 'nocheck' : 'check'; ?>24.png" alt="" /></td>
			<td>open_basedir</td>
			<td><?php echo JText::_('RSF_OPEN_BASEDIR_DESC'); ?></td>
			<td><?php echo empty($this->PHPSettings->open_basedir) ? JText::_('RSF_OPEN_BASEDIR_OFF') : JText::_('RSF_OPEN_BASEDIR_ON').' '.$this->PHPSettings->open_basedir; ?></td>
		</tr>
	</table>

	<?php if ($this->wrong_php) { ?>
	<div class="rsfirewall_click" id="rsfirewall_php">
	<img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/loading.gif" alt="" id="rsfirewall_php_loading" style="display: none" />
	<p><?php echo JText::_('RSF_PHP_ERROR'); ?> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&amp;task=redirect&amp;code=PHP_CONFIGURATION" target="_blank"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/readmore.png" alt="" /></a></p>
	<p class="rsfirewall_high"><?php echo JText::_('RSF_PHP_ERROR_DESC'); ?></p>
	<p><button type="button" onclick="rsfirewall_fix_php(this);"><?php echo JText::_('RSF_CLICK_FIX'); ?></button></p>
	</div>
	<?php } ?>

<!-- users check -->

<h3>&rarr; <?php echo JText::_('RSF_USERS_CHECK'); ?></h3>
	<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="1%">&nbsp;</th>
			<th><?php echo JText::_('RSF_DESCRIPTION'); ?></th>
			<th><?php echo JText::_('RSF_RESULT'); ?></th>
		</tr>
	</thead>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo $this->adminActive ? 'nocheck' : 'check'; ?>24.png" alt="" /></td>
			<td><?php echo JText::_('RSF_ADMIN_ACTIVE_DESC'); ?></td>
			<td>
			<?php if ($this->adminActive) {
			echo JText::_('RSF_ADMIN_ACTIVE_ON'); ?>
			<a href="<?php echo JRoute::_('index.php?option=com_rsfirewall&task=fix&what=admin'); ?>" target="_blank"><?php echo JText::_('RSF_CLICK_FIX'); ?></a>
			<?php } else
			echo JText::_('RSF_ADMIN_ACTIVE_OFF'); ?> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&amp;task=redirect&amp;code=ADMIN_ACTIVE" target="_blank"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/readmore.png" alt="" /></a></td>
		</tr>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo !empty($this->weakPasswords) ? 'nocheck' : 'check'; ?>24.png" alt="" /></td>
			<td><?php echo JText::_('RSF_WEAK_PASSWORDS_DESC'); ?></td>
			<td><?php if (!empty($this->weakPasswords))
			foreach ($this->weakPasswords as $pass) { ?>
			<p><b><?php echo JText::_('RSF_USERNAME'); ?>:</b> <?php echo htmlspecialchars($pass->username); ?> <b><?php echo JText::_('RSF_PASSWORD'); ?>:</b> <?php echo htmlspecialchars($pass->password); ?> <a href="<?php echo JRoute::_('index.php?option=com_rsfirewall&task=fix&what=user&username='.$pass->username); ?>" target="_blank"><?php echo JText::_('RSF_CLICK_FIX'); ?></a></p>
			<?php } else
			echo JText::_('RSF_WEAK_PASSWORDS_OK'); ?>
			<a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&amp;task=redirect&amp;code=WEAK_PASSWORDS" target="_blank"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/readmore.png" alt="" /></a>
			</td>
		</tr>
	</table>

<h3>&rarr; <?php echo JText::_('RSF_JUMI_CHECK'); ?></h3>
	<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="1%">&nbsp;</th>
			<th><?php echo JText::_('RSF_DESCRIPTION'); ?></th>
			<th><?php echo JText::_('RSF_RESULT'); ?></th>
		</tr>
	</thead>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo $this->JUMIVulnerable === true ? 'nocheck' : 'check'; ?>24.png" alt="" /></td>
			<td><?php echo JText::_('RSF_JUMI_ACTIVE_DESC'); ?></td>
			<td>
			<?php
			if ($this->JUMIVulnerable === true) echo JText::_('RSF_JUMI_VULN');
			elseif ($this->JUMIVulnerable === null) echo JText::_('RSF_JUMI_NOT_INSTALLED');
			else echo JText::_('RSF_JUMI_OK');
			?> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&amp;task=redirect&amp;code=JUMI_VULN" target="_blank"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/readmore.png" alt="" /></a>
			<?php if ($this->JUMIVulnerable) { ?>
			<div class="rsfirewall_click" id="rsfirewall_jumi">
			<img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/loading.gif" alt="" id="rsfirewall_jumi_loading" style="display: none" />
			<p><button type="button" onclick="rsfirewall_fix_jumi(this);"><?php echo JText::_('RSF_CLICK_FIX'); ?></button></p>
			</div>
			<?php } ?>
			</td>
		</tr>
	</table>

<h3>&rarr; <?php echo JText::_('RSF_JOOMLA_CONFIGURATION_CHECK'); ?></h3>
	<table class="adminlist" cellspacing="1">
	<thead>
		<tr>
			<th width="1%">&nbsp;</th>
			<th class="title" width="20%"><?php echo JText::_('RSF_ACTION'); ?></th>
			<th><?php echo JText::_('RSF_DESCRIPTION'); ?></th>
			<th><?php echo JText::_('RSF_RESULT'); ?></th>
		</tr>
	</thead>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo $this->joomlaConfiguration->sef ? 'check' : 'nocheck'; ?>24.png" alt="" /></td>
			<td><?php echo JText::_('RSF_SEF_ACTIVE'); ?></td>
			<td><?php echo JText::_('RSF_SEF_ACTIVE_DESC'); ?></td>
			<td><?php echo $this->joomlaConfiguration->sef ? JText::_('RSF_SEF_ACTIVE_ON') : JText::_('RSF_SEF_ACTIVE_OFF'); ?></td>
		</tr>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo $this->joomlaConfiguration->htaccess ? 'check' : 'nocheck'; ?>24.png" alt="" /></td>
			<td><?php echo JText::_('RSF_HTACCESS'); ?></td>
			<td><?php echo JText::_('RSF_HTACCESS_DESC'); ?></td>
			<td><?php echo $this->joomlaConfiguration->htaccess ? JText::_('RSF_HTACCESS_OK') : JText::_('RSF_HTACCESS_NOT_OK'); ?></td>
		</tr>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo $this->joomlaConfiguration->lifetime <= 15 ? 'check' : 'nocheck'; ?>24.png" alt="" /></td>
			<td><?php echo JText::_('RSF_SESSION_LIFETIME'); ?></td>
			<td><?php echo JText::_('RSF_SESSION_LIFETIME_DESC'); ?></td>
			<td><?php echo $this->joomlaConfiguration->lifetime <= 15 ? JText::sprintf('RSF_SESSION_LIFETIME_OK', $this->joomlaConfiguration->lifetime) : JText::sprintf('RSF_SESSION_LIFETIME_NOT_OK', $this->joomlaConfiguration->lifetime); ?></td>
		</tr>
		<tr>
			<td><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/<?php echo $this->joomlaConfiguration->ftp_pass ? 'check' : 'nocheck'; ?>24.png" alt="" /></td>
			<td><?php echo JText::_('RSF_FTP_PASSWORD'); ?></td>
			<td><?php echo JText::_('RSF_FTP_PASSWORD_DESC'); ?></td>
			<td><?php echo $this->joomlaConfiguration->ftp_pass ? JText::_('RSF_FTP_PASSWORD_OK') : JText::_('RSF_FTP_PASSWORD_NOT_OK'); ?></td>
		</tr>
	</table>
	
<?php if ($this->joomlaConfiguration->wrong) { ?>
	<a href="<?php echo JRoute::_('index.php?option=com_rsfirewall&task=fix&what=configuration'); ?>" target="_blank"><?php echo JText::_('RSF_CLICK_FIX_PROBLEMS'); ?></a> <a href="http://www.rsjoomla.com/index.php?option=com_rsfirewall_kb&amp;task=redirect&amp;code=JOOMLA_CONFIGURATION" target="_blank"><img src="<?php echo JURI :: root(); ?>administrator/components/com_rsfirewall/assets/images/readmore.png" alt="" /></a>
<?php } ?>