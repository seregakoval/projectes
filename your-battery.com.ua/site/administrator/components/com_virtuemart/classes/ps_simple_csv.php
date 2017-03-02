<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' ); 
/**
*
* @version $Id: ps_csv.php,v 1.7.2.1 2005/11/30 20:18:59 soeren_nb Exp $
* @package VirtueMart
* @subpackage classes
* @copyright Copyright (C) 2004-2005 Soeren Eberhardt. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See /administrator/components/com_virtuemart/COPYRIGHT.php for copyright notices and details.
*
* http://virtuemart.net
*/

/* The NEW ps_csv class
*
* This class allows for the adding of multiple
* products and categories from a csv file
* Да, да, да всё это круто, но такой класс как тут был можно смело спустить в унитаз... начинаю делать свой - 27.11.06
*************************************************************************/

class ps_simple_csv {
	var $classname = "ps_simple_csv";
	
	/**************************************************************************
	** name: upload_csv()
	** created by: John Syben
	** modified by: nhyde
	** A db table named 'mos_{vm}_csv' must exist with the product fields
	** allocated their relative positions in the csv line
	***************************************************************************/
	var $csv_file;
	var $csv_delimiter;
	var $csv_enclosure;

  function upload_csv() {
    global $vmLogger;

    //ignore_user_abort(1);
    set_time_limit(0);    
    //ini_set('max_input_time',450);        
    ini_set('display_errors', 1);
    error_reporting(E_ALL^E_NOTICE);
    
    // Засекаем время
    $this->t_pagetime("init");

    if( !$this->option['_offset'] ) {
      // 0 - without limit
      $this->option['_time_limit'] = floatval(mosGetParam($_REQUEST, 'time_limit', 25));      
      $this->option['_line_limit'] = intval(mosGetParam($_REQUEST, 'line_limit', 1000));
      
      $this->csv_file = mosGetParam($_REQUEST, 'local_csv_file', '');
      
      $this->csv_delimiter = mosGetParam($_REQUEST, 'csv_delimiter', '');
      if( $this->csv_delimiter == 'other' ) $this->csv_delimiter = mosGetParam($_REQUEST, 'other_delimiter', '');
      
      $this->csv_enclosure = mosGetParam($_REQUEST, 'csv_enclosurechar', '');
      if( $this->csv_enclosure == 'other' ) $this->csv_enclosure = mosGetParam($_REQUEST, 'other_enclosurechar', '');
      
      $this->option['_check_products'] = mosGetParam($_REQUEST, 'check_products', 0);

      // handle the upload here
      if ( $this->handle_csv_upload() == false ) {
        return false;
      }
      
      $vmLogger->info('Начало обработки CSV.');
      $this->line = 0;
    }
    else {
      //Возвращаем системные сообщения с предыдущего сеанса
      $vmLogger = $this->vmlogger; unset($this->vmlogger);
      
      $vmLogger->info('Продолжение обработки CSV.');
    }    
    
    if( !$this->parse() ) {
      return false;
    }
    $vmLogger->info('Обработка CSV завершена.'."\n".'Общее время выполнения: '.floatval($this->stats['time']).' сек.');
    
    if( !$this->finish() ) {
      return false;
    }

    return true;
    
  } //End function upload_csv
  
  /**
  * @desc Определяем формат последующих строк
  * 
  */
  function get_definition($data) {
    global $vmLogger;
    include(CLASSPATH.'ps_simple_csv_aliases.php');
    
    // Если ищем заголовок
    if( count($data) == 1 ) {
      $this->option['_module'] = $modules[$data];
      if( !is_callable( 'ps_csv', $this->option['_module'] ) ) {
        return false;
      }
      
      return true;
    }
    
    // Иначе ищем колонки
    $aliases = $this->option['_module'].'_fields'; 
    $aliases = $$aliases;
     
    $dynamic_aliases = $this->option['_module'].'_dynamic_fields';
    $dynamic_aliases = $$dynamic_aliases;

    // Если есть массив с алиасами на колонки и есть алиас для соотвествующей колонки переписываем их вместо реальных данных
    for($i = 0; $i < count($data); $i++) {
      $data[$i] = trim($data[$i]);
      if( is_array($aliases) && count($aliases) && isset($aliases[$data[$i]]) ) {
        $this->columns[] = array( 'name' => $aliases[$data[$i]]);
      }
      else {
        if( is_array($dynamic_aliases) && count($dynamic_aliases) ) {
          foreach( $dynamic_aliases as $format => $columns ) {
            //$result = sscanf($data[$i], $format);
            $result = preg_match($format, $data[$i], $matches);
            if( $result ){
              $columns = explode('|', $columns);
              $this->columns[] = array( 'name' => $columns[0] );
              for($j = 1; $j < count($columns); $j++) {
                $this->columns[count($this->columns) - 1]['parameters'][$columns[$j]] = $matches[$j];
              }
              break;
            }
          }
        }
        
        if( !$result ) {
          $this->columns[] = array( 'name' => $data[$i]);
        }
      }
    }
    
    if( !count( $this->columns ) ) {
      $vmLogger->error('Не удалось определить формат файла.');
      return false;
    }
    else {
      $vmLogger->info('Определение формата файла успешно выполнено. Время выполнения: '.$this->t_pagetime("print").' сек.');
      return true;
    }
  }
  
