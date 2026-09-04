<?php
/**
 * Reusable output functions for the retro poster system.
 * Every device here matches concept2/STYLEGUIDE.md.
 *
 * @package bellaworks
 */

/**
 * Palette helpers.
 */
function bellaworks_color( $name ) {
	$colors = array(
		'brown' => '#2b0b0a',
		'red'   => '#df0118',
		'tan'   => '#efdec4',
	);
	return ( isset( $colors[ $name ] ) ) ? $colors[ $name ] : $name;
}

/**
 * Filled star (the 24-box path used everywhere).
 */
function bellaworks_star( $size = 18, $color = 'red', $class = '' ) {
	$fill = bellaworks_color( $color );
	echo '<svg class="star ' . esc_attr( $class ) . '" width="' . intval( $size ) . '" height="' . intval( $size ) . '" viewBox="0 0 24 24" fill="' . esc_attr( $fill ) . '" aria-hidden="true"><path d="M12 1.6l2.9 6.6 7.1.7-5.4 4.8 1.6 7.1L12 17.2l-6.2 3.6 1.6-7.1L2 8.9l7.1-.7z"></path></svg>';
}

/**
 * Arrow used inside buttons.
 */
function bellaworks_arrow() {
	echo '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"></path><path d="M13 6l6 6-6 6"></path></svg>';
}

/**
 * Pill button with the inset dotted ring.
 *
 * @param string $label   Button text.
 * @param string $url     Link.
 * @param string $variant brown | red | tan.
 * @param string $size    '' | sm | lg.
 */
function bellaworks_button( $label, $url, $variant = 'red', $size = '', $arrow = true ) {
	$class = 'btn btn--' . $variant . ( $size ? ' btn--' . $size : '' );
	echo '<a href="' . esc_url( $url ) . '" class="' . esc_attr( $class ) . '">' . esc_html( $label );
	if ( $arrow ) {
		bellaworks_arrow();
	}
	echo '</a>';
}

/**
 * Dashed rule with a star in the middle.
 */
function bellaworks_star_rule( $color = 'tan' ) {
	echo '<div class="star-rule">';
	bellaworks_star( 26, $color );
	echo '</div>';
}

/**
 * The bw monogram path (from images/logo-dark.svg), cached.
 */
function bellaworks_monogram_path() {
	static $d = null;
	if ( null === $d ) {
		$svg = @file_get_contents( get_template_directory() . '/images/logo-dark.svg' );
		$d   = ( $svg && preg_match( '/<path[^>]*\sd="([^"]+)"/', $svg, $m ) ) ? $m[1] : '';
	}
	return $d;
}

/**
 * Round rubber stamp: ring text + red monogram, tilted -8deg.
 */
function bellaworks_stamp( $ring_text = 'SIMPLE • BEAUTIFUL • SECURE • ', $size = 300 ) {
	$id = 'stamp-ring-' . wp_unique_id();
	$d  = bellaworks_monogram_path();
	echo '<svg class="stamp" width="' . intval( $size ) . '" height="' . intval( $size ) . '" viewBox="0 0 300 300" aria-hidden="true">';
	echo '<defs><path id="' . esc_attr( $id ) . '" d="M150,150 m-97,0 a97,97 0 1,1 194,0 a97,97 0 1,1 -194,0"></path></defs>';
	echo '<circle cx="150" cy="150" r="142" fill="none" stroke="#2b0b0a" stroke-width="5"></circle>';
	echo '<circle cx="150" cy="150" r="130" fill="none" stroke="#2b0b0a" stroke-width="2" stroke-dasharray="3 6"></circle>';
	echo '<circle cx="150" cy="150" r="78" fill="none" stroke="#2b0b0a" stroke-width="4"></circle>';
	echo '<text font-family="DM Sans, system-ui, sans-serif" font-weight="700" font-size="21" letter-spacing="5" fill="#2b0b0a"><textPath href="#' . esc_attr( $id ) . '">' . esc_html( $ring_text ) . '</textPath></text>';
	if ( $d ) {
		// 112px wide monogram centered in the inner circle.
		echo '<g transform="translate(94.0 115.7) scale(0.1094)"><path d="' . esc_attr( $d ) . '" fill="#df0118"></path></g>';
	}
	echo '</svg>';
}

/**
 * Starburst points.
 */
