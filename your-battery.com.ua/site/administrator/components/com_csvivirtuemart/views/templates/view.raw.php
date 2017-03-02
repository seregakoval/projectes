<?php
/**
* Templates view
 *
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: view.raw.php 1117 2010-01-01 21:39:52Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.view' );

/**
* Templates View
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartViewTemplates extends JView {
	/**
	* Templates view display method
	* @return void
	* */
	function display($tpl = null) {
		
		$task = JRequest::getVar('task');
		
		switch ($task) {
			case 'listfields':
				$model = $this->getModel('templates');
				$model->setTemplateId(JRequest::getInt('template_id'));
				$templatename = $model->getTemplateName();
				$this->assignRef('templatename', $templatename);
				$fields = $model->GetFields(JRequest::getInt('template_id'), false, 0, 0);
				$this->assignRef('fields', $fields);
				break;
		}
		
		/* Display it all */
		parent::display($tpl);
	}
}
?>