  /**
  * @desc Парсинг значений
  */
  function parse() {
    global $vmLogger;
    static $time;
    
    while ( $data = $this->get_next_line() ) {       
      // Засекаем время
      $this->t_pagetime('init');
      // Берем действие для строки
      if($this->columns) $this->data[$this->line]['_action'] = $data[count($this->columns)];
      $action = '';     
      
      if($this->line == 300) {
        echo "good";
      } 
      
      // Если одна значащая колонка
      if( count(array_filter($data)) == 1 ) {
        // Если это ключевое слово переходим на след итерацию, где ищем колонки
        if( $data[0] ) {                          
          if( $this->get_definition($data[0]) ) {
            $this->option['_header'] = $this->line;
            unset($this->columns);
            
            $this->write_log('Найден заголовок. Определяем формат последующих записей.');
            continue;
          }
          
          $vmLogger->notice('Не удалось найти обработчик '.$data[0].'.');
        }        
        // Если не заголовок
        else {
          // Если формат не определен - пропускаем, дряная строка
          if( !count($this->columns) ) {
            $action = 'ignore';
            
          }
          // Если формат определен - ищем информацию. В данном случае информацию о категории. В этой версии такого нет.
          $action = 'ignore';
          $this->write_log('Ожидаются данные.');
        }     
        
      }
      /*
      elseif( count(array_filter($data)) == 0 ) {
        $this->write_log('Пустая строка. Пропускаем.');
        continue;
      }
      */
      
      // Если колонка не одна
      // Если формат файла не определен, но заголовок найден - определяем формат и скидываем заголовок
      if( !count($this->columns) && isset($this->option['_header']) ) {
        // Если формат получили - скидываем заголовок (может потом ещё найдем)
        if( $this->get_definition($data) ) {
          unset($this->option['_header']);
          continue;
        }
        else {
          return false;
        }
      }             
      // Если формат есть - основное действо      
      elseif( count($this->columns) ) {
        for($i = 0; $i < count($this->columns); $i++){
          // Очень важно обрезать пробелы
          $data[$i] = trim($data[$i]);
          if( $this->columns[$i]['parameters'] ) {
            $temp = $this->columns[$i]['parameters'];
            $temp['value'] = $data[$i]; //addslashes(stripslashes($data[$i]));
            $this->data[$this->line][$this->columns[$i]['name']][] = $temp; //addslashes($data[$i]);
            unset($temp);
          }
          else {
            $this->data[$this->line][$this->columns[$i]['name']] = $data[$i]; //addslashes(stripslashes($data[$i]));
          }
        }
      }        
      
      if( !$this->option['_module'] ) {
        $action = 'ignore';
        $this->write_log('Не указан обрабатывающий модуль.');
      }
      
      if( !empty($this->data[$this->line]['_action']) ) {
        $this->write_log('Для строки указано действие «'.$this->data[$this->line]['_action'].'»');
      }
      //Определились с данными - обрабатываем
      if ( $action != 'ignore' && $this->data[$this->line]['_action'] != 'ignore' ) {
        // Обработка модулями
        //$this->$module();                                     
        call_user_method($this->option['_module'], $this, $this->data[$this->line]);
        // Освобождаем немного ресурсов. Не обязательно
        unset($this->data[$this->line]);
      }
      else {
        $this->write_log('Строка пропущена.');
      }
     
      //Отдаём время
      $vmLogger->info('Строка '.$this->line."\n".$this->read_log()."\n".'Время выполнения: '.$this->t_pagetime("print").' сек.');
    }
    
    return true;                   
  }
  
  /**
  * @desc Финишная обработка
  */
  function finish() {
    global $database, $vmLogger;
    // Если при заливке указана опция на проверку товаров в базе, то строим мегазапрос.
    if ( $this->option['_check_products'] ) {
      $vmLogger->info('Обработка базы данных');
      $db = new ps_DB;
      if(is_array($this->num['products']) && count($this->num['products']) ) {
        $q  = "UPDATE #__{vm}_product SET product_publish = 'N' WHERE product_sku NOT IN ('".implode("', '", $this->num['products'])."') AND product_publish = 'Y'";
        $db->query($q);
        $result = $database->getAffectedRows();
        $vmLogger->info('Распубликовано '.$result.' товаров.');
      }
      
      if(is_array($this->num['categories']) && count($this->num['categories']) ) {
        $db = new ps_DB;
        $q  = "UPDATE #__{vm}_category SET category_publish = 'N' WHERE category_id NOT IN ('".implode("', '", $this->num['categories'])."') AND category_publish = 'Y'";
        $db->query($q);
        $result = $database->getAffectedRows();
        $vmLogger->info('Распубликовано '.$result.' категорий.');
      }      
      $vmLogger->info('Обработка базы данных завершена.');
    }
    
    // Hide log
    $vmLogger->_temp_messages = $vmLogger->_messages;
    $vmLogger->_messages = array();
    
    // Уничтожаем файло
    @unlink($this->csv_file);
    @unlink($this->class_storage_file);
    
    return true;
  }

