<?php
$sfThemeMode='viewAll';
if (isset($_REQUEST['sfThemeMode'])) $sfThemeMode=$_REQUEST['sfThemeMode'];

if($sfThemeMode=='viewAll'){
	
	$sfThemes = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}sf_survey_themes where type=2");
	?>
	<script type="text/javascript">
		function sfConfirmDeleteTheme(survey_id,survey_theme_id,name){
			var flag=confirm("Sure to delete '"+name+"'?");
			if(flag) window.location.href = 'admin.php?page=survey_funnel_edit&addSurveyMode=manage_themes&sfThemeMode=deleteTheme&survey_id='+survey_id+'&theme_id='+survey_theme_id;
		}
	</script>
	<div class="panel panel-primary" style="width: 50%;margin-top: 21px;">
	      <div class="panel-heading">
	        <h3 class="panel-title">Manage Custom Funnel Themes</h3>
	      </div>
	      <div class="panel-body">
	      	
	      	<table class="table table-striped" width="100%" cellpadding="3" cellspacing="1">
				<tr>
					<th>Name</th>
					<th>Actions</th>
				</tr>
				<?php foreach ($sfThemes as $sfTheme){?>
				<tr>
					<td><?php echo $sfTheme->name;?></td>
					<td>
						[<a href='admin.php?page=survey_funnel_edit&addSurveyMode=manage_themes&sfThemeMode=addNew&survey_id=<?php echo $_REQUEST['survey_id'];?>&theme_id=<?php echo $sfTheme->survey_theme_id;?>'>Edit</a>]
						[<a href="javascript:sfConfirmDeleteTheme(<?php echo $_REQUEST['survey_id'];?>,<?php echo $sfTheme->survey_theme_id;?>,'<?php echo $sfTheme->name;?>');">Delete</a>]
					</td>
				</tr>
				<?php }?>
			</table>
			<span><button class="btn btn-primary" style="padding: 2px 10px !important;" onclick="window.location.href = 'admin.php?page=survey_funnel_edit&addSurveyMode=manage_themes&sfThemeMode=addNew&survey_id=<?php echo $_REQUEST['survey_id'];?>';">+ Add New</button></span>
			<span><button class="btn btn-primary" style="padding: 2px 10px !important;" onclick="window.location.href = 'admin.php?page=survey_funnel_edit&survey_id=<?php echo $_REQUEST['survey_id'];?>';">Back to Design Survey</button></span>
	      </div>
	</div>
	
	<?php 
}
/*	
*	Code to add new Button tab in Manage Custom Theme Setting
*	Added by Kaustubh
*/
if($sfThemeMode=='addNew'){
	
	$cssValues=array();
	if(isset($_REQUEST['theme_id'])){
		$row=$wpdb->get_row('select * from '.$wpdb->prefix . 'sf_survey_themes where survey_theme_id='.$_REQUEST['theme_id']);
		$containerCSS=explode(';', htmlspecialchars_decode($row->container_css,ENT_QUOTES));
		$qustionCSS=explode(';', htmlspecialchars_decode($row->question_css,ENT_QUOTES));
		$answerCSS=explode(';', htmlspecialchars_decode($row->answer_css,ENT_QUOTES));
		$buttonCSS=explode(';', htmlspecialchars_decode($row->button_css,ENT_QUOTES));
		
		$QuestionBackground="#efebf5";
		if($row->question_use_background!='no'){
			$tempQBack=explode(':', $qustionCSS[5]);
			$QuestionBackground=$tempQBack[1];
		} 
		
		$questionBorderSize='1px';
		$questionBorderColor="#9e9898";
		if($row->question_use_border!='no'){
			$tempQBorderSize=explode(':', $qustionCSS[6]);
			$tempQBorderSize=explode(' ',$tempQBorderSize[1]);
			$questionBorderSize=$tempQBorderSize[0];
			$tempQBorderCol=explode(':', $qustionCSS[6]);
			$tempQBorderCol=explode(' ',$tempQBorderCol[1]);
			$questionBorderColor=$tempQBorderCol[2];
		}
		
		$AnswerBackground="#efebf5";
		if($row->answer_use_background!='no'){
			$tempABack=explode(':', $answerCSS[5]);
			$AnswerBackground=$tempABack[1];
		} 
		
		$answerBorderSize='1px';
		$answerBorderColor="#9e9898";
		if($row->question_use_border!='no'){
			$tempABorderSize=explode(':', $qustionCSS[6]);
			$tempABorderSize=explode(' ',$tempABorderSize[1]);
			$answerBorderSize=$tempABorderSize[0];
			$tempABorderCol=explode(':', $qustionCSS[6]);
			$tempABorderCol=explode(' ',$tempABorderCol[1]);
			$answerBorderColor=$tempABorderCol[2];
		}
		
		$ButtonBackground="#efebf5";
		if($row->button_use_background!='no'){
			$tempBBack=explode(':', $buttonCSS[9]);
			$ButtonBackground=$tempBBack[1];
		} 
		
		$buttonBorderSize='1px';
		$buttonBorderColor="#9e9898";
		if($row->button_use_border!='no'){
			
			$tempBBorderRadius=explode(':', $buttonCSS[6]);
			$tempBBorderRadius=explode(' ',$tempBBorderRadius[1]);
			$buttonBorderSize=$tempBBorderRadius[0];
			$tempBBorderCol=explode(':', $buttonCSS[5]);
			$tempBBorderCol=explode(' ',$tempBBorderCol[1]);
			$buttonBorderColor=$tempBBorderCol[2];
		}
		
		$container_background_color=explode(':', $containerCSS[0]);
		$tempContainer_border_size=explode(':', $containerCSS[1]);
		$tempContainer_border_size=explode(' ', $tempContainer_border_size[1]);
		$tempContainer_border_color=explode(':', $containerCSS[1]);
		$tempContainer_border_color=explode(' ', $tempContainer_border_color[1]);
		$container_padding=explode(':', $containerCSS[2]);
		$question_font_family=explode(':', $qustionCSS[0]);
		$question_font_size=explode(':', $qustionCSS[1]);
		$question_font_weight=explode(':', $qustionCSS[2]);
		$question_font_style=explode(':', $qustionCSS[3]);
		$question_text_color=explode(':', $qustionCSS[4]);
		$question_border_radius=explode(':', $qustionCSS[7]);
		$question_padding=explode(':', $qustionCSS[8]);
		$question_margin=explode(':', $qustionCSS[9]);
		$answer_font_family=explode(':', $answerCSS[0]);
		$answer_font_size=explode(':', $answerCSS[1]);
		$answer_font_weight=explode(':', $answerCSS[2]);
		$answer_font_style=explode(':', $answerCSS[3]);
		$answer_text_color=explode(':', $answerCSS[4]);
		$answer_border_radius=explode(':', $answerCSS[7]);
		$answer_padding=explode(':', $answerCSS[8]);
		$answer_margin=explode(':', $answerCSS[9]);

		$button_font_family=explode(':', $buttonCSS[0]);
		$button_font_size=explode(':', $buttonCSS[1]);
		$button_font_weight=explode(':', $buttonCSS[2]);
		$button_font_style=explode(':', $buttonCSS[3]);
		$button_text_color=explode(':', $buttonCSS[4]);
		$button_border_radius=explode(':', $buttonCSS[6]);
		$button_padding=explode(':', $buttonCSS[7]);
		$button_margin=explode(':', $buttonCSS[8]);

		$cssValuesTemp=array(
				"sfCustThemeName"=>$row->name,
				"container_background_color"=>$container_background_color[1],
				"container_border_size"=>$tempContainer_border_size[0],
				"container_border_color"=>$tempContainer_border_color[2],
				"container_padding"=>$container_padding[1],
				"question_font_family"=>$question_font_family[1],
				"question_font_size"=>$question_font_size[1],
				"question_font_weight"=>$question_font_weight[1],
				"question_font_style"=>$question_font_style[1],
				"question_text_color"=>$question_text_color[1],
				"question_use_background"=>$row->question_use_background,
				"question_back_color"=>$QuestionBackground,
				"question_use_border"=>$row->question_use_border,
				"question_border_size"=>$questionBorderSize,
				"question_border_radius"=>$question_border_radius[1],
				"question_border_color"=>$questionBorderColor,
				"question_padding"=>$question_padding[1],
				"question_margin"=>$question_margin[1],
				"answer_font_family"=>$answer_font_family[1],
				"answer_font_size"=>$answer_font_size[1],
				"answer_font_weight"=>$answer_font_weight[1],
				"answer_font_style"=>$answer_font_style[1],
				"answer_text_color"=>$answer_text_color[1],
				"answer_use_background"=>$row->answer_use_background,
				"answer_back_color"=>$AnswerBackground,
				"answer_use_border"=>$row->answer_use_border,
				"answer_border_size"=>$answerBorderSize,
				"answer_border_radius"=>$answer_border_radius[1],
				"answer_border_color"=>$answerBorderColor,
				"answer_padding"=>$answer_padding[1],
				"answer_margin"=>$answer_margin[1],
				"button_font_family"=>$button_font_family[1],
				"button_font_size"=>$button_font_size[1],
				"button_font_weight"=>$button_font_weight[1],
				"button_font_style"=>$button_font_style[1],
				"button_text_color"=>$button_text_color[1],
				"button_use_background"=>$row->button_use_background,
				"button_back_color"=>$ButtonBackground,
				"button_use_border"=>$row->button_use_border,
				"button_border_size"=>$buttonBorderSize,
				"button_border_radius"=>$button_border_radius[1],
				"button_border_color"=>$buttonBorderColor,
				"button_padding"=>$button_padding[1],
				"button_margin"=>$button_margin[1]
		);
		$cssValues=$cssValuesTemp;
	}
	else{
		$cssValuesTemp=array(
				"sfCustThemeName"=>"",
				"container_background_color"=>"#fcfcfc",
				"container_border_size"=>"1px",
				"container_border_color"=>"#080808",
				"container_padding"=>"10px",
				"question_font_family"=>"Lato,sans-serif",
				"question_font_size"=>"15px",
				"question_font_weight"=>"lighter",
				"question_font_style"=>"normal",
				"question_text_color"=>"#000000",
				"question_use_background"=>"no",
				"question_back_color"=>"#efebf5",
				"question_use_border"=>"no",
				"question_border_size"=>"1px",
				"question_border_radius"=>"5px",
				"question_border_color"=>"#9e9898",
				"question_padding"=>"4px",
				"question_margin"=>"0px",
				"answer_font_family"=>"Helvetica",
				"answer_font_size"=>"15px",
				"answer_font_weight"=>"normal",
				"answer_font_style"=>"italic",
				"answer_text_color"=>"#0a0a0a",
				"answer_use_background"=>"no",
				"answer_back_color"=>"#efebf5",
				"answer_use_border"=>"no",
				"answer_border_size"=>"1px",
				"answer_border_radius"=>"4px",
				"answer_border_color"=>"#9e9898",
				"answer_padding"=>"4px",
				"answer_margin"=>"6px",
				"button_font_family"=>"Helvetica",
				"button_font_size"=>"15px",
				"button_font_weight"=>"normal",
				"button_font_style"=>"italic",
				"button_text_color"=>"#0a0a0a",
				"button_use_background"=>"no",
				"button_back_color"=>"#efebf5",
				"button_use_border"=>"no",
				"button_border_size"=>"1px",
				"button_border_radius"=>"4px",
				"button_border_color"=>"#9e9898",
				"button_padding"=>"4px",
				"button_margin"=>"6px"
		);
		$cssValues=$cssValuesTemp;
	}
	?>
	<div class="panel panel-primary" style="width: 99%;margin-top: 21px;">
	      <div class="panel-heading">
	        <h3 class="panel-title"><?php echo isset($_REQUEST['theme_id'])?'Edit':'Add New';?> Theme</h3>
	      </div>
	      <div class="panel-body">
	      	<table width="100%;"><tr>
	      		<td width="50%" style="border-right: 1px solid #000000;padding: 10px;vertical-align: top;">
	      			Name: <input type="text" id="sfCustThemeName" placeholder="Enter Theme Name" value="<?php echo $cssValues['sfCustThemeName'];?>" data-placement="right" title="Please Enter Theme Name"><br/><br/>
	      			<!-- Nav tabs -->
					<ul class="nav nav-tabs">
					  <li class="active"><a href="#sfCustContainer" data-toggle="tab">Funnel Container</a></li>
					  <li><a href="#sfCustQuestion" data-toggle="tab">Question</a></li>
					  <li><a href="#sfCustAnswer" data-toggle="tab">Answers</a></li>
					  <li><a href="#sfCustButton" data-toggle="tab">Button</a></li>
					</ul>
					
					<!-- Tab panes -->
					<div class="tab-content">
					  <div class="tab-pane active" id="sfCustContainer">
					  	<table width="100%"><tr>
					  	<td style="width: 25%;vertical-align: top;">
					  		<h5>Select Property</h5>
					  		<select size="3" onchange="changeContainerProperty(this);">
					  			<option value="background" selected="selected">Background</option>
					  			<option value="border">Border</option>
					  			<option value="padding">Padding</option>
					  		</select>
					  	</td>
					  	<td style="width: 75%;">
					  		<fieldset id="sfFieldContBackground">
								<legend>&nbsp;Funnel Background&nbsp; </legend>
								Background Color:<input type="text" id="container_background_color" class="colors" onblur="applyFunnelChanges();" value="<?php echo $cssValues['container_background_color'];?>"/>
							</fieldset>
							<fieldset id="sfFieldContBorder" style="display: none;">
								<legend>&nbsp;Funnel Border&nbsp; </legend>
								<table><tr>
								<td style="padding-bottom: 5px;">Border Size:</td><td style="padding-bottom: 5px;">
									<select id="container_border_size" onchange="applyFunnelChanges();">
										<option <?php echo ($cssValues['container_border_size']=='1px')?'selected="selected"':'';?> value="1px">1px</option>
										<option <?php echo ($cssValues['container_border_size']=='2px')?'selected="selected"':'';?> value="2px">2px</option>
										<option <?php echo ($cssValues['container_border_size']=='3px')?'selected="selected"':'';?> value="3px">3px</option>
										<option <?php echo ($cssValues['container_border_size']=='4px')?'selected="selected"':'';?> value="4px">4px</option>
									</select>
								</td></tr>
								<tr><td>Border Color:</td><td><input type="text" id="container_border_color" class="colors" onblur="applyFunnelChanges();" value="<?php echo $cssValues['container_border_color'];?>"/></td>
								</tr></table>
							</fieldset>
							<fieldset id="sfFieldContPadding" style="display: none;">
								<legend>&nbsp;Funnel Padding&nbsp; </legend>
								Padding:<select id="container_padding" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['container_padding']=='10px')?'selected="selected"':'';?> value="10px">10px</option>
											<option <?php echo ($cssValues['container_padding']=='11px')?'selected="selected"':'';?> value="11px">11px</option>
											<option <?php echo ($cssValues['container_padding']=='12px')?'selected="selected"':'';?> value="12px">12px</option>
											<option <?php echo ($cssValues['container_padding']=='13px')?'selected="selected"':'';?> value="13px">13px</option>
											<option <?php echo ($cssValues['container_padding']=='14px')?'selected="selected"':'';?> value="14px">14px</option>
											<option <?php echo ($cssValues['container_padding']=='15px')?'selected="selected"':'';?> value="15px">15px</option>
										</select>
							</fieldset>
					  	</td>
					  	</tr></table>
					  </div>
					  <div class="tab-pane" id="sfCustQuestion">
					  <table width="100%"><tr>
					  	<td style="width: 25%;vertical-align: top;">
					  		<h5>Select Property</h5>
					  		<select size="5" onchange="changeQuestionProperty(this);">
					  			<option value="font" selected="selected">Font & Color</option>
					  			<option value="background">Background</option>
					  			<option value="border">Border</option>
					  			<option value="padding">Padding</option>
					  			<option value="margin">Margin</option>
					  		</select>
					  	</td>
					  	<td style="width: 75%;">
					  		<fieldset id="sfFieldQueFont">
								<legend>&nbsp;Question Font & Color&nbsp; </legend>
								<table>
								<tr>
									<td style="padding-bottom: 5px;">Font-Family:</td>
									<td style="padding-bottom: 5px;">
										<select id="question_font_family" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['question_font_family']=='Arial')?'selected="selected"':'';?> value="Arial">Arial</option>
											<option <?php echo ($cssValues['question_font_family']=='Courier')?'selected="selected"':'';?> value="Courier">Courier</option>
											<option <?php echo ($cssValues['question_font_family']=='Garamond')?'selected="selected"':'';?> value="Garamond">Garamond</option>
											<option <?php echo ($cssValues['question_font_family']=='Helvetica')?'selected="selected"':'';?> value="Helvetica">Helvetica</option>
											<option <?php echo ($cssValues['question_font_family']=='Palatino')?'selected="selected"':'';?> value="Palatino">Palatino</option>
											<option <?php echo ($cssValues['question_font_family']=='Tahoma')?'selected="selected"':'';?> value="Tahoma">Tahoma</option>
											<option <?php echo ($cssValues['question_font_family']=='Verdana')?'selected="selected"':'';?> value="Verdana">Verdana</option>
											<option <?php echo ($cssValues['question_font_family']=='Comic Sans MS')?'selected="selected"':'';?> value="Comic Sans MS">Comic Sans MS</option>
											<option <?php echo ($cssValues['question_font_family']=='Lato,sans-serif')?'selected="selected"':'';?> value="Lato,sans-serif">Lato,sans-serif</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding-bottom: 5px;">Font-Size:</td>
									<td style="padding-bottom: 5px;">
										<select id="question_font_size" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['question_font_size']=='15px')?'selected="selected"':'';?> value="15px">15px</option>
											<option <?php echo ($cssValues['question_font_size']=='16px')?'selected="selected"':'';?> value="16px">16px</option>
											<option <?php echo ($cssValues['question_font_size']=='17px')?'selected="selected"':'';?> value="17px">17px</option>
											<option <?php echo ($cssValues['question_font_size']=='18px')?'selected="selected"':'';?> value="18px">18px</option>
											<option <?php echo ($cssValues['question_font_size']=='19px')?'selected="selected"':'';?> value="19px">19px</option>
											<option <?php echo ($cssValues['question_font_size']=='20px')?'selected="selected"':'';?> value="20px">20px</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding-bottom: 5px;">Font-Weight:</td>
									<td style="padding-bottom: 5px;">
										<select id="question_font_weight" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['question_font_weight']=='normal')?'selected="selected"':'';?> value="normal">Normal</option>
											<option <?php echo ($cssValues['question_font_weight']=='bold')?'selected="selected"':'';?> value="bold">Bold</option>
											<option <?php echo ($cssValues['question_font_weight']=='bolder')?'selected="selected"':'';?> value="bolder">Bolder</option>
											<option <?php echo ($cssValues['question_font_weight']=='lighter')?'selected="selected"':'';?> value="lighter">Lighter</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding-bottom: 5px;">Font-Style:</td>
									<td style="padding-bottom: 5px;">
										<select id="question_font_style" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['question_font_style']=='normal')?'selected="selected"':'';?> value="normal">Normal</option>
											<option <?php echo ($cssValues['question_font_style']=='italic')?'selected="selected"':'';?> value="italic">Italic</option>
											<option <?php echo ($cssValues['question_font_style']=='oblique')?'selected="selected"':'';?> value="oblique">Oblique</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding-bottom: 5px;">Text-Color:</td>
									<td style="padding-bottom: 5px;">
										<input type="text" id="question_text_color" onblur="applyFunnelChanges();" class="colors" value="<?php echo $cssValues['question_text_color'];?>"/>
									</td>
								</tr>
								</table>
							</fieldset>
					  		<fieldset id="sfFieldQueBackground" style="display: none;">
								<legend>&nbsp;Question Background&nbsp; </legend>
								<table>
								<tr>
									<td style="padding-bottom: 5px;">Use Background:</td>
									<td style="padding-bottom: 5px;">
										<select id="question_use_background" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['question_use_background']=='no')?'selected="selected"':'';?> value="no">No</option>
											<option <?php echo ($cssValues['question_use_background']=='yes')?'selected="selected"':'';?> value="yes">Yes</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Background-Color:</td>
									<td><input type="text" id="question_back_color" onblur="applyFunnelChanges();" class="colors" value="<?php echo $cssValues['question_back_color'];?>"/></td>
								</tr>
								</table>
							</fieldset>
							<fieldset id="sfFieldQueBorder" style="display: none;">
								<legend>&nbsp;Question Border&nbsp; </legend>
								<table>
								<tr>
									<td style="padding-bottom: 5px;">Use Border:</td>
									<td style="padding-bottom: 5px;">
										<select id="question_use_border" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['question_use_border']=='no')?'selected="selected"':'';?> value="no">No</option>
											<option <?php echo ($cssValues['question_use_border']=='yes')?'selected="selected"':'';?> value="yes">Yes</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding-bottom: 5px;">Border Size:</td>
									<td style="padding-bottom: 5px;">
										<select id="question_border_size" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['question_border_size']=='1px')?'selected="selected"':'';?> value="1px">1px</option>
											<option <?php echo ($cssValues['question_border_size']=='2px')?'selected="selected"':'';?> value="2px">2px</option>
											<option <?php echo ($cssValues['question_border_size']=='3px')?'selected="selected"':'';?> value="3px">3px</option>
											<option <?php echo ($cssValues['question_border_size']=='4px')?'selected="selected"':'';?> value="4px">4px</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding-bottom: 5px;">Border-Radius:</td>
									<td style="padding-bottom: 5px;">
										<select id="question_border_radius" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['question_border_radius']=='1px')?'selected="selected"':'';?> value="1px">1px</option>
											<option <?php echo ($cssValues['question_border_radius']=='2px')?'selected="selected"':'';?> value="2px">2px</option>
											<option <?php echo ($cssValues['question_border_radius']=='3px')?'selected="selected"':'';?> value="3px">3px</option>
											<option <?php echo ($cssValues['question_border_radius']=='4px')?'selected="selected"':'';?> value="4px">4px</option>
											<option <?php echo ($cssValues['question_border_radius']=='5px')?'selected="selected"':'';?> value="5px">5px</option>
											<option <?php echo ($cssValues['question_border_radius']=='6px')?'selected="selected"':'';?> value="6px">6px</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Border Color:</td>
									<td>
										<input type="text" id="question_border_color" onblur="applyFunnelChanges();" class="colors" value="<?php echo $cssValues['question_border_color'];?>"/>
									</td>
								</tr>
								</table>
							</fieldset>
							<fieldset id="sfFieldQuePadding" style="display: none;">
								<legend>&nbsp;Question Padding&nbsp; </legend>
								Padding:<select id="question_padding" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['question_padding']=='0px')?'selected="selected"':'';?> value="0px">0px</option>
											<option <?php echo ($cssValues['question_padding']=='2px')?'selected="selected"':'';?> value="2px">2px</option>
											<option <?php echo ($cssValues['question_padding']=='4px')?'selected="selected"':'';?> value="4px">4px</option>
											<option <?php echo ($cssValues['question_padding']=='6px')?'selected="selected"':'';?> value="6px">6px</option>
											<option <?php echo ($cssValues['question_padding']=='8px')?'selected="selected"':'';?> value="8px">8px</option>
											<option <?php echo ($cssValues['question_padding']=='10px')?'selected="selected"':'';?> value="10px">10px</option>
										</select>
							</fieldset>
							<fieldset id="sfFieldQueMargin" style="display: none;">
								<legend>&nbsp;Question Margin&nbsp; </legend>
								Margin:<select id="question_margin" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['question_margin']=='0px')?'selected="selected"':'';?> value="0px">0px</option>
											<option <?php echo ($cssValues['question_margin']=='2px')?'selected="selected"':'';?> value="2px">2px</option>
											<option <?php echo ($cssValues['question_margin']=='4px')?'selected="selected"':'';?> value="4px">4px</option>
											<option <?php echo ($cssValues['question_margin']=='6px')?'selected="selected"':'';?> value="6px">6px</option>
											<option <?php echo ($cssValues['question_margin']=='8px')?'selected="selected"':'';?> value="8px">8px</option>
											<option <?php echo ($cssValues['question_margin']=='10px')?'selected="selected"':'';?> value="10px">10px</option>
										</select>
							</fieldset>
					  	</td>
					  	</tr></table>
					  </div>
					  <div class="tab-pane" id="sfCustAnswer">
					  <table width="100%"><tr>
					  	<td style="width: 25%;vertical-align: top;">
					  		<h5>Select Property</h5>
					  		<select size="5" onchange="changeAnswerProperty(this);">
					  			<option value="font" selected="selected">Font & Color</option>
					  			<option value="background">Background</option>
					  			<option value="border">Border</option>
					  			<option value="padding">Padding</option>
					  			<option value="margin">Margin</option>
					  		</select>
					  	</td>
					  	<td style="width: 75%;">
					  		<fieldset id="sfFieldAnsFont">
								<legend>&nbsp;Answer Font & Color&nbsp; </legend>
								<table>
								<tr>
									<td style="padding-bottom: 5px;">Font-Family:</td>
									<td style="padding-bottom: 5px;">
										<select id="answer_font_family" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['answer_font_family']=='Arial')?'selected="selected"':'';?> value="Arial">Arial</option>
											<option <?php echo ($cssValues['answer_font_family']=='Courier')?'selected="selected"':'';?> value="Courier">Courier</option>
											<option <?php echo ($cssValues['answer_font_family']=='Garamond')?'selected="selected"':'';?> value="Garamond">Garamond</option>
											<option <?php echo ($cssValues['answer_font_family']=='Helvetica')?'selected="selected"':'';?> value="Helvetica">Helvetica</option>
											<option <?php echo ($cssValues['answer_font_family']=='Palatino')?'selected="selected"':'';?> value="Palatino">Palatino</option>
											<option <?php echo ($cssValues['answer_font_family']=='Tahoma')?'selected="selected"':'';?> value="Tahoma">Tahoma</option>
											<option <?php echo ($cssValues['answer_font_family']=='Verdana')?'selected="selected"':'';?> value="Verdana">Verdana</option>
											<option <?php echo ($cssValues['answer_font_family']=='Comic Sans MS')?'selected="selected"':'';?> value="Comic Sans MS">Comic Sans MS</option>
											<option <?php echo ($cssValues['answer_font_family']=='Lato,sans-serif')?'selected="selected"':'';?> value="Lato,sans-serif">Lato,sans-serif</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding-bottom: 5px;">Font-Size:</td>
									<td style="padding-bottom: 5px;">
										<select id="answer_font_size" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['answer_font_size']=='15px')?'selected="selected"':'';?> value="15px">15px</option>
											<option <?php echo ($cssValues['answer_font_size']=='16px')?'selected="selected"':'';?> value="16px">16px</option>
											<option <?php echo ($cssValues['answer_font_size']=='17px')?'selected="selected"':'';?> value="17px">17px</option>
											<option <?php echo ($cssValues['answer_font_size']=='18px')?'selected="selected"':'';?> value="18px">18px</option>
											<option <?php echo ($cssValues['answer_font_size']=='19px')?'selected="selected"':'';?> value="19px">19px</option>
											<option <?php echo ($cssValues['answer_font_size']=='20px')?'selected="selected"':'';?> value="20px">20px</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding-bottom: 5px;">Font-Weight:</td>
									<td style="padding-bottom: 5px;">
										<select id="answer_font_weight" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['answer_font_weight']=='normal')?'selected="selected"':'';?> value="normal">Normal</option>
											<option <?php echo ($cssValues['answer_font_weight']=='bold')?'selected="selected"':'';?> value="bold">Bold</option>
											<option <?php echo ($cssValues['answer_font_weight']=='bolder')?'selected="selected"':'';?> value="bolder">Bolder</option>
											<option <?php echo ($cssValues['answer_font_weight']=='lighter')?'selected="selected"':'';?> value="lighter">Lighter</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding-bottom: 5px;">Font-Style:</td>
									<td style="padding-bottom: 5px;">
										<select id="answer_font_style" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['answer_font_style']=='normal')?'selected="selected"':'';?> value="normal">Normal</option>
											<option <?php echo ($cssValues['answer_font_style']=='italic')?'selected="selected"':'';?> value="italic">Italic</option>
											<option <?php echo ($cssValues['answer_font_style']=='oblique')?'selected="selected"':'';?> value="oblique">Oblique</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding-bottom: 5px;">Text-Color:</td>
									<td style="padding-bottom: 5px;">
										<input type="text" id="answer_text_color" onblur="applyFunnelChanges();" class="colors" value="<?php echo $cssValues['answer_text_color'];?>"/>
									</td>
								</tr>
								</table>
							</fieldset>
					  		<fieldset id="sfFieldAnsBackground" style="display: none;">
								<legend>&nbsp;Answer Background&nbsp; </legend>
								<table>
								<tr>
									<td style="padding-bottom: 5px;">Use Background:</td>
									<td style="padding-bottom: 5px;">
										<select id="answer_use_background" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['answer_use_background']=='no')?'selected="selected"':'';?> value="no">No</option>
											<option <?php echo ($cssValues['answer_use_background']=='yes')?'selected="selected"':'';?> value="yes">Yes</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Background-Color:</td>
									<td><input type="text" id="answer_back_color" onblur="applyFunnelChanges();" class="colors" value="<?php echo $cssValues['answer_back_color'];?>"/></td>
								</tr>
								</table>
							</fieldset>
							<fieldset id="sfFieldAnsBorder" style="display: none;">
								<legend>&nbsp;Answer Border&nbsp; </legend>
								<table>
								<tr>
									<td style="padding-bottom: 5px;">Use Border:</td>
									<td style="padding-bottom: 5px;">
										<select id="answer_use_border" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['answer_use_border']=='no')?'selected="selected"':'';?> value="no">No</option>
											<option <?php echo ($cssValues['answer_use_border']=='yes')?'selected="selected"':'';?> value="yes">Yes</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding-bottom: 5px;">Border Size:</td>
									<td style="padding-bottom: 5px;">
										<select id="answer_border_size" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['answer_border_size']=='1px')?'selected="selected"':'';?> value="1px">1px</option>
											<option <?php echo ($cssValues['answer_border_size']=='2px')?'selected="selected"':'';?> value="2px">2px</option>
											<option <?php echo ($cssValues['answer_border_size']=='3px')?'selected="selected"':'';?> value="3px">3px</option>
											<option <?php echo ($cssValues['answer_border_size']=='4px')?'selected="selected"':'';?> value="4px">4px</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding-bottom: 5px;">Border-Radius:</td>
									<td style="padding-bottom: 5px;">
										<select id="answer_border_radius" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['answer_border_radius']=='1px')?'selected="selected"':'';?> value="1px">1px</option>
											<option <?php echo ($cssValues['answer_border_radius']=='2px')?'selected="selected"':'';?> value="2px">2px</option>
											<option <?php echo ($cssValues['answer_border_radius']=='3px')?'selected="selected"':'';?> value="3px">3px</option>
											<option <?php echo ($cssValues['answer_border_radius']=='4px')?'selected="selected"':'';?> value="4px">4px</option>
											<option <?php echo ($cssValues['answer_border_radius']=='5px')?'selected="selected"':'';?> value="5px">5px</option>
											<option <?php echo ($cssValues['answer_border_radius']=='6px')?'selected="selected"':'';?> value="6px">6px</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Border Color:</td>
									<td>
										<input type="text" id="answer_border_color" class="colors" onblur="applyFunnelChanges();" value="<?php echo $cssValues['answer_border_color'];?>"/>
									</td>
								</tr>
								</table>
							</fieldset>
							<fieldset id="sfFieldAnsPadding" style="display: none;">
								<legend>&nbsp;Answer Padding&nbsp; </legend>
								Padding:<select id="answer_padding" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['answer_padding']=='0px')?'selected="selected"':'';?> value="0px">0px</option>
											<option <?php echo ($cssValues['answer_padding']=='2px')?'selected="selected"':'';?> value="2px">2px</option>
											<option <?php echo ($cssValues['answer_padding']=='4px')?'selected="selected"':'';?> value="4px">4px</option>
											<option <?php echo ($cssValues['answer_padding']=='6px')?'selected="selected"':'';?> value="6px">6px</option>
											<option <?php echo ($cssValues['answer_padding']=='8px')?'selected="selected"':'';?> value="8px">8px</option>
											<option <?php echo ($cssValues['answer_padding']=='10px')?'selected="selected"':'';?> value="10px">10px</option>
										</select>
							</fieldset>
							<fieldset id="sfFieldAnsMargin" style="display: none;">
								<legend>&nbsp;Answer Margin&nbsp; </legend>
								Margin:<select id="answer_margin" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['answer_margin']=='0px')?'selected="selected"':'';?> value="0px">0px</option>
											<option <?php echo ($cssValues['answer_margin']=='2px')?'selected="selected"':'';?> value="2px">2px</option>
											<option <?php echo ($cssValues['answer_margin']=='4px')?'selected="selected"':'';?> value="4px">4px</option>
											<option <?php echo ($cssValues['answer_margin']=='6px')?'selected="selected"':'';?> value="6px">6px</option>
											<option <?php echo ($cssValues['answer_margin']=='8px')?'selected="selected"':'';?> value="8px">8px</option>
											<option <?php echo ($cssValues['answer_margin']=='10px')?'selected="selected"':'';?> value="10px">10px</option>
										</select>
							</fieldset>
					  	</td>
					  	</tr></table>
					  </div>
					  <div class="tab-pane" id="sfCustButton">
					  <table width="100%">
					  	<tr>
					  	<td style="width: 25%;vertical-align: top;">
					  		<h5>Select Property</h5>
					  		<select size="5" onchange="changeButtonProperty(this);">
					  			<option value="font" selected="selected">Font & Color</option>
					  			<option value="background">Background</option>
					  			<option value="border">Border</option>
					  			<option value="padding">Padding</option>
					  			<option value="margin">Margin</option>
					  		</select>
					  	</td>
					  	<td style="width: 75%;">
					  		<fieldset id="sfFieldButtonFont">
								<legend>&nbsp;Button Font & Color&nbsp; </legend>
								<table>
								<tr>
									<td style="padding-bottom: 5px;">Font-Family:</td>
									<td style="padding-bottom: 5px;">
										<select id="button_font_family" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['button_font_family']=='Arial')?'selected="selected"':'';?> value="Arial">Arial</option>
											<option <?php echo ($cssValues['button_font_family']=='Courier')?'selected="selected"':'';?> value="Courier">Courier</option>
											<option <?php echo ($cssValues['button_font_family']=='Garamond')?'selected="selected"':'';?> value="Garamond">Garamond</option>
											<option <?php echo ($cssValues['button_font_family']=='Helvetica')?'selected="selected"':'';?> value="Helvetica">Helvetica</option>
											<option <?php echo ($cssValues['button_font_family']=='Palatino')?'selected="selected"':'';?> value="Palatino">Palatino</option>
											<option <?php echo ($cssValues['button_font_family']=='Tahoma')?'selected="selected"':'';?> value="Tahoma">Tahoma</option>
											<option <?php echo ($cssValues['button_font_family']=='Verdana')?'selected="selected"':'';?> value="Verdana">Verdana</option>
											<option <?php echo ($cssValues['button_font_family']=='Comic Sans MS')?'selected="selected"':'';?> value="Comic Sans MS">Comic Sans MS</option>
											<option <?php echo ($cssValues['button_font_family']=='Lato,sans-serif')?'selected="selected"':'';?> value="Lato,sans-serif">Lato,sans-serif</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding-bottom: 5px;">Font-Size:</td>
									<td style="padding-bottom: 5px;">
										<select id="button_font_size" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['button_font_size']=='15px')?'selected="selected"':'';?> value="15px">15px</option>
											<option <?php echo ($cssValues['button_font_size']=='16px')?'selected="selected"':'';?> value="16px">16px</option>
											<option <?php echo ($cssValues['button_font_size']=='17px')?'selected="selected"':'';?> value="17px">17px</option>
											<option <?php echo ($cssValues['button_font_size']=='18px')?'selected="selected"':'';?> value="18px">18px</option>
											<option <?php echo ($cssValues['button_font_size']=='19px')?'selected="selected"':'';?> value="19px">19px</option>
											<option <?php echo ($cssValues['button_font_size']=='20px')?'selected="selected"':'';?> value="20px">20px</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding-bottom: 5px;">Font-Weight:</td>
									<td style="padding-bottom: 5px;">
										<select id="button_font_weight" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['button_font_weight']=='normal')?'selected="selected"':'';?> value="normal">Normal</option>
											<option <?php echo ($cssValues['button_font_weight']=='bold')?'selected="selected"':'';?> value="bold">Bold</option>
											<option <?php echo ($cssValues['button_font_weight']=='bolder')?'selected="selected"':'';?> value="bolder">Bolder</option>
											<option <?php echo ($cssValues['button_font_weight']=='lighter')?'selected="selected"':'';?> value="lighter">Lighter</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding-bottom: 5px;">Font-Style:</td>
									<td style="padding-bottom: 5px;">
										<select id="button_font_style" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['button_font_style']=='normal')?'selected="selected"':'';?> value="normal">Normal</option>
											<option <?php echo ($cssValues['button_font_style']=='italic')?'selected="selected"':'';?> value="italic">Italic</option>
											<option <?php echo ($cssValues['button_font_style']=='oblique')?'selected="selected"':'';?> value="oblique">Oblique</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding-bottom: 5px;">Text-Color:</td>
									<td style="padding-bottom: 5px;">
										<input type="text" id="button_text_color" onblur="applyFunnelChanges();" class="colors" value="<?php echo $cssValues['answer_text_color'];?>"/>
									</td>
								</tr>
								</table>
							</fieldset>
					  		<fieldset id="sfFieldButtonBackground" style="display: none;">
								<legend>&nbsp;Button Background&nbsp; </legend>
								<table>
								<tr>
									<td style="padding-bottom: 5px;">Use Background:</td>
									<td style="padding-bottom: 5px;">
										<select id="button_use_background" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['button_use_background']=='no')?'selected="selected"':'';?> value="no">No</option>
											<option <?php echo ($cssValues['button_use_background']=='yes')?'selected="selected"':'';?> value="yes">Yes</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Background:</td>
									<td><input type="text" id="button_back_color" onblur="applyFunnelChanges();" class="colors" value="<?php echo $cssValues['button_back_color'];?>"/></td>
								</tr>
								</table>
							</fieldset>
							<fieldset id="sfFieldButtonBorder" style="display: none;">
								<legend>&nbsp;Button Border&nbsp; </legend>
								<table>
								<tr>
									<td style="padding-bottom: 5px;">Use Border:</td>
									<td style="padding-bottom: 5px;">
										<select id="button_use_border" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['button_use_border']=='no')?'selected="selected"':'';?> value="no">No</option>
											<option <?php echo ($cssValues['button_use_border']=='yes')?'selected="selected"':'';?> value="yes">Yes</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding-bottom: 5px;">Border Size:</td>
									<td style="padding-bottom: 5px;">
										<select id="button_border_size" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['button_border_size']=='1px')?'selected="selected"':'';?> value="1px">1px</option>
											<option <?php echo ($cssValues['button_border_size']=='2px')?'selected="selected"':'';?> value="2px">2px</option>
											<option <?php echo ($cssValues['button_border_size']=='3px')?'selected="selected"':'';?> value="3px">3px</option>
											<option <?php echo ($cssValues['button_border_size']=='4px')?'selected="selected"':'';?> value="4px">4px</option>
										</select>
									</td>
								</tr>
								<tr>
									<td style="padding-bottom: 5px;">Border-Radius:</td>
									<td style="padding-bottom: 5px;">
										<select id="button_border_radius" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['button_border_radius']=='1px')?'selected="selected"':'';?> value="1px">1px</option>
											<option <?php echo ($cssValues['button_border_radius']=='2px')?'selected="selected"':'';?> value="2px">2px</option>
											<option <?php echo ($cssValues['button_border_radius']=='3px')?'selected="selected"':'';?> value="3px">3px</option>
											<option <?php echo ($cssValues['button_border_radius']=='4px')?'selected="selected"':'';?> value="4px">4px</option>
											<option <?php echo ($cssValues['button_border_radius']=='5px')?'selected="selected"':'';?> value="5px">5px</option>
											<option <?php echo ($cssValues['button_border_radius']=='6px')?'selected="selected"':'';?> value="6px">6px</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Border Color:</td>
									<td>
										<input type="text" id="button_border_color" class="colors" onblur="applyFunnelChanges();" value="<?php echo $cssValues['button_border_color'];?>"/>
									</td>
								</tr>
								</table>
							</fieldset>
							<fieldset id="sfFieldButtonPadding" style="display: none;">
								<legend>&nbsp;Button Padding&nbsp; </legend>
								Padding:<select id="button_padding" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['button_padding']=='0px')?'selected="selected"':'';?> value="0px">0px</option>
											<option <?php echo ($cssValues['button_padding']=='2px')?'selected="selected"':'';?> value="2px">2px</option>
											<option <?php echo ($cssValues['button_padding']=='4px')?'selected="selected"':'';?> value="4px">4px</option>
											<option <?php echo ($cssValues['button_padding']=='6px')?'selected="selected"':'';?> value="6px">6px</option>
											<option <?php echo ($cssValues['button_padding']=='8px')?'selected="selected"':'';?> value="8px">8px</option>
											<option <?php echo ($cssValues['button_padding']=='10px')?'selected="selected"':'';?> value="10px">10px</option>
										</select>
							</fieldset>
							<fieldset id="sfFieldButtonMargin" style="display: none;">
								<legend>&nbsp;Button Margin&nbsp; </legend>
								Margin:<select id="button_margin" onchange="applyFunnelChanges();">
											<option <?php echo ($cssValues['button_margin']=='0px')?'selected="selected"':'';?> value="0px">0px</option>
											<option <?php echo ($cssValues['button_margin']=='2px')?'selected="selected"':'';?> value="2px">2px</option>
											<option <?php echo ($cssValues['button_margin']=='4px')?'selected="selected"':'';?> value="4px">4px</option>
											<option <?php echo ($cssValues['button_margin']=='6px')?'selected="selected"':'';?> value="6px">6px</option>
											<option <?php echo ($cssValues['button_margin']=='8px')?'selected="selected"':'';?> value="8px">8px</option>
											<option <?php echo ($cssValues['button_margin']=='10px')?'selected="selected"':'';?> value="10px">10px</option>
										</select>
							</fieldset>
					  	</td>
					  	</tr>
					  </table>
					  </div>
					</div>
						      			
	      		</td>
	      		<td width="50%">
	      			<script type="text/javascript">
	      			jQuery(document).ready(function() {
      					jQuery('.sfCheckmark').css('background','url("<?php echo WP_PLUGIN_URL_SLLSAFE;?>/images/checkmark.png") repeat scroll 0px 0 rgba(0, 0, 0, 0)');
      					var funnelMargin=(jQuery('#sfDemoFunnelContainer').parent().width()-jQuery('#sfDemoFunnelContainer').width())/2;
      					jQuery('#sfDemoFunnelContainer').css("margin-left",funnelMargin);
      					jQuery('label').css("font-weight","normal");
						jQuery(".colors").miniColors({
      						change: function(hex, rgb) {
      							
      						}
      					});
						applyFunnelChanges();
	      			});
	      			function checkSFCheckmark(obj){ 
						jQuery('.sfCheckmark').css('background','url("<?php echo WP_PLUGIN_URL_SLLSAFE;?>/images/checkmark.png") repeat scroll 0px 0 rgba(0, 0, 0, 0)');
		      			jQuery(obj).css('background','url("<?php echo WP_PLUGIN_URL_SLLSAFE;?>/images/checkmark.png") repeat scroll -20px 0 rgba(0, 0, 0, 0)'); 
		      		}
		      		function changeContainerProperty(obj){
						switch(jQuery(obj).val()){
							case 'background':
								jQuery('#sfFieldContBorder,#sfFieldContPadding').hide();
								jQuery('#sfFieldContBackground').show();
								break;
							case 'border':
								jQuery('#sfFieldContBackground,#sfFieldContPadding').hide();
								jQuery('#sfFieldContBorder').show();
								break;
							case 'padding':
								jQuery('#sfFieldContBackground,#sfFieldContBorder').hide();
								jQuery('#sfFieldContPadding').show();
								break;
						}
			      	}
			      	function changeQuestionProperty(obj){
			      		switch(jQuery(obj).val()){
							case 'font':
								jQuery('#sfFieldQueBackground,#sfFieldQueBorder,#sfFieldQuePadding,#sfFieldQueMargin').hide();
								jQuery('#sfFieldQueFont').show();
								break;
							case 'background':
								jQuery('#sfFieldQueFont,#sfFieldQueBorder,#sfFieldQuePadding,#sfFieldQueMargin').hide();
								jQuery('#sfFieldQueBackground').show();
								break;
							case 'border':
								jQuery('#sfFieldQueBackground,#sfFieldQueFont,#sfFieldQuePadding,#sfFieldQueMargin').hide();
								jQuery('#sfFieldQueBorder').show();
								break;
							case 'padding':
								jQuery('#sfFieldQueBackground,#sfFieldQueBorder,#sfFieldQueFont,#sfFieldQueMargin').hide();
								jQuery('#sfFieldQuePadding').show();
								break;
							case 'margin':
								jQuery('#sfFieldQueBackground,#sfFieldQueBorder,#sfFieldQuePadding,#sfFieldQueFont').hide();
								jQuery('#sfFieldQueMargin').show();
								break;
						}
			      	}
			      	function changeAnswerProperty(obj){
			      		switch(jQuery(obj).val()){
							case 'font':
								jQuery('#sfFieldAnsBackground,#sfFieldAnsBorder,#sfFieldAnsPadding,#sfFieldAnsMargin').hide();
								jQuery('#sfFieldAnsFont').show();
								break;
							case 'background':
								jQuery('#sfFieldAnsFont,#sfFieldAnsBorder,#sfFieldAnsPadding,#sfFieldAnsMargin').hide();
								jQuery('#sfFieldAnsBackground').show();
								break;
							case 'border':
								jQuery('#sfFieldAnsBackground,#sfFieldAnsFont,#sfFieldAnsPadding,#sfFieldAnsMargin').hide();
								jQuery('#sfFieldAnsBorder').show();
								break;
							case 'padding':
								jQuery('#sfFieldAnsBackground,#sfFieldAnsBorder,#sfFieldAnsFont,#sfFieldAnsMargin').hide();
								jQuery('#sfFieldAnsPadding').show();
								break;
							case 'margin':
								jQuery('#sfFieldAnsBackground,#sfFieldAnsBorder,#sfFieldAnsPadding,#sfFieldAnsFont').hide();
								jQuery('#sfFieldAnsMargin').show();
								break;
						}
			      	}
			      	function changeButtonProperty(obj){
			      		switch(jQuery(obj).val()){
							case 'font':
								jQuery('#sfFieldButtonBackground,#sfFieldButtonBorder,#sfFieldButtonPadding,#sfFieldButtonMargin').hide();
								jQuery('#sfFieldButtonFont').show();
								break;
							case 'background':
								jQuery('#sfFieldButtonFont,#sfFieldButtonBorder,#sfFieldButtonPadding,#sfFieldButtonMargin').hide();
								jQuery('#sfFieldButtonBackground').show();
								break;
							case 'border':
								jQuery('#sfFieldButtonBackground,#sfFieldButtonFont,#sfFieldButtonPadding,#sfFieldButtonMargin').hide();
								jQuery('#sfFieldButtonBorder').show();
								break;
							case 'padding':
								jQuery('#sfFieldButtonBackground,#sfFieldButtonBorder,#sfFieldButtonFont,#sfFieldButtonMargin').hide();
								jQuery('#sfFieldButtonPadding').show();
								break;
							case 'margin':
								jQuery('#sfFieldButtonBackground,#sfFieldButtonBorder,#sfFieldButtonPadding,#sfFieldButtonFont').hide();
								jQuery('#sfFieldButtonMargin').show();
								break;
						}
			      	}
			      	function sf_submit_theme(){
			      		if(jQuery('#sfCustThemeName').val().trim()==''){
							jQuery('#sfCustThemeName').tooltip('show');
							jQuery('#sfCustThemeName').val('');
						}
						else {
							jQuery('#frm_theme_name').val(jQuery('#sfCustThemeName').val().trim());
							jQuery('#frm_custom_theme').submit();
						} 
				    }
			      	
	      			</script>
	      			
	      			<div id="sfDemoFunnelContainer" style="">
	      				<div id="sfDemoFunnelQuestion">
	      					How do you Like This Feature?
	      				</div>
	      				<div class="sfDemoFunnelAnswer" onclick="checkSFCheckmark(jQuery(this).find('img'));">
	      					<input type="radio"> 
							<label><img style="width:20px;height:20px;margin:0 3px -4px -23px;z-index:11;" src="<?php echo WP_PLUGIN_URL_SLLSAFE;?>/images/radio_style_container.png" class="sfCheckmark"><span>Very Nice</span></label>
						</div>
						<div class="sfDemoFunnelAnswer" onclick="checkSFCheckmark(jQuery(this).find('img'));">
	      					<input type="radio"> 
							<label><img style="width:20px;height:20px;margin:0 3px -4px -23px;z-index:11;" src="<?php echo WP_PLUGIN_URL_SLLSAFE;?>/images/radio_style_container.png" class="sfCheckmark"><span>Cool</span></label>
						</div>
						<div class="sfDemoFunnelAnswer" onclick="checkSFCheckmark(jQuery(this).find('img'));">
	      					<input type="radio"> 
							<label><img style="width:20px;height:20px;margin:0 3px -4px -23px;z-index:11;" src="<?php echo WP_PLUGIN_URL_SLLSAFE;?>/images/radio_style_container.png" class="sfCheckmark"><span>Average</span></label>
						</div>
						<div class="sfDemoFunnelAnswer" onclick="checkSFCheckmark(jQuery(this).find('img'));">
	      					<input type="radio"> 
							<label><img style="width:20px;height:20px;margin:0 3px -4px -23px;z-index:11;" src="<?php echo WP_PLUGIN_URL_SLLSAFE;?>/images/radio_style_container.png" class="sfCheckmark"><span>Do Not Like</span></label>
						</div>
						<div id="sfDemoFunnelButton">
	      					<input type="button" value="Done !" />
	      				</div>
	      			</div>
	      		</td>
	      	</tr></table>
	      	<form action="admin.php?page=survey_funnel_edit" id="frm_custom_theme" method="post">
	      		<input type="hidden" name="addSurveyMode" value="manage_themes"/>
	      		<input type="hidden" name="survey_id" value="<?php echo $_REQUEST['survey_id'];?>">
	      		<input type="hidden" name="theme_id" value="<?php if(isset($_REQUEST['theme_id'])) echo $_REQUEST['theme_id'];?>" />
	      		<input type="hidden" name="sfThemeMode" value="<?php echo isset($_REQUEST['theme_id'])?'updateTheme':'createNewTheme';?>">
	      		<input type="hidden" name="name" id="frm_theme_name" value=""/>
	      		<input type="hidden" name="container_css" id="frm_container_css" value=""/>
	      		<input type="hidden" name="question_css" id="frm_question_css" value=""/>
	      		<input type="hidden" name="answer_css" id="frm_answer_css" value=""/>
	      		<input type="hidden" name="question_use_background" id="frm_question_use_background" value=""/>
	      		<input type="hidden" name="question_use_border" id="frm_question_use_border" value=""/>
	      		<input type="hidden" name="answer_use_background" id="frm_answer_use_background" value=""/>
	      		<input type="hidden" name="answer_use_border" id="frm_answer_use_border" value=""/>
	      		<input type="hidden" name="button_css" id="frm_button_css" value=""/>
	      		<input type="hidden" name="button_use_background" id="frm_button_use_background" value=""/>
	      		<input type="hidden" name="button_use_border" id="frm_button_use_border" value=""/>
	      	</form>
	      	<button class="btn btn-primary" style="padding: 2px 10px !important;" onclick="sf_submit_theme();"><?php echo isset($_REQUEST['theme_id'])?'Update':'Save';?></button>
	      	<button class="btn btn-primary" onclick="window.location.href = 'admin.php?page=survey_funnel_edit&addSurveyMode=manage_themes&survey_id=<?php echo $_REQUEST['survey_id'];?>';" style="padding: 2px 10px !important;">Cancel</button>
	      </div>
	</div>
	<?php 
}

