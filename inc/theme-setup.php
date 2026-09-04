<?php
/**
 * Theme setup: supports, menus, content width.
 *
 * @package bellaworks
 */

if ( ! function_exists( 'bellaworks_setup' ) ) :
function bellaworks_setup() {
	load_theme_textdomain( 'bellaworks', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'bellaworks' ),
		'footer'  => esc_html__( 'Footer', 'bellaworks' ),
	) );

	add_theme_support( 'html5', array(
		'search-form',
		'gallery',
		'caption',
	) );

	// Portfolio thumbnails on the homepage grid (3:2, cropped).
	add_image_size( 'bellaworks-work', 880, 560, true );
	// Project pages: wide site banner and the tall full-page screenshot (no crop).
	add_image_size( 'bellaworks-banner', 1600, 0, false );
	add_image_size( 'bellaworks-tall', 1000, 0, false );
}
endif;
add_action( 'after_setup_theme', 'bellaworks_setup' );

/**
 * Content width.
 */
function bellaworks_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bellaworks_content_width', 1240 );
}
add_action( 'after_setup_theme', 'bellaworks_content_width', 0 );

/**
 * Body class hooks for the fixed nav and pinned hero.
 */
function bellaworks_body_classes_2026( $classes ) {
	$classes[] = 'has-fixed-nav';
	if ( is_front_page() ) {
		$classes[] = 'is-home';
	}
	return $classes;
}
add_filter( 'body_class', 'bellaworks_body_classes_2026' );
