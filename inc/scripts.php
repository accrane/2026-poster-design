<?php
/**
 * Enqueue scripts and styles.
 *
 * @package bellaworks
 */
function bellaworks_scripts() {
	$dir = get_template_directory_uri();
	// cache-bust compiled assets by modification time (no stale CSS/JS while building)
	$ver_css = filemtime( get_stylesheet_directory() . '/style.css' );
	$ver_js  = filemtime( get_template_directory() . '/assets/js/custom.min.js' );

	wp_enqueue_style( 'bellaworks-fonts', 'https://fonts.googleapis.com/css2?family=Anton&family=Kaushan+Script&family=DM+Sans:wght@400;500;700&display=swap', array(), null );
	wp_enqueue_style( 'bellaworks-style', get_stylesheet_uri(), array( 'bellaworks-fonts' ), $ver_css );

	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', 'https://code.jquery.com/jquery-3.7.1.min.js', false, '3.7.1', false );
	wp_enqueue_script( 'jquery' );

	// Motion stack: GSAP + ScrollTrigger + Lenis (only where the hero lives).
	if ( is_front_page() ) {
		wp_enqueue_script( 'gsap', $dir . '/assets/js/vendor/gsap.min.js', array(), '3.13.0', true );
		wp_enqueue_script( 'gsap-scrolltrigger', $dir . '/assets/js/vendor/ScrollTrigger.min.js', array( 'gsap' ), '3.13.0', true );
		wp_enqueue_script( 'lenis', $dir . '/assets/js/vendor/lenis.min.js', array(), '1.3.0', true );
	}

	wp_enqueue_script( 'bellaworks-custom', $dir . '/assets/js/custom.min.js', array( 'jquery' ), $ver_js, true );

	wp_localize_script( 'bellaworks-custom', 'frontajax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'bellaworks_scripts' );
