<?php
/**
 * Template for the About page (slug: about-us).
 *
 * ACF groups: "About Content" (row1_title, row1_text, row2_text_left,
 * row2_text_right) and "Bios" (bios_title, bios[pic, name, bio]).
 *
 * @package bellaworks
 */

get_header();

$row1_title      = function_exists( 'get_field' ) ? get_field( 'row1_title' ) : '';
$row1_text       = function_exists( 'get_field' ) ? get_field( 'row1_text' ) : '';
$row2_text_left  = function_exists( 'get_field' ) ? get_field( 'row2_text_left' ) : '';
$row2_text_right = function_exists( 'get_field' ) ? get_field( 'row2_text_right' ) : '';
$bios_title      = function_exists( 'get_field' ) ? get_field( 'bios_title' ) : '';
$bios            = function_exists( 'get_field' ) ? get_field( 'bios' ) : array();

// row1_title is a textarea: line 1 plain, <strong>…</strong> becomes the red line.
$title_html = $row1_title ? wp_kses( $row1_title, array( 'strong' => array(), 'br' => array() ) ) : get_the_title();
$title_html = preg_replace( '/(<br\s*\/?>\s*)+/i', '<br>', $title_html );
$title_html = preg_replace_callback( '/<strong>(.*?)<\/strong>/is', function ( $m ) {
	$t = trim( $m[1] );
	if ( strtoupper( $t ) === $t ) {
		$t = ucfirst( strtolower( $t ) );
	}
	return '<span class="script page-hero__script">' . $t . '</span>';
}, $title_html );

// row2_text_left starts with an <h2>; split it from the body so the heading gets the display face.
$approach_heading = '';
$approach_body    = $row2_text_left;
if ( $row2_text_left && preg_match( '/<h2[^>]*>(.*?)<\/h2>/is', $row2_text_left, $m ) ) {
	$approach_heading = wp_strip_all_tags( $m[1] );
	$approach_body    = trim( str_replace( $m[0], '', $row2_text_left ) );
}
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<!-- PAGE HERO -->
		<section class="section section--tan page-hero about-hero">
			<?php bellaworks_watermark( 'halftone', 'brown', 0.12, 'left: -120px; bottom: -140px; width: 460px; height: 460px;' ); ?>
			<div class="wrapper page-hero__grid">
				<div class="page-hero__copy">
					<div class="page-hero__eyebrow">
						<?php bellaworks_star( 18, 'red' ); ?>
						<span class="label"><?php the_title(); ?></span>
					</div>
					<h1 class="display page-hero__title"><?php echo $title_html; // phpcs:ignore -- sanitized above ?></h1>
					<?php if ( $row1_text ) : ?>
					<div class="page-hero__text"><?php echo wp_kses_post( $row1_text ); ?></div>
					<?php endif; ?>
				</div>
				<div class="page-hero__art-col">
					<div class="page-hero__art retro-object retro-object--typewriter">
						<?php bellaworks_retro_info( 'This is what used to be known as a typewriter.', 'typewriter' ); ?>
						<img src="<?php echo esc_url( get_template_directory_uri() . '/images/about-typewriter.png' ); ?>" alt="" width="520" height="520">
					</div>
				</div>
			</div>
			<div class="label page-hero__vertical">Charlotte, North Carolina</div>
		</section>

		<!-- OUR APPROACH -->
		<?php if ( $row2_text_left || $row2_text_right ) : ?>
		<section class="section section--red approach">
			<?php bellaworks_watermark( 'burst', 'tan', 0.16, 'right: -120px; top: -140px; width: 520px; height: 520px; transform: rotate(-10deg);' ); ?>
			<div class="wrapper approach__grid">
				<div class="approach__copy">
					<?php if ( $approach_heading ) : ?>
					<h2 class="display"><?php echo esc_html( $approach_heading ); ?></h2>
					<?php endif; ?>
					<div class="approach__text"><?php echo wp_kses_post( $approach_body ); ?></div>
				</div>
				<?php if ( $row2_text_right ) : ?>
				<div class="approach__aside">
					<?php bellaworks_star( 26, 'brown' ); ?>
					<div class="script approach__quote"><?php echo wp_kses_post( wp_strip_all_tags( $row2_text_right ) ); ?></div>
				</div>
				<?php endif; ?>
			</div>
		</section>
		<?php endif; ?>

		<!-- TEAM -->
		<?php if ( $bios ) : ?>
		<section class="section section--tan team">
			<?php bellaworks_watermark( 'rings', 'brown', 0.10, 'right: -160px; top: -120px; width: 620px; height: 620px;' ); ?>
			<div class="wrapper team__inner">
				<div class="team__head">
					<h2 class="display display--xl"><?php echo esc_html( $bios_title ? $bios_title : __( 'Meet Our Team', 'bellaworks' ) ); ?></h2>
					<?php bellaworks_star( 44, 'red' ); ?>
				</div>
				<?php foreach ( $bios as $b ) :
					$pic  = ( isset( $b['pic'] ) && is_array( $b['pic'] ) ) ? $b['pic'] : null;
					$src  = ( $pic && ! empty( $pic['sizes']['bellaworks-work'] ) ) ? $pic['sizes']['bellaworks-work'] : ( $pic ? $pic['url'] : '' );
					$name = isset( $b['name'] ) ? $b['name'] : '';
					$bio  = isset( $b['bio'] ) ? $b['bio'] : '';
					?>
				<div class="team__member">
					<div class="team__who">
						<?php if ( $src ) : ?>
						<img class="team__photo" src="<?php echo esc_url( $src ); ?>" alt="<?php echo esc_attr( $name ); ?>" loading="lazy">
						<?php endif; ?>
						<h3 class="display team__name"><?php echo esc_html( $name ); ?></h3>
					</div>
					<div class="team__bio"><?php echo wp_kses_post( $bio ); ?></div>
				</div>
				<?php endforeach; ?>
			</div>
		</section>
		<?php endif; ?>

		<!-- CLOSING BAND -->
		<section class="section section--brown closer">
			<?php bellaworks_watermark( 'halftone', 'tan', 0.14, 'left: -180px; bottom: -180px; width: 520px; height: 520px;' ); ?>
			<div class="wrapper closer__inner">
				<?php bellaworks_star_rule( 'tan' ); ?>
				<h2 class="display closer__title">Creating stunning websites <span class="text-red">that also drive results.</span></h2>
				<?php bellaworks_button( 'Book A Call', home_url( '/contact-us/' ), 'red', 'lg' ); ?>
			</div>
		</section>

	</main>
</div>

<?php get_footer(); ?>
