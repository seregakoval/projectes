<?php
/*
 Plugin Name: Google Analytics Injector
 Plugin URI: http://www.geckosolutions.se/blog/wordpress-plugins/
 Description: Google Analytics Injector plugin let you inject Google Analytics tracking code into your website to 
 collect statistics about your visitors. Just add your tracking code from Google Analytics to start the tracking.
 Version: 1.1.3
 Author: Niklas Olsson
 Author URI: http://www.geckosolutions.se
 License: GPL 2.0, @see http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * WP Hooks
 **/
add_action('init', 'load_google_analytics_injector_translation_file');
add_action('wp_head', 'inject_google_analytics_code');
add_action('admin_head', 'admin_register_google_analytics_injector_head');
add_action('admin_menu', 'add_google_analytics_injector_options_admin_menu');

/**
 * Loads the translation file for this plugin.
 */
function load_google_analytics_injector_translation_file() {
  $plugin_path = basename(dirname(__FILE__));
  load_plugin_textdomain('google-analytics-injector', null, $plugin_path . '/languages/');
}

/**
 * Prints the stylesheet link in the admin head.
 */
function admin_register_google_analytics_injector_head() {
  $wp_content_url = get_option('siteurl');
  if(is_ssl()) {
    $wp_content_url = str_replace('http://', 'https://', $wp_content_url);
  }
  
  $url = $wp_content_url . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/css/google-analytics-injector.css';
  echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
}

/**
 * Injects the Google Analytics tracking code.
 */
function inject_google_analytics_code() {
  if (!current_user_can('edit_posts') && get_option('ua_tracking_code') != "") {
    echo "<!-- Google Analytics Injector from http://www.geckosolutions.se/blog/wordpress-plugins/ -->\n"; 
    echo get_google_analytics_tracking_code(get_option('ua_tracking_code'), get_option('site_restriction_url'), get_option('site_domain_url'));
    echo "\n<!-- Google Analytics Injector -->\n";
  }
}

/**
 * Get the Google Analytics tracking code based on the users given values for UA-xxxx-x tracking code
 * and the url which is used to restrict the tracking to the given site only.
 * 
 * @param ua_tracking_code the UA-xxxx-x code from your Google Analytics account.
 * @param site_restriction_url the url to use for restricton of the tracking.
 * @return the tracking code to render.
 */
function get_google_analytics_tracking_code($ua_tracking_code, $site_restriction_url, $site_domain_url) {
  $google_tracking_code = "<script type='text/javascript'>";
  $google_tracking_code .= "";
  if($site_restriction_url) {
    $google_tracking_code .= "
	var site = '' + document.location;
	if(site.indexOf('".$site_restriction_url."') == -1 ) {";
  }
  $google_tracking_code .= "
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', '".$ua_tracking_code."']);";
    if($site_domain_url) {
        $google_tracking_code .= "_gaq.push(['_setDomainName', '".$site_domain_url."']);";
    }
    $google_tracking_code .= "_gaq.push(['_trackPageview']);
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();";
    if($site_restriction_url) {
			$google_tracking_code .= "
	}";
		}
    $google_tracking_code .= "
</script>";
  return $google_tracking_code;
}

/**
 * Add the plugin options page link to the dashboard menu.  
 */
function add_google_analytics_injector_options_admin_menu() {
  add_options_page(__('Google Analytics Injector Settings', 'google-analytics-injector'), __('Google Analytics Injector Settings', 'google-analytics-injector'), 'manage_options', basename(__FILE__), 'google_analytics_injector_plugin_options_page'); 
} 

/**
 * The main function that generate the options page for this plugin.
 */
