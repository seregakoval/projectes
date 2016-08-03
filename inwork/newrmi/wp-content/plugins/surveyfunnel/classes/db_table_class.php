<?php
class DBTables {

	
	/**
	 * Constructor function
	 *
	 * @return DBTables
	 */
	function DBTables() {
		
	}
	
	
	/**
	 * Enter description here...
	 *
	 */
	function initDBTables() {
		global $wpdb;

		$collate = '';				/*--Added by Rajashri L to change collation of table--*/

		if ( $wpdb->has_cap( 'collation' ) ) 
		{
			if ( ! empty( $wpdb->charset ) ) 
			{
				$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
			}
			if ( ! empty( $wpdb->collate ) ) 
			{
				$collate .= " COLLATE $wpdb->collate";
			}
		}
		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		
		$sf_surveys_db_version = get_option('sf_surveys_db_version');

		if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}sf_surveys'") != $wpdb->prefix . 'sf_surveys') {
			dbDelta("CREATE TABLE {$wpdb->prefix}sf_surveys (
						startDate date,
						endDate date,
						survey_id integer not null auto_increment,
						survey_name varchar(250),
						survey_key varchar(50),
						tab_image varchar(250),
						show_survey varchar(1),
						background_color varchar(10),
						background_image varchar(250),
						border_color varchar(10),
						border_size integer,
						all_pages boolean,
						post_ids text,
						category_ids text,
						lightbox_image varchar(250),
						use_widget boolean,
						use_cookie boolean,
						cookie_days integer,
						width integer,
						height integer,
						padding integer,
						question_background_color varchar(10),
						answer_images text,
						answer_flows text,
						active_status_id integer,
						date_modified timestamp,
						date_created timestamp,
     					use_shortcode boolean,
     					default_question_header LONGTEXT,
     					survey_theme VARCHAR(50),
     						
						PRIMARY KEY (survey_id)
					)$collate;");