function bellaworks_burst_points( $kind = 16 ) {
	if ( 20 === intval( $kind ) ) {
		return '90.0,0.0 102.2,13.0 117.8,4.4 125.4,20.5 142.9,17.2 145.2,34.8 162.8,37.1 159.5,54.6 175.6,62.2 167.0,77.8 180.0,90.0 167.0,102.2 175.6,117.8 159.5,125.4 162.8,142.9 145.2,145.2 142.9,162.8 125.4,159.5 117.8,175.6 102.2,167.0 90.0,180.0 77.8,167.0 62.2,175.6 54.6,159.5 37.1,162.8 34.8,145.2 17.2,142.9 20.5,125.4 4.4,117.8 13.0,102.2 0.0,90.0 13.0,77.8 4.4,62.2 20.5,54.6 17.2,37.1 34.8,34.8 37.1,17.2 54.6,20.5 62.2,4.4 77.8,13.0';
	}
	return '70.0,0.0 81.7,11.2 96.8,5.3 103.3,20.1 119.5,20.5 119.9,36.7 134.7,43.2 128.8,58.3 140.0,70.0 128.8,81.7 134.7,96.8 119.9,103.3 119.5,119.5 103.3,119.9 96.8,134.7 81.7,128.8 70.0,140.0 58.3,128.8 43.2,134.7 36.7,119.9 20.5,119.5 20.1,103.3 5.3,96.8 11.2,81.7 0.0,70.0 11.2,58.3 5.3,43.2 20.1,36.7 20.5,20.5 36.7,20.1 43.2,5.3 58.3,11.2';
}

/**
 * Starburst badge.
 *
 * @param string $big    Large text (e.g. "01", "15+").
 * @param string $small  Small caps line under it (optional).
 * @param string $fill   red | brown.
 * @param string $text   tan | brown.
 * @param int    $kind   16 (140 box) or 20 (180 box).
 * @param int    $size   Rendered px.
 * @param int    $rotate Degrees.
 */
function bellaworks_starburst( $big, $small = '', $fill = 'red', $text = 'tan', $kind = 16, $size = 140, $rotate = 0 ) {
	$box  = ( 20 === intval( $kind ) ) ? 180 : 140;
	$c    = $box / 2;
	$r    = ( 20 === intval( $kind ) ) ? 70 : 53;
	$fs   = ( 20 === intval( $kind ) ) ? 54 : 52;
	$y    = ( 20 === intval( $kind ) ) ? 92 : 86;
	$style = $rotate ? ' style="transform: rotate(' . intval( $rotate ) . 'deg);"' : '';
	echo '<svg class="starburst" width="' . intval( $size ) . '" height="' . intval( $size ) . '" viewBox="0 0 ' . $box . ' ' . $box . '" aria-hidden="true"' . $style . '>';
	echo '<polygon points="' . esc_attr( bellaworks_burst_points( $kind ) ) . '" fill="' . esc_attr( bellaworks_color( $fill ) ) . '"></polygon>';
	echo '<circle cx="' . $c . '" cy="' . $c . '" r="' . $r . '" fill="none" stroke="' . esc_attr( bellaworks_color( $text ) ) . '" stroke-width="2" stroke-dasharray="2 4"></circle>';
	echo '<text x="' . $c . '" y="' . $y . '" text-anchor="middle" font-family="Anton, Impact, sans-serif" font-size="' . $fs . '" fill="' . esc_attr( bellaworks_color( $text ) ) . '">' . esc_html( $big ) . '</text>';
	if ( $small ) {
		echo '<text x="' . $c . '" y="' . ( $y + 28 ) . '" text-anchor="middle" font-family="DM Sans, system-ui, sans-serif" font-weight="700" font-size="14" letter-spacing="4" fill="' . esc_attr( bellaworks_color( $text ) ) . '">' . esc_html( $small ) . '</text>';
	}
	echo '</svg>';
}

/**
 * Faint watermark texture. Place inside a `.section` (isolated, overflow hidden).
 *
 * @param string $kind    star | rings | halftone | monogram | burst.
 * @param string $color   tan | brown.
 * @param float  $opacity 0.06 - 0.20.
 * @param string $style   Positioning (left/top/width/height/transform).
 */