	/**
	* Handle the upload of file "file".
	*
	* Longer, multi-line description here.
	* 
	* @name handle_csv_upload
	* @author Nathan Hyde <nhyde@bigdrift.com>
	* @returns boolean True of False
	*/
  function handle_csv_upload() {
    global $vmLogger;

    $allowed_suffixes_arr = array(
      0 => 'csv',
      1 => 'txt'
      // add more here if needed
    );
    
    $allowed_mime_types_arr = array(
      0 => 'text/html',
      1 => 'text/plain',
      2 => 'application/octet-stream',
      3 => 'application/x-octet-stream',
      4 => 'application/vnd.ms-excel',
      5 => 'application/force-download',
      6 => 'text/comma-separated-values',
      7 => 'text/x-csv',
      8 => 'text/x-comma-separated-values',
      // add more here if needed
    );
    
    // Если нет загруженных файлов и локальный файл не указан - ошибка
    if( empty($_FILES["file"]["name"]) && empty($this->csv_file) ) {
      $vmLogger->err('Error: No file provided.');
      return false;
    }
    
    // Если нет загруженных файлов
    if( empty($_FILES["file"]["tmp_name"]) ) {
      if( !file_exists($this->csv_file) ) {
        $vmLogger->err('Error: Specified local file doesn\'t exist.');
        return false;
      }
      $fileinfo = pathinfo( $this->csv_file ); 
      $extension = $fileinfo["extension"]; 
    }
    // Если файл загружали
    else {
      // test the mime type here
      if ( !in_array($_FILES["file"]["type"], $allowed_mime_types_arr) ) {
        $vmLogger->err('Mime type not accepted. Type for file uploaded: '.$_FILES["file"]["type"]);
        return false;
      }
      $this->csv_file = $_FILES["file"]["tmp_name"];
      $fileinfo = pathinfo($_FILES["file"]["name"]); 
      $extension = $fileinfo["extension"]; 
    }

    // Дополнительная проверка на расширение, т.к. мы не можем посмотреть на миме локального файла
    // Если неправильное расширение - ошибка
    if ( !in_array($extension, $allowed_suffixes_arr) ) {
      $vmLogger->err('Suffix not allowed. Valid suffixes are: '.implode(', ', $allowed_suffixes_arr));
      return false;
    }
    
    global $mosConfig_absolute_path;
    if( $tmp_name = tempnam($mosConfig_absolute_path.'/media/', 'vmc')) {  
      unlink($tmp_name);
      if( rename($this->csv_file, $tmp_name) ) {
        $this->option['_infinity'] = 1;
        $this->csv_file = $tmp_name;
      }
      else {
        return false;
      }
    }
    else {
      return false;
    }
    
    return true;
  }
	
  /**
  * Get next line from csv file
  *
  * @name get_next_line
  * @author tug
  * @param class vars: csv_file, csv_delimiter, csv_enclosure
  * @return array data
  */
  function get_next_line() {
    global $vmLogger;
    static $fp, $php_version, $line, $time;
    
    if( !$fp ) {
      if( !$fp = fopen ($this->csv_file, "r") ) {
        $vmLogger->crit('Ошибка при открытии файла '.$this->csv_file);
        return false;
      }
      
      if( $this->option['_infinity'] && $this->option['_offset'] ) {
        fseek($fp, $this->option['_offset'] );
      }
    }
    
    $this->stats['time'] = $this->stats['time'] + $this->t_pagetime('print');
    $time = $time + $this->t_pagetime('print');
    
    // Redirrect
    if( $this->option['_infinity'] && ( ($this->option['_line_limit'] && $line > $this->option['_line_limit']) || ($this->option['_time_limit'] && $time > $this->option['_time_limit']) ) ) {
      $line = 0; $time = 0;
      $this->option['_offset'] = ftell($fp);      
      
      if( !$this->class_storage_file ) {
        global $mosConfig_absolute_path;
        if( !$this->class_storage_file = tempnam($mosConfig_absolute_path.'/media/', 'vmt') ) {
          return false;
        }
      }
      
      if( file_exists($this->class_storage_file) && is_file($this->class_storage_file) ) {
        $tfp = fopen($this->class_storage_file, "w");
        $this->vmlogger = $vmLogger;
        $tfp = fopen($this->class_storage_file, "w");
        fputs($tfp, serialize($this));
        fclose($fp);
        fclose($tfp);
        mosredirect('index2.php?option=com_virtuemart&page=product.simple_csv_upload&temp='.basename($this->class_storage_file));
      }
    }
    
    /*
    if( !$php_version ) {
      $php_version = floatval(substr(phpversion(), 0, 3));
    }
    
    if ( $php_version >= 4.3 && !empty($this->enclosure) ) {
      $data = fgetcsv($fp, 8192, $this->csv_delimiter, $this->csv_enclosure);
    }
    else {
      $data = fgetcsv($fp, 8192, $this->csv_delimiter);
    }
    */
    
    if( $this->csv_enclosure != '' ) {
      $data = $this->fgetcsv($fp, 8192, $this->csv_delimiter, $this->csv_enclosure);
    }
    else {
      $data = $this->fgetcsv($fp, 8192, $this->csv_delimiter);
    }
    
    $this->line++;
    $line++;    
    //print_r($data);
    //echo '<br/><br/>';
    
    return $data;
  }
  
  
  
  
  
	
	/**
	* gets data from class data array
	* @name get_data
	* @param string field name
	* @param string value
	* @return array with data
	*  
	*/
	function get_data( $field = '', $value = '' ) {
		if ( empty($field) && empty($value) ) {
			return $this->data[$this->line];
		}
		/*
		else {		
			foreach( $this->data as $record ) {
				if( array_key_exists( $field, $record ) ) {
					array_search( $value );
				}
				else {
					return false;
				}
			}
		}
		*/			
	}
	
	/**
	* Function for write log messages
	* it can be used for standart VirtueMart logging lately
	*/
	function write_log ( $text, $data = '' ) {
		if( $data ) $text .= ' '.$data;
    $this->messages[$this->line][] = $text;
	}
	
	function read_log () {
		if( count($this->messages[$this->line]) )
		return implode("\n", $this->messages[$this->line]);
	}
	
	##################################################################################################
	## HANDLERS ## HANDLERS ## HANDLERS ## HANDLERS ## HANDLERS ## HANDLERS ## HANDLERS ## HANDLERS ##
	## HANDLERS ## HANDLERS ## HANDLERS ## HANDLERS ## HANDLERS ## HANDLERS ## HANDLERS ## HANDLERS ##
	## HANDLERS ## HANDLERS ## HANDLERS ## HANDLERS ## HANDLERS ## HANDLERS ## HANDLERS ## HANDLERS ##
	##################################################################################################
	
