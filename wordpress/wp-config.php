<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'coderspk');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '9koof+1~/@~8GlkAFqEw&Y*=L>e=!X|_Rv=PVc(JiSEnj<<hubgyT]GuKA;w9&C_');
define('SECURE_AUTH_KEY',  '6tF0=4#CZl;aB[-P-Hj5dv(*?hxT>=9 (c;nT3l[LUa-g2kF8=fqxuMA++)jQR%-');
define('LOGGED_IN_KEY',    's#Q~zW-jETB)B&.v~aRXKk7+hyX2X6jv}[[/sAIdwfA7-_q|^r4Az+G7#DBmF#?+');
define('NONCE_KEY',        '7|1,3|;|RX&fA8h xI22yX(9$ho7^@ IBu[},&~LKg4j|,|K9~K21Oyf}zqYU>8?');
define('AUTH_SALT',        '+myIg;bt|_GM+D^m{{W##Q%5F- p>{W%}6M6M DXNC<7])RU;+EjN3AJ0^_p4ro-');
define('SECURE_AUTH_SALT', 'J>#<mr]Vp@Xf7A^3x8E}2C-+^Oc-iG&f?NO+^,B!r~QQI+~H?-jk5!P4QtlEp(wX');
define('LOGGED_IN_SALT',   '^2nO7>23%S<9>e5(!;mz+=CSd+:,<Brte&A4`#+-kw-jjt<=YvE?IKLcwjEB<PUp');
define('NONCE_SALT',       '+T}JN1pz YI.|#lI;JP+e^AD,9u^|}(yEmZ]ToGlvVUR;stIH-P<M^eqzIHm7esi');

/**#@-*/

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
