<?php
if($update_needed == true)
{

?>
<div id="message" class="updated below-h2"><p><strong>There is a new version of the <?php echo NOTIFIER_PLUGIN_NAME; ?> plugin available.</strong> <a href="<?php echo admin_url( 'admin.php?page=plugin-update-notifier');?>">Click here</a> for instructions and details.</p></div>
<?php
}

?>
<div><h3>Survey Funnel: Dashboard</h3>

<table width="99%" cellpadding="3" cellspacing="1">
	<tr>
		<td width="100%"><a class="button button-primary" href="admin.php?page=survey_funnel_add"><b>+ Add a New Funnel</b></a></td>
	</tr>
</table>

<br>

</div>
<div style="margin-top: 10px;">
<?php

global $wpdb;

$email_display = get_option('sf_email_id');
if(!$email_display){
       $email_display = '';
}
$email = isset($_POST['sf-email'])? $_POST['sf-email']:'';
if($email != '') {
	update_option('sf_email_id',$email);
	$email_display = $email;
}
$tr = $wpdb->get_results("SELECT 
								{$wpdb->prefix}sf_surveys.survey_id, 
								{$wpdb->prefix}sf_surveys.survey_name,
								{$wpdb->prefix}sf_surveys.use_shortcode, 
								{$wpdb->prefix}sf_surveys.survey_key, 
								DATE_FORMAT({$wpdb->prefix}sf_surveys.date_created,'%b %d, %Y %h:%i %p') as date_created,
								TIMESTAMPDIFF(MONTH,{$wpdb->prefix}sf_surveys.date_modified,UTC_TIMESTAMP()) as date_modified_month,
								TIMESTAMPDIFF(DAY,{$wpdb->prefix}sf_surveys.date_modified,UTC_TIMESTAMP()) as date_modified_day,
								TIMESTAMPDIFF(HOUR,{$wpdb->prefix}sf_surveys.date_modified,UTC_TIMESTAMP()) as date_modified_hour,
 								TIMESTAMPDIFF(MINUTE,{$wpdb->prefix}sf_surveys.date_modified,UTC_TIMESTAMP()) as date_modified_min,
 								TIMESTAMPDIFF(SECOND,{$wpdb->prefix}sf_surveys.date_modified,UTC_TIMESTAMP()) as date_modified_sec,
								{$wpdb->prefix}sf_survey_stats.imprints, 
								{$wpdb->prefix}sf_survey_stats.completions FROM {$wpdb->prefix}sf_surveys 
								LEFT JOIN 
								{$wpdb->prefix}sf_survey_stats 
								ON 
								({$wpdb->prefix}sf_surveys.survey_id = {$wpdb->prefix}sf_survey_stats.survey_id AND {$wpdb->prefix}sf_survey_stats.active_status_id = 1)
								WHERE {$wpdb->prefix}sf_surveys.active_status_id = 1 ORDER BY {$wpdb->prefix}sf_surveys.date_created ASC");
?>
<table class="sflist" width="99%" cellpadding="3" cellspacing="0">
<tr class="sfTblHeader">
	<th>Survey Title</th>
	<th>Analyze</th>
	<th>Export</th>
	<th>Actions</th>
	<th>Survey Shortcode</th>
	<th>Created</th>
	<th>Modified</th>
	<th>Stats
	<table width="60%" cellpadding="0" cellspacing="0">
	<tr>
		<td style="background-color: #21759B;" valign="bottom"><img src="<?php echo SF_PLUGIN_URL; ?>/images/blank.gif" width="20" height="0"></td>
		<td nowrap> &nbsp; Completed Surveys</td>
		<td>&nbsp; </td>
		<td style="background-color: #ECECEC;" valign="bottom"><img src="<?php echo SF_PLUGIN_URL; ?>/images/blank.gif" width="20" height="0"></td>
		<td nowrap> &nbsp; Survey Imprints</td>
		
		<td width="100%"></td>
	</tr>
</table>
	</th>
	
</tr>
<?php 
$count=1;
foreach ($tr as $r) {
	$rowClass='backgroundEven';
	if($count%2) $rowClass='backgroundOdd';$count++;

	if ($r->completions == '') { $r->completions = 0; }
	if ($r->imprints == '') { $r->imprints = 0; }
	$displaysc= "Not set";
	
	$max_value = $r->imprints;
	
	$modified='';
	if ($r->date_modified_hour<0)$modified='Unmodified';
	else if ($r->date_modified_month) $modified=$r->date_modified_month.' months ago';
	else if ($r->date_modified_day) $modified=$r->date_modified_day.' days ago';
	else if ($r->date_modified_hour) $modified=$r->date_modified_hour.' hours ago';
	else if ($r->date_modified_min) $modified=$r->date_modified_min.' minutes ago';
	else $modified=$r->date_modified_sec.' seconds ago';
	
	if($r->use_shortcode) {
		$displaysc = "[survey_funnel key = '$r->survey_key']";
	}
	
	echo "<tr class='$rowClass'>
				<td class='survey_funnel_stats'> <a href=\"admin.php?page=survey_funnel_edit&survey_id=$r->survey_id\"><b>$r->survey_name</b></a></td>
				<td class='survey_funnel_stats'><a href=\"admin.php?page=survey_funnel_results&survey_id=$r->survey_id\"><img src=\"".WP_PLUGIN_URL_SLLSAFE."/images/analyzeSurvey.gif\"></a></td>
				<td class='survey_funnel_stats'>
					[ <a href=\"" . SF_PLUGIN_URL . "/json.php?action=EXPORT_TO_XLS&survey_id=$r->survey_id\" target=\"_blank\">Export Summary</a> ]<br>
					[ <a href=\"" . SF_PLUGIN_URL . "/json.php?action=EXPORTXML&survey_id=$r->survey_id\" target=\"_blank\">Export Details</a> ]
				</td>
				<td class='survey_funnel_stats'>
					[ <a href=\"javascript:void(0);\" onclick=\"copySFFunnel($r->survey_id, '" . SF_PLUGIN_URL . "');\">Clone</a> ]<br/>
					[ <a href=\"javascript:void(0);\" onclick=\"deleteSFFunnel($r->survey_id, '" . SF_PLUGIN_URL . "');\">Delete</a> ]
					
				</td>";
		if($r->use_shortcode) {
			echo "<td class='survey_funnel_stats'>[survey_funnel key=$r->survey_key]</td>";
		}else {
			echo "<td class='survey_funnel_stats'>-</td>";
		}
			echo "<td class='survey_funnel_stats'>$r->date_created</td>
				<td class='survey_funnel_stats'>$modified</td>
				 <td colspan='5' class='survey_funnel_stats'> 
				<a href=\"admin.php?page=survey_funnel_results&survey_id=$r->survey_id\"><img src=\"http://chart.apis.google.com/chart?chxr=0,0,$r->imprints&chxt=x&chbh=a&chs=300x50&cht=bhs&chco=21759B,ECECEC&chds=0,$max_value,0,$max_value&chd=t:$r->completions|$r->imprints&chdl=$r->completions|$r->imprints\" border=\"0\"></a>
		  </td>
                </tr>
             <tr class='$rowClass'>
         </tr>";
	

}

if($count==1){
	?>
	  <tr class="backgroundEven">
	    <td colspan="8" style="text-align: center;">
	    	No Funnel Added.  <a href="admin.php?page=survey_funnel_add"><b>Click Here</b></a>  to add New Funnel
	    </td>
	  </tr>
	<?php 
}
?>

</table>
</div>