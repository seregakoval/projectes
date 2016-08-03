<?php
class SurveyActivity {

	var $survey_id;
	var $survey_theme;
	var $survey_key;
	var $survey_question_id;
	var $survey_priority;
	var $question_background_color;
	var $answer;
	var $WP_PLUGIN_URL;
	var $light_box;
	var $trigger_answer;
	var $answer_index;
	var $result_answer;
	var $question_type;
	var $extra_ans;
	
	var $question_display;
	
	var $action;
	var $script_reDirect;
	var $script_updateBtn;
	
	var $start;
	var $end;

	
	/**
	 * Survey Activity Constructor Function
	 *
	 * @return SurveyActivity
	 */
	function SurveyActivity() {
		$this->action = "";
		$this->survey_priority = 0;
		$this->survey_question_id = 0;		
	}
	
	
	/**
	 * Enter description here...
	 *
	 */
	function initSurveyActivity() {
	global $wpdb;
		if( isset( $_POST['survey_key'] ) ){
			$this->survey_key = $_POST['survey_key'];
		}
		if( isset( $_REQUEST['survey_id'] ) ){
 			$this->survey_id = $_REQUEST['survey_id'];
		}	
		$r = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}sf_surveys WHERE survey_key = '$this->survey_key'");


	//added by Jack
if ( ! defined( 'WP_CONTENT_URL' ) )
	define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
	define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
if ( ! defined( 'WP_PLUGIN_URL' ) )
	define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
if ( ! defined( 'WP_PLUGIN_DIR' ) )
	define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );	




		$this->action = $_REQUEST['action'];

		switch ($this->action) {
			case 'LOAD_FUNNEL':
					$this->survey_key = $_POST['survey_key'];
					//$this->WP_PLUGIN_URL = $_POST['url'];
					$this->WP_PLUGIN_URL = WP_PLUGIN_URL_SLLSAFE;
					$this->light_box = $_POST['light_box'];
					$this->trigger_answer = $_POST['trigger_answer'];
					
					if ($this->loadFirstQuestion()) {
						// Add an impression for a lightbox start
						if ($this->light_box == 'true') {
							$Survey = new Survey();
							$Survey->addImprint($this->survey_id);
						}
					  if ($this->light_box == 'slide') {
							$Survey = new Survey();
							$Survey->addImprint($this->survey_id);
						}
						
						if (!$this->loadNextQuestion()) {
							$this->question_display .= "|||eosf";
							
							// Set the completion cookie (if necessary)
							$this->setSFCookie();
						
							// Add a completion to the stats table
							$this->addCompletion();
						}
						
						echo $this->question_display;
					}

					exit;
					break;
			
			case 'SUBMIT_ANSWER':
					$this->survey_id = $_POST['survey_id'];
					$this->survey_question_id = $_POST['survey_question_id'];
					$this->survey_priority = $_POST['survey_priority'];
					$this->survey_key = $_POST['survey_key'];
					$this->question_background_color = $_POST['color'];
					$this->answer_index = $_POST['answer_index'];
					$this->survey_theme = $_POST['survey_theme'];
					$this->answer = $_POST['answer'];
					$this->extra_ans = isset($_POST['extra_ans']) ? $_POST['extra_ans'] : '';
					//$this->WP_PLUGIN_URL = $_POST['url'];
					$this->WP_PLUGIN_URL = WP_PLUGIN_DIR;
					// Add the answer to the results table	
				
					$this->addAnswer();
					
					// Check to see if the specified answer has a rule
					$this->checkForAnswerRule();
					
					// Load the next question in the current column
					if (!$this->loadNextQuestion()) {
						$this->question_display .= "|||eosf";
						
						// Set the completion cookie (if necessary)
						$this->setSFCookie();
						
						// Add a completion to the stats table
						$this->addCompletion();
						
						do_action( 'sf_after_survey_completion', $_POST );
					}
					
					echo $this->question_display;
					
					exit;
					break;

	// BEGIN Added By Arvind On 7-AUG-2013  For Add UserInformation
	
		case 'SUBMIT_USERINFO':
					
						$this->survey_id = $_POST['survey_id'];
						$this->survey_question_id = $_POST['survey_question_id'];
					
						$this->survey_key = $_POST['survey_key'];
						$this->survey_priority = $_POST['survey_priority'];
						$this->question_background_color = isset($_POST['color'])?$_POST['color']:'';
				
						
						$this->user_name = $_POST['user_name'];
						$this->email_id = $_POST['email_id'];
						$this->WP_PLUGIN_URL = WP_PLUGIN_DIR;
							
						// Add the answer to the results table
						$this->addAnswer1();
					
						// Check to see if the specified answer has a rule
						$this->checkForAnswerRule();
					
						// Load the next question in the current column
						if (!$this->loadNextQuestion()) {
							$this->question_display .= "|||eosf";
					
							// Set the completion cookie (if necessary)
							$this->setSFCookie();
					
							// Add a completion to the stats table
							$this->addCompletion();
							do_action( 'sf_after_user_info_submission', $_POST );
						}
					
						echo $this->question_display;
						
						exit;
						break;
		
		case 'CANCELUSERINFO':
$this->survey_id = $_POST['survey_id'];
						$this->survey_question_id = $_POST['survey_question_id'];
					
						$this->survey_key = $_POST['survey_key'];
						$this->survey_priority = $_POST['survey_priority'];
						$this->question_background_color = isset($_POST['color'])?$_POST['color']:'';
				   		$this->WP_PLUGIN_URL = WP_PLUGIN_DIR;
						// Check to see if the specified answer has a rule
						$this->checkForAnswerRule();
					
						// Load the next question in the current column
						if (!$this->loadNextQuestion()) {
							$this->question_display .= "|||eosf";
					
							// Set the completion cookie (if necessary)
							$this->setSFCookie();
					
							// Add a completion to the stats table
							$this->addCompletion();
						}
					
						echo $this->question_display;
			
			           exit;
					   break;
	// End By Arvind			

					
			default:	
					break;
		}
	}
	
	
	/**
	 * Add the answer to the results table
	 *
	 */
	private function addAnswer() {
		global $wpdb;
		$ActiveStatus = new ActiveStatus();
		//---------------------Begin -Added by Dinesh on 3rd September 2013----------
		// Insert the new users id while taking survey....
		$insanswer = $wpdb->get_row("SELECT priority FROM {$wpdb->prefix}sf_survey_questions WHERE survey_id = '$this->survey_id' and survey_question_id = '$this->survey_question_id'");
		if($insanswer->priority =='1')
		{
			$wpdb->insert($wpdb->prefix . 'sf_survey_user_information',
					array(
			
							'user_name' =>'',
							'email_id'=>''
					));
		
		}
		
		// ----------End by Dinesh on 3rd September, 2013----------------   
		$date = date("Y-m-d H:i:s");
		// BEGIN Added By Arvind On 7-AUG-2013  For Add UserInformation
		$r1 = $wpdb->get_row("SELECT user_id FROM {$wpdb->prefix}sf_survey_user_information WHERE 1 ORDER BY user_id DESC LIMIT 1");
		
		$wpdb->insert($wpdb->prefix . 'sf_survey_results', 
						array(
								'survey_id' => $this->survey_id,
								'survey_question_id' => $this->survey_question_id, 
								'answer' => $this->answer,
								'extra_ans' => $this->extra_ans,
								'active_status_id' => $ActiveStatus->active_records,
								'date_created' => $date,
								'user_id'=> $r1->user_id));
		// End
	}	
	
	