			add_option("sf_surveys_db_version", "4.6.3");
		}
		else if($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}sf_surveys'") == $wpdb->prefix . 'sf_surveys')
		{
			$sql="SHOW COLUMNS FROM {$wpdb->prefix}sf_surveys LIKE 'survey_key'";
			$res=$wpdb->get_row($sql);
			if($res->Type=="varchar(25)")
			{
				$sql3="ALTER TABLE {$wpdb->prefix}sf_surveys CHANGE survey_key survey_key VARCHAR( 50 )";
				$wpdb->query($sql3);
			}
			
			$sql = "SHOW COLUMNS FROM {$wpdb->prefix}sf_surveys LIKE '%Date'";

			if(!$wpdb->get_var($sql) )
			{
				$sql2 = "alter table {$wpdb->prefix}sf_surveys add (startDate date, endDate date)";
				
				$wpdb->query($sql2);
			}

			$sql = "SHOW COLUMNS FROM {$wpdb->prefix}sf_surveys LIKE 'category_ids'";
			if(!$wpdb->get_var($sql) )
			{
				$sql2 = "alter table {$wpdb->prefix}sf_surveys add category_ids text after post_ids";
				$wpdb->query($sql2);
			}
			//Add code for adding use_shortcode col begin by Dinesh
			
			$sql = "SHOW COLUMNS FROM {$wpdb->prefix}sf_surveys LIKE 'use_shortcode'";
			if(!$wpdb->get_var($sql) )
			{
				$sql2 = "alter table {$wpdb->prefix}sf_surveys add use_shortcode boolean after date_created";
				$wpdb->query($sql2);
			}
			// End by dinesh
			//Add code for adding col default_question_header
			$sql = "SHOW COLUMNS FROM {$wpdb->prefix}sf_surveys LIKE 'default_question_header'";
			if(!$wpdb->get_var($sql) )
			{
				$sql2 = "alter table {$wpdb->prefix}sf_surveys add default_question_header LONGTEXT after use_shortcode";
				$wpdb->query($sql2);
			}
			//Add code for adding col survey_theme
			$sql = "SHOW COLUMNS FROM {$wpdb->prefix}sf_surveys LIKE 'survey_theme'";
			if(!$wpdb->get_var($sql) )
			{
				$sql2 = "alter table {$wpdb->prefix}sf_surveys add survey_theme VARCHAR(50) after default_question_header";
				$wpdb->query($sql2);
			}
		}
		
				if ($sf_surveys_db_version < '2.0' ) {
			maybe_add_column("{$wpdb->prefix}sf_surveys", "lightbox_image", "ALTER TABLE {$wpdb->prefix}sf_surveys ADD COLUMN lightbox_image varchar(250);");
			update_option('sf_surveys_db_version', '4.6.3');  
		}
		
				if ($sf_surveys_db_version < '2.1' ) {
			maybe_add_column("{$wpdb->prefix}sf_surveys", "use_widget", "ALTER TABLE {$wpdb->prefix}sf_surveys ADD COLUMN use_widget boolean;");
			update_option('sf_surveys_db_version', '4.6.3'); 
		}
		
				if ($sf_surveys_db_version <= '4.7' ) {
			maybe_add_column("{$wpdb->prefix}sf_surveys", "show_survey", "ALTER TABLE {$wpdb->prefix}sf_surveys ADD COLUMN show_survey VARCHAR( 1 );" );
			update_option('sf_surveys_db_version', '4.7.1');
		}
		if ($sf_surveys_db_version <= '4.7.4' )		/* Added by Rajashri L*/
		{
			$sql2 = "ALTER TABLE {$wpdb->prefix}sf_surveys CONVERT TO character set utf8 collate utf8_general_ci;";
			$wpdb->query($sql2);
			update_option('sf_surveys_db_version', '4.7.5');
		}
		/*
		*	New Column added to save Other answer Label field
		*/
		if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}sf_survey_questions'") != $wpdb->prefix . 'sf_survey_questions') {
			dbDelta("CREATE TABLE {$wpdb->prefix}sf_survey_questions (
						survey_question_id integer not null auto_increment,
						survey_id integer,
						question varchar(250),
						font varchar(25),
						font_size varchar(10),
						font_color varchar(10),
						answers text,
						other_answer text,
						text_answer_allowed varchar(5),
						priority integer,
						question_type integer default '1',
						active_status_id integer, 
						date_modified timestamp, 
						date_created timestamp,
						question_header LONGTEXT,
						PRIMARY KEY (survey_question_id)
					)$collate;");

			dbDelta("CREATE INDEX idx_survey_questions ON {$wpdb->prefix}sf_survey_questions(survey_id);");
			
			add_option("sf_survey_questions_db_version", "4.6");
		}
		else if($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}sf_survey_questions'") == $wpdb->prefix . 'sf_survey_questions')
		{
			//Add code for adding col question_header
			$sql = "SHOW COLUMNS FROM {$wpdb->prefix}sf_survey_questions LIKE 'question_header'";
			if(!$wpdb->get_var($sql) )
			{
				$sql2 = "alter table {$wpdb->prefix}sf_survey_questions add question_header LONGTEXT after date_created";
				$wpdb->query($sql2);
			}
			$text_answer_query = "SHOW COLUMNS FROM {$wpdb->prefix}sf_survey_questions LIKE 'text_answer_allowed'";
			if(!$wpdb->get_var($text_answer_query) )
			{
				$add_text_answers = "alter table {$wpdb->prefix}sf_survey_questions add text_answer_allowed varchar(5) after other_answer";
				$wpdb->query($add_text_answers);
			}
		/*--Added by Rajashri L*/
		
			/*	
			*	Added new column for other_answer label text
			*	Added by Kaustubh - START
			*/
			$sql = "SHOW COLUMNS FROM {$wpdb->prefix}sf_survey_questions LIKE 'other_answer'";
			if(!$wpdb->get_var($sql) )
			{
				$sql3 = "alter table {$wpdb->prefix}sf_survey_questions add other_answer text after answers";
				$wpdb->query($sql3);
			}
			/*
			*	Added by Kaustubh - END
			*/

			if ($sf_surveys_db_version <= '4.7.4' )
			{
				$sql2 = "ALTER TABLE {$wpdb->prefix}sf_survey_questions CONVERT TO character set utf8 collate utf8_general_ci;";
				$wpdb->query($sql2);
				update_option('sf_surveys_db_version', '4.7.5');
			}
		}
		
		if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}sf_survey_rules'") != $wpdb->prefix . 'sf_survey_rules') {
			dbDelta("CREATE TABLE {$wpdb->prefix}sf_survey_rules (
						survey_rule_id integer not null auto_increment,
						survey_question_id integer,	
						answer_index integer,	
						result_answer integer,						
						active_status_id integer, 
						date_modified timestamp, 
						date_created timestamp,
						PRIMARY KEY (survey_rule_id)
					)$collate;");

			add_option("sf_survey_rules_db_version", "4.6");
		}
		/*--Added by Rajashri L*/

		

			if ($sf_surveys_db_version <= '4.7.4' )
			{
				$sql2 = "ALTER TABLE {$wpdb->prefix}sf_survey_rules CONVERT TO character set utf8 collate utf8_general_ci;";
				$wpdb->query($sql2);
				update_option('sf_surveys_db_version', '4.7.5');
			}
		
		// BEGIN Added By Arvind On 7-AUG-2013  For Add UserInformation
		
		if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}sf_survey_user_information'") != $wpdb->prefix . 'sf_survey_user_information') {
			dbDelta("CREATE TABLE {$wpdb->prefix}sf_survey_user_information (
			user_id integer  auto_increment,
			user_name varchar(150),
			email_id varchar(250),
			PRIMARY KEY (user_id)
			)$collate;");
		
		}
		/*--Added by Rajashri L*/

			if ($sf_surveys_db_version <= '4.7.4' )
			{
				$sql2 = "ALTER TABLE {$wpdb->prefix}sf_survey_user_information CONVERT TO character set utf8 collate utf8_general_ci;";
				$wpdb->query($sql2);
			}
	
		if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}sf_survey_results'") != $wpdb->prefix . 'sf_survey_results') {
			dbDelta("CREATE TABLE {$wpdb->prefix}sf_survey_results (
						survey_result_id integer not null auto_increment,
						survey_id integer,
						survey_question_id integer,	
						answer text,
						extra_ans text,
						active_status_id integer, 
						date_modified timestamp, 
						date_created timestamp,
						user_id integer,
						PRIMARY KEY (survey_result_id)
					)$collate;");
			
			dbDelta("CREATE INDEX idx_survey_results ON {$wpdb->prefix}sf_survey_results(survey_id);");

			add_option("sf_survey_results_db_version", "4.6");
			
	
		}
		else if($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}sf_survey_results'") == $wpdb->prefix . 'sf_survey_results')
		{
			$sql = "SHOW COLUMNS FROM {$wpdb->prefix}sf_survey_results LIKE 'user_id'";
			if(!$wpdb->get_var($sql) )
			{
				$sql2 = "alter table {$wpdb->prefix}sf_survey_results add user_id integer after date_created";
				$wpdb->query($sql2);
				$sql1 = "alter table {$wpdb->prefix}sf_survey_results add foreign key(user_id) references {$wpdb->prefix}sf_survey_user_information (user_id)";
				$wpdb->query($sql1);
			}

			$sql = "SHOW COLUMNS FROM {$wpdb->prefix}sf_survey_results LIKE 'extra_ans'";
			if(!$wpdb->get_var($sql) )
			{
				$sql3 = "alter table {$wpdb->prefix}sf_survey_results add extra_ans text after answer";
				$wpdb->query($sql3);
			}
								
			/*-Added by Rajashri L*/						

			if ($sf_surveys_db_version <= '4.7.4' )
			{
				$sql2 = "ALTER TABLE {$wpdb->prefix}sf_survey_results CONVERT TO character set utf8 collate utf8_general_ci;";
				$wpdb->query($sql2);
				update_option('sf_surveys_db_version', '4.7.5');
			}
		}
		