function google_analytics_injector_plugin_options_page() {

  $tracking_code_err = "";
  if(!isset($_POST['update_google_analytics_injector_plugin_options'])) {
    $_POST['update_google_analytics_injector_plugin_options'] == 'false';
  } 
  
  if ($_POST['update_google_analytics_injector_plugin_options'] == 'true') {
    
  	$errors = google_analytics_injector_plugin_options_update(); 
  
    if (is_wp_error($errors)) {
      $tracking_code_err = $errors->get_error_message('tracking_code');
    }
  }
  ?>
    <div class="wrap">
    	<div class="gai-col1">
        <div id="icon-themes" class="icon32"><br /></div>
        <h2><?php echo __('Google Analytics Injector Settings', 'google-analytics-injector'); ?></h2>
  
        <form method="post" action="">
          
          <h4 style="margin-bottom: 0px;"><?php echo __('Google Analytics tracking code (UA-xxxx-x)', 'google-analytics-injector'); ?></h4>
          <?php 
            if ($tracking_code_err) {
              echo '<div class="errorMsg">'.$tracking_code_err.'</div>';
            }
          ?>
          <input type="text" name="ua_tracking_code" id="ua_tracking_code" value="<?php echo get_option('ua_tracking_code'); ?>" style="width:400px;"/>

          <h4 style="margin-bottom: 0px;"><?php echo __('Your domain eg. .mydomain.com', 'google-analytics-injector'); ?></h4>
          <input type="text" name="site_domain_url" id="site_domain_url" value="<?php echo get_option('site_domain_url'); ?>" />

          <h4 style="margin-bottom: 0px;"><?php echo __('Restrict tracking to this domain http://', 'google-analytics-injector'); ?></h4>
          <input type="text" name="site_restriction_url" id="site_restriction_url" value="<?php echo get_option('site_restriction_url'); ?>" style="width:400px;"/>
          
          <input type="hidden" name="update_google_analytics_injector_plugin_options" value="true" />
          <p><input type="submit" name="search" value="<?php echo __('Update Options', 'google-analytics-injector'); ?>" class="button" /></p>
        </form>
      </div>
      <div class="gai-col2">
      
      	<div class="description">
      		<?php 
      		  echo __('Enter the tracking code from the Google Analytics account you want to use for this site. None of the java script code will be injected if you leave this field empty. (eg. the plugin will be inactive) ', 'google-analytics-injector');
      		  
      		  $images_path = path_join(WP_PLUGIN_URL, basename(dirname(__FILE__))."/images/");
      		  $external_icon = '<img src="'.$images_path.'external_link_icon.png" title="External link" />';
      		  
      		  printf(__('Go to <a href="http://www.google.com/analytics/" target="_blank">Google Analytics</a> %s and get your tracking code.', 'google-analytics-injector'), $external_icon);
      		?>
      	</div>
      	
      	<div class="description">
      	  <?php echo __('To be sure this tracking code is not used on the wrong site you could restrict the useage by specifying the site url. This plugin also exclude the visits from the Administrator if he/she is currently logged in.', 'google-analytics-injector'); ?>
      	</div>
      	
      	<div class="description">
      	  <?php printf(__('This plugin is created by Gecko Solutions. Find more plugins at <br /><a href="http://www.geckosolutions.se/blog/wordpress-plugins/">Gecko Solutions plugins</a> %s', 'google-analytics-injector'), $external_icon); ?>
      	</div>
      	
      </div>
    </div>
  <?php
}

/**
 * Update the Google Analytics Injector plugin options. 
 */
function google_analytics_injector_plugin_options_update() {
  
  
  
  if(isset($_POST['ua_tracking_code'])) {
    update_option('ua_tracking_code', $_POST['ua_tracking_code']);
  } 
  
  if(isset($_POST['ua_tracking_code']) && !isValidUaCode($_POST['ua_tracking_code'])) {
    $errors = new WP_Error('tracking_code', __('The tracking code is on the wrong format', 'google-analytics-injector'));
  }

  if(isset($_POST['site_domain_url'])) {
    update_option('site_domain_url', $_POST['site_domain_url']);
  }

  if(isset($_POST['site_restriction_url'])) {
    update_option('site_restriction_url', $_POST['site_restriction_url']);
  }
  return $errors;
}

/**
 * Validate the format of the given Google Analytics tracking code.
 * @param $ua_tracking_code the given Google Analytics tracking code to validate.
 */
function isValidUaCode($ua_tracking_code) {
  if($ua_tracking_code == "" || preg_match('/^UA-\d{4,9}-\d{1,2}$/', $ua_tracking_code)) {
    return true;
  }
  return false;
}
