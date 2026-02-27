<?php
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
define( 'DB_NAME', 'news_db' );

/** Database username */
define( 'DB_USER', 'news_user' );

/** Database password */
define( 'DB_PASSWORD', '123456' );

/** Database hostname */
define( 'DB_HOST', 'mysql-8.4' );

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
define( 'AUTH_KEY',         '[U]vOXmHb 7&Q Jm-x5QwwTPG59;x.,ch2;-YW]&]Jwtlzt)[j@t[Q%%Sn;yyXg*' );
define( 'SECURE_AUTH_KEY',  'k*p.cNGrsebi{0W#toh,thMbZC ro-NhomdBlM<Pqi(OBaO~{qo+g<mT,0.Y[ca)' );
define( 'LOGGED_IN_KEY',    'T?+[|+[W}FeG$;K;C)]/sfeqNbphBxGc:)E9R6aRQJ/9bQ<Cn23ZTvrw&Zz7`(2+' );
define( 'NONCE_KEY',        '*C|)M$%A#EN6V3OS<RkrDS`U7A#_ON#2LlsO93<jM>>*MjTAVMJ:] c`dzACG2fc' );
define( 'AUTH_SALT',        'A!-#?uf}OZkyAY30H?8,>;![c1z>V5t.Hd!xucNMXC89pyF#J}K[i+f-2sF9@6?a' );
define( 'SECURE_AUTH_SALT', 'k7xRfM-+{=eT^msreiTdE}~O[C%Pt 5>gapcr<S[N|Q)kq/)-r|Oi;)GLw]PU<k1' );
define( 'LOGGED_IN_SALT',   'eDB|Q_B8e{_:tO+?{4:/[4:_>f8._n+^A@Jm-` R(Z8Q[o]f#>_Y$Vrp5>.!j755' );
define( 'NONCE_SALT',       '+CI)SU3u^,#,Lh g>PhVq=YTP[?*]nk mySYb,<`FLca!h j/5>*K_@voEru]/MB' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wpnb_';

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
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