// BEGIN Added By Arvind On 7-AUG-2013  For Add UserInformation

	private function addAnswer1() {
	
		global $wpdb;
		$ActiveStatus = new ActiveStatus();
	
		$r1 = $wpdb->get_row("SELECT user_id FROM {$wpdb->prefix}sf_survey_user_information WHERE 1 ORDER BY user_id DESC LIMIT 1");
	
	
		$wpdb->update(
				($wpdb->prefix).'sf_survey_user_information',
				array(
						'user_name' =>$this->user_name,
						'email_id' => $this->email_id	),
				array( 'user_id' => $r1->user_id ));
	
	}
	// END
	
	/**
	 * Check to see if the specified answer/question has a column change
	 *
	 */
	private function checkForAnswerRule() {
		global $wpdb;
		$ActiveStatus = new ActiveStatus();

		$r = $wpdb->get_row("SELECT result_answer FROM {$wpdb->prefix}sf_survey_rules WHERE survey_question_id = '$this->survey_question_id' AND answer_index = '$this->answer_index'");
		
		if (isset($r->result_answer)) {
			$this->result_answer = $r->result_answer;
		
		} else {
			$this->result_answer = 0;
		}
	}
	
	
	/**
	 * Enter description here...
	 *
	 */
	private function loadFirstQuestion() {
		if (func_num_args() > 0) {
			$this->survey_key = func_get_arg(0);
		}
		
		global $wpdb;
		$ActiveStatus = new ActiveStatus();
		
		// BEGIN Added By Arvind On 7-AUG-2013  For Add UserInformation
		
		/* $wpdb->insert($wpdb->prefix . 'sf_survey_user_information',
				array(
		
						'user_name' =>'',
						'email_id'=>''
				)); */
		
		//End
		
		$r = $wpdb->get_row("SELECT survey_id, question_background_color, answer_flows,survey_theme FROM {$wpdb->prefix}sf_surveys WHERE survey_key = '$this->survey_key' AND active_status_id = '$ActiveStatus->active_records'");
		
		if (!isset($r->survey_id)) {
			return false;
		}

		if (!isset($r->answer_flows)) {
			return false;
		}
		
		$this->survey_id = $r->survey_id;
		$this->survey_theme = $r->survey_theme;
		$this->question_background_color = $r->question_background_color;
		
		$tmpColumns = explode("|", $r->answer_flows);
		
		$this->result_answer = isset($tmpColumns[$this->trigger_answer])?$tmpColumns[$this->trigger_answer]:'';
		
		return true;
	}
	
	
	/**
	 * Load the next question in the current column
	 *
	 */
	private function loadNextQuestion() {
		global $wpdb;
		$ActiveStatus = new ActiveStatus();

		if ($this->result_answer > 0) {
			$r = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}sf_survey_questions WHERE survey_id = '$this->survey_id' AND active_status_id = '$ActiveStatus->active_records' ORDER BY priority LIMIT " . ($this->result_answer - 1) . ",1");

		} else {
			$r = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}sf_survey_questions WHERE survey_id = '$this->survey_id' AND survey_question_id <> '$this->survey_question_id' AND priority > $this->survey_priority AND active_status_id = '$ActiveStatus->active_records' ORDER BY priority LIMIT 1");
		}
		
		if (!isset($r->survey_question_id)) {
			return false;
		}
				
                $header = $wpdb->get_row("SELECT default_question_header from {$wpdb->prefix}sf_surveys where survey_id=".$this->survey_id);
                $sf_question_header=htmlspecialchars_decode($header->default_question_header, ENT_QUOTES);
                
		if ($r->question_type == 1) {
			
			$sf_question=str_ireplace("\'", "'",$r->question);
			$this->question_display='';
			if ($sf_question_header!='') {
				$this->question_display.="<div style=\"width=100%;\">".$sf_question_header."</div>";
			}
			
			$this->question_display .=  "<div style=\"font-family: $r->font; font-size: $r->font_size; color: $r->font_color;\"><div style=\"".$this->getSFQuestionThemeStyle($this->survey_theme)."\">".htmlspecialchars_decode($sf_question, ENT_QUOTES)."</div>";
			/*
+			*	Get Funnel height
+			*/
			$sfp_height = $wpdb->get_results('SELECT height FROM '.$wpdb->prefix.'sf_surveys WHERE survey_id = '.$this->survey_id );

			if( !empty($sfp_height)){
				$funnel_height = ($sfp_height[0]->height) + 50;
			}

			if ( $r->answers && $r->text_answer_allowed == 'no') {			
				$answers = explode("|||", $r->answers);
				foreach ($answers as $answer_index => $tmpAnswer) {
					$jsAnswer = str_ireplace("'", "\'", $tmpAnswer);
					$extra_answer = '';
					$this->question_display .= "<div class=\"sfQuestion\" style=\"cursor:pointer;".$this->getSFAnsThemeStyle($this->survey_theme)."\" onclick=\"checkSFCheckmark(jQuery(this));submitSFAnswer('$this->survey_key', '" . SF_PLUGIN_URL . "', $r->survey_id, $r->survey_question_id, $r->priority, '$jsAnswer', '$extra_answer', '$this->question_background_color', $answer_index, '$this->survey_theme');\"> 
													<label><img class=\"sfCheckmark\" src=\"".WP_PLUGIN_URL_SLLSAFE."/images/radio_style_container.png\" style=\"width:20px;height:20px;z-index:11;\"/><span style=\"cursor:pointer;\">$tmpAnswer</span></label>
												</div>";
				}
				/*	On FrontEnd Survey form added New Field
				*	to Extra option Answer. Get its value and pass directly
				*	to javascript variable 'new_answer'
				*	Added By Kaustubh - START
				*/
				if ($r->other_answer) {
					$this->question_display .= "<div class=\"other_answer\" style=\"cursor:pointer;".$this->getSFAnsThemeStyle($this->survey_theme)."\"> 
													<label><img class=\"sfCheckmark\" src=\"".WP_PLUGIN_URL_SLLSAFE."/images/radio_style_container.png\" style=\"width:20px;height:20px;z-index:11;\"/><span style=\"cursor:pointer;\">$r->other_answer</span></label>
												</div>";
					$this->question_display .= "<script>
												jQuery('.other_answer').find('label').one(\"click\",function(){
													jQuery('.other_answer').append('<input type=\"text\" id=\"new_answer\" rows=\"4\" cols=\"50\" />');
												jQuery('.other_answer').append('<input type=\"text\" id=\"new_answer\" style=\"margin-top: 10px;\" rows=\"4\" cols=\"50\" />');
													checkSFCheckmark(jQuery(this));
													jQuery('.other_answer').append('<input type=\"button\" id=\"other_option_submit\" style=\"".$this->getSFButtonThemeStyle($this->survey_theme)."\" value=\"Done !\" />');
													jQuery('#other_option_submit').click(function(){
														if( jQuery('#new_answer').val().length > 0){
															var new_answer = jQuery('#new_answer').val();
															var extra_answer = 'true';
															submitSFAnswer('$this->survey_key', '" . SF_PLUGIN_URL . "', $r->survey_id, $r->survey_question_id, $r->priority, new_answer, extra_answer, '$this->question_background_color', $answer_index, '$this->survey_theme');
														}
													});
												});</script>";							
				}
				/*
				*	Added By Kaustubh - END
				*/
				$this->question_display .="<script>
										   	var sfUseCheckmark=true;
										   	if(sfUseCheckmark) jQuery('.sfCheckmark').css('background','url(\"".WP_PLUGIN_URL_SLLSAFE."/images/checkmark.png\") repeat scroll 0px 0 rgba(0, 0, 0, 0)');
										    function checkSFCheckmark(obj){ 
										   			if(sfUseCheckmark) jQuery(obj).find('img').css('background','url(\"".WP_PLUGIN_URL_SLLSAFE."/images/checkmark.png\") repeat scroll -20px 0 rgba(0, 0, 0, 0)');
											}
										   </script>";
			}
		
			/*
			*	New condition to allow text answers for each question
			*/

			if($r->text_answer_allowed == 'yes'){

				$answers = explode("|||", $r->answers);
				foreach ($answers as $answer_index => $tmpAnswer) {
					$jsAnswer = str_ireplace("'", "\'", $tmpAnswer);
					$extra_answer = '';
					$this->question_display .= "<div class=\"sfQuestion\" id=\"sfp_text_answer\" style=\"cursor:pointer;".$this->getSFAnsThemeStyle($this->survey_theme)."\" onclick=\"text_answer_input(jQuery(this)); checkSFCheckmark(jQuery(this));\"> 
													<label><img class=\"sfCheckmark\" src=\"".WP_PLUGIN_URL_SLLSAFE."/images/radio_style_container.png\" style=\"width:20px;height:20px;z-index:11;\"/><span style=\"cursor:pointer; padding-left: 5px;\">$tmpAnswer</span></label>
													<input type=\"text\" id=\"text_answer\" style=\"display: none; margin-top: 10px;\" rows=\"4\" cols=\"50\" />
													<input type=\"button\" class=\"text_answer_submit\" style=\"display: none; ".$this->getSFButtonThemeStyle($this->survey_theme)."\" value=\"Submit\" />
												</div>";
				}

					/*onclick=\"checkSFCheckmark(jQuery(this));submitSFAnswer('$this->survey_key', '" . SF_PLUGIN_URL . "', $r->survey_id, $r->survey_question_id, $r->priority, '$jsAnswer', '$extra_answer', '$this->question_background_color', $answer_index, '$this->survey_theme');\"*/
					$this->question_display .= "<script>
												function text_answer_input(obj){

													jQuery('#question_".$this->survey_key."').css({
														'height' : '".$funnel_height."'
													});
													
													jQuery('#sfp_minimize').css({
														'bottom' : '".$funnel_height."px'
													});

													jQuery('.sfQuestion').removeClass('active');
													jQuery('.sfQuestion').find('#text_answer').hide();
													jQuery('.sfQuestion').find('.text_answer_submit').hide();
													jQuery('.other_answer').find('#other_option_submit').hide();
													jQuery('.other_answer').find('#new_answer').hide();
													jQuery('.sfCheckmark').css('background-position-x','0px');
													jQuery(obj).addClass('active');
													jQuery('.active').find('#text_answer').show();
													jQuery('.active').find('.text_answer_submit').show();
												}
												jQuery('.text_answer_submit').click(function(){
										
													if( jQuery('.active').find('#text_answer').val() ){
														var text_answer = jQuery('.active').find('#text_answer').val();
var jsAnswer = jQuery('.active').find('span').html();
														submitSFAnswer('$this->survey_key', '" . WP_PLUGIN_URL_SLLSAFE . "', $r->survey_id, $r->survey_question_id, $r->priority, jsAnswer, text_answer, '$this->question_background_color', $answer_index, '$this->survey_theme');
													}
												});
											</script>";
				/*	On FrontEnd Survey form added New Field
				*	to Extra option Answer. Get its value and pass directly
				*	to javascript variable 'new_answer'
				*	Added By Kaustubh - START
				*/
				if ($r->other_answer) {

					$this->question_display .= "<div class=\"other_answer\" style=\"cursor:pointer;".$this->getSFAnsThemeStyle($this->survey_theme)."\" onclick=\"other_answer_input(jQuery(this)); checkSFCheckmark(jQuery(this));\"> 
													<label><img class=\"sfCheckmark\" src=\"".WP_PLUGIN_URL_SLLSAFE."/images/radio_style_container.png\" style=\"width:20px;height:20px;z-index:11;\"/><span style=\"cursor:pointer; padding-left: 5px;\">$r->other_answer</span></label>
													<input type=\"text\" id=\"new_answer\" style=\"display: none; margin-top: 10px;\" rows=\"4\" cols=\"50\" />
													<input type=\"button\" id=\"other_option_submit\" style=\"display: none; ".$this->getSFButtonThemeStyle($this->survey_theme)."\" value=\"Submit\" />
												</div>";

					$this->question_display .= "<script>
												
												
												function other_answer_input(obj){

													jQuery('#sfp_minimize').css({
														'bottom' : '".$funnel_height."px'
													});

													jQuery('#question_".$this->survey_key."').css({
														'height' : '".$funnel_height."',
														'transition' : 'opacity 1s ease-in-out'
													});
													

													jQuery('.sfQuestion').find('#text_answer').hide();
													jQuery('.sfQuestion').find('.text_answer_submit').hide();
													jQuery('.sfQuestion').find('.sfCheckmark').css('background-position-x','0px');
													jQuery('.other_answer').removeClass('active');
												
													jQuery(obj).addClass('active');
													jQuery('.active').find('#new_answer').show();	
													jQuery('.other_answer').find('#other_option_submit').show();

												}
												jQuery('#other_option_submit').click(function(){
														if( jQuery('#new_answer').val().length > 0){
																var new_answer = jQuery('#new_answer').val();
																var extra_answer = 'true';
																submitSFAnswer('$this->survey_key', '" . WP_PLUGIN_URL_SLLSAFE . "', $r->survey_id, $r->survey_question_id, $r->priority, new_answer, extra_answer, '$this->question_background_color', $answer_index, '$this->survey_theme');
															}
												});
												</script>";							
				}
				/*
				*	Added By Kaustubh - END
				*/
				$this->question_display .="<script>
										   	var sfUseCheckmark=true;
										   	if(sfUseCheckmark) jQuery('.sfCheckmark').css('background','url(\"".WP_PLUGIN_URL_SLLSAFE."/images/checkmark.png\") repeat scroll 0px 0 rgba(0, 0, 0, 0)');
										    function checkSFCheckmark(obj){ 
										   			if(sfUseCheckmark) 
										   				{
										   					jQuery(obj).find('img').css('background','url(\"".WP_PLUGIN_URL_SLLSAFE."/images/checkmark.png\") repeat scroll -20px 0 rgba(0, 0, 0, 0)');
										   				}
											}
										   </script>";
			}

			/*
			*	End of text_answer_allowed condition 
			*/

			$this->question_display .= "</div>";

		} elseif ($r->question_type == 2) {
                    $this->question_display='';
                    if ($sf_question_header!='') {
                            $this->question_display.="<div style=\"width=100%;\">".$sf_question_header."</div>";
                    }
                    		
                    $this->question_display .= htmlspecialchars_decode(do_shortcode($r->answers), ENT_QUOTES);
		}
		
	// BEGIN Added By Arvind On 7-AUG-2013  For Add UserInformation
		
		elseif($r->question_type == 3){
		
			$this->question_display .="<div class=\"sfQuestion\" style=\"background-color: $this->question_background_color; padding: 5px; cursor: pointer; cursor: hand;\"  id=\"usercontent\">
			<form action='' method='post' id=\"frm1\"> <h2 style=\"font-size: 16pt;margin: 3px;\"> User Information </h2>
				
			<table  id=\"defaultcontent\">
			<tr>
			<td style=\"vertical-align: middle;\">Name</td><td style=\"vertical-align: middle;\"><input style=\"padding: 7px;\" type=\"text\" name=\"uname\" id=\"uname\"></td>
			</tr>
			<tr>
			<td style=\"vertical-align: middle;\">Email Id</td><td style=\"vertical-align: middle;\"><input style=\"padding: 7px;\" type=\"email\" name=\"email\" id=\"email\"></td>
			</tr>
				
			</table></form>";
			$this->question_display .= "<button style=\"padding:2px 10px;\" onclick=\"mysfUserinfo('$this->survey_key', '" . SF_PLUGIN_URL . "', $r->survey_id, $r->survey_question_id, $r->priority,'$this->question_background_color')\">Submit</button>  <button style=\"padding:2px 10px;\" onclick=\"cancelUserInfo('$this->survey_key', '" . SF_PLUGIN_URL . "', $r->survey_id, $r->survey_question_id, $r->priority,'$this->question_background_color')\">Cancel</button> </div>";
		
			do_action( 'sf_after_user_info_fields' );
		}
		
    //END
		if ($r->question_type != 1) {
			return false;
			
		} else {
			return true;
		}
	}
		
	
	/**
	 * Set the completion cookie (if necessary)
	 *
	 */
	private function setSFCookie() {
		global $wpdb;
		$r = $wpdb->get_row("SELECT survey_key, use_cookie, cookie_days FROM {$wpdb->prefix}sf_surveys WHERE survey_id = '$this->survey_id'");
			
		if ($r->use_cookie) {
			
		}
		
		setcookie($r->survey_key, 1, time() + 60 * 60 * 24 * $r->cookie_days, COOKIEPATH, COOKIE_DOMAIN, false);
	}
	
	
	/**
	 * Add a completion to the stats table
	 *
	 */
	private function addCompletion() {
                /* Begin - Arun 29-April-2013 */
		if($email = get_option('sf_email_id')){
		mail($email, 'Survey Answered','Your survey has been answered by a user at '.date('Y-m-d H:i:s').' on '.get_site_url(),'Notification@surveyfunnel.com');
	    }
/* Ended - Arun */
		global $wpdb;
		$ActiveStatus = new ActiveStatus();
		
		$date = date("Y-m-d H:i:s");
		
		$r = $wpdb->get_row("SELECT imprints, completions FROM {$wpdb->prefix}sf_survey_stats WHERE survey_id = '$this->survey_id'");

		if (!$r->imprints) {
			$wpdb->insert($wpdb->prefix . 'sf_survey_stats', 
							array(
									'survey_id' => $this->survey_id,
									'completions' => '1', 
									'active_status_id' => $ActiveStatus->active_records,
									'date_created' => $date));			
		} else {
			$tmpNum = $r->completions + 1;
			$wpdb->update($wpdb->prefix . 'sf_survey_stats', 
							array(
									'completions' => $tmpNum, 
									'date_modified' => $date
							), 
							array('survey_id' => $this->survey_id));			
		}
	}	
	
	function getSFQuestionThemeStyle($theme_id){
            global $wpdb;
            $sfTheme = $wpdb->get_row("SELECT question_css FROM {$wpdb->prefix}sf_survey_themes where survey_theme_id=".$theme_id);
            $question_css=htmlspecialchars_decode($sfTheme->question_css,ENT_QUOTES);
            return $question_css;
	}
	
	function getSFAnsThemeStyle($theme_id){
            global $wpdb;
            $sfTheme = $wpdb->get_row("SELECT answer_css FROM {$wpdb->prefix}sf_survey_themes where survey_theme_id=".$theme_id);
            $answer_css=htmlspecialchars_decode($sfTheme->answer_css,ENT_QUOTES);
            return $answer_css;
	}
	/*	
	*	Apply Funnel CSS Theme to Button
	*	Added by Kaustubh
	*/
	function getSFButtonThemeStyle($theme_id){
            global $wpdb;
            $sfTheme = $wpdb->get_row("SELECT button_css FROM {$wpdb->prefix}sf_survey_themes where survey_theme_id=".$theme_id);
            $button_css=htmlspecialchars_decode($sfTheme->button_css,ENT_QUOTES);
            return $button_css;
	}
} // End Survey Activity Class
?>
