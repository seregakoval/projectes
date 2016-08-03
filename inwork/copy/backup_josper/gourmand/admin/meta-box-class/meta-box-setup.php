<?php

require_once("meta-box-class.php");

if (is_admin()){

	//All meta boxes prefix
	$prefix = 'gourmand_';
	
	//Bio info meta box config
	$config3 = array(
	'id' => 'recipe_options',          			// meta box id, unique per meta box
	'title' => 'Recipe Options',          		// meta box title
	'pages' => array('recipes'),      		// post types, accept custom post types as well, default is array('post'); optional
	'context' => 'normal',            		// where the meta box appear: normal (default), advanced, side; optional
	'priority' => 'high',            		// order of meta box: high (default), low; optional
	'fields' => array(),            		// list of meta fields (can be added by field arrays)
	'local_images' => true,          		// Use local or hosted images (meta box images for add/remove)
	'use_with_theme' => true          		//change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
	);


	//Initiate bio info meta box
	$my_meta3 =  new AT_Meta_Box($config3);


	//Bio info fields
	$my_meta3->addCheckbox($prefix.'featuredrecipe',array('name'=> 'Featured ', 'desc'=>'Is this a featured recipe? '));
	$my_meta3->addText($prefix.'cooktime',array('name'=> 'Cooking Time ', 'desc'=>'Enter cooking time of the recipe '));
	$my_meta3->addText($prefix.'difficulty',array('name'=> 'Difficulty Degree ', 'desc'=>'Enter the difficulty degree of the recipe'));

    //Finish bio info meta mox decleration
	$my_meta3->Finish();


}