<?php
/**
 * Single project (post type: portfolio).
 *
 * Reads the ACF "Portfolio" flexible content (acf-json/group_66292c24bbc72.json)
 * and flattens it: every project carries intro_block, second_section,
 * third_section, hero and color_palette; detail_photos is optional.
 *
 * @package bellaworks
 */

get_header();
the_post();

$d = array( 'photos' => array() );
if ( function_exists( 'have_rows' ) ) {
	while ( have_rows( 'blocks' ) ) {
		the_row();
		switch ( get_row_layout() ) {
			case 'intro_block':
				$d['client_logo'] = get_sub_field( 'client_logo' );
				$d['intro_text']  = get_sub_field( 'intro_text' );
				break;
			case 'hero':
				if ( empty( $d['hero_image'] ) ) {
					$d['hero_image'] = get_sub_field( 'hero_image' );
				}
				break;
			case 'second_section':
				$d['color_logo'] = get_sub_field( 'color_logo' );
				$d['blurb']      = get_sub_field( 'small_blurg' );
				break;
			case 'third_section':
				$d['detail_photo']    = get_sub_field( 'detail_photo' );
				$d['detail_photo2']   = get_sub_field( 'detail_photo2' );
				$d['full_site_photo'] = get_sub_field( 'full_site_photo' );
				$d['key_features']    = get_sub_field( 'key_features' );
				$d['website_url']     = get_sub_field( 'website__url' );
				break;
			case 'color_palette':
				$d['colors']      = get_sub_field( 'colors' );
				$d['colors_note'] = get_sub_field( 'colors_description' );
				$d['testimonial'] = get_sub_field( 'text_field' );
				break;
			case 'detail_photos':
				foreach ( (array) get_sub_field( 'photos' ) as $row ) {
					if ( ! empty( $row['photo'] ) ) {
						$d['photos'][] = $row['photo'];
					}
				}
				break;
		}
	}
}

$terms = get_the_terms( get_the_ID(), 'business-type' );
$type  = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';

$site_url  = ! empty( $d['website_url'] ) ? $d['website_url'] : '';
$site_host = $site_url ? preg_replace( '/^www\./', '', (string) wp_parse_url( $site_url, PHP_URL_HOST ) ) : '';

// Blurb: plain paragraphs (strip Google Sheets paste markup).
$blurb = ! empty( $d['blurb'] ) ? wp_kses( $d['blurb'], array( 'p' => array(), 'br' => array(), 'strong' => array(), 'em' => array(), 'a' => array( 'href' => array() ) ) ) : '';

// Key features: pull the <li> items so they can get star bullets.
$features = array();
if ( ! empty( $d['key_features'] ) && preg_match_all( '/<li[^>]*>(.*?)<\/li>/is', $d['key_features'], $m ) ) {
	foreach ( $m[1] as $li ) {
		$li = trim( wp_strip_all_tags( $li ) );
		if ( $li ) {
			$features[] = $li;
		}
	}
}

// Palette note: skip placeholder text.
$colors_note = ! empty( $d['colors_note'] ) && stripos( $d['colors_note'], 'lorem ipsum' ) === false ? trim( wp_strip_all_tags( $d['colors_note'] ) ) : '';
$colors      = ! empty( $d['colors'] ) ? array_values( array_filter( array_map( function ( $c ) { return isset( $c['color'] ) ? sanitize_hex_color( $c['color'] ) : ''; }, (array) $d['colors'] ) ) ) : array();

// Testimonial: strip markup and the outer quotation marks; the template adds its own.
$quote = '';
$cite  = '';
if ( ! empty( $d['testimonial'] ) ) {
	$quote = html_entity_decode( wp_strip_all_tags( $d['testimonial'] ), ENT_QUOTES, 'UTF-8' );
	$quote = trim( preg_replace( '/\s+/u', ' ', str_replace( "\xc2\xa0", ' ', $quote ) ) );
	$quote = ltrim( $quote, "\"“”'‘’ " );
	// A short name after the closing quotation mark is the attribution.
	if ( preg_match( '/^(.*?[.!?])\s*["”]\s*(?:[-–—]\s*)?([A-Z][\w.&,\'’\s-]{1,60})$/su', $quote, $qm ) ) {
		$quote = trim( $qm[1] );
		$cite  = trim( $qm[2], " -–—" );
	}
	$quote = rtrim( $quote, "\"“”'‘’ " );
}

// Gallery: extra detail photos (and the second detail photo when present).
$gallery = $d['photos'];
if ( ! empty( $d['detail_photo2'] ) ) {
	array_unshift( $gallery, $d['detail_photo2'] );
}

// Previous / next in menu order.
$ids  = get_posts( array( 'post_type' => 'portfolio', 'post_status' => 'publish', 'posts_per_page' => -1, 'orderby' => array( 'menu_order' => 'ASC', 'date' => 'DESC' ), 'fields' => 'ids' ) );
$idx  = array_search( get_the_ID(), $ids, true );
$prev = ( false !== $idx && $idx > 0 ) ? $ids[ $idx - 1 ] : 0;
$next = ( false !== $idx && $idx < count( $ids ) - 1 ) ? $ids[ $idx + 1 ] : 0;

