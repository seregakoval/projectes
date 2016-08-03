<?php
	$options[] = array("name" => "Homepage",
						"sicon" => "user-home.png",
						"type" => "heading");
    
    $options[] = array( "name" => "Homepage Image",
                        "desc" => "Click to 'Upload Image' button and upload your homepage image.",
                        "id" => SN."homepageimg",
                        "std" => "$blogpath/img/large.jpg",
                        "type" => "upload");

    $options[] = array( "name" => "Homepage Intro Text",
                        "desc" => "You can use &lt;b&gt; tags and new lines.",
                        "id" => SN."homepagetext",
                        "std" => "<b>GOURMAND</b>",
                        "type" => "textarea");
    
    $options[] = array( "name" => "Homepage Description Text",
                        "desc" => "You can use &lt;b&gt; tags and new lines.",
                        "id" => SN."homepagedescription",
                        "std" => "All about cooking, tastes &amp;pleasure of eating",
                        "type" => "textarea"); 

	$options[] = array( "name" => "Homepage Browse Recipes Button Text",
						"desc" => "",
						"id" => SN."browserecipes_text",
						"std" => "Browse Recipes",
						"type" => "text");

    $options[] = array( "name" => "Homepage Browse Recipes Button URL",
						"desc" => "",
						"id" => SN."browserecipes_url",
						"std" => "./recipes",
						"type" => "text");  
						
	$options[] = array( "name" => "Homepage Browse Articles Button Text",
						"desc" => "",
						"id" => SN."browsearticles_text",
						"std" => "Browse Articles",
						"type" => "text");

    $options[] = array( "name" => "Homepage Browse Articles Button URL",
						"desc" => "",
						"id" => SN."browsearticles_url",
						"std" => "./articles",
						"type" => "text"); 

 

    $options[] = array( "name" => "Enable Featured Recipes in the homepage",
						"desc" => "",
						"id" => SN."recipesok",
						"std" => "1",
						"type" => "checkbox");
    
    $options[] = array( "name" => "Recipes URL Text",
						"desc" => "",
						"id" => SN."recipesurl_text",
						"std" => "Featured Recipes",
						"type" => "text");


    $options[] = array( "name" => "Enable 'Latest on the Blog' section",
						"desc" => "",
						"id" => SN."latestarticles",
						"std" => "1",
						"type" => "checkbox");

    $options[] = array( "name" => "'Latest on the Blog' section title",
						"desc" => "",
						"id" => SN."latestarticle_title",
						"std" => "What's cookin' lately?",
						"type" => "text");
						
						
    
    
						
?>