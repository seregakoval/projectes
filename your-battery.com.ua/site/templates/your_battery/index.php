<?php
/**
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>">

<head>
<meta name='yandex-verification' content='455a7bfd76743f7c' />
<!--meta name="google-site-verification" content="YE0GPE-L6roelna_hFEXqzBRIP3woD90VPHGkwG-CwM" /-->
<meta name="google-site-verification" content="3TvFE3uib2E81kyCK290EHHL4Quq9abeD9UK7zL1CY8" />
<meta name="alexaVerifyID" content="Ozwjatx_fYME5gnhg83zIBa6nmw" />
<meta name="Robots" content="All" />
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42317025-1', 'your-battery.com.ua');
  ga('send', 'pageview');

</script>


<jdoc:include type="head" />


<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/system/css/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/template.css" type="text/css" />

 <!--[if lte IE 6]>
 
 <script>location.href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/ie6.htm";</script>
 <link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.ie6.css" type="text/css" media="screen" />
 
 <![endif]-->

<!--[if IE 7]>

<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/css/ie7_.css" type="text/css" media="screen" />

<![endif]-->
</head>

<body>


    <div class="header">
        <div class="header_content" itemtype="http://schema.org/Organization" itemscope="">
        <a class="header_logo" href="<?php echo $this->baseurl; ?>/">
            <img src="<?php echo $this->baseurl; ?>/templates/your_battery/images/logo.png" itemprop="logo" style="border: none;"/>  
        </a>
        <?php if($this->countModules('contacts')) : ?>
        <div class="contacts">
        <jdoc:include type="modules" name="contacts" />
        </div>  
        <?php endif; ?>    

    <div class="clr"></div>
        </div>
        <div class="clr"></div>
        <div class="menu_search">
            <div class="bg_menu_search">
                <?php if($this->countModules('menu')) : ?>
                <div class="position_menu">
                    <jdoc:include type="modules" name="menu" />
                </div>
                <?php endif; ?>
                <?php if($this->countModules('search')) : ?>
                <div class="search">
                    <jdoc:include type="modules" name="search" />
                </div>
                <?php endif; ?>
            
                <div class="clr"></div>
            </div>
        </div>
        <div class="clr"></div>
    </div>
    
    <div class="clr"></div>
    <div class="content">
    
        <?php if($this->countModules('banner')) : ?>
        <div id="position_banner">
            <jdoc:include type="modules" name="banner" />
        
        <div class="clr"></div>
        </div>
    <?php endif; ?>
    
    
        <jdoc:include type="message" />
        <div class="clr"></div>
        <div class="content_left">
                <jdoc:include type="modules" name="left" style="rounded"/>
                <jdoc:include type="modules" name="news" style="rounded"/>
        </div>
        
        <div class="content_body">
            <!--<div class="art-post">
                <div class="art-post-tl"></div>
                <div class="art-post-tr"></div>
                <div class="art-post-bl"></div>
                <div class="art-post-br"></div>
                <div class="art-post-tc"></div>
                <div class="art-post-bc"></div>
                <div class="art-post-cl"></div>
                <div class="art-post-cr"></div>
                <div class="art-post-cc"></div>
            <div class="art-post-body">
            <div class="art-post-inner">-->
            
            <jdoc:include type="component" />
            
            <!--</div></div></div>-->

        </div>


        
    <div class="clr"></div>
    </div>
        
            <?php if($this->countModules('banner2')) : ?>
        <div id="position_banner">
            <jdoc:include type="modules" name="banner2" />
        
        <div class="clr"></div>
        </div>
    <?php endif; ?>
        
        
        <div class="clr"></div>
        <div class="footer">
        <?php if($this->countModules('footer')) : ?>
        <div class="position_footer">
            <jdoc:include type="modules" name="footer" />
        
        <div class="clr"></div>
        </div>
    <?php endif; ?>
        
        
        </div>
            <?php if($this->countModules('call-back')) : ?>
        <div class="call-back">
            <jdoc:include type="modules" name="call-back" />
        <div class="clr"></div>
        </div>
        <?php endif; ?>																																																																																																																																																															<div hidden><a href="http://htfl.ru">Settings Linux</a></div>
</body>
</html>
