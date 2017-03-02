<?php
/**
* Image converter class
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: csvi_class_image_converter.php 1138 2010-01-27 22:54:36Z Roland $
 */
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Image converter
*
* @package CSVIVirtueMart
 */

class ImageConverter {
	
	/**	@var int $bg_red 0-255 - red color variable for background filler */
	private $bg_red = 0;
	/**	@var int $bg_green 0-255 - green color variable for background filler */
	private $bg_green = 0;
	/** @var int $bg_blue 0-255 - blue color variable for background filler */
	private $bg_blue = 0;
	/**	@var int $maxSize 0-1 - true/false - should thumbnail be filled to max pixels */
	private $maxSize = false;
	/** @var string Filename for the thumbnail */
	public $file_out = null;
	
	/**
	*   Constructor - requires following vars:
	*	
	*	@param array $thumb_file_details contains all the variables for creating a new image
	*	
	 */
	public function __construct($thumb_file_details) {
		
		/* Set all details */
		foreach ($thumb_file_details as $type => $value) {
			switch ($type) {
				case 'maxsize':
					if ($value) $this->maxSize = true;
					else $this->maxSize = false;
					break;
				case 'bgred':
					if ($thumb_file_details['bgred'] >= 0 || $thumb_file_details['bgred'] <= 255) $this->bg_red = $thumb_file_details['bgred'];
					else $this->bg_red = 0;
					break;
				case 'bggreen':
					if($thumb_file_details['bggreen'] >= 0 || $thumb_file_details['bggreen'] <= 255) $this->bg_green = $thumb_file_details['bggreen'];
					else $this->bg_green = 0;
					break;
				case 'bgblue':
					if($thumb_file_details['bgblue'] >= 0 || $thumb_file_details['bgblue'] <= 255) $this->bg_blue = $thumb_file_details['bgblue'];
					else $this->bg_blue = 0;
					break;
				default:
					$this->$type = $value;
					break;
			}
		}
		
		$this->NewImgCreate();
	}
	
	/**
	* Start creating the new image
	 */
	private function NewImgCreate() {
		/* Clear the cache */
		clearstatcache();
		
		switch($this->file_extension) {
			case "gif":
				if( function_exists("imagecreatefromgif") ) {
					$orig_img = imagecreatefromgif($this->file);
					break;
				}
				else return false;
			case "jpg":
				if (function_exists("imagecreatefromjpeg")) {
					$orig_img = imagecreatefromjpeg($this->file);
					break;
				}
				else return false;
				break;
			case "png":
				if( function_exists("imagecreatefrompng") ) {
					$orig_img = imagecreatefrompng($this->file);
					break;
				}
				else return false;
				break;
			default:
				return false;
				break;
		}
		if ($orig_img) {
			/* Save the new image */
			$img_resize = $this->NewImgSave($this->NewImgResize($orig_img));
			
			/* Clean up old image */
			ImageDestroy($orig_img);
		}
		else $img_resize = false;
		
		if ($img_resize) return true;
		else return false;
	}
	
