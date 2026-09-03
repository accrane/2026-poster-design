<?php
/**
 * Theme specific additions.
 *
 * @package bellaworks
 */

/**
 * Allow SVG + WebM uploads for the retro illustrations and hero video.
 */
function bellaworks_mime_types( $mimes ) {
	$mimes['svg']  = 'image/svg+xml';
	$mimes['webm'] = 'video/webm';
	return $mimes;
}
add_filter( 'upload_mimes', 'bellaworks_mime_types' );

/**
 * Menu fallback while no Primary menu is assigned: the five homepage links.
 */
function bellaworks_menu_fallback( $args = array() ) {
	$items = array(
		'About'    => home_url( '/about-us/' ),
		'Services' => home_url( '/services/' ),
		'Work'     => home_url( '/work/' ),
		'News'     => home_url( '/news/' ),
		'Contact'  => home_url( '/contact-us/' ),
	);
	$class = ( isset( $args['menu_class'] ) && $args['menu_class'] ) ? $args['menu_class'] : 'menu';
	echo '<ul class="' . esc_attr( $class ) . '">';
	foreach ( $items as $label => $url ) {
		echo '<li class="menu-item"><a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
	}
	echo '</ul>';
}