	/**
	* Manufacturer Category Handler
	* 
	* this module checks if manufacturer_category exists
	* than either add new manufacturer
	* either update existing
	* 
	* #__{vm}_manufacturer_category 
	* mf_category_id mf_category_name mf_category_desc
	*/
	function manufacturer_category() {
		//$csv_data = $this->get_data();
		$db = new ps_DB;
		
		$q  = "SELECT * FROM #__{vm}_manufacturer_category WHERE mf_category_name = '".$csv_data['mf_category_name']."'";	
		$db->SetQuery($q);
		if( $db->num_rows() ) $db_data = array_shift($db->loadAssocList());
		
		require_once( CLASSPATH.'ps_manufacturer_category.php' );
		$ps_manufacturer_category = new ps_manufacturer_category;
		
		if ( count($db_data) ) {
      foreach( $csv_data as $key => $value ) {
        $db_data[$key] = $value;
      }
      
      if( $ps_manufacturer_category->update( $csv_data ) ) {
        $this->write_log ('Категория производителей успешно обновлена.', $db_data['mf_category_name']);
      }
      else {
        $this->write_log('Категория производителей не была обновлена.', $db_data['mf_category_name']);
      }
		}
		else {
      if( $ps_manufacturer_category->add( $csv_data ) ) {
        $this->write_log ('Категория производителей успешно добавлена.', $csv_category['mf_category_name']);
      }
      else {
        $this->write_log('Категория производителей не была добавлена.', $csv_category['mf_category_name']);
      }
		}

    return true;
	}
	
	/**
	* Manufacturer Handler
	* 
	* this module checks if manufacturer exists
	* than either add new manufacturer
	* either update existing
	* 
	* #__{vm}_manufacturer
	* manufacturer_id mf_name mf_email mf_desc mf_category_id mf_url
	*/
	function manufacturer() {
		//$csv_manufacturer = $this->get_data();
		$db = new ps_DB;
		
		$q  = "SELECT * FROM #__{vm}_manufacturer WHERE mf_name = '".$csv_manufacturer['mf_name']."'";	
		$db->SetQuery($q);
		if( $db->num_rows() ) $db_manufacturer = array_shift($db->loadAssocList());
		
		require_once( CLASSPATH.'ps_manufacturer.php' );
		$ps_manufacturer = new ps_manufacturer;
		
		if ( count($db_manufacturer) ) {
      foreach( $csv_data as $key => $value ) {
        $db_data[$key] = $value;
      }
      $csv_data['manufacturer_id'] = $db_data['manufacturer_id'];
      
			if( $ps_manufacturer->update( $csv_manufacturer ) ) {
				$this->write_log('Производитель '.$db_manufacturer['manufacturer_id'].' успешно обновлен.');
			}
			else {
				$this->write_log('Производитель '.$db_manufacturer['manufacturer_id'].' не был обновлен.');
			}
		}
		else {
			if( $ps_manufacturer->add( $csv_manufacturer ) ) {
				$this->write_log('Производитель '.$csv_manufacturer['manufacturer_id'].' успешно добавлен.');
			}
			else {
				$this->write_log('Производитель не был добавлен.');
			}
		}

    return true;
	}
  
  /**
  * Category Handler
  *
  * this module checks if category exists
  * than either add new category
  * either update existing
  *
  * #__{vm}_category
  * category_id vendor_id category_name category_description category_thumb_image category_full_image category_publish cdate mdate category_browsepage products_per_row category_flypage list_order parent_category_id
  */   
  function category(&$csv_data) {
    //if( !$csv_data ) $csv_data = $this->get_data();
    $db = new ps_DB;

    if( !$csv_data['category_publish'] ) $csv_data['category_publish'] = 'Y';
    if( $csv_data['parent_category_id'] ) $csv_data['category_parent_id'] = $csv_data['parent_category_id'];
    if( $csv_data['category_thumb_image'] ) {
      $_REQUEST['category_thumb_image_curr'] = $csv_data['category_thumb_image'];
      if( !$csv_data['category_thumb_image_action'] ) $csv_data['category_thumb_image_action'] = 'none';
      if( !$csv_data['category_thumb_image_url'] ) $csv_data['category_thumb_image_url'] = '';
      unset($db_data['category_thumb_image']);
    }
    else {
      $_REQUEST['category_thumb_image_curr'] = '';
    }
        
    if( $csv_data['category_full_image'] ) {
      $_REQUEST['category_full_image_curr'] = $csv_data['category_full_image'];
      if( !$csv_data['category_full_image_action'] ) $csv_data['category_full_image_action'] = 'none';
      if( !$csv_data['category_full_image_url'] ) $csv_data['category_full_image_url'] = '';
      unset($db_data['category_full_image']);
    }
    else {
      $_REQUEST['category_full_image_curr'] = '';
    }

    // Отработка ситуаций когда выставлены номера категорий, а номера уже заняты удаленными категориями.
    /*
    if( !$this->option['no_truncate'] && !$this->option['first_category_occur'] ) {
      $this->option['first_category_occur'] = 1;
      $q  = "TRUNCATE TABLE #__{vm}_category";
      $db->SetQuery($q);
      if ( !$db->query() ) {
        $this->write_log('Невозможно очистить таблицу для обновления дерева категорий.');
        return false;
      }
      $q  = "TRUNCATE TABLE #__{vm}_category_xref";                             
      $db->SetQuery($q);
      if ( !$db->query() ) {
        $this->write_log('Невозможно очистить таблицу для обновления дерева категорий.');
        return false;
      }
    }
    */

    $q  = "SELECT * FROM #__{vm}_category INNER JOIN #__{vm}_category_xref ON category_id = child_category_id WHERE category_name = '".$csv_data['category_name']."' AND category_parent_id = '".intval($csv_data['category_parent_id'])."'";
    $db->SetQuery($q);
    if( $db->num_rows() ) $db_data = array_shift($db->loadAssocList());

    require_once( CLASSPATH.'ps_product_category.php' );
    $ps_product_category = new ps_product_category;

    if ( $this->action == 'delete' && count($db_data) ) {
      if( $ps_product_category->delete( $db_data ) ) {
        $this->write_log('Категория успешно удалена.', $db_data['category_id']);
        return true;
      }
      else {
        $this->write_log('Категория не была удалена.', $db_data['category_id']);
        return false;
      }
    }
    else {
      if ( count($db_data) ) {
        if( $db_data['category_thumb_image'] && !$csv_data['category_thumb_image'] ) {
          $_REQUEST['category_thumb_image_curr'] = $db_data['category_thumb_image'];
          unset($db_data['category_thumb_image']);
        }
        else {
          $_REQUEST['category_thumb_image_curr'] = '';
        }
        if( $db_data['category_full_image'] && !$csv_data['category_full_image'] ) {
          $_REQUEST['category_full_image_curr'] = $db_data['category_full_image'];
          unset($db_data['category_full_image']);
        }
        else {
          $_REQUEST['category_full_image_curr'] = '';
        }
        
        foreach( $csv_data as $key => $value ) {
          $db_data[$key] = $value;
        }
        $csv_data['category_id'] = $db_data['category_id'];
        
        if ( $ps_product_category->update( $db_data ) ) {
          $this->write_log('Категория '.$db_data['category_id'].' успешно обновлена.', $db_data['category_id'].'|'.$db_data['category_name'] );
          
        }
        else {
          $this->write_log('Категория '.$db_data['category_id'].' не была обновлена.', $db_data['category_id'].'|'.$db_data['category_name'] );
          return false;
        }
      }
      else {
        $db_data = $csv_data;
        if( $csv_data['category_id'] = $ps_product_category->add( $db_data ) ) {
          $this->write_log ('Категория '.$csv_data['category_id'].' успешно добавлена.', $csv_data['category_id'].'|'.$csv_data['category_name'] );
        }
        else {
          $this->write_log('Категория не была добавлена.', $csv_data['category_id'].'|'.$csv_data['category_name'] );
          return false;
        }
      }
    }
    
    if ( $this->option['_check_products'] ) {
      $this->num['categories'][] = $this->category[$csv_data['level']];
    }

    return true;
  } 
  
