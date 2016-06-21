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
define('DB_NAME', 'develodesigndatabase');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'Ed%D.#s~$ft9@#4Z(, xYtXJoqRy714SwG_l9iIS24OC~`~GI=<w0{lUd`,+2- o');
define('SECURE_AUTH_KEY',  '{0IqDihC8 weJ~4S)*W/(2K)Vf]Md$-57vhusv(C[D7}G,d22$HmZZa9u[@`e}WF');
define('LOGGED_IN_KEY',    '^uw8nY[o{X[6=LqXv[&;67>A{?8/hvmM<} M6QXW=!KL%^&b@98}o_e|01r9Du?G');
define('NONCE_KEY',        'FL_+Rux;~bqjUms|.d4QkO4cEyHc8Ze:A#`XRn6xY5(;n5j[Ek>@(;[ZU+v8.vQ ');
define('AUTH_SALT',        'lcDbXW:~O_Zq^a0;{`_*/%9}{TpTO;A@*IFaCN{!jh{xxqBTsY(vo41FD;SU83[K');
define('SECURE_AUTH_SALT', 'V|Q-m^kTl9Zcd=l8LFbo#4v(1`nbz1#-KE6c8E2]J5wEwqe:U5iSmTRpB3(yMo/.');
define('LOGGED_IN_SALT',   '/99NC=m#fYLJ5F#{4C>Q0wgDBd&;fOIK*r.KSZ,S4l@Aj$!=P@,:evhM:t <Zk|{');
define('NONCE_SALT',       '?}Pn`J<>i7yxQE~<]+EJy&AD*Getu@<O5qky`BnbhRfG$t3wl{@G[nGK/Z/fM@=f');

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
