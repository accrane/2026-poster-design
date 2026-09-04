<?php
/**
 * News listing (page slug: news). Nine posts per page, the first one featured.
 *
 * @package bellaworks
 */

get_header();

$paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );
$posts_q = new WP_Query( array(
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => 9,
	'paged'               => $paged,
	'ignore_sticky_posts' => true,
) );
$lede = trim( get_the_content() );
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<section class="section section--tan page-hero news-index">
			<?php bellaworks_watermark( 'halftone', 'brown', 0.12, 'left: -120px; bottom: -140px; width: 460px; height: 460px;' ); ?>
			<div class="wrapper news-index__inner">
				<div class="page-hero__grid news-index__head">
					<div class="page-hero__copy">
						<div class="page-hero__eyebrow">
							<?php bellaworks_star( 18, 'red' ); ?>
							<span class="label"><?php esc_html_e( 'Charlotte, North Carolina', 'bellaworks' ); ?></span>
						</div>
						<h1 class="display page-hero__title"><?php the_title(); ?></h1>
						<?php if ( $lede ) : ?><div class="page-hero__text"><?php echo wp_kses_post( wpautop( $lede ) ); ?></div><?php endif; ?>
					</div>
					<div class="page-hero__art-col news-index__search">
						<?php get_template_part( 'parts/site-search', null, array( 'label' => __( 'Search the news', 'bellaworks' ) ) ); ?>
					</div>
				</div>

				<?php get_template_part( 'parts/news-filters', null, array( 'active' => 0 ) ); ?>

				<?php if ( $posts_q->have_posts() ) : ?>
				<div class="news-index__grid">
					<?php $i = 0; while ( $posts_q->have_posts() ) : $posts_q->the_post(); $i++;
						get_template_part( 'parts/post-card', null, array( 'feature' => ( 1 === $i && 1 === $paged ) ) );
					endwhile; wp_reset_postdata(); ?>
				</div>
				<?php get_template_part( 'parts/pager', null, array( 'query' => $posts_q, 'current' => $paged ) ); ?>
				<?php else : ?>
				<p><?php esc_html_e( 'No news yet.', 'bellaworks' ); ?></p>
				<?php endif; ?>
			</div>
		</section>

		<?php get_template_part( 'parts/closer' ); ?>

	</main>
</div>

<?php get_footer(); ?>
