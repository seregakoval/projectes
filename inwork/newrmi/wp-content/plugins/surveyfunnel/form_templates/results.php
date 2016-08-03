<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

 <div class="panel panel-primary">
 	<div class='panel-heading'><h3>Survey Funnel Results: <?php echo $SurveyManage->survey_name; ?> - <a href="admin.php?page=survey_funnel_welcome" style="color: #FFF">Dashboard</a></h3>
 	</div>
	<div class="panel-body">
	
		
		

<?php
global $wpdb;

$select = "SELECT {$wpdb->prefix}sf_survey_questions.survey_question_id, {$wpdb->prefix}sf_survey_questions.question, {$wpdb->prefix}sf_survey_questions.answers,{$wpdb->prefix}sf_survey_questions.other_answer FROM {$wpdb->prefix}sf_survey_questions 
				WHERE {$wpdb->prefix}sf_survey_questions.survey_id = '$SurveyManage->survey_id' 
				AND {$wpdb->prefix}sf_survey_questions.active_status_id = 1 
				AND {$wpdb->prefix}sf_survey_questions.question_type = 1 
				ORDER BY {$wpdb->prefix}sf_survey_questions.priority";

//echo "$select\n<br>";
$tr = $wpdb->get_results($select);

?>
<?php  
$select1 = "SELECT user_id FROM {$wpdb->prefix}sf_survey_results , {$wpdb->prefix}sf_survey_questions
				WHERE {$wpdb->prefix}sf_survey_results.survey_id = '$SurveyManage->survey_id' 
				AND {$wpdb->prefix}sf_survey_questions.survey_question_id =  {$wpdb->prefix}sf_survey_results.survey_question_id
				AND {$wpdb->prefix}sf_survey_questions.active_status_id = '1'";

$user_ids = $this->wpdb->get_results($select1);
if($user_ids){
	foreach( $user_ids as $user_id )
		$users[] = $user_id->user_id;

	$counts = count((array_count_values($users)));
	
}else{
	$counts= 0;
}
?>
<div class="page-header"><h4>Responders  <?php echo $counts; ?></h4></div>


<ul class="nav nav-tabs" role="tablist" id="myTab">
  <li class="active"><a href="#ques" role="tab" data-toggle="tab">Question Summary</a></li>
  <li><a href="#indv" role="tab" data-toggle="tab">Individual Summary</a></li>
</ul>


<div class="tab-content">
  

<?php

$questions = array();
$answers = array();
$heights = array();

foreach ($tr as $r) {
	
	$heights[$r->survey_question_id] = count(explode("|||", $r->answers)) * 25;
	
	if(!empty($r->other_answer)){
		$r->answers .= "|||".$r->other_answer;
	}

	foreach (explode("|||", $r->answers) as $answer_name) {
		$answer_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}sf_survey_results WHERE survey_question_id = %s AND answer = %s",$r->survey_question_id,$answer_name));
		$questions[$r->survey_question_id] = $r->question;
		$answers[$r->survey_question_id][$answer_name] = $answer_count;
	}
	
	if(!empty($r->other_answer)){
		$other_answer_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}sf_survey_results WHERE survey_question_id = %s AND extra_ans = 'true'",$r->survey_question_id));
		$questions[$r->survey_question_id] = $r->question;
		$answers[$r->survey_question_id][$answer_name] = $other_answer_count;
	}
}

if (count($questions)) {	
	$questionCount = 1;
	echo '<div class="tab-pane active" id="ques">';
	foreach ($questions as $question_id => $question_name) {
		arsort($answers[$question_id]);
		
		$max_value = 0;
		$value_string = '';
		$legend_string = '';
		$totalAns_count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}sf_survey_results WHERE survey_question_id = %s",$question_id));
		

				echo '<div style="height:20px"></div>
				<div class="panel panel-info" style="width: 60%; margin: 0 auto;">
					<div class="panel-heading"><h3>Question '.$questionCount.': '.$question_name.'</h3></div>
					
					<table class="table  table-bordered table-striped table-hover" style="margin: 0 auto;" >';
		echo "<tr>
				<th>Answer Choice</th>
				<th> Responses In percent</th>
		<th> Responses Counts</th>
			 </tr>";
		
		foreach ($answers[$question_id] as $answer_name => $answer_count) {
				
			if ($answer_count > $max_value) { $max_value = $answer_count; }
			$value_string .= "$answer_count,";
			$legend_string .= urlencode("$answer_name: $answer_count") . "|";
			if($totalAns_count == 0){
				$percent = 0;
			}else{
				$percent = $answer_count/$totalAns_count*100;
				$percent = round($percent);
			}
			echo "<tr>
			<td><h4>".$answer_name."</h4></td>
			<td style='width:20%;'>"; 
			echo '<div class="progress res">
  <div class="progress-bar" role="progressbar" aria-valuenow="'.$percent.'" aria-valuemin="0" aria-valuemax="100" style="width: '.$percent.'%;">
    <span style = "color: #000;">'.$percent.'%</span>
  </div>
</div>';
			echo "<td style='width:20%;'><h4>".$answer_count."</h4></td>
			</tr>";
				
		}
		
		$value_string = substr($value_string, 0, strlen($value_string) - 1);
		$legend_string = substr($legend_string, 0, strlen($legend_string) - 1);

		
		echo "<tr>
		<th>Total</th>
		<th></th>
		<th> $totalAns_count</th>
		</tr>";
		
		echo		'</table>
				</div>';
		
		
		
		
					
		
		
		$questionCount++;
	}
}

?>
</div>
<div class="tab-pane" id="indv">
<?php 
	include 'results_individual.php';
	
?>

</div>
			</div>
		</div>
	</div>
	
	<script>
  $(function () {
    $('#indv a:last').tab('show')
    $('#ques a:last').tab('show')
  })
</script>
<!--  </table> -->