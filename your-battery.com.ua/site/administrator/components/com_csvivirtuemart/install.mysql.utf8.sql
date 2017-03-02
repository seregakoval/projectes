-- CSVI VirtueMart templates --
CREATE TABLE IF NOT EXISTS `#__csvivirtuemart_templates` (
	`template_id` tinyint(2) NOT NULL auto_increment,
	`template_name` varchar(255) NOT NULL default '',
	`template_type` varchar(50) NOT NULL,
	`skip_first_line` tinyint(1) NOT NULL default '0',
	`use_column_headers` tinyint(1) NOT NULL default '0',
	`collect_debug_info` tinyint(1) NOT NULL default '0',
	`overwrite_existing_data` tinyint(1) NOT NULL default '1',
	`skip_default_value` tinyint(1) NOT NULL default '0',
	`show_preview` tinyint(1) NOT NULL default '0',
	`include_column_headers` tinyint(1) NOT NULL default '0',
	`text_enclosure` varchar(2) NOT NULL default '~',
	`field_delimiter` varchar(2) NOT NULL default '^',
	`export_type` varchar(10) NOT NULL default 'csv',
	`export_site` varchar(255) default NULL,
	`thumb_width` int(4) default '0',
	`thumb_height` int(4) default '0',
	`shopper_group_id` int(4) unsigned default NULL,
	`producturl_suffix` varchar(255) default NULL,
	`file_location_product_images` varchar(255) default NULL,
	`file_location_category_images` varchar(255) default NULL,
	`file_location_media` varchar(255) default NULL,
	`file_location_export_files` varchar(255) default NULL,
	`product_publish` varchar(1) default NULL,
	`max_execution_time` int(4) default NULL,
	`max_input_time` int(4) default NULL,
	`memory_limit` int(4) default NULL,
	`post_max_size` int(4) default NULL,
	`upload_max_filesize` int(4) default NULL,
	`export_filename` varchar(255) default NULL,
	`manufacturer` varchar(255) default NULL,
	`thumb_create` tinyint(1) NOT NULL,
	`ignore_non_exist` tinyint(1) NOT NULL,
	`thumb_extension` enum('none','jpg','gif','png') NOT NULL default 'none',
	`append_categories` tinyint(1) NOT NULL default '0',
	`export_date_format` varchar(25) default 'd/m/Y H:i:s',
	`use_system_limits` tinyint(1) NOT NULL default '0',
	`add_currency_to_price` tinyint(1) unsigned NOT NULL default '0',
	`export_email` tinyint(1) NOT NULL default '0',
	`export_email_addresses` text,
	`export_email_subject` varchar(255) NOT NULL default '',
	`export_email_body` text,
	`auto_generate_image_name` tinyint(1) NOT NULL default '0',
	`export_email_addresses_cc` text,
	`export_email_addresses_bcc` text,
	`save_images_on_server` tinyint(1) NOT NULL default '0',
	`auto_generate_image_name_ext` enum('none','jpg','gif','png') NOT NULL default 'none',
	`unpublish_before_import` tinyint(1) NOT NULL default '0',
	`vm_itemid` int(11) NOT NULL default '1',
	`auto_detect_delimiters` tinyint(1) NOT NULL default '1',
	`export_frontend` tinyint(1) NOT NULL default '0',
	`export_price_format` VARCHAR(25) NULL DEFAULT '%01.2f',
	PRIMARY KEY  (`template_id`),
	UNIQUE KEY `name` (`template_name`)
) CHARSET=utf8 COMMENT='Templates for CSVI VirtueMart';

-- CSVI VirtueMart template fields --
CREATE TABLE IF NOT EXISTS `#__csvivirtuemart_template_fields` (
  `id` int(11) NOT NULL auto_increment,
  `field_template_id` int(11) NOT NULL default '0',
  `field_name` varchar(128) NOT NULL default '',
  `field_column_header` varchar(128) NOT NULL default '',
  `field_default_value` text,
  `field_order` int(3) NOT NULL default '0',
  `field_replace` tinyint(1) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) CHARSET=utf8 COMMENT='Template fields for CSVI VirtueMart';

-- CSVI VirtueMart template types
CREATE TABLE IF NOT EXISTS  `#__csvivirtuemart_template_types` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `template_type_name` varchar(55) NOT NULL,
  `template_type` varchar(55) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `type_name` (`template_type_name`,`template_type`)
) CHARSET=utf8 COMMENT='Template types for CSVI VirtueMart';