  /**
  * @desc Бьёт путь к категории по разделителю...
  * Возвращает массив c идентификаторами категорий
  */
  function category_proccess_path($paths) {
    $db = new ps_DB;
    
    $paths = explode('|', $paths);
    
    foreach($paths as $path) {
      // Уничтожаем завершающий слэш
      if( substr($path, -1) == '/' ) $path = substr($path, 0 , -1);
      // Спасаем экранированные слэши
      $path = str_replace('\/', '&#047;', $path);
      // Бьем на составляющие
      $path = explode('/', $path);
      for($i = 0; $i < count($path); $i++) {
        // Продолжаем спасать слэши
        $path[$i] = str_replace('&#047;', '/', $path[$i]);
        $categories[$i]['category_name'] = $path[$i];
        if( $path[$i - 1] ) $categories[$i]['parent_category_id'] = intval($categories[$i - 1]['category_id']);

        $q = "SELECT category_id FROM #__{vm}_category INNER JOIN #__{vm}_category_xref ON category_id = category_child_id WHERE category_name = '".$categories[$i]['category_name']."' AND category_parent_id = '".$categories[$i]['parent_category_id']."'";
        $db->query($q);
    
        if( !$db->num_rows() ) {  
          if( !$this->category($categories[$i]) ) break;
        }
        else {
          $categories[$i]['category_id'] = $db->loadResult();
        }
        
        if( $i == count($path) - 1 ) $result[] = $categories[$i]['category_id'];
      }
    }
    
    return $result;
  }
	
