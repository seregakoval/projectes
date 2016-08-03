<?php
class DesignSurvey {
	
	function DesignSurvey($designSurveyMode){
		switch ($designSurveyMode){
			case 'viewAll': $this->showAllSettings();break;
			case 'manage_themes':$this->manageCustomTheme();break;
		}
	}
	
	function manageCustomTheme(){
		global $wpdb;
		include(dirname(__FILE__)."/manage_survey_themes.php");
	}
	
	function getSurveyThemes($SurveyManage){
		global $wpdb;
		$sfThemes = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}sf_survey_themes where type=1");
		$response='<optgroup label="Themes">';
		foreach ($sfThemes as $sfTheme){
			$selected='';
			if($SurveyManage->survey_theme == $sfTheme->survey_theme_id) $selected='selected="selected"';
			$response.='<option '.$selected.' value="'.$sfTheme->survey_theme_id.'">'.$sfTheme->name.'</option>';
		}
		$response.='</optgroup>';
		$sfThemes = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}sf_survey_themes where type=2");
		$response.='<optgroup label="Custom Themes">';
		foreach ($sfThemes as $sfTheme){
			$selected='';
			if($SurveyManage->survey_theme == $sfTheme->survey_theme_id) $selected='selected="selected"';
			$response.='<option '.$selected.' value="'.$sfTheme->survey_theme_id.'">'.$sfTheme->name.'</option>';
		}
		$response.='</optgroup>';
		return $response;
	}
	
	function getSurveyThemesCSS(){
		global $wpdb;
		$sfThemes = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}sf_survey_themes");
		$response='';
		foreach ($sfThemes as $sfTheme){
			$response.='<input type=\'hidden\' id=\'sf_container_'.$sfTheme->survey_theme_id.'\' value=\''.htmlspecialchars_decode($sfTheme->container_css,ENT_QUOTES).'\' />';
			$response.='<input type=\'hidden\' id=\'sf_que_'.$sfTheme->survey_theme_id.'\' value=\''.htmlspecialchars_decode($sfTheme->question_css,ENT_QUOTES).'\' />';
			$response.='<input type=\'hidden\' id=\'sf_ans_'.$sfTheme->survey_theme_id.'\' value=\''.htmlspecialchars_decode($sfTheme->answer_css,ENT_QUOTES).'\' />';
			$response.='<input type=\'hidden\' id=\'sf_option_text_'.$sfTheme->survey_theme_id.'\' value=\''.htmlspecialchars_decode($sfTheme->answer_css,ENT_QUOTES).'\' />';
		}
		return $response;
	}
	
	function showAllSettings(){
		global $wpdb;
		$SurveyManage = new SurveyManage();
		$SurveyManage->loadSurvey($_REQUEST['survey_id']);
		?>
		<style>
			#surveyTitle:HOVER {
				text-decoration: underline;
			}
		</style>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('#surveyTitle').hover(function(){
					jQuery(this).tooltip('show');
				});
				jQuery("#survey_funnel_theme").change(function(){applySFTheme();});
				jQuery('#survey_funnel_question_flow').show();
				applySFTheme();
				<? if ($SurveyManage->lightbox_image != '') { ?>
					jQuery('#trigger_tabs').tabs({selected: 1});
				<? } else { ?>
					jQuery('#trigger_tabs').tabs();
				<? } ?>
				
				initSFEditor();	
			});
			function applySFTheme(){
				var funnelCSS=jQuery('#sf_container_'+jQuery("#survey_funnel_theme").val()).val();
				funnelCSS+='width:'+jQuery('#sfFunnelWidth').val()+'px;height:'+jQuery('#sfFunnelHeght').val()+'px;border-radius: 10px;';
				jQuery('.sf_preview_container').attr( "style", funnelCSS );

				var QueCSS=jQuery('#sf_que_'+jQuery("#survey_funnel_theme").val()).val();
				jQuery('.sf_preview_que').attr( "style", QueCSS );

				var AnsCSS=jQuery('#sf_ans_'+jQuery("#survey_funnel_theme").val()).val();
				jQuery('.answerDisplay').attr( "style", AnsCSS );

				/*	
				*	Give funnel CSS to new answer Option	
				*	Added by Kaustubh	
				*/
				var OptionCSS=jQuery('#sf_option_text_'+jQuery("#survey_funnel_theme").val()).val();
				jQuery('.other_answer').attr( "style", AnsCSS );
			}
		</script>
                
		<div class="panel panel-primary" style="width: 99%;margin-top: 21px;">
	      <div class="panel-heading">
	        <h3 class="panel-title">Design Survey: 
	        	<a href="admin.php?page=survey_funnel_add&survey_id=<?php echo $SurveyManage->survey_id;?>" id="surveyTitle" style="font-style: italic;font-size: 14px;cursor: pointer;" data-toggle="tooltip" data-placement="top" title="Change Survey Details">
	        		<?php echo $SurveyManage->survey_name;?>
	        		<img alt="edit" style="width: 25px;height: 25px;" src="<?php echo WP_PLUGIN_URL_SLLSAFE;?>/images/survey.png">
	        	</a>
	        	<button style="float: right;margin-top: -5px;" class="btn btn-success" onclick="doFormSubmit('Saving Survey Funnel...', jQuery('#survey_frm')); submitAJAX('<?php echo plugins_url( 'json.php?action=UPDATE_FUNNEL', dirname(__FILE__) );?>', jQuery('#survey_frm').serialize());">Save Funnel >></button>
	        </h3>
	      </div>
	      <div class="panel-body">
	      	<?php echo $this->getSurveyThemesCSS(); ?>
	      	<textarea id="tempDefaultHeaderHTML" style="display: none;"><?php echo htmlspecialchars_decode($SurveyManage->default_question_header, ENT_QUOTES); ?></textarea>
	        <form id="survey_frm" method="post" onsubmit="return false;">
	        <?php $SurveyManage->loadSurveyQuestions(); ?>
	        <input type="hidden" name="survey_id" id="survey_id" value="<?php echo $SurveyManage->survey_id; ?>">
	        <input type="hidden" name="survey_name" id="survey_name" value="<?php echo $SurveyManage->survey_name; ?>">
	        
	        
	        <!-- Nav tabs -->
			<ul class="nav nav-tabs">
			  <li class="active"><a href="#sfDesignTab" data-toggle="tab">Design</a></li>
			  <li><a href="#sfDisplayTab" data-toggle="tab">Trigger Settings</a></li>
			</ul>
			<!-- Tab panes -->
			<div class="tab-content">
			  <div class="tab-pane active" id="sfDesignTab">
			  	<br/>
			  	<span class="label label-info" style="font-size:13px;">Display Settings</span><br/><br/>
			  		<input type="radio" name="show_survey" <?php echo ($SurveyManage->show_survey=='0')? 'checked="checked"':'' ?> value="0" style="margin: 0px 10px 0px 0px;"/>Show this survey to all users<br/><br/>
					<input type="radio" name="show_survey" <?php echo ($SurveyManage->show_survey=='1')? 'checked="checked"':'' ?> value="1" style="margin: 0px 10px 0px 0px;"/>Show this survey to logged in users only<br/><br/>
					<input type="radio" name="show_survey" <?php echo ($SurveyManage->show_survey=='2')? 'checked="checked"':'' ?> value="2" style="margin: 0px 10px 0px 0px;"/>Show this survey to users who are not logged in only
			  	<hr/>
			  	<span class="label label-info" style="font-size:13px;">Select Theme</span><br/><br/>
			  	<span><select name="survey_theme" id="survey_funnel_theme"><?php echo $this->getSurveyThemes($SurveyManage);?></select></span>
			  	<span><button class="btn btn-default" style="padding: 2px 10px !important;" onclick="window.location.href = 'admin.php?page=survey_funnel_edit&addSurveyMode=manage_themes&survey_id=<?php echo $_REQUEST['survey_id'];?>';">Manage Custom Themes</button></span>
			  	<hr/>
			  	<span class="label label-info" style="font-size:13px;">Funnel Size</span><br/><br/>
			  	<span>Width X Height: </span>
			  	<span><input type="text" name="width" id="sfFunnelWidth" value="<?php echo $SurveyManage->width; ?>" size="3"/></span><span> X </span><span><input type="text" name="height" id="sfFunnelHeght" value="<?php echo $SurveyManage->height; ?>" size="3"/></span>
			  	<span><button class="btn btn-default" style="padding: 2px 10px !important;" onclick="applySFTheme();">Apply</button></span>
			  	<hr/>
			  	<span class="label label-info" style="font-size:13px;">Cookie</span><br/><br/>
				<span><input type="checkbox" id="use_cookie" name="use_cookie" value="1" onchange="if (jQuery(this).attr('checked')) { jQuery('#cookie_days').attr('disabled', false); } else { jQuery('#cookie_days').attr('disabled', true); }" <?php if ($SurveyManage->use_cookie) { ?>checked<?php } ?>>&nbsp; <a href="javascript:void(0);" onclick="jQuery('#use_cookie').trigger('click');">Use Cookie</a></span><br>
				<span>Expire cookie after <input type="text" name="cookie_days" id="cookie_days" value="<?php echo $SurveyManage->cookie_days; ?>" size="5" maxlength="5" <?php if (!$SurveyManage->use_cookie) { ?>disabled<?php } ?>> days</span>
				<hr/>
				<?php do_action( 'sf_before_add_question', $SurveyManage->survey_id ); ?>
			  	<button class="btn btn-primary" onclick="addSFQuestion('<?php echo SF_PLUGIN_URL; ?>');return false;">Add a New Question</button>
			  	<button class="btn btn-primary" onclick="addDefaultQueHeader('<?php echo SF_PLUGIN_URL; ?>');return false;">Question Header</button>
			  	<button class="btn btn-primary" onclick="addSFContent('<?php echo SF_PLUGIN_URL; ?>');return false;">Add Content</button>
			  	<button class="btn btn-primary" onclick="addSFDefaultContent('<?php  echo SF_PLUGIN_URL; ?>');return false;">Add Name/Email</button><br/>
			  	<table width="99%" cellpadding="3" cellspacing="1">
					<tr>
						<td id="survey_funnel_question_flow">
							<ul class="sfFlowList" id="sfFlowList">
								<?php $SurveyManage->loadSurveyQuestionDisplay(); ?>
							</ul>
						</td>
					</tr>
				</table>
			  </div>
			  <div class="tab-pane" id="sfDisplayTab">
                              <?php $FormDisplay = new FormDisplay(); ?>
                              

			<div id="trigger_tabs">
				<ul>
					<li><a href="#page">Pages</a></li>
					<li><a href="#lightbox">Image</a></li>
					<li><a href="#shortcode">ShortCode</a></li>
				</ul>
				
				<div id="page">
					<table width="" cellpadding="3" cellspacing="1">
						<tr>
							<td align="right" id="tab_image_label" nowrap>SlideOut Image: &nbsp;</td>
							<td width="">
								<label for="tab_image">
									<input id="tab_image" type="hidden" size="35" name="tab_image" value="<?php if ($SurveyManage->tab_image != '') { echo $SurveyManage->tab_image; } else { echo SF_PLUGIN_URL .'/images/tabs/click_here.png'; }?>" onfocus="cleanFormError(this);">
									<input id="tab_image_button" class="WPMediaBtn" type="button" value="Browse...">
								</label>
							</td>
							<td><span class="description">Select the slide out image.</span></td>
						</tr>
				
						<tr id="">
							<td align="right" id="trigger_question_1_label" nowrap> <!-- Answer(s): --> &nbsp;</td> <!-- ------------- Commented by nishtha on 8th Jan/2015 for CSS look -->
							<td width="">
								<label for="trigger_question_1">
									<input id="trigger_question_1" type="hidden" size="35" name="trigger_answers[]" value="<?php echo (isset($SurveyManage->trigger_answers[0]))?$SurveyManage->trigger_answers[0]:''; ?>" onfocus="cleanFormError(this);">
										<!--	<input id="trigger_question_1_button" class="WPMediaBtn" type="button" value="Browse..."> --> <!-- Commented by nishtha on 8th Jan/2015 for CSS look -->
										&nbsp;Start Question: <select name="start_flows[]" onmousedown="updateSFFlows(this);" class="sfRuleDropDown">
										<?php for ($i = 1; $i <= $SurveyManage->start_flows[0]; $i ++) { ?>
											<option value="<?php echo $i; ?>" <?php if ($SurveyManage->start_flows[0] == $i) { ?>selected<?php } ?>><?php echo $i; ?></option>
										<?php } ?>
									</select>
									<!--  	&nbsp;[ <a href="javascript:void(0);" onclick="addSFAnswerQuestion();">Add</a> ] --> <!-- --------- Commented by nishtha on 8th Jan/2015 for CSS look -->
								</label>
							</td>
							<td><span class="description">Select the number of question to start survey.</span></td>
						</tr>
				
						<?php if (count($SurveyManage->trigger_answers)) { ?>
							<?php foreach ($SurveyManage->trigger_answers as $key => $answer) { ?>
									<?php if ($key > 0) { ?>
									<tr id="answer_trigger_<?php echo $key; ?>">
										<td align="right" nowrap>&nbsp;</td><td width="">
											<label>
												<input id="trigger_question__<?php echo ($key + 1); ?>" type="hidden" size="35" name="trigger_answers[]" value="<?php echo $SurveyManage->trigger_answers[$key]; ?>" onfocus="cleanFormError(this);">
												<input id="trigger_question__<?php echo ($key + 1); ?>_button" class="WPMediaBtn" type="button" value="Browse...">
												&nbsp;Start Question: <select name="start_flows[]" onmousedown="updateSFFlows(this);" class="sfRuleDropDown">
													<?php for ($i = 1; $i <= $SurveyManage->start_flows[$key]; $i ++) { ?>
														<option value="<?php echo $i; ?>" <?php if ($SurveyManage->start_flows[$key] == $i) { ?>selected<?php } ?>><?php echo $i; ?></option>
													<?php } ?>
												</select>
												&nbsp;[ <a href="javascript:void(0);" onclick="removeSFTriggerAnswer('trigger_<?php echo $key; ?>');">Remove</a> ]
											</label>							
										</td>
									</tr>
								<?php } ?>
							<?php } ?>
						<?php } ?>
				
						<tr id="trigger_question_row"><td></td></tr>
						<tr><td height="10"></td></tr>
				
						<tr>
							<td align="right" id="page_id_label" valign="top" nowrap>Page(s) / Post(s): &nbsp;</td>
							<td width="">
								<input type="checkbox" name="all_pages" id="all_pages" value="1" onchange="if (jQuery(this).attr('checked')) { jQuery('#post_ids').attr('disabled', true); } else { jQuery('#post_ids').attr('disabled', false); }" <?php if ($SurveyManage->all_pages) { ?>checked<?php } ?>>&nbsp; <a href="javascript:void(0);" onclick="jQuery('#all_pages').trigger('click');">All Pages / Posts</a>
								<br>
								<?php $FormDisplay->getPost('post_ids[]', $SurveyManage->post_ids, $SurveyManage->all_pages); ?>
							</td>	
							<td><span class="description">Select the pages where you want to display survey.</span></td>
						</tr>
					</table>
				</div>
				
				<div id="lightbox">
					<table width="" cellpadding="3" cellspacing="1">
						<tr>
							<td align="right" id="lightbox_image_label" nowrap>Trigger Image: &nbsp;</td>
							<td width="">
								<label for="lightbox_image">
									<input id="lightbox_image" type="hidden" size="35" name="lightbox_image" value="<?php echo $SurveyManage->lightbox_image; ?>" onfocus="cleanFormError(this);">
									<input id="lightbox_image_button" class="WPMediaBtn" type="button" value="Browse...">
								</label>
							</td>
							<td><span class="description">Select the image by clicking it survey will be open as popup.</span></td>
						</tr>
						
						<tr>
						<td colspan="2">
						<input type="checkbox" id="use_widget" name="use_widget" value="1" <?php if ($SurveyManage->use_widget) { ?>checked<?php } ?>>&nbsp; Use In A Sidebar Widget
												<br /><br />
						<a href="" id="resetTriggerImage">Reset</a>
						</td>
						</tr>
					</table>				
				</div>
	<!--    Begin Started by Dinesh on 6th June, 2013  -->
	<div id="shortcode">
				
					<table width="" cellpadding="3" cellspacing="1">
					<!--  	<tr>
							<td align="right" id="shortcode_image_label" nowrap>ShortCode Image: &nbsp;</td>
							<td width="100%">
								<label for="shortcode_image">
									<input id="shortcode_image" type="hidden" size="35" name="shortcode_image" value="<?php echo $SurveyManage->lightbox_image; ?>" onfocus="cleanFormError(this);">
									<input id="shortcode_image_button" class="WPMediaBtn" type="button" value="Browse...">
								</label>
							</td>
						</tr>-->
						
						<tr>
						<td colspan="2">
						<input type="checkbox" id="use_shortcode" name="use_shortcode" value="1" <?php if ($SurveyManage->use_shortcode) { ?>checked<?php } ?>>&nbsp; Embed in Page
												<br /><br />
						<!-- <a href="" id="resetTriggerImage">Reset</a> -->
						</td>
						</tr>
					</table>		
						
				</div>
	
		
	<!-- // End By Dinesh  --> 			

			</div>
                          </div>
			</div>
			<table width="" cellpadding="3" cellspacing="1">
				<tr>
					<td colspan="2">
						<br>
						<div id="updateMsg" class="updateMsg"></div>
						<input type="submit" class="btn btn-success" name="store_key" value="<?php _e('Save Funnel') ?>" onclick="doFormSubmit('Saving Survey Funnel...', jQuery('#survey_frm')); submitAJAX('<?php echo plugins_url( 'json.php?action=UPDATE_FUNNEL', dirname(__FILE__) );?>', jQuery('#survey_frm').serialize());">
						<?php /*
						<input type="button" value="<?php _e('Disable Funnel') ?>" onclick="">
						*/ ?>
						<input type="button" class="btn btn-success" value="<?php _e('Cancel') ?>" onclick="window.location.href='admin.php?page=survey_funnel_welcome';">
<input type=button class="btn btn-success reset-button" name="store_key" value="<?php _e('Reset') ?>" onclick="doFormSubmit('Reset Survey Funnel...', jQuery('#survey_frm')); submitAJAX('<?php echo plugins_url( 'json.php?action=RESET_FUNNEL', dirname(__FILE__) );?>', jQuery('#survey_frm').serialize());">
					</td>
				</tr>
			</table>
			</form>
	      </div>
	    </div>
		<?php
	}
}


$designSurveyMode='viewAll';
if(isset($_REQUEST['addSurveyMode'])) $designSurveyMode=$_REQUEST['addSurveyMode'];
new DesignSurvey($designSurveyMode);
?>