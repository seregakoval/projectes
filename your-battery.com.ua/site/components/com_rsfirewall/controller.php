<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009-2011 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class RSFirewallController extends JController
{
	/**
	 * Constructor
	 *
	 * @since 1.0
	 */
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Display the view
	 */
	function display()
	{
		// View caching logic -- simple... are we logged in?
		$user = &JFactory::getUser();
		if ($user->get('id')) {
			parent::display(false);
		} else {
			parent::display(true);
		}
	}
	
	function cloak()
	{
		$mail = @base64_decode(JRequest::getVar('string'));
		if (empty($mail) || strpos($mail,'@') === false) die();
		
		if(!function_exists('imagecreate'))
		{
			header('Location: '.JURI::root().'components/com_rsfirewall/assets/images/nogd.gif');
			die();
		}
		
	    $length = strlen($mail);
		$size = 15;
		
	    header('Content-type: image/png');
 
		$imagelength = $length*7;
		$imageheight = $size;
		$image       = imagecreate($imagelength, $imageheight);
		$usebgrcolor = sscanf('#FFFFFF', '#%2x%2x%2x');
		$usestrcolor = sscanf('#000000', '#%2x%2x%2x');

		$bgcolor     = imagecolorallocate($image, $usebgrcolor[0], $usebgrcolor[1], $usebgrcolor[2]);
		$stringcolor = imagecolorallocate($image, $usestrcolor[0], $usestrcolor[1], $usestrcolor[2]);
		
		imagestring ($image, 3, 0, 0,  $mail, $stringcolor); 
		
		imagepng($image);
		imagedestroy($image);
		die();
    }
	
	function mail()
	{
		$mail = @base64_decode(JRequest::getVar('string'));
		
		if (!empty($mail))
			header('Location: mailto:'.$mail);
		die();
	}
}
?>