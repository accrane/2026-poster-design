<?php
/**
 * Single service (post type: service).
 *
 * Every service carries its own ACF group with the same shape:
 * row1_title (textarea, <strong> = script line), row1_content, then
 * row2/row3 content_left + content_right (wysiwyg). A right column with
 * no <h2> is a callout ("Dots" in the old theme) and renders as a script
 * pull quote. The "FAQ's" group (section_title, faqs[question, answer])
 * applies to every service.
 *
 * @package bellaworks
 */

get_header();
the_post();

$allowed = array(
	'p' => array(), 'br' => array(), 'strong' => array(), 'em' => array(), 'b' => array(), 'i' => array(),
	'ul' => array(), 'ol' => array(), 'li' => array(), 'h2' => array( 'class' => array() ), 'h3' => array( 'class' => array() ),
	'a' => array( 'href' => array(), 'target' => array(), 'rel' => array() ),
);

$icon_by_slug = array(
	'website-copywriting'        => 'copy',
	'website-design-development' => 'design',
	'website-hosting'            => 'hosting',
	'digital-marketing'          => 'marketing',
	'seo'                        => 'seo',
);
$icon = isset( $icon_by_slug[ get_post_field( 'post_name' ) ] ) ? $icon_by_slug[ get_post_field( 'post_name' ) ] : 'design';

// Hero title: plain line(s) + <strong> as the red script line (same rule as About).
$row1_title = get_field( 'row1_title' );
$title_html = $row1_title ? wp_kses( $row1_title, array( 'strong' => array(), 'br' => array() ) ) : get_the_title();
$title_html = preg_replace( '/\s*(<br\s*\/?>\s*)+/i', '<br>', $title_html );
$title_html = preg_replace_callback( '/<br>\s*<strong>(.*?)<\/strong>/is', function ( $m ) {
	$t = trim( $m[1] );
	if ( strtoupper( $t ) === $t ) {
		$t = ucfirst( strtolower( $t ) );
	}
	return '<span class="script page-hero__script">' . $t . '</span>';
}, $title_html );
$title_html = preg_replace( '/<strong>(.*?)<\/strong>/is', '<span class="text-red">$1</span>', $title_html );

$row1_content = get_field( 'row1_content' );

/**
 * Prepare a wysiwyg column: sanitize, give <h2> the display face, and
 * flag columns with no heading as callouts.
 */
function bellaworks_service_col( $html, $allow_callout = false ) {
	$html = trim( (string) $html );
	if ( ! $html ) {
		return null;
	}
	$html = wp_kses( $html, $GLOBALS['bellaworks_service_allowed'] );
	// Hidden for now: the Brochure Website "Learn More" link out to webjoy.site.
	$html = preg_replace( '/<p>\s*<a[^>]*webjoy\.site[^>]*>.*?<\/a>\s*<\/p>/is', '', $html );
	$html = preg_replace( '/<a[^>]*webjoy\.site[^>]*>(.*?)<\/a>/is', '$1', $html );
	$html = preg_replace( '/<p>(?:\s|&nbsp;)*<\/p>/i', '', $html );
	// Callout = the right column, no heading, short enough to set in the script face.
	$plain      = trim( wp_strip_all_tags( $html ) );
	$is_callout = $allow_callout && false === stripos( $html, '<h2' ) && false === stripos( $html, '<h3' ) && mb_strlen( $plain ) <= 260;
	if ( $is_callout ) {
		return array( 'callout' => true, 'text' => trim( wp_strip_all_tags( $html ) ) );
	}
	$html = preg_replace( '/<h2[^>]*>/i', '<h2 class="display service-row__heading">', $html );
	$html = preg_replace( '/<h3[^>]*>/i', '<h3 class="display service-row__heading">', $html );
	return array( 'callout' => false, 'html' => wpautop( $html ) );
}
$GLOBALS['bellaworks_service_allowed'] = $allowed;

$rows = array();
foreach ( array( 2, 3 ) as $n ) {
	$left  = bellaworks_service_col( get_field( "row{$n}_content_left" ) );
	$right = bellaworks_service_col( get_field( "row{$n}_content_right" ), true );
	if ( $left || $right ) {
		$rows[] = array( 'left' => $left, 'right' => $right );
	}
}

