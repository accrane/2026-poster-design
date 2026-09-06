<?php
/**
 * Site branding outside the templates: favicon set and the login screen.
 *
 * @package bellaworks
 */

/**
 * Favicon set. The SVG and 32px PNG are the monogram on a transparent
 * background for browser tabs (the SVG flips to cream in a dark UI). The 192px
 * PNG, apple-touch-icon and favicon.ico sit on an opaque cream ground so the
 * dark monogram reads in Google's result circle and on iOS home screens.
 *
 * No cache-busting query string: the host's robots.txt disallows "/*?", which
 * would hide the icons from Googlebot. Rename the file to bust the cache.
 * Everything lives in the theme; nothing needs uploading to the site root.
 * Replaces the Customizer site icon output so only one set is printed.
 */
function bellaworks_favicon() {
	$dir = get_template_directory_uri() . '/images/';
	echo '<link rel="icon" href="' . esc_url( $dir . 'favicon.svg' ) . '" type="image/svg+xml">' . "\n";
	echo '<link rel="icon" href="' . esc_url( $dir . 'favicon-32.png' ) . '" sizes="32x32" type="image/png">' . "\n";
	echo '<link rel="icon" href="' . esc_url( $dir . 'favicon-192.png' ) . '" sizes="192x192" type="image/png">' . "\n";
	echo '<link rel="icon" href="' . esc_url( $dir . 'favicon.ico' ) . '" sizes="48x48">' . "\n";
	echo '<link rel="apple-touch-icon" href="' . esc_url( $dir . 'apple-touch-icon.png' ) . '" sizes="180x180">' . "\n";
}
add_action( 'wp_head', 'bellaworks_favicon', 1 );
add_action( 'login_head', 'bellaworks_favicon', 1 );
add_action( 'admin_head', 'bellaworks_favicon', 1 );
remove_action( 'wp_head', 'wp_site_icon', 99 );
remove_action( 'login_head', 'wp_site_icon', 99 );
remove_action( 'admin_head', 'wp_site_icon', 99 );

/**
 * Requests for /favicon.ico that reach WordPress redirect to the theme's icon,
 * so no file has to sit in the site root. (Hosts whose web server 404s the
 * path before PHP never hit this; the <link> tags above cover them.)
 */
function bellaworks_favicon_ico() {
	wp_redirect( get_template_directory_uri() . '/images/favicon.ico', 301 );
	exit;
}
add_action( 'do_faviconico', 'bellaworks_favicon_ico', 1 );

/**
 * Login screen in the retro system: tan page, monogram, bordered card with the
 * dotted inset ring, theme fields and the red pill button.
 */
function bellaworks_login_fonts() {
	wp_enqueue_style( 'bellaworks-login-fonts', 'https://fonts.googleapis.com/css2?family=Anton&family=DM+Sans:wght@400;500;700&display=swap', array(), null );
}
add_action( 'login_enqueue_scripts', 'bellaworks_login_fonts' );

// Printed late in login_head so it lands after core's login.css.
function bellaworks_login_styles() {
	$logo = esc_url( get_template_directory_uri() . '/images/logo-dark.svg' );
	?>
	<style>
		body.login { background: #efdec4; color: #2b0b0a; font-family: 'DM Sans', system-ui, sans-serif; }
		.login #login { width: 380px; padding: 6vh 0 0; }
		.login h1 a { background: url(<?php echo $logo; ?>) center / contain no-repeat; width: 104px; height: 64px; margin: 0 auto 30px; }
		.login form, .login .message, .login .success, .login #login_error, .login .notice {
			background: #efdec4; color: #2b0b0a; border: 2px solid #2b0b0a; border-radius: 22px; box-shadow: none;
		}
		.login form { position: relative; padding: 34px 34px 30px; margin-top: 0; }
		.login form::before { content: ""; position: absolute; inset: 7px; border: 2px dotted #2b0b0a; border-radius: 15px; pointer-events: none; }
		.login .message, .login .success, .login #login_error, .login .notice { padding: 14px 18px; margin-bottom: 20px; font-size: 14px; line-height: 1.5; border-radius: 12px; }
		.login #login_error { border-color: #df0118; color: #df0118; }
		.login #login_error a { color: #df0118; }
		.login label { font-size: 12px; font-weight: 700; letter-spacing: 0.22em; text-transform: uppercase; color: #2b0b0a; margin-bottom: 8px; }
		.login form .input, .login input[type="text"], .login input[type="password"] {
			height: 54px; padding: 0 16px; margin: 4px 0 18px; font: 16px 'DM Sans', system-ui, sans-serif; color: #2b0b0a;
			background: rgba(255, 255, 255, 0.35); border: 2px solid #2b0b0a; border-radius: 12px; box-shadow: none;
		}
		.login form .input:focus, .login input[type="text"]:focus, .login input[type="password"]:focus { border-color: #df0118; box-shadow: inset 0 0 0 2px #df0118; outline: 0; }
		.login .wp-pwd { position: relative; }
		.login .wp-pwd .button.wp-hide-pw { color: #2b0b0a; height: 54px; margin-top: 4px; }
		.login .wp-pwd .button.wp-hide-pw:focus { box-shadow: none; border-color: transparent; }
		.login .forgetmenot { margin-top: 4px; }
		.login .forgetmenot label { text-transform: none; letter-spacing: 0; font-weight: 500; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; }
		.login input[type="checkbox"] { width: 18px; height: 18px; border: 2px solid #2b0b0a; border-radius: 5px; background: transparent; box-shadow: none; margin: 0; accent-color: #df0118; }
		.login input[type="checkbox"]:checked::before { content: ""; width: 10px; height: 10px; margin: 2px; background: #df0118; border-radius: 2px; display: block; }
		.login .submit { display: flex; justify-content: flex-end; }
		.login .button-primary, .login .button-primary:hover, .login .button-primary:focus {
			height: 48px; min-height: 0; padding: 0 24px; border: 0; border-radius: 999px; box-shadow: none;
			background: #df0118; color: #efdec4; font: 700 13px/48px 'DM Sans', system-ui, sans-serif; letter-spacing: 0.16em; text-transform: uppercase;
			outline: 2px dotted #efdec4; outline-offset: -7px; transition: background-color 180ms ease;
		}
		.login .button-primary:hover, .login .button-primary:focus { background: #2b0b0a; }
		.login #nav, .login #backtoblog { text-align: center; padding: 0; margin: 22px 0 0; font-size: 13px; }
		.login #backtoblog { margin-top: 10px; }
		.login #nav a, .login #backtoblog a { color: #2b0b0a; text-decoration: none; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; font-size: 12px; }
		.login #nav a:hover, .login #backtoblog a:hover { color: #df0118; }
		.login .privacy-policy-page-link { margin-top: 24px; }
		.login .privacy-policy-page-link a { color: #2b0b0a; font-size: 12px; }
		.login .language-switcher { display: none; }
	</style>
	<?php
}
add_action( 'login_head', 'bellaworks_login_styles', 99 );

function bellaworks_login_url() {
	return home_url( '/' );
}
add_filter( 'login_headerurl', 'bellaworks_login_url' );

function bellaworks_login_title() {
	return get_bloginfo( 'name' );
}
add_filter( 'login_headertext', 'bellaworks_login_title' );
