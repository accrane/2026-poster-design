<?php
/**
 * Template for the Services page (slug: services).
 *
 * ACF group "Services" (acf-json/group_66b435a87e56e.json): row1_title
 * (textarea; a <small> line becomes the script accent) and row1_blocks
 * (repeater: name, link -> a `service` post). Each block pulls its
 * service's excerpt and permalink.
 *
 * @package bellaworks
 */

get_header();

$row1_title  = function_exists( 'get_field' ) ? get_field( 'row1_title' ) : '';
$row1_blocks = function_exists( 'get_field' ) ? get_field( 'row1_blocks' ) : array();

// Title: "OUR WEBSITE\nSOLUTIONS\n<small>(We Got You Covered)</small>" -> display lines + script line.
$title_html  = '';
$script_line = '';
if ( $row1_title ) {
	if ( preg_match( '/<small[^>]*>(.*?)<\/small>/is', $row1_title, $m ) ) {
		$script_line = trim( wp_strip_all_tags( $m[1] ) );
		$row1_title  = str_replace( $m[0], '', $row1_title );
	}
	$lines = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n|<br\s*\/?>/i', wp_strip_all_tags( $row1_title ) ) ) );
	$title_html = implode( '<br>', array_map( 'esc_html', $lines ) );
}
if ( ! $title_html ) {
	$title_html = esc_html( get_the_title() );
}

// Icon per service, keyed by the service post slug (falls back to block order).
$icon_by_slug = array(
	'website-copywriting'        => 'copy',
	'website-design-development' => 'design',
	'website-hosting'            => 'hosting',
	'digital-marketing'          => 'marketing',
	'seo'                        => 'seo',
);
$icon_by_index = array_values( $icon_by_slug );

$services = array();
foreach ( (array) $row1_blocks as $i => $b ) {
	$link = ! empty( $b['link'] ) ? $b['link'] : '';
	$pid  = $link ? url_to_postid( $link ) : 0;
	$post_obj = $pid ? get_post( $pid ) : null;
	$slug = $post_obj ? $post_obj->post_name : '';
	$services[] = array(
		'name'    => ! empty( $b['name'] ) ? wp_kses( nl2br( wp_strip_all_tags( $b['name'] ) ), array( 'br' => array() ) ) : ( $post_obj ? esc_html( $post_obj->post_title ) : '' ),
		'title'   => $post_obj ? $post_obj->post_title : wp_strip_all_tags( $b['name'] ),
		'excerpt' => $post_obj ? get_the_excerpt( $post_obj ) : '',
		'url'     => $post_obj ? get_permalink( $post_obj ) : $link,
		'icon'    => isset( $icon_by_slug[ $slug ] ) ? $icon_by_slug[ $slug ] : ( isset( $icon_by_index[ $i ] ) ? $icon_by_index[ $i ] : 'design' ),
	);
}
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<!-- PAGE HERO -->
		<section class="section section--tan page-hero services-hero">
			<?php bellaworks_watermark( 'halftone', 'brown', 0.12, 'left: -120px; bottom: -140px; width: 460px; height: 460px;' ); ?>
			<div class="wrapper page-hero__grid">
				<div class="page-hero__copy">
					<div class="page-hero__eyebrow">
						<?php bellaworks_star( 18, 'red' ); ?>
						<span class="label"><?php the_title(); ?></span>
					</div>
					<h1 class="display page-hero__title"><?php echo $title_html; // phpcs:ignore -- escaped above ?><?php if ( $script_line ) : ?><span class="script page-hero__script"><?php echo esc_html( $script_line ); ?></span><?php endif; ?></h1>
				</div>
				<div class="page-hero__art-col">
					<div class="page-hero__art retro-object retro-object--bell">
						<?php bellaworks_retro_info( 'Ding Ding Ding. What can we help you with?', 'bell' ); ?>
						<img src="<?php echo esc_url( get_template_directory_uri() . '/images/services-bell.png' ); ?>" alt="" width="520" height="520">
					</div>
				</div>
			</div>
			<div class="label page-hero__vertical">Simple • Beautiful • Secure</div>
		</section>

		<!-- SERVICES -->
		<?php if ( $services ) : ?>
		<section class="section section--brown service-list">
			<?php bellaworks_watermark( 'halftone', 'tan', 0.20, 'right: -160px; top: -160px; width: 640px; height: 640px;' ); ?>
			<div class="wrapper">
				<div class="service-list__grid">
					<?php foreach ( $services as $s ) : ?>
					<a class="service-list__item" href="<?php echo esc_url( $s['url'] ); ?>">
						<?php bellaworks_icon( $s['icon'] ); ?>
						<h2 class="display service-list__title"><?php echo esc_html( $s['title'] ); ?></h2>
						<?php if ( $s['excerpt'] ) : ?>
						<p class="service-list__text"><?php echo esc_html( $s['excerpt'] ); ?></p>
						<?php endif; ?>
						<span class="service-list__more"><?php esc_html_e( 'Learn More', 'bellaworks' ); ?><?php bellaworks_arrow(); ?></span>
					</a>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php endif; ?>

		<!-- STEPS -->
		<?php get_template_part( 'parts/steps', null, array( 'color' => 'tan' ) ); ?>

	</main>
</div>

<?php get_footer(); ?>
