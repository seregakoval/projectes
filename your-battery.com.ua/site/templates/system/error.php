<?php
      defined('JPATH_BASE') or die();
      header("HTTP/1.1 404 Not Found");
      header('Location: '.JURI::root().'articles/19-404.html');
      exit;
?>