	/**
	* Product Handler
	* 
	* this module checks if product exists
	* than either add new product
	* either update existing
	* 
	* #__{vm}_product_type_parameter
	* product_type_id parameter_name parameter_label parameter_description parameter_list_order parameter_type parameter_values parameter_multiselect parameter_default parameter_unit
	*/
	function product(&$csv_data) {
    //if( !$csv_data ) $csv_data = $this->get_data();    
    $db = new ps_DB;
    
    // Обработка неуказанных полей
    if( !$csv_data['vendor_id'] && !$csv_data['vendor_id'] = $this->option['vendor_id'] ) {
      $q = "SELECT vendor_id FROM #__{vm}_vendor LIMIT 1";
      $db->query($q);
      $csv_data['vendor_id'] = $db->loadResult();
      
      if( !$csv_data['vendor_id'] ) {
        $this->write_log('Не найден стандартный продавец.');
      }
      else {
        $this->option['vendor_id'] = $csv_data['vendor_id'];
      }
    }      
    if( !$csv_data['shopper_group_id'] && !$csv_data['shopper_group_id'] = $this->option['shopper_group'] ) {
      $q = "SELECT shopper_group_id FROM #__{vm}_shopper_group WHERE `vendor_id` = '".$csv_data['vendor_id']."' AND `default` = '1'";
      $db->query($q);
      $csv_data['shopper_group_id'] = $db->loadResult();
      
      if( !$csv_data['shopper_group_id'] ) {
        $this->write_log('Не найдена стандартная группа покупателей.');
      }
      else {
        $this->option['shopper_group'] = $csv_data['shopper_group_id'];
      }
    }
    if( !$csv_data['product_available_date'] ) $csv_data['product_available_date'] = date('Y.m.d');
    if( !$csv_data['product_publish'] ) $csv_data['product_publish'] = 'Y';
    if( !$csv_data['products_per_row'] ) $csv_data['products_per_row'] = 2;
    if( $csv_data['product_thumb_image'] ) {
      $_REQUEST['product_thumb_image_curr'] = $csv_data['product_thumb_image'];
      if( !$csv_data['product_thumb_image_action'] ) $csv_data['product_thumb_image_action'] = 'none';
      if( !$csv_data['product_thumb_image_url'] ) $csv_data['product_thumb_image_url'] = '';
      unset($db_data['product_thumb_image']);
    }
    else {
      $_REQUEST['product_thumb_image_curr'] = '';
    }
    if( $csv_data['product_full_image'] ) {
      $_REQUEST['product_full_image_curr'] = $csv_data['product_full_image'];
      if( !$csv_data['product_full_image_action'] ) $csv_data['product_full_image_action'] = 'none';
      if( !$csv_data['product_full_image_url'] ) $csv_data['product_full_image_url'] = '';
      unset($db_data['product_full_image']);
    }
    else {
      $_REQUEST['product_full_image_curr'] = '';
    }
    //if( !$csv_data['products_per_row'] ) $csv_data['products_per_row'] = 2;
    if( $csv_data['category_path'] ) $csv_data['product_categories'] = $this->category_proccess_path($csv_data['category_path']);

		$q  = "SELECT * FROM #__{vm}_product WHERE product_sku = '".$csv_data['product_sku']."'";
		$db->query($q);
		if( $db->num_rows() ) $db_data = array_shift($db->loadAssocList());

		require_once( CLASSPATH.'ps_product.php' );
		$ps_product = new ps_product;

		if ( $this->action == 'delete' && count($db_data) ) {
			if( $ps_product->delete( $db_data ) ) {
				$this->write_log('Товар успешно удален.', $db_data['product_id'] );
			}
			else {
				$this->write_log('Товар не был удален.', $db_data['product_id'] );
			}
		}
		else {
			if ( count($db_data) ) {
        // Разруливаем картинки
        if( $db_data['product_thumb_image'] && !$csv_data['product_thumb_image'] ) {
          $_REQUEST['product_thumb_image_curr'] = $db_data['product_thumb_image'];
          unset($db_data['product_thumb_image']);
        }
        else {
          $_REQUEST['product_thumb_image_curr'] = '';
        }
        if( $db_data['product_full_image'] && !$csv_data['product_full_image'] ) {
          $_REQUEST['product_full_image_curr'] = $db_data['product_full_image'];
          unset($db_data['product_full_image']);
        }
        else {
          $_REQUEST['product_full_image_curr'] = '';
        }        
        
        $csv_data['product_id'] = $db_data['product_id'];
        
        // Обрабатываем ли типы и параметры, проверяем на наличие связи товар-тип и создаем её в случае отстутсвия
        if( is_array($csv_data['product_types']) && $csv_data['product_id'] ) {
          foreach( $csv_data['product_types'] as $csv_type ) { 
            if( $csv_type['value'] == '' ) continue;
                       
            if( $this->ptp( $csv_data, $csv_type ) ) {
              // формируем массив с параметрами правильно
              $csv_data['product_type_'.$csv_type['product_type_id'].'_'.$csv_type['parameter_name']] = $csv_type['value'];
            }
          }
        }
        
        // Присваиваем значения выборке из базы
        foreach( $csv_data as $key => $value ) {
          $db_data[$key] = $value;
        }        
        
        if( $ps_product->update( $db_data ) ) {
					$this->write_log('Товар успешно обновлен.', $db_data['product_id'].'|'.$db_data['product_name'] );
				}
				else {
					$this->write_log('Товар не был обновлен.', $db_data['product_id'].'|'.$db_data['product_name'] );
				}
			}
			else {
				if( $csv_data['category_id'] = $ps_product->add( $csv_data ) ) {
					$this->write_log ('Товар успешно добавлен.', $csv_data['category_id'].'|'.$csv_data['product_name'] );
          $this->product($csv_data);
				}
				else {
					$this->write_log('Товар не был добавлен.', $csv_data['category_id'].'|'.$csv_data['product_name'] );
				}
			}
		}

    if ( $this->option['check_products'] ) {
      $this->sku[] = addslashes($csv_data['product_sku']);
    }

		// Если добавление или обновление прошло успешно - обрабатываем доп поля
		// В первую очередь это привязка к типам, параметры и цены для разных групп	
    if( is_array($csv_data['product_prices']) && $csv_data['product_id'] ) {
      foreach( $csv_data['product_prices'] as $csv_price ) {
        $this->price( $csv_data, $csv_price );
      }
    }
		
    // Если в составе колонок есть type_id type_name то обрабатываем на привязку к типам
		// Привязка к типам
		// Проверяем привязан ли данный товар к типам
		// Если привязан берем
    /*
    if( is_array($csv_data['product_types']) && $csv_data['product_id'] ) {
      foreach( $csv_data['product_types'] as $csv_type ) {
        $this->parameters( $csv_data, $csv_type );
      }
    }
    */
    
    return true;
	}
  
