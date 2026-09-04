<?php
/**
 * Case Studies listing (page slug: case-studies).
 *
 * @package bellaworks
 */

get_header();

$lede    = trim( get_the_content() );
$studies = new WP_Query( array( 'post_type' => 'case_study', 'post_status' => 'publish', 'posts_per_page' => -1, 'orderby' => array( 'menu_order' => 'ASC', 'date' => 'DESC' ), 'no_found_rows' => true ) );
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<section class="section section--tan page-hero cases">
			<?php bellaworks_watermark( 'rings', 'brown', 0.10, 'right: -160px; top: -120px; width: 620px; height: 620px;' ); ?>
			<div class="wrapper cases__inner">
				<div class="page-hero__grid">
					<div class="page-hero__copy">
						<div class="page-hero__eyebrow">
							<?php bellaworks_star( 18, 'red' ); ?>
							<span class="label"><?php esc_html_e( 'Charlotte, North Carolina', 'bellaworks' ); ?></span>
						</div>
						<h1 class="display page-hero__title"><?php the_title(); ?></h1>
						<?php if ( $lede ) : ?><div class="page-hero__text"><?php echo wp_kses_post( wpautop( $lede ) ); ?></div><?php endif; ?>
					</div>
					<div class="page-hero__art-col">
						<div class="page-hero__art retro-object retro-object--casefile">
							<?php bellaworks_retro_info( 'Can you imagine what is in here!?', 'casefile' ); ?>
							<img src="<?php echo esc_url( get_template_directory_uri() . '/images/case-file.png' ); ?>" alt="" width="520" height="520">
						</div>
					</div>
				</div>

				<?php if ( $studies->have_posts() ) : ?>
				<div class="cases__list">
					<?php while ( $studies->have_posts() ) : $studies->the_post();
						$hero  = get_field( 'hero_image' );
						$img   = ! empty( $hero['ID'] ) ? $hero['ID'] : get_post_thumbnail_id();
						$stats = array_slice( (array) get_field( 'stats' ), 0, 3 );
						?>
					<a class="case-card" href="<?php the_permalink(); ?>">
						<span class="thumb-card case-card__thumb"><?php if ( $img ) { echo wp_get_attachment_image( $img, 'bellaworks-banner', false, array( 'loading' => 'lazy', 'decoding' => 'async', 'alt' => get_the_title() ) ); } ?></span>
						<span class="case-card__body">
							<span class="case-card__meta">
								<span class="label case-card__eyebrow"><?php esc_html_e( 'Case Study', 'bellaworks' ); ?></span>
								<?php if ( get_field( 'industry' ) ) : ?><span class="label"><?php echo esc_html( get_field( 'industry' ) ); ?></span><?php endif; ?>
							</span>
							<span class="display case-card__title"><?php the_title(); ?></span>
							<?php if ( get_field( 'summary' ) ) : ?><span class="case-card__summary"><?php echo esc_html( get_field( 'summary' ) ); ?></span><?php endif; ?>
							<?php if ( $stats ) : ?>
							<span class="case-card__stats">
								<?php foreach ( $stats as $st ) : if ( empty( $st['value'] ) ) { continue; } ?>
								<span class="case-card__stat"><span class="display"><?php echo esc_html( $st['value'] ); ?></span><span class="label"><?php echo esc_html( $st['label'] ); ?></span></span>
								<?php endforeach; ?>
							</span>
							<?php endif; ?>
							<span class="case-card__more label"><?php esc_html_e( 'Read the case study', 'bellaworks' ); ?><?php bellaworks_arrow(); ?></span>
						</span>
					</a>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
				<?php else : ?>
				<p class="cases__empty"><?php esc_html_e( 'Case studies are on the way.', 'bellaworks' ); ?></p>
				<?php endif; ?>
			</div>
		</section>

		<?php get_template_part( 'parts/closer' ); ?>

	</main>
</div>

<?php get_footer(); ?>