function bellaworks_watermark( $kind, $color, $opacity, $style ) {
	$c   = bellaworks_color( $color );
	$op  = floatval( $opacity );
	$vb  = '0 0 200 200';
	$inner = '';
	switch ( $kind ) {
		case 'star':
			$vb    = '0 0 24 24';
			$inner = '<path d="M12 1.6l2.9 6.6 7.1.7-5.4 4.8 1.6 7.1L12 17.2l-6.2 3.6 1.6-7.1L2 8.9l7.1-.7z" fill="none" stroke="' . $c . '" stroke-width="0.55" stroke-linejoin="round"></path>';
			break;
		case 'rings':
			$inner = '<circle cx="100" cy="100" r="94" fill="none" stroke="' . $c . '" stroke-width="1.5" stroke-dasharray="2 5"></circle><circle cx="100" cy="100" r="76" fill="none" stroke="' . $c . '" stroke-width="3"></circle><circle cx="100" cy="100" r="46" fill="none" stroke="' . $c . '" stroke-width="1.5" stroke-dasharray="2 5"></circle>';
			break;
		case 'burst':
			$vb    = '0 0 140 140';
			$inner = '<polygon points="' . bellaworks_burst_points( 16 ) . '" fill="none" stroke="' . $c . '" stroke-width="1.6" stroke-linejoin="round"></polygon><circle cx="70" cy="70" r="52" fill="none" stroke="' . $c . '" stroke-width="1.2" stroke-dasharray="2 4"></circle>';
			break;
		case 'monogram':
			$vb    = '0 0 1024 627';
			$inner = '<path d="' . esc_attr( bellaworks_monogram_path() ) . '" fill="' . $c . '"></path>';
			break;
		case 'halftone':
		default:
			$id    = 'ht-' . wp_unique_id();
			$inner = '<defs><pattern id="' . $id . 'p" width="10" height="10" patternUnits="userSpaceOnUse"><circle cx="5" cy="5" r="2.2" fill="' . $c . '"></circle></pattern>'
				. '<radialGradient id="' . $id . 'g" cx="50%" cy="50%" r="50%"><stop offset="0" stop-color="#fff"></stop><stop offset="1" stop-color="#000"></stop></radialGradient>'
				. '<mask id="' . $id . 'm"><rect width="200" height="200" fill="url(#' . $id . 'g)"></rect></mask></defs>'
				. '<rect width="200" height="200" fill="url(#' . $id . 'p)" mask="url(#' . $id . 'm)"></rect>';
			break;
	}
	echo '<svg class="wm" aria-hidden="true" viewBox="' . esc_attr( $vb ) . '" style="opacity: ' . esc_attr( $op ) . '; ' . esc_attr( $style ) . '">' . $inner . '</svg>';
}

/**
 * Retro decoder: "i" icon + styled tooltip.
 * Each retro object gets its own name; the icon is positioned per object in
 * _components.scss (.retro-info--{name}) as percentages of the artwork, so it
 * scales with the image. Place inside `.retro-object.retro-object--{name}`.
 *
 * @param string $text   One-sentence tooltip.
 * @param string $object rolodex | typewriter | ... (must have a CSS rule).
 */
function bellaworks_retro_info( $text, $object = 'rolodex' ) {
	$object = sanitize_html_class( $object );
	echo '<div class="retro-info retro-info--' . esc_attr( $object ) . '">';
	// Font Awesome Pro 5 regular "info-circle" (FA6 name: fa-regular fa-circle-info).
	echo '<button type="button" class="retro-info__btn" aria-label="' . esc_attr__( 'What is this?', 'bellaworks' ) . '"><i class="far fa-info-circle" aria-hidden="true"></i></button>';
	echo '<div class="retro-info__tip" role="tooltip">' . esc_html( $text ) . '</div>';
	echo '</div>';
}

/**
 * Stroke icons for the Solutions strip.
 */
function bellaworks_icon( $name, $size = 64 ) {
	$paths = array(
		'copy'      => '<path d="M12 20h9"></path><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"></path>',
		'design'    => '<rect x="3" y="4" width="18" height="16" rx="2"></rect><path d="M3 9h18"></path><path d="M9 14l-2 2 2 2"></path><path d="M15 14l2 2-2 2"></path>',
		'hosting'   => '<rect x="3" y="4" width="18" height="6" rx="1.5"></rect><rect x="3" y="14" width="18" height="6" rx="1.5"></rect><path d="M7 7h.01"></path><path d="M7 17h.01"></path>',
		'marketing' => '<path d="M3 11v2a1 1 0 0 0 1 1h2l6 4V6L6 10H4a1 1 0 0 0-1 1z"></path><path d="M16 9a4 4 0 0 1 0 6"></path><path d="M18.5 6.5a8 8 0 0 1 0 11"></path>',
		'seo'       => '<circle cx="10" cy="11" r="6"></circle><path d="M14.5 15.5L20 21"></path><path d="M18.5 2.5l.9 2.1 2.1.9-2.1.9-.9 2.1-.9-2.1-2.1-.9 2.1-.9z"></path>',
	);
	$p = ( isset( $paths[ $name ] ) ) ? $paths[ $name ] : '';
	echo '<svg width="' . intval( $size ) . '" height="' . intval( $size ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $p . '</svg>';
}
