<?php
class Survey {
	
	var $survey_id;
	var $survey_name;
	var $survey_key;
	var $tab_image;
	var $background_color;
	var $background_image;	
	var $border_color;
	var $border_size;
	var $lightbox_image;

	var $active_status_id;
	var $date_modified;
	var $date_created;
	var $use_widget;
	var $use_shortcode;
	var $survey_theme;
	
	/**
	 * Survey Constructor Function
	 *
	 * @return Survey
	 */
	function Survey() {
		
	}
	
		/**
	 * Enter description here...
	 *
	 * @param unknown_type $iID
	 */
	function isSurveyPage($iID) {
	global $wpdb, $post;
		$ActiveStatus = new ActiveStatus();
		$tr = $wpdb->query("SELECT survey_key, use_cookie, lightbox_image FROM {$wpdb->prefix}sf_surveys WHERE ((all_pages = true OR post_ids LIKE '%$iID,%' OR category_ids LIKE '%$iID,%' OR use_widget = true) AND use_shortcode = false) AND {$wpdb->prefix}sf_surveys.active_status_id = 1 ORDER BY all_pages DESC, date_created LIMIT 1");
		
		
		
		
		$numRows = $wpdb->num_rows;
		if($numRows == 1){
			return true;
		
		}
		
		$tr = $wpdb->get_results("SELECT survey_key, use_cookie, lightbox_image FROM {$wpdb->prefix}sf_surveys WHERE lightbox_image <> '' AND {$wpdb->prefix}sf_surveys.active_status_id = 1 ORDER BY all_pages DESC, date_created");
		// LIMIT 1 - removed in 2.0.8 for multiple lightboxes
		
		$numRows = $wpdb->num_rows;
		if($numRows >= 1){
		
	$content = $post->post_content;
	
	foreach ($tr as $r) {
	if(stristr($content,$r->lightbox_image)){
	
	return true;
	
	}
			}
			
			}
		
	

	
		return false;
	}
	
	
	/*   Check is shortcode present on page    */
	
