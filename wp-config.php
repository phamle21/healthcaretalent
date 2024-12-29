<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', "hct_db" );

/** Database username */
define( 'DB_USER', "root" );

/** Database password */
define( 'DB_PASSWORD', "" );

/** Database hostname */
define( 'DB_HOST', "localhost" );

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
define( 'AUTH_KEY',         ';?uQ^jBo^pP8dQr*aK{#_5[@0Aiox4(R3X|l/V9e,ns|p1h9*L6C=TUMFmxen)8n' );
define( 'SECURE_AUTH_KEY',  '5=LkuYxa%QNT,av>e0Cnl_# E=]lKg:P@)X;(+zfUuD1C:a[7OUES<8az;awpx)T' );
define( 'LOGGED_IN_KEY',    ':FsJTHnl-EC9NtWS9laCG0z:W?o}[l~Y(:vCR9q/AcS/omPBP;V$JPHa<i>;#biZ' );
define( 'NONCE_KEY',        'h{w}J1KB7Rfl[Hhqz);g*U$+5iURyb=;x19SPlsNJdS.s^*0MkrK{;n7:&e$,70u' );
define( 'AUTH_SALT',        '/96{./7JX?x*d3zyg9=_2h(g:`YRv*-p7XL@jH<SO R7ScH*3``92J@Nr_t#HD@i' );
define( 'SECURE_AUTH_SALT', '/hLTf]Uk%i9k1BLHiQo@$X})O4Fe/grHHN468sdL/-;Yrmho%ZD,FjP7$X26)j/O' );
define( 'LOGGED_IN_SALT',   '.kOY/HcC+1Zt6(<F9@a16K9n0IlXN7gD2rb6H4C`+X<pK>hVn08{6steX_J2<`;q' );
define( 'NONCE_SALT',       'oq6b[gt>3DyVX{3S.OWh@w!-~37zi7$#.A{s><NV(B*`O1(8m%;LgUMdmg~y[;p$' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
// Enable WP_DEBUG mode
define( 'WP_DEBUG', false );

// Enable Debug logging to the /wp-content/debug.log file
//define( 'WP_DEBUG_LOG', true );

// Disable display of errors and warnings 
//define( 'WP_DEBUG_DISPLAY', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';