<?php
/**
 * Single case study (post type: case_study).
 *
 * Sections alternate red / tan / brown after the tan hero; anything left
 * empty in the fields is skipped, and the colours re-flow around it.
 *
 * @package bellaworks
 */

get_header();
the_post();

$allowed = array( 'p' => array(), 'br' => array(), 'strong' => array(), 'em' => array(), 'ul' => array(), 'ol' => array(), 'li' => array(), 'a' => array( 'href' => array(), 'target' => array(), 'rel' => array() ), 'h3' => array() );

$client   = get_field( 'client' ) ? get_field( 'client' ) : get_the_title();
$industry = get_field( 'industry' );
$summary  = get_field( 'summary' );
$site_url = get_field( 'website_url' );
$hero     = get_field( 'hero_image' );
$hero_id  = ! empty( $hero['ID'] ) ? $hero['ID'] : get_post_thumbnail_id();
$services = array_filter( array_map( 'get_post', (array) get_field( 'services' ) ) );
$project  = get_field( 'project' ) ? get_post( get_field( 'project' ) ) : null;
$stats    = array_values( array_filter( (array) get_field( 'stats' ), function ( $s ) { return ! empty( $s['value'] ); } ) );
$quote    = trim( (string) get_field( 'quote' ) );
$quote_by = get_field( 'quote_by' );
$gallery  = array_filter( (array) get_field( 'gallery' ), function ( $g ) { return ! empty( $g['ID'] ); } );

$story = array();
foreach ( array( 'challenge' => __( 'The challenge', 'bellaworks' ), 'approach' => __( 'What we did', 'bellaworks' ), 'results' => __( 'The results', 'bellaworks' ) ) as $key => $heading ) {
	$html = trim( (string) get_field( $key ) );
	if ( $html ) {
		$story[] = array( 'heading' => $heading, 'html' => wpautop( wp_kses( $html, $allowed ) ), 'key' => $key );
	}
}

