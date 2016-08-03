<?php

/**

 * The base configuration for WordPress

 *

 * The wp-config.php creation script uses this file during the

 * installation. You don't have to use the web site, you can

 * copy this file to "wp-config.php" and fill in the values.

 *

 * This file contains the following configurations:

 *

 * * MySQL settings

 * * Secret keys

 * * Database table prefix

 * * ABSPATH

 *

 * @link https://codex.wordpress.org/Editing_wp-config.php

 *

 * @package WordPress

 */



// ** MySQL settings - You can get this info from your web host ** //

/** The name of the database for WordPress */

define('DB_NAME', 'africa');  //wp-restyle



/** MySQL database username */

define('DB_USER', 'root');       //user



/** MySQL database password */

define('DB_PASSWORD', ''); //11111



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

define('AUTH_KEY',         '57I8sRguM62Cdu1PQKexKrJhBkYrlIyZE8fk1QCIns6evMTZPjunyK8nPkF2XeJB');

define('SECURE_AUTH_KEY',  'kumV4pxIWKgor44aVrLzX6dpL8WJVu7TeinkR08UDdyehL64BuAFZf14pfNm22BE');

define('LOGGED_IN_KEY',    'yjjDENayM02rha8mrIzT7UQATD2rlFxZorKULjjhU0BmjVWsW6EFAR2zk93joS6D');

define('NONCE_KEY',        'Mo7rKaLaEQz8XDxDGV24KvVB0tY69nCIfPa4RMNVBzB6kq8EbzXmP1EjEMfRPu10');

define('AUTH_SALT',        'KcgWHVRagva9CgGFO2k3kqKISHJGQCeOut4rFP8EfKyOPfjhudOgNgdM5CXAjEt2');

define('SECURE_AUTH_SALT', 'Nmw9mEnUKC0iI4VjYQoOwnd9UJWO8SF9CBP3WqOqhI6p5eAeY8r2oKrkRUMczXMp');

define('LOGGED_IN_SALT',   'SyIdKZmlPDb3ml4oQTHPLeHwNavAbHI306OJo8i3fQYdIQQN2nS0FLhPQRJF18AE');

define('NONCE_SALT',       'JGGS0qJQqtqjplCejdfps72vsMOlzZMEZUIR1rAJ3PDecTkDTUyCiDPENcc0oFGi');



/**

 * Other customizations.

 */

define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');



/**

 * Turn off automatic updates since these are managed upstream.

 */

define('AUTOMATIC_UPDATER_DISABLED', true);





/**#@-*/



/**

 * WordPress Database Table prefix.

 *

 * You can have multiple installations in one database if you give each

 * a unique prefix. Only numbers, letters, and underscores please!

 */

$table_prefix  = 'wp_';



/**

 * For developers: WordPress debugging mode.

 *

 * Change this to true to enable the display of notices during development.

 * It is strongly recommended that plugin and theme developers use WP_DEBUG

 * in their development environments.

 *

 * For information on other constants that can be used for debugging,

 * visit the Codex.

 *

 * @link https://codex.wordpress.org/Debugging_in_WordPress

 */

define('WP_DEBUG', false);



/* That's all, stop editing! Happy blogging. */



/** Absolute path to the WordPress directory. */

if ( !defined('ABSPATH') )

	define('ABSPATH', dirname(__FILE__) . '/');



/** Sets up WordPress vars and included files. */

require_once(ABSPATH . 'wp-settings.php');