	function isShortcode($iID) {
		global $wpdb, $post;
		$content = $post->post_content;
		 
		if(stristr($content,'[survey_funnel')){
	
			return true;
	
		}
	
	
		return false;
	}
	
	
	/**
	 * Check whether particular category has survey
	 *	 
	 */
	function isSurveyCategory($iID){
		global $wpdb, $post;
		
		$ActiveStatus = new ActiveStatus();
		$tr = $wpdb->query("SELECT survey_key, use_cookie, lightbox_image FROM {$wpdb->prefix}sf_surveys WHERE ((all_pages = true OR category_ids LIKE '%$iID,%' OR use_widget = true) AND use_shortcode = false) AND {$wpdb->prefix}sf_surveys.active_status_id = 1 ORDER BY all_pages DESC, date_created LIMIT 1");
		
		// OR lightbox_image <> ''
		
		
		
		$numRows = $wpdb->num_rows;
		if($numRows == 1){
	return true;
		
		}
		
		$tr = $wpdb->get_results("SELECT survey_key, use_cookie, lightbox_image FROM {$wpdb->prefix}sf_surveys WHERE lightbox_image <> '' AND {$wpdb->prefix}sf_surveys.active_status_id = 1 ORDER BY all_pages DESC, date_created");
		
		// LIMIT 1 - removed in 2.0.8 for multiple lightboxes
		
		$numRows = $wpdb->num_rows;
		if($numRows >= 1){
		//if($numRows == 1){ changed in 2.0.8 for multiple lightboxes
	$content = $post->post_content;
	
	foreach ($tr as $r) {
	if(stristr($content,$r->lightbox_image)){
	
	return true;
	
	}
			}
			
			}
		
		return false;
	
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $iID
	 */
	function getSurveys($iID) {
		global $wpdb;
		$ActiveStatus = new ActiveStatus();
		$tr = $wpdb->get_results("SELECT post_ids,survey_key, use_cookie, lightbox_image FROM {$wpdb->prefix}sf_surveys WHERE (all_pages = true OR post_ids LIKE '%$iID,%' OR lightbox_image <> '') AND {$wpdb->prefix}sf_surveys.active_status_id = 1 ORDER BY all_pages DESC, date_created");
		
		foreach ($tr as $r) {
			$this->lightbox_image = basename($r->lightbox_image);
			
			if ($r->use_cookie) {
				if (!$_COOKIE[$r->survey_key]) {
					$this->getSurveyDisplay($r->survey_key);
				}
			
			} 
			else 
			{
				$this->getSurveyDisplay($r->survey_key);
			}
		}

	}
	


	/* Function for displaying SF on categories page */
	
	function getSurveysforCategories($icID)
	{
		
		global $wpdb;
		$ActiveStatus = new ActiveStatus();
		
		$trcat = $wpdb->get_results("SELECT category_ids,survey_key, use_cookie, lightbox_image FROM {$wpdb->prefix}sf_surveys WHERE (all_pages = true OR category_ids LIKE '%$icID,%' OR lightbox_image <> '') AND {$wpdb->prefix}sf_surveys.active_status_id = 1 ORDER BY all_pages DESC, date_created");
	
		foreach ($trcat as $rc) {
	
			$this->lightbox_image = basename($rc->lightbox_image);
			if ($rc->use_cookie) {
				if (!$_COOKIE[$rc->survey_key]) {
					$this->getCategorySurveyDisplay($rc->survey_key);
				}
					
			} else 
				{
					$this->getCategorySurveyDisplay($rc->survey_key);
				}
		}
	}
	
	/**** For category survey display ****/
	private function getCategorySurveyDisplay() {
	
		if (func_num_args() == 1) {
			$this->survey_key = func_get_arg(0);
		}
		
		if (trim($this->lightbox_image) == '') {
			$this->showFloatingDiv($this->survey_key);
				
		} else { 
			if(is_category())
			{ 
				$this->showLightBox($this->survey_key);
			}
		}
	}
	
	
	
	
	/**
	 * Enter description here...
	 *
	 */
	private function getSurveyDisplay() {
		if (func_num_args() > 0) {
			$this->survey_key = func_get_arg(0);
		}
		
		if (trim($this->lightbox_image) == '') {
			$this->showFloatingDiv($this->survey_key);
			
		} else {
			if(is_single() || is_page() || is_home())
			{ 
			$this->showLightBox($this->survey_key);
		}
		}
		
	}
	
	
	/**
	 * Enter description here...
	 *
	 */
	private function showFloatingDiv() {
		$ActiveStatus = new ActiveStatus();
		if (func_num_args() > 0) {
			$this->survey_key = func_get_arg(0);
		}
		
		global $wpdb;
		$r = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}sf_surveys WHERE survey_key = '$this->survey_key'");
		
		$this->survey_id = $r->survey_id;
		$this->border_color = $r->border_color;
		$this->survey_theme = $r->survey_theme;
		$sdate = strtotime($r->startDate);
		$edate = strtotime($r->endDate);
		$curr=strtotime(date("Y-m-d"));
		
		if (!$this->survey_id) {
			return false;
		}
		//  Add an imprint to the stats table
		//$this->addImprint();
		if($r->startDate=='0000-00-00')
		{
			$sdate = 0;
		}
		if($r->startDate=='0000-00-00')
		{
			$edate = 0;
		}
		
		$display_survey=$r->show_survey;
		if(($curr >= $sdate && $curr <= $edate) || ($sdate=='0' && $edate=='0') || ($curr >= $sdate && $edate=='0') || ($sdate=='0' && $curr <= $edate))
		{
		if($display_survey==0 || $display_survey==1 && is_user_logged_in() || $display_survey==2 && !is_user_logged_in())
		{
		echo "<style type=\"text/css\">#$this->survey_key {position: fixed; top: 30%; left: 0; z-index: 1000;}</style>";
		echo "<style type=\"text/css\">#$this->survey_key img {margin-top: -7px;}</style>";
		
		if ($r->background_image) {
			echo "<style type=\"text/css\">#question_$this->survey_key {margin-top: -7px; position: fixed; top: 40%; left: -" . $r->width . "px; z-index: 2000; display: none; padding: $r->padding" . "px; padding-right: 20px; max-width: $r->width" . "px; width:100%; height: $r->height" . "px; background: url(\"$r->background_image\") left top no-repeat; border: " . $r->border_size . "px solid $r->border_color;}@media only screen and (min-width: 220px) and (max-width: 660px){#question_$this->survey_key {width:90%;height:auto;}}</style>";
		} else {
			echo "<style type=\"text/css\">#question_$this->survey_key {margin-top: -7px; position: fixed; top: 30%; left: -" . $r->width . "px; z-index: 2000; display: none; padding: $r->padding" . "px; max-width: $r->width" . "px; width:100%; height: $r->height" . "px; background: $r->background_color; border: " . $r->border_size . "px solid $r->border_color;}@media only screen and (min-width: 220px) and (max-width: 660px){#question_$this->survey_key {width:90%;height:auto;}}</style>";
		}
		
		echo "<div id = 'staticsurvey'><div id=\"$this->survey_key\" class=\"surveyFunnelDiv\"><a href=\"javascript:void(0);\" onclick=\"prepareSFFunnel('$this->survey_key', 0, '" . WP_PLUGIN_URL_SLLSAFE . "');\"><img src=\"$r->tab_image\" border=\"0\"></a><br>";

		if ($r->answer_images) {
			foreach (explode("|", $r->answer_images) as $key => $val) {
				echo "<a href=\"javascript:void(0);\" onclick=\"prepareSFFunnel('$this->survey_key', $key, '" . WP_PLUGIN_URL_SLLSAFE . "');\"><img src=\"$val\" border=\"0\"></a><br>";
			}
		}
		
		echo "</div>";								
		echo "<div id=\"question_$this->survey_key\" class=\"surveyFunnelDiv survey_container_body\" style=\"".$this->getSFContainerThemeStyle($this->survey_theme)."\"><br><center><img src=\"" . WP_PLUGIN_URL_SLLSAFE."/images/loading.gif\"></center></div></div>";		
	}
	}

	}
	
	
	//  Start of short code
	// Begin Added by dinesh on 29th May, 2013-------------------------------
	