$faq_title = get_field( 'section_title' );
$faqs      = get_field( 'faqs' );
$faqs      = is_array( $faqs ) ? array_values( array_filter( $faqs, function ( $f ) { return ! empty( $f['question'] ); } ) ) : array();

// Alternate section colors: hero tan, rows red/brown, FAQ tan, steps never after another brown.
$palette = array( 'red', 'brown' );
$last    = 'tan';
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<!-- HERO -->
		<section class="section section--tan page-hero service-hero">
			<?php bellaworks_watermark( 'halftone', 'brown', 0.12, 'left: -120px; bottom: -140px; width: 460px; height: 460px;' ); ?>
			<div class="wrapper page-hero__grid">
				<div class="page-hero__copy">
					<div class="page-hero__eyebrow">
						<?php bellaworks_star( 18, 'red' ); ?>
						<span class="label"><?php the_title(); ?></span>
					</div>
					<h1 class="display page-hero__title"><?php echo $title_html; // phpcs:ignore -- sanitized above ?></h1>
					<?php if ( $row1_content ) : ?>
					<div class="page-hero__text"><?php echo wp_kses( $row1_content, $allowed ); ?></div>
					<?php endif; ?>
					<?php bellaworks_button( 'Book A Call', home_url( '/lets-do-this/' ), 'brown' ); ?>
				</div>
				<div class="page-hero__art-col">
					<div class="service-seal" aria-hidden="true">
						<?php bellaworks_icon( $icon, 150 ); ?>
						<?php bellaworks_star( 22, 'red' ); ?>
					</div>
				</div>
			</div>
			<div class="label page-hero__vertical">Simple • Beautiful • Secure</div>
		</section>

		<!-- CONTENT ROWS -->
		<?php foreach ( $rows as $i => $row ) :
			$color = $palette[ $i % 2 ];
			$last  = $color;
			$ink   = 'tan';
			?>
		<section class="section section--<?php echo esc_attr( $color ); ?> service-row">
			<?php if ( 0 === $i ) { bellaworks_watermark( 'burst', $ink, 0.16, 'right: -120px; top: -140px; width: 520px; height: 520px; transform: rotate(-10deg);' ); } else { bellaworks_watermark( 'halftone', $ink, 0.18, 'left: -160px; bottom: -160px; width: 560px; height: 560px;' ); } ?>
			<div class="wrapper service-row__grid">
				<?php foreach ( array( 'left', 'right' ) as $side ) : $col = $row[ $side ]; if ( ! $col ) { continue; } ?>
				<?php if ( $col['callout'] ) : ?>
				<div class="service-row__col service-row__col--aside">
					<?php bellaworks_star( 26, 'red' === $color ? 'brown' : 'red' ); ?>
					<p class="script service-row__quote"><?php echo esc_html( $col['text'] ); ?></p>
				</div>
				<?php else : ?>
				<div class="service-row__col"><?php echo $col['html']; // phpcs:ignore -- kses'd in bellaworks_service_col ?></div>
				<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</section>
		<?php endforeach; ?>

		<!-- FAQ -->
		<?php if ( $faqs ) : $last = 'tan'; ?>
		<section class="section section--tan faq">
			<?php bellaworks_watermark( 'rings', 'brown', 0.10, 'right: -160px; top: -120px; width: 620px; height: 620px;' ); ?>
			<div class="wrapper faq__inner">
				<div class="faq__head">
					<h2 class="display"><?php echo esc_html( $faq_title ? $faq_title : __( 'FAQs', 'bellaworks' ) ); ?></h2>
					<?php bellaworks_star( 44, 'red' ); ?>
				</div>
				<div class="faq__list">
					<?php foreach ( $faqs as $f ) : ?>
					<details class="faq__item">
						<summary><span class="faq__mark"></span><span><?php echo esc_html( $f['question'] ); ?></span></summary>
						<div class="faq__answer"><?php echo wp_kses( wpautop( $f['answer'] ), $allowed ); ?></div>
					</details>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php endif; ?>

		<!-- STEPS -->
		<?php get_template_part( 'parts/steps', null, array( 'color' => 'brown' === $last ? 'tan' : 'brown' ) ); ?>

	</main>
</div>

<?php get_footer(); ?>
