<?php
/**
* Export file
*
* @package CSVIVirtueMart
* @subpackage Export
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: exportfile.php 1129 2010-01-14 10:33:40Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

$csvilog = JRequest::getVar('csvilog');
/* Display any messages there are */
if (!empty($csvilog->logmessage)) echo $csvilog->logmessage;
else {
   ?>
	<table class="adminlist">
		<thead>
		<tr>
			<th colspan="4" class="message"><?php echo JText::_('Results for').' '.JRequest::getVar('user_filename'); ?></th>
		</tr>
		</thead>
		<tr>
			<th class="title" width="5%">
			<?php echo JText::_('Line'); ?>
			</th>
			<th class="title">
			<?php echo JText::_('Result'); ?>
			</th>
			<th class="title">
			<?php echo JText::_('Message'); ?>
			</th>
		</tr>
		<?php
		$k = 0;
		$logresult = $csvilog->GetStats();
		$logcount = array();
		for ($i=1, $n=count( $logresult ); $i <= $n; $i++) {
			if (isset($logresult[$i])) {
				$row = $logresult[$i];
				foreach ($row['status'] as $result => $details) {
				?>
				<tr class="<?php echo 'row'. $k; ?>">
					<td align="center">
						<?php echo $i; ?>
					</td>
					<td>
						<?php echo $details['result']; ?>
					</td>
					<td width="80%">
						<?php
							$msgbox = '';
							echo '<span class="msgtitle">'.JText::_($result).' :: ';
							$rid = rand();
							echo '<a onclick="switchMenu(\''.$rid.'\');" title="'.JText::_('SHOW_HIDE').'"> '.JText::_('SHOW_HIDE').'</a></span>';
							$msgbox .= '<div id="'.$rid.'" class="debug">'.$details['message'].'</div>';
							echo $msgbox;
						?>
					</td>
				</tr>
			<?php
				}
			$k = 1 - $k;
			}
		}
		/* Get the logcount for statistics */
		$logcount = JRequest::getVar('logcount');
		?>
		</table>
		<br />
		<table class="adminlist">
		<thead>
		<tr><th colspan="<?php echo count($logcount); ?>"><?php echo JText::_('Totals'); ?></th></tr>
		</thead>
		<tr>
		<?php foreach ($logcount as $result => $count) {
			echo '<th>'.$result.': '.$count.'</th>';
		} ?>
		</tr>
		</table>
<?php } ?>