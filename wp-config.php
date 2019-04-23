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
/** The name of the database for WordPress */
define('DB_NAME', 'wizard_lakeunionsearay');

/** MySQL database username */
define('DB_USER', 'cws_root');

/** MySQL database password */
define('DB_PASSWORD', 'g3neric!');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'YpF}-0b, }c||y**~;L p<e+.}m(?^C&(swi. GM~s ];Y[T|9X>h`8*QPJTA;>@');
define('SECURE_AUTH_KEY',  'Znx}NE^6?5tK-SKa}>k|+Zdp`}=mt8<}`g+s?sG@,$~3;b)kt-~1Of`-y@mE|4,0');
define('LOGGED_IN_KEY',    'D[|!+b%kYusM-8-(FW`}X zEk!MW*s+x|oaA]A{iqDmopfq[xFcA?)-RD:#@6OHA');
define('NONCE_KEY',        'mhPFUB1+sr:<$FpqVJoY&}iwF6le<Ct,{U++m:^A;>%]VI0Shw4?nJY>DPjF{soo');
define('AUTH_SALT',        'TSbS_s?&*K=;aQR8euVgnE_y{i/<$Qh0YG#9s%$ogUC@6WCfd6(RcgU|h>K-s>K%');
define('SECURE_AUTH_SALT', 'ud50^Ffj<^L-Pe +1cSi.hV }Zp6JnI_n}mKi1-{`uZ%P)G$Nf$I}.|R#j,!HSwp');
define('LOGGED_IN_SALT',   '0,:_:[b,LVt(3hy7 UNE+/]OE:h$:v@Wdv2i k<<D@O~75^.B17=Qdm2SLT^ssz.');
define('NONCE_SALT',       'n[gJh+Ur/v$jia4L2|419y.&ptWq7VDX9h12yrd+8rQ91f?Pfo+jN./:-+vBhcpV');

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