INSERT IGNORE INTO `#__csvivirtuemart_template_types` (`template_type_name`, `template_type`) VALUES
('categorydetailsexport', 'export'),
('categorydetailsimport', 'import'),
('couponsexport', 'export'),
('couponsimport', 'import'),
('manufacturercategoryimport', 'import'),
('manufacturerexport', 'export'),
('manufacturerimport', 'import'),
('multiplepricesexport', 'export'),
('multiplepricesimport', 'import'),
('orderexport', 'export'),
('productexport', 'export'),
('productfilesexport', 'export'),
('productfilesimport', 'import'),
('productimport', 'import'),
('productreviewsexport', 'export'),
('productreviewsimport', 'import'),
('productstockimport', 'import'),
('producttypeexport', 'export'),
('producttypeimport', 'import'),
('producttypenamesexport', 'export'),
('producttypenamesimport', 'import'),
('producttypeparametersexport', 'export'),
('producttypeparametersimport', 'import'),
('shippingratesexport', 'export'),
('shippingratesimport', 'import'),
('templateexport', 'export'),
('templatefieldsexport', 'export'),
('templatefieldsimport', 'import'),
('templateimport', 'import'),
('userfieldsexport', 'export'),
('userfieldsimport', 'import'),
('userinfoexport', 'export'),
('userinfoimport', 'import');

-- CSVI VirtueMart logs --
CREATE TABLE IF NOT EXISTS `#__csvivirtuemart_logs` (
  `id` int(11) NOT NULL auto_increment,
  `userid` int(11) NOT NULL,
  `logstamp` datetime NOT NULL,
  `action` varchar(255) NOT NULL,
  `action_type` varchar(255) NOT NULL default '',
  `template_name` varchar(255) NULL default NULL,
  `records` int(11) NOT NULL,
  `import_id` INT(11) NULL DEFAULT NULL,
  `file_name` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY  (`id`)
) CHARSET=utf8 COMMENT='Logging results for CSVI VirtueMart';

-- CSVI VirtueMart log details --
CREATE TABLE IF NOT EXISTS `#__csvivirtuemart_log_details` (
  `id` int(11) NOT NULL auto_increment,
  `log_id` int(11) NOT NULL,
  `line` INT(11) NOT NULL,
  `description` TEXT NOT NULL,
  `result` varchar(45) NOT NULL,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) CHARSET=utf8 COMMENT='Log details for CSVI VirtueMart';

-- CSVI VirtueMart available fields --
CREATE TABLE IF NOT EXISTS `#__csvivirtuemart_available_fields` (
  `id` int(11) NOT NULL auto_increment,
  `csvi_name` varchar(255) NOT NULL,
  `vm_name` varchar(55) NOT NULL,
  `vm_table` varchar(55) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `vm_name_table` (`vm_name`,`vm_table`)
) CHARSET=utf8 COMMENT='Available fields for CSVI VirtueMart';

-- CSVI VirtueMart currency table --
CREATE TABLE IF NOT EXISTS  `#__csvivirtuemart_currency` (
  `currency_id` tinyint(4) NOT NULL auto_increment,
  `currency_code` varchar(3) NULL DEFAULT NULL,
  `currency_rate` varchar(55) NULL DEFAULT NULL,
  PRIMARY KEY  (`currency_id`),
  UNIQUE KEY `currency_code` (`currency_code`)
) CHARSET=utf8 COMMENT='Curriencies and exchange rates for CSVI VirtueMart';

-- CSVI VirtueMart replacement table --
CREATE TABLE IF NOT EXISTS `#__csvivirtuemart_replacements` (
  `id` int(10) NOT NULL auto_increment,
  `old_value` varchar(255) NOT NULL default '',
  `new_value` varchar(255) NOT NULL default '',
  `published` int(1) NOT NULL default '0',
  `regex` tinyint(1) NOT NULL default '0',
  `template_id` int(11) NOT NULL default '0',
  `field_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) CHARSET=utf8 COMMENT='Replacement values for CSVI VirtueMart';

-- CSVI VirtueMart settings table --
CREATE TABLE IF NOT EXISTS `#__csvivirtuemart_settings` (
	`id` INT(11) NOT NULL auto_increment,
	`params` TEXT NOT NULL,
	PRIMARY KEY (`id`)
) CHARSET=utf8 COMMENT='Configuration values for CSVI VirtueMart';

-- CSVI VirtueMart insert default value --
INSERT IGNORE INTO `#__csvivirtuemart_settings` (`id`, `params`) VALUES (1, 'hostname=
csvi_license_key=
log_store=1
category_separator=/
import_nolines=0
import_preview=5
import_wait=5
gb_title=
gb_link=
gb_description=');