	/**
	* Resize the image
	*
	* Includes function ImageCreateTrueColor and ImageCopyResampled which are available only under GD 2.0.1 or higher !
	 */
	private function NewImgResize($orig_img) {
		$orig_size = getimagesize($this->file);
		
		$maxX = $this->file_out_width;
		$maxY = $this->file_out_height;
		
		if ($orig_size[0] < $orig_size[1]) {
			$this->file_out_width = $this->file_out_height* ($orig_size[0]/$orig_size[1]);
			$adjustX = ($maxX - $this->file_out_width)/2;
			$adjustY = 0;
		}
		else {
			$this->file_out_height = $this->file_out_width / ($orig_size[0]/$orig_size[1]);
			$adjustX = 0;
			$adjustY = ($maxY - $this->file_out_height)/2;
		}
		
		while ($this->file_out_width < 1 || $this->file_out_height < 1) {
			$this->file_out_width*= 2;
			$this->file_out_height*= 2;
		}
		
		/* See if we need to create an image at maximum size */
		if ($this->maxSize) {
			if (function_exists("imagecreatetruecolor")) $im_out = imagecreatetruecolor($maxX,$maxY);
			else $im_out = imagecreate($maxX,$maxY);
			
			if ($im_out) {
				/* Need to image fill just in case image is transparent, don't always want black background */
				$bgfill = imagecolorallocate( $im_out, $this->bg_red, $this->bg_green, $this->bg_blue );
				
				if (function_exists("imageAntiAlias")) imageAntiAlias($im_out,true);
				imagealphablending($im_out, false);
				
				if (function_exists("imagesavealpha")) imagesavealpha($im_out,true);
				
				if (function_exists( "imagecolorallocatealpha")) $transparent = imagecolorallocatealpha($im_out, 255, 255, 255, 127);
				
				if (function_exists("imagecopyresampled")) ImageCopyResampled($im_out, $orig_img, $adjustX, $adjustY, 0, 0, $this->file_out_width, $this->file_out_height,$orig_size[0], $orig_size[1]);
				else ImageCopyResized($im_out, $orig_img, $adjustX, $adjustY, 0, 0, $this->file_out_width, $this->file_out_height,$orig_size[0], $orig_size[1]);
			}
			else return false;
		}
		else {
			if (function_exists("imagecreatetruecolor")) $im_out = ImageCreateTrueColor($this->file_out_width,$this->file_out_height);
			else $im_out = imagecreate($this->file_out_width,$this->file_out_height);
			
			if ($im_out) {
				if (function_exists("imageAntiAlias")) imageAntiAlias($im_out,true);
				imagealphablending($im_out, false);
				
				if (function_exists("imagesavealpha")) imagesavealpha($im_out,true);
				if (function_exists("imagecolorallocatealpha")) $transparent = imagecolorallocatealpha($im_out, 255, 255, 255, 127);
				  
				if (function_exists("imagecopyresampled")) ImageCopyResampled($im_out, $orig_img, 0, 0, 0, 0, $this->file_out_width, $this->file_out_height,$orig_size[0], $orig_size[1]);
				else ImageCopyResized($im_out, $orig_img, 0, 0, 0, 0, $this->file_out_width, $this->file_out_height,$orig_size[0], $orig_size[1]);
			}
			else return false;
		}
		
		return $im_out;
	}
	
	/**
	* Save the new image
	* @todo Add check if destination folder exists
	*
	 */
	private function NewImgSave($new_img) {
		/* Lets see if we need to rename the output file since we know the sizes */
		if ($this->rename) {
			$filename = basename($this->file_out, '.'.$this->file_extension);
			$filename_new = $filename.'_'.round($this->file_out_height).'x'.round($this->file_out_width).'.'.$this->file_extension;
			$this->file_out = str_ireplace($filename.'.'.$this->file_extension, $filename_new, $this->file_out);
		}
		
		switch($this->file_out_extension) {
			case "gif":
			if (!function_exists("imagegif")) {
				if (strtolower(substr($this->file_out,strlen($this->file_out)-4,4)) != ".gif") $this->file_out .= ".png";
				return @imagepng($new_img,$this->file_out);
			}
			else {
				if (strtolower(substr($this->file_out,strlen($this->file_out)-4,4)) != ".gif") $this->file_out .= ".gif";
				return @imagegif ($new_img, $this->file_out);
			}
			break;
			case "jpg":
				if (strtolower(substr($this->file_out,strlen($this->file_out)-4,4)) != ".jpg")
				$this->file_out .= ".jpg";
				return @imagejpeg($new_img, $this->file_out, 100);
				break;
			case "png":
				if (strtolower(substr($this->file_out,strlen($this->file_out)-4,4)) != ".png")
				$this->file_out .= ".png";
				return @imagepng($new_img,$this->file_out);
				break;
		}
	}
}
?>