  function price( $csv_product, $csv_price ) {    
    $db = new ps_DB; 
    require_once(CLASSPATH.'ps_product_price.php');
    $ps_product_price = new ps_product_price;
    
    // Values
    if( !$csv_price['product_id'] ) $csv_price['product_id'] = $csv_product['product_id'];
    if( !$csv_price['product_price'] ) $csv_price['product_price'] = $csv_price['value'];
    if( !$csv_price['product_currency'] ) $csv_price['product_currency'] = $_SESSION['vendor_currency'];
    if( !$csv_price['price_quantity_start'] ) $csv_price["price_quantity_start"] = 0;
    if( !$csv_price['price_quantity_end'] ) $csv_price["price_quantity_end"] = 0;

    // Находим shopper_group_id
    if( !$csv_price['shopper_group_id'] && $csv_price['shopper_group_name'] ) {
      $q = "SELECT shopper_group_id FROM #__{vm}_shopper_group WHERE shopper_group_name = '".$csv_price['shopper_group_name']."'";
      $db->SetQuery($q);
      $csv_price['shopper_group_id'] = $db->loadResult();
      if( !$csv_price['shopper_group_id'] ) {
        $this->write_log('Указанная группа пользователей - '.$csv_price['shopper_group_name'].' не найдена.');
        return false;
      }
    }

    //Проверяем есть ли такая цена и либо обновляем либо добавляем
    $q  = "SELECT * FROM #__{vm}_product_price ";
    $q .= "WHERE product_id = '".$csv_product['product_id']."' ";
    $q .= "AND product_currency = '".$csv_price['product_currency']."' ";
    $q .= "AND shopper_group_id = '".$csv_price['shopper_group_id']."' ";
    $q .= "AND price_quantity_start = '".$csv_price['price_quantity_start']."' ";
    $q .= "AND price_quantity_end = '".$csv_price['price_quantity_end']."' ";
    $db->SetQuery($q);
    if( $db->num_rows() ) $db_price = array_shift($db->loadAssocList());

    // Формируем данные для массива цены
    if( $db_price ) {
      $product_price = $db_price;
      foreach($csv_price as $key => $value) {
        $product_price[$key] = $value;
      }

      if( $ps_product_price->update($product_price) ){
        $this->write_log ('Цена успешно обновлена.', $product_price['shopper_group_id'].'|'.$product_price['product_price'] );
      }
      else {
        $this->write_log('Цена не была обновлена.', $product_price['shopper_group_id'].'|'.$product_price['product_price'].' '.$product_price['error'] );
      }
    }
    else {
      $product_price = $csv_price;
      if( $ps_product_price->add($product_price) ){
        $this->write_log ('Новая цена успешно добавлена.', $product_price['shopper_group_id'].'|'.$product_price['product_price'] );
      }
      else {
        $this->write_log('Новая цена не была добавлена.', $product_price['shopper_group_id'].'|'.$product_price['product_price'].' '.$product_price['error'] );
      }
    }
  }
  
  function ptp( $csv_product, &$csv_type ) {
    $db = new ps_DB; 
    
    // Берем тип с указанным именем, если такого нет, то следующая запись
    $q = "SELECT * FROM #__{vm}_product_type WHERE product_type_name = '".$csv_type['product_type_name']."'";
    $db->query($q);
    if( $db->num_rows() ) $db_type = array_shift($db->loadAssocList());
    
    if( !$db_type ) {
      $this->write_log('Указанный тип - '.$csv_type['product_type_name'].' не найден.');
      return false;
    }     
    
    $csv_type['product_id'] = $csv_product['product_id'];
    $csv_type['product_type_id'] = $db_type['product_type_id'];
    
    // Проверяем присоединен ли тип к этому товару, если нет, то добавляем связь
    $q = "SELECT * FROM #__{vm}_product_product_type_xref WHERE product_id = '".$csv_product['product_id']."' AND product_type_id = '".$csv_type['product_type_id']."'";
    $db->query($q);
    
    if( !$db->num_rows() ) {
      require_once(CLASSPATH.'ps_product_product_type.php');
      $ps_product_poduct_type = new ps_product_product_type;
      
      if( $ps_product_poduct_type->add( $csv_type ) ) {
        $this->write_log('Новая связь товар-тип успешно добавлена.', $csv_type['product_id'].':'.$csv_type['product_type_id']);
      }
      else {                                                                                                                       
        $this->write_log('Новая связь связь товар-тип не была добавлена.', $csv_type['product_id'].':'.$csv_type['product_type_id']);
        return false;
      }
    }  
    
    // Нам нужно имя параметра в базе
    if( !$csv_type['parameter_name'] ) {
      $q = "SELECT parameter_name FROM #__{vm}_product_type_parameter WHERE product_type_id = '".$csv_type['product_type_id']."' AND (parameter_name = '".$csv_type['product_parameter_name']."' OR parameter_label = '".$csv_type['product_parameter_name']."')";
      $db->query($q);
      
      $csv_type['parameter_name'] = $db->loadResult();
      if( !$csv_type['parameter_name'] ) {
        $this->write_log('Параметр с указанным именем в данном типе не найден.', $db_type['product_type_name'].'|'.$csv_type['product_parameter_name']);
        return false;
      }
    }
    
    return true;
  }
  
	/**
	* Product Type Handler
	* 
	* this module checks if product type exists
	* than either add new type
	* either update existing
	* 
	* #__{vm}_product_type
	* product_type_id product_type_name product_type_description product_type_publish product_type_browsepage product_type_flypage  product_type_list_order
	*/      
	function product_type(&$csv_data) {
		//if(!$csv_data) $csv_data = $this->get_data();
    $db = new ps_DB;
		
    if( !$csv_data['product_type_publish'] ) $csv_data['product_type_publish'] = 'Y';
		
		$q  = "SELECT * FROM #__{vm}_product_type WHERE product_type_name = '".$csv_data['product_type_name']."'";	
		$db->SetQuery($q);
		if( $db->num_rows() ) $db_data = array_shift($db->loadAssocList());
		
		require_once( CLASSPATH.'ps_product_type.php' );
		$ps_product_type = new ps_product_type;
		
		if ( $this->action == 'delete' && count($db_data) ) {
			if( $ps_product_type->delete( $db_data ) ) {
				$this->write_log('Тип '.$db_data['category_id'].' успешно удален.');
			}
			else {
				$this->write_log('Тип '.$db_data['category_id'].' не был удален.');
			}
		}
		else {		
			if ( count($db_data) ) {        
        foreach( $csv_data as $key => $value ) {
          $db_data[$key] = $value;
        }
        $csv_data['product_type_id'] = $db_data['product_type_id'];
        
				if( $ps_product_type->update( $db_data ) ) {
					$this->write_log('Тип '.$db_data['product_type_id'].' успешно обновлен.');
				}
				else {
					$this->write_log('Тип '.$db_data['product_type_id'].' не был обновлен.');
				}
			}
			else {
				if( $csv_data['product_type_id'] = $ps_product_type->add( $csv_data ) ) {
					$this->write_log ('Тип '.$csv_data['product_type_id'].' успешно добавлен.');
				}
				else {
					$this->write_log('Тип не был добавлен.');
				}
			}
		}		
    
    return true;	
	}
	
