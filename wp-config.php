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
define('DB_NAME', 'imarkcli_speakersyndicate');

/** MySQL database username */
define('DB_USER', 'imarkcli_digdev');

/** MySQL database password */
define('DB_PASSWORD', 'a1b2c3d4');

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
define('AUTH_KEY',         'z`nTiq7D+?duAa/IJeIzt^N6CdJ$erR*x5E~UC<hD$8Q2Uyl6Y^Xa]h}l(b|7=1/');
define('SECURE_AUTH_KEY',  'Eclk~T6;/cc+/[A-r](e3R;b0n;(p`-[r7yIy6%#!N-[M=@n]ptK$`=!3I{^2W_-');
define('LOGGED_IN_KEY',    '#b#xO+:es~L0A=Hn[dZ1/aQhJBd;O/`0D#Y.yBB.-J7eN:|eAo,oVzGuL($ku)ai');
define('NONCE_KEY',        'Ti9r;lt0wjYCL=i1><]wH)_Tl$w=[cCJUd e+Esu?UfM*Kij*1hGo6_NcuH{T*R ');
define('AUTH_SALT',        'c6}1VJP(iD}a>hAa7oWaF C`qq$=sbZpbJ[|N.nscFHM.w]L~T}m)l2C6e&t5yBk');
define('SECURE_AUTH_SALT', ':B lS8wog*TyEm(U>mnOBCB7s|5e%CQ?,*Wwjeh4DNB7a)7we)$9tbB8r&lLGvaY');
define('LOGGED_IN_SALT',   ':0)HtHT+.iF!bY7;Hmf(hKf~?VpkfbK4w(qVm430jW=NH?l}o8S*{dmh):*P*|L)');
define('NONCE_SALT',       '!`+F((SHy%lUr@}Cf^ vJ{uF@1kRRjGQuv_3>L]m?}C?=FIFAj5a,h.}bUzF=NT<');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'sp_';

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
