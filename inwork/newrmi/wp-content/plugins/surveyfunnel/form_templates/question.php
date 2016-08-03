<div id="survey_funnel_question">
	<form id="sf_question_form" onsubmit="return false;">
		<input type="hidden" name="WP_PLUGIN_URL" value="<?php echo WP_PLUGIN_URL_SLLSAFE; ?>">
		<input type="hidden" name="question_id" id="question_id" value="">
		<input type="hidden" name="question_type" id="question_type" value="1">
	
		<h3><span id="header_display"></span> a Question</h3>
	
		<table width="100%" cellpadding="3" cellspacing="1" id="question_table">
			<tr>
				<td align="right" id="question_label" nowrap>Question: &nbsp;</td>
				<td width="100%" colspan="2"><textarea name="question" id="question" rows="3" cols="55"></textarea></td>
			</tr>
			
			<tr>
				<td></td>
				<td>
					(HTML Allowed)
				</td>
			</tr>
			
			<tr>
				<td align="right" id="ans_label" nowrap>Answers: &nbsp;</td>
				<td width="100%" colspan="2"><textarea name="answers" id="answers" rows="3" cols="55"></textarea></td>
			</tr>
			
			<tr>
				<td></td>
				<td>
					(Enter each answer on a separate line.)
				</td>
			</tr>
			<tr>
				<td width="100%">
					Display Other Answer Option
				</td>
				<td style="padding-left: 10px;">
					<input id="checkbox_value" type="checkbox" checked="" />
				</td>
			</tr>

			<!-- 
				New field under answers-textarea
				Gets Displayed on JS pop-up Frame
				Added By Kaustubh
			-->
			<tr id="text-field">
				<td>Text</td>
				<td><input type="text" name="other_answer_text" id="answer_label"></td>
			</tr>
			
			<tr>
				<td style= "width:100%;">Allow Descriptive Answers</td>
				<td><input name="text_answers" id="text_answer_checkbox" type="checkbox" checked="" /></td>
			</tr>
			<tr>
				<td></td>
				<td>This will show textarea below each answer</td>
			</tr>
				
		</table>
	
		<br/>
		<div id="updateMsg2" class="updateMsg"></div>
	</form>
</div>
<div id="survey_funnel_question_default_header" style="display: none;">
	<form id="sf_default_question_header_form" onsubmit="return false;">
		<input type="hidden" name="WP_PLUGIN_URL" value="<?php echo WP_PLUGIN_URL_SLLSAFE; ?>">
		<h3><span id="header_display"></span> Question Header</h3>
		
		<table width="100%" cellpadding="3" cellspacing="1" id="question_table">
			<tr>
				<td align="right" id="question_label" nowrap>Question header: </td>
				<td width="100%" colspan="2"><textarea name="default_question_header" id="default_question_header" rows="3" cols="50" ></textarea></td>
			</tr>
			
			<tr>
				<td></td>
				<td>(HTML Allowed)</td>
			</tr>
		</table>
		
		<br/>
 		<div id="updateMsg2" class="updateMsg"></div>
 	</form>
 </div>