	/**
	* Product Type Parameter Handler
	* 
	* this module checks if product type parameter exists
	* than either add new parameter
	* either update existing
	* 
	* #__{vm}_product_type_parameter
	* product_type_id parameter_name parameter_label parameter_description parameter_list_order parameter_type parameter_values parameter_multiselect parameter_default parameter_unit
	*/
	function product_type_parameter(&$csv_data) {
		//$csv_data = $this->get_data();    
		$db = new ps_DB;
    
    if ( !$csv_data['product_type_id'] ) {
      if( $csv_data['product_type_name'] ) {
        $q  = "SELECT product_type_id FROM #__{vm}_product_type WHERE product_type_name = '".$csv_data['product_type_name']."'";  
        $db->SetQuery($q);
        $csv_data['product_type_id'] = $db->loadResult();
        
        if( !intval($csv_data['product_type_id']) ) $this->product_type($csv_data);
      }
      
      if( !intval($csv_data['product_type_id']) ) {
        $this->write_log('Неправильный номер типа. Пропускаем строку.');
        return false;
      }
    }  
          
		$q  = "SELECT * FROM #__{vm}_product_type_parameter WHERE product_type_id = '".intval($csv_data['product_type_id'])."' AND (parameter_name = '".$csv_data['parameter_name']."' OR parameter_label = '".$csv_data['parameter_label']."')";	
		$db->SetQuery($q);
		if( $db->num_rows() ) $db_data = array_shift($db->loadAssocList());
		
		require_once( CLASSPATH.'ps_product_type.php' );
		$ps_product_type_parameter = new ps_product_type_parameter;
		
		if ( $this->action == 'delete' && count($db_data) ) {
			if( $ps_product_type_parameter->delete_parameter( $db_data ) ) {
				$this->write_log('Параметр успешно удален.', $db_data['parameter_name']);
			}
			else {
				$this->write_log('Параметр не был удален.', $db_data['parameter_name']);
			}
		}
		else {		
			if ( count($db_data) ) {
        $db_data['parameter_old_name'] = $db_data['parameter_name'];
        foreach( $csv_data as $key => $value ) {
          $db_data[$key] = $value;
        }                                                      
        
				if( $ps_product_type_parameter->update_parameter( $db_data ) ) {
					$this->write_log('Параметр успешно обновлен.', $db_data['product_type_id'].'|'.$db_data['parameter_name']);
				}
				else {
					$this->write_log('Параметр не был обновлен.', $db_data['error'].' '.$db_data['product_type_id'].'|'.$db_data['parameter_name']);
				}
			}
			else {
				if( $ps_product_type_parameter->add_parameter( $csv_data ) ) {
					$this->write_log ('Параметр успешно добавлен.', $csv_data['product_type_id'].'|'.$csv_data['parameter_name']);
				}
				else {
					$this->write_log('Параметр не был добавлен.', $csv_data['product_type_id'].'|'.$csv_data['parameter_name']);
				}
			}
		}	
    
    return true;		
	}

	##################################################################################################
	## HANDLERS ## HANDLERS ## HANDLERS ## HANDLERS ## HANDLERS ## HANDLERS ## HANDLERS ## HANDLERS ##
	##################################################################################################

  // MISC FUNCTIONS
  // MISC FUNCTIONS
  // MISC FUNCTIONS
  function t_getmicrotime() {
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
  } 

  function t_pagetime($type) {
    static $orig_time;
    if($type=="init") $orig_time = $this->t_getmicrotime();
    if($type=="print") return sprintf("%2.4f", $this->t_getmicrotime() - $orig_time);
  }
  
  function fgetcsv($f_handle, $length, $delimiter=',', $enclosure='"') {
    if (!strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
      return fgetcsv($f_handle, $length, $delimiter, $enclosure);
    if (!$f_handle || feof($f_handle))
      return false;
           
    if (strlen($delimiter) > 1)
      $delimiter = substr($delimiter, 0, 1);
    elseif (!strlen($delimiter))          // There _MUST_ be a delimiter
      return false;
                       
    if (strlen($enclosure) > 1)         // There _MAY_ be an enclosure
      $enclosure = substr($enclosure, 0, 1);
                       
    $line = fgets($f_handle, $length);
    if (!$line)
        return false;
    $result = array();
    $csv_fields = explode($delimiter, trim($line));
    $csv_field_count = count($csv_fields);
    $encl_len = strlen($enclosure);
    for ($i=0; $i<$csv_field_count; $i++) {
      // Removing possible enclosures
      if ($encl_len && $csv_fields[$i]{0} == $enclosure) $csv_fields[$i] = substr($csv_fields[$i], 1);
      if ($encl_len && $csv_fields[$i]{strlen($csv_fields[$i])-1} == $enclosure) $csv_fields[$i] = substr($csv_fields[$i], 0, strlen($csv_fields[$i])-1);
      // Double enclosures are just original symbols
      $csv_fields[$i] = str_replace($enclosure.$enclosure, $enclosure, $csv_fields[$i]);
      $result[] = $csv_fields[$i];
    }
    return $result;
  }  
}

?>