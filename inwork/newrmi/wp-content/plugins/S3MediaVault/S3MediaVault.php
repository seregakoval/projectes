<?php 
/* 
	Plugin Name: S3 Media Vault
	Plugin URI: http://S3MediaVault.com
	Description: S3 Media Vault
	Author: Ravi Jayagopal
	Author URI: http://S3MediaVault.com
	Version: 0.2
*/

//This function replaces the text within <s3mv></s3mv> tags with Amazon S3 Expiring URL's
function s3mv($data) { 
	if (strpos($data,'s3mv') !== false) {//found the string - so specific to login page
		// Check for CURL
		if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll')) {
			return("ERROR: CURL extension not loaded<br/><br/>. Please ask your web host to enable 'curl' on your site. <br/><br/>$data");
		}
		
		define( 'S3MVROOT', dirname(__FILE__));
		if (!class_exists('S3')) require_once 'S3.php';
		$data = htmlspecialchars_decode($data);
		
		preg_match_all("/\[s3mv\](.*?)\[\/s3mv\]/", $data, $matches);
		$i=0;
		$cool = "";
		
		while( isset($matches[1][$i]) ) {
			//$cool .= $matches[1][$i];
			$pieces = explode(",", $matches[1][$i]);
			$file = $pieces[0];
			$width = isset($pieces[1]) ? $pieces[1] : "480";
			$height = isset($pieces[2]) ? $pieces[2] : "360";
			$autoPlay = isset($pieces[3]) ? $pieces[3] : "false";
			$autoBuffering = isset($pieces[4]) ? $pieces[4] : "false";
			$id = rand() . "-" . time();
			
			// Instantiate the class
			$s3 = new S3(get_option('s3mv_accessKey'), get_option('s3mv_secretKey'));
			$file = $s3->getAuthenticatedURL(get_option('s3mv_bucketName'), $file, 1000, false, false);
			
			if($pieces[1] == "link") {
				//Just a regular media file
				$content = "<a href='".$file."'>".$pieces[0]."</a>";
				$data = str_replace ("[s3mv]".$matches[1][$i]."[/s3mv]", $content, $data);
				
			} else if( strtolower($pieces[1]) == "url") {
				//Just a regular media file
				$data = str_replace ("[s3mv]".$matches[1][$i]."[/s3mv]", $file, $data);
			} else {
				$content = file_get_contents(S3MVROOT . "/s3mediavault-player.php");
				$content = str_replace ("##PLUGINDIR##", WP_PLUGIN_URL , $content);
				$content = str_replace ("##FILE##", $file, $content);
				$content = str_replace ("##WIDTH##", $width, $content);
				$content = str_replace ("##HEIGHT##", $height, $content);
				$content = str_replace ("##AUTOPLAY##", $autoPlay, $content);
				$content = str_replace ("##AUTOBUFFERING##", $autoBuffering, $content);
				$content = str_replace ("##ID##", $id, $content);
				
				$data = str_replace("[s3mv]".$matches[1][$i]."[/s3mv]", $content, $data);
			}
			$i++;
		}
		
		//return "Cool: $cool";
	}

	//return blog post content
	return $data;

} //end function
	
// Add the options page
function s3mv_options_link() {
	add_options_page('Setup Options - S3MediaVault','S3 Media Vault', 8, 's3mv-manage','mys3mv');
}


function register_s3mvsettings() { // whitelist options
  register_setting( 's3mv-options-group', 's3mv_accessKey' );
  register_setting( 's3mv-options-group', 's3mv_secretKey' );
  register_setting( 's3mv-options-group', 's3mv_bucketName' );
}

function mys3mv() {
	?>
<div class="wrap">
<h2><?php _e( 'S3 Media Vault' ); ?></h2>
<h3>Created by: <a href="http://S3MediaVault.com" target="_blank">S3MediaVault.com</a>
& <a href="http://RavisRants.com" target="_blank">Ravi Jayagopal</a></h2>
<form method="post" action="options.php">
        <table class="form-table">
          <tr valign="top">
            <th scope="row">Amazon Access Key</th>
            <td><input name="s3mv_accessKey" type="text" id="s3mv_accessKey" value="<?php echo get_option('s3mv_accessKey'); ?>"></td>
          </tr>
          
          <tr valign="top">
            <th scope="row">Amazon Secret Key</th>
            <td><input name="s3mv_secretKey" type="text" id="s3mv_secretKey" value="<?php echo get_option('s3mv_secretKey'); ?>"></td>
          </tr>

          <tr valign="top">
            <th scope="row">Amazon Bucket Name</th>
            <td><input name="s3mv_bucketName" type="text" id="s3mv_bucketName" value="<?php echo get_option('s3mv_bucketName'); ?>"></td>
          </tr>
    </table>  

		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="s3mv_accessKey,s3mv_secretKey,s3mv_bucketName" />

        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
<?php settings_fields( 's3mv-options-group' ); ?>   
</form>
</div>
<?php 
}  

if ( is_admin() ){ // admin actions
	add_action('admin_menu','s3mv_options_link');
	add_action( 'admin_init', 'register_s3mvsettings' );
} else {
	add_filter('the_content', 's3mv'); 
}



?>