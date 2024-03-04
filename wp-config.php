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
define( 'DB_NAME', "tvlfrjks_gswp0" );

/** Database username */
define( 'DB_USER', "tvlfrjks_puzzel" );

/** Database password */
define( 'DB_PASSWORD', "NhX&cgJ#jAN#" );

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
define( 'AUTH_KEY',         '2oYN>%G57Iuy^[B{t(g{K*,uPDM!BtV}8 NUi~;I&x>@mlhFPbb(h}D~/20vYT7m' );
define( 'SECURE_AUTH_KEY',  ':A#uXGS8:5=BQvdr4EeF.==B` }$m-?W)&4g@_XxX9{g8juQbjy*kmcOc*75;?hH' );
define( 'LOGGED_IN_KEY',    'pGO$0cIzS=9D4p=4j5CVUunpmu^2B,$~pCh]%$0VY9`V,#d`0`n~aM]~Hm<C>OOk' );
define( 'NONCE_KEY',        '_fFfX#I4nt(d` _s^K3Dg,*$,&X!qXSiKM$$nBwjyN* O)ow<SziI$`a!.;69{%6' );
define( 'AUTH_SALT',        'z;P88{0]FcU/4IF<AEF.&M4K4c%sfMxt1)G;v7@W^X1Ll_h^VlF(AbDm?~5J[LFk' );
define( 'SECURE_AUTH_SALT', '5A!-@38L7nc(~~#9TFzSt8X26V!EnHCW-zm5Ky,&83`^.35WOGnz],mG~&-wg[KQ' );
define( 'LOGGED_IN_SALT',   '-8=HsDia]p^o+1I2}@=ezHGL.9rmd.mF)|i+mcQ@fL(O]1GU&&&%w^dBbHCQ$E  ' );
define( 'NONCE_SALT',       'MimB)-%%*$wFFN+1{ASHm]]L@M<&JLb,g[e`-M_@)mB)-k(t7y/k*@#AgwmNo;-I' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpgift_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
