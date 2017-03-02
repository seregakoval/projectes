<?php

if( !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );

	@ session_start();
	require_once( dirname(__FILE__).DS.'helper.php' );
	$call_email = $params->get( 'call_email', 'info@domain.com');
	$show_kcaptcha = $params->get('show_kcaptcha', 1);

	$phone = JRequest::getVar( 'phone', '' );
	$name = JRequest::getVar( 'name', '' );
	$time = JRequest::getVar( 'time', '' );
	$kcaptcha_code = JRequest::getVar( 'kcaptcha_code', '' );
	$form_send = JRequest::getVar( 'form_send', 0 );
	if ($form_send == 1)
	{
		if (($_SESSION['callback-captcha-code'] == $kcaptcha_code && $show_kcaptcha == 1) || $show_kcaptcha == 0)
		{
			if ($phone != '' && $name != '')
			{
				if (modCallbackHelper::SendCallback($phone, $call_email, $name, $time, $params))
					{
                            $send_code = JText::_('modcallback_send_succefull');

                        	/*function call back*/
                            $sms_body = 'Call back! Тел: '.$phone.', время :'.$time.', ФИО: '.$name;
                        	//$sms_body = mb_convert_encoding($sms_body, 'UTF-8'); 
                        
                        	 $sUrl  = 'http://letsads.com/api';
                        	 $sXML  = '<?xml version="1.0" encoding="UTF-8"?>
                        	    <request>
                        	    <auth>
                        	    <login>380675994180</login>
                        	    <password>battery180</password>
                        	    </auth>
                        	    <message>
                        	    <from>battery</from>
                        	    <text>'.$sms_body.'</text>
                        	    <recipient>380675994180</recipient>
                        	    </message>
                        	    </request>';
                        	
                        	 $rCurl = curl_init($sUrl);
                        	 curl_setopt($rCurl, CURLOPT_HEADER, 0);
                        	 curl_setopt($rCurl, CURLOPT_POSTFIELDS, $sXML);
                        	 curl_setopt($rCurl, CURLOPT_RETURNTRANSFER, 1);
                        	 curl_setopt($rCurl, CURLOPT_POST, 1);
                        	 $sAnswer = curl_exec($rCurl);
                        	 curl_close($rCurl);
                             /* END function call back */
                    }
				else
					{$send_code = JText::_('modcallback_send_error');}
			}
			else
				$send_code = JText::_('modcallback_invalid_name_phone');
		}
		else
			$send_code = JText::_('modcallback_invalid_kcaptcha');
	}
	require( JModuleHelper::getLayoutPath( 'mod_callback' ) );
?>