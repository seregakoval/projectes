<?php

$sendto = "kovalsergey09@mail.ru";
$from = $_POST['billing_first_name'];
$message = $_POST['order_comments'];
$email = $_POST['billing_email'];

$subject = "Новое сообщение";
$headers = "From: " . strip_tags($phone) . "\r\n";
//$headers .= "Reply-To: " . strip_tags($username) . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html;charset=UTF-8 \r\n";

$msg = "<html><body style='font-family:Arial,sans-serif;'>";
$msg .= "<h2 style='font-weight:bold;border-bottom:1px dotted #ccc;'>Cообщение с сайта</h2>\r\n";
$msg .= "<p><strong>Имя</strong> " . $from . "</p>\r\n";
$msg .= "<p><strong>Сообщение</strong> " . $message . "</p>\r\n";
$msg .= "<p><strong>Ваш E-mail</strong> " . $email . "</p>\r\n";
$msg .= "</body></html>";

mail($sendto, $subject, $msg, $headers);
?>