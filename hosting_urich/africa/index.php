<?php
/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
$server = $_SERVER['SERVER_NAME'];
if($server == "koval.urich.org"){
define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
require( dirname( __FILE__ ) . '/wp-blog-header.php' );
}else {
	echo "<h1> database coding error</h1>  <p>#1045 – Access denied for user ‘root’@’%’ (using password: YES)</p>";
}