// END By Arvind 
		
		if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}sf_survey_stats'") != $wpdb->prefix . 'sf_survey_stats') {
			dbDelta("CREATE TABLE {$wpdb->prefix}sf_survey_stats (
						survey_stat_id integer not null auto_increment,
						survey_id integer,
						imprints integer,
						completions integer,	
						active_status_id integer, 
						date_modified timestamp, 
						date_created timestamp,
						PRIMARY KEY (survey_stat_id)
					)$collate;");
			
			dbDelta("CREATE INDEX idx_survey_stats ON {$wpdb->prefix}sf_survey_stats(survey_id);");

			
			add_option("sf_survey_stats_db_version", "4.6");   
		}
		/*Added by Rajashri L*/

			if ($sf_surveys_db_version <= '4.7.4' )
			{
				$sql2 = "ALTER TABLE {$wpdb->prefix}sf_survey_stats CONVERT TO character set utf8 collate utf8_general_ci;";
				$wpdb->query($sql2);
				update_option('sf_surveys_db_version', '4.7.5');
			}

		if ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}sf_survey_themes'") != $wpdb->prefix . 'sf_survey_themes') {
			dbDelta("CREATE TABLE {$wpdb->prefix}sf_survey_themes (
			survey_theme_id integer not null auto_increment,
			name varchar(20),
			type integer(1),
			container_css longtext,
			question_css longtext,
			answer_css longtext,
			button_css longtext,
			question_use_background varchar(4),
			question_use_border varchar(4),
			button_use_background varchar(4),
			answer_use_background varchar(4),
		 	answer_use_border varchar(4),
		 	button_use_border varchar(4),
			PRIMARY KEY (survey_theme_id)
			)$collate;");
			
			$container_css=htmlspecialchars('background:-moz-linear-gradient(top, rgba(69,72,77,0.9) 0%, rgba(0,0,0,1) 100%);background:-webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(69,72,77,0.9)), color-stop(100%,rgba(0,0,0,1)));background:-webkit-linear-gradient(top, rgba(69,72,77,0.9) 0%,rgba(0,0,0,1) 100%);background:-o-linear-gradient(top, rgba(69,72,77,0.9) 0%,rgba(0,0,0,1) 100%);background:-ms-linear-gradient(top, rgba(69,72,77,0.9) 0%,rgba(0,0,0,1) 100%);background:linear-gradient(to bottom, rgba(69,72,77,0.9) 0%,rgba(0,0,0,1) 100%);filter:progid:DXImageTransform.Microsoft.gradient( startColorstr="#e645484d", endColorstr="#000000",GradientType=0 );border:4px solid #ffffff !important;padding:15px;',ENT_QUOTES);
			$question_css=htmlspecialchars('color:#ffffff;font-family:Lato,sans-serif;font-size:16px;font-style:normal;font-weight:bold;padding:8px;border-radius:5px !important;',ENT_QUOTES);
			$answer_css=htmlspecialchars('color:#ffffff;font-family:Lato,sans-serif;font-size:14px;font-style:normal;font-weight:normal;background-color:transparent !important;margin-top: 5px;padding: 5px;',ENT_QUOTES);
			$button_css=htmlspecialchars('color:#ffffff;font-family:Lato,sans-serif;font-size:14px;font-style:normal;font-weight:normal;background-color:transparent !important;margin-top: 5px;padding: 5px;',ENT_QUOTES);
			$wpdb->insert($wpdb->prefix . 'sf_survey_themes',
					array(
							'name' => 'Black',
							'type' => 1,
							'container_css'=>$container_css,
							'question_css'=>$question_css,
							'answer_css'=>$answer_css,
							'button_css'=>$button_css
						));
			$container_css=htmlspecialchars('background:#316192;background:-moz-linear-gradient(top, #316192 0%, #233c75 100%);background:-webkit-gradient(linear, left top, left bottom, color-stop(0%,#316192), color-stop(100%,#233c75));background:-webkit-linear-gradient(top, #316192 0%,#233c75 100%);background:-o-linear-gradient(top, #316192 0%,#233c75 100%);background:-ms-linear-gradient(top, #316192 0%,#233c75 100%);background:linear-gradient(to bottom, #316192 0%,#233c75 100%);filter:progid:DXImageTransform.Microsoft.gradient( startColorstr="#316192", endColorstr="#233c75",GradientType=0 );border:4px solid #ffffff !important;padding:15px;',ENT_QUOTES);
			$question_css=htmlspecialchars('color:#80b944;font-family:Lato,sans-serif;font-size:16px;font-style:normal;font-weight:normal;padding:8px;border-radius:5px !important;background:#000000;',ENT_QUOTES);
			$answer_css=htmlspecialchars('color:#ffffff;font-family:Lato,sans-serif;font-size:15px;font-style:normal;font-weight:normal;background-color:transparent !important;margin-top: 5px;padding: 5px;',ENT_QUOTES);
			$button_css=htmlspecialchars('color:#ffffff;font-family:Lato,sans-serif;font-size:15px;font-style:normal;font-weight:normal;background-color:transparent !important;margin-top: 5px;padding: 5px;',ENT_QUOTES);
			$wpdb->insert($wpdb->prefix . 'sf_survey_themes',
					array(
							'name' => 'Blue',
							'type' => 1,
							'container_css'=>$container_css,
							'question_css'=>$question_css,
							'answer_css'=>$answer_css,
							'button_css'=>$button_css
					));
			$container_css=htmlspecialchars('background:#3c4d2d;border:4px solid #ffffff !important;padding:15px;',ENT_QUOTES);
			$question_css=htmlspecialchars('color:#bddb52;font-family:Lato,sans-serif;font-size:16px;font-style:normal;font-weight:normal;padding:8px;border-radius:5px !important;background:#000000;',ENT_QUOTES);
			$answer_css=htmlspecialchars('color:#ffffff;font-family:Lato,sans-serif;font-size:15px;font-style:normal;font-weight:normal;background-color:transparent !important;margin-top: 5px;padding: 5px;',ENT_QUOTES);
			$button_css=htmlspecialchars('color:#ffffff;font-family:Lato,sans-serif;font-size:15px;font-style:normal;font-weight:normal;background-color:transparent !important;margin-top: 5px;padding: 5px;',ENT_QUOTES);
			$wpdb->insert($wpdb->prefix . 'sf_survey_themes',
					array(
							'name' => 'Green',
							'type' => 1,
							'container_css'=>$container_css,
							'question_css'=>$question_css,
							'answer_css'=>$answer_css,
							'button_css'=>$button_css
					));
		}
		elseif ($wpdb->get_var("SHOW TABLES LIKE '{$wpdb->prefix}sf_survey_themes'") == $wpdb->prefix . 'sf_survey_themes') {
			
			/*	
			*	Addition of new columns for Button CSS Auto-generation
			*	Added by Kaustubh
			*/
			
			$sql = "SHOW COLUMNS FROM {$wpdb->prefix}sf_survey_themes LIKE 'button_css'";
			if(!$wpdb->get_var($sql) )
			{
				$sql5 = "ALTER table {$wpdb->prefix}sf_survey_themes add (button_css text,button_use_border varchar(4),button_use_background varchar(4))";
				$wpdb->query($sql5);
			}
		}

		/* Added by Rajashri L*/

			if ($sf_surveys_db_version <= '4.7.4' )
			{
				$sql2 = "ALTER TABLE {$wpdb->prefix}sf_survey_themes CONVERT TO character set utf8 collate utf8_general_ci;";
				$wpdb->query($sql2);
				update_option('sf_surveys_db_version', '4.7.5');
			}
		
		update_option("sf_survey_stats_db_version", "4.6");
	}
	
	
} // End Table Class
?>
