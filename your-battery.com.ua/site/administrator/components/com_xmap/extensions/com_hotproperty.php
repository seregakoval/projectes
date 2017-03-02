<?php

defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class xmap_com_hotproperty {


	function getTree( &$xmap, &$parent, $params ) {
		$type=$company=0;
		$link_query = parse_url( $parent->link );
		parse_str( html_entity_decode($link_query['query']), $link_vars);
		$view = $xmap->getParam($link_vars,'view',0);
		$id = intval($xmap->getParam($link_vars,'id',0));
		
		// Only expand link to home or Property Type views
		if ($view != 'home' && $view != 'type' && $view != 'company') {
			return;
		}
		
		switch ($view) {
			case 'type':
				$type = $id;
				break;
			case 'company':
				$company = $id;
				break; 
		}
		
		$include_properties = $xmap->getParam($params,'include_properties',1);
		$include_properties = ( $include_properties == 1
				  || ( $include_properties == 2 && $xmap->view == 'xml')
				  || ( $include_properties == 3 && $xmap->view == 'html')
				  || $xmap->view == 'navigator');
		$params['include_properties'] = $include_properties;

		$include_companies = $xmap->getParam($params,'include_companies',1);
		$include_companies = ( $include_companies == 1
				  || ( $include_companies == 2 && $xmap->view == 'xml')
				  || ( $include_companies == 3 && $xmap->view == 'html')
				  || $xmap->view == 'navigator');
		$params['include_companies'] = $include_companies;

		$include_agents = $xmap->getParam($params,'include_agents',1);
		$include_agents = ( $include_agents == 1
				  || ( $include_agents == 2 && $xmap->view == 'xml')
				  || ( $include_agents == 3 && $xmap->view == 'html')
				  || $xmap->view == 'navigator');
		$params['include_agents'] = $include_agents;
		
		$priority = $xmap->getParam($params,'type_priority',$parent->priority);
		$changefreq = $xmap->getParam($params,'type_changefreq',$parent->changefreq);
		if ($priority  == '-1')
			$priority = $parent->priority;
		if ($changefreq  == '-1')
			$changefreq = $parent->changefreq;

		$params['type_priority'] = $priority;
		$params['type_changefreq'] = $changefreq;

		$priority = $xmap->getParam($params,'property_priority',$parent->priority);
		$changefreq = $xmap->getParam($params,'property_changefreq',$parent->changefreq);
		if ($priority  == '-1')
			$priority = $parent->priority;

		if ($changefreq  == '-1')
			$changefreq = $parent->changefreq;

		$params['property_priority'] = $priority;
		$params['property_changefreq'] = $changefreq;

		$priority = $xmap->getParam($params,'company_priority',$parent->priority);
		$changefreq = $xmap->getParam($params,'company_changefreq',$parent->changefreq);
		if ($priority  == '-1')
			$priority = $parent->priority;

		if ($changefreq  == '-1')
			$changefreq = $parent->changefreq;

		$params['company_priority'] = $priority;
		$params['company_changefreq'] = $changefreq;

		$priority = $xmap->getParam($params,'agent_priority',$parent->priority);
		$changefreq = $xmap->getParam($params,'agent_changefreq',$parent->changefreq);
		if ($priority  == '-1')
			$priority = $parent->priority;

		if ($changefreq  == '-1')
			$changefreq = $parent->changefreq;

		$params['agent_priority'] = $priority;
		$params['agent_changefreq'] = $changefreq;
		
		
		global $mosConfig_absolute_path;
		if (file_exists(JPATH_ADMINISTRATOR.DS."components".DS."com_hotproperty".DS."config.hotproperty.php")) {
			include (JPATH_ADMINISTRATOR.DS."components".DS."com_hotproperty".DS."config.hotproperty.php");
			$params['property_order'] = $hp_default_order? $hp_default_order : 'name';
			$params['property_order_mode'] = $hp_default_order2? $hp_default_order2 : 'asc';
		} elseif (file_exists(JPATH_ADMINISTRATOR.DS."components".DS."com_hotproperty".DS."configuration.php")) {
			require_once (JPATH_ADMINISTRATOR.DS."components".DS."com_hotproperty".DS."configuration.php");
			$conf = new HotpropertyConfiguration;
			$params['property_order'] = $conf->hp_default_order? $conf->hp_default_order : 'name';
			$params['property_order_mode'] = $conf->hp_default_order2? $conf->hp_default_order2 : 'asc';
		} else{//Component not found
			return;
		}

		if (!isset($params['companies_text'])) {
			$params['companies_text'] = 'Companies';
		}
		if (!isset($params['properties_text'])) {
			$params['properties_text'] = 'Properties';
		}
		if (!isset($params['agents_text'])) {
			$params['agents_text'] = 'Agents';
		}

		if ($view =='home' || $view=='type') {
			xmap_com_hotproperty::getHotProperty($xmap, $parent, $params,$type);
		}
		
		$list = $xmap->getParam($link_vars,'list','');
		if ($view == 'company') {
			if ($company) {
				xmap_com_hotproperty::getHotPropertyCompany($xmap, $parent, $params, $company,$list);
			} else {
				xmap_com_hotproperty::getHotPropertyCompanies($xmap, $parent, $params);
			}
		}
	}

	function getHotProperty ( &$xmap, &$parent, &$params,$type ) {

		$database =& JFactory::getDBO();

		$xmap->changeLevel(1);
		if (!$type) {
			$query = "SELECT id, name FROM #__hp_prop_types WHERE published='1' ORDER BY id";

			$database->setQuery($query);
			$rows = $database->loadObjectList();

				foreach($rows as $row) {
					$node = new stdclass;
			    	$node->name = $row->name;
			    	$node->id = $parent->id;
			    	$node->uid = $parent->uid.'t'.$row->id;
					$node->link = 'index.php?option=com_hotproperty&amp;view=type&amp;id='.$row->id;
					$node->priority = $params['type_priority'];
					$node->changefreq = $params['type_changefreq'];
					$node->expandible = true;
			    	if ($xmap->printNode($node) !== FALSE) {
						xmap_com_hotproperty::getHotProperty($xmap, $parent, $params,$row->id);
			    	}
	    		}
	    	} else {
				if ( $params['include_properties'] ) {
					$query = "SELECT id, name, UNIX_TIMESTAMP(created) AS `created`, UNIX_TIMESTAMP(`modified`) as `modified`, type FROM #__hp_properties  WHERE  published='1' AND approved='1' and type=$type ORDER BY {$params['property_order']} {$params['property_order_mode']}";
					$database->setQuery($query);
					$rows = $database->loadObjectList();
					foreach($rows as $row) {
						if( $row->modified == 0 ) {
							$row->modified = $row->created;
						}
						$node = new stdclass;
						$node->name = $row->name;
						$node->link = 'index.php?option=com_hotproperty&amp;view=property&amp;id='.$row->id;
						$node->id = $parent->id;
			    		$node->uid = $parent->uid.'p'.$row->id;
						$node->modified = $row->modified;
						$node->priority = $params['property_priority'];
						$node->changefreq = $params['property_changefreq'];
						$node->expandible = false;
				    	$xmap->printNode($node);
					}
			}
		}
		if ($params['include_companies'] && !$type) {
			$node = new stdclass;
	    	$node->name = $params['companies_text'];
	    	$node->id = $parent->id;
	    	$node->uid = $parent->uid.'c';
			$node->link = 'index.php?option=com_hotproperty&amp;view=company';
			$node->type = 'separator';
			$node->browserNav = 3;
			$node->priority = $params['company_priority'];
			$node->changefreq = $params['company_changefreq'];
			$node->expandible = true;
			$node->selectable = false;
			if ($xmap->printNode($node) !== FALSE) {
				xmap_com_hotproperty::getHotPropertyCompanies($xmap, $parent, $params);
		   	}
		}
		$xmap->changeLevel(-1);
	}


	function getHotPropertyProperties ( &$xmap, &$parent, &$params,$company ) {

		$database =& JFactory::getDBO();

		$xmap->changeLevel(1);

		$query = "SELECT id, name, UNIX_TIMESTAMP(created) AS `created`, UNIX_TIMESTAMP(`modified`) as `modified`, type ".
		         "FROM #__hp_properties ".
				 "WHERE  published='1' AND approved='1' AND ".
		         "       agent in (select id from #__hp_agents where company=$company) ".
				 "ORDER BY {$params['property_order']} {$params['property_order_mode']}";
		$database->setQuery($query);
		$rows = $database->loadObjectList();
		foreach($rows as $row) {
			if( $row->modified == 0 ) {
				$row->modified = $row->created;
			}
			$node = new stdclass;
			$node->name = $row->name;
			$node->link = 'index.php?option=com_hotproperty&amp;view=property&amp;id='.$row->id;
			$node->id = $parent->id;
    		$node->uid = $parent->uid.'p'.$row->id;
			$node->modified = $row->modified;
			$node->priority = $params['property_priority'];
			$node->changefreq = $params['property_changefreq'];
			$node->expandible = false;
	    	$xmap->printNode($node);
		}

		$xmap->changeLevel(-1);
	}
	
	function getHotPropertyCompany ( &$xmap, &$parent, &$params, $company, $list ) {

		$database =& JFactory::getDBO();
		if (!$list && $company) {
			$xmap->changeLevel(1);
			$node = new stdclass;
	    	$node->name = $params['properties_text'];
	    	$node->id = $parent->id;
	    	$node->uid = $parent->uid.'cp'.$company;
			$node->link = 'index.php?option=com_hotproperty&amp;view=company&amp;id='.$company.'&amp;list=property';
			$node->priority = $params['company_priority'];
			$node->changefreq = $params['company_changefreq'];
			$node->expandible = true;
			if ( $xmap->printNode($node) !== FALSE) {
				//xmap_com_hotproperty::getHotPropertyProperties($xmap, $parent, $params,$company);
			}

			$node = new stdclass;
	    	$node->name = $params['agents_text'];
	    	$node->id = $parent->id;
	    	$node->uid = $parent->uid.'ca'.$company;
			// Dummy link, there is no need to link to this page as it's the same as the company link but
			// we need to create a different link to use with the navigator
			$node->link = 'index.php?option=com_hotproperty&amp;view=company&amp;id='.$company.'&amp;list=agent';
			$node->type = 'separator';
			$node->browserNav = 3;
			$node->priority = $params['company_priority'];
			$node->changefreq = $params['company_changefreq'];
			$node->expandible = true;
			$node->selectable = false;
			if ($xmap->printNode($node) !== FALSE) {
				xmap_com_hotproperty::getHotPropertyAgents($xmap, $parent, $params,$company);
			}
			$xmap->changeLevel(-1);
		} else if ($list=='property' && $company && $params['include_properties']) {
			xmap_com_hotproperty::getHotPropertyProperties($xmap, $parent, $params,$company);
		} elseif ($list=='agent' && $company && $params['include_agents']) {
			xmap_com_hotproperty::getHotPropertyAgents($xmap, $parent, $params,$company);
	    }
	}

	function getHotPropertyCompanies ( &$xmap, &$parent, &$params ) {

		$database =& JFactory::getDBO();

		$query = "SELECT id, name FROM #__hp_companies ORDER BY name";

		$database->setQuery($query);
		$rows = $database->loadObjectList();

		$xmap->changeLevel(1);
		foreach($rows as $row) {
				$node = new stdclass;
		    	$node->name = $row->name;
		    	$node->id = $parent->id;
		    	$node->uid = $parent->uid.'c'.$row->id;
				$node->link = 'index.php?option=com_hotproperty&amp;view=company&amp;id='.$row->id;
				$node->priority = $params['company_priority'];
				$node->changefreq = $params['company_changefreq'];
				$node->expandible = true;
		    	if ($xmap->printNode($node) !== FALSE ) {
					xmap_com_hotproperty::getHotPropertyCompany($xmap, $parent, $params,$row->id,'');
		    	}
		}
		$xmap->changeLevel(-1);
	}
	
	function getHotPropertyAgents ( &$xmap, &$parent, &$params, $companyid ) {

		$database =& JFactory::getDBO();

		$xmap->changeLevel(1);
		$query = "SELECT id, name FROM #__hp_agents WHERE company=$companyid ORDER BY name";

		$database->setQuery($query);
		$rows = $database->loadObjectList();

		foreach($rows as $row) {
			$node = new stdclass;
	    	$node->name = $row->name;
	    	$node->id = $parent->id;
	    	$node->uid = $parent->uid.'c'.$row->id;
			$node->link = 'index.php?option=com_hotproperty&amp;view=agent&amp;id='.$row->id;
			$node->priority = $params['agent_priority'];
			$node->changefreq = $params['agent_changefreq'];
			$node->expandible = false;
			$xmap->printNode($node);
		}
		$xmap->changeLevel(-1);
	}
}

