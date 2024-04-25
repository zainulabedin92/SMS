<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
ini_set('display_errors', '0');

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'sms' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ',kbgpcE}.v+`y{abQU=`O/zf}KP_&Y{>:b+lFBy:d_w3W|M#evXu;VWjYGXYj!>;' );
define( 'SECURE_AUTH_KEY',  'o.Sh{#WTp:/*yedm<xV.*aOpNG!iGLEO5j2DAJs>-t0@.B&V:_Y$W)p5H-y~`yC_' );
define( 'LOGGED_IN_KEY',    '{x/|rzc)nqFs,zO?&Fd5YI_om%Eu>s}n2p~;M+U gJ`vp(}]d.AAQ/?/d_$J`Qc0' );
define( 'NONCE_KEY',        'dbShJ2LzkePA??C0:jw%qwxyRM/9TcE6M(,[OF`7w!eV>NJHfcf_u@@2W4_sSxPH' );
define( 'AUTH_SALT',        ',ql5?^i+XILAx;Xy%k%3[[rvee5d7mzI;h8LJ_;{fX`+Ggu[(e~uw[UwH/*vLL:X' );
define( 'SECURE_AUTH_SALT', '`6 <9C86=fpJVloh7I9>(IqATGI{cQuZBwRq=|SY?rbBLUG%(NG~E;^io)mB1z?{' );
define( 'LOGGED_IN_SALT',   '_Pg1|W)#E7%@:vHs0<zO&zC!d2m_R6l$)sH>|`0g@FEVrAiX6fXbotWJ;&7zpq=-' );
define( 'NONCE_SALT',       ')zZw6%K`V6CXwc/%1C1/>iC4yV$1femnRm5MX2*3^O3?T${w{xfF!N|1n:ig(x6g' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
