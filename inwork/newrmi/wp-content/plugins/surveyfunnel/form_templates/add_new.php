<?php
class AddNewSurvey {
	var $survey_key;
	var $survey_name;
	var $survey_id;
	var $startDate;
	var $endDate;
	
	function AddNewSurvey($addSurveyMode){
		switch ($addSurveyMode){
			case 'new': $this->showAddSurveyForm();break;
			case 'saveSurvey': $this->saveSurvey();break;
			case 'updateSurvey':$this->updateSurvey();break;
		}
	}
	
	function showAddSurveyForm(){
		global $wpdb;
		$title="Create Survey";
		$surveyTitle="";
		$sdate="";
		$edate="";
		$survey_id=0;
		$addSurveyMode="saveSurvey";
		$createBtnText="Create & Design";
		$cancelBtnHref="admin.php?page=survey_funnel_welcome";
		if(isset($_REQUEST['survey_id'])){
			$survey_id=$_REQUEST['survey_id'];
			$title="Change Survey Details";
			$r = $wpdb->get_row("SELECT startDate, endDate, survey_name FROM {$wpdb->prefix}sf_surveys WHERE survey_id = ".$_REQUEST['survey_id']);
			$surveyTitle=$r->survey_name;
			$addSurveyMode="updateSurvey";
			$sdate=$r->startDate;
			$edate=$r->endDate;
			$createBtnText="Change";
			$cancelBtnHref="admin.php?page=survey_funnel_edit&survey_id=".$survey_id;
		}
		?>
		<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('#sfFormSunmitBtn').click(function(){
				if(jQuery('#sfEnterTitle').val().trim()==''){
					jQuery('#sfEnterTitle').tooltip('show');
					jQuery('#sfEnterTitle').val('');
				}
				else {
					jQuery('#sfEnterTitle').val(jQuery('#sfEnterTitle').val().trim());
					jQuery('#sfFormTitleSubmit').submit();
				}  
			});
			jQuery('#sfFormCancelBtn').click(function(){
				window.location.href = '<?php echo $cancelBtnHref;?>' 
			});
			jQuery('#surveyStartDate').keypress(function(e){
				e.preventDefault();
			});
			jQuery('#surveyEndDate').keypress(function(e){
				e.preventDefault();
			});
		});
		</script>
			<link type="text/css" rel="stylesheet" href="<?php echo WP_PLUGIN_URL.'/surveyfunnel/css/datepicker.css'?>" />
			<style type="text/css">#ui-datepicker-div { display: none}</style>
		<div class="panel panel-primary" style="width: 99%;margin-top: 42px;">
		    <div class="panel-heading">
	        <h3 class="panel-title"><?php echo $title;?></h3>
	      </div>
	      <div class="panel-body">
	        <form action="" id="sfFormTitleSubmit" method="post" role="form">
			  <div class="form-group">
			    <label for="exampleInputEmail1">Survey Title</label>
			    <input type="text" id="sfEnterTitle" class="form-control" style="width:250px;" name="sfTitle" placeholder="Enter Survey Title" data-placement="right" title="Please Enter Survey Title" value="<?php echo $surveyTitle;?>"/>
			    <input type="hidden" name="addSurveyMode" value="<?php echo $addSurveyMode;?>"/>
			    <input type="hidden" name="survey_id" value="<?php echo $survey_id;?>"/><br><br>
			    <label for="Inputdate">Survey Dates</label><br>
	      	Start Date  <input type="text" class="textbox" name="surveyStartDate" id="surveyStartDate" title="Enter Survey Date" value="<?php if($sdate=='' || $sdate=='0000-00-00')echo ''; else echo date("d-m-Y",strtotime($sdate)); ?>" />
	      	End Date  <input type="text" class="textbox" name="surveyEndDate" id="surveyEndDate" title="Enter Survey Date" value="<?php if($edate=='' || $edate=='0000-00-00')echo ''; else echo date("d-m-Y",strtotime($edate)); ?>" /><br>
	      	<p style="font-size: 5; color: grey; padding-top: 10px; width: 47%;" >Note: Keep 'Start Date' empty if you want to start survey immediately. Keep 'End Date' empty if you want to run survey forever</p><br>
			    </div>
			</form>
			<button id="sfFormSunmitBtn" class="btn btn-default"><?php echo $createBtnText;?></button>
			<button id="sfFormCancelBtn" class="btn btn-default">Cancel</button><br><br>
	      	<!-- Date  -->
	      	</div>
	    </div>
		<?php
	}
	
	function saveSurvey(){
		global $wpdb;
		$this->survey_key=uniqid("survey_funnel_");
		$this->survey_key = substr($this->survey_key, 0 , 25);
		$this->survey_name=$_REQUEST['sfTitle'];
		$stime = !empty($_REQUEST['surveyStartDate'])?date('Y-m-d',strtotime($_REQUEST['surveyStartDate'])):NULL;
		$this->startDate = $stime;
		$etime = !empty($_REQUEST['surveyEndDate'])?date('Y-m-d',strtotime($_REQUEST['surveyEndDate'])):NULL;
		$this->endDate = $etime;
		$date = date("Y-m-d H:i:s");
		$wpdb->insert($wpdb->prefix . 'sf_surveys',
					array(
						'startDate' => $this->startDate,
						'endDate' => $this->endDate,
 						'survey_name' => $this->survey_name,
						'survey_key' => $this->survey_key,
						'active_status_id' => 1,
						'width' => 320,
						'height' => 250,
						'date_created' => $date,
						'survey_theme' => '1'));
			
		$this->survey_id = $wpdb->insert_id;
		header('location:admin.php?page=survey_funnel_edit&survey_id='.$this->survey_id);
	}
	
	function updateSurvey(){
		global $wpdb;
		$this->survey_name=$_REQUEST['sfTitle'];
		$stime = !empty($_REQUEST['surveyStartDate'])?date('Y-m-d',strtotime($_REQUEST['surveyStartDate'])):NULL;
		$this->startDate = $stime;
		$etime = !empty($_REQUEST['surveyEndDate'])?date('Y-m-d',strtotime($_REQUEST['surveyEndDate'])):NULL;
		$this->endDate = $etime;
		$survey_id=$_REQUEST['survey_id'];
		$date = date("Y-m-d H:i:s");
		$wpdb->update($wpdb->prefix . 'sf_surveys',
				array(
						'startDate' => $this ->startDate,
						'endDate' => $this->endDate,
						'survey_name' => $this->survey_name,
						'date_modified' => $date),
				array('survey_id' => $survey_id));
			
		header('location:admin.php?page=survey_funnel_edit&survey_id='.$survey_id);
	}
}


$addSurveyMode='new';
if(isset($_REQUEST['addSurveyMode'])) $addSurveyMode=$_REQUEST['addSurveyMode'];
new AddNewSurvey($addSurveyMode);
?>