	function Displayshortcode($key) {
		$ActiveStatus = new ActiveStatus();
	
	
		$this->survey_key = $key;
		
		 
		global $wpdb;
		$r = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}sf_surveys WHERE survey_key = '$this->survey_key'");
	
		$this->survey_id = $r->survey_id;
		$this->border_color = $r->border_color;
		$this->survey_theme = $r->survey_theme;

	
		if (!$this->survey_id) {
				
			return false;
	}
	
		//  Add an imprint to the stats table
		$this->addImprint();
		 
		$display_survey=$r->show_survey;
		
		if($display_survey==0 || $display_survey==1 && is_user_logged_in() || $display_survey==2 && !is_user_logged_in())
		{
		echo "<style type=\"text/css\">#question_$this->survey_key {padding: $r->padding" . "px; height: $r->height" . "px; max-width: $r->width" . "px; width:100%; background: $r->background_color; border: " . $r->border_size . "px solid $r->border_color; overflow: auto;}@media only screen and (min-width: 220px) and (max-width: 660px){#question_$this->survey_key {width:90%;height:auto;}}</style>";
	
		echo "<style type=\"text/css\">#$this->survey_key img {margin-top: -7px;}</style>";
		if ($r->background_image) {
			echo "<style type=\"text/css\">#question_$this->survey_key {margin-top: -7px; z-index: 2000; padding: $r->padding" . "px; padding-right: 20px; max-width: $r->width" . "px; width:100%; height: $r->height" . "px; background: url(\"$r->background_image\") left top no-repeat; border: " . $r->border_size . "px solid $r->border_color;}@media only screen and (min-width: 220px) and (max-width: 660px){#question_$this->survey_key {width:90%;height:auto;}}</style>";
		} else {
		echo "<style type=\"text/css\">#question_$this->survey_key {margin-top: -7px; z-index: 2000; padding: $r->padding" . "px; max-width: $r->width" . "px; width:100%; height: $r->height" . "px; background: $r->background_color; border: " . $r->border_size . "px solid $r->border_color;}@media only screen and (min-width: 220px) and (max-width: 660px){#question_$this->survey_key {width:90%;height:auto;}}</style>";
		}
		
		
		
		
		$funnelshort =  "<script type = 'text/javascript'> jQuery(document).ready(shortcodeSFFunnel('$this->survey_key', 0, '" . WP_PLUGIN_URL_SLLSAFE . "'));</script>";
		if ($r->answer_images) {
		foreach (explode("|", $r->answer_images) as $key => $val) {
	
	
		$funnelshort .= "<a href=\"javascript:void(0);\"><img src=\"$val\" border=\"0\"></a><br>";
		$funnelshort .=  "<script type ='text/javascript'> shortcodeSFFunnel('$this->survey_key', $key, '" . WP_PLUGIN_URL_SLLSAFE . "');</script>";
		}
		}
		$funnelshort .= "<div id=\"question_$this->survey_key\" class=\"surveyFunnelDiv survey_container_body\" style=\"".$this->getSFContainerThemeStyle($this->survey_theme)."\"><br><center><img src=\"" . WP_PLUGIN_URL_SLLSAFE."/images/loading.gif\"></center></div>";
	   
		return $funnelshort;
	}
		else
		{
			return "[ survey_funnel key = '".$this->survey_key."']";
		}
	}
	
	// End by Dinesh on 29th May, 2013
	
	/**
	 * Enter description here...
	 *
	 */
	private function showLightBox() {
		$ActiveStatus = new ActiveStatus();
		
		
		if (func_num_args() > 0) {
			$this->survey_key = func_get_arg(0);
		}
		
		global $wpdb;
		$r = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}sf_surveys WHERE survey_key = '$this->survey_key'");
		
		$this->survey_id = $r->survey_id;
		$this->border_color = $r->border_color;
		$this->survey_theme = $r->survey_theme;
		$sdate = strtotime($r->startDate);
		$edate = strtotime($r->endDate);
		$curr=strtotime(date("Y-m-d"));
		if (!$this->survey_id) {
			return false;
		}
		
		if($r->startDate=='0000-00-00')
		{
			$sdate = 0;
		}
		if($r->startDate=='0000-00-00')
		{
			$edate = 0;
		}
		$display_survey=$r->show_survey;
		
		if($display_survey==0 || $display_survey==1 && is_user_logged_in() || $display_survey==2 && !is_user_logged_in())
		{
		
		if ($r->background_image) {
			echo "<style type=\"text/css\">#question_$this->survey_key {z-index: 2000; padding: $r->padding" . "px; padding-right: 20px; width: $r->width" . "px; height: $r->height" . "px; background: url(\"$r->background_image\") left top no-repeat; border: " . $r->border_size . "px solid $r->border_color;}@media only screen and (min-width: 220px) and (max-width: 1024px){#question_$this->survey_key {width:100%;height:auto;}}</style>";
		} else {
			echo "<style type=\"text/css\">#question_$this->survey_key {z-index: 2000; padding: $r->padding" . "px; width: $r->width" . "px; height: $r->height" . "px; background: $r->background_color; border: " . $r->border_size . "px solid $r->border_color;}@media only screen and (min-width: 220px) and (max-width: 1024px){#question_$this->survey_key {width:100%;height:auto;}}</style>";
		}
		
		
		echo "<div style=\"display:none;background-color:red;\"><div id=\"question_$this->survey_key\" class=\"surveyFunnelDiv survey_container_body\" style=\"".$this->getSFContainerThemeStyle($this->survey_theme)."\"><br><center><img src=\"" . WP_PLUGIN_URL_SLLSAFE."/images/loading.gif\"></center></div></div>";
		if(($curr >= $sdate && $curr <= $edate) || ($sdate=='0' && $edate=='0') || ($curr >= $sdate && $edate=='0') || ($sdate=='0' && $curr <= $edate))
		{
		echo "<script type=\"text/javascript\">
				jQuery(document).ready(function() {
					triggerLightBox('$this->lightbox_image', '$this->survey_key', '" . WP_PLUGIN_URL_SLLSAFE . "');
				});
			  </script>";
		}
		}
		
		
	}
	
		
	/**
	 * Add an imprint to the stats table
	 *
	 */
	function addImprint() {
		if(func_num_args() > 0) {
			$this->survey_id = func_get_arg(0);
		}
		
		global $wpdb;
		$ActiveStatus = new ActiveStatus();
		
		$date = date("Y-m-d H:i:s");
		
		$r = $wpdb->get_row("SELECT imprints FROM {$wpdb->prefix}sf_survey_stats WHERE survey_id = '$this->survey_id'");

		if (!isset($r->imprints)) {
			$wpdb->insert($wpdb->prefix . 'sf_survey_stats', 
							array(
									'survey_id' => $this->survey_id,
									'imprints' => '1', 
									'active_status_id' => $ActiveStatus->active_records,
									'date_created' => $date));			
		} else {
			$tmpNum = $r->imprints + 1;
			$wpdb->update($wpdb->prefix . 'sf_survey_stats', 
							array(
									'imprints' => $tmpNum, 
									'date_modified' => $date
							), 
							array('survey_id' => $this->survey_id));			
		}
	}
	
	function getSFContainerThemeStyle($theme_id){
            global $wpdb;
            $sfTheme = $wpdb->get_row("SELECT container_css FROM {$wpdb->prefix}sf_survey_themes where survey_theme_id=".$theme_id);
            $containerCSS=htmlspecialchars_decode($sfTheme->container_css,ENT_QUOTES);
            return $containerCSS;
	}

	
} // End Survey Class
?>