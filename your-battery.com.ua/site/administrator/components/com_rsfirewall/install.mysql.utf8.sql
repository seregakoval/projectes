CREATE TABLE IF NOT EXISTS `#__rsfirewall_configuration` (
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `#__rsfirewall_configuration` (`name`, `value`) VALUES
('master_password', ''),
('master_password_enabled', '0'),
('blacklist_ips', ''),
('active_scanner_status', '1'),
('verify_sql', '1'),
('verify_js', '1'),
('verify_sql_skip', ''),
('verify_js_skip', ''),
('verify_upload', '1'),
('verify_upload_skip', ''),
('verify_upload_blacklist_exts', 'php\r\njs\r\nexe\r\ncom\r\nbat\r\ncmd\r\nmp3'),
('monitor_core', '1'),
('monitor_files', ''),
('monitor_users', ''),
('backend_access_control_enabled', '0'),
('backend_access_users', ''),
('backend_access_components', ''),
('backend_password_enabled', '0'),
('backend_password', ''),
('backend_whitelist_ips', ''),
('log_emails', 'admin@localhost'),
('log_alert_level', 'medium'),
('log_history', '30'),
('log_overview', '5'),
('lockdown', '0'),
('verify_dos', '1'),
('verify_agents', '1'),
('verify_multiple_exts', '1'),
('verify_php', '1'),
('verify_php_skip', ''),
('global_register_code', ''),
('verify_generator', '1'),
('grade', '0'),
('verify_emails', '0'),
('offset', '300'),
('backend_captcha', '3');

CREATE TABLE IF NOT EXISTS `#__rsfirewall_feeds` (
  `id` int(11) NOT NULL auto_increment,
  `url` text NOT NULL,
  `limit` tinyint(4) NOT NULL,
  `ordering` int(11) NOT NULL,
  `published` enum('0','1') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `#__rsfirewall_feeds` (`id`, `url`, `limit`, `ordering`, `published`) VALUES
(1, 'http://feeds.joomla.org/JoomlaSecurityNews', 5, 1, '1');

CREATE TABLE IF NOT EXISTS `#__rsfirewall_hashes` (
  `id` int(11) NOT NULL auto_increment,
  `file` text NOT NULL,
  `hash` varchar(32) NOT NULL,
  `type` varchar(64) NOT NULL,
  `flag` varchar(1) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `#__rsfirewall_hashes` (`file`, `hash`, `type`, `flag`, `date`) VALUES
('plugins/user/joomla.php', 'da5f32c68af1522847d6f740a44ea99e', '1.5.3', '', 0),
('plugins/authentication/joomla.php', 'db8601e150257d4b97307988e649eed0', '1.5.3', '', 0),
('index.php', '7100c16ea1d781f17eaaf06f47cf925f', '1.5.3', '', 0),
('index2.php', '3f1e067d30f43a585d0efff44868d3f1', '1.5.3', '', 0),

('plugins/user/joomla.php', '8d50d3a493ec9b6c8d0e416d95355334', '1.5.4', '', 0),
('plugins/authentication/joomla.php', 'cb7821ec3a5ea4eb409370721da757c9', '1.5.4', '', 0),
('index.php', '989f5281f21f2c79fafe69538a0ab9b4', '1.5.4', '', 0),
('index2.php', '32514970cefd9f8dc400d7269d2508c0', '1.5.4', '', 0),

('plugins/user/joomla.php', '8d50d3a493ec9b6c8d0e416d95355334', '1.5.6', '', 0),
('plugins/authentication/joomla.php', 'cb7821ec3a5ea4eb409370721da757c9', '1.5.6', '', 0),
('index.php', '989f5281f21f2c79fafe69538a0ab9b4', '1.5.6', '', 0),
('index2.php', '32514970cefd9f8dc400d7269d2508c0', '1.5.6', '', 0),

('plugins/user/joomla.php', '6f6185b42984b517c46dc32aa1c0872d', '1.5.7', '', 0),
('plugins/authentication/joomla.php', '30b888e91929bba7bb00fb843895ece5', '1.5.7', '', 0),
('index.php', '989f5281f21f2c79fafe69538a0ab9b4', '1.5.7', '', 0),
('index2.php', '32514970cefd9f8dc400d7269d2508c0', '1.5.7', '', 0),

('plugins/user/joomla.php', 'b18b9af850f92661af641f6731738301', '1.5.8', '', 0),
('plugins/authentication/joomla.php', '30b888e91929bba7bb00fb843895ece5', '1.5.8', '', 0),
('index.php', '989f5281f21f2c79fafe69538a0ab9b4', '1.5.8', '', 0),
('index2.php', '32514970cefd9f8dc400d7269d2508c0', '1.5.8', '', 0),

('plugins/user/joomla.php', 'b18b9af850f92661af641f6731738301', '1.5.9', '', 0),
('plugins/authentication/joomla.php', '30b888e91929bba7bb00fb843895ece5', '1.5.9', '', 0),
('index.php', '9a5d10287c94d0c7dd3c1f09d1bceb88', '1.5.9', '', 0),
('index2.php', 'ee02816fd90e37ca9d263af9492cc0fe', '1.5.9', '', 0),

('plugins/user/joomla.php', 'b18b9af850f92661af641f6731738301', '1.5.10', '', 0),
('plugins/authentication/joomla.php', '30b888e91929bba7bb00fb843895ece5', '1.5.10', '', 0),
('index.php', '9a5d10287c94d0c7dd3c1f09d1bceb88', '1.5.10', '', 0),
('index2.php', 'ee02816fd90e37ca9d263af9492cc0fe', '1.5.10', '', 0),

('plugins/user/joomla.php', 'b18b9af850f92661af641f6731738301', '1.5.11', '', 0),
('plugins/authentication/joomla.php', '30b888e91929bba7bb00fb843895ece5', '1.5.11', '', 0),
('index.php', '9a5d10287c94d0c7dd3c1f09d1bceb88', '1.5.11', '', 0),
('index2.php', 'ee02816fd90e37ca9d263af9492cc0fe', '1.5.11', '', 0),

('plugins/user/joomla.php', 'b18b9af850f92661af641f6731738301', '1.5.12', '', 0),
('plugins/authentication/joomla.php', '30b888e91929bba7bb00fb843895ece5', '1.5.12', '', 0),
('index.php', '9a5d10287c94d0c7dd3c1f09d1bceb88', '1.5.12', '', 0),
('index2.php', 'ee02816fd90e37ca9d263af9492cc0fe', '1.5.12', '', 0),

('plugins/user/joomla.php', 'b18b9af850f92661af641f6731738301', '1.5.13', '', 0),
('plugins/authentication/joomla.php', '30b888e91929bba7bb00fb843895ece5', '1.5.13', '', 0),
('index.php', '9a5d10287c94d0c7dd3c1f09d1bceb88', '1.5.13', '', 0),
('index2.php', 'ee02816fd90e37ca9d263af9492cc0fe', '1.5.13', '', 0),

('plugins/user/joomla.php', 'b18b9af850f92661af641f6731738301', '1.5.14', '', 0),
('plugins/authentication/joomla.php', '30b888e91929bba7bb00fb843895ece5', '1.5.14', '', 0),
('index.php', '9a5d10287c94d0c7dd3c1f09d1bceb88', '1.5.14', '', 0),
('index2.php', 'ee02816fd90e37ca9d263af9492cc0fe', '1.5.14', '', 0),

('plugins/user/joomla.php', 'b18b9af850f92661af641f6731738301', '1.5.15', '', 0),
('plugins/authentication/joomla.php', '30b888e91929bba7bb00fb843895ece5', '1.5.15', '', 0),
('index.php', '9a5d10287c94d0c7dd3c1f09d1bceb88', '1.5.15', '', 0),
('index2.php', 'ee02816fd90e37ca9d263af9492cc0fe', '1.5.15', '', 0),

('plugins/user/joomla.php', '5b1888530e4b6145432a1ca222b260f4', '1.5.16', '', 0),
('plugins/authentication/joomla.php', '3ddeac53c763b35f9c5c8bb0b84ca2b9', '1.5.16', '', 0),
('index.php', '31fa74772d49e0c661ce8ee28f52b590', '1.5.16', '', 0),
('index2.php', '3308fcb80865094c324d381f3d7f1bec', '1.5.16', '', 0),

('plugins/user/joomla.php', '5b1888530e4b6145432a1ca222b260f4', '1.5.17', '', 0),
('plugins/authentication/joomla.php', '3ddeac53c763b35f9c5c8bb0b84ca2b9', '1.5.17', '', 0),
('index.php', '31fa74772d49e0c661ce8ee28f52b590', '1.5.17', '', 0),
('index2.php', '3308fcb80865094c324d381f3d7f1bec', '1.5.17', '', 0),

('plugins/user/joomla.php', '5b1888530e4b6145432a1ca222b260f4', '1.5.18', '', 0),
('plugins/authentication/joomla.php', '3ddeac53c763b35f9c5c8bb0b84ca2b9', '1.5.18', '', 0),
('index.php', '31fa74772d49e0c661ce8ee28f52b590', '1.5.18', '', 0),
('index2.php', '3308fcb80865094c324d381f3d7f1bec', '1.5.18', '', 0),

('plugins/user/joomla.php', '5b1888530e4b6145432a1ca222b260f4', '1.5.19', '', 0),
('plugins/authentication/joomla.php', '3ddeac53c763b35f9c5c8bb0b84ca2b9', '1.5.19', '', 0),
('index.php', '31fa74772d49e0c661ce8ee28f52b590', '1.5.19', '', 0),
('index2.php', '3308fcb80865094c324d381f3d7f1bec', '1.5.19', '', 0),

('plugins/user/joomla.php', '5b1888530e4b6145432a1ca222b260f4', '1.5.20', '', 0),
('plugins/authentication/joomla.php', '3ddeac53c763b35f9c5c8bb0b84ca2b9', '1.5.20', '', 0),
('index.php', '31fa74772d49e0c661ce8ee28f52b590', '1.5.20', '', 0),
('index2.php', '3308fcb80865094c324d381f3d7f1bec', '1.5.20', '', 0),

('plugins/user/joomla.php', '5b1888530e4b6145432a1ca222b260f4', '1.5.21', '', 0),
('plugins/authentication/joomla.php', '3ddeac53c763b35f9c5c8bb0b84ca2b9', '1.5.21', '', 0),
('index.php', '31fa74772d49e0c661ce8ee28f52b590', '1.5.21', '', 0),
('index2.php', '3308fcb80865094c324d381f3d7f1bec', '1.5.21', '', 0),

('plugins/user/joomla.php', '5b1888530e4b6145432a1ca222b260f4', '1.5.22', '', 0),
('plugins/authentication/joomla.php', '3ddeac53c763b35f9c5c8bb0b84ca2b9', '1.5.22', '', 0),
('index.php', '31fa74772d49e0c661ce8ee28f52b590', '1.5.22', '', 0),
('index2.php', '3308fcb80865094c324d381f3d7f1bec', '1.5.22', '', 0),

('plugins/user/joomla.php', '5b1888530e4b6145432a1ca222b260f4', '1.5.23', '', 0),
('plugins/authentication/joomla.php', '3ddeac53c763b35f9c5c8bb0b84ca2b9', '1.5.23', '', 0),
('index.php', '31fa74772d49e0c661ce8ee28f52b590', '1.5.23', '', 0),
('index2.php', '3308fcb80865094c324d381f3d7f1bec', '1.5.23', '', 0),

('plugins/user/joomla.php', '5b1888530e4b6145432a1ca222b260f4', '1.5.24', '', 0),
('plugins/authentication/joomla.php', '3ddeac53c763b35f9c5c8bb0b84ca2b9', '1.5.24', '', 0),
('index.php', '31fa74772d49e0c661ce8ee28f52b590', '1.5.24', '', 0),
('index2.php', '3308fcb80865094c324d381f3d7f1bec', '1.5.24', '', 0),

('plugins/user/joomla.php', '5b1888530e4b6145432a1ca222b260f4', '1.5.25', '', 0),
('plugins/authentication/joomla.php', '3ddeac53c763b35f9c5c8bb0b84ca2b9', '1.5.25', '', 0),
('index.php', '31fa74772d49e0c661ce8ee28f52b590', '1.5.25', '', 0),
('index2.php', '3308fcb80865094c324d381f3d7f1bec', '1.5.25', '', 0),

('plugins/user/joomla/joomla.php', '6b2036f73ba907bf97d38fab0acbf6ee', '1.6.2', '', 0),
('plugins/authentication/joomla/joomla.php', '7d869a294d01a25b1ed911e6b783a1b8', '1.6.2', '', 0),
('index.php', '5e5c388593da3e90a0e098e7dc9d7e0e', '1.6.2', '', 0),

('plugins/user/joomla/joomla.php', '6b2036f73ba907bf97d38fab0acbf6ee', '1.6.3', '', 0),
('plugins/authentication/joomla/joomla.php', '7d869a294d01a25b1ed911e6b783a1b8', '1.6.3', '', 0),
('index.php', '5e5c388593da3e90a0e098e7dc9d7e0e', '1.6.3', '', 0),

('plugins/user/joomla/joomla.php', '6b2036f73ba907bf97d38fab0acbf6ee', '1.6.4', '', 0),
('plugins/authentication/joomla/joomla.php', '7d869a294d01a25b1ed911e6b783a1b8', '1.6.4', '', 0),
('index.php', '5e5c388593da3e90a0e098e7dc9d7e0e', '1.6.4', '', 0),

('plugins/user/joomla/joomla.php', '6b2036f73ba907bf97d38fab0acbf6ee', '1.6.5', '', 0),
('plugins/authentication/joomla/joomla.php', '7d869a294d01a25b1ed911e6b783a1b8', '1.6.5', '', 0),
('index.php', '5e5c388593da3e90a0e098e7dc9d7e0e', '1.6.5', '', 0),

('plugins/user/joomla/joomla.php', '6b2036f73ba907bf97d38fab0acbf6ee', '1.6.6', '', 0),
('plugins/authentication/joomla/joomla.php', '7d869a294d01a25b1ed911e6b783a1b8', '1.6.6', '', 0),
('index.php', '5e5c388593da3e90a0e098e7dc9d7e0e', '1.6.6', '', 0),

('plugins/user/joomla/joomla.php', 'f862ee6426b77152057ef67eebe1c649', '1.7.0b', '', 0),
('plugins/authentication/joomla/joomla.php', '7d869a294d01a25b1ed911e6b783a1b8', '1.7.0b', '', 0),
('index.php', '5e5c388593da3e90a0e098e7dc9d7e0e', '1.7.0b', '', 0),

('plugins/user/joomla/joomla.php', 'f862ee6426b77152057ef67eebe1c649', '1.7.0', '', 0),
('plugins/authentication/joomla/joomla.php', '7d869a294d01a25b1ed911e6b783a1b8', '1.7.0', '', 0),
('index.php', '5e5c388593da3e90a0e098e7dc9d7e0e', '1.7.0', '', 0),

('plugins/user/joomla/joomla.php', 'f862ee6426b77152057ef67eebe1c649', '1.7.1', '', 0),
('plugins/authentication/joomla/joomla.php', '7d869a294d01a25b1ed911e6b783a1b8', '1.7.1', '', 0),
('index.php', '5e5c388593da3e90a0e098e7dc9d7e0e', '1.7.1', '', 0),

('plugins/user/joomla/joomla.php', 'f862ee6426b77152057ef67eebe1c649', '1.7.2', '', 0),
('plugins/authentication/joomla/joomla.php', '7d869a294d01a25b1ed911e6b783a1b8', '1.7.2', '', 0),
('index.php', '5e5c388593da3e90a0e098e7dc9d7e0e', '1.7.2', '', 0),

('plugins/user/joomla/joomla.php', 'f862ee6426b77152057ef67eebe1c649', '1.7.3', '', 0),
('plugins/authentication/joomla/joomla.php', '7d869a294d01a25b1ed911e6b783a1b8', '1.7.3', '', 0),
('index.php', '5e5c388593da3e90a0e098e7dc9d7e0e', '1.7.3', '', 0),

('plugins/user/joomla/joomla.php', 'f862ee6426b77152057ef67eebe1c649', '1.7.4', '', 0),
('plugins/authentication/joomla/joomla.php', '7d869a294d01a25b1ed911e6b783a1b8', '1.7.4', '', 0),
('index.php', '5e5c388593da3e90a0e098e7dc9d7e0e', '1.7.4', '', 0),

('plugins/user/joomla/joomla.php', '945fdaa21093960f283ab43d7be9b02f', '2.5.0', '', 0),
('plugins/authentication/joomla/joomla.php', '493aa7e7fdcc8810d20c852ac8793ca5', '2.5.0', '', 0),
('index.php', '7b8842445269965a434c7bae60db279d', '2.5.0', '', 0),
('administrator/index.php', '43aa843ec0f3bbb0c0ee7654378a6470', '2.5.0', '', 0),

('plugins/user/joomla/joomla.php', '945fdaa21093960f283ab43d7be9b02f', '2.5.1', '', 0),
('plugins/authentication/joomla/joomla.php', '493aa7e7fdcc8810d20c852ac8793ca5', '2.5.1', '', 0),
('index.php', '7b8842445269965a434c7bae60db279d', '2.5.1', '', 0),
('administrator/index.php', '43aa843ec0f3bbb0c0ee7654378a6470', '2.5.1', '', 0);

CREATE TABLE IF NOT EXISTS `#__rsfirewall_ignored` (
  `path` text NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__rsfirewall_logs` (
  `id` int(11) NOT NULL auto_increment,
  `level` enum('low','medium','high','critical') NOT NULL,
  `date` int(11) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `userid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `page` text NOT NULL,
  `code` varchar(255) NOT NULL,
  `debug_variables` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__rsfirewall_snapshots` (
  `id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `snapshot` text NOT NULL,
  `type` enum('protect','lockdown') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__rsfirewall_patterns` (
  `name` varchar(255) NOT NULL,
  `type` enum('file','filename') NOT NULL,
  UNIQUE KEY `name` (`name`,`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `#__rsfirewall_patterns` (`name`, `type`) VALUES
('bash_history', 'filename'),
('bitchx', 'filename'),
('brute *force', 'filename'),
('c99shell', 'file'),
('c99shell', 'filename'),
('crystalshell', 'file'),
('cwings', 'filename'),
('DALnet', 'filename'),
('directmail', 'filename'),
('eggdrop', 'filename'),
('guardservices', 'filename'),
('m0rtix', 'filename'),
('MultiViews', 'filename'),
('phpremoteview', 'filename'),
('phpshell', 'file'),
('phpshell', 'filename'),
('psyBNC', 'filename'),
('r0nin', 'filename'),
('r57shell', 'file'),
('r57shell', 'filename'),
('raslan58', 'filename'),
('shellbot', 'filename'),
('spymeta', 'filename'),
('undernet', 'filename'),
('void\\.ru', 'filename'),
('vulnscan', 'filename'),
('\\.ru/', 'filename');