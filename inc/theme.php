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

/**
 * Service pages: move the four per-service ACF groups from the 2024 theme
 * onto the shared "Service Content" group (acf-json/group_bw_service_content.json).
 *
 * The values already live in postmeta under the same names; only the
 * field-key references (_row1_title etc.) point at the old fields. Rewrite
 * them and trash the old groups so the editor shows one set of fields.
 * Runs on theme activation; re-run any time from /wp-admin/?bw_migrate_services=1.
 */
function bellaworks_migrate_service_fields() {
	if ( ! function_exists( 'acf_get_field_group' ) ) {
		return 'ACF is not active.';
	}
	$map = array(
		'row1_title'         => 'field_bw_svc_row1_title',
		'row1_content'       => 'field_bw_svc_row1_content',
		'row2_content_left'  => 'field_bw_svc_row2_content_left',
		'row2_content_right' => 'field_bw_svc_row2_content_right',
		'row3_content_left'  => 'field_bw_svc_row3_content_left',
		'row3_content_right' => 'field_bw_svc_row3_content_right',
	);
	$posts = get_posts( array( 'post_type' => 'service', 'post_status' => 'any', 'posts_per_page' => -1, 'fields' => 'ids' ) );
	$n = 0;
	foreach ( $posts as $pid ) {
		foreach ( $map as $name => $key ) {
			if ( metadata_exists( 'post', $pid, $name ) ) {
				update_post_meta( $pid, '_' . $name, $key );
				$n++;
			}
		}
	}
	// Old per-service groups (2024 theme). Trashed, not deleted, so it is reversible.
	$old = array( 'group_66ac6aa62e9e3', 'group_66ac6c64a285b', 'group_66b42ef5434f1', 'group_66b431c8cb82e' );
	$t   = 0;
	foreach ( $old as $key ) {
		$g = acf_get_field_group( $key );
		if ( $g && ! empty( $g['ID'] ) && 'trash' !== get_post_status( $g['ID'] ) ) {
			wp_trash_post( $g['ID'] );
			$t++;
		}
	}
	update_option( 'bellaworks_service_fields_migrated', time() );
	return sprintf( '%d field references updated on %d service posts, %d old field groups trashed.', $n, count( $posts ), $t );
}
add_action( 'after_switch_theme', 'bellaworks_migrate_service_fields' );
add_action( 'admin_init', function () {
	if ( isset( $_GET['bw_migrate_services'] ) && current_user_can( 'manage_options' ) ) {
		$msg = bellaworks_migrate_service_fields();
		wp_die( esc_html( $msg ) . ' <a href="' . esc_url( admin_url( 'edit.php?post_type=service' ) ) . '">Back to Services</a>', 'Service fields migrated', array( 'response' => 200 ) );
	}
} );
