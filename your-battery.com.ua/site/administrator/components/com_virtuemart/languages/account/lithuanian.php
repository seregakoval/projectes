<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' ); 
/**
*
* @package VirtueMart
* @subpackage languages
* @copyright Copyright (C) 2004-2008 soeren - All rights reserved.
* @translator soeren
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See /administrator/components/com_virtuemart/COPYRIGHT.php for copyright notices and details.
*
* http://virtuemart.net
*/
global $VM_LANG;
$langvars = array (
	'CHARSET' => 'UTF-8',
	'PHPSHOP_ACC_CUSTOMER_ACCOUNT' => 'Kliento sąskaita:',
	'PHPSHOP_ACC_UPD_BILL' => 'Čia Jūs galite pakeisti savo Apmokėjimo detales.',
	'PHPSHOP_ACC_UPD_SHIP' => 'Čia Jūs galite pridėti, pakeisti Pristatymo adresus.',
	'PHPSHOP_ACC_ACCOUNT_INFO' => 'Informacija apie Sąskaitą',
	'PHPSHOP_ACC_SHIP_INFO' => 'Informacija apie Pristatymą',
	'PHPSHOP_DOWNLOADS_CLICK' => 'Spragtelėkite ant prekės pavadinimo norėdami atsisiųsti bylą/-as',
	'PHPSHOP_DOWNLOADS_EXPIRED' => 'Jūs jau išeikvojote parsisiuntimų limitą arba šios bylos parsisiuntimo galiojimo laikas baigėsi.'
); $VM_LANG->initModule( 'account', $langvars );
?>