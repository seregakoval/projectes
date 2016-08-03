<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', '/home2/andywhit/public_html/newrmi/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
/** The name of the database for WordPress */
define('DB_NAME', 'andywhit_wrdp13');

/** MySQL database username */
define('DB_USER', 'andywhit_wrdp13');

/** MySQL database password */
define('DB_PASSWORD', 'cnvdZne7cXlEHN');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'j42UlauGSMch^1PnBNG~fOmIlA3U8<ERg#1S_iCfvsbI1;WztwhwdG:A:tH_C~!sEb=Vy56');
define('SECURE_AUTH_KEY',  'SuqevJ$o0VeCd#gDK1PiAK5S_ImUG=Kxp3w#gbT*sF0Fx7ht/vY4PbKW~~img#y1y9o#M8Ghiiq\`Gzp8?7z');
define('LOGGED_IN_KEY',    '-9fvO@@jmnkIvApWeZzQ/8^OayFNhYqv>Uy/1A|ayHCxh!3eNtxuktp$)-1~X9(_7j|/V(>)Sp/5/h9O8h');
define('NONCE_KEY',        'eTB:1yrDBAsJB#nYzOPlY5#~640\`o2evU#HtHt#e<Z|ORuYg:g~Db-W#LDJW$;FpT(RBQ#vIk/I7');
define('AUTH_SALT',        'aYtKN=)wWA~m8)*s7aryG0#bH~BQFS9S7Wr0oKNFpmHLOe<08LWvisY8~zuApU1r');
define('SECURE_AUTH_SALT', 'S3lt^EPlua?kEh1HUOHxbsaHF=DsmBRG-UM_2W*\`T)ICdIxSTl3tsQ=(RoZ$r9OM3CBqsm08cchAf35R<Nc<w');
define('LOGGED_IN_SALT',   'f?WZe/W*\`ylFB$7t;E6D2dxEv<c;f9eiRI?m$xKSX*Z=-jN*Hb7B3=$0E-40ZbIRt:9saLF7ig3>x');
define('NONCE_SALT',       ')HIbRG0:<_lV=?!t(m:_q$p5#~egMJqR\`w@@)7;59?9rgK<8;m1l/#>oibyu~WWhrk977d4!PSA!;p');


/**#@-*/
define('AUTOSAVE_INTERVAL', 600 );
define('WP_POST_REVISIONS', 1);
define( 'WP_CRON_LOCK_TIMEOUT', 120 );
define( 'WP_AUTO_UPDATE_CORE', true );
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
add_filter( 'auto_update_plugin', '__return_true' );
add_filter( 'auto_update_theme', '__return_true' );
