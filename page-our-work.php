<?php
/**
 * Template for the Our Work page (slug: our-work).
 *
 * Lists every published `portfolio` project in menu order with its
 * featured image and business type. Page content (if any) becomes the lede.
 *
 * @package bellaworks
 */

get_header();

$lede = trim( get_the_content() );

$projects = new WP_Query( array(
	'post_type'      => 'portfolio',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
	'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
	'no_found_rows'  => true,
) );
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<!-- PAGE HERO + PROJECT INDEX (one tan block) -->
		<section class="section section--tan page-hero work-hero">
			<?php bellaworks_watermark( 'monogram', 'brown', 0.06, 'right: -140px; top: 40px; width: 760px; height: 465px; transform: rotate(-8deg);' ); ?>
			<div class="work-hero__top">
			<div class="wrapper page-hero__grid">
				<div class="page-hero__copy">
					<div class="page-hero__eyebrow">
						<?php bellaworks_star( 18, 'red' ); ?>
						<span class="label"><?php esc_html_e( 'Charlotte, North Carolina', 'bellaworks' ); ?></span>
					</div>
					<h1 class="display page-hero__title"><?php the_title(); ?></h1>
					<?php if ( $lede ) : ?>
					<div class="page-hero__text"><?php echo wp_kses_post( wpautop( $lede ) ); ?></div>
					<?php endif; ?>
				</div>
				<div class="page-hero__art-col">
					<div class="page-hero__art retro-object retro-object--projector">
						<?php bellaworks_retro_info( 'Instagram? Sure, on a real wall.', 'projector' ); ?>
						<img src="<?php echo esc_url( get_template_directory_uri() . '/images/work-projector.png' ); ?>" alt="" width="520" height="520">
					</div>
				</div>
			</div>
			<div class="label page-hero__vertical">Simple • Beautiful • Secure</div>
			</div><!-- .work-hero__top -->

			<?php if ( $projects->have_posts() ) : ?>
			<div class="wrapper work-index">
				<?php bellaworks_star_rule( 'brown' ); ?>
				<div class="work-index__grid">
					<?php
					$i = 0;
					while ( $projects->have_posts() ) :
						$projects->the_post();
						$i++;
						$terms = get_the_terms( get_the_ID(), 'business-type' );
						$type  = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
						?>
					<a class="work-card" href="<?php the_permalink(); ?>">
						<div class="thumb-card work-card__thumb">
							<?php
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'bellaworks-work', array(
									'loading'  => $i > 3 ? 'lazy' : 'eager',
									'decoding' => 'async',
								) );
							}
							?>
						</div>
						<div class="work-card__caption">
							<h2 class="display work-card__title"><?php the_title(); ?></h2>
							<?php if ( $type ) : ?>
							<span class="label work-card__type"><?php echo esc_html( $type ); ?></span>
							<?php endif; ?>
						</div>
					</a>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
			</div>
			<?php endif; ?>
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