$cycle = array( 'red', 'tan', 'brown' );
$n     = 0;
$last  = 'tan';
function bellaworks_cs_color( &$n, $cycle, &$last ) { $c = $cycle[ $n % 3 ]; $n++; $last = $c; return $c; }
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<!-- HERO -->
		<section class="section section--tan page-hero case-hero">
			<?php bellaworks_watermark( 'halftone', 'brown', 0.12, 'left: -120px; bottom: -140px; width: 460px; height: 460px;' ); ?>
			<div class="wrapper case-hero__inner">
				<div class="page-hero__grid">
					<div class="page-hero__copy">
						<div class="page-hero__eyebrow">
							<?php bellaworks_star( 18, 'red' ); ?>
							<a class="label" href="<?php echo esc_url( home_url( '/case-studies/' ) ); ?>"><?php esc_html_e( 'Case Study', 'bellaworks' ); ?></a>
							<?php if ( $industry ) : ?><span class="label case-hero__sep" aria-hidden="true">&bull;</span><span class="label"><?php echo esc_html( $industry ); ?></span><?php endif; ?>
						</div>
						<h1 class="display page-hero__title"><?php the_title(); ?></h1>
						<?php if ( $summary ) : ?><p class="script case-hero__summary"><?php echo esc_html( $summary ); ?></p><?php endif; ?>
					</div>
					<div class="page-hero__art-col case-hero__meta-col">
						<dl class="case-meta">
							<div><dt class="label"><?php esc_html_e( 'Client', 'bellaworks' ); ?></dt><dd><?php echo esc_html( $client ); ?></dd></div>
							<?php if ( $industry ) : ?><div><dt class="label"><?php esc_html_e( 'Industry', 'bellaworks' ); ?></dt><dd><?php echo esc_html( $industry ); ?></dd></div><?php endif; ?>
							<?php if ( $services ) : ?><div><dt class="label"><?php esc_html_e( 'Services', 'bellaworks' ); ?></dt><dd><?php echo implode( ', ', array_map( function ( $s ) { return '<a href="' . esc_url( get_permalink( $s ) ) . '">' . esc_html( get_the_title( $s ) ) . '</a>'; }, $services ) ); // phpcs:ignore ?></dd></div><?php endif; ?>
							<?php if ( $site_url ) : ?><div><dt class="label"><?php esc_html_e( 'Website', 'bellaworks' ); ?></dt><dd><a href="<?php echo esc_url( $site_url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( preg_replace( '#^https?://(www\.)?|/$#', '', $site_url ) ); ?></a></dd></div><?php endif; ?>
						</dl>
					</div>
				</div>
				<?php if ( $hero_id ) : ?>
				<div class="thumb-card case-hero__banner"><?php echo wp_get_attachment_image( $hero_id, 'bellaworks-banner', false, array( 'loading' => 'eager', 'decoding' => 'async', 'alt' => get_the_title() ) ); ?></div>
				<?php endif; ?>
			</div>
		</section>

		<!-- STATS -->
		<?php if ( $stats ) : $color = bellaworks_cs_color( $n, $cycle, $last ); ?>
		<section class="section section--<?php echo esc_attr( $color ); ?> case-stats">
			<?php bellaworks_watermark( 'star', 'tan' === $color ? 'brown' : 'tan', 0.12, 'left: -150px; top: -150px; width: 560px; height: 560px; transform: rotate(-14deg);' ); ?>
			<div class="wrapper case-stats__grid case-stats__grid--<?php echo count( $stats ); ?>">
				<?php foreach ( $stats as $st ) : ?>
				<div class="case-stats__item">
					<span class="display case-stats__value"><?php echo esc_html( $st['value'] ); ?></span>
					<span class="label case-stats__label"><?php echo esc_html( $st['label'] ); ?></span>
				</div>
				<?php endforeach; ?>
			</div>
		</section>
		<?php endif; ?>

		<!-- STORY -->
		<?php foreach ( $story as $part ) : $color = bellaworks_cs_color( $n, $cycle, $last ); ?>
		<section class="section section--<?php echo esc_attr( $color ); ?> case-section case-section--<?php echo esc_attr( $part['key'] ); ?>">
			<?php if ( 'approach' === $part['key'] ) { bellaworks_watermark( 'halftone', 'tan' === $color ? 'brown' : 'tan', 0.14, 'right: -160px; bottom: -160px; width: 560px; height: 560px;' ); } else { bellaworks_watermark( 'rings', 'tan' === $color ? 'brown' : 'tan', 0.08, 'right: -200px; top: -160px; width: 700px; height: 700px;' ); } ?>
			<div class="wrapper case-section__grid">
				<div class="case-section__head">
					<?php bellaworks_star( 26, 'red' === $color ? 'brown' : 'red' ); ?>
					<h2 class="display"><?php echo esc_html( $part['heading'] ); ?></h2>
				</div>
				<div class="case-section__body prose"><?php echo $part['html']; // phpcs:ignore -- kses'd above ?></div>
			</div>
			<?php if ( 'results' === $part['key'] && $gallery ) : ?>
			<div class="wrapper case-gallery">
				<?php foreach ( $gallery as $g ) : ?>
				<div class="thumb-card case-gallery__item"><?php echo wp_get_attachment_image( $g['ID'], 'bellaworks-banner', false, array( 'loading' => 'lazy', 'decoding' => 'async', 'alt' => ! empty( $g['alt'] ) ? $g['alt'] : get_the_title() ) ); ?></div>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</section>
		<?php endforeach; ?>

		<!-- QUOTE -->
		<?php if ( $quote ) : $color = bellaworks_cs_color( $n, $cycle, $last ); ?>
		<section class="section section--<?php echo esc_attr( $color ); ?> case-quote">
			<?php bellaworks_watermark( 'burst', 'tan' === $color ? 'brown' : 'tan', 0.14, 'right: -120px; top: -140px; width: 520px; height: 520px; transform: rotate(-10deg);' ); ?>
			<div class="wrapper case-quote__inner">
				<?php bellaworks_stamp( 'SIMPLE • BEAUTIFUL • SECURE • ', 150 ); ?>
				<blockquote class="case-quote__text">
					<p>&ldquo;<?php echo esc_html( trim( $quote, "\"“”" ) ); ?>&rdquo;</p>
					<?php if ( $quote_by ) : ?><cite class="label">&mdash; <?php echo esc_html( $quote_by ); ?></cite><?php endif; ?>
				</blockquote>
			</div>
		</section>
		<?php endif; ?>

		<!-- RELATED PROJECT + CTA -->
		<?php if ( 'brown' === $last ) : ?>
			<?php get_template_part( 'parts/steps', null, array( 'color' => 'tan' ) ); ?>
		<?php else : ?>
		<section class="section section--brown closer case-closer">
			<?php bellaworks_watermark( 'halftone', 'tan', 0.14, 'left: -180px; bottom: -180px; width: 520px; height: 520px;' ); ?>
			<div class="wrapper closer__inner">
				<?php bellaworks_star_rule( 'tan' ); ?>
				<?php if ( $project ) : ?>
				<p class="label case-closer__link"><a href="<?php echo esc_url( get_permalink( $project ) ); ?>"><?php echo esc_html( sprintf( __( 'See the %s project', 'bellaworks' ), get_the_title( $project ) ) ); ?><?php bellaworks_arrow(); ?></a></p>
				<?php endif; ?>
				<h2 class="display closer__title">Creating stunning websites <span class="text-red">that also drive results.</span></h2>
				<?php bellaworks_button( 'Book A Call', home_url( '/lets-do-this/' ), 'red', 'lg' ); ?>
			</div>
		</section>
		<?php endif; ?>

	</main>
</div>

<?php get_footer(); ?>
