<?php

// Set flag that this is a parent file
define( '_JEXEC', 1 );

define('JPATH_BASE', preg_replace('|\Smodules\Smod_.*?\Simage.php|i', '', __FILE__));

define( 'DS', DIRECTORY_SEPARATOR );

require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

$mainframe =& JFactory::getApplication('site');

$mainframe->initialise();

require(dirname(__FILE__).'/kcaptcha/kcaptcha.php');
@session_start();
$captcha = new KCAPTCHA();
$_SESSION['callback-captcha-code'] = $captcha->getKeyString();
exit;