// Slide image: the featured image (same cover as the Work grid), else the detail photo.
$slide_id = get_post_thumbnail_id();
if ( ! $slide_id && ! empty( $d['detail_photo']['ID'] ) ) {
	$slide_id = $d['detail_photo']['ID'];
}
$has_slide = (bool) $slide_id;
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<!-- HERO + BANNER (tan) -->
		<section class="section section--tan page-hero project-hero">
			<?php bellaworks_watermark( 'rings', 'brown', 0.10, 'right: -160px; top: -120px; width: 620px; height: 620px;' ); ?>
			<div class="project-hero__top">
				<div class="wrapper page-hero__grid">
					<div class="page-hero__copy">
						<div class="page-hero__eyebrow">
							<?php bellaworks_star( 18, 'red' ); ?>
							<span class="label"><?php echo esc_html( $type ? $type : __( 'Our Work', 'bellaworks' ) ); ?></span>
						</div>
						<h1 class="display page-hero__title"><?php the_title(); ?></h1>
						<?php if ( $blurb ) : ?>
						<div class="page-hero__text"><?php echo wpautop( $blurb ); // phpcs:ignore -- kses'd above ?></div>
						<?php endif; ?>
						<div class="project-hero__actions">
							<?php if ( $site_url ) : ?>
							<a href="<?php echo esc_url( $site_url ); ?>" class="btn btn--red" target="_blank" rel="noopener"><?php esc_html_e( 'View Website', 'bellaworks' ); ?><?php bellaworks_arrow(); ?></a>
							<?php endif; ?>
							<a class="project-hero__back" href="<?php echo esc_url( home_url( '/our-work/' ) ); ?>"><?php bellaworks_arrow(); ?><?php esc_html_e( 'All Work', 'bellaworks' ); ?></a>
						</div>
					</div>
					<?php if ( $has_slide ) : ?>
					<div class="page-hero__art-col">
						<div class="page-hero__art retro-object--slide">
							<div class="slide">
								<span class="label slide__label slide__label--top"><?php echo esc_html( $site_host ? $site_host : get_the_title() ); ?></span>
								<span class="slide__num"><?php echo esc_html( sprintf( '%02d', ( false !== $idx ? $idx : 0 ) + 1 ) ); ?></span>
								<span class="slide__window"><?php echo wp_get_attachment_image( $slide_id, 'bellaworks-work', false, array( 'alt' => get_the_title(), 'loading' => 'eager', 'decoding' => 'async' ) ); ?></span>
								<span class="label slide__label slide__label--bottom"><?php esc_html_e( 'Bellaworks Web Design', 'bellaworks' ); ?></span>
							</div>
						</div>
					</div>
					<?php endif; ?>
				</div>
				<div class="label page-hero__vertical">Simple • Beautiful • Secure</div>
			</div>
			<?php if ( ! empty( $d['hero_image']['ID'] ) ) : ?>
			<div class="wrapper project-hero__banner">
				<div class="thumb-card"><?php echo wp_get_attachment_image( $d['hero_image']['ID'], 'bellaworks-banner', false, array( 'alt' => get_the_title() . ' ' . __( 'website', 'bellaworks' ), 'loading' => 'lazy', 'decoding' => 'async' ) ); ?></div>
			</div>
			<?php endif; ?>
		</section>

		<!-- KEY FEATURES + FULL SITE (red) -->
		<?php if ( $features || ! empty( $d['full_site_photo']['ID'] ) ) : ?>
		<section class="section section--red project-features">
			<?php bellaworks_watermark( 'star', 'tan', 0.12, 'left: -150px; top: -150px; width: 560px; height: 560px; transform: rotate(-14deg);' ); ?>
			<div class="wrapper project-features__grid">
				<div class="project-features__copy">
					<h2 class="display"><?php esc_html_e( 'Key Features', 'bellaworks' ); ?></h2>
					<?php if ( $features ) : ?>
					<ul class="project-features__list">
						<?php foreach ( $features as $f ) : ?>
						<li><?php bellaworks_star( 16, 'brown' ); ?><span><?php echo esc_html( $f ); ?></span></li>
						<?php endforeach; ?>
					</ul>
					<?php elseif ( ! empty( $d['key_features'] ) ) : ?>
					<div class="project-features__text"><?php echo wp_kses_post( $d['key_features'] ); ?></div>
					<?php endif; ?>
					<?php if ( $site_url ) : ?>
					<a href="<?php echo esc_url( $site_url ); ?>" class="btn btn--tan" target="_blank" rel="noopener"><?php esc_html_e( 'View Website', 'bellaworks' ); ?><?php bellaworks_arrow(); ?></a>
					<?php endif; ?>
				</div>
				<?php if ( ! empty( $d['full_site_photo']['ID'] ) ) : ?>
				<div class="project-features__shot">
					<div class="thumb-card site-scroll" title="<?php esc_attr_e( 'Hover to scroll the page', 'bellaworks' ); ?>"><?php echo wp_get_attachment_image( $d['full_site_photo']['ID'], 'bellaworks-tall', false, array( 'alt' => get_the_title() . ' ' . __( 'full page', 'bellaworks' ), 'loading' => 'lazy', 'decoding' => 'async' ) ); ?></div>
					<span class="label project-features__hint"><?php esc_html_e( 'Hover to scroll the page', 'bellaworks' ); ?></span>
				</div>
				<?php endif; ?>
			</div>
		</section>
		<?php endif; ?>

		<!-- PALETTE + TESTIMONIAL (brown) -->
		<?php if ( $colors || $colors_note || $quote || ! empty( $d['color_logo']['ID'] ) ) : ?>
		<section class="section section--brown project-palette">
			<?php bellaworks_watermark( 'halftone', 'tan', 0.14, 'right: -160px; bottom: -160px; width: 560px; height: 560px;' ); ?>
			<div class="wrapper project-palette__grid">
				<div class="project-palette__brand">
					<?php if ( ! empty( $d['color_logo']['ID'] ) ) : ?>
					<div class="project-palette__logo"><?php echo wp_get_attachment_image( $d['color_logo']['ID'], 'medium', false, array( 'alt' => get_the_title() . ' ' . __( 'logo', 'bellaworks' ), 'loading' => 'lazy' ) ); ?></div>
					<?php endif; ?>
					<?php if ( $colors_note ) : ?>
					<p class="script project-palette__note"><?php echo esc_html( $colors_note ); ?></p>
					<?php endif; ?>
					<?php if ( $colors ) : ?>
					<div class="project-palette__chips">
						<?php foreach ( $colors as $hex ) : ?>
						<div class="project-palette__chip"><span style="background: <?php echo esc_attr( $hex ); ?>;"></span><span class="label"><?php echo esc_html( $hex ); ?></span></div>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>
				</div>
				<?php if ( $quote ) : ?>
				<blockquote class="project-palette__quote">
					<?php bellaworks_stamp( 'SIMPLE • BEAUTIFUL • SECURE • ', 150 ); ?>
					<p>&ldquo;<?php echo esc_html( $quote ); ?>&rdquo;</p>
					<?php if ( $cite ) : ?>
					<cite class="label">&mdash; <?php echo esc_html( $cite ); ?></cite>
					<?php endif; ?>
				</blockquote>
				<?php endif; ?>
			</div>
		</section>
		<?php endif; ?>

		<!-- GALLERY + PREV/NEXT (tan) -->
		<section class="section section--tan project-nav">
			<?php if ( $gallery ) : ?>
			<div class="wrapper project-gallery">
				<div class="project-gallery__grid">
					<?php foreach ( $gallery as $g ) : if ( empty( $g['ID'] ) ) { continue; } ?>
					<div class="thumb-card"><?php echo wp_get_attachment_image( $g['ID'], 'bellaworks-banner', false, array( 'alt' => get_the_title(), 'loading' => 'lazy', 'decoding' => 'async' ) ); ?></div>
					<?php endforeach; ?>
				</div>
			</div>
			<?php endif; ?>
			<div class="wrapper project-nav__inner">
				<?php bellaworks_star_rule( 'red' ); ?>
				<div class="project-nav__row">
					<?php if ( $prev ) : ?>
					<a class="project-nav__link project-nav__link--prev" href="<?php echo esc_url( get_permalink( $prev ) ); ?>"><span class="label"><?php esc_html_e( 'Previous', 'bellaworks' ); ?></span><span class="display"><?php echo esc_html( get_the_title( $prev ) ); ?></span></a>
					<?php endif; ?>
					<?php if ( $next ) : ?>
					<a class="project-nav__link project-nav__link--next" href="<?php echo esc_url( get_permalink( $next ) ); ?>"><span class="label"><?php esc_html_e( 'Next', 'bellaworks' ); ?></span><span class="display"><?php echo esc_html( get_the_title( $next ) ); ?></span></a>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<!-- CLOSING BAND -->
		<section class="section section--brown closer">
			<?php bellaworks_watermark( 'halftone', 'tan', 0.14, 'left: -180px; bottom: -180px; width: 520px; height: 520px;' ); ?>
			<div class="wrapper closer__inner">
				<?php bellaworks_star_rule( 'tan' ); ?>
				<h2 class="display closer__title">Creating stunning websites <span class="text-red">that also drive results.</span></h2>
				<?php bellaworks_button( 'Book A Call', home_url( '/lets-do-this/' ), 'red', 'lg' ); ?>
			</div>
		</section>

	</main>
</div>

<?php get_footer(); ?>