if($sfThemeMode=='createNewTheme'){
	
	$wpdb->insert($wpdb->prefix . 'sf_survey_themes',
			array(
					'name' => $_REQUEST['name'],
					'type' => 2,
					'container_css'=>htmlspecialchars($_REQUEST['container_css'],ENT_QUOTES),
					'question_css'=>htmlspecialchars($_REQUEST['question_css'],ENT_QUOTES),
					'answer_css'=>htmlspecialchars($_REQUEST['answer_css'],ENT_QUOTES),
					'button_css'=>htmlspecialchars($_REQUEST['button_css'],ENT_QUOTES),
					'question_use_background'=>$_REQUEST['question_use_background'],
					'question_use_border'=>$_REQUEST['question_use_border'],
					'button_use_background'=>$_REQUEST['button_use_background'],
					'answer_use_background'=>$_REQUEST['answer_use_background'],
					'answer_use_border'=>$_REQUEST['answer_use_border'],
					'button_use_border'=>$_REQUEST['button_use_border']
			));
	header("location:admin.php?page=survey_funnel_edit&addSurveyMode=manage_themes&survey_id=".$_REQUEST['survey_id']);
}

if($sfThemeMode=='updateTheme'){
	
	$sql = "SHOW COLUMNS FROM {$wpdb->prefix}sf_survey_themes LIKE 'button_css'";
	if(!$wpdb->get_var($sql) )
	{
		$sql_query = "Alter table {$wpdb->prefix}sf_survey_themes add (button_css text,button_use_background varchar(4),button_use_border varchar(4))";
		$wpdb->query($sql_query);
	}

	$wpdb->update($wpdb->prefix . 'sf_survey_themes',
			array(
					'name' => $_REQUEST['name'],
					'type' => 2,
					'container_css'=>htmlspecialchars($_REQUEST['container_css'],ENT_QUOTES),
					'question_css'=>htmlspecialchars($_REQUEST['question_css'],ENT_QUOTES),
					'answer_css'=>htmlspecialchars($_REQUEST['answer_css'],ENT_QUOTES),
					'button_css'=>htmlspecialchars($_REQUEST['button_css'],ENT_QUOTES),
					'question_use_background'=>$_REQUEST['question_use_background'],
					'question_use_border'=>$_REQUEST['question_use_border'],
					'answer_use_background'=>$_REQUEST['answer_use_background'],
					'button_use_background'=>$_REQUEST['button_use_background'],
					'answer_use_border'=>$_REQUEST['answer_use_border'],
					'button_use_border'=>$_REQUEST['button_use_border']
			),
			array('survey_theme_id' => $_REQUEST['theme_id']));

	header("location:admin.php?page=survey_funnel_edit&addSurveyMode=manage_themes&survey_id=".$_REQUEST['survey_id']);
}
if($sfThemeMode=='deleteTheme'){
	
	$wpdb->query('delete from '.$wpdb->prefix . 'sf_survey_themes where survey_theme_id='.$_REQUEST['theme_id']);
	header("location:admin.php?page=survey_funnel_edit&addSurveyMode=manage_themes&survey_id=".$_REQUEST['survey_id']);
}
?>