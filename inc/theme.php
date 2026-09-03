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

/**
 * Gravity Forms: drop the plugin stylesheets; forms are styled by the theme
 * (assets/sass/_forms.scss) against the stable gform_* / gfield_* classes.
 */
add_filter( 'gform_disable_css', '__return_true' );

/**
 * Gravity Forms: keep the submit button a real <button> so it can carry the
 * pill + dotted ring like every other button on the site.
 */
function bellaworks_gform_submit_button( $button, $form ) {
	$label = ( isset( $form['button']['text'] ) && $form['button']['text'] ) ? $form['button']['text'] : __( 'Submit', 'bellaworks' );
	$onclick = '';
	if ( preg_match( "/onclick='([^']*)'/", $button, $m ) ) {
		$onclick = " onclick='" . $m[1] . "'";
	}
	$id = 'gform_submit_button_' . intval( $form['id'] );
	return '<button type="submit" id="' . esc_attr( $id ) . '" class="gform_button button btn btn--red btn--lg"' . $onclick . '><span>' . esc_html( $label ) . '</span><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"></path><path d="M13 6l6 6-6 6"></path></svg></button>';
}
add_filter( 'gform_submit_button', 'bellaworks_gform_submit_button', 10, 2 );
